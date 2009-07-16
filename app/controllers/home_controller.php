<?php
class HomeController extends AppController {
	var $name = 'Home';
	var $uses = array();
	
	function index() {
		
		//detect mobile phone
		if(
			!(stripos($_SERVER['HTTP_USER_AGENT'], 'iphone') === FALSE) ||		//is iphone or
			!(stripos($_SERVER['HTTP_USER_AGENT'], 'blackberry') === FALSE)		//is blackberry
		)
			$this->redirect('/m/lines/security/');
			
		//continue as normal
		
		$this->pageTitle = 'FlyOnTime.us';
		$this->layout = 'blank';
		
		$this->Enum =& ClassRegistry::init('Enum');
		$this->Ontime =& ClassRegistry::init('Ontime');
		
		$airlines_used = $this->Ontime->find('all',
			array(
				'fields' => array(
					'carrier'
				),
				'group' => array(
					'carrier'
				)
			)
		);
		
		$airlines_used_arr = array();
		
		foreach($airlines_used as $airline)
		{
			$airlines_used_arr[] = $airline['Ontime']['carrier'];
		}
		
		$airlines = $this->Enum->find('all',
			array(
				'conditions' => array(
					'Enum.category' => 'UNIQUE_CARRIERS',
					'Enum.code' => $airlines_used_arr
				),
				'order' => array(
					'Enum.description'
				)
			)
		);
		
		$this->set('Airlines', $airlines);
	}
	
}
?>