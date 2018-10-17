<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class Login extends REST_Controller 
{

    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->model('login_model');
    }

    public function index_post()
    {

            header('Access-Control-Allow-Origin: *');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            // print_r($email);die();
            $result = $this->login_model->loginMe($email, $password);
            if(count($result) > 0)
            {
                foreach ($result as $res)
                {
                    $sessionArray = array('userId'=>$res->usr_id,                    
                    'role'=>$res->id_rol,
                    'roleText'=>$res->rol_name,
                    'pgw_nama'=>$res->pgw_nama,
                    'name'=>$res->usr_name,
                    'foto'=>$res->pgw_foto,
                    'nip'=>$res->pgw_nip,
                    'jk'=>$res->pgw_jenis_kelamin,
                    'unit'=>$res->id_unit_kerja,
                    'nama_unit'=>$res->nama_unit,
                    'isLoggedIn' => TRUE,
                    'message'=>'sukses'
                );
                                    
            }
            $this->session->set_userdata($sessionArray);
                if (!empty($this->session->userdata('unit'))) {
                    $this->response($sessionArray);                    
                } else {
                    $sessionArray = array('isLoggedIn'=>FALSE,'message'=>'error');
                    $this->response($sessionArray);  
                }
            }else{
                $sessionArray = array('isLoggedIn'=>FALSE,'message'=>'error');
                $this->response($sessionArray);  
            }
    }

    


}

?>