<?php
class Model_login extends CI_Model {
public function __construct() { //Call the Model constructor 
parent::__construct();
 }
function login_checkpoint($category ,$username ,$password ) {
$sql = "SELECT * FROM users WHERE category='".$category."' AND username='".$username."' AND password='".$password."' ";
$query = $this->db->query($sql);
return $query->num_rows();
}

function login_checkpoint_student($username ,$password ) {
$sql = "SELECT * FROM students WHERE index_no='".$username."' AND birthcert='".$password."' ";
$query = $this->db->query($sql);
return $query->num_rows();
}


function name($username) {
$sql = "SELECT * FROM students WHERE index_no='".$username."'";
$query = $this->db->query($sql);
return $query->row()->name;
}


public function insertusers($data)
            {
                $this->db->insert('users', $data);
                return $this->db->insert_id();
            }
}

/* End of file model_login.php */

/* Location: ./application/models/model_login.php */
?>