<!-- Content Wrapper. Contains page content -->
<style>
   .checkbox input[type="checkbox"]{
   opacity:1;
   }
   #sel_date{
   z-index:99999,
   opacity:1,
   }
   #load2{
   width:100%;
   height:100%;
   position:fixed;
   z-index:9999;
   background-color: white  !important;
   background:url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0,0,0,0.75)
   }
   .content{
   min-height:0px !important;
   }
</style>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
   <h3>
      Class Attendence Report
   </h3>
   <ol class="breadcrumb">
      <li><a href="<?php echo ADMIN_URL;?>students/classidcardreport"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="<?php echo ADMIN_URL;?>students/classidcardreport">Manage Strength Report </a></li>
   </ol>
   <div id="load2" style="display:none;"></div>
</section>
<!-- Main content -->
<div class="content" style="padding-top:20px;padding-bottom:20px">
   <div class="box" style="margin-bottom:0px;">
      <div class="box-body">
         <form method="post" id="attn_date">
            <div class="row">
               <div class="col-sm-3"><label>Date:</label><input type="text" id="sel_date" name="date" value="<?php echo date('d-m-Y');?>" class="form-control"> </div>
            </div>
            <div class="row" style="margin-top:10px">
               <div class="col-sm-3"> 
                  <input type="submit" class="btn btn-info" value="submit">
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<script>
   $( function() {
   	$( "#sel_date" ).datepicker({dateFormat: 'dd-mm-yy', maxDate: "0" });
   } );
</script>
<section class="content" id="updt">
<span class="description">
   <?   if($this->request->session()->read('Auth.User.role_id')== ADMIN){ if(isset($classess) && !empty($classess)){ 
      $findstudentrfidclassss=0;
      $findstudentwithrfidclassss=0;
      $findstudentamountcnt=0;
      
      
      	foreach($classess as $element) {
      	
      	$s_id=$element['class_id'];
      		$c_id=$element['section_id'];
      	$findstudentrfidclassss +=$this->Comman->findstudentrfidclass($element['class_id'],$element['section_id']);
      
      	$findstudentwithrfidclassss +=$this->Comman->findstudentcrfidclass($element['class_id'],$element['section_id']);
      	
      	$findstudentamountcnt +=$this->Comman->findstudentcountclass($element['class_id'],$element['section_id']);
      
      	
      	$findstudenttotlaclasss=$this->Comman->presentclasstodayreport($element['class_id'],$element['section_id']);
      				$cbntsf=0; foreach($findstudenttotlaclasss as $hs=>$js){
      			$cbntsf++;
      			
      			}  
      			
      			$coundtpresenttoday +=$cbntsf;
      					
      	
      	}
      	
      
      
      	$cbntsfs=0; 
      	
      	} ?>
   <ul class="list-inline">
      <p>
         <strong>Total Students </strong> : <?php echo 
            $findstudentamountcnt; ?> 
      </p>
      <li>
         <strong>With Id Card </strong> : <? 
            echo $findstudentwithrfidclassss; ?>   
      </li>
      <li><strong>Making Id Card </strong> : 
         <a target="_blank" href="<? echo ADMIN_URL; 
            ?>students/makingidcardreport"><? echo $findstudentrfidclassss; ?></a> 
</span>
</li>
<li>  <strong>Total Present Today 
</strong> : <a target="_blank" href="<? echo ADMIN_URL; 
   ?>students/presentreport"><? echo $countpresenttoday; 
   ?></a>   <? } else{  
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
   			
   
   		
   
   }
   
   
   }  ?>
</li>
<li>
<strong>Total Students </strong> : <?php echo 
   $studentcnt; ?> &nbsp;&nbsp;&nbsp; <!--- | 
   &nbsp;&nbsp;&nbsp;  <strong>Total Absent Today 
   </strong> : <a target="_blank" id="tabsent2" href="<? echo ADMIN_URL; 
      ?>students/searchabsentshow/<? echo $e; ?>,<? echo $rd; ?>"><? echo "Loading.......";
      ?></a> -->
<?  } 
   ?></span> </li>
</ul>
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
         $findstudenttotlaclassdds=$this->Comman->classtotalstudent($element['class_id'],$element['section_id']);
         if($findstudenttotlaclassdds==0){
         continue;
         }
         
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
            echo $findstudenttotlaclassdds; ?></td>
         <td> <? 
            $findstudenttotlacslasssabsent=$this->Comman->absentclasstodayreportss23($element['class_id'],$element['section_id']);
            $classstodayreportss23=$this->Comman->classtodayreportss23($element['class_id'],$element['section_id']);
            
            
            $classstotalstudent=$findstudenttotlaclassdds;
            
            
            
            if($classstodayreportss23){
            
            if($findstudenttotlacslasssabsent !='0'){
            		?><a  target="_blank" href="<?php echo SITE_URL;?>admin/students/searchabsent/<?php echo $element['class_id']; ?>/<?php echo $element['section_id']; ?>"> <?  $total_absent +=$findstudenttotlacslasssabsent; echo $findstudenttotlacslasssabsent; ?></a> <? }else{
            echo $findstudenttotlacslasssabsent;
            
            
            
            } } else{
            
            
            
            
            
            foreach($presentclasstodayreportsdf as $f){
            $rtyys++; 
            
            } 
            $rtss=$classstotalstudent-$rtyys;
            $total_absent +=$rtss; */
            ?><strong title="RFID COUNT" style="color:red;"><? echo $findstudenttotlaclassdds; ?></strong> </a> <?
            }   ?></a></td>
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
<div>      </div>
<script>
   $(document).ready(function() {
   	$("#attn_date").bind("submit", function (event) {
   	$.ajax({
   		async: true,
   		data: $("#attn_date").serialize(),
   		dataType: "html",
   		type: "POST",
   beforeSend: function() {
   		// setting a timeout
   		$('#load2').css("display", "block");
   	},
   
   		url: "<?php echo ADMIN_URL; ?>students/classidcard_search",
   		success: function(data) {
   		//  alert(data);
   		$('#load2').css("display", "none");
   		$("#updt").html(data);
   		},
   
   
   	});
   	return false;
   
   });
   });
</script>