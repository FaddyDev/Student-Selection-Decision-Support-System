<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php require_once('includes/header.php'); //include the template top ?>


<div class="container">

  <div class="col-md-12">
  <h1 style="text-align:center">About Student Selection Decision Support System</h1>
<p>Student Selection Decision Support System enables fast, efficient and fair placement of form ones to respective high schools in the country.</p>
   <hr/>
  </div>

 
<div class="col-md-4">
<?php require_once('includes/register_form.php'); ?>
</div>

<div class="col-md-8">
<h2>&nbsp;</h2>
<p align="right">	
<form class="form-horizontal well" action="<?php echo base_url(); ?>index.php/moe/importSchools" method="post" name="upload" enctype="multipart/form-data">
<input type="file" id="upload" accept="application/msexcel,.xlsx" name="upload" class="input-large" required>
<button type="submit" id="submit" name="Import" class="btn btn-primary button-loading">Upload Schools</button>
</form>

<form class="form-horizontal well" action="<?php echo base_url(); ?>index.php/moe/place" method="post" name="upload" enctype="multipart/form-data">
<label>Click the button besides to initiate automated placement</label>           
        <input type="submit" class="btn btn-primary" style="float: right;" value="Place Students" name="placementbtn" /> 
</form>

     </p>
	 
 </div>
                    
                   


 <hr>

</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
