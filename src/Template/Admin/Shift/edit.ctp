<div class="modal-header">
	<!--  <link rel="stylesheet" href="<?php echo SITE_URL; ?>js/timepicker/bootstrap-timepicker.min.css">
  <script src="<?php echo SITE_URL; ?>js/timepicker/bootstrap-timepicker.min.js"></script>
  <script type="text/javascript" src="<?php echo SITE_URL; ?>js/timepicker/bootstrap-datetimepicker.js" charset="UTF-8"></script>-->
	<button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
	
	<h4 class="modal-title">
		<i class="fa fa-plus-square"></i> Edit Shift
	</h4>

</div>

<?php echo $this->Form->create($shift, array('class'=>'form-horizontal')); ?>

<div class="modal-body">

	<div class="row">

		<div class="col-sm-12">

			<div class="form-group">

				<div class="col-sm-12">
					<label>Shift Name <span style="color: red;">*</span></label>
					<?php echo $this->Form->input('name', array('class'=>'form-control','placeholder'=>'Enter Shift name', 'label' =>false)); ?>
				</div>

			</div>

			<div class="form-group">

				<div class="col-sm-6">
					<label>Start Time <span style="color: red;">*</span></label>
					  <div class='input-group date' id='datetimepicker3'>
                  <?php echo $this->Form->input('s_time', array('class'=>'form-control', 'label' =>false, 'required',)); ?>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>
					
				</div>

				<div class="col-sm-6">
					<label>End Time <span style="color: red;">*</span></label>
					
				  <div class='input-group date' id='datetimepicker4'>
                  <?php echo $this->Form->input('e_time', array('class'=>'form-control', 'label' =>false, 'required', )); ?>
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-time"></span>
                    </span>
                </div>	
					
					
				</div>

			</div>

		</div>

	</div>

</div>

<div class="modal-footer">
	
	<?php
		echo $this->Form->submit(
			'Update', 
			['class' => 'btn btn-success pull-left']
		);
	?>

	<button data-dismiss="modal" class="btn btn-primary pull-right" type="button">Close</button>

</div>

<?php echo $this->Form->end(); ?>

 <script type="text/javascript">
            $(function () {
                $('#datetimepicker3').datetimepicker({
                    format: 'LT'
                });
            });
        </script>
         <script type="text/javascript">
            $(function () {
                $('#datetimepicker4').datetimepicker({
                    format: 'LT'
                });
            });
        </script>
