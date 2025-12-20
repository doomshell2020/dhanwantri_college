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
      <i class="fa fa-money"></i> Without ID CARD Today Report 
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL;?>students/absentwithoutcard">Without ID Today Report </a></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
<span class="description">
<?  $cio=0;
   if(isset($studentrfidsd) && !empty($studentrfidsd)){ 
   
   foreach($studentrfidsd as $element) {
   if($element['class_id']){
   $cio++;
   } } }
   ?>
<strong>Date </strong> : <?php echo date('d-m-Y'); ?> &nbsp;&nbsp;&nbsp;   | &nbsp;&nbsp;&nbsp;  <strong>Total </strong> : <? echo $cio; ?> </span>
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
      $(document).ready(function(){
      $("#YourbuttonId").click(function(){
          if($('input[type=checkbox]:checked').length == 0)
          {
              alert('Please select atleast one checkbox');
          }
      });	
      });		  
      				  
      //<![CDATA[
      $(document).ready(function () {
        $("#feesexl").bind("submit", function (event) {
          $.ajax({
            async:true,
            data:$("#feesexl").serialize(),
            dataType:"html", 
            type:"POST", 
           url:"<?php echo ADMIN_URL ;?>students/searchabsent",
            success:function (data) {   
              $("#updt").html(data); }, 
        });
          return false;
      });});
      //]]>
   </script>         
   <!-- /.box-header -->
   <?php echo $this->Flash->render(); ?>
</div>
<div id="updt">
<div class="table-responsive">
<table id="" class="table table-bordered table-striped">
   <tbody>
      <tr>
         <? if($classs2){ ?>
         <td><a id="" style="position: absolute;
            top: 0px;
            /* right: 0px; */
            right: 46px;" class="btn btn-info btn-sm pull-right"  href="<?php echo 
               ADMIN_URL ;?>report/absentwithoutcardreport/<?php echo 
               $studentrfidsd[0]['class_id'];?>/<?php echo 
               $studentrfidsd[0]['section_id'];?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Excel</a></td>
         <? }else{ ?>
         <td><a id="" style="position: absolute;
            top: 0px;
            /* right: 0px; */
            right: 46px;" class="btn btn-info btn-sm pull-right"  href="<?php echo 
               ADMIN_URL ;?>report/absentwithoutcardreport"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Excel</a></td>
         <? } ?>
      </tr>
      <tr>
         <th>No</th>
         <th>Sr.No</th>
         <th>Student Name</th>
         <th>Class</th>
         <th>Section</th>
         <th>Father's Name</th>
         <th>Mobile</th>
      </tr>
      <?php 
         $page = $this->request->params['paging']['Services']['page'];
         $limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
         $counter = 1;
         $total=0;
         $totalfee=0;
         $out=0;
         $total_discount=0;
         if(isset($studentrfidsd) && !empty($studentrfidsd)){ 
         
         foreach($studentrfidsd as $element) {
         if($element['class_id']){
         $s_id=$element['class_id'];
         $c_id=$element['section_id'];
         ?>
      <tr>
         <td><?php echo $counter;  ?></td>
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
      <?php $counter++;}}
         } else { ?>
      <td colspan="8" style="text-align:center;">No Present Data Available</td>
      <?	} ?>
</table>
<div>      
</div>