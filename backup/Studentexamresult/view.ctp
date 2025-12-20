
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Student Exam Category Result 
       
      </h1>
           <ol class="breadcrumb">
    <li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>studentexamresult/view">Manage Result</a></li>
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
url:"<?php echo SITE_URL; ?>admin/Studentexamresult/search"});
return false;
});
});

//]]>
</script>

   <?php echo $this->Form->create('Task',array('url'=>array('controller'=>'ClasstimeTabs','action'=>'viewtimetable'),'type'=>'file','inputDefaults'=>array('div'=>false,'label'=>false),'id'=>'TaskAdminCustomerForm','class'=>'form-horizontal')); ?>
    <?php $role_id= $this->request->session()->read('Auth.User.role_id');
                 
               if($role_id=='3'){ ?>
  <div class="form-group">
    
    <div class="col-sm-2">
 <label>Select Class<span style="color:red;">*</span></label>
    <?php 
    if (isset($classid)) {
      echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','required','empty'=>'Select ','options'=>$cname,'label' =>false,'selected'=>'selected','value'=>$classid));
     
    }else{
      echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','required','empty'=>'Select ','options'=>$cname,'label' =>false));
    
    }
    
     ?>
    </div>  

   <div class="col-sm-3">
 <label>Select Exam Category<span style="color:red;">*</span></label>
    <?php 

  if (isset($examtypesi)) {
     echo $this->Form->input('examtypesi',array('class'=>'form-control','type'=>'select','empty'=>'Select ','options'=>$examtypeses,'required','label' =>false,'selected'=>'selected','value'=>$examtypesi));
  } else
  {
    echo $this->Form->input('examtypes',array('class'=>'form-control','type'=>'select','empty'=>'Select ','options'=>$examtypeses,'required','label' =>false));
  }
  
      ?>  
    </div> 
      <!--<div class="col-sm-3">

   <label>Acedamic Year <span style="color:red;">*</span></label>
      <select class="form-control" name="acedamicyear" required="required" >
  <option value="">--- Select Acedamic Year ---</option>
      <option selected="selected" value="2017-18">2017-18</option>
 <?= $year=date("Y");  $year2=$year-1; $exyear=$year+3; ?>

  <?php for ($i = $year; $i <= $exyear; $i++) :  $rt=$i+1; $rt= substr($rt,2);$st=$i.'-'.$rt?> 
        <option <?php if($i==$year){ ?> <?php } ?> value="<?php echo $i; ?>-<?php echo  $rt;?>" <?php if($st==$exams['acedamicyear']){ echo "selected";  } ?> ><?php echo $i; ?>-<?php echo  $rt;?></option>
    <?php endfor; ?>
</select>
    </div>-->   
   
  
    <script>
$(document).ready(function(){
$('#class-id').on('change',function(){
var id = $('#class-id').val();
//alert(id);
 $.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL ;?>Studentexamresult/find_etype',
        data: {'id':id}, 
        success: function(data){  

 $('#examtypes').empty();
  $('#examtypes').html(data);
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
  <?php } else { ?>

<div class="form-group">
    
    <div class="col-sm-2">
 <label>Select Class<span style="color:red;">*</span></label>
    <?php 
    
  
    echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','required','empty'=>'Select ','options'=>$classeses,'label' =>false));
    

    
    
     ?>
    </div>  

   <div class="col-sm-3">
 <label>Select Exam Category<span style="color:red;">*</span></label>
    <?php 

  
     echo $this->Form->input('examtypes',array('class'=>'form-control','type'=>'select','empty'=>'Select ','options'=>$examtypeses,'required','label' =>false));
   
  
      ?>  
    </div> 
      <!--<div class="col-sm-3">

   <label>Acedamic Year <span style="color:red;">*</span></label>
      <select class="form-control" name="acedamicyear" required="required" >
  <option value="">--- Select Acedamic Year ---</option>
      <option selected="selected" value="2017-18">2017-18</option>
 <?= $year=date("Y");  $year2=$year-1; $exyear=$year+3; ?>

  <?php for ($i = $year; $i <= $exyear; $i++) :  $rt=$i+1; $rt= substr($rt,2);$st=$i.'-'.$rt?> 
        <option <?php if($i==$year){ ?> <?php } ?> value="<?php echo $i; ?>-<?php echo  $rt;?>" <?php if($st==$exams['acedamicyear']){ echo "selected";  } ?> ><?php echo $i; ?>-<?php echo  $rt;?></option>
    <?php endfor; ?>
</select>
    </div>-->   
   
  
    <script>
$(document).ready(function(){
$('#class-id').on('change',function(){
var id = $('#class-id').val();
//alert(id);
 $.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL ;?>Studentexamresult/find_etype',
        data: {'id':id}, 
        success: function(data){  

 $('#examtypes').empty();
  $('#examtypes').html(data);
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
<?php } ?>

     <?php
echo $this->Form->end();
?>   
  
</div>
        
        </div>
        
          </div>  </div>  </div>
    
    
    
    
    
    
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
                    <table id="" class="table table-bordered table-striped" >
                
  
 <thead>
    <tr>
      <th>#</th>
      <th>Section</th>
     <th>Class</th>
 <th>Exam Category</th>
 <th>Acedamic year</th>

    
       <th>Status</th>
      <th>Action</th>
    </tr>
 </thead>
                <tbody id="example2">
    <?php 
    $page = $this->request->params['paging']['Students']['page'];
    $limit = $this->request->params['paging']['Students']['perPage'];
    $counter = ($page * $limit) - $limit + 1; 
    if(isset($classid) && !empty($classid)){ 
    foreach($classes as $work){
    ?>
                <tr>
               <td><?php  echo $counter;?></td>
   
      <td><?php echo $work['Sections']['title']; ?></td>
 
        <td><?php echo $work['Classes']['title']; ?></td>
     
      <td><?php echo $examtypes[0]['Examtypes']['name']; ?></td>
     <td><?php echo $examtypes[0]['acedamicyear']; ?></td>
  
  
                  <td><?php if($examtypes[0]['status']=='Y'){  ?>
  <span class="label label-primary">Activate</span>
      
      <?php  }else{ ?>
        <span class="label label-primary">Deactivate</span>
        
      <?php } ?>
</td>
                   <td> <?php $totalsubjectmarks=$this->Comman->findexamresult($examtypes[0]['id'],$work['Sections']['id']);  if($totalsubjectmarks['id']){  
                 $role_id= $this->request->session()->read('Auth.User.role_id');
                
                 if($role_id=='3'){
                 
              $findclasssection=$this->Comman->findclassectionsed();  
               $ststatus=$this->Comman->showestudentexamstatus($examtypes[0]['id'],$work['Sections']['id']); 
               {
                $stdstus=$ststatus[0]['status']; 
              
             // if ($findclasssection['class_id']==$work['Classes']['id'] &&  $findclasssection['section_id']==$work['Sections']['id']) {?>
               <?php if($stdstus=='N') {?>
                <a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>

                    <a title="View Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/viewresult/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
              
              <?php }elseif($stdstus=='Y'){  ?>
             <a title="View Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/viewresult/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
              <?php } }?>
                <!--<a title="View Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/viewresult/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
              -->
        <?php }else{ ?>
                    
                    
                    
                      <a style="color:#900;" title="Update Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>?query=1"><i class="fa fa-upload" aria-hidden="true"></i></a>
                    <a title="View Result" href="<?php echo SITE_URL; ?>admin/studentexamresult/viewresult/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-list-ul" aria-hidden="true"></i></a>
                    
                    
                   <?php } }else{    
             $role_id= $this->request->session()->read('Auth.User.role_id');
                 
               if($role_id=='3'){
               $findclasssection=$this->Comman->findclassectionsed();    
              if ($findclasssection['class_id']==$work['Classes']['id'] &&  $findclasssection['section_id']==$work['Sections']['id']) { ?>
                <a title="Submit Result"  href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a>
              
              <?php }else{ ?>
              
              
              <?php } ?>
                   
              
                   
                    
                   <?php }else{ ?>
                   
                    <a title="Submit Result"  href="<?php echo SITE_URL; ?>admin/studentexamresult/addcsv/<?php echo $examtypes[0]['id']; ?>/<?php echo $work['Sections']['id']; ?>"><i class="fa fa-upload" aria-hidden="true"></i></a>
                   
                   
                <?php   
                   } } ?> 
                  
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




