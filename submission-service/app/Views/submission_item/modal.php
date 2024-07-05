<!-- Modal -->

<!-- Modal EDIT SUBMISSION -->

<div class="modal fade" id="editSubmissionModal" tabindex="-1" aria-labelledby="editSubmissionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSubmissionLabel">Edit Submission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('submission/update/') . $detail[0]['id'] ?>" method="post">

            <div class="form-group">	
                <label for="name">Name</label>
                <input type="text" name="submission_name" id="submission_name" class="form-control">
            </div>

            <div class="form-group">    
                <label for="year">Year</label>           
                <select class="form-select" aria-label="Select Year" id="submission_year" name="submission_year">
                        <option selected disabled>Select Year</option>
                        <?php $yearNow= date("Y"); 
                        for($i=$yearNow; $i<=$yearNow+2; $i++):?>
                        <option value="<?=$i?>"><?=$i?></option>
                        <?php endfor;?>
                    </select>

            </div>

            <div class="form-group">    
            <label for="semester">Semester</label>
                    <select class="form-select" aria-label="Select Semester" id="submission_semester" name="submission_semester">
                        <option selected disabled>Select Semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        
                    </select>

            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-primary float-right">Update</button>
            </div>

        
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal REJECT SUBMISSION -->

<div class="modal fade" id="rejectSubmissionModal" tabindex="-1" aria-labelledby="rejectSubmissionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectSubmissionLabel">Reject Submission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('submission/reject/') . $detail[0]['id'] ?>" method="post">

            <div class="form-group">	
                <label for="name">Reason</label>
                <textarea class="form-control" id="reason_rejected" name="reason_rejected" rows="3"></textarea>
            </div>

  
            <div class="form-group">
            <button type="submit" class="btn btn-danger float-right">Reject Submission</button>
            </div>

        
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal REQUEST REVISION SUBMISSION -->

<div class="modal fade" id="requestRevisionSubmissionModal" tabindex="-1" aria-labelledby="requestRevisionSubmissionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requestRevisionSubmissionLabel">Reject Submission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('submission/revision/') . $detail[0]['id'] ?>" method="post">

            <div class="form-group">	
                <label for="name">Reason</label>
                <textarea class="form-control" id="reason_need_revision" name="reason_need_revision" rows="3"></textarea>
            </div>

  
            <div class="form-group">
            <button type="submit" class="btn btn-warning float-right">Request Revision</button>
            </div>

        
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal UPLOAD INVOICE -->

<div class="modal fade" id="uploadInvoiceModal" tabindex="-1" aria-labelledby="uploadInvoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadInvoiceLabel">Upload Invoice</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('submission/upload-invoice/') . $detail[0]['id'] ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">	
                <label for="name">Invoice</label>
                <input class="form-control" type="file" id="invoiceFile" name="invoiceFile">
            </div>

  
            <div class="form-group">
            <button type="submit" class="btn btn-warning float-right">Upload</button>
            </div>

        
        </form>
      </div>
    </div>
  </div>
</div>


