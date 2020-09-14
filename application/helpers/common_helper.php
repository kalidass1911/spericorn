<?php

defined('BASEPATH') or exit('No direct script access allowed');


function isMobile() 
{
return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}



function sitename($user_id)
{
$ci =& get_instance();
$sitedetails = $ci->common_model->selectrow(db_prefix().'site_settings',['staffid'=>$user_id]);
$sitename = ($sitedetails)?$sitedetails->sitename:'GET THAT CREDIT';
return $sitename;
}

function sitelogo($user_id)
{
$ci =& get_instance();
$sitedetails = $ci->common_model->selectrow(db_prefix().'site_settings',['staffid'=>$user_id]);
$sitelogo = ($sitedetails) ? $sitedetails->sitelogo : base_url().'assets/images/logo.jpg';
//return $sitelogo;  
return '<img src="'.$sitelogo.'" class="logo img-responsive" >';
}


function orderusername($staffid)
{
$ci =& get_instance();
$staff = $ci->common_model->selectrow(db_prefix().'staff',['staffid'=>$staffid]);
$name = ($staff)?$staff->firstname.'  '.$staff->lastname:$staff->email;
return $name;    
}

function orderusernameclient($clientid)
{
$ci =& get_instance();
$clients = $ci->Common_model->selectrow(db_prefix().'clients',['userid'=>$clientid]);
if($clients)
{
 $staff = $ci->Common_model->selectrow(db_prefix().'staff',['staffid'=>$clients->client_id]);
$name = ($staff)?$staff->firstname.'  '.$staff->lastname:$staff->email;
return $name;    
}
}

function getclientid($staffid)
{
$ci =& get_instance();
 $staff = $ci->Common_model->selectrow(db_prefix().'staff',['staffid'=>$staffid]);
 if($staff)
 {
   $clients = $ci->Common_model->selectrow(db_prefix().'clients',['client_id'=>$staff->staffid]);
   return $clients->userid; 
 }
}


function getstaffid($clientid)
{
$ci =& get_instance();
 $clients = $ci->Common_model->selectrow(db_prefix().'clients',['userid'=>$clientid]);
 if($clients)
 {
   return $clients->client_id; 
 }
}


function setdynamicvalidation($slug)
{
	$phonearray = ['products_phone','products_employer_phone','products_business_phone','products_landlord_phone','products_business_reference_phone'];
	$ziparray = ['products_employer_zip','products_zip','products_business_zip'];

	$datearray = ['products_date_of_birth','products_drivers_license_exp_date','products_date_business_established'];

	$ssnarray = ['products_ssn'];

    if(in_array($slug, $ziparray))
    {
    	$onkey = " onkeypress='return isNumberKey(this)'  maxlength='5' minlength='5' ";
    }
    else if(in_array($slug, $phonearray))
    {
    	$onkey = " onkeypress='return isNumberKey(this)' maxlength='12' id='".$slug."' ";
    }
    else if(in_array($slug, $datearray))
    {
    	$onkey = " ";
    }
    else if(in_array($slug, $ssnarray))
    {
    	$onkey = " onkeypress='addDashesssn(this)'  maxlength='11' minlength='11' ";
    }
    else
    {
    	$onkey = '';
    }
    return $onkey;
}

function setdynamicdatetype($slug)
{
	$datearray = ['products_date_of_birth','products_drivers_license_exp_date','products_date_business_established'];

	 if(in_array($slug, $datearray))
    {
    	$onkey = "date";
    }

    return $onkey;
}


function getbankname($id)
{
$ci =& get_instance();
$bank = $ci->Common_model->selectrow(db_prefix().'bank',['id'=>$id]);
$name = ($bank)?$bank->bank_name:'';
return $name;  
}


function getproducttype($productId,$orderId)
{
      $ci =& get_instance();

            if(!empty($productId) || !empty($orderId)){
                $products = $ci->common->selectrow(db_prefix().'products',['id' =>$productId]);
                $type='';
                if(!empty($products)){
                    $categories = $ci->common->selectrow(db_prefix().'categories',['category_id' =>$products->category_id]);      
                    if($categories){ 
                        $categoryname = $categories->category_name;
                    }
                    else{
                        $categoryname = $products->product_name;    
                    }               
                    if(strpos($categoryname,'CREDIT') !== false)
                        $type = "credit";
                    else if (strpos($categoryname,'credit') !== false) 
                        $type = "credit";
                    else if (strpos($categoryname,'Credit') !== false) 
                        $type = "credit";
                    else if(strpos($categoryname,'FUNDING') !== false)
                        $type = "funding";
                    else if(strpos($categoryname,'funding') !== false)
                        $type = "funding";
                    else if(strpos($categoryname,'Funding') !== false)
                        $type = "funding";
                }
            }
        return  $type;

}



    function getpaymentmethod($clientid=0)
    {
        $ci =& get_instance();

        if(!empty($clientid))
        {
        $staff = $ci->common->selectrow('staff',['staffid' =>$clientid]); 

            if($staff)
            {
                $ci->db->from('payment_methods');
                
                /*if($staff->parent_user_id==6 || $staff->parent_user_id==9)
                {
                 $ci->db->where('payment_methods.payment_id',1);
                }
                else if($_SESSION['role']!=2 && $staff->role==3 && $staff->parent_user_id!=6)
                {
                   $ci->db->where('payment_methods.broker_id',$staff->parent_user_id); 
                }
                else
                {
                    //$ci->db->where('payment_methods.broker_id',$staff->parent_user_id);
                    $ci->db->where('payment_methods.payment_id',1);
                }*/
                $ci->db->where('payment_methods.broker_id',$staff->parent_user_id); 
                $ci->db->order_by('payment_methods.payment_id');
                $query = $ci->db->get();
                $method = $query->result(); 
            }
        }

       $methodsarray = [];
       foreach($method as $values)
         {
            $methods[$values->payment_id] = $values->name;
         }

       return $methods;
    }

    function allowedHours()
    {
        $allowedhours='';
        if($_SESSION['role']==3){
          $parent_user_id = $_SESSION['parent_user_id'];
          $allowedhours = json_encode(json_decode(get_option('appointly_available_hours')));
        }else {
        $allowedhours = json_encode(json_decode(get_option('appointly_available_hours')));
        }
        return $allowedhours;
    }
    
     function getIdenityfyBroker($staffid=0){
        $ci =& get_instance();
        if(!empty($staffid)){
            $staff = $ci->common->selectrow('staff',['staffid' =>$staffid],'staffid,parent_user_id');
            return $staff->parent_user_id ?? 0;
        }
    }


    function getuserstaffdetails($clientid=0)
    {
        $ci =& get_instance();
         $staffid = getstaffid($clientid);

         if($staffid)
         {
            $staff = $ci->common->selectrow('staff',['staffid' =>$staffid]);
            return $staff;
         }
    }

    function getReferralCode($staffid=0)
    {
        $ci =& get_instance();
        $ci->load->model('Common_model');
        $staff = $ci->Common_model->selectrow('staff',['staffid' => $staffid],'referal_code');
        if(!$staff->referal_code)
        {
        $staff = $ci->Common_model->selectrow('site_settings',['staffid' => $staffid],'refercode');  
        }

        return $staff->referal_code ?? '';
    }


    function getbrokername($staffid)
    {
          $ci =& get_instance();
          $staff = $ci->common->selectrow('staff',['staffid' =>$staffid]);

          if($staff)
          {
            $brokerdetails = $ci->common->selectrow('staff',['staffid'=>$staff->parent_user_id]);

            if($brokerdetails)
            {
                return $brokerdetails->firstname.' '.$brokerdetails->lastname;
            }
          }
    }
     function getProductIdsByCategoryId($categoryId=0)
    {
        $ci =& get_instance();
        $ci->load->model('Common_model');
        $getproductsIds = $ci->Common_model->select('products',['category_id' => $categoryId,'status' =>1],'id');
        $productids='';
        foreach($getproductsIds as $res){
           $productids.=$res->id .',';
        }
       return $productids;
    }


    function getrolepermission()
    {
         $ci =& get_instance();
         $roles = $ci->common->selectrow('roles',['roleid'=>$_SESSION['role']]); 
         if($roles)
         {
                 $permission = unserialize($roles->permissions);

                 if(isset($permission['password'][0]) && $permission['password'][0]=='view')
                 {
                    return  1;
                 }
                 else
                 {
                     return  0;
                 }
         }
    }

    function getlastreply($ticketid)
    {
        $ci =& get_instance();
         $ticket_replies = $ci->common->selectrow('ticket_replies',['ticketid'=>$ticketid],'',['ticketid','DESC']); 

         if($ticket_replies)
         {
$lastrreply = date('m/d/Y h:i A', strtotime($ticket_replies->date));
         }
         else
         {
          $lastrreply = 'No Reply Yet';
         }

         return $lastrreply;
    }


        function getlastreplynotes($notesid)
    {
        $ci =& get_instance();
         $replies = $ci->common->selectrow('admin_notes_comments',['notes_id'=>$notesid],'',['comment_id','DESC']); 

         if($replies)
         {
$lastrreply = date('m/d/Y h:i A', strtotime($replies->created));
         }
         else
         {
          $lastrreply = 'No Reply Yet';
         }

         return $lastrreply;
    }

    
    function get_task_order_step_details($block_id=0,$order_id=0)
    {
        $ci =& get_instance();
        $ci->load->model('projects_model');
        $data=[];
        if(!empty($block_id) && !empty($order_id)) {
            $data['ordersteps_details']=$ci->projects_model->getorder_step_details($order_id,$block_id);
            echo $ci->load->view('admin/tasks/order_step_details', $data,true);
        }
    }


    function getrole($role)
    {
       $ci =& get_instance(); 
         $roles = $ci->common->selectrow('roles',['roleid'=>$role]);
         return ($roles && $roles->name)?$roles->name:''; 
    }


    function getprojectbasics($project_id)
    {
        $ci =& get_instance();
        $ci->db->select('*');
        $ci->db->from(db_prefix() .'projects');
        $ci->db->where(db_prefix() .'projects.id',$project_id);
        $query = $ci->db->get();
        $list =$query->result_array();
        return $list[0];
    }

    function getusers($staffids)
    {
       $ci =& get_instance();
       $staffids = explode(',', $staffids);
       $name = '';
       foreach($staffids as $staff)
       {
         $staff = $ci->common->selectrow('staff',['staffid'=>$staff]); 

         if($staff)
         {
            $name .= ucfirst($staff->firstname.' '.$staff->lastname).' , ';
         }
       }
       return  $name;
    }


    function getclientlist($parent_user_id)
    {
        $ci =& get_instance();
        $ci->db->select('*');
        $ci->db->from(db_prefix() .'staff');
        $ci->db->where(db_prefix() .'staff.parent_user_id',$parent_user_id);
         $ci->db->where(db_prefix() .'staff.status',1);
        $ci->db->order_by(db_prefix() .'staff.staffid', 'DESC');
       
        $query = $ci->db->get();
        //echo $ci->db->last_query();exit;
        $list =$query->result_array();
        $staffids_list='';
        if($list)
        { 
          $staffids = [];
           foreach ($list as $key => $value) 
           {
             $staffids[]= $value['staffid']; 
           }

            $comma_separated= implode("','", $staffids);

           if(count($staffids)>0)
           {
             $comma_separated = "'".$comma_separated."'";
           } 
        }

      return $comma_separated;
        //return  rtrim($staffids_list, '/');
    }


    function getuseremail($staff_id)
    {
    $ci =& get_instance();
    $staff = $ci->common_model->selectrow(db_prefix().'staff',['staffid'=>$staff_id]);
    $email = ($staff)?$staff->email:'';
    return $email; 
    }

     function getclientlistclientid($parent_user_id)
    {
        $ci =& get_instance();
        $ci->db->select('*');
        $ci->db->from(db_prefix() .'staff');
        $ci->db->where(db_prefix() .'staff.parent_user_id',$parent_user_id);
        $ci->db->where(db_prefix() .'staff.status',1);
        $ci->db->order_by(db_prefix() .'staff.staffid', 'DESC');
       
        $query = $ci->db->get();
       // echo $ci->db->last_query();exit;
        $list =$query->result_array();
        $staffids_list='';
        if($list)
        { 
          $staffids = [];
           foreach ($list as $key => $value) 
           {
            $clients = $ci->common->selectrow(db_prefix() .'clients',['client_id'=>$value['staffid']]); 
                if($clients)
                $staffids[]= $clients->userid; 
           }
            $comma_separated= implode("','", $staffids);
           if(count($staffids)>0)
           {
             $comma_separated = "'".$comma_separated."'";
           }
        }else{
             $clients = $ci->common->selectrow('clients',['client_id'=>$parent_user_id]); 
                if($clients){
                 $comma_separated = "'".$clients->userid."'";
                }else{
                    $staffData = $ci->common->selectrow('staff',['staffid'=>$parent_user_id]); 
                    $cleintsdata['client_id'] 	= $parent_user_id;
					$cleintsdata['company'] 	= $staffData->firstname.' '.$staffData->lastname;
					$cleintsdata['phonenumber'] = $staffData->phonenumber;
					$cleintsdata['datecreated'] = $staffData->datecreated;
					$clientid = $ci->common->insert('clients',$cleintsdata);
                    $comma_separated = "'".$clientid."'";
                }
        }
      return $comma_separated;
        //return  rtrim($staffids_list, '/');
    }


      function getticketscount()
    {
        $ci =& get_instance();
        $ci->db->select('tickets.*,departments.assignusers as assignusers,departments.name as department,tickets_status.name as status,tickets_priorities.name as priority,tickets_status.statuscolor as color');
        if($_SESSION['role']==3)
        {
            $ci->db->where('userid',$_SESSION['staff_user_id']);  
        }
        else if($_SESSION['role']==2)
        {
            $ci->db->where('userid',$_SESSION['staff_user_id']);  
            $ci->db->or_where('admin',$_SESSION['staff_user_id']);
            $ci->db->or_where('assigned',$_SESSION['staff_user_id']);   
        }
        else if($_SESSION['role']==1)
        {}
        else
        {
            $ci->db->where('find_in_set("'.$_SESSION['staff_user_id'].'",' . db_prefix() . 'departments.assignusers) <> 0');
        }

        $ci->db->where('status !=',5); 

        $ci->db->join(db_prefix() . 'departments', db_prefix() . 'departments.departmentid= ' . db_prefix() . 'tickets.department');

        $ci->db->join(db_prefix() . 'tickets_status', db_prefix() . 'tickets_status.ticketstatusid='. db_prefix() . 'tickets.status');

        $ci->db->join(db_prefix() . 'tickets_priorities', db_prefix() . 'tickets_priorities.priorityid='. db_prefix() . 'tickets.priority');

         $ci->db->order_by('tickets.ticketid','asc');

        $count = $ci->db->get(db_prefix() . 'tickets')->result_array();

        //echo $ci->db->last_query();die;

        return count($count);
    }

    function getalluselist()
    {
        $ci =& get_instance();
        $where=['active' => 1,'role !='=>0];
        $staff_members = $ci->staff_model->get('', $where);

        $list = [];

        $roles[2] = 'Broker'; $roles[3] = 'Client';

        if($staff_members)
        {
            foreach ($staff_members as $key => $value) 
            {
                if($value['role']==2 || $value['role']==3)
                {
                $name = $value['firstname'].' '.$value['lastname'];

                if(!empty($name))
                {
                  $list[$value['staffid']] =  $name.' - '.$roles[$value['role']];   
                }
              }
            }
        }
        return $list;
    }


    function getotherusers()
    {
        $ci =& get_instance();
        $ci->db->select('*');
        $ci->db->from(db_prefix() .'staff');
        $ci->db->where(db_prefix() .'staff.role !=',2);
        $ci->db->where(db_prefix() .'staff.role !=',1);
        $ci->db->where(db_prefix() .'staff.role !=',3);
         $ci->db->where(db_prefix() .'staff.role !=',0);
        $ci->db->order_by(db_prefix() .'staff.staffid', 'DESC');
       
        $query = $ci->db->get();

        //echo $ci->db->last_query();die;

        $staff_members =$query->result_array(); 

        if($staff_members)
        {
            foreach ($staff_members as $key => $value) 
            {
                $name = $value['firstname'].' '.$value['lastname'];

                if(!empty($name))
                {
                  $list[$value['staffid']] = $name;   
                }
            }
        }
        return $list;
    }


    function getproducts_user_association_ids()
    {
         $ci =& get_instance();
         $ci->db->select('products.id');
         $ci->db->from(db_prefix() .'products');
         $ci->db->join(db_prefix() . 'products_user_association', db_prefix() . 'products.id= ' . db_prefix() . 'products_user_association.product_id');
         $ci->db->where('products_user_association.staff_id', $_SESSION['staff_user_id']);
        $query = $ci->db->get();
        $list =$query->result_array(); 

        $staffids_list='';
        if($list)
        { 
          $staffids = [];
           foreach ($list as $key => $value) 
           {
             $staffids[]= $value['id']; 
           }

            $comma_separated= implode(",", $staffids);

           if(count($staffids)>0)
           {
             $comma_separated = "".$comma_separated."";
           } 
        }

      return $comma_separated;
    }

    function getstepstatus($order_id,$stepno)
    {
         $ci =& get_instance();
         $verify = $ci->common->selectrow(db_prefix().'order_credit_process_verify',['order_id'=>$order_id,'step_no'=>$stepno]);

            if($verify)
            return "success";
            else
            return "fail";
    }
    /*****Verify by credit processor***/
    function getVerifiedStep($order_id)
    {
         $ci =& get_instance();
         $getdata = $ci->common->select(db_prefix().'order_credit_process_verify',['order_id'=>$order_id]);
         $verifyStep=[];
         foreach($getdata as $getResponseData){
             $verifyStep[$getResponseData->step_no]= $getResponseData->step_no;
         }
          return $verifyStep;
    }
    function clean($string) {
       $string = str_replace(' ', ' ', $string); // Replaces all spaces with hyphens.
       return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
    }
    
       function getverifybutton($project_id,$step_no)
    {
        return '<span id="updatestep_'.$step_no.'"><a href="javascript:void(0);" class="btn btn-success btn-sm" onclick="updatestepno('.$project_id.','.$step_no.')"> Click to Verify</a></span>';
    }

    function getremoveverifybutton($project_id,$step_no)
    {
     return  '<span id="updatestepremove_'.$step_no.'"><a href="javascript:void(0);"  style="cursor:none;" class="btn btn-success btn-sm"> Verified <i class="fa fa-check" aria-hidden="true"></i> </a>&nbsp &nbsp<a href="javascript:void(0);"  class="btn btn-warning btn-sm" onclick="removeverified('.$project_id.','.$step_no.')" > Remove Verified </a></span>';
    }


    function getsubstatus($statusid)
    {
         $ci =& get_instance();
         $substatus = $ci->common->select(db_prefix().'orderstatus',['parent_id'=>$statusid]);
         if($substatus)
         return $substatus;     
    }


    function getstatuscount($statusid)
    {
        $ci =& get_instance();
        $statuscount = []; 
        if($_SESSION['role']==2)
        {
            $clientlist = getclientlistclientid($_SESSION['staff_user_id']); 
        }
        $associationproductids = getproducts_user_association_ids();
            
             $_where = '';
              if($_SESSION['role']==3)
              {
              if(!has_permission('projects','','view')){
                  $_where = 'id IN (SELECT project_id FROM '.db_prefix().'project_members WHERE staff_id='.get_staff_user_id().')'; 
              }
              }
              else if($_SESSION['role']==2 && !empty($clientlist))
              {
                $_where = 'clientid IN ('.$clientlist.')';
              }

                $productcount ='';
                if($_SESSION['role']==5){
                $productcount = ' AND productid IN(10,62,96,105)';
                }else if($_SESSION['role']==4) {
                $productcount = ' AND productid IN('.$associationproductids.')'; 
                }
                $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$statusid . $productcount; 
                
                $count = total_rows(db_prefix().'projects',$where) ?? 0;

                $statuscount[] = $count;

                 $substatus = getsubstatus($statusid);

                if($substatus)
                { 
                foreach($substatus as $sub)
                {
                    $_wheresub = $subcount = '';
                    $_wheresub = ($_where == '' ? '' : $_where.' AND ').'status = '.$sub->id. $productcount;
                    $subcount = total_rows(db_prefix().'projects',$_wheresub); 
                    $statuscount[] = $subcount; 
                }
                }
                return array_sum($statuscount);      
    }


    function getstatuscountmaster($statusid)
    {
         $ci =& get_instance();

        $statuscount = []; 

        if($_SESSION['role']==2)
        {
            $clientlist = getclientlistclientid($_SESSION['staff_user_id']); 
        }

        $associationproductids = getproducts_user_association_ids();
            
             $_where = '';

              if($_SESSION['role']==3)
              {
              if(!has_permission('projects','','view')){
                  $_where = 'id IN (SELECT project_id FROM '.db_prefix().'project_members WHERE staff_id='.get_staff_user_id().')'; 
              }
              }
              else if($_SESSION['role']==2)
              {
                $_where = 'clientid IN ('.$clientlist.')';
              }

                $productcount ='';
                if($_SESSION['role']==5){
                $productcount = ' AND productid IN(10,62,96,105)';
                }else if($_SESSION['role']==4) {
                $productcount = ' AND productid IN('.$associationproductids.')'; 
                }
                $where = ($_where == '' ? '' : $_where.' AND ').'status = '.$statusid . $productcount;     
                $count = total_rows(db_prefix().'projects',$where);

                $statuscount[] = $count;
                
      return array_sum($statuscount); 
    }
    
    function getbrokerproiceforinvoiceonly($productid=0,$product_option_id=0)
    {
        $ci =& get_instance();
        $ci->db->from(db_prefix() .'products');
        $ci->db->where('id', $productid);
        $query = $ci->db->get();
        $productprice =$query->row_array(); 

        if(!empty($productprice))
        {
            if(!empty($product_option_id)){

            $ci =& get_instance();
            $ci->db->from(db_prefix() .'products_options');
            $ci->db->where('products_options_id', $product_option_id);
            $query = $ci->db->get();
            $subproductprice =$query->row_array(); 
                if($subproductprice){
                  $price = $subproductprice['sub_selling_price'];
                }
            }else{
                $price =$productprice['selling_price'];   
            }
        return $price;
        }
    }
    
    function cvf_convert_object_to_array($data) {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }

        if (is_array($data)) {
            return array_map(__FUNCTION__, $data);
        }
        else {
            return $data;
        }
    }


    function getstepcount($step_no=0)
    {
         $ci =& get_instance();
         $ci->db->select('order_credit_process_verify.id,projects.id');
         $ci->db->from(db_prefix() .'order_credit_process_verify');
         $ci->db->join(db_prefix() . 'projects', db_prefix() . 'projects.id= ' . db_prefix() . 'order_credit_process_verify.order_id');
        $ci->db->where('order_credit_process_verify.step_no', $step_no);
        $ci->db->where('projects.status <>',100);
        $query = $ci->db->get();
        $count = $query->result();
         //$count = $ci->common->select(db_prefix().'order_credit_process_verify',['step_no'=>$step_no]);
         $stepcount = ($count)?count($count):0;
         return $stepcount;
    }


    function gettaskcount($orderid='')
    {
        $ci =& get_instance();
         $count = $ci->common->select(db_prefix().'tasks',['rel_id'=>$orderid,'status !='=>5]);
         $stepcount = ($count)?count($count):0;
         return $stepcount;
    }

    function getnotescount($orderid='')
    {
         $ci =& get_instance();
         $count = $ci->common->select(db_prefix().'admin_notes',['project_id'=>$orderid]);
         $stepcount = ($count)?count($count):0;
         return $stepcount; 
    }

     function getsupportcount()
    {
        $ci =& get_instance();
        $gettickets  = $ci->support_model->gettickets();
        $stepcount = ($gettickets)?count($gettickets):0;
        return $stepcount; 
    }


    function validatedate($date)
    {
        if (strpos($date,'-') == true) 
        {
           $date1 = explode('-',$date);

           if(count($date1)>2)
           {
            $dnewdate =  $date1[1].'/'.$date1[2].'/'.$date1[0];
           }
           else
           {
              $dnewdate = $date;
           }
        }
        else
        {
             $dnewdate = $date;
        }
        return $dnewdate;
    }


    function getproductsteps($product_id)
    {
        $ci =& get_instance();
        $steps = $ci->common->getDynamicStepOfProducts($product_id);
        return $steps;
    }


    function getis_order_available($taskid)
    {
      $ci =& get_instance();
$task_order_steps = $ci->common_model->selectrow(db_prefix().'task_order_steps',['task_id'=>$taskid]);
return $task_order_steps;
    }

    function getorderclient($orderid='')
    {
    $ci =& get_instance();
    $projects = $ci->common_model->selectrow(db_prefix().'projects',['id'=>$orderid]);
        if($projects)
        {
             $name = orderusernameclient($projects->clientid);
        }
        return $name;
    }


function getlessonshome($courseid='',$section_id='')
{
        $ci =& get_instance();
        $ci->db->select('*')->from('lesson');
        $ci->db->where('course_id',$courseid);
        $ci->db->where('section_id',$section_id);
        $ci->db->order_by('order', 'asc');
        $query = $ci->db->get();
        return $query->result();
}


      function get_sectionhome($type_by, $id)
    {
         $ci =& get_instance();

        $ci->db->order_by("order", "asc");
        if ($type_by == 'course') {
            return $ci->db->get_where(db_prefix().'section', array('course_id' => $id));
        } elseif ($type_by == 'section') {
           return $ci->db->get_where(db_prefix().'section', array('id' => $id));
        }
    }
    
    /******get order details page*****/
    function get_orderOverview_detail($lession_id=0,$section_id=0,$course_id=0,$order_id=0)
    {
        $ci =& get_instance();
        $ci->load->model('order_model');
        $html_data = $ci->order_model->get_order_overview($lession_id,$section_id,$course_id,$order_id);
        return $html_data;
    }

    function getdomain($input='')
    {
    $input = trim($input, '/');
    if (!preg_match('#^http(s)?://#', $input)) {
    $input = 'http://' . $input;
    }
    $urlParts = parse_url($input);
    $domain = preg_replace('/^www\./', '', $urlParts['host']);
    return $domain;
    }

     function getmenuname($menuid)
    {
         $ci =& get_instance();
         $menu = $ci->common->selectrow(db_prefix().'menu',['menu_id'=>$menuid]);
         if($menu)
         return $menu->menu;   
    }


    function getfaqbytitleid($titleid=0)
    {
        $ci =& get_instance();
        $faq = $ci->common->select(db_prefix().'faq',['title_id'=>$titleid]);
        if($faq)
        return $faq; 
    }

    function getitems($membership_plan_id)
    {
       $ci =& get_instance();
       $items = $ci->common->select(db_prefix().'membership_item',['mebership_plan_id'=>$membership_plan_id]);
       if($items)
       return $items; 
    }

    function getspecficitem($id=0,$mebership_plan_id=0)
    {
       $ci =& get_instance();
       $items = $ci->common->selectrow(db_prefix().'membership_item',['mebership_plan_id'=>$mebership_plan_id,'title'=>$id]);
       if($items)
       return $items; 
    }

    function extract_domain($domain)
{
    if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches))
    {
        return $matches['domain'];
    } else {
        return $domain;
    }
}  
