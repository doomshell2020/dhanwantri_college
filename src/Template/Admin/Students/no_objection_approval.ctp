	<div class="modal-header">

		<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
		<h4 class="modal-title">
			<i class="fa fa-file-pdf-o"></i>Certificate Approval <?php echo $student['fname'] . " " . $student['middlename'] . " " . $student['lname']; ?> (<?php echo $student['enroll']; ?>)
		</h4>

	</div>

	<?php echo $this->Form->create($student, array('class' => 'form-horizontal')); ?>

	<div class="modal-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="form-group">
					<div class="col-sm-12">
						<label>Reasons</label>
						<?php
						echo $this->Form->input('reason', array('class' => 'form-control', 'type' => 'textarea', 'label' => false, 'style' => 'width: 615px; height: 48px;', 'required'));
						?>
					</div>
					<div class="col-sm-6">
						<label>From:</label>
						<input type="date" class="form-control" name="from_date" required="required">
					</div>
					<div class="col-sm-6">
						<label>To:</label>
						<input type="date" class="form-control" name="to_date" required="required">
					</div>
				</div>

			</div>

		</div>

	</div>

	<div class="modal-footer">
		<?php
		echo $this->Form->submit(
			'Submit',
			array('class' => 'btn btn-info pull-right', 'style' => 'margin-right: 10px;')
		);

		?>
		<button data-dismiss="modal" class="btn btn-default pull-left" type="button">Close</button>
	</div>
	<?php echo $this->Form->end(); ?>