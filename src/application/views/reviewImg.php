<div class="container-md my-3">
<h2>Write Review - Upload Image - <?php echo $brand.' '.$name.' '.$color; ?></h2>
<br>
</div>
<div class="container-md my-3">
    <?php if(isset($err)){echo json_encode($err);}?>
    <?php echo form_open_multipart("review/reviewPhotos");?>
        <input type="hidden" class="form-control" id="reviewID" name="reviewID" value="<?php echo $reviewID?>">
        <input type="hidden" class="form-control" id="product" name="product" value="<?php echo $id?>">
        <p>If you want to upload multiple files, please select them in one selection. Use the SHIFT key to help.</p>
        <div class="form-group">
            <label for="img">Image:</label>
            <input type="file" class="form-control" name="userfiles[]" multiple />
        </div>
        <br>
        <input type="submit" value="Upload" name="upload" class="btn btn-primary"/></button>
    <?php echo form_close();?>
    <a href="<?php echo base_url().'product/'.$id.'/';?>" class="btn btn-secondary">Skip</a>
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