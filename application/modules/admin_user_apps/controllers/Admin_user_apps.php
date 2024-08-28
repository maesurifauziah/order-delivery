<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Admin_user_apps extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Admin_user_apps_model',
            'log_activity/Log_activity_model',
        ));
        $this->load->library(array(
            'form_validation',
        ));
        if (!$this->session->userdata('logged_in')) {
        	redirect('login', 'refresh');
        }
    }

    public function index()
    {
        // if (!$this->session->userdata('barang')) {
        //     return;
        // }
        $data = [
            'group_user'=>$this->Admin_user_apps_model->get_list_group_user(),
        ];
        $this->load->view('admin_user_apps_view', $data);
    }

    public function admin_user_apps_list()
    {
        $list = $this->Admin_user_apps_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $list) {
            ++$no;
            $row = array();
            $row[] = $no;
            $row[] = $list->userid;
            $row[] = $list->user_name;
            $row[] = $list->nama_lengkap;
            $row[] = $list->tgl_insert;
            $row[] = $list->tgl_last_login;
            $row[] = $list->group_name;
            $row[] = $list->daerah;
            $row[] = $list->alamat;
            $row[] = $list->no_hp;
            $row[] = $list->aktif;

            $data_bind = '
                        data-userid="'.$list->userid.'" 
                        data-user_name="'.$list->user_name.'" 
                        data-nama_lengkap="'.$list->nama_lengkap.'" 
                        data-tgl_insert="'.$list->tgl_insert.'" 
                        data-tgl_last_login="'.$list->tgl_last_login.'" 
                        data-user_insert="'.$list->user_insert.'" 
                        data-user_group="'.$list->user_group.'"  
                        data-aktif="'.$list->aktif.'"  
                        data-alamat="'.$list->alamat.'"  
                        data-daerah="'.$list->daerah.'"  
                        data-no_hp="'.$list->no_hp.'"  
                        data-group_name="'.$list->group_name.'"  
            ';

            $select = '';
            $select .='
                <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                '.$data_bind.'
                ><i class="fas fa-eye"></i></a> 

                <a href="javascript:void(0);" class="edit_record btn btn-primary btn-xs" 
                '.$data_bind.'
                ><i class="fas fa-edit"></i></a> 

               
            ';
            if ($list->aktif == 'y'){
                $select .='
                    <a href="javascript:void(0);" class="nonactive_record btn btn-danger btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-ban"></i></a>
                ';
            } else {
                $select .='
                    <a href="javascript:void(0);" class="reactive_record btn btn-success btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-sync"></i></a> 
                ';
            }
           
            
            
            $row[] = $select;

            $data[] = $row;
        }

        $output = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $this->Admin_user_apps_model->count_all(),
                        'recordsFiltered' => $this->Admin_user_apps_model->count_filtered(),
                        'data' => $data,
                );
        //output to json format
        echo json_encode($output);
    }
  
    

   

    public function add()
    {
        $this->_validate();
        $password = $this->input->post('password');
        $data = array(
            // 'userid' => $this->input->post('userid', true),
            'userid' => $this->Admin_user_apps_model->generateIDUser(),
            'user_name' => $this->input->post('user_name', true),
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'password' => md5(sha1($password)),
            'tgl_insert'=>date('Y-m-d H:i:s'),
            'user_insert' => $this->session->userdata('user_name'),
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
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'admin_user_apps',
                'activity'=>'create admin user app',
                'keterangan'=>'create admin user app ID '.$this->input->post('userid', true),
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }

        // echo json_encode($data);
        echo json_encode(array('status' => true));
    }

    public function update()
    {
       $this->_validate();
       $id = $this->input->post('userid', true);
        $data = array(
            'user_name' => $this->input->post('user_name', true),
            'nama_lengkap' => $this->input->post('nama_lengkap', true),
            'tgl_last_login'=>date('Y-m-d H:i:s'),
            'user_insert' => $this->session->userdata('user_name'),
            'user_group' => $this->input->post('user_group', true),
            'alamat' => $this->input->post('alamat', true),
            'daerah' => $this->input->post('daerah', true),
            'no_hp' => $this->input->post('no_hp', true),
        );

        $update = $this->Admin_user_apps_model->update(array('userid' => $id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'admin_user_apps',
                'activity'=>'update admin user app',
                'keterangan'=>'update admin user app ID '.$this->input->post('userid', true),
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }

        // echo json_encode($id);
        echo json_encode(array('status' => true));
    }

    public function nonactive()
    {
        $id = $this->input->get('id', true);
        $data = array(
            'aktif' => 'n',
        );
        $nonactive = $this->Admin_user_apps_model->update(array('userid' => $id), $data);
        if ($nonactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'admin_user_apps',
                'activity'=>'nonactive admin_user_apps',
                'keterangan'=>'nonactive '.$id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function reactive(){
        $id = $this->input->get('id', true);
        $data = array(
            'aktif' => 'y',
        );
        $reactive = $this->Admin_user_apps_model->update(array('userid' => $id), $data);
        if ($reactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'admin_user_apps',
                'activity'=>'reactive admin_user_apps',
                'keterangan'=>'reactive '.$id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }
    

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;
        
       
        // if ($this->input->post('app_name_ci') == '') {
        //     $data['inputerror'][] = 'app_name_ci';
        //     $data['error_string'][] = 'Application Name is required';
        //     $data['status'] = false;
        // }
        // if ($this->input->post('full_app_name') == '') {
        //     $data['inputerror'][] = 'full_app_name';
        //     $data['error_string'][] = 'Full Name Application is required';
        //     $data['status'] = false;
        // }
        // if ($this->input->post('description') == '') {
        //     $data['inputerror'][] = 'description';
        //     $data['error_string'][] = 'Description is required';
        //     $data['status'] = false;
        // }
        // if ($this->input->post('base_folder') == '') {
        //     $data['inputerror'][] = 'base_folder';
        //     $data['error_string'][] = 'Base Folder is required';
        //     $data['status'] = false;
        // }
        // if ($this->input->post('icon_ci') == '') {
        //     $data['inputerror'][] = 'icon_ci';
        //     $data['error_string'][] = 'Icon is required';
        //     $data['status'] = false;
        // }
        // if ($this->input->post('seq_ci') == '') {
        //     $data['inputerror'][] = 'seq_ci';
        //     $data['error_string'][] = 'Sequence is required';
        //     $data['status'] = false;
        // }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
    public function get_list_user_by_id_kantor($oid)
    {
        $data = $this->Admin_user_apps_model->get_list_user_by_id_kantor($oid);
        echo json_encode($data);
    }

    public function get_list_user_by_id_kantor_access()
    {
        $typeTerm = $this->input->post('typeTerm', true);
        $searchTerm = $this->input->post('searchTerm', true);
        $data = $this->Admin_user_apps_model->get_list_user_by_id_kantor_access($typeTerm, $searchTerm);
        $datasource = [];
        $datasource [] = array(
            'id'=>0,
            'text'=>'- Pilih Karyawan -',
        );
        foreach($data as $data){
            $datasource [] = array(
                'id'=>$data->userid,
                'text'=>$data->nama_lengkap,
            );
        }
        echo json_encode($datasource);
    }
}