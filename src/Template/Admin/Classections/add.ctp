<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Class Sections Manager
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>classections/index"><i class="fa fa-home"></i>Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>classections/index">Manage Class Sections</a></li>
			<li class="active">Create Class Sections</li>
		</ol>


	</section>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#test").keyup(function() {

				var val = $("#test").val();
				if (parseInt(val) < 0 || isNaN(val)) {
					alert("please enter valid capacity!!");
					$("#test").val("");
					$("#test").focus();
				}
			});
		});
		$(document).ready(function() {
			$("#test1").keyup(function() {
				var val = $("#test1").val();
				if (parseInt(val) < 0 || isNaN(val)) {
					alert("please enter valid strength!!");
					$("#test1").val("");
					$("#test1").focus();
				}
			});
		});
	</script>
	<!-- Main content -->
	<section class="content">
		<div class="row">

			<!-- right column -->
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"><?php if (isset($classes['id'])) {
													echo 'Edit Class Section';
												} else {
													echo 'Add Class Section';
												} ?></h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->

					<?php echo $this->Flash->render(); ?>



					<?php echo $this->Form->create($classes, array(

						'class' => 'form-horizontal',
						'id' => 'sevice_form',
						'enctype' => 'multipart/form-data'

					)); ?>

					<div class="box-body">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">&nbsp;&nbsp;&nbsp;Select Class <span style="color:red">*</span></label>

							<div class="col-sm-2">
								<?php echo $this->Form->input('class_id', array('class' => 'form-control', 'type' => 'select', 'id' => 'cls', 'empty' => 'Select Class', 'options' => $classeslist, 'label' => false)); ?>
							</div>
						</div>


						<script>
							/*$(document).ready(function(){*/

							$('#cls').on('change', function() {

								var id = $(this).val();
								$.ajax({
									type: 'POST',
									url: '<?php echo ADMIN_URL; ?>Classections/classbyteacher',
									data: {
										'id': id
									},
									success: function(data) {
										//alert(data);
										$('#elp').html(data);

									},

								});

							});

							/*});*/
						</script>

						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">&nbsp;&nbsp;&nbsp;Select Section<span style="color:red">*</span></label>

							<div class="col-sm-2">
								<?php echo $this->Form->input('section_id', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Section', 'options' => $sectionslist, 'label' => false)); ?>
							</div>
						</div>


						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">&nbsp;Teacher<span style="color:red">*</span></label>


							<div class="col-sm-2">
								<div id="elp">
									<?php if (isset($classes['id'])) {
										$bhu = explode(',', $classes['teacher_id']);
										// pr($bhu); die;	  
										$designations2 = $this->Comman->find_teacher($classes['class_id']);
										foreach ($bhu as $k => $i) {
											$rt[$i] = $i;
										}
										foreach ($designations2 as $key => $value) {
											$array[$key] = str_replace(";", " ", $value);
										}  ?>
										<select name="teacher_id[]" class="form-control" id="elp" multiple="multiple">
											<? foreach ($array as $key => $value) {
												//pr($value); die 
											?>
												<option value="<?php echo $key; ?>" <?php if (in_array($key, $rt)) { ?> selected <?php } ?>><?php echo $value; ?></option>

											<? } ?>
										</select>


									<?  } else {
										foreach ($designations2 as $key => $value) {


											$array[$key] = str_replace(";", " ", $value);
										}
										echo $this->Form->input('teacher_id[]', array('class' => 'form-control', 'type' => 'select', 'empty' => 'Select Teachers', 'options' => $array, 'label' => false, 'multiple'));
									}

									?>
								</div>
							</div>
						</div>


						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Self Strength<span style="color:red">*</span></label>

							<div class="col-sm-2">

								<?php echo $this->Form->input('self_strength', array('class' => 'form-control', 'required', 'placeholder' => 'Self Strength', 'id' => 'test1', 'type' => 'text', 'label' => false)); ?>

							</div>
						</div>

						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">Capacity<span style="color:red">*</span></label>
							<div class="col-sm-2">
								<?php echo $this->Form->input('capacity', array('class' => 'form-control', 'placeholder' => 'Capacity', 'required', 'id' => 'test', 'label' => false, 'type' => 'text')); ?>
							</div>
						</div>


						<!-- /.form group -->

					</div>
					<!-- /.box-body -->
					<div class="box-footer" style="width: 814px;">


						<?php
						if (isset($classes['id'])) {
							echo $this->Form->submit(
								'Update',
								array('class' => 'btn btn-info pull-right', 'style' => '', 'title' => 'Update')
							);
						} else {
							echo $this->Form->submit(
								'Add',
								array('class' => 'btn btn-info pull-right', 'style' => '', 'title' => 'Add')
							);
						}
						?><?php
							echo $this->Html->link('Back', [
								'action' => 'index'

							], ['class' => 'btn btn-default']); ?>
					</div>
					<!-- /.box-footer -->
					<?php echo $this->Form->end(); ?>
				</div>

			</div>
			<!--/.col (right) -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>