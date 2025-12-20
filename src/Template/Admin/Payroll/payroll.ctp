<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

<!-- Isolated Version of Bootstrap, not needed if your site already uses Bootstrap -->


<!-- Bootstrap Date-Picker Plugin -->


<!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->

<div class="box">

        	<div class="maincontentinner">
            	<?php include_once('admin_menus.ctp'); ?>
                <!--maintabmenu-->
                <div class="box-body" style="margin-left:200px">
                                           <div class="alert alert-success alert-dismissable" id="alert" style="display:none">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    <strong>Information!!&nbsp;</strong> Entary added
  </div>
                <div class="contenttitle radiusbottom0">
               
                </div>
                <div class="content" style="border:none">
               	<?php echo $this->Form->create($payroll, array(
                       
                       'class'=>'form-horizontal',
			'id' => 'sevice_form',
                       'enctype' => 'multipart/form-data'
                     	)); ?>
                	  <a href="#" id="pf" class="pull-right">PF Settings</a>	
          
			 <div id="abc">
				 <div class="form-group">
					<label class="col-sm-3 control-label">Sync Data</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
<label class="radio-inline"><input type="radio" name="sync" value="1" <?php if($payroll['sync']=='1'){ ?> checked <?php } ?>>Yes</label>
<label class="radio-inline"><input type="radio" name="sync" value="0" <?php if($payroll['sync']=='0'){ ?> checked <?php } ?>>No</label>

</div>
		
             </div>
             </div>
				 
				 
			  	 <div class="form-group">
					<label class="col-sm-3 control-label">PF Number</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('pfnumber', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'PF','required','label'=>false)); ?> 
</div>
		
             </div>
             </div>
			      	
			      	 <div class="form-group">
					<label class="col-sm-3 control-label">Employee Share </label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('employeesharepf', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Employee Share','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
			      	 <div class="form-group">
					<label class="col-sm-3 control-label">Employer Share in  EPF</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('employorsharepf', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Employer Share','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
             
             <div class="form-group">
					<label class="col-sm-3 control-label">Employer Share in  EPS</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('employorshareps', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Employer Share','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
			      	 <div class="form-group">
					<label class="col-sm-3 control-label"> PF  Administrator Charges</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('admchargespf', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Administrator Charges','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
			      	 <div class="form-group">
					<label class="col-sm-3 control-label">EDLI Charges</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('edi', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'EDLI','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
             
              <div class="form-group">
					<label class="col-sm-3 control-label">PF Deduction Above PF Slab</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
<input type="checkbox" name="abovepfslab" value="1" <?php if($payroll['abovepfslab']=='1') { ?> checked <?php } ?> />
</div>
				
             </div>
             </div>
			       	 <div class="form-group">
					<label class="col-sm-3 control-label">EDLIS Administration Charges</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('EDLIS', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'EDLI','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
              <div class="form-group">
					<label class="col-sm-3 control-label">Inspection Charges</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('Inschargs', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Inspection Charges','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
			 	 <div class="form-group">
					<label class="col-sm-3 control-label">PF Slab(Basic + DA)</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('pfabpamt', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Amount','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
			 
			  <div class="form-group">
					<label class="col-sm-3 control-label">PF Limit of Employee</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('emprangepf', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Employee','required','label'=>false)); ?> 
</div>
				
             </div>

             </div>
			 
</div>
                
           	 <div class="form-group">
		
             </div>
                <a href="#" id="esi" class="pull-right">ESI Setting</a>
                   
                <div id="xyz">
				
				 <div class="form-group">
					<label class="col-sm-3 control-label">ESI Slab(Basic + DA)</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('esiamtap', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Amount','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
			 
			 	 <div class="form-group">
					<label class="col-sm-3 control-label">Employee Share</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('employeeshareeesi', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Amount','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
			  <div class="form-group">
					<label class="col-sm-3 control-label">EmployerShare</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('employorshareeesi', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Amount','required','label'=>false)); ?> 
</div>
				
             </div>
             </div>
			 

				
				
				
				
				</div>
                
             
                           	 <div class="form-group">
					<label class="col-sm-3 control-label">HRA Applicable</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('hra', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'HRA','required','label'=>false)); ?> <span class="input-group-addon" id="basic-addon1">Enter value in %</span>
</div>
				
             </div>
             </div>
                
                  	 <div class="form-group">
					<label class="col-sm-3 control-label">Travel allowance Applicable</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('travel', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Travel allowance','required','label'=>false)); ?> <span class="input-group-addon" id="basic-addon1">Enter value in %</span>
</div>
				
             </div>


             </div>

                           	 <div class="form-group">
					<label class="col-sm-3 control-label">LTA</label>
					<div class="field col-sm-6">
						<div class="input-group">
  
 <?php echo $this->Form->input('lta', array('class' => 
					'longinput form-control','maxlength'=>'20','required','placeholder'=>'Travel allowance','required','label'=>false)); ?> <span class="input-group-addon" id="basic-addon1">Enter value in %</span>
</div>
				
             </div>

             
       


                         
                
	
                 <p>
                <label>&nbsp;</label>
                <span class="field">
                  			<?php
				if(isset($payroll['id'])){
				echo $this->Form->submit(
				    'Update', 
				    array('class' => 'btn btn-info pull-right', 'title' => 'Update')
				); }
		       ?>
                </p>

                <?php echo $this->Form->end();?>   	
                               </div>   
                    </div>
                </div><!--content-->
                
            </div><!--maincontentinner-->

<script>

    $("#pf").click(function(){
     $("#abc").toggle();
    });

	
	   $("#esi").click(function(){
     $("#xyz").toggle();
    });

</script>
