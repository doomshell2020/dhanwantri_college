<!-- Content Wrapper. Contains page content -->
<style>
   .checkbox input[type="checkbox"] {
   opacity: 1;
   }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <i class="fa fa-money"></i> Today Absent Report
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>report/cancelledrecipiet">Manage Absent Report </a></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
   <div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
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
   <script inline="1">
      $(document).ready(function() {
        $("#YourbuttonId").click(function() {
          if ($('input[type=checkbox]:checked').length == 0) {
            alert('Please select atleast one checkbox');
          }
        });
      });
      
      //<![CDATA[
      $(document).ready(function() {
        $("#feesexl").bind("submit", function(event) {
          $.ajax({
            async: true,
            data: $("#feesexl").serialize(),
            dataType: "html",
            type: "POST",
            url: "<?php echo ADMIN_URL; ?>students/searchabsent",
            success: function(data) {
              $("#updt").html(data);
            },
          });
          return false;
        });
      });
      //]]>
   </script>
   <?php echo $this->Form->create('Fees', array('type' => 'file', 'inputDefaults' => array('div' => false, 'label' => false), 'id' => 'feesexl', 'class' => 'form-horizontal')); ?>
   <div class="form-group">
      <input type="hidden" name="acedmicyear" value="<? echo $acedmic; ?>">
      <div class="col-sm-2">
         <label for="inputEmail3" class="control-label">Sr. No.</label>
         <?php echo $this->Form->input('enroll', array('class' => 'form-control', 'id' => '', 'placeholder' => 'Sr.No.', 'label' => false)); ?>
      </div>
      <div class="col-sm-3">
         <label for="inputEmail3" class="control-label">Student Name</label>
         <?php echo $this->Form->input('fname', array('class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Student First Name', 'label' => false)); ?>
      </div>
      <div class="col-sm-3">
         <label for="inputEmail3" class="control-label">Father Name</label>
         <?php echo $this->Form->input('fathername', array('class' => 'form-control', 'id' => '', 'placeholder' => 'Enter Father Name', 'label' => false)); ?>
      </div>
      <div class="col-sm-2">
         <label for="inputEmail3" class="control-label">Select Class</label>
         <?php echo $this->Form->input('class_id', array('class' => 'form-control', 'id' => '', 'type' => 'select', 'empty' => 'Select Class', 'options' => $classes, 'label' => false)); ?>
      </div>
      <div class="col-sm-2">
         <label for="inputEmail3" class="control-label">Select Section</label>
         <?php echo $this->Form->input('section_id', array('class' => 'form-control', 'id' => '', 'type' => 'select', 'empty' => 'Select Section', 'options' => $sectionslist, 'label' => false)); ?>
      </div>
   </div>
   <div class="form-group">
      <input type="submit" style="background-color:#00c0ef;width:100px !important; margin-left: 10px;" class="btn btn4 btn_pdf myscl-btn date" value="Submit">
      <button type="reset" style="background-color:#f4f4f4;width:100px !important; margin-left: 10px;" class="btn btn4 btn_pdf myscl-btn date">Reset</button>
   </div>
   <?php
      echo $this->Form->end();
      ?>
   <!-- /.box-header -->
   <?php echo $this->Flash->render(); ?>
</div>
<div id="updt">
</div>