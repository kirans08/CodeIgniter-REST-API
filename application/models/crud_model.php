<?php

class Crud_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function create($table=NULL,$data=NULL)
	{
		if($table==NULL||$data==NULL)
			return;
		$this->db->insert($table,$data);	
	}
	public function read($table=NULL,$key=NULL)
	{
		if($table==NULL)
			return;
		if($key!=NULL)
			$this->db->where('id',$key);
		$result=$this->db->get($table);
		return $result->result_array();
	}
	public function update($table=NULL,$key=NULL,$data=NULL)
	{
		if($key==NULL||$table==NULL||$data==NULL)
			return;
		$this->db->where('id',$key);
		$this->db->update($table,$data);
	}
	public function delete($table=NULL,$key=NULL)
	{
		if($key==NULL||$table==NULL)
			return;
		$this->db->where('id',$key);
		$this->db->delete($table);
	}
	public function createForm($table=NULL)
	{
		if($table==NULL)
			return;
		$fields=$this->db->list_fields($table);
		return $fields;
	}
	public function updateForm($table=NULL,$key=NULL)
	{
		if($table==NULL||$key==NULL)
			return;
		$this->db->where('id',$key);
		$result=$this->db->get($table);
		return $result->row_array();
	}
}
?>