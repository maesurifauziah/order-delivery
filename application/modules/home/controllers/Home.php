<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Home_model',
            'login/Login_model',
            'log_activity/Log_activity_model',
        ));
        $this->load->library('user_agent');
        if (!$this->session->userdata('logged_in')) {
            redirect(base_url('login'), 'refresh');
        } elseif ($this->session->userdata('lockscreen')) {
            redirect(base_url('login/lockscreen'), 'refresh');
        }
    }

    public function index()
    {
        
        $data = [
            'title'=>'WBA | Home',
        ];
        
        $mobile=$this->agent->is_mobile();
        if($mobile){
            $this->load->view('home_mobile_view', $data);
        } else {
            $this->load->view('home_view', $data);
        }
       
        
        
    }

    public function change_password()
    {
        $data = [
            'status' => false,
            'message' => 'Password Old / New Incorrect!!!',
        ];
        $id = $this->db->escape($this->input->post('userid'));
        $password1 = $this->db->escape($this->input->post('password1'));
        $password2 = $this->db->escape($this->input->post('password2'));
        $password3 = $this->db->escape($this->input->post('password3'));

        $check = $this->Login_model->check_password($id, $password1, $password2, $password3);
        if ($check == true) {
            $change = $this->Login_model->change_password($id, $password1, $password2, $password3);
            if ($change == true) {
                $logdata = array(
                    'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                    'userid'=>$this->session->userdata('userid'),
                    'modul'=>'login',
                    'activity'=>'user change password',
                    'keterangan'=>'user change password',
                    'createdDate'=>date('Y-m-d H:i:s'),
                    'ip'=>$this->input->ip_address(),
                    'status'=>'y',
                );
                $this->Log_activity_model->save($logdata);
                $data = [
                    'status' => true,
                    'message' => 'Change Password Success...',
                ];
            } else {
                $data = [
                    'status' => false,
                    'message' => 'Change Password Failed!!!',
                ];
            }
        }
        header('Content-Type: application/json');
        echo json_encode($data);
    }
  
}
