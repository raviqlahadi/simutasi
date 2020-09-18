<?php
defined('BASEPATH') or exit('No Direct script allowed');

class Migration_add_base extends CI_Migration {
    public function up(){
        //add table agency
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'code' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100
                ),
                'name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 200
                ),               
                'ministry' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                    'null' => true
                ),
                'phone' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ),
                'fax' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50,
                    'null' => true
                ),
                'email' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'website' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'address' => array(
                    'type' => 'TEXT',
                    'null' => true
                ),
                
                'date_created' => array(
                    'type' => 'TIMESTAMP',
                )
                
            ));
        $this->dbforge->add_key('id', TRUE);
        //$this->dbforge->add_field('CONSTRAINT FOREIGN KEY (group_id) REFERENCES groups(id)');
        $this->dbforge->create_table('agencies');

        //add table assets
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 21,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'asset_code' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100
                ),
                'type' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 200
                ),
                'register_number' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                    'null' => true
                ),
                'brand' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                    'null' => true
                ),
                'year_purchased' => array(
                    'type' => 'YEAR',
                    'null' => true
                ),
                'color' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'factory_number' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'chassis_number' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'chassis_number' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'machine_number' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'police_number' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'bpkb_number' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'price' => array(
                    'type' => 'INT',
                    'constraint' => 50,
                    'null' => true
                ),
                'agency_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE
                ),
                'origin' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'code_number' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 100,
                    'null' => true
                ),
                'description' => array(
                    'type' => 'TEXT',
                    'null' => true
                ),

                'date_created' => array(
                    'type' => 'TIMESTAMP',
                )

            )
        );
        $this->dbforge->add_key('id',TRUE);
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (agency_id) REFERENCES agencies(id)');
        $this->dbforge->create_table('assets');

        //add table officers
        //add table agency
        $this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE,
                    'auto_increment' => TRUE
                ),
                'nip' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 50
                ),
                'full_name' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 200
                ),
                'position' => array(
                    'type' => 'VARCHAR',
                    'constraint' => 200,
                    'null' => true
                ),
                'agency_id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => TRUE
                ),
               

                'date_created' => array(
                    'type' => 'TIMESTAMP',
                )

            )
        );
        $this->dbforge->add_key('id',
            TRUE
        );
        $this->dbforge->add_field('CONSTRAINT FOREIGN KEY (agency_id) REFERENCES agencies(id)');
        $this->dbforge->create_table('officers');
    }

    public function down()
    {
        $this->dbforge->drop_table('agencies');
        $this->dbforge->drop_table('assets');
        $this->dbforge->drop_table('officers');
        
    }
}
