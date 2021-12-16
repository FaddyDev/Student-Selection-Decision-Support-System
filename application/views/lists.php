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
<script type="text/javascript">
//Limiting input to integers only
function numbersonly(e){
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8 & unicode!=46 & unicode!=37 & unicode!=39 ){ //if the key isn't the backspace,delete,left and right arrow keys (which we should allow)
        if (unicode<48||unicode>57) //if not a number
		//alert('Numbers Only!');
         return false //disable key press
		   
    }
}
</script>
 
<div class="col-md-4">
<h2>Schools Placement List</h2>
<?php if(isset($p)){ if($p == 1){?>
<label>Download form one list for your school.</label> 
<?php } else {?>
<label>Awaiting Form One Placement.</label>
<?php } } ?>

<br /><br />
<?php if(isset($p)){ if($p == 1){?>
<label>Enter school code to download/view form one list.</label> 

	<form class="form-horizontal well" action="<?php echo base_url(); ?>index.php/moe/download" method="post" name="upload" enctype="multipart/form-data"><input type="text" class="form-control add-todo" placeholder="Enter School Code" name="code" onkeypress="return numbersonly(event)" required>
        <input type="submit" class="btn btn-primary" style="float: right;" value="Download/View" name="codebtn" /> 
</form> 
<?php } else {?>
<label>Form One Placement for this year has not been done yet.</label>
<?php } } ?>
</div>

<div class="col-md-8">
<h2>&nbsp;</h2>
<?php if(isset($p)){ if($p == 1){?>
<marquee behavior="alternate" bgcolor="#696969"> <b><font color="#FFFFFF" "size="+1"> Download List of Form Ones Joining Your School </font></b> </marquee>
<?php } else {?>
<marquee behavior="alternate" bgcolor="#696969"> <b><font color="#FFFFFF" "size="+1"> Form One Placement for this year has not been done yet. </font></b> </marquee>
<?php } } ?>

 </div>

 <hr>

</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
