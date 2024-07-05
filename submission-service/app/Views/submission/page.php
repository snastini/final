

<?=view('__layout/header'); ?>

<h2 class="mb-4"><?=$title?></h2>
<?=view('__layout/flashdata'); ?>

<!-- CONTENT -->

<?php if(in_array('add_submissions', $groupPermission[session('active_group')])):?>
<?=view('submission/add');?>
<?php endif;?>
<?=view('submission/list');?>

 <!-- CONTENT END -->
 </div>
</div>


<?=view('__layout/footer');?>