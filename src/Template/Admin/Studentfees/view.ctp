<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Search Student
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>studentfees/view"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>studentfees/view">Manage Student Fee</a></li>
    </ol>
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

            <?php

            // pr($id);exit;
            if ($ids || $ids3) { ?>

              <?php
              if ($ids3 && $ids4) { ?>

                <a href="<? echo ADMIN_URL; ?>studentfees/<?php echo $ids3; ?>/<?php echo $ids4; ?>/<?php echo $acedemicdd; ?>" target="_blank" id="redicaution"></a>

                <script type="text/javascript">
                  $('#redicaution')[0].click();
                </script>

              <? } else if ($ids && $ids2) { ?>
                <a href="<? echo ADMIN_URL; ?>studentfees/<?php echo $ids; ?>/<?php echo $ids2; ?>/<?php echo $acedemicdd; ?>" target="_blank" id="redi"></a>

                <script type="text/javascript">
                  $('#redi')[0].click();
                </script>

            <?php }
            }  ?>

            <?php
            // Assuming $id is the variable you want to check
            if (isset($id)) {
              $student_id = $id;
              $accademic_year = $rolepresentyear;
            } else {
              $student_id = $_SESSION['student_id'];
              $accademic_year = $_SESSION['student_accademic'];
            }
            ?>


            <div class="manag-stu">

              <!-- optimize this code by Rupam Singh 20-07-2023 -->
              <script inline="1">
                $(document).ready(function() {

                  // let student_id = '<?php //echo $_SESSION['student_id']; 
                                        ?>';
                  // let accademic_year = '<?php //echo $_SESSION['student_accademic']; 
                                            ?>';
                  let student_id = '<?php echo $student_id; ?>';
                  let accademic_year = '<?php echo $accademic_year; ?>';
                  let accademicYear = '<?php echo $rolepresentyear; ?>';
                  let studentId = '<?php echo $id; ?>';
                  let requestData;

                  $("#TaskAdminCustomerForm").bind("submit", function(event) {
                    AmagiLoader.show();
                    event.preventDefault();
                    $.ajax({
                      async: true,
                      data: $("#TaskAdminCustomerForm").serialize(),
                      dataType: "html",
                      beforeSend: function(xhr) {
                        xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                      },
                      type: "POST",
                      url: "<?php echo SITE_URL; ?>admin/Studentfees/depositefees",
                      success: function(data, textStatus) {
                        AmagiLoader.hide();
                        $("#example12").html(data);
                      },
                      complete: function() {
                        AmagiLoader.hide();
                      },
                    });
                  });

                  if (student_id !== '') {
                    // console.log("🚀 ~ file: view.ctp:112 ~ $ ~ student_id:", student_id)
                    requestData = {
                      "student_id": student_id,
                      "accademic_year": accademic_year
                    };
                  } else {
                    // console.log('run by rupam');
                    return false;
                  }


                  $.ajax({
                    async: true,
                    data: requestData,
                    beforeSend: function(xhr) {
                      xhr.setRequestHeader('X-CSRF-Token', $('[name="_csrfToken"]').val());
                      AmagiLoader.show();
                    },
                    type: "POST",
                    url: "<?php echo SITE_URL; ?>admin/Studentfees/depositefees",
                    success: function(data, textStatus) {
                      AmagiLoader.hide();
                      $("#example12").html(data);
                    }
                  });
                });
              </script>

              <?php echo $this->Form->create('Task', array('url' => array('controller' => 'ClasstimeTabs', 'action' => 'viewtimetable'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>

              <div class="form-group">

                <div class="col-md-7">
                  <label for="inputEmail3" class="control-label">Pupil's Name</label>
                  <input type="hidden" name="student_id" id="student_id" value="id">
                  <input type="hidden" name="accademic_year" id="acedmicyear" value="acedmicyear">

                  <?php echo $this->Form->input('name', array('class' => 'form-control secrh-students stu_name js-searchBox-input', 'type' => 'text', 'label' => false, 'autofocus', 'autocomplete' => 'off', 'placeholder' => 'Enter Pupils Name', 'required')); ?>
                  <div id="test" style="display:none;">
                    <ul>

                    </ul>
                  </div>
                </div>

                <div class="col-md-1" style="top: 30px; width: 0px; padding: 0px; margin: 0px;">

                  <div class="searchBox-clearWrapper">
                    <style>
                      span.searchBox-clear.js-clearSearchBox:hover i {
                        color: black;
                      }
                      .secrh-students{
                        border-radius: 2px;
                      }
                    </style>
                    <span class="searchBox-clear js-clearSearchBox" style="opacity: 1;color: #CCC;  padding: 0;cursor: pointer;font-size: inherit;cursor: pointer;line-height: 1.5;"><i class="fa fa-times-circle" style="font-weight: 700;font-size: 24px;margin-left: -41px;"></i>
                    </span>

                  </div>
                </div>

                <div class="col-sm-3 col-xs-6" style="top: 23px;">
                  <button type="submit" class="btn btn-success">Search</button>

                  <a class="btn btn-info " style="color:#ffffff !important; background-color: #8B0000; !important" href="<?php echo SITE_URL; ?>admin/studentfees/view"><b>Reset</i></b></a>
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
          <h3 class="box-title"> View Students Fees</h3>

        </div>
        <!--/.col (left) -->
        <!-- <div class="row"> -->
        <div id="example12"> </div>
        <!-- </div> -->
        <!--/.col (right) -->
      </div>
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>

<script>
  $('.js-clearSearchBox').css('opacity', '0');

  $('.js-searchBox-input').focus(function() {
    $('.searchBox-fakeInput').toggleClass("is-focussed");
  });

  $('.js-searchBox-input').keyup(function() {
    if ($(this).val() != '') {
      $('.js-clearSearchBox').css('opacity', '1');
    } else {
      $('.js-clearSearchBox').css('opacity', '0');
    };

    $(window).bind('keydown', function(e) {
      if (e.keyCode === 27) {
        $('.js-searchBox-input').val('');
        $('.js-clearSearchBox').css('opacity', '0');
      };
    });
  });
  // click the button 
  $('.js-clearSearchBox').click(function() {
    $('.js-searchBox-input').val('');
    $('.js-searchBox-input').focus();
    $('.js-clearSearchBox').css('opacity', '0');
    $('#acedmicyear').val('');
    $('#student_id').val('');
  });


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