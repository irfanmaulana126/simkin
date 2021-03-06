<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */

class Master_indikator extends BaseController
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
        $data['aktif_menu_sub']='indikator'; 
        $data['datas'] = $this->indikator_penilaian->datasIndikator();
        $data['JenisPosisiKategori'] = $this->indikator_penilaian->datasMasterJabatan();
        $data['JenisPosisi'] = $this->indikator_penilaian->datasMasterUnitKerja();
        $data['Indikator'] = $this->indikator_penilaian->datasMasterIndikatorTupoksi();
        $this->loadViewsAdmin("admin/master_indikator/index", $data , NULL);
    }
    
    function addNew()
    {
        $table = 'master_indikator';
                $jabatan = $this->input->post('jabatan');
                $unit = $this->input->post('unit');
                $indikator_tupoksi = $this->input->post('indikator_tupoksi');
                $indikator = $this->input->post('indikator');
                $difinisi = $this->input->post('difinisi');
                $input = $this->input->post('input');
                
                $userInfo = array(  'id_jabatan'=>$jabatan, 
                                    'id_unit_kerja'=>$unit,
                                    'indikator_tupoksi'=>$indikator_tupoksi,
                                    'aktif'=>'Y', 
                                    'indikator'=>$indikator, 
                                    'difinisi'=>$difinisi, 
                                    'jns_input'=>$input, 
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'usr_insrt'=>$this->session->userdata ('name')
                                );
                $result = $this->indikator_penilaian->add($userInfo,$table);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New indikator created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'indikator creation failed');
                }
                
                redirect('/admin/Master_indikator');
        
    }


    function oldEdit($id = NULL)
    {
        $table = 'simkin.master_indikator';
        $data = $this->indikator_penilaian->getSelect($id,$table);
        echo json_encode($data);
    }
    
    
    function edit($id)
    {
        $table = 'master_indikator';
        $jabatan = $this->input->post('jabatan');
        $unit = $this->input->post('unit');
        $indikator_tupoksi = $this->input->post('indikator_tupoksi');
        $indikator = $this->input->post('indikator');
        $difinisi = $this->input->post('difinisi');
        $input = $this->input->post('input');
            $datas = array(  
                'id_jabatan'=>$jabatan, 
                'id_unit_kerja'=>$unit,
                'indikator_tupoksi'=>$indikator_tupoksi,
                'aktif'=>'Y', 
                'indikator'=>$indikator, 
                'difinisi'=>$difinisi, 
                'jns_input'=>$input, 
                'updated_at'=>date('Y-m-d H:i:s'),
                'usr_edit'=>$this->session->userdata ('name')
                    );
                $result = $this->indikator_penilaian->edit($datas, $id,$table);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('/admin/Master_indikator');
    }
    function detail($id)
    {
        $data['aktif_menu']='indi'; 
        $data['aktif_menu_sub']='indikator'; 
        $data['datas'] = $this->indikator_penilaian->datasTargetBobot($id);
        $data['id'] = $id;
        $data['detail'] = $this->indikator_penilaian->getDetail($id);
        $this->loadViewsAdmin("admin/master_indikator/detail", $data , NULL);
    }
    function detail_js($id)
    {
        $data = $this->indikator_penilaian->getDetail($id);
        echo json_encode($data);
    }
    function TargetBobot()
    {
        $table = 'target_bobot';
        $id = $this->input->post('id');
        $tgl_awal = $this->input->post('tgl_awal');
        $tgl_akhir = $this->input->post('tgl_akhir');
        $bobot = $this->input->post('bobot');
        $target = $this->input->post('target');
            $datas = array(  
                'id_m_indikator'=>$id, 
                'tgl_awal'=>$tgl_awal,
                'tgl_akhir'=>$tgl_akhir,
                'aktif'=>'Y', 
                'bobot'=>$bobot, 
                'target'=>$target, 
                'created_at'=>date('Y-m-d H:i:s'),
                'usr_create'=>$this->session->userdata ('name')
                    );
                $result = $this->indikator_penilaian->add($datas,$table);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'Target create successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                if(empty($this->input->post('detail'))){
                    redirect('/admin/Master_indikator');
                }else{
                    redirect('/admin/Master_indikator/detail/'.$id.'');
                }
    }


    function delete()
    {
            $id = $this->input->post('id');
            $table = 'master_indikator';
            $data = array('aktif'=>'N','usr_edit'=>$this->session->userdata('name'), 'updated_at'=>date('Y-m-d H:i:s'));
            
            $result = $this->indikator_penilaian->delete($data, $id, $table);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
    }
    function delete_target()
    {
            $id = $this->input->post('id');
            $table = 'target_bobot';
            $data = array('aktif'=>'N','usr_edit'=>$this->session->userdata('name'), 'updated_at'=>date('Y-m-d H:i:s'));
            
            $result = $this->indikator_penilaian->delete($data, $id, $table);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
    }
    function pageNotFound()
    {
        $data['aktif_menu']=''; 
        $data['aktif_menu_sub']='';         
        $this->loadViewsAdmin("404", NULL, NULL);
    }
}

?>