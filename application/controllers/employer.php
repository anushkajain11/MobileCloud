<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class Employer extends CI_Controller {

	function __construct() {
		parent::__construct();
		

	}
	public function index() {
		$this->User_model->makeSecureEmployer();
		$this->load->view('website/employerDashboard');
	}

	public function signUp() {

		if($this->input->post('submit')) {

			$name = $this->input->post('name'); 
			$email = $this->input->post('username');
			$password = $this->input->post('password');

			$this->User_model->registerEmployerUser($name,$email,$password);

		}
		$this->load->view('website/employerSignup');
	}
	public function login() {

		if($this->input->post('submit'))
		{
			//echo "Form Submitted ";
			$email = $this->input->post('username');
			$password = $this->input->post('password');

			$this->User_model->loginEmployerUser($email,$password);


		}

		$this->load->view('websitev2/employerLogin');
	}

	public function logout() {
		$this->User_model->logoutEmployerUser();
		redirect('employer', 'refresh');
	}

	public function dashboard() {
		$this->User_model->makeSecureEmployer();
		$this->load->view('websitev2/employerDashboard');

	}

	public function addemployee() {
		$this->User_model->makeSecureEmployer();
		if($this->input->post('submit')) {
			//echo "Sadfsdf";
			$email = $this->input->post('employeeEmail');
			//print_r($email);exit;
			$response = $this->Employer_model->addEmployee($email);
			$this->load->view('websitev2/employerAddEmployee', $response);
		}
		else {
			$this->load->view('websitev2/employerAddEmployee');
		}
		

	}

	public function listEmployee() {
		$this->User_model->makeSecureEmployer();

		$data = $this->Employer_model->listEmployee();


		$this->load->view('website/employerListEmployee', $data);
	}

	public function addJob() {
		$this->User_model->makeSecureEmployer();
		$data = $this->Employer_model->getEmployees();
		if($this->input->post('submit')) {

			$response = $this->Employer_model->addJobCat($_POST);
			$data['statusMsg'] = $response['statusMsg'];
			
		}
		else {
			$data = $this->Employer_model->getEmployees();

			
		}
		$this->load->view('website/employerAddJob', $data);
		
	}

	public function listJob() {
		$this->User_model->makeSecureEmployer();
		$data['jobs'] = $this->Employer_model->getJobCat();
		$this->load->view('website/employerListJob', $data);

	}

	public function listJobsByCat() {
		$this->User_model->makeSecureEmployer();
		$data = $this->Job_model->listJobsByCat($_GET['jobCatId']);
		$this->load->view('website/employerListJobsByCat', $data);

	}

	public function jobDetail() {
		$this->User_model->makeSecureEmployer();
		$data = $this->Job_model->getJobTimeline(base64_decode($_GET['q']));
		$this->load->view('website/employerJobDetail', $data);
	}

	public function kml($jobId) {
		$this->User_model->makeSecureEmployer();
		$this->Job_model->generateKmlByJobId($jobId);
	}

	public function liveTrack() {
		$this->User_model->makeSecureEmployer();
		$this->load->view('website/employerLiveTrack');
	}
	public function liveTrackGet() {
			$this->User_model->makeSecureEmployer();
		echo json_encode($this->User_model->liveTrackGet($_POST['email']));
	}
	
}