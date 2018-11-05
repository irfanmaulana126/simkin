<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

/**
 * Class : User (UserController)
 * User Class to control all user related operations.
 * @author : Kishor Mali
 * @version : 1.1
 * @since : 15 November 2016
 */
class Report extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->isLoggedIn();   
        if($this->isAdmin()==true){
            redirect('admin/user');
        }  
    }
    public function index()
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']=''; 
        $this->loadViewsMember("member/report/indexs", $data , NULL);
        
    }
    function pageNotFound()
    {
        
        $this->loadViewsMember("404", NULL, NULL);
    }
}

?>