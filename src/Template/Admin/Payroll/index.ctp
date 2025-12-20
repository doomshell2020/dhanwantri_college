 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Employee Manager
       
      </h1>
     <?php echo $this->Flash->render(); ?>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
	<div class="box">
            <div class="box-header">
              <h3 class="box-title">Employee List</h3>           
            </div>
            
            <!-- /.box-header -->

 <div class="row">
        <div class="col-xs-12">
	<div class="box">
		
       				<div class="clearfix">
						<?php if($pay['sync']!='1') { ?>
<a href="<?php echo SITE_URL; ?>admin/employee/add">
<button class="btn btn-success pull-right m-top10"><i class="fa fa-plus" aria-hidden="true"></i>
Add Employee</button></a>
<?php } ?>
<a href="<?php echo SITE_URL; ?>admin/employee/addcsv" class="btn btn-success pull-right m-top10" ><i class="fa fa-plus" aria-hidden="true"></i>Add Excel</a>

</div>
            <div class="box-body">
              <table id="" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>S.no</th>
                  <th>Eid</th>
                  <th>Name</th>
               
                   <th>Basic Salary</th>
                     <th>PF Number</th>
                  <th>Contact</th>
           
                  <th>DA</th>
                  <th>SD</th>
                  <th>Applicable Charges</th>
		  <th>Action</th>	
                </tr>
                </thead>
                <tbody>
		<?php $page = $this->request->params['paging']['Services']['page'];
		echo $page;
		$limit = $this->request->params['paging']['Services']['perPage'];
		$counter = ($page * $limit) - $limit + 1;
		if(isset($employee) && !empty($employee)){ 
		foreach($employee as $service){ //pr($service);
			$apl=array();
			if($service['leve']=='1'){
				$apl[]="Leave Deduction";
			}
			if($service['HRA']=='1'){
				$apl[]="HRA";
			}
			if($service['LTA']=='1'){
				$apl[]="LTA";
			}
			if($service['TA']=='1'){
				$apl[]="TA";
			}
			if($service['PF']=='1'){
				$apl[]="PF";
			}
			if($service['ESI_choice']=='1'){
				$apl[]="ESI";
			}
			if($service['EPS']=='1'){
				$apl[]="EPS";
			}
		
			
		?>
                <tr>
                  <td><?php echo $counter;?></td>
                  <td><?php if(isset($service['sanskar_eid'])){ echo ucfirst($service['sanskar_eid']);}else{ echo 'N/A'; } ?></td>
                  <td><?php if(isset($service['name'])){ echo ucfirst($service['name']);}else{ echo 'N/A'; } ?></td>
                
				  <td><?php if(isset($service['basicsalary'])){ echo ucfirst($service['basicsalary']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($service['pfnumber'])){ echo ucfirst($service['pfnumber']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($service['cnum'])){ echo ucfirst($service['cnum']);}else{ echo 'N/A'; } ?></td>
				  
				  <td><?php if(isset($service['Da'])){ echo ucfirst($service['Da']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($service['sd']) && !empty($service['sd'])){ echo ucfirst($service['sd']);}else{ echo 'N/A'; } ?></td>
				  <td><?php if(isset($apl) && !empty($apl)){ foreach($apl as $rty){ echo $rty.'<br>';  } }else{ echo 'N/A'; } ?></td>
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
