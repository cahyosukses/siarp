<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Arsip controllers class 
 *
 * @package     HRA CMS
 * @subpackage  Controllers
 * @category    Controllers
 * @author      Achyar Anshorie
 */
class Arsip extends CI_Controller {

    public function __construct() {
        parent::__construct(TRUE);
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('admin/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('Arsip_model', 'Activity_log_model', 'Category_model'));
        $this->load->helper('string');
    }

    // Surat Arsip view in list
    public function index($offset = NULL) {
        $this->load->library('pagination');
        $data['arsip'] = $this->Arsip_model->get(array('limit' => 10, 'offset' => $offset));
        $config['base_url'] = site_url('admin/arsip/index');
        $config['total_rows'] = count($this->Arsip_model->get(array('status' => TRUE)));
        $this->pagination->initialize($config);

        $data['title'] = 'Arsip Digital';
        $data['main'] = 'admin/arsip/arsip_list';
        $this->load->view('admin/layout', $data);
    }

    function detail($id = NULL) {
        if ($this->Arsip_model->get(array('id' => $id)) == NULL) {
            redirect('admin/arsip');
        }
        $data['arsip'] = $this->Arsip_model->get(array('id' => $id));
        $data['title'] = 'Arsip Digital';
        $data['main'] = 'admin/arsip/arsip_view';
        $this->load->view('admin/layout', $data);
    }

    // Add Surat and Update
    public function add($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('arsip_date', 'Tanggal Kirim', 'trim|required|xss_clean');                 
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
        $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

        if ($_POST AND $this->form_validation->run() == TRUE) {

            if ($this->input->post('arsip_id')) {
                $params['arsip_id'] = $this->input->post('arsip_id');
            } else {
                $lastnumber = $this->Arsip_model->get(array('limit' => 1, 'order_by' => 'arsip_id'));
                $num = $lastnumber['arsip_number'];
                $params['arsip_generate'] = "ARC-".sprintf('%03d', $num + 01);
                $params['arsip_input_date'] = date('Y-m-d H:i:s');
                
            }

            $params['arsip_number'] = $this->input->post('arsip_number');
            $params['arsip_date'] = $this->input->post('arsip_date');
            $params['category_id'] = $this->input->post('category_id');           
            $params['user_id'] = $this->session->userdata('user_id');            
            $params['arsip_last_update'] = date('Y-m-d H:i:s');
            $status = $this->Arsip_model->add($params);
 
            if (!empty($_FILES['arsip_image']['name'])) {
                $paramsupdate['arsip_image'] = $this->do_upload($name = 'arsip_image', $fileName = $params['arsip_generate']);
            }
            $paramsupdate['arsip_id'] = $status;
            $this->Arsip_model->add($paramsupdate);

            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id'),
                    'log_module' => 'Arsip Digital',
                    'log_action' => $data['operation'],
                    'log_info' => 'ID:'.$status.';Title:NULL' 
                    )
                );

            $this->session->set_flashdata('success', $data['operation'] . 'Arsip berhasil');
            redirect('admin/arsip');
        } else {
            if ($this->input->post('arsip_id')) {
                redirect('admin/arsip/edit/' . $this->input->post('arsip_id'));
            }

            // Edit mode
            if (!is_null($id)) {
                $data['arsip'] = $this->Arsip_model->get(array('id' => $id));
            }
            $data['category'] = $this->Category_model->get();
            $data['title'] = $data['operation'] . 'Arsip';
            $data['main'] = 'admin/arsip/arsip_add';
            $this->load->view('admin/layout', $data);
        }
    }

    // Delete Surat Arsip
    public function delete($id = NULL) {
        if ($_POST) {
            $this->Arsip_model->delete($this->input->post('del_id'));
            // activity log
            $this->Activity_log_model->add(
                array(
                    'log_date' => date('Y-m-d H:i:s'),
                    'user_id' => $this->session->userdata('user_id'),
                    'log_module' => 'Surat Arsip',
                    'log_action' => 'Hapus',
                    'log_info' => 'ID:' . $this->input->post('del_id') . ';Title:' . $this->input->post('del_name')
                    )
                );
            $this->session->set_flashdata('success', 'Hapus Surat Arsip berhasil');
            redirect('admin/arsip');
        } elseif (!$_POST) {
            $this->session->set_flashdata('delete', 'Delete');
            redirect('admin/arsip/edit/' . $id);
        }
    }

    function do_upload($name=NULL, $fileName=NULL) {
        $this->load->library('upload');

        $config['upload_path'] = FCPATH . 'uploads/arsips/';

        /* create directory if not exist */
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }

        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '32000';
        $config['file_name'] = $fileName;
                $this->upload->initialize($config);

        if (!$this->upload->do_upload($name)) {
            echo $config['upload_path'];
            $this->session->set_flashdata('success', $this->upload->display_errors(''));
            redirect(uri_string());
        }

        $upload_data = $this->upload->data();

        return $upload_data['file_name'];
    }

}



/* End of file Arsip.php */
/* Location: ./application/controllers/admin/Spb.php */
