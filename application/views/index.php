<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php require_once('includes/header.php'); //include the template top ?>


<div class="container">
   <?php if(isset($success)){
	        echo $success;}?>
  <div class="col-md-12">
  <h1 style="text-align:center">About Student Selection Decision Support System</h1>
<p>Student Selection Decision Support System enables fast, efficient and fair placement of form ones to respective high schools in the country.</p>
<!--  <a class="btn btn-primary" href="contact.php">CONTACT US</a> -->
   <hr/>
  </div>

 
<div class="col-md-4">
<?php require_once('includes/login_form.php'); ?>
</div>

<div class="col-md-8">
<h2>&nbsp;</h2>
<p>
<?php require_once('includes/slider.php'); ?>
</p>
 </div>
                    
                   


 <hr>

</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
