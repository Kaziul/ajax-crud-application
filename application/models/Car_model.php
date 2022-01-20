<?php 

Class Car_model extends CI_Model{

    public function create($formArray){
        $this->db->insert('car_models',$formArray);
        // return $id = $this->db->insert_id();
    }

    // This method will return all records from car_models table
    public function all(){
        $result = $this->db->order_by('id','ASC')->get('car_models')->result_array();

        // SELECT * FROM car_models order by id ASC
        return $result;
    }
    // function getRow($id){
    //     $this->db->where('id',$id);
    //     $row = $this->db->get('car_models')->row_array();
    //     // SELECT * FORM car_models Where id = $id
    //     return $row;
    // }
}

?>