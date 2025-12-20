<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <i class="fa fa-info-circle"></i> Genrate ID Student        
   </h1>
   <ul class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL;?>students/index">Manage Student</a></li>
      <li class="active">Genrate ID Student</li>
   </ul>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <i class="fa fa-search" aria-hidden="true"></i>
               <h3 class="box-title">Search Student</h3>
            </div>
            <!-- /.box-header -->
            <?php echo $this->Flash->render(); ?>
            <div class="box-body">
               <div class="manag-stu">
                  <script inline="1">
                     //<![CDATA[
                     $(document).ready(function () {
                     $("#TaskAdminCustomerForm").bind("submit", function (event) {
                     $.ajax({
                     async:true,
                      data:$("#TaskAdminCustomerForm").serialize(),
                      dataType:"html", 
                     
                     success:function (data, textStatus) {
                     
                     $("#example2").html(data);   $('#selectr').show();}, 
                     type:"POST", 
                     url:"<?php echo SITE_URL; ?>admin/Students/genrateidsearch"});
                     return false;
                     });
                     });
                     //]]>
                  </script>
                  <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'ClasstimeTabs','action'=>'viewtimetable'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>
                  <div class="form-group">
                     <div class="col-sm-2">
                        <label>Select Class</label>
                        <?php 
                           echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','empty'=>'Class','options'=>$classes,'label' =>false,));
                            ?>
                     </div>
                     <div class="col-sm-2">
                        <label>Select Section</label>
                        <?php 
                           echo $this->Form->input('section_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Section','options'=>$sectionslist,'label' =>false)); 
                           
                            ?>  
                     </div>
                     <div class="col-sm-2">
                        <label>Acedamic Year</label>
                        <select class="form-control"  name="acedmicyear"  >
                           <option value=""> Year</option>
                           <?= $year=date("Y"); $year2=$year-1;   $exyear=$year+3; ?>
                           <?php for ($i = $year2; $i <= $exyear; $i++) :  $rt=$i+1; $rt= substr($rt,2); $ar=$i.'-'.$rt; ?> 
                           <option  <?php if($i==$year){ ?>selected <?php } ?>value="<?php echo $i; ?>-<?php echo  $rt;?>" <?php if($ar==$alldata[0]['academic_year']){ echo "selected";  } ?>><?php echo $i; ?>-<?php echo  $rt;?></option>
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
                     <div class="col-sm-2">
                        <label>&nbsp;</label>
                        <input type="text" class="form-control" name="enroll" placeholder="Enter Gr.No Or Student ID">
                     </div>
                     <div class="col-sm-2">
                        <label>&nbsp;</label>
                        <input type="text" class="form-control" name="fname" placeholder="Enter Student First Name">
                     </div>
                     <div class="col-sm-2" style="top: 22px;">
                        <button type="submit" class="btn btn-success">Search</button>
                        <button type="reset" class="btn btn-primary">Reset</button>
                     </div>
                  </div>
                  <?php
                     echo $this->Form->end();
                     ?>   
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row"  >
   <div class="col-xs-12">
   <div class="box" >
   <div class="box-header">
      <i class="fa fa-search" aria-hidden="true"></i>
      <h3 class="box-title"> View Students List </h3>
   </div>
   <div class="row">
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-12">
         <!-- Horizontal Form -->
         <div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body" id="promotee">
               <?php echo $this->Form->create('Promote',array('url'=>array('controller'=>'students','action'=>'viewgenratepdf'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'PromoteAdminCustomerForm','class'=>'form-horizontal')); ?>
               <div class="" id="selectr" style="display:none;">
                  <div class="form-group ">
                     <div class="col-sm-3">
                        <input type="text" id="datepicksd123" class="form-control col-sm-3" name="validdate" placeholder="Enter  Valid upto Date" required="required">
                     </div>
                     <div class="col-sm-3">
                        <div class="form-group field-stuecdetail-secd_action">
                           <select class="form-control" name="print" required="required">
                              <option value="">--- Select Print Type---</option>
                              <option value="P">Portrait</option>
                              <option value="L">Landscape</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-sm-6 box-tool">
                        <button type="submit" class="btn btn-primary pull-right">Select &amp; Continue</button>									
                     </div>
                  </div>
               </div>
               <div class="box-body" >
                  <table class="table table-bordered table-striped" >
                     <script>
                        $(function () {
                            $('.check-alls').click(function () {
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
                        
                        
                        });
                         
                     </script>
                     <script type="text/javascript">	$('#promotee .btn').click(function (e) {
                        if ($('#example2 input[type=checkbox]:checked').length === 0) {
                        	e.preventDefault();
                        	alert("Please select one or more items from the list.");
                        	return false;
                        }
                        });
                     </script>
                     <thead>
                        <tr>
                           <th><input type="checkbox" class="check-alls" ></th>
                           <th>Student GR No.</th>
                           <th>Name</th>
                           <th>Academic Year</th>
                           <th>Class</th>
                           <th>Section</th>
                           <th>DOB</th>
                           <th>Father Name</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody id="example2">
                        <tr>
                           <td colspan="9" style="text-align:center;"> Please select the required fields from the search form.	</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!--/.col (right) -->
      </div>
      <!-- /.row -->
</section>
<!-- /.content -->
</div>