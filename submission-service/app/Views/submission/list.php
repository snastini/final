 <div class="row mt-3">
    
    <div class="col-md-12 card">

        <div class="card-body">
        <h3>Submision List</h3>
        <table class="table mt-4">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Applicant</th>
                <th scope="col">Year</th>
                <th scope="col">Semester</th>
                <th scope="col" class="text-center">Total Item</th>
                <th scope="col" class="text-center">Total Qty</th>
                <th scope="col" class="text-center">Total Price</th>
                <th scope="col" class="text-center">Status</th>
                <?php if(in_array('view_submission_details', $groupPermission[session('active_group')])):?>
                <th class="text-center">Action</th>
                <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php if($list['data'] == null): ?>
                <tr><td colspan="6"><?= $list['message'] ?></td></tr>


            <?php else: 
            foreach($list['data'] as $submission): ?>
                <tr>
                <th scope="row" class="text-center"><?= $submission['id'] ?></th>
                <td><?= $submission['name'] ?></td>
                <td><?= $submission['request_user_name'] ?></td>
                <td class="text-center"><?= $submission['year'] ?></td>
                <td class="text-center"><?= $submission['semester'] ?></td>                
                <td class="text-center"><?= $submission['total_item'] ?></td>
                <td class="text-center"><?= $submission['total_qty'] ?></td>
                <td class="text-center"><?= "Rp " . number_format($submission['total_price'], 0, ',', '.')   ?></td>
                <td class="text-center"><?= $submission['status_description'] ?></td>
                <?php if(in_array('view_submission_details', $groupPermission[session('active_group')])):?>
                <td class="text-center">
                    <div class="d-grid d-md-block  gap-2">                
                <a href="<?= base_url('submission/detail/'.$submission['id']) ?>" class="btn btn-primary btn-sm" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" 
                data-bs-content="View Detail"><i class="fa-regular fa-eye"></i></a>                
                <?php if(in_array('delete_submissions', $groupPermission[session('active_group')]) 
                && ($submission['status_id'] == 1 || $submission['status_id'] == 2)):?>
                <a href="<?=base_url('submission/delete/'.$submission['id']) ?>" class="btn btn-danger btn-sm" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" 
                data-bs-content="Delete"><i class="fa-solid fa-trash-can"></i></a>
                <?php endif; ?>
                    </div>                    
                </td>
                <?php endif;?>
                </tr>
            <?php endforeach; ?>
            <?php endif;?>

            </tbody>
            </table>
            
        </div>
    </div>
    </div>


