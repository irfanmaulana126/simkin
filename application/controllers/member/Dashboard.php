<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Dashboard extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->isLoggedIn(); 
        $this->load->model(array('member/dashboard_model'));
        $this->load->helper(array('form', 'url'));
        if($this->isAdmin()==true){
            redirect('member/user');
        }  
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']=''; 
        $data['kegiatans']= $this->dashboard_model->datasKegiatan($this->session->userdata('unit'));
        $this->loadViewsMember("member/dashboard/dashboard", $data , NULL);
    }
    function fetch()
	{
		$output = '';
		$data = $this->dashboard_model->datasAllKegiatan($this->input->post('limit'),$this->input->post('start'),$this->session->userdata('userId'));
        
        // print_r($data);die();
        if(!empty($data))
		{
            foreach ($data as $key=>$datas) {
                $output .='<ul class="timeline timeline-inverse" ><li>
                </li>
                <li class="time-label">
                </li>
                <li class="time-label">
                    <span class="bg-red">
                        '.$key.'
                    </span>
                </li></ul>';      
			foreach($datas as $row)
			{
				$output .= '<ul class="timeline timeline-inverse" >
				<li>
                      <i class="fa fa-comments bg-aqua"></i>
                      <div class="timeline-item bg-gray">
                        <span class="time"><i class="fa fa-clock-o"></i>'. date('H:i:s', strtotime($row->created_at)).'</span>
                        <h3 class="timeline-header">Tupoksi <a href="#">'. ucfirst($row->jenis) .'</a></h3>
                        <div class="timeline-body">
                          <p class="info-box-text">Tupoksi :'. ucfirst($row->indikator).'</p>
                          <p class="info-box-text">Definisi Tupoksi :'. ucfirst($row->difinisi_ops).'</p>
                          <p class="info-box-text">Nilai :'. $row->nilai.'</p>
                         
                        </div>
                        <div class="timeline-footer">';
                        if(date('Y-m-d', strtotime($row->created_at))==date('Y-m-d')){
                            $output .= '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit" onclick="edit('.$row->id.',\''.$row->jenis.'\')"><i class="fa fa-pencil"></i></a>';
                        }
                        $output .='&nbsp;
                          <a class="btn btn-sm btn-danger deleteUser" href="#" data-id="'.$row->id.'" data-tipe="\''.$row->jenis.'\'"><i class="fa fa-trash"></i></a>
                        </div>
                      </div>
                    </li>
                    </ul>
				';
            }
        }
		}
        echo $output;
        
    }
    public function upload(){
        if($_FILES['gambar']['name']!=''){
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 3000;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $config['upload_path']          =   './assets/images/';
            $tes=$this->load->initialize($config);
            $tess=$this->load->library('upload',$config);
            print_r($tes);die();
		if (!$this->upload->do_upload('gambar')){
			$message = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('message', $message['error']);
			redirect('member/dashboard/');
		}
		else{
			$data = array (
                'image'=>$config['file_name'].''.$ext
			);
            $this->upload->file_name;
			$this->pegawai_model->upload($data);
			$this->session->set_flashdata('message', "successful upload");
			redirect('member/dashboard/');
        }
    }else{
        //    update Data
        redirect('member/dashboard/');
    }
}
	
    function addNew()
    {
                $tupoksi = $this->input->post('tupoksi');
                $id_tupoksi = $this->input->post('id_tupoksi');
                $nilai = $this->input->post('nilai');
                switch ($tupoksi) {
                    case 'kuantitas':
                            $userInfo = array(  
                                'id_tupoksi'=>$id_tupoksi,
                                'nilai'=>$nilai,
                                'aktif'=>'Y',
                                'usr_id'=>$this->session->userdata('userId'),
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name')
                            );
                            $result = $this->dashboard_model->add($userInfo,'tupoksi_kuantitas');
                        break;
                    case 'kualitas':
                        $userInfo = array(   
                            'id_tupoksi'=>$id_tupoksi,
                            'nilai'=>$nilai,
                            'aktif'=>'Y',
                            'usr_id'=>$this->session->userdata('userId'),
                            'created_at'=>date('Y-m-d H:i:s'),
                            'usr_insrt'=>$this->session->userdata ('name')
                        );
                        $result = $this->dashboard_model->add($userInfo,'tupoksi_kualitas');
                        break;
                    case 'perilaku':
                            $userInfo = array(  
                                'id_tupoksi'=>$id_tupoksi,
                                'nilai'=>$nilai,
                                'aktif'=>'Y',
                                'usr_id'=>$this->session->userdata('userId'),
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name')
                            );
                            $result = $this->dashboard_model->add($userInfo,'tupoksi_perilaku');
                        break;
                    default:
                redirect('/member/dashboard');
                        break;
                }
                
                
                redirect('/member/dashboard');
        
    }
    function edit($id,$tipe)
    {
                $tupoksi = $this->input->post('tupoksi');
                $id_tupoksi = $this->input->post('id_tupoksi');
                $nilai = $this->input->post('nilai');
                switch ($tupoksi) {
                    case 'kuantitas':
                        if($tipe==$tupoksi){
                            $userInfo = array(  
                                'id_tupoksi'=>$id_tupoksi,
                                'nilai'=>$nilai,
                                'aktif'=>'Y',
                                'usr_id'=>$this->session->userdata('userId'),
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name')
                            );
                            $result = $this->dashboard_model->update($userInfo,$id,'tupoksi_kuantitas');
                        }else{
                            $userInfo = array(  
                                'id_tupoksi'=>$id_tupoksi,
                                'nilai'=>$nilai,
                                'aktif'=>'Y',
                                'usr_id'=>$this->session->userdata('userId'),
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name')
                            );
                            switch ($tipe) {
                                case 'kuantitas':
                                    $table='tupoksi_kuantitas';
                                    break;
                                case 'kualitas':
                                    $table='tupoksi_kualitas';
                                    break;
                                case 'perilaku':
                                    $table='tupoksi_perilaku';
                                    break;
                            }
                            $this->dashboard_model->deletefix($id,$table);
                            $result = $this->dashboard_model->add($userInfo,'tupoksi_kuantitas');
                        }
                        break;
                    case 'kualitas':
                        if($tipe==$tupoksi){
                            $userInfo = array(   
                                'id_tupoksi'=>$id_tupoksi,
                                'nilai'=>$nilai,
                                'aktif'=>'Y',
                                'usr_id'=>$this->session->userdata('userId'),
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name')
                            );
                            $result = $this->dashboard_model->update($userInfo,$id,'tupoksi_kualitas');
                        }else{
                            $userInfo = array(  
                                'id_tupoksi'=>$id_tupoksi,
                                'nilai'=>$nilai,
                                'aktif'=>'Y',
                                'usr_id'=>$this->session->userdata('userId'),
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name')
                            );
                            switch ($tipe) {
                                case 'kuantitas':
                                    $table='tupoksi_kuantitas';
                                    break;
                                case 'kualitas':
                                    $table='tupoksi_kualitas';
                                    break;
                                case 'perilaku':
                                    $table='tupoksi_perilaku';
                                    break;
                            }
                            $this->dashboard_model->deletefix($id,$table);
                            $result = $this->dashboard_model->add($userInfo,'tupoksi_kualitas');
                        }
                        break;
                    case 'perilaku':
                        if($tipe==$tupoksi){
                            $userInfo = array(  
                                'id_tupoksi'=>$id_tupoksi,
                                'nilai'=>$nilai,
                                'aktif'=>'Y',
                                'usr_id'=>$this->session->userdata('userId'),
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name')
                            );
                            $result = $this->dashboard_model->update($userInfo,$id,'tupoksi_perilaku');
                        }else{
                            $userInfo = array(  
                                'id_tupoksi'=>$id_tupoksi,
                                'nilai'=>$nilai,
                                'aktif'=>'Y',
                                'usr_id'=>$this->session->userdata('userId'),
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name')
                            );
                            switch ($tipe) {
                                case 'kuantitas':
                                    $table='tupoksi_kuantitas';
                                    break;
                                case 'kualitas':
                                    $table='tupoksi_kualitas';
                                    break;
                                case 'perilaku':
                                    $table='tupoksi_perilaku';
                                    break;
                            }
                            $this->dashboard_model->deletefix($id,$table);
                            $result = $this->dashboard_model->add($userInfo,'tupoksi_perilaku');
                        }
                            
                        break;
                    default:
                redirect('/member/dashboard');
                        break;
                }
                redirect('/member/dashboard');
    }
    function oldEdit($id = NULL,$tipe = NULL)
    {
        switch ($tipe) {
            case 'kuantitas':
                    $data = $this->dashboard_model->getSelect($id,'tupoksi_kuantitas',$tipe);
                    echo json_encode($data);
                break;
            case 'kualitas':
                    $data = $this->dashboard_model->getSelect($id,'tupoksi_kualitas',$tipe);
                    echo json_encode($data);
                break;
            case 'perilaku':
                    $data = $this->dashboard_model->getSelect($id,'tupoksi_perilaku',$tipe);
                    echo json_encode($data);
                break;
            default:
        redirect('/member/dashboard');
                break;
        }
    }
    function pageNotFound()
    {
        $data['aktif_menu']=''; 
        $data['aktif_menu_sub']='';         
        $this->loadViewsMember("404", NULL, NULL);
    }
}

?>