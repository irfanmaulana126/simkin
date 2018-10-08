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
        $this->isLoggedIn();   
        if($this->isAdmin()==true){
            redirect('admin/user');
        }  
    }
    public function index()
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']=''; 
        $data['datas']=$this->tindakan_kegiatan->datasCusTindakan(); 
        $data['tindakan']=$this->tindakan_kegiatan->datasTindakan(); 
        $this->loadViewsMember("member/tindakan_pasien/indexs", $data , NULL);
        
    }
   
    function pageNotFound()
    {
        
        $this->loadViewsMember("404", NULL, NULL);
    }
}

?>