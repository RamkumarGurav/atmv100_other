<?php
class User_Model extends CI_Model
{
  function __construct()
  {
    date_default_timezone_set("Asia/Kolkata");
    $this->load->library('session');
    $this->db->query("SET sql_mode = ''");

    //headers
    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    $this->output->set_header("Pragma: no-cache");
  }




  function get_user_employee_data($params = array())
  {
    $result = '';



    $this->db->select("ft.*, b.branch_id , b.branch_name , b.branch_address,dp.department_id,dp.department_name,ds.designation_id,
      ds.designation_name, 
 
      ");

    // From admin_user table "ft" refers to "from table"
    $this->db->from("user_employee as ft");
    $this->db->join("branch as  b", "b.branch_id = ft.branch_id");
    $this->db->join("department_master as  dp", "dp.department_id = ft.department_id");
    $this->db->join("designation_master as  ds", "ds.designation_id = ft.designation_id");
    $this->db->where("ft.status", 1);

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }


    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("ft.user_employee_custom_id", $params['user_employee_custom_id']);
    }


    if (!empty($params['branch_id'])) {
      $this->db->where("ft.branch_id", $params['branch_id']);
    }


    if (!empty($params['department_id'])) {
      $this->db->where("ft.department_id", $params['department_id']);
    }
    if (!empty($params['designation_id'])) {
      $this->db->where("ft.designation_id", $params['designation_id']);
    }

    if (!empty($params['find_birthday_by_today'])) {
      $today = date('m-d'); // Assuming birth_date is stored as MM-DD format

      $this->db->where('MONTH(ft.birthday)', date('m'));
      $this->db->where('DAY(ft.birthday)', date('d'));
    }

    if (!empty($params['joining_date'])) {
      $this->db->where("ft.joining_date", $params['joining_date']);
    }


    // Conditional logic for ordering results
    if (!empty($params['order_by'])) {
      $this->db->order_by($params['order_by']);
    } else {
      $this->db->order_by("ft.user_employee_id desc"); // Default order by admin_user_id descending
    }




    if (!empty($params['start_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['start_date']));
      $this->db->where("DATE_FORMAT(ft.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')"); // Start date condition
    }

    if (!empty($params['end_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['end_date']));
      $this->db->where("DATE_FORMAT(ft.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')"); // End date condition
    }


    if (!empty($params['field_value']) && !empty($params['field_name'])) {
      $this->db->where("$params[field_name] like ('%$params[field_value]%')"); // Field name and value condition
    }

    if (!empty($params['limit']) && !empty($params['offset'])) {
      $this->db->limit($params['limit'], $params['offset']); // Limit and offset for pagination
    } else if (!empty($params['limit'])) {
      $this->db->limit($params['limit']); // Limit for number of records
    }


    // Execute query and get results
    $query_get_list = $this->db->get();
    $result = $query_get_list->result();//RESULT CONTAINS ARRAY OF ADMIN_USERS


    // If details parameter is provided, fetch additional details
    if (!empty($result) && !empty($params['details'])) {
      foreach ($result as $utd) {
        $this->db->select("st.*");
        $this->db->from("shift_timing as st");
        $this->db->where("st.user_employee_id", $utd->user_employee_id);
        $this->db->order_by("st.day asc");
        $this->db->where("st.status", 1);
        $utd->shift_timing = $this->db->get()->result();



      }
    }

    return $result; // Return the final result
  }

  function get_user_employee_data_any($params = array())
  {
    $result = '';



    $this->db->select("ft.*, b.branch_id , b.branch_name , b.branch_address,dp.department_id,dp.department_name,ds.designation_id,
      ds.designation_name, 
 
      ");

    // From admin_user table "ft" refers to "from table"
    $this->db->from("user_employee as ft");
    $this->db->join("branch as  b", "b.branch_id = ft.branch_id");
    $this->db->join("department_master as  dp", "dp.department_id = ft.department_id");
    $this->db->join("designation_master as  ds", "ds.designation_id = ft.designation_id");

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }





    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("ft.user_employee_custom_id", $params['user_employee_custom_id']);
    }


    if (!empty($params['branch_id'])) {
      $this->db->where("ft.branch_id", $params['branch_id']);
    }


    if (!empty($params['department_id'])) {
      $this->db->where("ft.department_id", $params['department_id']);
    }
    if (!empty($params['designation_id'])) {
      $this->db->where("ft.designation_id", $params['designation_id']);
    }

    if (!empty($params['find_birthday_by_today'])) {
      $today = date('m-d'); // Assuming birth_date is stored as MM-DD format

      $this->db->where('MONTH(ft.birthday)', date('m'));
      $this->db->where('DAY(ft.birthday)', date('d'));
    }

    if (!empty($params['joining_date'])) {
      $this->db->where("ft.joining_date", $params['joining_date']);
    }


    // Conditional logic for ordering results
    if (!empty($params['order_by'])) {
      $this->db->order_by($params['order_by']);
    } else {
      $this->db->order_by("ft.user_employee_id desc"); // Default order by admin_user_id descending
    }




    if (!empty($params['start_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['start_date']));
      $this->db->where("DATE_FORMAT(ft.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')"); // Start date condition
    }

    if (!empty($params['end_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['end_date']));
      $this->db->where("DATE_FORMAT(ft.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')"); // End date condition
    }


    if (!empty($params['field_value']) && !empty($params['field_name'])) {
      $this->db->where("$params[field_name] like ('%$params[field_value]%')"); // Field name and value condition
    }

    if (!empty($params['limit']) && !empty($params['offset'])) {
      $this->db->limit($params['limit'], $params['offset']); // Limit and offset for pagination
    } else if (!empty($params['limit'])) {
      $this->db->limit($params['limit']); // Limit for number of records
    }


    // Execute query and get results
    $query_get_list = $this->db->get();
    $result = $query_get_list->result();//RESULT CONTAINS ARRAY OF ADMIN_USERS


    // If details parameter is provided, fetch additional details
    if (!empty($result) && !empty($params['details'])) {
      foreach ($result as $utd) {
        $this->db->select("st.*");
        $this->db->from("shift_timing as st");
        $this->db->where("st.user_employee_id", $utd->user_employee_id);
        $this->db->order_by("st.day asc");
        $this->db->where("st.status", 1);
        $utd->shift_timing = $this->db->get()->result();



      }
    }

    return $result; // Return the final result
  }

  function get_ip_address_data($params = array())
  {
    $result = '';
    $this->db->select("ft.* ");
    $this->db->from("ip_address as ft");
    $this->db->where("ft.status", 1);
    $this->db->order_by("ip_address_id desc");

    if (!empty($params['ip_address_id'])) {
      $this->db->where("ft.ip_address_id", $params['ip_address_id']);
    }

    if (!empty($params['ip_address'])) {
      $this->db->where("ft.ip_address", $params['ip_address']);
    }


    if (!empty($params['start_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['start_date']));
      $this->db->where("DATE_FORMAT(ft.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['end_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['end_date']));
      $this->db->where("DATE_FORMAT(ft.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['record_status'])) {
      if ($params['record_status'] == 'zero') {
        $this->db->where("ft.status = 0");
      } else {
        $this->db->where("ft.ip_address_id", $params['record_status']);
      }
    }



    if (!empty($params['field_value']) && !empty($params['field_name'])) {
      $this->db->where("$params[field_name] like ('%$params[field_value]%')");
    }

    if (!empty($params['limit']) && !empty($params['offset'])) {
      $this->db->limit($params['limit'], $params['offset']);
    } else if (!empty($params['limit'])) {
      $this->db->limit($params['limit']);
    }

    $query_get_list = $this->db->get();
    $result = $query_get_list->result();

    return $result;
  }


  function get_attendance_data($params = array())
  {
    $result = '';
    $this->db->select("ft.* ,ue.*");
    $this->db->from("attendance as ft");
    $this->db->join("user_employee as ue", "ue.user_employee_id = ft.user_employee_id");
    $this->db->where("ft.status", 1);
    $this->db->order_by("attendance_id desc");

    if (!empty($params['attendance_id'])) {
      $this->db->where("ft.attendance_id", $params['attendance_id']);
    }

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    // if (!empty($params['ip_address'])) {
    //   $this->db->where("ft.ip_address", $params['ip_address']);
    // }


    if (!empty($params['start_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['start_date']));
      $this->db->where("DATE_FORMAT(ft.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['end_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['end_date']));
      $this->db->where("DATE_FORMAT(ft.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['record_status'])) {
      if ($params['record_status'] == 'zero') {
        $this->db->where("ft.status = 0");
      } else {
        $this->db->where("ft.attendance_id", $params['record_status']);
      }
    }



    if (!empty($params['field_value']) && !empty($params['field_name'])) {
      $this->db->where("$params[field_name] like ('%$params[field_value]%')");
    }

    if (!empty($params['limit']) && !empty($params['offset'])) {
      $this->db->limit($params['limit'], $params['offset']);
    } else if (!empty($params['limit'])) {
      $this->db->limit($params['limit']);
    }

    $query_get_list = $this->db->get();
    $result = $query_get_list->result();

    return $result;
  }


  function get_attendance_data_any($params = array())
  {
    $result = '';
    $this->db->select("ft.* ,ue.*");
    $this->db->from("attendance as ft");
    $this->db->join("user_employee as ue", "ue.user_employee_id = ft.user_employee_id");
    $this->db->order_by("attendance_id desc");

    if (!empty($params['attendance_id'])) {
      $this->db->where("ft.attendance_id", $params['attendance_id']);
    }

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }


    if (!empty($params['get_todays_attendance_of_employee'])) {
      $this->db->where('DATE(ft.added_on)', date('Y-m-d'));
    }

    if (!empty($params['get_recent_attendance_of_employee'])) {
      $this->db->order_by("ft.added_on desc");
    }


    if (!empty($params['start_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['start_date']));
      $this->db->where("DATE_FORMAT(ft.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['end_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['end_date']));
      $this->db->where("DATE_FORMAT(ft.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['record_status'])) {
      if ($params['record_status'] == 'zero') {
        $this->db->where("ft.status = 0");
      } else {
        $this->db->where("ft.attendance_id", $params['record_status']);
      }
    }



    if (!empty($params['field_value']) && !empty($params['field_name'])) {
      $this->db->where("$params[field_name] like ('%$params[field_value]%')");
    }

    if (!empty($params['limit']) && !empty($params['offset'])) {
      $this->db->limit($params['limit'], $params['offset']);
    } else if (!empty($params['limit'])) {
      $this->db->limit($params['limit']);
    }

    $query_get_list = $this->db->get();
    $result = $query_get_list->result();

    return $result;
  }

}

?>