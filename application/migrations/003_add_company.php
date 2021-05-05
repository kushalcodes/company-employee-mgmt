<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Company extends CI_Migration {

  public function up()
  {
    $this->dbforge->add_field(array(
      'id' => array(
        'type' => 'INT',
        'auto_increment' => TRUE
      ),
      'name' => array(
        'type' => 'VARCHAR',
        'constraint' => '100',
      ),
      'email' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
      ),
      'logo' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
      ),
      'website' => array(
        'type' => 'TEXT',
      )
    ));
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table('company');
  }

  public function down()
  {
    $this->dbforge->drop_table('company');
  }
}