<div class="modal-header">
	<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title">
		<i class="fa fa-file-pdf-o"></i> Relieving Certificate
	</h4>
</div>
<?php echo $this->Form->create($student, array('class' => 'form-horizontal')); ?>
<div class="modal-body">
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<script>
					var date = new Date();
					var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
					$('.dpwe').datepicker({
						todayHighlight: true,
						autoclose: true,
						maxDate: 0,
						startDate: today,
					});
				</script>
				<script>
					var date = new Date();
					var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
					$('.dpwe2').datepicker({
						todayHighlight: true,
						autoclose: true,
						maxDate: 0,
						startDate: today,
					});
				</script>
				<div class="col-sm-6">
					<label>No.<span>
							<font color="red"> *</font>
						</span></label>
					<?php
					if ($student['sno']) {
						$bbokno = $student['sno'];
					} else {
						$bbokno = $lstbook['sno'] + 1;
					}
					echo $this->Form->input('sno', array('class' => 'form-control', 'value' => $bbokno, 'type' => 'text', 'required', 'label' => false,));
					?>
				</div>
				<div class="col-sm-6">
					<label>Application Date<span>
							<font color="red"> *</font>
						</span></label>
					<?php if ($student['date_application']) {
						$dateapplication = date('d-m-Y', strtotime($student['date_application']));
					} else {
						$dateapplication = date('d-m-Y');
					}
					echo $this->Form->input('date_application', array('value' => $dateapplication, 'class' => 'form-control dpwe', 'type' => 'text', 'label' => false, 'required'));
					?>
				</div>
				<div class="col-sm-12"><label>&nbsp;</label></div>
				<div class="col-sm-6">
					<label>Relieving Date<span>
							<font color="red"> *</font>
						</span></label>
					<?php if ($student['relevingdate']) {
						$relevingdate = date('d-m-Y', strtotime($student['relevingdate']));
					} else {
						$relevingdate = date('d-m-Y');
					}
					echo $this->Form->input(
						'relevingdate',
						array('value' => $relevingdate, 'class' => 'form-control dpwe2', 'type' => 'text', 'label' => false, 'required')
					);
					?>
				</div>
				<div class="col-sm-6">
					<label>Issue Date<span>
							<font color="red"> *</font>
						</span></label>
					<?php
					echo $this->Form->input(
						'date_issue',
						array('value' => date('d-m-Y'), 'class' => 'form-control', 'readonly' => 'readonly', 'type' => 'text', 'label' => false, 'id' => 'dateissue', 'required')
					);
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<?php
	echo $this->Form->submit(
		'Generate Order',
		array('class' => 'btn btn-info pull-left', 'style' => 'margin-right: 10px;')
	);
	?>
	<button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
</div>
<?php echo $this->Form->end(); ?>