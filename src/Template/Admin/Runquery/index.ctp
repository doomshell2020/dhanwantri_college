<style>
	.input_fields_wrap .form-control {
		margin-bottom: 15px;
	}
</style>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Run Query
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo SITE_URL; ?>admin/examtemplates"><i class="fa fa-home"></i>Home</a></li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<!-- right column -->
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">
					<?php echo $this->Flash->render(); ?>
					<div class="box-header with-border">

					</div>
					<!-- /.box-header -->
					<!-- form start -->

					<?php echo $this->Form->create($runquery, array('class' => 'form-horizontal', 'id' => 'sevice_form', 'enctype' => 'multipart/form-data', 'validate')); ?>

					<div class="box-body">
						<div class="form-group">
							<div class="col-sm-12" style="margin-bottom:15px;">
								<label>SQL Statement:</label> <strong style="color:red;">*</strong>
								<?php echo $this->Form->input('runquery', array('class' => 'form-control', 'id' => 'title', 'placeholder' => 'Type Your SQL Statement:', 'label' => false, 'required','type' => 'textarea')); ?>
							</div>

							<div class="col-sm-12">
								<?php
								// if (isset($exam_template['id']) && !empty($exam_template['id'])) {
									// echo '<button type="submit" name="button" value="update" class="btn btn-success pull-left">Update</button> ';
								// } else {
									echo '<button type="submit" class="btn btn-success pull-left">Run SQL</button> ';
								// }
								?>
							</div>
							<br>

						</div>

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