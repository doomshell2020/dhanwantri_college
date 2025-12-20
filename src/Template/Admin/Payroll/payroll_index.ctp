 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Payroll Manager
       
      </h1>
     <?php echo $this->Flash->render(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <h3 class="box-title">Payroll Setting</h3>           
            </div>
            
            <!-- /.box-header -->

 <div class="row">
        <div class="col-xs-12">
	<div class="box">
       				<div class="clearfix">


</div>
            <div class="box-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.no</th>
                  <th>HRA</th>
                  <th>Travel</th>
                  <th>LTA</th>
                   <th>Inschargs</th>
                     <th>PF(E)</th>
                  <th>PF(O)</th>
                  <th>Admchargespf</th>
                  <th>EDLIS</th>
                  <th>ESI(E)</th>
                  <th>ESI(O)</th>
		  <th>Action</th>	
                </tr>
                </thead>
                <tbody>
		<?php $page = $this->request->params['paging']['Services']['page'];
		echo $page;
		$limit = $this->request->params['paging']['Services']['perPage'];
		$counter = ($page * $limit) - $limit + 1;
		if(isset($employee) && !empty($employee)){ 
		foreach($employee as $service){
			
		?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td><?php if(isset($service['id'])){ echo ucfirst($service['hra']);}else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['travel'])){ echo ucfirst($service['travel']);}else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['lta'])){ echo ucfirst($service['lta']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($service['Inschargs'])){ echo ucfirst($service['Inschargs']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($service['employeesharepf'])){ echo ucfirst($service['employeesharepf']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($service['employorsharepf'])){ echo ucfirst($service['employorsharepf']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($service['admchargespf'])){ echo ucfirst($service['admchargespf']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($service['EDLIS'])){ echo ucfirst($service['EDLIS']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($service['employeeshareeesi'])){ echo ucfirst($service['employeeshareeesi']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($service['employorshareeesi'])){ echo ucfirst($service['employorshareeesi']);}else{ echo 'N/A'; } ?></td>
		<td><?php
			echo $this->Html->link('Edit', [
			    'action' => 'payroll',
			    $service->id
			],['class'=>'btn btn-primary']); ?>
			<?php  /*
			echo $this->Html->link('View', [
			    'action' => 'view',
			    $service->id
			],['class'=>'btn btn-success']); */ ?>
</td>
                </tr>
		<?php $counter++;} } else{ ?>
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
