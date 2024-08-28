<?php
defined('BASEPATH') or exit('No direct script access allowed');
 
class Sewa_kendaraan_approver extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'Sewa_kendaraan_approver_model',
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

        $this->load->view('sewa_kendaraan_approver_view', $data);
    }

    public function sewa_kendaraan_approver_list()
    {
       
        $list = $this->Sewa_kendaraan_approver_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $list) {
            $data_bind = '
                data-sewa_id="'.$list->sewa_id.'" 
                data-userid="'.$list->userid.'" 
                data-nama_lengkap="'.$list->nama_lengkap.'" 
                data-tgl_checkout="'.$list->tgl_checkout.'" 
                data-bukti_pembayaran_uang_muka="'.$list->bukti_pembayaran_uang_muka.'" 
                data-bukti_pembayaran_pelunasan="'.$list->bukti_pembayaran_pelunasan.'" 
                data-titik_jemput="'.$list->titik_jemput.'" 
                data-grand_total="'.$list->grand_total.'" 
                data-grand_total_format="'.$this->datenumberconverter->formatRupiah($list->grand_total).'"  
                data-uang_muka="'.$list->uang_muka.'" 
                data-uang_muka_format="'.$this->datenumberconverter->formatRupiah($list->uang_muka).'"  
                data-status_pembayaran="'.$list->status_pembayaran.'" 
                data-status="'.$list->status.'" 
                data-createdDate="'.$list->createdDate.'" 
                data-createdDateUangMuka="'.$list->createdDateUangMuka.'" 
                data-statusUangMuka="'.$list->statusUangMuka.'" 
                data-approvalUangMuka="'.$list->approvalUangMuka.'" 
                data-createdDatePelunasan="'.$list->createdDatePelunasan.'" 
                data-statusPelunasan="'.$list->statusPelunasan.'" 
                data-approvalPelunasan="'.$list->approvalPelunasan.'" 
                data-createdDateDone="'.$list->createdDateDone.'" 
                data-createdStatusDone="'.$list->createdStatusDone.'" 
                data-approvalDone="'.$list->approvalDone.'" 
                data-createdDateCancel="'.$list->createdDateCancel.'" 
                data-createdStatusCancel="'.$list->createdStatusCancel.'" 
                data-approvalCancel="'.$list->approvalCancel.'"                
                data-nama_approval_uangmuka="'.$list->nama_approval_uangmuka.'"                
                data-nama_approval_pelunasan="'.$list->nama_approval_pelunasan.'"                
                data-nama_approval_done="'.$list->nama_approval_done.'"                
                data-nama_approval_cancel="'.$list->nama_approval_cancel.'"                
            ';

            $select = '';
            if ($list->status_pembayaran == 'uang_muka' && $list->statusUangMuka == 'n' ) {
                $select .='
                    <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-eye"></i> Detail</a> 
                    <br>
                    <a href="javascript:void(0);" class="down_paymen_record btn btn-info btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-money-bill-wave"> Approve Uang Muka</i></a> 
                    <a href="javascript:void(0);" class="delete_record btn btn-danger btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-times"> Batal </i></a> 
                ';
            } else if ($list->status_pembayaran == 'pelunasan' && $list->statusPelunasan == 'n') {
                $select .='
                    <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-eye"></i> Detail</a> 
                    <br>
                    <a href="javascript:void(0);" class="pelunasan_record btn btn-primary btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-money-bill-wave-alt"> Approve Pelunasan</i></a> 
                    <a href="javascript:void(0);" class="delete_record btn btn-danger btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-times"> Batal </i></a> 
                ';
            } else if ($list->status_pembayaran == 'pelunasan' && $list->statusPelunasan == 'y') {
                $select .='
                    <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-eye"></i> Selesai</a> 
                    <br>
                    <a href="javascript:void(0);" class="done_record btn btn-success btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-check"> Selesai</i></a> 
                ';
            } else {
                $select .='
                    <a href="javascript:void(0);" class="view_record btn btn-secondary btn-xs" 
                    '.$data_bind.'
                    ><i class="fas fa-eye"></i> Detail</a> 
                ';
            }

            ++$no;
            $row = array();
            $row[] = $no;
            $row[] = $list->sewa_id;
            $row[] = $list->nama_lengkap;
            $row[] = $list->tgl_checkout;
            $row[] = 'Rp. '.$this->datenumberconverter->IdnCurrencyFormat($list->uang_muka);
            if($list->bukti_pembayaran_uang_muka)
                $row[] = '<a href="'.base_url('upload/transaksi_sewa/'.$list->bukti_pembayaran_uang_muka).'" target="_blank" ><img src="'.base_url('upload/transaksi_sewa/'.$list->bukti_pembayaran_uang_muka).'" class="img-responsive" style="width: 100%; max-width: 100px; height: auto;" /></a>';
            else
                $row[] = '(No photo)';
            $row[] = 'Rp. '.$this->datenumberconverter->IdnCurrencyFormat($list->grand_total);
            if($list->bukti_pembayaran_pelunasan)
                $row[] = '<a href="'.base_url('upload/transaksi_sewa/'.$list->bukti_pembayaran_pelunasan).'" target="_blank" ><img src="'.base_url('upload/transaksi_sewa/'.$list->bukti_pembayaran_pelunasan).'" class="img-responsive" style="width: 100%; max-width: 100px; height: auto;" /></a>';
            else
                $row[] = '(No photo)';

            $row[] = ucfirst($list->status_pembayaran);
            if ($list->status_pembayaran == 'uang_muka') {
                $row[] = $list->statusUangMuka;
                $row[] = $list->nama_approval_uangmuka;
            } else if ($list->status_pembayaran == 'pelunasan') {
                $row[] = $list->statusPelunasan;
                $row[] = $list->nama_approval_pelunasan;
            } else if ($list->status_pembayaran == 'done') {
                $row[] = '-';
                $row[] = $list->nama_approval_done;
            } else if ($list->status_pembayaran == 'cancel') {
                $row[] = '-';
                $row[] = $list->nama_approval_cancel;
            }
            $row[] = $list->titik_jemput;
            $row[] = $select;
            $data[] = $row;
        }

        $output = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $this->Sewa_kendaraan_approver_model->count_all(),
                        'recordsFiltered' => $this->Sewa_kendaraan_approver_model->count_filtered(),
                        'data' => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    public function approve_uang_muka(){
        $sewa_id = $this->input->post('sewa_id', true);
        $data = array(
            'status_pembayaran' => 'uang_muka',
            'createdDateUangMuka' => date('Y-m-d H:i:s'),
            'statusUangMuka' => 'y',
            'approvalUangMuka' => $this->session->userdata('userid'),
        );
        $update = $this->Sewa_kendaraan_approver_model->update(array('sewa_id' => $sewa_id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'sewa_kendaraan_approver',
                'activity'=>'Packing sewa_kendaraan_approver',
                'keterangan'=>'Packing sewa_kendaraan_approver No. Order '.$sewa_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function approve_pelunasan(){

        $this->_validate("approve_pelunasan");
        $sewa_id = $this->input->post('sewa_id_lns', true);
        $plat_nomer = $this->input->post('plat_nomer', true);
        $nama_supir = $this->input->post('nama_supir', true);

        $data = array(
            'createdDatePelunasan' => date('Y-m-d H:i:s'),
            'statusPelunasan' => 'y',
            'approvalPelunasan' => $this->session->userdata('userid'),
            'plat_nomer' => $plat_nomer,
            'nama_supir' => $nama_supir,
        );
        $update = $this->Sewa_kendaraan_approver_model->update(array('sewa_id' => $sewa_id), $data);
        $list = $this->Sewa_kendaraan_approver_model->get_detail_sewa_by_id($sewa_id);
        foreach ($list as $list) {
            $where = array(
                'kendaraan_id' => $list->kendaraan_id,
            );
            $data_update = array(
                "status_sewa"  => 'y',
            );
            $this->Sewa_kendaraan_approver_model->update_kendaraan($where, $data_update);
        } 
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'sewa_kendaraan_approver',
                'activity'=>'Packing sewa_kendaraan_approver',
                'keterangan'=>'Packing sewa_kendaraan_approver No. Order '.$sewa_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        // echo json_encode($data);
        echo json_encode(array('status' => true));
    }

    public function selesai(){
        $sewa_id = $this->input->post('sewa_id', true);
        $data = array(
            'status_pembayaran' => 'done',
            'createdDateDone' => date('Y-m-d H:i:s'),
            'createdStatusDone' => 'y',
            'approvalDone' => $this->session->userdata('userid'),
        );
        $list = $this->Sewa_kendaraan_approver_model->get_detail_sewa_by_id($sewa_id);
        foreach ($list as $list) {
            $where = array(
                'kendaraan_id' => $list->kendaraan_id,
            );
            $data_update = array(
                "status_sewa"  => 'n',
            );
            $this->Sewa_kendaraan_approver_model->update_kendaraan($where, $data_update);
        } 
        $update = $this->Sewa_kendaraan_approver_model->update(array('sewa_id' => $sewa_id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'sewa_kendaraan_approver',
                'activity'=>'Selesai sewa_kendaraan_approver',
                'keterangan'=>'Selesai sewa_kendaraan_approver No. Order'.$sewa_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function cancel(){
        $sewa_id = $this->input->post('sewa_id', true);
        $data = array(
            'status_pembayaran' => 'cancel',
            'createdDateCancel' => date('Y-m-d H:i:s'),
            'createdStatusCancel' => 'y',
            'approvalCancel' => $this->session->userdata('userid'),
        );
        $update = $this->Sewa_kendaraan_approver_model->update(array('sewa_id' => $sewa_id), $data);
        if ($update){
            $logdata = array(
                'activityID'=>$this->Log_activity_model->GenerateIDActivity(),
                'userid'=>$this->session->userdata('userid'),
                'modul'=>'sewa_kendaraan_approver',
                'activity'=>'Selesai sewa_kendaraan_approver',
                'keterangan'=>'Selesai sewa_kendaraan_approver No. Order'.$sewa_id,
                'createdDate'=>date('Y-m-d H:i:s'),
                'status'=>'y',
            );
            $this->Log_activity_model->save($logdata);
        }
        echo json_encode(array('status' => true));
    }

    public function tes(){
        $list = $this->Sewa_kendaraan_approver_model->get_detail_sewa_by_id('TRN0000320220226001');
        foreach ($list as $list) {
            $where = array(
                'kendaraan_id' => $list->kendaraan_id,
            );
            $data = array(
                "status_sewa"  => 'y',
            );
            $this->Sewa_kendaraan_approver_model->update_kendaraan($where, $data);
        } 

        echo json_encode($data);
    }

    public function get_detail_sewa_by_id($id){
        $list = $this->Sewa_kendaraan_approver_model->get_detail_sewa_by_id($id);
        $no = 1;
        $html = '';
        foreach ($list as $list) {
            $html .= '
            <tr>
                <td class="text-center" style="vertical-align: middle;">' . $no . '.</td>
                <td class="text-center" style="vertical-align: middle;">'.$list->nama_kendaraan.'</td>
                <td class="text-center" style="vertical-align: middle;">'.$list->merk_kendaraan.'</td>
                <td class="text-center" style="vertical-align: middle;">'.$list->tgl_pinjam.' - '.$list->tgl_kembali.'</td>
                <td class="text-center" style="vertical-align: middle;">'.$list->lama_pinjam.' Hari</td>
                <td class="text-right" style="vertical-align: middle;">'.$this->datenumberconverter->formatRupiah($list->harga_kendaraan).'</td>
                <td class="text-right" style="vertical-align: middle;">'.$this->datenumberconverter->formatRupiah($list->subtotal_sewa).'</td>
            </tr>
            ';
            $no++;
        }
        header('Content-Type: application/json');
        echo json_encode(['html' => $html]);
    }

    private function _validate($act)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = true;
        
        if ($act == "approve_pelunasan") {
            if ($this->input->post('sewa_id_lns') == '') {
                $data['inputerror'][] = 'sewa_id_lns';
                $data['error_string'][] = 'Sewa id harus di isi';
                $data['status'] = false;
            }
            if ($this->input->post('plat_nomer') == '') {
                $data['inputerror'][] = 'plat_nomer';
                $data['error_string'][] = 'Plat Nomer harus di isi';
                $data['status'] = false;
            }
            if ($this->input->post('nama_supir') == '') {
                $data['inputerror'][] = 'nama_supir';
                $data['error_string'][] = 'Nama Supir harus di isi';
                $data['status'] = false;
            }
        }
       
       
        if ($data['status'] === false) {
            echo json_encode($data);
            exit();
        }
    }
}