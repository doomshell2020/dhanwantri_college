
<div class="box-header">
	<h3 class="box-title"><i class="fa fa-check-square"></i> Employee Attendance</h3>
</div>  
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
              
	      <thead>

	        <tr>
	        
	          <th>#</th>
	          <th>Employee Id</th>
	          <th>Employee Name</th>
	          <th>Department</th>
	          <th>Designation</th>
	          <th>Shift</th>
	          <th class="text-center">Time-in</th>
	          <th class="text-center">Time-out</th>
	          <th>Overtime</th>
	          <th></th>
	        
	        </tr>

	      </thead>

	      <tbody>
<?php 

$page = $this->request->params['paging']['Employees']['page'];
$limit = $this->request->params['paging']['Employees']['perPage'];
$counter = ($page * $limit) - $limit + 1;

if(isset($employees) && !empty($employees)){ 
	foreach($employees as $work){
		// pr($shifts);
	
?>
		<tr>
			<td><?php echo $counter; ?></td>
			
			<td><?php if(isset($work['employee']['id'])){ echo $work['employee']['id'];}else{ echo 'N/A';}?></td>

			<td>
				<?php
					if(isset($work['employee']['fname']))
					{ 
						echo ucfirst($work['employee']['fname'])." ".ucfirst($work['employee']['middlename'])." ".
						ucfirst($work['employee']['lname']);
					}
					else { echo 'N/A'; }
				?>
			</td>

			<td>
				<?php
					if(isset($work['employee']['department']['name'])){ echo ucfirst($work['employee']['department']['name']); }
					else { echo 'N/A'; }
				?>
			</td>

			<td>
				<?php
					if(isset($work['employee']['designation']['name'])){ echo ucfirst($work['employee']['designation']['name']); }
					else{ echo 'N/A'; }
				?>		
			</td>

			<td>
				<?php echo $shifts['name'].' ('.date('h:i a',strtotime($shifts['start_time'])).' - '.
				date('h:i a',strtotime($shifts['end_time'])).')'; ?>
			</td>

			<td class="text-center">
				<?php  if(date('h:i a',strtotime($work['time_in']))!='12:00 am'){ echo date('h:i a',strtotime($work['time_in']));}else{ echo "Absent"; } ?>
			</td>
			
			<td class="text-center">
				<?php   if(date('h:i a',strtotime($work['time_in']))!='12:00 am'){ echo date('h:i a',strtotime($work['time_out'])); }else{ echo "Absent"; } ?>
			</td>

			<td>
				<?php  if(date('h:i a',strtotime($work['time_in']))!='12:00 am'){
					$datetime1 = new DateTime($work['time_out']);
					$datetime2 = new DateTime($shifts['end_time']);
					
					$over_time = $datetime1->diff($datetime2);
					echo $over_time->format('%H')." : ".$over_time->format('%I');
					
					}else{
					
					echo "0.00";
					
					}
				?>
			</td>

			<td>
				<a href="<?= SITE_URL ?>admin/EmployeeAttendance/update_time/<?= $work['id'] ?>" title="Update" data-target="#globalModal" 
				data-toggle="modal" class='global1'>
					<span class="glyphicon glyphicon-pencil"></span>
				</a>
			</td>
			
		</tr>

		<?php 

		$counter++;

	} } else{ 

		?>

		<tr>
			<td>No Data Available</td>
		</tr>

		<?php } ?>

	</tbody>

</table>
</div>

<div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="loader">
					<div class="es-spinner">
						<i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {

    	$(".global1").click(function(event){

        //load content from href of link
        $('.modal-content').load($(this).attr("href"));

      });
  }); 
</script>
