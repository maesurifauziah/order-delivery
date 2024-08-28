<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Order extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Order_model',
            'master_barang/Master_barang_model',
            'master_kategori_barang/Master_kategori_barang_model',
            'log_activity/Log_activity_model',
            
        ));
        $this->load->library(array(
            'form_validation',
            'datenumberconverter',
            'user_agent',
        ));
        if (!$this->session->userdata('logged_in')) {
        	redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $list_order = $this->Order_model->get_list_order_summary();
        $data = [
            'count_list_order' => count($list_order),
        ];

        $this->load->view('order_view', $data);
    }

    public function get_list_satuan_barang()
    {
       
        $kode_barang = $this->input->get('kode_barang', true);
        
        $list = $this->Master_barang_model->get_list_satuan_barang($kode_barang);
        foreach ($list as $list) {

            $sat = $list->sat;
            $harga_jual = $list->harga_jual;
            $stock = $list->stock;
    
            $data[] = array(
                'id' => $sat.' - '.$harga_jual.' - '.$stock,
                'text' => $sat . ' [ Rp. '.number_format($harga_jual, 2, '.', ',') . ']',
            );
            $data[] = array(
            );
            $data[] = array(
            );
        }

        echo json_encode($data);
    }

    

    public function add_to_cart()
    {
        $this->_validate("add_to_cart");
        $tgl_order = date('Y-m-d');
        $detailid = $this->Order_model->generateDetailID($tgl_order, $this->session->userdata('userid'));
        $data = array(
            'tgl_order'=> $tgl_order,
            'kode_barang' => $this->input->post('kode_barang', true),
            'userid'=>$this->session->userdata('userid'),
            'detailid' => $detailid,
            'photo' => $this->input->post('photo', true),
            'nama_barang' => $this->input->post('nama_barang', true),
            'quantity' => $this->input->post('quantity', true),
            'satuan_jual' => $this->input->post('satuan_jual_id', true),
            'harga_jual' => $this->input->post('harga_jual', true),
            'harga_total' => $this->input->post('harga_total', true),
            'keterangan' => $this->input->post('keterangan', true),
            'bonus' => $this->input->post('bonus2', true),
            'createdDate'=>date('Y-m-d H:i:s'),
            'status_order' => 'draft',
        );
        
        $insert = $this->Order_model->save_summary($data);
        if ($insert){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'master_barang',
                'activity'=>'create order summary',
                'keterangan'=>'create order summary '.$tgl_order. ', ' . $this->session->userdata('userid'). ', '. $detailid,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }

        // echo json_encode($data);
        echo json_encode(array('status' => true));
    }

    public function get_list_barang()
    {
        $typeTerm = $this->input->get('typeTerm', true);
        $searchTerm = $this->input->get('searchTerm', true);
        $list = $this->Master_barang_model->get_list_barang($typeTerm, $searchTerm);
        $html = '';
        foreach ($list as $list) {
            $data_bind = '
                data-kode_barang="'.$list->kode_barang.'" 
                data-nama_barang="'.$list->nama_barang.'" 
                data-harga_beli="'.$list->harga_beli.'" 
                data-harga_jual="'.$list->harga_jual.'"  
                data-photo="'.$list->photo.'" 
                data-createdDate="'.$list->createdDate.'" 
                data-status="'.$list->status.'"  
                data-satuan="'.$list->satuan.'"  
                data-keterangan="'.$list->keterangan.'"  
                data-path_photo="'.base_url('upload/master_barang/'.$list->photo).'"  
            ';
            $mobile=$this->agent->is_mobile();
            if($mobile){
                $str =$list->nama_barang;
                $pjng_nama = strlen($str);
                $nama_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_barang = substr($str,0,28) . "...";
                }
                $html .= '
                <div class="col-6 col-sm-6 col-md-3 align-items-stretch">
                    <div class="card mb-3">
                        <div class="row" style="height:8rem">
                            <div class="col-12 text-center">
                                <div class="position-relative">
                                <img class="img-fluid image-hight" src="'.base_url('upload/master_barang/'.$list->photo).'" style="width: 60%; max-width: 400px; margin: 1rem;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 1rem;">
                            <div id="wrapper">
                                <div class="block border-bottom">
                                    <label class="card-title" style="color:black; font-weight: bold;">'.$nama_barang.'</label>
                                </div>
                            </div>
                            <div class="text-center" style="padding-top: 3px; line-height: 1em;">
                                <h6><b>'.$this->datenumberconverter->formatRupiah($list->harga_jual).'</b></h6>
                            </div>
                            <div class="text-center" style="padding-top: 3px; line-height: 1em; height:3rem">
                                <p style="font-size:13px;">'.$list->keterangan.'</p>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="javascript:void(0);" class="add_to_cart btn btn-block bg-danger text-center" 
                                '.$data_bind.'
                                ><i class="fas fa-cart-plus"></i> Tambah</a>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            } else {
                $str =$list->nama_barang;
                $nama_barang = $str;
                $html .= '
                <div class="col-6 col-sm-6 col-md-3 align-items-stretch">
                    <div class="card mb-3">
                        <div class="row" style="height:13rem">
                            <div class="col-12 text-center">
                                <div class="position-relative">
                                <img class="img-fluid image-hight" src="'.base_url('upload/master_barang/'.$list->photo).'" style="width: 60%; max-width: 400px; margin: 1rem;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 1rem;">
                            <div id="wrapper">
                                <div class="block border-bottom">
                                    <label class="card-title" style="color:black; font-weight: bold;">'.$nama_barang.'</label>
                                </div>
                            </div>
                            <div class="text-center" style="padding-top: 3px; line-height: 1em;">
                                <h6><b>'.$this->datenumberconverter->formatRupiah($list->harga_jual).'</b></h6>
                            </div>
                            <div class="text-center" style="padding-top: 3px; line-height: 1em; height:3rem">
                                <p style="font-size:13px;">'.$list->keterangan.'</p>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="javascript:void(0);" class="add_to_cart btn btn-block bg-danger text-center" 
                                '.$data_bind.'
                                ><i class="fas fa-cart-plus"></i> Tambah</a>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }

    public function get_list_barang_top3()
    {
        $searchTerm = $this->input->get('searchTerm', true);
        $list = $this->Master_barang_model->get_list_barang_top3($searchTerm);
        $html = '';
        $html2 = '';
        foreach ($list as $list) {
            $data_bind = '
                data-kode_barang="'.$list->kode_barang.'" 
                data-nama_barang="'.$list->nama_barang.'" 
                data-harga_beli="'.$list->harga_beli.'" 
                data-harga_jual="'.$list->harga_jual.'"  
                data-photo="'.$list->photo.'" 
                data-createdDate="'.$list->createdDate.'" 
                data-status="'.$list->status.'"  
                data-satuan="'.$list->satuan.'"  
                data-keterangan="'.$list->keterangan.'"  
                data-path_photo="'.base_url('upload/master_barang/'.$list->photo).'"  
            ';
            $mobile=$this->agent->is_mobile();
            if($mobile){
                $str =$list->nama_barang;
                $pjng_nama = strlen($str);
                $nama_barang = substr($str,0,30);
                if ($pjng_nama > 28) {
                    $nama_barang = substr($str,0,28) . "...";
                }
                $html .= '
                <div class="col-6 col-sm-6 col-md-3 align-items-stretch">
                    <div class="card mb-3">
                        <div class="row" style="height:8rem">
                            <div class="col-12 text-center">
                                <div class="position-relative">
                                <img class="img-fluid image-hight" src="'.base_url('upload/master_barang/'.$list->photo).'" style="width: 60%; max-width: 400px; margin: 1rem;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 1rem;">
                            <div id="wrapper">
                                <div class="block border-bottom">
                                    <label class="card-title" style="color:black; font-weight: bold;">'.$nama_barang.'</label>
                                </div>
                            </div>
                            <div class="text-center" style="padding-top: 3px; line-height: 1em;">
                                <h6><b>'.$this->datenumberconverter->formatRupiah($list->harga_jual).'</b></h6>
                            </div>
                            <div class="text-center" style="padding-top: 3px; line-height: 1em; height:3rem">
                                <p style="font-size:13px;">'.$list->keterangan.'</p>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="javascript:void(0);" class="add_to_cart btn btn-block bg-danger text-center" 
                                '.$data_bind.'
                                ><i class="fas fa-cart-plus"></i> Tambah</a>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            } else {
                $str =$list->nama_barang;
                $nama_barang = $str;
                $html .= '
                <div class="col-6 col-sm-6 col-md-3 align-items-stretch">
                    <div class="card mb-3">
                        <div class="row" style="height:13rem">
                            <div class="col-12 text-center">
                                <div class="position-relative">
                                <img class="img-fluid image-hight" src="'.base_url('upload/master_barang/'.$list->photo).'" style="width: 60%; max-width: 400px; margin: 1rem;">
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 1rem;">
                            <div id="wrapper">
                                <div class="block border-bottom">
                                    <label class="card-title" style="color:black; font-weight: bold;">'.$nama_barang.'</label>
                                </div>
                            </div>
                            <div class="text-center" style="padding-top: 3px; line-height: 1em;">
                                <h6><b>'.$this->datenumberconverter->formatRupiah($list->harga_jual).'</b></h6>
                            </div>
                            <div class="text-center" style="padding-top: 3px; line-height: 1em; height:3rem">
                                <p style="font-size:13px;">'.$list->keterangan.'</p>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="javascript:void(0);" class="add_to_cart btn btn-block bg-danger text-center" 
                                '.$data_bind.'
                                ><i class="fas fa-cart-plus"></i> Tambah</a>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }
        $html2 = '
            <div class="col-6 col-sm-6 col-md-3 align-items-stretch">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="text-center">
                            <a href="#order" class="btn btn-block bg-default text-center text-danger" id="order_redirect"><h3>All Item <i class="fa fa-plus" aria-hidden="true"></i><h3></i></a>
                        </div>
                    </div>
                </div>
            </div>
            ';
        $html = $html . $html2;
       
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }

    public function get_list_order_summary(){
        $data = $this->Order_model->get_list_order_summary();
        echo json_encode($data);
    }


    public function cancel()
    {
        $tgl_order = $this->input->post('tgl_order', true);
        $kode_barang = $this->input->post('kode_barang', true);
        $userid = $this->input->post('userid', true);
        $detailid = $this->input->post('detailid', true);

        $where = array(
            'tgl_order' => $tgl_order,
            'kode_barang' => $kode_barang,
            'userid' => $userid,
            'detailid' => $detailid,
        );
        $data = array(
            'status_order' => 'cancel',
            'status' => 'n',
        );
        $cancel = $this->Order_model->update_summary($where, $data);
        if ($cancel){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'order',
                'activity'=>'cancel list order',
                'keterangan'=>'cancel list order'.$tgl_order.'-'.$kode_barang.'-'.$userid.'-'.$detailid,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function add_checkout()
    {     
        $this->_validate("add_checkout");
        $data_ceklis = $this->input->post('data_ceklis', true);
        $quantity = $this->input->post('order_list_quantity', true);
        $tgl_order = $this->input->post('order_list_tgl_order', true);
        $kode_barang = $this->input->post('order_list_kode_barang', true);
        $userid = $this->input->post('order_list_userid', true);
        $nama_barang = $this->input->post('order_list_nama_barang', true);
        $photo = $this->input->post('order_list_photo', true);
        $detailid2 = $this->input->post('order_list_detailid', true);
        $keterangan = $this->input->post('order_list_keterangan', true);
        $status_order = $this->input->post('order_list_status_order', true);
        $status = $this->input->post('order_list_status', true);
        $satuan_jual = $this->input->post('order_list_satuan_jual2', true);
        $harga_jual = $this->input->post('order_list_harga_jual', true);
        $harga_total = $this->input->post('order_list_harga_total', true);
        $bonus = $this->input->post('order_list_bonus', true);
        $kode = $this->Order_model->GenerateIDOrder();
        
        // header 
        $alamat_kirim = $this->input->post('alamat_kirim', true);
        $tipe_pembayaran = $this->input->post('tipe_pembayaran', true);
        $total = $this->input->post('total_belanja', true);
        $ongkir = $this->input->post('ongkir', true);
        $total_bonus = $this->input->post('bonus', true);
        $biaya_penanganan = $this->input->post('biaya_penanganan', true);
        $grand_total = $this->input->post('grand_total', true);

        $detail = [];
        $detail_summary = [];
        $nomor_detail = 0;
        // $total = 0;
        
        if (count($data_ceklis)==0){
            echo json_encode(array('status' => FALSE, 'msg' => 'Anda belum memilih produk!!!'));
            return;
        } 
        foreach($data_ceklis AS $key => $val){          
            $nomor_detail = $nomor_detail+1; 
            $where = array(
                "tgl_order"  => $tgl_order[$key],
                "detailid"  => $detailid2[$key],
                "kode_barang"  => $kode_barang[$key],
                "userid"  => $userid[$key],
                "status_order"  => $status_order[$key],
                "status"  => $status[$key],
                "satuan_jual"  => $satuan_jual[$key],
            );
            $detail_summary = array(
                "status_order"  => 'checkout',
            );
            
            $this->Order_model->update_summary($where, $detail_summary);
            
            // $total = $total + ($quantity[$key]*$harga_jual[$key]);
            $detail[] = array(
                "order_id"  => $kode,
                "tgl_order"  => $tgl_order[$key],
                "userid"  => $userid[$key],
                "detailid"  => $nomor_detail,
                "kode_barang"  => $kode_barang[$key],
                "nama_barang"  => $nama_barang[$key],
                "satuan_jual"  => $satuan_jual[$key],
                "quantity"  => $quantity[$key],
                "harga_jual"  => $harga_jual[$key],
                "harga_total"  => $harga_total[$key],
                "bonus"  => $bonus[$key],
                "keterangan"  => $keterangan[$key],
                "createdDate"=>date('Y-m-d H:i:s'),
                "status_order"  => 'checkout',
                "status"  => 'y',
            );
            
        }
        $header = array(
			'order_id' => $kode,
            'userid' => $this->session->userdata('userid'),
            "tgl_checkout"=>date('Y-m-d'),
            'total'=> $total,
            'total_bonus'=> $total_bonus,
            'ongkir'=> $ongkir,
            'biaya_penanganan'=> $biaya_penanganan,
            'grand_total'=> $grand_total,
            'alamat_kirim' => $alamat_kirim,
            'tipe_pembayaran' => $tipe_pembayaran,
            'status_order_barang' => 'checkout',
            'status' => 'y',
            'createdDate'=>date('Y-m-d h:i:s'),
        );
        if ($tipe_pembayaran == 'T'){
            if (!empty($_FILES['bukti_pembayaran']['name'])) {
                $bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
                $extension_file = pathinfo($bukti_pembayaran, PATHINFO_EXTENSION);
                $file = $this->Order_model->upload_file(str_replace("/", "", $kode. "." . $extension_file), 'bukti_pembayaran');
                $header['bukti_pembayaran'] = str_replace("/", "", $kode. "." . $extension_file);
            } else {
                echo json_encode(array('status' => false, 'msg' => 'Bukti Pembayaran harus di upload ...'));
                return;
            }
        }
       
        $insert = $this->Order_model->save($header, $detail);
        if ($insert){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'order',
                'activity'=>'add checkout',
                'keterangan'=>'add checkout'.$header['order_id'],
                'createdDate'=>date('Y-m-d h:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        // echo json_encode($header);
        echo json_encode(array('status' => true));
    }

    public function get_list_order_header_proses(){
        $data = $this->Order_model->get_list_order_header_proses();
        echo json_encode($data);
    }
    public function tes(){
        $typeTerm = $this->input->get('typeTerm', true);
        $searchTerm = $this->input->get('searchTerm', true);
        $list = $this->Master_barang_model->get_list_barang($typeTerm, $searchTerm);
        echo json_encode($list);
    }

    public function get_list_order_header_done(){
        $data = $this->Order_model->get_list_order_header_done();
        echo json_encode($data);
    }
    public function get_list_master_kategori_barang_active(){
        $data = $this->Master_kategori_barang_model->get_list_master_kategori_barang_active();
        echo json_encode($data);
    }

    private function _validate($act)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;
        
        if ($act == "add_to_cart") {
            if ($this->input->post('satuan_jual_id') == '') {
                $data['inputerror'][] = 'satuan_jual_id';
                $data['error_string'][] = 'Satuan harus di isi';
                $data['status'] = false;
            }
            if ($this->input->post('quantity') == '' || $this->input->post('quantity') == '0') {
                $data['inputerror'][] = 'quantity';
                $data['error_string'][] = 'Quantiti harus di isi';
                $data['status'] = false;
            }
        }
        if ($act == "add_checkout") {
            if ($this->input->post('alamat_kirim') == '') {
                $data['inputerror'][] = 'alamat_kirim';
                $data['error_string'][] = 'Alamat Kirim harus di isi';
                $data['status'] = false;
            }
        }
       
        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }

}