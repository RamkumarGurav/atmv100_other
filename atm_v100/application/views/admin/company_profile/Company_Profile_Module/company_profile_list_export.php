<?php


$filename = "Employee-List-" . date('d-m-Y') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");

header("Content-Type: application/vnd.ms-excel");
//print_r($customers_list);

?>

<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>Employee List</title>

</head>



<body>
	<?
	$colspan = 8;
	?>
	<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
		<thead>
			<?php if (!empty($start_date) || !empty($end_date)) { ?>
				<tr>
					<th colspan="<?php echo $colspan ?>" style="background-color:#CCC" width="*"><br />

						Search Record :
						<?php if (!empty($start_date)) {
							echo "From : " . date('d-m-Y', strtotime($start_date));
						} ?>

						<?php if (!empty($end_date)) {
							echo " &nbsp;&nbsp;&nbsp;&nbsp;	 To : " . date('d-m-Y', strtotime($end_date));
						} ?>
						<br />&nbsp;

					</th>

				</tr>
			<?php } ?>

			<tr>
				<th style="background-color:#999" width="*">Sl. No.</th>
				<th style="background-color:#999" width="*"> Company Unique Name</th>
				<th style="background-color:#999" width="*"> Company Name</th>
				<th style="background-color:#999" width="*"> Name</th>
				<th style="background-color:#999" width="*">Email Id</th>
				<th style="background-color:#999" width="*">Mobile No</th>
				<th style="background-color:#999" width="*">Alt Mobile No</th>
				<th style="background-color:#999" width="*">GST No</th>
				<th style="background-color:#999" width="*">Address 1</th>
				<th style="background-color:#999" width="*">Address 2</th>
				<th style="background-color:#999" width="*">Address 3</th>
				<th style="background-color:#999" width="*">Pincode</th>
				<th style="background-color:#999" width="*">City</th>
				<th style="background-color:#999" width="*">State</th>
				<th style="background-color:#999" width="*">Country</th>
				<th style="background-color:#999" width="*">Country Dial Code</th>
				<th style="background-color:#999" width="*">Company Logo</th>
				<th style="background-color:#999" width="*">Added On</th>
				<th style="background-color:#999" width="*">Added By</th>
				<th style="background-color:#999" width="*">Updated On</th>
				<th style="background-color:#999" width="*">Updated By</th>
				<th style="background-color:#999" width="*">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$count = 0;
			// echo "count : ".count($ptype_list)." <br>";
			if (!empty($company_profile_data)) { //print_r($ptype_list);
				foreach ($company_profile_data as $row) {
					//if($row->in_hand > 0 || $row->total_purchase > 0 || $row->total_sold > 0 || $row->total_returned > 0 || $row->to_receive > 0 )
					{
						$count++;


						?>
						<tr>
							<td width="*"><?php echo $count; ?></td>
							<td width="*"><?php echo $row->company_unique_name; ?></td>
							<td width="*"><?php echo $row->company_name; ?></td>
							<td width="*"><?php echo $row->name; ?></td>
							<td width="*"><?php echo $row->email; ?></td>
							<td width="*"><?php echo $row->mobile_no; ?></td>
							<td width="*"><?php echo $row->alt_mobile_no; ?></td>
							<td width="*"><?php echo $row->gst_no; ?></td>
							<td width="*"><?php echo $row->address1; ?></td>
							<td width="*"><?php echo $row->address2; ?></td>
							<td width="*"><?php echo $row->address3; ?></td>
							<td width="*"><?php echo $row->pincode; ?></td>
							<td width="*"><?php echo $row->city_name; ?></td>
							<td width="*"><?php echo $row->state_name; ?></td>
							<td width="*"><?php echo $row->country_name; ?></td>
							<td width="*"><?php echo $row->dial_code; ?></td>
							<td width="*"><?php if (!empty($row->logo)) { ?>
									<span class="pip">
										<a target="_blank" href="<?php echo _uploaded_files_ . 'company_profile/logo/' . $row->logo ?>">
											<?php echo _uploaded_files_ . 'company_profile/logo/' . $row->logo ?>
										</a>
									</span>
								<?php } ?>
							</td>
							<td width="*"> <?php echo date('d-m-Y h:i:s A', strtotime($row->added_on)); ?> &nbsp;</td>
							<td width="*"><?php echo $row->added_by_name; ?></td>
							<td width="*"> <?php if (!empty($row->updated_on)) {
								echo date('d-m-Y h:i:s A', strtotime($row->updated_on));
							} ?>
								&nbsp;</td>
							<td width="*"><?php if (!empty($row->updated_by_name)) {
								echo $row->updated_by_name;
							} ?></td>
							<td width="*">
								<?php if ($row->status == 1) { ?> Active
								<?php } else { ?>Block
								<?php } ?>
							</td>

						</tr>
					<?php }
				} ?>


			<?php } else { ?>
				<tr>
					<th colspan="<?php echo $colspan ?>">No records to display...</th>
				</tr>

			<?php } ?>
		</tbody>

	</table>



</body>

</html>