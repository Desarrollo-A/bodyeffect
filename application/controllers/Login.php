 

 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
  
  public function __construct(){
    parent::__construct();
    if( $this->session->userdata("inicio_sesion") )
      redirect("Home", "refresh");
    else
      $this->load->model('Login_model');
  }

  public function index(){
    $this->load->view('v_Login');
  }

  public function verificar(){
    if(isset($_POST) && !empty($_POST)){
      $this->Login_model->verificar_usuario();
    }
    redirect(base_url());
  }
}


 
  