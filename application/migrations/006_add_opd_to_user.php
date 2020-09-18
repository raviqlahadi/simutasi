<?php
defined('BASEPATH') or exit('No Direct script allowed');

class Migration_add_opd_to_user extends CI_Migration
{
    public function up()
    {
        //add table user_profile
        $this->dbforge->add_column('users',
            array(
                'agency_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                )

            )
        );
        $this->dbforge->add_column('users','CONSTRAINT FOREIGN KEY (agency_id) REFERENCES agencies(id)');
    }

    public function down()
    {
        $this->dbforge->drop_table('users');
    }
}
