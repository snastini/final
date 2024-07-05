<!-- Modal -->

<!-- Modal MANAGE GROUP -->


<div class="modal fade" id="manageGroupModal" tabindex="-1" aria-labelledby="manageGroupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="manageGroupLabel">Add Group for</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form  method="post" id="formAddGroup">
            <?php foreach($list_group as $group): ?>
            <div class="form-group">    
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="<?= $group['id'] ?>" id="group_<?= $group['id'] ?>" name="group_<?= $group['id'] ?>">
              <label class="form-check-label" for="flexCheckDefault">
                <?= $group['name'] ?>
              </label>
            </div>
            </div>
            <?php endforeach; ?>


            <div class="form-group">
            <button type="submit" class="btn btn-primary float-right">Update</button>
            </div>

        
        </form>
      </div>
    </div>
  </div>
</div>


