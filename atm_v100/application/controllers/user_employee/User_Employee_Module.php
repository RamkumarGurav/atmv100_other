<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once (APPPATH . "controllers/secureRegions/Main.php");
class User_Employee_Module extends Main
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		$this->load->model('Common_Model');
		$this->load->model('administrator/Admin_Common_Model');
		$this->load->model('administrator/Admin_model');
		$this->load->model('administrator/user_employee/User_Employee_Model');
		$this->load->library('pagination');

		$this->load->library('User_auth');

		$session_uid = $this->data['session_uid'] = $this->session->userdata('sess_psts_uid');
		$this->data['session_name'] = $this->session->userdata('sess_psts_name');
		$this->data['session_email'] = $this->session->userdata('sess_psts_email');

		$this->load->helper('url');

		$this->data['User_auth_obj'] = new User_auth();
		$this->data['user_data'] = $this->data['User_auth_obj']->check_user_status();

		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");

		$this->data['page_module_id'] = 202;
	}

	function unset_only()
	{
		$user_data = $this->session->all_userdata();
		foreach ($user_data as $key => $value) {
			if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
				$this->session->unset_userdata($key);
			}
		}
	}

	function index()
	{
		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/user_employee/User_Employee_Module/listings', $this->data);
		parent::get_footer();
	}

	function listings()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 202;

		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));

		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}

		// Initializing variables for search and filtering
		$search = array();
		$field_name = '';
		$field_value = '';
		$branch_id = 0;
		$department_id = 0;
		$designation_id = 0;
		$end_date = '';
		$start_date = '';
		$record_status = "";

		// Fetching data from request or using default values
		if (!empty($_REQUEST['field_name']))
			$field_name = $_POST['field_name'];
		else if (!empty($field_name))
			$field_name = $field_name;

		if (!empty($_REQUEST['field_value']))
			$field_value = $_POST['field_value'];
		else if (!empty($field_value))
			$field_value = $field_value;

		if (!empty($_POST['branch_id']))
			$branch_id = $_POST['branch_id'];

		if (!empty($_POST['designation_id']))
			$designation_id = $_POST['designation_id'];

		if (!empty($_POST['department_id']))
			$department_id = $_POST['department_id'];

		if (!empty($_POST['end_date']))
			$end_date = $_POST['end_date'];

		if (!empty($_POST['start_date']))
			$start_date = $_POST['start_date'];

		if (!empty($_POST['record_status']))
			$record_status = $_POST['record_status'];

		// Assigning fetched values to data variables
		$this->data['field_name'] = $field_name;
		$this->data['field_value'] = $field_value;
		$this->data['branch_id'] = $branch_id;
		$this->data['department_id'] = $department_id;
		$this->data['designation_id'] = $designation_id;
		$this->data['end_date'] = $end_date;
		$this->data['start_date'] = $start_date;
		$this->data['record_status'] = $record_status;

		// Setting search parameters
		$search['end_date'] = $end_date;
		$search['start_date'] = $start_date;
		$search['field_value'] = $field_value;
		$search['field_name'] = $field_name;
		$search['branch_id'] = $branch_id;
		$search['department_id'] = $department_id;
		$search['designation_id'] = $designation_id;
		$search['record_status'] = $record_status;
		$search['search_for'] = "count";

		// Getting total count of countries based on search parameters
		$data_count = $this->User_Employee_Model->get_user_employee($search);
		$r_count = $this->data['row_count'] = $data_count[0]->counts;

		// Removing 'search_for' parameter for further processing
		unset($search['search_for']);

		// Pagination setup
		$offset = (int) $this->uri->segment(5); // Get page offset

		if ($offset == "") {
			$offset = '0';
		}
		$per_page = _all_pagination_; // Number of records per page

		$this->load->library('pagination');
		$this->load->library('pagination');
		$config['base_url'] = MAINSITE_Admin . $this->data['user_access']->class_name . '/' . $this->data['user_access']->function_name . '/';
		$config['total_rows'] = $r_count; // Total number of records
		$config['uri_segment'] = '5'; // URI segment for pagination
		$config['per_page'] = $per_page; // Number of records per page
		$config['num_links'] = 4; // Number of links to show
		$config['first_link'] = '&lsaquo; First'; // Text for first link
		$config['last_link'] = 'Last &rsaquo;'; // Text for last link
		$config['prev_link'] = 'Prev'; // Text for previous link
		$config['full_tag_open'] = '<p>'; // Opening tag for pagination
		$config['full_tag_close'] = '</p>'; // Closing tag for pagination
		$config['attributes'] = array('class' => 'paginationClass'); // CSS class for pagination links

		// Initializing pagination with config
		$this->pagination->initialize($config);

		// Assigning additional data for the view
		$this->data['page_is_master'] = $this->data['user_access']->is_master;//this is for making left menu active
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;


		$search['details'] = 1;

		// Setting limit and offset for data retrieval
		$search['limit'] = $per_page;
		$search['offset'] = $offset;

		// Getting user_employee data based on search parameters
		$this->data['user_employee_data'] = $this->User_Employee_Model->get_user_employee($search);


		$this->data['country_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'country', 'where' => "country_id > 0", "order_by" => "country_name ASC"));
		$this->data['branch_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'branch', 'where' => "branch_id > 0", "order_by" => "branch_name ASC"));
		$this->data['department_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'department_master', 'where' => "department_id > 0", "order_by" => "department_name ASC"));
		$this->data['designation_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'designation_master', 'where' => "designation_id > 0", "order_by" => "designation_name ASC"));





		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/user_employee/User_Employee_Module/listings', $this->data);
		parent::get_footer();
	}

	function view($user_employee_id = "")
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 202;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if (empty($user_employee_id)) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. </div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
			exit;
		}
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}


		// Assigning additional data for the view
		$this->data['page_is_master'] = $this->data['user_access']->is_master;//this is for making left menu active
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;

		$this->data['user_employee_data'] = $this->User_Employee_Model->get_user_employee(array("user_employee_id" => $user_employee_id, "details" => 1));
		if (empty($user_employee_id)) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong. Please Try Again. </div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
			exit;
		}

		$this->data['user_employee_data'] = $this->data['user_employee_data'][0];



		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/user_employee/User_Employee_Module/view', $this->data);
		parent::get_footer();
	}


	function export()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 202;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}

		if ($this->data['user_access']->export_data != 1) {
			$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Export " . $user_access->module_name);
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		$search = array();
		$end_date = '';
		$start_date = '';
		$record_status = "";
		$customer_profile_id = "";
		$user_employee_mode = "";
		$admin_user_id = "";

		if (!empty($_POST['end_date']))
			$end_date = $_POST['end_date'];

		if (!empty($_POST['start_date']))
			$start_date = $_POST['start_date'];

		if (!empty($_POST['record_status']))
			$record_status = $_POST['record_status'];

		if (!empty($_POST['customer_profile_id']))
			$customer_profile_id = $_POST['customer_profile_id'];

		if (!empty($_POST['user_employee_mode']))
			$user_employee_mode = $_POST['user_employee_mode'];

		if (!empty($_POST['admin_user_id']))
			$admin_user_id = $_POST['admin_user_id'];

		$this->data['end_date'] = $end_date;
		$this->data['start_date'] = $start_date;
		$this->data['record_status'] = $record_status;
		$this->data['customer_profile_id'] = $customer_profile_id;
		$this->data['user_employee_mode'] = $user_employee_mode;
		$this->data['admin_user_id'] = $admin_user_id;

		$search['end_date'] = $end_date;
		$search['start_date'] = $start_date;
		$search['record_status'] = $record_status;
		$search['customer_profile_id'] = $customer_profile_id;
		$search['user_employee_mode'] = $user_employee_mode;
		$search['admin_user_id'] = $admin_user_id;
		$search['details'] = 1;

		$this->data['user_employee_data'] = $this->User_Employee_Model->get_user_employee($search);



		$this->load->view('admin/user_employee/User_Employee_Module/export', $this->data);
	}

	function pdf()
	{
		$this->load->library('pdf');

		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 202;
		$this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}

		if ($this->data['user_access']->export_data != 1) {
			$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Export " . $user_access->module_name);
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		$search = array();
		$end_date = '';
		$start_date = '';
		$record_status = "";
		$customer_profile_id = "";
		$user_employee_mode = "";
		$admin_user_id = "";

		if (!empty($_POST['end_date']))
			$end_date = $_POST['end_date'];

		if (!empty($_POST['start_date']))
			$start_date = $_POST['start_date'];

		if (!empty($_POST['record_status']))
			$record_status = $_POST['record_status'];

		if (!empty($_POST['customer_profile_id']))
			$customer_profile_id = $_POST['customer_profile_id'];

		if (!empty($_POST['user_employee_mode']))
			$user_employee_mode = $_POST['user_employee_mode'];

		if (!empty($_POST['admin_user_id']))
			$admin_user_id = $_POST['admin_user_id'];

		$this->data['end_date'] = $end_date;
		$this->data['start_date'] = $start_date;
		$this->data['record_status'] = $record_status;
		$this->data['customer_profile_id'] = $customer_profile_id;
		$this->data['user_employee_mode'] = $user_employee_mode;
		$this->data['admin_user_id'] = $admin_user_id;

		$search['end_date'] = $end_date;
		$search['start_date'] = $start_date;
		$search['record_status'] = $record_status;
		$search['customer_profile_id'] = $customer_profile_id;
		$search['user_employee_mode'] = $user_employee_mode;
		$search['admin_user_id'] = $admin_user_id;
		$search['details'] = 1;

		$this->data['user_employee_data'] = $this->User_Employee_Model->get_user_employee($search);


		$date = date('Y-m-d H:i:s');
		//echo "$customer_name : $customer_name <br>";
		$html = $this->load->view('admin/user_employee/pdf', $this->data, true);
		//echo $html;
		//$html = $this->load->view('admin/reports/Project_Reports_Module/project_reports_list_pdf' , $this->data, true);
		$this->pdf->createPDF($html, $date, false);

	}

	function edit($user_employee_id = "")
	{
		$this->data['page_type'] = "list";
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		if (empty($user_employee_id)) {
			if ($user_access->add_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Add " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}
		if (!empty($user_employee_id)) {
			if ($user_access->update_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Update " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}

		// Assigning additional data for the view
		$this->data['page_is_master'] = $this->data['user_access']->is_master;//this is for making left menu active
		$this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;

		$this->data['country_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'country', 'where' => "country_id > 0", "order_by" => "country_name ASC"));
		$this->data['branch_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'branch', 'where' => "branch_id > 0", "order_by" => "branch_name ASC"));
		$this->data['department_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'department_master', 'where' => "department_id > 0", "order_by" => "department_name ASC"));
		$this->data['designation_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'designation_master', 'where' => "designation_id > 0", "order_by" => "designation_name ASC"));
		// $this->data['shift_timing_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'shift_timing', 'where' => "shift_timing_id > 0", "order_by" => "login_time ASC"));
		// $this->data['user_employee_data'] = $this->Common_Model->getData(array('select' => '*', 'from' => 'admin_user', 'where' => "admin_user_id > 0", "order_by" => "name ASC"));

		// $this->data['page_is_master'] = $this->data['user_access']->is_master;
		// $this->data['page_parent_module_id'] = $this->data['user_access']->parent_module_id;

		if (!empty($user_employee_id)) {

			$this->data['user_employee_data'] = $this->User_Employee_Model->get_user_employee(array("user_employee_id" => $user_employee_id, "details" => 1));
			if (empty($this->data['user_employee_data'])) {
				$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> Record Not Found. 
				  </div>');
				REDIRECT(MAINSITE_Admin . $user_access->class_name . '/' . $user_access->function_name);
			}
			$this->data['user_employee_data'] = $this->data['user_employee_data'][0];
		}



		parent::get_header();
		parent::get_left_nav();
		$this->load->view('admin/user_employee/User_Employee_Module/edit', $this->data);
		parent::get_footer();
	}

	function doEdit()
	{




		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 202;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));




		if (
			empty($_POST['name']) && empty($_POST['contactno']) && empty($_POST['company_email']) && empty($_POST['address'])
			&& empty($_POST['aadhar_number']) && empty($_POST['pan_number']) && empty($_POST['birthday']) && empty($_POST['joining_date'])
			&& empty($_POST['branch_id']) && empty($_POST['department_id']) && empty($_POST['designation_id']) && empty($_POST['user_employee_custom_id'])
		) {
			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
			class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
			Something Went Wrong. Please Try Again.</div>';
			$this->session->set_flashdata('alert_message', $alert_message);
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
			exit;
		}

		$user_employee_id = $_POST['user_employee_id'];

		if (empty($this->data['user_access'])) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}

		if (empty($user_employee_id)) {
			if ($user_access->add_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Add " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}


		if (!empty($user_employee_id)) {
			if ($user_access->update_module != 1) {
				$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Update " . $user_access->module_name);
				REDIRECT(MAINSITE_Admin . "wam/access-denied");
			}
		}



		$branch_id = trim($_POST['branch_id']);
		$department_id = trim($_POST['department_id']);
		$designation_id = trim($_POST['designation_id']);
		$name = trim($_POST['name']);
		$contactno = trim($_POST['contactno']);
		$alt_contactno = trim($_POST['alt_contactno']);
		$marital_status = trim($_POST['marital_status']);

		if (!empty($_POST['marriage_anniversary'])) {
			$marriage_anniversary = date("Y-m-d", strtotime($_POST['marriage_anniversary']));
		} else {
			$marriage_anniversary = null;
		}

		$personal_email = trim($_POST['personal_email']);
		$company_email = trim($_POST['company_email']);
		$birthday = date("Y-m-d", strtotime($_POST['birthday']));
		$joining_date = date("Y-m-d", strtotime($_POST['joining_date']));
		$user_employee_custom_id = trim($_POST['user_employee_custom_id']);
		$address = trim($_POST['address']);
		$pan_number = trim($_POST['pan_number']);
		$aadhar_number = trim($_POST['aadhar_number']);
		$pincode = trim($_POST['pincode']);
		$country_id = trim($_POST['country_id']);
		$state_id = trim($_POST['state_id']);
		$city_id = $_POST['city_id'];
		$status = trim($_POST['status']);







		$is_exist = $this->Common_Model->getData(
			array(
				'select' => '*',
				'from' => 'user_employee',
				'where' => "user_employee_custom_id = '$user_employee_custom_id' and user_employee_id != $user_employee_id"
			)
		);




		if (!empty($is_exist)) {

			$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" 
			aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Employee with this Data already exist in database.</div>';

			$this->session->set_flashdata('alert_message', $alert_message);

			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/edit/" . $user_employee_id);
			exit;
		}

		$enter_data['branch_id'] = $branch_id;
		$enter_data['department_id'] = $department_id;
		$enter_data['designation_id'] = $designation_id;
		$enter_data['name'] = $name;
		$enter_data['contactno'] = $contactno;
		$enter_data['alt_contactno'] = $alt_contactno;
		$enter_data['marital_status'] = $marital_status;
		$enter_data['marriage_anniversary'] = $marriage_anniversary;
		$enter_data['personal_email'] = $personal_email;
		$enter_data['company_email'] = $company_email;
		$enter_data['birthday'] = $birthday;
		$enter_data['joining_date'] = $joining_date;
		// $enter_data['password'] = $password;
		$enter_data['user_employee_custom_id'] = $user_employee_custom_id;
		$enter_data['address'] = $address;
		$enter_data['pan_number'] = $pan_number;
		$enter_data['aadhar_number'] = $aadhar_number;
		$enter_data['pincode'] = $pincode;
		$enter_data['country_id'] = $country_id;
		$enter_data['state_id'] = $state_id;
		$enter_data['city_id'] = $city_id;
		$enter_data['status'] = $status;



		$alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert"
     aria-hidden="true">×</button><i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. </div>';
		if (!empty($user_employee_id)) {
			$enter_data['updated_on'] = date("Y-m-d H:i:s");
			$enter_data['updated_by'] = $this->data['session_uid'];

			$insertStatus = $this->Common_Model->update_operation(array('table' => 'user_employee', 'data' => $enter_data, 'condition' => "user_employee_id = $user_employee_id"));
			if (!empty($insertStatus)) {
				$this->upload_any_image("user_employee", "user_employee_id", $user_employee_id, "profile_image", "profile_image", "profile_image_", "user_employee/profile_image");
				$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" 
				aria-hidden="true">×</button><i class="icon fas fa-check"></i> Record Updated Successfully </div>';
			}

		} else {
			$enter_data['added_on'] = date("Y-m-d H:i:s");
			$enter_data['added_by'] = $this->data['session_uid'];

			$user_employee_id = $insertStatus = $this->Common_Model->add_operation(array('table' => 'user_employee', 'data' => $enter_data));
			if (!empty($insertStatus)) {
				$this->upload_any_image("user_employee", "user_employee_id", $user_employee_id, "profile_image", "profile_image", "profile_image_", "user_employee/profile_image");
				$alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> New Record Added Successfully </div>';
			}
		}





		if ($insertStatus > 0) { // Checking if $insertStatus is greater than 0 (indicating successful insertion)
			$this->upload_multi_texts_st($user_employee_id);
			$this->upload_multi_files_uekf($user_employee_id);

		}



		$this->session->set_flashdata('alert_message', $alert_message);

		if (!empty($_POST['redirect_type'])) {
			REDIRECT(MAINSITE_Admin . $user_access->class_name . "/edit");
		}

		REDIRECT(MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name);
	}





	function upload_any_image($table_name, $id_column, $id, $input_name, $target_column, $prefix, $target_folder_name)
	{
		$file_name = "";
		if (isset($_FILES[$input_name]['name'])) {
			$timg_name = $_FILES[$input_name]['name'];
			if (!empty($timg_name)) {
				$temp_var = explode(".", strtolower($timg_name));
				$timage_ext = end($temp_var);
				$timage_name_new = $prefix . $id . "." . $timage_ext;
				$image_enter_data[$target_column] = $timage_name_new;
				$imginsertStatus = $this->Common_Model->update_operation(array('table' => $table_name, 'data' => $image_enter_data, 'condition' => "$id_column = $id"));
				if ($imginsertStatus == 1) {
					if (!is_dir(_uploaded_temp_files_ . $target_folder_name)) {
						mkdir(_uploaded_temp_files_ . './' . $target_folder_name, 0777, TRUE);

					}
					move_uploaded_file($_FILES["$input_name"]['tmp_name'], _uploaded_temp_files_ . $target_folder_name . "/" . $timage_name_new);
					$file_name = $timage_name_new;
				}

			}
		}
	}

	public function addNewLine_uekf()
	{
		if (!empty($_POST['append_id_uekf'])) {
			$this->data['append_id_uekf'] = $_POST['append_id_uekf'];
		}
		$template = $this->load->view('admin/user_employee/User_Employee_Module/template/file_line_add_more_uekf', $this->data, true);
		echo json_encode(array("template" => $template));
	}

	function upload_multi_files_uekf($idf)
	{

		$table_name = "user_employee_kyc_file";
		$idp_column = "user_employee_kyc_file_id";
		$idf_column = "user_employee_id";
		$input_file_name = "file_uekf";
		$input_text_name = "file_title_uekf";
		$target_file_column = "file";
		$target_text_column = "file_title";
		$prefix = "user_employee_kyc_file_";
		$target_folder_name = "user_employee_kyc_file";
		$logo_file_name = "";
		$count = 0;



		if (!empty($_FILES[$input_file_name]['name'])) {
			if (!is_dir(_uploaded_temp_files_ . $target_folder_name)) {
				mkdir('./' . _uploaded_temp_files_ . $target_folder_name, 0777, TRUE);
			}

			$file_title2 = $_POST[$input_text_name];



			for ($i = 0; $i < count($_FILES[$input_file_name]['name']); $i++) {
				if (isset($_FILES[$input_file_name]['name'][$i]) && !empty($_FILES[$input_file_name]['name'][$i])) {

					$img_data[$target_text_column] = $file_title2[$i];
					$img_data[$idf_column] = $idf;
					$img_data['added_on'] = date("Y-m-d H:i:s");
					$img_data['added_by'] = $this->data['session_uid'];
					$idp = $this->Common_Model->add_operation(array('table' => $table_name, 'data' => $img_data));

					$count++;

					$timg_name = $_FILES[$input_file_name]['name'][$i];
					$temp_var = explode(".", strtolower($timg_name));
					$timage_ext = end($temp_var);
					$timage_name_new = $prefix . $idp . "." . $timage_ext;
					$update_img_data[$target_file_column] = $timage_name_new;

					$idp = $this->Common_Model->update_operation(array('table' => $table_name, 'data' => $update_img_data, 'condition' => "$idp_column = $idp"));
					if ($idp > 0) {
						move_uploaded_file($_FILES[$input_file_name]['tmp_name'][$i], _uploaded_temp_files_ . $target_folder_name . "/" . $timage_name_new);
						$logo_file_name = $timage_name_new;
					}
				}
			}
		}
	}

	function doUpdateStatus()
	{
		$this->data['page_type'] = "list";
		$this->data['page_module_id'] = 202;
		$user_access = $this->data['user_access'] = $this->data['User_auth_obj']->check_user_access(array("module_id" => $this->data['page_module_id']));
		//print_r($this->data['user_access']);
		$task = $_POST['task'];
		$id_arr = $_POST['sel_recds'];
		if (empty($user_access)) {
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
		if ($user_access->update_module == 1) {
			$this->session->set_flashdata('alert_message', '<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<i class="icon fas fa-ban"></i> Something Went Wrong Please Try Again. 
				  </div>');
			$update_data = array();
			if (!empty($id_arr)) {
				$action_taken = "";
				$ids = implode(',', $id_arr);
				if ($task == "active") {
					$update_data['status'] = 1;
					$action_taken = "Activate";
				}
				if ($task == "block") {
					$update_data['status'] = 0;
					$action_taken = "Blocked";
				}
				$update_data['updated_on'] = date("Y-m-d H:i:s");
				$update_data['updated_by'] = $this->data['session_uid'];
				$response = $this->Common_Model->update_operation(array('table' => "user_employee", 'data' => $update_data, 'condition' => "user_employee_id in ($ids)"));
				if ($response) {
					$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<i class="icon fas fa-check"></i> Records Successfully ' . $action_taken . ' 
						</div>');
				}
			}
			REDIRECT(MAINSITE_Admin . $user_access->class_name . '/' . $user_access->function_name);
		} else {
			$this->session->set_flashdata('no_access_flash_message', "You Are Not Allowed To Update " . $user_access->module_name);
			REDIRECT(MAINSITE_Admin . "wam/access-denied");
		}
	}

	function upload_multi_texts_st($idf)
	{
		$table_name = "shift_timing";
		$idf_column = "user_employee_id";
		$input_text_name1 = "day";
		$target_text_column1 = "day";
		$input_text_name2 = "is_working_day";
		$target_text_column2 = "is_working_day";
		$input_text_name3 = "login_time";
		$target_text_column3 = "login_time";
		$input_text_name4 = "logout_time";
		$target_text_column4 = "logout_time";
		$count = 0;
		if (!empty($_POST[$input_text_name1])) {


			$input_data1 = $_POST[$input_text_name1];
			$input_data2 = $_POST[$input_text_name2];
			$input_data3 = $_POST[$input_text_name3];
			$input_data4 = $_POST[$input_text_name4];

			$idp = $this->Common_Model->delete_operation(array('table' => $table_name, "where" => "user_employee_id = $idf"));

			for ($i = 0; $i < count($_POST[$input_text_name1]); $i++) {
				if (isset($_POST[$input_text_name1][$i])) {

					$enter_data[$target_text_column1] = $input_data1[$i];

					if (!isset($input_data2[$i]) or empty($input_data2[$i])) {
						$enter_data[$target_text_column2] = 0;
					} else {
						$enter_data[$target_text_column2] = $input_data2[$i];
					}
					$enter_data[$target_text_column3] = $input_data3[$i];
					$enter_data[$target_text_column4] = $input_data4[$i];

					$enter_data[$idf_column] = $idf;
					$enter_data['status'] = 1;
					$enter_data['added_on'] = date("Y-m-d H:i:s");
					$enter_data['added_by'] = $this->data['session_uid'];
					$idp = $this->Common_Model->add_operation(array('table' => $table_name, 'data' => $enter_data));
					$count++;
				}
			}
		}
	}


	function logout()
	{
		$this->unset_only();
		$this->session->set_flashdata('alert_message', '<div class="alert alert-success alert-dismissible">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
		<i class="icon fas fa-check"></i> You Are Successfully Logout.
		</div>');
		$this->session->unset_userdata('sess_psts_uid');
		REDIRECT(MAINSITE_Admin . 'login');
	}

	public function index1()
	{
		$this->load->view('welcome_message');
	}

	function mypdf()
	{
		$this->load->library('pdf');
		$this->pdf->load_view('mypdf');
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
	}

	//END


}
