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
        $this->set('domains', $this->Domain->find('all'));
    }
	
	public function search() {
		$path = func_get_args();
	}
	
	public function import(){
	//echo "<pre>";print_r($_FILES);die();
	    if ($this->request->is('post')){//echo "<pre>".$this->data['Domains']['domainsList']['tmp_name'];print_r($this->data);die();
		    $filename = WWW_ROOT. DS."files/".$this->data['Domains']['domainsList']['name'];
			$expiryDate =  substr($this->data['Domains']['domainsList']['name'], 0, strpos($this->data['Domains']['domainsList']['name'], "."));
			echo date("Y-m-d", strtotime($expiryDate));die();
		    if (move_uploaded_file($this->data['Domains']['domainsList']['tmp_name'],$filename)) {
                $fp = fopen($filename, "r");
				while(!feof($fp)){
                    echo $line = fgets($fp);
                }
                fclose($fp);
            $this->Session->setFlash('File uploaded successfuly.');
            /* redirect */
            $this->redirect(array('action' => 'index'));
          } else {
            /* save message to session */
            $this->Session->setFlash('There was a problem uploading file. Please try again.');
          }
		}
	}
}
