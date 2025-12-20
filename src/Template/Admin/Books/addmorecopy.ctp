<div class="modal-header">
	<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title">
		<i class="fa fa-plus-square"></i> Add More Copy
	</h4>
</div>

<?php echo $this->Form->create(null, array('class' => 'form-horizontal')); ?>

<div class="modal-body">

	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<div class="col-sm-12">
					<label>No. of Copies<span>
							<font color="red"> *</font>
						</span></label>
					<?php echo $this->Form->input('no_of_copy', array('class' => 'form-control', 'type' => 'number', 'min' => 1, 'label' => false, 'required')); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal-footer">
	<?php
	echo $this->Form->submit(
		'Add',
		array('class' => 'btn btn-info pull-left', 'style' => 'margin-right: 10px;', 'title' => 'Add')
	);
	?>
	<button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
</div>
<?php echo $this->Form->end(); ?>