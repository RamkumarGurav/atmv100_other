<?php
$page_module_name = "User Employee";
?>
<?php
$name = $contactno = $alt_contactno = $personal_email = $company_email = $pan_number = $aadhar_number = $address = $pincode = $profile_image = $user_employee_custom_id = $birthday = $joining_date = "";
$user_employee_id = 0;
$branch_id = 0;
$designation_id = 0;
$department_id = 0;
$marital_status = "";
$marriage_anniversary = "";
$country_id = 0;
$state_id = 0;
$city_id = 0;
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


$shift_timing = [
	(object) ["day" => 0, "login_time" => "", "logout_time" => "", "is_working_day" => 0],
	(object) ["day" => 1, "login_time" => "", "logout_time" => "", "is_working_day" => 1],
	(object) ["day" => 2, "login_time" => "", "logout_time" => "", "is_working_day" => 1],
	(object) ["day" => 3, "login_time" => "", "logout_time" => "", "is_working_day" => 1],
	(object) ["day" => 4, "login_time" => "", "logout_time" => "", "is_working_day" => 1],
	(object) ["day" => 5, "login_time" => "", "logout_time" => "", "is_working_day" => 1],
	(object) ["day" => 6, "login_time" => "", "logout_time" => "", "is_working_day" => 0]
];




if (!empty($user_employee_data)) {

	$record_action = "Update";
	$user_employee_id = $user_employee_data->user_employee_id;
	$branch_id = $user_employee_data->branch_id;
	$designation_id = $user_employee_data->designation_id;
	$department_id = $user_employee_data->department_id;
	$name = $user_employee_data->name;
	$marital_status = $user_employee_data->marital_status;
	$marriage_anniversary = $user_employee_data->marriage_anniversary?date('d-m-Y', strtotime($user_employee_data->marriage_anniversary)):"";
	$contactno = $user_employee_data->contactno;
	$alt_contactno = $user_employee_data->alt_contactno;
	$personal_email = $user_employee_data->personal_email;
	$company_email = $user_employee_data->company_email;
	$pan_number = $user_employee_data->pan_number;
	$aadhar_number = $user_employee_data->aadhar_number;
	$birthday = date('d-m-Y', strtotime($user_employee_data->birthday));
	$joining_date = date('d-m-Y', strtotime($user_employee_data->joining_date));
	$profile_image = $user_employee_data->profile_image;
	$user_employee_custom_id = $user_employee_data->user_employee_custom_id;
	$shift_timing = $user_employee_data->shift_timing;
	$country_id = $user_employee_data->country_id;
	$state_id = $user_employee_data->state_id;
	$city_id = $user_employee_data->city_id;
	$address = $user_employee_data->address;
	$pincode = $user_employee_data->pincode;
	$status = $user_employee_data->status;
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
					<h1 class="m-0 text-dark"><?php echo $page_module_name ?> </small></h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo MAINSITE_Admin . "wam" ?>">Home</a></li>
						<li class="breadcrumb-item"><a
								href="<?php echo MAINSITE_Admin . $user_access->class_name . "/" . $user_access->function_name ?>"><?php echo $user_access->module_name ?>
								List</a></li>
						<?php if (!empty($user_employee_data)) { ?>
							<li class="breadcrumb-item"><a
									href="<?php echo MAINSITE_Admin . $user_access->class_name . "/view/" . $user_employee_id ?>">View</a>
							</li>
						<?php } ?>
						<li class="breadcrumb-item"><?php echo $record_action ?></li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<?php ?>
	<section class="content">
		<div class="row">
			<div class="col-12">

				<div class="card">

					<div class="card-header">
						<h3 class="card-title"><?php echo $name ?> <small><?php echo $record_action ?></small></h3>
					</div>
					<!-- /.card-header -->
					<?php
					if ($user_access->view_module == 1 || true) {
						?>
						<?php echo $this->session->flashdata('alert_message'); ?>
						<div class="card-body">


							<?php echo form_open(
								MAINSITE_Admin . "$user_access->class_name/doEdit",
								array(
									'method' => 'post',
									'id' => 'employee_form',
									"name" => "employee_form",
									'style' => '',
									'class' => 'form-horizontal',
									'role' => 'form',
									'onsubmit' => 'return validateForm()',
									'enctype' => 'multipart/form-data'
								)
							); ?>
							<input type="hidden" name="user_employee_id" id="user_employee_id"
								value="<?php echo $user_employee_id ?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="" />

							<div class="">

								<div class="form-group row">

								 	<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Branch <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<select type="text" class="form-control form-control-sm custom-select" required id="branch_id"
												onchange="getState(this.value ,0)" name="branch_id">
												<option value="">Select Branch</option>
												<?php foreach ($branch_data as $item) {
													$selected = "";
													if ($item->branch_id == $branch_id) {
														$selected = "selected";
													}
													?>
													<option value="<?php echo $item->branch_id ?>" <?php echo $selected ?>>
														<?php echo $item->branch_name ?>
														<?php if ($item->status != 1) {
															echo " [Block]";
														} ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Deparment <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<select type="text" class="form-control form-control-sm custom-select" required id="department_id"
												name="department_id">
												<option value="">Select Department</option>
												<?php foreach ($department_data as $item) {
													$selected = "";
													if ($item->department_id == $department_id) {
														$selected = "selected";
													}
													?>
													<option value="<?php echo $item->department_id ?>" <?php echo $selected ?>>
														<?php echo $item->department_name ?>
														<?php if ($item->status != 1) {
															echo " [Block]";
														} ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Designation <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<select type="text" class="form-control form-control-sm custom-select" required id="designation_id"
												name="designation_id">

												<option value="">Select Designation</option>
												<?php foreach ($designation_data as $item) {
													$selected = "";
													if ($item->designation_id == $designation_id) {
														$selected = "selected";
													}
													?>
													<option value="<?php echo $item->designation_id ?>" <?php echo $selected ?>>
														<?php echo $item->designation_name ?>
														<?php if ($item->status != 1) {
															echo " [Block]";
														} ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Employee ID<span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" required id="user_employee_custom_id"
												name="user_employee_custom_id" value="<?php echo $user_employee_custom_id ?>"
												placeholder="Employee ID">
										</div>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Employee Name <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12	">
											<input type="text" class="form-control form-control-sm" required id="name" name="name"
												value="<?php echo $name ?>" placeholder="Employee Name">
										</div>
									</div>


									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Employee Profile Image <span
												style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
										<div class="col-sm-12 d-flex">
											<div class="input-group" style="width:90%">
												<div class="custom-file">
													<input type="file" name="profile_image" class="custom-file-input" id="files" accept="image/*">
													<label class="custom-file-label form-control-sm" for="files"></label>
												</div>
											</div>
											<div class="custom-file-display">
												<?php if (!empty($profile_image)) { ?>
													<span class="pip">
														<a target="_blank"
															href="<?php echo _uploaded_files_ . 'user_employee/profile_image/' . $profile_image ?>">
															<img class="imageThumb"
																src="<?php echo _uploaded_files_ . 'user_employee/profile_image/' . $profile_image ?>" />
														</a>
													</span>
												<?php } else { ?>
													<span class="pip">
													<img class="imageThumb " src="<?= _uploaded_files_ ?>no-img.png" />
													</span>
												<?php } ?>
											</div>
										</div>
									</div>


								
									<div class=" col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Marital Status<span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<select type="text" class="form-control form-control-sm" required id="marital_status"
												name="marital_status">
												<option value="">Select Marital Status</option>
												<? foreach ($marital_status_data as $item) {
													$selected = "";
													if ($item->marital_status == $marital_status) {
														$selected = "selected";
													}
													?>
													<option value="<?= $item->marital_status ?>" <?= $selected ?>> <?= $item->marital_status_name ?>

													</option>
												<? } ?>
											</select>

										</div>
									</div>
								
								<?php if ($marital_status==2): ?>

		
									<div class="col-md-3 col-sm-6 sd" id="marriage_anniversary_wrapper" style="z-index:99999;">
    <label for="marriage_anniversary" id="marriage_anniversary_wrapper-label" class="py-0 px-2 col-sm-12 col-form-label-lg label_content">Marriage Anniversary
        <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span>
    </label>
		<div class="input-group date marriage_anniversary_input_container" id="marriage_anniversary_input_container"  data-target-input="nearest">
		<input type="text" required  value="<?php echo $marriage_anniversary ?>" name="marriage_anniversary" id="marriage_anniversary"
													placeholder="Marriage Anniversary" style="width: 100%;"
													class="form-control datetimepicker-input width100 form-control-sm"
													data-target="#marriage_anniversary_input_container" />
								<div class="input-group-append" data-target="#marriage_anniversary_input_container" data-toggle="datetimepicker">
                <div class="input-group-text" id="marriage_anniversary_wrapper-icon" ><i class="fa fa-calendar"></i></div>
        </div>
		</div>
							</div>
							
							
						<?php else: ?>
							<div class="col-md-3 col-sm-6" id="marriage_anniversary_wrapper" style="visibility:hidden;z-index:99999;">
    <label for="marriage_anniversary" id="marriage_anniversary_wrapper-label" class="py-0 px-2 col-sm-12 col-form-label-lg label_content">Marriage Anniversary
        <span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span>
    </label>
		<div class="input-group date marriage_anniversary_input_container" id="marriage_anniversary_input_container" style="visibility:hidden;z-index:99999;" data-target-input="nearest">
							<input type="hidden" name="marriage_anniversary" id="marriage_anniversary" value="<?= $marriage_anniversary ?>"
                placeholder="Marriage Anniversary" class="form-control datetimepicker-input width100 form-control-sm"
                data-target="#marriage_anniversary_input_container" />
								<div class="input-group-append" data-target="#marriage_anniversary_input_container" data-toggle="datetimepicker" style="visibility:hidden;z-index:99999;">
                <div class="input-group-text" id="marriage_anniversary_wrapper-icon" style="visibility:hidden;z-index:99999;"><i class="fa fa-calendar"></i></div>
        </div>
		</div>
							</div>

							
						<?php endif; ?>
						</div>
						
						<div class="form-group row">
						<div class="col-lg-3 col-md-4 col-sm-6" style="z-index:99999;">
										<label for="inputEmail3" class="py-0 px-2 col-sm-12 col-form-label-lg label_content">Employee Birthday
											<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<div class="input-group date birthday_input" id="birthday_input" data-target-input="nearest">
												<input type="text" required value="<?php echo $birthday ?>" name="birthday" id="birthday"
													placeholder="Employee Birthday" style="width: 100%;"
													class="form-control datetimepicker-input width100 form-control-sm"
													data-target="#birthday_input" />
												<div class="input-group-append" data-target="#birthday_input" data-toggle="datetimepicker">
													<div class="input-group-text"><i class="fa fa-calendar"></i></div>
												</div>

											</div>

										</div>
									</div>



									<div class="col-lg-3 col-md-4 col-sm-6">
											<label for="inputEmail3" class="py-0 px-2 col-sm-12 col-form-label-lg label_content">Joining Date
												<span style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
											<div class="col-sm-12">
												<div class="input-group date joining_date_input" id="joining_date_input"
													data-target-input="nearest">
													<input type="text" value="<?php echo $joining_date ?>" name="joining_date" id="joining_date"
														placeholder="Joining Date" style="width: 100%;"
														class="form-control datetimepicker-input width100 form-control-sm"
														data-target="#joining_date_input" />
													<div class="input-group-append" data-target="#joining_date_input" data-toggle="datetimepicker">
														<div class="input-group-text"><i class="fa fa-calendar"></i></div>
													</div>

												</div>

											</div>
										</div>

										<div class="col-md-3 col-sm-6">

											<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Employee Mobile No. <span
													style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
											<div class="col-sm-12">
												<input type="number" class="form-control form-control-sm" pattern="[0-9]{8,15}" id="contactno"
													name="contactno" value="<?php echo $contactno ?>" placeholder="Mobile No.">
											</div>
										</div>



										<div class="col-md-3 col-sm-6">

									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Employee Alt Mobile No. <span
													style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="col-sm-12">
					<input type="number" class="form-control form-control-sm" pattern="[0-9]{8,15}" id="alt_contactno"
			name="alt_contactno" value="<?php echo $alt_contactno ?>" placeholder="Alt Mobile No.">
	</div>
	</div>

						</div>


								<div class="border rounded m-2 ">
								<div for="inputEmail3" class="p-2 border  px-2 py-0 text-primary text-bold ">SHIFT TIMINGS</div>
									<div class=" row px-2 ">

										<div class="col-md-3 col-sm-6">
											<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Day<span
													style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										</div>

										<div class="col-md-3 col-sm-6 ">
											<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Is Working Day<span
													style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										</div>

										<div class="col-md-3 col-sm-6 ">
											<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Login Time<span
													style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										</div>
										<div class="col-md-3 col-sm-6 ">
											<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Logout Time<span
													style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										</div>

									</div>


									<div class="form-group row p-2">
										<?php foreach ($day_data as $item): ?>
			<div class="row col-12" id="day-row-<?= $item->day; ?>">

				<div class="col-md-3 col-sm-6">
					<div class="col-sm-12">
						<input type="hidden" name="day[]" id="day[<?php echo $item->day ?>]"
							value="<?php echo $item->day ?>" />
						<p><?= $item->day_name ?></p>
					</div>
				</div>

				<div class="col-md-3 col-sm-6">
					<div class="col-sm-12">
						<div class="form-check" style="">
							<input class="form-check-input mx-auto" style="height:20px;width:20px;" type="checkbox"
								name="is_working_day[<?php echo $item->day; ?>]" 
								<?php if ($shift_timing[$item->day]->is_working_day == 1) {
									echo "checked";
								} ?> value="1"
						
								id="checkboxWorkingDay-<?= $item->day; ?>" data-day="<?= $item->day; ?>">
						</div>
					</div>
				</div>

				<div class="col-md-3 col-sm-6 login-time-wrapper mb-1" id="login-time-wrapper-<?= $item->day; ?>">
					<div class="col-sm-12">
						<?php if ($shift_timing[$item->day]->is_working_day != 1): ?>
								<input type="hidden" class="form-control form-control-sm" id="login_time" name="login_time[]"
									value="" placeholder="Login Time">
						<?php else: ?>
								<input type="time" class="form-control form-control-sm" id="login_time" name="login_time[]"
									value="<?php echo $shift_timing[$item->day]->login_time ?>" placeholder="Login Time">
						<?php endif; ?>

					</div>
				</div>
				<div class="col-md-3 col-sm-6 login-time-wrapper " id="logout-time-wrapper-<?= $item->day; ?>">
					<div class="col-sm-12">
						<?php if ($shift_timing[$item->day]->is_working_day != 1): ?>
								<input type="hidden" class="form-control form-control-sm" id="logout_time" name="logout_time[]"
									value="" placeholder="Logout Time">
						<?php else: ?>
								<input type="time" class="form-control form-control-sm" id="logout_time" name="logout_time[]"
									value="<?php echo $shift_timing[$item->day]->logout_time ?>" placeholder="Logout Time">
						<?php endif; ?>

					</div>
				</div>

			</div>
	<?php endforeach; ?>
	</div>
	</div>
								




							

								

									<div class="form-group row">
									<div class="col-md-3 col-sm-6">
	<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Employee Email <span
			style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
	<div class="col-sm-12">
		<input type="text" class="form-control form-control-sm" id="personal_email" name="personal_email"
			value="<?php echo $personal_email ?>" placeholder="Employee Email">
	</div>
	</div>

										<div class="col-md-3 col-sm-6">
											<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Company Email <span
													style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
											<div class="col-sm-12">
												<input type="text" class="form-control form-control-sm" id="company_email" name="company_email"
													value="<?php echo $company_email ?>" placeholder="Company Email">
											</div>
										</div>


										<div class="col-md-3 col-sm-6">
											<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Aadhar Number <span
													style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
											<div class="col-sm-12	">
												<input type="text" class="form-control form-control-sm" required id="aadhar_number"
													name="aadhar_number" value="<?php echo $aadhar_number ?>" placeholder="Aadhar Number">
											</div>
										</div>





										<!-- <div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Country <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<select type="text" class="form-control form-control-sm custom-select" required id="country_id"
												onchange="getState(this.value ,0)" name="country_id">
												<option value="">Select Country</option>
												<?php foreach ($country_data as $cd) {
													$selected = "";
													if ($cd->country_id == $country_id) {
														$selected = "selected";
													}
													?>
									<option value="<?php echo $cd->country_id ?>" <?php echo $selected ?>>
										<?php echo $cd->country_name ?>
										<?php if ($cd->status != 1) {
											echo " [Block]";
										} ?>
									</option>
									<?php } ?>
									</select>
								</div>
							</div> -->

								<!-- <div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">State <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<select type="text" class="form-control form-control-sm custom-select" required id="state_id"
												name="state_id" onchange="getCity(this.value ,0)">
												<option value="">Select State</option>
											</select>
										</div>
									</div>

									<div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">City <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<select type="text" class="form-control form-control-sm custom-select" required id="city_id"
												name="city_id">
												<option value="">Select City</option>
											</select>
										</div>
									</div> -->

								<div class="col-md-3 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Pan Number <span
											style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12	">
										<input type="text" class="form-control form-control-sm" required id="pan_number" name="pan_number"
											value="<?php echo $pan_number ?>" placeholder="Pan Number">
									</div>
								</div>

								

							</div>

						


							<div class="form-group row">
							<div class="col-md-6 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Address<span
											style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-12">
										<input type="text" class="form-control form-control-sm" required id="address" name="address"
											value="<?php echo $address ?>" placeholder="Address">
									</div>
								</div>
								<!-- <div class="col-md-3 col-sm-6">
										<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Pincode <span
												style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
										<div class="col-sm-12">
											<input type="text" class="form-control form-control-sm" id="pincode" name="pincode"
												value="<?php echo $pincode ?>" placeholder="Pincode">
										</div>
									</div> -->
								<div class="col-md-6 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">Upload KYC Files <span
											style="color:#f00;font-size: 22px;margin-top: 3px;"></span></label>
									<div class="card-body py-0 px-2">
										<table class="table table-sm">
											<thead>
												<tr>
													<th>#</th>
													<th width="25%">File Title</th>
													<th>File</th>
													<th></th>
												</tr>
											</thead>
											<tbody class="RFQDetailBody_uekf">
												<? $this->load->view('admin/user_employee/User_Employee_Module/template/file_line_add_more_uekf', $this->data); ?>
											</tbody>
											<tfoot>
												<tr>
													<td colspan="9"><button type="button" onclick="addNewRFQDeatilLine_uekf(0)"
															class="btn btn-block btn-default">Add New Line</button>
													<td>
												</tr>
											</tfoot>
										</table>
										<?php if (!empty($user_employee_data->user_employee_kyc_file)) { ?>
											<div class="card-body p-0 " style="width:90% !important">
												<table class="table table-sm">
													<thead>
														<tr>
															<th colspan="2" style="padding: 10px 5px;"><a data-target="#uploadImg_uekf"
																	data-toggle="collapse" class="collapsed uploadImgClick uploadImgClick2">Uploaded Files
																	<span class="bg-primary fa fa-chevron-down"></span></a></th>
														</tr>
													</thead>
													<tbody class="collapse" id="uploadImg_uekf">
														<?php foreach ($user_employee_data->user_employee_kyc_file as $item) { ?>
															<tr id="gi<?= $item->user_employee_kyc_file_id ?>">
																<td><?= !empty($item->file_title) ? $item->file_title : "NO FILE NAME" ?></td>
																<td><span class="">
																		<a target="_blank" class="btn btn-outline-primary btn-sm"
																			href="<?= _uploaded_files_ . 'user_employee_kyc_file/' . $item->file ?>">
																			view
																		</a>
																	</span></td>
																<td><button class=" btn btn-outline-danger btn-xs"
																		onclick="return del_uekf('<?= $item->user_employee_kyc_file_id ?>')" title="remove"><i
																			class="fas fa-trash"></i></button></td>
															</tr>
														<?php } ?>
														<tr>
															<td colspan="2"></td>
														</tr>
													</tbody>
												</table>
											</div>
										<?php } ?>
									</div>
								</div>

								
							</div>
							<div class="form-group row">
							<div class="col-md-3 col-sm-6">
									<label for="radioSuccess1" class="col-sm-12 label_content px-2 py-0">Status</label>
									<div class="col-sm-12">
										<div class="form-check" style="">
											<div class="form-group clearfix">
												<div class="icheck-success d-inline">
													<input type="radio" name="status" <?php if ($status == 1) {
														echo "checked";
													} ?> value="1"
														id="radioSuccess1">
													<label for="radioSuccess1"> Active
													</label>
												</div>
												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												<div class="icheck-danger d-inline">
													<input type="radio" name="status" <?php if ($status != 1) {
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
									<div id="before_submit">
										<button type="submit" name="save" onclick=" redirect_type_func('');" value="1"
											class="btn btn-info">Save</button>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<button type="submit" name="save-add-new" onclick="redirect_type_func('save-add-new'); " value="1"
											class="btn btn-default ">Save And Add New</button>
									</div>

									<div id="after_submit" style="display:none">
										<button class="btn btn-info" type="button" disabled>
											<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											Loading...
										</button>
									</div>
								</center>

							</div>
							<!-- /.card-footer -->

							<?php echo form_close() ?>
							</table>
						</div>
					<?php } else {
						$this->data['no_access_flash_message'] = "You Dont Have Access To View " . $page_module_name;
						$this->load->view('admin/template/access_denied', $this->data);
					} ?>
					<!-- /.card-body -->
				</div>
			</div>
		</div>


	</section>
	<?php ?>
</div>

<aside class="control-sidebar control-sidebar-dark">
	<!-- Control sidebar content goes here -->
</aside>
<script>

	// Function to validate the form before submission
	function validateForm() {
		event.preventDefault(); // Prevent the form from submitting
		showFormSubmitLoading(); // Show a loading indicator
		validate_user_employee_custom_id('yes'); // Validate the company unique name, then proceed to validate email
		$(".error_span").html(""); // Clear any error messages
	}

	// Function to validate the company unique name
	function validate_user_employee_custom_id(is_submit) {
		Pace.restart(); // Restart the Pace loading animation
		var user_employee_custom_id = $('#user_employee_custom_id').val(); // Get the value of the company unique name input
		var user_employee_id = $('#user_employee_id').val(); // Get the value of the company profile ID input
		$("#user_employee_custom_id").removeClass("is-invalid"); // Remove invalid class if present
		$("#user_employee_custom_id").removeClass("is-valid"); // Remove valid class if present
		$("#user_employee_custom_id_error").html(""); // Clear any error messages

		if (user_employee_custom_id == '') { // Check if the company unique name is empty
			toastrDefaultErrorFunc("Employee Code Can Not Be Empty."); // Show error message
			hideFormSubmitLoading(); // Hide the loading indicator
			return false; // Stop further execution
		}

		// AJAX request to validate the company unique name
		$.ajax({
			url: "<?php echo MAINSITE_Admin . 'Validation/isDuplicateUserEmployeeCode' ?>", // URL to send the request to
			type: 'post', // HTTP method
			dataType: "json", // Expected data type
			data: { 'user_employee_custom_id': user_employee_custom_id, 'user_employee_id': user_employee_id, "<?php echo $csrf['name'] ?>": "<?php echo $csrf['hash'] ?>" }, // Data to send
			success: function (response) { // Function to execute on successful response
				if (response.boolean_response) { // If the unique name exists in the database
					toastrDefaultErrorFunc(response.message); // Show error message
					hideFormSubmitLoading(); // Hide the loading indicator
					$("#user_employee_custom_id").addClass("is-invalid"); // Add invalid class
					$("#user_employee_custom_id_error").html("<br>" + response.message); // Show error message
					return false; // Stop further execution
				}
				else {
					$("#user_employee_custom_id").addClass("is-valid"); // Add valid class
					if (is_submit == "yes") { validate_user_employee_custom_id(is_submit); } // If validation is successful, proceed to validate email
				}
			},
			error: function (request, error) { // Function to execute on error
				toastrDefaultErrorFunc("Unknown Error. Please Try Again"); // Show error message
			}
		});
	}


	// Function to validate the company email
	function validate_user_employee_custom_id(is_submit) {
		Pace.restart(); // Restart the Pace loading animation
		var email = $('#email').val(); // Get the value of the email input
		var user_employee_id = $('#user_employee_id').val(); // Get the value of the company profile ID input
		$("#email").removeClass("is-invalid"); // Remove invalid class if present
		$("#email").removeClass("is-valid"); // Remove valid class if present
		$("#email_error").html(""); // Clear any error messages

		if (email == '') { // Check if the email is empty
			toastrDefaultErrorFunc("Employee Code Can Not Be Empty."); // Show error message
			hideFormSubmitLoading(); // Hide the loading indicator
			return false; // Stop further execution
		}

		// AJAX request to validate the company email
		$.ajax({
			url: "<?php echo MAINSITE_Admin . 'Validation/isDuplicateCompanyEmail' ?>", // URL to send the request to
			type: 'post', // HTTP method
			dataType: "json", // Expected data type
			data: { 'email': email, 'user_employee_id': user_employee_id, "<?php echo $csrf['name'] ?>": "<?php echo $csrf['hash'] ?>" }, // Data to send
			success: function (response) { // Function to execute on successful response
				if (response.boolean_response) { // If the email exists in the database
					toastrDefaultErrorFunc(response.message); // Show error message
					$("#email").addClass("is-invalid"); // Add invalid class
					hideFormSubmitLoading(); // Hide the loading indicator
					$("#email_error").html("<br>" + response.message); // Show error message
					return false; // Stop further execution
				}
				else {
					$("#email").addClass("is-valid"); // Add valid class
					if (is_submit == "yes") { $('#employee_form').attr('onsubmit', ''); $("#employee_form").submit(); } // If validation is successful, submit the form
				}
			},
			error: function (request, error) { // Function to execute on error
				toastrDefaultErrorFunc("Unknown Error. Please Try Again"); // Show error message
			}
		});
	}


	// Function to set the redirect type
	function redirect_type_func(data) {
		document.getElementById("redirect_type").value = data; // Set the redirect type value
		return true; // Return true
	}

	// Function to get states based on the selected country
	function getState(country_id, state_id = 0) {
		$("#state_id").html(''); // Clear the state dropdown
		$("#city_id").html(''); // Clear the city dropdown
		if (country_id > 0) { // Check if a valid country is selected
			Pace.restart(); // Restart the Pace loading animation
			$.ajax({
				url: "<?php echo MAINSITE_Admin . 'Ajax/getState' ?>", // URL to send the request to
				type: 'post', // HTTP method
				dataType: "json", // Expected data type
				data: { 'country_id': country_id, 'state_id': state_id, "<?php echo $csrf['name'] ?>": "<?php echo $csrf['hash'] ?>" }, // Data to send
				success: function (response) { // Function to execute on successful response
					$("#state_id").html(response.state_html); // Populate the state dropdown with the response
				},
				error: function (request, error) { // Function to execute on error
					toastrDefaultErrorFunc("Unknown Error. Please Try Again"); // Show error message
				}
			});
		}
	}

	// Function to get cities based on the selected state
	function getCity(state_id, city_id = 0) {
		$("#city_id").html(''); // Clear the city dropdown
		if (state_id > 0) { // Check if a valid state is selected
			Pace.restart(); // Restart the Pace loading animation
			$.ajax({
				url: "<?php echo MAINSITE_Admin . 'Ajax/getCity' ?>", // URL to send the request to
				type: 'post', // HTTP method
				dataType: "json", // Expected data type
				data: { 'city_id': city_id, 'state_id': state_id, "<?php echo $csrf['name'] ?>": "<?php echo $csrf['hash'] ?>" }, // Data to send
				success: function (response) { // Function to execute on successful response
					$("#city_id").html(response.city_html); // Populate the city dropdown with the response
				},
				error: function (request, error) { // Function to execute on error
					toastrDefaultErrorFunc("Unknown Error. Please Try Again"); // Show error message
				}
			});
		}
	}




	// Event listener for when the window loads
	window.addEventListener('load', function () {

		// If country_id and state_id are not empty, get the states for the selected country
		<?php if (!empty($country_id) && !empty($state_id)) { ?>
			getState(<?php echo $country_id ?>, <?php echo $state_id ?>)
		<?php } ?>

		// If city_id and state_id are not empty, get the cities for the selected state
		<?php if (!empty($city_id) && !empty($state_id)) { ?>
			getCity(<?php echo $state_id ?>, <?php echo $city_id ?>)
		<?php } ?>



		// Check if the File API is supported by the browser
		if (window.File && window.FileList && window.FileReader) {
			$("#files").on("change", function (e) {
				var files = e.target.files, // Get the selected files
					filesLength = files.length; // Get the number of selected files

				// Loop through each selected file
				for (var i = 0; i < filesLength; i++) {
					var f = files[i]; // Get the current file
					var fileReader = new FileReader(); // Create a new FileReader object
					fileReader.onload = (function (e) {
						var file = e.target; // Get the file from the event

						// Customized code to display the image
						$(".pip").remove(); // Remove any existing .pip elements
						$(".custom-file-display").html("<span class=\"pip\">" + // Insert the new image inside .custom-file-display element
							"<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "</span>");
					});
					fileReader.readAsDataURL(f);//actualy this triggers the above "	fileReader.onload"  // Read the file as a data URL (base64 encoded string)
				}
			});
		} else {
			alert("Your browser doesn't support to File API"); // Alert the user if the File API is not supported
		}

		// Check if the File API is supported by the browser
		if (window.File && window.FileList && window.FileReader) {
			$("#letterhead_header_image").on("change", function (e) {
				var files = e.target.files, // Get the selected files
					filesLength = files.length; // Get the number of selected files

				// Loop through each selected file
				for (var i = 0; i < filesLength; i++) {
					var f = files[i]; // Get the current file
					var fileReader = new FileReader(); // Create a new FileReader object
					fileReader.onload = (function (e) {
						var file = e.target; // Get the file from the event

						// Customized code to display the image
						$(".pip1").remove(); // Remove any existing .pip1 elements
						$(".custom-file-display1").html("<span class=\"pip1\">" + // Insert the new image inside .custom-file-display1 element
							"<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" + "</span>");
					});
					fileReader.readAsDataURL(f);//actualy this triggers the above "	fileReader.onload"  // Read the file as a data URL (base64 encoded string)
				}
			});
		} else {
			alert("Your browser doesn't support to File API"); // Alert the user if the File API is not supported
		}



	});



	window.addEventListener('load', function () {
		<?php if (!empty($country_id) && !empty($state_id)) { ?>
			getState(<?php echo $country_id ?>, <?php echo $state_id ?>)
		<?php } ?>

		<?php if (!empty($city_id) && !empty($state_id)) { ?>
			getCity(<?php echo $state_id ?>, <?php echo $city_id ?>)
		<?php } ?>

		//setSearch();
		var dateFormat = "DD-MM-YYYY";
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
		$('#birthday_input').datetimepicker({
			format: dateFormat,
			//maxDate: dateMax,
			ignoreReadonly: true
		});
		$('#marriage_anniversary_input_container').datetimepicker({
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

	})
</script>


<script>
	/*  >>> ADDING MORE tdate TEXT*/

	var append_id_uekf = 1;

	function addNewRFQDeatilLine_uekf(id_uekf = 0) {
		append_id_uekf++;
		Pace.restart();
		$.ajax({
			url: "<?= MAINSITE_Admin . $user_access->class_name . '/addNewLine_uekf' ?>",
			type: 'post',
			dataType: "json",
			data: { 'id_uekf': id_uekf, 'append_id_uekf': append_id_uekf, "<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>" },
			success: function (response) {
				$(".RFQDetailBody_uekf").append(response.template);
				set_qe_sub_table_count_uekf();
				set_qe_sub_table_remove_btn_uekf();
				calculate_qe_sub_table_price_uekf();
				set_input_element_functions_uekf();
				// Initialize Summernote
				$('.summernote').summernote({
					<?= _summernote_ ?>
				});
			},
			error: function (request, error) {
				toastrDefaultErrorFunc("Unknown Error. Please Try Again");
			}
		});
	}



	function set_qe_sub_table_count_uekf() {
		let count_uekf = 0;
		$('.qe_sub_table_count_uekf').each(function (index, value) {
			count_uekf++;
			$(this).html(count_uekf + '.');
		});
	}

	function set_qe_sub_table_remove_btn_uekf() {
		$('.qe_sub_table_remove_td_uekf').html('');
		let count_uekf = 0;
		$('.qe_sub_table_remove_td_uekf').each(function (index, value) {
			count_uekf++;
		});
		if (count_uekf > 1) {
			$('.qe_sub_table_remove_td_uekf').html('<button class="btn btn-outline-danger btn-xs" onclick="remove_qe_sub_table_row_uekf($(this))" title="remove"><i class="fas fa-trash"></i></button>');
		}
	}

	function remove_qe_sub_table_row_uekf(row) {
		row.closest('tr').remove();
		set_qe_sub_table_remove_btn_uekf();
		set_qe_sub_table_count_uekf();
	}


	function del_uekf($uekf_id) {
		if (parseInt($uekf_id) > 0) {
			var s = confirm('You want to delete this file?');
			if (s) {
				$.ajax({
					url: "<?= MAINSITE_Admin . 'Ajax/del_any_file' ?>",
					type: 'post',
					//dataType: "json",
					data: {
						"table_name": "user_employee_kyc_file",
						"id_column": "user_employee_kyc_file_id",
						'id': $uekf_id,
						"folder_name": "user_employee_kyc_file",
						"<?= $csrf['name'] ?>": "<?= $csrf['hash'] ?>"
					},
					success: function (response) {
						toastrDefaultSuccessFunc("Record Deleted Successfully");
						window.location.reload();
						//alert(response);
						$("#quotation_enquiry_file_" + $uekf_id).hide();
					},
					error: function (request, error) {
						toastrDefaultErrorFunc("Unknown Error. Please Try Again");
					}
				});
			}
		}

		return false;
	}

	/* <<<< ADDING MORE uekf TEXT*/
</script>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		var checkboxes = document.querySelectorAll('.form-check-input');

		checkboxes.forEach(function (checkbox) {
			checkbox.addEventListener('change', function () {
				var day = this.getAttribute('data-day');
				var loginWrapper = document.getElementById('login-time-wrapper-' + day);
				var logoutWrapper = document.getElementById('logout-time-wrapper-' + day);
				var loginInput = loginWrapper.querySelector('input');
				var logoutInput = logoutWrapper.querySelector('input');

				if (this.checked) {
					loginInput.setAttribute('required', 'required');
					logoutInput.setAttribute('required', 'required');
					loginInput.type = 'time'; // Change the input type back to text (or appropriate type)
					logoutInput.type = 'time';
				} else {
					loginInput.removeAttribute('required');
					logoutInput.removeAttribute('required');
					loginInput.type = 'hidden'; // Change the input type back to text (or appropriate type)
					logoutInput.type = 'hidden';
					loginInput.value = ''; // Change the input type back to text (or appropriate type)
					logoutInput.value = '';
				}
			});
		});
	});


</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    function toggleMarriageAnniversary() {
        var maritalStatus =document.getElementById('marital_status').value;
				console.log(maritalStatus);
				var marriage_anniversary_wrapper = document.getElementById('marriage_anniversary_wrapper');
				var marriage_anniversary_wrapper_label = document.getElementById('marriage_anniversary_wrapper-label');
				var marriage_anniversary_input_container = document.getElementById('marriage_anniversary_input_container');
				var marriage_anniversary_wrapper_icon = document.getElementById('marriage_anniversary_wrapper-icon');
				var marriage_anniversary_wrapper_input = marriage_anniversary_input_container.querySelector('input');
        if (maritalStatus == 2) { // Assuming '2' is the value for married status
        	marriage_anniversary_wrapper.style.visibility="visible";
					marriage_anniversary_wrapper_label.style.visibility="visible";
					marriage_anniversary_input_container.style.visibility="visible";
					marriage_anniversary_wrapper_icon.style.visibility="visible";
						marriage_anniversary_wrapper_input.type = 'text';
        } else {
					marriage_anniversary_wrapper.style.visibility="hidden";
					marriage_anniversary_wrapper_label.style.visibility="hidden";
					marriage_anniversary_input_container.style.visibility="hidden";
					marriage_anniversary_wrapper_icon.style.visibility="hidden";
						marriage_anniversary_wrapper_input.type = 'hidden';
						marriage_anniversary_wrapper_input.value= '';
						marriage_anniversary_wrapper_input.setAttribute('required', 'required');
        }
    }

    // Initial check
    toggleMarriageAnniversary();

    // Check on change
    $("#marital_status").change(function() {
        toggleMarriageAnniversary();
    });
});
</script>