<?php var_dump($detail)?>
<div class="row mt-3" >

<div class="col-md-12 card " >
    <div class="card-body" >
        <h3 id="CardTitle"><?=$detail['name']?></h3>   
        

        <div class="row">
            <div class="col-12">
                <table class="table mt-4 table-borderless">                        
                    <tbody>
                    <tr>
                        <td>Email</td>
                        <td>:</td>
                        <td><?=$detail['email']?></td>
                    </tr>
                    <tr>
                        <td>Registration Status</td>
                        <td>:</td>
                        <td><?php if($detail['is_registered']): ?> Registered 
                            <?php else:?>
                                <a onClick="acceptUser(<?= $detail['id']?>)" class="btn btn-success btn-sm">Accept</a>
                            <?php endif;?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            

        </div>

    </div>
    </div>
</div> 


<script>

function acceptUser(id){
    $.ajax({
        url: "<?= base_url('user/accept') ?>",
        method: "POST",
        data: {id:id},
        success: function(data){
            location.reload();
        }
    })
}
</script>