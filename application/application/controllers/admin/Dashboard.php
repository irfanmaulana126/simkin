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
        if($this->isAdmin()==false){
            redirect('member/dashborad');
        }  
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {
        $data['aktif_menu']='dash'; 
        $data['aktif_menu_sub']=''; 
        $this->loadViewsAdmin("admin/dashboard/dashboard", $data , NULL);
    }
    

    function pageNotFound()
    {
        $data['aktif_menu']=''; 
        $data['aktif_menu_sub']='';         
        $this->loadViewsAdmin("404", NULL, NULL);
    }
}

?>