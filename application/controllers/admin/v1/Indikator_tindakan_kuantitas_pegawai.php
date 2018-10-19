<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Indikator_tindakan_kuantitas_pegawai extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('tindakan_kuantitas_model_pegawai');
        $this->isLoggedIn();   
        if($this->isAdmin()==false){
            redirect('member/dashborad');
        }  
    }
   
    function index()
    {       
            $data['aktif_menu']='indi'; 
            $data['aktif_menu_sub']='ku_peg'; 
            $data['datas'] = $this->tindakan_kuantitas_model_pegawai->datasKuantitasPegawai();
            $data['JenisPosisiKategori'] = $this->tindakan_kuantitas_model_pegawai->datasMasterJabatan();
            $data['JenisPosisi'] = $this->tindakan_kuantitas_model_pegawai->datasMasterUnitKerja();
            $this->loadViewsAdmin("admin/tindakan_kuantitas_pegawai/tindakans", $data, NULL);
    }

    function addNew()
    {
                $master = $this->input->post('master');
                $posisi = $this->input->post('posisi');
                $indikator = $this->input->post('indikator');
                $nama_posisi = $this->input->post('nama_posisi');
                $target = $this->input->post('target');
                $bobot = $this->input->post('bobot');
                $difinisi = $this->input->post('difinisi');
                
                $userInfo = array(  'id_jenis_pos'=>$master, 
                                    'id_pos'=>$posisi,
                                    'indikator'=>$indikator,
                                    'target'=>$target, 
                                    'bobot'=>$bobot, 
                                    'aktif'=>'Y', 
                                    'difinisi_ops'=>$difinisi, 
                                    'nama_pos'=>$nama_posisi, 
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'usr_insrt'=>$this->session->userdata ('name')
                                );
                $result = $this->tindakan_kuantitas_model_pegawai->add($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('/admin/Indikator_tindakan_kuantitas_pegawai');
        
    }


    function oldEdit($id = NULL)
    {
        $data = $this->tindakan_kuantitas_model_pegawai->getSelect($id);
        echo json_encode($data);
    }
    
    
    function edit($id)
    {
            $master = $this->input->post('master');
            $posisi = $this->input->post('posisi');
            $indikator = $this->input->post('indikator');
            $nama_posisi = $this->input->post('nama_posisi');
            $target = $this->input->post('target');
            $bobot = $this->input->post('bobot');
            $difinisi = $this->input->post('difinisi');
            $datas = array(  
                        'id_jenis_pos'=>$master, 
                        'id_pos'=>$posisi,
                        'indikator'=>$indikator,
                        'target'=>$target, 
                        'bobot'=>$bobot, 
                        'aktif'=>'Y', 
                        'difinisi_ops'=>$difinisi, 
                        'nama_pos'=>$nama_posisi, 
                        'updated_at'=>date('Y-m-d H:i:s'),
                        'usr_edit'=>$this->session->userdata ('name')
                    );
                $result = $this->tindakan_kuantitas_model_pegawai->edit($datas, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('/admin/Indikator_tindakan_kuantitas_pegawai');
    }


    function delete()
    {
            $id = $this->input->post('id');
            $data = array('aktif'=>'n','usr_edit'=>$this->session->userdata('name'), 'updated_at'=>date('Y-m-d H:i:s'));
            
            $result = $this->tindakan_kuantitas_model_pegawai->delete($data, $id);
            
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