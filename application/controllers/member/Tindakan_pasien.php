<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Tindakan_pasien extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tindakan_kegiatan');
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->isLoggedIn();   
        if($this->isAdmin()==true){
            redirect('admin/user');
        }  
    }
    public function index($value='')
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']=''; 
        $data['tindakan']=$this->tindakan_kegiatan->datasTindakan();
        if ( empty($this->input->post('min')) || empty($this->input->post('max')) ){ $where['tindakan_tanggal'] = date('Y-m-d');
            $data['min']=date('Y-m-d'); 
            $data['max']=date('Y-m-d');  }
		if (!empty($this->input->post('min'))){ $where['tindakan_tanggal >='] =$this->input->post('min'); $data['min']=$this->input->post('min'); }
		if (!empty($this->input->post('max'))){ $where['tindakan_tanggal <='] =$this->input->post('max');$data['max']=$this->input->post('max');}
		if (!empty($this->input->post('nama'))) { $where['cust_usr_nama like'] = '%%'.$this->input->post('nama').'%%'; $data['nama']=$this->input->post('nama'); }else{ $data['nama']='';}	
		if (!empty($this->input->post('tindakan'))) { $where['a.id'] = $this->input->post('tindakan'); $data['indikator']=$this->input->post('tindakan');}else{$data['indikator']=''; }            
        clearstatcache();
        $data['datas']=$this->tindakan_kegiatan->datasCusTindakan($where); 
        $this->loadViewsMember("member/tindakan_pasien/indexs", $data , NULL);
        
    }
   
    function pageNotFound()
    {
        
        $this->loadViewsMember("404", NULL, NULL);
    }
}

?>