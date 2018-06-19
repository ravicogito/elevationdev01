<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerPhotosclone extends CI_Controller {

	private $data;
	private $theme;
	public $elements;
	public $elements_data;
	
	 function __construct(){
		
		parent::__construct();
		if($this->session->userdata('customer_id') =='') {
				redirect(base_url());
			}
		
		$this->elements 							= array();
		$this->elements_data 						= array();
		$this->data 								= array();	

		$this->load->model(array('Model_customerPhotos'));
		$this->load->model(array('Model_customerPhotosclone'));
		$this->load->model(array('model_login','model_home'));
		$this->load->library('pagination');
		$this->data['themePath'] 					= $this->config->item('theme');					
		$this->layout->setLayout('photo_layout');
	}
	public function customerEventPhotoList( $location_id ='', $limit = '' ) {
		if($location_id !='' && $limit !=''){
		$this->data['contentTitle']				= 'Customer Event Photo List';
		$this->data['contentKeywords']			= '';		
		
		$events_result							=	array();
		$eventAllImages	=   array();
		$photographer   =   array(); 
		if(!empty($location_id)){
			$this->data['location_id']	= $location_id;	
		}
		$customer_id 				= $this->session->userdata('customer_id'); 
		if(!empty($customer_id)){
			$this->data['customer_id']	= $customer_id;
		}
		$userDetails									= $this->Model_customerPhotos->getUserDetails($customer_id);
		if(!empty($userDetails)){
			$this->data['userDetails']					= $userDetails;
			
			//Event Location and cutomer wise
			$eventDetails								= $this->Model_customerPhotos->getEventByLocationID($userDetails['location_id'],$limit);
			//$eventDetails								= $this->Model_customerPhotos->getEventByLocationID($userDetails['location_id'],$customer_id, $limit);
			//pr($eventDetails);
			//if exists
			$counteventDetails							= $this->Model_customerPhotos->countEventByLocationID($userDetails['location_id']);
			
			$this->data['eventDetails']					= $eventDetails;
			if(!empty($eventDetails)){
			foreach($eventDetails as $key => $events) {
				$eventImages						   	= $this->Model_customerPhotos->getImagesByEventID($events['event_id'],$customer_id);
				$events_result[$events['event_id']]	   	= $eventImages;
				
				
				$eventphotographername					= $this->Model_customerPhotos->getPhotographer($events['photographer_id']);
				$photographer[$events['photographer_id']]	  	= $eventphotographername;
				
				
				$eventAllImages						= $this->Model_customerPhotos->getAllImages($events['event_id'],$customer_id);
				if(!empty($eventAllImages)){
				$eventsAllImages[$events['event_id']]	= $eventAllImages;
				//pr($eventsAllImages,0);
				}
			}
		}
		
		
		}
		//$this->data['allcountlist']		    			= $counteventDetails;
		$this->data['allcountlist']		    			= '2';
		$this->data['total_photo']		    			= $events_result;
		if(!empty($eventAllImages)){
		$this->data['alleventsimages']					= $eventsAllImages;
		}
		$this->data['photographer']						= $photographer;
		
		$this->layout->view('templates/Customer_Photos/event_customer_photos_list',$this->data);	
		}
		else{
			
			redirect(base_url());
		}
			
			
			
	}
	/*function Loadmorelocation(){
		$limit 							= $this->input->post('limit');
		$this->data['contentTitle']		= 'Elevation';
		$this->data['contentKeywords']	= '';		
		
		$this->data['result']	= $this->model_home->loadlocationWithLimit($limit);	
		//echo "dnhghj";print_r($this->data['result']) ;exit;
		if(!empty($this->data['result'])){
		foreach($this->data['result'] as $loc_list){
				
			$api_2 = 'http://api.openweathermap.org/data/2.5/weather?q='.$loc_list['location_name'].'&APPID=7eb4e09cd60880833d7ea97a686db4f6';
			error_reporting(E_ERROR | E_PARSE);
			$json = file_get_contents($api_2);
			if($json === FALSE){
				
			$weather[$loc_list['location_id']]	='NA';
				
			}
			else{
			 $data 								= json_decode($json,true);
			 $tmp_weather						= $data['main']['temp'];
			 $weather[$loc_list['location_id']]	= $tmp_weather - 273.15;
			 		
			}
		}
		$this->data['weather_info']	=	$weather;
		}
		else{
			$this->data['result']	='';
		}
		//print_r($this->data['location_info']);	
		$this->load->view('templates/Home/ajax_home_load_more',$this->data);
	}*/
	
	public function event_details($event_id) {
		$this->layout->view('templates/Customer_Photos/event_customer_photo_details',$this->data);
	}

    public function photodetails($location_id,$event_id) {
		$this->layout->setLayout('details_layout');
		
		
		$photographer   =   array(); 
		$this->data['contentTitle']			= 'Event Photo Details';
		$this->data['contentKeywords']		= '';	
		
		$customer_id 						= $this->session->userdata('customer_id'); 
		$location						    = $this->Model_customerPhotos->getLocation($location_id);
		$this->data['locationname']			= $location['location_name'];
		$this->data['locationid']			= $location['location_id'];
		
		
		$resort								= $this->Model_customerPhotosclone->getResort($customer_id,$location_id);
		$this->data['resortname']			= $resort['resort_name'];
		$resort_id                          = $resort['resort_id'];   
		
		$eventdetails						= $this->Model_customerPhotosclone->getEvents($location_id,$resort_id,$event_id);
		$this->data['event_date']			= $eventdetails['event_date'];
		$this->data['event_name']			= $eventdetails['event_name'];
		$this->data['event_price']			= $eventdetails['event_price'];
		$this->data['event_id']				= $eventdetails['event_id'];
		$config 							= array();
		$config['total_rows'] 				= $this->Model_customerPhotosclone->getAllCustomerImages($event_id,$customer_id);
        $this->data['total_count'] 			= $config['total_rows'];
		$config['base_url'] = base_url() . 'CustomerPhotos/photodetails/'.$location_id.'/'.$event_id;
		$config["per_page"] = 6;
        $config["uri_segment"] = 5;
		$this->pagination->initialize($config);

        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

		$eventAllImages						= $this->Model_customerPhotosclone->getAllDetailsImages($event_id,$customer_id,$config["per_page"], $page);
		$this->data['eventAllImages']		= $eventAllImages;
		
		$this->data['links'] = $this->pagination->create_links();
				
           
			if(!empty($eventAllImages))
				{	
					foreach($eventAllImages as $key => $eventAllImage)
						{
							$eventphotographername			= $this->Model_customerPhotos->getPhotographerdtls($eventAllImage['photographer_id']);

						}
					$this->data['photographer']			    = $eventphotographername;	
				}
				else
				{
					
				}
		
		//$eventAllImages						= $this->Model_customerPhotos->getAllDetailsImages($event_id,$customer_id);
		//$this->data['eventAllImages']		= $eventAllImages;
		
        		
		
		$this->layout->view('templates/Customer_Photos/event_customer_photo_details',$this->data);

	}
	
	
	public function photodetailsTemp() {
		//$location_id,$event_id
		$email = $this->uri->segment(3);
		
		//echo $this->uri->segment(3);
		//exit;
		
		if(isset($email) && !empty($email)){
			
			//echo base64_decode($email);
			//exit;
			
			//echo urldecode($email);
			//exit;
		
			$result = $this->model_login->getUserCredentials(urldecode($email));
			//print_r($result);
			//exit;
			$useremail = $result->customer_email;
			$password = $result->customer_password;
			$location_id = $result->location_id;
			
			//echo $useremail;
			//echo $password;
			//echo $location_id;
			//exit;
			
			
			
			
			
			if(!empty($useremail) && !empty($password)){
		
						
				$userDetails = $this->model_login->chkUserAuth($useremail,$password);
				//print_r($userDetails);
				//exit;
				if($userDetails) {
					$this->session->set_userdata('customer_id', $userDetails['customer_id']);
					//$this->nativesession->set( 'user_id', $userDetails['user_id'] );
					$this->session->set_userdata('customer_ref_id', $userDetails['customer_ref_id']);
					$this->session->set_userdata('customer_email', $userDetails['customer_email']);
					$this->session->set_userdata('customer_mobile', $userDetails['customer_mobile']);
					$this->session->set_userdata('location_id', $userDetails['location_id']);
					//echo $result = '1';
					$userID									= $this->session->userdata('user_id');
					
					//Get Event
					
					$eventDetails								= $this->Model_customerPhotos->getEventByLocationID($location_id,5);
					
					foreach($eventDetails as $events){
						
						$event_id = $events['event_id'];
					}

					
					$this->photodetails($location_id,$event_id);
					
				}
			} else{redirect(base_url());}
		} else{
			
			redirect(base_url());
		}
	}
}

/* End of file CustomerPhotos.php */
/* Location: ./application/controllers/CustomerPhotos.php */