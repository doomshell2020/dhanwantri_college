
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Deposit Fee Manager
       
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
<h3 class="box-title">Search Student</h3>
      
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
url:"<?php echo SITE_URL; ?>admin/Studentfees/search"});
return false;
});
});
//]]>
</script>
	 <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'ClasstimeTabs','action'=>'viewtimetable'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>


  
  
  
  
  
  <div class="form-group">
    
   <div class="col-sm-3 col-xs-6">
 <label>Acedamic Year<span style="color:red;">*</span></label>
    <?php
echo
$this->Form->input('acedmicyear', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Academic Year', 'options' => $acd, 'label' => false, 'value' => $rolepresentyear,'required'));
?>
    </div> 
 <div class="col-sm-3 col-xs-6">
 <label>Scholar No.</label>
      <input type="text" class="form-control" name="enroll" placeholder="Enter Scholar No.">
    </div>
    
    
 <div class="col-sm-3 col-xs-6">
 <label>Pupil's Name</label>
      <input type="text" class="form-control" name="name" placeholder="Enter Pupil's Name">
    </div>   
       
    <div class="col-sm-3 col-xs-6">
 <label>Father Name</label>
      <input type="text" class="form-control" name="fathername" placeholder="Enter Father Name">
    </div>  
     </div>   <div class="form-group">
   <div class="col-sm-3 col-xs-6">
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

    
      <div class="col-sm-3 col-xs-6">
 <label>Select Class</label>
   	<?php 
		echo 
		$this->Form->input('class_id',array('class'=>'form-control','type'=>'select','id'=>'class-ids','empty'=>'Select Class','options'=>$classes,'label' =>false));
		 ?>
    </div>  

   <div class="col-sm-3 col-xs-6">
 <label>Select Section</label>
   	<?php 

  
		 echo $this->Form->input('section_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Section','options'=>$sectionslist,'label' =>false)); 
		 
		  ?>  
    </div>   <div class="col-sm-3 col-xs-6" style="top: 22px;">
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
		      <div class="box-body"  id="example12">
				 
<div class="table-responsive">
   
                    <table  id="example1" class="table table-bordered table-striped" >
                
  
 <thead>
    <tr>
		
      <th>#</th>
     <th width="132px;">Scholar No.</th>
 <th>Name</th>
  <th>Father Name</th>
 <th>Mother Name</th>
      <th>Class</th>
      <th>Section</th>
        <th>Mobile</th>
       <th>House</th>
     
    </tr>
 </thead>
                <tbody id="example2">
		<?php 
		 $role_id=$this->request->session()->read('Auth.User.role_id');
		$page = $this->request->params['paging']['Students']['page'];
		$limit = $this->request->params['paging']['Students']['perPage'];
		$counter = ($page * $limit) - $limit + 1; 
		if(isset($students) && !empty($students)){ 
		foreach($students as $work){
		?>
                <tr>
               <td><?php echo $counter;?></td>
   
      <td><?php if($role_id=='5' || $role_id=='8'){  ?><a title="View Student Detail" href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $work['id']; ?>"><?php echo $work['enroll']; ?></a>
		  
		  <a   title="Edit Student" href="<?php echo SITE_URL; ?>admin/students/edit/<?php echo 
					 $work['id']; ?>"> <img src="<? echo SITE_URL; ?>images/edit.png" style="width: 18px;" ></a>
	
		    <? if($work['category']!="RTE"){ ?>
		    <a class='global1' title="Pending Fees" style="color:red;" 
		    href="<?php echo SITE_URL; ?>admin/students/view_out/<?php echo $work['id']; ?>" data-target="#global-drop-out<?php echo $work['id']; ?>" data-toggle="modal"><img src="<? echo SITE_URL; ?>images/pending.png" ></a>
                
                 <a title="Update Discount" href="<?php echo SITE_URL; 
                 ?>admin/students/discount/<?php echo $work['id']; ?>"  data-target="#globaldiscountjh" class="globaldiscountdss" data-toggle="modal"><img src="<? echo SITE_URL; ?>images/discount.png" ></a>
              
                <a  title="Tution Fees Acknowledgement <?php echo $work['acedmicyear']; ?>"  target="_blank" href="<?php echo SITE_URL; ?>admin/report/feeacknowledgement/<?php echo 
					 $work['id']; ?>/<?php echo $work['acedmicyear']; ?>"> <img src="<? echo SITE_URL; ?>images/fee_acnow.png" ></a> <? } ?>
                <a   title="Deposit Fees" href="<?php echo SITE_URL; ?>admin/studentfees/index/<?php echo 
					 $work['id']; ?>/<?php echo $work['acedmicyear']; ?>"> <img src="<? echo SITE_URL; ?>images/deposite_fee.png" ></a></td>
                 
                 
                  <div class="modal" id="global-drop-out<?php echo $work['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true" 
                  style="display: none;">
                  <div class="modal-dialog">
                    <div class="modal-content modal-content-drop-out">
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

                <script>
                      $(document).ready(function() {
                    //prepare the dialog

                    //respond to click event on anything with 'overlay' class
                    $("#global-drop-out<?php echo $work['id']; ?>").click(function(event){
    $('.modal-content-drop-out').html('');
                        //load content from href of link
                        $('.modal-content-drop-out').load($(this).attr("href"));

                      });
                  }); 
                </script>
		  
		  
		  
		  <? }else{ ?>  <?php echo $work['enroll']; ?><? } ?></td>
 
      <td><?php echo $work['fname']; ?> <?php echo $work['middlename']; 
      ?> <?php echo $work['lname']; ?> <?php  if($work['discountcategory']){ echo 
					   "<span style='color:green;font-weight:12px;'><b>".$work['discountcategory']."</b></span>";  } ?></td>
       <td><?php echo $work['fathername']; ?></td>
   <td><?php echo $work['mothername']; ?></td>
      <td><?php echo $work['class']['title']; ?></td>
       <td><?php echo $work['section']['title']; ?></td>
       <td><?php echo $work['sms_mobile']; ?></td>
       <td><?php  $house=$this->Comman->findhouse($work['h_id']); if($house['name']){ echo $house['name']; }else{ echo "--"; } ?></td>
           
                 
             
		
                </tr>
		<?php $counter++;} }else{ ?>
		<tr>
		<td>NO Data Available</td>
		</tr>
		<?php } ?>	
                </tbody>
               
              </table>
    		
    </div>
	
    <div class="modal globaldiscountdss" id="globaldiscountjh" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
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
    <script>
      $(document).ready(function() {
    //prepare the dialog

    //respond to click event on anything with 'overlay' class
    $(".globaldiscountdss").click(function(event){

     
     
        $('.modal-content').load($(this).attr("href"));  //load content from href of link

      });
  }); 
</script>

		     <div class="modal globaldiscountds" id="globaldiscountd" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
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




