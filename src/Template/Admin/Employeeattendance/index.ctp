 
<?php //echo $date; die; ?>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">

 	<section class="content-header">
 		<h1>
 			<i class="glyphicon glyphicon-check"></i> Take Attendance
 		</h1>
      <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>Employeeattendance/index">Take Attendance</a></li>
	      </ol>
 	</section>

 	<!-- Main content -->
 	<section class="content">
 <!-- start -->
 		<div class="row">
 			<div class="col-xs-12">

 				<?php echo $this->Flash->render(); ?>

 				<div class="box">
 					<div class="box-header">
 						<h3 class="box-title">
 							<i class="fa fa-search"></i> Search
 						</h3>
 					</div>
 					<!-- /.box-header -->

 					<div class="box-body">


 						<div class="manag-stu">

 							<?php echo $this->Form->create(null, array('class'=>'form-horizontal', 'id'=>'TaskAdminCustomerForm')); ?>

 							<div class="form-group">

                

                <div class="col-sm-4">
                  <label>Designation</label>
                  <?php
                  echo $this->Form->input('designation', array('class'=>'form-control','type'=>'select', 'empty'=>'Select Designation',
                   'options'=>$designations, 'label' =>false)
                  );
                  ?>
                </div>

                <div class="col-sm-4">
                  <label>Date <span style="color: red;">*</span></label>
                  <?php echo $this->Form->input('current_date',array('class'=>'form-control','id'=>'dp3','required', 'readonly', 
                  'label'=>false)); ?>
                </div>


                <div class="col-sm-4">
                  <label>Employee Name</label>
                  <?php echo $this->Form->input('e_name',array('class'=>'form-control','placeholder'=>'Enter name','label' =>false)); ?>
                </div>

              </div>

              <div class="form-group">


                <div class="col-sm-4">
                  <label>Employee Id</label>
                  <?php echo $this->Form->input('e_id',array('class'=>'form-control','placeholder'=>'Enter id','type'=>'text',
                  'label' =>false)); ?>
                </div>

              </div>

              <div class="form-group">

               <div class="col-sm-12">   

                <button type="submit" class="btn btn-success">Search</button>&nbsp;
                <button type="reset" class="btn btn-primary">Reset</button>

              </div>

            </div>

            <?php echo $this->Form->end(); ?>   

          </div>

        </div>

      </div>	</div>	</div>  
      <!-- end ---------------------------------------------------------------------------------->

      <div class="row">

          <div class="col-xs-12">

            <div class="box" style="display: block;" >
<?php if($employees) { ?>

  <link rel="stylesheet" href="<?php echo SITE_URL; ?>css/admin/jquery.timepicker.min.css">
  <script src="<?php echo SITE_URL; ?>js/admin/jquery.timepicker.min.js"></script>
</head>

 <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
 <script src="<?php echo SITE_URL; ?>js/admin/jquery.dataTables.min.js"></script>
 <script src="<?php echo SITE_URL; ?>js/admin/dataTables.bootstrap.min.js"></script>
 
 
 <script>
  
 /* $("#YourbuttonIds").click(function(){ 
    if($('input[type=checkbox]:checked').length == 0)
    {
        alert('Please select atleast one checkbox');
        return false;
    }
});	
*/
 
 </script>
 
 
 <script type="text/javascript">
 $(document).ready(function() { 
    $('.check-all').click(function () {
        if(this.checked) { 
       
           $(this).parents('table:eq(0)').find('.time_in').prop('disabled',false);
            $(this).parents('table:eq(0)').find('.time_out').prop('disabled',false);
            $(this).parents('table:eq(0)').find('.abs_remark').prop('disabled',true);
            $(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
            $(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);
        } else {
     
            $(this).parents('table:eq(0)').find('.time_in').prop('disabled',true);
            $(this).parents('table:eq(0)').find('.time_out').prop('disabled',true);
            $(this).parents('table:eq(0)').find('.abs_remark').prop('disabled',false);
            $(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
            $(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
        }
    });

	window.check = function (id) {
	    var ck = 'chk'+id;
	    var t_in = 'time_in'+id;
	    var t_out = 'time_out'+id;
	    var chkbox = document.getElementById(ck);
	    if(chkbox.checked)
	    {
	        document.getElementById(t_in).disabled = false;
	         document.getElementById(t_out).disabled = false;
	        document.getElementById(id).disabled = true;
	        document.getElementById(id).required = false;
	         document.getElementById(id).value = '';
	    }
	    else{
	        document.getElementById(t_in).disabled = true;
	         document.getElementById(t_out).disabled = true;
	        document.getElementById(id).disabled = false;
	        document.getElementById(id).required = true;
	    }

	    if($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
	        $('.check-all').prop('checked', true);
	    } else {
	        $('.check-all').prop('checked', false);
	    }  
	};

  });
</script>
	
<script type="text/javascript">

$('.time_in').timepicker({
    timeFormat: 'hh:mm a',
    interval: 15,
    minTime: '07',
    maxTime: '06:00pm',
    startTime: '07:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});

$('.time_out').timepicker({
    timeFormat: 'hh:mm a',
    interval: 15,
    minTime: '07',
    maxTime: '06:00pm',
    startTime: '07:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});

</script>


        
 <div class="box-header">
	<h3 class="box-title"><i class="fa fa-check-square"></i> Employee Attendance</h3>
</div>
	
	 <form id="studttendance-form" action="<?php echo SITE_URL; ?>admin/Employeeattendance/take_attendance" method="post">
        
        <div class="box-body">
          <div class="box-header">
     <?php
        echo '<div class="submit" style="float:right;"><input type="submit" id="YourbuttonIds" class="btn btn-info" value="Take Attendance"></div>';
      ?>
  </div>
  <div id="appear-box">
            <table id="example1" class="table table-bordered table-striped">

                  
                  <thead>

                    <tr>
                      <th><input type="checkbox" class="check-all" ></th>
                      <th>Employee Id</th>
                      <th>Employee Name</th>
                      <th>Department</th>
                      <th>Designation</th>
                      <th>Shift</th>
                      <th class="text-center">Time-in</th>
                      <th class="text-center">Time-out</th>
                      <th class="text-center">Remark</th>
                    </tr>

                  </thead>

                  <tbody>
<?php 

$page = $this->request->params['paging']['Employees']['page'];
$limit = $this->request->params['paging']['Employees']['perPage'];
$counter = ($page * $limit) - $limit + 1;
if(isset($employees) && !empty($employees)){ 
	foreach($employees as $work){ 
	$e_status=$this->Comman->findstatus($work['id'],$date);
	$a_status=$this->Comman->findstatuss($work['id'],$date);
?>
		<tr>
			<td>
			<label>
									<label><input type="checkbox" id="chk<?php echo $work['id']; ?>" class="StuAttendCk" name="emp_id[]" value="<?php echo $work['id'];?>"<?php if($work['id']==$e_status['employee_id']){ echo "checked"; } ?> onclick="check(<?php echo $work['id']; ?>)"> </label></td>
			</label>
			</td>

			<input type="hidden" name="date" value="<?php echo $current_date ?>">
			<input type="hidden" name="shift_id" value="<?php echo $shifts['id']; ?>">
		
		    <input type="hidden" name="designation_id" value="<?php echo $work['designation']['id']; ?>">
			
			<td><?php if(isset($work['id'])){ echo $work['id'];}else{ echo 'N/A';}?></td>

			<td><?php if(isset($work['fname'])){ echo ucfirst($work['fname'])." ".$work['middlename']." ".$work['lname']; }else{ echo 'N/A';}?>
			</td>

			<td><?php if(isset($work['department']['name'])){ echo ucfirst($work['department']['name']);}else{ echo 'N/A';}?></td>

			<td><?php if(isset($work['designation']['name'])){ echo ucfirst($work['designation']['name']);}else{ echo 'N/A';}?></td>

			<td>
				<?php  echo $shifts['name'].' ('.date('h:i a',strtotime($shifts['start_time'])).' - '.
				date('h:i a',strtotime($shifts['end_time'])).')';?>
			</td>

			<td class="text-center">
				<input class="time_in" name="time_in[]" id="time_in<?php echo $work['id']; ?>" <?php if($work['id']==$a_status['employee_id']){ ?>disabled="disabled" <?php  } ?>value="<?php echo date('h:i a',strtotime($shifts['start_time'])); ?>" >
			</td>
			
			<td class="text-center">
				<input class="time_out" name="time_out[]" id="time_out<?php echo $work['id']; ?>"  <?php if($work['id']==$a_status['employee_id']){ ?>disabled="disabled" <?php  } ?> value="<?php echo date('h:i a',strtotime($shifts['end_time'])); ?>" readonly="readonly">
			</td>
				<td><div class="form-group field-1">
	<input type="text" id="<?php echo $work['id']; ?>" class="abs_remark form-control" required name="remark[<?php echo $work['id']; ?>]"  maxlength="50" style="height:30px !important;" placeholder="Enter Absent remark" <?php if($work['id']==$e_status['employee_id']){ echo "disabled"; } ?><?php if($work['id']==$a_status['employee_id']){ ?> value="<?php echo $a_status['remark']; ?>" <?php }?>  >
		</tr>

		<?php 

		$counter++;

	} } else{ 

		?>

		<tr>
			<td>No Data Available</td>
		</tr>

		<?php } ?>

	</tbody>


</table>
 </div>
  	
</div>
</form>
           
           
           <?php } ?>
             <!-- Content will be loaded here using AJAX -->
                
              </div>
              <!-- /.box-body -->
            
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->

        </div>
        <!-- /.row -->

</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- custom search script: start -->
<script>

  $(document).ready(function () {

    $("#TaskAdminCustomerForm").bind("submit", function (event) {

      $.ajax({

        async:false,

        type:"POST", 
        
        url:"<?php echo ADMIN_URL ;?>Employeeattendance/take_attendance_search",
        
        data:$("#TaskAdminCustomerForm").serialize(),
        
        dataType:"html", 

        success:function (data) {
          // alert(data);
          $("#appear-box").html(data);
         
        }

      });

      return false;

    });

  });

</script>
<!-- custom search script: end -->
