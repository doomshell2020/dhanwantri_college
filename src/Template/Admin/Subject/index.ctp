<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h3>
         Manage Subject
      </h3>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>subject/index">Manage Subject</a></li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header" style="display: flex; align-items: center;">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  <h3 class="box-title" style="flex: 1;">View Subject</h3>
                  <a href="<?php echo ADMIN_URL; ?>subject/add" class="btn btn-default">Add Subject</a>
               </div>
               <?php echo $this->Form->create('Task', array('url' => array('controller' => 'students', 'action' => 'search'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'Subject-Search-Form', 'class' => 'form-horizontal')); ?>
               <div class="form-group form_gpr_colm">

                  <?php $course = !empty($_GET['course_id']) ? $_GET['course_id'] : '';
                  // pr($searchResult);exit; 
                  $searchresult = $_GET;
                  // pr($searchresult);exit;
                  ?>
                  <div class="col-sm-4" style="margin-left: 15px;">
                     <label>Course</label>
                     <select class="form-control" name="class_id" id="class-id">
                        <option value="">Select Course</option>
                        <?php foreach ($classes as $esr => $es) { ?>
                           <option value="<?php echo $esr; ?>" <?php echo $searchresult['class_id'] == $esr ? 'selected' : '' ?>><?php echo $es; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="col-sm-4">
                     <label>Year/Semester</label>
                     <select class="form-control" name="section_id" id="section-id">
                        <option value=""> Year/Semester </option>
                        <?php foreach ($sections as $er => $e) { ?>
                           <option value="<?php echo $e['id']; ?>" <?php echo $searchresult['section_id'] == $e['id'] ? 'selected' : '' ?>><?php echo $e['title']; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <script>
                     $(document).ready(function() {
                        $('#class-id').on('change', function() {
                           var id = $('#class-id').val();
                           $.ajax({
                              type: 'POST',
                              url: "<?php echo SITE_URL ?>admin/ClasstimeTabs/find_section",
                              data: {
                                 'id': id
                              },
                              beforeSend: function(xhr) {
                                 xhr.setRequestHeader('X-CSRF-Token', $(
                                    '[name="_csrfToken"]').val())
                              },
                              success: function(data) {
                                 $('#section-id').empty();
                                 $('#section-id').html(data);
                              },
                           });
                        });
                     });


                     $(document).ready(function() {
                        $("#Subject-Search-Form").bind("submit", function(event) {
                           $.ajax({
                              async: true,
                              data: $("#Subject-Search-Form").serialize(),
                              dataType: "html",
                              beforeSend: function(xhr) {
                                 xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
                              },
                              success: function(data, textStatus) {
                                 $("#example23").html(data);
                              },
                              type: "get",
                              url: "<?php echo ADMIN_URL; ?>subject/search"
                           });
                           return false;
                        });

                     });

                     $(document).on('click', '.pagination a', function(e) {
                        var target = $(this).attr('href');
                        var res = target.replace("/subject/search", "/subject");
                        window.location = res;
                        return false;
                     });
                  </script>

                  <div class="col-sm-12 text-center" style="padding: 23px;">
                     <label>&nbsp;</label>
                     <label>&nbsp;</label>
                     <button type="submit" class="btn btn-success">Search</button>
                     <a class="btn btn-info " style="color:#ffffff !important; background-color: #8B0000; !important" href="<?php echo SITE_URL; ?>admin/subject/index"><b>Reset</i></b></a>

                  </div>
               </div>
               <?php echo $this->Form->end(); ?>
               <?php echo $this->Flash->render(); ?>
               <div class="box-body" id="example23">
                  <table id="" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Subject Name</th>
                           <th>Course Name</th>
                           <th>Year/Semester</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody id="example2">
                        <?php $page = $this->request->params['paging']['CourseSubjects']['page'];
                        $limit = $this->request->params['paging']['CourseSubjects']['perPage'];
                        $counter = ($page * $limit) - $limit + 1;
                        if (isset($course_subject) && !empty($course_subject)) {
                           foreach ($course_subject as $subject) {
                        ?>
                              <tr>
                                 <td><?php echo $counter++; ?></td>
                                 <td><?php echo $subject['subject']; ?></td>
                                 <td><?php $class = $this->Comman->findclass($subject['course_id']);
                                       echo $class['title']; ?></td>
                                 <td><?php $section = $this->Comman->findsecti($subject['year']);
                                       echo $section['title'];
                                       ?>
                                 </td>
                                 <td>
                                    <!-- <?php if ($subject['featured'] == 'Y') {
                                             echo $this->Html->link('', [
                                                'action' => 'status',
                                                $subject->id, 'Y'
                                             ], ['title' => 'Active', 'class' => 'fas fa-check-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color: #36cb3c;']);
                                          } else {
                                             echo $this->Html->link('', [
                                                'action' => 'status', $subject->id, 'N'
                                             ], ['title' => 'Inactive', 'class' => 'fas fa-times-circle', 'style' => 'font-size: 16px !important; margin-left: 12px; color:#cd0404;']);
                                          } ?> -->
                                    <a title='Delete' href="<?php echo SITE_URL; ?>admin/subject/delete/<?php echo $subject->id; ?>" style="font-size: 16px !important; color: red;" onclick="javascript: return confirm('Are you sure do you want to delete this Notification.')"><span class="fa fa-trash"></span></a>
                                    <!-- <a title='Edit' href="<?php // echo SITE_URL; 
                                                               ?>admin/subject/edit/<?php //echo $subject->id; 
                                                                                    ?>" style="font-size: 16px !important; color: blue;"><span class="fa fa-edit"></span></a> -->
                                 </td>
                                 <?php // } 
                                 ?>
                              </tr>
                           <?php $counter + 1;
                           }
                        } else { ?>
                           <tr>
                              <td colspan="9">NO Data Available</td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
                  <?php
                  echo $this->element('admin/pagination');
                  ?>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>