<div class="row mt-3">

    <div class="col-md-12 card " >
        <div class="card-body" >
            <h3 id="CardTitleItem">Add Item</h3> 

            <form method="post" id="formItem">
                
                <div class="form-group">
                    <label for="name">Item Name</label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>

                <div class="form-group">                    
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" class="form-control">
                </div>
                <div class="form-group">
                    <label for="semester">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control">
                </div>

                
                
                <div class="form-group mt-5" id="BtnItem">
                <button type="submit" class="btn btn-primary float-right">Add</button>
                </div>

            </form>  

        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    $('#formItem').attr('action', '<?= base_url('item/add/').$detail[0]['id'] ?>');
  });
</script>