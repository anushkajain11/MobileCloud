<?php
class User_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	

	function loginUser($email, $password) {
		//print_r($email);

		$this->mongo_db->where('username', $email);
		$this->mongo_db->where('password', $password);
		$row = $this->mongo_db->get('users');
		//print_r($row);
		if(isset($row) && !empty($row)){
			//echo "qq";
			$session_data = array(
				"customerid" => $row[0]['_id'],
				"username" => $email,
				"name" => $row[0]['name'],
				"login_type" => 'U'
			);

			$this->session->set_userdata($session_data);
			$returnData['result'] = true;
			

		}else {
			$returnData['result'] = false;
		}

		return $returnData;

	}

	function logoutUser() {
		$this->session->sess_destroy();
	}

	function makeSecure() {

		if($this->session->userdata('customerid')) {

		}
		else {
			redirect('/login', 'refresh');
		}

	}

	


}
