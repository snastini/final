<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class ItemController extends BaseController
{
    use ResponseTrait;
    protected $submissionService;

    public function __construct()
    {
        $this->submissionService = Services::SubmissionServiceApi();
    }

    public function add($id){

        try{

            $price = $this->request->getPost('price');
            $qty = $this->request->getPost('quantity');

            $total_price = $price * $qty;

            $params = [
                'submission_id' => $id,
                'name' => $this->request->getPost('name'),
                'price' => $price,
                'qty' => $qty,
                'total_price' => $total_price
            ];

            $validation = Services::validation();
            $validation->setRules([
                'name' => 'required',
                'price' => 'required',
                'qty' => 'required'
            ]);

            if(!$validation->run($params)){
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->back()->withInput();
            }
    
            $submissionRekap = $this->submissionRekapAdd($params['submission_id'], $params);

            if($submissionRekap['data'] == null){
                session()->setFlashdata('errors', [$submissionRekap['message']]);
                return redirect()->back()->withInput();
            }

            $result = $this->submissionService->addSubmissionItem($params);

            if($result['data'] == null){
                session()->setFlashdata('errors', [$result['message']]);
                return redirect()->back()->withInput();
            } 


            session()->setFlashdata('success', $result['message']);
            return redirect('submission/detail/'.$id);

        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());

            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->back()->withInput();
        }

    }

    public function update($id){
        try {
            $price = $this->request->getPost('price');
            $qty = $this->request->getPost('quantity');
            $total_price = $price * $qty;
            $params = [
                'name' => $this->request->getPost('name'),
                'price' => $price,
                'qty' => $qty,
                'total_price' => $total_price
            ];

            $validation = Services::validation();
            $validation->setRules([
                'name' => 'required',
                'price' => 'required',
                'qty' => 'required'
            ]);

            if(!$validation->run($params)){
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->back()->withInput();
            }

            $oldItem = $this->submissionService->getItemById($id);

            if($oldItem['data'] == null){
                session()->setFlashdata('errors', [$oldItem['message']]);
                return redirect()->back()->withInput();
            }

            $oldData = ['qty' => $oldItem['data']['qty'],
                        'total_price' => $oldItem['data']['total_price']
                        ]; 

            $submissionRollback = $this->submissionRekapRollback($oldItem['data']['submission_id'], $oldData);

            if($submissionRollback['data'] == null){
                session()->setFlashdata('errors', [$submissionRollback['message']]);
                return redirect()->back()->withInput();
            }  

            $submissionRekap = $this->submissionRekapAdd($oldItem['data']['submission_id'], $params);

            if($submissionRekap['data'] == null){
                session()->setFlashdata('errors', [$submissionRekap['message']]);
                return redirect()->back()->withInput();
            } 

             $result = $this->submissionService->updateItem($id, $params);

            if($result['data'] == null){
                $this->submissionRekapRollback($oldItem['data']['submission_id'], $params);
                $this->submissionRekapAdd($oldItem['data']['submission_id'], $oldData);
                session()->setFlashdata('errors', [$result['message']]);
                return redirect()->back()->withInput();

            }


            session()->setFlashdata('success', $result['message']);
            return redirect('submission/detail/'.$oldItem['data']['submission_id']); 

        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            return redirect()->back()->withInput();
            
        }
    }

    public function fetch(){

        $id = $this->request->getPost('id');

        try{
            $item = $this->submissionService->getItemById($id);
            return $this->response->setJSON([
                'message' => $item['message'],
                'data' => $item['data']
            ])->setStatusCode(200);
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage(),
                'data' => null
            ])->setStatusCode(500);
        }

    
    }

    public function delete($id){

        try{

            $oldItem = $this->submissionService->getItemById($id);
            $oldData = ['qty' => $oldItem['data']['qty'],
                        'total_price' => $oldItem['data']['total_price']
                        ];

            $submissionRollback = $this->submissionRekapRollback($oldItem['data']['submission_id'], $oldData);
            if($submissionRollback['data'] == null ){
                session()->setFlashdata('errors', [$submissionRollback['message']]);
                return redirect()->back()->withInput();
            }

            $result = $this->submissionService->deleteItem($id);

            if($result['data'] == false){
                session()->setFlashdata('errors', [$result['message']]);
                return redirect()->back()->withInput();
            }

            session()->setFlashdata('success', $result['message']);
            return redirect()->back();

        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage(),
                'data' => false
            ])->setStatusCode(500);
        }
    }

    public function submissionRekapAdd($id, $params){

        try {
            $submission = $this->submissionService->getSubmissionDetail($id);
            $data = [
                'total_item' => $submission['data'][0]['total_item'] + 1,
                'total_qty' => $submission['data'][0]['total_qty'] + $params['qty'],
                'total_price' => $submission['data'][0]['total_price'] + $params['total_price']
            ];
            $result = $this->submissionService->updateSubmission($id, $data);

            return $result;


        } catch (Exception $e) {
            return [
                "message" => "Error from Submission Service: " . $e->getMessage(),
                "data"=> null
            ];  
        }

    }

    public function submissionRekapRollback($id, $params){
        try {
            $submission = $this->submissionService->getSubmissionDetail($id);
            $data = [
                'total_item' => $submission['data'][0]['total_item'] - 1,
                'total_qty' => $submission['data'][0]['total_qty'] - $params['qty'],
                'total_price' => $submission['data'][0]['total_price'] - $params['total_price']
            ];
            $result = $this->submissionService->updateSubmission($id, $data);

            return $result;


        } catch (Exception $e) {
            return [
                "message" => "Error from Submission Service: " . $e->getMessage(),
                "data"=> null
            ];  
        }

    }


}
