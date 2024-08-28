<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Master_kendaraan_model extends CI_Model
{
    public $table = 'master_kendaraan';
        public $column_order = array(null,
                                    'a.kendaraan_id',  
                                    'a.photo',
                                    'a.nama_kendaraan',
                                    'a.merk_kendaraan',  
                                    'a.deskripsi_kendaraan',
                                    'a.tahun_kendaraan',
                                    'a.kapasitas_kendaraan',  
                                    'a.harga_kendaraan',
                                    'a.warna_kendaraan',
                                    'a.no_polisi',
                                    'a.status_sewa',
                                    'a.status',
                                    null,
    ); //set column field database for datatable orderable

    public $column_search = array(
        'a.kendaraan_id',  
        'a.photo',
        'a.nama_kendaraan',
        'a.merk_kendaraan',  
        'a.deskripsi_kendaraan',
        'a.tahun_kendaraan',
        'a.kapasitas_kendaraan',  
        'a.harga_kendaraan',
        'a.warna_kendaraan',
        'a.bensin_kendaraan',  
        'a.no_polisi',
        'a.status_sewa',
        'a.status',  
        ); //set column field database for datatable searchable
    public $order = array('kendaraan_id' => 'ASC'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //add custom filter here
        if ($this->input->get('status', true)) {
            $this->db->where('a.status', $this->input->get('status', true));
        } else {
            $this->db->where('a.status', 'y');
        }
        

        $this->db->select('
                    a.kendaraan_id,
                    a.photo,
                    a.nama_kendaraan,
                    a.merk_kendaraan,
                    a.deskripsi_kendaraan,
                    a.tahun_kendaraan,
                    a.kapasitas_kendaraan,
                    a.harga_kendaraan,
                    a.warna_kendaraan,
                    a.bensin_kendaraan,
                    a.no_polisi,
                    a.status_sewa,
                    a.status,
                    a.createdDate
        ');
        $this->db->from($this->table.' a');
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
        $this->db->order_by('aid', $this->order);
        // $this->db->where('status', '1');

        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('aid', $id);

        return $this->db->get($this->table)->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    function import_template($column, $values)
    {
        $onupdate = [];
        foreach($column as $list){
            $onupdate [] = $list."=VALUES(".$list.")";
        }
        $onupdate [] = 'status="y"';
        $sql  = " INSERT INTO ".$this->table." (".implode(', ',$column).") ";
        $sql .= " VALUES ".$values." ";
        $sql .= " ON DUPLICATE KEY UPDATE ".implode(', ',$onupdate).";";
        
        return $this->db->query($sql);
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

    public function get_list_kendaraan($typeTerm, $searchTerm)
    { 
        // if ($typeTerm != 'all') {
        //     $this->db->where('tipe_id', $typeTerm);
        // }
        $this->db->select('a.*');
        $this->db->from('master_kendaraan a');
        // $this->db->where('a.status_sewa', 'n');
        $this->db->where('a.status', 'y');
        $this->db->like('a.nama_kendaraan', $searchTerm);
        return $this->db->get()->result();
    }

    public function get_list_kendaraan_aktif_by_id($kendaraan_id)
    { 
        $this->db->select('*');
        $this->db->from('master_kendaraan');
        $this->db->where('kendaraan_id', $kendaraan_id);
        return $this->db->get()->result();
    }

    public function generateIDKendaraan()
    {
        $code = "KD";

        $sql = 'SELECT MAX(RIGHT(kendaraan_id,5)) as id
        FROM master_kendaraan
        WHERE LEFT(kendaraan_id,2)="'.$code.'"
        ORDER BY kendaraan_id DESC';

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
        }  elseif (($id_new>=10000)&&($id_new<=99999)) {
            $id = $code.$id_new;
        } 

        $generateID = $id;

        return $generateID;
    }

    public function upload_file($filename)
    {
        $this->load->library('upload');
        if (!is_dir('upload')) {
            mkdir('upload', 0777, true);
        }
        if (!is_dir('upload/master_kendaraan')) {
            mkdir('upload/master_kendaraan', 0777, true);
        }
        $config['upload_path'] = 'upload/master_kendaraan';
        $config['allowed_types'] = '*';
        $config['max_size']    = '1024';
        $config['overwrite'] = true;
        $config['file_name'] = $filename;

        $this->upload->initialize($config);
        if ($this->upload->do_upload('photo')) {
            $res = array('status' => true, 'file' => $this->upload->data(), 'error' => '');
            return $res;
        } else {
            $res = array('status' => false, 'file' => '', 'error' => $this->upload->display_errors());
            return $res;
        }
    }

    public function get_all_master_kendaraan()
    { 
        $this->db->select('*');
        $this->db->from('master_kendaraan');
        return $this->db->get()->result();
    }

}