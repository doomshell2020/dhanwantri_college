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
            <?php echo $this->Form->create($exam, array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'validate', 'autocomplete' => 'off')); ?>
            <div class="box-body">
               <div class="row" style="display:flex; align-items: flex-end; flex-wrap:wrap;">
                  <div class="col-md-6">
                     <label>Exam Name<span style="color:red;">*</span></label>
                     <?php echo $this->Form->input('exam_name', array('class' => 'form-control', 'required' => "required",  'placeholder' => 'Exam Name', 'label' => false, 'value' => $exam['exam_name'])); ?>
                  </div>
                  <div class="col-md-6">
                     <label>Course Name<span style="color:red;">*</span></label>
                     <select class="form-control" name="course_id" id="class-id" required="required" disabled>
                        <option value="">---Select Course---</option>
                        <?php foreach ($course as $esr => $es) {
                           ?>
                        <option value="<?= $esr ?>" <?= $exam['course_id'] == $esr ? 'selected' : '' ?>><?php echo $es; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="col-md-6">
                     <label>Year/Semester<span style="color:red;">*</span></label>
                     <select class="form-control" name="year_id" id="section-id" required="required" disabled>
                        <option value=""> ---Select Section--- </option>
                        <?php foreach ($sections as $esrh => $esh) {
                           ?>
                        <option value="<?= $esh['id'] ?>" <?= $exam['year_id'] == $esh['id'] ? 'selected' : '' ?>><?php echo $esh['title']; ?></option>
                        <?php  }
                           ?>
                     </select>
                  </div>
                  <div class="col-md-6">
                     <label>Exam Date<span style="color:red;">*</span></label>
                     <input type="text" name="exam_date" placeholder="DD-MM-YYYY" required id="datepick1" class="form-control" value="<?= date('d-m-Y', strtotime($exam['exam_date'])) ?>">
                  </div>
                  <div class="col-md-6">
                     <label>Exam Result Date</span></label>
                     <input type="text" name="result_date" placeholder="DD-MM-YYYY" id="datepick2" class="form-control" value="<?= !empty($exam['result_date']) ? date('d-m-Y', strtotime($exam['result_date'])) : '' ?>">
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
<script>
   // course change after show in relate section title 
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
</script>
<script>
   $(document).ready(function() {
   
       var currentYear = new Date().getFullYear();
   
       // Initialize the datepicker with the year range from 1995 to the current year
       $("#datepick1").datepicker({
           dateFormat: "d-m-yy",
           changeMonth: true,
           changeYear: true,
           yearRange: currentYear + ":" + (currentYear + 5),
           onSelect: function() {}
       });
   
       var currentYear = new Date().getFullYear();
   
       // Initialize the datepicker with the year range from 1995 to the current year
       $("#datepick2").datepicker({
           dateFormat: "d-m-yy",
           changeMonth: true,
           changeYear: true,
           yearRange: currentYear + ":" + (currentYear + 5),
           onSelect: function() {}
       });
   });
</script>