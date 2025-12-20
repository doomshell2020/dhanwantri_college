<div class="modal-header">
   <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
   <h4 class="modal-title">
      <?php if(empty($selected)) { ?>
      <i class="fa fa-plus-square"></i> Add Subject
   </h4>
   <?php } else {  ?> 
   <i class="fa fa-plus-square"></i> Edit Subject</h4> 
   <?php } ?>
</div>
<?php 
   if(!empty($selected))
   {
   $sel=explode(",",$selected);
   }
   if(!empty($select1))
   {
   $opt=explode(",",$select1);
   }
   echo $this->Form->create($students,array('class'=>'form-horizontal','enctype' => 'multipart/form-data','novalidate')); 
   ?>
<div class="modal-body">
   <div class="row">
      <div class="col-sm-12">
         <div class="box-body">
            <!-- ---------------------- For 11 & 12 CBSE SubJects.  --------  -->
            <?php  if($class_id==12 || $class_id==13 || $class_id==15 || $class_id==17 || $class_id==20 || $class_id==22){ ?>
            <div class="form-group">
               <label for="inputEmail3" class="col-sm-2 control-label">Compulsory Subject</label>
               <div class="col-sm-10">
                  <?php echo $this->Form->input('comp_sid[]',array('class'=>'lko form-control','id'=>'comp','type'=>'select','multiple','options'=>$com,'value'=>$sel,'label' =>false));?> 
               </div>
            </div>
            <script>
               function myFunction() {
               
               		var t = $("#comp[multiple] option:selected").length;
               		var count = $("#opty[multiple] option:selected").length;
               		if(count>2){
               			alert("You can't select more than 2 optional subject");
               			return false;
               		}
               		var j= t+count;
               		if(j==5){
               			return true;
               		}else if(j==0){
               			alert("Select any 5 subjects.");
               			return false;
               		}else if(j<5){			
               			alert("Please select minimum 5 subjects.");
               			return false;
               		}else{
               			alert("You can select only 5 subjects.");
               			return false;
               		}
                   
               }
            </script>	    
            <div class="form-group">
               <label for="inputEmail3" class="col-sm-2 control-label">Optional Subject</label>
               <div class="col-sm-10">
                  <?php echo $this->Form->input('opt_sid.',array('class'=>'form-control opot','multiple','type'=>'select','id'=>'opty','options'=>$option,'value'=>$opt,'label' =>false)); ?> 
               </div>
            </div>
            <!-- ---------------------- For IBDP SubJects.  --------  -->
            <?php } else if($class_id==26 || $class_id==27) { ?>
            <script >
               function myFunction() {
                 var count1 = $(".gp1[multiple] option:selected").length;
                 var count2 = $(".gp2[multiple] option:selected").length;
                 var count3 = $(".gp3[multiple] option:selected").length;
                 var count4 = $(".gp4[multiple] option:selected").length;
                 var count5 = $(".gp5[multiple] option:selected").length;
                 var count6 = $(".gp6[multiple] option:selected").length;
                 var tot=count1+count2+count3+count4+count5+count6;
                 if(tot=='6'){
                 	return true;
                 }
               
               		        }	
               
               $('.gp3').click(function(){
               var jh = $(".gp3[multiple] option:selected").length;
               if(jh<='2'){
               	return true;
               }else{
               	alert("You can select only 2 subjects from group 3");
               	$(".gp3 option:selected").removeAttr("selected");
               }
               
               	  });
               
               $('.gp4').click(function(){
               	var yu = $(".gp4[multiple] option:selected").length;
               if(yu<='2'){
               	return true;
               }else{
               	alert("You can select only 2 subjects from group 4");
               	$(".gp4 option:selected").removeAttr("selected");
               }
               
               	  });
               
               		  $('.kl').click(function(){
                 var gh = $(".kl[multiple] option:selected").length;
               
                  //alert(yu);
               
               
               
               
                 if(gh>'3'){
                 	alert("You can select only 3 subjects from group 3 & 4.");
                 	$('.six').show();
                 	$(".kl option:selected").removeAttr("selected");
                 	return false;
                 }else if(gh=='3'){
                 	$(".gp6[multiple] option").prop("disabled", "disabled");
                 	$(".gp6 option:selected").removeAttr("selected");
               $('.six').hide();
               
               
                 }else{
                 	$(".kl option:selected").attr("selected");
               $('.six').show();
                 }
               		  });
               		   
               
               
               		        
            </script>
            <div style="height: 50vh; overflow: auto;">
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Group 1</label>
                  <div class="col-sm-10">
                     <?php echo $this->Form->input('comp_sid.',array('class'=>'gp1 form-control','type'=>'select','empty'=>'Select Subject','options'=>$ibsub1,'value'=>$sel,'label' =>false)); ?> 
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Group 2</label>
                  <div class="col-sm-10">
                     <?php echo $this->Form->input('comp_sid.',array('class'=>'gp2 form-control','type'=>'select','empty'=>'Select Subject','options'=>$ibsub2,'value'=>$sel,'label' =>false)); ?> 
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Group 3</label>
                  <div class="col-sm-10">
                     <?php echo $this->Form->input('comp_sid.',array('class'=>'gp3 kl form-control','type'=>'select','multiple','options'=>$ibsub3,'value'=>$sel,'id'=>'kl','onChange'=>'return findsub();','label' =>false)); ?> 
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Group 4</label>
                  <div class="col-sm-10">
                     <?php echo $this->Form->input('comp_sid.',array('class'=>'gp4 kl form-control','type'=>'select','multiple','options'=>$ibsub4,'value'=>$sel,'label' =>false)); ?> 
                  </div>
               </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Group 5</label>
                  <div class="col-sm-10">
                     <?php echo $this->Form->input('comp_sid.',array('class'=>'gp5 form-control','type'=>'select','empty'=>'Select Subject','options'=>$ibsub5,'value'=>$sel,'label' =>false)); ?> 
                  </div>
               </div>
               <div class="six form-group" >
                  <label for="inputEmail3" class="col-sm-2 control-label">Group 6</label>
                  <div class="col-sm-10">
                     <?php echo $this->Form->input('comp_sid.',array('class'=>'gp6 form-control','type'=>'select','empty'=>'Select Subject','options'=>$ibsub6,'value'=>$sel,'label' =>false)); ?> 
                  </div>
               </div>
            </div>
            <!-- ---------------------- For Class Vatika To 10th  SubJects.  --------  -->
            <?php } else { ?>
            <div class="form-group">
               <label for="inputEmail3" class="col-sm-2 control-label">Compulsory Subject</label>
               <div class="col-sm-10">
                  <?php echo $this->Form->input('comp_sid.',array('class'=>'form-control','type'=>'select','multiple','empty'=>'Select Subject','options'=>$com,'value'=>$sel,'label' =>false)); ?> 
               </div>
            </div>
            <?php } ?>
            <?php if(isset($selected)) { ?>
            <script>
               $('.gp6').click(function(){
               
               $(".kl option:selected").removeAttr("selected");
               });
               
               
               
               
               	        
            </script>
            <?php } ?>
         </div>
      </div>
   </div>
</div>
<!--./modal-body-->
<div class="modal-footer">
   <button data-dismiss="modal" class="btn btn-default pull-right" type="button">Close</button>
   <?php
      if(isset($selected)){
      echo $this->Form->submit(
          'Update', 
          array('class' => 'btn btn-info pull-left','style'=>'', 'title' => 'Update')
      );
       }else{ 
      echo $this->Form->submit(
          'Add', 
          array('class' => 'add btn btn-info pull-left ','style'=>'margin-right: 10px;', 'title' => 'Add','id'=>'','onClick'=>'return myFunction();')
      );
      }
           ?>   
</div>
<!--./modal-footer-->
</form>
<script>
   //  alert("hi");
         $('#datepicksd').datepicker({"changeMonth":true,'maxDate':'0',"yearRange":"1980:2018","changeYear":true,"autoSize":true,"autoclose":true,"dateFormat":"dd-mm-yy","todayHighlight":'TRUE'});
          
          $('#datepicksd').datepicker().on('changeDate', function(ev)
   {                 
      $('.datepicker').hide();
   });
     
</script> 
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>