 <h2>Login Here</h2>
 <script>
 function validate_login_form(){
	 var cat = document.loginform.cat.value;
	 var name = document.loginform.name.value;
	 var pass = document.loginform.pass.value;
	 
	 if(cat==""){
		 alert('Please Select Category');
		 return false;
		 }
	if(name==""){
		 alert('Please Enter Your Username');
		 return false;
		 }
		 
	 if(pass == ""){
			 alert('Please Enter Your Password');
			 return false;
			 }
	 
	 return true;
	 }
  </script>
        <!--<form name="loginform" onsubmit="return validate_login_form();"> -->
		<?php echo form_open('login/getLoginValues');?>
		<!--<form name="loginform" onsubmit="return validate_login_form();"> -->
               <select class="form-control" name="category" required>
		  <option value="">Select Category</option>
             <option value="MoE">MoE</option>
			 <option value="KNEC">KNEC</option>
			 <option value="Student">Student</option>
			 </select><br>
            
      <input type="text" class="form-control add-todo" placeholder="Username" name="username" required><br>
	  <span class="text-danger"><?php echo form_error('username');?></span>
       <input type="password" class="form-control add-todo" placeholder="Password" name="password" required><br>
            
        <input type="submit" class="btn btn-primary" style="float: right;" value="Login" name="loginbtn" /> 
		
		<?php echo form_close();?>
        <!--</form> -->
		
        <div style="clear:both"></div>            
     <hr>   
     <h3><b>Log in tips for students</b></h3> 
     <ul class="steps">
      <li><i class="glyphicon glyphicon-thumbs-up"></i> Use your index # as username </li> 
       <li><i class="glyphicon glyphicon-tag"></i> Use your birth cert # as Password </li>  
     </ul>    