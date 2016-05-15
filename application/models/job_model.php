<?php
class Job_model extends CI_Model {

	function __construct() {
		// Call the Model constructor
		parent::__construct();
	}

	

	function saveJob($data) {

		$jobData = json_decode($data);

		$this->db->trans_start();

		$dbJobData = array(
			'email'          => $jobData->job->email,
			'startTime'      => date("Y-m-d H:i:s", $jobData->job->startTime / 1000),
			'endTime'        => date("Y-m-d H:i:s", $jobData->job->endTime / 1000),
			'workType'       => $jobData->job->workType,
			'notes'          => $jobData->job->notes,
			'incidentNumber' => $jobData->job->incidentNumber
		);

		$this->db->insert('jobs', $dbJobData);

		$lastJobId      = $this->db->insert_id();
		$dbLocationData = array();

		for ($i = 0; $i < count($jobData->locations); $i++) {

			$dbLocationData[] = array(
				'jobID'   => $lastJobId,
				'lat'     => $jobData->locations[$i]->lat,
				'lon'     => $jobData->locations[$i]->lon,
				'timenow' => date("Y-m-d H:i:s", $jobData->locations[$i]->timenow / 1000 )

			);

		}

		if (count($jobData->locations) > 0) {
			$this->db->insert_batch('userLocation', $dbLocationData);
		}

		$this->db->trans_complete();

		$returnData['result'] = "OK";
		$returnData['jobId']  = $jobData->job->jobId;

		return $returnData;
	}

	function saveJobV2($data) {


		$jobData = json_decode($data);

		//print_r($jobData);exit;
		$this->db->trans_start();

		$dbJobData = array(
			'email'          => $jobData->job->email,
			'startTime'      => $jobData->job->startTime,
			'endTime'        => $jobData->job->endTime,
			'workType'       => $jobData->job->workType,
			'notes'          => $jobData->job->notes,
			'incidentNumber' => $jobData->job->incidentNumber,
			'jobCatId' => $jobData->job->jobCatId
		);

		$this->db->insert('jobs', $dbJobData);

		$lastJobId      = $this->db->insert_id();
		$dbLocationData = array();

		for ($i = 0; $i < count($jobData->locations); $i++) {

			$dbLocationData[] = array(
				'jobID'   => $lastJobId,
				'lat'     => $jobData->locations[$i]->lat,
				'lon'     => $jobData->locations[$i]->lon,
				'timenow' => $jobData->locations[$i]->timenow

			);

		}

		// In App Notes
		$dbInJobNotesData = array();
		for ($i = 0; $i < count($jobData->notes); $i++) {

			$dbInJobNotesData[] = array(
				'jobID'   => $lastJobId,
				'note'     => $jobData->notes[$i]->note,
				'timenow' => $jobData->notes[$i]->timenow

			);

		}

		if (count($jobData->locations) > 0) {
			$this->db->insert_batch('userLocation', $dbLocationData);
		}

		if (count($jobData->notes) > 0) {
			$this->db->insert_batch('inJobNote', $dbInJobNotesData);
		}
		
		$this->db->trans_complete();

		$returnData['result'] = "OK";
		$returnData['jobId']  = $jobData->job->jobId;
		$returnData['serverJobId'] = $lastJobId;

		return $returnData;
	}

	function getAds() {
		$query                = $this->db->get('ads');
		$returnData['result'] = "OK";
		$returnData['ads']    = $query->result();
		return $returnData;
	}

	function saveMedia($data, $files) {

		if(isset($data['serverJobId'])) {
			$target_dir = "userData/";
			$target_file = $target_dir . $data['serverJobId'] . "_" .basename($_FILES["file"]["name"]);

			move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

			$dbMediaData = array(
			'jobId'          => $data['serverJobId'],
			'filePath'      => $target_file,
			'timenow'		=> $data['timeNow']
			);

			$this->db->insert('inJobMedia', $dbMediaData);

			$returnData['result'] = "OK";
			return $returnData;
		}
		
	}

	/** ------------------------------------
	    Website Related Functions 
	    ------------------------------------ **/

	function getJobs($startTime, $endTime) {
		
		//$query = $this->db->order_by("jobId", "desc")->where('startTime >=', $startTime)->where('endTime <=', $endTime)->get_where('jobs', array('email' => $this->session->userdata('email')));
		$query = $this->db->query("select *, (select count(*) from inJobMedia where jobId = jobs.jobId ) + (select count(*) from inJobNote where jobId = jobs.jobId) as noteMediaCount FROM (`jobs`) WHERE `startTime` >= '".$startTime."' AND `startTime` <= '".$endTime."' AND `email` = '".$this->session->userdata('email')."' ORDER BY `startTime` desc");
		
		//echo $this->db->last_query();
		$locationQuery = $this->db->query("select * from userLocation where `jobID` in (select `jobId` from jobs where `startTime` >= '".$startTime."' and `endTime` <= '".$endTime."' and email = '".$this->session->userdata('email')."')");

		$data['jobs'] = $query->result();
		$data['locations'] = $locationQuery->result();

		return $data;

	}

	function listJobsByCat($jobCatId) {

		$query = $this->db->query("select *, (select count(*) from inJobMedia where jobId = jobs.jobId ) + (select count(*) from inJobNote where jobId = jobs.jobId) as noteMediaCount FROM (`jobs`) WHERE jobCatId = " . $jobCatId);
		
		//echo $this->db->last_query();
		$locationQuery = $this->db->query("select * from userLocation where `jobID` in (select `jobId` from jobs where jobCatId = " . $jobCatId . ")");

		$jobCatQuery = $this->db->where('id',$jobCatId)->where('users.userId = jobCat.userId')->get('users, jobCat');
		$data['jobs'] = $query->result();
		$data['locations'] = $locationQuery->result();
		$data['jobCat'] = $jobCatQuery->result();

		return $data;
	}

	function getJobsByType($startTime, $endTime) {

		$data = $this->getJobs($startTime,$endTime);
		$jobs = $data['jobs'];
		$jobType = array();

		foreach($jobs as $job) {

			$workTypes = explode(',', $job->workType);
			
			for($i=0 ; $i<count($workTypes) ; $i++) {
				$tempWorkType = $workTypes[$i];

				
				$tempJobTime = (strtotime($job->endTime) - strtotime($job->startTime)); // Converting Millisecond to Seconds
				if($tempWorkType == "")
					continue;
				if(array_key_exists($tempWorkType, $jobType)) {
					$jobType["$tempWorkType"]['count'] ++;
					$jobType["$tempWorkType"]['jobTime'] += $tempJobTime;
					
				}
				else {
					$jobType["$tempWorkType"] = array('count' => 1, 'jobTime' => $tempJobTime);
				}
				

			}
		}

		return $jobType;

		

	}

	function getJobTimeline($jobId) {
		$sql = "select * FROM ((select jobId, note, NULL as filePath, timenow as timenow  from inJobNote where jobId = ".$jobId.") UNION ALL (select jobId, NULL as note, filePath, timeNow as timenow from inJobMedia where jobId = ".$jobId.") ) results order by timeNow desc";

		$query = $this->db->query($sql);

		$data['timeline'] = $query->result();

		//print_r($query->result());

		for($i=0; $i < count($data['timeline']) ; $i++) {
			$timelineItem = $data['timeline'][$i];
			$innerSql = "select *,(ABS(TIMESTAMPDIFF(SECOND,timenow, '$timelineItem->timenow'))) as difference from userLocation where jobId= '$timelineItem->jobId' order by (ABS(TIMESTAMPDIFF(SECOND,timenow, '$timelineItem->timenow'))) asc limit 1";
			//echo $innerSql;echo "\n";
			$innerSqlQuery = $this->db->query($innerSql)->row();
			$data['timeline'][$i]->nearLocation = $innerSqlQuery;
		}
		
		return $data;
	}

	function generateKmlByJobId($jobId) {
		$this->load->helper('download');

		$query = $this->db->get_where('userLocation', array('jobID' => $jobId));

		$locations = $query->result();

		
		$locationData = '';

		foreach($locations as $location) {

			$locationData .= "$location->lon,$location->lat,100 \n";

		}

		$data = '<?xml version="1.0" encoding="UTF-8"?>
				<kml xmlns="http://www.opengis.net/kml/2.2">
				  <Document>
				    <name>Paths</name>
				    <description>Examples of paths. Note that the tessellate tag is by default
				      set to 0. If you want to create tessellated lines, they must be authored
				      (or edited) directly in KML.</description>
				    <Style id="yellowLineGreenPoly">
				      <LineStyle>
				        <color>7f00ffff</color>
				        <width>4</width>
				      </LineStyle>
				      <PolyStyle>
				        <color>7f00ff00</color>
				      </PolyStyle>
				    </Style>
				    <Placemark>
				      <name>Absolute Extruded</name>
				      <description>Transparent green wall with yellow outlines</description>
				      <styleUrl>#yellowLineGreenPoly</styleUrl>
				      <LineString>
				        <extrude>1</extrude>
				        <tessellate>1</tessellate>
				        <altitudeMode>absolute</altitudeMode>
				        <coordinates>';
		$data = $data . $locationData;
		$data = $data . ''.$locations[0]->lon.','.$locations[0]->lat. ",100 \n";
		$data = $data . ' 
				        </coordinates>
				      </LineString>
				    </Placemark>
				  </Document>
				</kml>';

		$name = 'kml_' . $jobId . '.kml';

		//print_r($data);exit;
		force_download($name, $data);
	}

	function dailyReportMail() {
		
		
	}

	function generateKmlByLatLon ($lat,$lon) {
		$this->load->helper('download');

		

		$data = '<?xml version="1.0" encoding="UTF-8"?>
					<kml xmlns="http://www.opengis.net/kml/2.2">
					  <Placemark>
					    <name>Nearest Location</name>
					    <description>This is the nearest location found to the place where you captured Note/Media</description>
					    <Point>
					      <coordinates>
					      '.$lon.','.$lat.'
					      </coordinates>
					    </Point>
					  </Placemark>
					</kml>
';
		$name = 'kml_' . time() . '.kml';
		force_download($name, $data);

	}

}
