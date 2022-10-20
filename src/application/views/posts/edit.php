<h2> <?= $title; ?> </h2>

<?php echo validation_errors(); ?>



<!-- post method to submit -->
<?php echo form_open('posts/update'); ?>
    <input type ="hidden" name = "id" value="<?php echo $post['id']; ?>">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" class="form-control"  name = 'title' 
            placeholder ="Add Title" value = "<?php echo $post['title'];?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Body</label>
            <textarea class="form-control" name= 'body' 
            placeholder = "Add Body" > <?php echo $post['body'];?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>