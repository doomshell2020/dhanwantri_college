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
      <i class="fa fa-money"></i> Today Prospectus Summary 
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL;?>report/admitstudentcollection">Office Summary Report </a></li>
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
         <th>Form No</th>
         <th>Receipt No</th>
         <th>Pupil's Name</th>
         <th>Father's Name</th>
         <th>Class</th>
         <th>Board</th>
         <th>Mobile</th>
         <th>Purchase Date</th>
      </tr>
      <?php 
         $page = $this->request->params['paging']['Services']['page'];
         $limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
         $counter ='1';
         $total=0;
         $totalfee=0;
         $out=0;
         $total_discount=0;
         
         
         if(isset($prospectussummary) && !empty($prospectussummary)){ 
         
         
         foreach($prospectussummary as $keys=>$element) {
         
         
         $s_id=$elements['class_id'];
         
         
         ?>
      <tr>
         <td><?php echo $counter++;  ?></td>
         <td><?php echo $element['acedmicyear'];  ?></td>
         <td><?php echo $element['formno'];  ?></td>
         <td><?php echo $element['recipietno'];  ?></td>
         <td><?php echo $element['s_name'];  ?></td>
         <td><?php echo $element['fee_submittedby'];  ?></td>
         <td><?php $classs=$this->Comman->findclass($element['class_id']); echo $classs['title'];  ?></td>
         <td><?php if($element['mode1_id']=='1'){  echo "CBSE"; }else{   echo "INTERNATIONAL"; } ?></td>
         <td><?php echo $element['mobile'];  ?></td>
         <td><?php echo date('d-m-Y',strtotime($element['created']));  ?></td>
      </tr>
      <?php  }
         } else { ?>
      <tr>
         <td colspan="10" style="text-align:center;color:red;"><b>No Prospectus Summary Data Available For Today</b></td>
      </tr>
      <?	} ?>
</table>
<div>
<div>