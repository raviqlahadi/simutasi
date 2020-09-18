<?php
defined('BASEPATH') or exit('No Direct script allowed');

class Migration_add_group extends CI_Migration {
    public function up(){
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                ),
                'description' => array(
                    'type' => 'TEXT',                    
                ),
                'date_created' => array(
                    'type' => 'TIMESTAMP',
                )
            ));
        $this->dbforge->add_key('id', TRUE);       
        $this->dbforge->create_table('groups');
    }

    public function down()
    {
        $this->dbforge->drop_table('groups');
    }
}
