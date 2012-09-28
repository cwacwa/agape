<?php
namespace Application\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\AbstractTableGateway;

class PhotoTable extends AbstractTableGateway
{
    protected $table ='photo';

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Photo());
        $this->initialize();
    }

    public function fetchAll($idProduit = null, $array = false)
    {
        if ($idProduit) {
            $where = array ('produit_id' => $idProduit);
        } else {
            $where = null;
        }
        
        $resultSet = $this->select($where);
        
        if ($array) {
            $array = array();
            foreach ($resultSet as $photo) {
                $array[] = $photo->getArrayCopy();
            }
            return $array;            
        }
        
        return $resultSet;
    }

    public function getPhoto($id)
    {
        $id  = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function savePhoto(Photo $photo)
    {
        $data = array(
            'id' => $photo->getId(),
            'produit_id' => $photo->getProduit_id(),
            'url' => $photo->getUrl(),
        );
        $id = (int)$photo->getId();
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getPhoto($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deletePhoto($id = null)
    {
        $this->delete(array('id' => $id));
    }
    
}