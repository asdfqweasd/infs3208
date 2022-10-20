<?php echo form_open_multipart('upload/do_upload');?>
<div class="row justify-content-center">
    <div class="col-md-4 col-md-offset-6 centered">
    <div class="row">
        
            <!-- Display status message -->

        <?php if($error = $this->session->flashdata('success_msg')): ?>
                    <div class="alter alter-success" role="alert">
                        <?= $error ?>
                    </div>
        <?php endif; ?>
        <?php if($error = $this->session->flashdata('error_msg')): ?>
            <div class="alter alter-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <!-- File upload form -->
        <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label>Choose Files</label>
            <input type="file" class="form-control" name="files[]" multiple/>
        </div>
        <div class="form-group">
            <input class="form-control" type="submit" name="fileSubmit" value="upload"/>
        </div>
        </form>
        <br>
        <br>
        <br>
    </div>
</div>

<?php echo form_close(); ?>

<h3>Drag & Drop files</h3>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <div class = "container">
        <!-- Files upload form -->
        <div class = "upload-div">
            <form action="<?php echo base_url();?>Upload/dragDropUpload" class="dropzone"></form>
        </div>
        
        <!-- Display uploaded files -->
        <!-- <div class="gallery">
                <h3>Uploaded Files:</h3>
                <?php 
                if(!empty($files))
                { foreach($files as $row)
                    { 
                        $filePath = 'uploads/'.$row["filename"]; 
                        $fileMime = mime_content_type($filePath); 
                ?> 
                <embed src="<?php echo base_url('uploads/'.$row["filename"]); ?>" type="<?php echo $fileMime; ?>" width="350px" height="240px" /> 
                <?php 
                    } 
                }else
                { 
                
                    echo '<p>No file(s) found...</p>'; 
                
                } 
                ?>
        </div> -->
    </div>
<div class="main"> </div>
