<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Order_kurir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Order_kurir_model',
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
     
        $data = [
        ];

        $this->load->view('order_kurir_view', $data);
    }

    public function order_kurir_list()
    {
       
        $list = $this->Order_kurir_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $list) {
            $data_bind = '
                data-order_id="'.$list->order_id.'" 
                data-userid="'.$list->userid.'" 
                data-nama_lengkap="'.$list->nama_lengkap.'" 
                data-tgl_checkout="'.$list->tgl_checkout.'" 
                data-total="'.$list->total.'"  
                data-total_format="'.$this->datenumberconverter->formatRupiah($list->total).'"  
                data-total_bonus="'.$list->total_bonus.'"  
                data-total_bonus_format="'.$this->datenumberconverter->formatRupiah($list->total_bonus).'"  
                data-grand_total="'.$list->grand_total.'" 
                data-grand_total_format="'.$this->datenumberconverter->formatRupiah($list->grand_total).'"  
                data-alamat_kirim="'.$list->alamat_kirim.'" 
                data-tipe_pembayaran="'.$list->tipe_pembayaran.'" 
                data-bukti_pembayaran="'.$list->bukti_pembayaran.'" 
                data-status_order_barang="'.$list->status_order_barang.'" 
                data-status="'.$list->status.'" 
                data-createdDateLunas="'.$list->createdDateLunas.'" 
                data-createdStatusLunas="'.$list->createdStatusLunas.'" 
                data-createdDate="'.$list->createdDate.'" 
                data-createdDatePacking="'.$list->createdDatePacking.'" 
                data-createdStatusPacking="'.$list->createdStatusPacking.'" 
                data-createdDatePengiriman="'.$list->createdDatePengiriman.'" 
                data-createdStatusPengiriman="'.$list->createdStatusPengiriman.'" 
                data-createdDateDone="'.$list->createdDateDone.'" 
                data-createdStatusDone="'.$list->createdStatusDone.'" 
                data-createdDateCancel="'.$list->createdDateCancel.'" 
                data-createdStatusCancel="'.$list->createdStatusCancel.'" 

                
            ';

            $select = '';

            if ($list->tipe_pembayaran == 'T') {
                if ($list->createdStatusLunas == 'n' && $list->createdStatusPacking == 'n' && $list->createdStatusPengiriman == 'n' &&  $list->createdStatusDone  == 'n' && $list->createdStatusCancel  == 'n' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                        <br>
                        <a href="javascript:void(0);" class="approve_record btn bg-olive btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-money-check-alt"></i> Approve Pembayaran</i></a> 
                        <a href="javascript:void(0);" class="delete_record btn btn-danger btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-times"> Batal </i></a> 
                    ';
                } else 
                if ($list->createdStatusLunas == 'y' && $list->createdStatusPacking == 'n' && $list->createdStatusPengiriman == 'n' &&  $list->createdStatusDone  == 'n' && $list->createdStatusCancel  == 'n' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                        <br>
                        <a href="javascript:void(0);" class="packing_record btn btn-primary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-box"> Packing</i></a> 
                        <a href="javascript:void(0);" class="delete_record btn btn-danger btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-times"> Batal </i></a> 
                    ';
                } else 
                if ($list->createdStatusLunas == 'y' && $list->createdStatusPacking == 'y' && $list->createdStatusPengiriman == 'n' &&  $list->createdStatusDone  == 'n' && $list->createdStatusCancel  == 'n' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                        <br>
                        <a href="javascript:void(0);" class="delivery_record btn btn-info btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-truck"></i> Kirim</i></a> 
                        <br>
                    ';
                } else 
                if ($list->createdStatusLunas == 'y' && $list->createdStatusPacking == 'y' && $list->createdStatusPengiriman == 'y' &&  $list->createdStatusDone  == 'n' && $list->createdStatusCancel  == 'n' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                        <br>
                        <a href="javascript:void(0);" class="checklist_record btn btn-success btn-xs"
                        '.$data_bind.'
                        ><i class="fas fa-check"> Selesai</i></a> 
                        <br>
                    ';
                } else 
                if ($list->createdStatusLunas == 'y' && $list->createdStatusPacking == 'y' && $list->createdStatusPengiriman == 'y' &&  $list->createdStatusDone  == 'y' && $list->createdStatusCancel  == 'n' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                    ';
                } else 
                if (($list->createdStatusLunas == 'y' && $list->createdStatusPacking == 'y' && $list->createdStatusPengiriman == 'y' &&  $list->createdStatusDone  == 'y' && $list->createdStatusCancel  == 'y') || $list->createdStatusCancel  == 'y' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                    ';
                }
            } else {
                
                if ($list->createdStatusPacking == 'n' && $list->createdStatusPengiriman == 'n' &&  $list->createdStatusDone  == 'n' && $list->createdStatusCancel  == 'n' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                        <br>
                        <a href="javascript:void(0);" class="packing_record btn btn-primary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-box"> Packing</i></a> 
                        <a href="javascript:void(0);" class="delete_record btn btn-danger btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-times"> Batal </i></a> 
                    ';
                } else 
                if ($list->createdStatusPacking == 'y' && $list->createdStatusPengiriman == 'n' &&  $list->createdStatusDone  == 'n' && $list->createdStatusCancel  == 'n' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                        <br>
                        <a href="javascript:void(0);" class="delivery_record btn btn-info btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-truck"></i> Kirim</i></a> 
                        <br>
                    ';
                } else 
                if ($list->createdStatusPacking == 'y' && $list->createdStatusPengiriman == 'y' &&  $list->createdStatusDone  == 'n' && $list->createdStatusCancel  == 'n' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                        <br>
                        <a href="javascript:void(0);" class="checklist_record btn btn-success btn-xs"
                        '.$data_bind.'
                        ><i class="fas fa-check"> Selesai</i></a> 
                        <br>
                    ';
                } else 
                if ($list->createdStatusPacking == 'y' && $list->createdStatusPengiriman == 'y' &&  $list->createdStatusDone  == 'y' && $list->createdStatusCancel  == 'n' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                    ';
                } else 
                if (($list->createdStatusPacking == 'y' && $list->createdStatusPengiriman == 'y' &&  $list->createdStatusDone  == 'y' && $list->createdStatusCancel  == 'y') || $list->createdStatusCancel  == 'y' ) {
                    $select .='
                        <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                        '.$data_bind.'
                        ><i class="fas fa-eye"></i> Detail</a> 
                    ';
                }
            }


            ++$no;
            $row = array();
            $row[] = $no;
            $row[] = $list->order_id;
            $row[] = $list->nama_lengkap;
            $row[] = $list->tgl_checkout;
            $row[] = 'Rp. '.$this->datenumberconverter->IdnCurrencyFormat($list->total);
            $row[] = 'Rp. '.$this->datenumberconverter->IdnCurrencyFormat($list->total_bonus);
            $row[] = 'Rp. '.$this->datenumberconverter->IdnCurrencyFormat($list->grand_total);
            if($list->bukti_pembayaran)
                $row[] = '<a href="'.base_url('upload/transaksi_order/'.$list->bukti_pembayaran).'" target="_blank" ><img src="'.base_url('upload/transaksi_order/'.$list->bukti_pembayaran).'" class="img-responsive" style="width: 100%; max-width: 100px; height: auto;" /></a>';
            else
                $row[] = '(No photo)';
            if($list->tipe_pembayaran == 'C')
                $row[] = 'COD';
            else
                $row[] = 'Transfer';
            $row[] = $list->alamat_kirim;
            $row[] = ucfirst($list->status_order_barang);
            $row[] = $select;
            $data[] = $row;
        }

        $output = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $this->Order_kurir_model->count_all(),
                        'recordsFiltered' => $this->Order_kurir_model->count_filtered(),
                        'data' => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function proses(){
        $order_id = $this->input->post('order_id', true);
        $data = array(
            'status_order_barang' => 'packing',
            'createdDatePacking' => date('Y-m-d H:i:s'),
            'createdStatusPacking' => 'y',
        );
        $update = $this->Order_kurir_model->update(array('order_id' => $order_id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'order_kurir',
                'activity'=>'Packing order_kurir',
                'keterangan'=>'Packing order_kurir No. Order '.$order_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function kirim(){
        $order_id = $this->input->post('order_id', true);
        $data = array(
            'status_order_barang' => 'pengiriman',
            'createdDatePengiriman' => date('Y-m-d H:i:s'),
            'createdStatusPengiriman' => 'y',
        );
        $update = $this->Order_kurir_model->update(array('order_id' => $order_id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'order_kurir',
                'activity'=>'pengiriman order_kurir',
                'keterangan'=>'pengiriman order_kurir No. Order'.$order_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function approve(){
        $order_id = $this->input->post('order_id', true);
        $data = array(
            'status_order_barang' => 'lunas',
            'createdDateLunas' => date('Y-m-d H:i:s'),
            'createdStatusLunas' => 'y',
        );
        $update = $this->Order_kurir_model->update(array('order_id' => $order_id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'order_kurir',
                'activity'=>'lunas order_kurir',
                'keterangan'=>'lunas order_kurir No. Order'.$order_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function selesai(){
        $order_id = $this->input->post('order_id', true);
        $data = array(
            'status_order_barang' => 'done',
            'createdDateDone' => date('Y-m-d H:i:s'),
            'createdStatusDone' => 'y',
        );
        $update = $this->Order_kurir_model->update(array('order_id' => $order_id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'order_kurir',
                'activity'=>'Selesai order_kurir',
                'keterangan'=>'Selesai order_kurir No. Order'.$order_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function cancel(){
        $order_id = $this->input->post('order_id', true);
        $data = array(
            'status_order_barang' => 'cancel',
            'createdDateCancel' => date('Y-m-d H:i:s'),
            'createdStatusCancel' => 'y',
        );
        $update = $this->Order_kurir_model->update(array('order_id' => $order_id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'order_kurir',
                'activity'=>'Selesai order_kurir',
                'keterangan'=>'Selesai order_kurir No. Order'.$order_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function get_detail_order_by_id($id){
        $list = $this->Order_kurir_model->get_detail_order_by_id($id);
        $no = 1;
        $html = '';
        foreach ($list as $list) {
            $html .= '
            <tr>
                <td class="text-center" style="vertical-align: middle;">' . $no . '.</td>
                <td class="text-center" style="vertical-align: middle;">'.$list->nama_barang.'</td>
                <td class="text-center" style="vertical-align: middle;">'.$list->satuan_jual.'</td>
                <td class="text-center" style="vertical-align: middle;">'.$list->quantity.'</td>
                <td class="text-right" style="vertical-align: middle;">'.$this->datenumberconverter->formatRupiah($list->harga_jual).'</td>
                <td class="text-right" style="vertical-align: middle;">'.$this->datenumberconverter->formatRupiah($list->harga_total).'</td>
            </tr>
            ';
            $no++;
        }
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }
}