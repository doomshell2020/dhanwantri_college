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
               <?php echo $this->Form->create($subject, array(
                  'class' => 'form-horizontal',
                  'id' => 'sevice_form',
                  'enctype' => 'multipart/form-data',
               )); ?>
               <div class="box-body">
                  <div class="row" style="display:flex; align-items: flex-end; flex-wrap:wrap;">
                     <div class="col-md-6">
                        <label>Course Name<span style="color:red;">*</span></label>
                        <select class="form-control" name="course_id" id="class-id" required="required">
                           <option value="">---Select Course---</option>
                           <?php foreach ($course as $esr => $es) { ?>
                              <option value="<?php echo $esr; ?>"><?php echo $es; ?></option>
                           <?php } ?>
                        </select>
                        <!-- <input type="hidden" name="class_id" id="h1"> -->
                     </div>
                     <div class="col-md-6">
                        <label>Year/Semester<span style="color:red;">*</span></label>
                        <select class="form-control" name="year" id="section-id" required="required">
                           <option value=""> ---Select Section--- </option>
                           <?php foreach ($sections as $esrh => $esh) {
                           ?>
                              <option value="<?php echo $esh['id']; ?>"><?php echo $esh['title']; ?></option>
                           <?php  }
                           ?>
                        </select>
                     </div>

                     <div class="col-sm-12">
                        <div class="table-responsive">
                           <div class="multi-field-wrapperpayment">
                              <div class="table table-bordered" style="padding-bottom: 20px;
                              margin-top: 20px;">
                                 <ul class="tab_foot_btn_add list-unstyled" style="position: absolute;
                                 right: 20px;
                                 top: 50px; z-index: 999">
                                    <li style="text-align:right"><a type="button" class="add-paymentfield pull-right" style="height:34px !important; width:max-content !important; padding:0 20px; display: flex; align-items: center; "><i class="fa fa-plus-circle" style="font-size:15px;color:#3c8dbc"></i> Add More </a></li>
                                 </ul>
                                 <div class="tab_header">
                                    <ul class="tab_hade_menu row list-unstyled " style="padding-top:20px">
                                       <li class="col-sm-4">Subject Name<span style="color:red;">*</span></li>
                                    </ul>
                                 </div>
                                 <div class="payment_container">
                                    <div class="removecurrentworking" style="margin-top: 12px;">
                                       <ul class="payment_details list-unstyled row">
                                          <li class="col-sm-6"><?php echo $this->Form->input('subject', array('class' => 'form-control', 'placeholder' => 'Subject Name', 'id' => '', 'label' => false, 'name' => 'subject[]', 'type' => 'text', 'required')); ?>
                                          </li>
                                          <li class="col-sm-4"><a href="javascript:void(0);" class="delete_paymentcurrent btn remove-field  btn-block" style="height:34px !important; width:max-content !important; padding:0 20px; display: flex; align-items: center;" data-val="<?php echo $current['id'] ?>"><i class="fa fa-minus-circle"></i></a></li>
                                       </ul>
                                    </div>
                                 </div>
                                 <div>
                                 </div>
                              </div>
                           </div>
                        </div>
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
</script>


<script>
   $('.multi-field-wrapperpayment').each(function() {
      lasttr = $(".removecurrentworking:last-child li:first-child");
      var $wrapper = $('.payment_container', this);
      $(".add-paymentfield", $(this)).click(function(e) {
         var currentwork = $('.removecurrentworking:first-child', $wrapper).clone(true).appendTo($wrapper)

         currentwork.find('input').val('').focus();
         currentwork.find('select').val('').focus();
         currentwork.find('textarea').val('').focus();
         currentwork.find('[data-val]').attr("data-val", '');

         ccounter = lasttr.find('.ccounter').attr('id');
         ccounter++
         $lastinput = $(".removecurrentworking:last-child li:nth-last-child(1) .cdate_from");
         $lastinput.attr('id', 'cdate_from' + ccounter);
         $lastinput
            .removeClass('hasDatepicker')
            .removeData('datepicker')
            .unbind()
            .datepicker({
               autoclose: true,
               minViewMode: 1,
               format: 'yyyy-mm'
            });

      });
      $('.remove-field', $wrapper).click(function() {
         if ($('.removecurrentworking', $wrapper).length > 1)
            $(this).closest('.removecurrentworking').remove();
      });
   });
</script>