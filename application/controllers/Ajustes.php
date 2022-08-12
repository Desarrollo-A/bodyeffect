<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajustes extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('phpmailer_lib');
		$this->validateSession();
    }


    public function index(){
    	$this->load->model("Ajustes_model");
    	$data['datos_del_perfil'] = json_decode(json_encode($this->Ajustes_model->get_datos_perfil()->result_array()));
        $this->load->view("v_Ajustes", $data);
    }



     public function actualizar_perfil(){
     	$this->load->model("Ajustes_model");
     	$respuesta = array( FALSE );
     	$id_user = $this->session->userdata("inicio_sesion")['id'];

        $data = array(
            "nombre" => $this->input->post("nombre"),
            "apellido_paterno" => $this->input->post("apellido_paterno"),
            "apellido_materno" => $this->input->post("apellido_materno"),
            "direccion" => $this->input->post("direccion"),
            "aboutme" => $this->input->post("aboutme"),
     	    "modificado_por" => $id_user
        );
        
        $respuesta = array( $this->Ajustes_model->update_perfil($id_user, $data));
     	echo json_encode( $respuesta );
     }

     public function test()
     {

            if($this->sendAttachmentMail($_FILES['pdf_attachment']['tmp_name'], $_FILES['pdf_attachment']['name']))
            {
                print_r("correo enviado exitosamente");
            }
            else
            {
                echo 'ERROR AL ENVIAR CORREO';
            }
            exit;
     }

    function sendAttachmentMail($file, $file_name)
    {
                // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        $namePDF = utf8_decode($file_name);

        $attachment= $file;

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPDebug  = 2;
//      $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@ciudadmaderas.com';
        $mail->Password = 'Marzo2019@';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        //25, 465, 2525 ---TEST PORTS
        //465 OFFICIAL

        $mail->setFrom('noreply@ciudadmaderas.com', 'Ciudad Maderas');
        $mail->AddAddress('programador.analista8@ciudadmaderas.com');
        // Email subject
        $mail->Subject = utf8_decode('ARCHIVO PDF ADJUNTO');

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = utf8_decode("<h1>Ciudad Maderas</h1>
        <p>Se adjunta el archivo adjunto correspondiente.</p>");
        $mail->Body = $mailContent;
        // $mail->AddStringAttachment($attachment, $namePDF);
        $uploadfile = tempnam(sys_get_temp_dir(), sha1($file_name));
        if (move_uploaded_file($file, $uploadfile))
            $mail->addAttachment($uploadfile,$file_name);


        $mail->smtpConnect(array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        ));
        $mail->send();
    }

    public function validateSession()
    {
        if ($this->session->userdata("inicio_sesion")['id'] == "") {
            redirect(base_url());
        }
    }

    /**------------FUNCIÓN PARA MANDAR SERVICIO PARA EL SISTEMA DE TICKETS */
    public function ServicePostTicket(){
        $url = 'https://dashboard.gphsis.com/back/paginainicio';

        $name = $this->session->userdata("inicio_sesion")['nombre'];
        $data = array(
            "idcrea" => $this->session->userdata("inicio_sesion")['id'],
            "nombre" => $name,
            "sistema" => "BODY EFFECT"   
        );

        $ch = curl_init($url);
        # Setup request to send json via POST.
        $payload = json_encode($data);
        curl_setopt( $ch, CURLOPT_POSTFIELDS,$payload);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        # Return response instead of printing.
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        # Send request.
        $result = curl_exec($ch);
        curl_close($ch);
        echo json_encode($result);
    }
    /**--------------------------FIN----------------------- */

}