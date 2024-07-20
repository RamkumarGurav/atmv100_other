<?php

$page_module_name = "User Employee";

?>
<?
$name = "";
$user_employee_id = 0;
$status = 1;
$record_action = "Add New Record";
$marital_status_data = [
    (object) ["marital_status" => 1, "marital_status_name" => "Single"],
    (object) ["marital_status" => 2, "marital_status_name" => "Married"],
];
$day_data = [
    (object) ["day" => 0, "day_name" => "Sunday"],
    (object) ["day" => 1, "day_name" => "Monday"],
    (object) ["day" => 2, "day_name" => "Tuesday"],
    (object) ["day" => 3, "day_name" => "Wednesday"],
    (object) ["day" => 4, "day_name" => "Thursday"],
    (object) ["day" => 5, "day_name" => "Friday"],
    (object) ["day" => 6, "day_name" => "Saturday"]
];

if (!empty($user_employee_data)) {
    // $record_action = "Update";
    // $user_employee_id = $user_employee_data->user_employee_id;
    // $name = $user_employee_data->name;
    // $status = $user_employee_data->status;

}






?>
<!-- /.navbar -->

<!-- Main Sidebar Container -->


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><?= $page_module_name ?> <small>Details</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= MAINSITE_Admin . "wam" ?>">Home</a></li>
                        <li class="breadcrumb-item"><a
                                href="<?= MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name ?>"><?= $user_access->module_name ?>
                                List</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <? ?>
    <section class="content">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title"><?= $user_employee_data->name ?></h3>
                        <div class="float-right">
                            <?php
                            if ($user_access->add_module == 1 && false) {
                                ?>
                                <a href="<?= MAINSITE_Admin . $user_access->class_name ?>/edit">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                                        New</button></a>
                            <? } ?>
                            <?php
                            if ($user_access->update_module == 1) {
                                ?>
                                <a
                                    href="<?= MAINSITE_Admin . $user_access->class_name ?>/edit/<?= $user_employee_data->user_employee_id ?>">
                                    <button type="button" class="btn btn-success btn-sm"><i class="fas fa-edit"></i>
                                        Update</button>
                                </a>
                            <? } ?>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <?php
                    if ($user_access->view_module == 1) {
                        ?>
                        <div class="card-body card-primary card-outline">

                            <?php echo form_open(MAINSITE_Admin . "$user_access->class_name/doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form', "name" => "ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="task" id="task" value="" />
                            <? echo $this->session->flashdata('alert_message'); ?>



                            <table id="" class="table table-bordered table-hover myviewtable responsiveTableNewDesign">
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong class="full">Data Base Id</strong>
                                            <?= $user_employee_data->user_employee_id ?>
                                        </td>

                                        <td>
                                            <strong class="full">Branch Name</strong>
                                            <?= $user_employee_data->branch_name ?>
                                        </td>

                                        <td>
                                            <strong class="full">Department Name</strong>
                                            <?= $user_employee_data->department_name ?>
                                        </td>

                                        <td>
                                            <strong class="full">Designation Name</strong>
                                            <?= $user_employee_data->designation_name ?>
                                        </td>

                                        <td>
                                            <strong class="full">Employee ID</strong>
                                            <?= $user_employee_data->user_employee_custom_id ?>
                                        </td>







                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class="full">Employee Name</strong>
                                            <?= $user_employee_data->name ?>
                                        </td>

                                        <td>
                                            <strong class="full">Profile Image</strong>
                                            <? if (!empty($user_employee_data->profile_image)) { ?>
                                                <span class="pip">
                                                    <a target="_blank"
                                                        href="<?= _uploaded_files_ . 'user_employee/profile_image/' . $user_employee_data->profile_image ?>">
                                                        <img class="imageThumb"
                                                            src="<?= _uploaded_files_ . 'user_employee/profile_image/' . $user_employee_data->profile_image ?>" />
                                                    </a>
                                                </span>
                                            <? } else { ?>
                                                <span class="pip">
                                                    <img class="imageThumb " src="<?= _uploaded_files_ ?>no-img.png" />
                                                </span>
                                            <? } ?>
                                        </td>
                                        <td>
                                            <strong class="full">Employee Birthday</strong>
                                            <?php if (!empty($user_employee_data->birthday)): ?>
                                                <?= date("d-m-Y", strtotime($user_employee_data->birthday)) ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>

                                        </td>
                                        <td>
                                            <strong class="full">Marital Status</strong>
                                            <span class=" ">
                                                <?php foreach ($marital_status_data as $item): ?>
                                                    <?php if ($user_employee_data->marital_status == $item->marital_status): ?>
                                                        <?= $item->marital_status_name ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>

                                            </span>

                                        </td>


                                        <td>
                                            <strong class="full">Marriage Anniversary</strong>
                                            <?php if (!empty($user_employee_data->marriage_anniversary)): ?>
                                                <?= date("d-m-Y", strtotime($user_employee_data->marriage_anniversary)) ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>

                                        </td>


                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <strong class="full">Shift Timings</strong>
                                            <div class="table-responsive">
                                                <table class="w-100 ">
                                                    <thead>
                                                        <tr>
                                                            <th>Day</th>
                                                            <th>Is Working Day</th>
                                                            <th>Login Time</th>
                                                            <th>Logout Time</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($day_data as $item): ?>
                                                            <tr id="day-row-<?= $item->day; ?>">
                                                                <td>

                                                                    <?= $item->day_name ?>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <p>
                                                                            <?php if ($user_employee_data->shift_timing[$item->day]->is_working_day == 1): ?>
                                                                                <i class="fas fa-check btn-success btn-sm "></i>
                                                                            <?php else: ?>
                                                                                <i class="fas fa-ban btn-danger btn-sm "></i>
                                                                            <?php endif; ?>
                                                                        </p>

                                                                    </div>
                                                                </td>
                                                                <td class="login-time-wrapper"
                                                                    id="login-time-wrapper-<?= $item->day; ?>">

                                                                    <?php if ($user_employee_data->shift_timing[$item->day]->is_working_day != 1): ?>
                                                                        --:--
                                                                    <?php else: ?>
                                                                        <div class="p-1 rounded border" style="">
                                                                            <?= (new DateTime($user_employee_data->shift_timing[$item->day]->login_time))->format('h:i A'); ?>
                                                                            &nbsp;&nbsp;
                                                                            <i class="fas fa-clock btn- btn-sm "></i>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </td>
                                                                <td class="login-time-wrapper"
                                                                    id="logout-time-wrapper-<?= $item->day; ?>">
                                                                    <?php if ($user_employee_data->shift_timing[$item->day]->is_working_day != 1): ?>
                                                                        --:--
                                                                    <?php else: ?>
                                                                        <div class="p-1 rounded border" style="">
                                                                            <?= (new DateTime($user_employee_data->shift_timing[$item->day]->logout_time))->format('h:i A'); ?>
                                                                            &nbsp;&nbsp;
                                                                            <i class="fas fa-clock btn- btn-sm "></i>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class="full">Employee Joining Date</strong>
                                            <?php if (!empty($user_employee_data->joining_date)): ?>
                                                <?= date("d-m-Y", strtotime($user_employee_data->joining_date)) ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>

                                        </td>
                                        <td>
                                            <strong class="full">Employee Mobile No.</strong>
                                            <?= $user_employee_data->contactno ?>
                                        </td>
                                        <td>
                                            <strong class="full">Employee Alt Mobile No.</strong>
                                            <?= $user_employee_data->alt_contactno ?>
                                        </td>
                                        <td>
                                            <strong class="full">Employee Email</strong>
                                            <?= $user_employee_data->personal_email ?>
                                        </td>
                                        <td>
                                            <strong class="full">Company Email</strong>
                                            <?= $user_employee_data->company_email ?>
                                        </td>






                                        <!-- <td >
                                    <strong class="full">Country</strong>
                                        <?= $user_employee_data->country_name ?>
                                    </td>
                                        <td >
                                    <strong class="full">State</strong>
                                        <?= $user_employee_data->state_name ?>
                                    </td>
                                        <td >
                                    <strong class="full">City</strong>
                                        <?= $user_employee_data->city_name ?>
                                    </td>
                                    <td >
                                    <strong class="full">Pincode</strong>
                                        <?= $user_employee_data->pincode ?>
                                    </td> -->




                                    </tr>

                                    <tr>

                                        <td>
                                            <strong class="full">AADHAR Number</strong>
                                            <?= $user_employee_data->aadhar_number ?>
                                        </td>
                                        <td>
                                            <strong class="full">PAN Number</strong>
                                            <?= $user_employee_data->pan_number ?>
                                        </td>
                                        <td colspan="1">
                                            <strong class="full">Address</strong>
                                            <?= $user_employee_data->address ?>
                                        </td>
                                        <td colspan="2">
                                            <strong class="full">Uploaded KYC files </strong>
                                            <div>
                                                <?php if (!empty($user_employee_data->user_employee_kyc_file)) { ?>
                                                    <ol type="1" class="list-styled">
                                                        <?php foreach ($user_employee_data->user_employee_kyc_file as $item) { ?>
                                                            <li class="mb-1">
                                                                <span><?= !empty($item->file_title) ? $item->file_title : "NO FILE NAME" ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span
                                                                    class="">
                                                                    <a target="_blank" class="btn btn-outline-primary btn-sm"
                                                                        href="<?= _uploaded_files_ . 'user_employee_kyc_file/' . $item->file ?>">
                                                                        view
                                                                    </a>
                                                                </span>
                                                            </li>
                                                        <?php } ?>
                                                    </ol>
                                                <?php } else { ?>
                                                    <p>-</p>
                                                <?php } ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class="full">Added On</strong>
                                            <?= date("d-m-Y h:i:s A", strtotime($user_employee_data->added_on)) ?>
                                        </td>
                                        <td>
                                            <strong class="full">Added By</strong>
                                            <?= $user_employee_data->added_by_name ?>
                                        </td>
                                        <td>
                                            <strong class="full">Updated On</strong>
                                            <? if (!empty($user_employee_data->updated_on)) {
                                                echo date("d-m-Y h:i:s A", strtotime($user_employee_data->updated_on));
                                            } else {
                                                echo "-";
                                            } ?>
                                        </td>
                                        <td>
                                            <strong class="full">Updated By</strong>
                                            <? if (!empty($user_employee_data->updated_by_name)) {
                                                echo $user_employee_data->updated_by_name;
                                            } else {
                                                echo "-";
                                            } ?>
                                        </td>
                                        <td>
                                            <strong class="full">Status</strong>
                                            <? if ($user_employee_data->status == 1) { ?> Active <i
                                                    class="fas fa-check btn-success btn-sm "></i>
                                            <? } else { ?> Block <i class="fas fa-ban btn-danger btn-sm "></i>
                                            <? } ?></
     td>
                                    </tr>

                                </tbody>
                            </table>
                            <?php echo form_close() ?>
                        </div>
                    <? } else {
                        $this->data['no_access_flash_message'] = "You Dont Have Access To View " . $page_module_name;
                        $this->load->view('admin/template/access_denied', $this->data);
                    } ?>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>


    </section>
    <? ?>
</div>

<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>

<script type="application/javascript">
    function check_uncheck_All_records() // done
    {
        var mainCheckBoxObj = document.getElementById("main_check");
        var checkBoxObj = document.getElementsByName("sel_recds[]");

        for (var i = 0; i < checkBoxObj.length; i++) {
            if (mainCheckBoxObj.checked)
                checkBoxObj[i].checked = true;
            else
                checkBoxObj[i].checked = false;
        }
    }

    function validateCheckedRecordsArray() // done
    {
        var checkBoxObj = document.getElementsByName("sel_recds[]");
        var count = true;

        for (var i = 0; i < checkBoxObj.length; i++) {
            if (checkBoxObj[i].checked) {
                count = false;
                break;
            }
        }

        return count;
    }

    function validateRecordsActivate() // done
    {
        if (validateCheckedRecordsArray()) {
            //alert("Please select any record to activate.");
            toastrDefaultErrorFunc("Please select any record to activate.");
            document.getElementById("sel_recds1").focus();
            return false;
        } else {
            document.ptype_list_form.task.value = 'active';
            document.ptype_list_form.submit();
        }
    }

    function validateRecordsBlock() // done
    {
        if (validateCheckedRecordsArray()) {
            //alert("Please select any record to block.");
            toastrDefaultErrorFunc("Please select any record to block.");
            document.getElementById("sel_recds1").focus();
            return false;
        } else {
            document.ptype_list_form.task.value = 'block';
            document.ptype_list_form.submit();
        }
    }

</script>