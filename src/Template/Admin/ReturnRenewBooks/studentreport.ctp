<?php
$session = $this->request->session();
?>
<style>
  .ui-autocomplete {
    max-height: 100px;
    overflow-y: auto;
    /* prevent horizontal scrollbar */
    overflow-x: hidden;
  }

  /* IE 6 doesn't support max-height
     * we use height instead, but this forces the menu to always be this tall
     */
  * html .ui-autocomplete {
    height: 100px;
  }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <section class="content-header">
    <h1>
      Issued Book Manager
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>ReturnRenewBooks/studentreport">Issued Book Manager </a></li>
    </ol>
  </section>



  <!-- Main content -->
  <section class="content">

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div>
            <?php echo $this->Flash->render(); ?>
          </div>
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-eye"></i> View Issuer/Borrower</h3>
          </div>
          <!-- /.box-header -->

          <script>
            $(document).ready(function() {
              $('#hol_id').on('change', function() {
                $("#klo").val('');
                var h_type = $('#hol_id').val();
                $.ajax({
                  type: 'POST',
                  url: '<?php echo ADMIN_URL; ?>Issuebooks/autocompleteList',
                  data: {
                    'h_type': h_type
                  },
                  dataType: "json",
                  success: function(data) {
                    $("#klo").autocomplete({
                      source: data,
                      change: function(event, ui) {
                        val = $(this).val();
                        exists = $.inArray(val, data);
                        if (exists < 0) {
                          $(this).val("");
                          return false;
                        }
                      }
                    });
                  },
                });
              });

              var h_type = $('#hol_id').val();
              $.ajax({
                type: 'POST',
                url: '<?php echo ADMIN_URL; ?>Issuebooks/autocompleteList',
                data: {
                  'h_type': h_type
                },
                dataType: "json",
                success: function(data) {
                  $("#klo").autocomplete({
                    source: data,
                    change: function(event, ui) {
                      val = $(this).val();
                      exists = $.inArray(val, data);
                      if (exists < 0) {
                        $(this).val("");
                        return false;
                      }
                    }
                  });
                },
              });
            });
          </script>




          <div class="box-body">
            <div class="manag-stu">
              <?php echo $this->Form->create($fine, array('class' => 'form-horizontal', 'id' => 'TaskAdminCustomerForm')); ?>
              <div class="form-group">
                <div class="col-sm-4">
                  <label>Holder Type</label>
                  <?php
                  echo $this->Form->input('holder_type_id', array(
                    'class' => 'form-control fine-amnt', 'type' => 'select', 'id' => 'hol_id', 'empty' => 'Select Holder Type',
                    'options' => $holder_type, 'value' => 'Student', 'label' => false
                  ));
                  ?>
                </div>

                <div class="col-sm-4">
                  <label>Holder Name</label>
                  <?php echo $this->Form->input('holder_name', array('class' => 'form-control fine-amnt', 'placeholder' => 'Enter Name/ID', 'id' => 'klo', 'label' => false)); ?>
                </div>

                <div class="col-sm-4" style="margin-top: 25px;">
                  <label></label>
                  <?php
                  echo '<button type="submit" class="btn btn-success">Search</button> ';
                  echo '<button type="reset" class="btn btn-primary">Reset</button>';
                  ?>
                </div>
              </div>
              <?php echo $this->Form->end(); ?>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box" style="display: none;" id="appear-box">
                <div class="box-body">
                  <table id="" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>S.No</th>
                        <th>Acc. No.</th>
                        <th>Book Name</th>
                        <th>ISBN No.</th>
                        <th>Holder Name</th>
                        <th>Class - Section</th>
                        <th>Holder Type</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Deposite Date</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="srch-rslt">
                    </tbody>
                  </table>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
  </section>
  <!-- /.content -->
</div>


<!-- /.content-wrapper -->


<div class="modal" id="globalModaler" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content testeingprogress">
      <div class="modal-body">
        <div class="loader">
          <div class="es-spinner">
            <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {

    $("#TaskAdminCustomerForm").bind("submit", function(event) {
      event.preventDefault();
      $.ajax({
        async: false,
        type: "POST",
        url: "<?php echo ADMIN_URL; ?>ReturnRenewBooks/studentreportsearch",
        data: $("#TaskAdminCustomerForm").serialize(),
        dataType: "html",
        success: function(data) {
          $("#srch-rslt").html(data);
          $("#appear-box").show();
        }
      });
    });

  });
</script>

<script>
  $(document).ready(function() {
    //prepare the dialog
    //respond to click event on anything with 'overlay' class
    $(".global1").click(function(event) {
      alert("hello");
      //load content from href of link
      $('.modal-content').load($(this).attr("href"));
    });
  });
</script>


<script>
  $(document).ready(function() {
    //prepare the dialog
    //respond to click event on anything with 'overlay' class
    $(".global2").click(function(event) {
      //load content from href of link
      $('.testeingprogress').load($(this).attr("href"));
    });
  });
</script>