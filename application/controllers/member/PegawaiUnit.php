<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class PegawaiUnit extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn(); 
        $this->load->model(array('member/pegawai_unit','member/dashboard_model'));
        $this->load->helper(array('form', 'url'));
        if($this->isAdmin()==true){
            redirect('member/user');
        }
        if($this->session->userdata('tipe')=='0'){
            redirect('member/tupoksi');
        }  
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']=''; 
        
        $data['pegawai']= $this->pegawai_unit->AllPegawai($this->session->userdata('jabatan'));
        // print_r($data['Pegawai']);die();
        $this->loadViewsMember("member/pegawai/index", $data , NULL);
    }
    public function pegawaiDetail($usr_id,$unit,$dates)
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']='';
        if($dates == NULL){
            $dates = date('Y-m');
        }
        // print_r($dates);die();
        $data=$this->pegawai_unit->datasDetailAllTupoksi($usr_id,$unit,$dates); 
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
        $data['usr_id']=$usr_id;
        $data['unit']=$unit;
        $data['pegawai']=$this->pegawai_unit->datasPegawai($usr_id);
        $this->loadViewsMember("member/pegawai/detail", $data , NULL);
        
    }
    public function oldEdit($id = NULL)
    {
        $data = $this->dashboard_model->getSelectKegiatan($id);
        echo json_encode($data);
     }
     function addNew()
    {
                $usr_id = $this->input->post('usr_id');
                $indikator = $this->input->post('indikator');
                $tupoksi = $this->input->post('tupoksi');
                $indikator_keterangan = $this->input->post('indikator_keterangan');
                $definisi = $this->input->post('definisi');
                $nilai = $this->input->post('nilai');
                $dates = $this->input->post('date');
                $unit = $this->input->post('unit');
                switch (true) {
                    case ($tupoksi == '1' || $tupoksi == '2' || $tupoksi == '3' ):
                        $date = $this->dashboard_model->getBoborTarget(date('Y-m-d'),$indikator);
                            $userInfo = array(  
                                'nilai'=>$nilai,
                                'id_master_indikator'=>$indikator,
                                'aktif'=>'Y',
                                'target'=>$date->target,
                                'bobot'=>$date->bobot,
                                'usr_id'=>$usr_id,
                                'created_at'=>date('Y-m-d H:i:s'),
                                'created'=>$dates,
                                'usr_insrt'=>$this->session->userdata ('name')
                            );
                            $result = $this->dashboard_model->add($userInfo,'input_kegitan_tupoksi');
                        break;
                    case ($tupoksi=='4'):
                            $inputkegiatan = array(  
                                'indikator'=>$indikator_keterangan,
                                'difinisi'=>$definisi,
                                'aktif'=>'Y',
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name'),
                                'jns_input'=>'3',
                                'id_unit_kerja'=>$unit,
                                'indikator_tupoksi'=>'4'
                            );
                            $this->pegawai_unit->addTupoksiKegitan($usr_id,$dates,$inputkegiatan,'master_indikator');
                        break;
                    default:
                redirect('/member/PegawaiUnit/pegawaiDetail/'.$usr_id.'/'.$unit.'/'.$dates.'');
                        break;
                }
                
                
                redirect('/member/PegawaiUnit/pegawaiDetail/'.$usr_id.'/'.$unit.'/'.$dates.'');
        
    }
    function edit($id)
    {
        $usr_id = $this->input->post('usr_id');
        $nilai = $this->input->post('nilai');
        $dates = $this->input->post('date');
        $unit = $this->input->post('unit');
                $userInfo = array(  
                    'nilai'=>$nilai,
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'usr_edit'=>$this->session->userdata ('name')
                );
                $result = $this->dashboard_model->update($userInfo,$id,'input_kegitan_tupoksi');
                redirect('/member/PegawaiUnit/pegawaiDetail/'.$usr_id.'/'.$unit.'/'.$dates.'');
    }
    function pageNotFound()
    {
        $data['aktif_menu']=''; 
        $data['aktif_menu_sub']='';         
        $this->loadViewsMember("404", NULL, NULL);
    }
    function delete()
    { 
        $id_i = $this->input->post('id_input');
        $id_m = $this->input->post('id_master_indikator');
        
        $userInfo = array(  
            'aktif'=>'N'
        );
        $result = $this->dashboard_model->update($userInfo,$id_m,'master_indikator');
        $result = $this->dashboard_model->update($userInfo,$id_i,'input_kegitan_tupoksi');
                

    }
}

?>