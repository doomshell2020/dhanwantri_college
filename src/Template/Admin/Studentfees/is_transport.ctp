<div class="modal-header" style="height: 65px; background:#2d95e3;">
  <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
  <h4 class="modal-title" style="margin:0px !important;">
    <i class="fa fa-plus-square"></i>
    <?php if (isset($student_data['location_id'])) {
      echo 'Edit Transport';
    } else {
      echo 'Add Transport';
    } ?>
  </h4>
</div>
<?php echo $this->Form->create($student_data, array('url' => array('controller' => 'studentfees', 'action' => 'is_transport'), 'class' => '', 'id' => 'sevice_form', 'enctype' => 'multipart/form-data', 'validate', 'autocomplete' => 'off')); ?>
<div class="modal-body transport">
  <div class="row">
    <!-- <div class="row"> -->
    <?php $loc_selected = $student_data['location_id'];
          $bus_selected = $student_data['bus_number'];
    ?>
    
    <div class="col-sm-6 align-self-center fields" style="margin-bottom: 15px;">
      <?php echo $this->Form->input('location', array('class' => 'form-control location', 'required', 'empty' => '---Select Locations--- ', 'options' => $locations, 'label' => false ,'value'=> $loc_selected)); ?>
    </div>

    <div class="col-sm-6 align-self-center fields" style="margin-bottom: 15px;">

      <?php echo $this->Form->input('busid', array('class' => 'form-control busid', 'required', 'empty' => '---Select Bus---', 'options' => $route, 'label' => false ,'value'=> $bus_selected)); ?>

    </div>

    <div class="col-sm-12" style="margin-bottom: 15px;">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <td>Quater(I)</td>
              <td>Quater(II)</td>
              <td>Quater(III)</td>
              <td>Quater(IV)</td>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td><input type="text" class="form-control" id="quarter1" readonly/></td>
              <td><input type="text" class="form-control" id="quarter2" readonly/></td>
              <td><input type="text" class="form-control" id="quarter3" readonly/></td>
              <td><input type="text" class="form-control" id="quarter4" readonly/></td>
            </tr>
          </tbody>
        </table>
    </div>

    <div class="col-sm-12" id="enquiryexist" style="display:none" style="margin-bottom: 15px;"> </div>

    <div class="col-sm-12" style="margin-bottom: 15px;">
      <input type="hidden" name="academic_year" id="academic_year" value="<? echo $academic_year; ?>">
      <input type="hidden" name="student_id" id="student_id" value="<? echo $sid; ?>">
    </div>
  </div>
</div>
<br>
<!--./modal-body-->
<div class="modal-footer">

  <button data-dismiss="modal" class="btn btn-default pull-left fields" type="button" style="margin-left: 32px;">Close</button>
  <?php
  if (isset($student_data['id'])) {
    echo $this->Form->submit(
      'Update',
      array('class' => 'btn btn-default pull-right fields', 'style' => '', 'title' => 'Update', 'style' => 'margin-right:31px')
    );
  } else {
    echo $this->Form->submit(
      'Add',
      array('class' => 'btn btn-default pull-right fields', 'style' => '', 'title' => 'Add', 'style' => 'margin-right:31px')
    );
  }
  ?>

  <?php
  echo $this->Form->submit(
    'Restore',
    array('class' => 'btn btn-info pull-right restore', 'title' => 'Restore', 'style' => 'display:none;')
  );
  ?>
</div>
<!--./modal-footer-->
</form>


<script>
  $(document).ready(function() {
    
    var id = $('#location').val();
    var session = $('#academic_year').val();

    $('#location').on('change', function() {
    
      var id = $('#location').val();
      var session = $('#academic_year').val();
      // alert(session)


      // find all location 
      $.ajax({
        type: 'POST',
        url: '<?php echo ADMIN_URL; ?>studentfees/find_bus',
        data: {
          'id': id,
          'session': session
        },
        success: function(data) {
          $('#busid').empty();
          $('#busid').html(data);
        }

      });
      // end


      // find location wise fee 
      $.ajax({
        type: 'POST',
        url: '<?php echo ADMIN_URL; ?>studentfees/find_fees',
        data: {
          'id': id,
          'session': session
        },
        success: function(data) {

          var alldata = JSON.parse(data);

          // for fees 
          var trans_fees1 = document.getElementById("quarter1");
          var trans_fees2 = document.getElementById('quarter2');
          var trans_fees3 = document.getElementById('quarter3');
          var trans_fees4 = document.getElementById('quarter4');
          $('#quarter1').empty();
          trans_fees1.value = alldata.quarter1;
          $('#quarter2').empty();
          trans_fees2.value = alldata.quarter2;
          $('#quarter3').empty();
          trans_fees3.value = alldata.quarter3;
          $('#quarter4').empty();
          trans_fees4.value = alldata.quarter4;


        }

      });
      // end 

    });
    $.ajax({
        type: 'POST',
        url: '<?php echo ADMIN_URL; ?>studentfees/find_fees',
        data: {
          'id': id,
          'session': session
        },
        success: function(data) {

          var alldata = JSON.parse(data);

          // for fees 
          var trans_fees1 = document.getElementById("quarter1");
          var trans_fees2 = document.getElementById('quarter2');
          var trans_fees3 = document.getElementById('quarter3');
          var trans_fees4 = document.getElementById('quarter4');
          $('#quarter1').empty();
          trans_fees1.value = alldata.quarter1;
          $('#quarter2').empty();
          trans_fees2.value = alldata.quarter2;
          $('#quarter3').empty();
          trans_fees3.value = alldata.quarter3;
          $('#quarter4').empty();
          trans_fees4.value = alldata.quarter4;


        }

      });
  });
</script>