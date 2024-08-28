<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Master_tipe_kendaraan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Master_tipe_kendaraan_model',
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
        $data = [];
        $this->load->view('master_tipe_kendaraan_view', $data);
    }

    public function master_tipe_kendaraan_list()
    {
        $list = $this->Master_tipe_kendaraan_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $list) {
            ++$no;
            $row = array();
            $row[] = $no;
            $row[] = $list->tipe_id;
            $row[] = $list->tipe_desc;
            $row[] = $list->siet;
            $row[] = $list->status;

            $select = '';
            $select .='
                <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                    data-tipe_id="'.$list->tipe_id.'" 
                    data-tipe_desc="'.$list->tipe_desc.'"
                    data-siet="'.$list->siet.'"
                    ><i class="fas fa-eye"></i></a> 
					
				<a href="javascript:void(0);" class="edit_record btn btn-primary btn-xs" 
                    data-tipe_id="'.$list->tipe_id.'" 
                    data-tipe_desc="'.$list->tipe_desc.'" 
                    data-siet="'.$list->siet.'" 
                    ><i class="fas fa-edit"></i></a> ';

            if ($list->status == 'y'){
                $select .='<a href="javascript:void(0);" class="delete_record btn btn-danger btn-xs" 
                    data-tipe_id="'.$list->tipe_id.'" 
                    data-tipe_desc="'.$list->tipe_desc.'""
                    data-siet="'.$list->siet.'""
                    ><i class="fas fa-ban"></i></a> ';
            }
			else{
                $select .='<a href="javascript:void(0);" class="reactive_record btn btn-success btn-xs" 
                    data-tipe_id="'.$list->tipe_id.'" 
                    data-tipe_desc="'.$list->tipe_desc.'"
                    data-siet="'.$list->siet.'"
                    ><i class="fas fa-sync"></i></a> ';
			}

            $row[] = $select;

            
            $data[] = $row;
        }

        $output = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $this->Master_tipe_kendaraan_model->count_all(),
                        'recordsFiltered' => $this->Master_tipe_kendaraan_model->count_filtered(),
                        'data' => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function add()
    {
		$this->_validate('add');

        $data = array(
            'tipe_id' => $this->Master_tipe_kendaraan_model->generateIDTP(),
            'tipe_desc' => $this->input->post('tipe_desc', true),
            'siet' => $this->input->post('siet', true),
        );
        $insert = $this->Master_tipe_kendaraan_model->save($data);
        if ($insert){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'Master_tipe_kendaraan',
                'activity'=>'create merk',
                'keterangan'=>'create merk '.$data['tipe_desc'],
                'createdDate'=>date('Y-m-d h:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function update()
    {
	   $this->_validate('update');

       $id = $this->input->post('tipe_id', true);
        $data = array(
            'tipe_desc' => $this->input->post('tipe_desc', true),
            'siet' => $this->input->post('siet', true),
        );
        $this->Master_tipe_kendaraan_model->update(array('tipe_id' => $id), $data);
        echo json_encode(array('status' => true));
    }

    public function nonactive(){
        $tipe_id = $this->input->post('tipe_id', true);
        $data = array(
            'status' => 'n',
        );
        $nonactive = $this->Master_tipe_kendaraan_model->update(array('tipe_id' => $tipe_id), $data);
        if ($nonactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_tipe_kendaraan',
                'activity'=>'nonactive master_tipe_kendaraan',
                'keterangan'=>'nonactive '.$tipe_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function reactive(){
        $tipe_id = $this->input->post('tipe_id', true);
        $data = array(
            'status' => 'y',
        );
        $reactive = $this->Master_tipe_kendaraan_model->update(array('tipe_id' => $tipe_id), $data);
        if ($reactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_tipe_kendaraan',
                'activity'=>'reactive master_tipe_kendaraan',
                'keterangan'=>'reactive '.$tipe_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    private function _validate($act)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;

        if ($this->input->post('tipe_desc') == '') {
            $data['inputerror'][] = 'tipe_desc';
            $data['error_string'][] = 'Tipe Kendaraan is required';
            $data['status'] = false;
        }
        if ($this->input->post('siet') == '') {
            $data['inputerror'][] = 'siet';
            $data['error_string'][] = 'Kapasitas is required';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
}
