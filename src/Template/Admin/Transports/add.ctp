<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Transport Manager
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
						<h3 class="box-title"><?php if (isset($transports['id'])) {
													echo 'Edit Transport';
												} else {
													echo 'Add Transport';
												} ?></h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->

					<?php echo $this->Flash->render(); ?>
					<?php echo $this->Form->create($transports, array(

						'class' => 'form-horizontal',
						'id' => 'sevice_form',
						'enctype' => 'multipart/form-data'
					)); ?>

					<div class="box-body">
						<div class="form-group">

							<div class="col-sm-3">
								<label>Vehicle No.</label>
								<?php echo $this->Form->input('vechical_no', array('class' => 'form-control', 'required', 'placeholder' => 'Vehicle No', 'label' => false)); ?>
							</div>


							<div class="col-sm-3">
								<label>Driver Name</label>
								<?php echo $this->Form->input('driver_name', array('class' => 'form-control', 'required', 'placeholder' => 'Driver name', 'label' => false)); ?>
							</div>

							<div class="col-sm-3">
								<label>Driver Mobile</label>
								<?php echo $this->Form->input('driver_mobile', array('class' => 'form-control', 'required', 'maxlength' => 10, 'placeholder' => 'Driver Mobile', 'label' => false)); ?>
							</div>

							<div class="col-sm-3">
								<label>Helper Name</label>
								<?php echo $this->Form->input('helper_name', array('class' => 'form-control', 'placeholder' => 'Helper name', 'label' => false)); ?>
							</div>

						</div>

						<div class="form-group">

							<div class="col-sm-3">
								<label>Helper Mobile</label>
								<?php echo $this->Form->input('helper_mobile', array('class' => 'form-control', 'maxlength' => 10, 'placeholder' => 'Helper Mobile', 'label' => false)); ?>
							</div>

							<div class="col-sm-3">
								<label>GPS Device ID</label>
								<?php echo $this->Form->input('gps_deviceid', array('class' => 'form-control', 'placeholder' => 'GPS Device ID', 'label' => false)); ?>
							</div>

							<div class="col-sm-3">
								<label>Bus Strength</label>
								<?php echo $this->Form->input('strength', array('class' => 'form-control', 'placeholder' => 'Bus Strength', 'type' => 'number', 'required', 'label' => false)); ?>
							</div>

							<div class="col-sm-3">
								<label>Select Route</label>
								<?php echo $this->Form->input('route', array('class' => 'form-control', 'required', 'value' => $optns, 'multiple' => true, 'type' => 'select', 'empty' => 'Select Route', 'options' => $route_master, 'multiple' => false, 'label' => false)); ?>
							</div>
						</div>


						<!-- /.form group -->

					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<?php
						echo $this->Html->link('Back', [
							'action' => 'index'

						], ['class' => 'btn btn-default']); ?>

						<?php
						if (isset($transports['id'])) {
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

<?php
if (!empty($transports['id'])) {
	echo '<script>$("#route").attr("disabled", true);</script>';
}
?>

<script>
	$(document).ready(function() {


		$('#c-id').on('change', function() {
			var id = $('#c-id').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo ADMIN_URL; ?>cities/find_state',
				data: {
					'id': id
				},
				success: function(data) {
					alert(data);
					$('#s-id').empty();
					$('#s-id').html(data);
				},

			});
		});
	});
</script>