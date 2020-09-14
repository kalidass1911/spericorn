<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends CI_Controller {


	function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->library('session');
     $this->load->model('Common_model','common');
  }


	public function login()
	{
		$this->load->view('login');
	}

	  function checkemilexist()
  {
  	if($_POST['email'] && !empty($_POST['email']))
	    {
	    	 $email = $_POST['email'];
	    	 $staff 	= $this->common->selectrow('user',['email'=>$email]);
             if($staff)
             echo json_encode(FALSE);
             else
             echo json_encode(TRUE);	
	    }
  }

  function loginusers()
  {
  	 $postdata = $this->input->post();
     if(!empty($postdata['emaillogin']) &&  !empty($postdata['passwordlogin']))
     {
             $email = trim($postdata['emaillogin']);
             $password = trim($postdata['passwordlogin']);
             $isUserExist = $this->common->selectrow('user',array('email' => $email,'password' => $password));

             if($isUserExist)
             {
                if($isUserExist->status==1)
                {
                  $this->session->set_userdata('name','virat');

                   $user_data = [
                        'staff_user_id' => $isUserExist->id,
                        'staff_logged_in' => true,
                        'role' => $isUserExist->role ?? 1,
                        'email' => $isUserExist->email,
                        'name' => $isUserExist->name,
                    ];

                 $this->session->set_userdata($user_data);

                 if($isUserExist->role==1)
                 redirect('site/userlist');
                 else
                 redirect('site/userprofile');

                }
                else if($isUserExist->status==3)
                {
                	 $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Waiting for Admin persmission.</div>');
             	redirect('site/login');	
                }	
                else
                {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Account deactivated ! Please contact Admin.</div>');
             	redirect('site/login');	
             }
             }
             else
             {
             	$this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">Invalid Email and password</div>');
             	redirect('site/login');
             }
     }

  }


  function deleteuser($id)
  {
       $where  = ['id'=>$id];
       $response = $this->common->delete_data($where,'user');
        if ($response == true) 
        {
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">User has been Deleted Successfully</div>');
        } 
        redirect($_SERVER['HTTP_REFERER']);
  }




   function saveUsers(){
    	$postdata = $this->input->post();
		try{
			if(!empty($postdata['name']) &&  !empty($postdata['email']) && !empty($postdata['password']) && !empty($postdata['address']))
			{
				$is_email_exist =0;
				$email = trim($postdata['email']);
				if(!empty($email)){
					$isUserExist = $this->common->selectrow('user',array('email' => $email));
					if(!empty($isUserExist)){
						throw new Exception('Email is already exsit!');
					}else{
						$is_email_exist =0;
					}
				}

				$insertData['role'] 		= 2;
				$insertData['name'] 		= $this->input->post('name');
				$insertData['email'] 			= $this->input->post('email');
				$insertData['password'] 		= $this->input->post('password');
				$insertData['address'] = $this->input->post('address');
				$insertData['status'] = 3;
				$insertData['datecreated'] 		= date('Y-m-d H:i:s');
				 $staff_id = $this->common->insert('user',$insertData);
			$this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Registration has been completed Successfully</div>');
				redirect('site/login');
			}
		}catch(Exception $e){
			$this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">'.$e->getMessage().'</div>');
			redirect('site/login');
		}
    }


    function userlist()
    {
    	if($_SESSION['staff_user_id'] && $_SESSION['role'])
    	{
    	 $data['userlist'] = $this->common->select('user',array('role' =>2));

    	  $data['user'] = $this->common->selectrow('user',array('id' =>$_SESSION['staff_user_id']));

          $this->load->view('userlist',$data);
       }
       else
       {
       	redirect('site/login');
       }
    }

    function  userprofile()
    {
    	if($this->input->post())
    	{
            $postdata = $this->input->post();

             if(!empty($_FILES["image"]["name"]))
               {   
                $fileExt = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $uploadPath = './uploads/user/';
                if(!file_exists($uploadPath)){
                    mkdir($uploadPath, 0777, true);
                }
                $savepath = '/uploads/user/';

                $image = preg_replace('/[^a-zA-Z0-9.]/', '', str_replace(' ', '-',$_FILES["image"]["name"]));
                $image = preg_replace("/\W(?=.*\.[^.]*$)/", "_",$image);
                $uniqueID                 = uniqid();
                $img                     = $uniqueID.'_'.$image;
                $img_unique              = basename($img);
                $config['upload_path']   = $uploadPath;
                $config['allowed_types'] = 'jpg|gif|png|jpeg|JPG|PNG||pdf';
                $config['file_name']     = $img_unique;  
                $this->load->library("upload", $config);
                $this->upload->initialize($config);
                if(!$this->upload->do_upload("image",$img_unique)){
                    echo $this->upload->display_errors();die;
                }
                else{
                    $image =base_url().$savepath.''.$img_unique;
                }
           }
           else
            {
            $image = $postdata['image_old'];
            }

           $name = $postdata['name'];
           $address = $postdata['address'];
           $updatedata = ['name'=>$name,'address'=>$address,'image'=>$image];
          $this->common->updatedata('user',$updatedata,['id' =>$_SESSION['staff_user_id']]);

         $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">Profile has been updated Successfully</div>');

           redirect($_SERVER['HTTP_REFERER']);
    	}

    	if($_SESSION['staff_user_id'] && $_SESSION['role'])
    	{
         $data['user'] = $this->common->selectrow('user',array('id' =>$_SESSION['staff_user_id']));

    	 $this->load->view('userprofile',$data);
    	}
    	else
    	{
    		redirect('site/login');
    	}
    }



    public function logout()
    {
    	unset($_SESSION['staff_user_id']);
    	unset($_SESSION['staff_logged_in']);
    	unset($_SESSION['role']);
    	unset($_SESSION['email']);
    	unset($_SESSION['name']);
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
         $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('is_admin_login'); 
        $this->session->unset_userdata('a_session_id');     
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('site/login', 'refresh');
    }


    function updatestatus()
    {
    	$postdata = $this->input->post();

    	if($postdata)
    	{
         $updatedata = ['status'=>$postdata['status']];
         $this->common->updatedata('user',$updatedata,['id' =>$postdata['id']]);
          echo "success";
    	}
    }


    function viewuser()
    {
    	$postdata = $this->input->post();

         $data['user'] = $this->common->selectrow('user',array('id' =>$postdata['id'])); 

         echo $this->load->view('viewuser',$data,true); 
    }


}
