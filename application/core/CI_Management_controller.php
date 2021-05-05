<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CI_Management_controller extends CI_Controller {

  protected $view_data;
  protected $pagination_limit = 10;
  protected $api_response;

  public function __construct()
  {
    parent::__construct();
    $this->init_file_upload();

    $this->api_response = new stdClass;
    $this->api_response->status = '';
    $this->api_response->msg = '';
    $this->api_response->data = '';
  }

  protected function init_file_upload()
  {
    $config['upload_path'] = 'public/logos/';
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size']     = '100';
    $config['min_width'] = '100';
    $config['encrypt_name'] = TRUE;
    $config['min_height'] = '100';
    $config['remove_spaces'] = TRUE;
    $this->upload->initialize($config);
  }

  // initializes pagination
  protected function init_pagination($model, $panel_name)
  {
    $config['base_url'] = '/admin/'.$panel_name;
    $config['total_rows'] = $model->count_all();
    $config['per_page'] = $this->pagination_limit;
    $config['first_link'] = '<<';
    $config['last_link'] = '>>';
    $config['prev_link'] = '<';
    $config['next_link'] = '>';
    $config['attributes'] = array('class' => 'page-item');
    $this->pagination->initialize($config);
  }

  // load view
  protected function v($name)
  {
    $this->view_data['title'] = isset($this->view_data['title']) ? $this->view_data['title'] : ucfirst($name);
    $this->load->view('templates/header.php', $this->view_data);
    $this->load->view($name, $this->view_data);
    $this->load->view('templates/footer.php', $this->view_data);
  }

  public function rdr($url, $refresh = FALSE)
  {
    if($refresh)
    {
      redirect($url, 'refresh');
    }
    else
    {
      redirect($url);
    }
  }

  protected function res_send()
  {
    echo json_encode($this->api_response);
    exit;
  }
}

?>