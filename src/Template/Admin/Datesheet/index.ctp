<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <section class="content-header">
    <h1>
    View DateSheet 
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards/"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="#">View DateSheet</a></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <!-- /.box-header -->

          <div class="box-body">
            <?php echo $this->Form->create($album, array('class' => 'form-horizontal', 'controller' => 'Datesheet', 'action' => 'add', 'onsubmit' => 'return ValidateExtension(this);', 'enctype' => 'multipart/form-data')); ?>

            <div class="form-group">
              <div class="col-sm-2">
                <label>Select Class<span>
                    <font color="red"> *</font>
                  </span></label>

                <?php echo $this->Form->input('class_id', array('class' => 'form-control', 'type' => 'select', 'options' => $class_id, 'empty' => '--Select Class--', 'id' => 'title', 'label' => false, 'required')); ?>
              </div>

              <div class="col-sm-2">
                <label>Name<span>
                    <font color="red"> *</font>
                  </span></label>
                <?php echo $this->Form->input('title', array('class' => 'form-control', 'placeholder' => 'Enter Sheet Name', 'type' => 'text', 'id' => 'title', 'label' => false, 'required')); ?>
              </div>

              <div class="col-sm-2">
                <label>Select DateSheet<span>
                    <font color="red"> *</font>
                  </span></label>
                <?php echo $this->Form->input('sheet_name', array('class' => 'form-control file', 'id' => 'imagename', 'type' => 'file', 'label' => false, 'required')); ?>
              </div>

              <div class="col-sm-2">
                <label>Start Date<span>
                    <font color="red"> *</font>
                  </span></label>
                <?php echo $this->Form->input('start_date', array('class' => 'form-control file', 'id' => 'datepicker1', 'type' => 'text', 'label' => false, 'required')); ?>
              </div>

              <div class="col-sm-2"><label>End Date<span>
                    <font color="red"> *</font>
                  </span></label>
                <?php echo $this->Form->input('end_date', array('class' => 'form-control file', 'id' => 'datepicker2', 'type' => 'text', 'label' => false, 'required')); ?>
              </div>

              <script>
                $(document).ready(function () {
                  $('#datepicker1').datepicker({
                    dateFormat: 'yy-mm-dd',
                    onSelect: function (date) {
                      var selectedDate = new Date(date);
                      var endDate = new Date(selectedDate);
                      endDate.setDate(endDate.getDate());
                      $("#datepicker2").datepicker("option", "minDate", endDate);
                      $("#datepicker2").val(date);
                    }
                  });
                  $('#datepicker1').datepicker('setDate', 'today');
                  $('#datepicker2').datepicker({
                    dateFormat: 'yy-mm-dd'
                  });
                  $('#datepicker2').datepicker('setDate', 'today');
                });
              </script>
              <div class="col-sm-2"  style="margin-top: 25px;">
                <button type="submit" style="" class="btn btn-success">Add</button>
                <button type="reset" style="" class="btn btn-primary">Reset</button>
              </div>

            </div>
            <?php echo $this->Form->end(); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div>
          <?php echo $this->Flash->render(); ?>
        </div>
        <div class="box">
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Class </th>
                  <th>Title</th>
                  <th>DateSheet</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php $counter = 1;
                if (count($sheet_det) > 0) { //pr($events); ?>
                  <?php foreach ($sheet_det as $key => $value) { ?>
                    <tr>
                      <td><?php echo $counter; ?></td>
                      <td><?php $class_id = explode(',', $value['class_id']);
                      foreach ($class_id as $id) {
                        $class = $this->Comman->showclasstitle($id);
                        echo $class['title']; ?> <br>
                        <?php }
                      ?>
                      </td>
                      <td> <?php echo ucfirst($value['title']); ?></td>
                      <td>
                        <?php $db = $this->request->session()->read('Auth.User.db'); ?>
                        <?php $filename = IMAGE_URL . 'img/' . $value['sheet_name'];
                        $file_headers = @get_headers($filename);

                        if ($file_headers && strpos($file_headers[0], '200 OK')) { ?>
                          <a target="_blank" href="<?php echo SITE_URL; ?>img/<?php echo $filename; ?>">View attachment</a>
                        <?php } else { ?>
                          <a target="_blank" href="<?php echo SITE_URL; ?>img/<?php echo $value['sheet_name']; ?>">View
                            attachment</a> <?php } ?>
                      </td>

                      <td><?php echo date('d-m-Y', strtotime($value['start_date'])); ?></td>
                      <td><?php echo date('d-m-Y', strtotime($value['end_date'])); ?></td>
                      <td><a href="<?php echo ADMIN_URL ?>datesheet/delete/<?php echo $value['id']; ?>" class="fa fa-trash"
                          style="font-size: 16px !important; color: red;"
                          onClick="javascript: return confirm('Are you sure you want to delete this?')"></a>

                        <a href="<?php echo ADMIN_URL ?>datesheet/edit/<?php echo $value['id']; ?>" class="fas fa-edit"
                          style="font-size: 16px !important;"></a>
                      </td>
                    </tr>

                    <?php $counter++;
                  } ?>
                <?php } else { ?>
                  <tr>
                    <td colspan="7" align="center">No Data Available</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        </div>

      </div>

    </div>
  </section>
  <!-- /.content -->
</div>
<script>
  $(function () {
    $("#imagename").change(function () {
      var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.pdf|.doc|.docx)$/;
      if (regex.test($(this).val().toLowerCase())) {
        return true;
      } else {
        $('#imagename').val('');
        alert("Please upload pdf/doc/docx files.");
      }
    });
  });
</script>