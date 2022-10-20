<html>
    <head>
        <title>Discussion Plateform</title>
        <!-- use bootstrap style -->
        <link rel = "stylesheet" href="https://bootswatch.com/5/lux/bootstrap.min.css"> 
                <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
                <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>

    </head>
    <body>
    <nav class = "navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <div class="navbar-hearder">
                <a class="navbar-brand" href="<?php echo base_url(); ?>">
                    Discussion platform
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarColor01">
                <ul class="navbar-nav me-auto">
                    <!-- need tobe autoload  -->
                    <li class="nav-item"><a class="nav-link "  href=" <?php echo base_url(); ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link "  href="<?php echo base_url(); ?>about">Search</a></li>
                    
                    <li class="nav-item"><a class="nav-link "  href="<?php echo base_url(); ?>posts">Posts</a></li>
                    <li class="nav-item"><a class="nav-link "  href=" <?php echo base_url(); ?>posts/create">Create Posts</a></li>
                </ul>

                <ul class="navbar-nav me-auto">
                <?php if(!$this->session->userdata('logged_in')) : ?>
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo base_url(); ?>login"> Login </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link "  href=" <?php echo base_url(); ?>register">Register</a>
                    </li>
                    <?php endif; ?>
                    <?php if($this->session->userdata('logged_in')) : ?>
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo base_url(); ?>Pages/logout"> Logout </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo base_url(); ?>Pages/get_profile"> Profile </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo base_url(); ?>file"> Upload </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="<?php echo base_url("products"); ?>"> Cart </a>
                    </li>
                    <?php endif; ?>
                </ul>
                   
            </div>
        </div>
    </nav>
    
