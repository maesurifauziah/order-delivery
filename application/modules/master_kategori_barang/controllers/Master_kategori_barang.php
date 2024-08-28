<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Master_kategori_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Master_kategori_barang_model',
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
        $this->load->view('master_kategori_barang_view', $data);
    }

    public function master_kategori_barang_list()
    {
        $list = $this->Master_kategori_barang_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $list) {
            ++$no;
            $row = array();
            $row[] = $no;
            $row[] = $list->kategori_id;
            $row[] = $list->kategori_desc;
            $row[] = $list->urutan;
            $row[] = $list->status;

            $select = '';
            $select .='
                <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                    data-kategori_id="'.$list->kategori_id.'" 
                    data-kategori_desc="'.$list->kategori_desc.'"
                    data-urutan="'.$list->urutan.'"
                    ><i class="fas fa-eye"></i></a> 
					
				<a href="javascript:void(0);" class="edit_record btn btn-primary btn-xs" 
                    data-kategori_id="'.$list->kategori_id.'" 
                    data-kategori_desc="'.$list->kategori_desc.'" 
                    data-urutan="'.$list->urutan.'" 
                    ><i class="fas fa-edit"></i></a> ';

            if ($list->status == 'y'){
                $select .='<a href="javascript:void(0);" class="delete_record btn btn-danger btn-xs" 
                    data-kategori_id="'.$list->kategori_id.'" 
                    data-kategori_desc="'.$list->kategori_desc.'""
                    data-urutan="'.$list->urutan.'""
                    ><i class="fas fa-ban"></i></a> ';
            }
			else{
                $select .='<a href="javascript:void(0);" class="reactive_record btn btn-success btn-xs" 
                    data-kategori_id="'.$list->kategori_id.'" 
                    data-kategori_desc="'.$list->kategori_desc.'"
                    data-urutan="'.$list->urutan.'"
                    ><i class="fas fa-sync"></i></a> ';
			}

            $row[] = $select;

            
            $data[] = $row;
        }

        $output = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $this->Master_kategori_barang_model->count_all(),
                        'recordsFiltered' => $this->Master_kategori_barang_model->count_filtered(),
                        'data' => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function add()
    {
		$this->_validate('add');

        $data = array(
            'kategori_id' => $this->Master_kategori_barang_model->generateIKategori(),
            'kategori_desc' => $this->input->post('kategori_desc', true),
            'urutan' => $this->input->post('urutan', true),
        );
        $insert = $this->Master_kategori_barang_model->save($data);
        if ($insert){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'Master_kategori_barang',
                'activity'=>'create merk',
                'keterangan'=>'create merk '.$data['kategori_desc'],
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

       $id = $this->input->post('kategori_id', true);
        $data = array(
            'kategori_desc' => $this->input->post('kategori_desc', true),
            'urutan' => $this->input->post('urutan', true),
        );
        $this->Master_kategori_barang_model->update(array('kategori_id' => $id), $data);
        echo json_encode(array('status' => true));
    }

    public function nonactive(){
        $kategori_id = $this->input->post('kategori_id', true);
        $data = array(
            'status' => 'n',
        );
        $nonactive = $this->Master_kategori_barang_model->update(array('kategori_id' => $kategori_id), $data);
        if ($nonactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_kategori_barang',
                'activity'=>'nonactive master_kategori_barang',
                'keterangan'=>'nonactive '.$kategori_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function reactive(){
        $kategori_id = $this->input->post('kategori_id', true);
        $data = array(
            'status' => 'y',
        );
        $reactive = $this->Master_kategori_barang_model->update(array('kategori_id' => $kategori_id), $data);
        if ($reactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_kategori_barang',
                'activity'=>'reactive master_kategori_barang',
                'keterangan'=>'reactive '.$kategori_id,
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

        if ($this->input->post('kategori_desc') == '') {
            $data['inputerror'][] = 'kategori_desc';
            $data['error_string'][] = 'Tipe Kendaraan harus diisi';
            $data['status'] = false;
        }
        if ($this->input->post('urutan') == '') {
            $data['inputerror'][] = 'urutan';
            $data['error_string'][] = 'Urutan harus diisi';
            $data['status'] = false;
        }
        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
}
