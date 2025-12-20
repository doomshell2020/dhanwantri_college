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
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title">Search Student List</h3>
     
            </div>
    
            <!-- /.box-header -->
<?php echo $this->Flash->render(); ?>
            <div class="box-body">
		

<div class="manag-stu">
	
	 <?php echo $this->Form->create('Studattends',array('url'=>array('controller'=>'Studattends','action'=>'attendence'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>


  
  
  
  
  
  <div class="form-group">
    
    <div class="col-sm-4">
 <label>Select Class</label><span style="color:red;">*</span>
   	<?php if($seletedclassid){  echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Class','options'=>$classes,'value'=>$seletedclassid,'label' =>false,'required')); }else{  
		echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Class','options'=>$classes,'label' =>false,'required'));
		} ?>
    </div>  

   <div class="col-sm-4">
 <label>Select Section</label><span style="color:red;">*</span>
   	<?php 
   	
   	if($seletedsectionid) { 
   	 echo $this->Form->input('section_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Section','options'=>$sectionselectlist,'value'=>$seletedsectionid,'label' =>false,'required')); }else if($sectionsg){
		 
		  	 echo $this->Form->input('section_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Section','options'=>$sectionsg,'value'=>$seletedsectioid,'label' =>false,'required')); 
		 
		 }else{
		 
		 echo $this->Form->input('section_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Section','options'=>$sectionslist,'label' =>false,'required')); 
		 
		 } ?>  
    </div>  
     <div class="col-sm-4">
 <label>Select Academic Year</label><span style="color:red;">*</span>
    <select class="form-control" name="academic" required='required'>
  <?= $year=date('Y'); echo $year; $exyear=$year+4; ?>
  <option value="">Select Year</option>
  <?php for ($i = $year; $i <= $exyear; $i++) :  $rt=$i+1; $rt= substr($rt,2);?> 
    <option <?php if($i==$year){ ?>selected <?php } ?>value="<?php echo $i; ?>-<?php echo  $rt;?>"><?php echo $i; ?>-<?php echo  $rt;?></option>
  <?php endfor; ?>
</select>
    </div>  
    <script>
$(document).ready(function(){
$('#class-id').on('change',function(){
var id = $('#class-id').val();
//alert(id);
 $.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL ;?>ClasstimeTabs/find_section',
        data: {'id':id}, 
        success: function(data){  

 $('#section-id').empty();
  $('#section-id').html(data);
        }, 
        
    });  
});
});

</script>

    <div class="col-sm-4" style="top: 22px;">
      <button type="submit" class="btn btn-success">Search</button>
       <button type="reset" class="btn btn-primary">Reset</button>
    </div>
  </div>
     <?php
echo $this->Form->end();
?>   
  
</div>
				
				</div>
				
					</div>	</div>	</div>
		
		
		
		
		
		
		<?php if($classtitle) { ?>
		
      <div class="row">
       
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		    
		      <span class="text-muted" style="padding-left: 10px; font-size: 15px;">
		
			<strong>Class Name : </strong><?php echo $classtitle; ?> | <strong>Section Name : </strong><?php echo $sectiontitle; ?> 		 | <strong>Acedmicyear : </strong><?php echo $academic; ?> 	</span>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render();   ?>
 <script>
  $(function () {


  $('#datepicks').datepicker({
	 
	  
	  "changeMonth":true,'maxDate':'0',"yearRange":"1980:2018","changeYear":true,"autoSize":true,"dateFormat":"yy-mm-dd",onSelect: function(){
        var selected = $(this).val();
        $('.datepicks').val(selected);
        $('#stud-attendance-form').submit();
        
        }});
	  });
           </script>
		
		      <div class="box-body">
	 <form id="stud-attendance-form" action="school/admin/Studattends/add" method="post">
		<div class="row">
			<div class="col-sm-4">
        		<div class="form-group field-stuattendance-sa_date ">
<label class="control-label" for="stuattendance-sa_date">Date</label>
<input type="text" id="datepicks" class="form-control" name="StuAttendance[sa_date]"   value="" readonly="">


</div>			</div>
		</div> <!-- /.row -->
		</form>
		  
		   
	<div class="row">
				<div class="col-lg-12">
					 <form id="stud-attendance-form" action="<?php echo SITE_URL; ?>admin/Studattends/add" method="post">
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
					
						<input type="hidden" name="date" class="datepicks" value="<?php echo $dates; ?>">
						
						
						<label><input type="checkbox" id="chk<?php echo $work['id']; ?>" class="StuAttendCk" name="stud_id[]" value="<?php echo $work['id']; ?>" checked="" onclick="check(<?php echo $work['id']; ?>)"> </label></td>
												<td><?php echo $work['id']; ?></td>
						<td><?php echo $work['fname']; ?> <?php echo $work['middlename']; ?> <?php echo $work['lname']; ?></td>
						<td><div class="form-group field-1">
<div class="col-lg-6">
	<input type="text" id="<?php echo $work['id']; ?>" class="abs_remark form-control" name="remark[<?php echo $work['id']; ?>]" disabled="" maxlength="50" style="height:30px !important;" placeholder="Enter Absent remark"></div>
</div></td>
					</tr>
									<?php } } ?>
												</tbody></table>
												<?php echo $this->Form->submit(
				    'Take Attendance', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
				); ?>
														</form>
				</div>
			</div>
			<div class="box-footer">
							
		
		       	<?php
			echo $this->Html->link('Back', [
			    'action' => 'attendence2'
			   
			],['class'=>'btn btn-default']); ?>
		      </div>
		      <!-- /.box-footer -->
	
		      </div>
		      <!-- /.box-body -->
		     
		
		      
		
        
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
      <?php } ?>
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


