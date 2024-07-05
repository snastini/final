<div class="row mt-3" id="DetailSubmission">

<div class="col-md-12 card " >
    <div class="card-body" >
        <h3 id="CardTitle"><?=$detail[0]['name']?> 
            <span class="badge bg-<?=$detail[0]['status_color']?> "><?=$detail[0]['status_description']?>
        </span></h3>   
        
        <div class="row">
            <div class="col-5">
                <table class="table mt-4 table-borderless">                        
                    <tbody>
                    <tr>
                        <td>Applicant</td>
                        <td>:</td>
                        <td><?=$detail[0]['request_user_name']?></td>
                    </tr>
                    <tr>
                        <td>Year</td>
                        <td>:</td>
                        <td><?=$detail[0]['year']?></td>
                    </tr>
                    <tr>
                        <td>Semester</td>
                        <td>:</td>
                        <td><?=$detail[0]['semester']?></td>
                    </tr>
                    </tbody>
                </table>
            </div>

  
            

        </div>
        <div class="row">
            <div class="col-9">
                <table class="table mt-4 table-borderless">
                    <tbody>
                        <?php if($detail[0]['approval_one_user_name'] != null): ?>
                            <tr>
                                <td>Approved Atasan By</td>
                                <td>:</td>
                                <td><?=$detail[0]['approval_one_user_name']?></td>
                            </tr>
                        <?php endif;?>
                        <?php if($detail[0]['approval_two_user_name'] != null): ?>
                            <tr>
                                <td>Approved HRD By</td>
                                <td>:</td>
                                <td><?=$detail[0]['approval_two_user_name']?></td>
                            </tr>
                        <?php endif;?>
                        <?php if($detail[0]['authenticator_user_name'] != null): ?>
                            <tr>
                                <td>Authenticator</td>
                                <td>:</td>
                                <td><?=$detail[0]['authenticator_user_name']?></td>
                            </tr>
                        <?php endif;?>
                        <?php if($detail[0]['rejected_user_name'] != null): ?>
                            <tr>
                                <td>Rejected By</td>
                                <td>:</td>
                                <td><?=$detail[0]['rejected_user_name']?></td>
                            </tr>
                        <?php endif;?>
                        <?php if($detail[0]['need_revision_user_name'] != null): ?>
                            <tr>
                                <td>Request Revision By</td>
                                <td>:</td>
                                <td><?=$detail[0]['need_revision_user_name']?></td>
                            </tr>
                        <?php endif;?>
                        <?php if($detail[0]['reason_rejected'] != null): ?>
                            <tr>
                                <td>Reason Rejected</td>
                                <td>:</td>
                                <td><?=$detail[0]['reason_rejected']?></td>
                            </tr>
                        <?php endif;?>
                        <?php if($detail[0]['reason_need_revision'] != null): ?>
                            <tr>
                                <td>Reason Revision</td>
                                <td>:</td>
                                <td><?=$detail[0]['reason_need_revision']?></td>
                            </tr>
                        <?php endif;?>

                        <?php if($detail[0]['invoice_dir'] != null): ?>
                            <tr>
                                <td>Invoice</td>
                                <td>:</td>
                                <td><a href="<?=base_url($detail[0]['invoice_dir'])?>" type="button" class="btn btn-info " target="_blank">Download</a></td>
                            </tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>




        <div class="d-grid gap-2 d-md-flex justify-content-md-end">

            <?php if(in_array('update_submission', $groupPermission[session('active_group')]) &&
            ($detail[0]['status_id'] == 1 || $detail[0]['status_id'] == 2)):?>
            <button onclick="editDetail()" type="button" class="btn btn-warning ">Edit</button>
            <?php endif;?>


            <?php if(in_array('upload_invoice_submission', $groupPermission[session('active_group')]) &&
            ($detail[0]['status_id'] == 5) && ($detail[0]['request_user_id'] == session('user_id'))):?>
            <button  type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#uploadInvoiceModal">Upload Invoice</button>
            <?php endif;?>

        </div>


    </div>
    </div>
</div>

<script>
    function editDetail(){
        $('#submission_name').val('<?=$detail[0]['name'] ?>');
        $('#submission_year').val(<?=$detail[0]['year'] ?>);
        $('#submission_semester').val(<?=$detail[0]['semester'] ?>);
        $('#editSubmissionModal').modal('show');
    }

</script>