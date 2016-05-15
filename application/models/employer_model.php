<?php
class Employer_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	function addEmployee($email) {
		$this->load->helper('string');
		$invitationCode = random_string('alnum', 16);

		$data = array(
			'employer_id' => $this->session->userdata('employerId'),
			'user_email' => $email,
			'invitationCode' => $invitationCode
			);

		$result = $this->db->insert('employer_user', $data);

		if($result) {
			$response['statusMsg'] = "Employee " . $email . " invited Successfully";
		}

		return $response;
	}

	function listEmployee() {

		$array = array (
			'employer_id' => $this->session->userdata('employerId')
			);
		$query = $this->db->get_where('employer_user',$array);

		$data['employees'] = $query->result();

		return $data;
	}

	function getEmployees() {
		$array = array (
			'employer_id' => $this->session->userdata('employerId')
			);
		$query = $this->db->where($array)->where('user_id IS NOT NULL')->where('users.userId = employer_user.user_id')->get('employer_user,users');
		//echo $this->db->last_query();

		$data['employees'] = $query->result();

		return $data;
	}

	function addJobCat($data) {

		$data['employerId'] = $this->session->userdata('employerId');
		$data['date'] = DateTime::createFromFormat('d/m/Y', $data['date'])->format('Y-m-d');
		unset($data['submit']);
		if($this->db->insert('jobCat', $data))
		{
			$response['statusMsg'] = "Job Created & Assigned Successfully";
		}
		return $response;
	}

	function getJobCat() {

		$query = $this->db->where('employerId', $this->session->userdata('employerId'))->where('users.userId = jobCat.userId')->get('jobCat, users');
		


		return $query->result();
	}

	
}
