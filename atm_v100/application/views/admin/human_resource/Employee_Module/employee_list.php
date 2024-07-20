<?php 

$page_module_name = "Employee";

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
                    <h1 class="m-0 text-dark"><?php  echo $page_module_name?> <small>List</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php  echo MAINSITE_Admin."wam"?>">Home</a></li>
                        <li class="breadcrumb-item active"><?php  echo $page_module_name?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <?php   ?>
    <section class="content">
        <div class="row">
            <div class="col-12">
			    <div id="accordion">
                  <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                  <div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="" aria-expanded="false">
                          Search Panel
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" style="">
                      <div class="card-body">
					  
                      <?php  echo form_open(MAINSITE_Admin."$user_access->class_name/$user_access->function_name", array('method' => 'post', 'id' => 'search_report_form' , "name"=>"search_report_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>

					  <div class="card-body">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
								<label>Field</label>
								<select name="field_name" id="field_name" class="form-control" style="width: 100%;">
									<!-- <option value=''>Select Field</option> -->
									<option value='aau.name' <?php  if($field_name=='aau.name'){echo 'selected';} ?>>Employee Name</option>
									<option value='aau.email' <?php  if($field_name=='aau.email'){echo 'selected';} ?>>Email</option>
									<option value='aau.mobile_no' <?php  if($field_name=='aau.mobile_no'){echo 'selected';} ?>>Mobile No.</option>
									<option value='aau.fax_no' <?php  if($field_name=='aau.fax_no'){echo 'selected';} ?>>Fax No.</option>
								</select>
								
								</div>
							</div>
							<!-- /.col -->
							<div class="col-md-3">
								<div class="form-group">
								<label>Field Value</label>
								<input type="text" name="field_value" id="field_value" placeholder="Field Value" style="width: 100%;" class="form-control" value="<?php  echo $field_value?>"  >
								</div>
							</div>
                            
                            <div class="col-md-3">
								<div class="form-group">
									<label>User Role</label>
									<select type="text" class="form-control" id="user_role_id" name="user_role_id" style="width: 100%;">
										<option value="">Select Role</option>
										<?php  foreach($users_role_data as $urd){
											$selected="";
											if($urd->user_role_id == $user_role_id){$selected = "selected";}
											?>
											<option value="<?php  echo $urd->user_role_id?>" <?php  echo $selected?>><?php  echo $urd->user_role_name?>
											<?php  if($urd->status!=1){echo " [Block]";} ?>
											</option>
										<?php  } ?>
									</select>
									
								</div>
							</div>
							<!-- /.col -->
							<div class="col-md-3">
								<div class="form-group">
									<label>Designation</label>
									<select type="text" class="form-control" id="designation_id" name="designation_id" style="width: 100%;" >
										<option value="">Select Designation</option>
										<?php  foreach($designation_data as $d){
											$selected="";
											if($d->designation_id == $designation_id){$selected = "selected";}
											?>
											<option value="<?php  echo $d->designation_id?>" <?php  echo $selected?>><?php  echo $d->designation_name?>
											<?php  if($d->status!=1){echo " [Block]";} ?>
											</option>
										<?php  } ?>
									</select>
									
								</div>
							</div>
                            
						</div>

						
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Country</label>
									<select type="text" class="form-control"  id="country_id" name="country_id" onchange="getState(this.value ,0)" style="width: 100%;">
										<option value="">Select Country</option>
										<?php  foreach($country_data as $cd){
											$selected="";
											if($cd->country_id == $country_id){$selected = "selected";}
											?>
											<option value="<?php  echo $cd->country_id?>" <?php  echo $selected?>><?php  echo $cd->country_name?>
											<?php  if($cd->status!=1){echo " [Block]";} ?>
											</option>
										<?php  } ?>
									</select>
									
								</div>
							</div>
							<!-- /.col -->
							<div class="col-md-3">
								<div class="form-group">
									<label>State</label>
									<select type="text" class="form-control"  id="state_id" name="state_id" style="width: 100%;" onchange="getCity(this.value ,0)">
										<option value="">Select State</option>
									</select>
									
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>City</label>
									<select type="text" class="form-control"  id="city_id" name="city_id" style="width: 100%;">
										<option value="">Select City</option>
									</select>
									
								</div>
							</div>
                            
                            <div class="col-md-3">
								<div class="form-group">
									<label>Status</label>
									<select name="record_status" id="record_status" class="form-control" style="width: 100%;">
										<option value='' >Active / Block</option>
										<option value='1' <?php  if($record_status==1){echo 'selected';} ?>>Active</option>
										<option value='zero' <?php  if($record_status=='zero'){echo 'selected';} ?>>Block</option>
									</select>
									
								</>
							</div>
							<!-- /.col -->
							<div class="col-md-6">
								
							</div>
						</div>
                            
						</div>
					
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								<label>Start Date</label>
								<div class="input-group date reservationdate" id="reservationdate" data-target-input="nearest">
									<input type="text" value="<?php  echo $start_date?>" name="start_date" id="start_date" placeholder="Start Date" style="width: 100%;"  class="form-control datetimepicker-input" data-target="#reservationdate"/>
									<div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
								
								</div>
							</div>
							<!-- /.col -->
							<div class="col-md-6">
								<div class="form-group">
								<label>End Date</label>
								<div class="input-group date reservationdate1" id="reservationdate1" data-target-input="nearest">
									<input type="text" value="<?php  echo $end_date?>" name="end_date" id="end_date" placeholder="End Date" style="width: 100%;"  class="form-control datetimepicker-input" data-target="#reservationdate1"/>
									<div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
										<div class="input-group-text"><i class="fa fa-calendar"></i></div>
									</div>
								</div>
								
								</div>
							</div>
						</div>

                                <div class="panel-footer">
                                        <center>
                                            <button type="submit" class="btn btn-info" id="search_report_btn" name="search_report_btn" value="1">Search</button>
                                            &nbsp;&nbsp;<button type="reset" class="btn btn-default">Reset</button>
                                        </center>
                                </div>
                                 </form>
                      </div>
                      <?php  echo form_close() ?>
                    </div>
                  </div>
                  
                </div>
              
                <div class="card">

                    <div class="card-header">
                        <h3 class="card-title"><span style="color:#FF0000;">Total Records: <?php  echo $row_count; ?></span></h3>
                        <div class="float-right">
                            <?php  
									if($user_access->add_module==1)	{
								?>
								<a href="<?php  echo MAINSITE_Admin.$user_access->class_name?>/employee-edit"> 
                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add
                                New</button></a>
                            <?php  } ?>
                            <?php  
							if($user_access->update_module==1)	{
							?>
                            <button type="button" class="btn btn-success btn-sm" onclick="validateRecordsActivate()"><i
                                    class="fas fa-check"></i> Active</button>
                            <button type="button" class="btn btn-dark btn-sm" onclick="validateRecordsBlock()"><i
                                    class="fas fa-ban"></i> Block</button>
							<?php  } ?>
							<?php  
							if($user_access->export_data==1)	{
							?>
                            <button type="button" class="btn btn-success btn-sm export_excel" ><i
                                    class="fas fa-file-excel"></i> Export</button>
                            <?php  } ?>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <?php  
						if($user_access->view_module==1)	{
					?>
                    <div class="card-body">
                        
                            <?php  echo form_open(MAINSITE_Admin."$user_access->class_name/userEmployee-doUpdateStatus", array('method' => 'post', 'id' => 'ptype_list_form' , "name"=>"ptype_list_form", 'style' => '', 'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data')); ?>
                            <input type="hidden" name="task" id="task" value="" />
                            <?php  echo $this->session->flashdata('alert_message'); ?>
                            <table id="example1" class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <?php  if($user_access->update_module==1)	{ ?>
                                        <th width="4%"><input type="checkbox" name="main_check" id="main_check"
                                                onclick="check_uncheck_All_records()" value="" /></th>
                                        <?php  } ?>
                                        <th>Employee Name</th>
                                        <th>Role</th>
                                        <th>Designation</th>
                                        <th>Contact</th>
                                        <th>Added On</th>
                                        <th>Added By</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <?php  if(!empty($employee_data)){ ?>
                                <tbody>
									<?php  
									$offset_val = (int)$this->uri->segment(5);
										
									$count=$offset_val;
										
										foreach($employee_data as $urm) { 
											$count++;
											?>
                                    <tr>
                                        <td><?php  echo $count?>.</td>
                                        <?php  if($user_access->update_module==1)	{ ?>
                                        <td><input type="checkbox" name="sel_recds[]"
                                                id="sel_recds<?php  echo $count; ?>"
                                                value="<?php  echo $urm->admin_user_id; ?>" /></td>
                                        <?php  } ?>
										<td><a href="<?php  echo MAINSITE_Admin.$user_access->class_name."/employee-view/".$urm->admin_user_id?>"><?php  echo $urm->name	?></a></td>
                                        <td>
										<?php 
										if(!empty($urm->roles))
										{
											if(count($urm->roles)>1)
											{
												//echo "<ol>";
												foreach($urm->roles as $r)
												{
													echo '<p>'.$r->user_role_name.'</p>';
												}
												//echo "</ol>";
											}
											else
											{
												echo $urm->roles[0]->user_role_name;
											}
										}
										?>
										<?php  //=$urm->user_role_name?>
                                        
                                        </td>
                                        <td><?php  echo $urm->designation_name?></td>
                                        <td><?php  echo $urm->email?><br> <?php  echo $urm->mobile_no?></td>
                                        <td><?php  echo date("d-m-Y" , strtotime($urm->added_on))?></td>
                                        <td><?php  echo $urm->added_by_name?></td>
                                        <td>
                                            <?php  if($urm->status==1){ ?> <i class="fas fa-check btn-success btn-sm "></i>
                                                <?php }else{ ?><i class="fas fa-ban btn-danger btn-sm "></i>
                                                <?php  }?>
                                        </td>
                                    </tr>
                                    <?php  } ?>
                                </tbody>
                                <?php  } ?>
						</table>
						</form>
						<center><div class="pagination_custum"><?php  echo $this->pagination->create_links(); ?></div></center>
                    </div>
                    <?php  }else{ 
						$this->data['no_access_flash_message']="You Dont Have Access To View ".$page_module_name;
						$this->load->view('admin/template/access_denied' , $this->data); 
					} ?>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>


    </section>
    <?php   ?>
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

<script>

	function getState(country_id , state_id=0)
	{
		$('#loader1').show();
		$("#state_id").html( '' );
		$("#city_id").html( '' );
		if(country_id > 0)
		{
			Pace.restart();
			$.ajax({
				url: "<?php  echo MAINSITE_Admin.'Ajax/getState'?>",
				type: 'post',
				dataType: "json",
				data: {	'country_id' : country_id , 'state_id' : state_id , "<?php  echo $csrf['name']?>":"<?php  echo $csrf['hash']?>"  },
				success: function( response ) {
					$("#state_id").html( response.state_html );
				},
				error: function (request, error) {
					toastrDefaultErrorFunc("Unknown Error. Please Try Again");
					$("#quick_view_model").html( 'Unknown Error. Please Try Again' );
				}
			});
		}
		
	}

	function getCity(state_id , city_id=0)
	{
		$("#city_id").html( '' );
		if(state_id > 0)
		{
			Pace.restart();
			$.ajax({
				url: "<?php  echo MAINSITE_Admin.'Ajax/getCity'?>",
				type: 'post',
				dataType: "json",
				data: {	'city_id' : city_id , 'state_id' : state_id  , "<?php  echo $csrf['name']?>":"<?php  echo $csrf['hash']?>" },
				success: function( response ) {
					$("#city_id").html( response.city_html );
				},
				error: function (request, error) {
					toastrDefaultErrorFunc("Unknown Error. Please Try Again");
				}
			});
		}	
	}

window.addEventListener('load' , function(){

	$( ".paginationClass" ).click(function() {
		// console.log($(this).data('ci-pagination-page'));
		// console.log($(this));
		// console.log($(this).attr('href'));//alert();
		//alert(this.data('ci-pagination-page'));
		$('#search_report_form').attr('action', $(this).attr('href'));
		$('#search_report_form').submit();
		return false ;
	});
	$('#reservationdate').datetimepicker({
        format: 'DD-MM-YYYY'
	});
	$('#reservationdate1').datetimepicker({
        format: 'DD-MM-YYYY'
	});
	
	$(".export_excel").bind("click" , function(){
			
		$('#search_report_form').attr('action', '<?php  echo MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name."-export"; ?>');
		$('#search_report_form').attr('target', '_blank');
		$('#search_report_btn').click();
		
		$('#search_report_form').attr('action', '<?php  echo MAINSITE_Admin.$user_access->class_name."/".$user_access->function_name; ?>');
		$('#search_report_form').attr('target', '');
	})
	
<?php  if(!empty($country_id) && !empty($state_id)){ ?>
	getState(<?php  echo $country_id?> , <?php  echo $state_id?>)
<?php  } ?>

<?php  if(!empty($city_id) && !empty($state_id)){ ?>
	getCity(<?php  echo $city_id?> , <?php  echo $state_id?>)	
<?php  } ?>
	
})

</script>
