

<?php 
foreach($designations as $key=>$value){
  $array[$key]=str_replace(";"," ",$value);
} 
echo $this->Form->input('teacher_id[]',array('class'=>'form-control','type'=>'select','id'=>'elp','empty'=>'Select Teachers','options'=>$array,'label' =>false,'multiple')); 
