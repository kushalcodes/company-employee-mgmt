<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_User extends CI_Migration {
  private $seedData = [
    [
      'username' => 'Administrator',
      'email' => 'admin@admin.com',
      'password' => 'password',
      'role' => '0'
    ],
  ];

  private function hash_pass($password)
  {
    return password_hash($password, PASSWORD_BCRYPT);
  }

  public function up()
  {
    $this->dbforge->add_field(array(
      'id' => array(
        'type' => 'INT',
        'auto_increment' => TRUE
      ),
      'username' => array(
        'type' => 'VARCHAR',
        'constraint' => '50',
      ),
      'email' => array(
        'type' => 'VARCHAR',
        'constraint' => '255',
      ),
      'password' => array(
        'type' => 'TEXT'
      ),
      'role' => array(
        'type' => 'INT',
      )
    ));
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table('user');
    $this->seed_data();
  }

  public function down()
  {
    $this->dbforge->drop_table('user');
  }

  private function seed_data()
  { 
    foreach ($this->seedData as $seed ) {
      $seed['password'] = $this->hash_pass($seed['password']);
      $this->db->insert('user', $seed);
    }
  }
}