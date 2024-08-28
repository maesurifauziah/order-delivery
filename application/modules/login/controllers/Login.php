<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Login_model',
            'admin_user_apps/Admin_user_apps_model',
            'log_activity/Log_activity_model',
        ));
    }

    public function index()
    {
       
        if ($this->session->userdata('logged_in')) {
            redirect(base_url(), 'refresh');
        } elseif ($this->session->userdata('lockscreen')) {
            redirect(base_url('login/lockscreen'), 'refresh');
        }
        $data = [
            'group_user'=>$this->Admin_user_apps_model->get_list_group_user(),
        ];
        $this->load->view('login_view', $data);
        
    }

    public function auth()
    {
        $user_name = $this->db->escape($this->input->post('user_name'));
        $password = $this->db->escape($this->input->post('password'));
        
        $login = $this->Login_model->login($user_name, $password);
        if ($login == true) {
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'login',
                'activity'=>'user login',
                'keterangan'=>'user login',
                'createdDate'=>date('Y-m-d H:i:s'),
                'ip'=>$this->input->ip_address(),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
            redirect(base_url(), 'refresh');
        } else {
            $this->session->set_flashdata('msg_status', 'danger');
            $this->session->set_flashdata('msg', 'Username / Password Incorrect!!!');
            redirect(base_url('login'), 'refresh');
        }
    }

    public function authback()
    {
        $user_name = $this->db->escape($this->input->post('user_name'));
        $password = $this->db->escape($this->input->post('password'));
        
        $login = $this->Login_model->login($user_name, $password);
        if ($login == true) {
            $data = array(
                'lockscreen' => false,
            );
            $this->session->set_userdata($data);
            redirect(base_url(), 'refresh');
        } else {
            $this->session->set_flashdata('msg_status', 'danger');
            $this->session->set_flashdata('msg', 'Password Incorrect!!!');
            redirect(base_url('login/lockscreen'), 'refresh');
        }
    }

    public function lockscreen()
    {
        $lockscreen = false;
        if ($this->session->userdata('user_name')!='') {
            $lockscreen = true;
        }
        $data = array(
            'lockscreen' => $lockscreen,
        );
        $this->session->set_userdata($data);
        if ($this->session->userdata('user_name')=='') {
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'login',
                'activity'=>'user lockscreen',
                'keterangan'=>'user lockscreen',
                'createdDate'=>date('Y-m-d H:i:s'),
                'ip'=>$this->input->ip_address(),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
            redirect(base_url('login'), 'refresh');
        }
        
        $this->load->view('login_lockscreen_view');
    }

    public function logout()
    {
        $logdata = array(
            'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
            'userid'=>$this->session->userdata('userid'),
            'modul'=>'login',
            'activity'=>'user logout',
            'keterangan'=>'user logout',
            'createdDate'=>date('Y-m-d H:i:s'),
            'ip'=>$this->input->ip_address(),
            'status'=>'y',
        );
        $this->Log_activity_model->save($logdata);
        $this->Login_model->logout();
        $this->session->set_flashdata('msg_status', 'success');
        $this->session->set_flashdata('msg', 'Logout Successfully...');
        redirect(base_url('login'), 'refresh');
    }

    public function backlogin()
    {
        $this->Login_model->logout();
        redirect(base_url('login'), 'refresh');
    }

    public function register()
    {
        $this->_validate();
        $password = $this->input->post('password');
        $data = array(
            'userid' => $this->Admin_user_apps_model->generateIDUser(),
            'user_name' => $this->input->post('user_name', true),
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'password' => md5(sha1($password)),
            'tgl_insert'=>date('Y-m-d H:i:s'),
            'user_insert' => $this->Admin_user_apps_model->generateIDUser(),
            'user_group' => $this->input->post('user_group', true),
            'alamat' => $this->input->post('alamat', true),
            'daerah' => $this->input->post('daerah', true),
            'no_hp' => $this->input->post('no_hp', true),
            'aktif' => 'y',
        );
        $insert = $this->Admin_user_apps_model->save($data);
        if ($insert){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->Admin_user_apps_model->generateIDUser(),
                'modul'=>'login',
                'activity'=>'create akun',
                'keterangan'=>'create akun '.$this->Admin_user_apps_model->generateIDUser(),
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }

        // echo json_encode($data);
        echo json_encode(array('status' => true));
        // redirect(base_url('login'), 'refresh');
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;
        
       
        if ($this->input->post('nama_lengkap') == '') {
            $data['inputerror'][] = 'nama_lengkap';
            $data['error_string'][] = 'Nama harus diisi!';
            $data['status'] = false;
        }
        if ($this->input->post('user_name') == '') {
            $data['inputerror'][] = 'user_name';
            $data['error_string'][] = 'User Name harus diisi!';
            $data['status'] = false;
        }
        if ($this->input->post('password') == '') {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password harus diisi!';
            $data['status'] = false;
        }
        if ($this->input->post('confirm_password') == '') {
            $data['inputerror'][] = 'confirm_password';
            $data['error_string'][] = 'Ulang Password harus diisi!';
            $data['status'] = false;
        }
        if ($this->input->post('user_group') == '') {
            $data['inputerror'][] = 'user_group';
            $data['error_string'][] = 'Group User harus diisi!';
            $data['status'] = false;
        }
        if ($this->input->post('alamat') == '') {
            $data['inputerror'][] = 'alamat';
            $data['error_string'][] = 'Alamat harus diisi!';
            $data['status'] = false;
        }
        if ($this->input->post('daerah') == '') {
            $data['inputerror'][] = 'daerah';
            $data['error_string'][] = 'Daerah harus diisi!';
            $data['status'] = false;
        }
        if ($this->input->post('no_hp') == '') {
            $data['inputerror'][] = 'no_hp';
            $data['error_string'][] = 'No Hp harus diisi!';
            $data['status'] = false;
        }
       

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
  
}
