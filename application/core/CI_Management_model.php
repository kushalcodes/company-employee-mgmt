<?php 

class CI_Management_model extends CI_Model {

  public $table;
  public $primary_key = 'id';

  public function __construct()
  {
    parent::__construct();
  }

  // get all 
  // accepts where 
  public function get_all($where = array())
  {
    $this->db->from($this->table);
    $this->db->where($where);
    return $this->db->get()->result();
	}

  public function get_all_paginated($page, $limit, $where = array())
  {
    $this->db->from($this->table);
    $this->db->where($where);
    $this->db->limit($limit, $page);  
    return $this->db->get()->result();
  }

  // get by primary key
  public function get($id)
  {
    $this->db->from($this->table);
    $this->db->where($this->primary_key, $id, TRUE);
    return $this->db->get()->row();
	}

  // get row by field
  public function get_by_field($field, $value)
  {
		$this->db->from($this->table);
    $this->db->where($field, $value, TRUE);
    return $this->db->get()->row();
	}

  // get row by where
  public function get_where($where)
  {
		$this->db->from($this->table);
    $this->db->where($where, TRUE);
    return $this->db->get()->row();
	}

  // get row by where all
  public function get_where_all($where)
  {
		$this->db->from($this->table);
    $this->db->where($where, TRUE);
    return $this->db->get()->result();
	}

  // create / insert
  public function create($data)
  {
    $inserted_row = $this->db->insert($this->table, $data, TRUE);
    if ($inserted_row)
    {
      return $this->db->insert_id();
    }
    return FALSE;
  }

  // edit by primary key
  public function edit($data, $id)
  {
    $this->db->where($this->primary_key, $id, TRUE);
		return $this->db->update($this->table, $data);
  }

  // edit where
  public function edit_where($data, $where)
  {
		$this->db->from($this->table);
    $this->db->where($where, TRUE);
    return $this->db->update($this->table, $data);
	}

  // delete with id
  public function delete($id)
	{
    return $this->db->delete($this->table, ['id' => $id]);
  }

  // delete all / truncate
  public function delete_all()
	{
		return $this->db->truncate($this->table);
  }

  public function count_all()
  {
    $this->db->from($this->table);
    return $this->db->count_all_results();
  }

}

?>