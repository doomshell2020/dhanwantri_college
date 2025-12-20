<style>
   .modal .modal-dialog {
      width: auto !important;
      /* max-width: 220px !important; */
   }
</style>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>Student Manager</h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>students/index"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>students/index">Manage Student</a></li>
         <li class="active"><?php echo $students['fname']; ?></li>
      </ol>
   </section>
   <script>
      $(document).ready(function() {
         //prepare the dialog

         //respond to click event on anything with 'overlay' class
         $(".globalModals").click(function(event) {
            $('.modal-content').load($(this).attr("href")); //load content from href of link
         });
      });
   </script>
   <?php if ($selectid) { ?>
      <script>
         var id = '<?php echo $selectid; ?>';
         $(document).ready(function() {
            $('#personal-tab').removeClass('active');
            $('.tab-pane').removeClass('active');
            $('#' + id + '-tab').addClass('active');
            $('#' + id).addClass('active');

         });
      </script>
   <?php } ?>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-info">
               <div class="box-body">
                  <?php echo $this->Flash->render(); ?>
                  <section class="content-header container-fluid">
                     <h3 class="col-sm-4">
                        <i class="fa fa-eye"></i> View Student | <small><?php echo ucfirst($students['fname']); ?> <?php echo $students['middlename']; ?></small>
                     </h3>
                  </section>
                  <section class="content">
                     <!---Start display student profile header with photo -->
                     <div class="row">
                        <div class="col-sm-12 col-xs-12">
                           <div class="well well-sm panel panel-default">
                              <div class="panel-body">
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-3 text-center edusecArLangCss">
                                       <?php

                                       if (!empty($students['file'])) { ?>

                                          <img class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL ?>student/<?php echo $students['file']; ?>">
                                          <div class="photo-edit-admin">
                                          <?php } else { ?>
                                             <img class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL ?>uploads/no-images.png">

                                             <div class="photo-edit-admin">
                                             <?php } ?>

                                             <?php if (empty($students['file'])) { ?>
                                                <a class="photo-edit-icon-admin" href="<?php echo SITE_URL; ?>admin/students/studentimage/<?php echo $students['id'] ?>" title="Add Profile Picture"><i class="fa fa-pencil"> </i></a>
                                             <?php } else { ?>
                                                <a class="photo-edit-icon-admin" href="<?php echo SITE_URL; ?>admin/students/studentimage/<?php echo $students['id'] ?>" title="Edit Profile Picture"><i class="fa fa-pencil"> </i></a>
                                             <?php } ?>

                                             </div>

                                          </div>

                                          <div class="col-xs-12 col-sm-6 edusecArLangCss">
                                             <h3 class="text-primary">
                                                <b><span class="glyphicon glyphicon-user"></span> <?php echo ucfirst($students['fname']); ?> <?php echo $students['middlename']; ?> <?php echo $students['lname']; ?></b>
                                             </h3>
                                             <p>
                                                <strong>Student Sr.No. : </strong>
                                                <?php echo $students['enroll']; ?>
                                             </p>
                                             <p>
                                                <strong>Email/Login Id : </strong>
                                                <?php echo $students['username']; ?> <a class="photo-edit-icon-admin bg-aqua globalModals" href="<?php echo SITE_URL; ?>admin/students/change_email/<?php echo $students['id'] ?>" title="Change Email/Login ID" data-target="#globalModal" data-toggle="modal"><i class="fa fa-pencil"></i></a>
                                             </p>
                                             <p>
                                                <strong>Mobile No : </strong>
                                                <?php echo $students['mobile']; ?>
                                             </p>
                                             <p>
                                                <strong>Status :</strong>
                                                <?php if ($students['status'] == 'Y') { ?> <span class="label label-success"> Active</span> <?php } else { ?> <span class="label label-primary"> In-Active</span><?php } ?>
                                             </p>
                                          </div>
                                          <!--/col-->
                                          <!-- <div class="col-xs-12 col-sm-3 edusecArLangCss text-right">
                                 <a class="btn btn-app" href="<?php echo ADMIN_URL; ?>studentfees/view/<?php echo $students['id']; ?>/<?php echo $students['acedmicyear']; ?>" target="_blank"><i class="fa fa-money"></i> Fees</a> <br>
                                 <a class="btn btn-app" href="<?php echo ADMIN_URL; ?>ClasstimeTabs/view/<?php echo $students['class_id']; ?>/<?php echo $students['section_id']; ?>/<?php echo $students['acedmicyear']; ?>" target="_blank"><i class="fa fa-calendar-o"></i> Timetable</a>
                              </div> -->
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row edusec-user-profile">
                           <div class="col-sm-12">
                              <ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="profileTab">
                                 <li class="active" id="personal-tab"><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $students['id']; ?>#personal" data-toggle="tab"><i class="fa fa-street-view"></i> Personal</a></li>
                                 <li id="academic-tab"><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $students['id']; ?>#academic" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Academic</a></li>
                                 <li id="address-tab"><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $students['id']; ?>#address" data-toggle="tab"><i class="fa fa-home"></i> Address</a></li>
                                 <li id="documents-tab"><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $students['id']; ?>#documents" data-toggle="tab"><i class="fa fa-file-text"></i> Documents</a></li>
                                 <?php $cls = array('12', '13', '15', '17', '20', '22', '26', '27');
                                 if (in_array($students['class']['id'], $cls)) { ?>
                                    <li id="history-tab"><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $students['id']; ?>#history" data-toggle="tab"><i class="fa fa-history"></i> Subject</a></li>
                                 <?php } ?>

                                 <li id="result-tab"><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $students['id']; ?>#result" data-toggle="tab"><i class="fa fa-result"></i> Result</a></li>
                              </ul>
                              <div id="content" class="tab-content responsive hidden-xs hidden-sm">
                                 <div class="tab-pane active" id="personal">
                                    <h3 class="page-header edusec-border-bottom-primary">
                                       <i class="fa fa-info-circle"></i> Personal Details
                                       <div class="pull-right">
                                          <a class="btn btn-primary" href="<?php echo SITE_URL; ?>admin/students/edit/<?php echo $students['id']; ?>">Edit</a>
                                       </div>
                                    </h3>
                                    <div class="box box-solid">
                                       <div class="box-body no-padding table-responsive">
                                          <table class="table tbl-profile">
                                             <colgroup>
                                                <col style="width:15%">
                                                <col style="width:35%">
                                                <col style="width:15%">
                                                <col style="width:35%">
                                             </colgroup>
                                             <tbody>
                                                <tr>
                                                   <td class="profile-label">Pupil's Name :</td>
                                                   <td><?php echo ucfirst($students['fname']); ?> <?php echo ucfirst($students['middlename']); ?> <?php echo ucfirst($students['lname']); ?></td>
                                                   <td class="profile-label">Gender :</td>
                                                   <td><?php echo $students['gender']; ?></td>
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Date of Birth :</td>
                                                   <td><?php echo date('d-m-Y', strtotime($students['dob'])); ?></td>
                                                   <td class="profile-label">Nationality :</td>
                                                   <td><?php echo $students['nationality']; ?></td>
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Admission Category :</td>
                                                   <td><?php echo $students['category']; ?></td>
                                                   <td class="profile-label">Admission Date :</td>
                                                   <td><?php echo date('d-m-Y', strtotime($students['created']) + 86400); ?></td>
                                                </tr>

                                                <!-- <tr>
                                          <td class="profile-label">Bloodgroup :</td>
                                          <td><?php // echo $students['bloodgroup']; 
                                                ?></td>
                                          <td class="profile-label">Enrollnment No. :</td>
                                          <td><?php // echo $students['enroll']; 
                                                ?></td>
                                       </tr> -->

                                                <tr>
                                                   <td class="profile-label">Mobile No. :</td>
                                                   <td><?php echo $students['mobile']; ?></td>
                                                   <td class="profile-label">Father Mobile No. :</td>
                                                   <td><?php echo $students['f_phone']; ?></td>
                                                   <!-- <td class="profile-label">Mother Mobile No. :</td> -->
                                                   <!-- <td><?php // echo $students['m_phone']; 
                                                            ?></td> -->
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">SMS Mobile No. :</td>
                                                   <td><?php echo $students['sms_mobile']; ?></td>
                                                   <td class="profile-label">Aadhar No. :</td>
                                                   <td><?php echo $students['adaharnumber']; ?></td>
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Form No</td>
                                                   <td><?php echo $students['formno']; ?></td>
                                                   <td class="profile-label">Fees Received By :</td>
                                                   <td><?php echo $students['fee_submittedby']; ?></td>

                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Father Name:</td>
                                                   <td>
                                                      <?php echo $students['fathername']; ?>
                                                   </td>

                                                   <!--- Father image view !---->
                                                   <!-- <div id="father_image" class="modal fade" tabindex="-1" role="dialog">
                                                   <div class="modal-dialog">
                                                      <div class="modal-content">
                                                         <div class="modal-body">
                                                            <?php  // if(!empty($students['father_pic'])){ 
                                                            ?>
                                                            <img src="<?php // echo SITE_URL; 
                                                                        ?>images/<?php // echo $students['father_pic']; 
                                                                                 ?>" class="img-responsive" style="border: 1px solid #333;"> 
                                                            <?php //  }else{ 
                                                            ?>
                                                            <span>No Image Available</span>
                                                            <?php // } 
                                                            ?>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   </div> -->

                                                   <td class="profile-label">Mother Name :</td>
                                                   <td>
                                                      <?php echo $students['mothername']; ?>
                                                   </td>

                                                </tr>

                                                <tr>
                                                   <td class="profile-label">Category :</td>
                                                   <td>
                                                      <?php echo $students['cast']; ?>
                                                   </td>

                                                   <td class="profile-label">Course :</td>

                                                   <td><?php $findclass123 = $this->Comman->findclass123($students['class_id']);
                                                         $findsection123 = $this->Comman->findsection123($students['section_id']);
                                                         echo $findclass123['title'] . " (" . $findsection123['title'] . ")";
                                                         ?></td>

                                                </tr>

                                                <tr>
                                                   <td class="profile-label">Application Form/Date :</td>
                                                   <td>
                                                      <?php echo $students['applocation_form_date']; ?>
                                                   </td>


                                                   <td class="profile-label">Date of Joining :</td>
                                                   <td>
                                                      <?php
                                                      if ($students['date_of_joining']) {
                                                         echo date('d-m-Y', strtotime($students['date_of_joining']));
                                                      } else {
                                                         echo date('d-m-Y', strtotime($students['created']));
                                                      }

                                                      ?>
                                                   </td>
                                                </tr>

                                                <tr>
                                                   <td class="profile-label">Student Type :</td>
                                                   <td> <?php echo $students['category']; ?> </td>

                                                </tr>

                                                <tr>
                                                   <!-- <td class="profile-label">Cast :</td>
                                          <td><?php // echo $students['cast']; 
                                                ?></td> -->


                                                </tr>

                                                <!-- <tr>
                                          <div id="myModal" class="modal fade" tabindex="-1" role="dialog" style=" width: 100px;">
                                             <div class="modal-dialog">
                                                <div class="modal-content">
                                                   <div class="modal-body">
                                                      <?php // if(!empty($students['mother_pic'])){ 
                                                      ?>
                                                      <img src="<?php // echo SITE_URL; 
                                                                  ?>images/<?php // echo $students['mother_pic']; 
                                                                           ?>" class="img-responsive" style="border: 1px solid #333;"> 
                                                      <?php  // }else{ 
                                                      ?>
                                                      <span>No Image Available</span>
                                                      <?php // } 
                                                      ?>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <td class="profile-label">Current Class</td>
                                          <td><?php //$findclass123 = $this->Comman->findclass123($students['class_id']);
                                                //$findsection123 = $this->Comman->findsection123($students['section_id']);
                                                //echo $findclass123['title'] . " (" . $findsection123['title'] . ")"; 
                                                ?></td>
                                          <td class="profile-label">Religion :</td>
                                          <td><?php //echo $students['religion']; 
                                                ?></td>
                                       </tr> -->
                                                <!-- 
                                       <tr>
                                          <td class="profile-label">First Admission Class</td>
                                          <td><?php // $findclass123s = $this->Comman->showadmissionclasstitle($students['admissionclass']);
                                                // echo $findclass123s['title']; 
                                                ?></td>
                                          <td class="profile-label">House</td>
                                          <td><?php // $house = $this->Comman->findhouse($students['h_id']);
                                                // echo $house['name']; 
                                                ?></td>
                                       </tr> -->


                                             </tbody>
                                          </table>
                                       </div>
                                       <!--/box-body-->
                                    </div>
                                    <!--/box-->
                                 </div>
                                 <div class="tab-pane" id="academic">
                                    <h3 class="page-header edusec-border-bottom-primary">
                                       <i class="fa fa-info-circle"></i> Academic Details
                                       <div class="pull-right">
                                       </div>
                                    </h3>
                                    <div class="box box-solid">
                                       <div class="box-body no-padding">
                                          <div id="w1" class="grid-view">
                                             <div class="summary"></div>
                                             <table class="table table-striped table-bordered">
                                                <thead>
                                                   <tr>
                                                      <th>#</th>
                                                      <th>Action</th>
                                                      <th>Sr.No.</th>
                                                      <th>Academic Year</th>
                                                      <th>Course</th>
                                                      <th>Year/Section</th>
                                                      <th>Completion <br> Status</th>
                                                      <th>Status</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php $class = $this->Comman->findclass($students['class_id']);
                                                   $section = $this->Comman->findsecti($students['section_id']);
                                                   ?>
                                                   <tr data-key="44">
                                                      <td>1</td>
                                                      <td>ENROLL</td>
                                                      <td><?php echo $students['enroll']; ?></td>
                                                      <td><?php echo $students['acedmicyear']; ?></td>
                                                      <td><?php echo $class['title']; ?></td>
                                                      <td><?php echo $section['title']; ?></td>
                                                      <td><span class="label label-primary">In Progress</span></td>
                                                      <td> <?php if ($students['status'] == 'Y') { ?>
                                                            <span class="label label-success"> Active</span>
                                                         <?php } else { ?> <span class="label label-primary"> In-Active</span>
                                                         <?php } ?>
                                                      </td>
                                                   </tr>
                                                   <?php $cnts = 2;
                                                   if (isset($studentshistory) && !empty($studentshistory)) {
                                                      foreach ($studentshistory as $key => $value) { ?>
                                                         <?php $class = $this->Comman->findclass($value['class_id']);
                                                         $section = $this->Comman->findsecti($value['section_id']);
                                                         ?>
                                                         <tr data-key="44">
                                                            <td><?php echo $cnts++; ?></td>
                                                            <td><?php echo $value['actionhistory'];  ?></td>
                                                            <td><?php echo $value['enroll']; ?></td>
                                                            <td><?php echo $value['acedmicyear']; ?></td>
                                                            <td><?php echo $class['title']; ?></td>
                                                            <td><?php echo $section['title']; ?></td>
                                                            <td><span class="label label-primary"><? if ($value['actionhistory'] == "REPEAT") {
                                                                                                      echo "REPEAT";
                                                                                                   } else {
                                                                                                      echo "Completed";
                                                                                                   } ?></span></td>
                                                            <td><span class="label label-success">Active</span></td>
                                                         </tr>
                                                   <?php
                                                      }
                                                   } ?>
                                                </tbody>
                                             </table>
                                             <h3 class="page-header edusec-border-bottom-primary">
                                                <i class="fa fa-info-circle"></i> Migration Details
                                                <div class="pull-right">
                                                </div>
                                             </h3>
                                             <table class="table table-striped table-bordered">
                                                <thead>
                                                   <tr>
                                                      <th>#</th>
                                                      <th>Action</th>
                                                      <th>Sr.No.</th>
                                                      <th>Academic Year</th>
                                                      <th>Course</th>
                                                      <th>Year/Section</th>
                                                      <th>Completion <br> Status</th>
                                                      <th>Status</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php $cntsss = 1;
                                                   if (isset($studsentold) && !empty($studsentold)) {
                                                      foreach ($studsentold as $values) { ?>
                                                         <tr data-key="44">
                                                            <td><?php echo $cntsss++; ?></td>
                                                            <td>ENROLL</td>
                                                            <td><?php echo $values['enroll']; ?></td>
                                                            <td><?php echo $values['acedmicyear']; ?></td>
                                                            <td><?php echo $values['class']['title']; ?></td>
                                                            <td><?php echo $values['section']['title']; ?></td>
                                                            <td><span class="label label-primary"><? echo "Migration";  ?></span></td>
                                                            <td><span class="label label-success">Active</span></td>
                                                         </tr>
                                                      <?php
                                                      }
                                                   } else {  ?>
                                                      <tr data-key="44">
                                                         <td colspan="8" style="text-align: center;"><b>No Data Found</b></td>
                                                      </tr>
                                                   <?php } ?>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                       <!--/box-body-->
                                    </div>
                                    <!--/box-->
                                 </div>
                                 <div class="tab-pane" id="guardians">
                                    <h3 class="page-header edusec-border-bottom-primary">
                                       <i class="fa fa-files-o"></i> Guardians Detail
                                       <div class="pull-right edusecRtlPullLeft">
                                          <?php if (empty($classessss['id'])) { ?>
                                             <a class="btn btn-primary btn-sm globalModals" href="<?php echo SITE_URL; ?>admin/students/addguardian?id=<?php echo $students['id'] ?>" data-target="#globalModal" data-toggle="modal">Add Guardian</a>
                                          <?php } else { ?>
                                             <a class="btn btn-primary btn-sm globalModals" href="<?php echo SITE_URL; ?>admin/students/addguardian/<?php echo $classessss['id'] ?>" data-target="#globalModal" data-toggle="modal">Edit Guardian </a>
                                          <?php } ?>
                                       </div>
                                    </h3>
                                    <div class="box box-solid">
                                       <div class="box-body no-padding table-responsive">
                                          <table class="table tbl-profile">
                                             <colgroup>
                                                <col style="width:15%">
                                                <col style="width:35%">
                                                <col style="width:15%">
                                                <col style="width:35%">
                                             </colgroup>
                                             <tbody>
                                                <tr>
                                                   <td class="profile-label">Full Name</td>
                                                   <td><?php echo ucfirst($classessss['fullname']); ?></td>
                                                   <td class="profile-label">Relation</td>
                                                   <td><?php echo ucfirst($classessss['relation']); ?></td>
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Qualification</td>
                                                   <td><?php echo ucfirst($classessss['qualification']); ?></td>
                                                   <td class="profile-label">Occupation</td>
                                                   <td><?php echo $classessss['occupation']; ?></td>
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Total Income</td>
                                                   <td><?php echo $classessss['total_Income']; ?></td>
                                                   <td class="profile-label">Mobile No</td>
                                                   <td><?php echo $classessss['mobileno']; ?></td>
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Email Id</td>
                                                   <td><?php echo $classessss['emails']; ?></td>
                                                   <td class="profile-label">Address</td>
                                                   <td><?php echo $classessss['address']; ?></td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                                       <!--/box-body-->
                                    </div>
                                    <!--/box-->
                                    <!--/box-->
                                 </div>
                                 <div class="tab-pane" id="address">
                                    <h3 class="page-header edusec-border-bottom-primary">
                                       <i class="fa fa-info-circle"></i> Address Info
                                       <div class="pull-right">
                                          <?php if ($students['address']) { ?>
                                             <a class="btn btn-primary" href="<?php echo SITE_URL; ?>admin/students/edit/<?php echo $students['id'] ?>">Edit</a>
                                          <?php } else { ?>
                                             <a class="btn btn-primary" href="<?php echo SITE_URL; ?>admin/students/edit/<?php echo $students['id'] ?>">Edit</a>
                                          <?php } ?>
                                       </div>
                                    </h3>
                                    <!---Start Current Address Block--->
                                    <h4 class="edusec-border-bottom-warning page-header with-button profile-sub-header">
                                       Address
                                    </h4>
                                    <div class="box box-solid">
                                       <div class="box-body no-padding table-responsive">
                                          <table class="table tbl-profile">
                                             <colgroup>
                                                <col style="width:200px">
                                                <col style="width:300px">
                                                <col style="width:200px">
                                                <col style="width:300px">
                                             </colgroup>
                                             <tbody>
                                                <tr>
                                                   <td class="profile-label">Location</td>
                                                   <td><?php echo $students['address']; ?></td>
                                                </tr>
                                                <tr>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </div>
                                       <!--/box-body-->
                                    </div>
                                    <!--/box-->
                                 </div>
                                 <div class="tab-pane" id="documents">
                                    <!---Display document upload title-->
                                    <h4 class="page-header edusec-border-bottom-primary">
                                       <i class="fa fa-files-o"></i> Uploaded Documents
                                       <div class="pull-right edusecRtlPullLeft">
                                          <a class="btn btn-primary btn-sm globalModals" href="<?php echo SITE_URL; ?>admin/students/addocument?ids=<?php echo $ids; ?>" data-target="#globalModal" data-toggle="modal">
                                             <i class="fa fa-plus-square"></i> Add</a>
                                       </div>
                                    </h4>
                                    <div class="box box-solid">
                                       <div class="box-body no-padding ">
                                          <div id="w4" class="grid-view">
                                             <table class="table table-striped table-bordered">
                                                <thead>
                                                   <tr>
                                                      <th>#</th>
                                                      <th>Category</th>
                                                      <th>Document Details</th>
                                                      <th>Submited Date</th>
                                                      <th>Download</th>
                                                      <th>Approved/Disapproved</th>
                                                      <th class="action-column">Action</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php $cnt = '1';
                                                   if (count($doc_img) > 0) {
                                                      foreach ($doc_img as $value) { ?>
                                                         <tr>
                                                            <td><?php echo $cnt++; ?></td>
                                                            <td><?php echo $value['documentcategory']['categoryname']; ?></td>
                                                            <td><?php echo $value['description']; ?></td>
                                                            <td><?php echo  date('d M Y', strtotime($value['created'])); ?></td>
                                                            <td><?php if (isset($value['photo'])) { ?><a download="Document.<?php echo $value['ext']; ?>" href="<?php echo SITE_URL; ?>webroot/img/<?php echo $value['photo']; ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a> <?php } else {
                                                                                                                                                                                                                                                                                                                                          echo "N\A";
                                                                                                                                                                                                                                                                                                                                       } ?><br>
                                                            <td><?php if ($value['status'] == 'Y') {
                                                                     echo $this->Html->link('Approved', [
                                                                        'action' => 'documentstatus',
                                                                        $value->id,
                                                                        $value['status']
                                                                     ], ['class' => 'label label-success']);
                                                                  } else {
                                                                     echo $this->Html->link('Disapproved', [
                                                                        'action' => 'documentstatus',
                                                                        $value->id,
                                                                        $value['status']
                                                                     ], ['class' => 'label label-primary']);
                                                                  } ?></td>
                                                            <td>
                                                               <div class="btn-group">
                                                                  <button id="w2" class="btn-primary btn-xs btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i> <span class="caret"></span></button>
                                                                  <ul id="w3" class="dropdown-menu" style="left:-73px;min-width:50px">
                                                                     <li><a class="text-green globalModals" href="<?php echo SITE_URL; ?>admin/students/addocument/<?php echo $value->id; ?>" data-placement="top" tabindex="-1" data-target="#globalModal" data-toggle="modal"><i class="fa fa-pencil-square-o"></i>EDIT</a></li>
                                                                     <li><a class="text-green" href="<?php echo SITE_URL; ?>admin/students/deletedocument/<?php echo $value->id; ?>" data-toggle="tooltip" data-placement="top" onclick="return confirm('Are you sure you want to delete this document?');" data-method="post" tabindex="-1"><i class="fa fa-pencil-square-o"></i>Delete</a></li>
                                                                  </ul>
                                                               </div>
                                                            </td>
                                                         <?php }
                                                   } else { ?>
                                                         <td colspan="8">
                                                            <div class="empty">No results found.</div>
                                                         </td>
                                                      <?php } ?>
                                                         </tr>
                                                </tbody>
                                             </table>
                                          </div>
                                       </div>
                                       <!--/box-body-->
                                    </div>
                                    <!--/box-->
                                 </div>
                                 <div class="tab-pane" id="history">
                                    <h4 class="page-header edusec-border-bottom-primary">
                                       <i class="fa fa-files-o"></i>Compulsory Subject
                                       <div class="pull-right edusecRtlPullLeft">
                                          <?php if (empty($students['comp_sid'])) { ?>
                                             <a class="btn btn-primary btn-sm globalModals" href="<?php echo SITE_URL; ?>admin/students/addsubject/<?php echo $students['id']; ?>" data-target="#globalModal" data-toggle="modal">
                                                <i class="fa fa-plus-square"></i> Add</a>
                                          <?php } else { ?>
                                             <a class="btn btn-primary btn-sm globalModals" href="<?php echo SITE_URL; ?>admin/students/addsubject/<?php echo $students['id']; ?>" data-target="#globalModal" data-toggle="modal">
                                                <i class="fa fa-plus-square"></i> Edit</a>
                                          <?php } ?>
                                       </div>
                                    </h4>
                                    <div class="box box-solid">
                                       <div class="box-body no-padding table-responsive">
                                          <table class="table tbl-profile">
                                             <colgroup>
                                                <col style="width:200px">
                                                <col style="width:300px">
                                                <col style="width:200px">
                                                <col style="width:300px">
                                             </colgroup>
                                             <tbody>
                                                <?php $k = 1;
                                                foreach ($subjects as $key => $value) { ?>
                                                   <tr>
                                                      <td class="profile-label">Subject-<?php echo $k++; ?></td>
                                                      <td class="profile-label"><?php echo $value['name']; ?></br>
                                                      </td>
                                                   </tr>
                                                <?php } ?>
                                             </tbody>
                                          </table>
                                       </div>
                                       <!--/box-body-->
                                    </div>
                                    <!--/box-->
                                    <?php if ($students['class_id'] > 10) { ?>
                                       <!---Start Permenant Address Block--->
                                       <h4 class="edusec-border-bottom-warning page-header with-button profile-sub-header">
                                          Optional Subject
                                       </h4>
                                       <div class="box box-solid">
                                          <div class="box-body no-padding table-responsive">
                                             <table class="table tbl-profile">
                                                <colgroup>
                                                   <col style="width:200px">
                                                   <col style="width:300px">
                                                   <col style="width:200px">
                                                   <col style="width:300px">
                                                </colgroup>
                                                <?php $k = 1;
                                                foreach ($subjectss as $keyed => $valued) { ?>
                                                   <tr>
                                                      <td class="profile-label">Subject<?php echo $k++; ?></td>
                                                      <td class="profile-label"><?php echo $valued['name']; ?></br>
                                                      </td>
                                                   </tr>
                                                <?php } ?>
                                             </table>
                                          </div>
                                          <!--/box-body-->
                                       </div>
                                       <!--/box-->
                                    <?php } ?>
                                 </div>

                                 <!-- for show result  -->


                                 <div class="tab-pane" id="result">

                                    <h4 class="page-header edusec-border-bottom-primary">
                                       <i class="fa fa-files-o"></i> Student Result

                                    </h4>
                                    <div class="box box-solid">
                                       <div class="box-body no-padding ">
                                          <div id="w4" class="grid-view">

                                             <?php /*
                                             <table class="table table-striped table-bordered">
                                                <thead>
                                                   <tr>
                                                      <th>#</th>
                                                      <th>Exam Name</th>
                                                      <th>Subject Name</th>
                                                      <th>Year</th>
                                                      <th>Result</th>
                                                      <th>Exam Date</th>
                                                      <th class="action-column">Exam Result Date</th>
                                                   </tr>
                                                </thead>
                                                <tbody>

                                                   <?php
                                                   $i = 1;
                                                   $findexam_name = $this->Comman->findexam_id($students['id']);

                                                   foreach ($findexam_name as $key => $value) {


                                                      $studetnt_result = $this->Comman->findStudentsResult($students['id'], $value['id']);

                                                      $studetnt_backlog_result = $this->Comman->findStudentsBacklogResult($students['id']);



                                                      foreach ($studetnt_result as $key => $values) {
                                                         $findSubjName = $this->Comman->findsubjnames($values['subject_id']);
                                                   ?>
                                                         <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $value['exam_name']; ?></td>
                                                            <td><?php echo $findSubjName['subject']; ?></td>
                                                            <td><?php echo $value['exam_year']; ?></td>
                                                            <td><?php echo $values['result']; ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($value['exam_date'])); ?></td>
                                                            <td><?php echo date('d-m-Y', strtotime($value['result_date'])); ?></td>
                                                         </tr>

                                                      <?php $i++;
                                                      }
                                                      ?>

                                                      <?php if (!empty($studetnt_backlog_result)) {
                                                         foreach ($studetnt_backlog_result as $keys => $findStudentsResult) {
                                                            $findSubjName = $this->Comman->findsubjbacklog($findStudentsResult['subject_id']);
                                                      ?>
                                                            <tr>
                                                               <td><?php echo $i; ?></td>
                                                               <td><?php echo $value['exam_name']; ?></td>
                                                               <td><?php echo $findSubjName['subject']; ?></td>
                                                               <td><?php echo $value['exam_year']; ?></td>
                                                               <td><?php echo $findStudentsResult['result']; ?></td>
                                                               <td><?php echo date('d-m-Y', strtotime($value['exam_date'])); ?></td>
                                                               <td><?php echo date('d-m-Y', strtotime($value['result_date'])); ?></td>
                                                            </tr>


                                                   <?php     }
                                                      }
                                                   } ?>
                                                </tbody>
                                             </table>
                                             */ ?>

                                             <table class="table table-striped table-bordered">
                                                <thead>
                                                   <tr>
                                                      <th>#</th>
                                                      <th>Exam Name</th>
                                                      <th>Year</th>
                                                      <th>Result</th>
                                                      <th>Total Marks</th>
                                                      <th>Marks Obtained</th>
                                                      <th>Exam Date</th>
                                                      <th class="action-column">Exam Result Date</th>
                                                   </tr>
                                                </thead>
                                                <tbody>

                                                   <?php
                                                   $i = 1;

                                                   $findexam_name = $this->Comman->student_finel_result($students['id']);

                                                   foreach ($findexam_name as $value) {  ?>

                                                      <tr>
                                                         <td><?php echo $i; ?></td>
                                                         <td> <a class="globalModalssss" href="<?php echo SITE_URL; ?>admin/students/resultinfo?ids=<?php echo $ids; ?>" data-target="#globalModalssss" data-toggle="modal"><?php echo $value['exam_name']; ?></a></td>
                                                         <td><?php echo $value['exam_year']; ?></td>
                                                         <td><?php echo $value['result']; ?></td>
                                                         <td><?php echo $value['total_marks']; ?></td>
                                                         <td><?php echo $value['obtained_marks']; ?></td>
                                                         <td><?php echo date('d-m-Y', strtotime($value['exam_date'])); ?></td>
                                                         <td><?php echo date('d-m-Y', strtotime($value['result_date'])); ?></td>
                                                      </tr>

                                                   <?php $i++;
                                                   } ?>
                                                </tbody>
                                             </table>




                                          </div>
                                       </div>
                                       <!--/box-body-->
                                    </div>
                                    <!--/box-->
                                 </div>


                                 <!--end result section-->


                              </div>
                              <!--/row-->
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
               <div class="box-footer">
                  <?php
                  echo $this->Html->link('Back', [
                     'action' => 'index'

                  ], ['class' => 'btn btn-default']); ?>
               </div>
               <!-- /.box-footer -->
            </div>
         </div>
         <!--/.col (right) -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>

<div class="modal" id="globalModalssss" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
                     <div class="modal-dialog" style="max-width: 750px !important;">
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