<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubmissionsTable extends Migration
{
    public function up()
    {

        // STATUS TYPE TABLE
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'color' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('statustypes', true);

        // SUBMISSIONS TABLE
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'year' => [
                'type' => 'INT',
                'constraint' => 4
            ],
            'semester' => [
                'type' => 'INT',
                'constraint' => 1
            ],
            'name'=> [
                'type' => 'VARCHAR',
                'constraint'=> 255
            ],
            'reason_rejected'=> [
                'type'=> 'VARCHAR',
                'constraint'=> 255,
                'null'=> true
            ],
            'reason_need_revision'=> [
                'type'=> 'VARCHAR',
                'constraint'=> 255,
                'null'=> true
            ],
            'status_id'=> [
                'type'=> 'INT',
                'constraint'=> 11
            ],
            'request_user_id'   => [
                'type' => 'INT',
                'constraint' => 11,
                'null'=> true,
                'unsigned' => true
            ],
            'approval_one_user_id'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'null'=> true
            ],
            'approval_two_user_id'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'null'=> true
            ],
            'authenticator_user_id'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'null'=> true
            ],
            'rejected_user_id'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'null'=> true
            ],
            'need_revision_user_id'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'null'=> true
            ],
            'total_qty'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'null'=> true
            ],
            'total_item'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'null'=> true
            ],
            'total_price'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'null'=> true
            ],
            'invoice_dir'=> [
                'type'=> 'VARCHAR',
                'constraint'=> 255,
                'null'=> true
            ],'created_at'=> [
                'type'=> 'DATETIME',
                'null'=> true
            ],
            'updated_at'=> [
                'type'=> 'DATETIME',
                'null'=> true
            ]
        ]);
        $this->forge->addPrimaryKey(['id']);
        $this->forge->addForeignKey('status_id', 'statustypes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('request_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('approval_one_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('approval_two_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('authenticator_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('submissions', true);


        // SUBMISSIONS_ITEMS TABLE
        $this->forge->addField([
            'id'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'unsigned'=> true,
                'auto_increment'=> true
            ],
            'submission_id'=> [
                'type'=> 'INT',
                'constraint'=> 11,
                'unsigned'=> true
            ],
            'name'=> [
                'type'=> 'VARCHAR',
                'constraint'=> 255
            ],
            'price'=> [
                'type'=> 'INT',
                'constraint'=> 11,
            ],
            'qty'=> [
                'type'=> 'INT',
                'constraint'=> 11
            ],
            'total_price'=> [
                'type'=> 'INT',
                'constraint'=> 11
            ],
            'created_at'=> [
                'type'=> 'DATETIME',
                'null'=> true
            ],
            'updated_at'=> [
                'type'=> 'DATETIME',
                'null'=> true
            ]
        ]);
        $this->forge->addPrimaryKey(['id']);
        $this->forge->addForeignKey('submission_id', 'submissions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('submissions_items', true);
    }

    public function down()
    {
        $this->forge->dropTable('submissions_items', true);
        $this->forge->dropTable('submissions', true);
        $this->forge->dropTable('statustypes', true);
        
    }
}
