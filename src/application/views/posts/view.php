<h2> <?php echo $post['title'] ;?> </h2>
<small class = 'post-date'> Posted on: <?php echo $post ['created_at']; ?></small> <br>
<div class = 'post-body'>
    <?php echo $post['body'] ;?>
    
</div>

<hr>
<?php echo form_open('/posts/delete/'.$post['id']); ?>
    <input type="submit" value ="Delete" class = "btn btn-danger">
</form>
<a class="btn btn-secondary" href="/milestone2/posts/edit/<?php echo $post['slug']; ?>">Edit</a>



<!-- <br />
  <h3 align="center"><a href="#">Add your comments below</a></h3>
  <br />
  <div class="container">
   <form method="POST" id="comment_form">
    <div class="form-group">
     <input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Enter Name" />
    </div>
    <div class="form-group">
     <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
    </div>
    <div class="form-group">
     <input type="hidden" name="comment_id" id="comment_id" value="0" />
     <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
    </div>
   </form>
   <span id="comment_message"></span>
   <br />
   <div id="display_comment"></div>
  </div> -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Building a 5 Star Rating System in CodeIgniter</title>

    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font awesome -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Bootstrap Star Rating CSS -->
    <link href='<?= base_url() ?>assets/bootstrap-star-rating/css/star-rating.min.css' type='text/css' rel='stylesheet'>

    <!-- Custom CSS -->
    <link href="<?= base_url() ?>assets/style.css" rel="stylesheet">

    <!-- jQuery Library -->
    <script src='<?= base_url() ?>assets/js/jquery-3.3.1.js' type='text/javascript'></script>

    <!-- Bootstrap Star Rating JS -->
    <script src='<?= base_url() ?>assets/bootstrap-star-rating/js/star-rating.min.js' type='text/javascript'></script>

  </head>
  <body>

    <div class='content'>

      <!-- Post List -->
      <?php 
      foreach($posts as $post){
        $id = $post['id'];
        $title = $post['title'];
        $content = $post['body'];
        // $link = $post['link'];
        $rating = $post['rating']; // User rating on a post
        $averagerating = $post['averagerating']; // Average rating

      ?>
      <div class="post">
        <h1><a href='<?= $link ?>' class='link' target='_blank'><?= $title; ?></a></h1>
        <div class="post-text">
          <?= $content; ?>
        </div>
        <div class="post-action">

          <!-- Rating Bar -->
          <input id="post_<?= $id ?>" value='<?= $rating ?>' class="rating-loading ratingbar" data-min="0" data-max="5" data-step="1">

          <!-- Average Rating -->
          <div >Average Rating: <span id='averagerating_<?= $id ?>'><?= $averagerating ?></span></div>
        </div>
      </div>
      <?php
      }
      ?>

    </div>

    <!-- Script -->
    <script type='text/javascript'>
    $(document).ready(function(){

      // Initialize
      $('.ratingbar').rating({
        showCaption:false,
        showClear: false,
        size: 'sm'
      });

      // Rating change
      $('.ratingbar').on('rating:change', function(event, value, caption) {
        var id = this.id;
        var splitid = id.split('_');
        var postid = splitid[1];

        $.ajax({
          url: '<?= base_url() ?>index.php/employee/updateRating',
          type: 'post',
          data: {postid: postid, rating: value},
          success: function(response){
             $('#averagerating_'+postid).text(response);
          }
        });
      });
    });
 
    </script>

  </body>
</html>