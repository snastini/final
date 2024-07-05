<div class="row mt-3">
    <div class="col-md-12 card">

        <div class="card-body">
        <h3>Submision Item List</h3>

        <table class="table mt-4">
                    <thead>
                        <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Item Name</th>
                        <th scope="col" class="text-center">Price</th>
                        <th scope="col" class="text-center">Quantity</th>
                        <th scope="col" class="text-center">Total Price</th>
                        <?php if(in_array('update_submission_items', $groupPermission[session('active_group')])
                        && ($detail[0]['status_id'] == 1 || $detail[0]['status_id'] == 2)):?>
                        <th class="text-center">Action</th>
                        <?php endif; ?>
                        </tr>
            </thead>
            <tbody>

            <?php if($list['data'] == null): ?>
                <tr><td colspan="6"><?= $list['message'] ?></td></tr>


            <?php else: 
                $no = 1;
                foreach($list['data'] as $item): ?>
                <tr>
                <th scope="row"  class="text-center"><?= $no?></th>
                <td><?= $item['item_name'] ?></td>
                <td class="text-center"><?=  "Rp " . number_format($item['price'], 0, ',', '.') ?></td>
                <td class="text-center"><?= $item['qty'] ?></td>
                <td class="text-center"><?=  "Rp " . number_format($item['total_price'], 0, ',', '.') ?></td>     
                <?php if(in_array('update_submission_items', $groupPermission[session('active_group')])
                && ($detail[0]['status_id'] == 1 || $detail[0]['status_id'] == 2)):?>           
                <td class="text-center">
                    <div class="d-grid d-md-block  gap-2">
                <a onclick="editItem(<?=$item['id'] ?>)" class="btn btn-primary btn-sm" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" 
                data-bs-content="Edit Item"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="<?=base_url('item/delete/'.$item['id'])?>" class="btn btn-danger btn-sm" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" 
                data-bs-content="Delete"><i class="fa-solid fa-trash-can"></i></a>
                    </div>
                    
                </td>
                <?php endif; ?>
                </tr>

            <?php $no++; endforeach; ?>
            <?php endif;?>

            </tbody>
        </table>

        <div class="row">
            <div class="col-5">
                
            <table class="table mt-4 table-borderless">                        
                <tbody>
                    <tr>
                        <td>Total Item</td>
                        <td>:</td>
                        <td><?=$detail[0]['total_item']?></td>
                    </tr>
                    <tr>
                        <td>Total Quantity</td>
                        <td>:</td>
                        <td><?=$detail[0]['total_qty']?></td>
                    </tr>
                    <tr>
                        <td>Total Price</td>
                        <td>:</td>
                        <td><?= "Rp " . number_format($detail[0]['total_price'], 0, ',', '.') ?></td>
                    </tr>
                    </tbody>
            </table>

            </div>
        </div>


        <div class="d-grid gap-2 d-md-flex justify-content-md-end">

        <?php if(in_array('submit_submission', $groupPermission[session('active_group')]) &&
        ($detail[0]['status_id'] == 1 || $detail[0]['status_id'] == 2) && ($detail[0]['request_user_id'] == session('user_id'))):?>
        <a href="<?=base_url('submission/submit/').$detail[0]['id'] ?>" type="button" class="btn btn-success ">Submit</a>
        <?php endif;?>

        <?php if(in_array('upload_invoice_submission', $groupPermission[session('active_group')]) &&
        ($detail[0]['status_id'] == 5) && ($detail[0]['request_user_id'] == session('user_id')) && ($detail[0]['invoice_dir'] != null)):?>
        <a href="<?=base_url('submission/submit-two/').$detail[0]['id'] ?>" type="button" class="btn btn-success ">Submit</a>
        <?php endif;?>

        <?php if(in_array('approval_one_submission', $groupPermission[session('active_group')]) &&
        ($detail[0]['status_id'] == 3)):?>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectSubmissionModal">Reject</button>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#requestRevisionSubmissionModal">Revision</button>
        <a href="<?=base_url('submission/approve-one/').$detail[0]['id'] ?>" type="button" class="btn btn-success">Approve</a>
        <?php endif;?>

        <?php if(in_array('approval_two_submission', $groupPermission[session('active_group')]) &&
        ($detail[0]['status_id'] == 4)):?>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectSubmissionModal">Reject</button>
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#requestRevisionSubmissionModal">Revision</button>
        <a href="<?=base_url('submission/approve-two/').$detail[0]['id'] ?>" type="button" class="btn btn-success">Approve</a>
        <?php endif;?>

        <?php if(in_array('authenticate_submission', $groupPermission[session('active_group')]) &&
        ($detail[0]['status_id'] == 6)):?>
        <a href="<?=base_url('submission/authenticate/').$detail[0]['id'] ?>" type="button" class="btn btn-success">Authenticate</a>
        <?php endif;?>






        </div>
        
        



            
        </div>
    </div>
    </div>

<script>

    function editItem(id){
        $.ajax({
            url: '<?=base_url('item/fetch') ?>',
            type: 'POST',
            data: {id:id},
            success: function(response){
                data = response.data
                $('#name').val(data.name)
                $('#price').val(data.price)
                $('#quantity').val(data.qty)
                $('#formItem').attr('action', '<?= base_url("item/update/")?>'+data.id);
                $('#BtnItem').empty();
                $('#BtnItem').append('<button type="submit" class="btn btn-primary float-right">Edit</button>');
                $('#CardTitleItem').empty();
                $('#CardTitleItem').append('Edit Item');
               
                console.log(response)
            }
        })   
    }


</script>