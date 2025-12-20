<!-- Content Wrapper. Contains page content -->
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
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Edit Registration Manager</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>report/prospect"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>report/prospect">Manage Applicant</a></li>
      <li class="active">Edit Registration</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">

      <!-- right column -->
      <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-plus-square" aria-hidden="true"></i> Edit Register Student Form No.
              <? echo $applicant['sno']; ?>
            </h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <?php echo $this->Flash->render(); ?>
          <?php echo $this->Form->create($applicant, array(
            'class' => 'form-horizontal',
            'id' => 'student_form',
            'enctype' => 'multipart/form-data',
            'validate'
          )); ?>

          <div class="box-body">

            <div class="form-group">
              <div class="col-md-4 col-sm-6">

                <label for="inputEmail3" class="control-label">FORM No.<span style="color:red;">*</span></label>
                <?php echo $this->Form->input('sno', array('class' => 'form-control secrh-loc', 'readonly', 'placeholder' => 'Form serial no.', 'required', 'id' => 'title', 'label' => false)); ?>
                <span id="spinner" style="color: red;"></span>

              </div>

              <div class="col-md-4 col-sm-6">

                <div><label>If Switch Registration</label></div>
                <label class="radio-inline">
                  <input type="radio" name="category" id="inlinessRadio2" class="cnormm" value="NORMAL" checked> NORMAL
                </label>


                <label class="radio-inline">
                  <input type="radio" name="category" id="inlinessRadio3" class="cnormm" value="Migration"> Migration
                </label>

              </div>


              <div class="col-md-4 col-sm-6">
                <label for="inputEmail3" class="control-label">Class<span style="color:red;">*</span></label>
                <?php echo $this->Form->input('class_id', array('class' => 'form-control', 'id' => 'subjt', 'type' => 'select', 'empty' => 'Select Class', 'options' => $classes, 'label' => false)); ?>
                <!--<input type="hidden" name="class_id" id="h1">  -->
              </div>


              <!-- <div class="col-sm-2">
                <label for="inputEmail3" class="control-label">Academic Year<span style="color:red;">*</span></label>
                <?php
                // echo
                // $this->Form->input('acedmicyear', array('class' => 'form-control', 'id' => 'academic', 'type' => 'select', 'empty' => 'Select Academic Year', 'options' => $acd, 'label' => false, 'value' => $applicant['acedmicyear'], 'required'));
                ?>
              </div> -->


              <div class="col-md-4 col-sm-6">
                <label>Academic Year<span style="color:red;">*</span></label>
                <select class="form-control" name="acedmicyear" required="required">
                  <?php
                  $current_year = date('Y');
                  for ($i = 0; $i < 3; $i++) {
                    $selected = ($i == 0) ? 'selected' : ''; // Set the current year as selected by default
                    $start_year = $current_year - $i;
                    $end_year = $start_year + 1;
                    $year_range = $start_year . '-' . substr($end_year, 2);  // Format the year range
                  ?>
                    <option value="<?php echo $year_range; ?>" <?php echo $selected; ?>><?php echo $year_range; ?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>



              <div class="col-md-4 col-sm-6">
                <label for="inputEmail3" class="control-label">Receipt No<span style="color:red;">*</span></label>
                <?php echo $this->Form->input('recipietno', array('class' => 'form-control', 'readonly', 'type' => 'text', 'label' => false)); ?>
              </div>
            </div>


            <fieldset>
              <legend><i class="fa fa-child" aria-hidden="true"></i> Applicant Information</legend>

              <div class="form-group">

                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">Pupil's First Name<span style="color:red;">*</span></label>
                  <?php echo $this->Form->input('fname', array('class' => 'form-control', 'placeholder' => 'First Name', 'autocomplete' => 'off', 'required', 'id' => 'fname', 'label' => false)); ?>
                </div>

                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">Middle Name</label>
                  <?php echo $this->Form->input('middlename', array('class' => 'form-control', 'placeholder' => 'Middle Name', 'autocomplete' => 'off', 'id' => 'mname', 'label' => false)); ?>
                </div>


                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">Last Name</label>
                  <?php echo $this->Form->input('lname', array('class' => 'form-control', 'placeholder' => 'Last Name', 'autocomplete' => 'off', 'id' => 'lname', 'label' => false)); ?>
                </div>

              </div>





              <div class="form-group">

                <div class="col-md-4 col-sm-6">
                  <div><label for="inputEmail3" class="control-label">Gender</label></div>
                  <label class="radio-inline">
                    <input type="radio" name="gender" id="inlineRadio1" checked value="Male"> Male
                  </label>
                  <label for="inputEmail3" class="radio-inline">
                    <input type="radio" name="gender" id="inlineRadio2" value="Female"> Female
                  </label>
                </div>

                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label data">DATE Of BIRTH<span style="color:red;">*</span></label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <?php echo $this->Form->input('dob', array('class' => 'form-control data', 'type' => 'text', 'placeholder' => 'Date Of Birth', 'id' => 'datepick1', 'label' => false, 'value' => date('d/m/Y', strtotime($applicant['dob'])), 'required')); ?>
                  </div> <span style="color:red; display:none;" class="display_error">New Student D.O.B. must have 2
                    years old.</span>
                </div>

                <script type="text/javascript">
                  $("#datepick1").change(function() {
                    var stu = $("#datepick1").val().split('/');
                    // alert(stu);

                    var wMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                      'September', 'October', 'November', 'December'
                    ]

                    var final = toWords(stu[0]) + " " + wMonths[parseInt(stu[1]) - 1] + " " + toWords(stu[2])

                    $('#bhu').val(final);
                  });

                  // Convert numbers to words
                  // copyright 25th July 2006, by Stephen Chapman http://javascript.about.com
                  // permission to use this Javascript on your web page is granted
                  // provided that all of the code (including this copyright notice) is
                  // used exactly as shown (you can change the numbering system if you wish)

                  // American Numbering System
                  var th = ['', 'Thousand', 'Million', 'Billion', 'Trillion'];
                  // uncomment this line for English Number System
                  // var th = ['','thousand','million', 'milliard','billion'];

                  var dg = ['Zero', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
                  var tn = ['Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen',
                    'Eighteen', 'Nineteen'
                  ];
                  var tw = ['Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

                  function toWords(s) {
                    s = s.toString();
                    s = s.replace(/[\, ]/g, '');
                    if (s != parseFloat(s)) return 'not a number';
                    var x = s.indexOf('.');
                    if (x == -1) x = s.length;
                    if (x > 15) return 'too big';
                    var n = s.split('');
                    var str = '';
                    var sk = 0;
                    for (var i = 0; i < x; i++) {
                      if ((x - i) % 3 == 2) {
                        if (n[i] == '1') {
                          str += tn[Number(n[i + 1])] + ' ';
                          i++;
                          sk = 1;
                        } else if (n[i] != 0) {
                          str += tw[n[i] - 2] + ' ';
                          sk = 1;
                        }
                      } else if (n[i] != 0) {
                        str += dg[n[i]] + ' ';
                        if ((x - i) % 3 == 0) str += 'hundred ';
                        sk = 1;
                      }
                      if ((x - i) % 3 == 1) {
                        if (sk) str += th[(x - i - 1) / 3] + ' ';
                        sk = 0;
                      }
                    }
                    if (x != s.length) {
                      var y = s.length;
                      str += 'point ';
                      for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
                    }
                    return str.replace(/\s+/g, ' ');
                  }
                </script>


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

                <script>
                  // this code use to dob readonly after chose date 
                  $('.data').change(function() {
                    stu_dob = $(this).val();
                    if (stu_dob) {
                      $('.data').attr('readonly', 'readonly');
                    } else {
                      $('.data').attr('readonly', false);
                    }
                  });
                </script>




                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">PLACE OF BIRTH</label>
                  <?php echo $this->Form->input('pob', array('class' => 'form-control', 'placeholder' => 'Place of Birth', 'id' => 'pob', 'label' => false)); ?>
                </div>
                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">PREVIOUS BOARD</label>
                  <?php
                  // $arrt = array('CBSE' => 'CBSE', 'RBSE' => 'RBSE', 'ICSE' => 'ICSE');

                  echo $this->Form->input('previous_board', array('class' => 'form-control', 'placeholder' => 'Previous Board', 'type' => 'select', 'options' => $board_name, 'id' => 'previous_board', 'label' => false)); ?>
                </div>

              </div>

              <div class="form-group">

                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">DATE OF BIRTH(IN WORDS)</label>
                  <?php echo $this->Form->input('dob_word', array('class' => 'form-control', 'readonly', 'placeholder' => 'Date of Birth in Words', 'id' => 'bhu', 'label' => false)); ?>
                </div>
                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">Fee Submitted By</label>
                  <?php echo $this->Form->input('fee_submittedby', array('class' => 'form-control', 'placeholder' => 'Name', 'autocomplete' => 'off', 'id' => 'name', 'label' => false)); ?>
                </div>





                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">MOTHER TONGUE</label>
                  <?php echo $this->Form->input('mother_tounge', array('class' => 'form-control', 'placeholder' => 'Language', 'autocomplete' => 'off', 'id' => 'mother_tounge', 'label' => false)); ?>
                </div>



              </div>

            </fieldset>
            <hr>
            <fieldset>
              <legend><i class="fa fa-user" aria-hidden="true"></i> Parent Information</legend>
              <div class="form-group">

                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">FATHER'S NAME</label>
                  <?php echo $this->Form->input('f_name', array('class' => 'form-control', 'placeholder' => 'Father Name', 'autocomplete' => 'off', 'id' => 'fathername', 'label' => false)); ?>
                </div>

                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">QUALIFICATION</label>
                  <?php echo $this->Form->input('f_qualification', array('class' => 'form-control', 'placeholder' => 'Qualification', 'autocomplete' => 'off', 'id' => 'f_qualification', 'label' => false)); ?>
                </div>




                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">OCCUPATION</label>
                  <?php echo $this->Form->input('f_occupation', array('class' => 'form-control', 'placeholder' => 'Occupation', 'autocomplete' => 'off', 'id' => 'f_occupation', 'label' => false)); ?>
                </div>



              </div>

              <div class="form-group">

                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">MOTHER/GUARDIAN'S NAME</label>
                  <?php echo $this->Form->input('m_name', array('class' => 'form-control', 'placeholder' => 'Guardians Name', 'autocomplete' => 'off', 'id' => 'm_name', 'label' => false)); ?>
                </div>

                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">QUALIFICATION</label>
                  <?php echo $this->Form->input('m_qualification', array('class' => 'form-control', 'placeholder' => 'Qualification', 'autocomplete' => 'off', 'id' => 'm_qualification', 'label' => false)); ?>
                </div>




                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">OCCUPATION</label>
                  <?php echo $this->Form->input('m_occupation', array('class' => 'form-control', 'placeholder' => 'Occupation', 'autocomplete' => 'off', 'id' => 'm_occupation', 'label' => false)); ?>
                </div>



              </div>

              <div class="form-group">


                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">NATIONALITY</label>
                  <select class="form-control" name="nationality" style="width: 100%;">

                    <option value="INDIAN" selected="selected">INDIAN</option>

                    <option value="OTHERS">OTHERS</option>


                  </select>
                </div>

                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">PHONE NUMBER(MOTHER)</label>
                  <?php echo $this->Form->input('m_phone', array('class' => 'form-control',  'onkeypress' => 'return isNumber(event);', 'placeholder' => 'Phone Number', 'autocomplete' => 'off', 'maxlength' => '11', 'id' => 'm_phone', 'label' => false)); ?>
                </div>

                <div class="col-md-4 col-sm-6">
                  <label for="inputEmail3" class="control-label">PHONE NUMBER(FATHER)</label>
                  <?php echo $this->Form->input('f_phone', array('class' => 'form-control', 'onkeypress' => 'return isNumber(event);',  'placeholder' => 'Phone Number', 'autocomplete' => 'off', 'maxlength' => '11', 'id' => 'f_phone', 'label' => false)); ?>
                </div>








              </div>





            </fieldset>

            <fieldset>
              <legend><i class="fa fa-user" aria-hidden="true"></i> Guardian Information</legend>

              <div class="form-group">

                <div class="col-sm-4">
                  <label for="inputEmail3" class="control-label">GUARDIAN NAME</label>
                  <?php echo $this->Form->input('fullname', array('class' => 'form-control', 'placeholder' => 'GUARDIAN NAME', 'value' => $guardians['fullname'], 'autocomplete' => 'off', 'id' => 'fullname', 'label' => false)); ?>
                </div>

                <div class="col-sm-4">
                  <label for="inputEmail3" class="control-label">MOBILE No.</label>
                  <?php echo $this->Form->input('mobileno', array('class' => 'form-control', 'onkeypress' => 'return isNumber(event);',  'placeholder' => 'MOBILE NO', 'value' => $guardians['mobileno'], 'id' => 'mobileno', 'label' => false, 'onkeypress' => 'return isNumber(event);',)); ?>
                </div>




                <div class="col-sm-4">
                  <label for="inputEmail3" class="control-label">RELATION</label>
                  <?php echo $this->Form->input('relation', array('class' => 'form-control', 'placeholder' => 'RELATION', 'value' => $guardians['relation'], 'id' => 'relation', 'label' => false)); ?>
                </div>



              </div>

            </fieldset>





          </div>
        </div>



        <!-- /.box-body -->
        <div class="box-footer">


          <?php


          echo $this->Form->submit(
            'Update',
            array('class' => 'btn btn-info pull-right', 'title' => 'Update')
          );

          ?>
          <?php
          echo $this->Html->link('Back', [
            'action' => 'index'

          ], ['class' => 'btn btn-default']); ?>
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