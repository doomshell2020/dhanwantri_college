<!-- Content Wrapper. Contains page content -->
<script type="text/javascript">
	$(function () {
	    $('.check-all').click(function () {
	        if(this.checked) {
	            $(this).parents('table:eq(0)').find('.abs_remark').prop('disabled',true);
	            $(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
	            $(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);
	        } else {
	            $(this).parents('table:eq(0)').find('.abs_remark').prop('disabled',false);
	            $(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
	            $(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
	        }
	    });

		window.check = function (id) {
		    var ck = 'chk'+id;
		    var chkbox = document.getElementById(ck);
		    if(chkbox.checked)
		    {
		        document.getElementById(id).disabled = true;
		        document.getElementById(id).required = false;
		    }
		    else{
		        document.getElementById(id).disabled = false;
		        document.getElementById(id).required = true;
		    }

		    if($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
		        $('.check-all').prop('checked', true);
		    } else {
		        $('.check-all').prop('checked', false);
		    }
		};

		$( '#stuattendance-sa_date' ).datepicker({
			beforeShowDay: function(date) {
			   var day = date.getDay();
			   return [(day == 1)];
		   },
		   maxDate : 0, changeMonth : true, dateFormat: 'dd-mm-yy',
		   onSelect : function(){
		        $('#stud-attendance-form').submit();
			}
	   });
	});</script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
		 Take Student Attendance
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
		    
		      <span class="text-muted" style="padding-left: 10px; font-size: 15px;">
		
			<strong>Class Name : </strong><?php echo $classtitle; ?> | <strong>Section Name : </strong><?php echo $sectiontitle; ?> | <strong>Subject : </strong><?php echo $subjectsname; ?>		</span>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render();   if($weekofday=="Monday"){ $inlinerefrence='1'; 
		}elseif($weekofday=="Tuesday"){ $inlinerefrence='2';  }elseif($weekofday=="Wednesday"){ $inlinerefrence='3';  }elseif($weekofday=="Thursday"){ $inlinerefrence='4';  }elseif($weekofday=="Friday"){ $inlinerefrence='5';  }elseif($weekofday=="Saturday"){ $inlinerefrence='6';  }; ?>

 <script>
  $(function () {


  $('#datepicks').datepicker({
	  "beforeShowDay": function(date){ return [date.getDay() == '<?php echo $inlinerefrence; ?>',""]},
	  
	  "changeMonth":true,'maxDate':'0',"yearRange":"1980:2018","changeYear":true,"autoSize":true,"dateFormat":"dd-mm-yy"});
	  });
           </script>
		
		      <div class="box-body">
	 <form id="stud-attendance-form" action="school/admin/Studattends/add?ids=<?php echo $ids; ?>?date=<?php echo $dates; ?>" method="post">
		<div class="row">
			<div class="col-sm-4">
        		<div class="form-group field-stuattendance-sa_date ">
<label class="control-label" for="stuattendance-sa_date">Date</label>
<input type="text" id="datepicks" class="form-control" name="StuAttendance[sa_date]"   value="<?php echo $dates; ?>" readonly="">


</div>			</div>
		</div> <!-- /.row -->
		</form>
		    <?php echo $this->Form->create($classes, array(
                       
                       'class'=>'form-horizontal',
			'id' => 'sevice_form',
                       'enctype' => 'multipart/form-data',
                       'novalidate'
                     	)); ?>
		   
	<div class="row">
				<div class="col-lg-12">
	  		<table class="table table-striped table-hover" id="mytable">
				
					<tbody>
					
						
						<tr>
						<th><input type="checkbox" class="check-all" checked=""> Check/Uncheck All</th>
						<th colspan="3" class="text-center">Student List</th>
					</tr>
					<tr class="table_header">
						<th style="width:150px"><span class="present">P</span> / <span class="absent">A</span></th>
						<th> Student Id </th>
						<th> Name </th>
						<th> Remark </th>
					</tr>
					
					
						<?php if(isset($students) && !empty($students)){  
		foreach($students as $work){    ?> 
										<tr>
						<td>
						<input type="hidden" name="tt_id" value="<?php echo $ttid; ?>">
						<input type="hidden" name="day" value="<?php echo $weekofday; ?>">
						<input type="hidden" name="date" value="<?php echo $dates; ?>">
						
						
						<label><input type="checkbox" id="chk<?php echo $work['id']; ?>" class="StuAttendCk" name="stud_id[<?php echo $work['id']; ?>]" value="<?php echo $work['id']; ?>" checked="" onclick="check(<?php echo $work['id']; ?>)"> </label></td>
												<td><?php echo $work['id']; ?></td>
						<td><?php echo $work['fname']; ?> <?php echo $work['middlename']; ?> <?php echo $work['lname']; ?></td>
						<td><div class="form-group field-1">
<div class="col-lg-6">
	<input type="text" id="<?php echo $work['id']; ?>" class="abs_remark form-control" name="remark[<?php echo $work['id']; ?>]" disabled="" maxlength="50" style="height:30px !important;" placeholder="Enter Absent remark"></div>
</div></td>
					</tr>
									<?php } } ?>
																			</tbody></table>
				</div>
			</div>
			<div class="box-footer">
							
		<?php
				if(isset($classes['id'])){
				echo $this->Form->submit(
				    'Take Attendance', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
				); }else{ 
				echo $this->Form->submit(
				    'Take Attendance', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Add')
				);
				}
		       ?>
		       	<?php
			echo $this->Html->link('Back', [
			    'action' => 'index'
			   
			],['class'=>'btn btn-default']); ?>
		      </div>
		      <!-- /.box-footer -->
		  <?php echo $this->Form->end(); ?>
		      </div>
		      <!-- /.box-body -->
		     
		
		      
		
        
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
<script>
$(document).ready(function(){
$('#c-id').on('change',function(){
var id = $('#c-id').val();
//alert(id);
 $.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL ;?>cities/find_state',
        data: {'id':id}, 
        success: function(data){  
alert(data);
 $('#s-id').empty();
  $('#s-id').html(data);
        }, 
        
    });  
});
});

</script>


