<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            redirect('login');
        }

        $this->load->model('welcome_model');
        $this->load->model('stores_model');
    }

    public function index() {
        if ($this->Settings->version < '2.0.2') {
            $this->db->update('settings', array('version' => '2.0.2'), array('setting_id' => 1));
        }
        $this->data['error'] = validation_errors() ? validation_errors() : $this->session->flashdata('error');
		
		$this->data['store'] = '';
		if($this->Admin && $this->input->get('store')){
			$this->store_id = $this->input->get('store');
			$this->data['store_id'] = $this->input->get('store');	
		}
		
        $check_ins = $this->welcome_model->getCheckinQuantity();
        $check_outs = $this->welcome_model->getCheckoutQuantity();
		
        $data = $this->tec_array_merge($check_ins, $check_outs);
        if($data) { ksort($data); }
        $this->data['data'] = $data;
        $this->data['stores'] = $this->stores_model->getAllStores();
        $this->data['page_title'] = lang('dashboard');
		$this->page_construct('index', $this->data);

    }

    private function tec_array_merge($a, $b) {
        if(empty($a) && empty($b)) {
            return FALSE;
        }
        $data = array();
        $AB = array_merge($a, $b);
        foreach ( $AB as $value ) {
            $id = $value['month'];
            if ( !isset($data[$id]) ) {
                $data[$id] = array();
            }
            $data[$id] = array_merge($data[$id], $value);
        }
        return $data;
    }

    public function download($file) {
        if ( ! $file || ! file_exists('uploads/'.$file)) {
            redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
        }
        $this->load->helper('download');
        force_download('uploads/'.$file, NULL);
    }

    function language($lang = false) {
        if($this->input->get('lang')){ $lang = $this->input->get('lang'); }
        $folder = 'app/language/';
        $languagefiles = scandir($folder);
        if(in_array($lang, $languagefiles)){
            $cookie = array(
             'name'   => 'language',
             'value'  => $lang,
             'expire' => '31536000',
             'prefix' => 'ssm_',
             'secure' => false
             );
            $this->input->set_cookie($cookie);
        }
        redirect($_SERVER["HTTP_REFERER"]); 
    }

}
