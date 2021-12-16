<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

function __construct()

{

parent::__construct();
$this->load->view('index');
$this->load->library('session');
$this->load->helper('form');
$this->load->helper('url');
$this->load->helper('html');
$this->load->database();
$this->load->library('form_validation');

$this->load->model('model_login');

}
public function getLoginValues()

{
$category = $this->input->post('category');
$username = $this->input->post('username');
$password = $this->input->post('password');

$this->form_validation->set_rules('category','Category','required');
$this->form_validation->set_rules('username','Username','required');
$this->form_validation->set_rules('password','Password','required');

if($this->form_validation->run() == FALSE)
{$data['success'] = '<script language="javascript">window.alert("Login failed! Kindly confirm your credentials then try again");</script>';
		  $this->load->view('index',$data);}
else{
    $result='';
     if($this->input->post('loginbtn') == "Login")
	 { 
	   if($category=='Student')
	   {
	    $result = $this->model_login->login_checkpoint_student($username ,$password );
	   }else{
	  $result = $this->model_login->login_checkpoint($category ,$username ,$password);}
	     if($result > 0)
		 {
		   $sessiondata = array(
           'category'=>$category,
		   'username'=>$username,
		   //'is_logged_in'=>1
		   'loggedin'=>TRUE);
           $this->session->set_userdata($sessiondata);
		         if($category=='Student'){
				    $name = $this->model_login->name($username);
					$sessiondata['name'] = $name;
					$this->session->set_userdata($sessiondata);
	  	  	  	  redirect('student');
	  	  	  	  }
	 	  	  	  else if($category=='MoE'){
	 	  	  	  redirect('moe');}
	 	  	  	  else{
	 	  	  	  redirect('knec');
	 	  	  	  }
	 
		 }
		 else
		 {
		 $data['success'] = '<script language="javascript">window.alert("Login failed! Kindly confirm your credentials then try again");</script>';
		  $this->load->view('index',$data);
		 }
   }
   else
   {
     $data['success'] = '<script language="javascript">window.alert("Login failed! Kindly confirm your credentials then try again");</script>';
		  $this->load->view('index',$data);
		 
   }
 }
}

public function register()
{
$category = $this->input->post('category');
$username = $this->input->post('username');
$password = $this->input->post('password');

$this->form_validation->set_rules('category','Category','required');
$this->form_validation->set_rules('username','Username','required');
$this->form_validation->set_rules('password','Password','required');

if($this->form_validation->run() == FALSE)
{$this->load->view('register_form');}
else{
     if($this->input->post('registerbtn') == "Register")
	 {
	  $data = array(
              'category' => $category,
              'username' => $username,
              'password' => $password,
                                );
	 $this->load->model('model_login');
     $insertId = $this->model_login->insertusers($data);
	 redirect('moe');
   }
   else
   {
     $this->load->view('register_form');
   }
 }
}

public function logout()
{
$this->session->sess_destroy();
redirect('home');
}

}

/* End of file welcome.php */

/* Location: ./application/controllers/login.php */
