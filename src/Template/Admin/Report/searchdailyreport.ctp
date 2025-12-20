<style>
	.dropppss:after {
		display: inline-block;
		width: 0;
		height: 0;
		margin-left: .255em;
		vertical-align: .255em;
		content: "";
		border-top: .3em solid;
		border-right: .3em solid transparent;
		border-bottom: 0;
		border-left: .3em solid transparent;
	}

	.hover:hover {
		background-color: #f1f1f1;
	}
</style>

<div class="table-responsive">

	<div class="pa" style="padding-right: 20px; padding-bottom: 10px;">
		<div class="d-flex pl-3 " style="justify-content: end; padding-left:20px;">
			<div class="dropdown">
				<button class="btn btn-primary dropdown-toggle dropppss" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Report
				</button>
				<div class="dropdown-menu " aria-labelledby="dropdownMenuButton" style="left: -30px !important; ">
					<a target="_blank" class="dropdown-item hover" style="display: block; color:black; padding:5px;" href="<?php echo ADMIN_URL; ?>report/dailyreportprintinhtml">Print</a>
					<!-- <div class="devider" style="height: 1px; background:#000;"></div> -->
					<a class="dropdown-item hover" style="display: block; color:black; padding:5px;" href="<?php echo ADMIN_URL; ?>report/user_dailyfee">Export to PDF</a>
				</div>
			</div>
		</div>
	</div>
	<table class="table table-bordered table-striped">
		<tbody>
			<?php
			$session = $this->request->session();
			if ($mode) {
				$session->delete($mode);
				$session->write('mode', $mode);
			}

			if ($selectField) {
				$session->delete($selectField);
				$session->write('selectField', $selectField);
			}
			?>

			<tr>
				<td><b> Fee Collection
						<? if ($datefrom && $dateto && $datefrom != '1970-01-01' && $dateto2 != '1970-01-01') {

							$datefromh = $datefrom;
							$session = $this->request->session();

							$session->delete($datefromh);
							$session->write('datefrom', $datefromh);
							$session->delete($dateto2);
							$session->write('dateto', $dateto2);
							$dateto2h = $dateto2;
							echo "From " . date('d-m-Y', strtotime($datefrom)) . " To " . date('d-m-Y', strtotime($dateto2));
						} else {
							$datefromh = date('Y') . "-04-01";
							$dateto2h = date('d-m-Y');
							$session = $this->request->session();
							$session->delete($datefromh);
							$session->write('datefrom', $datefromh);

							echo "From 01-04-" . date('Y') . " To " . $dateto2h;
							$dateto2h = date('Y-m-d', strtotime($dateto2h));

							$session->delete($dateto2h);
							$session->write('dateto', $dateto2h);
						} ?></b></td>

				<?php
				foreach ($mode as $k => $rt) {

					echo '<td ><b>' . strtoupper($rt) . '</b></td>';
				} ?>
			</tr>
			<?
			// pr($selectField);die;
			foreach ($selectField as $j => $el) {
				$el = trim($el);
				// pr($el); 
			?>
				<tr>
					<? if ($el == "Discount Fee") { ?>
						<?
						echo $html = '<td>';
						echo $html = '(-) ' . ucwords(strtolower($el));
						echo  $html = '</td>';
					} else if ($el == "Due Amount") {
						echo $html = '<td>';
						echo $html = '(-) ' . ucwords(strtolower($el));
						echo  $html = '</td>';
					} else if ($el == "Prev. Access Amount") {
						echo $html = '<td>';
						echo $html = '' . ucwords(strtolower($el));
						echo  $html = '</td>';
					} else if ($el == "Other Discount") {
						echo $html = '<td>';
						echo $html = '(-) ' . ucwords(strtolower($el));
						echo  $html = '</td>';
					} else {
						echo $html = '<td align="left">';
						$existInArray = ['Transport1', 'Transport2', 'Transport3', 'Transport4', 'Quater1', 'Quater2', 'Quater3', 'Quater4'];
						if ($el == 'Transport1') {
							echo $html = '1st Year Transport Fee';
						} else if ($el == 'Transport2') {
							echo $html = '2st Year Transport Fee';
						} else if ($el == 'Transport3') {
							echo $html = '3st Year Transport Fee';
						} else if ($el == 'Transport4') {
							echo $html = '4st Year Transport Fee';
						} else if ($el == 'Quater1') {
							echo $html = '1st Year Tuition Fee';
						} else if ($el == 'Quater2') {
							echo $html = '2st Year Tuition Fee';
						} else if ($el == 'Quater3') {
							echo $html = '3st Year Tuition Fee';
						} else if ($el == 'Quater4') {
							echo $html = '4st Year Tuition Fee';
						} else {
							echo $html = ucwords(strtolower($el));
						}

						echo $html = '</td>';
					}

					foreach ($mode as $k => $rt) {
						$tot = 0;
						if ($el == "Due Amount") {
						?>
							<td>
								<?php
								$paidamounts = $this->Comman->findpaidamountsmodety($acedmicyear, $datefromh, $dateto2h, $rt);
								$paidamounts2 = $this->Comman->findpaidamountsmode2y($acedmicyear, $datefromh, $dateto2h, $rt);

								$totd = 0;
								foreach ($paidamounts as $keyd => $valuef) {

									$findpendingdues = $this->Comman->findpendingsfee2($valuef['student']['id'], $valuef['id']);

								?>
									<? if ($findpendingdues[0]['sum']) {
										$tot -= $findpendingdues[0]['sum'];
										$aet += $findpendingdues[0]['sum'];
										$totd += $findpendingdues[0]['sum'];
									} else {
										$tot -= 0;
										$totd += 0;
									}
								}


								if (!empty($paidamounts2)) {
									foreach ($paidamounts2 as $keyd => $valuef) {
										$findpendingdues = $this->Comman->findpendingsfee2($valuef['student']['s_id'], $valuef['id']);
									?>
								<? if ($findpendingdues[0]['sum']) {
											$tot -= $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
											$aet += $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
											$totd += $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
										} else {
											$tot -= 0;
											$totd += 0;
										}
									}
								}
								echo $totd;  ?>
								<!-- Here is Due Amount  -->
							</td>
						<? } else if ($el == "Access Amount") {
						?>
							<td>
								<?
								$paidamounts = $this->Comman->findpaidamountsmodety($acedmicyear, $datefromh, $dateto2h, $rt);
								$paidamounts2s = $this->Comman->findpaidamountsmode24s($acedmicyear, $datefromh, $dateto2h, $rt);
								$totde = 0;
								foreach ($paidamounts as $keyd => $valuef) {
									$findacces = $this->Comman->findpendingsfeess2($valuef['student']['id'], $valuef['id']);
									$findacces[0]['sum'] = preg_replace('/\D/', '', $findacces[0]['sum']);
								?>
								<? if ($findacces[0]['sum']) {
										$tot += $findacces[0]['sum'];
										$aets += $findacces[0]['sum'];
										$totde += $findacces[0]['sum'];
									} else {
										$tot += 0;
										$totde += 0;
									}
								}

								if (!empty($paidamounts2s)) {
									foreach ($paidamounts2s as $keyd => $valuef) {
										$findacces = $this->Comman->findpendingsfeess2($valuef['student']['s_id'], $valuef['id']);
										$findacces[0]['sum'] = preg_replace('/\D/', '', $findacces[0]['sum']);
										if ($findacces[0]['sum']) {
											$tot += $findacces[0]['sum'];
											$aets += $findacces[0]['sum'];
											$totde += $findacces[0]['sum'];
										} else {
											$tot += 0;
											$totde += 0;
										}
									}
								}
								echo $totde;  ?>
							</td>
							<? } else {

							$paidamount = $this->Comman->findpaidamountsmodety($acedmicyear, $datefromh, $dateto2h, $rt);
							$paidamount23s = $this->Comman->findpaidamountsmode24s($acedmicyear, $datefromh, $dateto2h, $rt);
							// pr($rt);
							// die;

							$fees = 0;
							$cfees = 0;
							$dfees = 0;
							$qfees = 0;
							$tj = 0;
							$totalfine = 0;
							$totalOther = 0;
							$totalOther236 = 0;
							$totaldiscount = 0;
							$adddiscount = 0;
							foreach ($paidamount as $key => $value) {

								if ($rt == $value['mode']) {

									$quas = unserialize($value['quarter']);

									foreach ($quas as $iteam['quarter'] => $iteam['amount']) {

										if ($el == "Admission / Prosspectus") {
											if ($iteam['quarter'] == 'Admission / Prosspectus') {
												$fees += 0;
											} else if ($iteam['quarter'] == 'Admission / Prosspectus'  && $value['recipetno'] == '0') {
												$fees += 0;
											} else if ($iteam['quarter'] == 'Admission / Prosspectus') {
												$fees += $iteam['amount'];
											}
										} else if ($el == "Collage Caution Money (Refundable)") {
											if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {
												$cfees += 0;
											} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)'  && $value['recipetno'] == '0') {
												$cfees += 0;
											} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {
												$cfees += $iteam['amount'];
											}
										} else if ($el == "Uniform") {
											if ($iteam['quarter'] == 'Uniform') {
												$dfees += 0;
											} else if ($iteam['quarter'] == 'Uniform'  && $value['recipetno'] == '0') {
												$dfees += 0;
											} else if ($iteam['quarter'] == 'Uniform') {
												$dfees += $iteam['amount'];
											}
										} else if ($el == "Tution Fee") {
											if ($iteam['quarter'] == 'Quater1' || $iteam['quarter'] == 'Quater2' || $iteam['quarter'] == 'Quater3' || $iteam['quarter'] == 'Quater4') {
												$qfees += $iteam['amount'];
											}
										} else {
											$totalas = array();
											$el = trim($el);
											$j = trim($iteam['quarter']);
											if (strcasecmp($j, $el) == 0) {
												$tj += $iteam['amount'];
												$totalas[$i] = $ted;
												$totalass[] = $totalas;
											}
										}
									}

									if ($el == "Late Fee") {
										$el = trim($el);
										$totalfine += $value['lfine'];
									} else if ($el == "Prev. Due") {

										foreach ($quas as $j => $te) {
											$iteam['quarter'] = str_replace('"', "", $j);
											$findpendinsg = $this->Comman->findpendingrefrencefees235($iteam['quarter'], $te);

											if ($findpendinsg) {
												$totalOther += $findpendinsg['amt'];
											}
										}
									} else if ($el == "Prev. Access Amount") {

										foreach ($quas as $j => $te) {
											$iteam['quarter'] = str_replace('"', "", $j);
											$findpendinsgs = $this->Comman->findpendingrefrencefees236($iteam['quarter'], $te);
											if ($findpendinsgs) {
												$totalOther236 += $findpendinsgs['amt'];
											}
										}
									} else if ($el == "Discount Fee") {

										$total2 = 0;
										$discounts = 0;
										$quan = 0;
										if ($value['discount'] != '0.00') {
											foreach ($quas as $jn => $tn) {
												$quan += $tn;
											}
											$discounts = $value['discount'];
											$totaldiscount += $discounts;
										}
									} else if ($el == "Other Discount") {
										$adddiscount += $value['addtionaldiscount'];
									}
								}
							}

							if (!empty($paidamount23s)) {
								foreach ($paidamount23s as $key => $value) {

									if ($rt == $value['mode']) {

										$quas = unserialize($value['quarter']);

										foreach ($quas as $iteam['quarter'] => $iteam['amount']) {
											if ($el == "Admission / Prosspectus") {
												if ($iteam['quarter'] == 'Admission / Prosspectus') {


													$fees += 0;
												} else if ($iteam['quarter'] == 'Admission / Prosspectus'  && $value['recipetno'] == '0') {


													$fees += 0;
												} else if ($iteam['quarter'] == 'Admission / Prosspectus') {


													$fees += $iteam['amount'];
												}
											} else if ($el == "Collage Caution Money (Refundable)") {
												if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {

													$cfees += 0;
													//$cfees +=$iteam['amount'];

												} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)'  && $value['recipetno'] == '0') {

													$cfees += 0;
												} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {


													$cfees += $iteam['amount'];
												}
											} else if ($el == "Uniform") {
												if ($iteam['quarter'] == 'Uniform') {


													$dfees += 0;
												} else if ($iteam['quarter'] == 'Uniform'  && $value['recipetno'] == '0') {


													$dfees += 0;
												} else if ($iteam['quarter'] == 'Uniform') {


													$dfees += $iteam['amount'];
												}
											} else if ($el == "Tution Fee") {


												if ($iteam['quarter'] == 'Quater1' || $iteam['quarter'] == 'Quater2' || $iteam['quarter'] == 'Quater3' || $iteam['quarter'] == 'Quater4') {
													$qfees += $iteam['amount'];
												}
											} else {
												// pr('else');
												$totalas = array();
												$el = trim($el);
												$j = trim($iteam['quarter']);

												if (strcasecmp($j, $el) == 0) {
													$tj += $iteam['amount'];
													$totalas[$i] = $ted;
													$totalass[] = $totalas;
												}
											}
										}

										if ($el == "Late Fee") {
											$el = trim($el);


											$totalfine += $value['lfine'];
										} else if ($el == "Prev. Due") {

											foreach ($quas as $j => $te) {
												$iteam['quarter'] = str_replace('"', "", $j);
												$findpendinsg = $this->Comman->findpendingrefrencefees235($iteam['quarter'], $te);

												if ($findpendinsg) {
													$totalOther += $findpendinsg['amt'];
												}
											}
										} else if ($el == "Prev. Access Amount") {

											foreach ($quas as $j => $te) {

												$iteam['quarter'] = str_replace('"', "", $j);

												$findpendinsgs = $this->Comman->findpendingrefrencefees236($iteam['quarter'], $te);

												if ($findpendinsgs) {
													$totalOther236s += $findpendinsgs['amt'];
												}
											}
										} else if ($el == "Discount Fee") {

											$total2 = 0;
											$discounts = 0;
											$quan = 0;
											if ($value['discount'] != '0.00') {
												foreach ($quas as $jn => $tn) {
													$quan += $tn;
												}

												$discounts = $value['discount'];
												$totaldiscount += $discounts;
											}
										} else if ($el == "Other Discount") {
											$adddiscount += $value['addtionaldiscount'];
										}
									}
								}
							}


							if ($el == "Late Fee") {
							?>
								<td>
									<? $tot += $totalfine;
									echo $totalfine; ?>
								</td>
							<?   } else if ($el == "Admission / Prosspectus") {
							?>
								<td>
									<? $tot += $fees;
									$aet += $fees;
									echo $fees; ?>
								</td>
							<?   } else if ($el == "Collage Caution Money (Refundable)") {
							?>
								<td>
									<? $tot += $cfees;
									echo $cfees; ?>
								</td>
							<?   } else if ($el == "Uniform") {
							?>
								<td>
									<? $tot += $dfees;
									echo $dfees; ?>
								</td>
							<?   } else if ($el == "Tution Fee") {
							?>
								<td>
									<? $tot += $qfees;
									$tty += $qfees;
									echo $qfees; ?>
								</td>
							<?   } else if ($el == "Prev. Due") {
							?>
								<td>
									<? $tot += $totalOther;
									echo $totalOther; ?>
								</td>
							<?   } else if ($el == "Prev. Access Amount") {
							?>
								<td>
									<? $tot -= $totalOther236;
									$str = preg_replace('/\D/', '', $totalOther236);

									if ($str != '0') {
										echo "-" . $str;
									} else {

										echo $str;
									} ?>
								</td>
							<?   } else if ($el == "Discount Fee") {
							?>
								<td>
									<? $tot -= $totaldiscount;
									echo $totaldiscount; ?>
								</td>
							<?   } else if ($el == "Other Discount") {

							?>
								<td>
									<? $tot -= $adddiscount;
									echo $adddiscount; ?>
								</td>
							<? } else {
							?>
								<td>
									<? $tot += $tj;
									echo $tj; ?>
								</td>
					<?   }
						}
					}
					?>



				</tr>
			<? } ?>

			<tr>
				<td><strong style="color:green;">Net Received </strong></td>
				<?
				$ttys = 0;
				foreach ($mode as $k => $rt) {

					$tot = 0;
					foreach ($selectField as $j => $el) {
						$el = trim($el);

						if ($el == "Due Amount") {

							$paidamounts = $this->Comman->findpaidamountsmodety($acedmicyear, $datefromh, $dateto2h, $rt);
							$paidamounts2 = $this->Comman->findpaidamountsmode2y($acedmicyear, $datefromh, $dateto2h, $rt);
							$totd = 0;

							foreach ($paidamounts as $keyd => $valuef) {

								$findpendingdues = $this->Comman->findpendingsfee2($valuef['student']['id'], $valuef['id']);
				?>
								<? if ($findpendingdues[0]['sum']) {
									$tot -= $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
									$aet += $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
									$totd += $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
								} else {
									$tot -= 0;
									$totd += 0;
								}
							}
							if (!empty($paidamounts2)) {
								foreach ($paidamounts2 as $keyd => $valuef) {
									$findpendingdues = $this->Comman->findpendingsfee2($valuef['student']['s_id'], $valuef['id']);
								?>
					<? if ($findpendingdues[0]['sum']) {
										$tot -= $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
										$aet += $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
										$totd += $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
									} else {
										$tot -= 0;
										$totd += 0;
									}
								}
							}
						} else if ($el == "Access Amount") {

							$paidamounts = $this->Comman->findpaidamountsmodety($acedmicyear, $datefromh, $dateto2h, $rt);
							$paidamounts2s = $this->Comman->findpaidamountsmode24s($acedmicyear, $datefromh, $dateto2h, $rt);
							// pr($paidamounts);
							// exit;

							$totde = 0;
							foreach ($paidamounts as $keyd => $valuef) {

								$findacces = $this->Comman->findpendingsfeess2($valuef['student']['id'], $valuef['id']);
								$findacces[0]['sum'] = preg_replace('/\D/', '', $findacces[0]['sum']);
								if ($findacces[0]['sum']) {
									$tot += $findacces[0]['sum'];
									$aets += $findacces[0]['sum'];
									$totde += $findacces[0]['sum'];
								} else {
									$tot += 0;
									$totde += 0;
								}
							}

							if (!empty($paidamounts2s)) {
								foreach ($paidamounts2s as $keyd => $valuef) {

									$findacces = $this->Comman->findpendingsfeess2($valuef['student']['s_id'], $valuef['id']);
									$findacces[0]['sum'] = preg_replace('/\D/', '', $findacces[0]['sum']);
									if ($findacces[0]['sum']) {
										$tot += $findacces[0]['sum'];
										$aets += $findacces[0]['sum'];
										$totde += $findacces[0]['sum'];
									} else {
										$tot += 0;
										$totde += 0;
									}
								}
							}
						} else {

							$paidamount = $this->Comman->findpaidamountsmodety($acedmicyear, $datefromh, $dateto2h, $rt);
							$paidamount23s = $this->Comman->findpaidamountsmode24s($acedmicyear, $datefromh, $dateto2h, $rt);
							// pr($paidamount23s);die;


							$fees = 0;
							$cfees = 0;
							$dfees = 0;
							$qfees = 0;
							$tj = 0;
							$totalfine = 0;
							$totalOther = 0;
							$totalOther236s = 0;
							$totaldiscount = 0;
							$adddiscount = 0;
							foreach ($paidamount as $key => $value) {

								if ($rt == $value['mode']) {

									$quas = unserialize($value['quarter']);

									foreach ($quas as $iteam['quarter'] => $iteam['amount']) {

										if ($el == "Admission / Prosspectus") {
											if ($iteam['quarter'] == 'Admission / Prosspectus') {


												$fees += 0;
											} else if ($iteam['quarter'] == 'Admission / Prosspectus'  && $value['recipetno'] == '0') {


												$fees += 0;
											} else if ($iteam['quarter'] == 'Admission / Prosspectus') {


												$fees += $iteam['amount'];
											}
										} else if ($el == "Collage Caution Money (Refundable)") {
											if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {

												$cfees += 0;
											} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)'  && $value['recipetno'] == '0') {

												$cfees += 0;
											} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {

												$cfees += $iteam['amount'];
											}
										} else if ($el == "Uniform") {
											if ($iteam['quarter'] == 'Uniform') {

												$dfees += 0;
											} else if ($iteam['quarter'] == 'Uniform'  && $value['recipetno'] == '0') {

												$dfees += 0;
											} else if ($iteam['quarter'] == 'Uniform') {

												$dfees += $iteam['amount'];
											}
										} else if ($el == "Tution Fee") {

											if ($iteam['quarter'] == 'Quater1' || $iteam['quarter'] == 'Quater2' || $iteam['quarter'] == 'Quater3' || $iteam['quarter'] == 'Quater4') {

												$qfees += $iteam['amount'];
											}
										} else {

											$totalas = array();
											$el = trim($el);
											$j = trim($iteam['quarter']);

											if (strcasecmp($j, $el) == 0) {
												$tj += $iteam['amount'];
												$totalas[$i] = $ted;
												$totalass[] = $totalas;
											}
										}
									}

									if ($el == "Late Fee") {
										$el = trim($el);


										$totalfine += $value['lfine'];
									} else if ($el == "Prev. Due") {

										foreach ($quas as $j => $te) {
											$iteam['quarter'] = str_replace('"', "", $j);
											$findpendinsg = $this->Comman->findpendingrefrencefees235($iteam['quarter'], $te);
											if ($findpendinsg) {
												$totalOther += $findpendinsg['amt'];
											}
										}
									} else if ($el == "Prev. Access Amount") {
										foreach ($quas as $j => $te) {
											$iteam['quarter'] = str_replace('"', "", $j);
											$findpendinsgs = $this->Comman->findpendingrefrencefees236($iteam['quarter'], $te);
											if ($findpendinsgs) {
												$totalOther236s += $findpendinsgs['amt'];
											}
										}
									} else if ($el == "Discount Fee") {

										$total2 = 0;
										$discounts = 0;
										$quan = 0;
										if ($value['discount'] != '0.00') {
											foreach ($quas as $jn => $tn) {
												$quan += $tn;
											}

											$discounts = $value['discount'];
											$totaldiscount += $discounts;
										}
									} else if ($el == "Other Discount") {
										$adddiscount += $value['addtionaldiscount'];
									}
								}
							}

							if (!empty($paidamount23s)) {
								foreach ($paidamount23s as $key => $value) {
									// pr($value);die;

									if ($rt == $value['mode']) {

										$quas = unserialize($value['quarter']);

										foreach ($quas as $iteam['quarter'] => $iteam['amount']) {
											if ($el == "Admission / Prosspectus") {
												if ($iteam['quarter'] == 'Admission / Prosspectus') {
													$fees += 0;
												} else if ($iteam['quarter'] == 'Admission / Prosspectus'   && $value['recipetno'] == '0') {
													$fees += 0;
												} else if ($iteam['quarter'] == 'Admission / Prosspectus') {
													$fees += $iteam['amount'];
												}
											} else if ($el == "Collage Caution Money (Refundable)") {
												if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {

													$cfees += 0;
													//$cfees +=$iteam['amount'];

												} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)'  && $value['recipetno'] == '0') {


													$cfees += 0;
												} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {


													$cfees += $iteam['amount'];
												}
											} else if ($el == "Uniform") {
												if ($iteam['quarter'] == 'Uniform') {


													$dfees += 0;
												} else if ($iteam['quarter'] == 'Uniform'  && $value['recipetno'] == '0') {


													$dfees += 0;
												} else if ($iteam['quarter'] == 'Uniform') {


													$dfees += $iteam['amount'];
												}
											} else if ($el == "Tution Fee") {


												if ($iteam['quarter'] == 'Quater1' || $iteam['quarter'] == 'Quater2' || $iteam['quarter'] == 'Quater3' || $iteam['quarter'] == 'Quater4') {


													$qfees += $iteam['amount'];
												}
											} else {

												$totalas = array();
												$el = trim($el);
												$j = trim($iteam['quarter']);

												if (strcasecmp($j, $el) == 0) {
													$tj += $iteam['amount'];
													$totalas[$i] = $ted;
													$totalass[] = $totalas;
												}
											}
										}

										if ($el == "Late Fee") {
											$el = trim($el);

											$totalfine += $value['lfine'];
										} else if ($el == "Prev. Due") {

											foreach ($quas as $j => $te) {

												$iteam['quarter'] = str_replace('"', "", $j);

												$findpendinsg = $this->Comman->findpendingrefrencefees235($iteam['quarter'], $te);

												if ($findpendinsg) {

													$totalOther += $findpendinsg['amt'];
												}
											}
										} else if ($el == "Prev. Access Amount") {

											foreach ($quas as $j => $te) {
												$iteam['quarter'] = str_replace('"', "", $j);
												$findpendinsgs = $this->Comman->findpendingrefrencefees236($iteam['quarter'], $te);

												if ($findpendinsgs) {
													$totalOther236s += $findpendinsgs['amt'];
												}
											}
										} else if ($el == "Discount Fee") {

											$total2 = 0;
											$discounts = 0;
											$quan = 0;
											if ($value['discount'] != '0.00') {
												foreach ($quas as $jn => $tn) {
													$quan += $tn;
												}
												$discounts = $value['discount'];
												$totaldiscount += $discounts;
											}
										} else if ($el == "Other Discount") {

											$adddiscount += $value['addtionaldiscount'];
										}
									}
								}
							}

							if ($el == "Admission / Prosspectus") {
								$tot += $fees;
							} else if ($el == "Collage Caution Money (Refundable)") {
								$tot += $cfees;
							} else if ($el == "Uniform") {
								$tot += $dfees;
							} else if ($el == "Tution Fee") {
								$tot += $qfees;
							} else if ($el == "Late Fee") {
								$tot += $totalfine;
							} else if ($el == "Prev. Due") {
								$tot += $totalOther;
							} else if ($el == "Prev. Access Amount") {
								$str = preg_replace('/\D/', '', $totalOther236s);
								$tot -= $str;
							} else if ($el == "Discount Fee") {
								$tot -= $totaldiscount;
							} else if ($el == "Other Discount") {
								$tot -= $adddiscount;
							} else {
								$tot += $tj;
							}
						}
					} ?>

					<td>
						<b style="color:green;">
							<? setlocale(LC_MONETARY, 'en_IN');
							$srtt = $this->Comman->findfeemonth($rt, $datefromh, $dateto2h);
							// pr($srtt); die;
							$tyys += $srtt;
							$amount = money_format('%!i', $srtt);
							echo $amount; ?>*</b>
					</td>
				<? } ?>
			</tr>

			<tr>
				<td>
					<b style="color:green;">Grand Total</b> : <b><?php $amounttyys = money_format('%!i', $tyys);
																	echo $amounttyys; ?></b>
				</td>
			</tr>

	</table>

	<br><br>

	<!-- Coures wise fees details -->
	<table class="table table-bordered table-striped">
		<tbody>
			<?php
			$session = $this->request->session();
			if ($mode) {
				$session->delete($mode);
				$session->write('mode', $mode);
			}

			if ($selectField) {
				$session->delete($selectField);
				$session->write('selectField', $selectField);
			}
			?>

			<tr>
				<td><b>Course Wise Fee Collection
						<? if ($datefrom && $dateto && $datefrom != '1970-01-01' && $dateto2 != '1970-01-01') {

							$datefromh = $datefrom;
							$session = $this->request->session();

							$session->delete($datefromh);
							$session->write('datefrom', $datefromh);
							$session->delete($dateto2);
							$session->write('dateto', $dateto2);
							$dateto2h = $dateto2;
							echo "From " . date('d-m-Y', strtotime($datefrom)) . " To " . date('d-m-Y', strtotime($dateto2));
						} else {
							$datefromh = date('Y') . "-04-01";
							$dateto2h = date('d-m-Y');
							$session = $this->request->session();
							$session->delete($datefromh);
							$session->write('datefrom', $datefromh);

							echo "From 01-04-" . date('Y') . " To " . $dateto2h;
							$dateto2h = date('Y-m-d', strtotime($dateto2h));

							$session->delete($dateto2h);
							$session->write('dateto', $dateto2h);
						} ?></b></td>

				<?php
				foreach ($mode as $k => $rt) {
					echo '<td ><b>' . strtoupper($rt) . '</b></td>';
				} ?>
			</tr>
			<?
			// pr($selectField);die;
			foreach ($classes as $key => $value) { ?>
				<tr>
					<td><?php echo $value; ?> <?php //echo "tttt".$key; 
												?></td>

					<?php
					foreach ($mode as $k => $rt) {
						$tot = 0;
						if ($value) { ?>
							<td>

								<?php
								//   echo $rt."dfsgdsfd".$key;
								$paidamounts = $this->Comman->findpaidamountsmodetyaaaaa($acedmicyear, $datefromh, $dateto2h, $rt, $key);
								//  pr($paidamounts);
								$paidamounts2 = $this->Comman->findpaidamountsmode2y($acedmicyear, $datefromh, $dateto2h, $rt);
								// pr($paidamounts2);

								$totd = 0;
								foreach ($paidamounts as $keyd => $valuef) {

									$findpendingdues = $this->Comman->findpendingsfee2($valuef['student']['id'], $valuef['id']);
									// pr($valuef['deposite_amt']); die;
								?>
									<? if ($findpendingdues[0]['sum']) {
										$tot -= $findpendingdues[0]['sum'];
										$aet += $findpendingdues[0]['sum'];
										$totd += $findpendingdues[0]['sum'];
									} else {
										$tot -= 0;
										$totd += $valuef['total'];
									}
								}


								if (!empty($paidamounts2)) {
									foreach ($paidamounts2 as $keyd => $valuef) {
										$findpendingdues = $this->Comman->findpendingsfee2($valuef['student']['s_id'], $valuef['id']);
									?>
								<? if ($findpendingdues[0]['sum']) {
											$tot -= $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
											$aet += $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
											$totd += $findpendingdues[0]['sum'] + $findpendingdues2[0]['sum'];
										} else {
											$tot -= 0;
											$totd += 0;
										}
									}
								}
								// pr($totd);
								echo $totd;  ?>
								<!-- Here is Due Amount  -->
							</td>
						<? } else if ($el == "Access Amount") {
						?>
							<td>
								<?
								$paidamounts = $this->Comman->findpaidamountsmodetyaaaaa($acedmicyear, $datefromh, $dateto2h, $rt, $key);
								$paidamounts2s = $this->Comman->findpaidamountsmode24s($acedmicyear, $datefromh, $dateto2h, $rt);
								$totde = 0;
								foreach ($paidamounts as $keyd => $valuef) {
									$findacces = $this->Comman->findpendingsfeess2($valuef['student']['id'], $valuef['id']);
									$findacces[0]['sum'] = preg_replace('/\D/', '', $findacces[0]['sum']);
								?>
								<? if ($findacces[0]['sum']) {
										$tot += $findacces[0]['sum'];
										$aets += $findacces[0]['sum'];
										$totde += $findacces[0]['sum'];
									} else {
										$tot += 0;
										$totde += 0;
									}
								}

								if (!empty($paidamounts2s)) {
									foreach ($paidamounts2s as $keyd => $valuef) {
										$findacces = $this->Comman->findpendingsfeess2($valuef['student']['s_id'], $valuef['id']);
										$findacces[0]['sum'] = preg_replace('/\D/', '', $findacces[0]['sum']);
										if ($findacces[0]['sum']) {
											$tot += $findacces[0]['sum'];
											$aets += $findacces[0]['sum'];
											$totde += $findacces[0]['sum'];
										} else {
											$tot += 0;
											$totde += 0;
										}
									}
								}
								echo $totde;  ?>
							</td>
							<? } else {

							$paidamount = $this->Comman->findpaidamountsmodety($acedmicyear, $datefromh, $dateto2h, $rt);
							$paidamount23s = $this->Comman->findpaidamountsmode24s($acedmicyear, $datefromh, $dateto2h, $rt);
							// pr($rt);
							// die;

							$fees = 0;
							$cfees = 0;
							$dfees = 0;
							$qfees = 0;
							$tj = 0;
							$totalfine = 0;
							$totalOther = 0;
							$totalOther236 = 0;
							$totaldiscount = 0;
							$adddiscount = 0;
							foreach ($paidamount as $key => $value) {

								if ($rt == $value['mode']) {

									$quas = unserialize($value['quarter']);

									foreach ($quas as $iteam['quarter'] => $iteam['amount']) {

										if ($el == "Admission / Prosspectus") {
											if ($iteam['quarter'] == 'Admission / Prosspectus') {
												$fees += 0;
											} else if ($iteam['quarter'] == 'Admission / Prosspectus'  && $value['recipetno'] == '0') {
												$fees += 0;
											} else if ($iteam['quarter'] == 'Admission / Prosspectus') {
												$fees += $iteam['amount'];
											}
										} else if ($el == "Collage Caution Money (Refundable)") {
											if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {
												$cfees += 0;
											} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)'  && $value['recipetno'] == '0') {
												$cfees += 0;
											} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {
												$cfees += $iteam['amount'];
											}
										} else if ($el == "Uniform") {
											if ($iteam['quarter'] == 'Uniform') {
												$dfees += 0;
											} else if ($iteam['quarter'] == 'Uniform'  && $value['recipetno'] == '0') {
												$dfees += 0;
											} else if ($iteam['quarter'] == 'Uniform') {
												$dfees += $iteam['amount'];
											}
										} else if ($el == "Tution Fee") {
											if ($iteam['quarter'] == 'Quater1' || $iteam['quarter'] == 'Quater2' || $iteam['quarter'] == 'Quater3' || $iteam['quarter'] == 'Quater4') {
												$qfees += $iteam['amount'];
												// pr($qfees);
											}
										} else {
											$totalas = array();
											$el = trim($el);
											$j = trim($iteam['quarter']);
											if (strcasecmp($j, $el) == 0) {
												$tj += $iteam['amount'];
												$totalas[$i] = $ted;
												$totalass[] = $totalas;
											}
										}
									}

									if ($el == "Late Fee") {
										$el = trim($el);
										$totalfine += $value['lfine'];
									} else if ($el == "Prev. Due") {

										foreach ($quas as $j => $te) {
											$iteam['quarter'] = str_replace('"', "", $j);
											$findpendinsg = $this->Comman->findpendingrefrencefees235($iteam['quarter'], $te);

											if ($findpendinsg) {
												$totalOther += $findpendinsg['amt'];
											}
										}
									} else if ($el == "Prev. Access Amount") {

										foreach ($quas as $j => $te) {
											$iteam['quarter'] = str_replace('"', "", $j);
											$findpendinsgs = $this->Comman->findpendingrefrencefees236($iteam['quarter'], $te);
											if ($findpendinsgs) {
												$totalOther236 += $findpendinsgs['amt'];
											}
										}
									} else if ($el == "Discount Fee") {

										$total2 = 0;
										$discounts = 0;
										$quan = 0;
										if ($value['discount'] != '0.00') {
											foreach ($quas as $jn => $tn) {
												$quan += $tn;
											}
											$discounts = $value['discount'];
											$totaldiscount += $discounts;
										}
									} else if ($el == "Other Discount") {
										$adddiscount += $value['addtionaldiscount'];
									}
								}
							}

							if (!empty($paidamount23s)) {
								foreach ($paidamount23s as $key => $value) {

									if ($rt == $value['mode']) {

										$quas = unserialize($value['quarter']);

										foreach ($quas as $iteam['quarter'] => $iteam['amount']) {
											if ($el == "Admission / Prosspectus") {
												if ($iteam['quarter'] == 'Admission / Prosspectus') {


													$fees += 0;
												} else if ($iteam['quarter'] == 'Admission / Prosspectus'  && $value['recipetno'] == '0') {


													$fees += 0;
												} else if ($iteam['quarter'] == 'Admission / Prosspectus') {


													$fees += $iteam['amount'];
												}
											} else if ($el == "Collage Caution Money (Refundable)") {
												if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {

													$cfees += 0;
													//$cfees +=$iteam['amount'];

												} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)'  && $value['recipetno'] == '0') {

													$cfees += 0;
												} else if ($iteam['quarter'] == 'Collage Caution Money (Refundable)') {


													$cfees += $iteam['amount'];
												}
											} else if ($el == "Uniform") {
												if ($iteam['quarter'] == 'Uniform') {


													$dfees += 0;
												} else if ($iteam['quarter'] == 'Uniform'  && $value['recipetno'] == '0') {


													$dfees += 0;
												} else if ($iteam['quarter'] == 'Uniform') {


													$dfees += $iteam['amount'];
												}
											} else if ($el == "Tution Fee") {


												if ($iteam['quarter'] == 'Quater1' || $iteam['quarter'] == 'Quater2' || $iteam['quarter'] == 'Quater3' || $iteam['quarter'] == 'Quater4') {
													$qfees += $iteam['amount'];
												}
											} else {
												// pr('else');
												$totalas = array();
												$el = trim($el);
												$j = trim($iteam['quarter']);

												if (strcasecmp($j, $el) == 0) {
													$tj += $iteam['amount'];
													$totalas[$i] = $ted;
													$totalass[] = $totalas;
												}
											}
										}

										if ($el == "Late Fee") {
											$el = trim($el);


											$totalfine += $value['lfine'];
										} else if ($el == "Prev. Due") {

											foreach ($quas as $j => $te) {
												$iteam['quarter'] = str_replace('"', "", $j);
												$findpendinsg = $this->Comman->findpendingrefrencefees235($iteam['quarter'], $te);

												if ($findpendinsg) {
													$totalOther += $findpendinsg['amt'];
												}
											}
										} else if ($el == "Prev. Access Amount") {

											foreach ($quas as $j => $te) {

												$iteam['quarter'] = str_replace('"', "", $j);

												$findpendinsgs = $this->Comman->findpendingrefrencefees236($iteam['quarter'], $te);

												if ($findpendinsgs) {
													$totalOther236s += $findpendinsgs['amt'];
												}
											}
										} else if ($el == "Discount Fee") {

											$total2 = 0;
											$discounts = 0;
											$quan = 0;
											if ($value['discount'] != '0.00') {
												foreach ($quas as $jn => $tn) {
													$quan += $tn;
												}

												$discounts = $value['discount'];
												$totaldiscount += $discounts;
											}
										} else if ($el == "Other Discount") {
											$adddiscount += $value['addtionaldiscount'];
										}
									}
								}
							}


							if ($el == "Late Fee") {
							?>
								<td>
									<? $tot += $totalfine;
									echo $totalfine; ?>
								</td>
							<?   } else if ($el == "Admission / Prosspectus") {
							?>
								<td>
									<? $tot += $fees;
									$aet += $fees;
									echo $fees; ?>
								</td>
							<?   } else if ($el == "Collage Caution Money (Refundable)") {
							?>
								<td>
									<? $tot += $cfees;
									echo $cfees; ?>
								</td>
							<?   } else if ($el == "Uniform") {
							?>
								<td>
									<? $tot += $dfees;
									echo $dfees; ?>
								</td>
							<?   } else if ($el == "Tution Fee") {
							?>
								<td>
									<? $tot += $qfees;
									$tty += $qfees;
									echo $qfees; ?>
								</td>
							<?   } else if ($el == "Prev. Due") {
							?>
								<td>
									<? $tot += $totalOther;
									echo $totalOther; ?>
								</td>
							<?   } else if ($el == "Prev. Access Amount") {
							?>
								<td>
									<? $tot -= $totalOther236;
									$str = preg_replace('/\D/', '', $totalOther236);

									if ($str != '0') {
										echo "-" . $str;
									} else {

										echo $str;
									} ?>
								</td>
							<?   } else if ($el == "Discount Fee") {
							?>
								<td>
									<? $tot -= $totaldiscount;
									echo $totaldiscount; ?>
								</td>
							<?   } else if ($el == "Other Discount") {

							?>
								<td>
									<? $tot -= $adddiscount;
									echo $adddiscount; ?>
								</td>
							<? } else {
							?>
								<td>
									<? $tot += $tj;
									echo $tj; ?>
								</td>
					<?   }
						}
					}
					?>



				</tr>
			<? }
			$classesss = array();
			foreach ($classes as $key => $value) {
				$classesss[] = $key;
			} ?>
			<tr>
				<td><strong style="color:green;">Net Received </strong></td>
				<?
				$ttys = 0;
				$tyys = 0;
				foreach ($mode as $k => $rt) {

					$tot = 0;
					foreach ($selectField as $j => $el) {
						$el = trim($el);
					} ?>

					<td>
						<b style="color:green;">
							<? setlocale(LC_MONETARY, 'en_IN');
							$srtt = $this->Comman->findfeemonth_classwise($rt, $datefromh, $dateto2h, $classesss);

							$tyys += $srtt;
							$amount = money_format('%!i', $srtt);
							echo $amount; ?>*</b>
					</td>
				<? } ?>
			</tr>

			<tr>
				<td>
					<b style="color:green;">Grand Total</b> : <b><?php $amounttyys = money_format('%!i', $tyys);
																	echo $amounttyys; ?></b>
				</td>
			</tr>

	</table>

	<br><br>


	<!-- end -->


	<? /*
	$rolepresent = $this->request->session()->read('Auth.User.role_id');

	if ($rolepresent == '5') {
	?>
		<table class="table table-bordered table-striped">


			<tbody>

				<tr>
					<td><b>Other Fees Collection
							<? if ($datefrom && $dateto && $datefrom != '1970-01-01' && $dateto2 != '1970-01-01') {

								$datefromh = $datefrom;
								$session = $this->request->session();
								$session->delete($datefromh);
								$session->write('datefrom', $datefromh);
								$session->delete($dateto2);
								$session->write('dateto', $dateto2);
								$dateto2h = $dateto2;
								echo "From " . date('d-m-Y', strtotime($datefrom)) . " To " . date('d-m-Y', strtotime($dateto2));
							} else {
								$datefromh = date('Y') . "-04-01";
								$dateto2h = date('d-m-Y');
								$session = $this->request->session();
								$session->delete($datefromh);
								$session->write('datefrom', $datefromh);
								echo "From 01-04-" . date('Y') . " To " . $dateto2h;
								$dateto2h = date('Y-m-d', strtotime($dateto2h));
								$session->delete($dateto2h);
								$session->write('dateto', $dateto2h);
							} ?></b></td>

					<?php foreach ($mode as $k => $rt) {
						echo '<td ><b>' . strtoupper($rt) . '</b></td>';
					} ?>

				</tr>

				<tr>
					<?
					echo $html = '<td style="color:red;">';
					echo $html = "(+) Other Fees Collection";
					echo  $html = '</td>';

					foreach ($mode as $k => $rt) {
						$tothh = 0;
						$otherfee = $this->Comman->findofcashdate($datefromh, $dateto2h, $rt);
					?>
						<td>
							<? if ($otherfee[0]['sum']) {
								$tothh += $otherfee[0]['sum'];
								echo $otherfee[0]['sum'];
							} else {
								$tot += 0;
								echo 0;
							} ?>
						</td>
					<?

					} ?>

				</tr>

				<tr>
					<td><strong style="color:green;">Net Received </strong></td>
					<?
					$ttys = 0;
					$tothh = 0;
					foreach ($mode as $k => $rt) {
						$otherfee = $this->Comman->findofcashdate($datefromh, $dateto2h, $rt);
					?>
						<td style="color:green;font-weight:bold;">
							<? if ($otherfee[0]['sum']) {
								$tothh += $otherfee[0]['sum'];
								echo $otherfee[0]['sum'];
							} else {
								$tothh += 0;
								echo 0;
							} ?>
						</td>
					<?

					} ?>

				</tr>

				<tr>
					<td><strong style="color:green;">Grand Total</strong> : <b>
							<?php
							$amounttysys = money_format('%!i', $tothh);
							echo $amounttysys; ?></b></td>
				</tr>

			</tbody>


		<?php } */ ?>