<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Banner extends CI_Controller {
	public function __construct(){
			parent::__construct();
			$this->load->model('Bannermodel');
			$this->load->model('Pagemodel');
	}
	public function index(){
			$data['banner_lists']	= $this->Bannermodel->listBanners();		
			
			$this->load->view("common/header");
			$this->load->view("common/sidebar");
			$this->load->view("theme-v1/banner_list", $data);
			$this->load->view("common/footer-inner");
	}
	public function addBanner(){
		$data			= array();
		$banner_type	= $this->input->post('banner_type');
		if($_POST)
		{
			$data['banner_exist']	= $this->Bannermodel->getBannersByBannertype($banner_type);
			if($data['banner_exist'] == '0'){
			
			if (!$this->upload->do_upload('banner_img'))
			{
					$error = array('error' => $this->upload->display_errors());
			}
			else
                {
					$imageDetailArray = $this->upload->data();
					$imageDetailArray['file_name'];
					$bannerImage =  $imageDetailArray['file_name'];
						//echo "success!";
                }
				
				$page_data	= $this->Pagemodel->allpageList();
				if(!empty($page_data)){
					foreach($page_data as $list){
							$seo_title	=	$list['seo_title'];
						}
					}
				}
				$data =  array(
						'seo_title'							=>$seo_title,
			$mess = $this->Bannermodel->addBanner($data);	
			if($mess){
						$this->session->set_flashdata("sucessPageMessage","Banner Added Successfully!");
						redirect(base_url()."Banner/addBanner/");
					}
			}
			else{
				$this->session->set_flashdata("errorPageMessage",'Please select any other page.It is already exist.' );
				redirect(base_url()."Banner/addBanner/");
			}
		}
		else{
				$this->load->view("common/header");
				$this->load->view("common/sidebar");
				$this->load->view('theme-v1/add_banner', $data);
				$this->load->view("common/footer-inner");
			}
	}
	public function editBanner($id=''){
		$id = $this->uri->segment(3);
		$page_list		= $this->Bannermodel->listPage();
		if(!empty($page_list)){
			$data['page_list']	= $page_list;
		}
		$data['banner_edit'] = $this->Bannermodel->Banneredit($id);
		//print_r($data['slider_edit']);

		$this->load->view("common/header");

		$this->load->view("common/sidebar");

		$this->load->view("theme-v1/edit_banner", $data);

		$this->load->view("common/footer-inner");
	}
	public function updateBanner(){
		$banner_id = $this->input->post('banner_id');

		$img_file = $this->input->post('img_file');

		$edit_file = $_FILES['banner_img']['name'];

				
			else {
						
						'banner_type'						=>$this->input->post('banner_type'),
						'banner_image'						=>$banimg,
						'banner_title'						=>$this->input->post('ptitle'),
						'banner_content'					=>$this->input->post('editor1'),						
						'status'							=>'1'
					);
					if($mess==1){
						$this->session->set_flashdata("sucessPageMessage","Banner Edit Successfully!");

						redirect(base_url()."Banner/editBanner/".$banner_id);
					} 
	}
	public function deleteBanner($id=''){
		$id = $this->uri->segment(3);
		$banner=$this->Bannermodel->getBannerById($id);
		$img_file=$banner->banner_image;
		if($img_file)
		{
			unlink('../uploads/bannerImg/'.$img_file);
		}
		$del=$this->Bannermodel->deleteBannerbyId($id);
		if($del==1)
		{
			$this->session->set_flashdata("sucessPageMessage","Banner Deleted Successfully!");
			redirect(base_url()."Banner/");
		} 
	}
}
