<?php
class Service_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	function getServices() {
		$query = $this->db->get('servicesMaster');
		return  $query->result();
	}

	function updateServiceLogo($serviceId, $serviceLogo) {

		$updateData = array(
              		 'serviceLogo' => $serviceLogo
            		);
		$this->db->update('servicesMaster', $updateData, "serviceId = $serviceId");

	}
}

