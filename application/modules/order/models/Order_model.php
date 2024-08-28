<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Order_model extends CI_Model
{
    public $table = 'order_summary';
    public $table2 = 'order_header';
    public $table3 = 'order_detail';

    public $column_order = array(null,
                                'a.activityID',
                                'a.createdDate',
                                'a.userid',
                                'b.nama_lengkap',
                                'd.nama_kantor',
                                'a.ip',
                                'a.modul',
                                'a.activity',
                                'a.keterangan'); //set column field database for datatable orderable

    public $column_search = array('a.activityID', 'a.createdDate', 'a.userid', 'b.nama_lengkap', 'd.nama_kantor', 'a.ip', 'a.modul', 'a.activity', 'a.keterangan'); //set column field database for datatable searchable
    public $order = array('createdDate' => 'DESC'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    

    // private function _get_datatables_query()
    // {
    //     //add custom filter here
    //     if ($this->input->get('date_start', true) && $this->input->get('date_end', true)) {
    //         $this->db->where('DATE(a.createdDate)>=', $this->input->get('date_start', true));
    //         $this->db->where('DATE(a.createdDate)<=', $this->input->get('date_end', true));
    //     }


    //     $this->db->select('
    //                     a.activityID,
    //                     a.userid,
    //                     b.nama_lengkap,
    //                     a.modul,
    //                     a.activity,
    //                     a.keterangan,
    //                     a.createdDate,
    //                     a.ip,
    //                     a.status
    //                     ');
    //     $this->db->from($this->table.' a');
    //     $this->db->join('sys_user b','b.userid=a.userid');


    //     $i = 0;

    //     foreach ($this->column_search as $item) { // loop column
    //         if ($_POST['search']['value']) { // if datatable send POST for search
    //             if ($i === 0) { // first loop
    //                 $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
    //                 $this->db->like($item, $_POST['search']['value']);
    //             } else {
    //                 $this->db->or_like($item, $_POST['search']['value']);
    //             }

    //             if (count($this->column_search) - 1 == $i) { //last loop
    //                 $this->db->group_end();
    //             } //close bracket
    //         }
    //         ++$i;
    //     }

    //     if (isset($_POST['order'])) { // here order processing
    //         $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    //     } elseif (isset($this->order)) {
    //         $order = $this->order;
    //         $this->db->order_by(key($order), $order[key($order)]);
    //     }
    // }

    // public function get_datatables()
    // {
    //     $this->_get_datatables_query();
    //     if ($_POST['length'] != -1) {
    //         $this->db->limit($_POST['length'], $_POST['start']);
    //     }
    //     $query = $this->db->get();

    //     return $query->result();
    // }

    // public function count_filtered()
    // {
    //     $this->_get_datatables_query();
    //     $query = $this->db->get();

    //     return $query->num_rows();
    // }

    // public function count_all()
    // {
    //     $this->db->from($this->table);
    //     // $this->db->where('status', '1');

    //     return $this->db->count_all_results();
    // }

    // public function get_all()
    // {
    //     $this->db->order_by('activityID', $this->order);
    //     // $this->db->where('status', '1');

    //     return $this->db->get($this->table)->result();
    // }

    // public function get_by_id($id)
    // {
    //     $this->db->where('activityID', $id);

    //     return $this->db->get($this->table)->row();
    // }

    public function save($header, $detail)
    {
        $this->db->insert($this->table2, $header);
        $this->db->insert_batch($this->table3, $detail);
        return TRUE;
    }

    public function save_summary($data)
    {
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function update_summary($where, $data)
    {
        $this->db->update($this->table, $data, $where);

        return $this->db->affected_rows();
    }

    // public function update_batch($where, $data)
    // {
    //     $this->db->update_batch($this->table, $data, $where);

    //     return $this->db->affected_rows();
    // }

    // public function delete_by_id($id)
    // {
    //     $this->db->where('activityID', $id);
    //     $this->db->delete($this->table);
    // }
    
    public function generateDetailID($tgl_order, $userid){
		$sql = "SELECT MAX(detailid) as id
                FROM  order_summary
                WHERE tgl_order ='".$tgl_order."'				    
                    AND userid ='".$userid."'";
		$result = $this->db->query($sql)->row();
		$id_last = $result->id;
		$id_new = $id_last + 1;
		$detailID = $id_new;
		return $detailID;
	}

    public function get_list_order_summary()
    { 
        $this->db->select('*');
        $this->db->from('order_summary');
        $this->db->where('userid', $this->session->userdata('userid'));
        $this->db->where('status_order', 'draft');
        $this->db->where('status', 'y');
        return $this->db->get()->result();
    }

    public function GenerateIDOrder(){
		$date  = date("Ymd");

		$sql = 'SELECT MAX(RIGHT(order_id,3)) as id
				  FROM  order_header
				  WHERE MID(order_id,1,6)='.$this->db->escape($this->session->userdata('userid')).'
                  AND MID(order_id,7,8)='.$this->db->escape($date).'
                  ORDER BY order_id ASC';

		$result = $this->db->query($sql)->row();
		
		$id_last = $result->id;
		
		$id_new = $id_last + 1;
		$prev = $this->session->userdata('userid').$date;
		
		if($id_new<10)
            $id = $prev."00".$id_new;
		else if(($id_new>=10)&&($id_new<=99))  
		$id = $prev."0".$id_new;
		else if(($id_new>=100)&&($id_new<=999))  
        $id = $prev.$id_new;

		$order_id = $id;

		return $order_id;
	}

    public function get_list_order_header_proses()
    { 
        $sql = "SELECT * 
                FROM order_header 
                WHERE userid = ".$this->db->escape($this->session->userdata('userid'))."
                    AND status_order_barang NOT IN ('cancel','done')
                ORDER BY order_id DESC";

		$result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_list_order_header_done()
    { 
        $sql = "SELECT * 
                FROM order_header 
                WHERE userid = ".$this->db->escape($this->session->userdata('userid'))."
                    AND status_order_barang = 'done' 
                    AND createdStatusDone = 'y'
                ORDER BY order_id DESC";

		$result = $this->db->query($sql)->result();
        return $result;
    }

    public function upload_file($filename, $doupload)
    {
        $this->load->library('upload');
        if (!is_dir('upload')) {
            mkdir('upload', 0777, true);
        }
        if (!is_dir('upload/transaksi_order')) {
            mkdir('upload/transaksi_order', 0777, true);
        }
        $config['upload_path'] = 'upload/transaksi_order';
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
}