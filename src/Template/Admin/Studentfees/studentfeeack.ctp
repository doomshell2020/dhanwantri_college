
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Fee Acknowledgement Manager
       
      </h1>
           <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>studentfees/view">Manage Fee Acknowledgement Fee</a></li>
	      </ol>
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
url:"<?php echo SITE_URL; ?>admin/Studentfees/searchfeeack"});
return false;
});
});
//]]>
</script>
	 <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'ClasstimeTabs','action'=>'viewtimetable'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>


  
  
  
  
  
  <div class="form-group">
    
  
 <div class="col-sm-2">
 <label>&nbsp;</label>
      <input type="text" class="form-control" name="enroll" placeholder="Enter Sr. No.">
    </div>
    
    
 <div class="col-sm-2">
 <label>&nbsp;</label>
      <input type="text" class="form-control" name="fname" placeholder="Enter  First Name">
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
 <label>Select Class</label>
   	<?php 
		echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Class','options'=>$classes,'label' =>false));
		 ?>
    </div>  

   <div class="col-sm-2">
 <label>Select Section</label>
   	<?php 

  
		 echo $this->Form->input('section_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Section','options'=>$sectionslist,'label' =>false)); 
		 
		  ?>  
    </div>   <div class="col-sm-2" style="top: 22px;">
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
     <th> Serial No.</th>
 <th>Name</th>
  <th>Father Name</th>

      <th>Class</th>
      <th>Section</th>
       <th>House</th>
      <th>Print</th>
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
   
      <td><?php echo $work['enroll']; ?></td>
 
      <td><a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>"><?php echo $work['fname']; ?> <?php echo $work['middlename']; ?> <?php echo $work['lname']; ?></a></td>
       <td><?php echo $work['fathername']; ?></td>
  
      <td><?php echo $work['class']['title']; ?></td>
       <td><?php echo $work['section']['title']; ?></td>
       <td><?php  $house=$this->Comman->findhouse($work['h_id']); echo $house['name']; ?></td>
           
                 
                   <td><a title="Print Fee Ack." href="<?php echo SITE_URL; ?>admin/report/feeacknowledgement/<?php echo $work['id']; ?>"><i class="fa fa-file-text-o"></i></a>
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




