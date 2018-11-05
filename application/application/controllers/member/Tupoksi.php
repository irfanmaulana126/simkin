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
        $this->load->model(array('member/tupoksi_model','member/pegawai_unit'));
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
        $data=$this->tupoksi_model->datasDetailAllTupoksi($dates); 
        // print_r($data);die();        
        $kuantitas=[];
        $kualitas=[];
        $perilaku=[];
        $tambahan=[];
        foreach ($data as $key) {
            switch ($key->indikator_tupoksi) {
                case '1':
                    $kuantitas['Kuantitas'][] = $key;
                    break;
                case '2':
                    $kualitas['Kualitas'][] = $key;
                    break;
                case '3':
                    $perilaku['Perilaku'][] = $key;
                    break;
                case '4':
                    $dats = explode('-',$key->created_at);
                    $datetupoksi=$dats[0].'-'.$dats[1];
                    if($dates==$datetupoksi){
                        $tambahan['Tambahan'][] = $key;
                    }else{
                        $tambahan=[];
                    }
                    break;
            }
        }
        $data['Kuantitas']=$kuantitas;
        $data['Kualitas']=$kualitas; 
        $data['Perilaku']=$perilaku; 
        $data['Tambahan']=$tambahan; 
        $data['dates']=$dates;
        $this->loadViewsMember("member/tupoksi/indexs", $data , NULL);
        
    }
    public function cetak($dates)
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']='';
        $date = $this->input->post('table_search'); 
        // print_r($dates);die();
        // print_r($dates);die();
        $data=$this->tupoksi_model->datasDetailAllTupoksi($dates); 
        // print_r($data);die();        
        $kuantitas=[];
        $kualitas=[];
        $perilaku=[];
        $tambahan=[];
        foreach ($data as $key) {
            switch ($key->indikator_tupoksi) {
                case '1':
                    $kuantitas['Kuantitas'][] = $key;
                    break;
                case '2':
                    $kualitas['Kualitas'][] = $key;
                    break;
                case '3':
                    $perilaku['Perilaku'][] = $key;
                    break;
                case '4':
                    $dats = explode('-',$key->created_at);
                    $datetupoksi=$dats[0].'-'.$dats[1];
                    if($dates==$datetupoksi){
                        $tambahan['Tambahan'][] = $key;
                    }else{
                        $tambahan=[];
                    }
                    break;
            }
        }
        $data['Kuantitas']=$kuantitas;
        $data['Kualitas']=$kualitas; 
        $data['Perilaku']=$perilaku; 
        $data['Tambahan']=$tambahan; 
        $data['dates']=$dates;
        $this->loadViewsMember("member/tupoksi/cetak_pdf", $data , NULL);
        
    }
    public function cetak_detail_tupoksi_folio($usr_id,$tupoksi,$dates,$unit_kerja)
    {
        $data['indikator']=$this->tupoksi_model->datasDetailTupoksiFolio($usr_id,$tupoksi,$dates,$unit_kerja);
        $data['dates']=$dates;
        $data['pegawai']=$this->pegawai_unit->datasPegawai($usr_id);
        $this->loadViewsMember("member/tupoksi/cetak_pdf_tupoksi", $data , NULL);  
    }
    public function cetak_detail_tupoksi_tindakan($usr_id,$tupoksi,$dates,$unit_kerja)
    {
        $data['indikator']=$this->tupoksi_model->datasDetailTupoksiTindakan($usr_id,$tupoksi,$dates,$unit_kerja);
        $data['dates']=$dates;
        $data['pegawai']=$this->pegawai_unit->datasPegawai($usr_id);
        $this->loadViewsMember("member/tupoksi/cetak_pdf_tupoksi", $data , NULL);  
    }
    public function cetak_detail_all($dates)
    {
        $data['indikator']=$this->tupoksi_model->datasDetailAllTupoksiTindakanPoli($dates); 
        $data['dates']=$dates;
        $this->loadViewsMember("member/tupoksi/cetak_pdf_all", $data , NULL);  
    }
    function pageNotFound()
    {
        
        $this->loadViewsMember("404", NULL, NULL);
    }
}

?>