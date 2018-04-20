<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Stores extends MY_Controller
{

    function __construct() {
        parent::__construct();

        if (!$this->loggedIn) {
            redirect('login');
        }

        $this->load->library('form_validation');
        $this->load->model('Stores_model');
    }

    function index()
    {
    	$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
    	$this->data['page_title'] = lang('stores');
    	$bc = array(array('link' => '#', 'page' => lang('stores')));
    	$meta = array('page_title' => lang('stores'), 'bc' => $bc);
    	$this->page_construct('stores/index', $this->data, $meta);
    }

	
    function get_stores()
    {

    	$this->load->library('datatables');
    	$this->datatables
    	->select("id, store_name, location")
    	->from("stores")
    	->add_column("Actions", "<div class='text-center'><div class='btn-group'><a href='" . site_url('stores/edit/$1') . "' class='tip btn btn-warning btn-xs' title='".$this->lang->line("edit_customer")."'><i class='fa fa-edit'></i></a> <a href='#' class='btn btn-danger btn-xs tip po' title='<b>" . lang("delete_store") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('stores/delete/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div></div>", "id")
    	->unset_column('id');

    	echo $this->datatables->generate();

    }

	
	function add()
	{

		$this->form_validation->set_rules('store_name', $this->lang->line("store_name"), 'required|is_unique[stores.store_name]');
		$this->form_validation->set_rules('location', $this->lang->line("location"), 'required');

		if ($this->form_validation->run() == true) {

			$data = array('store_name' => $this->input->post('store_name'),
				'location' => $this->input->post('location'),
			);

		}

		if ( $this->form_validation->run() == true && $this->Stores_model->addStore($data)) {

            $this->session->set_flashdata('message', $this->lang->line("store_added"));
            redirect("stores");

		} else {

			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
    		$this->data['page_title'] = lang('add_store');
    		$bc = array(array('link' => site_url('stores'), 'page' => lang('stores')), array('link' => '#', 'page' => lang('add_store')));
    		$meta = array('page_title' => lang('add_store'), 'bc' => $bc);
    		$this->page_construct('stores/add', $this->data, $meta);
		}
	}

	function edit($id = NULL)
	{
        if (!$this->Admin) {
            $this->session->set_flashdata('error', $this->lang->line('access_denied'));
            redirect('/');
        }
		if($this->input->get('id')) { $id = $this->input->get('id', TRUE); }
        $store = $this->Stores_model->getStoreByID($id);
		
		$this->form_validation->set_rules('store_name', $this->lang->line("store_name"), 'required');
		$this->form_validation->set_rules('location', $this->lang->line("location"), 'required');
        if ($store->store_name != $this->input->post('store_name')) {
            $this->form_validation->set_rules('store_name', $this->lang->line("store_name"), 'is_unique[stores.store_name]');
        }
		if ($this->form_validation->run() == true) {

			$data = array('store_name' => $this->input->post('store_name'),
				'location' => $this->input->post('location'),
				
			);

		}
		
  

		if ( $this->form_validation->run() == true && $this->Stores_model->updateStore($id, $data)) {

			$this->session->set_flashdata('message', $this->lang->line("store_updated"));
			redirect("stores");

		} else {

			$this->data['store'] = $store;
			$this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
    		$this->data['page_title'] = lang('edit_store');
    		$bc = array(array('link' => site_url('stores'), 'page' => lang('stores')), array('link' => '#', 'page' => lang('edit_store')));
    		$meta = array('page_title' => lang('edit_store'), 'bc' => $bc);
    		$this->page_construct('stores/edit', $this->data, $meta);

		}
		
		
	}
	
	function delete($id = NULL)
	{
		if(DEMO) {
			$this->session->set_flashdata('error', $this->lang->line("disabled_in_demo"));
			redirect('/');
		}

		if($this->input->get('id')) { $id = $this->input->get('id', TRUE); }

		if (!$this->Admin)
		{
			$this->session->set_flashdata('error', lang("access_denied"));
			redirect('/');
		}

		if ( $this->Stores_model->deleteStore($id) )
		{
			$this->session->set_flashdata('message', lang("store_deleted"));
			redirect("stores");
		}

	}
	
}