<?php
$session = $this->request->session();
?>

<div class="box-body"><a id="" style="margin-right: 20px; margin-top: 10px;" class="btn btn-info btn-sm pull-right" href="<?php echo ADMIN_URL; ?>ReturnRenewBooks/depositreport_excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a></div>
<table id="" class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>S.No</th>
			<th>Acc. No.</th>
			<th>Book Name</th>
			<th>ISBN No.</th>
			<th>Holder Name</th>
			<th>Class - Section</th>
			<th>Holder Type</th>
			<th>Issue Date</th>
			<th>Due Date</th>
			<th>Deposite Date</th>
			<th>Status</th>

		</tr>
	</thead>
	<tbody>

		<?php

		$page = $this->request->params['paging']['books']['page'];
		$limit = $this->request->params['paging']['books']['perPage'];
		$counter = ($page * $limit) - $limit + 1;

		if (isset($books) && !empty($books)) {
			foreach ($books as $work) { 
				$dffg = $this->Comman->findstudentname1($work['holder_id'], $work['board']);
				$cls = $dffg['class']['title'] . ' - ' . $dffg['section']['title'];
				$d1 = $this->Time->format($work['issue_date'], 'dd-MM-Y');
				$d2 = $this->Time->format($work['due_date'], 'dd-MM-Y');
				$d3 = $this->Time->format($work['dep_date'], 'dd-MM-Y');
		      ?>
				<tr>
					<td><?php echo $counter; ?></td>

					<td><?php if (isset($work['asn_no'])) {
							echo $work['asn_no'];
						} else {
							echo 'N/A';
						} ?></td>
					<td><?php if (isset($work['name'])) {
							echo ucfirst($work['name']);
						} else {
							echo 'N/A';
						} ?></td>

					<td><?php if (isset($work['ISBN_NO'])) {
							echo ucfirst($work['ISBN_NO']);
						} else {
							echo 'N/A';
						} ?></td>

					<td><?php if (isset($work['holder_id'])) {
							if ($work['holder_type_id'] != 'Employee') {
								$stu = $this->Comman->findstudentname1($work['holder_id'], $work['board']);
								if ($stu) {
									echo $stu['enroll'] . '-' . $stu['fname'] . ' ' . $stu['middlename'] . ' ' . $stu['lname'];
								} else {
									echo ucfirst($work['holder_name']);
								}
							} else {
								echo ucfirst($work['holder_name']);
							}
						} else {
							echo 'N/A';
						} ?></td>
					<td><?php if (isset($cls)) {
							echo ucfirst($cls);
						} else {
							echo 'N/A';
						} ?></td>
					<td><?php if (isset($work['holder_type_id'])) {
							echo ucfirst($work['holder_type_id']);
						} else {
							echo 'N/A';
						} ?></td>

					<td><?php if (!empty($d1)) {
							echo $d1;
						} else {
							echo "N/A";
						} ?></td>
					<td><?php if (!empty($d2)) {
							echo $d2;
						} else {
							echo "N/A";
						} ?></td>
					<?php if (!empty($d3)) { ?>
						<td><?php if (!empty($d3)) {
								echo $d3;
							} else {
								echo "N/A";
							} ?></td>
					<?php } else { ?>
						<td><?php echo "-"; ?></td>
					<?php } ?>
					<?php if ($work['status'] == 'Y') { ?>
						<td style="color:red">Issued</td>
					<?php } else { ?>
						<td style="color:green">Deposited</td>
					<?php } ?>


				</tr>
			<?php $counter++;
			}
		} else { ?>
			<tr>
				<td colspan="10" style="text-align:center;">NO Data Available</td>
			</tr>
		<?php } ?>

	</tbody>

</table>