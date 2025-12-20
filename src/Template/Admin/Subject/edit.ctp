<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Subject Manager
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
               <h3 class="box-title"><?php if (isset($subject['id'])) {
                  echo 'Edit Subject';
                  } else {
                  echo 'Add Subject';
                  } ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php echo $this->Flash->render(); ?>
            <?php echo $this->Form->create($subject, array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'validate', 'autocomplete' => 'off')); ?>
            <div class="box-body">
               <div class="row" style="display:flex; align-items: flex-end; flex-wrap:wrap;">
                  <div class="col-md-6">
                     <label>Course Name<span style="color:red;">*</span></label>
                     <select class="form-control" name="course_id" id="class-id" required="required">
                        <option value="">---Select Course---</option>
                        <?php foreach ($course as $esr => $es) { ?>
                        <option value="<?= $subject['course_id'] ?>" <?= $subject['course_id'] == $es ? 'selected' : '' ?>><?php echo $es; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="col-md-6">
                     <label>Year/Semester<span style="color:red;">*</span></label>
                     <select class="form-control" name="section_id" id="section-id" required="required">
                        <option value=""> ---Select Section--- </option>
                        <?php foreach ($sections as $esrh => $esh) {
                           ?>
                        <option value="<?php echo $esh['id']; ?>"><?php echo $esh['title']; ?></option>
                        <?php  }
                           ?>
                     </select>
                  </div>
                  <div class="col-md-6">
                     <label for="inputEmail3" class="control-label">Batch<span style="color:red;">*</span></label>
                     <select class="form-control" name="academic_session" required="required">
                        <option value="">---Select Batch---</option>
                        <?php foreach ($academic_session as $key => $value) { ?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="col-md-12" style="margin-top:10px;">
                     <div style="display:flex; justify-content:space-between; align-items:center;">
                        <?php
                           echo $this->Html->link('Back', [
                               'action' => 'index'
                           ], ['class' => 'btn btn-default']); ?>
                        <?php
                           if (isset($subject['id'])) {
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