<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {


	function __construct()
    {
        parent::__construct();
             
        
        
    }
	public function index()
	{
		if($this->input->post('submit'))
		{
			//echo "Form Submitted ";

			//print_r($_POST);
			$fName =  $this->input->post('fName');
			$lName =  $this->input->post('lName');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$invitationCode = $this->input->post('invitationCode');
			$employer = $this->input->post('employer');

			$this->User_model->registerUser($fName, $lName, $email,$password, $invitationCode, $employer);

			redirect('login', 'refresh');

		}
		else
		$this->load->view('website/register');
	}

}