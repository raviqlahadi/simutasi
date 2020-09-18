<?php
defined('BASEPATH') or exit('No Direct script allowed');

class Migration_add_bmd_status extends CI_Migration
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
                'status' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                ),
                'asset_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned'=>TRUE
                ),
                'officer_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'null'=>TRUE
                ),
                'date_created' => array(
                    'type' => 'TIMESTAMP',
                )

            )
        );
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (asset_id) REFERENCES assets(id)');
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (officer_id) REFERENCES officers(id)');
        $this->dbforge->create_table('asset_status');

    
    }

    public function down()
    {
        $this->dbforge->drop_table('asset_status');
    }
}
