<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Bank Model Class
 *
 * @package     HRA CMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Achyar Anshorie
 */

class Category_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('category.category_id', $params['id']);
        }
        
        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if(isset($params['order_by']))
        {
            $this->db->order_by($params['order_by'], 'asc');
        }        

        $this->db->select('category.category_id, category_name,');               
        $res = $this->db->get('category');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }

    // Add and update to database
    function add($data = array()) {
        
         if(isset($data['category_id'])) {
            $this->db->set('category_id', $data['category_id']);
        }
        
         if(isset($data['category_name'])) {
            $this->db->set('category_name', $data['category_name']);
        }    
                   
         if (isset($data['category_id'])) {
            $this->db->where('category_id', $data['category_id']);
            $this->db->update('category');
            $id = $data['category_id'];
        } else {
            $this->db->insert('category');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    
    // Delete to database
    function delete($id) {
        $this->db->where('category_id', $id);
        $this->db->delete('category');
    }
    
}
