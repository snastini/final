

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="<?= base_url('bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('fontawesome-free/css/all.min.css')?>">    
    <link rel="stylesheet" href="<?= base_url('css/style.css')?>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="<?= base_url('bootstrap/dist/js/bootstrap.min.js')?>"></script>
    

</head>
<body>


		
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="p-4 pt-5">
                    <a href="<?= base_url('dashboard') ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-4" >HRD</span>
                    </a>
                    <hr style="background-color: white; height: 2px; border: 0;">
                    <h5 class="mb-0 text-white" ><?= session('name') ?></h5>
                    <select class="form-select mt-3" aria-label="Default select example" onchange="ChangeGroup(this)">
                       <?php foreach(session('permissions_by_group') as $group => $permission):?>
                            <?php if($group == session('active_group')): ?>
                            <option value="<?= $group ?>" selected><?= $group ?></option>
                            <?php else:?>
                            <option value="<?= $group ?>"><?= $group ?></option>
                            <?php endif;?>

                       <?php endforeach; ?>

                    </select>
                    <hr style="background-color: white; height: 2px; border: 0;">
	                <ul class="list-unstyled components mb-5">
                        <li class="<?= $title == 'Dashboard' ? 'active' : '' ?>">
                            <a href= "<?= base_url('dashboard') ?>" >Dashboard</a>                            
                        </li>
                        <?php if(in_array('view_submissions_page', $groupPermission[session('active_group')])):?>
                        <li class="<?= str_contains($title, 'Submission') ? 'active' : '' ?>">
                            <a href= "<?= base_url('submission') ?>">Submission</a>                       
                        </li>
                        <?php endif; ?>
                        <?php if(in_array('view_user_management_page', $groupPermission[session('active_group')])):?>
                        <li class="<?= str_contains($title, 'User') ? 'active' : '' ?>">
                            <a href= "<?= base_url('user') ?>">User Management</a>                       
                        </li>
                        <?php endif;?>
                       
                    </ul>

                   
                    <hr style="background-color: white; height: 2px; border: 0;">
                    <div class="footer">
                        <p>Suci © Copyright 2024. All Rights Reserved.</p>
                    </div>
	            </div>
    	    </nav>

        <!-- Page Content  -->
      <div id="content" class="p-4 p-md-5">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="btn btn-primary">
              <i class="fa fa-bars"></i>
              <span class="sr-only">Toggle Menu</span>
            </button>

            <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                <?=session('name') ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
            <li class="nav-item active">
                <li><button class="dropdown-item" type="button" onclick="changePassword()">Change Password</button></li>
                    
                </li>
                <li class="nav-item active">
                    <a class="dropdown-item" type="button" href="<?= base_url('/logout') ?>">Logout</a>
                </li>
            </ul>
            </div>


          </div>
        </nav>



       



<script>
    function ChangeGroup(e){
        console.log(e.value);

        $.ajax({
            url: '<?= base_url('dashboard/change_group') ?>',
            type: 'POST',
            data: {
                groupName: e.value
            },
            success: function(response){

                console.log(response);
                if(response.status){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Successfully changed group',
                    }).then((result) => {
                        location.reload();
                        });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to change group',
                    })
                }
                
            }
        })
    }

    
    function changePassword(){
        id= <?=session('user_id') ?>
            
        $('#resetPasswordModal').modal('show');
        $('#formResetPassword').attr('action', '<?= base_url('dashboard/change_password/') ?>'+ id);

    }
</script>