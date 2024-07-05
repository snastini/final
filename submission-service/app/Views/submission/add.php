

<div class="row">

    <div class="col-md-12 card " >
        <div class="card-body" >
            <h3 id="CardTitle">Add Submission</h3> 

            <form action="<?= base_url('submission/add') ?>" method="post">
                
                <div class="form-group">
                    <label for="name">Submission Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>

                <div class="form-group">
                    
                    <label for="year">Year</label>
                    <select class="form-select" aria-label="Select Year" id="year" name="year">
                        <option selected disabled>Select Year</option>
                        <?php $yearNow= date("Y"); 
                        for($i=$yearNow; $i<=$yearNow+2; $i++):?>
                        <option value="<?=$i?>"><?=$i?></option>
                        <?php endfor;?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <select class="form-select" aria-label="Select Semester" id="semester" name="semester">
                        <option selected disabled>Select Semester</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        
                    </select>
                </div>

                
                
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-primary float-right">Add</button>
                </div>

            </form>  

        </div>
    </div>
</div>