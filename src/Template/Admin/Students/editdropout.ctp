<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <b>Drop Out Student Manager</b>
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>studentfees/drop"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>students/drop">Manage Drop Out Student</a></li>
         <li class="active">EDIT Student</li>
      </ol>
   </section>
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-info">
               <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> <?php if (isset($students['id'])) {
                                                                                                echo 'View Drop Out Student';
                                                                                             } else {
                                                                                                echo 'Add Student';
                                                                                             } ?> For Session <? echo $acedmicyearfi; ?></h3>
               </div>
               <?php echo $this->Flash->render(); ?>
               <?php echo $this->Form->create($students, array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'validate')); ?>
               <div class="box-body">
                  <div class="form-group">
                     <div class="col-sm-3">
                     </div>
                     <label for="inputEmail3" class="col-sm-5 control-label">
                        <h2 style="font-size:22px;margin-bottom: 15px;"><b>Academic Details</b></h2>
                     </label>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Scholar No<span style="color:red;">*</span></label>
                        <?php echo
                        $this->Form->input('enroll', array('class' => 'form-control', 'placeholder' => 'Enrollment No.', 'disabled', 'required', 'type' => 'text', 'label' => false, 'maxlength' => '10')); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Date of Admission<span style="color:red;">*</span></label>
                        <div class="input-group">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                           <?php echo $this->Form->input('dob', array('class' => 'form-control ', 'disabled', 'type' => 'text', 'placeholder' => 'Date Of Birth', 'id' => 'datepick1', 'label' => false, 'value' => date('d/m/Y', strtotime($students['admissiondate'])))); ?>
                        </div>
                     </div>
                     <div class="col-sm-2">
                        <div><label for="inputEmail3" class="control-label">Gender</label></div>
                        <label class="radio-inline">
                           <input type="radio" name="gender" id="inlineRadio1" <?php if ($students['gender'] == 'Male') { ?> checked<?php } ?> value="Male"> Male
                        </label>
                        <label for="inputEmail3" class="radio-inline">
                           <input type="radio" name="gender" id="inlineRadio2" <?php if ($students['gender'] == 'Female') { ?> checked<?php } ?> value="Female"> Female
                        </label>
                     </div>
                     <script>
                        $(document).ready(function() {
                           $('#datepickdob').datepicker({
                              dateFormat: 'yy-mm-dd',
                              "changeMonth": true,
                              minDate: '-20Y',
                              maxDate: '-2Y',
                              "changeYear": true,
                              "autoSize": true
                           }).on('change', function() {


                              today = new Date();
                              tenYearBefore = new Date().setYear(new Date().getFullYear() - 3);
                              selected = new Date($('#datepickdob').val());

                           });
                        });
                     </script>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Date of Birth<span style="color:red;">*</span></label>
                        <div class="input-group">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                           <?php echo $this->Form->input('dob', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Date Of Birth', 'id' => 'datepickdob', 'label' => false,'readonly','value' => date('Y-m-d', strtotime($students['dob'])))); ?>
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <script>
                           $(document).ready(function() {
                              $("#stuimg").click(function() {
                                 $("input[id='my_file']").click();
                              });
                           });
                        </script>
                        <?php
                        if ($students['board_id'] == CBSE) {
                           $bordd = "";
                        } else if ($students['board_id'] == CAMBRIDGE) {
                           $bordd = "CAM";
                        } else if ($students['board_id'] == IB) {

                           $bordd = "IB";
                        }
                        $db = $this->request->session()->read('Auth.User.db');
                        if ($students['file']) { ?>
                           <img id="stuimg" class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL; ?><?php echo $db . '_image'; ?>/student/<?php echo $students['file'] ?>" style="cursor:pointer;position: absolute;right: 84px;" />
                           <input type="file" name="file" id="my_file" accept="image/*" />
                        <?php } else { ?>
                           <img id="stuimg" class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL; ?>webroot/uploads/no-images.png" style="cursor:pointer;position: absolute;right: 84px;" />
                           <input type="file" name="file" onchange="return fileValidation();" id="my_file" accept="image/*"/>
                        <?php } ?>
                     </div>
                     <script>
                        function fileValidation() {
                           var fileInput = document.getElementById('my_file');
                           var filePath = fileInput.value;
                           var allowedExtensions = /(\.jpg|\.jpeg)$/i;
                           if (!allowedExtensions.exec(filePath)) {
                              alert('Please upload file having extensions .jpeg/.jpg only.');
                              fileInput.value = '';
                              return false;
                           } else {
                              //Image preview
                              if (fileInput.files && fileInput.files[0]) {
                                 var reader = new FileReader();
                                 reader.onload = function(e) {
                                    document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '"/>';
                                 };
                                 reader.readAsDataURL(fileInput.files[0]);
                              }
                           }
                        }
                     </script>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Pupil's First Name<span style="color:red;">*</span></label>
                        <?php echo $this->Form->input('fname', array('class' => 'form-control', 'placeholder' => 'First Name', 'required', 'id' => 'title', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Middle Name</label>
                        <?php echo $this->Form->input('middlename', array('class' => 'form-control', 'placeholder' => 'Middle Name', 'id' => 'title', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Last Name</label>
                        <?php echo $this->Form->input('lname', array('class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'title', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label>First Admission Class<span>
                              <font color="red"> *</font>
                           </span></label>
                        <select name="admissionclass" disabled="disabled" class="form-control" required="required">
                           <option value="-">Select Admission Class</option>
                           <?php foreach ($admissionclass as $jhj => $rdt) { ?>
                              <option value="<? echo $jhj; ?>" <? if ($students['admissionclass'] == $jhj) { ?> selected <? } ?>><? echo $rdt; ?></option>
                           <? } ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Cast</label>
                        <select class="form-control" name="cast" style="width: 100%;">
                           <option value="GEN" <?php if ($students['cast'] == 'GEN') { ?> selected="selected" <?php } ?>>General</option>
                           <option value="OBC" <?php if ($students['cast'] == 'OBC') { ?> selected="selected" <?php } ?>>OBC</option>
                           <option value="SC" <?php if ($students['cast'] == 'SC') { ?> selected="selected" <?php } ?>>SC</option>
                           <option value="ST" <?php if ($students['cast'] == 'ST') { ?> selected="selected" <?php } ?>>ST</option>
                           <option value="Others" <?php if ($students['cast'] == 'Others') { ?> selected="selected" <?php } ?>>Others</option>
                        </select>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Current Class<span style="color:red;">*</span></label>
                        <?php if ($students['category'] == 'RTE') { ?>
                           <?php echo
                           $this->Form->input('class_id', array(
                              'class' => 'form-control',
                              'readonly' => 'readonly', 'value' => $students['class_id'], 'disabled', 'options' => $classes, 'empty' => 'Select', 'label' => false
                           )); ?>
                        <? } else { ?>
                           <?php echo $this->Form->input('class_id', array('class' => 'form-control', 'disabled', 'id' => 'class-ids', 'value' => $students['class_id'], 'options' => $classes, 'empty' => 'Select', 'label' => false)); ?>
                        <? } ?>
                     </div>
                     <script>
                        $(document).ready(function() {
                           $('#class-ids').on('change', function() {
                              var id = $('#class-ids').val();
                              //alert(id);
                              $.ajax({
                                 type: 'POST',
                                 url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/find_section',
                                 data: {
                                    'id': id
                                 },
                                 success: function(data) {
                                    $('#section-id').empty();
                                    $('#section-id').html(data);
                                 },

                              });
                           });
                        });
                     </script>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Section<span style="color:red;">*</span></label>
                        <?php echo $this->Form->input('section_id', array('class' => 'form-control', 'disabled', 'id' => 'section-id', 'value' => $students['section_id'], 'options' => $sections, 'empty' => 'Select', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">House<span style="color:red;">*</span></label>
                        <?php echo $this->Form->input('h_id', array('class' => 'form-control', 'disabled', 'id' => '', 'value' => $students['h_id'], 'options' => $houses, 'empty' => 'Select', 'label' => false)); ?>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-4">
                        <div><label>Admission Category</label></div>
                        <label class="radio-inline">
                           <input type="radio" name="category" disabled="disabled" id="inlineRadio2" value="NORMAL" <?php if ($students['category'] == 'NORMAL') { ?> checked<?php } ?>> NORMAL
                        </label>
                        <label class="radio-inline">
                           <input type="radio" name="category" disabled="disabled" id="inlineRadio1" value="RTE" <?php if ($students['category'] == 'RTE') { ?> checked<?php } ?>> RTE
                        </label>
                        <label class="radio-inline">
                           <input type="radio" name="category" disabled="disabled" id="inlineRadio3" value="Migration" <?php if ($students['category'] == 'Migration') { ?> checked<?php } ?>>
                           MIGRATED
                        </label>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Discount category</label>
                        <?php echo
                        $this->Form->input('discountcategory', array('class' => 'form-control', 'disabled', 'placeholder' => 'discountcategory', 'type' => 'select', 'id' => 'discountcategory', 'empty' => 'No Discount', 'options' => $discountCategorylist, 'label' => false)); ?>
                     </div>
                     <div class="col-sm-4">
                        <label for="inputEmail3" class="control-label">Is Disability</label>
                        <?php echo $this->Form->input('disability', array('class' => 'form-control', 'placeholder' => 'Disability', 'type' => 'select', 'id' => 'disability', 'empty' => 'Select', 'options' => $disabilityslist, 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Bloodgroup</label>
                        <select class="form-control" name="bloodgroup" style="width: 100%;">
                           <option value="">--Select--</option>
                           <option value="A" <?php if ($students['bloodgroup'] == 'A') { ?> selected="selected" <?php } ?>>A</option>
                           <option value="B" <?php if ($students['bloodgroup'] == 'B') { ?> selected="selected" <?php } ?>>B</option>
                           <option value="O" <?php if ($students['bloodgroup'] == 'O') { ?> selected="selected" <?php } ?>>O</option>
                           <option value="AB" <?php if ($students['bloodgroup'] == 'AB') { ?> selected="selected" <?php } ?>>AB</option>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Height</label>
                        <?php echo $this->Form->input('height', array('class' => 'form-control', 'placeholder' => 'Height in feet', 'type' => 'text', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Weight</label>
                        <?php echo $this->Form->input('weight', array('class' => 'form-control', 'placeholder' => 'Weight in KG', 'type' => 'text', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Is Special </label>
                        <?php $selectspecial = array('Y' => 'Y', 'N' => 'N');
                        echo
                        $this->Form->input('is_special', array('class' => 'form-control', 'placeholder' => 'lc', 'type' => 'select', 'required', 'empty' => 'Select', 'options' => $selectspecial, 'value' => $students['is_special'], 'id' => 'lc', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Is Learning Centre</label>
                        <?php $selectleraning = array('Y' => 'Y', 'N' => 'N');
                        echo
                        $this->Form->input('is_lc', array('class' => 'form-control', 'placeholder' => 'lc', 'type' => 'select', 'required', 'empty' => 'Select', 'options' => $selectleraning, 'value' => $students['is_lc'], 'id' => 'lc', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Aadhar No.</label>
                        <?php echo $this->Form->input('adaharnumber', array('class' => 'form-control', 'maxlength' => '12', 'minlength' => '12', 'placeholder' => 'Aadhar No.', 'type' => 'text', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Religion<span style="color:red;">*</span></label>
                        <select class="form-control" name="religion" style="width: 100%;" required="required">
                           <option value="Hindu" <?php if ($students['religion'] == 'Hindu') { ?> selected="selected" <?php } ?>>Hindu</option>
                           <option value="Muslim" <?php if ($students['religion'] == 'Muslim') { ?> selected="selected" <?php } ?>>Muslim</option>
                           <option value="Sikh" <?php if ($students['religion'] == 'Sikh') { ?> selected="selected" <?php } ?>>Sikh</option>
                           <option value="Christian" <?php if ($students['religion'] == 'Christian') { ?> selected="selected" <?php } ?>>Christian</option>
                           <option value="Jain" <?php if ($students['religion'] == 'Jain') { ?> selected="selected" <?php } ?>>Jain</option>
                           <option value="Buddhist" <?php if ($students['religion'] == 'Buddhist') { ?> selected="selected" <?php } ?>>Buddhist</option>
                           <option value="Parsi" <?php if ($students['religion'] == 'Parsi') { ?> selected="selected" <?php } ?>>Parsi</option>
                           <option value="Others" <?php if ($students['religion'] == 'Others') { ?> selected="selected" <?php } ?>>Others</option>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-4">
                        <label for="inputEmail3" class="control-label">Mobile No<span style="color:red;">*</span></label>
                        <script>
                           $('#mobiled').on('change', function() {
                              var mobile = $('#mobiled').val();
                              var e_id = <? echo $students['id'] ?>;
                              $.ajax({
                                 type: 'POST',
                                 url: '<?php echo ADMIN_URL; ?>students/edit_dup_mobile',
                                 data: {
                                    'mobile': mobile,
                                    'e_id': e_id
                                 },
                                 success: function(data) {
                                    if (data == 1) {
                                       $('#mobiled').html(data);
                                    } else {
                                       $.ajax({
                                          type: 'POST',
                                          url: '<?php echo ADMIN_URL; ?>students/dup_mobile',
                                          data: {
                                             'mobile': mobile
                                          },
                                          success: function(data) {
                                             if (data > 0) {
                                                $('#mobiled').val('');
                                                alert("User Already Exist");
                                             }

                                          },

                                       });
                                    }
                                 },

                              });
                           });
                        </script>
                        <?php echo $this->Form->input('mobile', array('class' => 'form-control', 'maxlength' => '10', 'minlength' => '10', 'required', 'placeholder' => 'Mobile No.', 'id' => 'mobiled', 'label' => false,'onkeypress' => 'return isNumber(event);')); ?>
                        <!-- /.input group -->
                     </div>
                     <div class="col-sm-5">
                        <div><label>Sms Received By :</label></div>
                        <label class="radio-inline">
                           <input type="radio" name="feecatss" class="chji" id="inlinefRadios2" value="f_phone"> Father Mobile No.
                        </label>
                        <label class="radio-inline">
                           <input type="radio" name="feecatss" class="chji" id="inlinefRadios1" value="m_phone"> Mother Mobile No.
                        </label>
                        <label class="radio-inline">
                           <input type="radio" name="feecatss" class="chji" id="inlinefRadios0" value="Other"> Other Mobile No.
                        </label>
                     </div>
                     <div class="col-sm-3" id="smsmobile" style="display:block;">
                        <label for="inputEmail3" class="control-label">SMS Mobile<span style="color:red;">*</span></label>
                        <input type="text" class="form-control sms_mobiless" placeholder="Enter SMS Mobile Number" value="<? echo $students['sms_mobile']; ?>" maxlength="10" minlength="10" required="required" name="sms_mobile" onkeypress = "return isNumber(event);">
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-4">
                        <script language="javascript" type="text/javascript">
                           $(document).ready(function(e) {
                              $("#inlinefRadio0").click(function() {
                                 if ($(this).val() == 'Other') {
                                    $("#feesubmittedby").val('');
                                 }
                              });
                              $("#inlinefRadio1").click(function() {
                                 if ($(this).val() == 'Mother') {
                                    var mothername = $("#mothername").val();
                                    $("#feesubmittedby").val(mothername);
                                 }
                              });
                              $("#inlinefRadio2").click(function() {
                                 if ($(this).val() == 'Father') {
                                    var fathernaem = $("#fathername").val();
                                    $("#feesubmittedby").val(fathernaem);
                                 }
                              });
                           });
                        </script>
                        <div><label>Fees Submitted By :</label></div>
                        <label class="radio-inline">
                           <input type="radio" name="feecat" id="inlinefRadio2" <? if ($students['fee_submittedby'] == $students['fathername']) { ?>checked <? } ?> value="Father"> Father
                        </label>
                        <label class="radio-inline">
                           <input type="radio" name="feecat" id="inlinefRadio1" <? if ($students['fee_submittedby'] == $students['mothername']) { ?>checked <? } ?> value="Mother"> Mother
                        </label>
                        <label class="radio-inline">
                           <input type="radio" name="feecat" id="inlinefRadio0" value="Other"> Other
                        </label>
                     </div>
                     <div class="col-sm-4">
                        <label for="inputEmail3" class="control-label">Fee Submitted By<span style="color:red;">*</span></label>
                        <input type="text" class="form-control fee_submittedbyss" id="feesubmittedby" placeholder="Enter Fee Submitted By" value="<? echo $students['fee_submittedby']; ?>" required="required" name="fee_submittedby">
                     </div>
                     <script>
                        $('.chji').click(function() {
                           var hg = $(this).val();
                           //alert(hg);
                           if (hg != 'Other') {
                              var gh = '<? echo $students['id']; ?>';
                              var gbh = '<? echo $students['board_id']; ?>';
                              $.ajax({
                                 type: 'POST',
                                 url: '<?php echo ADMIN_URL; ?>Students/findphonenos',
                                 data: {
                                    'id': gh,
                                    'bid': gbh,
                                    'fieln': hg
                                 },
                                 success: function(data) {
                                    //alert(data);
                                    if (data != '0') {
                                       $('.sms_mobiless').val(data);
                                    }
                                 },
                              });
                           } else {
                              $('.sms_mobiless').val('');
                           }
                        });
                     </script>
                  </div>
                  <br>
                  <div class="form-group">
                     <div class="col-sm-3">
                     </div>
                     <label for="inputEmail3" class="col-sm-5 control-label">
                        <h2 style="font-size:22px; margin-bottom: 15px;"><b>Father's Information</b></h2>
                     </label>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-3">
                        <label for="inputEmail3" class="control-label">Father Name</label>
                        <?php echo $this->Form->input('fathername', array('class' => 'form-control', 'placeholder' => 'Father Name', 'id' => 'fathername', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-3">
                        <label for="inputEmail3" class="control-label">Father Qualification</label>
                        <?php echo $this->Form->input('f_qualification', array('class' => 'form-control', 'placeholder' => 'Father Qualification', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-3">
                        <label for="inputEmail3" class="control-label">Father Occupation</label>
                        <?php echo $this->Form->input('f_occupation', array('class' => 'form-control', 'placeholder' => 'Father Occupation', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Father Mobile No</label>
                        <?php echo $this->Form->input('f_phone', array('class' => 'form-control', 'placeholder' => 'Father Mobile No.', 'label' => false,'maxlength' => '10', 'minlength' => '10','onkeypress' => 'return isNumber(event);')); ?>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-3">
                     </div>
                     <label for="inputEmail3" class="col-sm-5 control-label">
                        <h2 style="font-size:22px; margin-bottom: 15px;"><b>Mother's Information</b></h2>
                     </label>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-3">
                        <label for="inputEmail3" class="control-label">Mother Name</label>
                        <?php echo $this->Form->input('mothername', array('class' => 'form-control', 'placeholder' => 'Mother Name', 'id' => 'mothername', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-3">
                        <label for="inputEmail3" class="control-label">Mother Qualification</label>
                        <?php echo $this->Form->input('m_qualification', array('class' => 'form-control', 'placeholder' => 'Mother Qualification', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-3">
                        <label for="inputEmail3" class="control-label">Mother Occupation</label>
                        <?php echo $this->Form->input('m_occupation', array('class' => 'form-control', 'placeholder' => 'Mother Occupation', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-2">
                        <label for="inputEmail3" class="control-label">Mother Mobile No</label>
                        <?php echo $this->Form->input('m_phone', array('class' => 'form-control', 'placeholder' => 'Mother Mobile No', 'label' => false,'maxlength' => '10', 'minlength' => '10','onkeypress' => 'return isNumber(event);')); ?>
                     </div>
                  </div>
                  <script>
                     $('.chjif').click(function() {
                        var hg = $(this).val();
                        if (hg != 'Other') {
                           var gh = '<? echo $students['id']; ?>';
                           $.ajax({
                              type: 'POST',
                              url: '<?php echo ADMIN_URL; ?>Students/findfeesubmittedby',
                              data: {
                                 'id': gh,
                                 'fieln': hg
                              },
                              success: function(data) {
                                 if (data != '0') {
                                    $('.fee_submittedbyss').val(data);
                                 }
                              },
                           });
                        } else {
                           $('.fee_submittedbyss').val('');
                        }
                     });
                  </script>
                  <h4><i class="fa fa-info-circle" aria-hidden="true"></i>
                     Address Info
                  </h4>
                  <div class="form-group">
                     <div class="col-sm-12">
                        <?php echo $this->Form->input('address', array('class' => 'form-control', 'type' => 'text', 'value' => $students['address'], 'label' => false, 'placeholder' => 'Enter Address')); ?>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12">
                        <div class="modal-footer">
                           <?php
                           echo $this->Html->link('Close', [
                              'action' => 'index'

                           ], ['class' => 'btn btn-info pull-left']); ?>
                           <?php
                           if (isset($students['id'])) {
                              echo $this->Form->submit(
                                 'Update',
                                 array('class' => 'btn btn-info pull-right', 'title' => 'Update')
                              );
                           } else {
                              echo $this->Form->submit(
                                 'Save',
                                 array('class' => 'btn btn-info pull-right', 'title' => 'Save')
                              );
                           }
                           ?>
                        </div>
                        <!-- /.box-footer -->
                     </div>
                  </div>
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

   function isNumber(evt) {
          evt = (evt) ? evt : window.event;
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {
      
              alert("Please Enter Numeric Value");
              return false;
          }
          return true;
      }

</script>
