 <h2>Register Users</h2>
 <script>
 function confirm_pass(){
	 var pass = document.loginform.password.value;
	 var pass2 = document.loginform.password2.value;
	 
	 if(pass!=pass2){
		 alert('Passwords do not match');
		 return false;
		 }
	
	 return true;
	 }
  </script>
  
		<form class="form-horizontal well" action="<?php echo base_url(); ?>index.php/login/register" name="loginform" onsubmit="return confirm_pass();" method="post" name="upload" enctype="multipart/form-data">
               <select class="form-control" name="category" required>
		  <option value="">Select Category</option>
             <option value="MoE">MoE</option>
			 <option value="KNEC">KNEC</option>
			 </select><br>
            
      <input type="text" class="form-control add-todo" placeholder="Username" name="username" required><br>
       <input type="password" class="form-control add-todo" placeholder="Password" name="password" required><br>
	   <input type="password" class="form-control add-todo" placeholder="Confirm Password" name="password2" required><br>
            
        <input type="submit" class="btn btn-primary" style="float: right;" value="Register" name="registerbtn" /> 
		</form> 
		
        <div style="clear:both"></div>            
   