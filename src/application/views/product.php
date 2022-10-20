<div class="container-md my-3">
<h2>Product - <?php echo $brand.' '.$name.' '.$color; ?></h2>
<a class="btn btn-primary" href="http://www.facebook.com/sharer.php?u=<?php echo base_url();?>product/<?php echo $id;?>/" target="_blank">Share to Facebook</a>
<?php
    if($loggedin){
        if($wish){
            echo '<a class="btn btn-outline-secondary" href="'.base_url().'wish/delete/'.$id.'">Remove from Wishlist</a>';
        }else{
            echo '<a class="btn btn-outline-secondary" style="color:#FF93DD;" href="'.base_url().'wish/add/'.$id.'">Add to Wishlist</a>';
        }
    }
?>
<br>
</div>
<div class="container-md my-3">
    <div class="row">
        <div class="col">
            <h3>Product Details</h3>
            <p>Brand: <?php echo $brand; ?></p>
            <p>Product Name: <?php echo $name; ?></p>
            <p>Color: <?php echo $color; ?></p>
            <p>Category: <?php echo $category1; if(isset($category2)){echo ' , '.$category2;} ?></p>
            <p>Description: <?php echo $des; ?></p>
        </div>
        <div class="col">
        <?php if($img_path!=""){ echo '<img src="'.base_url().'/uploads/'.$img_path.'" alt="Product Image" class="mx-auto">';}?>
        </div>
        <div class="col">
            <h5>Ratings:  <a href="<?php echo base_url().'rating/'.$product_id.'/';?>" style="font-size:0.5em;" class="btn btn-outline-primary">Add/View My Rating</a><h5>
            <table class="table">
                <tr>
                    <th>Overall Ratings</th>
                    <th><?php if(isset($overall)){echo $overall;}else{echo "-";}?></th>
                </tr>
                <tr>
                    <td>Easy to Use</td>
                    <td><?php if(isset($easy)){ echo $easy;}else{echo "-";}?></td>
                </tr>
                <tr>
                    <td>Smells</td>
                    <td><?php if(isset($smell)){ echo $smell;}else{echo "-";}?></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h3>Reviews</h3>
            <a href="<?php echo base_url().'review/displayReviewForm/'.$product_id.'/';?>">Write a review</a>
            <?php 
                if(isset($review)){
                    foreach ($review as $row){
                        $id = $row['id'];
                        $uname = $row['uname'];
                        $time = $row['time'];
                        $content = $row['content'];
                        $img = $row['img'];
                        echo "<div class='container-md my-4 border border-dark'>";
                            echo "<div class='row'>";
                                echo "<div class='col'>";
                                    echo "<p>Posted by ".$uname."</p>";
                                    echo "<p>at ".$time."(UTF+0)</p>";
                                echo "</div>";
                                echo "<div class='col'>";
                                    echo "<p>".$content."</p>";
                                    if(isset($img)){
                                        foreach($img as $i){
                                            echo "<img class='m-3' src='".base_url()."/reviewImage/".$i."' alt='Product Image'>";
                                        }  
                                    }
                                echo "</div>";
                            echo "</div>";
                        echo "</div>";
                    }
                }
            ?>
            <div id="loadData"></div>
        </div>
    </div>
</div>

<script>
   $(document).ready(function(){
       var limit = 5;
       var start = 3;
       var id = <?php echo $product_id;?>;
       var end = false;
 
       window.onscroll = function(e){
           if(((window.innerHeight + window.scrollY + 10) >= document.body.offsetHeight)&&(end==false)){
               //ajax
               $.ajax({
                   url: "<?php echo base_url();?>ajax/loadreview",
                   method:"GET",
                   data:{id:id, start:start},
                   cache: false,
                   success:function(response){
                    if(response == "false"){
                        $("#loadData").append("<p>You have reached the end of the page!</p>");
                        end = true;
                    }else{
                        $("#loadData").append(response);
                    }
                   }
               })
               start = limit + start;
           }
       }
   });
</script>
