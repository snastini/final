<?php

namespace App\Controllers\Client;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Exception;

class SubmissionController extends BaseController
{
    use ResponseTrait;
    protected $submissionService;

    public function __construct()
    {
        $this->submissionService = Services::SubmissionServiceApi();
    }

    public function index()
    {
        try {
           $submissions = $this->submissionService->getAllSubmissions();
           $groupPermission = session('permissions_by_group');

            $data = [
                'title' => 'Submissions',
                'list' => $submissions
                ,'groupPermission' => $groupPermission
            ];
            
            return view('submission/page', $data);

        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            return $this->response->setJSON([
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function detail($id){

        $list = $this->submissionService->getSubmissionItemBySubmissionId($id);
        $detail = $this->submissionService->getSubmissionDetail($id);
        $groupPermission = session('permissions_by_group');

        $data= [
            'title' => 'Submission Detail',
            'detail' => $detail['data'],
            'list'=> $list,
            'groupPermission' => $groupPermission
        ];

        return view('submission_item/page', $data);
    }

    public function add(){

        try{
            $params = [
                'status_id' => 1,
                'name' => $this->request->getPost('name'),
                'year' => $this->request->getPost('year'),
                'semester' => $this->request->getPost('semester'),
                'request_user_id' => session('user_id')
            ];

            $validation = Services::validation();
            $validation->setRules([
                'name' => 'required',
                'year' => 'required',
                'semester' => 'required'
            ]);

            if(!$validation->run($params)){
                session()->setFlashdata('errors', $validation->getErrors());
                return redirect()->back()->withInput();
            }
    
            $result = $this->submissionService->addSubmission($params);

            session()->setFlashdata('success', 'Submission created successfully.');
            return redirect('submission/detail/'.$result['data']);    

        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());

            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->back()->withInput();
        }

    }

    public function delete($id){

        try{
            $this->submissionService->deleteSubmission($id);

            session()->setFlashdata('success', 'Submission deleted successfully.');
            return redirect()->back();  
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', $e->getMessage());
            return redirect()->back();
        }


    }

    public function update($id){
        try{
            $params = [
                'name' => $this->request->getPost('submission_name'),
                'year' => $this->request->getPost('submission_year'),
                'semester' => $this->request->getPost('submission_semester')
            ];
            $result = $this->submissionService->updateSubmission($id, $params);
            session()->setFlashdata('success', $result['message']);
            return redirect()->back();
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', $e->getMessage());
            return redirect()->back();
        }

    }

    public function submit($id){

        try{
            $params = [
                'status_id' => 3
            ];
            $result = $this->submissionService->updateSubmission($id, $params);
            session()->setFlashdata('success', $result['message']);
            return redirect()->back();
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', $e->getMessage());
            return redirect()->back();
        }
    }

    public function reject($id){
        try{
            $params = [
                'status_id' => 7,
                'rejected_user_id' => session('user_id'),
                'reason_rejected' => $this->request->getPost('reason_rejected')
            ];
            $result = $this->submissionService->updateSubmission($id, $params);
            session()->setFlashdata('success', 'Submission rejected successfully');
            return redirect()->back();
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', $e->getMessage());
            return redirect()->back();
        }
    }

    public function revision($id){
        try{
            $params = [
                'status_id' => 2,
                'need_revision_user_id' => session('user_id'),
                'reason_need_revision' => $this->request->getPost('reason_need_revision')
            ];
            $result = $this->submissionService->updateSubmission($id, $params);
            session()->setFlashdata('success', 'Submission need revision successfully');
            return redirect()->back();
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', $e->getMessage());
            return redirect()->back();
        }
    }

    public function approveOne($id){

        try{
            $params = [
                'status_id' => 4,
                'approval_one_user_id' => session('user_id')
            ];
            $result = $this->submissionService->updateSubmission($id, $params);
            session()->setFlashdata('success', 'Submission approved successfully');
            return redirect()->back();
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', $e->getMessage());
            return redirect()->back();
        }
    }

    public function approveTwo($id){

        try{
            $params = [
                'status_id' => 5,
                'approval_two_user_id' => session('user_id')
            ];
            $result = $this->submissionService->updateSubmission($id, $params);
            session()->setFlashdata('success', 'Submission approved successfully');
            return redirect()->back();
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', $e->getMessage());
            return redirect()->back();
        }
    }

    public function authenticate($id){

        try{
            $params = [
                'status_id' => 8,
                'authenticator_user_id' => session('user_id')
            ];
            $result = $this->submissionService->updateSubmission($id, $params);
            session()->setFlashdata('success', 'Submission approved successfully');
            return redirect()->back();
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', $e->getMessage());
            return redirect()->back();
        }
    }

    public function uploadInvoice($id){
        try{
            $validationRules = [
                'invoiceFile' => [
                    'label' => 'Invoice File',
                    'rules' => 'uploaded[invoiceFile]|mime_in[invoiceFile,application/pdf]|max_size[invoiceFile,2048]',
                ],
            ];
            if (!$this->validate($validationRules)) {
                session()->setFlashdata('errors', $this->validator->getErrors());
                return redirect()->back();
            }

            $file = $this->request->getFile('invoiceFile');           

            if(!is_dir('./uploads/invoice')){
                mkdir('./uploads/invoice', 0777, true);
            }

            if(!is_dir('./uploads/invoice/'.session('user_id'))){
                mkdir('./uploads/invoice/'.session('user_id'), 0777, true);
            }

            $newName = 'Invoice_' . $id . '.' . $file->getClientExtension();

            $file->move('./uploads/invoice/'.session('user_id'), $newName, true);

            if(!file_exists('./uploads/invoice/'.session('user_id').'/'.$newName)){
                throw new Exception("Failed to upload invoice file");
            }

            $params = [
                'invoice_dir' => './uploads/invoice/'.session('user_id').'/'.$newName
            ];

            $result = $this->submissionService->updateSubmission($id, $params);

            session()->setFlashdata('success', 'Receipt file uploaded successfully');
            return redirect()->back();
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', $e->getMessage());
            return redirect()->back();
        }


    }

    public function submitTwo($id){
        try{
            $params = [
                'status_id' => 6
            ];
            $result = $this->submissionService->updateSubmission($id, $params);
            session()->setFlashdata('success', 'Submission submitted successfully');
            return redirect()->back();
        } catch (Exception $e) {
            $this->logger->error("Error from Submission Service: " . $e->getMessage());
            session()->setFlashdata('errors', $e->getMessage());
            return redirect()->back();
        }
    }



}
