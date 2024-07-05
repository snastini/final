<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Admin', //1
                'email' => 'admin@email.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'is_registered' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Pegawai 1', //2 
                'email' => 'pegawai1@email.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'is_registered' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Pegawai 2', //3
                'email' => 'pegawai2@email.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'is_registered' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Pegawai 3', //4
                'email' => 'pegawai3@email.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'is_registered' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'HRD', //5
                'email' => 'hrd@email.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'is_registered' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Supervisor', //6
                'email' => 'supervisor@email.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'is_registered' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],[
                'name' => 'Authenticator', //7
                'email' => 'authenticator@email.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'is_registered' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at'=> date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('users')->insertBatch($data);
    }
}
