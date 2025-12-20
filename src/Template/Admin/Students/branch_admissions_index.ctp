<div class="content-wrapper" style="min-height: 410px;">
  <section class="content-header">
    <h1>
      Branches Admission Data
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo SITE_URL; ?>admin/dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo SITE_URL; ?>admin/students/branch_admissions_index">Branches Admission Data</a></li>
    </ol>
  </section>
  <!-- content header -->
  <style>
    #testUL {
      position: relative;
    }

    #testUL ul {
      position: absolute;
      z-index: 999;
      overflow: scroll;
      height: 100px;
      top: 100%;
      left: 0px;
      right: 0px;
      list-style-type: none;
      background-color: white;
      padding-left: 0px;
    }

    #testUL ul li {
      padding: 5px 8px;
      border: 1px solid lightgray;
    }

    #testUL ul li a {
      color: black;
    }

    .preview {
      margin-right: 15px;
    }
  </style>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">

            <script inline="1">
              $(document).ready(function() {
                $("#mysubscription").bind("submit", function(event) {
                  $.ajax({
                    async: true,
                    data: $("#mysubscription").serialize(),
                    dataType: "html",
                    type: "POST",
                    url: "<?php echo ADMIN_URL; ?>students/search_admission_data",
                    beforeSend: function() {},
                    success: function(data) {
                      $("#updt").html(data);
                    },
                    complete: function(data) {},
                  });
                  return false;
                });
              });
            </script>

            <?php echo $this->Form->create('Fees', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'mysubscription', 'class' => 'form-horizontal', 'style' => 'margin-bottom:0px;  display: flex;align-items: flex-end;')); ?>


            <div class="col-sm-3">
              <script>
                $(document).ready(function() {
                  $('#fdatefrom').datepicker({
                    dateFormat: 'dd-mm-yy',
                    yearRange: '2018:2030',
                    changeMonth: true,
                    changeYear: true,

                  });
                  $('#fendfrom').datepicker({
                    dateFormat: 'dd-mm-yy'
                  });
                });
              </script>
              <label for="inputEmail3" class="control-label">Date From <strong style="color:red;">*</strong></label>
              <?php echo $this->Form->input('datefrom', array('class' => 'form-control', 'id' => 'fdatefrom', 'readonly', 'placeholder' => 'Date From', 'label' => false,'required')); ?>
            </div>

            <div class="col-sm-3">
              <label for="inputEmail3" class="control-label">Date To <strong style="color:red;">*</strong></label>
              <?php echo $this->Form->input('dateto', array('class' => 'form-control', 'id' => 'fendfrom', 'readonly', 'placeholder' => 'Date To', 'label' => false,'required')); ?>
            </div>

            <div class="col-sm-3">

              <label for="inputEmail3" class="control-label">Branch Name</label>
              <select name="branch_name" class="form-control" style="width:200px">
                <option value="">Select Branch Name</option>
                <?php

                foreach ($branch as $key => $value) {
                  $values = explode('_', $value);
                ?>
                  <option value="<?php echo $value; ?>"><?php echo ucfirst($values[1]); ?></option>
                <?php  } ?>
              </select>
            </div>
            <div class="col-sm-3 " style="display:flex;align-items:center;">
              <label for="inputEmail3" class="control-label"></label>
              <input type="submit" style="background-color:#00c0ef; color:#fff;width:100px !important; margin-top: 0px;" id="Mysubscriptions" class="btn btn4 btn_pdf myscl-btn date" value="Search">

              <a style="margin-left:10px;" href="<?php echo SITE_URL; ?>admin/students/branch_admissions">
                <i class="fa fa-file-excel-o " style="font-size: 28px; color:red;"></i>
              </a>

            </div>
          </div>
          <?php echo $this->Form->end(); ?>
        </div>

        <div class="box-body" id="example2">
          <table id="" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>S.No</th>
                <th>Enroll No</th>
                <th>Student Name</th>
                <th>Father Mobile</th>
                <th>Mother Mobile</th>
                <th>Admission Date</th>
                <th>Class</th>
                <th>Section</th>
                <th>Father Name</th>
                <th>Mother Name</th>
                <th>Branch Name</th>

              </tr>
            </thead>
            <tbody id="updt">

            </tbody>
          </table>
        </div>

        <!-- /.box-body -->
      </div>
    </div>
</div>
</section>
<!-- /.content -->
</div>