<div class="container-md my-3">
    <h3>Search Result: <?php echo $key; ?></h3>
    <?php 
        foreach ($products as $row){
            $id = $row['id'];
            $name = $row['name'];
            $color = $row['color'];
            $brand = $row['brand'];
            $category1 = $row['category1'];
            $category2 = $row['category2'];
            $des = $row['description'];
            $img = $row['img_path'];
            $wish = $row['wish'];
            echo "<div class='container-md my-4 border border-dark'>";
                echo "<a href='".base_url()."product/".$id."' class='text-reset product'>";
                    echo "<div class='row'>";
                        echo "<div class='col'>";
                            echo "<h4>".$brand." ".$name." ".$color."</h4>";
                            echo "<p>Category: ".$category1;
                            if($category2 != NULL){
                                echo " , ".$category2."</p>";
                            }else{
                                echo "</p>";
                            }
                            echo "<p>Description: ".$des."</p>";
                            if($loggedin){
                                if($wish){
                                    echo "<p style='color:pink;'>In Wishlist</p>";
                                }else{
                                    echo "<p style='color:grey;'>Not in wishlist</p>";
                                }
                            }
                        echo "</div>";
                        echo "<div class='col'>";
                        if($img!=""){ 
                            echo '<img src="'.base_url().'/uploads/'.$img.'" alt="Product Image" class="mx-auto">';
                        }
                        echo "</div>";
                    echo "</div>";
                echo "</a>";
            echo "</div>";
        }
    ?>
</div>

<script>
$(document).ready(function() {
<?php
if(isset($scrollsearch)){
    echo '$(document).scrollTop('.$scrollsearch.' );';
}
?>

$('.product').on("click", function() {

    var position = $(document).scrollTop();
    document.cookie = "searchScroll="+position+";path=/";
    document.cookie = "searchKeyword=<?php if($key!=""){echo $key;}else{echo "emptysearch";}?>;path=/";

});

});
</script>
