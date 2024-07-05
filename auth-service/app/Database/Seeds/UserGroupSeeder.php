<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 1,
                'group_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 1,
                'group_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 1,
                'group_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 2,
                'group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 3,
                'group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 4,
                'group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 5,
                'group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 6,
                'group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 7,
                'group_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 5,
                'group_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 6,
                'group_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'user_id' => 7,
                'group_id' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            
        ];	

        $this->db->table('user_groups')->insertBatch($data);
            
    }
}
