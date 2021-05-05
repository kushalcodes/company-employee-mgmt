<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'CI_Management_controller.php';

class CI_admin_controller extends CI_Management_controller {

  public function __construct() {
    parent::__construct();
  }

  protected function is_logged_in()
  {
    return isset($_SESSION['login']) ? TRUE : FALSE;
  }

  protected function check_login()
  {
    if(!$this->is_logged_in())
    {
      $this->rdr('/admin/login', FALSE);
    }
  }

  protected function check_no_login()
  {
    if($this->is_logged_in())
    {
      $this->rdr('/', FALSE);
    }
  }

}

?>