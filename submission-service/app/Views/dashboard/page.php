<?=view('__layout/header'); ?>

<h2 class="mb-4"><?=$title?></h2>
<?=view('__layout/flashdata'); ?>

<!-- CONTENT -->
 <div class="row">


    <div class="col-md-12 card">
        <div class="card-body">
            <div class="row">
            <div class="col-md-2">
            <img src="<?=base_url('images/avatar.jpg')?>" class="card-img" alt="" width="100%">
            </div>

            <div class="col-md-10">
            <h4 class="card-title"><?=session('name')?></h4>
                <p class="card-text">Email : <?=session('email')?></p>
                <p class="card-text">Active Group : <?=session('active_group')?></p>
            </div>
            </div>
        </div>
    </div>
 </div>

 <div class="row mt-3">
<?php if(isset($submission['data']['count'])){ $count = $submission['data']['count'];}?>

    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3" >
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white"><h5 class="card-title">Submission Pending</h5></div>
                        <div class="text-lg fw-bold"><h2 class="card-title"><?= isset($count['pending']) ? $count['pending'] : 0?></h2></div>
                    </div>
                    <h1 class="card-title"><i class="fa-regular fa-clock"></i></h1>
                </div>
               
            </div>
            </div>
    </div>
        
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3" >            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white"><h5 class="card-title">Submission Done</h5></div>
                        <div class="text-lg fw-bold"><h2 class="card-title"><?= isset($count['done']) ? $count['done'] : 0?></h2></div>
                    </div>
                    <h1 class="card-title"><i class="fa-solid fa-check"></i></h1>
                </div>
            </div>
        </div>
    </div>
        
    <div class="col-md-4">
        <div class="card text-white bg-danger mb-3" >
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="me-3">
                        <div class="text-white"><h5 class="card-title">Submission Rejected</h5></div>
                        <div class="text-lg fw-bold"><h2 class="card-title"><?= isset($count['rejected']) ? $count['rejected'] : 0?></h2></div>
                    </div>
                    <h1 class="card-title"><i class="fa-solid fa-xmark"></i></h1>
                </div>
              
            </div>
        </div>
    </div>
 </div>

 <div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
            <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Year</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Number of completed Submissions</th>
                        <th scope="col">Total Price</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php if(empty($submission['data']['submissionByPeriod'])):?>
                        <tr>
                            <td colspan="5" class="text-center">No data</td>
                        </tr>

                    <?php else: ?>
                        <?php $no= 1; foreach($submission['data']['submissionByPeriod'] as $submission): ?>
                        <tr>
                        <th scope="row"><?=$no?></th>
                        <td><?=$submission['year']?></td>
                        <td><?=$submission['semester']?></td>
                        <td><?=$submission['count'] ?></td>
                        <td><?=$submission['total_price'] ?></td>
                        </tr>
                    <?php $no++; endforeach;?>
                    <?php endif; ?>


                    </tbody>
                    </table>
            </div>
        </div>
    </div>

 </div>

 

<!-- CONTENT END -->
    </div>
    </div>


<?=view('__layout/footer');?>