
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header ">
   <h1>View All Exam Result</h1>
     <ol class="breadcrumb">
    <li><a href="<?php echo ADMIN_URL;?>studentexamresult/examcontrolview"><i class="fa fa-home"></i>Home</a></li>
</ol>
    </section>

    <!-- Main content -->
    <section class="content">
     <div class="row"  >
		     <?  if($this->Flash->render()){  ?>
          <div id="salert">
         <div class="alert alert-success alert-dismissible" >
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        Exam Result Genrated Sucessfully !!    </div>
           </div>
         <? } ?>
<?   $rolepresent= $this->request->session()->read('Auth.User.role_id');
?>
        <div class="col-xs-12">
          
  <div class="box" >
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title">  Exam Result </h3>


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
<th>Exam </th>
<th>Total </th>
<th>Type </th>
<th>Consolidate Sheet</th>
<th>Genrate Result Term</th>


</tr>
 </thead>
                <tbody id="example2">
   
	<?php /*foreach ($examtypes  as $key){
		foreach($classes as $work){
		 pr($work['Sections']['title']); die;}
			}*/ ?>	
		<?php // pr($examtypes);examcontrolview
		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
	
		     $arrt=array();
		if(isset($examtypei2) && !empty($examtypei2)){ 
		
	//	pr($examtypei2); die;
		foreach ($examtypei2  as $key){
		
		
		$classid=explode(',',$key['class_id']);
                    
foreach($classid as $k=>$ty){
	
	if(!in_array($ty,$arrt)){
		$arrt[]=$ty;
		
     $classnme=$this->Comman->findclassesdesc($ty); 
		foreach($classnme as $work){ 

		?>
           <tr>
               <td><?php echo $counter;?></td>
   
      <td> <a href="<? echo ADMIN_URL; ?>studentexamresult/searcharea/<? echo $work['Classes']['id']; ?>/<? echo $work['Sections']['id']; ?>" title="View Student List" target="_blank"><?php echo $work['Classes']['title']."-".$work['Sections']['title']; ?></a>

        
      </td>
      <td><?php   $termm=$key['termf'];
   
      foreach ($examtypei  as $keys){
      
      $e_type_id=explode(',',$keys['e_type_id']);
                
      $stcounr=$this->Comman->findexamner2($work['Classes']['id'],$e_type_id[0],$termm);
      
   
      if($stcounr['examname']){
      
       echo $stcounr['examname']."<br>";  } } ?></td>
          
      
   
        <td>  <? $stcounr=$this->Comman->findexamresultstudentcount($work['Classes']['id'],$work['Sections']['id']); ?> <? echo $stcounr; ?></td>
        
        
        
       
  

    
    <td> <? echo "Term ".$termm; ?></td>
    <td><a class="btn btn-primary" href="<? echo SITE_URL; ?>admin/studentexamresult/exportresult/<?php echo "1"; ?>/<? echo $work['Sections']['id']; ?>/<? echo $work['Classes']['id']; ?>/<?php echo $termm; ?>" target="blank"><i class="fa 
  fa-file-excel-o"></i> Export</a></td>
        <td> <? 

        
         $examtypesterm1s= $this->Comman->findexamresultcount1($work['Classes']['id'],$work['Sections']['id'],$termm); 
    $excount= $this->Comman->findexamr($work['Classes']['id'],$termm); 
         if($excount>=$examtypesterm1s) {
			 
			 if($termm=='1'){
			 
			   if($work['Classes']['id']=='7' || $work['Classes']['id']=='8' || $work['Classes']['id']=='9'){ ?>
			 
			 
			  <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultall/<? echo $work['Classes']['id']; 
        ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['acedamicyear']; ?>"><? echo "Generate Term".$termm." Result"?></a>
        
			<? }else if($work['Classes']['id']=='10' || $work['Classes']['id']=='11'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallixx/<? echo $work['Classes']['id']; 
        ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['acedamicyear']; ?>"><? echo "Generate Term".$termm." Result"?></a>
        <? }else if($work['Classes']['id']=='23' || $work['Classes']['id']=='24' || $work['Classes']['id']=='28'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallcam/<? echo $work['Classes']['id']; 
        ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['acedamicyear']; ?>"><? echo "Generate Term".$termm." Result"?></a>
        <? }else if($work['Classes']['id']=='25' || $work['Classes']['id']=='29'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallcamnine/<? echo $work['Classes']['id']; 
        ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['acedamicyear']; ?>"><? echo "Generate Term".$termm." Result"?></a>
        <? }else{ ?>
         <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallscience/<? echo $work['Classes']['id']; 
        ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['acedamicyear']; ?>"><? echo "Generate Term".$termm." Result"?></a>
        <? } ?><br>
        
        <? }else if($termm=='2'){
			
			 if($work['Classes']['id']=='7' || $work['Classes']['id']=='8' || $work['Classes']['id']=='9'){ ?>
			 
			 
			  <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultall2/<? echo $work['Classes']['id']; 
        ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['acedamicyear']; ?>"><? echo "Generate Term".$termm." Result"?></a>
        
			<? }else if($work['Classes']['id']=='10' || $work['Classes']['id']=='11'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallixx2/<? echo $work['Classes']['id']; 
        ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['acedamicyear']; ?>"><? echo "Generate Term".$termm." Result"?></a>
        <? }else if($work['Classes']['id']=='23' || $work['Classes']['id']=='24'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallcam2/<? echo $work['Classes']['id']; 
        ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['acedamicyear']; ?>"><? echo "Generate Term".$termm." Result"?></a>
        <? }else if($work['Classes']['id']=='25'){ ?>
        
        <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallcamnine2/<? echo $work['Classes']['id']; 
        ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['acedamicyear']; ?>"><? echo "Generate Term".$termm." Result"?></a>
        <? }else{ ?>
         <a class="uploadfromd" target="_blank" href="<? echo ADMIN_URL; 
        ?>studentexamresult/resultallcamten2/<? echo $work['Classes']['id']; 
        ?>/<? echo $work['Sections']['id']; ?>/<? echo $key['acedamicyear']; ?>"><? echo "Generate Term".$termm." Result"?></a>
        <? } ?><br> 
			
			<? } ?>
        
        <? /*    if 
        (!file_exists(WWW_ROOT.'excel_file/student/'.$work['Classes']['title'].'-'.$work['Sections']['title'].'-Term1'.'.pdf')) {   
$filefounsd ='0';                         
}else{
$filefounsd='1';

}

if($filefounsd=='1'){

?><a target="_blank" href="<?php echo SITE_URL; ?>excel_file/student/<? 
echo $work['Classes']['title']; ?>-<? echo $work['Sections']['title']; ?>-Term1.pdf" >View Result</a> 


<?  } */

?>
        
        
        <? }else{
        echo "Term 1";
        
        
        }   ?></td>
  
  
              
		
                </tr>
		<?php $counter++;  } } } } } else{ ?>
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

  $('.modal-content').html('');
     
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
    <!-- /.content -->
  </div>
