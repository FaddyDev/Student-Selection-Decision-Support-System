<?php 
class Model_student extends CI_Model
    {
	public function __construct() { //Call the Model constructor 
parent::__construct();
 }			
			public function insertchoices($data)
            {
                $this->db->insert('choices', $data);
                return $this->db->insert_id();
            }
			
			public function selectChoices($index)
			{$sql = "SELECT * FROM choices WHERE index_no='".$index."' ";
             $query = $this->db->query($sql);
			  return $query;
			}
			
			public function selectChoicesnat($index)
              {
			  $sql = "SELECT DISTINCT national FROM choices WHERE index_no='".$index."' ";
			  $query = $this->db->query($sql);
			   if($query->num_rows() > 0){ return $query->row()->national;}
			  else{return 0;}
			}
			
		   public function selectChoicesex($index)
			{
			  $sql = "SELECT DISTINCT extra FROM choices WHERE index_no='".$index."' ";
             $query = $this->db->query($sql);
			 if($query->num_rows() > 0){ return $query->row()->extra; }
			 else{ return 0;}
			}
			
			public function selectChoicescou($index)
			{
			  $sql = "SELECT DISTINCT county FROM choices WHERE index_no='".$index."' ";
			  $query = $this->db->query($sql);
             if($query->num_rows() > 0){ return $query->row()->county; }
			 else{ return 0;};
			}
			
			public function selectChoicesdis($index)
			{		  
			  $sql = "SELECT DISTINCT district FROM choices WHERE index_no='".$index."' ";
			  $query = $this->db->query($sql);
             if($query->num_rows() > 0){ return $query->row()->district; }
			 else{ return 0;};
			}
			
			public function selectGender($index)
			{$sql = "SELECT DISTINCT gender FROM students WHERE index_no='".$index."' ";
             $query = $this->db->query($sql);
			  return $query->result();
			}
			
			public function confirmChoicesAvailability($year)
			{$sql = "SELECT * FROM choices WHERE year='".$year."' ";
             $query = $this->db->query($sql);
			  return $query->num_rows();
			}
			
			public function confirmStudentsAvailability($year)
			{$sql = "SELECT * FROM students WHERE year='".$year."' ";
             $query = $this->db->query($sql);
			  return $query->num_rows();
			}
			
			public function confirmStudentAvailability($year,$index)
			{$sql = "SELECT * FROM students WHERE year='".$year."' AND index_no='".$index."' ";
             $query = $this->db->query($sql);
			  return $query->num_rows();
			}
			
		    function confirmchoices($index) {
					$sql = "SELECT * FROM choices WHERE index_no='".$index."' ";
					$query = $this->db->query($sql);
					return $query->num_rows();
			}
			
			public function updatechoices($index,$data)
            {    $this->db->where('index_no',$index);
                $this->db->update('choices', $data);
                //return $this->db->insert_id();
            }
			public function addphone($index,$data)
            {    $this->db->where('index_no',$index);
                $this->db->update('students', $data);
                //return $this->db->insert_id();
            }
			
			public function getphone($index)
			{$sql = "SELECT * FROM students WHERE index_no='".$index."' ";
             $query = $this->db->query($sql);
			  return $query->row()->phone;
			}
			
			 public function updateStudents($index,$year,$data)
			 { 
               $this->db->where('index_no',$index);
			   $this->db->where('year',$year);
			  return $this->db->update('students', $data);
			  }
			  
			  public function selectSpecificName($index)
			{
			  $sql = "SELECT DISTINCT name FROM students WHERE index_no='".$index."' ";
             $query = $this->db->query($sql);
			   if($query->num_rows() > 0){ return $query->row()->name; }
			 else{ return 0;};
			}
    }
?>