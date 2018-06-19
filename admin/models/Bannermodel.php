<?php
class Bannermodel extends CI_Model {
    function __construct() {
       parent::__construct();
    }
    function listBanners(){
        $this->db->select('*');
        $this->db->from('el_banner');
        $query = $this->db->get();
        $num = $query->num_rows();
        if($num>0){
            //print_r($query->row_array()); exit;
            //echo "<pre>";
            $result = $query->result();
			//print_r($result);exit;
            return $result;
        }else{
            return 0;
        }
    }
    function addBanner($data) {
		if(!empty($data)){              
    }
	function Banneredit($id = 0){
        if(isset($id) && !empty($id) && $id!=0){
        $this->db->select('*');
        $this->db->from('el_banner');
        $this->db->where('banner_id',$id);
        $query = $this->db->get();
        $num = $query->num_rows();
        if($num>0){
            $result = $query->row_array();
            return $result;
        }else{
            return 0;
        }
        }
    }
    function updateBannerbyId($pid, $data) {
            if($data!=''){
                $this->db->where('banner_id', $pid);
                $this->db->update('el_banner', $data);
                return 1;
            } else{
                return 0;
            }
    }
	function getBannerById($id){
			$this->db->select('*');
			$this->db->from('el_banner');
			$this->db->where('banner_id', $id);
			$query = $this->db->get();
			$num = $query->num_rows();
			if($num>0){

				$result = $query->row();

				return $result;
			}else{
				return 0;
			}

    }
    function deleteBannerbyId($pid){
        if(isset($pid) && !empty($pid)){
            $this->db->where('banner_id', $pid);
			$this->db->update('el_banner', $data); 
            return 1;
        } else{
                return 0;
        }
    }
}