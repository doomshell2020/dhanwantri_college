
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Student Complete Fee Manager
       
      </h1>
           <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>studentfees/view"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>studentfees/view">Manage Student Fee</a></li>
	      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div id="load"></div>
     <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title">Search Active Student / Dropout Student</h3>
      
            </div>
              
     <style>
         
         #load{
    width:100%;
    height:100%;
    position:fixed;
    z-index:9999;
    background-color: white  !important;
    background:url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0,0,0,0.75)
}

</style>
 <style>
         
         #load2{
    width:100%;
    height:100%;
    position:fixed;
    z-index:9999;
    background-color: white  !important;
    background:url("<? echo SITE_URL; ?>images/Preloader_2.gif") no-repeat center center rgba(0,0,0,0.75)
}

</style>
<script>
    document.onreadystatechange = function () {
  var state = document.readyState
  if (state == 'complete') {
         document.getElementById('interactive');
         document.getElementById('load').style.visibility="hidden";
  }
}
</script>
            <!-- /.box-header -->
<?php echo $this->Flash->render(); ?>
            <div class="box-body">
		
<?php 
if($ids || $ids3){ ?>
	
	<?php 
if($ids3 && $ids4){ ?>
	
	<a href="<? echo ADMIN_URL; ?>studentfees/<?php echo $ids3; ?>/<?php echo $ids4; ?>/<?php echo $acedemicdd; ?>" target="_blank" id="redicaution"></a>
	
  <script type="text/javascript">
              
               $('#redicaution')[0].click();
            </script>
	
	
	<? } 
if($ids && $ids2){ ?>
	<a href="<? echo ADMIN_URL; ?>studentfees/<?php echo $ids; ?>/<?php echo $ids2; ?>/<?php echo $acedemicdd; ?>" target="_blank" id="redi"></a>
	
  <script type="text/javascript">
              
               $('#redi')[0].click();
            </script>



<?php }  } ?>
<div class="manag-stu">
	
<script inline="1">
//<![CDATA[
$(document).ready(function () {
$("#TaskAdminCustomerForm").bind("submit", function (event) {
$.ajax({
async:true,
 data:$("#TaskAdminCustomerForm").serialize(),
 dataType:"html", 
  beforeSend: function() {
        // setting a timeout
         $('#load2').css("display", "block");
    },

success:function (data, textStatus) {

$("#example12").html(data);}, 
 complete: function() {
           $('#load2').css("display", "none");
    },
type:"POST", 
url:"<?php echo SITE_URL; ?>admin/Studentfees/searchstudentfees"});
return false;
});
});
//]]>
</script>
	 <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'ClasstimeTabs','action'=>'viewtimetable'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>


  
  
  
  
  
  <div class="form-group">
    

 <div class="col-md-2 col-sm-6 col-xs-6">
 <label>Scholar No.</label>
      <input type="text" class="form-control" name="enroll" placeholder="Enter Scholar No.">
    </div>
    
    
 <div class="col-md-2 col-sm-6 col-xs-6">
 <label>Pupil's Name</label>
      <input type="text" class="form-control" name="name" placeholder="Enter Pupil's Name">
    </div>   
       
    <div class="col-md-2 col-sm-6 col-xs-6">
 <label>Father Name</label>
      <input type="text" class="form-control" name="fathername" placeholder="Enter Father Name">
    </div>  

   <div class="col-md-2 col-sm-6 col-xs-6">
 <label>Mother Name</label>
      <input type="text" class="form-control" name="mothername" placeholder="Enter Mother Name">
    </div>  
    <script>
$(document).ready(function(){
$('#class-ids').on('change',function(){
var id = $('#class-ids').val();
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
		    <div id="load2" style="display:none;"></div>
        <div class="col-xs-12">
          
	<div class="box" >
            <div class="box-header">
              <i class="fa fa-search" aria-hidden="true"></i>
<h3 class="box-title"> Sessionwise Fee Detail </h3>


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
		      <div class="box-body"  id="example12">
				 
 <table  id="example1ss" class="table table-bordered table-striped" >
                
  
 <thead>
    <tr>
		
      <th></th>
     <th width="132px;"></th>
 <th></th>
  <th></th>
 <th></th>
      <th></th>
      <th></th>
        <th></th>
       <th></th>
     
    </tr>
 </thead>
                <tbody id="example2">
		
		<tr>
		<td colspan="9" align="center" style="font-weight:bold;color:green;">Select Student details for View history !!</td>
		</tr>
		
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




