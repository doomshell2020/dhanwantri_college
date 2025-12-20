 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Students <strong><? if($cisd==1){ echo $data[0]['discountcategory'];}?></strong>Discount Manager
      </h1>
     <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>DiscountCategory/index/"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>DiscountCategory/getdetails/">Manage Discount</a></li>

	      </ol>
	        
    </section>


<?php $role_id=$this->request->session()->read('Auth.User.role_id');  ?>

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

$("#example3").html(data);}, 
type:"POST", 
url:"<?php echo ADMIN_URL ;?>DiscountCategory/search"});
return false;
});
});
//]]>
</script>
	 


   <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'employees','action'=>'search'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>
  
  
  
  <div class="form-group">
    

    
    
  <div class="col-sm-3">
 <label></label>
  <?php echo $this->Form->input('class_id',array('class'=>'form-control','empty'=>'Select Class','options'=>$classes,'label' =>false)); ?>
    </div>   
       
     <div class="col-sm-3">
 <label></label>
 <select name="section-id" class="form-control" id="section-id"><option value="">Select section</option></select>
    </div>   

<input type="hidden" value="<?php echo $cid ?>" name="dis">
    <div class="col-sm-3 text-xs-center">
		 <label></label>
      <button type="submit"   style="margin-top: 24px;" class="btn btn-success">Search</button>
       <button type="reset"   style="margin-top: 24px;"  class="btn btn-primary">Reset</button>
    </div>
    <div class="col-sm-3 text-xs-center">
		 <label></label>
 	<?php if( $role_id=='5' || $role_id=='8'){ ?>

<a id="" style="margin-top:10px;" class="btn btn-info btn-sm "  href="<?php echo ADMIN_URL ;?>DiscountCategory/classsection_excel/<?php echo $cid; ?>"><i class="fa fa-file-excel-o"   aria-hidden="true"></i> <? if($cisd==1){ echo $data[0]['discountcategory']; } ?> Excel</a>
<?php } ?>
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
<h3 class="box-title">  Students  <strong><? if($cisd==1){ echo $data[0]['discountcategory'];}?></strong> Discount  List </h3>


            </div>
      <div class="row">
       <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info" id="updt">
		   
          
					
            <div class="box-body" id="example3">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Receipt Number</th>
                  <th>Sr. No.</th>
                  <th>Name</th>
                  <th>Class</th>
                  <th>Section</th>
                  <th>Father name</th>
                  <th>Mobile</th>
                  <th>Discount</th>
                 
                </tr>
                </thead>
                <tbody >
		<?php $page = $this->request->params['paging']['classes']['page'];
		$limit = $this->request->params['paging']['classes']['perPage'];
		$counter = ($page * $limit) - $limit + 1;
		if(isset($data) && !empty($data)){ 
		foreach($data as $work){  //pr($work);

		?>
                <tr>
                  <td><?php echo $counter;?></td>
				                   

                  <td><?php if(isset($work['id'])){  
					  
					  $wrecipiet=$this->Comman->findrecipiet($work['id'],$work['discountcategory']);   
					  
					   echo ucfirst($wrecipiet['recipetno']);}else{ echo '-';}?></td>
                                <td><?php if(isset($work['enroll'])){ echo ucfirst($work['enroll']);}else{ echo 'N/A';}?></td>
                  <td><a target="_blank" href="<?php echo SITE_URL ?>admin/studentfees/index/<? echo $work['id']; ?>/<? echo $work['acedmicyear']; ?>"><?php if(isset($work['fname'])){ echo ucfirst(strtolower($work['fname'])); ?>&nbsp; <? echo ucfirst(strtolower($work['middlename'])); ?>&nbsp; <? echo ucfirst(strtolower($work['lname']));}else{ echo 'N/A';}?></a></td>
                  <td><?php if(isset($work['classname'])){ echo ucfirst($work['classname']);}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['sectionname'])){ echo ucfirst($work['sectionname']);}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['fathername'])){ echo ucfirst(strtolower($work['fathername']));}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['sms_mobile'])){ echo ucfirst($work['sms_mobile']);}else{ echo 'N/A';}?></td>
                    <td><?php if(isset($work['discountcategory'])){ echo ucfirst($work['discountcategory']);}else{ echo 'N/A';}?></td>
				  

		
                </tr>
		<?php $counter++;} }else{?>
		<tr>
		<td>NO Data Available</td>
		</tr>
		<?php } ?>	
                </tbody>
               
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
         </div>   </div>   </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


  <!-- /.content-wrapper -->
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
