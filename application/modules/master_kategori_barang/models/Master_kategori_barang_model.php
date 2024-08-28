<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Master_kategori_barang_model extends CI_Model
{
    public $table = 'master_kategori_barang';
    public $column_order = array(null,
                                'a.kategori_id',
                                'a.kategori_desc',
                                'a.urutan',
                                'a.status',
                                null,
                            ); //set column field database for datatable orderable
    public $column_search = array(
                                'a.kategori_id',
                                'a.kategori_desc',	
                                'a.urutan',	
                                ); //set 

                            
    public $order = array('kategori_id' => 'ASC'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        ///add custom filter here
        if ($this->input->get('status', true)) {
            $this->db->where('a.status', $this->input->get('status', true));
        } 

        $this->db->select('
                        a.kategori_id,
                        a.kategori_desc,
                        a.urutan,
						a.status,
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

        return $this->db->count_all_results();
    }

    public function get_all()
    {
        $this->db->order_by('kategori_id', $this->order);

        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('kategori_id', $id);

        return $this->db->get($this->table)->row();
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);

        return TRUE;
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
        $this->db->where('kategori_id', $id);
        $this->db->delete($this->table);
    }

    function delete($where,$table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function generateIKategori()
    {
        $code = "KT";

        $sql = 'SELECT MAX(RIGHT(kategori_id,3)) as id
				  FROM master_kategori_barang
                  WHERE LEFT(kategori_id,2)="'.$code.'"
                  ORDER BY kategori_id DESC';

        $result = $this->db->query($sql)->row();
        $id_last = $result->id;
        $id_new = $id_last+1;
        
        if ($id_new<10) {
            $id = $code."00".$id_new;
        } elseif (($id_new>=10)&&($id_new<=99)) {
            $id = $code."0".$id_new;
        } elseif (($id_new>=100)&&($id_new<=999)) {
            $id = $code.$id_new;
        } 

        $generateID = $id;

        return $generateID;
    }

    public function get_list_master_kategori_barang_active()
    { 
        $this->db->select('*');
        $this->db->from('master_kategori_barang');
        $this->db->where('status', 'y');
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get()->result();
    }

    public function get_list_master_kategori_barang_not_all()
    { 
        $this->db->select('*');
        $this->db->from('master_kategori_barang');
        $this->db->where('status', 'y');
        $this->db->where('kategori_id !=', 'KT001');
        $this->db->order_by('urutan', 'ASC');
        return $this->db->get()->result();
    }

}
