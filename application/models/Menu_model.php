<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Menu_model extends CI_Model
{

    public $table = 'tbl_menu';
    public $id = 'id_menu';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json() {
        $this->datatables->select('id_menu,title,url,icon,is_main_menu,is_aktif');
        $this->datatables->from('tbl_menu');
        $this->datatables->order_by('id_menu', 'ASC');        
        $this->datatables->add_column('is_aktif', '$1', 'rename_string_is_aktif(is_aktif)');
        //add this line for join
        //$this->datatables->join('table2', 'tbl_menu.field = table2.field');
        $this->datatables->add_column('action',anchor(site_url('kelolamenu/update/$1'),'<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', array('class' => 'btn btn-danger btn-sm'))." 
                ".anchor(site_url('kelolamenu/delete/$1'),'<i class="fa fa-trash-o" aria-hidden="true"></i>','class="btn btn-danger btn-sm" onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_menu');
        return $this->datatables->generate();
    }
    
    function clab_update($id_user, $data)
    {
        $this->db->where('id_users', $id_user);
        $this->db->update('tbl_user', $data);
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_menu', $q);
	$this->db->or_like('title', $q);
	$this->db->or_like('url', $q);
	$this->db->or_like('icon', $q);
	$this->db->or_like('is_main_menu', $q);
	$this->db->or_like('is_aktif', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_menu', $q);
	$this->db->or_like('title', $q);
	$this->db->or_like('url', $q);
	$this->db->or_like('icon', $q);
	$this->db->or_like('is_main_menu', $q);
	$this->db->or_like('is_aktif', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function notif()
    {
        // if(isset($_POST['view'])){
            $query = $this->db->get('v_notif');
            $output = '';
            if ($query->num_rows() > 0)
            {
               foreach ($query->result() as $row)
               {
                    $output .= '
                    <li>
                    <a href="tbl_receive_sj">
                    <strong>'.$row->customer_name.'</strong><br />
                    <small>'.$row->delivery_number. ' <b> (' . $row->itemqty . ')</b></small>
                    </a>
                    </li>
                    ';
               }
            }
            else{
                 $output .= '
                 <li><a href="#" class="text-bold text-italic">No New Notification</a></li>';
            }
            
            $count = $query->num_rows();
            $data = array(
                'notification' => $output,
                'unseen_notification'  => $count
            );
            
            echo json_encode($data);
            // }
    }    
        
}

/* End of file Menu_model.php */
/* Location: ./application/models/Menu_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-10-04 10:50:27 */
/* http://harviacode.com */