<script>
  $(document).ready(function () {

    $("#TaskAdminCustomerForm").bind("submit", function (event) {

      $.ajax({

        async: true,

        type: "GET",

        url: "<?php echo ADMIN_URL; ?>report/documentsearch",

        data: $("#TaskAdminCustomerForm").serialize(),

        dataType: "html",
        beforeSend: function () {
          // setting a timeout
          $('#load2').css("display", "block");
        },
        success: function (data) {
          $("#example2").html(data);
        }, complete: function () {
          $('#load2').css("display", "none");
        },

      });

      return false;

    });

  });
  $(document).on('click', '.pagination a', function (e) {
    var target = $(this).attr('href');
    var res = target.replace("/report/documentsearch", "/report/document");
    window.location = res;
    return false;
  });
</script>
<style>
  #load2 {
    width: 100%;
    height: 100%;
    position: fixed;
    z-index: 9999;
    background-color: white !important;
    background: url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0, 0, 0, 0.75)
  }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Students Document Report
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>students/index">Manage Student</a></li>
      <li><a href="#" class="active">Document Report</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div id="load2" style="display:none;"></div>
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <i class="fa fa-search" aria-hidden="true"></i>
            <h3 class="box-title">Search Category</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="manag-stu">
              <?php echo $this->Form->create('Task', array('url' => array('controller' => 'students', 'action' => 'search'), 'type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'TaskAdminCustomerForm', 'class' => 'form-horizontal')); ?>
              <div class="form-group margin_btmcol">
                <div class="col-sm-4 col-xs-12">
                  <label>Document Category</label>
                  <select class="form-control" name="document_id">
                    <option value=""> Select Category </option>
                    <?php foreach ($documentcategory as $er => $e1) { ?>
                      <option value="<?php echo $er; ?>"><?php echo $e1; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-sm-4 col-xs-12">
                  <label>SR No.</label>
                  <?php echo $this->Form->input(
                    'enroll',
                    array(
                      'class' => 'form-control',
                      'type' => 'text',
                      'placeholder' => 'SR NO.',
                      'id' => 'hol_id',
                      'label' => false
                    )
                  );
                  ?>
                </div>
                <div class="col-sm-4 col-xs-12 text-xs-center" style="top: 24px;">
                  <label>&nbsp;</label>
                  <button type="submit" class="btn btn-success">Search</button>
                  <!-- <button type="reset" class="btn btn-primary">Reset</button> -->
                  <a class="btn btn-info " style="color:#ffffff !important; background-color: #8B0000; !important"
                    href="<?php echo SITE_URL; ?>admin/report/document"><b>Reset</i></b></a>
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
      <div class="col-xs-12">
        <div class="box">
          <!-- /.box-header -->
          <?php echo $this->Flash->render(); ?>
          <div style="text-align:right"><a id="" style="margin-right: 15px; margin-top: 10px;"
              class="btn btn-info btn-sm" href="<?php echo ADMIN_URL; ?>report/documentexcel"><i
                class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a></div>
          <div class="box-body">
            <div id="example2" class="table-responsive">
              <table class="table table-bordered table-striped">
                <!--
                        <tr>
                        <td><a id="" style="position: absolute;
                        top: -163px;
                        /* right: 0px; */
                        right: 46px;" class="btn btn-info btn-sm pull-right" target="_blank" href="<?php echo ADMIN_URL; ?>report/smsdeliverdreports"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Excel</a></td>
                        </tr>
                        -->
                <thead>
                  <tr>
                    <th width="3%"># </th>
                    <th width="4%">S.No.</th>
                    <th width="12%">Student Name</th>
                    <th width="12%">Fathers Name</th>
                    <th width="9%">Class/Year</th>
                    <!-- <th width="4%">Section</th> -->
                    <th width="32%">Category</th>
                    <th width="12%">Document Detail</th>
                    <th width="8%">Submitted Date</th>
                    <th width="6%">Download</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $page = $this->request->params['paging']['Documents']['page'];
                  $limit = $this->request->params['paging']['Documents']['perPage'];
                  $counter = ($page * $limit) - $limit + 1;

                  if (isset($students) && !empty($students)) {
                    foreach ($students as $work) {//pr($work);
                      if ($work['student']['fname']) {
                        ?>
                        <tr>
                          <td><?php echo $counter; ?></td>
                          <td><?php echo $work['student']['enroll']; ?></td>
                          <td>
                            <?php echo $work['student']['fname'] . ' ' . $work['student']['middlename'] . ' ' . $work['student']['lname']; ?>
                          </td>
                          <td><?php echo $work['student']['fathername']; ?></td>
                          <td>
                            <?php $classname = $this->Comman->findclass123($work['student']['class_id']);
                            $sectionname = $this->Comman->findsection123($work['student']['section_id']);
                            echo $classname['title'] . '/' . $sectionname['title']; ?>
                          </td>
                          <!-- <td>
                            <?php $sectionname = $this->Comman->findsection123($work['student']['section_id']);
                            echo $sectionname['title']; ?>
                          </td> -->
                          <td><?php echo $work['documentcategory']['categoryname']; ?></td>
                          <td><?php echo $work['description']; ?></td>
                          <td><?php echo date('d-m-Y', strtotime($work['created'])); ?></td>
                          <td><?php if (isset($value['photo'])) { ?><a download="Document.<?php echo $work['ext']; ?>"
                                href="<?php echo SITE_URL; ?>webroot/img/<?php echo $work['photo']; ?>"
                                class="btn btn-default btn-sm" target="_blank"><i class="fa fa-download"
                                  aria-hidden="true"></i></a> <?php } else {
                            echo "N\A";
                          } ?><br>
                          </td>
                        </tr>
                        <?php $counter++;
                      }
                    }
                  } else { ?>
                    <tr>
                      <td colspan="10" style="text-align:center;"><b>NO Dosument Added Yet</b></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <?php echo $this->element('admin/pagination'); ?>
            </div>
          </div>
          <!-- /.box-body    -->
        </div>
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
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
<div class="modal" id="globalModals" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true"
  style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
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
  $(document).ready(function () {

    $(".global").click(function (event) {
      //load content from href of link
      $('.modal-content').load($(this).attr("href"));
    });

  });

</script>