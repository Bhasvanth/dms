<?php
/*
 * Author : Bhasvanth
 * Date   : 23 Nov 2014
 * Description : To upload domains to database table "domains" and search the table.
 *
 */

App::uses('AppController', 'Controller');

class DomainsController extends AppController {

	public $uses = array();
	public $helpers = array('Html', 'Form');

	public function index() {
	    //echo "<pre>";print_r($this->data);die();
	    $params = array();
		if ($this->request->is('post')){
		    $params["conditions"] = array();
			if(!empty($this->data["name"])){
		        if($this->data["name_condition"] == "starts-with")
    		        $params["conditions"]["OR"][] = array("Domain.name LIKE" => $this->data["name"]."%");
		        else if($this->data["name_condition"] == "contains")
        		    $params["conditions"]["OR"][] = array("Domain.name LIKE" => "%".$this->data["name"]."%");
		        else if($this->data["name_condition"] == "ends-with")
		            $params["conditions"]["OR"][] = array("Domain.name LIKE" => "%".$this->data["name"].".com");
			}
		    if(isset($this->data["with-hyphens"]) && $this->data["with-hyphens"] == "with-hyphens")
			    $params["conditions"]["OR"][] = array("Domain.name LIKE" => "%-%");
		    if(isset($this->data["with-numbers"]) && $this->data["with-numbers"] == "with-numbers")
			    $params["conditions"]["OR"][] = array("Domain.name REGEXP" => ".*[0-9].*");
		    if(isset($this->data["without"]) && $this->data["without"] == "without"){
			    $params["conditions"]["NOT"][] = array("Domain.name LIKE" => "%-%");
				$params["conditions"]["NOT"][] = array("Domain.name REGEXP" => ".*[0-9].*");
			}
			
			$start_date = "0000-00-00";
			$end_date = date("Y-m-d");
			if(!empty($this->data["start_date"]) && !empty($this->data["end_date"] ))
			    $params["conditions"]  ["Domain.expiry_date BETWEEN ? AND ?"] = array($this->data["start_date"], $this->data["end_date"]);
			else if(empty($this->data["start_date"]) && !empty($this->data["end_date"] ))
			    $params["conditions"] ["Domain.expiry_date BETWEEN ? AND ?"] = array($start_date, $this->data["end_date"]);
			else if(!empty($this->data["start_date"]) && empty($this->data["end_date"] ))
			    $params["conditions"]["Domain.expiry_date BETWEEN ? AND ?"] = array($this->data["start_date"], $end_date);
				
		    if(!empty($this->data["min-length"]) && !empty($this->data["max-length"] ))
			    $params["conditions"]  ["LENGTH(Domain.name) BETWEEN ? AND ?"] = array($this->data["min-length"], $this->data["max-length"]);
			
		}
		
        $this->set('domains', $this->Domain->find('all', $params));
    }
	
	public function search() {
		$path = func_get_args();
	}
	
	public function import(){
	//echo "<pre>";print_r($_FILES);die();
	    if ($this->request->is('post')){//echo "<pre>".$this->data['Domains']['domainsList']['tmp_name'];print_r($this->data);die();
		    $filepath = WWW_ROOT. DS."files/".$this->data['Domains']['domainsList']['name'];
			$filename =  substr($this->data['Domains']['domainsList']['name'], 0, strpos($this->data['Domains']['domainsList']['name'], "."));
			$expiry_date =  date("Y-m-d", strtotime($filename));
		    if (move_uploaded_file($this->data['Domains']['domainsList']['tmp_name'],$filepath)) {
                $fp = fopen($filepath, "r");
				$success = "File has been uploaded successfully.<br>";
				$failure = "";
				while(!feof($fp)){
                    $line = fgets($fp);
					$data = array();
					$data['Domain']['name'] = $line;
					$data['Domain']['expiry_date'] = $expiry_date;
                    $this->Domain->create();
                    if (!$this->Domain->save($data)) {
                        $failure = "Unable to upload $line<br>";
					}
                }
                fclose($fp);
            $this->Session->setFlash($success);
            $this->Session->setFlash($failure);
            /* redirect */
            $this->redirect(array('action' => 'index'));
          } else {
            /* save message to session */
            $this->Session->setFlash('There was a problem uploading file. Please try again.');
          }
		}
	}
}
