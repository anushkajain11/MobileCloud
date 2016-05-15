<?php
class Sensor_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	function getAllPhysicalSensors() {


		$rows = $this->mongo_db->get('sensorMetaData');
		return $rows;


	} 


}	
