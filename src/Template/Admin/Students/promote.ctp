<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <i class="fa fa-info-circle"></i> Promote Student
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>students/index"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>students/index">Manage Student</a></li>
         <li class="active">Promote Student</li>
      </ol>
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
                        $(document).ready(function() {
                           $("#TaskAdminCustomerForm").bind("submit", function(event) {
                              AmagiLoader.show();
                              $.ajax({
                                 async: true,
                                 data: $("#TaskAdminCustomerForm").serialize(),
                                 dataType: "html",
                                 beforeSend: function(xhr) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())

                                 },
                                 success: function(data, textStatus) {
                                    AmagiLoader.hide();
                                    $("#example2").html(data);
                                    $('#selectr').show();
                                 },
                                 type: "POST",
                                 url: "<?php echo SITE_URL; ?>admin/Students/promotesearch"
                              });
                              return false;
                              AmagiLoader.hide();
                           });
                        });
                        //]]>
                     </script>
                     <?php echo $this->Form->create('Task', array('url' => array('controller' => 'ClasstimeTabs', 'action' => 'viewtimetable'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>
                     <div class="form-group">
                        <div class="col-md-2 col-sm-4 col-xs-6">
                           <label>Select Course<span style="color:red;">*</span></label>
                           <?php
                           echo $this->Form->input('class_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Course', 'options' => $classes, 'value' => $class, 'label' => false, 'required'));
                           ?>
                        </div>

                        <div class="col-md-2 col-sm-4 col-xs-6">
                           <label>Select Year/Section</label>
                           <?php
                           echo $this->Form->input('section_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Year/Section', 'options' => $sectionslist, 'value' => $section, 'label' => false)); ?>
                        </div>

                        <div class="col-md-2 col-sm-4 col-xs-6">
                           <label>Select Batch</label>
                           <?php
                           $batch = ['2018-19'=>'2018-19','2019-20'=>'2019-20','2020-21'=>'2020-21','2021-22'=>'2021-22','2022-23'=>'2022-23','2023-24'=>'2023-24'];
                           echo $this->Form->input('batch', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Batch', 'options' => $batch, 'label' => false)); ?>
                        </div>

                        <div class="col-md-2 col-sm-4 col-xs-6">
                           <label>Academic Year<span style="color:red;">*</span></label>
                           <select class="form-control" name="acedmicyear" required="required">
                              <?php
                              $current_year = date('Y');
                              for ($i = 0; $i < 3; $i++) {
                                 $selected = ($i == 0) ? 'selected' : '';
                                 $start_year = $current_year - $i;
                                 $end_year = $start_year + 1;
                                 $year_range = $start_year . '-' . substr($end_year, 2);
                              ?>
                                 <option value="<?php echo $year_range; ?>" <?php echo $selected; ?>><?php echo $year_range; ?></option>
                              <?php } ?>
                           </select>
                        </div>

                        <div class="col-md-2 col-sm-4 col-xs-6">
                           <label>&nbsp;</label>
                           <input type="text" class="form-control" name="enroll" placeholder="Enter Enroll No.">
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6">
                           <label>&nbsp;</label>
                           <input type="text" class="form-control" name="fname" placeholder="Enter First Name">
                        </div>
                        <div class="col-md-2 col-sm-4 col-xs-6 text-xs-center" style="top: 22px;">
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
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
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
                           <?php echo $this->Form->create('Promote', array('url' => array('controller' => 'students', 'action' => 'viewpromotestudent'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'PromoteAdminCustomerForm', 'class' => 'form-horizontal')); ?>
                           <div class="v_studnt_listjustf" id="selectr" style="<?php if ($yeard) { ?>display:block;<?php } else { ?>display:none; <?php } ?>">
                              <div class="row v_studnt_listjustf_left">
                                 <label class="col-md-3 col-sm-12" style="padding-top : 10px;">Mark selected as</label>
                                 <div class="col-sm-6">
                                    <div class="form-group field-stuecdetail-secd_action col-md-3 col-sm-12">
                                       <select id="stuecdetail-secd_action" class="" name="action" required="">
                                          <option value="">--- Select Action ---</option>
                                          <option value="2">PROMOTE/LEVEL-UP</option>
                                          <option value="3">REPEAT</option>
                                       </select>
                                       <div class="help-block"></div>
                                    </div>
                                 </div>
                              </div>
                              <div class="box-tool text-right">
                                 <button type="submit" class="btn btn-primary">Select &amp; Continue</button>
                              </div>
                           </div>
                           <div class="box-body">
                              <div class="table-responsive">
                                 <table class="table table-bordered table-striped">
                                    <script>
                                       $(function() {
                                          $('.check-alls').click(function() {
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
                                       });
                                    </script>
                                    <script type="text/javascript">
                                       $('#promotee .btn').click(function(e) {
                                          if ($('#example2 input[type=checkbox]:checked').length === 0) {
                                             e.preventDefault();
                                             alert("Please select one or more items from the list.");
                                             return false;
                                          }
                                       });
                                    </script>
                                    <thead>
                                       <tr>
                                          <th><input type="checkbox" class="check-alls"></th>
                                          <th>Sr. No.</th>
                                          <th>Scholar No.</th>
                                          <th>Name</th>
                                          <th>Father Name</th>
                                          <th>Mobile No.</th>
                                          <th>Academic Year</th>
                                          <th>Course</th>
                                          <th>Year/Section</th>
                                          <th>Due Fees</th>
                                          <th>Completion Status</th>
                                          <th>Current Status</th>
                                       </tr>
                                    </thead>
                                    <tbody id="example2">
                                       <?php if ($yeard) { ?>
                                          <input type="hidden" name="year" value="<?php echo $yeard; ?>">
                                          <input type="hidden" name="class" value="<?php echo $class; ?>">
                                          <input type="hidden" name="section" value="<?php echo $section; ?>">
                                          <?php $page = $this->request->params['paging']['Students']['page'];
                                          $limit = $this->request->params['paging']['Students']['perPage'];
                                          $counter = ($page * $limit) - $limit + 1;

                                          $cnt = 1;
                                          if (isset($students) && !empty($students)) {
                                             foreach ($students as $work) {
                                          ?>
                                                <tr>
                                                   <td><input type="checkbox" id="chk12009" class="StuAttendCk" name="stud_id[]" value="<?php echo $work['id']; ?>">
                                                   </td>
                                                   <td><?php echo $cnt++; ?></td>
                                                   <td><?php echo $work['enroll']; ?></td>
                                                   <td><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>"> <?php echo ucwords(strtolower($work['st_full_name'])); ?></a></td>
                                                   <td>
                                                      <?php echo ucwords(strtolower($work['fathername'])); ?>
                                                   </td>
                                                   <td><?php echo $work['sms_mobile']; ?></td>
                                                   <td><?php echo $work['acedmicyear']; ?></td>
                                                   <td><?php echo $work['classtitle']; ?></td>
                                                   <td><?php echo $work['sectiontitle']; ?></td>
                                                   <td>
                                                      <?php if ($work['category'] == "RTE") {
                                                         echo "<b style='color:red;'>--RTE--</b>";
                                                      } else {
                                                         echo $work['due_fees'];
                                                      } ?>
                                                   </td>
                                                   <td><span class="label bg-blue">In Progress</span></td>
                                                   <td><?php if ($work['status'] == 'Y') {
                                                         ?>
                                                         <span class="label label-success">Active</span>
                                                      <?php } else {
                                                      ?>
                                                         <span class="label label-primary">Deactivate</span>
                                                      <?php  } ?>
                                                   </td>
                                                </tr>
                                             <?php $counter++;
                                             }
                                          } else { ?>
                                             <tr>
                                                <td colspan="12" style="text-align:center;">NO Data Available</td>
                                             </tr>
                                          <?php } ?>
                                       <?php } else { ?>
                                          <tr>
                                             <td colspan="12" style="text-align:center; "> <b>Please select the required fields from the search form.</b> </td>
                                          </tr>
                                       <?php } ?>
                                    </tbody>
                                 </table>
                              </div>
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