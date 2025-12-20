<style>
	.input_fields_wrap .form-control {
		margin-bottom: 15px;
	}
</style>
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Add Faq
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
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

					<?php echo $this->Form->create($faq, array('class' => 'form-horizontal', 'id' => 'sevice_form', 'enctype' => 'multipart/form-data', 'validate')); ?>

					<div class="box-body">
						<div class="form-group">

						<div class="col-sm-3" style="margin-bottom:15px;">
								<label>Category</label> <strong style="color:red;">*</strong>
								<?php echo $this->Form->input('category_id', array('class' => 'form-control','empty' => 'Select category', 'options' => $users,'placeholder' => 'Category','required', 'label' => false,)); ?>
							</div>

							<div class="col-sm-3" style="margin-bottom:15px;">
								<label>Tittle</label> <strong style="color:red;">*</strong>
								<?php echo $this->Form->input('faq_question', array('class' => 'form-control','placeholder' => 'Faq Question', 'label' => false, 'required')); ?>
							</div>


                            <div class="col-sm-3" style="margin-bottom:15px;">
								<label>Discription</label> <strong style="color:red;">*</strong>
								<?php echo $this->Form->input('faq_answer', array('class' => 'form-control','placeholder' => 'Faq Answer', 'label' => false, 'required')); ?>
							</div>

                         
							 <div class="col-sm-3" style="margin-bottom:15px;">
							 <label>Image</label> <strong style="color:red;"></strong>
                                <?php  echo $this->Form->input('image', array('class' => 'form-control', 'type' => 'file', 'label' => false)); ?>
                            </div> 


                            <div class="col-sm-12">
								<?php
								if (isset($faq['id']) && !empty($faq['id'])) {
									echo '<button type="submit" name="button" value="update" class="btn btn-success pull-right">Update</button> ';
								} else {
									echo '<button type="submit" class="btn btn-success pull-right">Submit</button> ';
								}
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