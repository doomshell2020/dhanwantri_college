 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Hostel Manager
       
      </h1>
              <ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>hostels/index">Manage Hostel </a></li>
	      </ol>   
      
      
     <?php echo $this->Flash->render(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <h3 class="box-title">Hostel List</h3>           
            </div>
            
            <!-- /.box-header -->

 <div class="row">
        <div class="col-xs-12">
	<div class="box">
       				<div class="clearfix">
<a href="<?php echo SITE_URL; ?>admin/hostels/add">
<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
Add Hostel</button></a>

</div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#</th>
                   <th>Name</th>
                  <th>Type</th>
                   <th>Warden Name</th>
                   <th>Warden Mobile</th>
                     <th>Fees</th>
                     <th>Last submission date</th>
                        <th>Academic Year</th>
                  <th>Status</th>
		  <th>Action</th>	
                </tr>
                </thead>
                <tbody>
		<?php $page = $this->request->params['paging']['Services']['page'];
		$limit = $this->request->params['paging']['Services']['perPage'];
		$counter = ($page * $limit) - $limit + 1;
		if(isset($hostels) && !empty($hostels)){ 
		foreach($hostels as $service){
		?>
                <tr>
                  <td><?php echo $counter;?></td>
                     <td><?php if(isset($service['name'])){ echo ucfirst($service['name']);}else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['type'])){ if($service['type']=="0"){ echo "Boys";}elseif($service['type']=="1"){ echo "Girls"; }else{ echo 'N/A'; } }?></td>
                  <td><?php if(isset($service['wardenname'])){ echo ucfirst($service['wardenname']);}else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['w_mobile'])){ echo ucfirst($service['w_mobile']);}else{ echo 'N/A'; } ?></td>
                  <td><span class="text-black">&#8377; </span><?php if(isset($service['fees'])){ echo ucfirst($service['fees']);}else{ echo 'N/A'; } ?></td>
          <td><?php if(isset($service['lastdate'])){ echo date('d-m-Y',strtotime($service['lastdate']));}else{ echo 'N/A'; } ?></td>
          <td><?php if(isset($service['academicyear'])){ echo $service['academicyear'];}else{ echo 'N/A'; } ?></td>
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
