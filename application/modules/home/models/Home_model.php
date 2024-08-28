<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home_model extends CI_Model
{
    public function upload_file_excel($filename)
    {
        $this->load->library('upload');
        if (!is_dir('upload')) {
            mkdir('upload', 0777, true);
        }
        if (!is_dir('upload/excel')) {
            mkdir('upload/excel', 0777, true);
        }
        $config['upload_path'] = 'upload/excel';
        $config['allowed_types'] = 'xls|xlsx';
        // $config['max_size']	= '2048';
        $config['overwrite'] = true;
        //   $filename= $_FILES["file_excel"]["name"];
        $config['file_name'] = $filename;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('file_excel')) {
            $res = array('status' => true, 'file' => $this->upload->data(), 'error' => '');
            return $res;
        } else {
            $res = array('status' => false, 'file' => '', 'error' => $this->upload->display_errors());
            return $res;
        }
    }
}
