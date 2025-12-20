 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Admin User Management-<b><?php echo $academic_year; ?></b>
       
      </h1>
          <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>roles"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>roles/index">Manage Sections</a></li>
	      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
<h3 class="box-title"><?php if(isset($rolesnew['id'])){ ?>Edit User <?php }else{ ?>Add User  <?php } ?></h3>
              <?php echo $this->Flash->render(); ?>
      <?php echo $this->Form->create($rolesnew, array('class' => '', 'id' => 'sevice_form1', 'enctype' => 'multipart/form-data', 'validate', 'autocomplete' => 'off')); ?>
              
                <div class="box-body">
                    <div class="row">
                       
                    
                        <div class="col-sm-3 col-xs-6">
                            <label>Select Role<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('role_id', array('class' => 'form-control', 'required', 'type'=>'select', 'options'=>$roles, 'empty' => "--Select Role--", 'label' => false)); ?>
                        
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Board</label>
                            <?php  
                            echo $this->Form->input('board', array('class' => 'form-control',  'type'=>'select', 'options'=>$board, 'empty' => "--Select--", 'label' => false)); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Username<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('user_name', array('class' => 'form-control','type' => 'text', 'label' => false)); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>User Email<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('email', array('class' => 'form-control','type' => 'email', 'label' => false)); ?>
                        </div>
                       
                      
                    </div>    <div class="row"> <div class="col-sm-6 col-xs-12"> <br></div>  </div>  
                    <div class="row">
                    <div class="col-sm-3 col-xs-6">
                            <label>Mobile<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('mobile', array('class' => 'form-control', 'required', 'maxlength' => 10, 'id' => 'dup_mobile', 'placeholder' => 'Mobile', 'onkeypress' => 'return isNumber(event);', 'label' => false)); ?>
                            <script>
                        function isNumber(evt) {
                            evt = (evt) ? evt : window.event;
                            var charCode = (evt.which) ? evt.which : evt.keyCode;
                            if (charCode != 46 && charCode != 45 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                                alert("Please Enter Valid Value");
                                return false;
                            }
                            return true;
                        }
                        </script>
                        </div>

                        <?php if(isset($rolesnew['id'])){ ?>
                        <input type="hidden" name="id" value="<?php echo $rolesnew['id']; ?>">
                          <div class="col-sm-3 col-xs-6">
                            <label>Password<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('password', array('class' => 'form-control','type' => 'password','value'=>$rolesnew['confirm_pass'], 'label' => false)); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Confirm Password<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('confirm_pass', array('class' => 'form-control','type' => 'text','value'=>$rolesnew['confirm_pass'], 'label' => false)); ?>
                        </div>
                        <?php }else{ ?>
                    <div class="col-sm-3 col-xs-6">
                            <label>Password<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('password', array('class' => 'form-control','type' => 'password', 'label' => false)); ?>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <label>Confirm Password<span style="color:red;">*</span></label>
                            <?php echo $this->Form->input('confirm_pass', array('class' => 'form-control','type' => 'text', 'label' => false)); ?>
                        </div>

                        <?php } ?>
                        <div class="col-sm-3 col-xs-6">
                            <label></label>
                            <?php if(isset($rolesnew['id'])){ 
                              echo $this->Form->submit('Update User', array('class' => 'btn btn-info pull-right', 'style' => '', 'title' => 'Submit'));  }else{ ?>
                           <?php echo $this->Form->submit('Add User', array('class' => 'btn btn-info pull-right', 'style' => '', 'title' => 'Submit'));  } ?>
                        </div>
                       
                        
                    </div>
                  
                
          <?php echo $this->Form->end(); ?>      
          </div>
            <!-- /.box-header -->
<style>
#example1_wrapper #example1 tr td:last-child a {
    display: inline-block; 
}
</style>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Role</th>
                  <th>Username</th>
                  <th>User Email</th>
                  <th>Mobile</th>
                   <th>Created</th>
                   <th>Action</th>
                  <!--<th>Action</th>-->
                </tr>
                </thead>
                <tbody>
                <?php $page = $this->request->params['paging']['Users']['page'];
                $limit = $this->request->params['paging']['Users']['perPage'];
                $counter = ($page * $limit) - $limit + 1;
                if(isset($allusers) && !empty($allusers)){ 
                foreach($allusers as $work){
                ?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td><?php if(isset($work['role_id'])){ echo ucfirst($work['role']['name']);}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['user_name'])){ echo ucfirst($work['user_name']);}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['email'])){ echo $work['email'];}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['mobile'])){ echo ucfirst($work['mobile']);}else{ echo 'N/A';}?></td>
                  <td><?php if(isset($work['created'])){ echo date('d-m-Y',strtotime($work['created'])); }else{ echo 'N/A';}?></td>
         
         
    <td><a title="Edit User" href="<?php echo SITE_URL; ?>admin/roles/index/<?php echo $work->id; ?>"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></a> 
		 <a title="Assign Permission" href="<?php echo SITE_URL; ?>admin/permissionmodules/index/<?php echo $work->id; ?>/<?php echo $work['role_id']; ?>"><i class="fa fa-lock fa-2x" aria-hidden="true"></i></a>
     <?php if($work['role_id']!=1){ ?>
      <a  title="Delete User" onClick="javascript: return confirm('Are you sure do you want to delete this')" href="<?php echo SITE_URL; ?>admin/roles/delete/<?php echo $work->id; ?>"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a> 
    <?php } ?>
		  </td> 
		
                </tr>
		<?php $counter++;} }else{?>
		<tr>
		<td>NO Data Available</td>
		</tr>
		<?php } ?>	
                </tbody>
               
              </table>
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
