<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Category controllers class
 *
 * @package     Arca CMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Achyar Anshorie
 */
class Category extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('Category_model', 'Activity_log_model'));
        $this->load->helper('string');
    }

    // Category view in list
    public function index($offset = NULL) {
        $this->load->library('pagination');
        $data['category'] = $this->Category_model->get(array('limit' => 10, 'offset' => $offset));
        $config['base_url'] = site_url('admin/category/index');
        $config['total_rows'] = count($this->Category_model->get(array('status' => TRUE)));
        $this->pagination->initialize($config);

        $data['title'] = 'Kategori';
        $data['main'] = 'admin/category/category_list';
        $this->load->view('admin/layout', $data);
    }

    function detail($id = NULL) {
        if ($this->Category_model->get(array('id' => $id)) == NULL) {
            redirect('admin/category');
        }
        $data['category'] = $this->Category_model->get(array('id' => $id));
        $data['title'] = 'Detail Kategori';
        $data['main'] = 'admin/category/category_view';
        $this->load->view('admin/layout', $data);
    }

    // Add Category and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('category_name', 'Name', 'trim|required|xss_clean');        
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('category_id')) {
                $params['category_id'] = $this->input->post('category_id');
            } else {                
                
            }

            $params['category_name'] = $this->input->post('category_name');            
            $params['user_id'] = $this->session->userdata('user_id');            
            $status = $this->Category_model->add($params);

            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id'),
                    'log_module' => 'Category',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:'.$status.';Title:' . $params['category_name']
                    )
                );

            $this->session->set_flashdata('success', $data['operation'] . ' Category berhasil');
            redirect('admin/category');
        } else {
            if ($this->input->post('category_id')) {
                redirect('admin/category/edit/' . $this->input->post('category_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $data['category'] = $this->Category_model->get(array('id' => $id));
            }
            $data['title'] = $data['operation'] . ' Category';
            $data['main'] = 'admin/category/category_add';
            $this->load->view('admin/layout', $data);
        }
    }

    // Delete Category
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Category_model->delete($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id'),
                    'log_module' => 'Category',
                    'log_action' => 'Hapus',
                    'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                    )
                );
            $this->session->set_flashdata('success', 'Hapus Category berhasil');
            redirect('admin/category');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/category/edit/' . $id);
        }
    }

}

/* End of file category.php */
/* Location: ./application/controllers/admin/category.php */
