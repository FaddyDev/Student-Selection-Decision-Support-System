<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php require_once('includes/header.php'); //include the template top ?>
<script type= 'text/javascript'>
            $(document).ready(function () {
                $('#cd-grid').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "<?php echo base_url(); ?>index.php/moe/cd_list",
                });
            });
        </script>

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
<h2>Schools</h2>
<label>These are the secondary schools currently registered in the country.</label> (<i>Just my sample from three conties-Nairobi, Nyeri, Trans-Nzoia</i>)

</div>

<div class="col-md-8">
<h2>&nbsp;</h2>
 <p align="right">	
<table id="cd-grid" class="table table-striped table-bordered table-hover table-condensed table-responsive display">
<tbody>
<tr><th>Sr</th><th>Code</th><th>Name</th><th>Phone</th><th>E-mail</th><th>County</th><th>Gender</th><th>Level</th><th>Capacity</th></tr>
<?php  foreach ($s->result() as $row){ ?>
<tr><td><?php echo $row->id;?></td><td><?php echo $row->code;?></td><td><?php echo $row->name;?></td><td><?php echo $row->phone;?></td><td><?php echo $row->email;?></td><td><?php echo $row->county;?></td><td><?php echo $row->gender;?></td><td><?php echo $row->level;?></td><td><?php echo $row->capacity;?></td></tr><?php } ?>
</tbody>
</table>
 </div>
                    
                   


 <hr>

</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
