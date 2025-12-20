<!-- Content Wrapper. Contains page content -->
<script type="text/javascript">
	$(function() {
		$('.check-all').click(function() {
			if (this.checked) {
				$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', true);
				$(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
				$(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);
			} else {
				$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', false);
				$(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
				$(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
			}
		});

		window.check = function(id) {
			var ck = 'chk' + id;
			var chkbox = document.getElementById(ck);
			if (chkbox.checked) {
				document.getElementById(id).disabled = true;
				document.getElementById(id).required = false;
				document.getElementById(id).value = '';
			} else {
				document.getElementById(id).disabled = false;
				document.getElementById(id).required = true;
			}

			if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
				$('.check-all').prop('checked', true);
			} else {
				$('.check-all').prop('checked', false);
			}
		};


	});
</script>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<?php //pr($selectdadte);die;?>
	<section class="content-header">
		<h1>
			Take Student Attendance <?php if(!empty($selectdadte)){echo date_format($selectdadte,'d/m/Y');}else{echo date('d-m-Y');} ?>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>Studattends/attendence">Manage Student Attendance</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">


		<?php if ($classtitle) { ?>

			<div class="row">
				<?php echo $this->Flash->render(); ?>

				<!-- right column -->
				<div class="col-md-12">
					<!-- Horizontal Form -->
					<div class="box box-info">
						<div class="box-header with-border">

							<span class="text-muted" style="padding-left: 10px; font-size: 15px;">

								<strong>Class Name : </strong><?php echo $classtitle; ?> | <strong>Section Name : </strong><?php echo $sectiontitle; ?> | <strong>Acedmicyear : </strong><?php echo $academics; ?> | <strong>Date : </strong><?php if(!empty($selectdadte)){echo date("d-m-Y", strtotime($selectdadte));}else{echo date('d-m-Y');} ?> </span>
						</div>
						<?php echo $this->Flash->render();   ?>
						<script>
							$(function() {
								$('#datepicks').datepicker({
									"changeMonth": true,
									'maxDate': '0',
									"yearRange": "1980:2018",
									"changeYear": true,
									"autoSize": true,
									"dateFormat": "yy-mm-dd",
									onSelect: function() {
										var selected = $(this).val();
										//$('.datepicks').val(selected);
										$('#stud-attendance-form').submit();
									}
								});
							});
						</script>

						<div class="box-body">

							<?php echo $this->Form->create('Studattends', array('url' => array('controller' => 'Studattends', 'action' => 'attendence'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'stud-attendance-form', 'class' => '')); ?>
							<div class="row">
								<div class="col-sm-4">
									<div class="form-group field-stuattendance-sa_date ">
										<!--
										<label class="control-label" for="attendence2">Date<small> (Click on particular date for see attendence)</small>*</label>
										-->
										<input type="hidden" name="class_id" class="" value="<?php echo $seletedclassid; ?>">
										<input type="hidden" name="section_id" class="" value="<?php echo $seletedsectionid; ?>">
										<input type="hidden" name="academic" class="" value="<?php echo $academics; ?>">

										<?php if ($selectdadte) { ?>
											<input type="hidden" id="datepicksf" class="form-control" name="date" required="required" value="<?php echo $selectdadte; ?>" readonly="readonly">

										<?php } else { ?>
											<input type="hidden" id="datepicksf" class="form-control" name="date" required="required" value="<?php echo date('Y-m-d'); ?>" readonly="readonly">
											<!-- <input type="date" id="datepicksf" class="form-control" name="date" required="required" value="<?php// echo date('Y-m-d'); ?>" > -->
										<?php } ?>


									</div>
								</div>
							</div> <!-- /.row -->
							</form>


							<div class="row">
								<div class="col-lg-12">
									<form id="studttendance-form" action="<?php echo SITE_URL; ?>admin/Studattends/add" method="post">
										<table class="table table-striped table-hover" id="mytable">

											<tbody>
												<tr class="table_header" style="color: green;">
													<thead>
														<th>
															<?php if (isset($attedenceall) && !empty($attedenceall)) { ?>

																<input type="checkbox" class="check-all" checked=""> For Absent

															<?php } else { ?>

																<input type="checkbox" class="check-all"> For Absent

															<?php } ?>
														</th>

														<th> Enroll No. </th>
														<th> Student Name </th>

													</thead>
												</tr>



												<?php if (isset($attedenceall) && !empty($attedenceall)) {

													foreach ($attedenceall as $work) {
														// pr($work);die;
														$getMachineStatus = $this->Comman->getMachineStatus($work['class_id'], $work['section_id'], $work['id']);
// pr($work);die;
												?>
														<tr class="stuname" style="cursor:pointer;">
															<td>
																<?php if ($selectdadte) { ?>
																	<input type="hidden" name="date" required="required" class="datepicks" value="<?php echo $selectdadte; ?>">

																<?php } else { ?>

																	<input type="hidden" name="date" required="required" class="datepicks" value="<?php echo date('Y-m-d'); ?>">

																<?php } ?>
																<input type="hidden" name="class_id" class="" value="<?php echo $seletedclassid; ?>">
																<?php if ($seletedsectionid) { ?>
																	<input type="hidden" name="section_id" class="" value="<?php echo $seletedsectionid; ?>">
																<?php } else { ?>
																	<input type="hidden" name="section_id" class="" value="<?php echo $seletedsectioid; ?>">

																<?php } ?>

																<input type="hidden" name="academic" class="" value="<?php echo $academic; ?>">
																<label><input type="checkbox" id="chk<?php echo $work['id']; ?>" class="StuAttendCk" name="stud_id[]" value="<?php echo $work['stud_id']; ?>" <?php if ($work['status'] == 'A') { ?>checked="checked" <?php } ?> onclick="check(<?php echo $work['id']; ?>)"> </label>
															</td>
															<td><?php $rty = $this->Comman->findstudents($work['stud_id']);
																echo $rty['enroll']; ?></td>
															<td><b><?php echo $rty['fname']; ?> <?php echo $rty['middlename']; ?> <?php echo $rty['lname']; ?></b></td>
															<?php /* ?>	<td><div class="form-group field-1">
																	<div class="col-lg-6">
																		<input type="text" id="<?php echo $work['id']; ?>" class="abs_remark form-control" name="remark[<?php echo $work['stud_id']; ?>]" value="<?php  if($work['status'] == 'A'){  echo $work['remark']; } ?>" <?php  if($work['status'] == 'A'){ ?>required="required" <?php } ?> <?php  if($work['status'] == 'P'){ ?> disabled="" <?php } ?> maxlength="50" style="height:30px !important;" placeholder="Enter Absent remark"></div>
																	</div></td> <?php */ ?>
														</tr>
														<?php }
												} else {
													if (isset($studentsarry) && !empty($studentsarry)) {
														foreach ($studentsarry as $krrt => $work) {
															$getMachineStatus = $this->Comman->getMachineStatus($work['class_id'], $work['section_id'], $work['id']);
														?>

															<tr class="stuname" style="cursor:pointer;">
																<td>
																	<?php if ($selectdadte) { ?>
																		<input type="hidden" name="date" required="required" class="datepicks" value="<?php echo $selectdadte; ?>">

																	<?php } else { ?>

																		<input type="hidden" name="date" required="required" class="datepicks" value="<?php echo date('Y-m-d'); ?>">

																	<?php } ?>
																	<input type="hidden" name="class_id" class="" value="<?php echo $seletedclassid; ?>">
																	<?php if ($seletedsectionid) { ?>
																		<input type="hidden" name="section_id" class="" value="<?php echo $seletedsectionid; ?>">
																	<?php } else { ?>
																		<input type="hidden" name="section_id" class="" value="<?php echo $seletedsectioid; ?>">

																	<?php } ?>

																	<input type="hidden" name="academic" class="" value="<?php echo $academic; ?>">
																	<label><input type="checkbox" id="chk<?php echo $work['id']; ?>" class="StuAttendCk" name="stud_id[]" value="<?php echo $work['id']; ?>" onclick="check(<?php echo $work['id']; ?>)"> </label>
																</td>
																<td><?php echo $work['enroll']; ?></td>
																<td>

																	<b><?php echo $work['fname']; ?> <?php echo $work['middlename']; ?> <?php echo $work['lname']; ?></b>
																</td>
																<?php /* ?>	<td><div class="form-group field-1">
<div class="col-lg-6">
	<input type="text" id="<?php echo $work['id']; ?>" class="abs_remark form-control" name="remark[<?php echo $work['id']; ?>]"  maxlength="50" style="height:30px !important;" placeholder="Enter Absent remark"></div>
</div></td>  <?php */ ?>
															</tr>
												<?php }
													}
												} ?>
											</tbody>
										</table>
										<?php echo $this->Form->submit(
											'Take Attendance',
											array('class' => 'btn btn-info pull-right', 'title' => 'Update')
										); ?>
									</form>
									<?php
									$role = $this->request->session()->read('Auth.User.role_id');
									if ($role == '3') {
										echo $this->Html->link('Back To Classes', [
											'controller' => 'students', 'action' => 'classattendance'

										], ['class' => 'btn btn-default']);
									} else {
										echo $this->Html->link('Back To Classes', [
											'controller' => 'students', 'action' => 'classattendance'

										], ['class' => 'btn btn-default']);
									} ?>
								</div>
							</div>
							<div class="box-footer">



							</div>
							<!-- /.box-footer -->

						</div>
						<!-- /.box-body -->






					</div>
					<!--/.col (right) -->
				</div>
				<!-- /.row -->
			<?php   } ?>
	</section>
	<!-- /.content -->
</div>

<script>
	$(document).ready(function() {
		$('#c-id').on('change', function() {
			var id = $('#c-id').val();
			//alert(id);
			$.ajax({
				type: 'POST',
				url: '<?php echo ADMIN_URL; ?>cities/find_state',
				data: {
					'id': id
				},
				success: function(data) {

					$('#s-id').empty();
					$('#s-id').html(data);
				},

			});
		});
		$('.stuname').click(function() {
			$(this).find('input:checkbox').each(function() {
				if (this.checked) this.checked = false; // toggle the checkbox
				else this.checked = true;
			})
		});
	});
</script>