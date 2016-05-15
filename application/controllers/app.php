<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class App extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
		parent::__construct();
		// Your own constructor code
		header('Access-Control-Allow-Origin: *');
	}

	public function index() {

		redirect(base_url());

	}
	public function syncJob() {

		if (isset($_POST['json'])) {
			$result = $this->Job_model->saveJob($_POST['json']);
			$this->load->view('app_saveJob', $result);

		}
	}

	public function syncAds() {

		$result = $this->Job_model->getAds();
		$this->load->view('app_ads', $result);

	}

	public function register() {
		if (isset($_POST['email']) && isset($_POST['password'])) {

			$result = $this->User_model->register($_POST);
			$this->load->view('app_register', $result);

		}
	}

	public function login() {

		if (isset($_POST['email']) && isset($_POST['password'])) {

			$result = $this->User_model->login($_POST);
			$this->load->view('app_login', $result);

		}
	}

	public function changePassword() {

		if (isset($_POST['email']) && isset($_POST['changePassword'])) {
			$result = $this->User_model->changePassword($_POST);
			$this->load->view('app_changePassword', $result);
		}
	}

	public function updateProfile() {
		if (isset($_POST['email'])) {
			$result = $this->User_model->updateProfile($_POST);
			$this->load->view('app_updateProfile', $result);
		}
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */