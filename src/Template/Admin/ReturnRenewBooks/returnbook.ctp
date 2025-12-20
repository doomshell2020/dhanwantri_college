<div class="modal-header">
  <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
  <h4>
    <i class="fa fa-hand-o-left"></i> Return Book
  </h4>
</div>
<?php echo $this->Form->create($do, array('class' => 'form-horizontal')); ?>
<div class="modal-body">
  <div class="row">
    <div class="col-sm-12">
      <div class="form-group">
        <div class="col-sm-6">
          <label>Book Name</label> :- <?php echo $bname; ?>
        </div>
        <div class="col-sm-6">
          <label style="float:right;">Issued date :- <?php echo $dat; ?></label>
        </div>
      </div>


      <div class="form-group">
        <div class="col-sm-3">
          <label>Fine Type<span style="color:red;">*</span></label>
        </div>
        <div class="col-sm-3">
          <?php if ($did == '2') {
            $fine_type = array('Over due' => 'Over due', 'Book lost' => 'Book lost', 'No Fine' => 'No Fine');
          } else {
            $fine_type = array('Book lost' => 'Book lost', 'No Fine' => 'No Fine');
          } ?>
          <?php echo $this->Form->input('fine_type', array(
            'class' => 'form-control fine_type', 'type' => 'select', 'empty' => 'Select Fine Type',
            'options' => $fine_type, 'value' => 'No Fine', 'label' => false, 'required' => required
          )); ?>
          <input type="hidden" name="asn" value="<?php echo $asnn; ?>">
        </div>
        <div class="char" style="display:none;">
          <div class="col-sm-3">
            <label style="float: right;">Amount:-</label>
          </div>
          <div class="col-sm-3">
            <?php echo $this->Form->input('amount', array('class' => 'form-control amount', 'label' => false)); ?>
          </div>
        </div>
      </div>
      <div class="form-group ren">
        <div class="col-sm-3">
          <label>
            <input id="renew_status" name="checkbox" value="1" type="checkbox"> Is Renewed
          </label>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-3">
          <label>
            Submission Date
          </label>
        </div>
        <div class="col-sm-3">
          <?php echo $this->Form->input('sub_date', array(
            'class' => 'form-control datepick1 ', 'placeholder' => 'Issue Date', 'value' => '', 'label' => false,
            'required'
          )); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(".datepick1").val($.datepicker.formatDate("dd/mm/yy", new Date()));
  $('.datepick1').datepicker({
    minDate: '+0',

  }).attr("readonly", "readonly");
</script>
<script type="text/javascript">
  $('.fine_type').on('change', function() {

    var fine = $(this).val();
    var asn = '<?php echo $asnn2; ?>';
    if (fine != 'No Fine') {
      if (fine == 'Book lost') {
        $(".ren").hide();
      } else {
        $(".ren").show();
      }



      if (fine != '' && asn != '') {
        $.ajax({
          type: 'POST',
          url: '<?php echo ADMIN_URL; ?>ReturnRenewBooks/calculateFine',
          data: {
            'fine_type': fine,
            'asn_no': asn
          },

          success: function(data) {
            if (data != '0') {
              $(".amount").val(data);
              $(".char").show();
            } else {
              $(".char").hide();
              $(".amount").val("");
            }
          }

        });
      } else {
        $(".amount").val('');
      }
    } else {
      $(".char").hide();
      $(".ren").show();
    }
  });
</script>


<div class="modal-footer">
  <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
  <div class="returnBook" style="display: block;">
    <button type="submit" class="btn btn-info pull-left" name="return" value="return_book">Return Book</button>
  </div>

  <div id="renewBook" style="display: none;">
    <button type="submit" class="btn btn-success pull-left">Renew Book</button>
  </div>

</div>

<?php echo $this->Form->end(); ?>

<script type="text/javascript">
  var a = $('#renew_status').is(':checked');
  $('#renewBook').hide();
  if (a == true) {
    $('#renewBook').show();
    $('.returnBook').css('display', 'none');
  }

  $('#renew_status').change(function() {
    $('#renewBook').toggle();
    $('.returnBook').toggle();
  });
</script>