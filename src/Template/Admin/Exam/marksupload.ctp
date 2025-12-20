<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Marks Upload
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
                  echo 'Export Student Excel';
                  } else {
                  echo 'Export Student Excel';
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
                     <select class="form-control" name="year_id" id="section-id" required>
                        <option value=""> ---Select Section--- </option>
                        <?php foreach ($sections as $esrh => $esh) {
                           ?>
                        <option value="<?php echo $esh['id']; ?>"><?php echo $esh['title']; ?></option>
                        <?php  }
                           ?>
                     </select>
                  </div>
                  <div class="col-md-12" style="margin-top:10px;">
                     <div style="display:flex; justify-content:space-between; align-items:center;">
                        <?php
                           echo $this->Html->link('Back', [
                               'action' => 'index'
                           ], ['class' => 'btn btn-default']); ?>
                        <?php
                           echo $this->Form->submit(
                               'Submit',
                               array('class' => 'btn btn-info pull-right', 'title' => 'Submit')
                           );
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
   // course change after show in related section title
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