<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'core/CI_admin_controller.php';

class Employee_controller extends CI_admin_controller {

  public function __construct() {
    parent::__construct();
    $this->check_login();
    $this->load->model('employee_model');
    $this->load->model('company_model');
    $this->init_pagination($this->employee_model, 'employee');

    // to load individual css files to view
    // for eg. we load login.css here
    // custom_js_links can also be used
    $this->view_data['custom_css_links'] = ['dashboard'];
    $this->view_data['custom_js_links'] = ['call_ajax'];
  }

  public function index($page_num)
  {
    $rows = $this->employee_model->get_all_paginated($page_num, $this->pagination_limit);
    foreach ($rows as $key => $row) {
      $row->company = $this->company_model->get($row->company_id) ?? 'Unassigned' ;
    }
    $this->view_data['rows'] = $rows;
    
    $this->v('employee');
  }

  public function create()
  {
    $this->form_validation->set_rules('first_name', 'First Name', 'required');
    $this->form_validation->set_rules('last_name', 'Last Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('phone', 'Phone', 'required');
    
    if ($this->form_validation->run() == FALSE)
    {
      $this->rdr('/admin/employee/0', TRUE);
      exit;
    }

    $first_name = $this->input->post('first_name');
    $last_name = $this->input->post('last_name');
    $email = $this->input->post('email');
    $phone = $this->input->post('phone');

    $created = $this->employee_model->create([
      'first_name' => $first_name,
      'email' => $email,
      'last_name' => $last_name,
      'phone' => $phone
    ]);

    if($created)
    {
      $this->session->set_flashdata('success', 'Employee added.');
    }
    else
    {
      $this->session->set_flashdata('error', 'Error occurred while adding employee.');
    }

    $this->rdr('/admin/employee/0', TRUE);
    exit;
  }



  public function rdr_index()
  {
    $this->rdr('/admin/employee/0', TRUE);
  }

  public function edit()
  {
    $this->form_validation->set_rules('first_name', 'First Name', 'required');
    $this->form_validation->set_rules('last_name', 'Last Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('phone', 'Phone', 'required');
    $this->form_validation->set_rules('id', 'Id', 'required');
    
    if ($this->form_validation->run() == FALSE)
    {
      $this->api_response->msg = 'All fields required!';
      $this->api_response->status = 'error';
      $this->res_send();
    }

    $id = $this->input->post('id');
    $first_name = $this->input->post('first_name');
    $last_name = $this->input->post('last_name');
    $email = $this->input->post('email');
    $phone = $this->input->post('phone');

    $payload = [
      'first_name' => $first_name,
      'email' => $email,
      'last_name' => $last_name,
      'phone' => $phone
    ];

    $edited = $this->employee_model->edit($payload, $id);

    if($edited)
    {
      $this->api_response->msg = 'Employee edited.';
      $this->api_response->status = 'success';
    }
    else
    {
      $this->api_response->msg = 'Error while deleting employee.';
      $this->api_response->status = 'error';
    }

    $this->res_send();
  }

  public function delete($id)
  {
    $deleted = $this->employee_model->delete($id);

    if($deleted)
    {
      $this->api_response->msg = 'Employee deleted.';
      $this->api_response->status = 'success';
    }
    else
    {
      $this->api_response->msg = 'Error occurred while deleting employee.';
      $this->api_response->status = 'error';
    }
    $this->res_send();
  }

  public function update_company()
  {
    $this->form_validation->set_rules('id', 'Employee Id', 'required');
    $this->form_validation->set_rules('company_id', 'Company', 'required');
    
    if ($this->form_validation->run() == FALSE)
    {
      $this->api_response->msg = 'Employee id and company required.';
      $this->api_response->status = 'error';
      $this->res_send();
    }

    $id = $this->input->post('id', TRUE);
    $company_id = $this->input->post('company_id', TRUE);

    $payload = [
      'company_id' => $company_id,
    ];

    $edited = $this->employee_model->edit_where($payload, ['id' => $id]);

    if($edited)
    {
      $this->api_response->msg = 'Employee edited.';
      $this->api_response->status = 'success';
    }
    else
    {
      $this->api_response->msg = 'Error while deleting employee.';
      $this->api_response->status = 'error';
    }

    $this->res_send();

  }
}

?>