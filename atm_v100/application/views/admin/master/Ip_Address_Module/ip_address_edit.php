<?php
$page_module_name = "IP Address";
?>
<?php
$ip_address = "";
$ip_address_id = 0;
$status = 1;
$record_action = "Add New Record";
if (!empty($ip_address_data)) {
	$record_action = "Update";
	$ip_address_id = $ip_address_data->ip_address_id;
	$ip_address = $ip_address_data->ip_address;
	$status = $ip_address_data->status;

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
						<?php if (!empty($ip_address_data)) { ?>
							<li class="breadcrumb-item"><a
									href="<?= MAINSITE_Admin . $user_access->class_name . "/ip_address_view/" . $ip_address_id ?>">View</a>
							</li>
						<?php } ?>
						<li class="breadcrumb-item"><?= $record_action ?></li>
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
						<h3 class="card-title"><?= $ip_address ?> <small><?= $record_action ?></small></h3>
					</div>
					<!-- /.card-header -->
					<?php
					if ($user_access->view_module == 1 || true) {
						?>
						<?php echo $this->session->flashdata('alert_message'); ?>
						<div class="card-body">

							<?php echo form_open(MAINSITE_Admin . "$user_access->class_name/ip-address-doEdit", array('method' => 'post', 'id' => 'ptype_list_form', "name" => "ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
							<input type="hidden" name="ip_address_id" id="ip_address_id" value="<?= $ip_address_id ?>" />
							<input type="hidden" name="redirect_type" id="redirect_type" value="" />

							<div class="row">
								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="inputEmail3" class="col-sm-12 label_content px-2 py-0">IP Address<span
											style="color:#f00;font-size: 22px;margin-top: 3px;">*</span></label>
									<div class="col-sm-10">
										<input type="text" class="form-control form-control-sm" required id="ip_address" name="ip_address"
											value="<?= $ip_address ?>" placeholder="IP Address">

									</div>
								</div>



								<div class="col-lg-3 col-md-4 col-sm-6">
									<label for="radioSuccess1" class="col-sm-12 label_content px-2 py-0">Status</label>
									<div class="col-sm-10">
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
	function redirect_type_func(data) {
		document.getElementById("redirect_type").value = data;
		return true;
	}
</script>