<?php 
include_once APPPATH . 'core/CI_Management_model.php';

class Company_model extends CI_Management_model {

  public function __construct()
  {
    $this->table = 'company';
  }

}

?>