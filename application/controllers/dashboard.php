<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class Dashboard extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->User_model->makeSecure();

	}
	public function index() {

		$getAllPhysicalSensors = $this->Sensor_model->getAllPhysicalSensors('sensor_model');

		$jsonObject = array();
		for($i=0; $i< count($getAllPhysicalSensors); $i++) {

			$t = new stdClass;
			$t->name = $getAllPhysicalSensors[$i]["name"];
			$t->lat = $getAllPhysicalSensors[$i]["latitude (degree)"];
			$t->lon = $getAllPhysicalSensors[$i]["longitude (degree)"];
			$jsonObject[$i] = $t;

			if($i > 10) break;

		}
		//print_r($jsonObject);exit;
		$viewData['physicalSensors'] = $jsonObject;

		

		$this->load->view('dashboard', $viewData);
	}

}