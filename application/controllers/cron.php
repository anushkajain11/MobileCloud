<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

class Cron extends CI_Controller {

	
	public function dailyReportMail() {

		$this->load->dbutil();
		$this->load->library('email');
		$this->load->helper('file');
		

		$data = read_file('./dataFiles/adminNotifiedLastJob.txt');
		
		$query = $this->db->query('select jobs.jobId as jobId, CONCAT (fName, " ", lName) as Name, users.email, users.brigadeName, (select serviceName from servicesMaster where serviceId = users.service) as "Service", users.phoneNumber as "Phone", (endTime - startTime) / 1000 as "Time Taken", workType as "Work Type", incidentNumber as "IncidentNumber", notes as "Notes" from jobs,users where users.email = jobs.email and jobs.jobId > '.$data.' order by jobs.jobId desc');
		$this->email->from('admin@eslogger.com');
		$this->email->to('reports@eslogger.com');
		$this->email->cc('ritvick.paliwal@gmail.com');
		$this->email->subject('ESLogger Status Report');
			
		if($query->num_rows() < 1) {
			$this->email->message('No New Entries since last run');
		}
		else {
			$maxJobId = $query->row()->jobId;
			$csv = "Job Id\tName\t Email\tBrigade Name\tService\tPhone\tTime Taken\tWork Type\tIncident Number\tNotes";
			$csv .= "\r\n";
			$delimiter = "\t";
			$newline = "\r\n";
			$csv .=  $this->dbutil->csv_from_result($query, $delimiter, $newline );
			write_file('./dataFiles/csvReport.csv', $csv);
			echo $csv;
			
			
			$this->email->message('PFA the report file');
			$this->email->attach('./dataFiles/csvReport.csv');
			write_file('./dataFiles/adminNotifiedLastJob.txt', $maxJobId);
		}
		
		//echo $maxJobId;
		
		$this->email->send();

		

	}

	public function phpinfo() {

		echo phpinfo();
	}

	public function dailyReport() {
		$this->load->helper('file');
		$pathToFile = './dataFiles/adminNotifiedLastJob.txt';
		$data = read_file($pathToFile);
		//$query = $this->db->query('select jobs.jobId as jobId, CONCAT (fName, " ", lName) as Name, users.email, (endTime - startTime) / 1000 as "Time Taken", workType as "Work Type", notes as "Notes" from jobs,users where users.email = jobs.email and jobs.jobId > '.$data. ' order by jobs.jobId desc');
		//echo $this->dbutil->csv_from_result($query);
		//$maxJobId = $query->row()->jobId;
		//write_file($pathToFile, $maxJobId);

		log_message('debug', 'got data as '. $data. 'got current maxId as' );

	}
}