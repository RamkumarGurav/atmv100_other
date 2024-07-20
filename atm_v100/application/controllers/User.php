<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');


include_once ('Main.php');
class User extends Main
{

  public function __construct()
  {
    parent::__construct();
    date_default_timezone_set("Asia/Kolkata");
    //models
    $this->load->library('session');
    $this->load->model('Common_Model');
    $this->load->model('User_Model');


    //headers
    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    $this->output->set_header("Pragma: no-cache");

  }

  public function index()
  {

    $this->data['meta_title'] = _project_name_;
    $this->data['meta_description'] = _project_name_;
    $this->data['meta_keywords'] = _project_name_;
    $this->data['meta_others'] = "";



    /*** checking ip address {*/
    $ip_address = $this->Common_Model->get_client_ip();
    $ip_address_exist = $this->User_Model->get_ip_address_data([
      "ip_address" => $ip_address,
      "details" => 1
    ]);



    // if (empty($ip_address_exist)) {
    if (empty(true)) {
      $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
          class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
          Sorry this service is unavailable in your computer.' . $ip_address . '</div>';
      $this->session->set_flashdata('login_alert_message', $alert_message);
      REDIRECT(MAINSITE . "access-denied");
      exit;
    } else {

      if (!empty($_POST["user_employee_custom_id"])) {
        $user_employee_custom_id = trim($_POST["user_employee_custom_id"]);


        /*** checking valid user_employee {*/
        $this->data['user_employee_data'] = $this->User_Model->get_user_employee_data_any([
          "user_employee_custom_id" => $user_employee_custom_id,
          "details" => 1
        ]);



        if (empty($this->data['user_employee_data'])) {

          $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
			class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
			Invalid Employee ID.</div>';
          $this->session->set_flashdata('alert_message', $alert_message);
          REDIRECT(MAINSITE);
          exit;
        } else {

          $this->data['user_employee_data'] = $this->data['user_employee_data'][0];
          $user_employee_id = $this->data['user_employee_data']->user_employee_id;
          $this->session->set_userdata('user_employee_id', $user_employee_id);
          REDIRECT(MAINSITE . "employee-attendance");
          exit;
          // REDIRECT(MAINSITE . "employee-login-success");
        }


        /*** checking valid user_employee } */

      } else {

        $today = date('m-d'); // Assuming birth_date is stored as MM-DD format

        $this->data['user_employee_with_birthday'] = $this->User_Model->get_user_employee_data([
          "find_birthday_by_today" => $today,
          "details" => 1
        ]);

        parent::getHeader('header', $this->data);
        $this->load->view('home', $this->data);
        parent::getFooter('footer', $this->data);

      }


    }



  }


  public function employee_attendance()
  {

    $this->data['meta_title'] = "Employee Attendance";
    $this->data['meta_description'] = _project_name_;
    $this->data['meta_keywords'] = _project_name_;
    $this->data['meta_others'] = "";

    $employee_status = "blocked";
    $employee_login_status = "blocked";

    $last_screen = $this->Common_Model->checkScreen();



    /*** checking ip address {*/
    $ip_address = $this->Common_Model->get_client_ip();
    $ip_address_exist = $this->User_Model->get_ip_address_data([
      "ip_address" => $ip_address,
      "details" => 1
    ]);



    //IF THERE IS VALID IP ADDRESS
    // if (empty($ip_address_exist)) {
    if (empty(true)) {

      $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
			class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
			Sorry this service is unavailable in your computer.' . $ip_address . '</div>';
      $this->session->set_flashdata('login_alert_message', $alert_message);
      REDIRECT(MAINSITE . "access-denied");
      exit;
    } else {
      $user_employee_id = $this->session->userdata('user_employee_id');



      //IF THERE IS VALID EMPLOYEE
      if (!empty($user_employee_id)) {



        /*** checking valid user_employee {*/
        $this->data['user_employee_data'] = $this->User_Model->get_user_employee_data_any([
          "user_employee_id" => $user_employee_id,
          "details" => 1
        ]);




        //IF THERE IS EMPLOYEE IN DB
        if (empty($this->data['user_employee_data'])) {
          $employee_status = "not_found";

          $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
			class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
		Employee with this ID Not Found.Please contact the office </div>';
          $this->session->set_flashdata('alert_message', $alert_message);
          REDIRECT(MAINSITE);
          exit;
        } else {

          $this->data['user_employee_data'] = $this->data['user_employee_data'][0];
          $status = $this->data['user_employee_data']->status;





          //IF THERE IS ACTIVE EMPLOYEE IN DB
          if ($status == 1) {
            $employee_status = "active";

            $this->data['attendance_data'] = $this->User_Model->get_attendance_data_any([
              "user_employee_id" => $user_employee_id,
              "check_attendance_status" => 1,
              "details" => 1
            ]);

            if (!empty($this->data['user_employee_data'])) {
              $attendance_data = $this->data['attendance_data'][0];
              if (!empty($attendance_data->login_time) && empty(($attendance_data->logout_time))){
                $employee_login_status = "allowed_for_logout";
            } elseif(!empty($attendance_data->login_time) && !empty(($attendance_data->logout_time))) {
              $employee_login_status = "allowed_for_login";

            }



            parent::getHeader('header', $this->data);
            $this->load->view('employee_attendance', $this->data);
            parent::getFooter('footer', $this->data);



          } else {
            $employee_status = "blocked";
            $employee_login_status = "not_allowed_for_login";


            $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
            class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
          Employee with this ID is Blocked.Please contact the office </div>';
            $this->session->set_flashdata('alert_message', $alert_message);
            parent::getHeader('header', $this->data);
            $this->load->view('employee_attendance', $this->data);
            parent::getFooter('footer', $this->data);
          }

          // REDIRECT(MAINSITE . "employee-login-success");
        }


        /*** checking valid user_employee } */

      } else {

        REDIRECT(MAINSITE);
        exit;

      }

    }


  }

  public function user_employee_login()
  {

    $this->data['meta_title'] = "Employee Login";
    $this->data['meta_description'] = _project_name_;
    $this->data['meta_keywords'] = _project_name_;
    $this->data['meta_others'] = "";

    $last_screen = $this->Common_Model->checkScreen();



    /*** checking ip address {*/
    $ip_address = $this->Common_Model->get_client_ip();
    $ip_address_exist = $this->User_Model->get_ip_address_data([
      "ip_address" => $ip_address,
      "details" => 1
    ]);



    if (empty($ip_address_exist)) {
      $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
			class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
			Sorry this service is unavailable in your computer.' . $ip_address . '</div>';
      $this->session->set_flashdata('login_alert_message', $alert_message);
      REDIRECT(MAINSITE . "access-denied");
      exit;
    } else {
      $today = date('m-d'); // Assuming birth_date is stored as MM-DD format

      $this->data['user_employee_with_birthday'] = $this->User_Model->get_user_employee_data([
        "find_birthday_by_today" => $today,
        "details" => 1
      ]);

      parent::getHeader('header', $this->data);
      $this->load->view('user_employee_login', $this->data);
      parent::getFooter('footer', $this->data);

    }


  }


  public function access_denied()
  {

    $this->data['meta_title'] = "Access Denied";
    $this->data['meta_description'] = _project_name_;
    $this->data['meta_keywords'] = _project_name_;
    $this->data['meta_others'] = "";



    parent::getHeader('header', $this->data);
    $this->load->view('access_denied', $this->data);
    parent::getFooter('footer', $this->data);


  }

  public function ajax_user_employee_do_login()
  {


    $user_employee_custom_id = $this->input->post('user_employee_custom_id');

    $ip_address = $this->Common_Model->get_client_ip();

    /*** checking ip address {*/

    $ip_address_exist = $this->User_Model->get_ip_address_data([
      "ip_address" => $ip_address,
      "details" => 1
    ]);



    if (empty($ip_address_exist)) {
      $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
			class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
			Sorry this service is unavailable in your computer.' . $ip_address . '</div>';
      $this->session->set_flashdata('login_alert_message', $alert_message);
      REDIRECT(MAINSITE . "employee-login");
      exit;
    }

    /*** checking ip address } */


    /*** checking valid user_employee {*/
    $this->data['logged_user_employee_data'] = $this->User_Model->get_user_employee_data([
      "user_employee_custom_id" => $user_employee_custom_id,
      "details" => 1
    ]);



    if (empty($this->data['logged_user_employee_data'])) {

      $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
			class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
			Invalid Employee ID.</div>';
      $this->session->set_flashdata('login_alert_message', $alert_message);
      REDIRECT(MAINSITE . "employee-login");
      exit;
    } else {

      $this->data['logged_user_employee_data'] = $this->data['logged_user_employee_data'][0];

      $enter_data["user_employee_id"] = $this->data['logged_user_employee_data']->user_employee_id;
      $enter_data["login_time"] = date("Y-m-d H:i:s");
      $enter_data["status"] = 1;

      $attendance_id = $insertStatus = $this->Common_Model->add_operation(array('table' => 'attendance', 'data' => $enter_data));

      // if (!empty($insertStatus)) {
      //   $this->upload_any_image("attendance", "attendance_id", $attendance_id, "attendance_login_image", "attendance_login_image", "attendance_login_image_", "user_employee/profile_image");
      //   $alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> New Record Added Successfully </div>';
      // }
      // $alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" 
      // class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
      // Invalid Employee ID.</div>';
      // $this->session->set_flashdata('alert_message', $alert_message);

      $this->data['logged_attendance_data'] = $this->User_Model->get_attendance_data([
        "attendance_id" => $attendance_id,
        "user_employee_id" => $enter_data["user_employee_id"],
        "details" => 1
      ]);

      $this->session->set_userdata('logged_attendance_data', $this->data['logged_attendance_data'][0]);
      REDIRECT(MAINSITE . "employee-login-success");
      exit;
      // REDIRECT(MAINSITE . "employee-login-success");
    }


    /*** checking valid user_employee } */



  }

  public function user_employee_login_success()
  {

    $this->data['meta_title'] = "Employee Login Success";
    $this->data['meta_description'] = _project_name_;
    $this->data['meta_keywords'] = _project_name_;
    $this->data['meta_others'] = "";

    $logged_attendance_data = $this->session->userdata('logged_attendance_data');


    if (!empty($logged_attendance_data)) {

      $this->data["attendance_data"] = $logged_attendance_data;
      $this->session->sess_destroy();

      parent::getHeader('header', $this->data);
      $this->load->view('user_employee_login_success', $this->data);
      parent::getFooter('footer', $this->data);
    } else {
      REDIRECT(MAINSITE);
      exit;
    }


  }


  public function user_employee_logout()
  {

    $this->data['meta_title'] = "Employee Logout";
    $this->data['meta_description'] = _project_name_;
    $this->data['meta_keywords'] = _project_name_;
    $this->data['meta_others'] = "";



    $last_screen = $this->Common_Model->checkScreen();

    /*** checking ip address {*/
    $ip_address = $this->Common_Model->get_client_ip();

    $ip_address_exist = $this->User_Model->get_ip_address_data([
      "ip_address" => $ip_address,
      "details" => 1
    ]);




    if (empty($ip_address_exist)) {

      $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
          class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
          Sorry this service is unavailable in your computer.' . $ip_address . '</div>';
      $this->session->set_flashdata('login_alert_message', $alert_message);
      REDIRECT(MAINSITE . "access-denied");
      exit;
    } else {
      $today = date('m-d'); // Assuming birth_date is stored as MM-DD format

      $this->data['user_employee_with_birthday'] = $this->User_Model->get_user_employee_data([
        "find_birthday_by_today" => $today,
        "details" => 1
      ]);

      parent::getHeader('header', $this->data);
      $this->load->view('user_employee_logout', $this->data);
      parent::getFooter('footer', $this->data);


    }


  }


  public function ajax_user_employee_do_logout()
  {


    $user_employee_custom_id = $this->input->post('user_employee_custom_id');

    $ip_address = $this->Common_Model->get_client_ip();

    /*** checking ip address {*/

    $ip_address_exist = $this->User_Model->get_ip_address_data([
      "ip_address" => $ip_address,
      "details" => 1
    ]);



    if (empty($ip_address_exist)) {
      $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
			class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
			Sorry this service is unavailable in your computer.</div>';
      $this->session->set_flashdata('logout_alert_message', $alert_message);
      REDIRECT(MAINSITE . "employee-logout");
      exit;
    }

    /*** checking ip address } */


    /*** checking valid user_employee {*/
    $this->data['logout_user_employee_data'] = $this->User_Model->get_user_employee_data([
      "user_employee_custom_id" => $user_employee_custom_id,
      "details" => 1
    ]);



    if (empty($this->data['logout_user_employee_data'])) {

      $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
			class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
			Invalid Employee ID.</div>';
      $this->session->set_flashdata('logout_alert_message', $alert_message);
      REDIRECT(MAINSITE . "employee-logout");
      exit;
    } else {

      $this->data['logout_user_employee_data'] = $this->data['logout_user_employee_data'][0];
      $user_employee_id = $this->data['logout_user_employee_data']->user_employee_id;
      $enter_data["logout_time"] = date("Y-m-d H:i:s");

      $this->data['logout_attendance_data'] = $this->User_Model->get_attendance_data([
        "user_employee_id" => $user_employee_id,
        "details" => 1
      ]);
      $this->data['logout_attendance_data'] = $this->data['logout_attendance_data'][0];
      $login_attendance_id = $this->data['logout_attendance_data']->attendance_id;


      $login_time = new DateTime($this->data['logout_attendance_data']->login_time);
      $logout_time = new DateTime($enter_data["logout_time"]);
      $interval = $login_time->diff($logout_time);
      $total_time = $interval->format('%H:%I:%S');
      $enter_data["total_time"] = $total_time;

      $update_status = $this->Common_Model->update_operation(array('table' => 'attendance', 'data' => $enter_data, 'condition' => "user_employee_id = $user_employee_id and attendance_id = $login_attendance_id"));


      // if (!empty($insertStatus)) {
      //   $this->upload_any_image("attendance", "attendance_id", $attendance_id, "attendance_login_image", "attendance_login_image", "attendance_login_image_", "user_employee/profile_image");
      //   $alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-check"></i> New Record Added Successfully </div>';
      // }
      // $alert_message = '<div class="alert alert-success alert-dismissible"><button type="button" 
      // class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
      // Invalid Employee ID.</div>';
      // $this->session->set_flashdata('alert_message', $alert_message);

      $this->data['logout_attendance_data'] = $this->User_Model->get_attendance_data([
        "attendance_id" => $login_attendance_id,
        "details" => 1
      ]);




      $this->session->set_userdata('logout_attendance_data', $this->data['logout_attendance_data'][0]);
      REDIRECT(MAINSITE . "employee-logout-success");
      exit;

      // REDIRECT(MAINSITE . "employee-login-success");
    }


    /*** checking valid user_employee } */



  }

  public function user_employee_logout_success()
  {

    $this->data['meta_title'] = "Employee Logout Success";
    $this->data['meta_description'] = _project_name_;
    $this->data['meta_keywords'] = _project_name_;
    $this->data['meta_others'] = "";

    $logout_attendance_data = $this->session->userdata('logout_attendance_data');

    $result = !empty($logout_attendance_data);

    if (!empty($logout_attendance_data)) {

      $this->data["attendance_data"] = $logout_attendance_data;
      $this->session->sess_destroy();

      parent::getHeader('header', $this->data);
      $this->load->view('user_employee_logout_success', $this->data);
      parent::getFooter('footer', $this->data);

    } else {
      REDIRECT(MAINSITE);
      exit;
      // $this->load->view('user_employee_logout_success', $this->data);

    }

    // $last_screen = $this->Common_Model->checkScreen();

    // $today = date('m-d'); // Assuming birth_date is stored as MM-DD format

    // $this->data['user_employee_with_birthday'] = $this->User_Model->get_user_employee_data([
    //   "find_birthday_by_today" => $today,
    //   "details" => 1
    // ]);


    // $this->load->view('home', $this->data);
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


  function ajax_insert_enquiry()
  {
    $page = trim($_POST['page']);

    ini_set('display_errors', 'Off');
    ini_set('error_reporting', E_ALL);
    date_default_timezone_set('Asia/Kolkata');
    $timestamp = date("Y-m-d H:i:s");

    //echo '<pre>'; print_r($_POST); echo '</pre>'; exit; 

    if (true) {
      if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
        $link = $_SERVER['HTTP_REFERER'];
        $link_array = explode('/', $link);
        $page_action = end($link_array);
        $parts = parse_url($link);
        $page_host = $parts['host'];
        if (strpos($parts["host"], 'www.') !== false) { //echo 'yes<br>';
          $parts1 = explode('www.', $parts["host"]);
          $page_host = $parts1[1];
        }


        if ($page_host != _mainsite_hostname_) {

          echo '<script language="javascript">';
          echo 'alert("Host validation failed! Please try again.")';
          echo '</script>';
          die();
        }
      } else {
        echo '<script language="javascript">';
        echo 'alert("Error: HTTP_REFERER failed! Please try again.")';
        echo '</script>';
        die();
      }

      $request = '';
      if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
        $param['secret'] = _google_recaptcha_secret_key_;
        $param['response'] = $_POST['g-recaptcha-response'];
        $param['remoteip'] = $_SERVER['REMOTE_ADDR'];
        foreach ($param as $key => $val) {
          $request .= $key . "=" . $val;
          $request .= "&";
        }
        $request = substr($request, 0, strlen($request) - 1);
        $url = "https://www.google.com/recaptcha/api/siteverify?" . $request;
        //echo $url; exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result_data = curl_exec($ch);
        if (curl_exec($ch) === false) {
          $error_info = curl_error($ch);
        }
        curl_close($ch);

        $response = json_decode($result_data);
        if ($response->success != 1) {
          REDIRECT(MAINSITE . $page);
          echo '<script language="javascript">';
          echo 'alert("google recaptcha validation failed! Please try again.")';
          echo '</script>';

          die();
        }
      } else {
        REDIRECT(MAINSITE . $page);
        echo '<script language="javascript">';
        echo 'alert("Error: google recaptcha post validation failed! Please try again.")';
        echo '</script>';
        die();
      }
    }


    $enter_data['name'] = trim($_POST['name']);
    $enter_data['contactno'] = trim($_POST['contactno']);
    $enter_data['email'] = trim($_POST['email']);
    $enter_data['subject'] = trim($_POST['subject']);
    $enter_data['description'] = trim($_POST['description']);
    $enter_data['status'] = 1;

    $enter_data['added_on'] = date("Y-m-d H:i:s");

    $enquiry_result = $insertStatus = $this->Common_Model->add_operation(array('table' => 'enquiry', 'data' => $enter_data));

    if (!empty($enquiry_result)) {
      //redirect to thank you page
      REDIRECT(MAINSITE . "/thank-you");
    } else {
      //redirect to the same page
      REDIRECT(MAINSITE . $page);
    }


  }


  public function thank_you()
  {
    $this->data['meta_title'] = _project_name_ . " - Thank You";
    $this->data['meta_description'] = _project_name_ . " - Thank You";
    $this->data['meta_keywords'] = _project_name_ . " - Thank You";
    $this->data['meta_others'] = "";






    parent::getHeader('header', $this->data);
    $this->load->view('thank-you', $this->data);
    parent::getFooter('footer', $this->data);
  }


  public function test1p()
  {
    $this->data['meta_title'] = _project_name_ . " - Testing";
    $this->data['meta_description'] = _project_name_ . " - Testing";
    $this->data['meta_keywords'] = _project_name_ . " - Testing";
    $this->data['meta_others'] = "";






    parent::getHeader('header', $this->data);
    $this->load->view('test1p', $this->data);
    parent::getFooter('footer', $this->data);
  }







  public function pageNotFound()
  {
    $this->data['meta_title'] = _project_name_ . " - Page Not Found";
    $this->data['meta_description'] = _project_name_ . " - Page Not Found";
    $this->data['meta_keywords'] = _project_name_ . " - Page Not Found";
    $this->data['meta_others'] = "";

    $this->load->view('pageNotFound', $this->data);
  }

  public function found404()
  {
    $this->data['meta_title'] = _project_name_ . " - 404 found";
    $this->data['meta_description'] = _project_name_ . " - 404 found";
    $this->data['meta_keywords'] = _project_name_ . " - 404 found";
    $this->data['meta_others'] = "";

    parent::getHeader('header', $this->data);
    $this->load->view('404found', $this->data);
    parent::getFooter('footer', $this->data);
  }













}
