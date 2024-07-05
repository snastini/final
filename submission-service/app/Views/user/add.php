

<div class="row">

    <div class="col-md-12 card " >
        <div class="card-body" >
            <h3 id="CardAddUserTitle">Add User</h3> 

            <form  method="post" id="formAddUser">
                
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="form-group" id="formGroupPassword">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group" id="formGroupPassword2">
                    <label for="password">Confirm Password</label>
                    <input type="password" name="password2" id="password2" class="form-control">
                </div>
                
                
                <div class="form-group mt-5"  id="BtnAddUser">
                    <button type="submit" class="btn btn-primary float-right">Add</button>
                </div>

            </form>  

        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    $('#formAddUser').attr('action', '<?= base_url('register') ?>');
  });
</script>