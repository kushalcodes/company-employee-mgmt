<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . 'core/CI_admin_controller.php';

class Company_controller extends CI_admin_controller {

  public function __construct() {
    parent::__construct();
    $this->check_login();
    $this->load->model('company_model');
    $this->init_pagination($this->company_model, 'company');

    // to load individual css files to view
    // for eg. we load login.css here
    // custom_js_links can also be used
    $this->view_data['custom_css_links'] = ['dashboard'];
  }
  
  public function index($page_num)
  {
    $this->view_data['rows'] = $this->company_model->get_all_paginated($page_num, $this->pagination_limit);
    
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('website', 'Website', 'required');
    
    if ($this->form_validation->run() == FALSE)
    {
      return $this->v('company');
    }

    if (empty($_FILES['logo']['name'])) 
    {
      $this->session->set_flashdata('error', 'Please upload logo for the company.');
      $this->rdr('/admin/company/0', TRUE);
      exit;
    }

    if ( ! $this->upload->do_upload('logo'))
    {
      $error = array('error' => $this->upload->display_errors());
      $this->session->set_flashdata('error', $error[0]);
      $this->rdr('/admin/company/0', TRUE);
      exit;
    }

    $name = $this->input->post('name');
    $email = $this->input->post('email');
    $website = $this->input->post('website');

    $created = $this->company_model->create([
      'name' => $name,
      'email' => $email,
      'website' => $website,
      'logo' => $this->upload->data('file_name')
    ]);

    if($created)
    {
      $this->session->set_flashdata('success', 'Company added.');
    }
    else
    {
      $this->session->set_flashdata('error', 'Error occurred while adding company.');
    }

    $this->rdr('/admin/company/0', TRUE);
    exit;
  }

  public function rdr_index()
  {
    $this->rdr('/admin/company/0', TRUE);
  }

  public function edit()
  {
    $this->form_validation->set_rules('id', 'Company Id', 'required');
    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('website', 'Website', 'required');
    
    if ($this->form_validation->run() == FALSE)
    {
      $this->rdr('/admin/company/0', TRUE);
      exit;
    }
    
    $logo_file_name = '';
    if (!empty($_FILES['logo']['name'])) 
    {
      if ( ! $this->upload->do_upload('logo'))
      {
        $this->session->set_flashdata('error', $this->upload->display_errors());
        $this->rdr('/admin/company/0', TRUE);
        exit;
      }
    }
    $logo_file_name = $this->upload->data('file_name');

    $id = $this->input->post('id');
    $name = $this->input->post('name');
    $email = $this->input->post('email');
    $website = $this->input->post('website');

    $payload = [
      'name' => $name,
      'email' => $email,
      'website' => $website
    ];
    if(strlen($logo_file_name) > 0 )
    {
      $payload['logo'] = $logo_file_name;
    }

    $edited = $this->company_model->edit($payload, $id);

    if($edited)
    {
      $this->session->set_flashdata('success', 'Company edited.');
    }
    else
    {
      $this->session->set_flashdata('error', 'Error occurred while editing company.');
    }

    $this->rdr('/admin/company/0', TRUE);
  }

  public function delete($id)
  {
    $deleted = $this->company_model->delete($id);

    if($deleted)
    {
      $this->session->set_flashdata('success', 'Company deleted.');
    }
    else
    {
      $this->session->set_flashdata('error', 'Error occurred while deleting company.');
    }

    $this->rdr('/admin/company/0', TRUE);
  }

}

?>