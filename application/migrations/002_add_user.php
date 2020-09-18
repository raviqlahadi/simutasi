<?php
defined('BASEPATH') or exit('No Direct script allowed');

class Migration_add_user extends CI_Migration {
    public function up(){
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'username' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '200'
                ),
                'password' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '200'
                ),
                'group_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                ),
                'date_created' => array(
                    'type' => 'TIMESTAMP',
                )
                
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (group_id) REFERENCES groups(id)');
        $this->dbforge->create_table('users');
    }

    public function down()
    {
        $this->dbforge->drop_table('user');
    }
}


?>