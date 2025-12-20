<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h3>
         Manage Exam
      </h3>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>exam/index">Manage Exam</a></li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="box-header" style="display: flex; align-items: center;">
                  <i class="fa fa-search" aria-hidden="true"></i>
                  <?php $coordinator = $this->request->session()->read('Auth.User.role_id');

                  if ($coordinator == 1) { ?>
                     <a href="<?php echo ADMIN_URL; ?>exam/add" class="btn btn-default">Add Exam</a>

                  <?php    } ?>
                  <h3 class="box-title" style="flex: 1;">View Exam</h3>
               </div>
               <?php echo $this->Flash->render(); ?>
               <div class="box-body">
                  <table id="" class="table table-bordered table-striped">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Exam Name</th>
                           <th>Course Name</th>
                           <th>Year/Semester</th>
                           <th>Exam Date</th>
                           <th>Exam Result Date</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody id="example2">
                        <?php $page = $this->request->params['paging']['Students']['page'];
                        $limit = $this->request->params['paging']['Students']['perPage'];
                        $counter = ($page * $limit) - $limit + 1;
                        if (isset($exams) && !empty($exams)) {
                           foreach ($exams as $exam) {
                        ?>
                              <tr>
                                 <td><?php echo $counter++; ?></td>
                                 <td><?php echo $exam['exam_name']; ?></td>
                                 <td><?php $class = $this->Comman->findclass($exam['course_id']);
                                       echo $class['title']; ?></td>
                                 <td><?php $section = $this->Comman->findsecti($exam['year_id']);
                                       echo $section['title'];
                                       ?>
                                 </td>
                                 <td><?php echo date('d-m-Y', strtotime($exam['exam_date'])); ?></td>
                                 <td><?php echo !empty($exam['result_date']) ? date('d-m-Y', strtotime($exam['result_date'])) : ''; ?></td>

                                 <?php
                                 $findExamResultCount = $this->Comman->findExamResultIsNotNull($exam['id']);
                                 // pr($findExamResultCount); 
                                 ?>
                                 <td>
                                    <?php if ($findExamResultCount == 0) { ?>
                                       <a title='Delete' href="<?php echo SITE_URL; ?>admin/exam/delete/<?php echo $exam->id; ?>" style="font-size: 16px !important; color: red;" onclick="javascript: return confirm('Are you sure do you want to delete this exam.')"><span class="fa fa-trash"></span></a>
                                    <?php } ?>

                                    <!-- <a title='Edit' href="<?php echo SITE_URL; ?>admin/exam/edit/<?php echo $exam->id; ?>" style="font-size: 16px !important; color: blue;"><span class="fa fa-edit"></span></a> -->


                                    <?php if (!empty($exam['result_date']) && date('Y-m-d', strtotime($exam['result_date'])) <= date('Y-m-d')) { ?>
                                       <a title='download pdf' target="_blank" href="<?php echo SITE_URL; ?>admin/exam/downloadpdf/<?php echo $exam['id'] . '/' . $exam['course_id'] . '/' . $exam['exam_year'] ?>" style="font-size: 16px !important; color: blue;"><span style="margin: 3px;" class="fa fa-file-pdf-o"></span></a>
                                    <?php } ?>

                                    <?php if ($exam['is_finalized'] != 1) { ?>
                                       <a title='Upload Excel' href="<?php echo SITE_URL; ?>admin/exam/uploadexcel/<?php echo $exam['id'] . '/' . $exam['course_id'] . '/' . $exam['year_id'] . '/' . $exam['section_id'] . $exam['exam_year'] ?>" style="font-size: 16px !important; color: blue;"><span style="margin: 3px;" class="fa fa-upload"></span></a>
                                    <?php }  ?>
                                 </td>
                                 <?php // } 
                                 ?>
                              </tr>
                           <?php $counter + 1;
                           }
                        } else { ?>
                           <tr>
                              <td colspan="9">No Data Available</td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </section>
</div>