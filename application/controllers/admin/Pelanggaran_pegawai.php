<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Pelanggaran_pegawai extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('pelanggaran_pegawai_model');
        $this->isLoggedIn();   
        if($this->isAdmin()==false){
            redirect('member/user');
        }  
    }
    public function index()
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']='';
        $data['pegawai'] = $this->pelanggaran_pegawai_model->dataspegawai(); 
        $this->loadViewsAdmin("admin/pelanggaran_pegawai/indexs", $data , NULL);
        
    }
    function pageNotFound()
    {
        
        $this->loadViewsAdmin("404", NULL, NULL);
    }
}

?>