
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Student Fee Manager
       
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
    
     <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title">Search Student</h3>
      
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
url:"<?php echo SITE_URL; ?>admin/Studentfees/search"});
return false;
});
});
//]]>
</script>
	 <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'ClasstimeTabs','action'=>'viewtimetable'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>


  
  
  
  
  
  <div class="form-group">
    
    <div class="col-sm-2">
 <label>Select Class</label>
   	<?php 
		echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','empty'=>'Class','options'=>$classes,'label' =>false));
		 ?>
    </div>  

   <div class="col-sm-2">
 <label>Select Section</label>
   	<?php 

  
		 echo $this->Form->input('section_id',array('class'=>'form-control','type'=>'select','empty'=>'Section','options'=>$sectionslist,'label' =>false)); 
		 
		  ?>  
    </div>  
    <div class="col-sm-2">
 <label>Acedamic Year</label>
     <select class="form-control"  name="acedmicyear" >
  <option value=""> Year</option>
 <?= $year=date("Y"); $year2=$year-1;   $exyear=$year+3; ?>

  <?php for ($i = $year2; $i <= $exyear; $i++) :  $rt=$i+1; $rt= substr($rt,2); $ar=$i.'-'.$rt; ?> 
        <option  value="<?php echo $i; ?>-<?php echo  $rt;?>" <?php if($ar==$alldata[0]['academic_year']){ echo "selected";  } ?>><?php echo $i; ?>-<?php echo  $rt;?></option>
    <?php endfor; ?>
</select>
    </div> 
  
    <script>
$(document).ready(function(){
$('#class-id').on('change',function(){
var id = $('#class-id').val();
//alert(id);
 $.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL ;?>ClasstimeTabs/find_section',
        data: {'id':id}, 
        success: function(data){  

 $('#section-id').empty();
  $('#section-id').html(data);
        }, 
        
    });  
});
});

</script>
 <div class="col-sm-2">
 <label>&nbsp;</label>
      <input type="text" class="form-control" name="enroll" placeholder="Enter Gr.No Or Student ID">
    </div>
    
    
 <div class="col-sm-2">
 <label>&nbsp;</label>
      <input type="text" class="form-control" name="fname" placeholder="Enter Student First Name">
    </div>   
       
    <div class="col-sm-2" style="top: 22px;">
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
<h3 class="box-title"> View Students List </h3>


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
     <th>Student GR No.</th>
 <th>Name</th>
 <th>Academic Year</th>
      <th>Class</th>
      <th>Section</th>
       <th>Status</th>
      <th>Assign Fee</th>
    </tr>
 </thead>
                <tbody id="example2">
		<?php $page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		if(isset($students) && !empty($students)){ 
		foreach($students as $work){
		?>
                <tr>
               <td><?php echo $counter;?></td>
   
      <td><?php echo $work['id']; ?></td>
 
      <td><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>"><?php echo $work['fname']; ?></a></td>
   
      <td><?php echo $work['acedmicyear']; ?></td>
      <td><?php echo $work['class']['title']; ?></td>
       <td><?php echo $work['section']['title']; ?></td>
           
                  <td><?php if($work['status']=='Y'){ 
			echo $this->Html->link('Activate', [
			    'action' => 'view#',
			   	
			],['class'=>'label label-success']);
			
			 }else{ 
				echo $this->Html->link('Deactivate', [
			    'action' => 'view#',
			
			],['class'=>'label label-primary']);
				
			 } ?>
</td>
                   <td><a title="Assign-Fees" href="<?php echo SITE_URL; ?>admin/studentfees/index/<?php echo $work['id']; ?>/<?php echo $work['acedmicyear']; ?>"><i class="fa fa-exchange"></i></a>
		  </td>
		
                </tr>
		<?php $counter++;} }else{ ?>
		<tr>
		<td>NO Data Available</td>
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




