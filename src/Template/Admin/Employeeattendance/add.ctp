<script type="text/javascript">
		$('.close').click(function(){
			$('.modal-body').html("<div class='loader'><div class='es-spinner'><i class='fa fa-spinner fa-pulse fa-5x fa-fw'></i></div></div>");

		});
		$('.close1').click(function(){ 
			$('.modal-body').html("<div class='loader'><div class='es-spinner'><i class='fa fa-spinner fa-pulse fa-5x fa-fw'></i></div></div>");

		});
	</script>

	<div class="modal-header">
        <button type="button" class="close cls" data-dismiss="modal">
        	<span aria-hidden="true">×</span><span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="modalLabel"><i class="fa fa-calendar"></i>
			Assign Lecture  - <?php echo $weekname; ?>		</h4>
		<small>
			<strong> Class </strong> : <?php echo $classtitle; ?>		</small> |
		<!-- <small>
			<strong> Section </strong> :
			<?php echo $sectiontitle; ?>		</small> | -->
		<small>
			<strong> Lecture </strong> :
			<?php echo $name1; ?>		</small>
			<!-- <small> 
			<strong> Classteacher </strong> :
			<?php echo $employeefname; ?> - <?php echo $employeetlname; ?>		</small> -->
	</div> <!-- /.modal-header -->

		<?php echo $this->Form->create($timestable , array(
                       
                       'class'=>'form-horizontal',
			'id' => 'timestable_form',
                       'enctype' => 'multipart/form-data',
                       'validate'
                     	)); ?>
	<div class="modal-body">
	    		
		         <div id="s-id">
 <!--  <div class="form-group">
<label for="inputEmail3" class="col-sm-2 control-label">Subject</label>

		          <div class="col-sm-10">
	<?php 

	/*echo $this->Form->input('subject_id',array('class'=>'form-control','type'=>'select','empty'=>'Select Subject','options'=>$subject,'label' =>false,'required'));*/

 ?>  
  
		     </div>
       
		           </div> -->
		          
          <div class="form-group">
          	<?php echo $this->Form->input('class_id',array('class'=>'form-control','type'=>'hidden','empty'=>'Select Class','id'=>'c-id','required','value'=>$classsec_id,'label' =>false)); ?>  

 <?php echo $this->Form->input('timetable_id',array('class'=>'form-control','type'=>'hidden','empty'=>'Select Class','id'=>'c-id','required','value'=>$tt_id,'label' =>false)); ?>      
	<?php echo $this->Form->input('weekday',array('class'=>'form-control','type'=>'hidden','empty'=>'Select Class','id'=>'c-id','required','value'=>$weekname,'label' =>false)); ?>  

	
		          <label for="inputEmail3" class="col-sm-2 control-label">Employee</label>

		          <div class="col-sm-10">
	<?php   foreach($employee as $key=>$value){
  $array[$key]=str_replace(";"," ",$value);

} 
 echo $this->Form->input('new_empid',array('class'=>'form-control','type'=>'select','empty'=>'Select Employee','options'=>$array,'required', 'label' =>false)); ?>  
 <span class="msg<?php echo $c;?><?php echo $a;?><?php echo $b;?>" style="color:red;"></span>
		           
		          </div>
		                </div> 
		            




             </div>
			 
			
		
	</div> <!-- /. modal-body -->
   <div class="modal-footer">
        <button type="submit" id="sum" class="btn btn-primary pull-left">Assign</button>		<button type="button" class="close1 btn btn-default" data-dismiss="modal">Close</button>   </div> <!-- /. modal-footer -->
</form>
            
	
		   
	<? /* ?>	    

<script>
$(document).ready(function(){
	
$('.emp<?php echo $c;?><?php echo $a;?><?php echo $b;?>').on('change',function(){

var id =$(this).val();
var tid='<?php echo $tt_id; ?>';
var week='<?php echo $weekname; ?>';
//alert(week);
$.ajax({ 
        type: 'POST', 
        url: '<?php echo ADMIN_URL ;?>Employeeattendance/teacheroccupy',
        data: {'empid':id, 'tid':tid, 'week':week }, 
        success: function(data){
        	 //alert(data);
        	if(data!=0){
        	
 	$('.msg<?php echo $c;?><?php echo $a;?><?php echo $b;?>').html(data);
 	$('.emp<?php echo $c;?><?php echo $a;?><?php echo $b;?>').val('');
 	$('.emp<?php echo $c;?><?php echo $a;?><?php echo $b;?>').focus();
 }else{
 		
 	$('.msg<?php echo $c;?><?php echo $a;?><?php echo $b;?>').html("");
        }
 },
        
    });

});
});
</script> 
	<? */ ?>
