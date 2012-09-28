<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class ProduitTable extends AbstractTableGateway
{
    protected $table ='produit';

    public function __construct(Adapter $adapter)
    {
        
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Produit());
        $this->initialize();
    }

    public function fetchAll($idCategorie = null)
    {
        if ($idCategorie) {
            $where = array ('categorie_id' => $idCategorie);
        } else {
            $where = null;
        }
        
        $resultSet = $this->select($where);
        
        return $resultSet;
    }

    public function getProduit($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveProduit(Produit $produit)
    {
        $data = array(
            'id' => $produit->getId(),
            'name' => $produit->getName(),
            'description' => $produit->getDescription(),
            'info'  => $produit->getInfo(),
            'categorie_id'  => $produit->getCategorie_id(),
        );
        $id = (int)$produit->getId();
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getProduit($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
        return $this->getLastInsertValue();
    }

    public function deleteProduit($id)
    {
        $this->delete(array('id' => $id));
    }
    
}