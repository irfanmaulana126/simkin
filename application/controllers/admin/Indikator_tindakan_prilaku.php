<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Indikator_tindakan_prilaku extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('tindakan_kuantitas_model_pegawai','tindakan_perilaku_model'));
        $this->isLoggedIn();   
        if($this->isAdmin()==false){
            redirect('member/dashborad');
        }  
    }
   
    function index()
    {       
            $data['aktif_menu']='indi'; 
            $data['aktif_menu_sub']='per'; 
            $data['datas'] = $this->tindakan_perilaku_model->datasPerilakuPegawai();
            $data['JenisPosisiKategori'] = $this->tindakan_kuantitas_model_pegawai->datasMasterJabatan();
            $data['JenisPosisi'] = $this->tindakan_kuantitas_model_pegawai->datasMasterUnitKerja();
            $this->loadViewsAdmin("admin/perilaku/tindakan_perilaku", $data, NULL);
    }

    function addNew()
    {
                $master = $this->input->post('jabatan');
                $posisi = $this->input->post('unit');
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
                $result = $this->tindakan_perilaku_model->add($userInfo);
                
                redirect('/admin/Indikator_tindakan_prilaku');
        
    }


    function oldEdit($id = NULL)
    {
        $data = $this->tindakan_perilaku_model->getSelect($id);
        echo json_encode($data);
    }
    
    
    function edit($id)
    {
            $master = $this->input->post('jabatan');
            $posisi = $this->input->post('unit');
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
                $result = $this->tindakan_perilaku_model->edit($datas, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('/admin/Indikator_tindakan_prilaku');
    }


    function delete()
    {
            $id = $this->input->post('id');
            $data = array('aktif'=>'n','usr_edit'=>$this->session->userdata('name'), 'updated_at'=>date('Y-m-d H:i:s'));
            
            $result = $this->tindakan_perilaku_model->delete($data, $id);
            
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