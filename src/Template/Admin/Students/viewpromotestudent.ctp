<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-wrapper">
      <section class="content-header">
         <h1>
            <i class="fa fa-info-circle" aria-hidden="true"></i> Students Promote ?
         </h1>
         <ul class="breadcrumb">
            <li><a href="/"><i class="fa fa-home"></i>Home</a></li>
            <li><a href="/student/default/index">Student</a></li>
            <li class="active">Promote of Students</li>
         </ul>
      </section>
      <section class="content">
         <?php echo $this->Form->create('Promote', array('url' => array('controller' => 'students', 'action' => 'savepromotestudent'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'PromoteAdminCustomerForm', 'class' => 'form-horizontal')); ?>
         <div class="box box-solid">
            <div class="box-body">
               <div class="row">
                  <div class="col-sm-4">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <i class="fa fa-info-circle" aria-hidden="true"></i> Preview Selected Details
                        </div>
                        <table class="table">
                           <colgroup>
                              <col style="width:125px">
                           </colgroup>
                           <tbody>
                              <tr>
                                 <th>Academic Year</th>
                                 <td><?php echo $year; ?>
                                    <input type="hidden" id="stuecdetail-secd_action" class="form-control" name="previousyear" value="<?php echo $year; ?>">
                                 </td>
                              </tr>
                              <tr>
                                 <th>Class</th>
                                 <td><?php echo $class; ?>
                                    <input type="hidden" id="stuecdetail-secd_action" class="form-control" name="previousclass" value="<?php echo $class; ?>">
                                 </td>
                              </tr>
                              <?php if ($section) { ?>
                                 <tr>
                                    <th>Section</th>
                                    <td><?php echo $section; ?>
                                       <input type="hidden" id="stuecdetail-secd_action" class="form-control" name="previoussection" value="<?php echo $section; ?>">
                                    </td>
                                 </tr>
                              <? } ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <div class="col-sm-2 text-center">
                     <div class="panel panel-warning">
                        <div class="panel-body">
                           <h4>
                              <i class="fa fa-cog"></i> Apply Action
                           </h4>
                           <div class="form-group field-stuecdetail-secd_action">
                              <div class="col-sm-8">
                                 <? if ($action == '2') { ?>
                                    <input type="hidden" id="stuecdetail-secd_action" class="form-control" name="action" value="PROMOTE">
                                 <? } else if ($action == '3') { ?>
                                    <input type="hidden" id="stuecdetail-secd_action" class="form-control" name="action" value="REPEAT">
                                 <? } ?>
                              </div>
                           </div>
                           <h4 class="text-yellow">
                              <strong style="color:red;">
                                 <? if ($action == '2') { ?>
                                    PROMOTE<? } else { ?> REPEAT<? } ?></strong>
                           </h4>
                           <? if ($action == '2') { ?>
                              <h4><i class="fa fa-hand-o-right"></i></h4>
                           <? } else { ?>
                              <h4><img src="https://use.fontawesome.com/releases/v5.0.13/svgs/solid/undo.svg" width="30" height="30"></h4>
                           <? } ?>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <i class="fa fa-check-circle"></i> Select Promote Details
                        </div>
                        <div class="panel-body">
                           <div class="form-group field-stuecdetail-secd_academic_year required">
                              <label class="col-sm-3 control-label" for="stuecdetail-secd_academic_year">Academic Year<span style="color:red;">*</span></label>
                              <div class="col-sm-8">
                                 <select class="form-control" name="academicyear" required="required">
                                    <?php
                                    $currentYear = date('Y');
                                    $nextYear = $currentYear + 1;
                                    $selectedYear = '';
                                    for ($i = $currentYear; $i <= $nextYear; $i++) {
                                       $startYear = $i;
                                       $endYear = $i + 1;
                                       $shortEndYear = substr($endYear, 2);
                                       $academicYear = "$startYear-$shortEndYear";
                                       echo '<option value="' . $academicYear . '"';
                                       if ($academicYear == $selectedYear) {
                                          echo ' selected';
                                       }
                                       echo ">$academicYear</option>";
                                    }
                                    ?>

                                 </select>
                              </div>
                           </div>
                           <div class="form-group field-stuenrolcourse-sec_course required">
                              <label class="col-sm-3 control-label" for="stuenrolcourse-sec_course">Class<span style="color:red;">*</span></label>
                              <div class="col-sm-8">
                                 <select class="form-control" name="class_id" required="required" id="class-id">
                                    <option value="">-- Select Class --</option>
                                    <?php foreach ($classes as $esr => $es) {
                                       if ($students[0]['class_id'] != $esr && $action == '2') { ?>
                                          <option value="<?php echo $esr; ?>"><?php echo $es; ?></option>
                                          <?php } else if ($action == '3') {
                                          if ($students[0]['class_id'] == $esr) {  ?>
                                             <option value="<?php echo $esr; ?>"><?php echo $es; ?></option>
                                    <?php }
                                       }
                                    } ?>
                                 </select>
                              </div>
                           </div>
                           <script>
                              $(document).ready(function() {
                                 $('#class-id').on('change', function() {
                                    var id = $('#class-id').val();
                                    $.ajax({
                                       type: 'POST',
                                       url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/find_section',
                                       data: {
                                          'id': id
                                       },
                                       success: function(data) {

                                          $('#section-id').empty();
                                          $('#section-id').html(data);
                                       },
                                    });
                                 });
                              });
                           </script>
                           <div class="form-group field-stuecdetail-secd_section required">
                              <label class="col-sm-3 control-label" for="stuecdetail-secd_section"> Section<span style="color:red;">*</span></label>
                              <div class="col-sm-8">
                                 <select class="form-control" name="section_id" id="section-id" required="required">
                                    <option value=""> -- Select Section -- </option>
                                    <?php foreach ($sectionslist as $er => $e) {
                                       if ($students[0]['section_id'] == $er && $action == '3') { ?>
                                          <option selected value="<?php echo $er; ?>"><?php echo $e; ?></option>
                                    <?php }
                                    } ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!--./box-body-->
            <div class="box-footer">
               <a class="btn btn-default" href="<?php echo SITE_URL; ?>admin/students/promote/<?php echo $classid; ?>/<?php echo $sectionid; ?>/<?php echo $year; ?>" aria-hidden="true"></i> Back/Cancel</a> <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Confirm &amp; Submit</button>
            </div>
         </div>
         <div class="panel panel-default">
            <div class="panel-heading">
               <h3 class="panel-title"><i class="fa fa-check-square-o"></i> Selected Student</h3>
            </div>
            <div class="panel-body table-responsive">
               <div id="w0" class="grid-view">
                  <div class="summary">Showing <b>1-<? echo count($students); ?></b> of <b><? echo count($students); ?></b> items.</div>
                  <table class="table table-striped table-bordered table-condensed">
                     <colgroup>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col>
                        <col class="text-center">
                        <col>
                     </colgroup>
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>S.No.</th>
                           <th>Scholar No.</th>
                           <th>Name</th>
                           <th>Father Name</th>
                           <th>Academic Year</th>
                           <th>Class</th>
                           <th>Section</th>
                           <th>Due Fees</th>
                           <th>Completion Status</th>
                           <th>Current Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $page = $this->request->params['paging']['Students']['page'];
                        $limit = $this->request->params['paging']['Students']['perPage'];
                        $counter = ($page * $limit) - $limit + 1;
                        $cnt = 1;
                        if (isset($students) && !empty($students)) {
                           foreach ($students as $work) {
                        ?>
                              <tr>
                                 <td>
                                    <input type="hidden" id="chk12009" checked="checked" readonly class="StuAttendCk" name="stud_id[]" value="<?php echo $work['id']; ?>">
                                 </td>
                                 <td><?php echo $cnt++; ?></td>
                                 <td><?php echo $work['enroll']; ?></td>
                                 <td><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>">
                                       <?php echo ucwords(strtolower($work['st_full_name'])); ?>
                                    </a></td>
                                 <td>
                                    <?php echo ucwords(strtolower($work['fathername'])); ?>
                                 </td>
                                 <td><?php echo $work['acedmicyear']; ?></td>
                                 <td><?php echo $work['class']['title']; ?></td>
                                 <td><?php echo $work['section']['title']; ?></td>
                                 <td>
                                    <?php if ($work['category'] == "RTE") {
                                       echo "<b style='color:red;'>--RTE--</b>"; ?>
                                       <input type="hidden" name="duefees[]" value="0">
                                       0
                                    <? } else {  ?>
                                       <input type="hidden" name="duefees[]" value="<?php echo strip_tags($work['due_fees']); ?>">
                                       <?php echo strip_tags($work['due_fees']); ?>
                                    <? } ?>
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
                              <td colspan="11" style="text-align:center;">NO Data Available</td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.box-->
      </section>
   </div>
   </section>
   <!-- /.content -->
</div>