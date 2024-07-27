<?php

$page_module_name = "Attendance";

?>
<?
$attendance_id = "";
$status = 1;
$record_action = "Add New Record";
if (!empty($attendance_data)) {
    // $record_action = "Update";
    // $branch_id = $attendance_data->branch_id;
    // $branch_name = $attendance_data->branch_name;
    // $status = $attendance_data->status;

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
                        <h3 class="card-title">
                            Employee Attendance
                        </h3>
                        <div class="float-right">
                            <?php
                            if ($user_access->add_module == 1 && false) {
                                ?>
                                <a href="<?= MAINSITE_Admin . $user_access->class_name ?>/attendance-edit">
                                    <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                                        New</button></a>
                            <? } ?>
                            <?php
                            if ($user_access->update_module == 1) {
                                ?>
                                <a
                                    href="<?= MAINSITE_Admin . $user_access->class_name ?>/attendance-edit/<?= $attendance_data->attendance_id ?>">
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
                        <div class="card-body">

                            <?php echo form_open(MAINSITE_Admin . "$user_access->class_name/attendance-doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form', "name" => "ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="task" id="task" value="" />
                            <? echo $this->session->flashdata('alert_message'); ?>
                            <table id="" class="table table-bordered table-hover myviewtable responsiveTableNewDesign">
                                <tbody>
                                    <tr>
                                        <td>
                                            <strong class="full">Data Base Id</strong>
                                            <?= $attendance_data->attendance_id ?>
                                        </td>
                                        <td>
                                            <strong class="full">Attendace Day</strong>
                                            <?php if (!empty($attendance_data->added_on)): ?>
                                                <?= (new DateTime($attendance_data->added_on))->format("\A\\t h:i A \O\\n d-F-Y"); ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <strong class="full">Employee Id</strong>
                                            <?= $attendance_data->user_employee_custom_id ?>
                                        </td>

                                        <td>
                                            <strong class="full">Employee Name</strong>
                                            <u><a class="text-bold text-dark "
                                                    href="<?= MAINSITE_Admin . "user_employee/User-Employee-Module/view/" . $attendance_data->user_employee_id ?>"><?= $attendance_data->name ?></a></u>


                                        </td>
                                        <td>
                                            <strong class="full">Employee Contact No.</strong>
                                            <?= $attendance_data->contactno ?>
                                        </td>











                                    </tr>
                                    <tr>
                                        <td>
                                            <strong class="full">Logged-in Time </strong>
                                            <?php if (!empty($attendance_data->login_time)): ?>
                                                <?= (new DateTime($attendance_data->login_time))->format("\A\\t h:i A \O\\n d-F-Y"); ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <strong class="full">Logged-in Image</strong>
                                            <? if (!empty($attendance_data->attendance_login_image)) { ?>
                                                <span class="pip">
                                                    <a target="_blank"
                                                        href="<?= _uploaded_files_ . 'attendance_login_image/' . $attendance_data->attendance_login_image ?>">
                                                        <img class="imageThumb"
                                                            src="<?= _uploaded_files_ . 'attendance_login_image/' . $attendance_data->attendance_login_image ?>" />
                                                    </a>
                                                </span>
                                            <? } else { ?>
                                                <span class="pip">
                                                    <img class="imageThumb " src="<?= _uploaded_files_ ?>no-img.png" />
                                                </span>
                                            <? } ?>
                                        </td>

                                        <td>
                                            <strong class="full">Logged-out Time </strong>
                                            <?php if (!empty($attendance_data->logout_time)): ?>
                                                <?= (new DateTime($attendance_data->logout_time))->format("\A\\t h:i A \O\\n d-F-Y"); ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <strong class="full">Logged-out Image</strong>
                                            <? if (!empty($attendance_data->attendance_logout_image)) { ?>
                                                <span class="pip">
                                                    <a target="_blank"
                                                        href="<?= _uploaded_files_ . 'attendance_logout_image/' . $attendance_data->attendance_logout_image ?>">
                                                        <img class="imageThumb"
                                                            src="<?= _uploaded_files_ . 'attendance_logout_image/' . $attendance_data->attendance_logout_image ?>" />
                                                    </a>
                                                </span>
                                            <? } else { ?>
                                                <span class="pip">
                                                    <img class="imageThumb " src="<?= _uploaded_files_ ?>no-img.png" />
                                                </span>
                                            <? } ?>
                                        </td>
                                        <td>
                                            <strong class="full">Total working time </strong>
                                            <?php if (!empty($attendance_data->total_time)): ?>
                                                <?php

                                                list($hours, $minutes, $seconds) = explode(':', $attendance_data->total_time);

                                                // Format the time
                                                $formatted_time = "{$hours}hr:{$minutes}min:{$seconds}sec";

                                                echo $formatted_time; // Output: 09hr:30min:20sec
                                                ?>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>

                                    </tr>




                                    <tr>
                                        <td>
                                            <strong class="full">Added On</strong>
                                            <?= date("d-m-Y h:i:s A", strtotime($attendance_data->added_on)) ?>
                                        </td>
                                        <td>
                                            <strong class="full">Added By</strong>
                                            <?= $attendance_data->added_by_name ?>
                                        </td>
                                        <td>
                                            <strong class="full">Updated On</strong>
                                            <? if (!empty($attendance_data->updated_on)) {
                                                echo date("d-m-Y h:i:s A", strtotime($attendance_data->updated_on));
                                            } else {
                                                echo "-";
                                            } ?>
                                        </td>
                                        <td>
                                            <strong class="full">Updated By</strong>
                                            <? if (!empty($attendance_data->updated_by_name)) {
                                                echo $attendance_data->updated_by_name;
                                            } else {
                                                echo "-";
                                            } ?>
                                        </td>
                                        <td>
                                            <strong class="full">Status</strong>
                                            <? if ($attendance_data->status == 1) { ?> Active <i
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