 <div class="form-group">
 	<label for="inputEmail3" class="col-sm-2 control-label">Subject</label>

 	<div class="col-sm-10">
 		<?php
			foreach ($timetabledatas as $key => $iteamss) {

				$as = $iteamss['Subjects']['id'];
				unset($subjectes[$as]);
			}
			if (!empty($subjectes)) {
				echo $this->Form->input('subject_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Subject', 'options' => $subjectes, 'label' => false, 'required'));
			} else {

				echo	$this->Form->input('subject_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Subject', 'options' => $subjectes, 'label' => false, 'required'));
			} ?>
 	</div>

 </div>
 <div class="form-group">
 	<label for="inputEmail3" class="col-sm-2 control-label">Employee</label>
 	<div class="col-sm-10">
 		<?php foreach ($employee as $key => $value) {
				$array[$key] = str_replace(";", " ", $value);
			}
			echo $this->Form->input('employee_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Employee', 'options' => $array, 'required', 'label' => false)); ?>
 	</div>
 </div>
 <div class="form-group">
 	<label for="inputEmail3" class="col-sm-2 control-label">Period (Timetable)</label>
 	<div class="col-sm-10">
 		<?php echo $this->Form->input('tt_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Period', 'options' => $timetables, 'label' => false, 'required')); ?>

 	</div>
 </div>