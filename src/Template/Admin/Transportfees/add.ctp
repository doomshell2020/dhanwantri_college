<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Transport Fee Manager
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">

			<!-- right column -->
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"><?php if (isset($transportfees['id'])) {	echo 'Edit Transport Fee';	} else {echo 'Add Transport Fee';	} ?></h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->

					<?php echo $this->Flash->render(); ?>

					<?php echo $this->Form->create($datass, array(

						'class' => 'form-horizontal',
						'id' => 'sevice_form',
						'enctype' => 'multipart/form-data',
						'validate'
					)); ?>

					<div class="box-body">

						<div class="form-group">
					
							<div class="col-sm-4">
								<label>Acedamic Year </label>
								<select class="form-control" name="academic_year" required="required">
									<option value="">--- Select Acedamic Year ---</option>
									<?= $year = date("Y");
									$year2 = $year - 1;
									$exyear = $year + 3; ?>

									<?php for ($i = $year; $i <= $exyear; $i++) :  $rt = $i + 1;
										$rt = substr($rt, 2);
										$st = $i . '-' . $rt ?>
										<option <?php if ($i == $year) { ?>selected <?php } ?> value="<?php echo $i; ?>-<?php echo  $rt; ?>" <?php if ($st == $transportfees['academic_year']) {	echo "selected";} ?>><?php echo $i; ?>-<?php echo  $rt; ?></option>
									<?php endfor; ?>
								</select>
							</div>

						</div>
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th class="text-center bg-teal color-palette"> Locations</th>
									<th class="text-center bg-teal color-palette">Quater(I)</th>
									<th class="text-center bg-teal color-palette">Quater(II)</th>
									<th class="text-center bg-teal color-palette">Quater(III)</th>
									<th class="text-center bg-teal color-palette">Quater(IV)</th>

								</tr>
							</thead>
							<tbody>

								<?php
								foreach ($locations as $key => $value) { ?>
									
									<tr>
										<td class="text-center text-bold">
										<a class = 'label label-success'><?php echo $value['name']; ?></a>
										</td>

										<td class="text-center">
											<input type="number" name="loc_id[<? echo $value['id']; ?>][q1]" value="<?php if ($value['transportfee']['quarter1'] != 0) {echo $value['transportfee']['quarter1'];} ?>" required="required" placeholder="Enter Quaterly Amount">
										</td>

										<td class="text-center"><input type="number" name="loc_id[<? echo $value['id']; ?>][q2]" value="<?php if ($value['transportfee']['quarter2'] != 0) {echo $value['transportfee']['quarter2'];} ?>" required="required" placeholder="Enter Quaterly Amount"></td>

										<td class="text-center"><input type="number" name="loc_id[<? echo $value['id']; ?>][q3]" value="<?php if ($value['transportfee']['quarter3'] != 0) {echo $value['transportfee']['quarter3'];} ?>" required="required" placeholder="Enter Quaterly Amount"></td>

										<td class="text-center"><input type="number" name="loc_id[<? echo $value['id']; ?>][q4]" value="<?php if ($value['transportfee']['quarter4'] != 0) {echo $value['transportfee']['quarter4'];} ?>" required="required" placeholder="Enter Quaterly Amount"></td>
										
									</tr>
									
								<?php } ?>
								
								 <tr>
									<td class="text-center text-bold"><a class = 'label label-success'>Last Submission Date</a></td>
									<td class="text-center"><input type="text" value="<?php echo date('Y-m-d',strtotime($fee_sub_q1)); ?>" name="fee_sub_dateq1" id="fee_date1" required="required" placeholder="Select Last Date"></td>

									<td class="text-center"><input type="text" value="<?php echo date('Y-m-d',strtotime($fee_sub_q2)); ?>" name="fee_sub_dateq2" id="fee_date2" required="required" placeholder="Select Last Date"></td>

									<td class="text-center"><input type="text" value="<?php echo date('Y-m-d',strtotime($fee_sub_q3)); ?>" name="fee_sub_dateq3" id="fee_date3" required="required" placeholder="Select Last Date"></td>

									<td class="text-center"><input type="text" value="<?php echo date('Y-m-d',strtotime($fee_sub_q4)); ?>" name="fee_sub_dateq4" id="fee_date4" required="required" placeholder="Select Last Date"></td>
								</tr> 
								
							
							</tbody>
						</table>

					</div>
					<!-- /.box-body -->
					<div class="box-footer">

						<?php
						if (isset($transportfees['id'])) {
							echo $this->Form->submit(
								'Update',
								array('class' => 'btn btn-info pull-right', 'title' => 'Update')
							);
						} else {
							echo $this->Form->submit(
								'Add',
								array('class' => 'btn btn-info pull-right', 'title' => 'Add')
							);
						}
						?> <?php
							echo $this->Html->link('Back', [
								'action' => 'index'

							], ['class' => 'btn btn-default']); ?>
					</div>
					<!-- /.box-footer -->
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
		<!--/.col (right) -->
</div>
<!-- /.row -->
</section>
<!-- /.content -->
</div>

<script>
	$(document).ready(function() {

		$('#fee_date1').datepicker({
			'minDate': new Date(2022, 01 - 1, 25),
			"changeMonth": true,
			"changeYear": true,
			"dateFormat": "yy-mm-dd"
		});
		$('#fee_date2').datepicker({
			'minDate': new Date(2022, 01 - 1, 25),
			"changeMonth": true,
			"changeYear": true,
			"dateFormat": "yy-mm-dd"
		});
		$('#fee_date3').datepicker({
			'minDate': new Date(2022, 01 - 1, 25),
			"changeMonth": true,
			"changeYear": true,
			"dateFormat": "yy-mm-dd"
		});
		$('#fee_date4').datepicker({
			'minDate': new Date(2022, 01 - 1, 25),
			"changeMonth": true,
			"changeYear": true,
			"dateFormat": "yy-mm-dd"
		});

	});
</script>

<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>