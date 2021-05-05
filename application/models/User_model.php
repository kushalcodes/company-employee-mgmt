<?php 
include_once APPPATH . 'core/CI_Management_model.php';

class User_model extends CI_Management_model {

  public function __construct()
  {
    $this->table = 'user';
  }

  public function role_mapping()
  {
    return [
      'admin',
      'user'
    ];
  }

}

?>