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
						<h3 class="box-title"><?php if (isset($academicoptns)) {
													echo 'Edit Transport Fee';
												} else {
													echo 'Add Transport Fee';
												} ?></h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->

					<?php echo $this->Flash->render(); ?>
					<?php echo $this->Form->create($transportfees, array(

						'class' => 'form-horizontal',
						'id' => 'sevice_form',
						'enctype' => 'multipart/form-data',
						'validate'
					)); ?>

					<div class="box-body">

						<div class="form-group">
							<input type="hidden" name="location_name" id="location_name">
							<div class="col-sm-3">
								<label>Select Student</label>
								<?php echo $this->Form->input('student_id', array('class' => 'form-control', 'required', 'empty' => 'Select Student', 'options' => $studentlist, 'value' => $soptns, 'label' => false)); ?>
							</div>
							<div class="col-sm-3">
								<label>Select Location</label>
								<?php echo $this->Form->input('loc_id', array('class' => 'form-control', 'required', 'empty' => 'Select Location', 'options' => $locations, 'value' => $loptns, 'label' => false)); ?>
							</div>

							<div class="col-sm-3">
								<label>Select Bus</label>
								<?php echo $this->Form->input('bus_id', array('class' => 'form-control', 'required', 'empty' => '---Select Bus---', 'options' => $route, 'label' => false)); ?>
							</div>

							<div class="col-sm-3">
								<label>Academic Year </label>
								<select class="form-control" name="academic_year" id="session" required="required">
									<option value="">--- Select Acedamic Year ---</option>
									<option value="<?php echo $previous_year; ?>" <?= $previous_year == $academicoptns ? ' selected="selected"' : ''; ?>><?php echo $previous_year; ?></option>
									<option value="<?php echo $currentyear; ?>" <?= $currentyear == $academicoptns ? ' selected="selected"' : ''; ?> <?= empty($academicoptns) ? ' selected="selected"' : ''; ?>><?php echo $currentyear; ?></option>
									<option value="<?php echo $nextyear; ?>" <?= $nextyear == $academicoptns ? ' selected="selected"' : ''; ?>><?php echo $nextyear; ?></option>
								</select>
							</div>

						</div>
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th class="text-center bg-teal color-palette"> Fee</th>
									<th class="text-center bg-teal color-palette">1st Quater</th>
									<th class="text-center bg-teal color-palette">2nd Quater</th>
									<th class="text-center bg-teal color-palette">3rd Quater</th>
									<th class="text-center bg-teal color-palette">4th Quater</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="text-center text-bold">
										Transport Fee
									</td>

									<td><?php echo $this->Form->input('qu1_fees', array('id' => 'trans_fees1', 'required' => 'required', 'label' => false)); ?></td>
									<td><?php echo $this->Form->input('qu2_fees', array('id' => 'trans_fees2', 'required' => 'required', 'label' => false)); ?></td>
									<td><?php echo $this->Form->input('qu3_fees', array('id' => 'trans_fees3', 'required' => 'required', 'label' => false)); ?></td>
									<td><?php echo $this->Form->input('qu4_fees', array('id' => 'trans_fees4', 'required' => 'required', 'label' => false)); ?></td>
								</tr>
								<tr>

									<td class="text-center text-bold">Last Submission Date</td>
									<td><?php echo $this->Form->input('qu1_date', array('id' => 'fee_date1', 'required' => 'required', 'label' => false, 'disabled' => 'disabled')); ?>
									</td>
									<td><?php echo $this->Form->input('qu2_date', array('id' => 'fee_date2', 'required' => 'required', 'label' => false, 'disabled' => 'disabled')); ?>
									</td>
									<td><?php echo $this->Form->input('qu3_date', array('id' => 'fee_date3', 'required' => 'required', 'label' => false, 'disabled' => 'disabled')); ?>
									</td>
									<td><?php echo $this->Form->input('qu4_date', array('id' => 'fee_date4', 'required' => 'required', 'label' => false, 'disabled' => 'disabled')); ?>
									</td>

								</tr>
							</tbody>
						</table>

					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<?php
						if (isset($academicoptns)) {
							echo $this->Form->submit(
								'Update',
								array('class' => 'btn btn-info pull-right', 'title' => 'Update')
							);
						} else {
							echo $this->Form->submit(
								'Submit',
								array('class' => 'btn btn-info pull-right', 'title' => 'Submit')
							);
						}
						?> <?php
							echo $this->Html->link('Back', [
								'action' => 'studentlist'
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
			'minDate': '0',
			"changeMonth": true,
			"changeYear": true,
			"dateFormat": "yy-mm-dd"
		});
		$('#fee_date2').datepicker({
			'minDate': '0',
			"changeMonth": true,
			"changeYear": true,
			"dateFormat": "yy-mm-dd"
		});
		$('#fee_date3').datepicker({
			'minDate': '0',
			"changeMonth": true,
			"changeYear": true,
			"dateFormat": "yy-mm-dd"
		});
		$('#fee_date4').datepicker({
			'minDate': '0',
			"changeMonth": true,
			"changeYear": true,
			"dateFormat": "yy-mm-dd"
		});

	});
</script>

<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script>
	$(document).ready(function() {
		$('#loc-id').on('change', function() {
			var id = $('#loc-id').val();
			var session = $('#session').val();

			// find all location 
			$.ajax({
				type: 'POST',
				url: '<?php echo ADMIN_URL; ?>transportfees/find_bus',
				data: {
					'id': id
				},
				success: function(data) {
					$('#bus-id').empty();
					$('#bus-id').html(data);
				}

			});
			// end 

			// find location wise fee 
			$.ajax({
				type: 'POST',
				url: '<?php echo ADMIN_URL; ?>transportfees/find_fees',
				data: {
					'id': id,
					'session': session
				},
				success: function(data) {
					var alldata = JSON.parse(data);

					// console.log(alldata);
					// for fees 
					var trans_fees1 = document.getElementById('trans_fees1');
					var trans_fees2 = document.getElementById('trans_fees2');
					var trans_fees3 = document.getElementById('trans_fees3');
					var trans_fees4 = document.getElementById('trans_fees4');
					$('#trans_fees1').empty();
					trans_fees1.value = alldata.quarterly_fee;
					$('#trans_fees2').empty();
					trans_fees2.value = alldata.quarterly_fee;
					$('#trans_fees3').empty();
					trans_fees3.value = alldata.quarterly_fee;
					$('#trans_fees4').empty();
					trans_fees4.value = alldata.quarterly_fee;

					// for date 
					var fee_date1 = document.getElementById('fee_date1');
					var fee_date2 = document.getElementById('fee_date2');
					var fee_date3 = document.getElementById('fee_date3');
					var fee_date4 = document.getElementById('fee_date4');

					$('#fee_date1').empty();
					fee_date1.value = alldata.fee_sub_q1;
					$('#fee_date2').empty();
					fee_date2.value = alldata.fee_sub_q2;
					$('#fee_date3').empty();
					fee_date3.value = alldata.fee_sub_q3;
					$('#fee_date4').empty();
					fee_date4.value = alldata.fee_sub_q4;
					// $('#trans_fees').html(data);
				}
			});
			// end 
			var loc_ids = document.getElementById("loc-id");
			var locationname = document.getElementById("location_name");
			var selectedText = loc_ids.options[loc_ids.selectedIndex].text;
			$('#location_name').empty();
			locationname.value = selectedText;
		});
	});
</script>

<!-- Edit time  -->
<script>
	$(document).ready(function() {

		var id = <?php echo $loptns; ?>;
		var session = $('#session').val();
		var student_id = $('#student-id').val();
		$('#session').attr("disabled", true);

		// find all location 
		$.ajax({
			type: 'POST',
			url: '<?php echo ADMIN_URL; ?>transportfees/find_bus',
			data: {
				'id': id
			},
			success: function(data) {
				$('#bus-id').empty();
				$('#bus-id').html(data);
			}

		});
		// end 

		// find location wise fee 
		$.ajax({
			type: 'POST',
			url: '<?php echo ADMIN_URL; ?>transportfees/find_fees',
			data: {
				'id': id,
				'session': session,
				'student_id': student_id

			},
			success: function(data) {

				var alldata = JSON.parse(data);
				// for fees 
				var trans_fees1 = document.getElementById('trans_fees1');
				var trans_fees2 = document.getElementById('trans_fees2');
				var trans_fees3 = document.getElementById('trans_fees3');
				var trans_fees4 = document.getElementById('trans_fees4');
				$('#trans_fees1').empty();
				$('#trans_fees1').attr("disabled", true);
				$('#trans_fees2').attr("disabled", true);
				$('#trans_fees3').attr("disabled", true);
				$('#trans_fees4').attr("disabled", true);
				trans_fees1.value = alldata.qu1_fees;
				$('#trans_fees2').empty();
				trans_fees2.value = alldata.qu2_fees;
				$('#trans_fees3').empty();
				trans_fees3.value = alldata.qu3_fees;
				$('#trans_fees4').empty();
				trans_fees4.value = alldata.qu4_fees;

				// for date 
				var fee_date1 = document.getElementById('fee_date1');
				var fee_date2 = document.getElementById('fee_date2');
				var fee_date3 = document.getElementById('fee_date3');
				var fee_date4 = document.getElementById('fee_date4');

				$('#fee_date1').empty();
				fee_date1.value = alldata.qu1_date;
				$('#fee_date2').empty();
				fee_date2.value = alldata.qu2_date;
				$('#fee_date3').empty();
				fee_date3.value = alldata.qu3_date;
				$('#fee_date4').empty();
				fee_date4.value = alldata.qu4_date;
				$('#bus-id').val(alldata.bus_number);
			}

		});
		// end 
		var loc_ids = document.getElementById("loc-id");
		var locationname = document.getElementById("location_name");
		var selectedText = loc_ids.options[loc_ids.selectedIndex].text;
		$('#location_name').empty();
		locationname.value = selectedText;

	});
</script>