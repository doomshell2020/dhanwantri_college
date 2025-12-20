 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Hostel Room Manager
       
      </h1>
      		               <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>hostelrooms/index">Manage Hostel Room</a></li>
	      </ol>     
      
      
     <?php echo $this->Flash->render(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <h3 class="box-title">Room List</h3>           
            </div>
            
            <!-- /.box-header -->

 <div class="row">
        <div class="col-xs-12">
	<div class="box">
       				<div class="clearfix">
<a href="<?php echo SITE_URL; ?>admin/hostelrooms/add">
<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
Add Hostel Rooms</button></a>

</div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                  <th>Hostel Name</th>
                  <th>Hostel Type</th>
                  <th>No Of Floor</th>
                  <th>No Of Rooms</th>
                   <th>Capacity</th>
                   <th>EPBX</th>
                  <th>Status</th>
		  <th>Action</th>	
                </tr>
                </thead>
                <tbody>
		<?php $page = $this->request->params['paging']['Services']['page'];
		$limit = $this->request->params['paging']['Services']['perPage'];
		$counter = ($page * $limit) - $limit + 1;
		if(isset($hostelrooms) && !empty($hostelrooms)){ 
		foreach($hostelrooms as $service){ //pr($service);
		?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td><?php if(isset($service['hostel']['name'])){ echo ucfirst($service['hostel']['name']);}else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['type'])){ echo ucfirst($service['type']);}else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['floor_no'])){ echo ucfirst($service['floor_no']."&nbsp;Floor");}else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['room_no'])){ echo ucfirst($service['room_no']."&nbsp;Rooms");}else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['capacity'])){ echo ucfirst($service['capacity']);}else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['epax'])){ echo ucfirst($service['epax']);}else{ echo 'N/A'; } ?></td>
                
       
                  <td><?php if($service['status']=='Y'){ 
			echo $this->Html->link('Activate', [
			    'action' => 'status',
			    $service->id,
			     $service['status'],
			       $service['h_id']		
			],['class'=>'label label-success']);
			
			 }else{ 
				echo $this->Html->link('Deactivate', [
			    'action' => 'status',
			    $service->id,
			     $service['status'],
			            $service['h_id']	
			],['class'=>'label label-primary']);
				
			 } ?>
		</td>
		<td><?php
			echo $this->Html->link('Edit', [
			    'action' => 'add',
			    $service->id
			],['class'=>'btn btn-primary']); ?>
			<?php  /*
			echo $this->Html->link('View', [
			    'action' => 'view',
			    $service->id
			],['class'=>'btn btn-success']); */ ?>
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
