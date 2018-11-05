<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Check_out extends MY_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect('logout');
        }

        $this->load->library('form_validation');
        $this->load->model('check_out_model');
        $this->load->model('stores_model');
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt';
    }

    public function index() {
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $this->data['page_title'] = lang('check_outs');
        $this->page_construct('check_out/index', $this->data);
    }

    public function get_list() {
        $start_date = $this->input->get('start_date') ? $this->input->get('start_date') : NULL;
        $end_date = $this->input->get('end_date') ? $this->input->get('end_date') : NULL;

        $this->load->library('datatables');
        $this->datatables
        ->select($this->db->dbprefix('check_out').".id as id, date, reference, ".$this->db->dbprefix('stores').".store_name, concat(".$this->db->dbprefix('users').".first_name, ' ', ".$this->db->dbprefix('users').".last_name) as created_by, note, attachment", FALSE)
        ->from('check_out')
        ->join('users', 'users.id=check_out.created_by', 'left')
        ->join('stores', 'stores.id=check_out.store_id', 'left')
        ->group_by('check_out.id')
        ->add_column("Actions", "<div class='text-center'><div class='btn-group btn-group-justified' role='group'> <div class='btn-group' role='group'><a class=\"btn btn-warning btn-xs tip\" title='" . lang("edit_check_out") . "' href='" . site_url('check_out/edit/$1') . "'><i class=\"fa fa-edit\"></i></a></div> <div class='btn-group' role='group'><a href='#' class='btn btn-danger btn-xs tip po' title='<b>" . lang("delete_check_out") . "</b>' data-content=\"<p>" . lang('action_x_undone') . "</p><a class='btn btn-danger po-delete' href='" . site_url('check_out/delete/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></div></div>", "id");
        //$this->datatables->unset_column("id");
        if($start_date) { $this->datatables->where('date >=', $start_date); }
        if($end_date) { $this->datatables->where('date <=', $end_date); }
		
		if(!$this->Admin){
			$this->datatables->where('check_out.store_id ='. $this->store_id);
		}
		
        echo $this->datatables->generate();
    }

    public function view($id) {

        $inv = $this->check_out_model->getStockOutByID($id);
        $this->data['inv'] = $inv;
        $this->data['items'] = $this->check_out_model->getAllOutItems($id);
        $this->data['created_by'] = $this->check_out_model->getUser($inv->created_by);
        $this->data['updated_by'] = $this->check_out_model->getUser($inv->updated_by);
        $this->data['store'] = $this->stores_model->getStoreByID($inv->store_id);
        $this->data['page_title'] = lang('check_out_id')." ".$id;
        $this->load->view($this->theme.'check_out/view', $this->data);
    }

    public function add() {

        $this->form_validation->set_rules('reference', lang("reference"), 'trim|required|is_unique[check_out.reference]');
        $this->form_validation->set_rules('date', lang("date"), 'trim|required');
        	if($this->Admin){
		$this->form_validation->set_rules('store', lang("store"), 'trim|required');
			}
        if ($this->form_validation->run() == true) {

            $quantity = "quantity";
            $product_id = "product_id";
            $i = isset($_POST['product_id']) ? sizeof($_POST['product_id']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['product_id'][$r];
                $item_qty = $_POST['quantity'][$r];
                $item_plate_code = $_POST['plate_code'][$r];
                $serial_number = $_POST['serial_number'][$r];
                $item_plate_number = $_POST['plate_number'][$r];
                if( $item_id && $item_qty && $item_plate_code && $item_plate_number) {

                    if(!$this->check_out_model->getItemByID($item_id)) {
                        $this->session->set_flashdata('error', $this->lang->line("product_not_found")." ( ".$item_id." ).");
                        redirect('check_out/add');
                    }

                    $items[] = array(
                        'item_id' => $item_id,
                        'quantity' => $item_qty,
                        'plate_code' => $item_plate_code,
                        'plate_number' => $item_plate_number,
                        'serial_number' => $serial_number,
                        );

                }
            }

            if (!isset($items) || empty($items)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                krsort($items);
            }

			if($this->Admin){
				$store_id = $this->input->post('store');
			}else{
				$store_id = $this->store_id ;
			}
			
            $data = array( 'date' => $this->input->post('date'),
                'reference' => $this->input->post('reference'),
                'store_id' => $store_id ,
                'note' => $this->input->post('note'),
                'created_by' => $this->session->userdata('user_id'),
            );

            if ($_FILES['attachment']['size'] > 0) {

                $this->load->library('upload');
                $config['upload_path'] = 'uploads/';
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = 2000;
                $config['encrypt_name'] = TRUE;
                $config['overwrite'] = FALSE;
                $config['file_ext_tolower'] = TRUE;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('attachment')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("check_out/add");
                }

                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;

            }

            // $this->tec->print_arrays($data, $items);

        }

        if ( $this->form_validation->run() == true && $this->check_out_model->addStockOut($data, $items)) {
            $this->session->set_flashdata('message', lang("check_out_added"));
            redirect('check_out');
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $this->data['page_title'] = lang('add_check_out');
            $this->data['stores'] = $this->stores_model->getAllStores();
			$this->data['reference'] = $this->check_out_model->generateReference();
            $this->page_construct('check_out/add', $this->data);

        }
    }

    public function add_by_csv() {

        $this->form_validation->set_rules('reference', lang("reference"), 'trim|required|is_unique[check_out.reference]');
        $this->form_validation->set_rules('date', lang("date"), 'trim|required');
        
		if($this->Admin)
		$this->form_validation->set_rules('store', lang("store"), 'trim|required');

		
        if ($this->form_validation->run() == true) {

          if (isset($_FILES["userfile"])) {

              $this->load->library('upload');

              $config['upload_path'] = 'uploads/';
              $config['allowed_types'] = 'csv';
              $config['max_size'] = '500';
              $config['overwrite'] = TRUE;
              $config['encrypt_name'] = TRUE;

              $this->upload->initialize($config);

              if (!$this->upload->do_upload()) {
                  $error = $this->upload->display_errors();
                  $this->session->set_flashdata('error', $error);
                  redirect("check_out/add_by_csv");
              }


              $csv = $this->upload->file_name;

              $arrResult = array();
              $handle = fopen("uploads/" . $csv, "r");
              if ($handle) {
                  while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                      $arrResult[] = $row;
                  }
                  fclose($handle);
              }
              array_shift($arrResult);

              $keys = array('code', 'quantity');

              $final = array();
              foreach ($arrResult as $key => $value) {
                  $final[] = array_combine($keys, $value);
              }

              if (sizeof($final) > 1001) {
                  $this->session->set_flashdata('error', lang("more_than_allowed"));
                  redirect("check_out/add_by_csv");
              }

              foreach ($final as $csv_pr) {
                  if($item = $this->check_out_model->getItemByCode($csv_pr['code'])) {
                    $items[] = array('item_id' => $item->id, 'quantity' => $csv_pr['quantity']);
                  } else {
                    $this->session->set_flashdata('error', lang("check_item_code") . " (" . $csv_pr['code'] . "). " . lang("item_x_exist"));
                    redirect("check_out/add_by_csv");
                  }

              }
          } else {
            $this->form_validation->set_rules('userfile', lang("csv_file"), 'required');
          }

		  
		if($this->Admin){
			$store_id = $this->input->post('store');
		}else{
			$store_id = $this->store_id ;
		}
            $data = array( 'date' => $this->input->post('date'),
                'reference' => $this->input->post('reference'),
                'store_id' => $store_id,
                'note' => $this->input->post('note'),
                'created_by' => $this->session->userdata('user_id'),
            );

            if ($_FILES['attachment']['size'] > 0) {

                $this->load->library('upload');
                $config['upload_path'] = 'uploads/';
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = 2000;
                $config['encrypt_name'] = TRUE;
                $config['overwrite'] = FALSE;
                $config['file_ext_tolower'] = TRUE;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('attachment')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("check_out/add");
                }

                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;

            }

            // $this->tec->print_arrays($data, $items);

        }

        if ( $this->form_validation->run() == true && $this->check_out_model->addStockOut($data, $items)) {
            $this->session->set_flashdata('message', lang("check_out_added"));
            redirect('check_out');
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $this->data['page_title'] = lang('add_check_out');
            $this->data['stores'] = $this->stores_model->getAllStores();
            $this->data['reference'] = $this->check_out_model->generateReference();
            $this->page_construct('check_out/add_by_csv', $this->data);

        }
    }

    public function edit($id) {
       
      /* this is removed for normal user to edit
       if (!$this->Admin) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect('check_out');
        } 
	*/



        $this->form_validation->set_rules('reference', lang("reference"), 'trim|required');
        $this->form_validation->set_rules('date', lang("date"), 'trim|required');
        
        //line added for normal user to edit
        if($this->Admin){
		$this->form_validation->set_rules('store', lang("store"), 'trim|required');
			}
        //removed for user to edit $this->form_validation->set_rules('store', lang("store"), 'trim|required');

        
        
        $check_out = $this->check_out_model->getStockOutByID($id);
        if($check_out->reference != $this->input->post('reference')) {
            $this->form_validation->set_rules('reference', lang("reference"), 'is_unique[check_out.reference]');
        }

        if ($this->form_validation->run() == true) {

            $quantity = "quantity";
            $product_id = "product_id";
            $i = isset($_POST['product_id']) ? sizeof($_POST['product_id']) : 0;
            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['product_id'][$r];
                $item_qty = $_POST['quantity'][$r];
				$item_plate_code = $_POST['plate_code'][$r];
                $serial_number = $_POST['serial_number'][$r];
                $item_plate_number = $_POST['plate_number'][$r];
                if( $item_id && $item_qty && $item_plate_code && $item_plate_number) {

                    if(!$this->check_out_model->getItemByID($item_id)) {
                        $this->session->set_flashdata('error', $this->lang->line("product_not_found")." ( ".$item_id." ).");
                        redirect('check_out/add');
                    }

                    $items[] = array(
                        'item_id' => $item_id,
						'plate_code' => $item_plate_code,
                        'plate_number' => $item_plate_number,
                        'quantity' => $item_qty,
                        'serial_number' => $serial_number,
                        );

                }
            }

            if (!isset($items) || empty($items)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                krsort($items);
            }
            
            //added
            if($this->Admin){
				$store_id = $this->input->post('store');
			}else{
				$store_id = $this->store_id ;
			}
            
            
            //removed 'store_id' => $this->input->post('store'),

            $data = array( 'date' => $this->input->post('date'),
                'reference' => $this->input->post('reference'),
                'store_id' => $store_id ,
                
                'note' => $this->input->post('note'),
                'updated_by' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H-i:s'),
            );

            if ($_FILES['attachment']['size'] > 0) {

                $this->load->library('upload');
                $config['upload_path'] = 'uploads/';
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = 2000;
                $config['encrypt_name'] = TRUE;
                $config['overwrite'] = FALSE;
                $config['file_ext_tolower'] = TRUE;
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('attachment')) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("check_out/eidt/".$id);
                }

                $photo = $this->upload->file_name;
                $data['attachment'] = $photo;

            }

            // $this->tec->print_arrays($data, $items);

        }

        if ( $this->form_validation->run() == true && $this->check_out_model->updateStockOut($id, $data, $items)) {
            $this->session->set_flashdata('message', lang("check_out_updated"));
            redirect('check_out');
        } else {
            $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
            $this->data['check_out'] = $check_out;
            $items = array();
            if($check_out_items = $this->check_out_model->getAllOutItems($id)) {
		
                foreach ($check_out_items as $item) {
                    $row = $this->check_out_model->getItemByID($item->item_id);
                    $row->qty = $item->quantity;
					$index = $row->id.  microtime();
                    $pr[$index] = array('id' => $index, 'label' => $row->name . " (" . $row->code . ")", 'plate_code' =>$item->plate_code, 'serial_number'=>$item->serial_number, 'plate_number'=>$item->plate_number, 'row' => $row);
                }
                $items = json_encode($pr);
            }
            $this->data['items'] = $items;
            $this->data['stores'] = $this->check_out_model->getAllStores();
            $this->data['page_title'] = lang('edit_check_out');
            $this->page_construct('check_out/edit', $this->data);

        }
    }

    public function delete($id = NULL) {
        if (!$this->Admin) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect('check_out');
        }
        if ($this->check_out_model->deleteStockOut($id)) {
            $this->session->set_flashdata('message', lang("check_out_deleted"));
            redirect("check_out");
        } else {
            $this->session->set_flashdata('error', lang("delete_failed"));
            redirect("check_out");
        }
    }

    function suggestions()
    {
        $term = $this->input->get('term', TRUE);

        $rows = $this->check_out_model->getProductNames($term);
        if ($rows) {
            foreach ($rows as $row) {
				if(!$this->Admin && $this->store_id!= $row->store_id)
				continue;
	
                $row->qty = 1;
                $pr[] = array('id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row);
            }
            echo json_encode($pr);
        } else {
            echo json_encode(array(array('id' => 0, 'label' => lang('no_match_found'), 'value' => $term)));
        }
    }

    function customers(){
        $term = $this->input->get('term', TRUE);

        $rows = $this->check_out_model->getCustomers($term);
        if ($rows) {
            foreach ($rows as $row) {
                $cu[] = array('id' => $row->customer, 'label' => $row->customer, 'value' => $row->customer);
            }
            echo json_encode($cu);
        } else {
            echo NULL;
        }
    }

    public function transaction_details() {
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
        $this->data['page_title'] = lang('out_transaction');
        $store_id=null;
        if(!$this->Admin) $store_id = $this->store_id ;
        $this->data['items'] = $this->check_out_model->getAllItems($store_id);
        $this->page_construct('check_out/transaction_details', $this->data);
    }


    public function get_all_transaction() {
        if ($_POST["end_date"]) {
            $end_date = $_POST["end_date"];
            $end_date=$end_date ." 23:59:59";

        } else {
            $end_date1 = NULL;
        }
        if ($_POST["start_date"]) {
            $start_date = $_POST["start_date"];
            $start_date=$start_date ." 00:00:00";
        } else {
            $start_date = NULL;
        }

        $this->load->library('datatables');
        $this->datatables
            ->select($this->db->dbprefix('check_out').".id as id, date,". $this->db->dbprefix('check_out_items').".serial_number, ".$this->db->dbprefix('stores').".store_name,".$this->db->dbprefix('items').".name as item_name,".$this->db->dbprefix('check_out_items').".plate_number as number,  ".$this->db->dbprefix('check_out_items').".plate_code as item_code, ".$this->db->dbprefix('check_out_items').".quantity,  ".$this->db->dbprefix('items').".unit as um", FALSE)
            ->from('check_out')
            ->join('check_out_items', 'check_out_items.check_out_id=check_out.id', 'inner')
            ->join('items', 'items.id=check_out_items.item_id', 'left')
            ->join('users', 'users.id=check_out.created_by', 'left')
            ->join('stores', 'stores.id=check_out.store_id', 'left')
            ->group_by('check_out_items.item_id,check_out.id,stores.id,check_out_items.plate_number');
        //$this->datatables->unset_column("id");
        if($start_date) { $this->datatables->where('date >=', $start_date); }
        if($end_date) { $this->datatables->where('date <=', $end_date); }
        if($_POST["qty"]) { $this->datatables->where('check_out_items.quantity', $_POST["qty"]); }
        if($_POST["items"]) {
            $item=$_POST["items"];
            $this->datatables->where('check_out_items.item_id', $item);
        }

        if(!$this->Admin){
            $this->datatables->where('check_out.store_id ', $this->store_id);
        }

        echo $this->datatables->generate();
    }
}
