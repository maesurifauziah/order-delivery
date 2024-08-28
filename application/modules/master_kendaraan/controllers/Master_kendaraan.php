<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Master_kendaraan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Master_kendaraan_model',
            'master_tipe_kendaraan/Master_tipe_kendaraan_model',
            'home/Home_model',
            'log_activity/Log_activity_model',
        ));
        $this->load->library(array(
            'form_validation',
            'datenumberconverter',
        ));
        if (!$this->session->userdata('logged_in')) {
        	redirect('login', 'refresh');
        }
    }

    public function index()
    {
        // if (!$this->session->userdata('kendaraan')) {
        //     return;
        // }
        $data = [
            'tipe_kendaraan' => $this->Master_tipe_kendaraan_model->get_list_master_tipe_kendaraan(),
        ];
        $this->load->view('master_kendaraan_view', $data);
    }

    public function master_kendaraan_list()
    {
        $list = $this->Master_kendaraan_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $list) {
            
            $data_bind = '
                data-kendaraan_id="'.$list->kendaraan_id.'" 
                data-photo="'.$list->photo.'" 
                data-nama_kendaraan="'.$list->nama_kendaraan.'"  
                data-merk_kendaraan="'.$list->merk_kendaraan.'" 
                data-deskripsi_kendaraan="'.$list->deskripsi_kendaraan.'" 
                data-tahun_kendaraan="'.$list->tahun_kendaraan.'" 
                data-kapasitas_kendaraan="'.$list->kapasitas_kendaraan.'" 
                data-harga_kendaraan="'.$list->harga_kendaraan.'" 
                data-warna_kendaraan="'.$list->warna_kendaraan.'" 
                data-bensin_kendaraan="'.$list->bensin_kendaraan.'" 
                data-no_polisi="'.$list->no_polisi.'" 
                data-status_sewa="'.$list->status_sewa.'" 
                data-status="'.$list->status.'" 
                data-path_photo="'.base_url('upload/master_kendaraan/'.$list->photo).'" 
            ';
            
            ++$no;
            $row = array();
            $row[] = $no;
            $row[] = $list->kendaraan_id;
            if($list->photo)
                $row[] = '<a href="#" ><img src="'.base_url('upload/master_kendaraan/'.$list->photo).'" class="img-responsive" style="width: 100%; max-width: 100px; height: auto;" /></a>';
            else
                $row[] = '(No photo)';
            $row[] = $list->nama_kendaraan;
            $row[] = $list->merk_kendaraan;
            $row[] = $list->deskripsi_kendaraan;
            $row[] = $list->tahun_kendaraan;
            $row[] = $list->kapasitas_kendaraan;
            $row[] = $this->datenumberconverter->formatRupiah($list->harga_kendaraan);
            $row[] = $list->warna_kendaraan;
            $row[] = $list->no_polisi;
            if($list->status_sewa == 'y'){
                $row[] = 'Disewa';
            } else {
                $row[] = 'Belum disewa';
            }
            if($list->status == 'y'){
                $row[] = 'Active';
            } else {
                $row[] = 'Non Active';
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
            if ($list->status == 'y'){
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
                'recordsTotal' => $this->Master_kendaraan_model->count_all(),
                'recordsFiltered' => $this->Master_kendaraan_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function add()
    {
        $this->_validate();
     
        $data = array(
            'kendaraan_id' => $this->Master_kendaraan_model->generateIDKendaraan(),
            'nama_kendaraan' => $this->input->post('nama_kendaraan', true),
            'merk_kendaraan' => $this->input->post('merk_kendaraan', true),
            'deskripsi_kendaraan' => $this->input->post('deskripsi_kendaraan', true),
            'tahun_kendaraan' => $this->input->post('tahun_kendaraan', true),
            'kapasitas_kendaraan' => $this->input->post('kapasitas_kendaraan', true),
            'harga_kendaraan' => str_replace(".",'',$this->input->post('harga_kendaraan', true)),
            'warna_kendaraan' => $this->input->post('warna_kendaraan', true),
            'bensin_kendaraan' => $this->input->post('bensin_kendaraan', true),
            'no_polisi' => $this->input->post('no_polisi', true),
            'createdDate'=>date('Y-m-d H:i:s'),
        );
        if (!empty($_FILES['photo']['name'])) {
            $photo = $_FILES['photo']['name'];
            $extension_file = pathinfo($photo, PATHINFO_EXTENSION);
            $file = $this->Master_kendaraan_model->upload_file(str_replace("/", "", $data['kendaraan_id'] . "." . $extension_file));
            $data['photo'] = str_replace("/", "", $data['kendaraan_id'] . "." . $extension_file);
        } else {
            echo json_encode(array('status' => false, 'msg' => '"Attachment" harus dipilih...'));
            return;
        }
        $insert = $this->Master_kendaraan_model->save($data);
        if ($insert){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_kendaraan',
                'activity'=>'create admin user app',
                'keterangan'=>'create admin user app ID '.$this->input->post('kendaraan_id', true),
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
       $id = $this->input->post('kendaraan_id', true);
       $data = array(
            'nama_kendaraan' => $this->input->post('nama_kendaraan', true),
            'merk_kendaraan' => $this->input->post('merk_kendaraan', true),
            'deskripsi_kendaraan' => $this->input->post('deskripsi_kendaraan', true),
            'tahun_kendaraan' => $this->input->post('tahun_kendaraan', true),
            'kapasitas_kendaraan' => $this->input->post('kapasitas_kendaraan', true),
            'harga_kendaraan' => str_replace(".",'',$this->input->post('harga_kendaraan', true)),
            'warna_kendaraan' => $this->input->post('warna_kendaraan', true),
            'bensin_kendaraan' => $this->input->post('bensin_kendaraan', true),
            'no_polisi' => $this->input->post('no_polisi', true),
            'photo' => $this->input->post('photo_name', true),
            'updatedDate'=>date('Y-m-d H:i:s'),
        );
        
        if (!empty($_FILES['photo']['name'])) {
            $attachment_file = $_FILES['photo']['name'];
            $extension_file = pathinfo($attachment_file, PATHINFO_EXTENSION);
            $file = $this->Master_kendaraan_model->upload_file(str_replace("/", "",$id . "." . $extension_file));
            $data['photo'] = str_replace("/", "",$id . "." . $extension_file);
        }
        if ($this->input->post('remove_photo', true) == 'y'){
            if (file_exists('upload/master_kendaraan/'.$data['photo']) && $data['photo']) {
                unlink('upload/master_kendaraan/'.$data['photo']);
            }
            $data['photo']='';
        }
        $update = $this->Master_kendaraan_model->update(array('kendaraan_id' => $id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_kendaraan',
                'activity'=>'update admin user app',
                'keterangan'=>'update admin user app ID '.$this->input->post('kendaraan_id', true),
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
        $kendaraan_id = $this->input->post('kendaraan_id', true);
        $data = array(
            'status' => 'n',
        );
        $nonactive = $this->Master_kendaraan_model->update(array('kendaraan_id' => $kendaraan_id), $data);
        if ($nonactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_kendaraan',
                'activity'=>'nonactive master_kendaraan',
                'keterangan'=>'nonactive '.$kendaraan_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function reactive(){
        $kendaraan_id = $this->input->post('kendaraan_id', true);
        $data = array(
            'status' => 'y',
        );
        $reactive = $this->Master_kendaraan_model->update(array('kendaraan_id' => $kendaraan_id), $data);
        if ($reactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_kendaraan',
                'activity'=>'reactive master_kendaraan',
                'keterangan'=>'reactive '.$kendaraan_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function generate()
    {
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $excel = new PHPExcel();
        $excel->getProperties()->setCreator('EXPORT MASTER KENDARAAN')
                        ->setLastModifiedBy('EXPORT MASTER KENDARAAN')
                        ->setTitle("DATA EXPORT MASTER KENDARAAN")
                        ->setSubject("EXPORT MASTER KENDARAAN")
                        ->setDescription("DATA EXPORT MASTER KENDARAAN")
                        ->setKeywords("DATA EXPORT MASTER KENDARAAN");

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "kendaraan_id");
        $excel->setActiveSheetIndex(0)->setCellValue('B1', "photo");
        $excel->setActiveSheetIndex(0)->setCellValue('C1', "nama_kendaraan");
        $excel->setActiveSheetIndex(0)->setCellValue('D1', "merk_kendaraan");
        $excel->setActiveSheetIndex(0)->setCellValue('E1', "deskripsi_kendaraan");
        $excel->setActiveSheetIndex(0)->setCellValue('F1', "tahun_kendaraan");
        $excel->setActiveSheetIndex(0)->setCellValue('G1', "kapasitas_kendaraan");
        $excel->setActiveSheetIndex(0)->setCellValue('H1', "harga_kendaraan");
        $excel->setActiveSheetIndex(0)->setCellValue('I1', "warna_kendaraan");
        $excel->setActiveSheetIndex(0)->setCellValue('J1', "bensin_kendaraan");
        $excel->setActiveSheetIndex(0)->setCellValue('K1', "no_polisi");
        $excel->setActiveSheetIndex(0)->setCellValue('L1', "status_sewa");
        $excel->setActiveSheetIndex(0)->setCellValue('M1', "status");
        $excel->setActiveSheetIndex(0)->setCellValue('N1', "createdDate");
        $excel->setActiveSheetIndex(0)->setCellValue('O1', "updatedDate");
        
        // LIST SALDO AWAL
        $data = $this->Master_kendaraan_model->get_all_master_kendaraan();
        $no = 1;
        $numrow = 2; 
        
        foreach($data as $list){ 
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $list->kendaraan_id);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $list->photo);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $list->nama_kendaraan);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $list->merk_kendaraan);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $list->deskripsi_kendaraan);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $list->tahun_kendaraan);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $list->kapasitas_kendaraan);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $list->harga_kendaraan);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $list->warna_kendaraan);
            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $list->bensin_kendaraan);
            $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $list->no_polisi);
            $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $list->status_sewa);
            $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $list->status);
            $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $list->createdDate);
            $excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $list->updatedDate);
            $numrow++; 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("master_kendaraan");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        // $filename = "master_kendaraan.xlsx";
        ob_start();
        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();
        $response =  array(
            'status' => TRUE,
            'file' => "data:application/vnd.ms-excel;base64," . base64_encode($xlsData)
        );

        die(json_encode($response)); 
    }

    public function import()
    {
        $header = array();
        $data_import = array();
        $filename = 'master_kendaraan';
        $upload = $this->Home_model->upload_file_excel($filename);
        $filepath = 'upload/excel/' . $filename . '.xlsx';
        if (empty($_FILES['file_excel']['name'])) {
            echo json_encode(array('status' => false));
            return;
        }
        if ($upload['status'] == true) {
            include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
            $excelreader = new PHPExcel_Reader_Excel2007();
            $loadexcel = $excelreader->load($filepath);
            $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

            $column = [
                'kendaraan_id',
                'photo',
                'nama_kendaraan',
                'merk_kendaraan',
                'deskripsi_kendaraan',
                'tahun_kendaraan',
                'kapasitas_kendaraan',
                'harga_kendaraan',
                'warna_kendaraan',
                'bensin_kendaraan',
                'no_polisi',
                'status_sewa',
                'status',
                'createdDate',
                'updatedDate',
            ];
            $data_monitoring = [];
            $values_header = '';
            $values = '';
            if (count($sheet) > 1) {
                $numrow = 1;
                foreach ($sheet as $row) {
                    if ($numrow > 1) {
                        if ($values != "") {
                            $values .= ",";
                        }
                        
                        $values .= "('" . trim($row['A']) . "','" .
                                trim($row['B']) . "','" .
                                trim($row['C']) . "','" .
                                trim($row['D']) . "','" .
                                trim($row['E']) . "','" .
                                trim($row['F']) . "','" .
                                trim($row['G']) . "','" .
                                trim($row['H']) . "','" .
                                trim($row['I']) . "','" .
                                trim($row['J']) . "','" .
                                trim($row['K']) . "','" .
                                trim($row['L']) . "','" .
                                trim($row['M']) . "','" .
                                date('Y-m-d H:i:s') . "','" .
                                trim($row['O']) . "')";
                    }

                    ++$numrow;
                }

                $msg = '';
                $no = 1;
                $this->Master_kendaraan_model->import_template($column, $values);
            }
            if (file_exists($filepath)) {
                unlink($filepath);
            }
            echo json_encode(array('status' => true, 'msg' => 'Upload OK.',));
        } else {
            $data['upload_error'] = $upload['error'];
            echo json_encode(array('status' => false, 'msg' => $data['upload_error'],));
        }
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
        $data = $this->Master_kendaraan_model->get_list_user_by_id_kantor($oid);
        echo json_encode($data);
    }

    public function get_list_user_by_id_kantor_access()
    {
        $typeTerm = $this->input->post('typeTerm', true);
        $searchTerm = $this->input->post('searchTerm', true);
        $data = $this->Master_kendaraan_model->get_list_user_by_id_kantor_access($typeTerm, $searchTerm);
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