<div class="container-md my-3">
<h2>Wishlist</h2>
<br>
</div>
<div class="container-md my-3">
    <?php
        if(isset($wish)){
            foreach($wish as $w){
                echo "<div class='row border border-dark d-flex'>";
                    echo "<div>";
                        if($w['img_path']!=""){echo "<img src='".base_url()."uploads/".$w['img_path']."' alt='Product Image' width='150'>";}else{echo "<p style='width:130px; margin:15px 10px;'>Don't have an image!<p>";}
                    echo "</div>";
                    echo "<div class='d-flex'>";
                        echo "<h4 class='my-auto'><a class='text-reset' href='".base_url()."product/".$w['pID']."/'>".$w['brand']." ".$w['name']." ".$w['color']."</a></h4>";
                    echo "</div>";
                    echo "<div class='ml-auto mr-3 d-flex'>";
                        echo "<a class='btn btn-outline-secondary my-auto wishS' href='".base_url()."wish/delete/".$w['pID']."/TRUE/'>Remove from wishlist</a>";
                    echo "</div>";
                echo "</div>";
            }
        }else{
            echo "Your wishlist is empty!";
        }
        
    ?>
</div>

<script>
$(document).ready(function() {
<?php
if(isset($scroll)){
    echo '$(document).scrollTop('.$scroll.' );';
}
?>

$('.wishS').on("click", function() {

    var position = $(document).scrollTop();
    document.cookie = "wishScroll="+position+";path=/";

});

});
</script>