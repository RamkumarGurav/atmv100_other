<?php
class Attendance_Model extends CI_Model
{
  public $session_uid = '';
  public $session_name = '';
  public $session_email = '';

  function __construct()
  {
    $this->load->database();
    $this->model_data = array();
    $this->db->query("SET sql_mode = ''");
    $this->session_uid = $this->session->userdata('sess_psts_uid');
    $this->session_name = $this->session->userdata('sess_psts_name');
    $this->session_email = $this->session->userdata('sess_psts_email');

  }

  /**
   * getting attendances with search ,pagination  and sorting using params ,if your using this method to find single attendance data with its attendance_id then it will be present int the 0th index of the resultant array
   */
  function get_attendance($params = array())
  {
    $result = '';
    if (!empty($params['search_for'])) {
      $this->db->select("count(urm.attendance_id) as counts");
    } else {
      $this->db->select("urm.* , uemp.name,uemp.user_employee_custom_id,uemp.profile_image,uemp.contactno");
      $this->db->select("(select au.name from admin_user as  au where au.admin_user_id = urm.added_by) as added_by_name ");
      $this->db->select("(select au.name from admin_user as  au where au.admin_user_id = urm.updated_by) as updated_by_name ");
    }

    $this->db->from("attendance as urm");
    $this->db->join("user_employee as  uemp", "uemp.user_employee_id = urm.user_employee_id");
    $this->db->order_by("urm.attendance_id desc");


    if (!empty($params['attendance_id'])) {
      $this->db->where("urm.attendance_id", $params['attendance_id']);
    }
    if (!empty($params['user_employee_id'])) {
      $this->db->where("urm.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("uemp.user_employee_custom_id", $params['user_employee_custom_id']);
    }

    if (!empty($params['branch_id'])) {
      $this->db->where("uemp.branch_id", $params['branch_id']);
    }

    if (!empty($params['department_id'])) {
      $this->db->where("uemp.department_id", $params['department_id']);
    }

    if (!empty($params['designation_id'])) {
      $this->db->where("uemp.designation_id", $params['designation_id']);
    }


    if (!empty($params['login_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['login_date']));
      $this->db->where("DATE_FORMAT(urm.login_time, '%Y%m%d') = DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['logout_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['logout_date']));
      $this->db->where("DATE_FORMAT(urm.logout_time, '%Y%m%d') = DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['start_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['start_date']));
      $this->db->where("DATE_FORMAT(urm.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['end_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['end_date']));
      $this->db->where("DATE_FORMAT(urm.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['record_status'])) {
      if ($params['record_status'] == 'zero') {
        $this->db->where("urm.status = 0");
      } else {
        $this->db->where("urm.status", $params['record_status']);
      }
    }

    if (!empty($params['employee_record_status'])) {
      if ($params['employee_record_status'] == 'zero') {
        $this->db->where("uemp.status = 0");
      } else {
        $this->db->where("uemp.status", $params['employee_record_status']);
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



  function get_attendance_report1($params = array())
  {
    $result = '';

    $this->db->select("urm.* , ue.name,ue.user_employee_custom_id,ue.profile_image,ue.contactno");
    $this->db->select("(select au.name from admin_user as  au where au.admin_user_id = urm.added_by) as added_by_name ");
    $this->db->select("(select au.name from admin_user as  au where au.admin_user_id = urm.updated_by) as updated_by_name ");

    $this->db->from("attendance as urm");
    $this->db->join("user_employee as  ue", "ue.user_employee_id = urm.user_employee_id");
    $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');

    $this->db->group_by('ue.user_employee_id');
    $this->db->order_by("urm.user_employee_id desc");


    if (!empty($params['attendance_id'])) {
      $this->db->where("urm.attendance_id", $params['attendance_id']);
    }

    if (!empty($params['user_employee_id'])) {
      $this->db->where("urm.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("ue.user_employee_custom_id", $params['user_employee_custom_id']);
    }

    if (!empty($params['branch_id'])) {
      $this->db->where("ue.branch_id", $params['branch_id']);
    }

    if (!empty($params['department_id'])) {
      $this->db->where("ue.department_id", $params['department_id']);
    }

    if (!empty($params['designation_id'])) {
      $this->db->where("ue.designation_id", $params['designation_id']);
    }


    if (!empty($params['start_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['start_date']));
      $this->db->where("DATE_FORMAT(urm.added_on, '%Y%m%d') >= DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['end_date'])) {
      $temp_date = date('Y-m-d', strtotime($params['end_date']));
      $this->db->where("DATE_FORMAT(urm.added_on, '%Y%m%d') <= DATE_FORMAT('$temp_date', '%Y%m%d')");
    }

    if (!empty($params['record_status'])) {
      if ($params['record_status'] == 'zero') {
        $this->db->where("urm.status = 0");
      } else {
        $this->db->where("urm.status", $params['record_status']);
      }
    }

    if (!empty($params['employee_record_status'])) {
      if ($params['employee_record_status'] == 'zero') {
        $this->db->where("ue.status = 0");
      } else {
        $this->db->where("ue.status", $params['employee_record_status']);
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


  public function get_attendance_report($start_date, $end_date)
  {
    $query = $this->db->query("
        SELECT 
            ue.user_employee_id,
            ue.name,
            ue.user_employee_custom_id,
            ue.branch_id,
            ue.department_id,
            ue.designation_id,
            ue.contactno,
            ue.company_email,
            ue.name,
            DATE_FORMAT('$start_date', '%d/%m/%Y') AS from_date,
            DATE_FORMAT('$end_date', '%d/%m/%Y') AS to_date,
            SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, a.actual_login_time, a.actual_logout_time))) AS total_work_time,
            COUNT(DISTINCT DATE(st.added_on)) - COUNT(DISTINCT DATE(a.actual_login_time)) AS absent_days,
            SUM(CASE WHEN a.actual_login_time > CONCAT(DATE(a.actual_login_time), ' ', st.ideal_login_time) THEN 1 ELSE 0 END) AS late_logins,
            SUM(CASE WHEN a.actual_logout_time < CONCAT(DATE(a.actual_logout_time), ' ', st.ideal_logout_time) THEN 1 ELSE 0 END) AS early_logouts
        FROM 
            user_employee ue
        LEFT JOIN 
            attendance a ON ue.user_employee_id = a.user_employee_id AND a.actual_login_time BETWEEN '$start_date' AND '$end_date'
        LEFT JOIN 
            shift_timing st ON ue.user_employee_id = st.user_employee_id AND DAYOFWEEK(a.actual_login_time) = st.day_number
        WHERE 
            st.is_working_day = '1'
        GROUP BY 
            ue.user_employee_id
    ");
    return $query->result();
  }

  public function get_total_working_time_by_month1($params = array())
  {
    $this->db->select('ft.user_employee_id, ft.name, 
                       YEAR(attendance.login_time) AS year, 
                       MONTH(attendance.login_time) AS month, 
                       SEC_TO_TIME(SUM(TIME_TO_SEC(attendance.total_time))) AS total_working_time');

    $this->db->from('user_employee as ft');
    $this->db->join('attendance', 'ft.user_employee_id = attendance.user_employee_id');
    // $this->db->where('ft.user_employee_id', $user_employee_id);

    if (!empty($params['user_employee_id'])) {
      $this->db->where('ft.user_employee_id', $params['user_employee_id']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(attendance.login_time)', $params['year']);
    }


    $this->db->group_by('ft.user_employee_id, year, month');
    $this->db->order_by('year desc');
    $this->db->order_by('month desc');
    $query = $this->db->get();
    return $query->result();
  }




  public function get_total_working_time_by_month($params = array())
  {
    $this->db->select('ft.user_employee_id, ft.name, 
                       YEAR(attendance.login_time) AS year, 
                       MONTH(attendance.login_time) AS month, 
                       SEC_TO_TIME(SUM(TIME_TO_SEC(attendance.total_time))) AS total_working_time,
                       COUNT(CASE WHEN attendance.logout_time IS NOT NULL AND attendance.status=1 THEN 1 END) AS successful_attendance_days');
    $this->db->from('user_employee as ft');
    $this->db->join('attendance', 'ft.user_employee_id = attendance.user_employee_id', 'left');

    if (!empty($params['user_employee_id'])) {
      $this->db->where('ft.user_employee_id', $params['user_employee_id']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(attendance.login_time)', $params['year']);
    }

    $this->db->group_by('ft.user_employee_id, year, month');
    $this->db->order_by('year DESC, month DESC');
    $query = $this->db->get();
    return $query->result();
  }








  public function get_late_logins_group_by_employee($params = array())
  {
    $this->db->select(' ue.*');
    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
    $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("ue.user_employee_custom_id", $params['user_employee_custom_id']);
    }

    if (!empty($params['attendance_record_status'])) {
      $this->db->where("ft.status", $params['attendance_record_status']);
    }

    if (!empty($params['current_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE(CURDATE())');
    }

    if (!empty($params['last_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
    }

    if (!empty($params['last_month'])) {
      $this->db->where('MONTH(ft.login_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
      $this->db->where('YEAR(ft.login_time) = YEAR(CURDATE())');
    }

    if (!empty($params['last_year'])) {
      $this->db->where('YEAR(ft.login_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
    }

    if (!empty($params['date_in_ymd'])) {
      $this->db->where('DATE(ft.login_time)', $params['date_in_ymd']);
    }

    if (!empty($params['year']) && !empty($params['month'] && !empty($params['day']))) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
      $this->db->where('DAY(ft.login_time)', $params['day']);
    }



    if (!empty($params['year']) && !empty($params['month'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
    }

    $this->db->where('ft.login_time IS NOT NULL');
    $this->db->where('DAYOFWEEK(ft.login_time) = (shift_timing.day+1)');
    $this->db->where('TIME(ft.login_time) > ADDTIME(shift_timing.login_time, "00:15:00")');
    $this->db->where('shift_timing.is_working_day', 1);
    $this->db->group_by('ue.user_employee_id');

    $query = $this->db->get();
    // return $query->result();
    $results = $query->result();

    // Loop through results to fetch attendance data
    foreach ($results as $result) {
      $this->db->select('ft.*');
      $this->db->from('attendance as ft');
      $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
      $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');

      $this->db->where('ft.user_employee_id', $result->user_employee_id);

      if (!empty($params['attendance_record_status'])) {
        $this->db->where("ft.status", $params['attendance_record_status']);
      }

      if (!empty($params['current_day'])) {
        $this->db->where('DATE(ft.login_time) = DATE(CURDATE())');
      }

      if (!empty($params['last_day'])) {
        $this->db->where('DATE(ft.login_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
      }

      if (!empty($params['last_month'])) {
        $this->db->where('MONTH(ft.login_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
        $this->db->where('YEAR(ft.login_time) = YEAR(CURDATE())');
      }

      if (!empty($params['last_year'])) {
        $this->db->where('YEAR(ft.login_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
      }

      if (!empty($params['date_in_ymd'])) {
        $this->db->where('DATE(ft.login_time)', $params['date_in_ymd']);
      }

      if (!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
        $this->db->where('YEAR(ft.login_time)', $params['year']);
        $this->db->where('MONTH(ft.login_time)', $params['month']);
        $this->db->where('DAY(ft.login_time)', $params['day']);
      }



      if (!empty($params['year']) && !empty($params['month'])) {
        $this->db->where('YEAR(ft.login_time)', $params['year']);
        $this->db->where('MONTH(ft.login_time)', $params['month']);
      }

      if (!empty($params['year'])) {
        $this->db->where('YEAR(ft.login_time)', $params['year']);
      }

      $this->db->where('ft.login_time IS NOT NULL');
      $this->db->where('DAYOFWEEK(ft.login_time) = (shift_timing.day+1)');
      $this->db->where('TIME(ft.login_time) > ADDTIME(shift_timing.login_time, "00:15:00")');
      $this->db->where('shift_timing.is_working_day', 1);

      $attendance_query = $this->db->get();
      $result->attendance_data = $attendance_query->result();
    }

    return $results;
  }

  public function get_late_logins($params = array())
  {

    if (!empty($params['search_for'])) {
      $this->db->select("count(ft.attendance_id) as counts");
    } else {

      $this->db->select('ft.*, ue.user_employee_id,ue.name,ue.profile_image,ue.contactno,ue.personal_email,ue.user_employee_custom_id');

    }
    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
    $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');

    $this->db->where('ft.login_time IS NOT NULL');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("ue.user_employee_custom_id", $params['user_employee_custom_id']);
    }

    if (!empty($params['attendance_record_status'])) {
      $this->db->where("ft.status", $params['attendance_record_status']);
    }

    if (!empty($params['current_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE(CURDATE())');
    }

    if (!empty($params['last_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
    }

    if (!empty($params['last_month'])) {
      $this->db->where('MONTH(ft.login_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
      $this->db->where('YEAR(ft.login_time) = YEAR(CURDATE())');
    }

    if (!empty($params['last_year'])) {
      $this->db->where('YEAR(ft.login_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
    }

    if (!empty($params['date_in_ymd'])) {
      $this->db->where('DATE(ft.login_time)', $params['date_in_ymd']);
    }

    if (!empty($params['year']) && !empty($params['month'] && !empty($params['day']))) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
      $this->db->where('DAY(ft.login_time)', $params['day']);
    }



    if (!empty($params['year']) && !empty($params['month'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
    }

    $this->db->where('DAYOFWEEK(ft.login_time) = (shift_timing.day+1)');
    $this->db->where('TIME(ft.login_time) > ADDTIME(shift_timing.login_time, "00:15:00")');
    $this->db->where('shift_timing.is_working_day', 1);

    $query = $this->db->get();
    // return $query->result();
    $results = $query->result();



    return $results;
  }

  public function get_late_logins_between_2dates($params = array())
  {
    if (!empty($params['search_for'])) {
      $this->db->select("count(ft.attendance_id) as counts");
    } else {
      $this->db->select('
            ue.user_employee_id,
            ue.name,
            ue.profile_image,
            ue.contactno,
            ue.personal_email,
            ue.user_employee_custom_id,
            COUNT(ft.attendance_id) as late_logins_count
        ');
    }

    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
    $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');

    $this->db->where('ft.login_time IS NOT NULL');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("ue.user_employee_custom_id", $params['user_employee_custom_id']);
    }

    if (!empty($params['attendance_record_status'])) {
      $this->db->where("ft.status", $params['attendance_record_status']);
    }

    if (!empty($params['start_date']) && !empty($params['end_date'])) {
      $this->db->where('ft.login_time >=', $params['start_date']);
      $this->db->where('ft.login_time <=', $params['end_date']);
    }

    $this->db->where('DAYOFWEEK(ft.login_time) = (shift_timing.day + 1)');
    $this->db->where('TIME(ft.login_time) > ADDTIME(shift_timing.login_time, "00:15:00")');
    $this->db->where('shift_timing.is_working_day', 1);

    if (empty($params['search_for'])) {
      $this->db->group_by('ue.user_employee_id');
    }

    $query = $this->db->get();
    $results = $query->result();

    return $results;
  }




  public function get_attendance_report11($params = array())
  {
    $start_date = $params["start_date"];
    $end_date = $params["end_date"];
    // $this->db->select(` DATE_FORMAT('$start_date', '%d/%m/%Y') AS from_date,
    //             DATE_FORMAT('$end_date', '%d/%m/%Y') AS to_date`);
    $this->db->select("
     DATE_FORMAT('$start_date', '%d/%m/%Y') AS from_date,
             DATE_FORMAT('$end_date', '%d/%m/%Y') AS to_date,
              ue.user_employee_id,
              ue.name,
              ue.profile_image,
              ue.contactno,
              ue.personal_email,
              ue.user_employee_custom_id,
           COUNT(CASE WHEN  TIME(ft.login_time) > ADDTIME(shift_timing.login_time, '00:15:00') THEN ft.attendance_id ELSE NULL END) as late_logins_count,
   COUNT(CASE WHEN TIME(ft.logout_time) < SUBTIME(shift_timing.logout_time, '00:15:00') THEN ft.attendance_id ELSE NULL END) as early_logouts_count,
     SEC_TO_TIME(SUM(TIMESTAMPDIFF(SECOND, ft.login_time, ft.logout_time))) as total_work_time ,
      COALESCE(COUNT(missed_logins.missed_date), 0) AS missed_logins_count    
   ");




    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
    $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');


    // Subquery to count missed logins
    $this->db->join('(
      SELECT st.user_employee_id, COUNT(*) AS missed_days
      FROM shift_timing st
      LEFT JOIN attendance a ON st.user_employee_id = a.user_employee_id 
          AND DATE(a.login_time) = st.shift_date
      WHERE st.is_working_day = 1 
        AND a.login_time IS NULL
        AND st.shift_date BETWEEN "' . $start_date . '" AND "' . $end_date . '"
      GROUP BY st.user_employee_id
  ) AS missed_logins', 'ue.user_employee_id = missed_logins.user_employee_id', 'left');

    $this->db->where('ft.login_time IS NOT NULL');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }
    if (!empty($params['attendance_record_status'])) {
      if ($params['attendance_record_status'] == 'zero') {
        $this->db->where("ft.status = 0");
      } else {
        $this->db->where("ft.status", $params['attendance_record_status']);
      }
    }

    if (!empty($params['user_employee_record_status'])) {
      if ($params['user_employee_record_status'] == 'zero') {
        $this->db->where("ue.status = 0");
      } else {
        $this->db->where("ue.status", $params['user_employee_record_status']);
      }
    }
    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("ue.user_employee_custom_id", $params['user_employee_custom_id']);
    }



    if (!empty($params['start_date']) && !empty($params['end_date'])) {
      $this->db->where('ft.login_time >=', $params['start_date']);
      $this->db->where('ft.login_time <=', $params['end_date']);
    }

    $this->db->where('DAYOFWEEK(ft.login_time) = (shift_timing.day + 1)');
    $this->db->where('shift_timing.is_working_day', 1);

    $this->db->group_by('ue.user_employee_id');

    $query = $this->db->get();
    $results = $query->result();

    return $results;
  }

  public function get_late_logins_only_count($params = array())
  {
    $this->db->select(' COUNT(*) as count');
    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
    $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("ue.user_employee_custom_id", $params['user_employee_custom_id']);
    }

    if (!empty($params['attendance_record_status'])) {
      $this->db->where("ft.status", $params['attendance_record_status']);
    }

    if (!empty($params['current_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE(CURDATE())');
    }

    if (!empty($params['last_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
    }

    if (!empty($params['last_month'])) {
      $this->db->where('MONTH(ft.login_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
      $this->db->where('YEAR(ft.login_time) = YEAR(CURDATE())');
    }

    if (!empty($params['last_year'])) {
      $this->db->where('YEAR(ft.login_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
    }

    if (!empty($params['date_in_ymd'])) {
      $this->db->where('DATE(ft.login_time)', $params['date_in_ymd']);
    }

    if (!empty($params['year']) && !empty($params['month'] && !empty($params['day']))) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
      $this->db->where('DAY(ft.login_time)', $params['day']);
    }



    if (!empty($params['year']) && !empty($params['month'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
    }

    $this->db->where('ft.login_time IS NOT NULL');
    $this->db->where('DAYOFWEEK(ft.login_time) = (shift_timing.day+1)');
    $this->db->where('TIME(ft.login_time) > ADDTIME(shift_timing.login_time, "00:15:00")');
    $this->db->where('shift_timing.is_working_day', 1);

    $query = $this->db->get();
    return $query->result();
  }



  public function get_early_logouts_group_by_employee($params = array())
  {
    $this->db->select(' ue.*');
    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("BINARY ue.user_employee_custom_id", $params['user_employee_custom_id']); // Ensure case sensitivity
    }






    $this->db->group_by('ue.user_employee_id');

    $query = $this->db->get();
    // return $query->result();
    $results = $query->result();

    // Loop through results to fetch attendance data
    foreach ($results as $result) {
      $this->db->select('ft.*');
      $this->db->from('attendance as ft');
      $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
      $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');

      $this->db->where('ft.user_employee_id', $result->user_employee_id);

      if (!empty($params['attendance_record_status'])) {
        $this->db->where("ft.status", $params['attendance_record_status']);
      }

      if (!empty($params['current_day'])) {
        $this->db->where('DATE(ft.logout_time) = DATE(CURDATE())');
      }

      if (!empty($params['last_day'])) {
        $this->db->where('DATE(ft.logout_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
      }

      if (!empty($params['last_month'])) {
        $this->db->where('MONTH(ft.logout_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
        $this->db->where('YEAR(ft.logout_time) = YEAR(CURDATE())');
      }

      if (!empty($params['last_year'])) {
        $this->db->where('YEAR(ft.logout_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
      }

      if (!empty($params['date_in_ymd'])) {
        $this->db->where('DATE(ft.logout_time)', $params['date_in_ymd']);
      }

      if (!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
        $this->db->where('YEAR(ft.logout_time)', $params['year']);
        $this->db->where('MONTH(ft.logout_time)', $params['month']);
        $this->db->where('DAY(ft.logout_time)', $params['day']);
      }



      if (!empty($params['year']) && !empty($params['month'])) {
        $this->db->where('YEAR(ft.logout_time)', $params['year']);
        $this->db->where('MONTH(ft.logout_time)', $params['month']);
      }

      if (!empty($params['year'])) {
        $this->db->where('YEAR(ft.logout_time)', $params['year']);
      }

      $this->db->where('ft.login_time IS NOT NULL');
      $this->db->where('ft.logout_time IS NOT NULL');
      $this->db->where('DAYOFWEEK(ft.logout_time) = (shift_timing.day+1)');
      $this->db->where('TIME(ft.logout_time) < SUBTIME(shift_timing.logout_time, "00:15:00")');
      $this->db->where('shift_timing.is_working_day', 1);

      $attendance_query = $this->db->get();
      $result->attendance_data = $attendance_query->result();
    }

    return $results;
  }

  public function get_early_logouts($params = array())
  {

    if (!empty($params['search_for'])) {
      $this->db->select("count(ft.attendance_id) as counts");
    } else {

      $this->db->select('ft.*, ue.user_employee_id,ue.name,ue.profile_image,ue.contactno,ue.personal_email,ue.user_employee_custom_id');

    }
    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
    $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');

    $this->db->where('ft.login_time IS NOT NULL');
    $this->db->where('ft.logout_time IS NOT NULL');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("ue.user_employee_custom_id", $params['user_employee_custom_id']);
    }

    if (!empty($params['attendance_record_status'])) {
      $this->db->where("ft.status", $params['attendance_record_status']);
    }

    if (!empty($params['current_day'])) {
      $this->db->where('DATE(ft.logout_time) = DATE(CURDATE())');
    }

    if (!empty($params['last_day'])) {
      $this->db->where('DATE(ft.logout_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
    }

    if (!empty($params['last_month'])) {
      $this->db->where('MONTH(ft.logout_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
      $this->db->where('YEAR(ft.logout_time) = YEAR(CURDATE())');
    }

    if (!empty($params['last_year'])) {
      $this->db->where('YEAR(ft.logout_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
    }

    if (!empty($params['date_in_ymd'])) {
      $this->db->where('DATE(ft.logout_time)', $params['date_in_ymd']);
    }

    if (!empty($params['year']) && !empty($params['month'] && !empty($params['day']))) {
      $this->db->where('YEAR(ft.logout_time)', $params['year']);
      $this->db->where('MONTH(ft.logout_time)', $params['month']);
      $this->db->where('DAY(ft.logout_time)', $params['day']);
    }



    if (!empty($params['year']) && !empty($params['month'])) {
      $this->db->where('YEAR(ft.logout_time)', $params['year']);
      $this->db->where('MONTH(ft.logout_time)', $params['month']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(ft.logout_time)', $params['year']);
    }

    $this->db->where('DAYOFWEEK(ft.logout_time) = (shift_timing.day+1)');
    $this->db->where('TIME(ft.logout_time) < SUBTIME(shift_timing.logout_time, "00:15:00")');
    $this->db->where('shift_timing.is_working_day', 1);

    $query = $this->db->get();
    // return $query->result();
    $results = $query->result();



    return $results;
  }

  public function get_early_logouts_only_count($params = array())
  {
    $this->db->select('COUNT(*) as count');
    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
    $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("BINARY ue.user_employee_custom_id", $params['user_employee_custom_id']); // Ensure case sensitivity
    }

    if (!empty($params['attendance_record_status'])) {
      $this->db->where("ft.status", $params['attendance_record_status']);
    }




    if (!empty($params['last_day'])) {
      $this->db->where('DATE(ft.logout_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
    }

    if (!empty($params['current_day'])) {
      $this->db->where('DATE(ft.logout_time) = DATE(CURDATE())');
    }

    if (!empty($params['last_month'])) {
      $this->db->where('MONTH(ft.logout_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
      $this->db->where('YEAR(ft.logout_time) = YEAR(CURDATE())');
    }

    if (!empty($params['last_year'])) {
      $this->db->where('YEAR(ft.logout_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
    }

    if (!empty($params['date_in_ymd'])) {
      $this->db->where('DATE(ft.logout_time)', $params['date_in_ymd']);
    }

    if (!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
      $this->db->where('YEAR(ft.logout_time)', $params['year']);
      $this->db->where('MONTH(ft.logout_time)', $params['month']);
      $this->db->where('DAY(ft.logout_time)', $params['day']);
    }

    if (!empty($params['year']) && !empty($params['month'])) {
      $this->db->where('YEAR(ft.logout_time)', $params['year']);
      $this->db->where('MONTH(ft.logout_time)', $params['month']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(ft.logout_time)', $params['year']);
    }

    $this->db->where('ft.logout_time IS NOT NULL');
    $this->db->where('DAYOFWEEK(ft.logout_time) = (shift_timing.day + 1)');
    $this->db->where('TIME(ft.logout_time) < SUBTIME(shift_timing.logout_time, "00:15:00")');
    $this->db->where('shift_timing.is_working_day', 1);

    $query = $this->db->get();
    return $query->result();
  }


  public function get_incomplete_logouts($params = array())
  {
    $this->db->select('ue.*');
    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
    $this->db->join('shift_timing as st', 'ue.user_employee_id = st.user_employee_id');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("BINARY ue.user_employee_custom_id", $params['user_employee_custom_id']); // Ensure case sensitivity
    }

    if (!empty($params['attendance_record_status'])) {
      $this->db->where("ft.status", $params['attendance_record_status']);
    }

    if (!empty($params['last_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
    }

    if (!empty($params['last_month'])) {
      $this->db->where('MONTH(ft.login_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
      $this->db->where('YEAR(ft.login_time) = YEAR(CURDATE())');
    }

    if (!empty($params['last_year'])) {
      $this->db->where('YEAR(ft.login_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
    }

    if (!empty($params['date_in_ymd'])) {
      $this->db->where('DATE(ft.login_time)', $params['date_in_ymd']);
    }

    if (!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
      $this->db->where('DAY(ft.login_time)', $params['day']);
    }

    if (!empty($params['year']) && !empty($params['month'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
    }

    // Check for empty logout_time
    $this->db->where('ft.logout_time IS NULL');
    $this->db->group_by('ue.user_employee_id');

    $query = $this->db->get();
    $results = $query->result();

    // Loop through results to fetch attendance data
    foreach ($results as $result) {
      $this->db->select('*');
      $this->db->from('attendance');
      $this->db->where('user_employee_id', $result->user_employee_id);
      $this->db->where('logout_time IS NULL');

      if (!empty($params['last_day'])) {
        $this->db->where('DATE(login_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
      }
      if (!empty($params['last_month'])) {
        $this->db->where('MONTH(login_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
        $this->db->where('YEAR(login_time) = YEAR(CURDATE())');
      }
      if (!empty($params['last_year'])) {
        $this->db->where('YEAR(login_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
      }
      if (!empty($params['date_in_ymd'])) {
        $this->db->where('DATE(login_time)', $params['date_in_ymd']);
      }
      if (!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
        $this->db->where('YEAR(login_time)', $params['year']);
        $this->db->where('MONTH(login_time)', $params['month']);
        $this->db->where('DAY(login_time)', $params['day']);
      }
      if (!empty($params['year']) && !empty($params['month'])) {
        $this->db->where('YEAR(login_time)', $params['year']);
        $this->db->where('MONTH(login_time)', $params['month']);
      }
      if (!empty($params['year'])) {
        $this->db->where('YEAR(login_time)', $params['year']);
      }

      $attendance_query = $this->db->get();
      $result->attendance_data = $attendance_query->result();
    }

    return $results;
  }

  public function get_missed_logouts($params = array())
  {

    if (!empty($params['search_for'])) {
      $this->db->select("count(ft.attendance_id) as counts");
    } else {

      $this->db->select('ft.*, ue.user_employee_id,ue.name,ue.profile_image,ue.contactno,ue.personal_email,ue.user_employee_custom_id');

    }
    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');
    $this->db->join('shift_timing', 'ue.user_employee_id = shift_timing.user_employee_id');

    $this->db->where('ft.login_time IS NOT NULL');
    $this->db->where('ft.logout_time IS NULL');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("ue.user_employee_custom_id", $params['user_employee_custom_id']);
    }

    if (!empty($params['attendance_record_status'])) {
      $this->db->where("ft.status", $params['attendance_record_status']);
    }

    if (!empty($params['current_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE(CURDATE())');
    }

    if (!empty($params['last_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
    }

    if (!empty($params['last_month'])) {
      $this->db->where('MONTH(ft.login_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
      $this->db->where('YEAR(ft.login_time) = YEAR(CURDATE())');
    }

    if (!empty($params['last_year'])) {
      $this->db->where('YEAR(ft.login_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
    }

    if (!empty($params['date_in_ymd'])) {
      $this->db->where('DATE(ft.login_time)', $params['date_in_ymd']);
    }

    if (!empty($params['year']) && !empty($params['month'] && !empty($params['day']))) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
      $this->db->where('DAY(ft.login_time)', $params['day']);
    }



    if (!empty($params['year']) && !empty($params['month'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
    }

    $this->db->where('DAYOFWEEK(ft.login_time) = (shift_timing.day+1)');
    // $this->db->where('shift_timing.is_working_day', 1);

    $query = $this->db->get();
    // return $query->result();
    $results = $query->result();



    return $results;
  }

  public function get_incomplete_logouts_only_count($params = array())
  {
    $this->db->select('COUNT(*) as count');
    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("BINARY ue.user_employee_custom_id", $params['user_employee_custom_id']); // Ensure case sensitivity
    }

    if (!empty($params['attendance_record_status'])) {
      $this->db->where("ft.status", $params['attendance_record_status']);
    }

    if (!empty($params['last_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
    }

    if (!empty($params['last_month'])) {
      $this->db->where('MONTH(ft.login_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
      $this->db->where('YEAR(ft.login_time) = YEAR(CURDATE())');
    }

    if (!empty($params['last_year'])) {
      $this->db->where('YEAR(ft.login_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
    }

    if (!empty($params['date_in_ymd'])) {
      $this->db->where('DATE(ft.login_time)', $params['date_in_ymd']);
    }

    if (!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
      $this->db->where('DAY(ft.login_time)', $params['day']);
    }

    if (!empty($params['year']) && !empty($params['month'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
    }

    // Check for empty logout_time
    $this->db->where('ft.logout_time IS NULL');

    $query = $this->db->get();
    return $query->result();
  }






  public function get_employees_absent_on_date($params = array())
  {
    $day_number_from_0 = date('w', strtotime($params['date_dash_ymd']));


    // Step 1: Get all employees who had a working day on the specified date

    $this->db->select('ue.*');


    $this->db->from('user_employee as ue');
    $this->db->join('shift_timing as st', 'ue.user_employee_id = st.user_employee_id');
    $this->db->where('st.is_working_day', 1);
    $this->db->where('st.day', $day_number_from_0); // DAYOFWEEK returns 1 for Sunday, so subtract 1 for consistency
    $working_day_employees = $this->db->get()->result();

    // Step 2: Get all employees who logged in on the specified date
    $this->db->select('ft.user_employee_id');
    $this->db->from('attendance as ft');
    $this->db->where('DATE(ft.login_time)', $params['date_dash_ymd']);
    $logged_in_employees = $this->db->get()->result_array();



    // Extract user_employee_id of logged in employees
    $logged_in_employee_ids = array_column($logged_in_employees, 'user_employee_id');


    // Step 3: Filter out employees who did not log in on the specified date
    $absent_employees = array_filter($working_day_employees, function ($employee) use ($logged_in_employee_ids) {
      return !in_array($employee->user_employee_id, $logged_in_employee_ids);
    });

    return $absent_employees;
  }

  // public function get_employees_absent_on_date($params = array())
  // {
  //   $day_number_from_0 = date('w', strtotime($params['date_dash_ymd']));

  //   // Step 1: Get all employees who had a working day on the specified date
  //   if (!empty($params['search_for'])) {
  //     $this->db->select("count(ue.user_employee_id) as counts");
  //   } else {
  //     $this->db->select('ue.*');
  //   }

  //   $this->db->from('user_employee as ue');
  //   $this->db->join('shift_timing as st', 'ue.user_employee_id = st.user_employee_id');
  //   $this->db->where('st.is_working_day', 1);
  //   $this->db->where('st.day', $day_number_from_0); // DAYOFWEEK returns 1 for Sunday, so subtract 1 for consistency
  //   $query = $this->db->get();

  //   if (!empty($params['search_for'])) {
  //     $result = $query->row();
  //     return $result->counts; // Return the count if we're only looking for the count
  //   } else {
  //     $working_day_employees = $query->result();
  //   }

  //   // Step 2: Get all employees who logged in on the specified date
  //   $this->db->select('ft.user_employee_id');
  //   $this->db->from('attendance as ft');
  //   $this->db->where('DATE(ft.login_time)', $params['date_dash_ymd']);
  //   $logged_in_employees = $this->db->get()->result_array();

  //   // Extract user_employee_id of logged in employees
  //   $logged_in_employee_ids = array_column($logged_in_employees, 'user_employee_id');

  //   // Step 3: Filter out employees who did not log in on the specified date
  //   $absent_employees = array_filter($working_day_employees, function ($employee) use ($logged_in_employee_ids) {
  //     return !in_array($employee->user_employee_id, $logged_in_employee_ids);
  //   });

  //   return $absent_employees;
  // }

  public function get_missed_attendance_only_count($params = array())
  {
    $this->db->select('COUNT(*) as count');
    $this->db->from('attendance as ft');
    $this->db->join('user_employee as ue', 'ft.user_employee_id = ue.user_employee_id');

    if (!empty($params['user_employee_id'])) {
      $this->db->where("ft.user_employee_id", $params['user_employee_id']);
    }

    if (!empty($params['user_employee_record_status'])) {
      $this->db->where("ue.status", $params['user_employee_record_status']);
    }

    if (!empty($params['user_employee_custom_id'])) {
      $this->db->where("BINARY ue.user_employee_custom_id", $params['user_employee_custom_id']); // Ensure case sensitivity
    }

    if (!empty($params['attendance_record_status'])) {
      $this->db->where("ft.status", $params['attendance_record_status']);
    }

    if (!empty($params['last_day'])) {
      $this->db->where('DATE(ft.login_time) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)');
    }

    if (!empty($params['last_month'])) {
      $this->db->where('MONTH(ft.login_time) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))');
      $this->db->where('YEAR(ft.login_time) = YEAR(CURDATE())');
    }

    if (!empty($params['last_year'])) {
      $this->db->where('YEAR(ft.login_time) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 YEAR))');
    }

    if (!empty($params['date_in_ymd'])) {
      $this->db->where('DATE(ft.login_time)', $params['date_in_ymd']);
    }

    if (!empty($params['year']) && !empty($params['month']) && !empty($params['day'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
      $this->db->where('DAY(ft.login_time)', $params['day']);
    }

    if (!empty($params['year']) && !empty($params['month'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
      $this->db->where('MONTH(ft.login_time)', $params['month']);
    }

    if (!empty($params['year'])) {
      $this->db->where('YEAR(ft.login_time)', $params['year']);
    }

    // Check for empty logout_time
    $this->db->where('ft.logout_time IS NULL');

    $query = $this->db->get();
    return $query->result();
  }



}

?>