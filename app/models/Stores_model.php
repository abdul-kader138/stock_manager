<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stores_model extends CI_Model
{

	public function __construct() {
		parent::__construct();
	}

	public function getStoreByID($id)
	{
		$q = $this->db->get_where('stores', array('id' => $id), 1);
		if( $q->num_rows() > 0 ) {
			return $q->row();
		}
		return FALSE;
	}

	public function addStore($data = array())
	{
		if($this->db->insert('stores', $data)) {
			return true;
		}
		return false;
	}

	public function updateStore($id, $data = array())
	{
		if($this->db->update('stores', $data, array('id' => $id))) {
			return true;
		}
		return false;
	}

	public function deleteStore($id)
	{
		if($this->db->delete('stores', array('id' => $id))) {
			return true;
		}
		return FALSE;
	}

	public function getStoreByName($name)
	{
		$q = $this->db->get_where('stores', array('store_name' => $name), 1);
		if( $q->num_rows() > 0 ) {
			return $q->row();
		}
		return FALSE;
	}

	
	public function getStroreByID($id)
	{
		$q = $this->db->get_where('stores', array('id' => $id), 1);
		if( $q->num_rows() > 0 ) {
			return $q->row();
		}
		return FALSE;
	}
	
	public function add_stores($data = array()) {
        if ($this->db->insert_batch('stores', $data)) {
            return true;
        }
        return false;
    }
	
	 public function getAllStores() {
        $q = $this->db->get('stores');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

}
