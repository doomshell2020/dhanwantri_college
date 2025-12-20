<!-- Content Wrapper. Contains page content -->
<style>
   .dropppss:after {
      display: inline-block;
      width: 0;
      height: 0;
      margin-left: .255em;
      vertical-align: .255em;
      content: "";
      border-top: .3em solid;
      border-right: .3em solid transparent;
      border-bottom: 0;
      border-left: .3em solid transparent;
   }

   .hover:hover {
      background-color: #f1f1f1;
   }
</style>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Students Manager
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>students/index"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>students/index">Manage Students</a></li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div id="load"></div>
      <div class="row">
         <div class="col-xs-12">
            <?php echo $this->Flash->render(); ?>
            <div class="box">
               <style>
                  #load {
                     width: 100%;
                     height: 100%;
                     position: fixed;
                     z-index: 9999;
                     background-color: white !important;
                     background: url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
                  }

                  #load2 {
                     width: 100%;
                     height: 100%;
                     position: fixed;
                     z-index: 9999;
                     background-color: white !important;
                     background: url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
                  }
               </style>
               <script>
                  document.onreadystatechange = function() {
                     var state = document.readyState
                     if (state == 'complete') {
                        document.getElementById('interactive');
                        document.getElementById('load').style.visibility = "hidden";
                     }
                  }
               </script>
               <!-- <div class="box-header">
                  <h3 class="box-title">Search Student</h3>
               </div> -->
               <!-- /.box-header -->
               <div class="box-body">
                  <div class="clearfix">
                     <?php
                     if ($role_id == ADMIN) { ?>
                        <a href="<?php echo SITE_URL; ?>admin/students/add">
                           <button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
                              Add</button></a>
                     <?php } ?>
                  </div>
                  <div class="manag-stu">
                     <script inline="1">
                        //<![CDATA[
                        $(document).ready(function() {
                           $("#TaskAdminCustomerForm").bind("submit", function(event) {
                              $.ajax({
                                 async: true,
                                 data: $("#TaskAdminCustomerForm").serialize(),
                                 dataType: "html",
                                 beforeSend: function(xhr) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
                                    $('#load2').css("display", "block");
                                 },
                                 success: function(data, textStatus) {
                                    $("#example23").html(data);
                                 },
                                 complete: function() {
                                    $('#load2').css("display", "none");
                                 },
                                 type: "get",
                                 url: "<?php echo ADMIN_URL; ?>students/search"
                              });
                              return false;
                           });

                        });

                        $(document).on('click', '.pagination a', function(e) {
                           var target = $(this).attr('href');
                           var res = target.replace("/students/search", "/students");
                           window.location = res;
                           return false;
                        });

                        //]]>
                     </script>
                     <?php echo $this->Form->create('Task', array('url' => array('controller' => 'students', 'action' => 'search'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>
                     <div class="form-group form_gpr_colm">
                        <div class="col-sm-3">
                           <label for="inputEmail3" class="control-label">Batch</label>
                           <?php
                           $batchValue = $_GET['batch'];
                           echo $this->Form->select(
                              'batch',
                              $academic_session,
                              [
                                 'class' => 'form-control',
                                 'placeholder' => '---Select Batch---',
                                 'empty' => '---Select Batch---',
                                 'id' => 'batch',
                                 // 'required' => true,
                                 'value' => $batchValue
                              ]
                           );
                           ?>
                        </div>
                        <div class="col-sm-3">
                           <label>Course</label>

                           <select class="form-control" name="class_id[]" multiple="multiple" id="class-id">
                              <option value="">Select</option>
                              <?php foreach ($classes as $esr => $es) {
                                 $selectedClass = (isset($_GET['class_id']) && in_array($esr, $_GET['class_id'])) ? 'selected' : '';
                              ?>
                                 <option value="<?php echo $esr; ?>" <?php echo $selectedClass; ?>><?php echo $es; ?>
                                 </option>
                              <?php } ?>
                           </select>


                        </div>
                        <div class="col-sm-3">
                           <label>Year</label>
                           <select class="form-control" name="section_id[]" multiple="multiple" id="section-id">
                              <option value=""> Year </option>
                              <?php foreach ($sections as $er => $e) {
                                 $selectedSection = (isset($_GET['section_id']) && in_array($esr, $_GET['section_id'])) ? 'selected' : '';
                              ?>
                                 <option value="<?php echo $e['id']; ?>" <?php echo $selectedSection; ?>>
                                    <?php echo $e['title']; ?>
                                 </option>
                              <?php } ?>
                           </select>
                        </div>

                        <script>
                           $(document).ready(function() {
                              var isSectionChange = false;

                              $('#section-id').on('change', function() {
                                 isSectionChange = true; // Set the flag to indicate section change
                              });

                              $('#class-id').on('change', function() {
                                 var selectedClassId = $(this).val();

                                 if (isSectionChange) {
                                    $('#section-id').val(null); // Set section ID value to null
                                    isSectionChange = false; // Reset the flag
                                 }


                                 $.ajax({
                                    type: 'POST',
                                    url: "<?php echo SITE_URL ?>admin/ClasstimeTabs/find_multiple_section",
                                    data: {
                                       'id': selectedClassId
                                    },
                                    headers: {
                                       'X-CSRF-Token': $('[name="_csrfToken"]').val()
                                    },
                                    success: function(data) {
                                       $('#section-id').html(data);
                                    },
                                    error: function(xhr, status, error) {
                                       console.error("AJAX Error:", error);
                                    }
                                 });
                              });
                           });

                           $(document).ready(function() {
                              // Get references to the relevant elements
                              var classSelect = $("#class-id");
                              var sectionSelect = $("#section-id");
                              var downloadLink = $("#download-link");

                              // Initially hide the download button
                              downloadLink.hide();

                              // Store the initial value of section_id
                              var initialSectionValue = sectionSelect.val();

                              // When class_id select changes
                              classSelect.change(function() {
                                 // Reset section_id to its initial value
                                 sectionSelect.val(initialSectionValue);

                                 // Hide the download button
                                 downloadLink.hide();
                              });

                              // When section_id select changes
                              sectionSelect.change(function() {
                                 // Check if both class_id and section_id have selected values
                                 if (classSelect.val() && sectionSelect.val()) {
                                    // Construct the download URL
                                    if (classSelect.val() > 0 && sectionSelect.val() > 0) {
                                       var downloadUrl = "<?php echo SITE_URL; ?>admin/students/exceldownloadbackstudent" +
                                          "?course=" + classSelect.val() +
                                          "&section=" + sectionSelect.val();

                                       // Set the href attribute of the download link
                                       downloadLink.attr("href", downloadUrl);

                                       // Show the download button
                                       downloadLink.show();
                                    }

                                 } else {
                                    // Hide the download button
                                    downloadLink.hide();
                                 }
                              });
                           });
                        </script>

                        <div class="col-sm-3">
                           <label>&nbsp;</label>
                           <input type="text" class="form-control" name="enroll" placeholder="Enter Scholar No."
                              value="<?php echo isset($_GET['enroll']) ? $_GET['enroll'] : ''; ?>">
                        </div>
                        <div class="col-sm-3">
                           <label>&nbsp;</label>
                           <input type="text" class="form-control" name="fname" placeholder="Enter Pupil's Name"
                              value="<?php echo isset($_GET['fname']) ? $_GET['fname'] : ''; ?>">
                        </div>
                        <div class="col-sm-3">
                           <label>&nbsp;</label>
                           <input type="text" class="form-control" name="mobile" placeholder="Enter Mobile No"
                              value="<?php echo isset($_GET['mobile']) ? $_GET['mobile'] : ''; ?>">
                        </div>
                        <div class="col-sm-3">
                           <label>&nbsp;</label>
                           <input type="text" class="form-control" name="mothername" placeholder="Enter Mother Name"
                              value="<?php echo isset($_GET['mothername']) ? $_GET['mothername'] : ''; ?>">
                        </div>
                        <div class="col-sm-3">
                           <label>&nbsp;</label>
                           <input type="text" class="form-control" name="fathername" placeholder="Enter Father Name"
                              value="<?php echo isset($_GET['fathername']) ? $_GET['fathername'] : ''; ?>">
                        </div>
                        <div class="col-sm-3">
                           <br>
                           <input type="checkbox" id="transport" name="transport" value="1" <?php echo isset($_GET['transport']) ? 'checked' : ''; ?>>
                           <label for="transport">Transport</label>
                           <input type="checkbox" id="hostel" name="hostel" value="1" <?php echo isset($_GET['hostel']) ? 'checked' : ''; ?>>
                           <label for="hostel">Hostel</label>
                        </div>
                        <div class="col-sm-12 text-center" style="padding: 23px;">
                           <label>&nbsp;</label>
                           <label>&nbsp;</label>
                           <button type="submit" class="btn btn-success">Search</button>
                           <a class="btn btn-info "
                              style="color:#ffffff !important; background-color: #8B0000; !important"
                              href="<?php echo SITE_URL; ?>admin/students/index"><b>Reset</i></b></a>
                           <!-- <div class="pa" > -->
                           <!-- <div class="d-flex pl-3 " style="justify-content: end; padding-left:20px;"> -->
                           <!-- <div class="dropdown"> -->
                           <button class="btn btn-primary dropdown-toggle dropppss dropdown" type="button"
                              id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Report
                           </button>
                           <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"
                              style="left: 633px !important;top: 57px;">
                              <a target="_blank" class="dropdown-item hover"
                                 style="display: block; color:black; padding:5px;"
                                 href="<?php echo SITE_URL; ?>admin/students/printdatahtml">Print</a>
                              <a class="dropdown-item hover" style="display: block; color:black; padding:5px;"
                                 href="<?php echo SITE_URL; ?>admin/students/download_students_excel">Export to
                                 Excel</a>
                              <a class="dropdown-item hover" style="display: block; color:black; padding:5px;"
                                 id="download-link" href="#">Download Backlog Student</a>
                              <!-- </div> -->
                              <!-- </div> -->
                              <!-- </div> -->
                           </div>
                        </div>

                     </div>
                     <?php echo $this->Form->end(); ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">

         <div id="load2" style="display:none;"></div>

         <div class="col-xs-12">
            <div class="box">
               <!-- <div class="box-header"> -->
               <!-- margin-right: 23px; -->
               <!-- <div style="display:flex; justify-content: space-between;align-items:center; margin-bottom: 4px;"></div>
                  <?php if ($role_id == ADMIN || $rolepresent == CENTER_COORDINATOR) { ?>
                     <a href="<?php echo SITE_URL; ?>admin/students/addcsv">
                        <button class="btn btn-success pull-right m-top10">
                           <i class="fa fa-plus" aria-hidden="true"></i>
                           Add CSV
                        </button>
                     </a>
                  <?php }
                  ?>
               </div> -->

               <!-- /.box-header -->
               <div class="box-body" id="example23">
                  <div class="table-responsive student_listtb_rspv">
                     <!-- <table id="example1" class="table table-bordered table-striped"> -->
                     <table class="table table-bordered table-striped">
                        <thead>
                           <tr>
                              <th>S.No</th>
                              <th>Schloar. No.</th>
                              <th>Name</th>
                              <th>Mobile</th>
                              <th>Fathername</th>
                              <th>Admission Date</th>
                              <th width="5%">Batch</th>
                              <th>Course/Year</th>
                              <th>Fee</th>
                              <th>Discount</th>
                              <th>Paid</th>
                              <th>Balance</th>
                              <th>Deposit</th>
                              <?php if (in_array($role_id, [CENTER_COORDINATOR, ADMIN])) { ?>
                                 <th>Action</th>
                              <?php } ?>
                           </tr>
                        </thead>
                        <tbody id="example2">
                           <?php
                           $page = $this->request->params['paging']['Students']['page'];
                           $limit = $this->request->params['paging']['Students']['perPage'];
                           $counter = ($page * $limit) - $limit + 1;

                           if (isset($students) && !empty($students)) {
                              foreach ($students as $work) {
                                 $getFeesDetails = $this->Comman->getstudenttotalfeesdetails($work);
                                 $section_id = $work['section_id'];
                                 if ($section_id == 1) {
                                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'];
                                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'];
                                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'];
                                 } elseif ($section_id == 2) {
                                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'];
                                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'];
                                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'];
                                 } elseif ($section_id == 3) {
                                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'];
                                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'];
                                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'];
                                 } else {
                                    $total_batch_fee = $getFeesDetails['previous_year'] + $getFeesDetails['1st_year_total_fees'] + $getFeesDetails['2nd_year_total_fees'] + $getFeesDetails['3rd_year_total_fees'] + $getFeesDetails['4th_year_total_fees'] + $getFeesDetails['1st_year_transport_fees'] + $getFeesDetails['2nd_year_transport_fees'] + $getFeesDetails['3rd_year_transport_fees'] + $getFeesDetails['4th_year_transport_fees'];
                                    $total_batch_paid_fee = $getFeesDetails['previous_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_fee_deposite'] + $getFeesDetails['2nd_year_students_fee_deposite'] + $getFeesDetails['3rd_year_students_fee_deposite'] + $getFeesDetails['4th_year_students_fee_deposite'] + $getFeesDetails['1st_year_students_transport_deposite'] + $getFeesDetails['2nd_year_students_transport_deposite'] + $getFeesDetails['3rd_year_students_transport_deposite'] + $getFeesDetails['4th_year_students_transport_deposite'];
                                    $getFeesDetails['discount'] = $getFeesDetails['1st_year_students_discount'] + $getFeesDetails['2nd_year_students_discount'] + $getFeesDetails['3rd_year_students_discount'] + $getFeesDetails['4th_year_students_discount'];
                                 }
                                 $total_balance = $total_batch_fee - $total_batch_paid_fee - $getFeesDetails['discount'];
                           ?>
                                 <tr>
                                    <td><?= $counter; ?></td>
                                    <td>
                                       <?= $work['enroll']; ?>&nbsp;
                                       <?php if (in_array($role_id, [CBSE_FEE_COORDINATOR, CENTER_COORDINATOR, ADMIN])) { ?>
                                          <a title="View Student" href="<?= SITE_URL; ?>admin/students/view/<?= $work['id']; ?>">
                                             <i class="fa fa-info-circle"></i>
                                          </a>
                                          <a title="Edit Student" href="<?= SITE_URL; ?>admin/students/edit/<?= $work['id']; ?>">
                                             <i class="fa fa-pencil"></i>
                                          </a>
                                       <?php } ?>
                                    </td>
                                    <td>
                                       <?php
                                       if (isset($work['fname'])) {
                                          echo ucwords(strtolower($work['st_full_name']));
                                       }
                                       if ($work['category'] == "Migration" || $work['oldenroll'] != 0) {
                                          echo '<span style="color: red; font-weight:bold;">(Migr.)*</span>';
                                       }
                                       if ($work['is_transport'] == 'Y') {
                                          echo '&nbsp;<i class="fa fa-bus"></i>';
                                       }
                                       ?>
                                       <!-- For Hostel Fees Start -->
                                       <a class='global1'
                                          title="<?= ($work['is_hostel']) ? 'Hostel Assigned' : 'Hostel Unassigned'; ?>"
                                          href="<?= SITE_URL; ?>admin/students/hostel_fee_enable_disable/<?= $work['id']; ?>"
                                          data-target="#hostal-fee-enable-disable<?= $work['id']; ?>" data-toggle="modal">
                                          <i class="fas fa-bed"
                                             style="color: <?= ($work['is_hostel']) ? 'green;' : 'red;'; ?>"></i>
                                       </a>
                                       <!-- For Hostel Fees End -->
                                    </td>
                                    <td><?= (!empty($work['mobile'])) ? $work['mobile'] : "N/A"; ?></td>
                                    <td><?= (!empty($work['fathername'])) ? ucwords(strtolower($work['fathername'])) : "N/A"; ?></td>
                                    <td><?= date('d-m-Y', strtotime($work['created'])); ?></td>
                                    <td><?= $work['batch']; ?></td>
                                    <td><?= $work['class']['title'] . '/' . $work['section']['title']; ?></td>
                                    <td><?= $total_batch_fee; ?></td>
                                    <td><?= $getFeesDetails['discount']; ?></td>
                                    <td><?= $total_batch_paid_fee; ?></td>
                                    <td><?= $total_balance; ?></td>
                                    <td>
                                       <a href="<?= SITE_URL; ?>admin/studentfees/view/<?= $work['id']; ?>" target="_blank">
                                          <i class="fa fa-money" title="Deposit Fees" aria-hidden="true"></i>
                                       </a>
                                    </td>
                                    <?php
                                    $allowedRoles = [ADMIN, CENTER_COORDINATOR];
                                    if (in_array($role_id, $allowedRoles) && $get_managesettings['drop_out_student'] == '0') {
                                    ?>
                                       <td>
                                          <!-- Regular Drop Out -->
                                          <a class="global1" title="Drop Out"
                                             href="<?= SITE_URL; ?>admin/students/drop_out/<?= $work['id']; ?>"
                                             data-target="#global-drop-out<?= $work['id']; ?>" data-toggle="modal">
                                             <i class="fa fa-ban" aria-hidden="true"></i>
                                          </a>

                                          &nbsp;

                                          <!-- Drop Out with Refund -->
                                          <a href="<?= SITE_URL; ?>/admin/students/dropoutwithrefund/<?= $work['id']; ?>"
                                             class="btn-drop-out-with-refund"
                                             title="Drop Out & Refund"
                                             data-target="#global-drop-out-with-refund"
                                             data-toggle="modal">
                                             <i class="fa fa-undo" aria-hidden="true" style="color: green;"></i>
                                          </a>
                                       </td>

                                    <?php } ?>
                                 </tr>
                                 <!-- Drop Out Modal Start -->
                                 <div class="modal" id="global-drop-out<?php echo $work['id']; ?>" tabindex="-1" role="dialog"
                                    aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                       <div class="modal-content modal-content-drop-out">
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
                                 <script>
                                    // $(document).ready(function () {
                                    $("#global-drop-out<?php echo $work['id']; ?>").click(function(event) {
                                       $('.modal-content-drop-out').load($(this).attr("href"));
                                    });
                                    // });
                                 </script>
                                 <!-- Drop Out Modal End -->

                                 <!-- For Hostal Fees Start -->
                                 <script>
                                    $(document).ready(function() {
                                       $("#hostal-fee-enable-disable<?php echo $work['id']; ?>").click(function(event) {
                                          $('.modal-content-hostal').load($(this).attr("href"));
                                       });

                                    });
                                 </script>
                                 <div class="modal" id="hostal-fee-enable-disable<?php echo $work['id']; ?>" tabindex="-1"
                                    role="dialog" aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                       <div class="modal-content modal-content-hostal">
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
                                 <!-- For Hostal Fees End -->

                              <?php
                                 $counter++;
                              }
                           } else {
                              ?>
                              <tr>
                                 <td>NO Data Available</td>
                              </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
                  <?php echo $this->element('admin/pagination'); ?>
               </div>
               <!-- /.box-body -->
            </div>
         </div>
         <!-- /.box -->
      </div>
      <!-- /.col -->
   </section>
</div>
<!-- /.row -->
<!-- /.content -->
<!-- /.content-wrapper -->



<!-- Drop Out Modal Start -->
<div class="modal" id="global-drop-out-with-refund" tabindex="-1" role="dialog"
   aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
   <div class="modal-dialog">
      <div class="modal-content modal-content-drop-out-refund">
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

<script>
   $(".btn-drop-out-with-refund").click(function(event) {
      event.preventDefault(); // prevent default link behavior
      $('.modal-content-drop-out-refund').load($(this).attr("href"));
      $("#global-drop-out-with-refund").modal("show");
   });
</script>
<!-- Drop Out Modal End -->