<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Admin_group_user extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Admin_group_user_model',
            
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
          
        ];
        $this->load->view('admin_group_user_view', $data);
    }

    public function admin_group_user_list()
    {
        $list = $this->Admin_group_user_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $list) {
            $data_bind = '
                data-user_group="'.$list->user_group.'" 
                data-group_name="'.$list->group_name.'" 
                data-aktif="'.$list->aktif.'"  
            ';
            
            ++$no;
            $row = array();
            $row[] = $no;
            $row[] = $list->user_group;
            $row[] = $list->group_name;
            if($list->aktif == 'y'){
                $row[] = 'YES';
            } else {
                $row[] = 'NO';
            }

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
                'recordsTotal' => $this->Admin_group_user_model->count_all(),
                'recordsFiltered' => $this->Admin_group_user_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add()
    {      
        $this->_validate('add');
        $kode=$this->Admin_group_user_model->generateIDUserGroup();
        
        $header = array(
			'user_group' => $kode,
            'group_name' => $this->input->post('group_name', true),
            'aktif' => 'y',
            'createdDate' => date('Y-m-d H:i:s'),
        );
       
        $insert = $this->Admin_group_user_model->save($header);
        if ($insert){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'admin_group_user',
                'activity'=>'create admin group user',
                'keterangan'=>'create admin group user '.$header['user_group'],
                'createdDate'=>date('Y-m-d h:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function update()
    {

        $header = array(
            'group_name' => $this->input->post('group_name_edit', true),
            'modifiedDate' => date('Y-m-d H:i:s'),
        );
		
        $where = array('user_group' => $user_group);
       
        $update = $this->Admin_group_user_model->update($where, $header);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'admin_group_user',
                'activity'=>'edit admin group user',
                'keterangan'=>'edit admin group user '.$user_group,
                'createdDate'=>date('Y-m-d h:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }

       echo json_encode(array('status' => true));
    }

    public function nonactive()
    {
        $id = $this->input->get('id', true);
        $data = array(
            'aktif' => 'n',
        );
        $nonactive = $this->Admin_group_user_model->update(array('user_group' => $id), $data);
        if ($nonactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'admin_group_user',
                'activity'=>'nonactive admin_group_user',
                'keterangan'=>'nonactive '.$id,
                'createdDate'=>date('Y-m-d h:i:s'),
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
        $reactive = $this->Admin_group_user_model->update(array('user_group' => $id), $data);
        if ($reactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'admin_group_user',
                'activity'=>'reactive admin_group_user',
                'keterangan'=>'reactive '.$id,
                'createdDate'=>date('Y-m-d h:i:s'),
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
        
       
        if ($this->input->post('group_name') == '') {
            $data['inputerror'][] = 'group_name';
            $data['error_string'][] = 'Group Name is required';
            $data['status'] = false;
        }
      

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
}