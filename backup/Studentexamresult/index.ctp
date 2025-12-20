
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Assign Fee Manager
       
      </h1>
      
    </section>




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

		window.check = function (sid,id) {
		    var ck = 'chk'+sid+id;
		     var cks = 's'+sid+id;
		         var id1 = 'pd'+sid+id;
		    var chkbox = document.getElementById(ck);
		    if(chkbox.checked)
		    {
				
				  $(".addgen").css("display","block"); 
				
		
		var idf=+$('.tamount').text() + +id;
		$('.tamount').text(idf);
			    document.getElementById(cks).disabled = false;
		    document.getElementById(id1).disabled = false;
		        document.getElementById(id1).required = true;
		    }
		    else{
		        var idf=$('.tamount').text() - id;
		        $('.tamount').text(idf);
		         document.getElementById(cks).disabled = true;
		            document.getElementById(id1).disabled = true;
		        document.getElementById(id1).required = false;
		    }

		    if($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
		        $('.check-all').prop('checked', true);
		    } else {
		        $('.check-all').prop('checked', false);
		    }
		};
		
		window.check12 = function (name) {
		    var ck12 = 'chk12'+name;
		     var cks12 = 's12'+name;
		         var id12 = 'pd12'+name;
		    var chkbox = document.getElementById(ck12);
		    if(chkbox.checked)
		    {
				
		

			    document.getElementById(cks12).disabled = false;
		    document.getElementById(id12).disabled = false;
		        document.getElementById(id12).required = true;
		    }
		    else{
		      
		      
		         document.getElementById(cks12).disabled = true;
		            document.getElementById(id12).disabled = true;
		        document.getElementById(id12).required = false;
		    }

		    if($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
		        $('.check-all').prop('checked', true);
		    } else {
		        $('.check-all').prop('checked', false);
		    }
		};
		
		
		
		window.check1 = function (sid,id) {
			
		    var ck1 = 'chk1'+sid+id;
		    var id1 = 'pd'+sid+id;
		     var cks1 = 's'+sid+id;
		    var chkbox2 = document.getElementById(ck1);
		    if(chkbox2.checked)
		    {
				
		
		var idf1=+$('.tamount1').text() + +id;
		$('.tamount1').text(idf1);
			    document.getElementById(cks1).disabled = false;
		    document.getElementById(id1).disabled = false;
		        document.getElementById(id1).required = true;
		    }
		    else{
		        var idf1=$('.tamount1').text() - id;
		        $('.tamount1').text(idf1);
		      
		         document.getElementById(cks1).disabled = true;
		            document.getElementById(id1).disabled = true;
		        document.getElementById(id1).required = false;
		    }

		    if($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
		        $('.check-all').prop('checked', true);
		    } else {
		        $('.check-all').prop('checked', false);
		    }
		};
		
		
		
			window.checks = function (id) {
			
	
			var doc=$('input[name="mode"]:checked').val();
			if(doc=="Cash"){
			
				  $("#che").css("display","none"); 
				  $("#bnk").css("display","none"); 
			
		        document.getElementById('chequno').required = false;
		        document.getElementById('bank').required = false;
				
				}else{
					
					  $("#che").css("display","block"); 
				  $("#bnk").css("display","block"); 
			
		        document.getElementById('chequno').required = true;
		        document.getElementById('bank').required = true;
					
					}
			
			}
				window.checks1 = function (id) {
			
	
			var doc1=$('input[name="modes"]:checked').val();
			if(doc1=="Cash"){
			
				  $("#che1").css("display","none"); 
				  $("#bnk1").css("display","none"); 
			
		        document.getElementById('chequno1').required = false;
		        document.getElementById('bank1').required = false;
				
				}else{
					
					  $("#che1").css("display","block"); 
				  $("#bnk1").css("display","block"); 
			
		        document.getElementById('chequno1').required = true;
		        document.getElementById('bank1').required = true;
					
					}
			
			}
			
			window.checks12 = function (id) {
			
	
			var doc12=$('input[name="modes1"]:checked').val();
			if(doc12=="Cash"){
			
				  $("#che12").css("display","none"); 
				  $("#bnk12").css("display","none"); 
			
		        document.getElementById('chequno12').required = false;
		        document.getElementById('bank12').required = false;
				
				}else{
					
					  $("#che12").css("display","block"); 
				  $("#bnk12").css("display","block"); 
			
		        document.getElementById('chequno12').required = true;
		        document.getElementById('bank12').required = true;
					
					}
			
			}

		$( '.stuattendance-sa_date' ).datepicker({
			
		   maxDate : 0, changeMonth : true, dateFormat: 'dd-mm-yy',
		   onSelect : function(){
		        $('#stud-attendance-form').submit();
			}
	   });
	});</script>
	<?php if($selectid) { ?>

<script>
var id ='<?php echo $selectid; ?>';
$(document).ready(function() {
	
	
	  $('#personal-tab').removeClass('active');
	  $('.tab-pane').removeClass('active');
	   $('#'+id+'-tab').addClass('active');
	      $('#'+id).addClass('active');

    });



</script>



<?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
       <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		      <h3 class="box-title">Student Fee Structure </h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->
                   <div class="box-body">
                     <?php echo $this->Flash->render(); ?>
		    <section class="content-header container-fluid">
        <h3 class="col-sm-4">
         <i class="fa fa-exchange"></i> Assign Fee Student | <small><?php echo ucfirst($students['fname']); ?> <?php echo $students['middlename']; ?></small>        </h3>
        <ul class="breadcrumb col-sm-8"><li><a href="#"><i class="fa fa-home"></i>Home</a></li>
<li><a href="#">Student</a></li>
<li><a href="#">Manage Student</a></li>
<li class="active"><?php echo ucfirst($students['fname']); ?> <?php echo $students['middlename']; ?></li>
</ul>    </section>
    <section class="content">
        
<div class="row edusec-user-profile">
	<div class="col-sm-12">
		<ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="profileTab">
			<li class="active" id="personal-tab"><a href="http://demo.edusec.org/student/stu-master/view?id=38#personal" data-toggle="tab"><i class="fa fa-street-view"></i> General Fee</a></li><?php if($is_transport=='1'){ ?>
			<li id="academic-tab"><a href="http://demo.edusec.org/student/stu-master/view?id=38#academic" data-toggle="tab"><i class="fa fa-bus"></i> Transport Fee</a></li>
			<?php } ?>
			<?php if($is_hostel=='1'){ ?>
			<li id="guardians-tab"><a href="http://demo.edusec.org/student/stu-master/view?id=38#guardians" data-toggle="tab"><i class="fa fa-bed"></i> Hostal Fee</a></li>
		<?php } ?>
			
			
		</ul>
		

		<div id="content" class="tab-content responsive hidden-xs hidden-sm">
		
			<div class="tab-pane active" id="personal">
					<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_form" validate="validate" action="<?php echo ADMIN_URL; ?>studentfees/add">
<h3 class="page-header edusec-border-bottom-primary">
	<i class="fa fa-info-circle"></i> Fee Structure	
</h3>

		   
	<div class="row">
				<div class="col-lg-12">
	  		<table class="table table-striped table-hover" id="mytable">
				
					<tbody>
				
					<tr class="table_header">
						<th class="text-center bg-teal color-palette" style="width:150px"></th>
					
						<th class="text-left bg-teal color-palette"> Quater  </th>
						<th class="text-left bg-teal color-palette"> Amount </th>
						<th class="text-left bg-teal color-palette"> Paydate </th>
						<th class="text-left bg-teal color-palette"> Payment Mode </th>
					</tr>
					
					
						<?php $def=0; foreach($studentfees as $value){
							$qua[]=$value['quarter'];
							}  if(isset($classfee ) && !empty($classfee )){  
		for($i=1;$i<5;$i++)
				{     ?> 
										<tr>
						<td>
						
						
						
						<label><input type="hidden"  name="student_id" value="<?php echo $id; ?>" >
					<?php if (!in_array("Quater".$i, $qua))
  { if($classfee[0]['qu'.$i.'_fees'] != 0){ $def=1;  ?>
						<input type="checkbox" id="chk<?php echo $i; ?><?php echo $classfee[0]['qu'.$i.'_fees']; ?>" class="StuAttendCk" name="amount[]" value="<?php echo $classfee[0]['qu'.$i.'_fees']; ?>"  onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu'.$i.'_fees']; ?>)"> <?php } }else{ ?><input type="checkbox"  class="StuAttendCk"  checked="checked" readonly disabled  ><?php } ?></label></td>
						<td> 	<input type="text"  style="
    background-color: transparent;
    border: none;
" name="quater[]" id="s<?php echo $i; ?><?php echo $classfee[0]['qu'.$i.'_fees']; ?>" value="Quater<?php echo $i; ?>" readonly disabled="" ></td>
												<td><?php echo $classfee[0]['qu'.$i.'_fees']; ?></td>
					
						<td><div class="form-group field-1">
<div class="col-lg-6">
	<?php if (!in_array("Quater".$i, $qua))
  {  ?>
	<input type="text" id="pd<?php echo $i; ?><?php echo $classfee[0]['qu'.$i.'_fees']; ?>" class="abs_remark form-control stuattendance-sa_date"  name="paydate[]" disabled="" maxlength="50" style="height:30px !important;" placeholder="Enter Paydate"><?php }else{  $paydatevalue=$this->Comman->findfeesallocation("Quater".$i,$id);  ?> 
	
	<input type="text" style="
    background-color: transparent;
    border: none;
" id="<?php echo $classfee[0]['qu'.$i.'_fees']; ?>" class="abs_remark form-control stuattendance-sa_date"  name="paydate[]" value="<?php echo $paydatevalue['paydate']; ?>" disabled="" maxlength="50" style="height:30px !important;" placeholder="Enter Paydate">
	
	
	<?php } ?></div>
</div></td>
			
						<td><div class="form-group field-1">
<div class="col-lg-6">
	<?php if (!in_array("Quater".$i, $qua))
  {  ?>
	-<?php }else{ 
		 $paydatevalue=$this->Comman->findfeesallocation("Quater".$i,$id); 
		 echo $paydatevalue['mode']; 
	  ?> <?php if($paydatevalue['mode']=="Cheque") { ?></br>No. (<?php echo $paydatevalue['cheque_no'];  ?>) <?php  } } ?></div>
</div></td>
	
					</tr>
									<?php } ?> <?php if($def=='1'){ ?><tr><td colspan="4">
										
										
										<b>Total Amount  = </b> <span class="tamount">0</span></td></tr>
									 <tr><td colspan="4"><b>Mode: </b>    <span><label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="Cash" onclick="return checks(this);">Cash</label><label class="radio-inline"><input type="radio" name="mode" required id="radio2"  onclick="return checks(this);"  value="Cheque">Cheque</label></span></td></tr>
									 <tr id="che"><td><b>Cheque No.</b><input type="text"   id="chequno" onclick="checks(1)" name="cheque_no" ></td></tr><tr id="bnk"><td><b>Bank</b><?php  echo $this->Form->input('bank_id',array('class'=>'form-control','id'=>'bank','type'=>'select','empty'=>'Select Bank','options'=>$banks,'label'=>false)); ?></td></tr><?php  } } ?>
									
																			</tbody></table>
				</div>
			</div>
			<div class="box-footer">
							
		<?php if($def=='1'){
				if(isset($classes['id'])){
				echo $this->Form->submit(
				    'Add Fee', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
				); }else{ 
				echo $this->Form->submit(
				    'Add Fee', 
				    array('class' => 'btn btn-info pull-right addgen', 'title' => 'Add','style'=>'display:none;')
				);
				} }
		       ?>
		       	<?php
			echo $this->Html->link('Back', [
			    'action' => 'view'
			   
			],['class'=>'btn btn-default']); ?>
			
		      </div>
		      	  <?php echo $this->Form->end(); ?>
		      <!-- /.box-footer -->
	
			</div>
			<?php if($is_transport=='1'){ ?>
			<div class="tab-pane" id="academic">
			<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_form" validate="validate" action="<?php echo ADMIN_URL; ?>studentfees/addtransport">
<h3 class="page-header edusec-border-bottom-primary">
	<i class="fa fa-info-circle"></i> Transport Fee Structure	
</h3>

		   
	<div class="row">
				<div class="col-lg-12">
	  		<table class="table table-striped table-hover" id="mytable">
				
					<tbody>
				
					<tr class="table_header">
						<th class="text-left bg-teal color-palette" style="width:150px"></th>
					
						<th class="text-left bg-teal color-palette"> Quater  </th>
						<th class="text-left bg-teal color-palette"> Amount </th>
						<th class="text-left bg-teal color-palette"> Paydate </th>
						<th class="text-left bg-teal color-palette"> Payment Mode </th>
					</tr>
					
					
						<?php $def=0;  foreach($studenttransfee as $values){
							$quatrans[]=$values['quarter'];
							}   if(isset($transportfeess ) && !empty($transportfeess )){  
		for($i=1;$i<5;$i++)
				{    ?> 
										<tr>
						<td>
						
						
						
						<label><input type="hidden"  name="student_id" value="<?php echo $id; ?>" >
					<?php if (!in_array("Quater".$i, $quatrans))
  { if($transportfeess[0]['qu'.$i.'_fees'] != 0){ $def=1;  ?>
						<input type="checkbox" id="chk1<?php echo $i; ?><?php echo $transportfeess[0]['qu'.$i.'_fees']; ?>" class="StuAttendCk" name="amount[]" value="<?php echo $transportfeess[0]['qu'.$i.'_fees']; ?>"  onclick="check1(<?php echo $i; ?>,<?php echo $transportfeess[0]['qu'.$i.'_fees']; ?>)"><?php } }else{ ?><input type="checkbox"  class="StuAttendCk"  checked="checked" readonly  disabled><?php }  ?> </label></td>
						<td> 	<input type="text" style="
    background-color: transparent;
    border: none;
"  name="quater[]" id="s<?php echo $i; ?><?php echo $transportfeess[0]['qu'.$i.'_fees']; ?>" value="Quater<?php echo $i; ?>" readonly disabled="" ></td>
												<td><?php echo $transportfeess[0]['qu'.$i.'_fees']; ?></td>
					
						<td><div class="form-group field-1">
<div class="col-lg-6">
	<?php if (!in_array("Quater".$i, $quatrans))
  { ?>
	<input type="text"  id="pd<?php echo $i; ?><?php echo $transportfeess[0]['qu'.$i.'_fees']; ?>" class="abs_remark form-control stuattendance-sa_date"  name="paydate[]" disabled="" maxlength="50" style="height:30px !important;" placeholder="Enter Paydate">
	<?php }else{ $paydatevalues=$this->Comman->findtransportfeesallocation("Quater".$i,$id);  ?>
	
		<input type="text" style="
    background-color: transparent;
    border: none;
" id="pd<?php echo $i; ?><?php echo $transportfeess[0]['qu'.$i.'_fees']; ?>" class="abs_remark form-control stuattendance-sa_date"  value="<?php echo $paydatevalues['paydate']; ?>"  name="paydate[]" disabled="" maxlength="50" style="height:30px !important;" placeholder="Enter Paydate">
	
	
	<?php } ?>
	
	
	
	</div>
</div></td>
			
				
						<td><div class="form-group field-1">
<div class="col-lg-6">
	<?php if (!in_array("Quater".$i, $quatrans))
  {  ?>
	-<?php }else{ 
		 $paydatevalues=$this->Comman->findtransportfeesallocation("Quater".$i,$id); 
		 echo $paydatevalues['mode']; 
	  ?> <?php if($paydatevalues['mode']=="Cheque") { ?></br>No. (<?php echo $paydatevalues['cheque_no'];  ?>) <?php  } } ?></div>
</div></td>
	
					</tr>
									<?php } ?> <?php if($def=='1'){ ?> <tr><td colspan="4">
										
										
										<b>Total Amount  = </b> <span class="tamount1">0</span></td></tr>
									 <tr><td colspan="4"><b>Mode: </b>    <span><label class="radio-inline"><input type="radio" required id="radio1" name="modes" value="Cash" onclick="return checks1(this);">Cash</label><label class="radio-inline"><input type="radio" name="modes" required id="radio2"  onclick="return checks1(this);"  value="Cheque">Cheque</label></span></td></tr>
									 <tr id="che1"><td><b>Cheque No.</b><input type="text"   id="chequno1"  name="cheque_no" ></td></tr><tr id="bnk1"><td><b>Bank</b><?php  echo $this->Form->input('bank_id',array('class'=>'form-control','id'=>'bank1','type'=>'select','empty'=>'Select Bank','options'=>$banks,'label'=>false)); ?></td></tr><?php }  } ?>
									
																			</tbody></table>
				</div>
			</div>
			<div class="box-footer">
							
		<?php if($def=='1'){
				if(isset($classes['id'])){
				echo $this->Form->submit(
				    'Add Fee', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
				); }else{ 
				echo $this->Form->submit(
				    'Add Fee', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Add')
				);
				} }
		       ?>
		       	<?php
			echo $this->Html->link('Back', [
			    'action' => 'view'
			   
			],['class'=>'btn btn-default']); ?>
			
		      </div>
		      	  <?php echo $this->Form->end(); ?>
			</div>
			
			<?php } ?>
			<?php if($is_hostel=='1'){ ?>
			<div class="tab-pane" id="guardians">
	<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_form" validate="validate" action="<?php echo ADMIN_URL; ?>studentfees/addhostal">
<h3 class="page-header edusec-border-bottom-primary">
	<i class="fa fa-info-circle"></i> Hostal Fee Structure	
</h3>

		   
	<div class="row">
				<div class="col-lg-12">
	  		<table class="table table-striped table-hover" id="mytable">
				
					<tbody>
				
					<tr class="table_header">
						<th class="text-left bg-teal color-palette" style="width:150px"></th>
					
						<th class="text-left bg-teal color-palette"> Hostal Name  </th>
						<th class="text-left bg-teal color-palette"> Amount </th>
						<th class="text-left bg-teal color-palette"> Paydate </th>
						<th class="text-left bg-teal color-palette"> Payment Mode </th>
					</tr>
					
					
						<?php  $def=0;   if(isset($hostalfeess ) && !empty($hostalfeess )){  
		for($i=1;$i<2;$i++)
				{    ?> 
										<tr>
						<td>
						
						
						
						<label><input type="hidden"  name="student_id" value="<?php echo $id; ?>" >
						<input type="hidden"  name="h_id" value="<?php echo $hostalfeess[0]['id']; ?>" >
			<?php if($studenthostalfee[0]['student_id']==$id){ ?>
			<input type="checkbox"  class="StuAttendCk"  checked="checked" readonly  disabled>
			<?php }else{ $def =1;?>
						<input type="checkbox" id="chk12<?php echo $hostalfeess[0]['name']; ?>" class="StuAttendCk" name="amount" value="<?php echo $hostalfeess[0]['fees']; ?>"  onclick="check12('<?php echo $hostalfeess[0]['name']; ?>')"> <?php } ?></label></td>
						<td> 	<input type="text"  style="
    background-color: transparent;
    border: none;
" name="h_name" id="s12<?php echo $hostalfeess[0]['name']; ?>" value="<?php echo $hostalfeess[0]['name']; ?>" readonly disabled="" ></td>
												<td><?php echo $hostalfeess[0]['fees']; ?></td>
					
						<td><div class="form-group field-1">
<div class="col-lg-6">
	<?php if($studenthostalfee[0]['student_id']==$id){  $paydatevaluess=$this->Comman->findhostalfeesallocation($id,$studenthostalfee[0]['h_id']); ?>
		<input type="text" style="
    background-color: transparent;
    border: none;
" id="pd12<?php echo $hostalfeess[0]['name']; ?>" class="abs_remark form-control stuattendance-sa_date"  name="paydate" value="<?php echo $paydatevaluess['paydate']; ?>" disabled="" maxlength="50" style="height:30px !important;" placeholder="Enter Paydate">
	
	<?php }else{ ?>
		<input type="text"  id="pd12<?php echo $hostalfeess[0]['name']; ?>" class="abs_remark form-control stuattendance-sa_date"  name="paydate" disabled="" maxlength="50" style="height:30px !important;" placeholder="Enter Paydate">
	
	
	<?php } ?>

	
	<td><div class="form-group field-1">
<div class="col-lg-6">
	<?php if($studenthostalfee[0]['student_id']==$id){ 
 $paydatevaluess=$this->Comman->findhostalfeesallocation($id,$studenthostalfee[0]['h_id']);
		 echo $paydatevalues['mode']; 
	  ?> <?php if($paydatevalues['mode']=="Cheque") { ?></br>No. (<?php echo $paydatevalues['cheque_no'];  ?>) <?php   } } ?></div>
</div></td>
	
	
	</div>
</div></td>
			
				
						
	
					</tr>
									<?php } ?><?php if($def=='1'){ ?> <tr><td colspan="4">
										
										
										<b>Total Amount  = </b> <span class="tamount12" ><?php echo $hostalfeess[0]['fees']; ?></span></td></tr>
									 <tr><td colspan="4"><b>Mode: </b>    <span><label class="radio-inline"><input type="radio" required id="radio1" name="modes1" value="Cash" onclick="return checks12(this);">Cash</label><label class="radio-inline"><input type="radio" name="modes1" required id="radio2"  onclick="return checks12(this);"  value="Cheque">Cheque</label></span></td></tr>
									 
									 <tr id="che12"><td><b>Cheque No.</b><input type="text"   id="chequno12"  name="cheque_no" ></td></tr><tr id="bnk12"><td><b>Bank</b><?php  echo $this->Form->input('bank_id',array('class'=>'form-control','id'=>'bank12','type'=>'select','empty'=>'Select Bank','options'=>$banks,'label'=>false)); ?></td></tr><?php } } ?>
									
																			</tbody></table>
				</div>
			</div>
			<div class="box-footer">
							
		<?php if($def=='1'){
				if(isset($classes['id'])){
				echo $this->Form->submit(
				    'Add Fee', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
				); }else{ 
				echo $this->Form->submit(
				    'Add Fee', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Add')
				);
				} }
		       ?>
		       	<?php
			echo $this->Html->link('Back', [
			    'action' => 'view'
			   
			],['class'=>'btn btn-default']); ?>
			
		      </div>
		      	  <?php echo $this->Form->end(); ?>
<?php } ?>
			</div>
			

    </section>
    
      <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="loader">
                                <div class="es-spinner">
                                    <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
		
		        
		      </div>
		      <!-- /.box-body -->
		    
		      <!-- /.box-footer -->
		  
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>




