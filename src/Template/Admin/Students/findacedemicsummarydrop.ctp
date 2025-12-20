<!-- Content Wrapper. Contains page content -->
<style>
   .checkbox input[type="checkbox"]{
   opacity:1;
   }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <i class="fa fa-money"></i> <?php echo $acedmic; ?>  Drop Out Admission Student Detail Summary 
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>report/admitstudent"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL;?>report/admitstudent">Admission Summary </a></li>
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
         <th>Admission Date</th>
         <th>Admission Year</th>
         <th>Academic Year</th>
         <th>Scholar No</th>
         <th>Pupil's Name</th>
         <th>Father's Name</th>
         <th>Class</th>
         <th>Board</th>
         <th> Mobile</th>
      </tr>
      <?php 
         $page = $this->request->params['paging']['Services']['page'];
         $limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
         $counter =1;
         $total=0;
         $totalfee=0;
         $out=0;
         $total_discount=0;
         
         
         if(isset($registrationsummary) && !empty($registrationsummary)){ 
         //pr($registrationsummary); die;
         
         foreach($registrationsummary as $keys=>$element) {
         
         
         
         
         ?>
      <tr>
         <td><?php echo $counter++;  ?></td>
         <td><?php if($element['created']!=''){  echo date('d-m-Y',strtotime($element['created'])); }else{  echo "N/A"; }  ?></td>
         <td><?php echo $element['admissionyear'];  ?></td>
         <td><?php echo $element['acedmicyear'];  ?></td>
         <td><?php echo $element['enroll'];  ?></td>
         <td><?php echo $element['fname'].' '.$element['middlename'].' '.$element['lname'];
            if($element['oldenroll']!=0 || $element['category']=="Migration"){ echo "<span style='color: red;'>(Migr.)*</span>";  } ?></td>
         <td><?php echo $element['fee_submittedby'];  ?></td>
         <td><?php $classs=$this->Comman->findclass($element['class_id']); echo $classs['title'];  ?></td>
         <td><?php if($element['board_id']=='1'){  echo "CBSE"; }else{  echo "INTERNATIONAL"; } ?></td>
         <td><?php if($element['sms_mobile']!=''){ echo $element['sms_mobile'];  }else{  echo "N/A"; } ?></td>
         <?php } ?>
      </tr>
      <?php  
         }
         if (empty($registrationsummary)) { ?>
      <tr>
         <td colspan="10" style="text-align:center;color:red;"><b>No Admission Summary Data Available For selected Date</b></td>
      </tr>
      <?	} ?>
</table>
<div>
<div>