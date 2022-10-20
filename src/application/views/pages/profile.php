
<div class="student-profile py-4">
  <div class="container">
    <div class="row"> 
      <div class="col-lg-8">
        <div class="card shadow-sm">
          <div class="card-header bg-transparent border-0">
            <h3 class="mb-0"><i class="far fa-clone pr-1"></i>User Information</h3>
          </div>
          <div class="row">
            <div class="col-lg-4">
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
            </div>
          </div>
          <div class="panel-body">
                <?= form_open()?>
                    <div class = "row">
                        <div class="col-lg-4 ">
                            <div class = "form-group">
                                <label> User Full Name</label>
                                <input type="text" name="user_name" value="<?= $this->session->userdata("Name") ?>" class= 'form-control'>
                                <?= form_error("user_name")?>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class = "form-group">
                                <label> Email Address</label>
                                <input type="text" name="user_email" value="<?= $this->session->userdata("Email") ?>" class= 'form-control'>
                                <?= form_error("user_email")?>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class = "form-group">
                                <label> Password</label>
                                <input type="text" name="user_password" value="<?= $this->session->userdata("Password") ?>" class= 'form-control'>
                                <?= form_error("user_password")?>
                            </div>
                        </div>
                    </div>
                    
                    
                    <a href="<?php echo base_url('/htmltopdf/pdfdetails/'.$this->session->userdata("User_id"));?>">View in PDF</a>
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<h2>Click button find your current location</h2>   
<button onclick="getlocation();"> Show Position</button>   
<div id="demo" style="width: 600px; height: 400px; margin-left: 200px;"></div>   
 
<script src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyDdn3s_zaq3xFl3gtg0V436sd1fkMfLZP4" async="" defer="defer" type="text/javascript";> </script>   
  
<script type="text/javascript">   
function getlocation(){   
    if(navigator.geolocation){   
        navigator.geolocation.getCurrentPosition(showPos, showErr);   
    }  
    else{  
        alert("Sorry! Your browser does not support Geolocation API")  
    }  
}   
//Showing Current Poistion on Google Map  
function showPos(position){   
    latt = position.coords.latitude;   
    long = position.coords.longitude;   
    var lattlong = new google.maps.LatLng(latt, long);   
    var myOptions = {   
        center: lattlong,   
        zoom: 15,   
        mapTypeControl: true,   
        navigationControlOptions: {style:google.maps.NavigationControlStyle.SMALL}   
    }   
    var maps = new google.maps.Map(document.getElementById("demo"), myOptions);   
    var markers =   
    new google.maps.Marker({position:lattlong, map:maps, title:"You are here!"});   
}   

//Handling Error and Rejection  
     function showErr(error) {  
      switch(error.code){  
      case error.PERMISSION_DENIED:  
     alert("User denied the request for Geolocation API.");  
      break;  
      case error.POSITION_UNAVAILABLE:  
      alert("USer location information is unavailable.");  
      break;  
      case error.TIMEOUT:  
      alert("The request to get user location timed out.");  
      break;  
    case error.UNKNOWN_ERROR:  
      alert("An unknown error occurred.");  
      break;  
   }  
}      
  </script> 