 
         <div class="box-body">    
             <tr>
             <?php $role_id = $this->request->session()->read('Auth.User.role_id'); ?>
   <td><a id="" style="position: absolute;top: -35px;

right: 13px;" class="btn btn-info btn-sm pull-right" target="_blank" href="<?php echo ADMIN_URL ;?>Classections/classteacherpdf"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export PDF</a></td>
   </tr>
         
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                   <!-- <th>Email</th> -->
                   <th>Mobile</th>
                   <th>Password</th>
                  <th>Type</th>
                  <th>Class</th>
                  <th>Section</th>
                  <?php if($role_id == '5' || $role_id == '8'){ ?>
                  <th>Action</th> 

                  <?php } ?>
                </tr>
                </thead>
                <tbody>
    <?php $page = $this->request->params['paging']['Services']['page'];
   $limit = $this->request->params['paging']['Services']['perPage'];
    $counter = ($page * $limit) - $limit + 1;
    if(isset($classts) && !empty($classts)){ 
    foreach($classts as $service){// pr($service);
    ?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td><?php if(isset($service['employee']['fname'])){ echo ucwords(strtolower($service['employee']['fname'])).' '.ucwords(strtolower($service['employee']['middlename'])).' '.ucwords(strtolower($service['employee']['lname']));}else{ echo 'N/A'; } ?></td>
                  <!-- <td><?php //if(isset($service['employee']['username'])){ echo $service['employee']['username'];}else{ echo 'N/A'; } ?></td> -->
                     <td><?php if(isset($service['employee']['mobile'])){ echo $service['employee']['mobile'];}else{ echo 'N/A'; } ?></td>
                     <td><?php if(isset($service['employee']['id'])){  $dt=$this->Comman->findapass($service['employee']['id']); echo $dt['confirm_pass']; }else{ echo 'N/A'; } ?></td>
 <td><?php if(isset($service['teacher_type'])){ if($service['teacher_type']=='1'){echo "Class Teacher";}else{ echo "Co-Class Teacher"; } }else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['class_id'])){ echo ucfirst($service['class']['title']);}else{ echo 'N/A'; } ?></td>
                   <td><?php if(isset($service['section_id'])){ echo ucfirst($service['section']['title']);}else{ echo 'N/A'; } ?></td>
                 
                
                   <?php if($role_id == '5' || $role_id == '8'){ ?>
    <td><?php
      echo $this->Html->link('Edit', [
          'action' => 'classteacher_add',
          $service->id
      ],['class'=>'btn btn-primary']); ?>
      <?php /*
      echo $this->Html->link('View', [
          'action' => 'view',
          $service->id
      ],['class'=>'btn btn-success']); */?>
      <?php $role_id=$this->request->session()->read('Auth.User.role_id');   
      echo $this->Html->link('Delete', [
          'action' => 'deleteclassteacher',
          $service->id
      ],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]);   ?></td>
      <?php } ?>
                </tr>
    <?php $counter++; }}else{?>
    <tr>
    <td colspan="7" align="center" >NO Data Available</td>
    </tr>
    <?php } ?>  
                </tbody>
               
              </table>
            </div>
