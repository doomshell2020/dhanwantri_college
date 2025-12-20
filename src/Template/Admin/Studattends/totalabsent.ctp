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
      <i class="fa fa-money"></i> <?php echo $acedmic; ?> Today Absent Summary </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL; ?>studattends/totalabsent/">Today Absent Report </a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">


      </div>


      <!-- /.box-header -->
      <?php echo $this->Flash->render(); ?>
    </div>
    <div id="updt">
      <div class="table-responsive">
        <table id="" class="table table-bordered table-striped">
          <tbody>
   
            <tr>
              <th>S.No</th>
              <th>Academic Year</th>
              <th>Scholar No</th>
              <th>Pupil's Name</th>
              <th>Father's Name</th>
              <th>Class</th>
              <th>Section</th>
                <th> Mobile</th>
              <th>Father Mobile</th>
              <th>Mother Mobile</th>
      



            </tr>

            <?php
$page = $this->request->params['paging']['Services']['page'];
$limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
$counter = '1';
$total = 0;
$totalfee = 0;
$out = 0;
$total_discount = 0;

if (isset($absentoday) && !empty($absentoday)) {
    
    foreach ($absentoday as $keys => $element) {
        //pr($element); die;

        $s_id = $elements['class_id'];

        ?>
            <tr>
              <td><?php echo $counter++; ?></td>
              <td><?php echo $element['student']['acedmicyear']; ?></td>
              <td><?php echo $element['student']['enroll']; ?></td>

              <td><?php echo $element['student']['fname'] . ' ' . $element['student']['middlename'] . ' ' . $element['student']['lname']; ?></td>
              <td><?php echo $element['student']['fee_submittedby']; ?></td>
              <td><?php 
        echo $element['class']['title'];?></td>
     <td><?php 
        echo $element['section']['title'];?></td>
        
              <td><?php echo $element['student']['sms_mobile']; ?></td>
              <td><?php echo $element['student']['f_phone']; ?></td>
              <td><?php echo $element['student']['m_phone']; ?></td>
              




            </tr>
            <?php }
}else { ?>
            <tr>
              <td colspan="10" style="text-align:center;color:red;"><b>No Summary Data Available For
                  selected Date</b></td>
            </tr>
            <? } ?>

        </table>

        <div>
          <div>
