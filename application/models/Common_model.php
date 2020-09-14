<?php

defined('BASEPATH') or exit('No direct script access allowed');

class  Common_model  extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get client object based on passed clientid if not passed clientid return array of all clients
     * @param  mixed $id    client id
     * @param  array  $where
     * @return mixed
     */
    public function getclientListByRole($role=0,$staff_id=0)
    {
        $this->db->select('*');
        $this->db->join(db_prefix() . 'staff', '' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'clients.client_id');
         if($role==2){   
            $this->db->where(db_prefix() . 'staff.parent_user_id',$staff_id);
         }else if($role==3){
             $this->db->where(db_prefix() . 'staff.staffid',$staff_id); 
         }
        $this->db->order_by('company', 'asc');
        return $this->db->get(db_prefix() . 'clients')->result_array();
    }
    
    function updatedata($table,$data,$where){
        $uptdata=$this->db->update($table, $data , $where); 
        return $uptdata; 
    }

    function selectrow($table,$condition = [] ,$selectField = '*',$orderby = []){
        $this->db->select($selectField);
        $this->db->from($table);
        if(isset($condition) && !empty($condition)){
            $this->db->where($condition);
        }
        if(isset($orderby) && !empty($orderby)){
             $this->db->order_by($orderby[0],$orderby[1]);
        }
        $query = $this->db->get();

        if($query !== false)
        {
        return  $query->row();
        }
        else
        {
        return false;
        }
    }

    function select($table,$condition = [] ,$selectField = '*',$condition2 = [],$whereIn=[],$orderby=[]){
        $this->db->select($selectField);
        $this->db->from($table);
        if(isset($condition) && !empty($condition)){
            $this->db->where($condition);
        }
        if(isset($condition2) && !empty($condition2)){
            $this->db->where($condition2);
        }
        if(isset($whereIn) && !empty($whereIn)){
            $this->db->where_in($whereIn);
        }

        if(isset($orderby) && !empty($orderby)){
            $this->db->order_by($orderby[0],$orderby[1]);
        }

        $query = $this->db->get();
        //if($query->num_rows()>=1) {
        return  $query->result();
       // }
        //else{
        //return false;
        //}
    }

    function insert($table,$data){
        $insdata=$this->db->insert($table, $data);
        if($insdata){
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        }
    }

    function getUserDetailById($id)
    {
        $this->db->select('*');
        $this->db->from(db_prefix() .'staff');
        $this->db->join(db_prefix() .'clients', db_prefix() .'clients.client_id = '.db_prefix().'staff.staffid');
        if(!empty($id))
        {
            $this->db->where(db_prefix() .'staff.staffid',$id);
        }
        $this->db->order_by(db_prefix() .'staff.staffid', 'DESC');
        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        return $query->result_array();
    }
    
   function delete_data($where,$table)
    {
        $this->db->where($where);
        $this->db->delete($table);
		return true;

    } //delete_data closed
	
	
	// User logged in check
    public function is_logged_in()
    {
        if(empty($this->session->userdata('staff_user_id')))
		{
			redirect('login');
		}
    }
}
