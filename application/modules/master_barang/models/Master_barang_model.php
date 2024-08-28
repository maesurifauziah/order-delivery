<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Master_barang_model extends CI_Model
{
    public $table = 'master_barang';
        public $column_order = array(null,
        'a.kode_barang',  
        null,
        'a.nama_barang',
        null,
        null,  
        null,
        null,
    ); //set column field database for datatable orderable

    public $column_search = array(
        'a.kode_barang',  
        'a.nama_barang',
        ); //set column field database for datatable searchable
    public $order = array('nama_barang' => 'ASC'); // default order

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
        if ($this->input->get('kategori_id', true) != 'all') {
            $this->db->where('a.kategori_id', $this->input->get('kategori_id', true));
        }

        $this->db->select('
                        a.kode_barang,
                        a.nama_barang,
                        a.kategori_id,
                        b.kategori_desc,
                        a.harga_beli,
                        a.harga_jual,
                        a.satuan,
                        a.photo,
                        a.createdDate,
                        a.status,
                        a.keterangan,
                        a.stock
                    
        ');
        $this->db->from($this->table.' a');
        $this->db->join('master_kategori_barang b', 'b.kategori_id=a.kategori_id');
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

    public function get_list_barang($typeTerm, $searchTerm)
    { 
        // $sql = "SELECT * 
        //         FROM master_barang 
        //         WHERE nama_barang LIKE '%".$searchTerm."%'
        //             AND status = 'y'
        //         ORDER BY nama_barang ASC";
        // $result = $this->db->query($sql)->result();
        // return $result;
        if (!$typeTerm == '') {
            $this->db->where('kategori_id', $typeTerm);
        }
        if (!$searchTerm == '') {
            $this->db->like('nama_barang', $searchTerm);
        }

        $this->db->select('*');
        $this->db->from('master_barang');
        $this->db->order_by('nama_barang', 'ASC');
        
        
        return $this->db->get()->result();
    }
    
    public function get_list_barang_top3($searchTerm)
    { 
        $sql = "SELECT * 
                FROM master_barang 
                WHERE nama_barang LIKE '%".$searchTerm."%'
                    AND status = 'y'
                ORDER BY nama_barang ASC
                LIMIT 0,3";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_list_satuan_barang($kode_barang)
    { 
        $sql = "SELECT 
                    sat_kecil, 
                    sat_sedang,
                    sat_besar,  
                    harga_jual_kecil, 
                    harga_jual_sedang,
                    harga_jual_besar,
                    stock_kecil,
                    stock_sedang,
                    stock_besar
                FROM master_barang  
                WHERE kode_barang = '".$kode_barang."'";
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_list_barang_aktif_by_id($kode_barang)
    { 
        $this->db->select('*');
        $this->db->from('master_barang');
        $this->db->where('kode_barang', $kode_barang);
        return $this->db->get()->result();
    }

    public function get_all_master_barang()
    { 
        $this->db->select('*');
        $this->db->from('master_barang');
        return $this->db->get()->result();
    }

    public function generateIDBarang()
    {
        $code = "B";

        $sql = 'SELECT MAX(RIGHT(kode_barang,5)) as id
				  FROM master_barang
                  WHERE LEFT(kode_barang,1)="'.$code.'"
                  ORDER BY kode_barang DESC';

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

    public function upload_file($filename)
    {
        $this->load->library('upload');
        if (!is_dir('upload')) {
            mkdir('upload', 0777, true);
        }
        if (!is_dir('upload/master_barang')) {
            mkdir('upload/master_barang', 0777, true);
        }
        $config['upload_path'] = 'upload/master_barang';
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
}