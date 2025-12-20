<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1> Exam Result Upload Excel </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
         <li class="active"> Upload Excel </li>
      </ol>
      <div id="imagePreview" style="position: absolute; z-index: 9;left: 0;right: 0;text-align: center;top: 0px; margin-top: 88px;">
      </div>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- right column -->
         <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
               <div class="box-header with-border">
               </div>
               <a style="text-decoration:underline;" href="<?php echo SITE_URL; ?>admin/exam/excelexport/<?php echo $id . '/' . $course_id . '/' . $section_id . '/' . $exam_year ?>">
                  &nbsp; &nbsp;Click Here For Download <span style="color:red;">
                     <? echo $examname['examname']; ?>
                  </span> Excel Format</a>
               <!-- /.box-header -->
               <!-- form start -->
               <?php echo $this->Flash->render(); ?>
               <?php echo $this->Form->create(null, array(
                  'action' => 'uploadexcel/' . $id . '/' . $course_id . '/' . $section_id . '/' . $exam_year,
                  'class' => 'form-horizontal',
                  'type' => 'file',
                  'enctype' => 'multipart/form-data',
                  'validate',
                  'id' => 'uploadForm'
               )); ?>
               <div class="box-body">
                  <div class="form-group">
                     <?php echo $this->Form->hidden('finalize', ['value' => '', 'id' => 'finalize']); ?>
                     <label for="inputEmail3" class="col-sm-2 control-label">Upload Excel</label>
                     <div class="col-sm-10">
                        <?php echo $this->Form->input('file', array('class' => 'form-control', 'type' => 'file', 'required', 'id' => 'title', 'label' => false)); ?>
                     </div>
                  </div>
               </div>
               <!-- /.box-body -->
               <div class="box-footer">
                  <?php if ($is_finalized['is_finalized'] != 1) {
                     echo $this->Form->submit(
                        'Upload',
                        array('class' => 'btn btn-info pull-right', 'title' => 'Upload')
                     );
                  }

                  ?>

                  <!-- /.box-footer -->
                  <?php echo $this->Form->end(); ?>

                  <?php if ($is_finalized['is_finalized'] != 1) { ?>
                     <a href="" class="btn btn-info pull-left drop">Save & Finalized</a>
                  <?php } ?>
               </div>



               <h5 style="color:red;">Important Notes:-</h5>
               <ul>
                  <li>Marks Cannot Be Greater Than Maximum Marks.</li>
                  <li>Integer Type Marks Allowed Only In Excel Cell.</li>
                  <li>For Absent Student Kindly Fill Excel Cell(A).</li>
               </ul>
               <!-- End  -->
            </div>
         </div>
         <!--/.col (right) -->
      </div>
      <!-- /.row -->
   </section>

   <script>
      $(document).ready(function() {
         $(document).on("click", ".drop", function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to save and finalize?')) {
               // Submit the form using JavaScript
               $('#finalize').val('1');
               $('#uploadForm').submit();
            }
         });
      });
   </script>