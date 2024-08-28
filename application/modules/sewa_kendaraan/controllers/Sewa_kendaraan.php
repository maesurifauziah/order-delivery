<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Sewa_kendaraan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Sewa_kendaraan_model',
            'master_tipe_kendaraan/Master_tipe_kendaraan_model',
            'master_kendaraan/Master_kendaraan_model',
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
        $list_sewa = $this->Sewa_kendaraan_model->get_list_sewa_summary();
        $data = [
            'count_list_sewa' => count($list_sewa),
        ];
        $this->load->view('sewa_kendaraan_view', $data);
    }

    public function get_list_kendaraan()
    {
        $typeTerm = $this->input->get('typeTerm', true);
        $searchTerm = $this->input->get('searchTerm', true);
        $list = $this->Master_kendaraan_model->get_list_kendaraan($typeTerm, $searchTerm);
        $html = '';
        $html_st_sewa = '';
        $html_photo = '';
        foreach ($list as $list) {
            if ($list->photo != '' || $list->photo != null) {
                $html_photo = '<img class="card-img-top image-hight" src="'.base_url('upload/master_kendaraan/'.$list->photo.'').'" style="width: 100%; max-width: 400px;">';
                $path_photo = base_url('upload/master_kendaraan/'.$list->photo);
            } else {
                $html_photo = '<img class="card-img-top image-hight" src="'.base_url('upload/dummy/images.jpg').'" style="width: 100%; max-width: 400px;">';
                $path_photo = base_url('upload/dummy/images.jpg');
            }

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
                data-path_photo="'.$path_photo.'" 
            ';
            
            if ($list->status_sewa == 'n') {
                $html_st_sewa = '<a href="javascript:void(0);" class="add_to_cart btn btn-block bg-danger text-center" disabled '.$data_bind.'> Sewa</a>';
            } else {
                $html_st_sewa = '<a href="javascript:void(0);" class="bg-white btn btn-block bg-danger text-center disabled" role="button" aria-disabled="true"> Disewa</a>';
            }
            

            $html .= '
            <div class="col-6 col-sm-6 col-md-4 align-items-stretch">
                <div class="card mb-3">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="notify-badge">'.$this->datenumberconverter->formatRupiah($list->harga_kendaraan).'</div>
                            '.$html_photo.'
                        </div>
                    </div>
                    <div class="card-body" style="padding-bottom: 0.25rem">
                        <div id="wrapper">
                            <div class="block border-bottom">
                                <label class="card-title" style="color:black; font-weight: bold;">'.$list->nama_kendaraan.'</label>
                            </div>
                        </div>
                        <div style="padding-top: 5px; line-height: 1.214em;">
                            <p style="margin-bottom: 0.5rem;"><b>Tipe</b> <br> '.$list->merk_kendaraan.'</p>
                            <p style="margin-bottom: 0.5rem;"><b>Kapasitas</b> <br> '.$list->kapasitas_kendaraan.'</p>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="text-right">
                            '.$html_st_sewa.'
                        </div>
                    </div>
                </div>
            </div>
            ';
        }
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }

    public function add_to_cart()
    {
        $this->_validate("add_to_cart");
        $tgl_sewa = date('Y-m-d');
        $tgl_pinjam = $this->input->post('tgl_pinjam', true);
        $tgl_kembali = $this->input->post('tgl_kembali', true);
        $harga_kendaraan = $this->input->post('harga_kendaraan', true);
        $subtotal_sewa = $this->Sewa_kendaraan_model->get_subtotal_sewa($tgl_pinjam, $tgl_kembali, $harga_kendaraan);
        $lama_pinjam = $subtotal_sewa / $harga_kendaraan;
        $detailid = $this->Sewa_kendaraan_model->generateDetailID($tgl_sewa, $this->session->userdata('userid'));
        $data = array(
            'tgl_sewa'=> $tgl_sewa,
            'kendaraan_id' => $this->input->post('kendaraan_id', true),
            'userid'=>$this->session->userdata('userid'),
            'detailid' => $detailid,
            'photo' => $this->input->post('photo', true),
            'nama_kendaraan' => $this->input->post('nama_kendaraan', true),
            'tgl_pinjam' => $tgl_pinjam,
            'tgl_kembali' => $tgl_kembali,
            'lama_pinjam' => $lama_pinjam,
            'harga_kendaraan' => $harga_kendaraan,
            'subtotal_sewa' => $subtotal_sewa,
            'createdDate'=>date('Y-m-d H:i:s'),
            'status_sewa' => 'draft',
        );
        
        $insert = $this->Sewa_kendaraan_model->save_summary($data);
        if ($insert){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'sewa_kendaraan',
                'activity'=>'create sewa summary',
                'keterangan'=>'create sewa summary '.$tgl_sewa. ', ' . $this->session->userdata('userid'). ', '. $detailid,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }

        // echo json_encode($data);
        echo json_encode(array('status' => true));
    }

    public function add_checkout()
    {     
        $this->_validate("add_checkout");
        $data_ceklis = $this->input->post('data_ceklis', true);
        $tgl_sewa = $this->input->post('sewa_list_tgl_sewa', true);
        $kendaraan_id = $this->input->post('sewa_list_kendaraan_id', true);
        $userid = $this->input->post('sewa_list_userid', true);
        $detailid = $this->input->post('sewa_list_detailid', true);
        $nama_kendaraan = $this->input->post('sewa_list_nama_kendaraan', true);
        $photo = $this->input->post('sewa_list_photo', true);
        $tgl_pinjam = $this->input->post('sewa_list_tgl_pinjam', true);
        $tgl_kembali = $this->input->post('sewa_list_tgl_kembali', true);
        $lama_pinjam = $this->input->post('sewa_list_lama_pinjam', true);
        $harga_kendaraan = $this->input->post('sewa_list_harga_kendaraan', true);
        $subtotal_sewa = $this->input->post('sewa_list_subtotal_sewa', true);
        $status_sewa = $this->input->post('sewa_list_status_sewa', true);
        $status = $this->input->post('sewa_list_status', true);
        $kode = $this->Sewa_kendaraan_model->GenerateIDTransSewa();

        $detail = [];
        $detail_summary = [];
        $nomor_detail = 0;
        $total = 0;
        $total_bonus = 0;
        if (count($data_ceklis)==0){
            echo json_encode(array('status' => FALSE, 'msg' => 'Anda belum memilih item!!!'));
            return;
        } 
        foreach($data_ceklis AS $key => $val){          
            $nomor_detail = $nomor_detail+1; 
            $where = array(
                "tgl_sewa"  => $tgl_sewa[$key],
                "detailid"  => $detailid[$key],
                "kendaraan_id"  => $kendaraan_id[$key],
                "userid"  => $userid[$key],
                "status_sewa"  => $status_sewa[$key],
                "status"  => $status[$key],
            );
            $detail_summary = array(
                "status_sewa"  => 'checkout',
            );
            
            $this->Sewa_kendaraan_model->update_summary($where, $detail_summary);
            
            $total = $total + $subtotal_sewa[$key];

            $detail[] = array(
                "sewa_id"  => $kode,
                "tgl_sewa"  => $tgl_sewa[$key],
                "userid"  => $userid[$key],
                "detailid"  => $nomor_detail,
                "kendaraan_id"  => $kendaraan_id[$key],
                "nama_kendaraan"  => $nama_kendaraan[$key],
                "tgl_pinjam"  => $tgl_pinjam[$key],
                "tgl_kembali"  => $tgl_kembali[$key],
                "lama_pinjam"  => $lama_pinjam[$key],
                "harga_kendaraan"  => $harga_kendaraan[$key],
                "subtotal_sewa"  => $subtotal_sewa[$key],
                "createdDate"=>date('Y-m-d H:i:s'),
                "status_sewa"  => 'checkout',
                "status"  => 'y',
            );

        }
        $uang_muka = ($total * 30) / 100;
        $header = array(
			'sewa_id' => $kode,
            'userid' => $this->session->userdata('userid'),
            "tgl_checkout"=>date('Y-m-d'),
            'grand_total'=> $total,
            'uang_muka'=> $uang_muka,
            'titik_jemput'=> $this->input->post('titik_jemput', true),
            'status_pembayaran' => 'uang_muka',
            'status' => 'y',
            'createdDate'=>date('Y-m-d H:i:s'),
            'createdDatePelunasan'=>date('Y-m-d H:i:s'),
        );
    
        if (!empty($_FILES['bukti_pembayaran_uang_muka']['name'])) {
            $bukti_pembayaran_uang_muka = $_FILES['bukti_pembayaran_uang_muka']['name'];
            $extension_file = pathinfo($bukti_pembayaran_uang_muka, PATHINFO_EXTENSION);
            $file = $this->Sewa_kendaraan_model->upload_file(str_replace("/", "", $kode. "_dp" . "." . $extension_file), 'bukti_pembayaran_uang_muka');
            $header['bukti_pembayaran_uang_muka'] = str_replace("/", "", $kode. "_dp" . "." . $extension_file);
        } else {
            echo json_encode(array('status' => false, 'msg' => 'Bukti Pembayaran harus di upload ...'));
            return;
        }
       
        $insert = $this->Sewa_kendaraan_model->save($header, $detail);
        if ($insert){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'sewa_kendraan',
                'activity'=>'add checkout',
                'keterangan'=>'add checkout'.$header['sewa_id'],
                'createdDate'=>date('Y-m-d h:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        // echo json_encode($header);
        echo json_encode(array('status' => true));
    }

    public function bayar_lunas()
    {
        $data = array(
            'sewa_id' => $this->input->post('sewa_id_pelunasan', true),
            'status_pembayaran' => 'pelunasan',
        );
		if (!empty($_FILES['bukti_pembayaran_pelunasan']['name'])) {
            $bukti_pembayaran_pelunasan = $_FILES['bukti_pembayaran_pelunasan']['name'];
            $extension_file = pathinfo($bukti_pembayaran_pelunasan, PATHINFO_EXTENSION);
            $file = $this->Sewa_kendaraan_model->upload_file(str_replace("/", "", $this->input->post('sewa_id_pelunasan', true). "_lns" . "." . $extension_file), 'bukti_pembayaran_pelunasan');
            $data['bukti_pembayaran_pelunasan'] = str_replace("/", "", $this->input->post('sewa_id_pelunasan', true). "_lns" . "." . $extension_file);
        } else {
            echo json_encode(array('status' => false, 'msg' => 'Bukti Pembayaran harus di upload ...'));
            return;
        }
        $where = array('sewa_id' => $this->input->post('sewa_id_pelunasan', true));
       
        $update = $this->Sewa_kendaraan_model->update_header($where, $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'sewa_kendaraan',
                'activity'=>'upload pelunasan',
                'keterangan'=>'upload pelunasan '.$this->input->post('sewa_id_pelunasan', true),
                'createdDate'=>date('Y-m-d h:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
    //    echo json_encode($data);
       echo json_encode(array('status' => true));
    }

    public function cancel()
    {
        $tgl_sewa = $this->input->post('tgl_sewa', true);
        $kendaraan_id = $this->input->post('kendaraan_id', true);
        $userid = $this->input->post('userid', true);
        $detailid = $this->input->post('detailid', true);

        $where = array(
            'tgl_sewa' => $tgl_sewa,
            'kendaraan_id' => $kendaraan_id,
            'userid' => $userid,
            'detailid' => $detailid,
        );
        $data = array(
            'status_sewa' => 'cancel',
            'status' => 'n',
        );
        $cancel = $this->Sewa_kendaraan_model->update_summary($where, $data);
        if ($cancel){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'sewa',
                'activity'=>'cancel list sewa',
                'keterangan'=>'cancel list sewa'.$tgl_sewa.'-'.$kendaraan_id.'-'.$userid.'-'.$detailid,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function get_list_sewa_summary(){
        $data = $this->Sewa_kendaraan_model->get_list_sewa_summary();
        echo json_encode($data);
    }

    public function get_list_sewa_header_not_cancel(){
        $data = $this->Sewa_kendaraan_model->get_list_sewa_header_not_cancel();
        echo json_encode($data);
    }

    public function tes()
    {
        $data = $this->Sewa_kendaraan_model->get_list_sewa_header_not_cancel();
        echo json_encode($data);
    }

    private function _validate($act)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;
        
        if ($act == "add_to_cart") {
            if ($this->input->post('tgl_pinjam') == '') {
                $data['inputerror'][] = 'tgl_pinjam';
                $data['error_string'][] = 'Tanggal Pinjam harus di isi';
                $data['status'] = false;
            }
            if ($this->input->post('tgl_kembali') == '') {
                $data['inputerror'][] = 'tgl_kembali';
                $data['error_string'][] = 'Tanggal Kembali harus di isi';
                $data['status'] = false;
            }
        }
        if ($act == "add_checkout") {
            if ($this->input->post('titik_jemput') == '') {
                $data['inputerror'][] = 'titik_jemput';
                $data['error_string'][] = 'Titik Jemput harus di isi';
                $data['status'] = false;
            }
        }
       
        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
}