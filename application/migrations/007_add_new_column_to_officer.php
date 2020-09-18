<?php
defined('BASEPATH') or exit('No Direct script allowed');

class Migration_add_new_column_to_officer extends CI_Migration
{
    public function up()
    {
        //add table user_profile
        $this->dbforge->add_column(
            'officers',
            array(
                'gender' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 20,
                    'null' => true
                ),
                'religion' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ),
                'section' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                    'null' => true
                ),
            )
        );
       
    }

    public function down()
    {
        $this->dbforge->drop_table('officers');
    }
}
