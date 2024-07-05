<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StatusTypesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'draft',
                'description' => 'Draft',
                'color' => 'secondary'
            ],
            [
                'name' => 'need_revision',
                'description' => 'Need Revision',
                'color' => 'danger'
            ],
            [
                'name' => 'pending_approval_one',
                'description' => 'Wait for Approval Supervisor',
                'color' => 'warning'
            ],
            [
                'name' => 'pending_approval_two',
                'description' => 'Wait for Approval HRD',
                'color' => 'warning'
            ],
            [
                'name' => 'wait_document',
                'description' => 'Wait for Document',
                'color' => 'danger'
            ],
            [
                'name' => 'pending_approval_authenticator',
                'description' => 'Wait for Authentication',
                'color' => 'warning'
            ],
            [
                'name' => 'rejected',
                'description' => 'Rejected',
                'color' => 'danger'
            ],
            [
                'name' => 'done',
                'description' => 'Done',
                'color' => 'success'
            ],
        ];
        $this->db->table('statustypes')->insertBatch($data);
    }
}
