<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Tupoksi extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tupoksi_model');
        $this->isLoggedIn();   
        $this->load->library('tcpdf/tcpdf');
        if($this->isAdmin()==true){
            redirect('admin/user');
        }  
    }
    public function index()
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']='';
        $date = $this->input->post('table_search'); 
        if($date == NULL){
            $dates = date('Y-m');
        }else{
            $dates = $date;
        }
        // print_r($dates);die();
        $data['Kuantitas']=$this->tupoksi_model->datasTupoksiKuantitasPegawai($dates); 
        $data['Kualitas']=$this->tupoksi_model->datasTupoksiKualitas($dates); 
        $data['Perilaku']=$this->tupoksi_model->datasTupoksiPerilaku($dates); 
        $data['dates']=$dates;
        $this->loadViewsMember("member/tupoksi/indexs", $data , NULL);
        
    }
    public function cetak($dates)
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']='';
        $date = $this->input->post('table_search'); 
        // print_r($dates);die();
        $data['Kuantitas']=$this->tupoksi_model->datasTupoksiKuantitasPegawai($dates); 
        $data['Kualitas']=$this->tupoksi_model->datasTupoksiKualitas($dates); 
        $data['Perilaku']=$this->tupoksi_model->datasTupoksiPerilaku($dates); 
        $data['dates']=$dates;
        $this->loadViewsMember("member/tupoksi/cetak_pdf", $data , NULL);
        
    }
    public function cetak_detail_tupoksi($tupoksi,$dates)
    {
        $data['indikator']=$this->tupoksi_model->datasDetailTupoksiKuantitasPegawai($tupoksi,$dates);
        $this->loadViewsMember("member/tupoksi/cetak_pdf_tupoksi", $data , NULL);  
    }
    public function cetak_detail_all($dates)
    {
        $data['indikator']=$this->tupoksi_model->datasDetailAllTupoksiKuantitasPegawai($dates); 
        $this->loadViewsMember("member/tupoksi/cetak_pdf_all", $data , NULL);  
    }
    function pageNotFound()
    {
        
        $this->loadViewsMember("404", NULL, NULL);
    }
}

?>