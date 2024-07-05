<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGroupsTable extends Migration
{
    public function up()
    {
        // GROUP TABLE
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null'=> true,
            ],
            'updated_at'=> [
                'type' => 'TIMESTAMP',
                'null'=> true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('groups', true);

        // GROUPS_USERS TABLE
        $this->forge->addField([
            'id'=> [
                'type'=> 'INT',
                'constraint'=> 5,
                'unsigned'=> true,
                'auto_increment'=> true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'group_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'created_at'=> [
                'type'=> 'TIMESTAMP',
                'null'=> true,
            ],
            'updated_at'=> [
                'type'=> 'TIMESTAMP',
                'null'=> true,
            ],  
        ]);
        $this->forge->addPrimaryKey(['id']);
        $this->forge->addUniqueKey(['user_id','group_id']);
        $this->forge->addForeignKey('group_id', 'groups', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_groups', true);

        // PERMISSIONS TABLE
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null'=> true,
            ],
            'updated_at'=> [
                'type' => 'TIMESTAMP',
                'null'=> true,
            ],
        ]);
        $this->forge->addPrimaryKey(['id']);
        $this->forge->createTable('permissions', true);

        // GROUPS_PERMISSIONS TABLE
        $this->forge->addField([
            'id'=> [
                'type'=> 'INT',
                'constraint'=> 5,
                'unsigned'=> true,
                'auto_increment'=> true,
            ],
            'group_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'permission_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'created_at'=> [
                'type'=> 'TIMESTAMP',
                'null'=> true,
            ],
            'updated_at'=> [
                'type'=> 'TIMESTAMP',
                'null'=> true,
            ],
        ]);
        $this->forge->addPrimaryKey(['id']);
        $this->forge->addUniqueKey(['group_id','permission_id']);   
        $this->forge->addForeignKey('group_id','groups','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('permission_id','permissions','id','CASCADE', 'CASCADE');
        $this->forge->createTable('group_permissions', true);

    }

    public function down()
    {
        $this->forge->dropTable('group_permissions', true);
        $this->forge->dropTable('user_groups', true);
        $this->forge->dropTable('groups', true);
        $this->forge->dropTable('permissions', true);

    }
}
