<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'core/CI_admin_controller.php';

class Dashboard_controller extends CI_admin_controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('user_model');
    $this->load->model('employee_model');
    $this->load->model('company_model');

    // to load individual css files to view
    // for eg. we load login.css here
    // custom_js_links can also be used
    $this->view_data['custom_css_links'] = ['dashboard'];
    $this->view_data['custom_js_links'] = ['call_ajax','interact'];
  }

  public function index()
  {
    $this->check_login();
    // $this->view_data['title'] = 'Admin Dashboard';
    $this->view_data['employee_unassigned'] = $this->employee_model->get_where_all(['company_id' => 0]);
    $companies_all = $this->company_model->get_all();
    foreach ($companies_all as $key => $company) {
      $company->employees = $this->employee_model->get_where_all(['company_id' => $company->id]);
    }
    $this->view_data['companies_all'] = $companies_all;
    $this->v('dashboard');
  }

  public function admin_login()
  {
    $this->check_no_login();
    $this->view_data['custom_css_links'] = ['login'];

    if( $this->input->post('email') && $this->input->post('password') )
    {

      $email = $this->input->post('email', TRUE);
      $password = $this->input->post('password', TRUE);

      $this->load->library('login_service');
      $this->login_service->set_model($this->user_model);

      $user = $this->login_service->admin_login($email, $password);

      if(!$user)
      {
        echo 'not login';
        exit;
      }

      $_SESSION['login'] = 'yes';
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_name'] = $user->username;
      $_SESSION['user_email'] = $user->email;
      $this->rdr('/', TRUE);

    }

    $this->v('admin_login');
  }

  public function logout()
  {
    session_destroy();
    $this->rdr('/', TRUE);
  }

}

?>