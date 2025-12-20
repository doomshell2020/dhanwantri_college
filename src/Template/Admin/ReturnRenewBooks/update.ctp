<div class="modal-header">
	<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
	<h4 class="modal-title">
		<i class="fa fa-pencil-square"></i> Update Details
	</h4>
</div>

<?php echo $this->Form->create($issuebook, array('class'=>'form-horizontal')); ?>
<div class="modal-body">
	<div class="row">
		<div class="col-sm-12">
			<div class="form-group">
				<div class="col-sm-6">
					<label>Holder Type<span><font color="red"> *</font></span></label>
					<?php
					echo $this->Form->input('holder_type_id', array('class'=>'form-control','type'=>'select', 'empty'=>'Select Holder Type',
						'options'=>$holder_type, 'label' =>false, 'disabled')
					);
					?>	
				</div>

				<div class="col-sm-6">
					<label>Holder Name<span><font color="red"> *</font></span></label>
					<?php echo $this->Form->input('holder_name',array('class'=>'form-control','placeholder'=>'Enter Name/ID', 'id'=>'title','label' =>false, 
						'disabled')); ?>
				</div>  
			</div>

			<div class="form-group">
				<div class="col-sm-6 datepc3 ">
					<label>Issue Date<span><font color="red"> *</font></span></label>
					<?php echo $this->Form->input('d1',array('class'=>'form-control ','placeholder'=>'Issue Date', 'id'=>'dastepicker','required','label' =>false, 
					'required')); ?>
				</div>

				<div class="col-sm-6 datepc4">
					<label>Due Date<span><font color="red"> *</font></span></label>
					<?php echo $this->Form->input('d2',array('class'=>'form-control ','placeholder'=>'Due Date', 'id'=>'daswtepicker','required','label' =>false, 'required')); ?>
				</div>  
			</div>
		</div>
	</div>
</div>

<div class="modal-footer">
	<?php
		echo $this->Form->submit(
			'Update Book', 
			array('class' => 'btn btn-info pull-left','style'=>'margin-right: 10px;', 'title' => 'Update Book')
		);
	?>
	<button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>   
</div>
<?php echo $this->Form->end(); ?>

<script>
	 $.datepicker.setDefaults({
        dateFormat: 'dd/mm/yy'});
    $('#dastepicker').datepicker({
        minDate: '+0',
        onSelect: function(dateStr) {
            var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
            var max = new Date(min.getTime());
            max.setMonth(max.getMonth() + 60); // Add one month
            $('#daswtepicker').datepicker('option', {minDate: min, maxDate: max});
        },
    }).attr("readonly","readonly");
    $('#daswtepicker').datepicker({
        minDate: '+0',
        maxDate: '+1m',
        autoclose: true,
        onSelect: function(dateStr) {
            var max = $(this).datepicker('getDate'); // Selected date or null if none
            $('#dastepicker').datepicker('option', {maxDate: max});
        },
    }).attr("readonly","readonly");
</script>
