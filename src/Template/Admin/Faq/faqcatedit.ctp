<style>
	.input_fields_wrap .form-control {
		margin-bottom: 15px;
	}
</style>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Category Name
		</h1>
		<ol class="breadcrumb">
			<!-- <li><a href="<?php echo SITE_URL; ?>admin/examtemplates"><i class="fa fa-home"></i>Home</a></li> -->
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
				
					<!-- /.box-header -->
					<!-- form start -->

					<?php echo $this->Form->create($result, array('class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'validate')); ?>

					<div class="box-body">
						<div class="form-group">
							<div class="col-sm-3" style="margin-bottom:15px;">
								<label>Category Name</label> <strong style="color:red;">*</strong>
								<?php echo $this->Form->input('category_name', array('class' => 'form-control',  'placeholder' => 'Category Name',  'label' => false, 'required')); ?>
							</div>

				
							<div class="col-sm-12">							
									<button type="submit" name="button" value="update" class="btn btn-success pull-right">Update</button>
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



