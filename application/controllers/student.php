<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {
function __construct()
{
parent::__construct();
$this->load->model('model_student');
$this->load->model('model_moe');
$this->load->model('model_knec');

$this->load->helper('form');
$this->load->helper('url');
$this->load->helper('html');
$this->load->database();
$this->load->library('form_validation');

}

    public function index()
        {$gender = '';
	$index = $this->session->userdata['username'];
	
	$gen = $this->model_student->selectGender($index);
	if($gen == 'M'){$gender = 'G';} else{$gender = 'B';}
	
	$this->load->model('model_moe');		
   $data['national'] = $this->model_moe->select_schools('National',$gender);
   $data['extra'] = $this->model_moe->select_schools('Extra-county',$gender);
   $data['county'] = $this->model_moe->select_schools('County',$gender);
   $data['district'] = $this->model_moe->select_schools('District',$gender);
   
   $this->load->model('model_knec');
   $data['result'] = $this->model_knec->selectSpecificResults($index);
   
   $data['choice'] = $this->model_student->selectChoices($index);
   
    $data['phone'] = $this->model_student->getphone($index);

   $this->load->view('student_view',$data);
   
   
 
			
        }
		
public function choices()
{
 $index = $this->input->post('index');
 $national = $this->input->post('national');
$extra = $this->input->post('extra');
$county = $this->input->post('county');
$district = $this->input->post('district');

$this->form_validation->set_rules('national','National School','required');
$this->form_validation->set_rules('extra','Extra County School','required');
$this->form_validation->set_rules('county','County','required');
$this->form_validation->set_rules('district','District','required');
//$this->form_validation->set_rules('index','Index','required');

if($this->form_validation->run() == FALSE)
{$this->load->view('student_view');}
else{
     if($this->input->post('submit') == "submit")
	 {
	 $year = date("Y") - 1; //previous year
	  $data = array(
              'index_no' => $index,
              'year' => $year,
              'national' => $national,
			  'extra' => $extra,
			  'county' => $county,
			  'district' => $district,
                                );
	 $this->load->model('model_student');
	 
	 //Check if choices already exist, if yes just update it
	if($this->model_student->confirmchoices($index) > 0){
	 $this->model_student->updatechoices($index,$data);}
	//if not, insert it
	else{
     $insertId = $this->model_student->insertchoices($data);}
	 //$data['success'] = '<script language="javascript">window.alert("Choices Submitted successfully");<//script>';
   //$this->load->view('student_view',$data);
   
    //SMS students here
	$phone =  $this->model_student->getphone($index);
	$result = $this->model_knec->selectSpecificResults($index);
	$name = $this->model_student->selectSpecificName($index);
	
	$nat = $this->model_moe->selectSchoolName($national);
	$ext = $this->model_moe->selectSchoolName($extra);
	$cou = $this->model_moe->selectSchoolName($county);
	$dis = $this->model_moe->selectSchoolName($district);
	
 // Be sure to include the file you've just downloaded
require_once(APPPATH.'/third_party/AfricasTalkingGateway.php');
  //$this->load->library('excel');	//similar to   require_once APPPATH.'/third_party/AfricasTalkingGateway.php';
// Specify your login credentials
$username   = "BEBZ";
$apikey     = "5848bc328d70e7757a36be5336c61dedf649ca0d5d7039d09229bba19dbf6443";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
$recipients = "+254".$phone;
// And of course we want our recipients to know what we really do
$message = '';
if($result>=430){
$message    = "SSDSS Notification: School selection choices for ".$name." (".$index."): National: ".$nat." (".$national."), Extra-County: ".$ext." (".$extra."), County: ".$cou." (".$county."), District: ".$dis." (".$district."). You can re-submit the selection at your convenience.";
}
else if($result>=370){
$message    = "SSDSS Notification: School selection choices for ".$name." (".$index."): Extra-County: ".$ext." (".$extra."), County: ".$cou." (".$county."), District: ".$dis." (".$district."). You can re-submit the selection at your convenience.";
}
else if($result>=280){
$message    = "SSDSS Notification: School selection choices for ".$name." (".$index."): County: ".$cou." (".$county."), District: ".$dis." (".$district."). You can re-submit the selection at your convenience.";
}
else {
$message    = "SSDSS Notification: School selection choices for ".$name." (".$index."): District: ".$dis." (".$district."). You can re-submit the selection at your convenience.";
}
$message    = $message;
// Create a new instance of our awesome gateway class
$gateway    = new AfricasTalkingGateway($username, $apikey);
// Any gateway error will be captured by our custom Exception class below, 
// so wrap the call in a try-catch block
try 
{ 
  // Thats it, hit send and we'll take care of the rest. 
  $results = $gateway->sendMessage($recipients, $message);
            
  /*foreach($results as $result) {
    // status is either "Success" or "error message"
    echo " Number: " .$result->number;
    echo " Status: " .$result->status;
    echo " MessageId: " .$result->messageId;
    echo " Cost: "   .$result->cost."\n";
  }*/
}
catch ( AfricasTalkingGatewayException $e )
{
  //echo "Encountered an error while sending: ".$e->getMessage();
}

   
   
   redirect('student/index');
   }
   else
   {
    //$data['success'] = '<script language="javascript">window.alert("Not submitted!");<//script>';
   //$this->load->view('student_view',$data);
   redirect('student');
      }
 }
}



public function savephone()
{
 $index = $this->input->post('index');
 $phone = $this->input->post('phone');

$this->form_validation->set_rules('phone','Phonel','required');
$this->form_validation->set_rules('index','Index','required');

if($this->form_validation->run() == FALSE)
{$this->load->view('student_view');}
else{
     if($this->input->post('phonetbtn') == "Save")
	 {
	 $year = date("Y") - 1; //previous year
	  $data = array(
              'index_no' => $index,
              'phone' => $phone,
                             );
	 $this->model_student->addphone($index,$data);
   redirect('student/index');
   }
   else
   {
    //$data['success'] = '<script language="javascript">window.alert("Not submitted!");<//script>';
   //$this->load->view('student_view',$data);
   redirect('student');
      }
 }
}




		
	 
	/* Loops through every cell, may be useful later
	 public function import2()
        {
		 $file = $_FILES['upload']['tmp_name'];
    //load the excel library
    $this->load->library('excel');
    //read file from path
    $objPHPExcel = PHPExcel_IOFactory::load($file);
    //get only the Cell Collection
    $cell_collection = $objPHPExcel->getActiveSheet()->getCellCollection();
    //extract to a PHP readable array format
    foreach ($cell_collection as $cell) {
     $column = $objPHPExcel->getActiveSheet()->getCell($cell)->getColumn();
     $row = $objPHPExcel->getActiveSheet()->getCell($cell)->getRow();
     $data_value = $objPHPExcel->getActiveSheet()->getCell($cell)->getValue();
     //header will/should be in row 1 only. 
     if ($row == 1) {
     $header[$row][$column] = $data_value;
     } else {
     $arr_data[$row][$column] = $data_value;
	
	 $data = array(
              'name' => $arr_data[$row][$column],
              'region' => $arr_data[$row][$column],
              'capacity' => $arr_data[$row][$column],
                                );
	 $this->load->model('model_schools');
     $insertId = $this->model_schools->insertexcel($data);
	 }
	 }
	 }*/
}
?>