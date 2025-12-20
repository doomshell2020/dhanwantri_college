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
      <i class="fa fa-money"></i> Today Absent Report 
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL;?>report/cancelledrecipiet">Manage Absent Report </a></li>
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
   <!-- /.box-header -->
   <?php echo $this->Flash->render(); ?>
</div>
<div id="updt">
<div class="table-responsive">
<table id="" class="table table-bordered table-striped">
   <tbody>
      <tr>
         <td><a id="" style="position: absolute;
            top: 0px;
            /* right: 0px; */
            right: 46px;" class="btn btn-info btn-sm pull-right"  href="<?php echo ADMIN_URL ;?>report/absentstudents/<? echo $class_id; ?>/<? echo $section_id; ?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Excel</a></td>
      </tr>
      <tr>
         <th>S.No</th>
         <th>Sch.No</th>
         <th>Student Name</th>
         <th>Class</th>
         <th>Section</th>
         <th>Father's Name</th>
         <th>Mobile</th>
      </tr>
      <?php 
         $page = $this->request->params['paging']['Services']['page'];
         $limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
         $counter ='1';
         $total=0;
         $totalfee=0;
         $out=0;
         $total_discount=0;
          $session = $this->request->session();
          $session->delete($attendenceentry); 
          $session->write('attendenceentry',$attendenceentry); 
         
         if(isset($attendenceentry) && !empty($attendenceentry)){ 
         
         
         foreach($attendenceentry as $key=>$element) {
         
         
         $s_id=$element['student']['class_id'];
         $c_id=$element['student']['section_id'];
         if($element['status']=="A"){
         ?>
      <tr <? if($element['status_m']=="P" && $element['status']=="A"){  ?>style="color:red;" <? } ?>>
         <td><?php echo $counter++;  ?></td>
         <td><?php echo $element['student']['enroll'];  ?></td>
         <td><?php   $studentname= $element['student']['fname']." ".$element['student']['middlename']." ".$element['student']['lname']; echo $studentname; ?></td>
         <td><?php $class=$this->Comman->findclasses($s_id);
            echo $class[0]['title'];
            ?>    </td>
         <td><?php 
            $section=$this->Comman->findsections($c_id);
               echo $section[0]['title'];
            ?>    </td>
         <td><?php echo $element['student']['fathername'];?></td>
         <td><?php echo $element['student']['sms_mobile'];?></td>
      </tr>
      <?php } }
         }else if(isset($attendenceentry2) && !empty($attendenceentry2)){ 
         
         
         foreach($attendenceentry2 as $key=>$element) {
         
         
         	 $s_id=$element['class_id'];
         	 $c_id=$element['section_id'];
         	
         ?>
      <tr>
         <td><?php echo $counter++;  ?></td>
         <td><?php echo $element['enroll'];  ?></td>
         <td><?php   $studentname= $element['fname']." ".$element['middlename']." ".$element['lname']; echo $studentname; ?></td>
         <td><?php $class=$this->Comman->findclasses($s_id);
            echo $class[0]['title'];
            ?>    </td>
         <td><?php 
            $section=$this->Comman->findsections($c_id);
               echo $section[0]['title'];
            ?>    </td>
         <td><?php echo $element['fathername'];?></td>
         <td><?php echo $element['sms_mobile'];?></td>
      </tr>
      <?php  }
         } else { ?>
      <tr>
         <td colspan="8" style="text-align:center;">No Absent Data Available</td>
      </tr>
      <?	} ?>
</table>
<div>
<div>