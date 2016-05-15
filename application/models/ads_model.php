<?php
class Ads_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	function getAds() {
		$query = $this->db->get('ads');
		return  $query->result();
		
	}

	function updateAds($data) {

		$ads = $this->getAds();

		foreach($ads as $ad) {
			$arrayKey = "serviceIds_" . $ad->adId;

			if(array_key_exists($arrayKey, $data)) {

				$adServiceIds = implode(',',$data[$arrayKey]);

				//print_r($adServiceIds);

				$updateData = array(
              		 'servicesId' => $adServiceIds
            		);
				
			}
			else {
				$updateData = array(
              		 'servicesId' => ""
            		);
			}

			$this->db->update('ads', $updateData, "adId = $ad->adId");


		}
		

	}
}	