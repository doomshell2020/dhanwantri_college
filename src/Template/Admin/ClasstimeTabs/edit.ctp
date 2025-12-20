<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">
    <span aria-hidden="true">×</span><span class="sr-only">Close</span>
  </button>
  <h4 class="modal-title" id="modalLabel"><i class="fa fa-calendar"></i>
    Assign Lecture - <?php echo $weekname; ?> </h4>
  <small>
    <strong> Class </strong> : <?php echo $classtitle; ?> </small> |
  <small>
    <strong> Section </strong> :
    <?php echo $sectiontitle; ?>
  </small> |

</div> <!-- /.modal-header -->




<?php $sid = explode(',', $subsn_id);
$teaid = explode(',', $tea);
$counter = 0;
foreach ($sid as $key => $value) {
  $subcheck = $this->Comman->checksub($value, $clasid);
  if ($subcheck['is_optional'] == '1') {
    $counter++;
  }
}
?>

<?php echo $this->Form->create($timestable, array(

  'class' => 'form-horizontal',
  'id' => 'timestable_form',
  'enctype' => 'multipart/form-data',
  'validate'
)); ?>
<div class="modal-body">

  <div id="s-id">
    <div class="after-add-more" id="test">

      <?php if ($clasid == '12' || $clasid == '13' || $clasid == '15' || $clasid == '17' || $clasid == '20' || $clasid == '22') { ?>
        <div class="form-group">
          <div class="col-sm-5">
            <label>Subject Type</label>
          </div>
          <div class="col-sm-5">
            <label class="radio-inline"><input type="radio" class="reg" <?php if ($counter == '0') { ?> checked <?php } ?> name="type" value="1">Regular</label>
            <label class="radio-inline"><input type="radio" class="opt" <?php if ($counter >= '1') { ?> checked <?php } ?> name="type" value="2">Optional</label>
          </div>
        </div>
      <?php } ?>
      <?php $cnt = 0;
      foreach ($sid as $k => $val) {
        foreach ($teaid as $s => $value1) {
          if ($k == $s) {
            $cnt++;

      ?>
            <script>
              $('.enm<?php echo $cnt; ?>').on('change', function() {
                var empid = $(this).val();
                var tid = '<?php echo $tt_id; ?>';
                var week = '<?php echo $weekname; ?>';
                $.ajax({
                  type: 'POST',
                  url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/teacheroccupy',
                  data: {
                    'empid': empid,
                    'tid': tid,
                    'week': week
                  },
                  success: function(data) {
                    var arr = data.split('/');

                    var clsname = arr['1'];
                    var secname = arr['2'];
                    var clid1 = arr['3'];
                    var clid2 = arr['4'];
                    var emp = arr['5'];

                    if (data != '0') {
                      if (confirm("Teacher already assigned in class (" + clsname + " - " + secname + "). Do you really want to assign this teacher?")) {
                        $.ajax({
                          type: 'POST',
                          url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/teacherdelete',
                          data: {
                            'clid1': clid1,
                            'clid2': clid2,
                            'emp': emp
                          },
                          success: function(data) {



                          }

                        });
                      } else {
                        var ih = $('.mklo<?php echo $cnt; ?>').val();

                        $('.enm<?php echo $cnt; ?>').val(ih);
                      }
                    } else {
                      $('.errer').html("");
                      $('.sub1').change(function() {
                        var d = $(this).val();
                        $('.sb').val(d);
                      });
                    }

                  },

                });
              });

              $(".sub1").click(function() {
                var d = $(this).val();
                $('.sb').val(d);
              });
            </script>

            <script type="text/javascript">
              $('.reg').click(function() {
                var cot = $('.cio').val();
                if (cot == 1) {
                  $('.asset2').hide();
                  var subn = '<?php echo $regsub; ?>';
                  var rege = '<?php echo $regemplo; ?>';
                  $('.sub1').prop('disabled', false);
                  $('.sub1').html("");
                  $('.enm<?php echo $cnt; ?>').html("");
                  $(".reg").prop("checked", true);

                  $('.sub1').append('<option value="' + "" + '">' + "Select Subject" + '</option>');
                  $.each(JSON.parse(subn), function(key, value) {
                    $('.sub1').append('<option value="' + key + '">' + value + '</option>');
                  });


                  $('.enm<?php echo $cnt; ?>').append('<option value="' + "" + '">' + "Select Teacher" + '</option>');
                  $.each(JSON.parse(rege), function(key, value) {
                    $('.enm<?php echo $cnt; ?>').append('<option value="' + key + '">' + value.replace(/;/g, " ") + '</option>');
                  });
                } else {
                  alert("You have optional subject");
                  $(".opt").prop("checked", true);
                  $(".reg").prop("checked", false);
                }
              });


              $('.opt').click(function() {
                var cot = $('.cio').val();

                if (cot == 1) {
                  $('.asset2').hide();
                  var subn2 = '<?php echo $optsub; ?>';
                  var opte = '<?php echo $optemplo; ?>';

                  $('.sub1').prop('disabled', false);
                  $('.sub1').html("");
                  $('.enm<?php echo $cnt; ?>').html("");
                  $(".opt").prop("checked", true);
                  $('.sub1').append('<option value="' + "" + '">' + "Select Subject" + '</option>');
                  $.each(JSON.parse(subn2), function(key, value) {
                    $('.sub1').append('<option value="' + key + '">' + value + '</option>');
                  });


                  $('.enm<?php echo $cnt; ?>').append('<option value="' + "" + '">' + "Select Teacher" + '</option>');
                  $.each(JSON.parse(opte), function(key, value) {
                    $('.enm<?php echo $cnt; ?>').append('<option value="' + key + '">' + value.replace(/;/g, " ") + '</option>');
                  });
                } else {
                  alert("You have Multiple subjects.");
                  $(".opt").prop("checked", false);
                  $(".reg").prop("checked", true);
                }

              });
            </script>

            <div class="assets_container">
              <div class="form-group">

                <div class="col-sm-5">
                  <?php
                  if ($clasid == '12' || $clasid == '13' || $clasid == '15' || $clasid == '17' || $clasid == '20' || $clasid == '22') {
                    $emty = json_decode($regemplo);
                    $omty = json_decode($optemplo);
                    if ($counter >= '1') {
                      foreach ($omty as $key => $value) {
                        $array[$key] = str_replace(";", " ", $value);
                      }
                      echo $this->Form->input('employee_id[]', array('class' => 'form-control enm' . $cnt, 'id' => $cnt, 'type' => 'select', 'value' => $value1, 'empty' => 'Select Employee', 'options' => $array, 'required', 'label' => false));
                    } else {
                      foreach ($emty as $key => $value) {
                        $array[$key] = str_replace(";", " ", $value);
                      }
                      echo $this->Form->input('employee_id[]', array('class' => 'form-control enm' . $cnt, 'id' => $cnt, 'type' => 'select', 'value' => $value1, 'empty' => 'Select Employee', 'options' => $array, 'required', 'label' => false));
                    }
                  } else if ($clasid == '26' || $clasid == '27') {
                    $emty = json_decode($regemplo);
                    foreach ($emty as $key => $value) {
                      $array[$key] = str_replace(";", " ", $value);
                    }
                    echo $this->Form->input('employee_id[]', array('class' => 'form-control enm' . $cnt, 'id' => $cnt, 'type' => 'select', 'empty' => 'Select Employee', 'value' => $value1, 'options' => $array, 'required', 'label' => false));
                  } else {
                    foreach ($employee as $key => $value) {
                      $array[$key] = str_replace(";", " ", $value);
                    }
                    echo $this->Form->input('employee_id[]', array('class' => 'form-control enm' . $cnt, 'id' => $cnt, 'type' => 'select', 'empty' => 'Select Employee', 'options' => $array, 'value' => $value1, 'required', 'label' => false));
                  }
                  ?>

                  <span class="errer" style="color: red;"></span>
                </div>





                <div class="col-sm-5" id="sub">
                  <?php
                  $rty = json_decode($regsub);
                  $oty = json_decode($optsub);
                  if ($counter >= '1') {
                    echo $this->Form->input('subject_id[]', array('class' => 'form-control sub1', 'type' => 'select', 'empty' => 'Select Subject', 'options' => $oty, 'value' => $val, 'label' => false, 'required'));
                  } else {
                    echo $this->Form->input('subject_id[]', array('class' => 'form-control sub1', 'type' => 'select', 'empty' => 'Select Subject', 'options' => $rty, 'value' => $val, 'label' => false, 'required'));
                  }
                  ?>

                  <?php
                   echo $this->Form->input('class_id', array('class' => 'form-control', 'type' => 'hidden', 'empty' => 'Select Class', 'id' => 'c-id', 'required', 'value' => $classsec_id, 'label' => false)); ?> <?php echo $this->Form->input('tt_id', array('class' => 'form-control', 'type' => 'hidden', 'empty' => 'Select Class', 'id' => 'c-id', 'required', 'value' => $tt_id, 'label' => false)); ?>
                   <?php echo $this->Form->input('weekday', array('class' => 'form-control', 'type' => 'hidden', 'empty' => 'Select Class', 'id' => 'c-id', 'required', 'value' => $weekname, 'label' => false));
                   echo $this->Form->input('emp', array('class' => 'form-control mklo' . $cnt, 'type' => 'hidden', 'value' => $value1, 'required', 'label' => false));
                  ?>
                </div>


                <div class="col-sm-2" class="subtype">
                  <?php if ($cnt == '1') { ?>
                    <a href="javascript:void(0);" class="add_field_butto" style="font-weight: bold; font-size: 15px;"><i class="fa fa-plus-circle"></i></a>
                  <?php } else { ?>
                    <a href="javascript:void(0);" class="remove1" style="font-weight: bold; font-size: 15px;"><i class="fa fa-minus-circle"></i></a>
                  <?php } ?>
                </div>


              </div>
            </div>
      <?php }
        }
      } ?>

      <input type="hidden" class="cio" name="cki" value="<?php echo $cnt; ?>">
      <input type="hidden" class="mkl" name="bjk">
    </div>

  </div>

</div> <!-- /. modal-body -->


<div class="modal-footer">
  <button type="submit" id="sum" class="btn btn-primary pull-left">Update</button> <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div> <!-- /. modal-footer -->
</form>

<script>

  var incments = '0';
  $(".add_field_butto").click(function() {
    var clsid = '<?php echo $clasid; ?>';

    incments++;

$('.after-add-more').append('<div class="assets_container asset2"> <div class="form-group"><div class="col-sm-5"><select data-id="' + incments + '" class="form-control  enm2' + incments + '" name="employee_id[]" required="required"><option value="" >Select Teacher</option><?php if ($clasid == '26' || $clasid == '27') {
foreach ($emty as $key => $value) { ?><option value="<?php echo $key; ?>"><?php echo str_replace(";", " ", $value); ?></option><?php }
} else {
foreach ($employee as $key => $value) { ?><option value="<?php echo $key; ?>"><?php echo str_replace(";", " ", $value); ?></option><?php }
} ?></select>  </div> <div class="col-sm-5" id="sub"><select data-id="' + incments + '" class="form-control sub2' + incments + '" name="subject_id1[]" required="required"><option value="" >Select Subject</option><?php foreach ($rty as $key => $value) { ?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php } ?></select><input type="hidden" name="subject_id[]" class="sb' + incments + '" >  <?php echo $this->Form->input('class_id', array('class' => 'form-control', 'type' => 'hidden', 'empty' => 'Select Class', 'id' => 'c-id', 'required', 'value' => $classsec_id, 'label' => false)); ?>  <?php echo $this->Form->input('tt_id', array('class' => 'form-control', 'type' => 'hidden', 'empty' => 'Select Class', 'id' => 'c-id', 'required', 'value' => $tt_id, 'label' => false)); ?>    <?php echo $this->Form->input('weekday', array('class' => 'form-control', 'type' => 'hidden', 'empty' => 'Select Class', 'id' => 'c-id', 'required', 'value' => $weekname, 'label' => false)); ?>   </div> <div class="col-sm-2" style="float: right;" ><a href="javascript:void(0);" class="remove" style="font-weight: bold; font-size: 15px;"><i class="fa fa-minus-circle"></i></a>  </div> </div></div> ');

    if (clsid != '25' && clsid != '26' && clsid != '27' && clsid != '1' && clsid != '2' && clsid != '3' && clsid != '4' && clsid != '6' && clsid != '7' && clsid != '8' && clsid != '9' && clsid != '10' && clsid != '11' && clsid != '18' && clsid != '19' && clsid != '23' && clsid != '24' && clsid != '28' && clsid != '29') {


      var radioValue1 = $("input[type='radio']:checked").val();
      if (radioValue1 == '1') {
        var subn = '<?php echo $regsub; ?>';
        var rege = '<?php echo $regemplo; ?>';

        $(".sub2" + incments).html("");
        $(".sub2" + incments).append('<option value="' + "" + '">' + "Select Subject" + '</option>');
        $.each(JSON.parse(subn), function(key, value) {
          $(".sub2" + incments).append('<option value="' + key + '">' + value + '</option>');
        });

        $(".enm2" + incments).html("");
        $(".enm2" + incments).append('<option value="' + "" + '">' + "Select Teacher" + '</option>');
        $.each(JSON.parse(rege), function(key, value) {
          $(".enm2" + incments).append('<option value="' + key + '">' + value.replace(/;/g, " ") + '</option>');
        });
      } else {
        var subn2 = '<?php echo $optsub; ?>';
        var opte = '<?php echo $optemplo; ?>';
        $(".sub2" + incments).html("");
        $(".sub2" + incments).append('<option value="' + "" + '">' + "Select Subject" + '</option>');
        $.each(JSON.parse(subn2), function(key, value) {
          $(".sub2" + incments).append('<option value="' + key + '">' + value + '</option>');
        });

        $(".enm2" + incments).html("");
        $(".enm2" + incments).append('<option value="' + "" + '">' + "Select Teacher" + '</option>');
        $.each(JSON.parse(opte), function(key, value) {
          $(".enm2" + incments).append('<option value="' + key + '">' + value.replace(/;/g, " ") + '</option>');
        });
      }



      $('.opt').click(function() {
        $(".reg").prop('checked', false);
        var subn2 = '<?php echo $optsub; ?>';
        var opte = '<?php echo $optemplo; ?>';
        $(".sub2" + incments).prop('disabled', false);
        $(".sub2" + incments).html("");
        $(".sub2" + incments).append('<option value="' + "" + '">' + "Select Subject" + '</option>');
        $.each(JSON.parse(subn2), function(key, value) {
          $(".sub2" + incments).append('<option value="' + key + '">' + value + '</option>');
        });

        $(".enm2" + incments).html("");
        $(".enm2" + incments).append('<option value="' + "" + '">' + "Select Teacher" + '</option>');
        $.each(JSON.parse(opte), function(key, value) {
          $(".enm2" + incments).append('<option value="' + key + '">' + value.replace(/;/g, " ") + '</option>');
        });



      });

      $('.reg').click(function() {
        $('.asset2').hide();
        var subn = '<?php echo $regsub; ?>';
        var rege = '<?php echo $regemplo; ?>';
        $(".sub2" + incments).prop('disabled', false);
        $(".sub2" + incments).html("");
        $(".sub2" + incments).append('<option value="' + "" + '">' + "Select Subject" + '</option>');
        $.each(JSON.parse(subn), function(key, value) {
          $(".sub2" + incments).append('<option value="' + key + '">' + value + '</option>');
        });
        $(".enm2" + incments).html("");
        $(".enm2" + incments).append('<option value="' + "" + '">' + "Select Teacher" + '</option>');
        $.each(JSON.parse(rege), function(key, value) {
          $(".enm2" + incments).append('<option value="' + key + '">' + value.replace(/;/g, " ") + '</option>');
        });
      });

    }


    $(".enm2" + incments).on('change', function() {
      var empid = $(this).val();
      var tid = '<?php echo $tt_id; ?>';
      var week = '<?php echo $weekname; ?>';
      var mh = $(this).data('id');
      $.ajax({
        type: 'POST',
        url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/teacheroccupy',
        data: {
          'empid': empid,
          'tid': tid,
          'week': week
        },
        success: function(data) {
          var arr = data.split('/');
          var clsname = arr['1'];
          var secname = arr['2'];
          var clid1 = arr['3'];
          var clid2 = arr['4'];
          var emp = arr['5'];
          if (data != '0') {
            if (confirm("Teacher already assigned in class (" + clsname + " - " + secname + "). Do you really want to assign this teacher?")) {
              $.ajax({
                type: 'POST',
                url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/teacherdelete',
                data: {
                  'clid1': clid1,
                  'clid2': clid2,
                  'emp': emp
                },
                success: function(data) {
                }
              });
            } else {
              $(".enm2" + mh).val("");
            }
          }
        },
      });
    });


    $(".sub2" + incments).click(function() {
      var d = $(this).val();
      var gh = $(this).data('id');
      $(".sb" + gh).val(d);
    });
  });



  $("body").on("click", ".remove", function() {
    $(this).closest('.assets_container').remove();
  });
  var bh = '0';
  $('.remove1').click(function() {
    $(this).closest('.assets_container').remove();
    var cot = $('.cio').val();
    var bh = cot - 1;
    $('.cio').val(bh);
  });
  $('.mkl').val(bh);
</script>


<script>
  $(document).ready(function() {
    $('#c-id').on('change', function() {
      var id = $('#c-id').val();
      $.ajax({
        type: 'POST',
        url: '<?php echo ADMIN_URL; ?>ClasstimeTabs/find_subject',
        data: {
          'id': id
        },
        success: function(data) {
          $('#s-id').empty();
          $('#s-id').html(data);
        },
      });
    });
  });
</script>