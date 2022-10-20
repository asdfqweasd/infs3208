<div class="container-md my-3">
<h2>Home</h2>
<br>
</div>
<div class="container-md my-3">
    <h3>Top Reviewed: </h3>
    <div class="card-group my-3">
        <?php
            foreach($products as $row){
                echo '<a class="card text-reset" href="'.base_url().'product/'.$row['id'].'/">';
                    if($row['img_path']!=""){
                        echo '<img src="'.base_url().'/uploads/'.$row['img_path'].'" class="card-img-top" alt="">';
                    }else{
                        echo '<div class="my-auto"></div>';
                    }
                    echo '<div class="card-body">';
                        echo '<h5 class="card-title">'.$row['brand'].' '.$row['name'].' '.$row['color'].'</h5>';
                        if(isset($row['category2'])){
                            echo '<p class="card-text">Categories: '.$row['category1'].', '.$row['category2'].'</p>';
                        }else{
                            echo '<p class="card-text">Categories: '.$row['category1'].'</p>';
                        }
                        echo '<p class="card-text text-muted">Number of reviews: '.$row['num'].'</p>';
                        if($loggedin){
                            if($row['wish']){
                                echo "<p style='color:pink;'>In Wishlist</p>";
                            }else{
                                echo "<p style='color:grey;'>Not in wishlist</p>";
                            }
                        }
                    echo '</div>';
                echo '</a>';
            }
        ?>
    </div>
</div>
<br>
<br>