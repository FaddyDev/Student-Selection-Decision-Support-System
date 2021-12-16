<!DOCTYPE html>
<html lang="en">
<head>
  <title>Student Allocation DSS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url()?>css/sticky-footer.css">
  <link rel="stylesheet" href="<?=base_url()?>css/custom.css">
  <link rel="stylesheet" href="<?=base_url()?>css/jquery.dataTables.css">
  <link rel="stylesheet" href="<?=base_url()?>css/jquery.dataTables.min.css">
 <link rel="stylesheet" href="<?=base_url()?>css/jquery.dataTables_themeroller.css">
  
  <script src="<?=base_url()?>js/jquery.min.js"></script>
  <script src="<?=base_url()?>js/datetime.js"></script>
  <script src="<?=base_url()?>js/bootstrap.min.js"></script>
  <script src="<?=base_url()?>js/moment-with-locales.js"></script>
  <script src="<?=base_url()?>js/bootstrap-datetimepicker.js"></script>
  <script src="<?=base_url()?>js/jquery.dataTables.js"></script>
  <script src="<?=base_url()?>js/jquery.dataTables.min.js"></script>
  <script src="<?=base_url()?>js/jquery.js"></script>
  <script type="text/javascript" src="<?=base_url()?>js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jssor.slider.mini.js"></script>
  <link href="<?=base_url()?>css/bootstrap-datetimepicker.css" rel="stylesheet">
  
       <!--print script -->
     <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the pages HTML with divs HTML only
            document.body.innerHTML = 
              "<html><head><title></title></head><body>" + 
              divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;

          
        }
    </script>
	
	<style type="text/css">
	#nv{
	vbackground-color:#999999;
	border:none;
	}
	#nv li a{
	ccolor:#000000;
	}
	#nv li a hover{
	color:#00FF00;
	}
	.navbar-brand hover{
	color:#666666;	}
	.lbll{
	padding-top:10px;
	text-decoration:blink;
	color:#990000;
	font-family:"Times New Roman", Times, serif;
	}
	</style>
  
  
</head>
<body onload=display_ct(); oncontextmenu="return false">


<!-- header -->
<header>

<div class="container" style="padding:0px;">
 <div class="page-header">
  <h1 align="center" class="logo-img"><img src="<?=base_url()?>img/logo1.jpg" /></h1> 
  <ul class="nav sign-nav">
    <li class="welcome-guest">
	<?php 
	if(!isset($this->session->userdata['loggedin'])){?>
    Welcome Guest
    <?php } else {
	   if($this->session->userdata['category']=='Student'){echo 'Welcome '.$this->session->userdata['name'];
	   }else{
     echo 'Welcome '.$this->session->userdata['category'].'\'s '.$this->session->userdata['username'];}
	}
   ?>
   </li>
    <li class="date-time"><span id='ct' ></span></li>
  </ul>


<nav class="navbar navbar-inverse" id="nv">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#">SSDSS</a>
	 <!--<label class="lbl">SSDSS</label>-->
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <?php if(!isset($this->session->userdata['loggedin'])){?>
		<li><a href="<?=site_url('home');?>">Home</a></li>
	    <li><a href="<?=site_url('moe/viewSchools');?>">Schools</a></li>               
    <?php } else { ?>
	                        <?php if($this->session->userdata['category']=='Student'){?> <li><a href="<?=site_url('student');?>">Home</a></li>
							<?php } else if($this->session->userdata['category']=='MoE'){?><li><a href="<?=site_url('moe');?>">Home</a></li> 
							<?php } else { ?> <li><a href="<?=site_url('knec');?>">Home</a></li> <?php } ?> 
	<li><a href="<?=site_url('moe/viewSchools');?>">Schools</a></li>
	  <?php if($this->session->userdata['category']!='Student'){?> 
	  <li><a href="<?=site_url('knec/viewStudents');?>">Students</a></li> 
	  <li><a href="<?=site_url('knec/viewPlacedStudents');?>">Placement</a></li>
	  <li><a href="<?=site_url('knec/viewResults');?>">Results</a></li> <?php } } ?> 
	  <li><a href="<?=site_url('moe/lists');?>">Lists</a></li>
	<li><a href="<?=site_url('contacts');?>">Contacts</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
	<?php if(isset($this->session->userdata['loggedin'])){?>
        <li style="float:right"><a href="<?=site_url('login/logout');?>">Logout</a></li>
    <?php } ?>  
      </ul>
    </div>
  </div>
</nav>

  </div>
  
   <?php if(isset($success)){
	        echo $success;}?>
 
 </div>
</header>
<!-- header --> 