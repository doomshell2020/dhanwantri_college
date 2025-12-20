 <!-- Content Wrapper. Contains page content -->
<?php //pr($classt); die; ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Class Teacher Manager
    </h1>
             <ol class="breadcrumb">
    <li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>Classections/classteacher">Class Teacher Manager </a></li>
        </ol>
    </section>
 <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
  <div class="box">
            <div class="box-header">
              <h3 class="box-title">Add Class Teacher</h3>
             <?php echo $this->Flash->render(); ?>    
                  
         <div class="box-body">  
<?php echo $this->Form->create($classteacher, array(
                       'class'=>'form-horizontal',
                    'id' => 'sevice_form',
                       'enctype' => 'multipart/form-data'
                       
                      )); ?>
                      
           <div class="form-group">
             <div class="col-sm-2">
            <label >Teacher Name<span style="color:red;">*</span></label>
            
   <?php $array=array();   foreach($employee as $key=>$value){
  $array[$key]=str_replace(";"," ",$value);

}
if(!isset($ids)){ echo $this->Form->input('teach_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Teacher','options'=>$array,'label' =>false,'required')); }else{
 echo $this->Form->input('teach_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Teacher','options'=>$array,'value'=>$classt['teach_id'],'label' =>false,'required'));
} ?>
                     
              </div>
                 <div class="col-sm-4">
            <label >Type <span style="color:red;">*</span></label><br>
            
    <label class="radio-inline"><input type="radio" name="teacher_type" <?php if(isset($ids)){ if($classt['teacher_type']=='1') { ?> checked<?php } }?> value="1">Class Teacher</label>
<label class="radio-inline"><input type="radio" name="teacher_type" <?php if(isset($ids)){ if($classt['teacher_type']=='2') { ?> checked<?php } }?> value="2">Co-Class Teacher</label>
                     
              </div>
                 <div class="col-sm-2">
            <label >Class<span style="color:red;">*</span></label>
            
    <?php if(!isset($ids)){ echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Class','options'=>$classes,'value'=>$seletedclassid,'label' =>false,'required'));  }else{
 echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Class','options'=>$classes,'value'=>$classt['class_id'],'label' =>false,'required'));
}  ?>
                     
              </div>
                 <div class="col-sm-2">
            <label >Section<span style="color:red;">*</span></label>
            
    <?php if(!isset($ids)){ echo $this->Form->input('section_id',array('class'=>'form-control','type'=>'select','empty'=>'--Select Section--','options'=>$sectionslist,'label' =>false,'required')); }else{
 echo $this->Form->input('section_id',array('class'=>'form-control','type'=>'select','empty'=>'--Select Section--','','options'=>$sectionslist,'value'=>$classt['section_id'],'label' =>false,'required'));
} ?>
                     
              </div>
         </div>     
      <script>
$(document).ready(function(){
$('#class-id').on('change',function(){
var id = $('#class-id').val();
//alert(id);
 $.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL ;?>Classections/find_section',
        data: {'id':id}, 
        success: function(data){  

 $('#section-id').empty();
  $('#section-id').html(data);
        }, 
        
    });  
});
});

</script>

         <div class="form-group">
             <div class="col-sm-12" style="margin-top: 10px;">
      <button type="submit" class="btn btn-success">Submit</button>
      <?php if(empty($ids) && !isset($ids)) {?>
       <button type="reset" class="btn btn-primary" id="re">Reset</button>
       <?php } else {
       
      echo $this->Html->link('Back', [
          'controller' => 'Classections',
          'action' => 'classteacher_add'
         
      ],['class'=>'btn btn-default']); 
      } ?>
    </div>
  </div>
  
<?php echo $this->Form->end();  ?>  
              
          
           </div>   
</div>

        
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


  <!-- /.content-wrapper -->

  <!-- /. 