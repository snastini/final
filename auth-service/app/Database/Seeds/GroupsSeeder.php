<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Pegawai',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Supervisor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'HRD',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],            
            [
                'name' => 'Authenticator',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('groups')->insertBatch($data);
    }
}
