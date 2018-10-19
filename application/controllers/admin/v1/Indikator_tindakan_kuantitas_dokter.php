<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Indikator_tindakan_kuantitas_dokter extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('tindakan_kuantitas_model_dokter','tindakan_kuantitas_model_pegawai'));
        $this->isLoggedIn();   
        if($this->isAdmin()==false){
            redirect('member/dashborad');
        }  
    }
   
    function index()
    {   
            $data['aktif_menu']='indi'; 
            $data['aktif_menu_sub']='ku_dok'; 
            $data['indikator'] = $this->tindakan_kuantitas_model_dokter->datasKuantitasDokter();
            $data['JenisPosisiKategori'] = $this->tindakan_kuantitas_model_pegawai->datasMasterJabatan();
            $data['JenisPosisi'] = $this->tindakan_kuantitas_model_pegawai->datasMasterUnitKerja();
            $data['KategoriHeaderInstalasi'] = $this->tindakan_kuantitas_model_dokter->datasKategoriHeaderInstalasi();
            $data['KategoriTindakanHeader'] = $this->tindakan_kuantitas_model_dokter->datasKategoriTindakanHeader();
            $data['KategoriTindakan'] = $this->tindakan_kuantitas_model_dokter->datasKategoriTindakan();
            $this->loadViewsAdmin("admin/tindakan_kuantitas_dokter/tindakans", $data, NULL);
    }

    function addNew()
    {
        $master = $this->input->post('master');
        $posisi = $this->input->post('posisi');
                $instalasi = $this->input->post('instalasi');
                $header = $this->input->post('header');
                $tindakan = $this->input->post('tindakan');
                $nama_kategori = $this->input->post('nama_kategori');
                $target = $this->input->post('target');
                $bobot = $this->input->post('bobot');
                $definisi_ops = $this->input->post('definisi_ops');
                
                $userInfo = array(  
                                    'id_jenis_pos'=>$master, 
                                    'id_pos'=>$posisi,
                                    'id_header_instalasi'=>$instalasi, 
                                    'id_header'=>$header,
                                    'id_tindakan'=>$tindakan,
                                    'uraian'=> $nama_kategori,
                                    'target'=>$target, 
                                    'bobot'=>$bobot, 
                                    'definisi_ops'=>$definisi_ops, 
                                    'aktif'=>'Y', 
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'usr_insrt'=>$this->session->userdata ('name')
                                );
                $result = $this->tindakan_kuantitas_model_dokter->add($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('/admin/Indikator_tindakan_kuantitas_dokter');
        
    }


    function oldEdit($id = NULL)
    {
        $data = $this->tindakan_kuantitas_model_dokter->getSelect($id);
        echo json_encode($data);
    }
    
    
    function edit($id)
    {
        $master = $this->input->post('master');
        $posisi = $this->input->post('posisi');
  $instalasi = $this->input->post('instalasi');
            $header = $this->input->post('header');
            $tindakan = $this->input->post('tindakan');
            $nama_kategori = $this->input->post('nama_kategori');
            $target = $this->input->post('target');
            $bobot = $this->input->post('bobot'); 
            $definisi_ops = $this->input->post('definisi_ops'); 
            $datas = array(  
                        'id_jenis_pos'=>$master, 
                        'id_pos'=>$posisi,
                        'id_header_instalasi'=>$instalasi, 
                        'id_header'=>$header,
                        'id_tindakan'=>$tindakan,
                        'uraian'=> $nama_kategori,
                        'target'=>$target, 
                        'bobot'=>$bobot, 
                        'definisi_ops'=>$definisi_ops, 
                        'updated_at'=>date('Y-m-d H:i:s'),
                        'usr_edit'=>$this->session->userdata ('name')
                    );
                $result = $this->tindakan_kuantitas_model_dokter->edit($datas, $id);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('/admin/Indikator_tindakan_kuantitas_dokter');
    }


    function delete()
    {
            $id = $this->input->post('id');
            $data = array('aktif'=>'n','usr_edit'=>$this->session->userdata('name'), 'updated_at'=>date('Y-m-d H:i:s'));
            
            $result = $this->tindakan_kuantitas_model_dokter->delete($data, $id);
            
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