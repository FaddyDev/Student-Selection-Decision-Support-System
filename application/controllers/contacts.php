<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends CI_Controller {

function __construct()

{

parent::__construct();

//$this->load->helper('url');

}

public function index()

{

$this->load->view('contact');

}

}

/* End of file home.php */

/* Location: ./application/controllers/home.php */
?>