<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Pegawai extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('pegawai_model','tindakan_kuantitas_model_pegawai'));
        $this->isLoggedIn();   
        if($this->isAdmin()==false){
            redirect('member/dashborad');
        }  
    }
    
    public function index()
    {
        $data['aktif_menu']=''; 
        $data['aktif_menu_sub']=''; 
        $data['datas'] = $this->pegawai_model->dataspegawais();        
        $data['pegawai'] = $this->pegawai_model->dataspegawai();        
        $data['JenisPosisiKategori'] = $this->tindakan_kuantitas_model_pegawai->datasMasterJabatan();
        $data['JenisPosisi'] = $this->tindakan_kuantitas_model_pegawai->datasMasterUnitKerja();
        $this->loadViewsAdmin("admin/data_pegawai/pegawais", $data, NULL);
    }

    function addNew()
    {
                $jabatan = $this->input->post('jabatan');
                $unit = $this->input->post('unit');
                $id_pegawai = $this->input->post('id_pegawai');
                
                $userInfo = array(
                    'id_jabatan'=>$jabatan, 
                    'id_unit_kerja'=>$unit,
                    'id_pgw'=>$id_pegawai,
                    'aktif'=>'y',
                    'usr_insrt'=>$this->session->userdata('name'),
                    'created_at'=>date('Y-m-d H:i:s')
                );
                $result = $this->pegawai_model->addPegawai($userInfo);
                $userInfo = array('id_unit_kerja'=>$unit);
                $result = $this->pegawai_model->editPegawaihris($userInfo,$id_pegawai);
                
                redirect('/admin/Pegawai');
        
    }


    function oldEdit($id = NULL)
    {
        $data = $this->pegawai_model->getSelect($id);
        echo json_encode($data);
    }
    
    
    function edit($id)
    {

            $jabatan = $this->input->post('jabatan');
            $unit = $this->input->post('unit');
            $id_pegawai = $this->input->post('id_pegawai');
            
            $userInfo = array(
                'id_jabatan'=>$jabatan, 
                'id_unit_kerja'=>$unit,
                'id_pgw'=>$id_pegawai,
                'usr_edit'=>$this->session->userdata('name'),
                'updated_at'=>date('Y-m-d H:i:s')
            );
            $result = $this->pegawai_model->editPegawai($userInfo, $id);
            $userInfo = array('id_unit_kerja'=>$unit);
            $result = $this->pegawai_model->editPegawaihris($userInfo,$id_pegawai);
                
                
                redirect('/admin/Pegawai');
    }


    function delete()
    {
            $id = $this->input->post('id');
            $data = array('aktif'=>'n','usr_edit'=>$this->session->userdata('name'), 'updated_at'=>date('Y-m-d H:i:s'));
            
            $result = $this->pegawai_model->delete($data, $id);
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