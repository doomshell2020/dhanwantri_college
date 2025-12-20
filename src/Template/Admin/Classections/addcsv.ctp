<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			<i class="fa fa-plus-square"></i>
			Add Section
		</h1>
		<ol class="breadcrumb">
		<li><a href="<?php echo ADMIN_URL;?>dashboards"><i class="fa fa-home"></i>Home</a></li>
<li><a href="<?php echo ADMIN_URL;?>classections/index">Manage Class Section</a></li>
			<li><a href="#">Add Section</a></li>
		</ol> 
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">

			<!-- right column -->
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Upload CSV</h3>
						<a href="<?php echo SITE_URL ;?>webroot/excel_file/class-section-add-format/add-class-section.csv" style="margin-left: 450px;">
							Click here to download CSV format
						</a>
					</div>
					<!-- /.box-header -->
					<!-- form start -->

					<?php echo $this->Flash->render(); ?>

					<?php echo $this->Form->create(null, array(
						'class'=>'form-horizontal',
						'type'=>'file',
						'enctype' => 'multipart/form-data',
						'novalidate'
						)); ?>

						<div class="box-body">

							<div class="form-group">
								<label class="col-sm-2 control-label">Upload CSV</label>

								<div class="col-sm-10">
									<?php echo $this->Form->input('file',array('class'=>'form-control','type'=>'file', 'label' =>false)); ?>
								</div>
							</div>


							<!-- /.form group -->

						</div>
						<!-- /.box-body -->
						<div class="box-footer">
							<?php
							echo $this->Html->link('Back', [
								'action' => 'index'

								],['class'=>'btn btn-default']);
								?>

								<?php
								echo $this->Form->submit(
									'Upload', 
									array('class' => 'btn btn-info pull-right', 'title' => 'Upload','style'=>'margin-top: -33px;')
									);
									?>
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
