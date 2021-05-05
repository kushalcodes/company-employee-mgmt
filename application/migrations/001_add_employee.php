<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Employee extends CI_Migration {

  public function up()
  {
    $this->dbforge->add_field(array(
      'id' => array(
        'type' => 'INT',
        'auto_increment' => TRUE
      ),
      'first_name' => array(
        'type' => 'VARCHAR',
        'constraint' => '100',
      ),
      'last_name' => array(
        'type' => 'VARCHAR',
        'constraint' => '100',
      ),
      'email' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
      ),
      'phone' => array(
        'type' => 'TEXT',
      ),
      'company_id' => array(
        'type' => 'INT',
      ),
    ));
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table('employee');
  }

  public function down()
  {
    $this->dbforge->drop_table('employee');
  }
}