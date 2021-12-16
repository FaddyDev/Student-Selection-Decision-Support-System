<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Moe extends CI_Controller {
function __construct()
{
parent::__construct();
$this->load->model('model_moe');
$this->load->model('model_knec');
$this->load->library('form_validation');
  
}

    public function index()
        {
            $this->load->view('moe_view');
        }
		
public function importSchools()
{
	//load the excel library
    $this->load->library('excel');	//similar to   require_once APPPATH.'/third_party/phpexcel/Classes/PHPExcel.php';
		// Create new PHPExcel object
$inputFileName = $_FILES['upload']['tmp_name'];
if(!$inputFileName){
  $data['success'] = '<script language="javascript">window.alert("Please select a file to upload");</script>';
   $this->load->view('moe_view',$data);
}
else{
$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($inputFileName);
 
$dataArr = array();
 
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
    $worksheetTitle     = $worksheet->getTitle();
    $highestRow         = $worksheet->getHighestRow(); // e.g. 10
    $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
     
    for ($row = 2; $row <= $highestRow; ++ $row) {
        for ($col = 0; $col < $highestColumnIndex; ++ $col) {
            $cell = $worksheet->getCellByColumnAndRow($col, $row);
            $val = $cell->getValue();
            $dataArr[$row][$col] = $val;
		
        }
    }
	foreach($dataArr as $val){
			$data = array(
              'code' => $val['0'],
              'name' => $val['1'],
              'gender' => $val['2'],
			  'county' => $val['3'],
              'level' => $val['4'],
              'capacity' => $val['5'],
			  'email' => $val['6'],
			  'phone' => $val['7'],
                                );
	 		//Insert schools which do not exist/ whose code does not exist
 if($this->model_moe->confirmSchoolAvailability($val['0']) <= 0)
  {					
     $insertId = $this->model_moe->insertexcel($data);}
	 //Update schools whose code exixts
	 else{$this->model_moe->updateSchool($val['0'],$data);}	 
	 }
   }$data['success'] = '<script language="javascript">window.alert("Schools uploaded successfully");</script>';
   $data['s'] = $this->model_moe->selectSchools();
   $this->load->view('schools',$data);
   }//End of else if uploaded
}

 public function viewSchools(){
   $data['s'] = $this->model_moe->selectSchools();
   //return data in view
   $this->load->view('schools',$data);
 }
 
 
  public function place(){
  //Proceed with placement only when choices have been made and schools, results and candidates exist
  $year = date("Y") - 1; //previous year
  
  $this->load->model('model_student');
  $choiceav = $this->model_student->confirmChoicesAvailability($year);
 if(!($choiceav > 0)) 
 {  $data['success'] = '<script language="javascript">window.alert("Placement aborted! There are no secondary school choices for '.$year.'.");</script>'; 
	$this->load->view('moe_view',$data);
 }
 
 //Proceed with placement only when candidates exist
  $sudentsav = $this->model_student->confirmStudentsAvailability($year);
 if(!($sudentsav > 0)) 
 {  $data['success'] = '<script language="javascript">window.alert("Placement aborted! There are no candidates for '.$year.'.");</script>'; 
	$this->load->view('moe_view',$data);
 }
 
  //Proceed with placement only when results exist
  $this->load->model('model_knec');
  $resultsav = $this->model_knec->confirmResultsAvailability($year);
 if(!($resultsav > 0)) 
 {  $data['success'] = '<script language="javascript">window.alert("Placement aborted! There are no results for '.$year.'.");</script>'; 
	$this->load->view('moe_view',$data);
 }
 
 //Proceed with placement only when schools exist
  $schoolsav = $this->model_moe->confirmSchoolsAvailability();
 if(!($schoolsav > 0)) 
 {  $data['success'] = '<script language="javascript">window.alert("Placement aborted! There are no schools registered.");</script>'; 
	$this->load->view('moe_view',$data);
 }

//Proceed with placement now

//Declare globally a variable for placement
$placement = 0;

//fetch students
//public $result = $this->model_knec->selectStudents();
//Loop through each student
foreach ($this->model_knec->selectStudents()->result() as $row)
{ 
$index = $row->index_no;
$phone = $row->phone;
$name = $row->name;
$gender = $row->gender;

   //Fetch the school choices for the student while checking if others have made choices, for now, do not place those who have made no choices, but later we will place them wherever they fit
   
   //Check availability of choices for this fellow, return 0 if not
   //$choiceav = $this->model_student->confirmMyChoicesAvailability($index);
   
   $national = $this->model_student->selectChoicesnat($index);
   $extra = $this->model_student->selectChoicesex($index);
   $county = $this->model_student->selectChoicescou($index);
   $district = $this->model_student->selectChoicesdis($index);
   
  /* if($national == 0 && $extra == 0 && $county == 0 && $district == 0 )//made no choices
   {
   $placement = 0;
   }
   else{*/
   //Get the capacity of the chosen schools
   $natcap = $extracap = $countycap = $districtcap = 0 ;
   if($national == 0){$natcap = (int) $this->model_moe->selectCapacity($national);} else{$natcap = 0;}
   if($extra == 0){$extracap = (int) $this->model_moe->selectCapacity($extra);} else{$extracap = 0;} 
   if($county == 0){$countycap = (int) $this->model_moe->selectCapacity($county);} else{$countycap = 0;}
   if($district == 0){$districtcap = (int) $this->model_moe->selectCapacity($district);} else{$districtcap = 0;}
   
   //Fetch result for each student
   $result = $this->model_knec->selectSpecificResults($index);
   //Determine the level of secondary schoool the student can be placed to depending on results
   if($result >= 430)//national school
   {
      //check if the capacity is full, place there if not
	  if($natcap > 0)
	   {
	     $placement = $national;
	   }
	   else//if full, select another national school for their gender and place there, The school should still not be full
	   {
	     //Fetch national school for this gender or mixxed
		 $gen = '';
		 if($gender == 'M'){$gen = 'G';} else{$gen = 'B';}
		 $code = $this->model_moe->select_another_school('National',$gen);
		   //If such a school exists, place the student there
		   if($code)
		   {
		     $placement = $code;
		   }
		   else//If no such school exists, just fix the student to the selected national school even if it is full
		   {
		     //check if national school choice was made, if yes, place there
			 if($national > 0){$placement = $national;}
			 //if not, select just any other national school and place there(Now without checking capacity)
			 else{$placement = $this->model_moe->select_another_school_nocap('National',$gen);}
		   }
	   }
   }
    else if(($result >= 370) && ($result < 430))//Extra-ccounty
   {
      //check if the capacity is full, place there if not
	  if($extracap > 0)
	   {
	     $placement = $extra;
	   }
	   else//if full, select another extra-county school for their gender and place their, The school should still not be full
	   {
	     //Fetch extra county school for this gender or mixxed
		 $gen = '';
		 if($gender == 'M'){$gen = 'G';} else{$gen = 'B';}
		 $code = $this->model_moe->select_another_school('Extra-county',$gen);
		   //If such a school exists, place the student there
		   if($code)
		   {
		     $placement = $code;
		   }
		   else//If no such school exists, just fix the student to the selected extra county school even if it is full
		   {
		     //check if extra county school choice was made, if yes, place there
			 if($extra > 0){$placement = $extra;}
			 //if not, select just any other extra-county school and place there(Now without checking capacity)
			 else{$placement = $this->model_moe->select_another_school_nocap('Extra-county',$gen);}
		   }
	   }
   }
    else if(($result >= 280) && ($result < 370))//ccounty
   {
     //check if the capacity is full, place there if not
	  if($countycap > 0)
	   {
	     $placement = $county;
	   }
	   else//if full, select another county school for their gender and place their, The school should still not be full
	   {
	     //Fetch county school for this gender or mixxed
		 $gen = '';
		 if($gender == 'M'){$gen = 'G';} else{$gen = 'B';}
		 $code = $this->model_moe->select_another_school('County',$gen);
		   //If such a school exists, place the student there
		   if($code)
		   {
		     $placement = $code;
		   }
		   else//If no such school exists, just fix the student to the selected county school even if it is full
		   {
		      //check if county school choice was made, if yes, place there
			 if($county > 0){$placement = $county;}
			 //if not, select just any other county school and place there(Now without checking capacity)
			 else{$placement = $this->model_moe->select_another_school_nocap('County',$gen);}
		   }
	   }
   }
   else //District school
   {
     //check if the capacity is full, place there if not
	  if($districtcap > 0)
	   {
	     $placement = $district;
	   }
	   else//if full, select another county school for their gender and place their, The school should still not be full
	   {
	     //Fetch district school for this gender or mixxed
		 $gen = '';
		 if($gender == 'M'){$gen = 'G';} else{$gen = 'B';}
		 $code = $this->model_moe->select_another_school('District',$gen);
		   //If such a school exists, place the student there
		   if($code)
		   {
		     $placement = $code;
		   }
		   else//If no such school exists, just fix the student to the selected district school even if it is full
		   {
		      //check if district school choice was made, if yes, place there
			 if($district > 0){$placement = $district;}
			 //if not, select just any other district school and place there(Now without checking capacity)
			 else{$placement = $this->model_moe->select_another_school_nocap('District',$gen);}
		   }
	   }
   }


//Trusting and believing that every student has been placed, finalize by sending data to db

//Fetch school details
//$row[] = array();selectSchoolGender
//$row = $this->model_moe->selectSpecificSchool($placement);

$schphone = $this->model_moe->selectSchoolPhone($placement);
$schname = $this->model_moe->selectSchoolName($placement);
$schgender = $this->model_moe->selectSchoolGender($placement);
$schlevel= $this->model_moe->selectSchoolLevel($placement);
 $data = array('placement' => $placement,
               'marks' => $result,
			   'schname' => $schname,
			   'schgender' => $schgender,
			   'schlevel' => $schlevel,);
 $st = $this->model_moe->updateStudents($index,$data);
 
//SMS students here
 // Be sure to include the file you've just downloaded
require_once(APPPATH.'/third_party/AfricasTalkingGateway.php');
  //$this->load->library('excel');	//similar to   require_once APPPATH.'/third_party/AfricasTalkingGateway.php';
// Specify your login credentials
$username   = "BEBZ";
$apikey     = "5848bc328d70e7757a36be5336c61dedf649ca0d5d7039d09229bba19dbf6443";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
//$phone = '0717246969';
$recipients = "+254".$phone;
// And of course we want our recipients to know what we really do
$message    = "SSDSS Notification: Congratulations ".$name." (".$index."):, You've been selected to join ".$schname." for form one. Kindly await a letter from the school.";
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

 
//We update school capacity (less by 1)
//First, fetch the school's capacity
$cap = (int) $this->model_moe->selectCapacity($placement);
//less by 1
$cap = $cap - 1;
 $data = array('capacity' => $cap,);
     $st = $this->model_moe->updateSchool($placement,$data);
	//}//End of else ya choices
	
}//End of foreach student


 //SMS download link to each school here
 foreach ($this->model_moe->selectSchools()->result() as $row)
{ 
$schoolcode = $row->code;
$schoolphone = $row->phone;
$schoolname = $row->name;
 // Be sure to include the file you've just downloaded
require_once(APPPATH.'/third_party/AfricasTalkingGateway.php');
  //$this->load->library('excel');	//similar to   require_once APPPATH.'/third_party/AfricasTalkingGateway.php';
// Specify your login credentials
$username   = "BEBZ";
$apikey     = "5848bc328d70e7757a36be5336c61dedf649ca0d5d7039d09229bba19dbf6443";
// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
$recipients = "+254".$schoolphone;
// And of course we want our recipients to know what we really do
$link = 'http://ssdss.000webhostapp.com/ssdss/index.php/moe/lists'; //Applies to 000webhost site only, change for others
$message    = "SSDSS Notification: Form one placement list is out. Kindly follow this link ".$link." to download list for ".$schoolname." (".$schoolcode.").";
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
}//Download link sent

	  $data2['success'] = '<script language="javascript">window.alert("Placement successful");</script>';
	   $data2['st'] = $this->model_knec->selectStudents();
	   //Get details of chosen school
	   //$data2['sch'] = $this->model_moe->selectSpecificSchool($placement);
   $this->load->view('placement',$data2);
 }

 public function lists()
        {
		
		   //check if there is placement report for last year's students
   $year = date('Y')-1;
   if($this->model_knec->confirmPlacement($year) > 0){
   $data['p'] = 1;} else{$data['p'] = 0;}
            $this->load->view('lists',$data);
        }


public function download()
{
require_once(APPPATH.'/third_party/fpdf/fpdf.php');
 $code = $this->input->post('code');

$this->form_validation->set_rules('code','Code','required');

if($this->form_validation->run() == FALSE)
{
//check if there is placement report for last year's students
   $year = date('Y')-1;
   if($this->model_knec->confirmPlacement($year) > 0){
   //$data['p'] = $this->model_knec->selectStudents();
   $data2['p'] = 1;} else{$data['p'] = 0;}
$data2['success'] = '<script language="javascript">window.alert("Kindly Re-Enter School Code");</script>';
$this->load->view('lists',$data2);}
else{
     if($this->input->post('codebtn') == "Download/View")
	 {
	 
	  if($this->model_moe->selectPlaces($code) == NULL)
	  {
	    //check if there is placement report for last year's students
   $year = date('Y')-1;
   if($this->model_knec->confirmPlacement($year) > 0){
   //$data['p'] = $this->model_knec->selectStudents();
   $data2['p'] = 1;} else{$data['p'] = 0;}
   $data2['success'] = '<script language="javascript">window.alert("No records found, kindly check the code and try again.");</script>';
   $this->load->view('lists',$data2);
	  }
	  
	  else{
	   $pdf=new FPDF();
	   $pdf->SetAutoPageBreak(false);
	   //Add page
      $pdf->AddPage("P","A4");
	  $pdf->SetFont("Times","U","14");
$pdf->SetX(90);
$pdf->Cell(10,8,"THE REPUBLIC OF KENYA",0,1,"C");
$pdf->SetX(90);
$pdf->Cell(10,8,"MINISTRY OF EDUCATION",0,1,"C");
$pdf->SetX(90);
$pdf->Cell(10,8,"FORM ONE LIST FOR ".$code.": ".strtoupper ($this->model_moe->selectSchoolName($code)).".",0,2,"C");

//Table heading
$pdf->SetX(10);
 
$pdf->SetFont("","B","14");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Multicell(80,8,"NAME",1,"C",0,1);
$pdf->setXY($x+80,$y);

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Multicell(50,8,"INDEX NO",1,"C",0);
$pdf->setXY($x+50,$y);

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Multicell(30,8,"GENDER",1,"C",0);
$pdf->setXY($x+30,$y);

$pdf->Multicell(30,8,"MARKS",1,"C",0);

foreach ($this->model_moe->selectPlaces($code)->result() as $row)
{ 
$index = $row->index_no;
$marks = $row->marks;
$name = $row->name;
$gender = $row->gender;

$pdf->SetFont("","","14");
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->Multicell(80,8,"".$name."",1);

$h = $pdf->GetY();
$pdf->setXY($x+80,$y);
if($h<=8){$h=8;} else{$h=$h-$y;}
$pdf->Multicell(50,$h,"".$index."",1,"C",0);

$h = $pdf->GetY();
$pdf->setXY($x+130,$y);
if($h<=8){$h=8;} else{$h=$h-$y;}
$pdf->Multicell(30,$h,"".$gender."",1,"C",0);

$h = $pdf->GetY();
$pdf->setXY($x+160,$y);
if($h<=8){$h=8;} else{$h=$h-$y;}
$pdf->Multicell(30,$h,"".$marks."",1,"C",0);

//To force page break when cell height is larger than space left at the bottom
$height_of_cell = 20; // mm
$page_height = 286.93; // mm (portrait letter)
$bottom_margin = -5; // mm
  for($i=0;$i<=100;$i++) :
    $block=floor($i/6);
    $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
      if ($i/6==floor($i/6) && $height_of_cell > $space_left) {
        $pdf->AddPage(); // page break
      }
  endfor;
}//End of foreach loop
 
 //check if there is placement report for last year's students
   $year = date('Y')-1;
   if($this->model_knec->confirmPlacement($year) > 0){
   //$data['p'] = $this->model_knec->selectStudents();
   $data2['p'] = 1;} else{$data['p'] = 0;}
$data2['success'] = '<script language="javascript">window.alert("Kindly Re-Enter School Code");</script>';
  $data2['dwnld'] = $pdf->Output();
   $this->load->view('schools',$data2);
     }
   }
 }
}




function cd_list() {
        $results = $this->model_moe->get_cd_list();
        echo json_encode($results);
		$this->load->view('schools',NULL);}
}
?>