<?php 
class Model_moe extends CI_Model
    {
	private $schools = 'schools';
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
			
			public function selectSchools()
			{
			  $query = $this->db->get('schools');
			  return $query;
			}

			function select_schools($level,$gender) 
		  {
           $sql = "SELECT * FROM schools WHERE level='".$level."' AND NOT gender='".$gender."' ";
           $query = $this->db->query($sql);
		   $result = $query->result();
           return $result;
		   }
		   		   
		   function select_another_school($level,$gender) 
		  {
           $sql = "SELECT * FROM schools WHERE level='".$level."' AND NOT gender='".$gender."' AND NOT capacity='0' ";
		   $query = $this->db->query($sql);
		   if($query->num_rows() > 0){ return $query->row()->code; }
			 else{ return 0;};
		   }
		   
		   function select_another_school_nocap($level,$gender) 
		  {
           $sql = "SELECT * FROM schools WHERE level='".$level."' AND NOT gender='".$gender."'";
		   $query = $this->db->query($sql);
		   if($query->num_rows() > 0){ return $query->row()->code; }
			 else{ return 0;};
		   }
		   
		   public function confirmSchoolsAvailability()
			{$sql = "SELECT * FROM schools";
             $query = $this->db->query($sql);
			  return $query->num_rows();
			}
			
			public function confirmSchoolAvailability($code)
			{$sql = "SELECT * FROM schools WHERE code='".$code."' ";
             $query = $this->db->query($sql);
			  return $query->num_rows();
			}
			
			public function selectCapacity($code)
			{		  
			   $sql = "SELECT DISTINCT capacity FROM schools WHERE code='".$code."' ";
             $query = $this->db->query($sql);
			 if($query->num_rows() > 0){ return $query->row()->capacity; }
			 else{ return 0;};
			  }
			  
			 /* public function selectSpecificSchool($code)
			{		  
			   //$sql = "SELECT * FROM schools WHERE code='".$code."' ";
			   $query = $this->db->select('*');
			   $query = $this->db->where('code',$code);
			   $query = $this->db->get('schools');
             //$query = $this->db->query($sql);
			 if($query->num_rows() > 0){ return $query; }
			 else{ return 0;};
			  } */	
			  
			    public function selectSchoolName($code)
			{		  
			   $sql = "SELECT * FROM schools WHERE code='".$code."' ";
            $query = $this->db->query($sql);
		   if($query->num_rows() > 0){ return $query->row()->name; }
			 else{ return 0;};
			 }
			 
			     public function selectSchoolPhone($code)
			{		  
			   $sql = "SELECT * FROM schools WHERE code='".$code."' ";
            $query = $this->db->query($sql);
		   if($query->num_rows() > 0){ return $query->row()->phone; }
			 else{ return 0;};
			 }
			 
			    public function selectSchoolMail($code)
			{		  
			   $sql = "SELECT * FROM schools WHERE code='".$code."' ";
            $query = $this->db->query($sql);
		   if($query->num_rows() > 0){ return $query->row()->email; }
			 else{ return 0;};
			 }	
			 
			   public function selectSchoolGender($code)
			{		  
			   $sql = "SELECT * FROM schools WHERE code='".$code."' ";
            $query = $this->db->query($sql);
		   if($query->num_rows() > 0){ return $query->row()->gender; }
			 else{ return 0;};
			 }
			 
			   public function selectSchoolLevel($code)
			{		  
			   $sql = "SELECT * FROM schools WHERE code='".$code."' ";
            $query = $this->db->query($sql);
		   if($query->num_rows() > 0){ return $query->row()->level; }
			 else{ return 0;};
			 }	  
			  
			  public function updateStudents($index,$data)
			 { 
               $this->db->where('index_no',$index);
			  return $this->db->update('students', $data);
			  }
			  
			   public function updateSchool($code,$data)
			 { 
               $this->db->where('code',$code);
			  return $this->db->update('schools', $data);
			  }
			  
			     public function selectPlaces($code)
			{		  
			   $sql = "SELECT * FROM students WHERE placement='".$code."' ";
            $query = $this->db->query($sql);
		   if($query->num_rows() > 0){ return $query; }
			 else{ return NULL;};
			 }	
			  
//JSON DATATABLE CODE
    function get_cd_list() {
        /* Array of table columns which should be read and sent back to DataTables. Use a space where
         * you want to insert a non-database field (for example a counter or static image)
         */
        $aColumns = array(
            'id',
            'code',
            'name',
            'county',
            'gender',
            'level',
            'capacity');
 
        /* Indexed column (used for fast and accurate table cardinality) */
        $sIndexColumn = "id";
 
        /* Total data set length */
        $sQuery = "SELECT COUNT('" . $sIndexColumn . "') AS row_count
            FROM $this->schools";
        $rResultTotal = $this->db->query($sQuery);
        $aResultTotal = $rResultTotal->row();
        $iTotal = $aResultTotal->row_count;
 
        /*
         * Paging
         */
        $sLimit = "";
        $iDisplayStart = $this->input->get_post('start', true);
        $iDisplayLength = $this->input->get_post('length', true);
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $sLimit = "LIMIT " . intval($iDisplayStart) . ", " .
                    intval($iDisplayLength);
        }
 
        $uri_string = $_SERVER['QUERY_STRING'];
        $uri_string = preg_replace("/%5B/", '[', $uri_string);
        $uri_string = preg_replace("/%5D/", ']', $uri_string);
 
        $get_param_array = explode("&", $uri_string);
        $arr = array();
        foreach ($get_param_array as $value) {
            $v = $value;
            $explode = explode("=", $v);
            $arr[$explode[0]] = $explode[1];
        }
 
        $index_of_columns = strpos($uri_string, "columns", 1);
        $index_of_start = strpos($uri_string, "start");
        $uri_columns = substr($uri_string, 7, ($index_of_start - $index_of_columns - 1));
        $columns_array = explode("&", $uri_columns);
        $arr_columns = array();
        foreach ($columns_array as $value) {
            $v = $value;
            $explode = explode("=", $v);
            if (count($explode) == 2) {
                $arr_columns[$explode[0]] = $explode[1];
            } else {
                $arr_columns[$explode[0]] = '';
            }
        }
 
        /*
         * Ordering
         */
        $sOrder = "ORDER BY ";
        $sOrderIndex = $arr['order[0][column]'];
        $sOrderDir = $arr['order[0][dir]'];
        $bSortable_ = $arr_columns['columns[' . $sOrderIndex . '][orderable]'];
        if ($bSortable_ == "true") {
            $sOrder .= $aColumns[$sOrderIndex] .
                    ($sOrderDir === 'asc' ? ' asc' : ' desc');
        }
 
        /*
         * Filtering
         */
        $sWhere = "";
        $sSearchVal = $arr['search[value]'];
        if (isset($sSearchVal) && $sSearchVal != '') {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearchVal) . "%' OR ";
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }
 
        /* Individual column filtering */
        $sSearchReg = $arr['search[regex]'];
        for ($i = 0; $i < count($aColumns); $i++) {
            $bSearchable_ = $arr['columns[' . $i . '][searchable]'];
            if (isset($bSearchable_) && $bSearchable_ == "true" && $sSearchReg != 'false') {
                $search_val = $arr['columns[' . $i . '][search][value]'];
                if ($sWhere == "") {
                    $sWhere = "WHERE ";
                } else {
                    $sWhere .= " AND ";
                }
                $sWhere .= $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($search_val) . "%' ";
            }
        }
 
 
        /*
         * SQL queries
         * Get data to display
         */
        $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $aColumns)) . "
        FROM $this->schools
        $sWhere
        $sOrder
        $sLimit
        ";
        $rResult = $this->db->query($sQuery);
 
        /* Data set length after filtering */
        $sQuery = "SELECT FOUND_ROWS() AS length_count";
        $rResultFilterTotal = $this->db->query($sQuery);
        $aResultFilterTotal = $rResultFilterTotal->row();
        $iFilteredTotal = $aResultFilterTotal->length_count;
 
        /*
         * Output
         */
        $sEcho = $this->input->get_post('draw', true);
        $output = array(
            "draw" => intval($sEcho),
            "recordsTotal" => $iTotal,
            "recordsFiltered" => $iFilteredTotal,
            "data" => array()
        );
 
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aColumns as $col) {
                $row[] = $aRow[$col];
            }
            $output['data'][] = $row;
        }
 
        return $output;
    }
 
 
 
    }
?>