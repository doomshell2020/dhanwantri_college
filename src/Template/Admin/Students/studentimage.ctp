<div class="content-wrapper">
<section class="content-header">
   <h1>
      <!--    Student Image Manager -->
   </h1>
   <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
      <li><a href="#">Student</a></li>
      <li><a href="#" class="active">Manage Student</a></li>
      <li><a href="#" class="active">Upload Image</a></li>
   </ol>
</section>
<section class="content">
   <div class="row">
      <div class="col-sm-12">
         <ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="profileTab">
            <!--<li  id="personal-tab"><a href="https://www.idsprime.com/admin/students/studentimage/12009#personal" data-toggle="tab"><i class="fa fa-street-view"></i> Capture Image</a></li>-->
            <li class="active" id="academic-tab"><a href="http://www.idsprime.com/admin/students/studentimage/12009#academic" data-toggle="tab"><i class="fa fa-graduation-cap"></i> Upload Image</a></li>
         </ul>
      </div>
   </div>
   <div id="content" class="tab-content responsive hidden-xs hidden-sm">
   <div class="tab-pane active" id="personal">
      <!-- form start -->
      <div class="box-body">
         <div class="tab-pane" id="academic">
            <?php echo $this->Form->create($studentss, array(
               'class'=>'form-horizontal',
               'id' => 'sevice_form',
               'enctype' => 'multipart/form-data'
               
               
               )); ?>
            <div class="box-body">
               <div class="row">
                  <!--/.col (left) -->
                  <!-- right column -->
                  <div class="col-md-12">
                     <!-- Horizontal Form -->
                     <div class="box box-info">
                        <div class="box-header with-border">
                           <h3 class="box-title">Update Profile Picture (JPEG/JPG only)</h3>
                        </div>
                        <?php echo $this->Flash->render(); ?>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                           <section class="content-header container-fluid">
                              <script>
                                 function fileValidation(){
                                     var fileInput = document.getElementById('rem');
                                     var filePath = fileInput.value;
                                     var allowedExtensions = /(\.jpg|\.jpeg)$/i;
                                     if(!allowedExtensions.exec(filePath)){
                                         alert('Please upload file having extensions .jpeg/.jpg only.');
                                         fileInput.value = '';
                                         return false;
                                     }else{
                                         //Image preview
                                         if (fileInput.files && fileInput.files[0]) {
                                             var reader = new FileReader();
                                             reader.onload = function(e) {
                                                 document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
                                             };
                                             reader.readAsDataURL(fileInput.files[0]);
                                         }
                                     }
                                 }
                                 
                                 
                                 
                              </script>
                              <h3 class="col-sm-6 " id="upl">
                                 <i class="fa fa-eye" ></i> Upload Image  (JPEG/JPG only)| <small><?php echo ucfirst($students['fname']); ?> <?php echo $students['middlename']; ?> <?php echo $students['lname']; ?> (<?php echo $students['enroll']; ?>)</small>        
                              </h3>
                           </section>
                           <div class="form-group" >
                              <div class="col-sm-6" id="upll"> 
                                 <label for="inputEmail" class="control-label"></label>
                                 <?php echo $this->Form->input('photo',array('class'=>'form-control', 'onchange'=>'return fileValidation()','type'=>'file','required','placeholder'=>'Choose File', 'id'=>'rem','label' =>false)); ?>
                              </div>
                           </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                           <?php
                              if(isset($students['id'])){
                              echo $this->Form->submit(
                                  'Update', 
                                  array('class' => 'btn btn-info pull-left',  'title' => 'Update')
                              ); }else{ 
                              echo $this->Form->submit(
                                  'Add', 
                                  array('class' => 'btn btn-info pull-left', 'title' => 'Add')
                              );
                              }  ?>
                           <?php
                              echo $this->Html->link('Back', [
                                  'action' => 'view/'.$students['id']
                                 
                              ],['class'=>'btn btn-default pull-right']); ?>
                        </div>
                        <!-- /.box-footer -->
                     </div>
                  </div>
                  <!--/.col (right) -->
               </div>
               <!-- /.row -->
            </div>
            <?php
               echo $this->Form->end();
               ?>  
         </div>
      </div>
</section>
<!-- /.content -->
</div>