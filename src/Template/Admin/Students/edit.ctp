<style type="text/css">
   ul#myUL {
      padding-left: 0px;
      background-color: #fefe;
      position: absolute;
      left: 0px;
      right: 0px;
      top: 100%;
      z-index: 999;
      height: 100px;
      overflow: scroll;
   }

   ul#myUL li {
      list-style: none;
   }

   ul#myUL li a {
      display: block;
      padding: 5px 12px;
   }

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

   #load2 {
      width: 100%;
      height: 100%;
      position: fixed;
      z-index: 9999;
      background-color: white !important;
      background: url("https://www.idsprime.com/images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
   }
</style>

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

   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box box-info">
               <div class="box-header with-border">

               </div>
               <?php echo $this->Flash->render(); ?>
               <?php
               // pr($students);exit;
               echo $this->Form->create($students, array(
                  'class' => 'form-horizontal',
                  'id' => 'student_form',
                  'enctype' => 'multipart/form-data',
                  'validate', 'autocomplete' => 'off',
               )); ?>
               <div class="box-body">
                  <div class="form-group add_stundaddmi">
                     <div class="col-sm-9">
                        <div class="row">
                           <div class="col-md-12" style="margin-bottom:15px;">
                              <div><label>Student Type</label></div>
                              <label class="radio-inline">
                                 <input type="radio" name="mode" id="inlineRadio2" value="Govt" <?php echo ($students['mode'] == 'Govt') ? 'checked' : ''; ?>> GOVT.
                              </label>
                              <label class="radio-inline">
                                 <input type="radio" name="mode" id="inlineRadio2" <?php echo ($students['mode'] == 'Management') ? 'checked' : ''; ?> value="Management"> MANAGEMENT
                              </label>


                              <label class="radio-inline">
                                 <input type="radio" name="mode" id="inlineRadio2" <?php echo ($students['mode'] == 'Federation' || $students['mode'] == 'Direct') ? 'checked' : ''; ?> value="Federation"> FEDERATION
                              </label>
                              <!-- <label class="radio-inline">
                                            <input type="radio" name="category" id="inlineRadio3" value="Migration"> MIGRATION
                                        </label> -->
                           </div>


                           <?php $form_no  =  explode("_", $userDb); ?>

                           <?php if ($enroll_without_fees == 0) { ?>
                              <div class="col-md-4" id="srnosss">
                                 <label for="inputEmail3" class="control-label">Scholar No.</label>
                                 <?php if (isset($students['id'])) { ?>
                                    <?php echo $this->Form->input('enroll', array('class' => 'form-control', 'placeholder' => 'Enrollnment', 'id' => 'enroll', 'type' => 'text', 'disabled' => true, 'label' => false)); ?>
                                 <?php } else { ?>
                                 <?php $number = trim($studentsid['enroll']);
                                    $addst = $number + 1;
                                    echo $this->Form->input('enroll', array('class' => 'form-control', 'placeholder' => 'Enrollnment', 'readonly', 'type' => 'text', 'id' => 'enroll', 'value' => $addst, 'label' => false));
                                 }  ?>
                              </div>
                           <?php } else { ?>
                              <div class="col-md-4" id="srnosss2" style="display:none;">
                                 <label for="inputEmail3" class="control-label">Serial No.</label>
                                 <?php if (isset($students['id'])) { ?>
                                    <?php echo $this->Form->input('enrolls', array('class' => 'form-control', 'placeholder' => 'Enrollnment', 'id' => 'enroll', 'label' => false)); ?>
                                 <?php } else { ?>
                                 <?php $numberdd = trim($studentsid23['enroll']);
                                    $addstd = $numberdd + 1;
                                    echo $this->Form->input('enrolls', array('class' => 'form-control', 'placeholder' => 'Enrollnment', 'id' => 'enroll', 'value' => $addstd, 'label' => false, 'readonly'));
                                 } ?>
                              </div>
                           <?php } ?>


                           <div class="col-md-4">
                              <label for="inputEmail3" class="control-label">Batch<span style="color:red;">*</span></label>
                              <?php
                              echo $this->Form->select(
                                 'batch',
                                 $academic_session,
                                 [
                                    'class' => 'form-control',
                                    'placeholder' => 'Select Batch',
                                    'required' => true,
                                    'disabled' => true
                                 ]
                              );
                              ?>

                           </div>

                           <div class="col-md-4">
                              <label for="inputEmail3" class="control-label">Roll Number.</label>
                              <?php echo $this->Form->input('roll_no', array('class' => 'form-control', 'placeholder' => 'Roll Number', 'type' => 'text', 'label' => false)); ?>

                           </div>

                           <div class="col-md-4" id="frno">
                              <label for="inputEmail3" class="control-label">Enrolment Number.</label>
                              <?php echo $this->Form->input('enrolment_no', array('class' => 'form-control secrh-loc autoformnumber', 'value' => $fromnos, 'placeholder' => 'Enrolment Number.', 'autocomplete' => 'off', 'id' => 'frnofield', 'type' => 'text', 'label' => false)); ?>
                              <span id="spinner" style="color:red;"></span>
                           </div>


                           <div class="col-md-4" id="frno">
                              <label for="inputEmail3" class="control-label">RUHS/RNC/RPMC Enrolment</label>
                              <?php echo $this->Form->input('ruhs_rnc_rpmc_enroll', array('class' => 'form-control', 'placeholder' => 'RUHS/RNC/RPMC Enrolment.', 'autocomplete' => 'off', 'id' => 'frnofield', 'type' => 'text', 'label' => false)); ?>
                              <span id="spinner" style="color:red;"></span>
                           </div>


                        </div>
                     </div>

                     <style>
                        #dvPreview {
                           filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=image);
                           text-align: center;
                        }
                     </style>
                     <div class="col-sm-3 " style="position: relative;">
                        <div id="dvPreview">
                           <?php
                           if ($students['file']) {
                              $studentimg = SITE_URL . "student/" . $students['file'];
                           } else {
                              $studentimg = SITE_URL . "uploads/no-images.png";
                           }
                           ?>
                           <img class="center-block img-circle img-thumbnail profile-img" src="<?php echo $studentimg; ?>" id="my_img">

                        </div>
                        <div class="photo-edit-admin1">
                           <a id="lo" class="photo-edit-icon-admin1" href="#" title="Edit Profile Picture"><i class="fa fa-pencil"></i></a>
                        </div>
                        <input type="hidden" name="filesss1" id="img">
                     </div>

                     <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

                     <script language="javascript" type="text/javascript">
                        $(function() {
                           $("#pic1").change(function() {
                              $("#dvPreview").html("");
                              var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                              if (regex.test($(this).val().toLowerCase())) {
                                 if ($.browser.msie && parseFloat(jQuery.browser.version) <=
                                    9.0) {
                                    $("#dvPreview").show();
                                    $("#dvPreview")[0].filters.item(
                                          "DXImageTransform.Microsoft.AlphaImageLoader").src =
                                       $(this).val();
                                 } else {
                                    if (typeof(FileReader) != "undefined") {
                                       $("#dvPreview").show();
                                       $("#dvPreview").append(
                                          "<img  height='50%' width='50%'/>");
                                       var reader = new FileReader();
                                       reader.onload = function(e) {
                                          $("#dvPreview img").attr("src", e.target
                                             .result);
                                       }
                                       reader.readAsDataURL($(this)[0].files[0]);
                                    } else {
                                       alert("This browser does not support FileReader.");
                                    }
                                 }
                              } else {
                                 alert("Please upload a valid image file.");
                              }
                           });
                        });
                     </script>

                     <script type="text/javascript">
                        $(document).ready(function(e) {
                           $("#lo").click(function() {
                              $("#pic1").trigger('click');
                           });
                        });
                     </script>

                  </div>
                  <div class="form-group">

                     <div id="load2" style="display: none;"></div>

                     <div class="col-sm-4 col-xs-6" id="classmigrateoff">
                        <label for="inputEmail3" class="control-label">Course<span style="color:red;">*</span></label>

                        <?php
                        echo $this->Form->select(
                           'class_id',
                           $course,
                           [
                              'class' => 'form-control',
                              'placeholder' => 'Select Course',
                              'disabled' => true,
                              'id' => 'class-id',
                              'required' => true
                           ]
                        );
                        ?>

                        <!-- <input type="hidden" name="class_id" id="h1"> -->
                     </div>

                     <div class="col-sm-4 col-xs-6">
                        <label for="inputEmail3" class="control-label">Year/Semester<span style="color:red;">*</span></label>

                        <?php
                        echo $this->Form->select(
                           'section_id',
                           $sections,
                           [
                              'class' => 'form-control',
                              'placeholder' => 'Year/Semester',
                              'disabled' => true,
                              'id' => 'section-id',
                              'required' => true
                           ]
                        );
                        ?>

                     </div>

                     <div class="col-md-4">
                        <label for="inputEmail3" class="control-label ">Organization<span style="color: red;">*</span></label>
                        <?php
                        echo $this->Form->select(
                           'board_id',
                           $board_names,
                           [
                              'class' => 'form-control',
                              'placeholder' => 'Select Organization',
                              'disabled' => true
                           ]
                        );
                        ?>
                     </div>


                     <div class="col-sm-4 col-xs-6">
                        <label for="inputEmail3" class="control-label">Pupil's First Name<span style="color:red;">*</span></label>
                        <?php echo $this->Form->input('fname', array('class' => 'form-control capitalize-word', 'placeholder' => 'First Name', 'required', 'id' => 'fname', 'label' => false)); ?>
                     </div>

                     <div class="col-sm-4 col-xs-6">
                        <label for="inputEmail3" class="control-label">Middle Name</label>
                        <?php echo $this->Form->input('middlename', array('class' => 'form-control capitalize-word', 'placeholder' => 'Middle Name', 'id' => 'mname', 'label' => false)); ?>
                     </div>
                     <div class="col-sm-4 col-xs-6">
                        <label for="inputEmail3" class="control-label">Last Name</label>
                        <?php echo $this->Form->input('lname', array('class' => 'form-control capitalize-word', 'placeholder' => 'Last Name', 'id' => 'lname', 'label' => false)); ?>
                     </div>

                     <div class="col-sm-4 col-xs-6">
                        <label for="inputEmail3" class="control-label">Date of Birth<span style="color:red;">*</span></label>
                        <div class="input-group">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
<!-- 
                           <input type="text" name="dob" class="form-control data" placeholder="Date of Birth" id="datepick1" required> -->
                           <?php echo $this->Form->input('dob', array('class' => 'form-control data',  'placeholder' => 'DD-MM-YYYY', 'id' => 'datepick1', 'label' => false,'readonly' => true)); ?>

                        </div>
                        <script>
                           $(document).ready(function() {
                              $('.data').attr('readonly', 'readonly');
                              var currentYear = new Date().getFullYear();
                              // Initialize the datepicker with the year range from 1995 to the current year
                              $("#datepick1").datepicker({
                                 dateFormat: "dd-mm-yy",
                                 changeMonth: true,
                                 changeYear: true,
                                 yearRange: "1995:" + currentYear, // Adjusted the yearRange
                                 defaultDate: "01-01-2000", // Set defaultDate to January 1, 2000
                                 onSelect: function() {
                                    $('.data').trigger('change');
                                 }
                              });

                              var dobDate = new Date("<?php echo date('Y-m-d', strtotime($students['dob'])); ?>");
                              $('#datepick1').datepicker("setDate", dobDate);

                              $('.data').change(function() {
                                 var stu_dob = $(this).val();
                                 if (stu_dob) {
                                    $('.data').attr('readonly', 'readonly');
                                 } else {
                                    $('.data').attr('readonly', false);
                                 }
                              });
                           });
                        </script>

                        <span style="color:red; display:none;" class="display_error">New Student D.O.B.
                           must have 6 years old.</span>
                     </div>

                     <div class="col-sm-4 col-xs-6">
                        <label for="inputEmail3" class="control-label">Email/Login Id</label>
                        <?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'Email', 'id' => 'mcheckmail', 'label' => false)); ?>
                        <span id="dividhere" style="display:none;color:red;">Email Already Exist</span>
                        <span id="ntc" style="color:red; display:none"><?php echo __("Invalid email"); ?></span>
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

                     <div class="col-sm-4 col-xs-6">
                        <label for="inputEmail3" class="control-label">Mobile No<span style="color:red;">*</span></label>
                        <?php echo $this->Form->input('mobile', array('class' => 'form-control', 'minlength' => '10', 'maxlength' => '10', 'onkeypress' => 'return isNumber(event);', 'placeholder' => 'Mobile No.', 'id' => 'mobile', 'label' => false, 'required')); ?>
                        <!-- /.input group -->
                        <div id="erpfd" style="display:none;color:red;"></div>
                     </div>


                     <div class="col-sm-4 col-xs-6">
                        <div>
                           <label for="inputEmail3" class="control-label">Gender</label>
                        </div>
                        <div>
                           <?php
                           $selectedGender = ($students['gender'] == 'Male') ? 'Male' : 'Female';
                           ?>
                           <?php echo $this->Form->radio('gender', ['Male' => 'Male', 'Female' => 'Female'], ['class' => 'radio-inline', 'value' => $selectedGender, 'default' => 'Male']); ?>
                        </div>
                     </div>

                     <div class="col-sm-4 col-xs-6">
                        <label for="inputEmail3" class="control-label">Application Form/Date</label>
                        <?php echo $this->Form->input('applocation_form_date', array('class' => 'form-control', 'placeholder' => 'Application Form/Date', 'label' => false)); ?>
                     </div>

                     <div class="col-sm-4 col-xs-6">
                        <label for="inputEmail3" class="control-label">Date of Joining</label>

                        <div class="input-group">
                           <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                           </div>
                           <input type="text" name="date_of_joining" class="form-control data" placeholder="Date of Joining" id="datepick2" readonly>

                        </div>

                        <script type="text/javascript">
                           $(document).ready(function() {

                              <?php
                              $defaultDate = ($students['date_of_joining']) ? date('Y-m-d', strtotime($students['date_of_joining'])) : date('d-m-Y');
                              ?>
                              var defaultDate = new Date("<?php echo $defaultDate; ?>");

                              var currentYear = new Date().getFullYear();
                              var currentDate = new Date();

                              var day = ("0" + currentDate.getDate()).slice(-2);
                              var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
                              var year = currentDate.getFullYear();


                              $("#datepick2").datepicker({
                                 dateFormat: "dd-mm-yy",
                                 changeMonth: true,
                                 changeYear: true,
                                 yearRange: "1995:" + currentYear,
                              });

                              // Set the default date on the datepicker
                              $("#datepick2").datepicker("setDate", defaultDate);

                              // Trigger 'change' event on selection
                              $("#datepick2").on("change", function() {
                                 $('.data').trigger('change');
                              });
                           });
                        </script>

                     </div>

                     <div class="col-sm-4 col-xs-6" style="margin-bottom: 10px;">
                        <label for="hindiOutput" class="control-label">Full Name (Hindi)</label>
                        <?php echo $this->Form->input('hindiname', array('class' => 'form-control', 'placeholder' => 'Full Name (Hindi)', 'id' => 'hindiname', 'label' => false)); ?>
                     </div>

                     <div class="col-sm-4 col-xs-6" style="display: none;">
                        <label for="inputEmail3" class="control-label">Student Image</label>
                        <?php echo $this->Form->input('file12', array('class' => 'form-control', 'type' => 'file', 'id' => 'pic1', 'label' => false, 'accept' => 'image/*')); ?>
                     </div>

                     <input type="hidden" name="as" id="fg" value="<?php echo $studentsid['enroll']; ?>">

                     <script type="text/javascript">
                        $('#b1').change(function() {
                           var hg = $('#fg').val();
                           var gh = $('#b1').val();
                           $.ajax({
                              type: 'POST',
                              url: '<?php echo ADMIN_URL; ?>Students/findboard',
                              data: {
                                 'id': gh
                              },
                              beforeSend: function(xhr) {
                                 xhr.setRequestHeader('X-CSRF-Token', $(
                                    '[name="_csrfToken"]').val())
                              },
                              success: function(data) {
                                 $('#enroll').val(data);
                              },
                           });
                        });
                     </script>

                     <script language="javascript" type="text/javascript">
                        $(document).ready(function(e) {
                           $("#inlinefRadio0").click(function() {
                              if ($(this).val() == 'Other') {
                                 $("#feerecivier").show();
                                 $('#feesubmittedby').prop('required', true);
                              }
                           });
                           $("#inlinefRadio1").click(function() {
                              if ($(this).val() == 'Mother') {
                                 $('#feesubmittedby').prop('required', false);
                                 $("#feerecivier").hide();
                              }
                           });
                           $("#inlinefRadio2").click(function() {
                              if ($(this).val() == 'Father') {
                                 $('#feesubmittedby').prop('required', false);
                                 $("#feerecivier").hide();
                              }
                           });
                           $(".feesmode").click(function() {
                              if ($(this).val() == 'CHEQUE') {
                                 $("#srnosss").hide();
                              } else {
                                 $("#srnosss").show();
                              }
                           });
                        });



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

                  </div>
                  <fieldset>
                     <legend><i class="fa fa-child" aria-hidden="true"></i> Academic Details</legend>
                     <div class="form-group add_acadmi_dtl">

                        <div class="col-sm-4 col-xs-6">
                           <label for="inputEmail3" class="control-label">Aadhar No.</label>
                           <?php
                           echo $this->Form->text('adaharnumber', [
                              'class' => 'form-control',
                              'maxlength' => '12',
                              'onkeypress' => 'return isNumber(event);',
                              'placeholder' => 'Aadhar No'
                           ]);
                           ?>
                           <div id="erp" style="display:none;color:red;">Enter Only Number</div>
                        </div>


                        <div class="col-sm-4 col-xs-6" id="smsmobile" style="display:block;">
                           <label for="inputEmail3" class="control-label">SMS Mobile<span style="color:red;">*</span></label>
                           <?php
                           echo $this->Form->text('sms_mobile', [
                              'class' => 'form-control',
                              'placeholder' => 'Enter SMS Mobile Number',
                              'maxlength' => '10',
                              'minlength' => '10',
                              'required' => 'required',
                              'onkeypress' => 'return isNumber(event);',
                              'id' => 'sms_mobile'
                           ]);
                           ?>

                        </div>

                        <div class="col-sm-4 col-xs-6" style="display: none;">
                           <input type="hidden" class="form-control" name="acedmicyear" value="<?php echo $acedmicyearfi; ?>">
                           <input type="hidden" class="form-control" name="admissionyear" id="ady" value="<? echo $acedmicyearfi; ?>">
                        </div>

                        <div class="col-sm-4 col-xs-6">
                           <label for="inputEmail3" class="control-label">Nationality</label>
                           <select class="form-control" name="nationality" style="width: 100%;">
                              <option value="INDIAN" <?php if ($students['nationality'] == 'INDIAN') { ?> selected="selected" <?php } ?>>INDIAN</option>
                              <option value="OTHERS" <?php if ($students['nationality'] == 'OTHERS') { ?> selected="selected" <?php } ?>>OTHERS</option>
                           </select>
                        </div>

                        <div class="col-sm-4 col-xs-6">
                           <label for="inputEmail3" class="control-label">Category <span style="color:red;">*</span></label>
                           <select class="form-control" onchange="castChoose(this)" name="cast" style="width: 100%;" required="required">
                              <option value="Gen" <?= ($students['cast'] == 'Gen') ? 'selected' : '' ?>>General</option>
                              <option value="OBC" <?= ($students['cast'] == 'OBC') ? 'selected' : '' ?>>O.B.C.</option>
                              <option value="SC" <?= ($students['cast'] == 'SC') ? 'selected' : '' ?>>S.C.</option>
                              <option value="ST" <?= ($students['cast'] == 'ST') ? 'selected' : '' ?>>S.T.</option>
                              <option value="MBC" <?= ($students['cast'] == 'MBC') ? 'selected' : '' ?>>MBC</option>
                              <option value="Others" <?= ($students['category'] == 'Others') ? 'selected' : '' ?>>Others</option>
                           </select>
                        </div>

                        <script>
                           let checkOther = <?= json_encode($students['category'] == 'Others') ?>;
                           let other_cast_text = <?= json_encode($students['cast']) ?>;
                           document.addEventListener("DOMContentLoaded", function() {
                              if (checkOther) {
                                 castChoose(document.querySelector('[name="cast"]'));
                              }
                           });
                           // Declare castChoose outside the event listener
                           function castChoose(selectElement) {
                              // console.log(checkOther);
                              var otherCasteOption = document.getElementById("othercasteoption");
                              var otherCastTextField = document.getElementById("other_cast_text");

                              otherCasteOption.style.display = (selectElement.value === "Others") ? "block" : "none";
                              otherCastTextField.required = (selectElement.value === "Others");

                              if (selectElement.value === "Others") {
                                 $('#other_cast_text').val(other_cast_text);
                              }
                           }
                        </script>



                        <div class="col-sm-4 col-xs-6" id="othercasteoption" style="display:none;">
                           <label for="inputEmail3" class="control-label">Category Name<span style="color:red;">*</span></label>
                           <input type="text" class="form-control" placeholder="Enter Category Name" name="other_cast_text" id="other_cast_text">
                        </div>


                        <div class="col-sm-4 col-xs-6">
                           <div><label>Fees Submitted By </label></div>
                           <?php
                           // pr($students);exit;
                           echo $this->Form->radio('feecat', ['Father' => 'Father', 'Mother' => 'Mother', 'Other' => 'Other'], ['class' => 'radio-inline', 'default' => 'Father']); ?>

                        </div>

                        <div class="col-sm-4 col-xs-6" id="feerecivier" style="display:none;">
                           <label for="inputEmail3" class="control-label">Name<span style="color:red;">*</span></label>
                           <input type="text" class="form-control" placeholder="Enter Fee Receiver Name" name="fee_submittedby" id="feesubmittedby">
                        </div>

                        <div class="col-sm-4 col-xs-12">
                           <div><label>Sms Received By :</label></div>
                           <?php echo $this->Form->radio('feecatss', ['f_phone' => 'Father Mobile No', 'm_phone' => 'Mother Mobile No.'], ['class' => 'radio-inline chji', 'default' => 'Father']); ?>

                        </div>


                        <div class="col-sm-4 col-xs-6">
                           <div><label>Is Transport </label></div>
                           <?php
                           echo $this->Form->radio('is_transport', ['Y' => 'Y', 'N' => 'N',], ['class' => 'radio-inline', 'default' => 'N']); ?>
                        </div>

                  </fieldset>
                  <br>
                  <fieldset>
                     <legend><i class="fa fa-user" aria-hidden="true"></i> Parent Information</legend>
                     <div class="form-group">
                        <div class="col-sm-4">
                           <?php
                           echo $this->Form->input('fathername', [
                              'label' => ['text' => 'Father Name *', 'class' => 'control-label'],
                              'class' => 'form-control capitalize-word',
                              'maxlength' => '30',
                              'placeholder' => 'Father Name',
                              'required' => true,
                              'id' => 'f_name'
                           ]);
                           ?>
                        </div>


                        <div class="col-sm-4">
                           <?php
                           echo $this->Form->input('f_phone', [
                              'label' => ['text' => 'Father Mobile No', 'class' => 'control-label'],
                              'class' => 'form-control',
                              'maxlength' => '10',
                              'minlength' => '10',
                              'placeholder' => 'Father Mobile No',
                              'onkeypress' => 'return isNumber(event);',
                              'id' => 'fphone'
                           ]);
                           ?>
                        </div>


                        <div class="col-sm-4">
                           <?php
                           echo $this->Form->input('f_occupation', [
                              'label' => ['text' => 'Father Occupation', 'class' => 'control-label'],
                              'class' => 'form-control capitalize-word',
                              'placeholder' => 'Father Occupation',
                              'id' => 'foccupation'
                           ]);
                           ?>
                        </div>

                     </div>

                     <div class="form-group">

                        <div class="col-sm-4">
                           <?php
                           echo $this->Form->input('mothername', [
                              'label' => ['text' => 'Mother Name', 'class' => 'control-label'],
                              'class' => 'form-control capitalize-word',
                              'maxlength' => '30',
                              'placeholder' => 'Mother Name',
                              'id' => 'm_name'
                           ]);
                           ?>
                        </div>




                        <div class="col-sm-4">
                           <?php
                           echo $this->Form->input('m_phone', [
                              'label' => ['text' => 'Mother Mobile No', 'class' => 'control-label'],
                              'class' => 'form-control',
                              'maxlength' => '10',
                              'minlength' => '10',
                              'placeholder' => 'Mother Mobile No',
                              'onkeypress' => 'return isNumber(event);',
                              'id' => 'mphone'
                           ]);
                           ?>
                        </div>

                        <div class="col-sm-4">
                           <?php
                           echo $this->Form->input('m_occupation', [
                              'label' => ['text' => 'Mother Occupation', 'class' => 'control-label'],
                              'class' => 'form-control capitalize-word',
                              'placeholder' => 'Mother Occupation',
                              'id' => 'moccupation'
                           ]);
                           ?>
                        </div>

                        <!-- <div class="form-group"> -->
                        <div class="col-sm-12">
                           <?php
                           echo $this->Form->input('address', [
                              'label' => ['text' => 'Residential Address *', 'class' => 'control-label'],
                              'type' => 'textarea',
                              'rows' => '3',
                              'style' => 'width: 100%;',
                              'placeholder' => 'Enter Residential Address ...',
                              'required' => true,
                              'id' => 'addre'
                           ]);
                           ?>


                        </div>
                        <!-- </div> -->

                     </div>

                  </fieldset>
                  <br>


                  <!-- <fieldset>
                            <legend><i class="fa fa-user" aria-hidden="true"></i> Guardian Information (Only if child not living with parent)</legend>
                            <?php if ($guardians) { ?>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="inputEmail3" class="control-label">Guardian Name</label>
                                        <?php echo $this->Form->input('fullname', array('class' => 'form-control', 'placeholder' => 'Guardian Name', 'value' => $guardians['fullname'], 'autocomplete' => 'off', 'id' => 'fullname', 'label' => false)); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="inputEmail3" class="control-label">Mobile No.</label>
                                        <?php echo $this->Form->input('mobileno', array('class' => 'form-control',  'value' => $guardians['mobileno'], 'id' => 'mobileno', 'label' => false, 'placeholder' => 'Mobile No.', 'onkeypress' => 'return isNumber(event);', 'required')); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="inputEmail3" class="control-label">Relation</label>
                                        <?php echo $this->Form->input('relation', array('class' => 'form-control', 'placeholder' => 'Relation', 'value' => $guardians['relation'], 'id' => 'relation', 'label' => false)); ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label for="inputEmail3" class="control-label">Guardian Name</label>
                                        <?php echo $this->Form->input('fullname', array('class' => 'form-control', 'placeholder' => 'Guardian Name', 'autocomplete' => 'off', 'id' => 'fullname', 'label' => false)); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="inputEmail3" class="control-label">Mobile No.</label>
                                        <?php echo $this->Form->input('mobileno', array('class' => 'form-control', 'placeholder' => 'Mobile No.', 'id' => 'mobileno', 'label' => false, 'onkeypress' => 'return isNumber(event);')); ?>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="inputEmail3" class="control-label">Relation</label>
                                        <?php echo $this->Form->input('relation', array('class' => 'form-control', 'placeholder' => 'Relation', 'id' => 'relation', 'label' => false)); ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </fieldset> -->



                  <!-- <br>
                        <fieldset>
                            <legend><i class="fa fa-user" aria-hidden="true"></i> Other's Information</legend>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Does the Child have Special
                                        Education Need ?</label>
                                    <?php echo $this->Form->input('is_specialedu', array('class' => 'form-control', 'placeholder' => 'Enter Detail', 'autocomplete' => 'off', 'id' => 'is_specialedu', 'label' => false)); ?>
                                </div>
                                <div class="col-sm-2">
                                    <label for="inputEmail3" class="control-label">Are you applying first Time
                                        ?</label>
                                    <select class="form-control" name="first_time" style="width: 100%;">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset> -->


                  <!-- <br>
                        <fieldset>
                            <legend><i class="fa fa-user" aria-hidden="true"></i> Sibling's Information</legend>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Enter Scholar No.1 Details of
                                        Siblings Studying in School</label>
                                    <?php echo $this->Form->input('sibling_1', array('class' => 'form-control', 'placeholder' => 'Enter Scholar No.1', 'id' => 'scholarno', 'label' => false)); ?>
                                </div>
                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Enter Scholar No.2 Details of
                                        Siblings Studying in School</label>
                                    <?php echo $this->Form->input('sibling_2', array('class' => 'form-control', 'placeholder' => 'Enter Scholar No.2', 'id' => 'scholarnos', 'label' => false)); ?>
                                </div>
                                <div class="col-sm-4">
                                    <label for="inputEmail3" class="control-label">Enter Scholar No.3 Details of
                                        Siblings Studying in School</label>
                                    <?php echo $this->Form->input('sibling_3', array('class' => 'form-control', 'placeholder' => 'Enter Scholar No.3', 'id' => 'scholarnos', 'label' => false)); ?>
                                </div>
                            </div>
                        </fieldset> -->

               </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
               <?php
               if (isset($students['id'])) {
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
               <?php
               echo $this->Html->link('Back', [
                  'action' => 'index',
               ], ['class' => 'btn btn-default']); ?>
            </div>
            <!-- /.box-footer -->
            <?php echo $this->Form->end(); ?>
         </div>
      </div>
   </section>
   <!-- /.content -->
</div>
<script>
   $(document).ready(function() {
      $('#username').on('change', function() {
         var username = $('#username').val();

         $.ajax({
            type: 'POST',
            url: '<?php echo ADMIN_URL; ?>students/find_username',
            data: {
               'username': username
            },
            beforeSend: function(xhr) {
               xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val())
            },
            success: function(data) {

               if (data > 0) {
                  $('#username').val('');
                  $('#dividhere').show();

               } else {
                  $('#dividhere').hide();
               }
            },

         });
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

<script>
   // Get all input elements with the class 'capitalize-both'
   var inputElements = document.querySelectorAll('.capitalize-word');

   // Add an event listener to each input element
   inputElements.forEach(function(inputElement) {
      inputElement.addEventListener('input', function() {
         // Get the input value
         var inputValue = inputElement.value;

         // Capitalize the first letter of each word
         inputValue = inputValue.split(' ').map(function(word) {
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
         }).join(' ');

         // Set the modified value back to the input element
         inputElement.value = inputValue;
      });
   });
</script>