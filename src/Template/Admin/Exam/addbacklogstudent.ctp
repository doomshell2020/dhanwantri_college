<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Add Backlog Student
      </h1>
   </section>
   <style>
      #test ul {
         position: absolute;
         z-index: 999;
         overflow: scroll;
         height: 145px;
         top: 100%;
         left: 0px;
         right: 0px;
         list-style-type: none;
         background-color: white;
         padding-left: 0px;
      }

      #test {
         position: relative;
      }

      #test ul li a {
         color: black;
      }
   </style>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <!-- /.box-header -->
               <?php echo $this->Flash->render(); ?>
               <div class="box-body">
                  <div class="manag-stu">
                     <script inline="1">
                        $(document).ready(function() {

                           let student_id = '<?php echo $_SESSION['student_id']; ?>';
                           let accademic_year = '<?php echo $_SESSION['student_accademic']; ?>';
                           let accademicYear = '<?php echo $rolepresentyear; ?>';
                           let studentId = '<?php echo $id; ?>';
                           let requestData;

                           $("#BacklogstudentAddForm").bind("submit", function(event) {
                              AmagiLoader.show();
                              event.preventDefault();
                              var student_id = $('#student_id').val();
                              var accademicYear = $('#acedmicyear').val();

                              $.ajax({
                                 async: true,
                                 data: {
                                    'student_id': student_id,
                                    'accademicYear': accademicYear,
                                 },
                                 dataType: "html",
                                 beforeSend: function(xhr) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                                 },
                                 type: "POST",
                                 url: "<?php echo SITE_URL; ?>admin/exam/addbacklogstudent",
                                 success: function(data) {
                                    console.log(data);
                                    AmagiLoader.hide();
                                    $("#example12").html(data);
                                 },
                                 complete: function() {
                                    AmagiLoader.hide();
                                 },
                              });
                           });
                        });
                     </script>
                     <?php echo $this->Form->create(null, array('url' => array('controller' => 'exam', 'action' => 'addbacklogstudent'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'BacklogstudentAddForm', 'class' => 'form-horizontal')); ?>
                     <div class="form-group">
                        <div class="col-md-6">
                           <label for="inputEmail3" class="control-label">Pupil's Name</label>
                           <input type="hidden" name="student_id" id="student_id" value="id">
                           <input type="hidden" name="accademic_year" id="acedmicyear" value="acedmicyear">
                           <?php echo $this->Form->input('name', array('class' => 'form-control secrh-students stu_name', 'type' => 'text', 'label' => false, 'autofocus', 'autocomplete' => 'off', 'placeholder' => 'Enter Pupils Name', 'required')); ?>
                           <div id="test" style="display:none;">
                              <ul>
                              </ul>
                           </div>
                        </div>
                        <div class="col-sm-3 col-xs-6" style="top: 22px;">
                           <button type="submit" class="btn btn-success delete-button1">Search</button>
                        </div>
                     </div>
                     <?php
                     echo $this->Form->end();
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <!-- /.box-body -->
      </div>
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <i class="fa fa-search" aria-hidden="true"></i>
               <h3 class="box-title"> View Subject</h3>
            </div>
            <!--/.col (left) -->
            <div class="row">
               <div id="example12"> </div>
            </div>
            <!--/.col (right) -->
         </div>
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
<script>
   // function cllbckretail0(id, cid, sid,acedmicyear) {
   function cllbckretail0(id, cid, acedmicyear, classes, section, fname, enroll) {
      $('.secrh-students').val(id);
      $('#acedmicyear').val(acedmicyear);
      $('#student_id').val(cid);
      $('#name').val(id + " (" + classes + "-" + section + ") " + "(" + fname + ")" + " - (" + enroll + ")");
      $('#test').hide();
   }

   $(function() {
      $('.secrh-students').bind('keyup', function() {
         var pos = $(this).val();
         var check = 0;
         $('#test').show();
         $('#student_id').val('');
         var count = pos.length;
         if (count > 0) {
            $.ajax({
               type: 'POST',
               url: '<?php echo ADMIN_URL; ?>studentfees/getstudentname',
               data: {
                  'fetch': pos,
                  'check': check,
               },
               success: function(data) {
                  $('#test ul').html(data);
               },
            });
         } else {
            $('#test').hide();
         }
      });
   });
</script>