<?php
defined('BASEPATH') or exit('No Direct script allowed');

class Migration_add_user_profile_and_ownership extends CI_Migration
{
    public function up()
    {
        //add table user_profile
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'phone' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ),
                'gender' => array(
                    'type' => 'VARCHAR',
                    'constraint' =>20,
                    'null' => true
                ),
                'position' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null'=> true
                ),
                'user_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE
                ),
                'date_created' => array(
                    'type' => 'TIMESTAMP',
                )

            )
        );
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (user_id) REFERENCES users(id)');
        $this->dbforge->create_table('user_profiles');

        //add table owwnership
        
    }

    public function down()
    {
        $this->dbforge->drop_table('user_profiles');
       
    }
}
