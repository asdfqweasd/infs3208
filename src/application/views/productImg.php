<div class="container-md my-3">
<h2>Add an image for the product you added - <?php echo $product['brand'].' '.$product['name'].' '.$product['color']; ?></h2>
<br>
</div>
<div class="container-md my-3">
    <?php if(isset($error)){echo $error;}?>
    <?php echo form_open_multipart("product/addpimg",array('class'=>'border'));?>
        <input type="hidden" class="form-control" id="product" name="product" value="<?php echo $id?>">
        <h4>Drag and drop image to here or click "Choose file"</h4>
        <div class="form-group">
            <label for="img">Image:</label>
            <input type="file" class="form-control" size="20" name="userfilep" />
        </div>
        <br>
        <input type="submit" value="Upload" class="btn btn-primary"/></button>
    <?php echo form_close();?>
    <a href="<?php echo base_url().'review/displayReviewForm/'.$id.'/';?>" class="btn btn-secondary">Skip</a>
</div>

<script>
    $(document).on("dragover drop", function(e) {
        e.preventDefault();
    }).on("drop", function(e) {
        $("input[type='file']")
            .prop("files", e.originalEvent.dataTransfer.files)
            .closest("form")
    });
</script>