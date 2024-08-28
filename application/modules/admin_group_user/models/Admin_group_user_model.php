<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Admin_group_user_model extends CI_Model
{
    public $table = 'sys_group_user';
    public $column_order = array(null,
                                'a.user_group',
                                'a.group_name',
                                null,
                                'a.aktif',
                                null,
                            ); //set column field database for datatable orderable

                            public $column_search = array(
                                'a.user_group',
                                'a.group_name',
                                'a.aktif',
                                ); //set column field database for datatable searchable
    public $order = array('user_group' => 'ASC'); // default order

    public function __construct()
    {
        parent::__construct();
    }

    private function _get_datatables_query()
    {
        //add custom filter here
        if ($this->input->get('status', true)) {
            $this->db->where('a.aktif', $this->input->get('status', true));
        } else {
            $this->db->where('a.aktif', 'y');
        }
        

        $this->db->select(
            'a.user_group,  
                    a.group_name,
                    a.aktif'
                    
        );
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
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('aid', $id);

        return $this->db->get($this->table)->row();
    }

    public function save($header)
    {
        $this->db->insert($this->table, $header);
        return TRUE;
    }

    public function update($where, $header)
    {
        $this->db->update($this->table, $header, $where);
        return TRUE;
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

    public function generateIDUserGroup()
    {
        $sql = 'SELECT MAX(RIGHT(user_group,4)) as id
				  FROM sys_group_user                  
                  ORDER BY user_group DESC';

        $result = $this->db->query($sql)->row();
        $id_last = $result->id;
        $id_new = $id_last+1;
        
        if ($id_new<10) {
            $id = "000".$id_new;
        } elseif (($id_new>=10)&&($id_new<=99)) {
            $id = "00".$id_new;
        } elseif (($id_new>=100)&&($id_new<=999)) {
            $id = "0".$id_new;
        } elseif (($id_new>=1000)&&($id_new<=9999)) {
            $id = $id_new;
        }

        $generateID = $id;

        return $generateID;
    }

    public function get_list_group_user()
    { 
        return $this->db->get('sys_group_user')->result();
    }
}
