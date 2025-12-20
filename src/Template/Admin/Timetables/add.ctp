<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Timetables Manager

		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>Timetables/index"><i class="fa fa-home"></i>Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>Timetables/index">Manage Timetables</a></li>
			<li class="active">Create Timetable</li>
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
						<h3 class="box-title"><?php if (isset($sections['id'])) {
													echo 'Edit Timetable';
												} else {
													echo 'Add Timetable';
												} ?></h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<?php echo $this->Flash->render(); ?>
					<?php echo $this->Form->create($timestable, array(
						'class' => 'form-horizontal',
						'id' => 'timestable_form',
						'enctype' => 'multipart/form-data',
						'validate'
					)); ?>

					<div class="box-body">

						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<?php echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Name', 'id' => 'name', 'required' => 'required', 'label' => false)); ?>
							</div>
						</div>




						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Time From</label>
							<div class="col-sm-10">
								<div class="input-group bootstrap-timepicker timepicker">
									<?php echo $this->Form->input('time_from', array('class' => 'form-control', 'placeholder' => 'Time From', 'id' => 'timepicker1', 'required' => 'required', 'label' => false)); ?>
									<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
								</div>
							</div>
						</div>

						<script type="text/javascript">
							//$('#timepicker1').timepicker({  startMinutes: 15 });
						</script>

						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Time To</label>
							<div class="col-sm-10">
								<div class="input-group bootstrap-timepicker timepicker">
									<?php echo $this->Form->input('time_to', array('class' => 'form-control', 'placeholder' => 'Time To', 'id' => 'timepicker2', 'required' => 'required', 'label' => false)); ?>
									<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
								</div>
							</div>
						</div>

						<script type="text/javascript">
							//   $('#timepicker2').timepicker();
						</script>

						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Is Break</label>
							<div class="col-sm-10">
								<?php echo $this->Form->checkbox('is_break', array('class' => '', 'label' => false, 'type' => 'checkbox')); ?>
							</div>
						</div>

						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Weekday</label>
							<div class="col-sm-10">
								<?php $weekday = array('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday');
								echo $this->Form->input('weekday[]', array('class' => 'form-control', 'multiple', 'type' => 'select', 'empty' => 'Select Weekday', 'options' => $weekday, 'value' => $weekd, 'required', 'label' => false)); ?>
							</div>
						</div>

					</div>

					<!-- /.box-body -->
					<div class="box-footer">
						<?php
						echo $this->Html->link('Back', [
							'action' => 'index'
						], ['class' => 'btn btn-default']); 
						?>

						<?php
						if (isset($timestable['id'])) {
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
						?>
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