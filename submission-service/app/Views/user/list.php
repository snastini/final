
<div class="row mt-3">
    
    <div class="col-md-12 card">

        <div class="card-body">
        <h3>User List</h3>
        <table class="table mt-4">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col" class="text-center">Name</th>
                <th scope="col" class="text-center">Email</th>
                <th scope="col" class="text-center">Registration Status</th>
                <th class="text-center">Group</th>
                <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php if($list['data'] == null): ?>
                <tr><td colspan="6"><?= $list['message'] ?></td></tr>


            <?php else: 
            foreach($list['data'] as $key => $user): ?>
                <tr>
                <th scope="row" class="text-center"><?= $key ?></th>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td class="text-center"><?php if($user['is_registered']): ?> Registered 
                    <?php else:?>
                        <a href="<?= base_url('user/accept/'.$key) ?>" class="btn btn-success btn-sm">Accept</a>
                    <?php endif;?>
                </td>
                <td>
                    <?php foreach($user['groups'] as $gkey => $group): ?>
                        <span class="badge bg-primary text-light"><?= $group ?></span><br>
                    <?php endforeach; ?>
                </td>
                <td class="text-center">
                    
                    <div class="d-grid d-md-block gap-2">
                    <?php if($user['is_registered']): ?>

                <a onclick="manageUser(<?= $key?>)" class="btn btn-success btn-sm" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" 
                data-bs-content="Edit User">
                    <i class="fa-regular fa-user"></i></a>
                <a onclick="manageGroup(<?= $key?>, '<?= $user['name'] ?>')" class="btn btn-primary btn-sm" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" 
                data-bs-content="Manage User Group"><i class="fa-solid fa-user-group"></i></a>
                <a onclick="resetPassword(<?= $key?>)" class="btn btn-secondary btn-sm" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" 
                data-bs-content="Reset Password"><i class="fa-solid fa-key"></i></a>     
                    <?php endif; ?>             
                <a href="<?=base_url('user/delete/'.$key)?>"  class="btn btn-danger btn-sm" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" 
                data-bs-content="Delete User"><i class="fa-solid fa-trash-can"></i></a>
                    </div>
                    
                </td>
                </tr>
            <?php endforeach; ?>
            <?php endif;?>

            </tbody>
            </table>
            
        </div>
    </div>
    </div>



    <script>

        function resetPassword(id){
            
            $('#resetPasswordModal').modal('show');
            $('#formResetPassword').attr('action', '<?= base_url('user/reset_password/') ?>'+ id);

        }

        function manageUser(id){

            $.ajax({
                url: "<?= base_url('user/get_user') ?>",
                method: "POST",
                data: {id:id},
                success: function(data){
                   console.log(data.data)
                   user = data.data
                   $('#name').val(user.name)
                   $('#email').val(user.email)
                   $('#formGroupPassword').prop('hidden', true)
                   $('#formGroupPassword2').prop('hidden', true)
                   $('#formAddUser').attr('action', '<?= base_url('user/update_user/') ?>'+ user.id);
                   $('#CardAddUserTitle').html('Edit User');
                   $('#BtnAddUser').empty();
                   $('#BtnAddUser').append('<button type="submit" class="btn btn-primary float-right">Edit</button>');

                  

                }
            })
            
        }
        function manageGroup(id, name){

            $.ajax({
                url: "<?= base_url('user/get_group') ?>",
                method: "POST",
                data: {id:id},
                success: function(data){
                   console.log(data.data)
                   groups = data.data
                   $('#manageGroupLabel').html('Manage Group for '+name);
                   $('#formAddGroup').attr('action', '<?= base_url('user/add_group/') ?>'+ id);

                   allgroups = <?= json_encode($list_group) ?>

                   allgroups.forEach(element => {
                       $('#group_'+element.id).prop('checked', false);
                   })
                   
                   groups.forEach(element => { 
                       $('#group_'+element.group_id).prop('checked', true);
                   });
                  
                   $('#manageGroupModal').modal('show');
                }
            })
        }

        function addGroup(id, name){
            console.log(id, name)
            $('#user_id').val(id);
            $('#user_name').val(name);
            $('#addGroupModal').modal('show');
        }
    </script>

