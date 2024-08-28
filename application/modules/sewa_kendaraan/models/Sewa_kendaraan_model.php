<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Sewa_kendaraan_model extends CI_Model
{
    public $table = 'sewa_summary';
    public $table2 = 'sewa_header';
    public $table3 = 'sewa_detail';

    public function __construct()
    {
        parent::__construct();
    }


    public function count_all()
    {
        $this->db->from($this->table);
        // $this->db->where('status', '1');

        return $this->db->count_all_results();
    }

    public function get_all()
    {
        $this->db->order_by('aid', $this->order);
        // $this->db->where('status', '1');

        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('aid', $id);

        return $this->db->get($this->table)->row();
    }

    public function save($header, $detail)
    {
        $this->db->insert($this->table2, $header);
        $this->db->insert_batch($this->table3, $detail);
        return TRUE;
    }

    public function update_summary($where, $data)
    {
        $this->db->update($this->table, $data, $where);

        return $this->db->affected_rows();
    }

    public function save_summary($data)
    {
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function update_header($where, $data)
    {
        $this->db->update($this->table2, $data, $where);

        return $this->db->affected_rows();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);

        return $this->db->affected_rows();
    }

    public function update_batch($where, $data)
    {
        $this->db->update_batch($this->table, $data, $where);

        return $this->db->affected_rows();
    }

    public function delete_by_id($id)
    {
        $this->db->where('aid', $id);
        $this->db->delete($this->table);
    }
    function delete($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function get_list_user()
    { 
        return $this->db->get('sys_user')->result();
    }

    public function get_list_user_by_id_kantor($oid)
    { 
        $this->db->select('*');
        $this->db->from('sys_user');
        $this->db->where('oid', $oid);
        return $this->db->get()->result();
    }
    public function get_list_user_by_id_kantor_access($typeTerm, $searchTerm)
    { 
        $this->db->select('*');
        $this->db->from('sys_user');
        $this->db->where('oid', $typeTerm);
        $this->db->like('nama_lengkap', $searchTerm);
        return $this->db->get()->result();
    }

    public function generateIDUser()
    {
        $code = "U";

        $sql = 'SELECT MAX(RIGHT(userid,5)) as id
				  FROM sys_user
                  WHERE LEFT(userid,1)="'.$code.'"
                  ORDER BY userid DESC';

        $result = $this->db->query($sql)->row();
        $id_last = $result->id;
        $id_new = $id_last+1;
        
        if ($id_new<10) {
            $id = $code."0000".$id_new;
        } elseif (($id_new>=10)&&($id_new<=99)) {
            $id = $code."000".$id_new;
        } elseif (($id_new>=100)&&($id_new<=999)) {
            $id = $code."00".$id_new;
        } elseif (($id_new>=1000)&&($id_new<=9999)) {
            $id = $code."0".$id_new;
        } elseif (($id_new>=10000)&&($id_new<=99999)) {
            $id = $code.$id_new;
        }

        $generateID = $id;

        return $generateID;
    }

    public function generateDetailID($tgl_sewa, $userid){
		$sql = "SELECT MAX(detailid) as id
                FROM  sewa_summary
                WHERE tgl_sewa ='".$tgl_sewa."'				    
                    AND userid ='".$userid."'";
		$result = $this->db->query($sql)->row();
		$id_last = $result->id;
		$id_new = $id_last + 1;
		$detailID = $id_new;
		return $detailID;
	}

    public function get_subtotal_sewa($tgl_pinjam,$tgl_kembali,$harga_kendaraan){
        $tgl_pinjam=date_create($tgl_pinjam); //mis. tgl chekin
        $tgl_kembali=date_create($tgl_kembali); //mis. tgl chekout
        $diff=date_diff($tgl_pinjam,$tgl_kembali); 
        $jumlah_hari=$diff->format("%d%");
        if ($jumlah_hari == 0){
            $jumlah_hari = 1;
        }
        $subtotal_sewa = $harga_kendaraan * $jumlah_hari;
		return $subtotal_sewa;
	}

    public function get_list_sewa_summary()
    { 
        $this->db->select('
                        a.tgl_sewa,
                        a.kendaraan_id,
                        a.userid,
                        a.detailid,
                        a.nama_kendaraan,
                        a.photo,
                        a.tgl_pinjam,
                        a.tgl_kembali,
                        a.lama_pinjam,
                        a.harga_kendaraan,
                        a.subtotal_sewa,
                        a.createdDate,
                        a.status_sewa,
                        a.status,
                        b.merk_kendaraan,
                        b.deskripsi_kendaraan,
                        b.tahun_kendaraan,
                        b.kapasitas_kendaraan,
                        b.harga_kendaraan,
                        b.warna_kendaraan,
                        b.no_polisi
        ');
        $this->db->from('sewa_summary a');
        $this->db->join('master_kendaraan b', 'a.kendaraan_id=b.kendaraan_id');
        $this->db->where('a.userid', $this->session->userdata('userid'));
        $this->db->where('a.status_sewa', 'draft');
        $this->db->where('a.status', 'y');
        return $this->db->get()->result();
    }

    public function upload_file($filename, $doupload)
    {
        $this->load->library('upload');
        if (!is_dir('upload')) {
            mkdir('upload', 0777, true);
        }
        if (!is_dir('upload/transaksi_sewa')) {
            mkdir('upload/transaksi_sewa', 0777, true);
        }
        $config['upload_path'] = 'upload/transaksi_sewa';
        $config['allowed_types'] = '*';
        $config['max_size']    = '1024';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;

        $this->upload->initialize($config);
        if ($this->upload->do_upload($doupload)) {
            $res = array('status' => true, 'file' => $this->upload->data(), 'error' => '');
            return $res;
        } else {
            $res = array('status' => false, 'file' => '', 'error' => $this->upload->display_errors());
            return $res;
        }
    }

    public function GenerateIDTransSewa(){
		$date  = date("Ymd");

		$sql = 'SELECT MAX(RIGHT(sewa_id,3)) as id
				  FROM  sewa_header
				  WHERE MID(sewa_id,1,8)='.$this->db->escape(str_replace("U",'TRN',$this->session->userdata('userid'))).'
                  AND MID(sewa_id,9,8)='.$this->db->escape($date).'
                  ORDER BY sewa_id ASC';

		$result = $this->db->query($sql)->row();
		
		$id_last = $result->id;
		
		$id_new = $id_last + 1;
		$prev = str_replace("U",'TRN',$this->session->userdata('userid')).$date;
		
		if($id_new<10)
            $id = $prev."00".$id_new;
		else if(($id_new>=10)&&($id_new<=99))  
		$id = $prev."0".$id_new;
		else if(($id_new>=100)&&($id_new<=999))  
        $id = $prev.$id_new;

		$order_id = $id;

		return $order_id;
	}

    public function get_list_sewa_header_not_cancel()
    { 
        $sql = "SELECT
                    a.sewa_id,
                    a.grand_total,
                    a.uang_muka,
                    a.titik_jemput,
                    a.status_pembayaran,
                    a.statusUangMuka,
                    a.statusPelunasan,
                    a.createdStatusDone,
                    a.createdStatusCancel,
                    a.plat_nomer,
                    a.nama_supir,
                    b.tgl_sewa,
                    b.userid,
                    b.detailid,
                    b.kendaraan_id,
                    b.nama_kendaraan,
                    b.lama_pinjam,
                    b.harga_kendaraan,
                    b.tgl_pinjam,
                    b.tgl_kembali,
                    c.merk_kendaraan,
                    c.kapasitas_kendaraan,
                    b.subtotal_sewa,
                    b.createdDate,
                    b.status_sewa,
                    b.STATUS,
                    ( SELECT MIN( tgl_pinjam ) FROM sewa_detail WHERE sewa_id = a.sewa_id ) AS tgl_pinjam_min,
                    ( SELECT DATE( MIN( tgl_pinjam )) - INTERVAL 1 DAY FROM sewa_detail WHERE sewa_id = a.sewa_id ) AS tgl_pinjam_min_1  
                FROM
                    sewa_header a
                JOIN sewa_detail b ON b.sewa_id=a.sewa_id
                LEFT JOIN master_kendaraan c ON c.kendaraan_id = b.kendaraan_id 
                WHERE
                    a.userid = ".$this->db->escape($this->session->userdata('userid'))." 
                    AND a.status_pembayaran NOT IN ( 'done', 'cancel' )";

		$result = $this->db->query($sql)->result();
        return $result;
    }

    
}