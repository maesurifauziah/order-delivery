<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Master_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Master_barang_model',
            'master_kategori_barang/Master_kategori_barang_model',
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
        // if (!$this->session->userdata('barang')) {
        //     return;
        // }
        $data = [
            'kategori' => $this->Master_kategori_barang_model->get_list_master_kategori_barang_not_all(),
        ];
        $this->load->view('master_barang_view', $data);
    }

    public function master_barang_list()
    {
        $list = $this->Master_barang_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $list) {
            $data_bind = '
                data-kode_barang="'.$list->kode_barang.'" 
                data-nama_barang="'.$list->nama_barang.'" 
                data-kategori_id="'.$list->kategori_id.'" 
                data-kategori_desc="'.$list->kategori_desc.'" 
                data-harga_beli="'.$list->harga_beli.'" 
                data-harga_jual="'.$list->harga_jual.'" 
                data-satuan="'.$list->satuan.'"  
                data-photo="'.$list->photo.'"  
                data-createdDate="'.$list->createdDate.'" 
                data-keterangan="'.$list->keterangan.'" 
                data-status="'.$list->status.'" 
                data-stock="'.$list->stock.'" 
                data-path_photo="'.base_url('upload/master_barang/'.$list->photo).'"  
            ';
            
            ++$no;
            $row = array();
            $row[] = $no;
            $row[] = $list->kode_barang;
            $row[] = $list->kategori_desc;
            if($list->photo)
                $row[] = '<a href="#" ><img src="'.base_url('upload/master_barang/'.$list->photo).'" class="img-responsive" style="width: 100%; max-width: 100px; height: auto;" /></a>';
            else
                $row[] = '(No photo)';
            $row[] = $list->nama_barang;
            $row[] = $this->datenumberconverter->formatRupiah($list->harga_beli);
            $row[] = $this->datenumberconverter->formatRupiah($list->harga_jual);
            $row[] = $list->satuan;
            $row[] = $list->keterangan;
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
                'recordsTotal' => $this->Master_barang_model->count_all(),
                'recordsFiltered' => $this->Master_barang_model->count_filtered(),
                'data' => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function add()
    {
        $this->_validate();
        $data = array(
            'kode_barang' => $this->Master_barang_model->generateIDBarang(),
            'nama_barang' => $this->input->post('nama_barang', true),
            'kategori_id' => $this->input->post('kategori_id', true),
            'harga_beli' => $this->input->post('harga_beli', true),
            'harga_jual' => $this->input->post('harga_jual', true),
            'satuan' => $this->input->post('satuan', true),
            'keterangan' => $this->input->post('keterangan', true),
            'createdDate'=>date('Y-m-d H:i:s'),
            'status' => 'y',
        );
        if (!empty($_FILES['photo']['name'])) {
            $photo = $_FILES['photo']['name'];
            $extension_file = pathinfo($photo, PATHINFO_EXTENSION);
            $file = $this->Master_barang_model->upload_file(str_replace("/", "", $data['kode_barang'] . "." . $extension_file));
            $data['photo'] = str_replace("/", "", $data['kode_barang'] . "." . $extension_file);
        } else {
            echo json_encode(array('status' => false, 'msg' => '"Attachment" harus dipilih...'));
            return;
        }
        $insert = $this->Master_barang_model->save($data);
        if ($insert){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_barang',
                'activity'=>'create admin user app',
                'keterangan'=>'create admin user app ID '.$this->input->post('kode_barang', true),
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
       $id = $this->input->post('kode_barang', true);
        $data = array(
            'nama_barang' => $this->input->post('nama_barang', true),
            'kategori_id' => $this->input->post('kategori_id', true),
            'harga_beli' => $this->input->post('harga_beli', true),
            'harga_jual' => $this->input->post('harga_jual', true),
            'satuan' => $this->input->post('satuan', true),
            'keterangan' => $this->input->post('keterangan', true),
            'photo' => $this->input->post('photo_name', true),
        );
        if (!empty($_FILES['photo']['name'])) {
            $attachment_file = $_FILES['photo']['name'];
            $extension_file = pathinfo($attachment_file, PATHINFO_EXTENSION);
            $file = $this->Master_barang_model->upload_file(str_replace("/", "",$id . "." . $extension_file));
            $data['photo'] = str_replace("/", "",$id . "." . $extension_file);
        }
        if ($this->input->post('remove_photo', true) == 'y'){
            if (file_exists('upload/master_barang/'.$data['photo']) && $data['photo']) {
                unlink('upload/master_barang/'.$data['photo']);
            }
            $data['photo']='';
        }

        $update = $this->Master_barang_model->update(array('kode_barang' => $id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_barang',
                'activity'=>'update admin user app',
                'keterangan'=>'update admin user app ID '.$this->input->post('kode_barang', true),
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }

        // echo json_encode($data);
        echo json_encode(array('status' => true));
    }

    public function nonactive()
    {
        $kode_barang = $this->input->post('kode_barang', true);
        $data = array(
            'status' => 'n',
        );
        $nonactive = $this->Master_barang_model->update(array('kode_barang' => $kode_barang), $data);
        if ($nonactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_barang',
                'activity'=>'nonactive master_barang',
                'keterangan'=>'nonactive '.$kode_barang,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function reactive(){
        $kode_barang = $this->input->post('kode_barang', true);
        $data = array(
            'status' => 'y',
        );
        $reactive = $this->Master_barang_model->update(array('kode_barang' => $kode_barang), $data);
        if ($reactive){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_barang',
                'activity'=>'reactive master_barang',
                'keterangan'=>'reactive '.$kode_barang,
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
        $excel->getProperties()->setCreator('EXPORT MASTER BARANG')
                        ->setLastModifiedBy('EXPORT MASTER BARANG')
                        ->setTitle("DATA EXPORT MASTER BARANG")
                        ->setSubject("EXPORT MASTER BARANG")
                        ->setDescription("DATA EXPORT MASTER BARANG")
                        ->setKeywords("DATA EXPORT MASTER BARANG");

        $excel->setActiveSheetIndex(0)->setCellValue('A1', "kode_barang");
        $excel->setActiveSheetIndex(0)->setCellValue('B1', "nama_barang");
        $excel->setActiveSheetIndex(0)->setCellValue('C1', "kategori_id");
        $excel->setActiveSheetIndex(0)->setCellValue('D1', "harga_beli");
        $excel->setActiveSheetIndex(0)->setCellValue('E1', "harga_jual");
        $excel->setActiveSheetIndex(0)->setCellValue('F1', "satuan");
        $excel->setActiveSheetIndex(0)->setCellValue('G1', "photo");
        $excel->setActiveSheetIndex(0)->setCellValue('H1', "keterangan");
        $excel->setActiveSheetIndex(0)->setCellValue('I1', "createdDate");
        $excel->setActiveSheetIndex(0)->setCellValue('J1', "status");
        $excel->setActiveSheetIndex(0)->setCellValue('K1', "stock");

        $excel->setActiveSheetIndex(0)->setCellValue('M2', "KETERANGAN KATEGORI");
        $excel->setActiveSheetIndex(0)->setCellValue('M3', "Kategori ID");
        $excel->setActiveSheetIndex(0)->setCellValue('N3', "Nama Kategori");
        
        // LIST BARANG
        $data = $this->Master_barang_model->get_all_master_barang();
        $no = 1;
        $numrow = 2; 
        
        foreach($data as $list){ 
            $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $list->kode_barang);
            $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $list->nama_barang);
            $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $list->kategori_id);
            $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $list->harga_beli);
            $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $list->harga_jual);
            $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $list->satuan);
            $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $list->photo);
            $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $list->keterangan);
            $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $list->createdDate);
            $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $list->status);
            $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $list->stock);
            $numrow++; 
        }

        // LIST MATEGORI
        $this->db->where('kategori_id !=', 'KT001');
        $data_kategori = $this->Master_kategori_barang_model->get_list_master_kategori_barang_active();
        
        $numrow = 4; 
        
        foreach($data_kategori as $list2){ 
            $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $list2->kategori_id);
            $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $list2->kategori_desc);
            $numrow++; 
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("master_barang");
        $excel->setActiveSheetIndex(0);
        // Proses file excel
        // $filename = "master_barang.xlsx";
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
        $filename = 'master_barang';
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
                'kode_barang',
                'nama_barang',
                'kategori_id',
                'harga_beli',
                'harga_jual',
                'satuan',
                'photo',
                'keterangan',
                'createdDate',
                'status',
                'stock',
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
                                date('Y-m-d H:i:s') . "','" .
                                trim($row['J']) . "','" .
                                trim($row['K']) . "')";
                    }

                    ++$numrow;
                }

                $msg = '';
                $no = 1;
                $this->Master_barang_model->import_template($column, $values);
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
        
        if ($this->input->post('nama_barang') == '') {
            $data['inputerror'][] = 'nama_barang';
            $data['error_string'][] = 'Nama Barang harus diisi';
            $data['status'] = false;
        }
        if ($this->input->post('kategori_id') == '') {
            $data['inputerror'][] = 'kategori_id';
            $data['error_string'][] = 'Kategori harus diisi';
            $data['status'] = false;
        }
        if ($this->input->post('harga_beli') == '') {
            $data['inputerror'][] = 'harga_beli';
            $data['error_string'][] = 'Harga Beli harus diisi';
            $data['status'] = false;
        }
        if ($this->input->post('harga_jual') == '') {
            $data['inputerror'][] = 'harga_jual';
            $data['error_string'][] = 'Harga Jual harus diisi';
            $data['status'] = false;
        }
        if ($this->input->post('satuan') == '') {
            $data['inputerror'][] = 'satuan';
            $data['error_string'][] = 'Satuan harus diisi';
            $data['status'] = false;
        }
        if ($this->input->post('keterangan') == '') {
            $data['inputerror'][] = 'keterangan';
            $data['error_string'][] = 'Keterangan harus diisi';
            $data['status'] = false;
        }

        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
    
}