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
      $this->session->set_flashdata('alert_message', $alert_message);
      REDIRECT(MAINSITE . "access-denied");
      exit;
    } else {
      $user_employee_id = $this->session->userdata('user_employee_id');
      //IF THERE IS VALID EMPLOYEE
      if (!empty($user_employee_id)) {
        /*** checking valid user_employee <*/
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
              "get_recent_attendance_of_employee" => 1,
              "details" => 1
            ]);


            if (!empty($this->data['attendance_data'])) {
              $attendance_data = $this->data['attendance_data'][0];


              //HERE employee is trying to logout
              //if the employee is already logged_in and not yet logged_out then
              if (!empty($attendance_data->login_time) && empty(($attendance_data->logout_time))) {

                $total_hours_from_login = $this->total_time_between_login_and_now($attendance_data->login_time);
                $is_time1_greater_than_time2 = $this->is_time1_greater_than_time2($total_hours_from_login, 12);


                //if the employee is forgot to logout before 12hours and try to logout now then block him ELSE allow him to login
                if (!empty($is_time1_greater_than_time2)) {
                  $enter_data["status"] = 0;
                  $update_status = $this->Common_Model->update_operation(array('table' => 'user_employee', 'data' => $enter_data, 'condition' => "user_employee_id = $user_employee_id"));
                  $employee_status = "blocked";
                  $employee_login_status = "blocked";
                  $attendance_log = "tryied to late logout at ";
                  $alert_message = '<div class="alert alert-warning alert-dismissible"><button type="button" 
                  class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
               Late logout ,please contact admin  </div>';
                  $this->session->set_flashdata('alert_message', $alert_message);
                } else {
                  //this is a normal logout
                  $employee_login_status = "allowed_for_logout";

                }

                //when employee is already logged_in and logged_out then
              } elseif (!empty($attendance_data->login_time) && !empty(($attendance_data->logout_time))) {

                //if the last logout date falls in  same as today 
                $is_time1_and_time2_same = $this->is_time1_and_time2_same($attendance_data->logout_time);

                if (!empty($is_time1_and_time2_same)) {
                  $alert_message = '<div class="alert alert-info alert-dismissible"><button type="button" 
                    class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-info"></i>
                  Multiple Attendance in same day?? </div>';
                  $this->session->set_flashdata('alert_message', $alert_message);

                  //Here if you want to restrict the multiple attendances in single day then change belelow status to "blocked"
                  $employee_login_status = "allowed_for_login";
                  $attendance_log = "another attendance login in same day ";


                } else {
                  //noraml login in when last logout doesn't fall in today
                  $employee_login_status = "allowed_for_login";
                }


                //if in any case if the employee is somehow logged_in but his logged_in time is not regestered in the database ,but his logout 
                //time is there or if the a recored is created for attendance but don't have login and logout time then also block the employee
              } else {
                //if there is attendace record with empty login and logut times or only has logout_time then block the employee
                $employee_status = "blocked";
                $employee_login_status = "blocked";
                $enter_data["status"] = 0;
                $alert_message = '<div class="alert alert-warning alert-dismissible"><button type="button" 
                class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
              Your last attendance was not successful ,please contact admin  </div>';
                $this->session->set_flashdata('alert_message', $alert_message);
                $update_status = $this->Common_Model->update_operation(array('table' => 'user_employee', 'data' => $enter_data, 'condition' => "user_employee_id = $user_employee_id"));
              }

            } else {
              //allow first login of fresh employee
              $employee_login_status = "allowed_for_login";

            }




          } else {


            $employee_status = "blocked";
            $this->data['employee_status'] = $employee_status;
            $employee_login_status = "blocked";
            $this->data['employee_login_status'] = $employee_login_status;



            $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
                                          class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
                                        Employee with this ID is Blocked.Please contact the office </div>';
            $this->session->set_flashdata('alert_message', $alert_message);

          }

          $this->data['employee_status'] = $employee_status;
          $this->data['employee_login_status'] = $employee_login_status;


          parent::getHeader('header', $this->data);
          $this->load->view('employee_attendance', $this->data);
          parent::getFooter('footer', $this->data);


        }

      } else {

        $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
        class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
        Session Got destroyed </div>';
        $this->session->set_flashdata('alert_message', $alert_message);
        REDIRECT(MAINSITE);
        exit;
      }

    }

  }


  public function total_time_between_login_and_now($login_time)
  {
    $login_time = new DateTime($login_time);
    $today_time = date("Y-m-d H:i:s");
    $logout_time = new DateTime($today_time);
    $interval = $login_time->diff($logout_time);
    $total_time = $interval->format('%H:%I:%S');
    return $total_time;
  }

  public function total_time_between_login_and_logout($login_time, $logout_time)
  {
    $login_time = new DateTime($login_time);
    $logout_time = new DateTime($logout_time);
    $interval = $login_time->diff($logout_time);
    $total_time = $interval->format('%H:%I:%S');
    $enter_data["total_time"] = $total_time;
  }

  public function is_time1_greater_than_time2($time1, $time2 = 12)
  {
    // Split the time string into hours, minutes, and seconds
    list($hours, $minutes, $seconds) = explode(':', $time1);

    // Convert the time to total hours
    $total_hours = $hours + ($minutes / 60) + ($seconds / 3600);

    // Check if the total hours are greater than 12
    return $total_hours > $time2;
  }


  public function is_time1_and_time2_same($datetime1, $datetime2 = "")
  {
    // Create DateTime objects from the given datetime strings
    $date1 = new DateTime($datetime1);
    $date2 = new DateTime($datetime2);

    // Format the dates to 'Y-m-d'
    $date1_formatted = $date1->format('Y-m-d');
    $date2_formatted = $date2->format('Y-m-d');

    // Compare the formatted dates
    if ($date1_formatted === $date2_formatted) {
      return $date1_formatted;
    } else {
      0;
    }
  }

  public function is_time1_and_now_same($datetime1)
  {
    // Create DateTime objects from the given datetime strings
    $date1 = new DateTime($datetime1);
    $date2 = new DateTime();

    // Format the dates to 'Y-m-d'
    $date1_formatted = $date1->format('Y-m-d');
    $date2_formatted = $date2->format('Y-m-d');

    // Compare the formatted dates
    if ($date1_formatted === $date2_formatted) {
      return $date1_formatted;
    } else {
      0;
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
      $this->session->set_flashdata('alert_message', $alert_message);
      REDIRECT(MAINSITE . "access-denied");
      exit;
    } else {

      $user_employee_id = $this->session->userdata('user_employee_id');

      if ($user_employee_id >= 1) {

        $enter_data["user_employee_id"] = $user_employee_id;
        $enter_data["login_time"] = date("Y-m-d H:i:s");
        $enter_data["status"] = 1;

        $attendance_id = $insertStatus = $this->Common_Model->add_operation(array('table' => 'attendance', 'data' => $enter_data));

        if ($attendance_id >= 1) {
          $this->upload_any_image("attendance", "attendance_id", $attendance_id, "attendance_login_image", "attendance_login_image", "attendance_login_image_", "attendance_login_image");
          $this->session->set_userdata('attendance_id', $attendance_id);
        }

        REDIRECT(MAINSITE . "employee-login-success");
      } else {
        $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
        class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
       Session got destroyed' . $ip_address . '</div>';
        $this->session->set_flashdata('alert_message', $alert_message);
        REDIRECT(MAINSITE);
      }


    }





  }

  public function user_employee_login_success()
  {

    $this->data['meta_title'] = "Employee Login Success";
    $this->data['meta_description'] = _project_name_;
    $this->data['meta_keywords'] = _project_name_;
    $this->data['meta_others'] = "";

    $attendance_id = $this->session->userdata('attendance_id');
    $user_employee_id = $this->session->userdata('user_employee_id');


    if (!empty($attendance_id)) {

      $this->data["attendance_data"] = $attendance_id;
      $this->data['attendance_data'] = $this->User_Model->get_attendance_data_any([
        "attendance_id" => $attendance_id,
        "details" => 1
      ]);
      $this->data['user_employee_data'] = $this->User_Model->get_user_employee_data_any([
        "user_employee_id" => $user_employee_id,
        "details" => 1
      ]);

      $this->session->sess_destroy();

      echo "<pre> <br>";
      print_r($this->data['attendance_data']);
      print_r($this->data['user_employee_data']);
      exit;

      parent::getHeader('header', $this->data);
      $this->load->view('user_employee_login_success', $this->data);
      parent::getFooter('footer', $this->data);
    } else {
      $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
        class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
       Session got destroyed' . '</div>';
      $this->session->set_flashdata('alert_message', $alert_message);
      REDIRECT(MAINSITE);
      exit;
    }


  }







  public function ajax_user_employee_do_logout()
  {

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
      $this->session->set_flashdata('alert_message', $alert_message);
      REDIRECT(MAINSITE . "access-denied");
      exit;
    } else {
      $user_employee_id = $this->session->userdata('user_employee_id');
      $attendance_id = $this->session->userdata('attendance_id');
      if ($attendance_id >= 1) {
        // $attendance_id = $this->input->post('attendance_id');
        // $enter_data["user_employee_id"] = $user_employee_id;
        $enter_data["logout_time"] = date("Y-m-d H:i:s");

        $insertStatus = $this->Common_Model->update_operation(array('table' => 'attendance', 'data' => $enter_data, 'condition' => "attendance_id = $attendance_id"));
        if (!empty($insertStatus)) {
          $this->upload_any_image("attendance", "attendance_id", $attendance_id, "attendance_logout_image", "attendance_logout_image", "attendance_logout_image_", "attendance_logout_image");
          $this->session->set_userdata('attendance_id', $attendance_id);
        }

        REDIRECT(MAINSITE . "employee-logout-success");
      } else {
        $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
        class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
       Session got destroyed.</div>';
        $this->session->set_flashdata('alert_message', $alert_message);
        REDIRECT(MAINSITE);
      }


    }





  }

  public function user_employee_logout_success()
  {

    $this->data['meta_title'] = "Employee Logout Success";
    $this->data['meta_description'] = _project_name_;
    $this->data['meta_keywords'] = _project_name_;
    $this->data['meta_others'] = "";

    $attendance_id = $this->session->userdata('attendance_id');
    $user_employee_id = $this->session->userdata('user_employee_id');


    if (!empty($attendance_id)) {

      $this->data["attendance_data"] = $attendance_id;
      $this->data['attendance_data'] = $this->User_Model->get_attendance_data_any([
        "attendance_id" => $attendance_id,
        "details" => 1
      ]);
      $this->data['user_employee_data'] = $this->User_Model->get_user_employee_data_any([
        "user_employee_id" => $user_employee_id,
        "details" => 1
      ]);

      $this->session->sess_destroy();

      echo "<pre> <br>";
      print_r($this->data['attendance_data']);
      print_r($this->data['user_employee_data']);
      exit;

      parent::getHeader('header', $this->data);
      $this->load->view('user_employee_logout_success', $this->data);
      parent::getFooter('footer', $this->data);
    } else {
      $alert_message = '<div class="alert alert-danger alert-dismissible"><button type="button" 
        class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="icon fas fa-ban"></i>
       Session got destroyed' . '</div>';
      $this->session->set_flashdata('alert_message', $alert_message);
      REDIRECT(MAINSITE);
      exit;
    }


  }

  public function upload_any_image($table_name, $id_column, $id, $input_name, $target_column, $prefix, $target_folder_name)
  {

    $file_name = "";
    if (isset($_FILES[$input_name]['name'])) {
      $timg_name = $_FILES[$input_name]['name'];
      if (!empty($timg_name)) {
        $temp_var = explode(".", strtolower($timg_name));
        $timage_ext = end($temp_var);
        $timage_name_new = $prefix . $id . "." . $timage_ext;
c
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
