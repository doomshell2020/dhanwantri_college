<!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	    <section class="content-header">
		      <h1>
			Class Fee Manager
		      </h1>
	    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
       
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
		    <div class="box-header with-border">
		      <h3 class="box-title"><?php  echo 'Edit Class Fee';  ?></h3>
		    </div>
            <!-- /.box-header -->
            <!-- form start -->

		<?php echo $this->Flash->render(); ?>

 
          
		

 
          
		<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal"  novalidate="novalidate" action="/school/admin/classfee/edit/<?php echo $id; ?>">
		   
		      <div class="box-body">
				    
  <div class="form-group">
    
    <div class="col-sm-4">
 <label>Select Class</label>
   	<?php if($alldata[0]){  
		echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Class','options'=>$classlist,'value'=>$alldata[0]['class_id'],'label' =>false,'required','disabled')); }else{  
		echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Class','options'=>$classlist,'label' =>false,'required'));
		} ?>
    </div>  
 <div class="col-sm-4">
 <label>Acedamic Year </label>
      <select class="form-control" disabled="disabled" name="academic_year" required="required">
  <option value="">--- Select Acedamic Year ---</option>
 <?= $year=date("Y");  $exyear=$year+4; ?>

  <?php for ($i = $year; $i <= $exyear; $i++) :  $rt=$i+1; $rt= substr($rt,2); $ar=$i.'-'.$rt; ?> 
        <option  value="<?php echo $i; ?>-<?php echo  $rt;?>" <?php if($ar==$alldata[0]['academic_year']){ echo "selected";  } ?>><?php echo $i; ?>-<?php echo  $rt;?></option>
    <?php endfor; ?>
</select>
    </div>  
  

  
  </div>
		           <table class="table table-bordered table-striped">
        		<thead>


        			<tr><th class="text-center bg-teal color-palette">Fees Heads</th>
        				        			<th class="text-center bg-teal color-palette">1st Quater</th>
        				        			<th class="text-center bg-teal color-palette">2nd Quater</th>
        				        			<th class="text-center bg-teal color-palette">3rd Quater</th>
        				        			<th class="text-center bg-teal color-palette">4th Quater</th>
        				        			</tr>
        		</thead>
        		<tbody>
					<?php 	  if(isset($alldata) && !empty($alldata)){  
		foreach($alldata as $key=>$work){ ?>
			<tr>
                            <td class="text-center text-bold">
								<input type="hidden" name="fee_h_id[]" value="<?php echo $work['feeshead']['id']; ?>"><?php echo $work['feeshead']['name']; ?></td>
                            <td class="text-center text-bold">
								<input type="text" name="qu1_fees[]"  value="<?php echo $work['qu1_fees']; ?>"></td>
                            <td class="text-center text-bold">
								<input type="text" name="qu2_fees[]"  value="<?php echo $work['qu2_fees']; ?>" ></td>
                            <td class="text-center text-bold">
								<input type="text" name="qu3_fees[]"  value="<?php echo $work['qu3_fees']; ?>" ></td>
                            <td class="text-center text-bold">
								<input type="text" name="qu4_fees[]"   value="<?php echo $work['qu4_fees']; ?>"></td>
                   
		
		
		
		  
			
			
   <?php  }   ?>
        			        		
        			        				<?php  }else{  ?>
        			        			<tr><td class="text-center text-bold" colspan="7">No Data Selected</td>
        			        				</tr><?php } ?>
        			        		</tbody>
    		</table>
		        
		      </div>
		      <!-- /.box-body -->
		      <div class="box-footer">
			<?php
			echo $this->Html->link('Back', [
			    'action' => 'index'
			   
			],['class'=>'btn btn-default']); ?>
		      
			<?php
				if(isset($classes['id'])){
				echo $this->Form->submit(
				    'Update', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
				); }else{ 
				echo $this->Form->submit(
				    'Add', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Add')
				);
				}
		       ?>
		      </div>
		      <!-- /.box-footer -->
		  <?php echo $this->Form->end(); ?>
          </div>
         
     


          </div>
         
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>




