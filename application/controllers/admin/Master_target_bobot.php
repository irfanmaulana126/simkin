<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Master_target_bobot extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn(); 
        if($this->isAdmin()==false){
            redirect('member/dashborad');
        }  
        $this->load->model('indikator_penilaian');
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $data['aktif_menu']='indi'; 
        $data['aktif_menu_sub']='tb'; 
        $data['JenisPosisiKategori'] = $this->indikator_penilaian->datasMasterJabatan();
        $data['JenisPosisi'] = $this->indikator_penilaian->datasMasterUnitKerja();
        $this->loadViewsAdmin("admin/master_target_bobot/modal", $data , NULL);
    }
    public function cari_unit_kerja()
    {
        $data['aktif_menu']='indi'; 
        $data['aktif_menu_sub']='tb'; 
        $jabatan = $this->input->post('jabatan');
        $unit = $this->input->post('sunit');        
        $datas= array('a.id_jabatan' =>$jabatan ,'a.id_unit_kerja' => $unit );
        $data['datas'] = $this->indikator_penilaian->datasDetailIndikatorUnitKerja($datas);
        $this->loadViewsAdmin("admin/master_target_bobot/index", $data , NULL);
    }
    

    function pageNotFound()
    {
        $data['aktif_menu']=''; 
        $data['aktif_menu_sub']='';         
        $this->loadViewsAdmin("404", NULL, NULL);
    }
}

?>