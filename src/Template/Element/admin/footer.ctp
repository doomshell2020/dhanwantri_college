<footer class="main-footer">


  <strong>Copyrightsa &copy; <?php echo date('Y'); ?>-<?php echo date('Y') + 1; ?> <a href="#" style="color:#3c8dbc">Dhanwantri</a> </strong> All rights
  reserved.
</footer>



</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    // Use event delegation for dynamically added elements
    $(document).on('click', '.delete-button', function(event) {

      event.preventDefault(); // Prevent default button action

      const key = $(this).data('key');
      const subject = $(this).data('subject');
      const button = $(this);
      // alert(key)
      // alert(subject)

      if (confirm('Are you sure you want to delete this exam?')) {
        // Perform AJAX request
        $.ajax({
          type: 'POST',
          url: '<?php echo ADMIN_URL; ?>exam/deletebacklog',
          data: {
            'key': key,
            'subject': subject
          },

          success: function(data) {
            // alert("Deleted")
            button.closest('tr').remove();
          },

        });
      }
    });
  });
</script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>



<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->


<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>


<!-- Sparkline -->
<?= $this->Html->script('admin/jquery.sparkline.min.js') ?>

<!-- jvectormap -->
<?= $this->Html->script('admin/jquery-jvectormap-1.2.2.min.js') ?>
<?= $this->Html->script('admin/jquery-jvectormap-world-mill-en.js') ?>

<!-- jQuery Knob Chart -->
<?= $this->Html->script('admin/jquery.knob.js') ?>

<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<?= $this->Html->script('admin/daterangepicker.js') ?>

<!-- datepicker -->
<?= $this->Html->script('admin/bootstrap-datepicker.js') ?>

<!-- Bootstrap WYSIHTML5 -->
<?= $this->Html->script('admin/bootstrap3-wysihtml5.all.min.js') ?>

<!-- Slimscroll -->
<?= $this->Html->script('admin/jquery.slimscroll.min.js') ?>

<!-- FastClick -->
<?= $this->Html->script('admin/fastclick.js') ?>
<?= $this->Html->script('admin/jquery.dataTables.min.js') ?>
<?= $this->Html->script('admin/dataTables.bootstrap.min.js') ?>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<!-- Commented the following line 60 and used the line 61 following it instead -->
<!-- <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
<?php echo $this->Html->css('admin/jquery-ui.css'); ?>

<script>
  $(function() {
    $("#example1").DataTable();
    $("#example").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });

    $('#example14').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false
    });
  });
</script>
<script>
  $(document).ready(function() {

    $('#emp_att').DataTable({

      "paging": false,
      "ordering": false,
      "ordering": true,
      "info": false

    });

  });
</script>
<!-- Select2 -->


<?= $this->Html->css('select2/select2.min.css') ?>

<?= $this->Html->script('select2/select2.full.min.js') ?>

<!-- input date -->
<?= $this->Html->script('input-mask/jquery.inputmask.js') ?>
<?= $this->Html->script('input-mask/jquery.inputmask.date.extensions.js') ?>
<?= $this->Html->script('input-mask/jquery.inputmask.extensions.js') ?>
<script>
  $('#datepicksd123').datepicker();
</script>

<script>
  $('#dp1').datepicker();
  $('#dp2').datepicker();
  // To use in EmployeeAttendance/index.ctp
  $('#dp3').datepicker({

    dateFormat: 'dd-mm-yy',
    minDate: 0,
    maxDate: 0

  }).datepicker("setDate", new Date());

  // To use in EmployeeAttendance/manage.ctp
  $('#dp4').datepicker({

    dateFormat: 'dd-mm-yy'

  }).datepicker("setDate", new Date());
</script>

<script>
  $(function() {
    //Initialize Select2 Elements
    $(".select2").select2();
    //Datemask dd/mm/yyyy
    var date = new Date();

    tenYearBefore = new Date().setYear(new Date().getFullYear() - 6);

    $('#datepick').datepicker({
      "changeMonth": true,
      'maxDate': '0',
      "yearRange": "1976:2018",
      "changeYear": true,
      "autoSize": true
    }).on('change', function() {

      today = new Date();
      eighteenYearBefore = new Date().setYear(new Date().getFullYear() - 18);
      selecteds = new Date($('#datepick').val());

      if (selecteds > eighteenYearBefore) {
        $('#datepick').val('')
        $(".display_errors").show();
      } else {
        $(".display_errors").hide();
      }
    });

    $('#datepick1').datepicker({
      dateFormat: 'dd/mm/yy',
      "changeMonth": true,
      minDate: '-21Y',
      maxDate: '-1Y',
      "changeYear": true,
      "autoSize": true
    }).on('change', function() {
      today = new Date();
      tenYearBefore = new Date().setYear(new Date().getFullYear() - 3);
      selected = new Date($('#datepick1').val());

    });
    $('#joindate').datepicker({
      "changeMonth": true,
      "changeYear": true,
      "autoSize": true,
      "dateFormat": "dd-mm-yy"
    });
    $('#datepicks').datepicker({
      "beforeShowDay": function(date) {
        return [date.getDay() == 1, ""]
      },

      "changeMonth": true,
      'maxDate': '0',
      "changeYear": true,
      "autoSize": true,
      "dateFormat": "dd-mm-yy"
    });
    // $("[data-mask]").inputmask();
  });
</script>


<!-- AdminLTE App -->
<?= $this->Html->script('admin/app.min.js') ?>

<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<? //= $this->Html->script('admin/dashboard.js') 
?>



<!-- AdminLTE for demo purposes -->
<?= $this->Html->script('admin/demo.js') ?>
<?= $this->Html->script('confirmation.js') ?>
<? //= $this->Html->script('admin/morris.min.js') 
?>


</body>

</html>