<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Order_kurir_model extends CI_Model
{
    public $table = 'order_header';

    public $column_order = array(null,
                                'a.order_id',
                                'b.nama_lengkap',
                                'a.tgl_checkout',
                                'a.total',
                                'a.alamat_kirim',
                                'a.status_order_barang',
                                null); //set column field database for datatable orderable

    public $column_search = array('a.order_id',
    'a.userid',
    'b.nama_lengkap',
    'a.tgl_checkout',
    'a.total',
    'a.alamat_kirim',
    'a.status_order_barang'); //set column field database for datatable searchable
    public $order = array('a.createdDate' => 'DESC'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //add custom filter here
        if ($this->input->get('date_start', true) && $this->input->get('date_end', true)) {
            $this->db->where('a.tgl_checkout >=', $this->input->get('date_start', true));
            $this->db->where('a.tgl_checkout <=', $this->input->get('date_end', true));
        }

        if ($this->input->get('status_order_barang', true)) {
            if ($this->input->get('status_order_barang', true) != 'all') {
                $this->db->where('a.status_order_barang', $this->input->get('status_order_barang', true));
            }
        }

        // if ($this->input->get('oid', true)) {
        //     if ($this->input->get('oid', true) != 'all') {
        //         $this->db->where('d.oid', $this->input->get('oid', true));
        //     }
        // } else {
        //     $this->db->where('d.oid', $this->session->userdata('oid'));
        // }

        $this->db->select('
                            sa.order_id,
                            a.userid,
                            b.nama_lengkap,
                            a.tgl_checkout,
                            a.total,
                            a.total_bonus,
                            a.grand_total,
                            a.alamat_kirim,
                            a.tipe_pembayaran,
                            a.bukti_pembayaran,
                            a.status_order_barang,
                            a.status,
                            a.createdDate,
                            a.createdDateLunas,
                            a.createdStatusLunas,
                            a.createdDatePacking,
                            a.createdStatusPacking,
                            a.createdDatePengiriman,
                            a.createdStatusPengiriman,
                            a.createdDateDone,
                            a.createdStatusDone,
                            a.createdDateCancel,
                            a.createdStatusCancel,

                        ');
        $this->db->from($this->table.' a');
        $this->db->join('sys_user b','b.userid=a.userid');


        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) { //last loop
                    $this->db->group_end();
                } //close bracket
            }
            ++$i;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();

        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();

        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        // $this->db->where('status', '1');

        return $this->db->count_all_results();
    }

    public function get_all()
    {
        $this->db->order_by('activityID', $this->order);
        // $this->db->where('status', '1');

        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('activityID', $id);

        return $this->db->get($this->table)->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
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
        $this->db->where('activityID', $id);
        $this->db->delete($this->table);
    }
    
    public function GenerateIDActivity(){
		$date  = date("Ymd");

		$sql = 'SELECT MAX(RIGHT(activityID,5)) as id
				  FROM  log_activity
				  WHERE MID(activityID,3,8)='.$this->db->escape($date).'
                  ORDER BY activityID ASC';

		$result = $this->db->query($sql)->row();
		
		$id_last = $result->id;
		
		$id_new = $id_last + 1;
		$prev = "AC";
		
		if($id_new<10)
			$id = $prev.$date."0000".$id_new;
		else if(($id_new>=10)&&($id_new<=99))  
			$id = $prev.$date."000".$id_new;
		else if(($id_new>=100)&&($id_new<=999))  
			$id = $prev.$date."00".$id_new;
		else if(($id_new>=1000)&&($id_new<=9999))  
			$id = $prev.$date."0".$id_new;
		else if(($id_new>=10000)&&($id_new<=99999))  
			$id = $prev.$date.$id_new;

		$activityID = $id;

		return $activityID;
	}

    public function get_detail_order_by_id($order_id)
	{
        $this->db->select('*');
        $this->db->from('order_detail');
        $this->db->where('order_id', $order_id);
        return $this->db->get()->result();
    }
}