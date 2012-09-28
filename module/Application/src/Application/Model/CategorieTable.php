<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class CategorieTable extends AbstractTableGateway
{
    protected $table ='categorie';

    public function __construct(Adapter $adapter)
    {
        
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Categorie());
        $this->initialize();
    }

    public function fetchAll($array = false)
    {        
        if ($array) {
            $resultSet = $this->select(array('parent' => 0));
            $arrayCategories = array();
            foreach ($resultSet as $key=>$categorie) {
                // catégorie de premier niveau
                $arrayCategories[$key] = $categorie->toArray();
                $resultSetChildren = $this->select(array('parent' => $categorie->id));
                // créer un array contenant tous les enfants de cette catégorie
                $arrayChildren = array();
                foreach ($resultSetChildren as $sousCategorie) {
                    $arrayChildren[] = $sousCategorie->toArray();
                }
                $arrayCategories[$key]['children'] = $arrayChildren;
            }
            return $arrayCategories;
        } else {
            $resultSet = $this->select();
            return $resultSet;
        }
    }

    
    public function fetchAllRootLevel($id = null)
    {        
        $select = new \Zend\Db\Sql\Select();
        $select->columns(array('*'))->from('categorie')->where('parent=0');
        
        if ($id) {
            $select->where('id != ' . (int)$id);
        }
        
        return $this->selectWith($select);
        
    }
    
    public function getCategorie($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveCategorie(Categorie $categorie)
    {
        $data = array(
            'id' => $categorie->getId(),
            'name' => $categorie->getName(),
            'parent' => $categorie->getParent(),
            'lien' => $categorie->getLien(),
        );
        $id = (int)$categorie->getId();
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getCategorie($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteCategorie($id)
    {
        $this->delete(array('id' => $id));
    }
    
}