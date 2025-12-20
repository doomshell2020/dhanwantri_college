
<head>
  <link rel="stylesheet" href="<?php echo SITE_URL; ?>css/admin/jquery.timepicker.min.css">
  <script src="<?php echo SITE_URL; ?>js/admin/jquery.timepicker.min.js"></script>
</head>

<div class="modal-header-color">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    <span class="fa-stack fa-lg pull-left">
        <i class="fa fa-pencil-square fa-2x"></i>
    </span>
    <strong style="padding-left: 10px;">Update Attendance</strong> <br>
    <span class="text-muted" style="padding-left: 10px;">
        <strong>Employee</strong> :
        <?=ucfirst($employees['employee']['fname'])." ".ucfirst($employees['employee']['middlename'])." ".
        	ucfirst($employees['employee']['lname']) ?> |
        <strong>Shift</strong> :
        <?=$shifts['name'].' ('.date('h:i a',strtotime($shifts['start_time'])).' - '.date('h:i a',strtotime($shifts['end_time'])).')' ?> |
        <strong>Date</strong> :
        <?=date('d-m-Y',strtotime($shifts['start_time'])) ?> 
    </span>
</div>

<?php echo $this->Form->create($emp_attendance, array('class'=>'form-horizontal','id'=>'UpdateTimeForm')); ?>

<div class="modal-body">

	<div class="row">

		<div class="col-sm-12">

			<div class="form-group">

				<div class="col-sm-6">
					<label>Time In<span><font color="red"> *</font></span></label>
					<?php echo $this->Form->input('in_time',array('class'=>'form-control ','label' =>false, 'required', 'readonly')); ?>
				</div>

				<div class="col-sm-6">
					<label>Time Out<span><font color="red"> *</font></span></label>
					<?php echo $this->Form->input('out_time',array('class'=>'form-control ','label' =>false, 'required', 'readonly')); ?>
				</div>  

			</div>

		</div>

	</div>

</div>

<div class="modal-footer">
	
	<?php
		echo $this->Form->submit(
			'Update Time', 
			array('class' => 'btn btn-info pull-left','style'=>'margin-right: 10px;')
		);
	?>

	<button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>   
	
</div>

<?php echo $this->Form->end(); ?>

<script type="text/javascript">

$('#in-time').timepicker({
    timeFormat: 'hh:mm a',
    interval: 15,
    minTime: '07',
    maxTime: '06:00pm',
    // defaultTime: '08',
    startTime: '07:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});

$('#out-time').timepicker({
    timeFormat: 'hh:mm a',
    interval: 15,
    minTime: '07',
    maxTime: '06:00pm',
    // defaultTime: '03:00pm',
    startTime: '07:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});

</script>

<script>

    $("#UpdateTimeForm").bind("submit", function (event) {

      $.ajax({

        async:false,

        type:"POST", 
        
        url:"<?php echo ADMIN_URL; ?>EmployeeAttendance/update_time/<?php echo $employees['id']; ?>",
        
        data:$("#UpdateTimeForm").serialize(),
        
        dataType:"html", 

        success:function (data) {
          // alert(data);
          if(data == 'form_success')
          {
          	$('#globalModal').modal('hide');
          	$('#TaskAdminCustomerForm').submit();
          }
          else{ alert('Something went wrong!'); }
        }

      });

      return false;

    });

</script>