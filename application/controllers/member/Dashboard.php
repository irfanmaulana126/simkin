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
        $data['Indikator']= $this->dashboard_model->Indikator($this->session->userdata('unit'));
        // print_r();die();
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
                switch ($row->indikator_tupoksi) {
                    case '1':
                        $indikator_tupoksi='Kuantitas';
                        break;
                    case '2':
                    $indikator_tupoksi='Kualitas';
                        break;
                    case '3':
                    $indikator_tupoksi='Perilaku';
                        break;
                    case '4':
                    $indikator_tupoksi='Tambahan';
                        break;
                }
				$output .= '<ul class="timeline timeline-inverse" >
				<li>
                      <i class="fa fa-comments bg-aqua"></i>
                      <div class="timeline-item bg-gray">
                        <span class="time"><i class="fa fa-clock-o"></i>'. date('H:i:s', strtotime($row->created_at)).'</span>
                        <h3 class="timeline-header">Tupoksi <a href="#">'. ucfirst($indikator_tupoksi) .'</a></h3>
                        <div class="timeline-body">
                          <p class="info-box-text">Tupoksi :'. ucfirst($row->indikator).'</p>
                          <p class="info-box-text">Definisi Tupoksi :'. ucfirst($row->difinisi).'</p>
                          <p class="info-box-text">Nilai :'. $row->nilai.'</p>
                         
                        </div>
                        <div class="timeline-footer">';
                        if(date('Y-m-d', strtotime($row->created_at))==date('Y-m-d') && $row->indikator_tupoksi != '4'){
                            $output .= '<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Edit" onclick="edit('.$row->id.')"><i class="fa fa-pencil"></i></a>';
                        }
                        $output .='&nbsp;
                          <a class="btn btn-sm btn-danger deleteUser" href="#" data-id="'.$row->id.'" data-master="'.$row->id_master_indikator.'" data-tipe="1"><i class="fa fa-trash"></i></a>
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
                $indikator = $this->input->post('indikator');
                $definisi = $this->input->post('definisi');
                $nilai = $this->input->post('nilai');
                switch (true) {
                    case ($tupoksi == '1' || $tupoksi == '2' || $tupoksi == '3' ):
                        $date = $this->dashboard_model->getBoborTarget(date('Y-m-d'),$id_tupoksi);
                            $userInfo = array(  
                                'nilai'=>$nilai,
                                'id_master_indikator'=>$id_tupoksi,
                                'aktif'=>'Y',
                                'target'=>$date->target,
                                'bobot'=>$date->bobot,
                                'usr_id'=>$this->session->userdata('userId'),
                                'created'=>date('Y-m-d H:i:s'),
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name')
                            );
                            $result = $this->dashboard_model->add($userInfo,'input_kegitan_tupoksi');
                        break;
                    case ($tupoksi=='4'):
                            $inputkegiatan = array(  
                                'indikator'=>$indikator,
                                'difinisi'=>$definisi,
                                'aktif'=>'Y',
                                'created_at'=>date('Y-m-d H:i:s'),
                                'usr_insrt'=>$this->session->userdata ('name'),
                                'jns_input'=>'3',
                                'id_unit_kerja'=>$this->session->userdata('unit'),
                                'indikator_tupoksi'=>'4'
                            );
                            $this->dashboard_model->addTupoksiKegitan($inputkegiatan,'master_indikator');
                        break;
                    default:
                redirect('/member/dashboard');
                        break;
                }
                
                
                redirect('/member/dashboard');
        
    }
    function edit($id)
    {
                $tupoksi = $this->input->post('tupoksi');
                $id_tupoksi = $this->input->post('id_tupoksi');
                $nilai = $this->input->post('nilai');
                $date = $this->dashboard_model->getBoborTarget(date('Y-m-d'),$id_tupoksi);
                $userInfo = array(  
                    'nilai'=>$nilai,
                    'id_master_indikator'=>$id_tupoksi,
                    'aktif'=>'Y',
                    'target'=>$date->target,
                    'bobot'=>$date->bobot,
                    'usr_id'=>$this->session->userdata('userId'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    'usr_edit'=>$this->session->userdata ('name')
                );
                $result = $this->dashboard_model->update($userInfo,$id,'input_kegitan_tupoksi');
                redirect('/member/dashboard');
    }
    function delete()
    {
        $id = $this->input->post('id');
        $tipe = $this->input->post('tipe');
        $master = $this->input->post('master');
        
        $userInfo = array(  
            'aktif'=>'N'
        );
        if (!empty($tipe)) {
            $userInfo = array(  
                'aktif'=>'N'
            );
            $result = $this->dashboard_model->update($userInfo,$master,'master_indikator');
        }
        $result = $this->dashboard_model->update($userInfo,$id,'input_kegitan_tupoksi');
                

    }
    function oldEdit($id = NULL)
    {
        $data = $this->dashboard_model->getSelectKegiatan($id);
        echo json_encode($data);
     }
    function pageNotFound()
    {
        $data['aktif_menu']=''; 
        $data['aktif_menu_sub']='';         
        $this->loadViewsMember("404", NULL, NULL);
    }
}

?>