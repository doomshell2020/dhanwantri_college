<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Exam Manager
      </h1>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- right column -->
         <div class="col-md-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
               <div class="box-header with-border">
                  <h3 class="box-title"><?php if (isset($exam['id'])) {
                                             echo 'Edit Exam';
                                          } else {
                                             echo 'Add Exam';
                                          } ?></h3>
               </div>
               <!-- /.box-header -->
               <!-- form start -->
               <?php echo $this->Flash->render(); ?>
               <?php echo $this->Form->create($exam, array(
                  'class' => 'form-horizontal',
                  'id' => 'sevice_form',
                  'enctype' => 'multipart/form-data',
               )); ?>
               <div class="box-body">
                  <div class="row" style="display:flex; align-items: flex-end; flex-wrap:wrap;">
                     <div class="col-md-6">
                        <label>Exam Name<span style="color:red;">*</span></label>
                        <?php echo $this->Form->input('exam_name', array('class' => 'form-control', 'required' => "required", 'placeholder' => 'Exam Name', 'label' => false)); ?>
                     </div>
                     <div class="col-md-6">
                        <label>Course Name<span style="color:red;">*</span></label>
                        <select class="form-control" name="course_id" id="class-id" required>
                           <option value="">---Select Course---</option>
                           <?php foreach ($course as $esr => $es) { ?>
                              <option value="<?php echo $esr; ?>"><?php echo $es; ?></option>
                           <?php } ?>
                        </select>
                     </div>


                     <div class="col-md-6">
                        <label>Year/Semester<span style="color:red;">*</span></label>
                        <select class="form-control" name="exam_year" id="section-id" required="required">
                           <option value=""> ---Select Section--- </option>
                           <?php foreach ($sections as $esrh => $esh) {
                           ?>
                              <option value="<?php echo $esh['id']; ?>"><?php echo $esh['title']; ?></option>
                           <?php  }
                           ?>
                        </select>
                     </div>


                     <div class="col-md-6">
                        <label>Exam Date<span style="color:red;">*</span></label>
                        <input type="text" name="exam_date" id="datepick1" placeholder="DD-MM-YYYY" required
                           class="form-control" autocomplete="off">
                     </div>

                     <div class="col-md-6">
                        <label>Exam Result Date</span></label>
                        <input type="text" name="result_date" placeholder="DD-MM-YYYY" class="form-control"
                           id="datepick2" autocomplete="off" readonly>
                     </div>

                     <div class="col-md-12">
                        <style>
                           table,
                           th,
                           td {
                              border: 1px solid black;
                           }
                        </style>
                        <div id="subject-id">
                        </div>
                     </div>
                     <div class="col-md-12" style="margin-top:10px;">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                           <?php
                           echo $this->Html->link('Back', [
                              'action' => 'index'
                           ], ['class' => 'btn btn-default']); ?>
                           <?php
                           if (isset($exam['id'])) {
                              echo $this->Form->submit(
                                 'Update',
                                 array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                              );
                           } else {
                              echo $this->Form->submit(
                                 'Add',
                                 array('class' => 'btn btn-info pull-right', 'title' => 'Add')
                              );
                           }
                           ?>
                        </div>
                     </div>
                  </div>
                  <!-- /.box-footer -->
                  <?php echo $this->Form->end(); ?>
               </div>
            </div>
            <!--/.col (right) -->
         </div>
         <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script>
   // change course and section after show in course subject
   $(document).ready(function() {
      var $classId = $('#class-id');
      var $sectionId = $('#section-id');
      var $subjectId = $('#subject-id');

      function findSubjects() {
         AmagiLoader.show();

         var classId = $classId.val();
         var sectionId = $sectionId.val();

         $.ajax({
            type: 'POST',
            url: "<?php echo SITE_URL ?>admin/exam/find_subject",
            data: {
               'id': classId,
               'section': sectionId
            },
            beforeSend: function(xhr) {
               xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
            },
            success: function(data) {
               AmagiLoader.hide();
               $subjectId.empty();
               $subjectId.append(data);
            },
         });
      }

      $classId.on('change', function() {

         $sectionId.val(null);
         $subjectId.empty();
         findSubjects();
      });

      $sectionId.on('change', function() {
         findSubjects();
      });
   });


   $(document).ready(function() {
      $('#class-id').on('change', function() {
         var id = $('#class-id').val();
         $.ajax({
            type: 'POST',
            url: "<?php echo SITE_URL ?>admin/Classes/find_section",
            data: {
               'classId': id
            },

            success: function(data1) {
               const data2 = JSON.parse(data1); // Convert JSON string to an object
               $('#section-id').empty();
               $('#section-id').append('<option value="">--- Select Section ---</option>');
               data2.forEach(function(section) {
                  $('#section-id').append('<option value="' + section.id + '">' + section.title + '</option>');
               });
            },
         });
      });
   });



   // only for choose input in number at total marks 
   function validateNumber(e) {
      const pattern = /^[0-9]$/;

      return pattern.test(e.key)
   }
</script>
<script>
   $(document).ready(function() {

      var currentYear = new Date().getFullYear() - 1;

      // Initialize the datepicker with the year range from 1995 to the current year
      $("#datepick1").datepicker({
         dateFormat: "dd-mm-yy",
         changeMonth: true,
         changeYear: true,
         yearRange: currentYear + ":" + (currentYear + 5),
         onSelect: function() {}
      });

      var currentYear = new Date().getFullYear() - 1;

      // Initialize the datepicker with the year range from 1995 to the current year
      $("#datepick2").datepicker({
         dateFormat: "dd-mm-yy",
         changeMonth: true,
         changeYear: true,
         yearRange: currentYear + ":" + (currentYear + 5),
         onSelect: function() {}
      });
   });
</script>