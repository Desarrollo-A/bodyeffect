<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Body_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }


     function getbancos(){
         $query =  $this->db->query("SELECT * FROM [usuarios]");
        echo "HOLA MORRIRLOO";
    }


 
}