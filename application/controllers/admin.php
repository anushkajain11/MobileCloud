<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class Admin extends CI_Controller {

	function __construct() {
		parent::__construct();
		

	}
	public function index() {
		$this->User_model->makeSecureAdmin();
		$this->load->view('website/adminDashboard');
	}
	public function login() {

		if($this->input->post('submit'))
		{
			//echo "Form Submitted ";
			$email = $this->input->post('username');
			$password = $this->input->post('password');

			$this->User_model->loginAdminUser($email,$password);


		}

		$this->load->view('website/adminLogin');
	}

	public function logout() {
		$this->User_model->logoutAdminUser();
		redirect('admin', 'refresh');
	}

	public function ads() {
		$this->User_model->makeSecureAdmin();
		if(isset($_POST['updateAds'])) {
			//echo "asd";
			$this->Ads_model->updateAds($_POST);

		}
		$data['ads'] = $this->Ads_model->getAds();
		$data['services'] = $this->Service_model->getServices();
		$this->load->view('website/adminAds', $data);
	}

	public function services() {
		$this->User_model->makeSecureAdmin();
		$this->load->helper('form');

		if(isset($_POST['uploadLogo'])) {
			$config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '100';
			$config['max_width']  = '1024';
			$config['max_height']  = '768';

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
				$data['error'] = $this->upload->display_errors();

				
			}
			else
			{
				$data['upload_data'] = $this->upload->data();
				$encoded_data = base64_encode(file_get_contents($data['upload_data']['full_path']));
				
				$this->Service_model->updateServiceLogo($_POST['serviceId'],$encoded_data);
			
			}
		}
		

		$data['services'] = $this->Service_model->getServices();
		$this->load->view('website/adminServices', $data);
	}
}