<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class Reports extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->User_model->makeSecure();

	}
	public function index() {

		$this->load->view('website/reports');
	}

	public function all($fileType = "html") {

		switch($fileType) {

			case 'csv' : 	$this->load->dbutil();

							$startDate = $this->input->get('startDate');
							$endDate = $this->input->get('endDate');

							$startTime = DateTime::createFromFormat('d/m/Y H:i:s', $startDate. " 00:00:00")->format('Y-m-d H:i:s');
							$endTime = DateTime::createFromFormat('d/m/Y H:i:s', $endDate. " 23:59:59")->format('Y-m-d H:i:s');
							
							$data = $this->Job_model->getJobs($startTime,$endTime);
							$this->load->view('website/csvreports', $data);
						break;
			default :
						if($this->input->post('submitFetchReports')) {
							$startDate = $this->input->post('startDate');
							$endDate = $this->input->post('endDate');

							$startTime = DateTime::createFromFormat('d/m/Y H:i:s', $startDate. " 00:00:00")->format('Y-m-d H:i:s');
							$endTime = DateTime::createFromFormat('d/m/Y H:i:s', $endDate. " 23:59:59")->format('Y-m-d H:i:s');
							

							
							$data = $this->Job_model->getJobs($startTime,$endTime);
							$this->load->view('website/reports', $data);	

						}
						else {
							$this->load->view('website/reports');
						}
						
		}

		
	}

	public function jobwise() {

		if($this->input->post('submitFetchReports')) {

			$startDate = $this->input->post('startDate');
			$endDate = $this->input->post('endDate');

			$startTime = DateTime::createFromFormat('d/m/Y H:i:s', $startDate. " 00:00:00")->format('Y-m-d H:i:s');
			$endTime = DateTime::createFromFormat('d/m/Y H:i:s', $endDate. " 23:59:59")->format('Y-m-d H:i:s');
							

			$data['jobType'] = $this->Job_model->getJobsByType($startTime,$endTime);


			$this->load->view('website/reportsByJobType', $data);	

		}
		else {
			$this->load->view('website/reportsByJobType');
		}

	}

	public function jobDetail() {

		$data = $this->Job_model->getJobTimeline(base64_decode($_GET['q']));
		$this->load->view('website/jobDetail', $data);
	}

	public function kml($jobId) {

		$this->Job_model->generateKmlByJobId($jobId);
	}

	public function kmlByLatLon($lat,$lon) {
		$this->Job_model->generateKmlByLatLon($lat, $lon);
	}

}