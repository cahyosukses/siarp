<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
* Arsip Model Class
 *
 * @package     HRA CMS
 * @subpackage  Models
 * @category    Models
 * @author      Achyar Anshorie
 */

class Arsip_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('arsip.arsip_id', $params['id']);
        }
        
        if(isset($params['category_category_id']))
        {
            $this->db->where('category.category_category_id', $params['category_category_id']);
        }

        if(isset($params['date_start']) AND isset($params['date_end']))
        {
            $this->db->where('bpjs_published_date >=', $params['date_start'] . ' 00:00:00');
            $this->db->where('bpjs_published_date <=', $params['date_end'] . ' 23:59:59');
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
            $this->db->order_by($params['order_by'], 'desc');
        }
        else
        {
            $this->db->order_by('arsip_last_update', 'desc');
        }

        $this->db->select('arsip.arsip_id, arsip_number, arsip_date, category_category_id, category_name, arsip_image, arsip_generate,          
            arsip.user_user_id, user_full_name, arsip_input_date, arsip_last_update');
        $this->db->join('category', 'category.category_id = arsip.category_category_id', 'left');
        $this->db->join('user', 'user.user_id = arsip.user_user_id', 'left');       
        $res = $this->db->get('arsip');

        if(isset($params['id']) OR (isset($params['limit']) AND $params['limit']==1))
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
        
       if(isset($data['arsip_id'])) {
        $this->db->set('arsip_id', $data['arsip_id']);
    }
    
    if(isset($data['arsip_generate'])) {
        $this->db->set('arsip_generate', $data['arsip_generate']);
    }

    if(isset($data['arsip_number'])) {
        $this->db->set('arsip_number', $data['arsip_number']);
    }

    if(isset($data['arsip_date'])) {
        $this->db->set('arsip_date', $data['arsip_date']);
    }
    
    if(isset($data['arsip_image'])) {
        $this->db->set('arsip_image', $data['arsip_image']);
    }    
    
    if(isset($data['category_id'])) {
        $this->db->set('category_category_id', $data['category_id']);
    }   

    if(isset($data['user_id'])) {
        $this->db->set('user_user_id', $data['user_id']);
    }   

    if(isset($data['arsip_input_date'])) {
        $this->db->set('arsip_input_date', $data['arsip_input_date']);
    }   

    if(isset($data['arsip_last_update'])) {
        $this->db->set('arsip_last_update', $data['arsip_last_update']);
    }   

    if (isset($data['arsip_id'])) {
        $this->db->where('arsip_id', $data['arsip_id']);
        $this->db->update('arsip');
        $id = $data['arsip_id'];
    } else {
        $this->db->insert('arsip');
        $id = $this->db->insert_id();
    }

    $status = $this->db->affected_rows();
    return ($status == 0) ? FALSE : $id;
}

    // Delete to database
function delete($id) {
    $this->db->where('arsip_id', $id);
    $this->db->delete('arsip');
}

}
