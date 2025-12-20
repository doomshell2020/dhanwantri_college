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
			<li class="active"><?php echo $sections['name']; ?></li>
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
						<h3 class="box-title">View Timetable</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<div class="box-body">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-4 control-label">Title</label>
							<?php if (isset($sections['name'])) {
								echo ucfirst($sections['name']);
							} else {
								echo 'N/A';
							} ?>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-4 control-label">Times From</label>
							<?php if (isset($sections['time_from'])) {
								echo $sections['time_from'];
							} else {
								echo 'N/A';
							} ?>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-4 control-label">Times To</label>
							<?php if (isset($sections['time_to'])) {
								echo $sections['time_to'];
							} else {
								echo 'N/A';
							} ?>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-4 control-label">Is Break</label>
							<?php if ($sections['is_break'] == '1') {
								echo "Yes";
							} else {
								echo 'No';
							} ?>
						</div>



					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<?php
						echo $this->Html->link('Back', [
							'action' => 'index'
						], ['class' => 'btn btn-default']); ?>
					</div>
					<!-- /.box-footer -->

				</div>

			</div>
			<!--/.col (right) -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>