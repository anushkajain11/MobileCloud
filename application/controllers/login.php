<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {


	function __construct()
    {
        parent::__construct();
             
       
        
    }
	public function index()
	{
		$viewData['errorMsg'] = "";
		

		if($this->input->post('submit'))
		{

			//echo "Form Submitted ";
			$email = $this->input->post('username');
			$password = $this->input->post('password');

			$resultData = $this->User_model->loginUser($email,$password);

		

			if($resultData['result'] == true) {
				 redirect('/dashboard', 'refresh');
			}
			else {
				$viewData['errorMsg'] = "Invalid Login Credentials";
			}


		}
		$this->load->view('login', $viewData);
	}

}