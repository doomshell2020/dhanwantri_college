 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   
    <section class="content-header">
      <h1>
          Document Category Manager
       
       
      </h1>
     <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>Documentcategory/index">Manage Document Category</a></li>
	      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
					<?php echo $this->Flash->render(); ?>

          
<h3 class="box-title">Add Document Category</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
	

<div class="manag-stu">

	 <?php echo $this->Form->create('Documentcategory',array('url'=>array('controller'=>'Documentcategory','action'=>'add'),'type'=>'file','class'=>'form-horizontal')); ?>


  
  <div class="form-group">
    
       
 <div class="col-sm-3">
 <label>Title<span>*</span></label>
     <?php echo $this->Form->input('categoryname',array('class'=>'form-control','placeholder'=>'CategoryName', 'id'=>'title','label' =>false,'required')); ?>
    </div>
    
    
 <div class="col-sm-3">
 <label>Alias<span>*</span></label>
      <?php echo $this->Form->input('alias',array('class'=>'form-control','placeholder'=>'Alias', 'id'=>'title','label' =>false,'required')); ?>
    </div>   
  
    <div class="col-sm-3">
 <label>Category<span>*</span></label></br>
  <span>						
 <input class="longinput"  value="0" name="type" id="ten_document1"  type="radio" /><strong>For Employees</strong></span>&nbsp;&nbsp;&nbsp;
 <span><input class="longinput" value="1"  type="radio"  id="ten_document2" name="type" /><strong>For Student</strong> </span>&nbsp;&nbsp;&nbsp;
                <span><input class="longinput" value="2" type="radio"  id="ten_document3" name="type" /><strong>Both</strong>
               

</span> </div>  
    
 
    <div class="col-sm-3">

		      
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
		       ?>    </div>
  </div>
     <?php
echo $this->Form->end();
?>   
  
</div>
				
				</div>
				
					</div>	</div>	</div>
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <h3 class="box-title">Category List</h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  
                                  <th>Alias</th><th>Type</th>

                  <th>Action</th>	
                </tr>
                </thead>
                <tbody>
		<?php $page = $this->request->params['paging']['classes']['page'];
		$limit = $this->request->params['paging']['classes']['perPage'];
		$counter = ($page * $limit) - $limit + 1;
		if(isset($classes) && !empty($classes)){ 
		foreach($classes as $work){
//pr($work);
		?>
                <tr>
                  <td><?php echo $counter;?></td>
				                   

                  <td><?php if(isset($work['categoryname'])){ echo ucfirst($work['categoryname']);}else{ echo 'N/A';}?></td>
				  
                  <td><?php if(isset($work['alias'])){ echo ucfirst($work['alias']);}else{ echo 'N/A';}?></td>
           
                  <td><?php if($work['type']=='0'){ echo "For Employee"; }elseif($work['type']=='1'){ echo "For Students"; }else{ echo 'Both';} ?></td>
           
                   <td><?php
			echo $this->Html->link('Edit', [
			    'action' => 'add',
			    $work->id
			],['class'=>'btn btn-primary']); ?>
		
	
			<?php
			echo $this->Html->link('Delete', [
			    'action' => 'delete',
			    $work->id
			],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); ?>
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
