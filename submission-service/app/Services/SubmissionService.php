<?php

namespace App\Services;

use App\Models\SubmissionItemModel;
use App\Models\SubmissionModel;
use CodeIgniter\Config\Services;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class SubmissionService
{

    // SUBMISSION
    public function addSubmission($params){

        try {
            $submissionModel = new SubmissionModel();
            $submissionModel->insert($params);

            return ["message"=> "Submission created successfully","data"=> $submissionModel->getInsertID()];

        } catch (Exception $e) {
            
            return ["message"=> $e->getMessage(), "data"=> null];
        }
    }

    public function deleteSubmission($id){

        $submissionModel = new SubmissionModel();
        $submissionModel->delete($id);

        $itemModel = new SubmissionItemModel();
        $itemModel->where('submission_id', $id)->delete();

        return ["message"=> "Submission deleted successfully","data"=> null];
    }



    public function getAllSubmissions(){

        $submissionModel = new SubmissionModel();
        $submissions = $submissionModel->builder()->select([
            'submissions.id  id',
            'submissions.name  name',
            'submissions.year  year',
            'submissions.semester  semester',
            'submissions.total_item  total_item',
            'submissions.total_qty  total_qty',
            'submissions.total_price  total_price',
            'submissions.reason_rejected  reason_rejected',
            'submissions.reason_need_revision  reason_need_revision',
            'submissions.status_id  status_id',
            'statustypes.name  status_name',
            'statustypes.description  status_description',
            'request_user.name  request_user_name',
            'request_user.id  request_user_id', 
            'approval_one_user.name  approval_one_user_name',
            'approval_two_user.name  approval_two_user_name',
            'authenticator_user.name authenticator_user_name',
            'rejected_user.name rejected_user_name',
            'need_revision_user.name need_revision_user_name'
        ])
            ->join('statustypes', 'statustypes.id = submissions.status_id', 'left')
            ->join('users request_user', 'request_user.id = submissions.request_user_id', 'left')
            ->join('users approval_one_user', 'approval_one_user.id = submissions.approval_one_user_id', 'left')
            ->join('users approval_two_user', 'approval_two_user.id = submissions.approval_two_user_id', 'left')
            ->join('users authenticator_user', 'authenticator_user.id = submissions.authenticator_user_id', 'left')
            ->join('users rejected_user', 'rejected_user.id = submissions.rejected_user_id', 'left')
            ->join('users need_revision_user', 'need_revision_user.id = submissions.need_revision_user_id', 'left');

        if(session('active_group') == 'Pegawai'){
            $submissions->where('request_user_id', session('user_id'));
        } else {
            $submissions->where('status_id >', 1);
        }

        $submissions = $submissions->orderBy('submissions.created_at', 'desc')
                                    ->get()->getResultArray();


        if(empty($submissions)){
            return ['message' => 'No submissions found', 'data' => null];
        }
        return ['message' => 'Submissions retrieved successfully', 
                'data' => $submissions];        

        
    }

    public function getSubmissionDetail($id){

        $submissionModel = new SubmissionModel();
        $submissions = $submissionModel->builder()->select([
            'submissions.id  id',
            'submissions.name  name',
            'submissions.year  year',
            'submissions.semester  semester',
            'submissions.total_item  total_item',
            'submissions.total_qty  total_qty',
            'submissions.total_price  total_price',
            'submissions.reason_rejected  reason_rejected',
            'submissions.reason_need_revision  reason_need_revision',
            'submissions.status_id  status_id',
            'submissions.invoice_dir  invoice_dir',
            'statustypes.name  status_name',
            'statustypes.description  status_description',
            'statustypes.color  status_color',
            'request_user.name  request_user_name',
            'request_user.id  request_user_id',
            'approval_one_user.name  approval_one_user_name',
            'approval_two_user.name  approval_two_user_name',
            'authenticator_user.name authenticator_user_name',
            'rejected_user.name rejected_user_name',
            'need_revision_user.name need_revision_user_name'
        ])
            ->join('statustypes', 'statustypes.id = submissions.status_id', 'left')
            ->join('users request_user', 'request_user.id = submissions.request_user_id', 'left')
            ->join('users approval_one_user', 'approval_one_user.id = submissions.approval_one_user_id', 'left')
            ->join('users approval_two_user', 'approval_two_user.id = submissions.approval_two_user_id', 'left')
            ->join('users authenticator_user', 'authenticator_user.id = submissions.authenticator_user_id', 'left')
            ->join('users rejected_user', 'rejected_user.id = submissions.rejected_user_id', 'left')
            ->join('users need_revision_user', 'need_revision_user.id = submissions.need_revision_user_id', 'left')
            ->where('submissions.id', $id)
            ->get()->getResultArray();

        if(!$submissions){
            return ['message' => 'No submissions found', 'data' => null];
        }
        return ['message' => 'Submissions retrieved successfully', 
                'data' => $submissions];
    }

    public function getSubmissionRecap(){

        $submissionModel = new SubmissionModel();
        $submissions = $submissionModel->builder()->select('statustypes.name as status_name,
                                            count(submissions.status_id) as count_status')
                        ->join('statustypes', 'statustypes.id = submissions.status_id');

        if(session('active_group') == 'Pegawai'){
            $submissions->where('submissions.request_user_id', session('user_id'));
        } else {
            $submissions->where('submissions.status_id >', 1);
        }

        $submissions = $submissions->groupBy('statustypes.name')                        
                                    ->get()->getResultArray();

        $count = [];
        $count['pending'] = 0;
        foreach($submissions as $key => $submission){
            if(!isset($count[$submission['status_name']])){
                $count[$submission['status_name']] = 0;
            }
            $count[$submission['status_name']] = $submission['count_status'];
            if($submission['status_name'] != 'rejected' &&
               $submission['status_name'] != 'done'){
                $count['pending'] += $submission['count_status'];
               }            
        }

        $submissionByPeriod = $submissionModel->builder()->select([
            'submissions.year as year',
            'submissions.semester as semester',
            'count(submissions.id) as count',
            'sum(submissions.total_price) as total_price'
        ])->join('statustypes', 'statustypes.id = submissions.status_id')
        ->groupBy(['submissions.year', 'submissions.semester']);

        if(session('active_group') == 'Pegawai'){
            $submissionByPeriod->where('submissions.request_user_id', session('user_id'));
        } 

        $submissionByPeriod = $submissionByPeriod->where('statustypes.name', 'done')->get()->getResultArray();

        $data = [
            'count' => $count,
            'submissionByPeriod' => $submissionByPeriod
        ];

        if(!$submissions){
            return ['message' => 'No submissions found', 'data' => null];
        }

        return ['message' => 'Submissions retrieved successfully',
                'data' => $data];

    }

    public function getSubmissionItemBySubmissionId($id){
        $itemModel = new SubmissionItemModel();

        $items = $itemModel->builder()->select([
            'submissions_items.id  id',
            'submissions_items.submission_id  submission_id',
            'submissions_items.name  item_name',
            'submissions_items.price  price',
            'submissions_items.qty  qty',
            'submissions_items.total_price total_price',
        ])
            ->where('submissions_items.submission_id', $id)
            ->get()->getResultArray();

        if(!$items){
            return ['message' => 'No items found', 'data' => null];
        }

        return ['message' => 'Items retrieved successfully','data'=> $items];
    }

    public function updateSubmission($id, $params){

        $submissionModel = new SubmissionModel();
        $submission = $submissionModel->find($id);

        if(!$submission){
            return [
                "message" => "Submission not found",
                "data"=> null
            ];            
        }

        $submissionModel->update($id, $params);

        return [
            "message" => "Submission updated successfully",
            "data"=> $submission
        ];
    }


    // SUBMISSION ITEM
    public function addSubmissionItem($params){       

        try {
            $itemModel = new SubmissionItemModel();
            $itemModel->insert($params);

            return ["message"=> "Submission item created successfully","data"=> $itemModel->getInsertID()];

        } catch (Exception $e) {
            
            return ["message"=> $e->getMessage(), "data"=> null];
        }
    }

    public function getItemById($id){

        $itemModel = new SubmissionItemModel();
        $item = $itemModel->find($id);
        
        if(!$item){
            return [
                "message" => "Submission item not found",
                "data"=> null
            ];
        }

        return ["message"=> "Submission item retrieved successfully",
                "data"=> $item];
    }

    public function updateItem($id, $params){

        $itemModel = new SubmissionItemModel();
        $item = $itemModel->find($id);
        if(!$item){
            return [
                "message" => "Submission item not found",
                "data"=> null
            ];            
        }

        $itemModel->update($id, $params);

        return [
            "message" => "Submission item updated successfully",
            "data"=> $item
        ];
    }

    public function deleteItem($id){
        $itemModel = new SubmissionItemModel();
        $item = $itemModel->find($id);
        if(!$item){
            return [
                "message" => "Submission item not found",
                "data"=> false
            ];
        }

        $itemModel->delete($id);

        return [
            "message" => "Submission item deleted successfully",
            "data"=> true
        ];
    }

    
}
