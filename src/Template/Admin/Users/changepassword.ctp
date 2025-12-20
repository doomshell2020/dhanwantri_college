<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Profile Manager
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
			<li><a href="#">Manage Profile</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<!--/.col (left) -->
			<!-- right column -->
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">

					<div class="box-header with-border">
						<h3 class="box-title">Change Profile Setting</h3>
						<!-- <a href="<?php //echo SITE_URL; ?>admin/users/branchespasschange">
							<button class="btn btn-success pull-right m-top10">
								Change Branches Password
							</button> -->
						</a>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<?php //pr($page); die; 
					?>
					<?php echo $this->Flash->render(); ?>



					<?php echo $this->Form->create($users, array(

						'class' => 'form-horizontal',
						'id' => 'sitesetting_form',
						'enctype' => 'multipart/form-data',
						'novalidate'
					)); ?>

					<div class="box-body">



						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">New Password</label>

							<div class="col-sm-5">
								<?php echo $this->Form->password('new_password', array('class' => 'form-control', 'placeholder' => 'New Password', 'maxlength' => '40', 'id' => 'password', 'label' => false)); ?>

								<input type="hidden" name="userssid" value="<? echo $userssid; ?>">

							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Confirm Password</label>

							<div class="col-sm-5">
								<?php echo $this->Form->input('confirm_pass', array('class' => 'form-control', 'placeholder' => 'Confirm Password', 'value' => '', 'maxlength' => '40', 'id' => 'confirm_pass', 'label' => false)); ?>

							</div>
						</div>
						<? if ($role_id == '5' || $role_id == '8') {  ?>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Late Fee</label>

								<div class="col-sm-5">
									<?php echo $this->Form->input('latefee', array('class' => 'form-control', 'value' => $latefee, 'maxlength' => '2', 'label' => false)); ?>

								</div>
							</div>

							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Quater-1 Last Date</label>

								<div class="col-sm-5">
									<?php echo $this->Form->input('qu1_date', array('class' => 'form-control', 'value' => date('Y-m-d', strtotime($classfee['qu1_date'])), 'id' => 'fee_date1', 'placeholder' => 'Quater1 Last Date', 'label' => false)); ?>

								</div>
							</div>

							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Quater-2 Last Date</label>

								<div class="col-sm-5">
									<?php echo $this->Form->input('qu2_date', array('class' => 'form-control', 'id' => 'fee_date2', 'value' => date('Y-m-d', strtotime($classfee['qu2_date'])), 'placeholder' => 'Quater2 Last Date', 'label' => false)); ?>

								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Quater-3 Last Date</label>

								<div class="col-sm-5">
									<?php echo $this->Form->input('qu3_date', array('class' => 'form-control', 'id' => 'fee_date3', 'value' => date('Y-m-d', strtotime($classfee['qu3_date'])), 'placeholder' => 'Quater3 Last Date', 'label' => false)); ?>

								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Quater-4 Last Date</label>

								<div class="col-sm-5">
									<?php echo $this->Form->input('qu4_date', array('class' => 'form-control', 'id' => 'fee_date4', 'value' => date('Y-m-d', strtotime($classfee['qu4_date'])), 'placeholder' => 'Quater4 Last Date', 'label' => false)); ?>

								</div>
							</div>

							<script>
								$(document).ready(function() {

									$('#fee_date1').datepicker({
										"changeMonth": false,
										"changeYear": false,
										"dateFormat": "yy-mm-dd"
									});
									$('#fee_date2').datepicker({
										"changeMonth": false,
										"changeYear": false,
										"dateFormat": "yy-mm-dd"
									});
									$('#fee_date3').datepicker({
										"changeMonth": false,
										"changeYear": false,
										"dateFormat": "yy-mm-dd"
									});
									$('#fee_date4').datepicker({
										"changeMonth": false,
										"changeYear": false,
										"dateFormat": "yy-mm-dd"
									});

								});
							</script>

							<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
							<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

						<? } ?>
						<!-- /.box-body -->
						<div class="box-footer">

							<div class="col-sm-8">
								<?php
								if (isset($work['id'])) {
									echo $this->Form->submit(
										'Update',
										array('class' => 'btn btn-info pull-right', 'title' => 'Update')
									);
								} else {
									echo $this->Form->submit(
										'Submit',
										array('class' => 'btn btn-info pull-right', 'title' => 'Add')
									);
								}
								?>
							</div>
						</div>
						<!-- /.box-footer -->
						<?php echo $this->Form->end(); ?>
					</div>

				</div>
				<!--/.col (right) -->
			</div>
			<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

<script type="text/javascript">
	$('#checkbox1').change(function() {
		if (this.checked)
			$('.passdata').show();
		else
			$('.passdata').hide();

	});
</script>