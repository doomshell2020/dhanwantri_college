<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>Update Student </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo ADMIN_URL; ?>studentfees/view"><i class="fa fa-home"></i>Home</a></li>
         <li><a href="<?php echo ADMIN_URL; ?>students/index">Manage Student</a></li>
         <li class="active">Update Student</li>
      </ol>
   </section>
   <section class="content xs_clfullw">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-info">
               <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i>
                     <?php if (isset($students['id'])) {


                        echo 'Edit Student';
                     } else {
                        echo 'Add Student';
                     } ?>
                  </h3>
               </div>
               <style>
                  .fieldset {
                     border: solid 1px #000;
                     padding: 10px;
                     display: block;
                     clear: both;
                     margin: 5px 0px;
                  }

                  legend {
                     padding: 0px 10px;
                     background: #3c8dbc;
                     color: #FFF;
                  }
               </style>

               <?php echo $this->Flash->render(); ?>
               <?php echo $this->Form->create($students, array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'validate', 'autocomplete' => 'off')); ?>

               <div class="box-body">
                  <fieldset>
                     <legend><i class="fa fa-child" aria-hidden="true"></i> Academic Information</legend>
                     <div class="form-group d-flex margin_btmcol">
                        <div class="col-sm-8 order-sm-3 col-xs-12">
                           <div class="row">
                              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                 <label for="inputEmail3" class="control-label">Admission. Date<span style="color:red;">*</span></label>
                                 <?php $crdate = date('d-m-Y', strtotime($students['created']));
                                 echo $this->Form->input('created', array('class' => 'form-control', 'required', 'type' => 'text', 'value' => $crdate, 'label' => false, 'id' => 'adminDate')); ?>
                              </div>

                              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                 <label for="inputEmail3" class="control-label">Scholar No<span style="color:red;">*</span></label>
                                 <?php echo
                                 $this->Form->input('enroll', array('class' => 'form-control', 'placeholder' => 'Enrollment No.', 'disabled', 'required', 'type' => 'text', 'label' => false, 'maxlength' => '10')); ?>
                              </div>


                              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                 <label for="inputEmail3" class="control-label">Form No<span style="color:red;">*</span></label>
                                 <?php echo
                                 $this->Form->input('formno', array('class' => 'form-control', 'placeholder' => 'Form No', 'required', 'type' => 'text', 'label' => false)); ?>
                              </div>

                              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                                 <label for="inputEmail3" class="control-label">Organization</label>
                                 <select class="form-control" name="board_id">
                                    <option value="-">Select Admission Class</option>
                                    <?php foreach ($board_names as $key => $value) { ?>
                                       <option value="<? echo $key; ?>" <? if ($students['board_id'] == $key) { ?> selected <? }
                                                                                                                              ?>>
                                          <? echo $value; ?>
                                       </option>
                                    <?php } ?>
                                 </select>
                              </div>

                              <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                                 <label for="inputEmail3" class="control-label">Batch</label>
                                 <select class="form-control" name="board_id">
                                    <option value="-">Select Batch</option>
                                    <?php foreach ($academic_session as $key => $value) { ?>
                                       <option value="<? echo $key; ?>" <? if ($students['board_id'] == $key) { ?> selected <? }
                                                                                                                              ?>>
                                          <? echo $value; ?>
                                       </option>
                                    <?php } ?>
                                 </select>
                              </div>


                              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                 <label for="inputEmail3" class="control-label">Pupil's First Name<span style="color:red;">*</span></label>
                                 <?php echo $this->Form->input('fname', array('class' => 'form-control', 'placeholder' => 'First Name', 'required', 'id' => 'title', 'label' => false)); ?>
                              </div>
                              <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                                 <label for="inputEmail3" class="control-label">Middle Name</label>
                                 <?php echo $this->Form->input('middlename', array('class' => 'form-control', 'placeholder' => 'Middle Name', 'id' => 'title', 'label' => false)); ?>
                              </div>
                           </div>
                        </div>



                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 order-sm-1">
                           <script>
                              $(document).ready(function() {
                                 $("#stuimg").click(function() {
                                    $("input[id='my_file']").click();
                                 });
                              });
                           </script>
                           <div class="edit_proimgdv">
                              <?php
                              if ($students['board_id'] == '1') {
                                 $bordd = "";
                              } elseif ($students['board_id'] == '2') {
                                 $bordd = "CAM";
                              } elseif ($students['board_id'] == '3') {

                                 $bordd = "IB";
                              }


                              if (!empty($students['file'])) { ?>
                                 <img id="stuimg" class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL ?>/webroot/student/<?php echo $students['file']; ?>" />
                                 <div class="edit_proimgdv_infile">
                                    <input type="file" name="file" style="margin-right: 10px;" id="my_file" accept="image/*" />
                                 </div>
                              <?php } else { ?>
                                 <img id="stuimg" class="center-block img-circle img-thumbnail profile-img" src="<?php echo SITE_URL; ?>webroot/uploads/no-images.png" /> <?php echo $students['file']; ?>
                                 <div class="edit_proimgdv_infile">
                                    <input type="file" name="file" style="margin-right: 10px;" onchange="return fileValidation();" id="my_file" accept="image/*" />
                                 </div>
                              <?php } ?>
                           </div>
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
                                       document.getElementById('imagePreview').innerHTML = '<img src="' + e
                                          .target.result + '"/>';
                                    };
                                    reader.readAsDataURL(fileInput.files[0]);
                                 }
                              }
                           }
                        </script>
                     </div>
                     <!--  -->
                     <div class="form-group margin_btmcol">
                        <?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
                        <!--  -->
                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                           <label for="inputEmail3" class="control-label">Last Name</label>
                           <?php echo $this->Form->input('lname', array('class' => 'form-control', 'placeholder' => 'Last Name', 'id' => 'title', 'label' => false)); ?>
                        </div>

                        <input type="hidden" name="oldname" value="<?php echo $students['full_name']; ?>">

                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                           <label for="inputEmail3" class="control-label">Current Course<span style="color:red;">*</span></label>
                           <?php if ($students['category'] == 'RTE') { ?>
                              <?php echo
                              $this->Form->input('class_idsgg', array(
                                 'class' => 'form-control',
                                 'disabled' => 'disabled', 'value' => $students['class_id'], 'options' => $course, 'empty' => 'Select', 'label' => false
                              )); ?>
                              <input type="hidden" name="class_id" value="<? echo $students['class_id']; ?>">
                           <? } else { ?>
                              <?php if ($role_id == 15) { ?>
                                 <?php echo $this->Form->input('class_id', array('class' => 'form-control', 'disabled' => 'disabled', 'id' => 'class-ids', 'value' => $students['class_id'], 'options' => $classes, 'empty' => 'Select', 'label' => false)); ?>
                                 <input type="hidden" name="class_id" value="<?php echo $students['class_id']; ?>">
                              <? } else { ?>
                                 <?php echo $this->Form->input('class_id', array('class' => 'form-control', 'id' => 'class-ids', 'value' => $students['class_id'], 'options' => $course, 'empty' => 'Select', 'label' => false)); ?>
                              <? } ?>
                           <? } ?>
                        </div>


                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                           <label for="inputEmail3" class="control-label">Section<span style="color:red;">*</span></label>
                           <?php if ($role_id == LEAD_COORDINATOR) { ?>
                              <?php echo $this->Form->input('section_id', array('class' => 'form-control', 'disabled' => 'disabled', 'id' => 'section-id', 'value' => $students['section_id'], 'options' => $sections, 'empty' => 'Select', 'required', 'label' => false)); ?>
                              <input type="hidden" name="section_id" value="<?php echo $students['section_id']; ?>">
                           <?  } else { ?>
                              <?php echo $this->Form->input('section_id', array('class' => 'form-control', 'id' => 'section-id', 'value' => $students['section_id'], 'options' => $sections, 'empty' => 'Select', 'required', 'label' => false)); ?>
                           <?  } ?>
                        </div>



                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                           <label for="inputEmail3" class="control-label">Email/Login Id</label>
                           <?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'Email', 'value' => $students['username'], 'id' => 'mcheckmail', 'label' => false)); ?>
                           <span id="dividhere" style="display:none;color:red;">Email Already Exist</span>
                           <span id="ntc" style="color:red; display:none"><?php echo __("Invalid email"); ?></span>
                        </div>



                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                           <label for="inputEmail3" class="control-label">Mobile No<span style="color:red;">*</span></label>
                           <script>
                              $('#mobiled').on('change', function() {
                                 var mobile = $('#mobiled').val();
                                 var e_id = <?php echo $students['id'] ?>;
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
                                                   alert(
                                                      "User Already Exist"
                                                   );
                                                }

                                             },

                                          });
                                       }
                                    },

                                 });
                              });
                           </script>
                           <?php echo $this->Form->input('mobile', array('class' => 'form-control', 'maxlength' => '10', 'minlength' => '10', 'required', 'placeholder' => 'Mobile No.', 'id' => 'mobiled', 'label' => false, 'onkeypress' => 'return isNumber(event);')); ?>
                           <!-- /.input group -->
                        </div>


                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                           <label for="inputEmail3" class="control-label">Aadhar No.</label>
                           <?php echo $this->Form->input('adaharnumber', array('class' => 'form-control', 'maxlength' => '12', 'minlength' => '12', 'placeholder' => 'Aadhar No.', 'type' => 'text', 'label' => false)); ?>
                        </div>


                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6" id="smsmobile" style="display:block;">
                           <label for="inputEmail3" class="control-label">SMS Mobile<span style="color:red;">*</span></label>
                           <input type="text" class="form-control sms_mobiless" <?php if ($role_id == 15) { ?> readonly <? } ?> placeholder="Enter SMS Mobile Number" value="<? echo $students['sms_mobile']; ?>" maxlength="10" minlength="10" required="required" name="sms_mobile" onkeypress="return isNumber(event);">
                        </div>



                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                           <label for="inputEmail3" class="control-label">Date of Birth<span style="color:red;">*</span></label>
                           <div class="input-group">
                              <div class="input-group-addon">
                                 <i class="fa fa-calendar"></i>
                              </div>
                              <?php echo $this->Form->input('dob', array('class' => 'form-control', 'type' => 'text', 'placeholder' => 'Date Of Birth', 'id' => 'datepick1', 'label' => false, 'readonly', 'value' => date('d/m/Y', strtotime($students['dob'])))); ?>
                           </div>
                        </div>

                        <script>
                           $(document).ready(function() {
                              $('#class-ids').on('change', function() {
                                 var id = $('#class-ids').val();
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

                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 col_hdv">
                           <div><label>Student Type</label></div>
                           <label class="radio-inline">
                              <input type="radio" name="category" style="color:green;" id="inlineRadio2" value="Govt" <?php if ($students['category'] == 'Govt') { ?> checked<?php } ?>> Govt.
                           </label>

                           <label class="radio-inline">
                              <input type="radio" name="category" style="color:green;" id="inlineRadio2" value="Management" <?php if ($students['category'] == 'Management') { ?> checked<?php } ?>> Management
                           </label>

                           <div class="col-sm-4 col-xs-6">
                              <label for="inputEmail3" class="control-label">Nationality</label>
                              <select class="form-control" name="nationality" style="width: 100%;">
                                 <option value="INDIAN" <?php if ($students['nationality'] == 'INDIAN') { ?> selected="selected" <?php } ?>>INDIAN</option>
                                 <option value="OTHERS" <?php if ($students['nationality'] == 'OTHERS') { ?> selected="selected" <?php } ?>>OTHERS</option>
                              </select>
                           </div>

                           <div class="col-lg-6 col-md-4 col-sm-4 col-xs-6 col_hdv">
                              <div><label class="control-label">Sms Received By :</label></div>
                              <label class="radio-inline">
                                 <input type="radio" name="feecatss" class="chji" <?php if ($role_id == 15) { ?> disabled="disabled" <? } ?> id="inlinefRadios2" <? if ($students['feecatss'] == 'f_phone') { ?> checked <? } ?> value="f_phone"> Father Mobile No.
                              </label>
                              <label class="radio-inline">
                                 <input type="radio" name="feecatss" class="chji" id="inlinefRadios1" <?php if ($role_id == 15) { ?> disabled="disabled" <? } ?> <? if ($students['feecatss'] == 'm_phone') { ?> checked <? } ?> value="m_phone"> Mother Mobile No.
                              </label>
                              <label class="radio-inline">
                                 <input type="radio" name="feecatss" class="chji" id="inlinefRadios0" <?php if ($role_id == 15) { ?> disabled="disabled" <? } ?> value="Other">
                                 Other Mobile No.
                              </label>
                           </div>



                           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 col_hdv">
                              <div><label for="inputEmail3" class="control-label">Gender</label></div>
                              <label class="radio-inline">
                                 <input type="radio" name="gender" id="inlineRadio1" <?php if ($students['gender'] == 'Male') { ?> checked<?php } ?> value="Male"> Male
                              </label>
                              <label for="inputEmail3" class="radio-inline">
                                 <input type="radio" name="gender" id="inlineRadio2" <?php if ($students['gender'] == 'Female') { ?> checked<?php } ?> value="Female"> Female
                              </label>
                           </div>



                           <!--  -->
                           <!--  -->


                           <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
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
                              <div><label class="control-label">Fees Submitted By :</label></div>
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


                           <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                              <label for="inputEmail3" class="control-label">Fee Submitted By<span style="color:red;">*</span></label>
                              <input type="text" class="form-control fee_submittedbyss" id="feesubmittedby" placeholder="Enter Fee Submitted By" value="<? echo $students['fee_submittedby']; ?>" required="required" name="fee_submittedby">
                           </div>



                           <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                              <label for="inputEmail3" class="control-label">Cast</label>
                              <select class="form-control" name="cast" style="width: 100%;">
                                 <option value="Gen" <?php if ($students['cast'] == 'Gen') { ?> selected="selected" <?php  } ?>>General</option>
                                 <option value="OBC" <?php if ($students['cast'] == 'OBC') { ?> selected="selected" <?php  } ?>>O.B.C.</option>
                                 <option value="SC" <?php if ($students['cast'] == 'SC') { ?> selected="selected" <?php } ?>>S.C.</option>
                                 <option value="ST" <?php if ($students['cast'] == 'ST') { ?> selected="selected" <?php } ?>>S.T.</option>
                                 <option value="MBC" <?php if ($students['cast'] == 'MBC') { ?> selected="selected" <?php } ?>>MBC</option>
                                 <option value="Others" <?php if ($students['cast'] == 'Others') { ?> selected="selected" <?php } ?>>Others</option>
                              </select>
                           </div>




                           <script>
                              function isValidEmailAddress(emailAddress) {
                                 var pattern =
                                    /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                                 return pattern.test(emailAddress);
                              };

                              $(document).ready(function() {
                                 $("#mcheckmail").change(function() {
                                    var txt = $('#mcheckmail').val();
                                    var testCases = [txt];
                                    var test = testCases;
                                    if (isValidEmailAddress(test) != true) {
                                       $('#ntc').css('display', 'block');
                                       $('#mcheckmail').val('');
                                    } else {
                                       $('#ntc').css('display', 'none');
                                    }
                                 });
                              });
                           </script>
                           <script>
                              $('.chji').click(function() {

                                 var hg = $(this).val();
                                 //alert(hg);
                                 if (hg != 'Other') {
                                    var gh = '<? echo $students['
                     id ']; ?>';
                                    var gbh = '<? echo $students['
                     board_id ']; ?>';

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
                           <!-- <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6">
                           <label for="inputEmail3" class="control-label">Previous Board</label>
                           <?php // $arrt = array('CBSE' => 'CBSE', 'RBSE' => 'RBSE', 'ICSE' => 'ICSE');
                           // echo $this->Form->input('previous_board', array('class' => 'form-control', 'placeholder' => 'Previous Board', 'type' => 'select', 'options' => $arrt, 'id' => 'previous_board', 'label' => false)); 
                           ?>
                        </div> -->
                        </div>

                        <!-- <div class="form-group">
                        <div class="col-sm-12">
                           <label for="inputEmail3" class="control-label">Address</label>
                           <?php // echo $this->Form->input('address', array('class' => 'form-control', 'type' => 'text', 'value' => $students['address'], 'label' => false, 'placeholder' => 'Enter Address')); 
                           ?>
                        </div>
                     </div> -->

                  </fieldset>
                  <fieldset>
                     <legend><i class="fa fa-user" aria-hidden="true"></i> Parent Information</legend>
                     <div class="form-group margin_btmcol">

                        <div class="col-sm-3">
                           <label for="inputEmail3" class="control-label">Father Name</label>
                           <?php echo $this->Form->input('fathername', array('class' => 'form-control', 'placeholder' => 'Father Name', 'id' => 'fathername', 'label' => false)); ?>
                        </div>


                        <!-- <div class="col-sm-3">
                           <label for="inputEmail3" class="control-label">Father Qualification</label>
                           <?php // echo $this->Form->input('f_qualification', array('class' => 'form-control', 'placeholder' => 'Father Qualification', 'label' => false)); 
                           ?>
                        </div> -->

                        <div class="col-sm-3">
                           <label for="inputEmail3" class="control-label">Father Mobile No</label>
                           <?php echo $this->Form->input('f_phone', array('class' => 'form-control', 'placeholder' => 'Father Mobile No.', 'label' => false, 'onkeypress' => 'return isNumber(event);')); ?>
                        </div>


                        <div class="col-sm-3">
                           <label for="inputEmail3" class="control-label">Father Occupation</label>
                           <?php echo $this->Form->input('f_occupation', array('class' => 'form-control', 'placeholder' => 'Father Occupation', 'label' => false)); ?>
                        </div>



                        <script>
                           function checkextension() {
                              var file = document.querySelector(".fUpload");
                              if (/\.(jpe?g|png|gif)$/i.test(file.files[0].name) === false) {
                                 alert("not an image please choose a image!");
                                 $('#fUpload').val('');
                              }
                              return false;
                           }
                        </script>

                        <!-- <div class="col-sm-3">
                           <label for="inputEmail3" class="control-label">Father Picture</label>
                           <?php // echo $this->Form->input('father_pic', array('class' => 'form-control', 'type' => 'file', 'id' => 'father_pic', 'label' => false)); 
                           ?>
                           <label for="inputEmail3" class="control-label">Mother Picture</label>
                           <?php // echo $this->Form->input('mother_pic', array('class' => 'form-control', 'type' => 'file', 'id' => 'mother_pic', 'label' => false)); 
                           ?>
                        </div> -->

                        <div class="form-group margin_btmcol">
                           <div class="col-sm-3">
                              <label for="inputEmail3" class="control-label">Mother Name</label>
                              <?php echo $this->Form->input('mothername', array('class' => 'form-control', 'placeholder' => 'Mother Name', 'id' => 'mothername', 'label' => false)); ?>
                           </div>

                           <!-- <div class="col-sm-3">
                              <label for="inputEmail3" class="control-label">Mother Qualification</label>
                              <?php // echo $this->Form->input('m_qualification', array('class' => 'form-control', 'placeholder' => 'Mother Qualification', 'label' => false)); 
                              ?>
                           </div>
                            -->

                           <!-- <div class="col-sm-3">
                              <label for="inputEmail3" class="control-label">Mother Occupation</label>
                              <?php // echo $this->Form->input('m_occupation', array('class' => 'form-control', 'placeholder' => 'Mother Occupation', 'label' => false)); 
                              ?>
                           </div> -->


                           <!-- <div class="col-sm-3">
                              <label for="inputEmail3" class="control-label">Mother Mobile No</label>
                              <?php // echo $this->Form->input('m_phone', array('class' => 'form-control', 'placeholder' => 'Mother Mobile No', 'label' => false,'onkeypress' => 'return isNumber(event);')); 
                              ?>
                           </div> -->

                        </div>
                        <script>
                           $('.chjif').click(function() {
                              var hg = $(this).val();
                              if (hg != 'Other') {
                                 var gh = '<? echo $students['
                     id ']; ?>';
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
                  </fieldset>


                  <!-- <fieldset>
                     <legend><i class="fa fa-user" aria-hidden="true"></i> Guardian Information</legend>
                     <?php if ($guardians) { ?>
                        <div class="form-group margin_btmcol">
                           <div class="col-sm-4">
                              <label for="inputEmail3" class="control-label">GUARDIAN NAME</label>
                              <?php echo $this->Form->input('fullname', array('class' => 'form-control', 'placeholder' => 'GUARDIAN NAME', 'value' => $guardians['fullname'], 'autocomplete' => 'off', 'id' => 'fullname', 'label' => false)); ?>
                           </div>
                           <div class="col-sm-4">
                              <label for="inputEmail3" class="control-label">Mobile No.</label>
                              <?php echo $this->Form->input('mobileno', array('class' => 'form-control', 'placeholder' => 'Mobile No', 'value' => $guardians['mobileno'], 'id' => 'mobileno', 'label' => false, 'onkeypress' => 'return isNumber(event);')); ?>
                           </div>
                           <div class="col-sm-4">
                              <label for="inputEmail3" class="control-label">RELATION</label>
                              <?php echo $this->Form->input('relation', array('class' => 'form-control', 'placeholder' => 'RELATION', 'value' => $guardians['relation'], 'id' => 'relation', 'label' => false)); ?>
                           </div>
                        </div>
                     <?php } else { ?>
                        <div class="form-group margin_btmcol">
                           <div class="col-sm-4">
                              <label for="inputEmail3" class="control-label">GUARDIAN NAME</label>
                              <?php echo $this->Form->input('fullname', array('class' => 'form-control', 'placeholder' => 'GUARDIAN NAME', 'autocomplete' => 'off', 'id' => 'fullname', 'label' => false)); ?>
                           </div>
                           <div class="col-sm-4">
                              <label for="inputEmail3" class="control-label">Mobile No.</label>
                              <?php echo $this->Form->input('mobileno', array('class' => 'form-control', 'placeholder' => 'Mobile No', 'id' => 'mobileno', 'label' => false)); ?>
                           </div>
                           <div class="col-sm-4">
                              <label for="inputEmail3" class="control-label">RELATION</label>
                              <?php echo $this->Form->input('relation', array('class' => 'form-control', 'placeholder' => 'RELATION', 'id' => 'relation', 'label' => false)); ?>
                           </div>
                        </div>
                     <?php } ?>
                  </fieldset> -->


                  <? if (!empty($selected)) {
                     $sel = explode(",", $selected);
                  }
                  if (!empty($select1)) {
                     $opt = explode(",", $select1);
                  } ?>
                  <?php if (
                     $class_id == 12 || $class_id == 13 || $class_id == 15 ||
                     $class_id == 17 || $class_id == 20 || $class_id == 22
                  ) { ?>
                     <h4><i class="fa fa-info-circle" aria-hidden="true"></i>
                        Subject Details</h4>
                     <div class="form-group margin_btmcol">
                        <div class="col-sm-4">
                           <label for="inputEmail3" class="control-label">Compulsory Subject</label>
                           <?php echo $this->Form->input('comp_sid[]', array('class' => 'lko form-control', 'id' => 'comp', 'type' => 'select', 'multiple', 'empty' => 'Select Subject', 'options' => $com, 'value' => $sel, 'label' => false));
                           ?>
                        </div>
                        <script>
                           function myFunction() {
                              var x = document.getElementById("comp").length;
                              var t = x - 1;
                              var y = document.getElementById("opty").length;
                              var k = y - 1;
                              var count = $("#opty[multiple] option:selected").length;
                              var j = t + count;
                              if (j == 5) {
                                 return true;
                              } else {
                                 alert("You can select only 5 subjects.");
                                 return false;
                              }
                           }
                        </script>
                        <div class="col-sm-4">
                           <label for="inputEmail3" class="control-label">Optional Subject</label>
                           <?php echo $this->Form->input('opt_sid[]', array('class' => 'form-control opot', 'multiple', 'type' => 'select', 'empty' => 'Select Subject', 'id' => 'opty', 'options' => $option, 'value' => $opt, 'label' => false)); ?>
                        </div>
                        <!-- ---------------------- For IBDP SubJects.  --------  -->
                     <?php } elseif ($class_id == 25 || $class_id == 29) { ?>
                        <h4><i class="fa fa-info-circle" aria-hidden="true"></i>
                           Subject Details</h4>
                        <div class="form-group margin_btmcol">
                           <div class="col-sm-4">
                              <label for="inputEmail3" class="control-label">Optional Subject</label>
                              <?php echo $this->Form->input('opt_sid[]', array('class' => 'form-control opot', 'multiple', 'type' => 'select', 'empty' => 'Select Subject', 'id' => 'opty', 'options' => $option, 'value' => $opt, 'label' => false)); ?>
                           </div>
                           <!-- ---------------------- For IBDP SubJects.  --------  -->
                        <?php } elseif ($class_id == 11 && $students['section_id'] == 14) { ?>
                           <h4><i class="fa fa-info-circle" aria-hidden="true"></i>
                              Subject Details</h4>
                           <div class="form-group margin_btmcol">
                              <div class="col-sm-4">
                                 <label for="inputEmail3" class="control-label">Optional Subject</label>
                                 <?php echo $this->Form->input('opt_sid[]', array('class' => 'form-control opot', 'multiple', 'type' => 'select', 'empty' => 'Select Subject', 'id' => 'opty', 'options' => $option, 'value' => $opt, 'label' => false)); ?>
                              </div>
                              <!-- ---------------------- For IBDP SubJects.  --------  -->
                           <?php } elseif ($class_id == 26 || $class_id == 27) { ?>
                              <script>
                                 function myFunction() {
                                    var count1 = $(".gp1[multiple] option:selected").length;
                                    var count2 = $(".gp2[multiple] option:selected").length;
                                    var count3 = $(".gp3[multiple] option:selected").length;
                                    var count4 = $(".gp4[multiple] option:selected").length;
                                    var count5 = $(".gp5[multiple] option:selected").length;
                                    var count6 = $(".gp6[multiple] option:selected").length;
                                    var tot = count1 + count2 + count3 + count4 + count5 + count6;
                                    if (tot == '6') {
                                       return true;
                                    }
                                 }
                                 $('.gp3').click(function() {
                                    var jh = $(".gp3[multiple] option:selected").length;
                                    if (jh <= '2') {
                                       return true;
                                    } else {
                                       alert("You can select only 2 subjects from group 3");
                                       $(".gp3 option:selected").removeAttr("selected");
                                    }

                                 });
                                 $('.gp4').click(function() {
                                    var yu = $(".gp4[multiple] option:selected").length;
                                    if (yu <= '2') {
                                       return true;
                                    } else {
                                       alert("You can select only 2 subjects from group 4");
                                       $(".gp4 option:selected").removeAttr("selected");
                                    }
                                 });
                                 $('.kl').click(function() {
                                    var gh = $(".kl[multiple] option:selected").length;

                                    if (gh > '3') {
                                       alert("You can select only 3 subjects from group 3 & 4.");
                                       $('.six').show();
                                       $(".kl option:selected").removeAttr("selected");
                                       return false;
                                    } else if (gh == '3') {
                                       $(".gp6[multiple] option").prop("disabled", "disabled");
                                       $(".gp6 option:selected").removeAttr("selected");
                                       $('.six').hide();
                                    } else {
                                       $(".kl option:selected").attr("selected");
                                       $('.six').show();
                                    }
                                 });
                              </script>
                              <div style="height: 50vh; overflow: auto;">
                                 <div class="form-group margin_btmcol">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Group 1</label>
                                    <div class="col-sm-10">
                                       <?php echo $this->Form->input('comp_sid[]', array('class' => 'gp1 form-control', 'type' => 'select', 'empty' => 'Select Subject', 'options' => $ibsub1, 'value' => '', 'label' => false)); ?>
                                    </div>
                                 </div>
                                 <div class="form-group margin_btmcol">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Group 2</label>
                                    <div class="col-sm-10">
                                       <?php echo $this->Form->input('comp_sid[]', array('class' => 'gp2 form-control', 'type' => 'select', 'empty' => 'Select Subject', 'options' => $ibsub2, 'value' => $sel, 'label' => false)); ?>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Group 3</label>
                                    <div class="col-sm-10">
                                       <?php echo $this->Form->input('comp_sid[]', array('class' => 'gp3 kl form-control', 'type' => 'select', 'multiple', 'options' => $ibsub3, 'value' => $sel, 'id' => 'kl', 'onChange' => 'return findsub();', 'label' => false)); ?>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Group 4</label>
                                    <div class="col-sm-10">
                                       <?php echo $this->Form->input('comp_sid[]', array('class' => 'gp4 kl form-control', 'type' => 'select', 'multiple', 'options' => $ibsub4, 'value' => $sel, 'label' => false)); ?>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Group 5</label>
                                    <div class="col-sm-10">
                                       <?php echo $this->Form->input('comp_sid[]', array('class' => 'gp5 form-control', 'type' => 'select', 'empty' => 'Select Subject', 'options' => $ibsub5, 'value' => $sel, 'label' => false)); ?>
                                    </div>
                                 </div>
                                 <div class="six form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Group 6</label>
                                    <div class="col-sm-10">
                                       <?php echo $this->Form->input('comp_sid[]', array('class' => 'gp6 form-control', 'type' => 'select', 'empty' => 'Select Subject', 'options' => $ibsub6, 'value' => $sel, 'label' => false)); ?>
                                    </div>
                                 </div>
                              </div>
                              <!-- ---------------------- For Class Vatika To 10th  SubJects.  --------  -->
                           </div>
                        </div>
                     <?php } ?>
                     <?php if (isset($selected)) { ?>
                        <script>
                           $('.gp6').click(function() {

                              $(".kl option:selected").removeAttr("selected");
                           });
                        </script>
                     <?php } ?>
                     <div class="form-group">
                        <div class="col-sm-12">
                           <div class="modal-footer">
                              <?php
                              echo $this->Html->link('Close', [
                                 'action' => 'index',

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
   $(function() {
      $("#adminDate").datepicker({
         dateFormat: 'dd-mm-yy',
         orientation: "top",
      });
   });

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