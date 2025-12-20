 <!-- Content sssWrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bank Manager
		
      </h1>
         <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>banks/index">Manage Bank</a></li>
	      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <h3 class="box-title">Add Bank</h3>
             <?php echo $this->Flash->render(); ?>    
                  
		     <div class="box-body">  
<?php echo $this->Form->create($banks, array(
                       'class'=>'form-horizontal',
		              	'id' => 'sevice_form',
                       'enctype' => 'multipart/form-data'
                       
                     	)); ?>
                     	
				   <div class="form-group">
		        <label class="col-sm-2">Bank Name<span style="color:red;">*</span></label>
		         <div class="col-sm-5">
		<?php echo $this->Form->input('name',array('class'=>'form-control','placeholder'=>'Bank Name','required'=>true, 'id'=>'title','label' =>false)); ?>
		          </div>	             
		          
		     </div>     
		  
		     <div class="form-group">
             <div class="col-sm-12" style="margin-top: 10px;">
      <button type="submit" class="btn btn-success">Submit</button>
      <?php if(empty($ids) && !isset($ids)) {?>
       <button type="reset" class="btn btn-primary" id="re">Reset</button>
       <?php } else {
       
			echo $this->Html->link('Back', [
			    'controller' => 'banks',
			    'action' => 'index'
			   
			],['class'=>'btn btn-default']); 
      } ?>
    </div>
  </div>
  
<?php echo $this->Form->end(); ?>  
              
          
		       </div>   
</div>

		     <div class="box-body">    
		      <h3 class="box-title">Bank List</h3>
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Status</th>
		  <th>Action</th>	
                </tr>
                </thead>
                <tbody>
		<?php $page = $this->request->params['paging']['Services']['page'];
		$limit = $this->request->params['paging']['Services']['perPage'];
		$counter = ($page * $limit) - $limit + 1;
		if(isset($bankss) && !empty($bankss)){ 
		foreach($bankss as $service){
		?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td><?php if(isset($service['name'])){ echo ucfirst($service['name']);}else{ echo 'N/A'; } ?></td>
                 
                
                  <td><?php if($service['status']=='Y'){ 
			echo $this->Html->link('Activate', [
			    'action' => 'status',
			    $service->id,
			     $service['status']	
			],['class'=>'label label-success']);
			
			 }else{ 
				echo $this->Html->link('Deactivate', [
			    'action' => 'status',
			    $service->id,
			     $service['status']
			],['class'=>'label label-primary']);
				
			 } ?>
		</td>
		<td><?php
			echo $this->Html->link('Edit', [
			    'action' => 'index',
			    $service->id
			],['class'=>'btn btn-primary']); ?>
			<?php /*
			echo $this->Html->link('View', [
			    'action' => 'view',
			    $service->id
			],['class'=>'btn btn-success']); */?>
			<?php  
			echo $this->Html->link('Delete', [
			    'action' => 'delete',
			    $service->id
			],['class'=> 'btn btn-danger',"onClick"=>"javascript: return confirm('Are you sure do you want to delete this')"]); ?></td>
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

<script>
$(document).ready(function(){
$('.sort').on('change',function(){
var sort = $(this).val();
var id = $(this).attr('data-val');
 $.ajax({ 
        type: 'POST', 
        url: '<?php echo $this->Url->build('/admin/services/sort'); ?>',
        data: {'id':id,'sort':sort}, 
        success: function(data){  
           $('#sort').val(data);
        }, 
        
    });  
});
});

</script>
  <!-- /.content-wrapper -->
