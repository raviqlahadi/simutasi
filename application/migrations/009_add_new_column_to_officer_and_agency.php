<?php
defined('BASEPATH') or exit('No Direct script allowed');

class Migration_add_new_column_to_officer_and_agency extends CI_Migration
{
    public function up()
    {
        //add table user_profile
        $this->dbforge->add_column(
            'officers',
            array(
                'rank' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                    
                ),
            )
        );
        //add table user_profile
        $this->dbforge->add_column(
            'agencies',
            array(
                'hod_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                ),
                'ao_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                ),
            )
        );
    }

    public function down()
    {
        $this->dbforge->drop_table('officers');
        $this->dbforge->drop_table('agencies');
    }
}
