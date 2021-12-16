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
<h2>Students</h2>
<label>These are the 2015 KCPE candidates.</label> (<i>Just my sample of 50 students from three conties-Nairobi, Nyeri, Trans-Nzoia.</i>)
</div>

<div class="col-md-8">
<h2>&nbsp;</h2>
 <p align="right">	
<table class="table table-striped table-bordered table-hover table-condensed table-responsive">
<tbody>
<tr><th>Sr</th><th>Index</th><th>Name</th><th>Birth Cert</th><th>Sch Type</th><th>County</th><th>Gender</th><th>E-mail</th></tr>
<?php foreach ($st->result() as $row){ ?>
<tr><td><?php echo $row->id;?></td><td><?php echo $row->index_no;?></td><td><?php echo $row->name;?></td><td><?php echo $row->birthcert;?></td><td><?php echo $row->schtype;?></td><td><?php echo $row->county;?></td><td><?php echo $row->gender;?></td><td><?php echo $row->e_mail;?></td></tr><?php } ?>
</tbody>
</table>
</p>
 </div>
                    
 <hr>

</div>
 
  
<?php require_once('includes/footer.php'); //include footer template ?>
