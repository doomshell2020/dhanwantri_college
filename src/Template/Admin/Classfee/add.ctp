<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		Course Fee Manager
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>classfee/index">Manage Course Fee</a></li>
			<li class="active">Create Course Fee</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">

			<!-- right column -->
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"><?php if (isset($classes['id'])) {
													echo 'Edit Course Fee';
												} else {
													echo 'Add Course Fee';
												} ?></h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->

					<?php echo $this->Flash->render(); ?>

					<script type="text/javascript">
						$(document).ready(function() {

							$("#board-id").change(function() {

								var selectedCountry = $("#board-id option:selected").val();

								$.ajax({
									type: 'POST',
									url: '<?php echo ADMIN_URL; ?>Classfee/find_fee',
									data: {
										'id': selectedCountry
									},
									success: function(data) {
										var res = data.split(",");
										$("#s3").val(res[0]);
										$("#s4").val(res[1]);
										$("#s7").val(res[2]);
									},
								});
							});
						});
					</script>


					<?php echo $this->Form->create($classes, array(

						'class' => 'form-horizontal',
						'id' => 'sevice_form',
						'enctype' => 'multipart/form-data',
						'validate'
					)); ?>

					<div class="box-body">

						<div class="form-group">

							<div class="col-sm-4">
								<label>Select Course</label>
								<?php if ($seletedclassid) {
									echo $this->Form->input('class_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Course', 'options' => $classlist, 'value' => $seletedclassid, 'label' => false, 'required'));
								} else {
									echo $this->Form->input('class_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Course', 'options' => $classlist, 'label' => false, 'required'));
								} ?>
							</div>


							<div class="col-sm-4">
								<label>Select Board</label>

								<select name="board_id" onchange="return board(this);" class="form-control" required="required" id="board-id">

									<option value="">Select Board</option>
									<?php foreach ($boarddata as $kr => $rt) { ?>
										<option value="<? echo $rt['id']; ?>"><? echo $rt['name']; ?></option>
									<? } ?>
								</select>
							</div>
						</div>
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th class="text-center bg-teal color-palette">Fees Heads</th>
									<th class="text-center bg-teal color-palette">1st Year</th>
									<th class="text-center bg-teal color-palette">2nd Year</th>
									<th class="text-center bg-teal color-palette">3rd Year</th>
									<th class="text-center bg-teal color-palette">4th Year</th>
								</tr>
							</thead>
							<tbody>
								<?php if (isset($feesheads) && !empty($feesheads)) {
									foreach ($feesheads as $key => $work) { //pr($work);  
								?>
										<tr>
											<td class="text-center text-bold">
												<input type="hidden" name="fee_h_id[]" value="<?php echo $work['id']; ?>"><?php echo $work['name']; ?>
											</td>
											<td class="text-center text-bold"><input type="text" id="s<?php echo $work['id']; ?>" name="qu1_fees[]" value="<? if ($work['cbse_fee'] != '') {
																																								echo $work['cbse_fee'];
																																							} else {
																																								echo "0";
																																							} ?>"></td>
											<td class="text-center text-bold"><input type="text" name="qu2_fees[]" value="0"></td>
											<td class="text-center text-bold"><input type="text" name="qu3_fees[]" value="0"></td>
											<td class="text-center text-bold"><input type="text" name="qu4_fees[]" value="0"></td>
										<?php  }   ?>

									<?php  } else {  ?>
										<tr>
											<td class="text-center text-bold" colspan="7">No Data Selected</td>
										</tr><?php } ?>
									<tr>
										<!-- <script>
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
										</script> -->

										<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
										<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



										<!-- <td class="text-center text-bold">Last Submission Date</td>
										<td class="text-center text-bold"><input type="text" name="qu1_date" id="fee_date1" required="required"></td>
										<td class="text-center text-bold"><input type="text" name="qu2_date" id="fee_date2" required="required"></td>
										<td class="text-center text-bold"><input type="text" name="qu3_date" id="fee_date3" required="required"></td>
										<td class="text-center text-bold"><input type="text" name="qu4_date" id="fee_date4" required="required"></td> -->
									</tr>

							</tbody>
						</table>

					</div>
					<!-- /.box-body -->
					<div class="box-footer">


						<?php
						if (isset($classes['id'])) {
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
						?><?php
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