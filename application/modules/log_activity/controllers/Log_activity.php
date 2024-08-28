<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Log_activity extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Log_activity_model',
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

        $this->load->view('log_activity_view', $data);
    }

    public function log_activity_list()
    {
        // if (!$this->session->userdata('barang')) {
        //     return;
        // }
        $list = $this->Log_activity_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $list) {
            ++$no;
            $row = array();
            $row[] = $no;
            $row[] = $list->activityID;
            $row[] = $list->createdDate;
            $row[] = $list->userid;
            $row[] = $list->nama_lengkap;
            $row[] = $list->ip;
            $row[] = $list->modul;
            $row[] = $list->activity;
            $row[] = $list->keterangan;
            //$row[] = $list->status;
           
            $data[] = $row;
        }

        $output = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $this->Log_activity_model->count_all(),
                        'recordsFiltered' => $this->Log_activity_model->count_filtered(),
                        'data' => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        // if (!$this->session->userdata('barang_edit')) {
        //     return;
        // }
        $row = $this->Log_activity_model->get_by_id($id);
        echo json_encode($row);
    }
}