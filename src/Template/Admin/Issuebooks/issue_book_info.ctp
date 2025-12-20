<head>
  <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
  <style>
    /* IE 6 doesn't support max-height
	   * we use height instead, but this forces the menu to always be this tall
	   */
    * html .ui-autocomplete {
      height: 100px;
    }

    .modal {
      width: 852px !important;
    }

    .modal .modal-dialog {
      width: 840px !important;
    }

    .modal-open .modal {
      overflow-y: hidden !important;
    }
  </style>

</head>

<div class="modal-header">
  <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
  <h4 class="modal-title">
    <i class="fa fa-plus-square"></i> Issue Book
  </h4>
</div>

<?php echo $this->Form->create($issuebook, array('url' => array('controller' => 'Issuebooks', 'action' => 'issue'), 'class' => 'form-horizontal'));
if (isset($request_id)) {
  echo $this->Form->input('request_id', array('type' => 'hidden', 'value' => $request_id));
}
?>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-12">
      <?php if (!empty($book)) { ?>
        <div class="form-group">
          <?php if ($book['periodic_category_id'] != '0' && $book['book_category_id'] == '0') { ?>
            <div class="col-sm-6">
              <label>Periodical Name:</label> <?php echo ucfirst($book['name']); ?>
            </div>
            <div class="col-sm-6">
              <label>Periodical Category:</label> <?php echo ucfirst($book['periodical_master']['name']); ?>
            </div>
          <?php }
          if ($book['periodic_category_id'] == '0' && $book['book_category_id'] != '0') { ?>
            <div class="col-sm-6">
              <label>Book Name:</label> <?php echo ucfirst($book['name']); ?>
            </div>

            <div class="col-sm-6">
              <label>Book Category:</label> <?php echo ucfirst($book['book_category']['name']); ?>
            </div>
          <?php } ?>
        </div>

        <div class="form-group">
          <?php if ($book['periodic_category_id'] != '0' && $book['book_category_id'] == '0') { ?>
            <div class="col-sm-6">
              <label>Author:</label> <?php echo ucfirst($book['periodical_master']['author']); ?>
            </div>

            <div class="col-sm-6">
              <label>Publisher:</label> <?php echo ucfirst($book['periodical_master']['publisher']); ?>
            </div>
          <?php }
          if ($book['periodic_category_id'] == '0' && $book['book_category_id'] != '0') { ?>
            <div class="col-sm-6">
              <label>Author:</label> <?php echo ucfirst($book['author']); ?>
            </div>

            <div class="col-sm-6">
              <label>Publisher:</label> <?php echo ucfirst($book['publisher']); ?>
            </div>
          <?php } ?>
        </div>

        <div class="form-group">

          <div class="col-sm-6">
            <label>Type<span>
                <font color="red"> *</font>
              </span></label>
            <?php
            if (isset($student)) {
              echo $this->Form->input('holder_type_id', array(
                'class' => 'form-control', 'type' => 'text',
                'label' => false, 'required', 'value' => 'Student', 'readonly'
              ));
            } else {
              echo $this->Form->input('holder_type_id', array(
                'class' => 'form-control', 'type' => 'select',
                'options' => $holder_type, 'label' => false, 'required', 'empty' => 'Select Type'
              ));
            }
            ?>
          </div>
          <?php
          if (isset($student)) {
            if (!empty($student['middlename'])) {
              $stuName = $student['enroll'] . '-' . $student['fname'] . ' ' . $student['middlename'] . ' ' . $student['lname'] . '-' . $student['class']['title'] . '-' . $student['section']['title'] . '(' . $student['board']['name'] . ')';
            } else {
              $stuName = $student['enroll'] . '-' . $student['fname'] . ' ' . $student['lname'] . '-' . $student['class']['title'] . '-' . $student['section']['title'] . '(' . $student['board']['name'] . ')';
            }
          } ?>
          <div class="col-sm-6">
            <label>Name<span>
                <font color="red"> *</font>
              </span></label>
            <?php if (isset($student)) {
              echo $this->Form->input('holder_name', array('class' => 'form-control', 'placeholder' => 'Enter Name/ID', 'type' => 'text', 'label' => false, 'required', 'value' => $stuName, 'readonly'));
            } else {
              echo $this->Form->input('holder_name', array('class' => 'form-control', 'placeholder' => 'Enter Name/ID', 'id' => 'njk', 'label' => false, 'required'));
            } ?>
          </div>
        </div>
        <div class="col-sm-12 hjk" style="display: none;">
        </div>
        <div class="form-group">

          <div class="col-sm-6 datepc1">
            <label>Issue Date<span>
                <font color="red"> *</font>
              </span></label>
            <?php echo $this->Form->input('d1', array(
              'class' => 'form-control ', 'placeholder' => 'Issue Date', 'id' => 'datepick1', 'value' => '', 'label' => false,
              'required'
            )); ?>
          </div>

          <div class="col-sm-6 datepc2">
            <label>Due Date<span>
                <font color="red"> *</font>
              </span></label>
            <?php echo $this->Form->input('d2', array('class' => 'form-control ', 'placeholder' => 'Due Date', 'id' => 'datepick2', 'label' => false, 'required')); ?>
          </div>

        </div>

        <?php echo $this->Form->input('asn_no', array('type' => 'hidden', 'value' => $book['accsnno'], 'class' => 'form-control', 'label' => false)); ?>
        <?php echo $this->Form->input('asn_no2', array('type' => 'hidden', 'id' => 'nko', 'value' => $book['asn_no'], 'class' => 'form-control', 'label' => false)); ?>

        <script>
          $('#issue-button').show();
        </script>

      <?php } else { ?>
        <div class="form-group">
          <div class="col-sm-12">
            <?php echo '<p style="color: red;">Book not found!</p>' ?>
          </div>

          <script>
            $('#issue-button').hide();
          </script>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
</div>
<div class="modal-footer">
  <?php
  echo $this->Form->submit(
    'Issue Book',
    array('id' => 'issue-button', 'class' => 'btn btn-info pull-left', 'style' => 'margin-right: 10px; display:none;', 'title' => 'Issue Book', 'disabled' => 'disabled')
  );
  ?>
  <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
</div>

<?php echo $this->Form->end(); ?>
<script>
  $('form').submit(function() {


    $(this).find(':submit').attr('disabled', 'disabled');
  });
</script>

<script>
  $("#datepick1").val($.datepicker.formatDate("dd/mm/yy", new Date()));
  var min = new Date(); // Selected date or today if none
  var max = new Date(min.getTime());
  max.setDate(max.getDate() + 7);
  var dd = max.getDate();
  var mm = (max.getMonth() + 1).toString();
  var yyyy = max.getFullYear().toString();
  var finaldate = dd + '/' + mm + '/' + yyyy;
  $("#datepick2").val(finaldate);

  $.datepicker.setDefaults({
    dateFormat: 'dd/mm/yy'
  });
  $('#datepick1').datepicker({
    minDate: '+0',
    onSelect: function(dateStr) {
      var min = $(this).datepicker('getDate') || new Date(); // Selected date or today if none
      var max = new Date(min.getTime());
      max.setMonth(max.getMonth() + 60); // Add one month
      $('#datepick2').datepicker('option', {
        minDate: min,
        maxDate: max
      });
    },
  }).attr("readonly", "readonly");
  $('#datepick2').datepicker({
    minDate: '+0',
    maxDate: '+1m',
    autoclose: true,
    onSelect: function(dateStr) {
      var max = $(this).datepicker('getDate'); // Selected date or null if none
      $('#datepick1').datepicker('option', {
        maxDate: max
      });
    },
  }).attr("readonly", "readonly");


  //---------------------------------------------------

  $('#holder-type-id').on('change', function() {

    $("#njk").val('');
    $('#njk').prop('disabled', true);
    var h_type = $('#holder-type-id').val();
    $.ajax({
      type: 'POST',
      url: '<?php echo ADMIN_URL; ?>Issuebooks/autocompleteList',
      data: {
        'h_type': h_type
      },
      dataType: "json",
      success: function(data) {
        $('#njk').prop('disabled', false);
        $("#njk").autocomplete({
          source: data,
          select: function(event, ui) {
            var val = $('.ui-state-focus').html();
            if (h_type != 'Employee') {
              $.ajax({
                type: 'POST',
                url: '<?php echo ADMIN_URL; ?>Issuebooks/studentissue',
                data: {
                  'hold': val
                },
                dataType: "html",
                success: function(issdu) {
                  if (issdu != 0) {
                    $('.hjk').html(issdu);
                    $('.hjk').show();
                    $('#issue-button').prop('disabled', true);
                  }
                }
              });
            }
            $('#issue-button').prop('disabled', false);
            exists = $.inArray(val, data);

            if (exists < 0) {
              $(this).val("");

              $('#issue-button').prop('disabled', true);
              return false;
            }
          }
        });
      },
    });
  });
  $("#njk").keyup(function() {
    $('#issue-button').prop('disabled', true);
    $('.hjk').html("");
    $('.hjk').hide();
  });
</script>

<style>
  .datepc1 .datepc2 .ui-datepicker {
    position: fixed;
    top: 348.98px;
    z-index: 1051;
    display: none;
    left: 0px;
  }
</style>
<?php if (isset($student)) { ?>
  <script>
    $('#issue-button').prop('disabled', false);
  </script>
<?php } ?>