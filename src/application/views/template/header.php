<html>
    <head>
            <title>Hair Dye Product Review</title>
            <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
            <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    </head>
<body>


<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FF93DD">
  <a class="navbar-brand ml-sm-3 ml-md-4 ml-lg-5 ml-xl-5 mr-auto" href="<?php echo base_url(); ?>">Hair Dye Product Review</a>

    <ul class="navbar-nav mx-sm-3 mx-md-4 mx-lg-5 mx-xl-5 my-3">
        <?php if(!$this->session->userdata('logged_in')) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>login"> Login </a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url(); ?>signUp"> Sign Up </a>
            </li>
        <?php endif; ?>
        <?php if($this->session->userdata('logged_in')) : ?>
            <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url(); ?>login/logout"> Logout </a>
           </li>
           <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url(); ?>profile"> My Profile </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo base_url(); ?>wish"> Wishlist </a>
            </li>
        <?php endif; ?>
    </ul>

</nav>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FF93DD">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse vw-100 d-flex align-items-center" id="mainNav">
        <ul class="navbar-nav mx-sm-3 mx-md-4 mx-lg-5 mx-xl-5">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>"> Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>search/searchCat/2"> For Dark Hair </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>search/searchCat/3"> For Grey Hair </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>search/searchCat/7"> For Lightened Hair </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>search/searchCat/1"> Bubble </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>search/searchCat/5"> Cream </a>
            </li>
            
        </ul>
        <form class="form-inline ml-auto mb-0 align-self-center" method="get" autocomplete="off" action="<?php echo base_url(); ?>search/">
            <div id="searauto"  style="position:relative;">
                <input id="headersearch" name="headersearch" class="form-control mr-sm-2" type="text" placeholder="Search">
                <div id="dropdown" style="position:absolute;z-index:99;top:100%;left:0;right:0;" class="border">
                </div>
            </div>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <a class="btn btn-primary align-self-center ml-3" href="<?php echo base_url(); ?>product/addProduct/">Write a Review</a>
        
    </div>

</nav>

<script>
    $(document).ready(function(){

        $("#headersearch").keyup(function(){
            var headersearch = $(this).val();
            $.ajax({
                url:"<?php echo base_url();?>ajax/searchbox",
                method:"GET",
                data:{headersearch:headersearch},
                success:function(result){
                    if(result==""){
                        $("#dropdown").html("");
                    }else{
                        $("#dropdown").html("");
                        var obj = JSON.parse(result);
                        if(obj.length>0){
                            obj.forEach(function(value){
                                $("#dropdown").append("<div style='left:0;right:0;background-color: #fcf0f8' class='border'><a href='<?php echo base_url();?>search/?headersearch="+value+"' class='text-reset'>"+value+"</a></div>");
                            });
                        }
                    }
                }
            });
        })

        document.addEventListener("click", function (e) {
            $("#dropdown").html("");
        });

        


    });
</script>
