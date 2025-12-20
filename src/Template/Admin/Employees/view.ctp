<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Employee Manager
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>employees">Manage Employee</a></li>
         <li class="active"><?php echo ucfirst($employees['fname']); ?> <?php echo $employees['middlename']; ?></li>
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
         <!--/.col (left) -->
         <!-- right column -->
         <div class="col-md-12">
            <!-- Horizontapr($students); die;l Form -->
            <div class="box box-info">
               <!-- /.box-header -->
               <!-- form start -->
               <div class="box-body">
                  <?php echo $this->Flash->render(); ?>
                  <section class="content">
                     <!---Start display student profile header with photo--->
                     <div class="row">
                        <div class="col-sm-12 col-xs-12">
                           <div class="well well-sm panel panel-default">
                              <div class="panel-body">
                                 <div class="row">
                                    <div class="col-xs-12 col-sm-4 text-center edusecArLangCss">
                                       <?php $db = $this->request->session()->read('Auth.User.db');
                                       if (!empty($employees['file'])) { ?>
                                          <img class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL; ?><?php echo $db . '_image'; ?>/employees/<?php echo $employees['file']; ?>">
                                          <div class="photo-edit-admin">
                                          <?php } else { ?>
                                             <img class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL; ?>webroot/uploads/no-images.png">
                                             <div class="photo-edit-admin">
                                             <?php } ?>
                                             <?php if (empty($employees['file'])) { ?>
                                                <a class="photo-edit-icon-admin" href="<?php echo SITE_URL; ?>admin/employees/employeesimage/<?php echo $employees['id'] ?>" title="Add Profile Picture"><i class="fa fa-pencil"> </i></a>
                                             <?php } else { ?>
                                                <a class="photo-edit-icon-admin" href="<?php echo SITE_URL; ?>admin/employees/employeesimage/<?php echo $employees['id'] ?>" title="Edit Profile Picture"><i class="fa fa-pencil"> </i></a>
                                             <?php } ?>
                                             </div>
                                             <h3 class="text-primary">
                                                <b> <?php echo ucfirst($employees['fname']); ?> <?php echo $employees['middlename']; ?>
                                                   <?php echo $employees['lname']; ?></b>
                                             </h3>
                                          </div>
                                          <div class="col-xs-12 col-sm-8 edusecArLangCss teacher_about">
                                             <h5>Contact Info</h5>
                                             <p>
                                                <strong>Teacher Id : </strong>
                                                <?php echo $employees['id']; ?>
                                             </p>
                                             <p>
                                                <strong>Email/Login Id : </strong>
                                                <?php echo $employees['email']; ?> <a class="photo-edit-icon-admin bg-aqua globalModals" href="<?php echo SITE_URL; ?>admin/employees/change_email/<?php echo $employees['id'] ?>" title="Change Email/Login ID" data-target="#globalModal" data-toggle="modal"><i class="fa fa-pencil"></i></a>
                                             </p>
                                             <p>
                                                <strong>Mobile No : </strong>
                                                <?php echo $employees['mobile']; ?>
                                             </p>
                                             <p><strong>Status :</strong>
                                                <?php if ($employees['status'] == 'Y') { ?> <span class="label label-success"> Active</span>
                                                <?php } else { ?> <span class="label label-primary"> In-Active</span><?php } ?>
                                             </p>
                                          </div>
                                          <!--/col-->
                                          <div class="col-xs-12 col-sm-3 edusecArLangCss text-right">

                                          </div>
                                    </div>
                                    <!--/row-->
                                 </div>
                                 <!--/panel-body-->
                              </div>
                              <!--/panel-->
                           </div>
                           <!--/col-->
                        </div>
                        <!--/row-->
                        <div class="row edusec-user-profile">
                           <div class="col-sm-12">
                              <ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="profileTab">
                                 <li class="active" id="personal-tab"><a href="http://demo.edusec.org/student/stu-master/view?id=38#personal" data-toggle="tab"><i class="fa fa-street-view"></i> Personal</a></li>
                                 <li id="documents-tab"><a href="http://demo.edusec.org/student/stu-master/view?id=38#documents" data-toggle="tab"><i class="fa fa-file-text"></i> Documents</a></li>
                              </ul>
                              <div id="content" class="tab-content responsive hidden-xs hidden-sm">
                                 <div class="tab-pane active" id="personal">
                                    <h3 class="page-header edusec-border-bottom-primary">
                                       <i class="fa fa-info-circle"></i> Personal Details
                                       <div class="pull-right">
                                          <a class="btn btn-primary btn-sm" href="<?php echo SITE_URL; ?>admin/employees/emp_edit/<?php echo $employees['id'] ?>" target="_blank"><i class="fas fa-pen"></i></a>
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
                                                   <td class="profile-label">Department</td>
                                                   <td><?php echo $employees['department']['name'] ?></td>
                                                   <td class="profile-label">Designation</td>
                                                   <td><?php echo $employees['designation']['name']; ?></td>
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Name</td>
                                                   <td><?php echo ucfirst($employees['fname']); ?>
                                                      <?php echo ucfirst($employees['middlename']); ?>
                                                      <?php echo ucfirst($employees['lname']); ?>
                                                   </td>
                                                   <td class="profile-label">Gender</td>
                                                   <td><?php echo $employees['gender']; ?></td>
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Date of Birth</td>
                                                   <td><?php echo date('d-m-Y', strtotime($employees['dob'])); ?></td>
                                                   <td class="profile-label">Nationality</td>
                                                   <td>Indian</td>
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Maritial Status</td>
                                                   <td><?php echo $employees['martial_status']; ?></td>
                                                   <td class="profile-label">Father/Husband Name</td>
                                                   <td><?php echo $employees['f_h_name']; ?></td>
                                                </tr>
                                                <tr>
                                                   <td class="profile-label">Slab Teachers</td>
                                                   <td><?php echo $employees['slab_type']; ?></td>
                                                   <td class="profile-label">Joining date</td>
                                                   <td><?php echo date('d-m-Y', strtotime($employees['joiningdate'])); ?></td>
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
                                          <a class="btn btn-primary btn-sm globalModals" href="<?php echo SITE_URL; ?>admin/employees/addocument?did=<?php echo $employees['id']; ?>" data-target="#globalModal" data-toggle="modal">Add </a>
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
                                                            <td><?php echo date('d M Y', strtotime($value['created'])); ?></td>
                                                            <td><a download="Document.<?php echo $value['ext']; ?>" href="<?php echo SITE_URL; ?>webroot/img/<?php echo $value['photo']; ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a><br>
                                                            <td>
                                                               <div class="btn-group">
                                                                  <button id="w2" class="btn-primary btn-xs btn dropdown-toggle" data-toggle="dropdown"><i class="fa fa-gear"></i> <span class="caret"></span></button>
                                                                  <ul id="w3" class="dropdown-menu" style="left:-73px;min-width:50px">
                                                                     <li><a class="text-green globalModals" href="<?php echo SITE_URL; ?>admin/employees/addocument/<?php echo $value->id; ?>" data-placement="top" tabindex="-1" data-target="#globalModal" data-toggle="modal"><i class="fa fa-pencil-square-o"></i>EDIT</a></li>
                                                                     <li><a class="text-green" href="<?php echo SITE_URL; ?>admin/employees/deletedocument/<?php echo $value->id; ?>" data-toggle="tooltip" data-placement="top" data-confirm="Are you sure you want to delete this student" data-method="post" tabindex="-1"><i class="fa fa-pencil-square-o"></i>Delete</a></li>
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
                     'action' => 'index',
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
<div class="modal fade global-drop-out" role="dialog" data-backdrop="true">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content modal-content-drop-out">
      </div>
   </div>
</div>
<script>
   $(document).ready(function() {
      $("#depform").click(function(event) {
         $('.modal-content-drop-out').load($(this).attr("href"));
      });
   });
</script>