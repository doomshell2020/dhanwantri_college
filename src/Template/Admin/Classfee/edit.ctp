<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
		Course Fee Structure Manager
		</h1>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">

			<!-- right column -->
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"><?php echo 'Update Course Fee Structure';  ?> </h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->

					<?php echo $this->Flash->render(); ?>







					<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" validate="validate" action="<?php echo SITE_URL; ?>admin/classfee/edit/<?php echo $id; ?>">



						<div class="box-body">

							<div class="form-group">

								<div class="col-sm-12">
									<? foreach ($subjectclaa as $jk => $rr) { ?>
										<b>Course : <? echo $rr['class']['title']; ?></b>
										<input type="hidden" name="class_id[]" value="<?php echo $rr['class']['id']; ?>"> |

									<? } ?> <b>Board : <? if ($alldata[0]['board_id'] == '1') {
															echo "CBSE";
														} else if ($alldata[0]['board_id'] == '2') {
															echo "CAMBRIDGE";
														} else {
															echo "IBDP";
														} ?></b> | <b style="color:red;"> Academic Year : <? echo $alldata[0]['academic_year']; ?></b>
									<input type="hidden" name="slab" value="<?php echo $alldata[0]['slab']; ?>">

									<input type="hidden" name="board_id" value="<?php echo $alldata[0]['board_id']; ?>">
									<input type="hidden" name="academic_year" value="<?php echo $alldata[0]['academic_year']; ?>">
								</div> <br> <br>

								<table class="table table-bordered table-striped">
									<thead>


										<tr>
											<th class="text-center bg-teal color-palette">Fees Heads</th>
											<th class="text-center bg-teal color-palette">APRIL-JUNE</th>
											<th class="text-center bg-teal color-palette">JULY-SEPTEMBER</th>
											<th class="text-center bg-teal color-palette">OCTOBER-DECEMBER</th>
											<th class="text-center bg-teal color-palette">JANUARY-MARCH</th>
										</tr>
									</thead>
									<tbody>
										<?php if (isset($alldata) && !empty($alldata)) {
											foreach ($alldata as $key => $work) { ?>
												<tr>
													<td class="text-center text-bold">
														<input type="hidden" name="fee_h_id[]" value="<?php echo $work['feeshead']['id']; ?>"><?php echo $work['feeshead']['name']; ?>
													</td>
													<td class="text-center text-bold">

														<? if ($work['qu1_fees']) { ?>
															<input type="text" name="qu1_fees[]" value="<?php echo $work['qu1_fees']; ?>">


														<? } else { ?> <input type="text" name="qu1_fees[]" value="<?php echo $work['qu1_fees']; ?>"> <? } ?>
													</td>
													<td class="text-center text-bold">


														<? if ($work['qu2_fees']) { ?>
															<input type="text" name="qu2_fees[]" value="<?php echo $work['qu2_fees']; ?>">



														<? } else { ?> --<input type="hidden" name="qu2_fees[]" value="<?php echo $work['qu2_fees']; ?>"> <? } ?>
													</td>
													<td class="text-center text-bold">


														<? if ($work['qu3_fees']) { ?>
															<input type="text" name="qu3_fees[]" value="<?php echo $work['qu3_fees']; ?>">


														<? } else { ?> --<input type="hidden" name="qu3_fees[]" value="<?php echo $work['qu3_fees']; ?>"> <? } ?>
													</td>
													<td class="text-center text-bold">


														<? if ($work['qu4_fees']) { ?>
															<input type="text" name="qu4_fees[]" value="<?php echo $work['qu4_fees']; ?>">


														<? } else { ?>

															--<input type="hidden" name="qu4_fees[]" value="<?php echo $work['qu4_fees']; ?>">

														<? } ?>
													</td>







												<?php  }   ?>

											<?php  } else {  ?>
												<tr>
													<td class="text-center text-bold" colspan="7">No Data Selected</td>
												</tr><?php } ?>

											<tr>
												<script>
													$(document).ready(function() {

														$('#fee_date1').datepicker({
															'minDate': '0',
															"changeMonth": true,
															"changeYear": true,
															"dateFormat": "yy-mm-dd"
														});
														$('#fee_date2').datepicker({
															'minDate': '0',
															"changeMonth": true,
															"changeYear": true,
															"dateFormat": "yy-mm-dd"
														});
														$('#fee_date3').datepicker({
															'minDate': '0',
															"changeMonth": true,
															"changeYear": true,
															"dateFormat": "yy-mm-dd"
														});
														$('#fee_date4').datepicker({
															'minDate': '0',
															"changeMonth": true,
															"changeYear": true,
															"dateFormat": "yy-mm-dd"
														});

													});
												</script>

												<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
												<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



												<td class="text-center text-bold">Last Submission Date</td>
												<td class="text-center text-bold"><input type="text" name="qu1_date" value="<?php echo date('Y-m-d', strtotime($alldata[0]['qu1_date'])); ?>" required="required" id="fee_date1"></td>
												<td class="text-center text-bold"><input type="text" required="required" value="<?php echo date('Y-m-d', strtotime($alldata[0]['qu2_date'])); ?>" name="qu2_date" value="" id="fee_date2"></td>
												<td class="text-center text-bold"><input type="text" required="required" value="<?php echo date('Y-m-d', strtotime($alldata[0]['qu3_date'])); ?>" name="qu3_date" value="" id="fee_date3"></td>
												<td class="text-center text-bold"><input type="text" required="required" value="<?php echo date('Y-m-d', strtotime($alldata[0]['qu4_date'])); ?>" name="qu4_date" value="" id="fee_date4"></td>
											</tr>

									</tbody>
								</table>

							</div>
							<!-- /.box-body -->
							<div class="box-footer">





							</div>
							<?php $getsclone = $this->Comman->suggestifclone($subjectclaa[0]['class']['id'], $acedmicyearpresent);
							if (empty($getsclone)) { ?>
								<div class="submit"><input type="submit" name="submit" class="btn btn-info pull-right" title="Update" value="Clone <?php echo $acedmicyearpresent; ?>" style="
    background-color: crimson; margin-left: 24px;
"></div>
							<?php } ?>
							<div class="submit"><input type="submit" name="submit" class="btn btn-info pull-right" title="Update" value="Update"></div>
							<?php
							echo $this->Html->link('Back', [
								'action' => 'index'

							], ['class' => 'btn btn-default']); ?>
						</div>
						<!-- /.box-footer -->
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