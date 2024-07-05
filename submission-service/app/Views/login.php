<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="<?= base_url('bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">

</head>
<body>
<?=view('__layout/flashdata'); ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mt-5">
                    <div class="card-header">
                        Welcome to Submisison HRD
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('login') ?>" method="post">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-primary">Login</button>
                                
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <p>Do not have an account?</p>
                    <a href="<?= base_url('register') ?>" class="btn btn-secondary" type="button">Register</a>
                    </div>
                    
                    </div>

                    
                </div>
            </div>
        </div>

    </div>
</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="<?= base_url('bootstrap/dist/js/bootstrap.min.js')?>"></script>