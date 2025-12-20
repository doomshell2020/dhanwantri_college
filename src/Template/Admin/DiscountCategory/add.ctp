<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Document Category Manager
       
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
       <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		      <h3 class="box-title"><?php if(isset($department['id'])){ echo 'Edit Document Category'; }else{ echo 'Add Document Category';} ?></h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->
<?php //pr($page); die; ?>
		<?php echo $this->Flash->render(); ?>

 
            
		<?php echo $this->Form->create($department , array(
                       
                       'class'=>'form-horizontal',
			'id' => 'work_form',
                       'enctype' => 'multipart/form-data',
                       'novalidate'
                     	)); ?>
		   
		      <div class="box-body">
		        <div class="form-group">
		        

		          <div class="col-sm-3">  <label for="inputEmail3" class=" control-label">Title</label>
			<?php echo $this->Form->input('categoryname',array('class'=>'form-control','placeholder'=>'CategoryName', 'id'=>'title','label' =>false,'required')); ?>
		           
		          </div>
				  

		          <div class="col-sm-3"> <label for="inputEmail3" class="control-label">Alias</label>
			<?php echo $this->Form->input('alias',array('class'=>'form-control','placeholder'=>'Alias', 'id'=>'title','label' =>false,'required')); ?>
		           
		          </div>
				    <label>Category<span>*</span></label></br>
 <div class="col-sm-3">					
 <input class="longinput"  value="0" name="type" id="ten_document1"  type="radio" />
 <strong> For Employees</strong></span>
 &nbsp;&nbsp;&nbsp;
 <span><input class="longinput" value="1"  type="radio"  id="ten_document2" name="type" /><strong> For Student</strong> </span>&nbsp;&nbsp;&nbsp;
                <span><input class="longinput" value="2" type="radio"  id="ten_document3" name="type" /><strong> Both</strong>
               

 </div>
		 
		        
			      </div> 
			
		        
		      </div>
		      <!-- /.box-body -->
		      <div class="box-footer">
			
			<?php
				if(isset($department['id'])){
				echo $this->Form->submit(
				    'Update', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
				); }else{ 
				echo $this->Form->submit(
				    'Add', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Add')
				);
				}
		       ?><?php
			echo $this->Html->link('Back', [
			    'action' => 'index'
			   
			],['class'=>'btn btn-default']); ?>
		      
		      </div>
		      <!-- /.box-footer -->
		  <?php echo $this->Form->end(); ?>
          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>




