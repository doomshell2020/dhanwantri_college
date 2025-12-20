<!-- Content Wrapper. Contains page content -->
<!-- Content Wrapper. Contains page content -->
<style>
   .checkbox input[type="checkbox"] {
   opacity: 1;
   }
   #sel_date {
   z-index: 99999,
   opacity:1,
   }
   #load2 {
   width: 100%;
   height: 100%;
   position: fixed;
   z-index: 9999;
   background-color: white !important;
   background: url("<?use function PHPSTORM_META\type;echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
   }
   .content {
   min-height: 0px !important;
   }
</style>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
   $(function() {
   	$('.check-all').click(function() {
   		if (this.checked) {
   			$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', true);
   			$(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
   			$(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);
   		} else {
   			$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', false);
   			$(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
   			$(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
   		}
   	});
   
   	window.check = function(id) {
   		var ck = 'chk' + id;
   		var chkbox = document.getElementById(ck);
   		if (chkbox.checked) {
   			document.getElementById(id).disabled = true;
   			document.getElementById(id).required = false;
   			document.getElementById(id).value = '';
   		} else {
   			document.getElementById(id).disabled = false;
   			document.getElementById(id).required = true;
   		}
   
   		if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
   			$('.check-all').prop('checked', true);
   		} else {
   			$('.check-all').prop('checked', false);
   		}
   	};
   
   
   });
</script>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Take Staff Attendance <?php echo date('d-m-Y'); ?>
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>students/staffattendance"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>students/staffattendance">Manage Staff Attendance</a></li>
   </ol>
   <div id="load2" style="display:none;"></div>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">
      <?php echo $this->Flash->render(); ?>
      <!-- right column -->
      <div class="col-md-12">
         <!-- Horizontal Form -->
         <div class="box box-info">
            <div class="box-header">
               <script>
                  $(document).ready(function() {
                  	$("#selectdate").bind("submit", function(event) {
                  		// $('.lds-facebook').show();
                  		$.ajax({
                  			async: true,
                  			data: $("#selectdate").serialize(),
                  			dataType: "html",
                  			type: "POST",
                  			beforeSend: function() {
                  				// setting a timeout
                  				$('#load2').css("display", "block");
                  			},
                  			url: "<?php echo ADMIN_URL; ?>students/searchstaffattend",
                  			success: function(data) {
                  				$('#load2').css("display", "none");
                  				$("#updt").html(data);
                  			},
                  		});
                  		return false;
                  	});
                  
                  	15
                  
                  	$(function() {
                  		$("#datepicker").datepicker({
                  			changeYear: true,
                  			dateFormat: 'dd-mm-yy',
                  			maxDate: new Date(),
                  		});
                  	});
                  
                  });
               </script>
               <?php echo $this->Form->create('selectdate', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'selectdate', 'class' => '')); ?>
               <div class="form-group pull-left" style="display:flex; align-items:flex-end; margin-bottom:0px;">
                  <div style="margin-right:10px;">
                     <label for="inputEmail3" class="control-label">Select Date</label>
                     <input type="text" class="form-control datepicker" id='datepicker' autocomplete="off" name="selectdate" placeholder="DD-MM-YYYY" required>
                  </div>
                  <input type="submit" style="background-color:#00c0ef; color:#fff" id="selectdate" class="btn btn4 btn_pdf myscl-btn date" value="Search">
               </div>
               <div style="clear-both"></div>
            </div>
            <?php echo $this->Flash->render();   ?>
            <script>
               $(function() {
               	$('#datepicks').datepicker({
               		"changeMonth": true,
               		'maxDate': '0',
               		"yearRange": "1980:2018",
               		"changeYear": true,
               		"autoSize": true,
               		"dateFormat": "yy-mm-dd",
               		onSelect: function() {
               			var selected = $(this).val();
               			$('#stud-attendance-form').submit();
               
               		}
               	});
               });
            </script>
            <div class="box-body">
               <?php echo $this->Form->create('Staffattends', array('url' => array('controller' => 'Students', 'action' => 'attendence'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'stud-attendance-form', 'class' => '')); ?>
               <div class="row">
                  <div class="col-sm-4">
                     <div class="form-group field-stuattendance-sa_date ">
                        <input type="hidden" name="academic" class="" value="<?php echo $academics; ?>">
                        <?php if ($dates) { ?>
                        <input type="hidden" id="datepicksf" class="form-control" name="date" required="required" value="<?php echo $dates; ?>" readonly="readonly">
                        <?php } else { ?>
                        <input type="hidden" id="datepicksf" class="form-control" name="date" required="required" value="<?php echo date('Y-m-d'); ?>" readonly="readonly">
                        <?php } ?>
                     </div>
                  </div>
               </div>
               <!-- /.row -->
               </form>
               <div class="row" id="updt" class="table-responsive">
                  <div class="col-lg-12">
                     <form id="studttendance-form" action="<?php echo SITE_URL; ?>admin/Students/addstaffattendance" method="post">
                        <table class="table table-striped table-hover" id="mytable">
                           <tbody>
                              <tr class="table_header" style="color: green;">
                           <thead>
                              <th>
                                 <?php if (isset($attedenceall) && !empty($attedenceall)) { ?>
                                 <input type="checkbox" class="check-all" checked=""> For Absent
                                 <?php } else { ?>
                                 <input type="checkbox" class="check-all"> For Absent
                                 <?php } ?>
                              </th>
                              <th> Staff Name </th>
                           </thead>
                           </tr>
                           <?php if (isset($attedenceall) && !empty($attedenceall)) {
                              foreach ($attedenceall as $work) {
                              ?>
                           <tr class="stuname" style="cursor:pointer;">
                              <td>
                                 <?php if ($dates) { ?>
                                 <input type="hidden" name="date" required="required" class="datepicks" value="<?php echo $dates; ?>">
                                 <?php } else { ?>
                                 <input type="hidden" name="date" required="required" class="datepicks" value="<?php echo date('Y-m-d'); ?>">
                                 <?php } ?>
                                 <input type="hidden" name="academic" class="" value="<?php echo $academic; ?>">
                                 <label><input type="checkbox" id="chk<?php echo $work['id']; ?>" class="StuAttendCk" name="emp_id[]" value="<?php echo $work['emp_id']; ?>" <?php if ($work['status'] == 'A') { ?>checked="checked" <?php } ?>> </label>
                              </td>
                              <td><b><?php echo $work['employee']['fname']; ?> <?php echo $work['employee']['middlename']; ?> <?php echo $work['employee']['lname']; ?></b></td>
                           </tr>
                           <?php }
                              } else {
                              	if (isset($studentsarry) && !empty($studentsarry)) {
                              		foreach ($studentsarry as $krrt => $work) {
                              
                              		?>
                           <tr class="stunames" style="cursor:pointer;">
                              <td>
                                 <?php if ($dates) { ?>
                                 <input type="hidden" name="date" required="required" class="datepicks" value="<?php echo $dates; ?>">
                                 <?php } else { ?>
                                 <input type="hidden" name="date" required="required" class="datepicks" value="<?php echo date('Y-m-d'); ?>">
                                 <?php } ?>
                                 <input type="hidden" name="academic" class="" value="<?php echo $academic; ?>">
                                 <label><input type="checkbox" id="chk<?php echo $work['id']; ?>" class="StuAttendCk" name="emp_id[]" value="<?php echo $work['id']; ?>"> </label>
                              </td>
                              <td>
                                 <b><?php echo $work['fname']; ?> <?php echo $work['middlename']; ?> <?php echo $work['lname']; ?></b>
                              </td>
                           </tr>
                           <?php }
                              }
                              } ?>
                           </tbody>
                        </table>
                        <?php echo $this->Form->submit(
                           'Take Attendance',
                           array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                           ); ?>
                     </form>
                  </div>
               </div>
               <div class="box-footer">
               </div>
               <!-- /.box-footer -->
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
   $(document).ready(function() {
   	$('#c-id').on('change', function() {
   		var id = $('#c-id').val();
   		//alert(id);
   		$.ajax({
   			type: 'POST',
   			url: '<?php echo ADMIN_URL; ?>cities/find_state',
   			data: {
   				'id': id
   			},
   			success: function(data) {
   
   				$('#s-id').empty();
   				$('#s-id').html(data);
   			},
   
   		});
   	});
   	$('.stuname').click(function() {
   		$(this).find('input:checkbox').each(function() {
   			if (this.checked) this.checked = false; // toggle the checkbox
   			else this.checked = true;
   		})
   	});
   });
</script>