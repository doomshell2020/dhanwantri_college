
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
      <h1>  <i class="fa fa-upload" aria-hidden="true"></i>
       Upload Scholastic Areas Result 
       
      </h1>
           <ol class="breadcrumb">
    <li><a href="<?php echo ADMIN_URL;?>studentexamresult/examcontrolviewsubject"><i class="fa fa-home"></i>Home</a></li>

        </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    <div class="row"  >
        <div class="col-xs-12">
          
  <div class="box" >
            <div class="box-header">
            
<script>
$( document ).ready(function() {
$('tbody tr').each(function(){

 
    $('td',this).each(function(){
		
if ( $(this).find("a").hasClass("current") ) {

    // $(this).closest('tr').css('background-color','#ADD8E6');;
}
    });

   

});
});

</script>
 <?  if($this->Flash->render()){  ?>
          <div id="salert">
         <div class="alert alert-success alert-dismissible" >
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        Exam Result Genrated Sucessfully !!    </div>
           </div>
         <? } ?>

            </div>
      <div class="row">
		  
		  
       <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
       
            <!-- /.box-header -->
            <!-- form start -->
                   <div class="box-body">
          <div class="box-body" >
          
         

                    <table id="example1" class="table table-bordered table-striped" >
                
  
 <thead>
    <tr>
      <th>#</th>
      
     <th>Class</th>
    
<th>Exam</th>

<th>Type</th>
<th>Absentees</th>
<th>Last Upload Date</th>

<th>Subject-Upload</th>
</tr>
 </thead>
                <tbody id="example2">
   
	<?php $classess=array_unique($classess);
	
	
	 $classsectionsid=array_unique($classsectionsid);
	 

		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		
		asort($classsectionsid);

		if(isset($examtypei) && !empty($examtypei)){ 
		
		

		foreach($classsectionsid as $d=>$h){
			
			
	
			
		 $classnme=$this->Comman->findclassesdescrt($h); 
							 
			
					 
                       
	
$findexamwitclass=$this->Comman->findsubjectwithclass($h);



		
//pr($classnme);
		foreach($classnme as $work){
			$rt=array();
			
			foreach($findexamwitclass as $j=>$kk){
						if(($work['Classes']['id']=="11" || $work['Classes']['id']=="10") && ($kk['Subjects']['name']=="Biology" || $kk['Subjects']['name']=="Chemistry" || $kk['Subjects']['name']=="Physics" || $kk['Subjects']['name']=="Science")){
						
						$rt[]="Science";
						
					}else if(($work['Classes']['id']=="11" || $work['Classes']['id']=="10") && ($kk['Subjects']['name']=="Geography" || $kk['Subjects']['name']=="History" || $kk['Subjects']['name']=="Civics" || $kk['Subjects']['name']=="Social Science")){
						
					
						
						
						$rt[] = str_replace(' ', '', "Social Science");
						
					}else{
						
						$rt[] = str_replace(' ', '', $kk['Subjects']['name']);
					}
					}
		

			
					$findexamwitsclass=$this->Comman->findexamwithsubject($work['Classes']['id'],$rt[0]);		
					//pr($findexamwitsclass);
				$findexamwitsclass='1';	
					if($findexamwitsclass){
			
			$findexamwitclass=$this->Comman->findexamwithclass($work['Classes']['id']);

			 foreach($findexamwitclass as $key){
				
		?>
                <tr>
               <td><?php echo $counter; ?></td>
   
     <?php if($work['Classes']['id']=='18' || $work['Classes']['id']=='19' || $work['Classes']['id']=='1' || $work['Classes']['id']=='2' || $work['Classes']['id']=='3' || $work['Classes']['id']=='4'  || $work['Classes']['id']=='6') { ?>
 
        <td> <a href="<? echo ADMIN_URL; ?>primarycentral/primarysearch/<? echo $work['Classes']['id']; ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['id']; ?>" title="View Student List" target="_blank"><?php echo $work['Classes']['title']."-".$work['Sections']['title']; ?></a>
      </td>
      <?php } else { ?>
		  <td> <?php echo $work['Classes']['title']."-".$work['Sections']['title']; ?><? /* ?><a href="<? echo ADMIN_URL; ?>studentexamresult/searcharea/<? echo $work['Classes']['id']; ?>/<? echo $work['Sections']['id']; ?>" title="View Student List" target="_blank"></a> <? */ ?>
      </td>
      <?php } ?>
      <td style="color:#3c8dbc;"><strong><?php  $e_type_id=explode(',',$key['e_type_id']);
                         
      $stcounr=$this->Comman->findexamner($work['Classes']['id'],$e_type_id[0]);
       echo $stcounr['examname'];  ?></strong></td>
          
      
   
      <? /*  <td>  <? $stcounr=$this->Comman->findexamresultstudentbyteacherscount($work['Classes']['id'],$work['Sections']['id']); ?> <? echo $stcounr; ?></td> <? */ ?>
        
        
        

      
     
       

    
  
             
        <td> <? 
        $excount= $this->Comman->findexamresultcount($work['Classes']['id'],$work['Sections']['id']);  
        
        if($key['Examtypes']['id']=='4' || $key['Examtypes']['id']=='9' ){  if($excount>=$examtypesterm1) { ?>
        
        
        <a class="uploadfromd"  href="<? echo ADMIN_URL; ?>studentexamresult/genratecard/<? echo $work['Classes']['id']; ?>/<? echo $work['Sections']['id']; ?>/<? echo "Term".$key['Examtypes']['term']; ?>"><? echo "Generate Term".$key['Examtypes']['term']." Result"?></a><br>
        
        <?    if (!file_exists(WWW_ROOT.'excel_file/student/'.$work['Classes']['title'].'-'.$work['Sections']['title'].'-Term'.$key['Examtypes']['term'].'.pdf')) {   
$filefounsd ='0';                         
}else{
$filefounsd='1';

}

if($filefounsd=='1'){

?><a target="_blank" href="<?php echo SITE_URL; ?>excel_file/student/<? echo $work['Classes']['title']; ?>-<? echo $work['Sections']['title']; ?>-Term<? echo $key['Examtypes']['term']; ?>.pdf" >View Result</a> <?  }

?>
        
        
        <? }else{
        echo "Term ".$key['termf'];
        
        
        }  }else{
        
        
         echo "Term ".$key['termf'];
        } ?></td>
             <td ><? $absentcounr=$this->Comman->findexamresultstudentabsentcountbyteachers($work['Classes']['id'],$work['Sections']['id'],$key['id']);  if($absentcounr>0){ echo "<b style='color:red;'>".$absentcounr."</b>";   /* ?><a title="Retest Absent Student" class="globalmodalclasssection" href="<? echo ADMIN_URL; ?>studentexamresult/retestprocess/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['id']; ?>"  data-target="#global<?php echo $work['Classes']['id']; ?><?php   echo $work['Sections']['id']; ?><?php echo $key['id']; ?>" data-toggle="modal" style="text-decoration: underline;"><?  echo $absentcounr;  ?></a>  <? */   }else{  echo $absentcounr;   } ?></td>
     <td><b><?php echo date('d-m-Y',strtotime($key['resultuploadlast_date'])); ?></b></td>
     
<!--  ----------------------For Pre Primary Class----------------------------------  -->
     
  <?php if($work['Classes']['id']=='18' || $work['Classes']['id']=='19' || $work['Classes']['id']=='1' || $work['Classes']['id']=='2' || $work['Classes']['id']=='3' || $work['Classes']['id']=='4'  || $work['Classes']['id']=='6') { ?>
  
                  <td>
					  <?php  $da=date('Y-m-d'); if(strtotime($key['resultuploadlast_date'])>=strtotime($da)) { ?>
					  
					  <a style="color:#900;" title="Update Scholastic Areas Result" href="<?php echo SITE_URL; ?>admin/Primarycentral/primarysearch/<?php echo $work['Classes']['id']; ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['id']; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a><br> 
					  
					  <?php } else { ?>
						  <a id="" style="margin-right: 20px; margin-top: 10px;" class="btn btn-info btn-sm " href="<?php echo ADMIN_URL ;?>Primarycentral/printsreportcard/<?php echo $work['id']; ?>/<?php echo $work['class_id']; ?>"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Export PDF</a>
						  <?php } ?>
                  
                  </td>
                  
                  
              <?php } else {  ?>
                   <td>  
                  <?php  $et=array_unique($rt); 
                  $findexamwitsclass=array();
              foreach($et as $hh=>$v){
 $findexamwitsclasss=$this->Comman->findexamwithsubject($work['Classes']['id'],$v);
 if($findexamwitsclasss){
 $findexamwitsclass[]=$findexamwitsclasss;
 
}

}

//$findexamwitsclass['id']='1';	
 $csecfindexama=$this->Comman->findsubjectwithclass($h);
                  
        
         $empids= $this->request->session()->read('Auth.User.tech_id');      
         $sbs=array();     
         $sbh=array();     
foreach ($csecfindexama as $keys=>$values){
	$emspo=explode(',',$values['employee_id']);
		$subsjects=explode(',',$values['subject_id']);
	
		foreach($emspo as $js=>$ts){
			
			foreach($subsjects as $sjs=>$sts){
				
				if($js==$sjs && $ts==$empids){
					
					
						$csec = $this->Comman->findclassubject($sts);
						$checksubject = $this->Comman->checksub($sts,$work['Classes']['id']);
						$isresult=$checksubject['is_result'];
						
						
				if($isresult){
				if(($work['Classes']['id']=="11" || $work['Classes']['id']=="10") 
				&& ($sts=="66" || $sts=="67" || $sts=="68")){
						$sbh[] = "Science";
						$sbs[]='48';
						
					}else if(($work['Classes']['id']=="11" || 
					$work['Classes']['id']=="10") && ($sts=="65" || 
					$sts=="70" || $sts=="71")){
							$sbh[] = "Social Science";
						
						$sbs[]='49';
						
					}else{
						
						$sbh[] = $csec['name'];
					$sbs[]=$sts;
				}
				}
				
				}
				
				
			}
			
			
		}
		
	} 
$ssb=array_unique($sbs); 
$sbh=array_unique($sbh);

foreach($ssb as $jj=>$rtt){

$csecss = $this->Comman->findclassubject($rtt);

$sbh=$csecss['name'];

                  if(!empty($findexamwitsclass)){
				?><span><? echo $sbh; ?></span>&nbsp;<?
				   $tech_id=$this->request->session()->read('Auth.User.tech_id');
                  
               
               
                  if(($work['Classes']['id']=="10" || $work['Classes']['id']=="11") && isset($sb)){
			
				$st=$this->Comman->findsubjectopt($work['Classes']['id'],$work['Sections']['id']);
				
			
				if(in_array("65",$st) || in_array("70",$st) || in_array("71",$st)){
					if($work['Classes']['id']=="10"){
						
						
						 $rh='29';
						 
						$totalsubjectmarsks=$this->Comman->findexamresultteacherbysubject($key['id'],$work['Classes']['id'],$work['Sections']['id'],$rh);
					  if(isset($totalsubjectmarsks['exam_id'])){
						  
						    $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					       if($role_id=='3'){
					     $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));

		  
		  
					   ?>
					    	<a <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> style="color:#900;" title="Update Scholastic Areas Result" 
					    	href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    	
					  
					
					    
				<?php   }
						  
					  }else{
						  
						 $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));
    
					   ?>
					    	<a  <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> title="Update Scholastic Areas Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    	
					   <?   	 
						  
						  
					  }
					}
					
					if($work['Classes']['id']=="11"){
						$rh='38';
						$totalsubjectmarsks=$this->Comman->findexamresultteacherbysubject($key['id'],$work['Classes']['id'],$work['Sections']['id'],$rh);
						
						
						
						  if(isset($totalsubjectmarsks['exam_id'])){
						  
						    $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					       if($role_id=='3'){
					     $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));
     
					   ?>
					    	<a  <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> style="color:#900;" title="Update Scholastic Areas Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    	
				
					    
					
					    
				<?php   }
						  
					  }else{
						  $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));
      if($clodates>=$currentdoates){
					   ?>
					    	<a  <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> title="Update Scholastic Areas Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    	
					   <?  } 	
						  
						  
					  }
					  
					}
					
					
				}else if(in_array("66",$st) || in_array("67",$st) || in_array("68",$st)){
					if($work['Classes']['id']=="10"){
						$rh='28';
						$totalsubjectmarsks=$this->Comman->findexamresultteacherbysubject($key['id'],$work['Classes']['id'],$work['Sections']['id'],$rh);
						
						  if(isset($totalsubjectmarsks['exam_id'])){
						  
						    $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					       if($role_id=='3'){
					     $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));

					   ?>
					    	<a <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> style="color:#900;" title="Update Scholastic Areas Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
				
					    
					
					    
				<?php   }
						  
					  }else{
						  
						  
						  $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));
      
					   ?>
					    	<a <? if($clodates>=$currentdoates){ ?>class="current" <? } ?>  title="Update Scholastic Areas Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    	
					   <?  	
						  
					  }
					  
					}
					
					if($work['Classes']['id']=="11"){
						$rh='37';
						$totalsubjectmarsks=$this->Comman->findexamresultteacherbysubject($key['id'],$work['Classes']['id'],$work['Sections']['id'],$rh);
						
						
						  if(isset($totalsubjectmarsks['exam_id'])){
						  
						    $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					       if($role_id=='3'){
					     $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));
    
					   ?>
					<a  <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> style="color:#900;" title="Update Scholastic Areas Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    	
					  
					    
					
					    
				<?php   }
						  
					  }else{
						  
						  $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));
      if($clodates>=$currentdoates){
					   ?>
					<a  <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> title="Update Scholastic Areas Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    	
					   <?  } 	
						  
						  
						  
					  }
					   
					}
					
					
				}else{
					
					//$totalsubjectmarks=$this->Comman->findexamresultteacher($key['id'],$work['Classes']['id'],$work['Sections']['id'],$tech_id);
					$rttss=$this->Comman->findexamwithsubject2($work['Classes']['id'],$sbh);
					
				
						$totalsubjectmarks=$this->Comman->findexamresultteacherbysubject($key['id'],$work['Classes']['id'],$work['Sections']['id'],$rttss['id']);
                
                   if($totalsubjectmarks['id']){  
					       $role_id= $this->request->session()->read('Auth.User.role_id');
					      
					       if($role_id=='3'){
							  
					     $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));
    
					   ?>
					    <a  <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> style="color:#900;" title="Update Scholastic Areas Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    	
			
					    
					
					    
				<?php   } }else{    
					   $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					     if($role_id=='3'){      
				 $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));
      if($clodates>=$currentdoates){ ?>
					    
					     <a  <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> title="Upload Scholastic Areas Result"  href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    
					   
                   
                    
                   <?php  } } } 
					
					
					
				}
				
				
				
				
					   
				
			}else{
				
	
				
                  $totalsubjectmarks=$this->Comman->findexamresultteacher($key['id'],$work['Classes']['id'],$work['Sections']['id'],$tech_id);

                   if($totalsubjectmarks['id']){  
					       $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					       if($role_id=='3'){
					     $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));

					   ?>
					    	<a <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> style="color:#900;" title="Update Scholastic Areas Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    	
					  
					    
					
					    
				<?php   } }else{    
					      $role_id= $this->request->session()->read('Auth.User.role_id'); 
					       
					     if($role_id=='3'){      
				 $clodates=strtotime(date('Y-m-d',strtotime($key['resultuploadlast_date']))); $currentdoates=strtotime(date('Y-m-d'));
      if($clodates>=$currentdoates){ ?>
					    
					<a <? if($clodates>=$currentdoates){ ?>class="current" <? } ?> title="Upload Scholastic Areas Result"  href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $key['id']; ?>/<?php echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<? echo $rtt; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a>
					    
					   
                   
                    
                   <?php  } } }  }  }  ?><br><? } ?> 
                  
                   </td>
               <?php } ?>
		
                </tr>
		<?php $counter++; } } } }   } else{ ?>
		<tr>
		<td colspan="11" style="text-align:center;">NO Data Available</td>
		</tr>
		<?php } ?>	
               
                </tbody>
               
              </table>
              
              
         
    <script>
      $(document).ready(function() {
    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $(".globalmodalclasssection").click(function(event){

    // $('.modal-content').html('');
     
        $('.modal-content').load($(this).attr("href"));  //load content from href of link

      });
  }); 
</script>
        
   
            

            
          </div>
          <!-- /.box-body -->
          
      
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>





