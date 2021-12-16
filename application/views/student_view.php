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
<h2>Student Profile</h2>
<label><u>My Result:</u></label>
<label><?php echo $result.' Marks'; ?></label></br>
<label><u>Index No:</u></label>
<label><?php echo $this->session->userdata['username']; ?></label></br>
<label>Select Secondary school</label>
<p align="right">	
<form class="form-horizontal well" action="<?php echo base_url(); ?>index.php/student/choices" method="post" name="upload" enctype="multipart/form-data">
<table class="table table-striped table-bordered table-hover table-condensed table-responsive">
<tbody>
<tr><td>
<?php if($result>=430){?>
<select class="form-control" name="national" required>
<option value="0"> Select National School </option>
<?php foreach ($national as $row){ ?>
<option value="<?php echo $row->code;?>"><?php echo $row->code.'-'.$row->name;?></option>
<?php }} ?></select> <?php if($result<430){ ?> <input type="hidden" name="national" value="0" /><?php } ?></td></tr>

<tr><td>
<?php if($result>=370){ ?>
<select class="form-control" name="extra" required>
<option value="0"> Select Extra-County School </option>
<?php foreach ($extra as $row){ ?>
<option value="<?php echo $row->code;?>"><?php echo $row->code.'-'.$row->name;?></option>
<?php }} ?></select> <?php if($result<370){ ?> <input type="hidden" name="extra" value="0" /><?php } ?></td></tr>

<tr><td>
<?php if($result>=280){ ?> 
<select class="form-control" name="county" required>
<option value="0"> Select County School </option>
<?php foreach ($county as $row){ ?>
<option value="<?php echo $row->code;?>"><?php echo $row->code.'-'.$row->name;?></option>
<?php }} ?> </select> <?php if($result<280){ ?> <input type="hidden" name="county" value="0" /><?php } ?></td></tr>

<tr><td><select class="form-control" name="district" required>
<option value=""> Select District School </option>
<?php foreach ($district as $row){ ?>
<option value="<?php echo $row->code;?>"><?php echo $row->code.'-'.$row->name;?></option>
<?php } ?></select></td></tr>
<tr><td><input type="hidden" class="form-control"  name="index" value="<?php echo $this->session->userdata['username']; ?>"/></td></tr>
</tbody>
</table>
<button type="submit" id="submit" name="submit" value="submit" class="btn btn-primary button-loading">Submit Choices</button>
</form>
</p>
</div>
<div class="col-md-8">
<h2>My Choices</h2>
 <p align="right">	
<table class="table table-striped table-bordered table-hover table-condensed table-responsive">
<tbody>
<tr><th>National</th><th>Extra-county</th><th>County</th><th>District</th></tr>
<?php foreach ($choice->result() as $row){ ?>
<tr><td><?php echo $row->national;?></td><td><?php echo $row->extra;?></td><td><?php echo $row->county;?></td><td><?php echo $row->district;?></td>
</tr><?php } ?>
</tbody>
</table>
</p>
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
	<form class="form-horizontal well" action="<?php echo base_url(); ?>index.php/student/savephone" method="post" name="upload" enctype="multipart/form-data">
Current Working Mobile Phone Number <i>(Start with 07...)</i><input type="text" class="form-control add-todo" 
	<?php if(isset($phone)){if($phone != 0){ ?>
value="<?php echo $phone;?>" <?php } else { ?> placeholder="Mobile Phone Number" <?php }} ?>
name="phone" onkeypress="return numbersonly(event)" required>
<input type="hidden" class="form-control"  name="index" value="<?php echo $this->session->userdata['username']; ?>"/>        
        <input type="submit" class="btn btn-primary" style="float: right;" value="Save" name="phonetbtn" /> 
</form> 
 </div>
 <hr>

</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
