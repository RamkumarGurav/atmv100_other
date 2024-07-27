<?php
$page_module_name = "Attendance";
?>
<?
$attendance_id = 0;
$user_employee_custom_id = "";
$login_time = "";
$logout_time = "";
$attendance_login_image = "";
$attendance_logout_image = "";
$total_time = "";
$status = 1;
$record_action = "Add New Record";
if (!empty($attendance_data)) {
	$record_action = "Update";
	$attendance_id = $attendance_data->attendance_id;
	$login_time = $attendance_data->login_time ? $attendance_data->login_time : "";
	$logout_time = $attendance_data->logout_time ? $attendance_data->logout_time : "";
	$attendance_login_image = $attendance_data->attendance_login_image;
	$attendance_logout_image = $attendance_data->attendance_logout_image;
	$total_time = $attendance_data->total_time;
	$status = $attendance_data->status;
	if (!empty($user_employee_data)) {
		$user_employee_custom_id = $user_employee_data->user_employee_custom_id;
	}

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
					<h1 class="m-0 text-dark"><?= $page_module_name ?> </small></h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= MAINSITE_Admin . "wam" ?>">Home</a></li>
						<li class="breadcrumb-item"><a
								href="<?= MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name ?>"><?= $user_access->module_name ?>
								List</a></li>
						<? if (!empty($attendance_data)) { ?>
							<li class="breadcrumb-item"><a
									href="<?= MAINSITE_Admin . $user_access->class_name . "/attendance_view/" . $attendance_id ?>">View</a>
							</li>
						<? } ?>
						<li class="breadcrumb-item"><?= $record_action ?></li>
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
						<h3 class="card-title">Attendance
						</h3>
					</div>
					<!-- /.card-header -->
					<?php
					if ($user_access->view_module == 1 || true) {
						?>
						<? echo $this->session->flashdata('alert_message'); ?>
						<div class="card-body">

							<?php echo form_open(MAINSITE_Admin . "$user_access->class_name/attendance-doEdit", array('method' => 'post', 'id' => 'ptype_list_form', "name" => "ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
							<input type="hidden" name="attendance_id" id="attendance_id" value="<?= $attendance_id ?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="" />

							<div class="row">
								<div class="col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Employee ID<span
											style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
										<input <?= $record_action == "Update" ? "readonly" : "" ?> type="text"
											class="form-control form-control-sm" required id="user_employee_custom_id"
											name="user_employee_custom_id" value="<?php echo $user_employee_custom_id ?>" required
											placeholder="Employee ID">
									</div>
								</div>
								<div class="col-md-4 col-sm-6">
									<label for="location" class="col-sm-12 label_content px-2 py-0">Login Time <span
											style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>

									<div class="col-sm-12">
										<input type="datetime-local" class="form-control form-control-sm" required id="login_time"
											name="login_time" value="<?php echo $login_time ?>" required placeholder="Login Time">
									</div>
								</div>
								<!-- <div class="col-md-4 col-sm-6">
									<label for="location" class="col-sm-12 label_content px-2 py-0">Login Time <span
											style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="input-group date joining_date_input" id="joining_date_input" data-target-input="nearest">
										<input type="text" readonly="readonly" name="login_time" id="login_time" placeholder="Login Time"
											style="width: 100%;" class="form-control datetimepicker-input width100 form-control-sm"
											data-target="#joining_date_input" required value="<?= $login_time ?>" />
										<div class="input-group-append" data-target="#joining_date_input" data-toggle="datetimepicker">
											<div class="input-group-text"><i class="fa fa-calendar"></i></div>
										</div>
									</div>
								</div> -->
								<div class="col-md-4 col-sm-6">
									<label for="location" class="col-sm-12 label_content px-2 py-0">Login Image <span
											style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>

									<div class="col-sm-12 d-flex">
										<!-- <div class="input-group" style="width:90%">
											<div class="custom-file">
												<input type="file" name="attendance_login_image" accept="image/*" class="custom-file-input"
													id="attendance_login_image">
												<label class="custom-file-label form-control-sm" for="attendance_login_image"></label>

											</div>

										</div> -->
										<div class="custom-file-display custom-file-display0">
											<? if (!empty($attendance_login_image)) { ?>
												<span class="pip pip0">
													<a target="_blank"
														href="<?= _uploaded_files_ . 'attendance_login_image/' . $attendance_data->attendance_login_image ?>">
														<img class="imageThumb imageThumb0"
															src="<?= _uploaded_files_ . 'attendance_login_image/' . $attendance_data->attendance_login_image ?>" />
													</a>
												</span>
											<? } else { ?>
												<span class="pip pip0">
													<img class="imageThumb imageThumb0" src="<?= _uploaded_files_ ?>no-img.png" />
												</span>
											<? } ?>
										</div>
									</div>
								</div>





							</div>

							<div class="row form-group">
								<div class="col-md-4 col-sm-6">
									<label for="location" class="col-sm-12 label_content px-2 py-0">Logout Time <span
											style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>

									<div class="col-sm-12">
										<input type="datetime-local" class="form-control form-control-sm" id="logout_time" name="logout_time"
											value="<?php echo $logout_time ?>" placeholder="Logout Time">
									</div>
								</div>


								<!-- <div class="col-md-4 col-sm-6">
									<label for="location" class="col-sm-12 label_content px-2 py-0">Logout Image <span
											style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="col-sm-12 d-flex">
										<div class="input-group" style="width:90%">
											<div class="custom-file">
												<input type="file" name="attendance_logout_image" accept="image/*" class="custom-file-input"
													id="attendance_logout_image">
												<label class="custom-file-label form-control-sm" for="attendance_logout_image"></label>

											</div>

										</div>
										<div class="custom-file-display custom-file-display1">
											<? if (!empty($attendance_logout_image)) { ?>
												<span class="pip pip1">
													<a target="_blank"
														href="<?= _uploaded_files_ . 'attendance_logout_image/' . $attendance_data->attendance_logout_image ?>">
														<img class="imageThumb imageThumb1"
															src="<?= _uploaded_files_ . 'attendance_logout_image/' . $attendance_data->attendance_logout_image ?>" />
													</a>
												</span>
											<? } else { ?>
												<span class="pip pip1">
													<img class="imageThumb imageThumb1" src="<?= _uploaded_files_ ?>no-img.png" />
												</span>
											<? } ?>
										</div>

									</div>
								</div> -->
								<div class="col-lg-4 col-md-4 col-sm-6">
									<label for="radioSuccess1" class="col-sm-12 label_content px-2 py-0">Status</label>
									<div class="col-sm-10">
										<div class="form-check" style="">
											<div class="form-group clearfix">
												<div class="icheck-success d-inline">
													<input type="radio" name="status" <? if ($status == 1) {
														echo "checked";
													} ?> value="1"
														id="radioSuccess1">
													<label for="radioSuccess1"> Active
													</label>
												</div>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<div class="icheck-danger d-inline">
													<input type="radio" name="status" <? if ($status != 1) {
														echo "checked";
													} ?> value="0"
														id="radioSuccess2">
													<label for="radioSuccess2"> Block
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /.card-body -->
							<div class="card-footer">
								<center>
									<button type="submit" name="save" onclick="return redirect_type_func('')" value="1"
										class="btn btn-info">Save</button>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<button type="submit" name="save-add-new" onclick="return redirect_type_func('save-add-new')" value="1"
										class="btn btn-default ">Save And Add New</button>
								</center>
							</div>
							<!-- /.card-footer -->

							<?php echo form_close() ?>
							</table>
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
<script>
	function redirect_type_func(data) {
		document.getElementById("redirect_type").value = data;
		return true;
	}
</script>
<!-- <script>
	window.addEventListener('load', function () {
		//setSearch();
		var dateFormat = "MM/DD/YYYY h:mm A";
		var CurrDate = new Date();
		var MinDate = new Date();
		var MaxDate = new Date();

		dateCurr = moment(CurrDate, dateFormat);
		dateMin = moment(MinDate, dateFormat);
		dateMax = moment(MaxDate, dateFormat);
		$('#joining_date_input').datetimepicker({
			format: dateFormat,
			//maxDate: dateMax,
			ignoreReadonly: true
		});

		$('#termination_date_input').datetimepicker({
			format: dateFormat,
			//maxDate: dateMax,
			timepicker: false,
			ignoreReadonly: true
		});
		<?php if (!empty($termination_date)) { ?>
			$('#termination_date_input').val('');
		<?php } ?>
	});

</script> -->
<script>




	window.addEventListener('load', function () {
		if (window.File && window.FileList && window.FileReader) {
			$("#attendance_login_image").on("change", function (e) {
				var files = e.target.files,
					filesLength = files.length;
				for (var i = 0; i < filesLength; i++) {
					var f = files[i]
					var fileReader = new FileReader();
					fileReader.onload = (function (e) {
						var file = e.target;
						//customized code 
						$(".pip0").remove();
						$(".custom-file-display0").html("<span class=\"pip pip0\">" +
							"<img class=\"imageThumb imageThumb0\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "</span>");
					});
					fileReader.readAsDataURL(f);
				}
			});
		} else {
			alert("Your browser doesn't support to File API")
		}

	});


	window.addEventListener('load', function () {
		if (window.File && window.FileList && window.FileReader) {
			$("#attendance_logout_image").on("change", function (e) {
				var files = e.target.files,
					filesLength = files.length;
				for (var i = 0; i < filesLength; i++) {
					var f = files[i]
					var fileReader = new FileReader();
					fileReader.onload = (function (e) {
						var file = e.target;
						//customized code 
						$(".pip1").remove();
						$(".custom-file-display1").html("<span class=\"pip pip1\">" +
							"<img  class=\"imageThumb imageThumb1\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "</span>");
					});
					fileReader.readAsDataURL(f);
				}
			});
		} else {
			alert("Your browser doesn't support to File API")
		}

	});




</script>