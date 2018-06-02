<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class customermodel extends CI_Model {
    function fnSaveContactUsInfo($ArrSaveDetails){
        $this->db->insert(EDB_QUERIES,$ArrSaveDetails);
        return $this->db->insert_id();
    }
}