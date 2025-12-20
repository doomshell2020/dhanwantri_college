
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <section class="content">
    
		
		
      <div class="row"  >
        <div class="col-xs-12">
          
	<div class="box" >
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title"> Update Students Marks List </h3>
<?php echo $this->Flash->render(); ?>

            </div>
      <div class="row">
       <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
           <span class="text-muted" style="padding-left: 10px; font-size: 15px;">
    
      <strong>Class Name : </strong><?php echo $students[0]['classtitle']; ?> | <strong>Section Name : </strong><?php echo  $students[0]['sectiontitle']; ?> </span><br>
     <? /*  if (!file_exists(WWW_ROOT.'excel_file/student/'.$students[0]['id'].'('.$students[0]['classtitle'].'-'.$students[0]['sectiontitle'].'-Term1).pdf')) {     ?>
     
  
     <div class="alert alert-error alert-dismissible">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-exclamation"></i> Alert !!!</h4>
        Exam Result Doesn't Upload Yet !!    </div>
          
     <? } */ ?>
		   
            <!-- /.box-header -->
            <!-- form start -->
             
		      <div class="box-body"  >
 <script type="text/javascript">
$("#checkall").change(function(){
     var checked = $(this).is(':checked');
     if(checked){
       $(".checkbox").each(function(){
         $(this).prop("checked",true);
       });
     }else{
       $(".checkbox").each(function(){
         $(this).prop("checked",false);
       });
     }
   });
</script>
<script type="text/javascript">
  
        $('.inv').click(function(){
        var sd= $(".checkbox:checked").length;
        if(sd==0){
          alert("Please Select One Student Atleast.")
          return false;
        }else{
          return true;
        }
        });
        
        </script>
        <table class="table table-bordered table-striped">
                <thead>
			   
   

          <tr>
      <th>#</th>
     <th>Student Sr No.</th>
 <th>Name</th>
 <th>Academic Year</th>
      <th>Class</th>
      <th>Section</th>
       
      <th>Update Term-1 Marks</th>
      <th>Update Term-2 Marks</th>
    </tr>
     </thead>
       <tbody >
            
		<?php $page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		if(isset($students) && !empty($students)){ 
		$resultfind=0;
		//pr($students); die;
		foreach($students as $work){
		?>
                <tr>
               <td><? echo $counter++; ?></td>
   
      <td><?php echo $work['enroll']; ?></td>
 
      <td><?php echo $work['fname']." "; ?><?php echo $work['middlename']." "; ?><?php echo $work['lname']; ?></td>
     
      <td><?php echo $work['acedmicyear']; ?></td>
     <td><?php echo $work['classtitle']; ?></td>
       <td><?php echo $work['sectiontitle']; ?></td>
  
              
                   <td><? 
                   
                   if($work['class_id']=='7' || $work['class_id']=='8' || $work['class_id']=='9'){ ?>
			 
			 <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; ?>studentexamresult/resultallupdatemarks/<? echo $work['class_id'];  ?>/<? echo $work['section_id']; ?>/<? echo $work['acedmicyear']; ?>/<? echo $work['id']; ?>"><? echo "Update Term1"." Result"?></a>
        
			<? }else if($work['class_id']=='10' || $work['class_id']=='11'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; ?>studentexamresult/resultallupdatemarksixx/<? echo $work['class_id']; 
        ?>/<? echo $work['section_id']; ?>/<? echo $work['acedmicyear']; ?>/<? echo $work['id']; ?>"><? echo "Update Term1"." Result"?></a>
        <? }else if($work['class_id']=='23' || $work['class_id']=='24'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallcam/<? echo $work['class_id']; 
        ?>/<? echo $work['section_id']; ?>/<? echo $work['acedmicyear']; ?>/<? echo $work['id']; ?>"><? echo "Update Term1"." Result"?></a>
        <? }else if($work['class_id']=='25'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallcamnine/<? echo $work['class_id']; 
        ?>/<? echo $work['section_id']; ?>/<? echo $work['acedmicyear']; ?>/<? echo $work['id']; ?>"><? echo "Update Term1"." Result"?></a>
        <? }else{ ?>
         <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; ?>studentexamresult/resultallupdatemarksscience/<? echo $work['class_id']; 
        ?>/<? echo $work['section_id']; ?>/<? echo $work['acedmicyear']; ?>/<? echo $work['id']; ?>"><? echo "Update Term1"." Result"?></a>
        <? } ?>
					   </td>
					   
					 <td> <? 
                   
                   if($work['class_id']=='7' || $work['class_id']=='8' || $work['class_id']=='9'){ ?>
			 
			 <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; ?>studentexamresult/resultallupdatemarks2/<? echo $work['class_id']; 
        ?>/<? echo $work['section_id']; ?>/<? echo $work['acedmicyear']; ?>/<? echo $work['id']; ?>"><? echo "Update Term2"." Result"?></a>
        
			<? }else if($work['class_id']=='10' || $work['class_id']=='11'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; ?>studentexamresult/resultallupdatemarksixx2/<? echo $work['class_id']; 
        ?>/<? echo $work['section_id']; ?>/<? echo $work['acedmicyear']; ?>/<? echo $work['id']; ?>"><? echo "Update Term2"." Result"?></a>
        <? }else if($work['class_id']=='23' || $work['class_id']=='24'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallcam2/<? echo $work['class_id']; 
        ?>/<? echo $work['section_id']; ?>/<? echo $work['acedmicyear']; ?>/<? echo $work['id']; ?>"><? echo "Update Term2"." Result"?></a>
        <? }else if($work['class_id']=='25'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallcamnine2/<? echo $work['class_id']; 
        ?>/<? echo $work['section_id']; ?>/<? echo $work['acedmicyear']; ?>/<? echo $work['id']; ?>"><? echo "Update Term2"." Result"?></a>
        <? }else{ ?>
         <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; ?>studentexamresult/resultallupdatemarksscience2/<? echo $work['class_id']; 
        ?>/<? echo $work['section_id']; ?>/<? echo $work['acedmicyear']; ?>/<? echo $work['id']; ?>"><? echo "Update Term2"." Result"?></a>
        <? } ?>
					   </td>   
					   
					   
                </tr>
		<?php $counter++;} }else{ ?>
		<tr>
		<td colspan="11" style="text-align:center;">NO Data Available</td>
		</tr>
		<?php } ?>	
			
                </tbody>
               
              </table>
    		    
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
               
