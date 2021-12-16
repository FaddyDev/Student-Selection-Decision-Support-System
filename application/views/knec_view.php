<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php require_once('includes/header.php'); //include the template top ?>


<div class="container">
  <div class="col-md-12">
  <h1 style="text-align:center">About Student Selection Decision Support System</h1>
<p>Student Selection Decision Support System enables fast, efficient and fair placement of form ones to respective high schools in the country.</p>
<!--  <a class="btn btn-primary" href="contact.php">CONTACT US</a> -->
   <hr/>
  </div>

 
<div class="col-md-4">
<h2>KNEC Home</h2>
</div>

<div class="col-md-8">
<h2>&nbsp;</h2>
 <p align="right">	
<form class="form-horizontal well" action="<?php echo base_url(); ?>index.php/knec/importStudents" method="post" name="upload" enctype="multipart/form-data">
<input type="file" id="upload" accept="application/msexcel,.xlsx" name="uploadstudents" class="input-large" required>
<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading">Upload Candidates</button>
</form>

     </p>
	 
	 <p align="right">	
<form class="form-horizontal well" action="<?php echo base_url(); ?>index.php/knec/importResults" method="post" name="upload" enctype="multipart/form-data">
<input type="file" id="upload" accept="application/msexcel,.xlsx" name="uploadresults" class="input-large" required>
<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading">Upload Results</button>
</form>

     </p>
 </div>
                    
                   


 <hr>

</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
