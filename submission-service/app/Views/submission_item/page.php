<?=view('__layout/header'); ?>

<h2 class="mb-4"><?=$title?></h2>
<?=view('__layout/flashdata'); ?>

<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button type="button" class="btn btn-info btn-sm" onclick="location.href='<?=base_url('submission') ?>'">Back to Submission List</button>
</div>




<!-- CONTENT -->

<?=view('submission_item/detail'); ?>
<?=view('submission_item/modal');?>
<?php if(in_array('add_submissions', $groupPermission[session('active_group')]) &&
($detail[0]['status_id'] == 1 || $detail[0]['status_id'] == 2)):?>
<?=view('submission_item/add'); ?>
<?php endif;?>
<?=view('submission_item/list'); ?>

<!-- CONTENT END -->
 </div>
</div>


<?=view('__layout/footer');?>