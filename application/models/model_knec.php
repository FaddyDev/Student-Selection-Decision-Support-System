<?php 
class Model_knec extends CI_Model
    {
	public function __construct() { //Call the Model constructor 
parent::__construct();
 }			
			public function insertExcel($data)
            {
                $this->db->insert('schools', $data);
                return $this->db->insert_id();
            }
			
			public function insertstudents($data)
            {
                $this->db->insert('students', $data);
                return $this->db->insert_id();
            }
			
			public function insertresults($data)
            {
                $this->db->insert('results', $data);
                return $this->db->insert_id();
            }
			
			public function selectStudents()
			{
			  $query = $this->db->get('students');
			  return $query;
			}
			
		    public function confirmResultsAvailability($year)
			{$sql = "SELECT * FROM results WHERE year='".$year."' ";
             $query = $this->db->query($sql);
			  return $query->num_rows();
			}
			
			 public function confirmResultAvailability($year,$index)
			{$sql = "SELECT * FROM results WHERE year='".$year."' AND index_no='".$index."' ";
             $query = $this->db->query($sql);
			  return $query->num_rows();
			}
			
			public function selectResults()
			{
			  $query = $this->db->get('results');
			  return $query;
			}
			
			public function selectSpecificResults($index)
			{
			  $sql = "SELECT DISTINCT total_marks FROM results WHERE index_no='".$index."' ";
             $query = $this->db->query($sql);
			   if($query->num_rows() > 0){ return $query->row()->total_marks; }
			 else{ return 0;};
			}
			public function confirmPlacement($year)
			{$sql = "SELECT * FROM students WHERE year='".$year."' AND NOT placement='0' ";
             $query = $this->db->query($sql);
			  return $query->num_rows();
			}	
			 public function updateResults($index,$year,$data)
			 { 
               $this->db->where('index_no',$index);
			   $this->db->where('year',$year);
			  return $this->db->update('results', $data);
			  }		
    }
?>