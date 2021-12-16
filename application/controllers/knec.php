<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Knec extends CI_Controller {
function __construct()
{
parent::__construct();
$this->load->model('model_knec');
}

    public function index()
        {
            $this->load->view('knec_view');
        }

public function importStudents()
{
	//load the excel library
    $this->load->library('excel');	//similar to   require_once APPPATH.'/third_party/phpexcel/Classes/PHPExcel.php';
		// Create new PHPExcel object
$inputFileName = $_FILES['uploadstudents']['tmp_name'];
if(!$inputFileName){
  $data['success'] = '<script language="javascript">window.alert("Please select a file to upload");</script>';
   $this->load->view('knec_view',$data);
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
              'index_no' => $val['0'],
			  'year' => $val['1'],
              'name' => $val['2'],
              'birthcert' => $val['3'],
			  'schtype' => $val['4'],
              'county' => $val['5'],
              'gender' => $val['6'],
			  'e_mail' => $val['7'],
			  'phone' => $val['8'],
                                );
     
	 $this->load->model('model_student');
	 //Insert students who do not exist
 if($this->model_student->confirmStudentAvailability($val['1'],$val['0']) <= 0)
  {					
     $insertId = $this->model_knec->insertstudents($data);}
	 //Update students who exixts
	 else{$this->model_student->updateStudents($val['0'],$val['1'],$data);}	
	 
	 }
   }$data['success'] = '<script language="javascript">window.alert("Students uploaded successfully");</script>';
   $data['st'] = $this->model_knec->selectStudents();
   //return data in view
   $this->load->view('students',$data);
   }//End of else if uploaded
}


public function importResults()
{
	//load the excel library
    $this->load->library('excel');	//similar to   require_once APPPATH.'/third_party/phpexcel/Classes/PHPExcel.php';
		// Create new PHPExcel object
$inputFileName = $_FILES['uploadresults']['tmp_name'];
if(!$inputFileName){
  $data['success'] = '<script language="javascript">window.alert("Please select a file to upload");</script>';
   $this->load->view('knec_view',$data);
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
              'year' => $val['0'],
              'index_no' => $val['1'],
              'total_marks' => $val['2'],
                                );
     	 }
	 
	 //insert a result whose index and year already existsn not
if($this->model_knec->confirmResultAvailability($val['0'],$val['1']) <= 0)
  {	  $insertId = $this->model_knec->insertresults($data);}
	 //update a result whose index and year already exists
	 else{$this->model_knec->updateResults($val['1'],$val['0'],$data);}	
	 
   }$data['success'] = '<script language="javascript">window.alert("Results uploaded successfully");</script>';
    $data['rs'] = $this->model_knec->selectResults();
   //return data in view
   $this->load->view('results',$data);
   }//End of else if uploaded
}
		
public function viewStudents(){
   $data['st'] = $this->model_knec->selectStudents();
   //return data in view
   $this->load->view('students',$data);
 } 
 
 public function viewPlacedStudents(){
   $data['st'] = $this->model_knec->selectStudents();
   //return data in view
   $this->load->view('placement',$data);
 }
 
 public function viewResults(){
   $data['rs'] = $this->model_knec->selectResults();
   //return data in view
   $this->load->view('results',$data);
 }
}
?>