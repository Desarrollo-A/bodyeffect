<?php
require_once './assets/js/jwt/JWT.php';

use Firebase\JWT\JWT;

    class Jwt_actions{

        private $_CI;
        public function __construct()
        {
            $this->_CI = & get_instance();
            $this->load->library('session');

        }

        function authorize($controller, $requestHeaders){
            $this->helper($requestHeaders);
            $tkn = $this->generateToken($controller);
            $response = $this->validateToken_authorize($tkn, $controller);
            $res = json_decode($response);
            if($res->status != 200){
               $this->load->view('errors/404not-found');
            }
        }

        function helper($requestHeaders){
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: Content-Type,Origin, authorization, X-API-KEY,X-Requested-With,Accept,Access-Control-Request-Method');
            header('Access-Control-Allow-Method: GET, POST, PUT, DELETE,OPTION');
            $urls = array('https://bodyeffect.gphsis.com','prueba.gphsis.com','localhost','http://localhost','127.0.0.1','https://prueba.gphsis.com/bodyeffect');
            date_default_timezone_set('America/Mexico_City');
            

            //echo $_SERVER['HTTP_ORIGIN'];
            if(isset($requestHeaders['origin'])){
                $origin = $requestHeaders;
            }else if(array_key_exists('HTTP_ORIGIN',$_SERVER)){
                $origin = $_SERVER['HTTP_ORIGIN'];
            }else if(array_key_exists('HTTP_PREFERER',$_SERVER)){
                $origin = $_SERVER['HTTP_PREFERER'];
            }
            else{
                $origin = $_SERVER['HTTP_HOST'];
            }
            if(in_array($origin,$urls) || strpos($origin,"192.168")){
              
                }else{
                    die ("Access Denied");       
                }
        }

        function generateToken($controller){
            $time = time();
            $JwtSecretKey = $this->getSecretKey($controller);
            $data = array(
                "iat" => $time, // Tiempo en que inició el token
                "exp" => $time + (24 * 60 * 60), // Tiempo en el que expirará el token (24 horas)
                "data" => array("id" => $this->session->userdata("inicio_sesion")['id'], "id_rol" => $this->session->userdata("inicio_sesion")['id_rol']),
            );
            $token = JWT::encode($data, $JwtSecretKey);
            return $token;
        }

        function validateToken_authorize($token, $controller)
        {
           
            $time = time();
            $JwtSecretKey = $this->getSecretKey($controller);
            $result = JWT::decode($token, $JwtSecretKey, array('HS256'));
            if (in_array($result, array('ALR001', 'ALR003', 'ALR004', 'ALR005', 'ALR006', 'ALR007', 'ALR008', 'ALR009', 'ALR010', 'ALR012', 'ALR013'))) {
                return json_encode(array("timestamp" => $time, "status" => 503, "error" => "Servicio no disponible", "exception" => "Servicio no disponible", "message" => "El servidor no está listo para manejar la solicitud. Por favor, inténtelo de nuevo más tarde."));
            } else if ($result == 'ALR002') {
                return json_encode(array("timestamp" => $time, "status" => 400, "error" => "Solicitud incorrecta", "exception" => "Número incorrecto de parámetros", "message" => "Verifique la estructura del token enviado."));
            } else if ($result == 'ALR011') {
                return json_encode(array("timestamp" => $time, "status" => 401, "error" => "No autorizado", "exception" => "Verificación de firma fallida", "message" => "Estructura no válida del token enviado."));
            } else if ($result == 'ALR014') {
                return json_encode(array("timestamp" => $time, "status" => 401, "error" => "No autorizado", "exception" => "Token caducado", "message" => "El tiempo de vida del token ha expirado."));
            } else {
                $validate= true;
                $keys = array_keys((array)$result->data );
                foreach($keys as $key){
                    if($result->data->$key != $this->session->userdata("inicio_sesion")[$key] || $result->data->$key == null){
                        $validate = false;
                    }
                }
                if($validate){
                    return json_encode(array("status" => 200, "message" => "Autenticado con éxito.", "data"=> $result));
                }else{
                    return json_encode(array("timestamp" => $time, "status" => 401, "error" => "No autorizado", "exception" => "Verificación de firma fallida", "message" => "Estructura no válida del token enviado."));
                }
            }
        }

        function getSecretKey($controller){

            $obj = (object) array(
                '636' => '9513831646{6537}-7613',
                '545' => '9736274869{3937}-282449',
                '514' => '7586177513{2298}-893393',
                '907' => '394473749{4879}-296828',
                '847' => '4331453826{624}-30838',
                '649' => '607155413{6016}-937190',
                '274' => '5195925991{1496}-858144',
                '728' => '6262218233{5491}-332527',
                '59' => '5497015467{8660}-375888',
                '223' => '484564740{2959}-26568',
                '671' => '8523226430{01}-8898',
                '840' => '660414518{5492}-328942',
                '667' => '7982851082{7853}-284644',
                '590' => '6649423150{2587}-483552',
                '895' => '9471323999{6154}-802471',
                '51' => '5448665713{9065}-606090',
                '761' => '9468090993{5692}-475733',
                '391' => '164961598{7159}-51258',
                '488' => '13239248{4742}-83991',
                '339' => '361078454{8721}-74801'
            );
            return $obj->$controller;
        }



    }
?>
