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
      <i class="fa fa-money"></i> Class Attendence Report 
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>students/classidcardreport"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL;?>students/classidcardreport">Manage Strength Report </a></li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
<span class="description">
<?  if($this->request->session()->read('Auth.User.role_id')== ADMIN ){ if(isset($classess) && !empty($classess)){ 
   $findstudentrfidclassss=0;
   $findstudentwithrfidclassss=0;
   $findstudentamountcnt=0;
   
   
   	foreach($classess as $element) {
   	
   	$s_id=$element['class_id'];
   		 $c_id=$element['section_id'];
   	 $findstudentrfidclassss +=$this->Comman->findstudentrfidclass($element['class_id'],$element['section_id']);
   	  $findstudentrfidclasssskk =$this->Comman->findstudentrfidclass($element['class_id'],$element['section_id']);
   	  $findstudentwithrfidclassss +=$this->Comman->findstudentcrfidclass($element['class_id'],$element['section_id']);
   	  
   	  $findstudentamountcnt +=$this->Comman->findstudentcountclass($element['class_id'],$element['section_id']);
   	  
   	  $findstudentamounthk +=$this->Comman->findstudentcountclass($element['class_id'],$element['section_id']);
   	  
   	  $findstudenttotlaclasss=$this->Comman->presentclasstodayreport($element['class_id'],$element['section_id']);
                  $cbntsf=0; foreach($findstudenttotlaclasss as $hs=>$js){
   			  $cbntsf++;
   			  
   			  }  
   			  
   			   $coundtpresenttoday +=$cbntsf;
   			    
   	  
   	}
   	
   	$findstudenttotlaclasss=$this->Comman->presentalltodayreport();
   
   	$cbntsfs=0; foreach($findstudenttotlaclasss as $hs=>$js){
   			  $cbntsfs++;
   			  
   			  }
   			  
   			  	$countpresenttoday=$cbntsfs;
   			  	
   			
   			         $afcuts =$findstudentwithrfidclassss-$cbntsfs;
   	
   	} ?>
<strong>Total Students </strong> : <?php echo 
   $findstudentamountcnt; ?> &nbsp;&nbsp;&nbsp; | 
&nbsp;&nbsp;&nbsp;  <strong>With Id Card </strong> : <? 
   echo $findstudentwithrfidclassss; ?>   | 
&nbsp;&nbsp;&nbsp;  <strong>Making Id Card </strong> : 
<a target="_blank" href="<? echo ADMIN_URL; 
   ?>students/makingidcardreport"><? echo $findstudentrfidclassss; ?></a> </span>  | 
&nbsp;&nbsp;&nbsp;  <strong>Without ID Card Today 
</strong> :  <a  target="_blank" href="<?php echo SITE_URL;?>admin/students/absentwithoutcard"><? echo $afcuts; ?></a> </span>  | 
&nbsp;&nbsp;&nbsp;  <strong>Total Present Today 
</strong> : <a target="_blank" href="<? echo ADMIN_URL; 
   ?>students/presentreport"><? echo $countpresenttoday; 
   ?></a>   <? }else{ 
   if(isset($classess) && !empty($classess)){ 
   
   
   $findstudentrfidclassss=0;
   $findstudentwithrfidclassss=0;
   $findstudentamountcnt=0;
   $c1=0;
   
   $errt=array();
   $errst=array();
   foreach($classess as $element) {
   
   $s_id=$element['class_id'];
   $c_id=$element['section_id'];
   			
   
   $findstudentwithrfidclassss +=$this->Comman->findstudentcrfidclass($element['class_id'],$element['section_id']);
   
   
   $classstodayrepsortss23=$this->Comman->classtodayreportss23($element['class_id'],$element['section_id']);
    if($classstodayrepsortss23){
   
    }else{
     
   $errt[]=$element['class_id'];
   $errst[]=$element['section_id'];
    }
    
   
   }
   
   $findstudenttotlaclasss=$this->Comman->presentalltodayreport();
   
   $cbntsfs=0; foreach($findstudenttotlaclasss as $hs=>$js){
     $cbntsfs++;
     
     }
     
     	$countpresenttoday=$cbntsfs;
     	
   
            $afcuts =$findstudentwithrfidclassss-$cbntsfs;
   
   }  $e= base64_encode(implode(',',$errt));   $rd= base64_encode(implode(',',$errst));  ?>
<strong>Total Students </strong> : <?php echo 
   $studentcnt; ?> &nbsp;&nbsp;&nbsp; | 
<strong>Without ID Card Today 
</strong> :  <a  target="_blank" href="<?php echo SITE_URL;?>admin/students/absentwithoutcard"><? echo $afcuts; ?></a> </span>  | 
&nbsp;&nbsp;&nbsp;  <strong>Total Absent Today 
</strong> : <a target="_blank" id="tabsent2" href="<? echo ADMIN_URL; 
   ?>students/searchabsentshow/<? echo $e; ?>,<? echo $rd; ?>"><? echo "Loading.......";
   ?></a> 
<? } ?></span>
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
         <th>S.No</th>
         <th>Class</th>
         <th>Section</th>
         <th>Class Teacher</th>
         <th>Mobile No.</th>
         <th>Strength</th>
         <th> Absent Today </th>
      </tr>
      <?php 
         $page = $this->request->params['paging']['Services']['page'];
         $limit = $this->request->params['pagc_c_iding']['Services']['perPage'];
         $counter = 1;
         $total=0;
         $totalfee=0;
         $out=0;
         $total_discount=0;
         $total_absent=0;
         
         $session = $this->request->session();
                  $session->delete($classess); 
                 $session->write('classess',$classess); 
         if(isset($classess) && !empty($classess)){ 
         $findstudentamount=0;
         $findstudentrfidclass=0;
         
         
         foreach($classess as $element) {
         
         if($element['class_id']){
         
         
         $s_id=$element['class_id'];
         $c_id=$element['section_id'];
         ?>
      <tr>
         <td><?php echo $counter;  ?></td>
         <td><?php $class=$this->Comman->findclasses($s_id);
            echo $class[0]['title'];
            ?>    </td>
         <td><?php 
            echo $element['Sections']['title'];
            ?>    </td>
         <td><?php 
            $ss=$this->Comman->findclassteachersorginal($element['class_id'],$element['section_id']);
            $studentname= ucwords(strtolower($ss['employee']['fname']." ".$ss['employee']['middlename']." ".$ss['employee']['lname'])); echo $studentname;
            ?>    </td>
         <td><?php  echo $ss['employee']['mobile'];?>    </td>
         <?php $findstudentamount=$this->Comman->findstudentcountclass($element['class_id'],$element['section_id']);  ?>
         <td> <? 
            $findstudenttotlaclassdds=$this->Comman->classtotalstudent($element['class_id'],$element['section_id']);
            
            
               echo $findstudenttotlaclassdds; ?></td>
         <td> <?
            $findstudenttotlacslasssabsent=$this->Comman->absentclasstodayreportss23($element['class_id'],$element['section_id']);
            $classstodayreportss23=$this->Comman->classtodayreportss23($element['class_id'],$element['section_id']);
            $presentclasstodayreportsdf=$this->Comman->presentclasstodayreport($element['class_id'],$element['section_id']);
            
             $classstotalstudent=$this->Comman->classtotalstudent($element['class_id'],$element['section_id']);
            $findstudenttotlacslasss=$this->Comman->presentclasstodayreportss24($element['class_id'],$element['section_id']);
            
            
            if($classstodayreportss23){
            
            if($findstudenttotlacslasssabsent !='0'){
                      ?><a  target="_blank" href="<?php echo SITE_URL;?>admin/students/searchabsent/<?php echo $element['class_id']; ?>/<?php echo $element['section_id']; ?>"> <?  $total_absent +=$findstudenttotlacslasssabsent; echo $findstudenttotlacslasssabsent; ?></a> <? }else{
            echo $findstudenttotlacslasssabsent;
            
            
            
            } }else{
            
            
            
            ?><a  target="_blank" href="<?php echo SITE_URL;?>admin/students/searchabsent/<?php echo $element['class_id']; ?>/<?php echo $element['section_id']; ?>"> <? 
            $rtyys=0;
            
            foreach($presentclasstodayreportsdf as $f){
            $rtyys++; 
            
            } 
             $rtss=$classstotalstudent-$rtyys;
             $total_absent +=$rtss;
            ?><strong title="RFID COUNT" style="color:red;"><? echo $rtss;?></strong> </a> <?
            } ?></a></td>
      </tr>
      <?php $counter++;}}
         } else { ?>
      <td colspan="8" style="text-align:center;">No Present Data Available</td>
      <?	} ?>
</table>
<span id="tabsent" style="display:none;"><? echo $total_absent; ?></span>
<script>
   $(document).ready(function(){ 
   
   var tabse=$("#tabsent").text();
   $("#tabsent2").html(tabse);
   
   });
   
   
</script>
<div>      
</div>