<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Co-Scholastic Activity  Manager
       
      </h1>
                    <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>studentexamresult/view">Manage Result</a></li>
<li class="active">Co-Scholastic Activity</li>
	      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    
     <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title">Search Exam</h3>
      
            </div>
    
            <!-- /.box-header -->
<?php echo $this->Flash->render(); ?>
            <div class="box-body">
		

<div class="manag-stu">
	
<script inline="1">
//<![CDATA[
$(document).ready(function () {
$("#TaskAdminCustomerForm").bind("submit", function (event) {
$.ajax({
async:true,
 data:$("#TaskAdminCustomerForm").serialize(),
 dataType:"html", 

success:function (data, textStatus) {

$("#example2").html(data);}, 
type:"POST", 
url:"<?php echo SITE_URL; ?>admin/Studentexamresult/coschoolsearch"});
return false;
});
});

//]]>
</script>
	 <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'ClasstimeTabs','action'=>'viewtimetable'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>


  
  
  
  
  <div class="form-group">
    
    <div class="col-sm-2">
 <label>Select Class<span style="color:red;">*</span></label>
    <?php foreach($examtypei as $gg=>$tt){
    
    
             
              
              $classidd[]=$tt['class_id'];
              
                         
                        } 
                      
                        function array_map_assoc( $callback , $array ){
  $r = array();
  foreach ($array as $key=>$value)
    $r[$key] = $callback($key,$value);
  return $r;
}
 
                       $mpassoc= implode(',',array_map_assoc(function($k,$v){return "$v";},$classidd));



$arr=explode(',',$mpassoc);

$drt=array_unique($arr);


 
                         foreach($drt as $k=>$ty){
                        $classnme=$this->Comman->findclass($ty); 
                         
                       $rrt[$ty]= $classnme['title'];  
                        }  
            
    if (isset($classid)) {
      echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','required','empty'=>'Select ','options'=>$rrt,'label' =>false,'selected'=>'selected','value'=>$classid));
     
    }else{
      echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','required','empty'=>'Select ','options'=>$rrt,'label' =>false));
    
    }
    
     ?>
    </div>  

   
      
       <div class="col-sm-3">
		    <label>Select Term<span style="color:red;">*</span></label>
    <select class="form-control" name="term" required="required">
  <option value="">--- Select Term ---</option>


 <option value="Term1">Term-1</option> 
 <option value="Term2">Term-2</option> 
</select>

     </div>  
       
    <div class="col-sm-3" style="top: 22px;">
      <button type="submit" class="btn btn-success">Search</button>
       <button type="reset" class="btn btn-primary">Reset</button>
    </div>
  </div>
     <?php
echo $this->Form->end();
?>   
  
</div>
				
				</div>
				
					</div>	</div>	</div>
		
		
		
		
		
		
      <div class="row"  >
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
           <th>Section</th>
    <th>Term</th>
 <th>Acedamic year</th>

      <th>Action</th>
    </tr>
 </thead>
                <tbody id="example2">
		<?php 
		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		
		
		if(isset($examtypei) && !empty($examtypei)){ 
		for($i=1;$i<=2;$i++){
		foreach ($examtypei  as $key){
		
		
		$classid=explode(',',$key['class_id']);
                         
                         foreach($classid as $k=>$ty){
                        $classnme=$this->Comman->findclassesdesc($ty); 
		
//pr($key);
		foreach($classnme as $work){
		?>
                <tr>
               <td><?php  echo $counter;?></td>
    <td><?php echo $work['Classes']['title']; ?></td>
      <td><?php echo $work['Sections']['title']; ?></td>
 
       
     
          <td><?php echo $term="Term".$i; ?></td>
     <td><?php echo $key['acedamicyear']; ?></td>
  
  
                
                   <td> <?php   $totalsubjectmarks=$this->Comman->findcoactivityresult($work['Classes']['id'],$work['Sections']['id'],$term,$key['acedamicyear']);  
                   
                   if($totalsubjectmarks['id']){
					   
					   $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					       if($role_id=='3'){
					    $findclasssection=$this->Comman->findclassectionsed();    
					    if ($findclasssection['class_id']==$work['Classes']['id'] &&  $findclasssection['section_id']==$work['Sections']['id']) { ?> 
                   
                   <a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/addcsv/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['acedamicyear']; ?>/<?php echo $term; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                    <a title="View Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/viewresult/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['acedamicyear']; ?>/<?php echo $term; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                    <?php }else{ ?>
                    
                     <a title="View Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/viewresult/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['acedamicyear']; ?>/<?php echo $term; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                    
                    
                     <?php } ?>
					    
				<?php }else{ ?>
                    
                    <a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/addcsv/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['acedamicyear']; ?>/<?php echo $term; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                    <a title="View Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/viewresult/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['acedamicyear']; ?>/<?php echo $term; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                    
                    
                     <?php } }else{   
						 
						  $role_id= $this->request->session()->read('Auth.User.role_id');
					       
					     if($role_id=='3'){
					     $findclasssection=$this->Comman->findclassectionsed();    
					    if ($findclasssection['class_id']==$work['Classes']['id'] &&  $findclasssection['section_id']==$work['Sections']['id']) { ?>
                      <a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/addcsv/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['acedamicyear']; ?>/<?php echo $term; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                        <?php }else{ ?>
					    
					    
					    <?php } ?>
					    
					         <?php }else{ ?>
					         
					            <a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/Coactivityresults/addcsv/<?php echo $work['Classes']['id']; ?>/<?php echo $work['Sections']['id']; ?>/<?php echo $key['acedamicyear']; ?>/<?php echo $term; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                   
                    
                    
                    
                    
                    <?php   
                   } } ?> 
                  
                  </td>
		
                </tr>
		<?php $counter++;} } } }  }else{ ?>
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




