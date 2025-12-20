<div class="content-wrapper">
	<section class="content-header">
		<h1>
			<ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="">
				<li class="active" id="personal-tab"><a style="background: #00C0EF;color:#fff" href="<?php echo ADMIN_URL; ?>studentfees/index/<?php echo $id; ?>/<?php echo $academic_year; ?>?id=personal"><i class="fa fa-street-view"></i> Fee Structure </a></li>
			</ul>
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo ADMIN_URL; ?>dashboards"><i class="fa fa-home"></i>Home</a></li>
			<li><a href="<?php echo ADMIN_URL; ?>studentfees/view">Manage Student Fee</a></li>
			<li class="active">Deposit Fee</li>

		</ol>

	</section>


	<?php
	if ($ids || $ids3) { ?>



		<?php
		if ($ids3 && $ids4) { ?>

			<a href="<? echo ADMIN_URL; ?>studentfees/<?php echo $ids3; ?>/<?php echo $ids4; ?>" target="_blank" id="redicaution"></a>

			<script type="text/javascript">
				$('#redicaution')[0].click();
			</script>


		<? }
		if ($ids && $ids2) { ?>
			<a href="<? echo ADMIN_URL; ?>studentfees/<?php echo $ids; ?>/<?php echo $ids2; ?>" target="_blank" id="redi"></a>

			<script type="text/javascript">
				$('#redi')[0].click();
			</script>



	<?php }
	} ?>




	<script type="text/javascript">
		$(function() {

			window.checkpaper = function(sid, id, discount, dat) {
				$('.tamount').text('0');
				$('.newamnt').text('0');
				$('.discnt').text('0');
				$('.newamnts').val('0');

				$('#lfines').val('0');
				$('#otherfeeamts').val('0');
				$('.afdiscount').val('0');
				var discount = $("#chkdiscountcateg option:selected").val();

				var ck = 'chk' + sid + id;
				var cks = 's' + sid + id;
				var id1 = 'pd' + sid + id;
				var chkbox = document.getElementById(ck);
				var selec = $("#" + ck).attr('class');



				if (sid == 1) {



					document.getElementById("s115985").disabled = false;

					document.getElementById("chk115985").disabled = false;


				} else if (sid == 41) {


					document.getElementById("s411850").disabled = false;
					document.getElementById("chk411850").disabled = false;


				} else if (sid == 2) {

					document.getElementById("s215985").disabled = false;
					document.getElementById("chk215985").disabled = false;



				} else if (sid == 3) {

					document.getElementById("s315985").disabled = false;
					document.getElementById("chk315985").disabled = false;



				} else if (sid == 4) {

					document.getElementById("s415985").disabled = false;
					document.getElementById("chk415985").disabled = false;



				}




				if (chkbox.checked) {

					$('.news').prop('checked', false);
					$('.news').prop('disabled', true);

					$('.StuAttendCk').prop('checked', false);
					$('.StuAttendCk').prop('disabled', true);
					$('#chkdiscountcateg').prop('selectedIndex', 0);

					$('#chkotherfee').prop('selectedIndex', 0);
					$('#chkotherfee').prop('disabled', true);
					$('.StuAttendCkrg').prop('disabled', true);
					$('.StuAttendCkrg').prop('checked', false);
					$('#chkdiscountcateg').prop('disabled', true);

					$.ajax({
						type: 'POST',
						url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
						data: {
							'pos': dat
						},
						success: function(data) {

							var pluss = parseInt($('#lfines').val()) + parseInt(data);
							// $('#lfine').html(pluss);
							$('#lfines').val(pluss);



							$(".addgen").css("display", "block");

							if (discount > 0) {
								var idf = id;
								idf = parseInt($('.tamount').text()) + parseInt(idf);
								$('.tamount').text(idf);



								var newamount = idf;
								$('.newamnt').text(newamount);
								var cat = parseInt($('#lfines').val()) + parseInt(newamount);
								$('.newamnts').val(cat);



								//$('.discnt').text(discounts);
								$('.afdiscount').val(newamount);

							} else {
								var idf = id;
								idf = parseInt($('.tamount').text()) + parseInt(idf);
								$('.tamount').text(idf);
								var newamount = idf;
								$('.newamnt').text(idf);
								var cat = parseInt($('#lfines').val()) + parseInt(idf);
								$('.newamnts').val(cat);

								$('.afdiscount').val(idf);
							}

							document.getElementById(cks).disabled = false;





						},

					});
				} else {

					$('.news').prop('disabled', false);

					$('.StuAttendCk').prop('disabled', false);
					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);

					$.ajax({
						type: 'POST',
						url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
						data: {
							'pos': dat
						},
						success: function(data) {

							var pluss = parseInt($('#lfines').val()) - parseInt(data);

							$('#lfines').val(pluss);




							if ($('.news').length == $('.news:checked').length) {
								$('.check-alls').prop('checked', true);

							} else {
								$('.check-alls').prop('checked', false);
							}
							var idf = '0';
							$('.tamount').text(idf);



							if (discount > 0) {


								var newamount = 0;



								$('.newamnt').text(newamount);
								var cat = parseInt(newamount);
								$('.newamnts').val(cat);
								//$('#fees_discount').val(discounts);
								$('.afdiscount').val(newamount);
								//$('.discnt').text(discounts);
								if (newamount == '0') {
									$('.discnt').text('0');

								}
							} else {

								var idsf = '0';
								$('.newamnt').text(idsf);
								var cat = parseInt(idsf);
								$('.newamnts').val(cat);
								$('.afdiscount').val(cat);
								if (idsf == '0') {
									$('.discnt').text('0');

								}

							}



							document.getElementById(cks).disabled = true;
							document.getElementById(id1).disabled = true;
							document.getElementById(id1).required = false;

						},

					});
				}


				if ($('.news').length == $('.news:checked').length) {
					$('.check-alls').prop('checked', true);

				} else {
					$('.check-alls').prop('checked', false);
				}


				if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
					$('.check-all').prop('checked', true);

				} else {
					$('.check-all').prop('checked', false);
				}
			};
		});
	</script>

	<? if ($students['class']['id'] == '18' ||  $students['class']['id'] == '19' || $students['class']['id'] == '1' ||  $students['class']['id'] == '2' ||  $students['class']['id'] == '3' ||  $students['class']['id'] == '4' ||  $students['class']['id'] == '6') { ?>

		<script type="text/javascript">
			$(function() {
				$('.check-all').click(function() {
					if (this.checked) {

						$('input:checkbox[id^="chk"]').trigger("click");

						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', false);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);




					} else {
						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');

						$('.afdiscount').val('0');
						$('.discnt').text('0' + '     %  ');
						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', true);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
					}
				});


				$('.check-alls').click(function() {

					$('#recipitno').val('0');
					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);

					$('#additionaldis').val('0');
					$('.StuAttendCkrg').prop('disabled', false);
					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);

					if (this.checked) {
						var dat = '0';
						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {


								var data = parseInt(data);
								var pluss = parseInt($('#lfines').val()) + parseInt(data);
								//  $('#lfine').html(pluss);
								$('#lfines').val(pluss);
							},

						});

						$(".addgen").css("display", "block");
						var sum = 0;
						$(".discnt").html('0');
						$('.news').each(function() {
							sum += parseFloat($(this).val());





						});


						document.getElementById("chk1125000").disabled = false;
						document.getElementById("chk215000").disabled = false;
						document.getElementById("chk315000").disabled = false;
						// document.getElementById("chk119550").disabled = false;
						// document.getElementById("chk411850").disabled = false;

						document.getElementById("s1125000").disabled = false;
						document.getElementById("s215000").disabled = false;
						document.getElementById("s315000").disabled = false;
						//  document.getElementById("s119550").disabled = false;
						//  document.getElementById("s411850").disabled = false;



						$('.tamount').text(sum);
						$('.newamnt').text(sum);
						$('.newamnts').val(sum);
						$('.discnt').text('0');
						$('#fees_discount').val('0');

						$("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());



						$('.news').prop('disabled', false);
						$('.news').prop('checked', true);
						$('.news').prop('required', true);


						$('.paper').prop('disabled', true);
						$('.paper1').prop('disabled', true);
						$('.paper').prop('checked', false);
						$('.paper').prop('required', false);
					} else {
						$('.paper').prop('disabled', false);
						$('.paper1').prop('disabled', false);



						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');
						$('.discnt').text('0');
						$('#fees_discount').val('0');


						$('.afdiscount').val('0');
						$(".addgen").css("display", "none");
						$('.news').prop('checked', false);
						$('.StuAttendCk').prop('checked', false);
						$('#otherfeeamts').val('0');
						$('#chkdiscountcateg').prop('selectedIndex', 0);

						$('#chkotherfee').prop('selectedIndex', 0);
						$('.news').prop('required', false);
						//    $('.paper').prop('disabled',true);
						//   $('.paper').prop('checked',false);

					}

				});



				window.check = function(sid, id, discount, dat) {

					$('.news').prop('required', false);

					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);


					var discount = $("#chkdiscountcateg option:selected").val();

					var ck = 'chk' + sid + id;
					var cks = 's' + sid + id;
					var id1 = 'pd' + sid + id;
					var chkbox = document.getElementById(ck);
					var selec = $("#" + ck).attr('class');



					if (sid == 1) {



						document.getElementById("s119550").disabled = false;

						document.getElementById("chk119550").disabled = false;


					} else if (sid == 41) {


						document.getElementById("s411850").disabled = false;
						document.getElementById("chk411850").disabled = false;


					} else if (sid == 2) {

						document.getElementById("s219550").disabled = false;
						document.getElementById("chk219550").disabled = false;



					} else if (sid == 3) {

						document.getElementById("s319550").disabled = false;
						document.getElementById("chk319550").disabled = false;



					} else if (sid == 4) {

						document.getElementById("s419550").disabled = false;
						document.getElementById("chk419550").disabled = false;



					}




					if (chkbox.checked) {
						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) + parseInt(data);
								//  $('#lfine').html(pluss);
								$('#lfines').val(pluss);




								$(".addgen").css("display", "block");

								if (discount > 0) {


									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);





									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {



												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);





											}


										},
									});
									//  alert(dasr);



									//~ var discounts= idf/100*discount;
									//~ var discounts= discounts.toFixed(2);

									//~ var newamount=idf-discounts;
									//~ $('.newamnt').text(newamount);

									//~ var cat=parseInt($('#lfines').val())+parseInt(newamount);
									//~ $('.newamnts').val(cat);



									//~ $('.discnt').text(discounts);
									//~ $('.afdiscount').val(newamount);

								} else {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);
									var newamount = idf;
									$('.newamnt').text(idf);
									var cat = parseInt($('#lfines').val()) + parseInt(idf);

									$('.newamnts').val(cat);

									$('.afdiscount').val(idf);
								}

								document.getElementById(cks).disabled = false;



								if (selec == "StuAttendCk imp news") {
									if (sid == '41') {



										document.getElementById("s411850").disabled = false;


										var dev = $("#chk411850").val();



										var toi = parseInt($('.tamount').text()) + parseInt(dev);
										$('.tamount').text(toi);
										if (discount > 0) {
											$('.tamount').text(toi);



											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													}


												},
											});




											//~ var discounts= toi/100*discount;
											//~ var newamount=toi-discounts;
											//~ $('.newamnt').text(newamount);
											//~ var cat=parseInt($('#lfines').val())+parseInt(newamount);
											//~ $('.newamnts').val(cat);
											//~ $('.afdiscount').val(newamount);



										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);

										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = false;
										var toi = parseInt($('.tamount').text()) + parseInt(dev);
										if (discount > 0) {









											$('.tamount').text(toi);



											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});











											//~ var discounts= toi/100*discount;
											//~ var newamount=toi-discounts;
											//~ $('.newamnt').text(newamount);
											//~ var cat=parseInt($('#lfines').val())+parseInt(newamount);
											//~ $('.newamnts').val(cat);
											//~ $('.afdiscount').val(newamount);


										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);



										}

									}
								}



							},

						});
					} else {
						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) - parseInt(data);
								//  $('#lfine').html(pluss);
								$('#lfines').val(pluss);




								if ($('.news').length == $('.news:checked').length) {
									$('.check-alls').prop('checked', true);

								} else {
									$('.check-alls').prop('checked', false);
								}
								var idf = $('.tamount').text() - id;
								$('.tamount').text(idf);



								if (discount > 0) {



									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {


												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);



											}


										},
									});







									//~ var discounts= idf/100*discount;
									//~ var discounts= discounts.toFixed(2);

									//~ var newamount=idf-discounts;



									//~ $('.newamnt').text(newamount);
									//~ var cat=parseInt($('#lfines').val())+parseInt(newamount);
									//~ $('.newamnts').val(cat);
									//~ //$('#fees_discount').val(discounts);
									//~ $('.afdiscount').val(newamount);
									//~ $('.discnt').text(discounts);
									/* if(newamount=='0'){
		$('.discnt').text('0');
			
			} */
								} else {

									var idsf = $('.newamnt').text() - id;
									$('.newamnt').text(idsf);
									var cat = parseInt($('#lfines').val()) + parseInt(idsf);
									$('.newamnts').val(cat);
									$('.afdiscount').val(cat);
									if (idsf == '0') {
										$('.discnt').text('0');


									}

								}
								if (selec == "StuAttendCk imp news") {



									//$(".imp").prop('checked', false);
									if (sid == '41') {


										var dev = $("#chk411850").val();


										document.getElementById("s411850").disabled = true;



										var toi = parseInt($('.tamount').text()) - parseInt(dev);

										if (discount > 0) {


											$('.tamount').text(toi);






											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});










											//~ var discounts= toi/100*discount;
											//~ var newamount=toi-discounts;
											//~ $('.newamnt').text(newamount);
											//~ var cat=parseInt($('#lfines').val())+parseInt(newamount);
											//~ $('.newamnts').val(cat);
											//~ $('.afdiscount').val(newamount);


										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = true;
										var toi = parseInt($('.tamount').text()) - parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);





											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});









											//~ var discounts= toi/100*discount;
											//~ var newamount=toi-discounts;
											//~ $('.newamnt').text(newamount);
											//~ var cat=parseInt($('#lfines').val())+parseInt(newamount);
											//~ $('.newamnts').val(cat);
											//~ $('.afdiscount').val(newamount);


										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}

									}


								}




								document.getElementById(cks).disabled = true;
								document.getElementById(id1).disabled = true;
								document.getElementById(id1).required = false;

							},

						});
					}




					if ($('.news').length == $('.news:checked').length) {
						$('.check-alls').prop('checked', true);

					} else {
						$('.check-alls').prop('checked', false);
					}


					if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
						$('.check-all').prop('checked', true);

					} else {
						$('.check-all').prop('checked', false);
					}
				};

			});
		</script>
	<? } else if ($students['class']['id'] == '7' ||  $students['class']['id'] == '8' ||  $students['class']['id'] == '9') { ?>

		<script type="text/javascript">
			$(function() {
				$('.check-all').click(function() {
					if (this.checked) {

						$('input:checkbox[id^="chk"]').trigger("click");

						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', false);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);




					} else {
						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');
						$('.afdiscount').val('0');
						$('.discnt').text('0' + '     %  ');
						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', true);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
					}
				});


				$('.check-alls').click(function() {
					$('#recipitno').val('0');
					$('#additionaldis').val('0');
					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);

					if (this.checked) {

						$(".addgen").css("display", "block");
						var sum = 0;
						$('.news').each(function() {
							sum += parseFloat($(this).val());
						});

						document.getElementById("chk1125000").disabled = false;
						document.getElementById("chk215000").disabled = false;
						document.getElementById("chk315000").disabled = false;
						// document.getElementById("chk119550").disabled = false;
						//  document.getElementById("chk411850").disabled = false;

						document.getElementById("s1125000").disabled = false;
						document.getElementById("s215000").disabled = false;
						document.getElementById("s315000").disabled = false;
						//  document.getElementById("s119550").disabled = false;
						//  document.getElementById("s411850").disabled = false;


						$('.tamount').text(sum);
						$('.newamnt').text(sum);
						$('.newamnts').val(sum);
						$('.discnt').text('0');
						$('#fees_discount').val('0');

						$("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());




						$('.news').prop('disabled', false);
						$('.news').prop('checked', true);
						$('.news').prop('required', true);

						$('.paper').prop('disabled', true);
						$('.paper1').prop('disabled', true);
						$('.paper').prop('checked', false);
						$('.paper').prop('required', false);


					} else {
						$('.paper').prop('disabled', false);
						$('.paper1').prop('disabled', false);



						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');
						$('.discnt').text('0');
						$('#fees_discount').val('0');


						$('.afdiscount').val('0');
						$(".addgen").css("display", "none");
						$('.news').prop('checked', false);
						$('.StuAttendCk').prop('checked', false);
						$('#otherfeeamts').val('0');
						$('#chkdiscountcateg').prop('selectedIndex', 0);

						$('#chkotherfee').prop('selectedIndex', 0);
						$('.news').prop('required', false);
						//    $('.paper').prop('disabled',true);
						//   $('.paper').prop('checked',false);

					}
				});



				window.check = function(sid, id, discount, dat) {
					$('.news').prop('required', false);

					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);
					var discount = $("#chkdiscountcateg option:selected").val();

					var ck = 'chk' + sid + id;
					var cks = 's' + sid + id;
					var id1 = 'pd' + sid + id;
					var chkbox = document.getElementById(ck);
					var selec = $("#" + ck).attr('class');



					if (sid == 1) {



						document.getElementById("s115985").disabled = false;

						document.getElementById("chk115985").disabled = false;


					} else if (sid == 41) {


						document.getElementById("s411850").disabled = false;
						document.getElementById("chk411850").disabled = false;


					} else if (sid == 2) {

						document.getElementById("s215985").disabled = false;
						document.getElementById("chk215985").disabled = false;



					} else if (sid == 3) {

						document.getElementById("s315985").disabled = false;
						document.getElementById("chk315985").disabled = false;



					} else if (sid == 4) {

						document.getElementById("s415985").disabled = false;
						document.getElementById("chk415985").disabled = false;



					}




					if (chkbox.checked) {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) + parseInt(data);
								// $('#lfine').html(pluss);
								$('#lfines').val(pluss);



								$(".addgen").css("display", "block");

								if (discount > 0) {



									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);



									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {



												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);





											}


										},
									});

									/*	var discounts= idf/100*discount;
var discounts= discounts.toFixed(2);
		
		var newamount=idf-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
		


$('.discnt').text(discounts);
				$('.afdiscount').val(newamount); */

								} else {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);
									var newamount = idf;
									$('.newamnt').text(idf);
									var cat = parseInt($('#lfines').val()) + parseInt(idf);
									$('.newamnts').val(cat);

									$('.afdiscount').val(idf);
								}

								document.getElementById(cks).disabled = false;



								if (selec == "StuAttendCk imp news") {



									//	$(".imp").prop('checked', true);

									if (sid == '41') {



										document.getElementById("s411850").disabled = false;


										var dev = $("#chk411850").val();



										var toi = parseInt($('.tamount').text()) + parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);

											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													}


												},
											});



											/*
      var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
        */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);

										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = false;
										var toi = parseInt($('.tamount').text()) + parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);


											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});
											/* var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount); */


										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);



										}

									}
								}

							},

						});
					} else {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) - parseInt(data);

								$('#lfines').val(pluss);




								if ($('.news').length == $('.news:checked').length) {
									$('.check-alls').prop('checked', true);

								} else {
									$('.check-alls').prop('checked', false);
								}
								var idf = $('.tamount').text() - id;
								$('.tamount').text(idf);



								if (discount > 0) {



									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {


												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);



											}


										},
									});



									/*var discounts= idf/100*discount;
var discounts= discounts.toFixed(2);

		 var newamount=idf-discounts;
	
	       
	    
		$('.newamnt').text(newamount);
	var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
		//$('#fees_discount').val(discounts);
				$('.afdiscount').val(newamount);
				$('.discnt').text(discounts); */
									if (newamount == '0') {
										$('.discnt').text('0');

									}
								} else {

									var idsf = $('.newamnt').text() - id;
									$('.newamnt').text(idsf);
									var cat = parseInt($('#lfines').val()) + parseInt(idsf);
									$('.newamnts').val(cat);
									$('.afdiscount').val(cat);
									if (idsf == '0') {
										$('.discnt').text('0');

									}

								}
								if (selec == "StuAttendCk imp news") {



									//$(".imp").prop('checked', false);
									if (sid == '41') {


										var dev = $("#chk411850").val();


										document.getElementById("s411850").disabled = true;



										var toi = parseInt($('.tamount').text()) - parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);




											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});



											/*  var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
	var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount); */


										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = true;
										var toi = parseInt($('.tamount').text()) - parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);


											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});

											/*  var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
  
			*/
										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}

									}


								}




								document.getElementById(cks).disabled = true;
								document.getElementById(id1).disabled = true;
								document.getElementById(id1).required = false;

							},

						});
					}


					if ($('.news').length == $('.news:checked').length) {
						$('.check-alls').prop('checked', true);

					} else {
						$('.check-alls').prop('checked', false);
					}


					if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
						$('.check-all').prop('checked', true);

					} else {
						$('.check-all').prop('checked', false);
					}
				};
			});
		</script>



	<? } else if ($students['class']['id'] == '10' ||  $students['class']['id'] == '11') { ?>



		<script type="text/javascript">
			$(function() {
				$('.check-all').click(function() {
					if (this.checked) {

						$('input:checkbox[id^="chk"]').trigger("click");

						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', false);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);




					} else {
						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');

						$('.afdiscount').val('0');
						$('.discnt').text('0' + '     %  ');
						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', true);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
					}
				});


				$('.check-alls').click(function() {
					$('#recipitno').val('0');
					$('#additionaldis').val('0');
					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);

					if (this.checked) {

						$(".addgen").css("display", "block");
						var sum = 0;
						$('.news').each(function() {
							sum += parseFloat($(this).val());
						});

						document.getElementById("chk1125000").disabled = false;
						document.getElementById("chk215000").disabled = false;
						document.getElementById("chk315000").disabled = false;
						// document.getElementById("chk119550").disabled = false;
						//  document.getElementById("chk411850").disabled = false;

						document.getElementById("s1125000").disabled = false;
						document.getElementById("s215000").disabled = false;
						document.getElementById("s315000").disabled = false;
						//  document.getElementById("s119550").disabled = false;
						//  document.getElementById("s411850").disabled = false;


						$('.tamount').text(sum);
						$('.newamnt').text(sum);
						$('.newamnts').val(sum);
						$('.discnt').text('0');
						$('#fees_discount').val('0');

						$("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());


						$('.news').prop('disabled', false);
						$('.news').prop('checked', true);
						$('.news').prop('required', true);

						$('.paper').prop('disabled', true);
						$('.paper1').prop('disabled', true);
						$('.paper').prop('checked', false);
						$('.paper').prop('required', false);


					} else {
						$('.paper').prop('disabled', false);
						$('.paper1').prop('disabled', false);



						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');
						$('.discnt').text('0');
						$('#fees_discount').val('0');


						$('.afdiscount').val('0');
						$(".addgen").css("display", "none");
						$('.news').prop('checked', false);
						$('.StuAttendCk').prop('checked', false);
						$('#otherfeeamts').val('0');
						$('#chkdiscountcateg').prop('selectedIndex', 0);

						$('#chkotherfee').prop('selectedIndex', 0);
						$('.news').prop('required', false);
						//    $('.paper').prop('disabled',true);
						//   $('.paper').prop('checked',false);

					}
				});



				window.check = function(sid, id, discount, dat) {
					$('.news').prop('required', false);

					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);
					var discount = $("#chkdiscountcateg option:selected").val();

					var ck = 'chk' + sid + id;
					var cks = 's' + sid + id;
					var id1 = 'pd' + sid + id;
					var chkbox = document.getElementById(ck);
					var selec = $("#" + ck).attr('class');



					if (sid == 1) {


						//  document.getElementById("chk119550").readOnly = true; 
						document.getElementById("s116910").disabled = false;
						document.getElementById("chk116910").disabled = false;


					} else if (sid == 41) {


						//document.getElementById("chk411850").readOnly = true; 
						// document.getElementById("chk116910").disabled = false; 
						// 	  document.getElementById("s116910").disabled = false; 
						document.getElementById("s411850").disabled = false;
						document.getElementById("chk411850").disabled = false;


					} else if (sid == 2) {

						document.getElementById("s216910").disabled = false;
						document.getElementById("chk216910").disabled = false;



					} else if (sid == 3) {

						document.getElementById("s316910").disabled = false;
						document.getElementById("chk316910").disabled = false;



					} else if (sid == 4) {

						document.getElementById("s416910").disabled = false;
						document.getElementById("chk416910").disabled = false;



					}


					if (chkbox.checked) {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) + parseInt(data);

								$('#lfines').val(pluss);


								$(".addgen").css("display", "block");

								if (discount > 0) {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);




									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {



												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);





											}


										},
									});

									/*var discounts= idf/100*discount;
var discounts= discounts.toFixed(2);
		
		var newamount=idf-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);


$('.discnt').text(discounts);
				$('.afdiscount').val(newamount); */

								} else {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);
									var newamount = idf;
									$('.newamnt').text(idf);
									var cat = parseInt($('#lfines').val()) + parseInt(idf);
									$('.newamnts').val(cat);

									$('.afdiscount').val(idf);
								}

								document.getElementById(cks).disabled = false;



								if (selec == "StuAttendCk imp news") {




									if (sid == '41') {



										document.getElementById("s411850").disabled = false;


										var dev = $("#chk411850").val();



										var toi = parseInt($('.tamount').text()) + parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);



											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													}


												},
											});
											/* var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
        
			*/
										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);

										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = false;
										var toi = parseInt($('.tamount').text()) + parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);




											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});




											/*
      var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
			var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
       
			*/
										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);



										}

									}
								}

							},

						});
					} else {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) - parseInt(data);

								$('#lfines').val(pluss);




								if ($('.news').length == $('.news:checked').length) {
									$('.check-alls').prop('checked', true);

								} else {
									$('.check-alls').prop('checked', false);
								}
								var idf = $('.tamount').text() - id;
								$('.tamount').text(idf);



								if (discount > 0) {





									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {


												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);



											}


										},
									});

									/*
		var discounts= idf/100*discount;

var discounts= discounts.toFixed(2);
		 var newamount=idf-discounts;
	
	       
	    
		$('.newamnt').text(newamount);
			var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
		//$('#fees_discount').val(discounts);
				$('.afdiscount').val(newamount);
				$('.discnt').text(discounts); */
									if (newamount == '0') {
										$('.discnt').text('0');

									}
								} else {

									var idsf = $('.newamnt').text() - id;
									$('.newamnt').text(idsf);
									var cat = parseInt($('#lfines').val()) + parseInt(idsf);
									$('.newamnts').val(cat);
									$('.afdiscount').val(cat);
									if (idsf == '0') {
										$('.discnt').text('0');

									}

								}
								if (selec == "StuAttendCk imp news") {



									//$(".imp").prop('checked', false);
									if (sid == '41') {


										var dev = $("#chk411850").val();


										document.getElementById("s411850").disabled = true;



										var toi = parseInt($('.tamount').text()) - parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);



											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});


											/*
      var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
			var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
      */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = true;
										var toi = parseInt($('.tamount').text()) - parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);


											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});



											/*
      var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
			var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
  */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}

									}


								}




								document.getElementById(cks).disabled = true;
								document.getElementById(id1).disabled = true;
								document.getElementById(id1).required = false;

							},

						});
					}

					if ($('.news').length == $('.news:checked').length) {
						$('.check-alls').prop('checked', true);

					} else {
						$('.check-alls').prop('checked', false);
					}


					if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
						$('.check-all').prop('checked', true);

					} else {
						$('.check-all').prop('checked', false);
					}
				};
			});
		</script>




	<? } else if ($students['class']['id'] == '12' ||  $students['class']['id'] == '13' || $students['class']['id'] == '15' ||  $students['class']['id'] == '17' || $students['class']['id'] == '20' ||  $students['class']['id'] == '22') { ?>



		<script type="text/javascript">
			$(function() {
				$('.check-all').click(function() {
					if (this.checked) {

						$('input:checkbox[id^="chk"]').trigger("click");

						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', false);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);




					} else {
						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');

						$('.afdiscount').val('0');
						$('.discnt').text('0' + '     %  ');
						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', true);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
					}
				});


				$('.check-alls').click(function() {
					$('#recipitno').val('0');
					$('#additionaldis').val('0');
					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);

					if (this.checked) {

						$(".addgen").css("display", "block");
						var sum = 0;
						$('.news').each(function() {
							sum += parseFloat($(this).val());
						});

						document.getElementById("chk1125000").disabled = false;
						document.getElementById("chk215000").disabled = false;
						document.getElementById("chk315000").disabled = false;
						// document.getElementById("chk119550").disabled = false;
						// document.getElementById("chk411850").disabled = false;

						document.getElementById("s1125000").disabled = false;
						document.getElementById("s215000").disabled = false;
						document.getElementById("s315000").disabled = false;
						//  document.getElementById("s119550").disabled = false;
						//  document.getElementById("s411850").disabled = false;

						$('.tamount').text(sum);
						$('.newamnt').text(sum);
						$('.newamnts').val(sum);
						$('.discnt').text('0');
						$('#fees_discount').val('0');

						$("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());



						$('.news').prop('disabled', false);
						$('.news').prop('checked', true);
						$('.news').prop('required', true);
						$('.paper').prop('disabled', true);
						$('.paper1').prop('disabled', true);
						$('.paper').prop('checked', false);
						$('.paper').prop('required', false);



					} else {
						$('.paper').prop('disabled', false);
						$('.paper1').prop('disabled', false);



						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');
						$('.discnt').text('0');
						$('#fees_discount').val('0');


						$('.afdiscount').val('0');
						$(".addgen").css("display", "none");
						$('.news').prop('checked', false);
						$('.StuAttendCk').prop('checked', false);
						$('#otherfeeamts').val('0');
						$('#chkdiscountcateg').prop('selectedIndex', 0);

						$('#chkotherfee').prop('selectedIndex', 0);
						$('.news').prop('required', false);
						//    $('.paper').prop('disabled',true);
						//   $('.paper').prop('checked',false);
					}
				});



				window.check = function(sid, id, discount, dat) {
					$('.news').prop('required', false);

					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);
					var discount = $("#chkdiscountcateg option:selected").val();

					var ck = 'chk' + sid + id;
					var cks = 's' + sid + id;
					var id1 = 'pd' + sid + id;
					var chkbox = document.getElementById(ck);
					var selec = $("#" + ck).attr('class');


					if (sid == 1) {


						//  document.getElementById("chk119550").readOnly = true; 

						document.getElementById("s119540").disabled = false;
						document.getElementById("chk119540").disabled = false;


					} else if (sid == 41) {


						//document.getElementById("chk411850").readOnly = true; 
						// document.getElementById("chk119540").disabled = false; 
						//  document.getElementById("s119540").disabled = false; 
						document.getElementById("s411850").disabled = false;
						document.getElementById("chk411850").disabled = false;


					} else if (sid == 2) {


						document.getElementById("s219540").disabled = false;
						document.getElementById("chk219540").disabled = false;



					} else if (sid == 3) {

						document.getElementById("s319540").disabled = false;
						document.getElementById("chk319540").disabled = false;




					} else if (sid == 4) {

						document.getElementById("s419540").disabled = false;
						document.getElementById("chk419540").disabled = false;



					}




					if (chkbox.checked) {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) + parseInt(data);

								$('#lfines').val(pluss);



								$(".addgen").css("display", "block");

								if (discount > 0) {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);





									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {



												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);





											}


										},
									});
									/* var discounts= idf/100*discount;

		
		var newamount=idf-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);

var discounts= discounts.toFixed(2);
$('.discnt').text(discounts);
				$('.afdiscount').val(newamount); */

								} else {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);
									var newamount = idf;
									$('.newamnt').text(idf);
									var cat = parseInt($('#lfines').val()) + parseInt(idf);
									$('.newamnts').val(cat);

									$('.afdiscount').val(idf);
								}

								document.getElementById(cks).disabled = false;



								if (selec == "StuAttendCk imp news") {



									//	$(".imp").prop('checked', true);

									if (sid == '41') {



										document.getElementById("s411850").disabled = false;


										var dev = $("#chk411850").val();



										var toi = parseInt($('.tamount').text()) + parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);



											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													}


												},
											});


											/* var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
	var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
        
			*/
										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);

										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = false;
										var toi = parseInt($('.tamount').text()) + parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);



											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});

											/*  var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
	var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
       */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);



										}

									}
								}
							},

						});
					} else {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) - parseInt(data);

								$('#lfines').val(pluss);




								if ($('.news').length == $('.news:checked').length) {
									$('.check-alls').prop('checked', true);

								} else {
									$('.check-alls').prop('checked', false);
								}
								var idf = $('.tamount').text() - id;
								$('.tamount').text(idf);



								if (discount > 0) {

									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {


												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);



											}


										},
									});

									/* var discounts= idf/100*discount;

var discounts= discounts.toFixed(2);
		 var newamount=idf-discounts;
	
	       
	    
		$('.newamnt').text(newamount);
	var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
		//$('#fees_discount').val(discounts);
				$('.afdiscount').val(newamount);
				$('.discnt').text(discounts); */
									if (newamount == '0') {
										$('.discnt').text('0');

									}
								} else {

									var idsf = $('.newamnt').text() - id;
									$('.newamnt').text(idsf);
									var cat = parseInt($('#lfines').val()) + parseInt(idsf);
									$('.newamnts').val(cat);
									$('.afdiscount').val(cat);
									if (idsf == '0') {
										$('.discnt').text('0');

									}

								}
								if (selec == "StuAttendCk imp news") {



									//$(".imp").prop('checked', false);
									if (sid == '41') {


										var dev = $("#chk411850").val();


										document.getElementById("s411850").disabled = true;



										var toi = parseInt($('.tamount').text()) - parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);





											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});



											/*var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
      */
										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = true;
										var toi = parseInt($('.tamount').text()) - parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);





											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});



											/*
      var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
	var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
  */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}

									}


								}




								document.getElementById(cks).disabled = true;
								document.getElementById(id1).disabled = true;
								document.getElementById(id1).required = false;

							},

						});
					}


					if ($('.news').length == $('.news:checked').length) {
						$('.check-alls').prop('checked', true);

					} else {
						$('.check-alls').prop('checked', false);
					}


					if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
						$('.check-all').prop('checked', true);

					} else {
						$('.check-all').prop('checked', false);
					}
				};
			});
		</script>





	<? } else if ($students['class']['id'] == '23' ||  $students['class']['id'] == '24') { ?>



		<script type="text/javascript">
			$(function() {
				$('.check-all').click(function() {
					if (this.checked) {

						$('input:checkbox[id^="chk"]').trigger("click");

						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', false);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);




					} else {
						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');

						$('.afdiscount').val('0');
						$('.discnt').text('0');
						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', true);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
					}
				});


				$('.check-alls').click(function() {
					$('#recipitno').val('0');
					$('#additionaldis').val('0');
					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);

					if (this.checked) {

						$(".addgen").css("display", "block");
						var sum = 0;
						$('.news').each(function() {
							sum += parseFloat($(this).val());
						});

						document.getElementById("chk1125000").disabled = false;
						document.getElementById("chk215000").disabled = false;
						document.getElementById("chk315000").disabled = false;
						// document.getElementById("chk119550").disabled = false;
						// document.getElementById("chk411850").disabled = false;

						document.getElementById("s1125000").disabled = false;
						document.getElementById("s215000").disabled = false;
						document.getElementById("s315000").disabled = false;
						//  document.getElementById("s119550").disabled = false;
						//  document.getElementById("s411850").disabled = false;

						$('.tamount').text(sum);
						$('.newamnt').text(sum);
						$('.newamnts').val(sum);
						$('.discnt').text('0');
						$('#fees_discount').val('0');

						$("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());



						$('.news').prop('disabled', false);
						$('.news').prop('checked', true);
						$('.news').prop('required', true);
						$('.paper').prop('disabled', true);
						$('.paper1').prop('disabled', true);
						$('.paper').prop('checked', false);
						$('.paper').prop('required', false);



					} else {

						$('.paper').prop('disabled', false);
						$('.paper1').prop('disabled', false);



						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');
						$('.discnt').text('0');
						$('#fees_discount').val('0');


						$('.afdiscount').val('0');
						$(".addgen").css("display", "none");
						$('.news').prop('checked', false);
						$('.StuAttendCk').prop('checked', false);
						$('#otherfeeamts').val('0');
						$('#chkdiscountcateg').prop('selectedIndex', 0);

						$('#chkotherfee').prop('selectedIndex', 0);
						$('.news').prop('required', false);
						//    $('.paper').prop('disabled',true);
						//   $('.paper').prop('checked',false);


					}
				});



				window.check = function(sid, id, discount, dat) {
					$('.news').prop('required', false);

					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);
					var discount = $("#chkdiscountcateg option:selected").val();

					var ck = 'chk' + sid + id;
					var cks = 's' + sid + id;
					var id1 = 'pd' + sid + id;
					var chkbox = document.getElementById(ck);
					var selec = $("#" + ck).attr('class');



					if (sid == 1) {


						//  document.getElementById("chk119550").readOnly = true; 
						document.getElementById("s126000").disabled = false;

						document.getElementById("chk126000").disabled = false;


					} else if (sid == 41) {


						//document.getElementById("chk411850").readOnly = true; 
						//   document.getElementById("chk126000").disabled = false; 
						//	  document.getElementById("s126000").disabled = false; 
						document.getElementById("s411850").disabled = false;
						document.getElementById("chk411850").disabled = false;


					} else if (sid == 2) {

						document.getElementById("s226000").disabled = false;
						document.getElementById("chk226000").disabled = false;



					} else if (sid == 3) {

						document.getElementById("s326000").disabled = false;
						document.getElementById("chk326000").disabled = false;



					} else if (sid == 4) {

						document.getElementById("s426000").disabled = false;
						document.getElementById("chk426000").disabled = false;



					}




					if (chkbox.checked) {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) + parseInt(data);
								//$('#lfine').html(pluss);
								$('#lfines').val(pluss);


								$(".addgen").css("display", "block");

								if (discount > 0) {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);


									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {



												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);





											}


										},
									});
									/*
											var discounts= idf/100*discount;
									var discounts= discounts.toFixed(2);
											
											var newamount=idf-discounts;
											$('.newamnt').text(newamount);
												var cat=parseInt($('#lfines').val())+parseInt(newamount);
											$('.newamnts').val(cat);


									$('.discnt').text(discounts);
													$('.afdiscount').val(newamount); */

								} else {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);
									var newamount = idf;
									$('.newamnt').text(idf);
									var cat = parseInt($('#lfines').val()) + parseInt(idf);
									$('.newamnts').val(cat);

									$('.afdiscount').val(idf);
								}

								document.getElementById(cks).disabled = false;



								if (selec == "StuAttendCk imp news") {



									//	$(".imp").prop('checked', true);

									if (sid == '41') {



										document.getElementById("s411850").disabled = false;


										var dev = $("#chk411850").val();



										var toi = parseInt($('.tamount').text()) + parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);

											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													}


												},
											});


											/* var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
	var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
        
			*/
										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);

										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = false;
										var toi = parseInt($('.tamount').text()) + parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);

											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});









											/*   var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
       */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);



										}

									}
								}
							},

						});
					} else {
						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) - parseInt(data);
								// $('#lfine').html(pluss);
								$('#lfines').val(pluss);





								if ($('.news').length == $('.news:checked').length) {
									$('.check-alls').prop('checked', true);

								} else {
									$('.check-alls').prop('checked', false);
								}
								var idf = $('.tamount').text() - id;
								$('.tamount').text(idf);



								if (discount > 0) {


									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {


												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);



											}


										},
									});


									/*
		var discounts= idf/100*discount;

var discounts= discounts.toFixed(2);
		 var newamount=idf-discounts;
	
	       
	    
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
		//$('#fees_discount').val(discounts);
				$('.afdiscount').val(newamount);
				$('.discnt').text(discounts); */
									if (newamount == '0') {
										$('.discnt').text('0');

									}
								} else {

									var idsf = $('.newamnt').text() - id;
									$('.newamnt').text(idsf);
									var cat = parseInt($('#lfines').val()) + parseInt(idsf);
									$('.newamnts').val(cat);
									$('.afdiscount').val(cat);
									if (idsf == '0') {
										$('.discnt').text('0');

									}

								}
								if (selec == "StuAttendCk imp news") {



									//$(".imp").prop('checked', false);
									if (sid == '41') {


										var dev = $("#chk411850").val();


										document.getElementById("s411850").disabled = true;



										var toi = parseInt($('.tamount').text()) - parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);




											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});



											/* var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
			var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
      */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = true;
										var toi = parseInt($('.tamount').text()) - parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);


											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});





											/*  var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
			var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount); */


										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}

									}


								}




								document.getElementById(cks).disabled = true;
								document.getElementById(id1).disabled = true;
								document.getElementById(id1).required = false;

							},

						});

					}

					if ($('.news').length == $('.news:checked').length) {
						$('.check-alls').prop('checked', true);

					} else {
						$('.check-alls').prop('checked', false);
					}


					if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
						$('.check-all').prop('checked', true);

					} else {
						$('.check-all').prop('checked', false);
					}
				};
			});
		</script>





	<? } else if ($students['class']['id'] == '25') { ?>



		<script type="text/javascript">
			$(function() {
				$('.check-all').click(function() {
					if (this.checked) {

						$('input:checkbox[id^="chk"]').trigger("click");

						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', false);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);




					} else {
						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');

						$('.afdiscount').val('0');
						$('.discnt').text('0' + '     %  ');
						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', true);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
					}
				});


				$('.check-alls').click(function() {
					$('#recipitno').val('0');
					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);

					$('#additionaldis').val('0');
					if (this.checked) {

						$(".addgen").css("display", "block");
						var sum = 0;
						$('.news').each(function() {
							sum += parseFloat($(this).val());
						});

						document.getElementById("chk1125000").disabled = false;
						document.getElementById("chk215000").disabled = false;
						document.getElementById("chk315000").disabled = false;
						// document.getElementById("chk119550").disabled = false;
						//  document.getElementById("chk411850").disabled = false;

						document.getElementById("s1125000").disabled = false;
						document.getElementById("s215000").disabled = false;
						document.getElementById("s315000").disabled = false;
						//  document.getElementById("s119550").disabled = false;
						//  document.getElementById("s411850").disabled = false;

						$('.tamount').text(sum);
						$('.newamnt').text(sum);
						$('.newamnts').val(sum);
						$('.discnt').text('0');
						$('#fees_discount').val('0');

						$("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());



						$('.news').prop('disabled', false);
						$('.news').prop('checked', true);
						$('.news').prop('required', true);

						$('.paper').prop('disabled', true);
						$('.paper1').prop('disabled', true);
						$('.paper').prop('checked', false);
						$('.paper').prop('required', false);


					} else {
						$('.paper').prop('disabled', false);
						$('.paper1').prop('disabled', false);



						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');
						$('.discnt').text('0');
						$('#fees_discount').val('0');


						$('.afdiscount').val('0');
						$(".addgen").css("display", "none");
						$('.news').prop('checked', false);
						$('.StuAttendCk').prop('checked', false);
						$('#otherfeeamts').val('0');
						$('#chkdiscountcateg').prop('selectedIndex', 0);

						$('#chkotherfee').prop('selectedIndex', 0);
						$('.news').prop('required', false);
						//    $('.paper').prop('disabled',true);
						//   $('.paper').prop('checked',false);

					}
				});



				window.check = function(sid, id, discount, dat) {
					$('.news').prop('required', false);

					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);
					var discount = $("#chkdiscountcateg option:selected").val();

					var ck = 'chk' + sid + id;
					var cks = 's' + sid + id;
					var id1 = 'pd' + sid + id;
					var chkbox = document.getElementById(ck);
					var selec = $("#" + ck).attr('class');



					if (sid == 1) {


						//  document.getElementById("chk119550").readOnly = true; 
						document.getElementById("s128000").disabled = false;

						document.getElementById("chk128000").disabled = false;


					} else if (sid == 41) {


						//document.getElementById("chk411850").readOnly = true; 
						// document.getElementById("chk128000").disabled = false; 
						//	  document.getElementById("s128000").disabled = false; 
						document.getElementById("s411850").disabled = false;
						document.getElementById("chk411850").disabled = false;


					} else if (sid == 2) {

						document.getElementById("s228000").disabled = false;
						document.getElementById("chk228000").disabled = false;



					} else if (sid == 3) {

						document.getElementById("s328000").disabled = false;
						document.getElementById("chk328000").disabled = false;




					} else if (sid == 4) {

						document.getElementById("s428000").disabled = false;
						document.getElementById("chk428000").disabled = false;



					}


					if (chkbox.checked) {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) + parseInt(data);
								//  $('#lfine').html(pluss);
								$('#lfines').val(pluss);



								$(".addgen").css("display", "block");

								if (discount > 0) {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);


									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {



												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);





											}


										},
									});
									/* var discounts= idf/100*discount;
var discounts= discounts.toFixed(2);
		
		var newamount=idf-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);


$('.discnt').text(discounts);
				$('.afdiscount').val(newamount); */

								} else {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);
									var newamount = idf;
									$('.newamnt').text(idf);
									var cat = parseInt($('#lfines').val()) + parseInt(idf);
									$('.newamnts').val(cat);

									$('.afdiscount').val(idf);
								}

								document.getElementById(cks).disabled = false;



								if (selec == "StuAttendCk imp news") {



									//	$(".imp").prop('checked', true);

									if (sid == '41') {



										document.getElementById("s411850").disabled = false;


										var dev = $("#chk411850").val();



										var toi = parseInt($('.tamount').text()) + parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);




											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													}


												},
											});

											/*   var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
        
			*/
										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);

										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = false;
										var toi = parseInt($('.tamount').text()) + parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);


											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});

											/*var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
	var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
       */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);



										}

									}
								}
							},

						});
					} else {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) - parseInt(data);
								// $('#lfine').html(pluss);
								$('#lfines').val(pluss);



								if ($('.news').length == $('.news:checked').length) {
									$('.check-alls').prop('checked', true);

								} else {
									$('.check-alls').prop('checked', false);
								}
								var idf = $('.tamount').text() - id;
								$('.tamount').text(idf);



								if (discount > 0) {


									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {


												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);



											}


										},
									});
									/* var discounts= idf/100*discount;

var discounts= discounts.toFixed(2);
		 var newamount=idf-discounts;
	
	       
	    
		$('.newamnt').text(newamount);
	var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
		//$('#fees_discount').val(discounts);
				$('.afdiscount').val(newamount);
				$('.discnt').text(discounts); */
									if (newamount == '0') {
										$('.discnt').text('0');

									}
								} else {

									var idsf = $('.newamnt').text() - id;
									$('.newamnt').text(idsf);
									var cat = parseInt($('#lfines').val()) + parseInt(idsf);
									$('.newamnts').val(cat);
									$('.afdiscount').val(cat);
									if (idsf == '0') {
										$('.discnt').text('0');

									}

								}
								if (selec == "StuAttendCk imp news") {



									//$(".imp").prop('checked', false);
									if (sid == '41') {


										var dev = $("#chk411850").val();


										document.getElementById("s411850").disabled = true;



										var toi = parseInt($('.tamount').text()) - parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);





											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});


											/* var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount); */


										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}




									} else if (sid == '31') {

										var dev = $("#chk315000").val();
										document.getElementById("s315000").disabled = true;
										var toi = parseInt($('.tamount').text()) - parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);







											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});



											/*  var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
  */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}

									}


								}




								document.getElementById(cks).disabled = true;
								document.getElementById(id1).disabled = true;
								document.getElementById(id1).required = false;
							},

						});
					}


					if ($('.news').length == $('.news:checked').length) {
						$('.check-alls').prop('checked', true);

					} else {
						$('.check-alls').prop('checked', false);
					}


					if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
						$('.check-all').prop('checked', true);

					} else {
						$('.check-all').prop('checked', false);
					}
				};
			});
		</script>





	<? } else if ($students['class']['id'] == '26' || $students['class']['id'] == '27') { ?>



		<script type="text/javascript">
			$(function() {
				$('.check-all').click(function() {
					if (this.checked) {

						$('input:checkbox[id^="chk"]').trigger("click");

						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', false);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', true);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', false);




					} else {
						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').text('0');

						$('.afdiscount').val('0');
						$('.discnt').text('0' + '     %  ');
						$(this).parents('table:eq(0)').find('.abs_remark').prop('disabled', true);
						$(this).parents('table:eq(0)').find(':checkbox').prop('checked', false);
						$(this).parents('table:eq(0)').find('.abs_remark').prop('required', true);
					}
				});


				$('.check-alls').click(function() {
					$('#recipitno').val('0');
					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);
					$('#additionaldis').val('0');
					if (this.checked) {

						$(".addgen").css("display", "block");
						var sum = 0;
						$('.news').each(function() {
							sum += parseFloat($(this).val());
						});

						document.getElementById("chk1140000").disabled = false;
						document.getElementById("chk210").disabled = false;
						document.getElementById("chk310").disabled = false;
						// document.getElementById("chk119550").disabled = false;
						//  document.getElementById("chk411850").disabled = false;

						document.getElementById("s1140000").disabled = false;
						document.getElementById("s210").disabled = false;
						document.getElementById("s310").disabled = false;
						//  document.getElementById("s119550").disabled = false;
						//  document.getElementById("s411850").disabled = false;


						$('.tamount').text(sum);
						$('.newamnt').text(sum);
						$('.newamnts').val(sum);
						$('.discnt').text('0');
						$('#fees_discount').val('0');

						$("#chkdiscountcateg").val($("#chkdiscountcateg option:first").val());




						$('.news').prop('disabled', false);
						$('.news').prop('checked', true);
						$('.news').prop('required', true);

						$('.paper').prop('disabled', true);
						$('.paper1').prop('disabled', true);
						$('.paper').prop('checked', false);
						$('.paper').prop('required', false);


					} else {
						$('.paper').prop('disabled', false);
						$('.paper1').prop('disabled', false);



						$('.tamount').text('0');
						$('.newamnt').text('0');
						$('.newamnts').val('0');
						$('.discnt').text('0');
						$('#fees_discount').val('0');


						$('.afdiscount').val('0');
						$(".addgen").css("display", "none");
						$('.news').prop('checked', false);
						$('.StuAttendCk').prop('checked', false);
						$('#otherfeeamts').val('0');
						$('#chkdiscountcateg').prop('selectedIndex', 0);

						$('#chkotherfee').prop('selectedIndex', 0);
						$('.news').prop('required', false);
						//    $('.paper').prop('disabled',true);
						//   $('.paper').prop('checked',false);


					}
				});



				window.check = function(sid, id, discount, dat) {
					$('.news').prop('required', false);

					$('#chkdiscountcateg').prop('disabled', false);
					$('#chkotherfee').prop('disabled', false);
					$('.StuAttendCkrg').prop('disabled', false);
					//var discount=$("#fees_discount").val();
					var discount = $("#chkdiscountcateg option:selected").val();

					var ck = 'chk' + sid + id;
					var cks = 's' + sid + id;
					var id1 = 'pd' + sid + id;
					var chkbox = document.getElementById(ck);
					var selec = $("#" + ck).attr('class');



					if (sid == 1) {



						document.getElementById("s138610").disabled = false;
						document.getElementById("chk138610").disabled = false;


					} else if (sid == 41) {



						document.getElementById("s410").disabled = false;
						document.getElementById("chk410").disabled = false;


					} else if (sid == 2) {

						document.getElementById("s238610").disabled = false;
						document.getElementById("chk238610").disabled = false;



					} else if (sid == 3) {

						document.getElementById("s338610").disabled = false;
						document.getElementById("chk338610").disabled = false;



					} else if (sid == 4) {

						document.getElementById("s438610").disabled = false;
						document.getElementById("chk438610").disabled = false;



					}




					if (chkbox.checked) {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) + parseInt(data);
								// $('#lfine').html(pluss);
								$('#lfines').val(pluss);



								$(".addgen").css("display", "block");

								if (discount > 0) {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);



									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {



												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);





											}


										},
									});
									/*
											var discounts= idf/100*discount;

											var discounts= discounts.toFixed(2);
											var newamount=idf-discounts;
											$('.newamnt').text(newamount);
										var cat=parseInt($('#lfines').val())+parseInt(newamount);
											$('.newamnts').val(cat);


									$('.discnt').text(discounts);
													$('.afdiscount').val(newamount); */

								} else {
									var idf = id;
									idf = parseInt($('.tamount').text()) + parseInt(idf);
									$('.tamount').text(idf);
									var newamount = idf;
									$('.newamnt').text(idf);
									var cat = parseInt($('#lfines').val()) + parseInt(idf);
									$('.newamnts').val(cat);
									$('.afdiscount').val(idf);
								}

								document.getElementById(cks).disabled = false;



								if (selec == "StuAttendCk imp news") {



									//	$(".imp").prop('checked', true);

									if (sid == '41') {



										document.getElementById("s410").disabled = false;


										var dev = $("#chk410").val();



										var toi = parseInt($('.tamount').text()) + parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);




											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													}


												},
											});
											/*  var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
			var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
        
			*/
										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);

										}




									} else if (sid == '31') {

										var dev = $("#chk310").val();
										document.getElementById("s310").disabled = false;
										var toi = parseInt($('.tamount').text()) + parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);


											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});


											/* var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
			var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
       */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);



										}

									}
								}
							},

						});
					} else {

						$.ajax({
							type: 'POST',
							url: '<?php echo ADMIN_URL; ?>Studentfees/finelate',
							data: {
								'pos': dat
							},
							success: function(data) {

								var pluss = parseInt($('#lfines').val()) - parseInt(data);
								// $('#lfine').html(pluss);
								$('#lfines').val(pluss);




								if ($('.news').length == $('.news:checked').length) {
									$('.check-alls').prop('checked', true);

								} else {
									$('.check-alls').prop('checked', false);
								}
								var idf = $('.tamount').text() - id;
								$('.tamount').text(idf);



								if (discount > 0) {



									var myselectedid = ck;
									var vale = $('#' + ck).val();
									var cleanUrl = myselectedid.replace(/^chk/, 'sp');
									var ffheads = $('#' + cleanUrl).val();
									var selectedValue = discount;

									$.ajax({
										type: 'POST',
										url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
										data: {
											'ffheads': ffheads,
											'sevalue': selectedValue,
											'amty': vale
										},
										success: function(data) {


											if (data > 0) {

												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);

											} else {


												var toi = parseInt($('.tamount').text());
												var additionaldis = parseInt($('#additionaldis').val());

												// alert($('#fees_discount').val());
												var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

												//alert(fdiscou);
												$('#fees_discount').val(fdiscou);

												var discounts = fdiscou;
												var newamount = toi - discounts;


												if (additionaldis != '0' && newamount >= additionaldis) {
													var newamounts = parseInt(newamount) - parseInt(additionaldis);
													//$('.newamnt').text(newamount);
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
													$('#depositamt').val(newamounts);
												} else {
													$('.newamnt').text(newamount);
													var cat = parseInt($('#lfines').val()) + parseInt(newamount);
													$('.newamnts').val(cat);
												}
												$('.afdiscount').val(newamount);
												$(".disfee").html(discounts);
												var discounts = discounts;
												$(".discnt").html(discounts);



											}


										},
									});


									//var discounts= idf/100*discount;


									/*var discounts= discounts.toFixed(2);

											 var newamount=idf-discounts;
										
										       
										    
											$('.newamnt').text(newamount);
												var cat=parseInt($('#lfines').val())+parseInt(newamount);
											$('.newamnts').val(cat);
											//$('#fees_discount').val(discounts);
													$('.afdiscount').val(newamount);
													$('.discnt').text(discounts); */
									if (newamount == '0') {
										$('.discnt').text('0');

									}
								} else {

									var idsf = $('.newamnt').text() - id;
									$('.newamnt').text(idsf);
									var cat = parseInt($('#lfines').val()) + parseInt(idsf);
									$('.newamnts').val(cat);
									$('.afdiscount').val(cat);
									if (idsf == '0') {
										$('.discnt').text('0');

									}

								}
								if (selec == "StuAttendCk imp news") {



									//$(".imp").prop('checked', false);
									if (sid == '41') {


										var dev = $("#chk410").val();


										document.getElementById("s410").disabled = true;



										var toi = parseInt($('.tamount').text()) - parseInt(dev);

										if (discount > 0) {
											$('.tamount').text(toi);





											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});



											/*
      var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
	var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount); */


										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}




									} else if (sid == '31') {

										var dev = $("#chk310").val();
										document.getElementById("s310").disabled = true;
										var toi = parseInt($('.tamount').text()) - parseInt(dev);
										if (discount > 0) {
											$('.tamount').text(toi);





											var myselectedid = ck;
											var vale = $('#' + ck).val();
											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
											var ffheads = $('#' + cleanUrl).val();
											var selectedValue = discount;

											$.ajax({
												type: 'POST',
												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
												data: {
													'ffheads': ffheads,
													'sevalue': selectedValue,
													'amty': vale
												},
												success: function(data) {


													if (data > 0) {

														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);

													} else {


														var toi = parseInt($('.tamount').text());
														var additionaldis = parseInt($('#additionaldis').val());

														// alert($('#fees_discount').val());
														var fdiscou = parseFloat($('#fees_discount').val()) - parseFloat(data);

														//alert(fdiscou);
														$('#fees_discount').val(fdiscou);

														var discounts = fdiscou;
														var newamount = toi - discounts;


														if (additionaldis != '0' && newamount >= additionaldis) {
															var newamounts = parseInt(newamount) - parseInt(additionaldis);
															//$('.newamnt').text(newamount);
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
															$('#depositamt').val(newamounts);
														} else {
															$('.newamnt').text(newamount);
															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
															$('.newamnts').val(cat);
														}
														$('.afdiscount').val(newamount);
														$(".disfee").html(discounts);
														var discounts = discounts;
														$(".discnt").html(discounts);



													}


												},
											});





											/* var discounts= toi/100*discount;
       var newamount=toi-discounts;
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
        $('.afdiscount').val(newamount);
  */

										} else {

											$('.tamount').text(toi);
											$('.newamnt').text(toi);
											var cat = parseInt($('#lfines').val()) + parseInt(toi);
											$('.newamnts').val(cat);
											$('.afdiscount').val(toi);


										}

									}


								}




								document.getElementById(cks).disabled = true;
								document.getElementById(id1).disabled = true;
								document.getElementById(id1).required = false;
							},

						});
					}

					if ($('.news').length == $('.news:checked').length) {
						$('.check-alls').prop('checked', true);

					} else {
						$('.check-alls').prop('checked', false);
					}


					if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
						$('.check-all').prop('checked', true);

					} else {
						$('.check-all').prop('checked', false);
					}
				};
			});
		</script>





	<? }  ?>

	<script type="text/javascript">
		$(function() {

			window.checks = function(id) {


				var doc = $('input[name="mode"]:checked').val();
				if (doc == "CASH") {

					$("#che").css("display", "none");
					$("#ref").hide();
					$("#bnk").css("display", "none");
					document.getElementById('chequno').required = false;
					document.getElementById('bank').required = false;
					document.getElementById('refno').required = false;


				} else if (doc == "CHEQUE") {

					$("#che").show();
					$("#ref").hide();
					$("#bnk").show();

					document.getElementById('chequno').required = true;
					document.getElementById('bank').required = true;
					document.getElementById('refno').required = false;

				} else if (doc == "DD") {

					$("#che").show();

					$("#ref").hide();
					$("#bnk").show();

					document.getElementById('chequno').required = true;
					document.getElementById('bank').required = true;
					document.getElementById('refno').required = false;

				} else if (doc == "NETBANKING") {

					$("#ref").show();
					$("#che").hide();

					$("#bnk").hide();
					document.getElementById('chequno').required = false;
					document.getElementById('refno').required = true;
					document.getElementById('bank').required = false;

				} else if (doc == "Credit Card/Debit Card/UPI") {

					$("#ref").show();

					$("#che").hide();
					$("#bnk").hide();
					document.getElementById('chequno').required = false;
					document.getElementById('refno').required = true;
					document.getElementById('bank').required = false;

				} else {

					$("#che").show();
					$("#bnk").show();

					document.getElementById('chequno').required = true;
					document.getElementById('bank').required = true;

				}

			}




			$('.stuattendance-sa_date').datepicker({

				maxDate: 0,
				changeMonth: true,
				dateFormat: 'dd-mm-yy',
				onSelect: function() {
					$('#stud-attendance-form').submit();
				}
			});
			$('.stuattendance-sa_date1').datepicker({

				maxDate: 0,
				changeMonth: true,
				dateFormat: 'dd-mm-yy',
				onSelect: function() {
					$('#stud-attendance-form').submit();
				}
			});
			$('.stuattendance-sa_date2').datepicker({

				maxDate: 0,
				changeMonth: true,
				dateFormat: 'dd-mm-yy',
				onSelect: function() {
					$('#stud-attendance-form').submit();
				}
			});

		});
	</script>
	<?php if ($selectid) { ?>

		<script>
			var id = '<?php echo $selectid; ?>';
			$(document).ready(function() {


				$('#personal-tab').removeClass('active');
				$('.tab-pane').removeClass('active');
				$('#' + id + '-tab').addClass('active');
				$('#' + id).addClass('active');

			});
		</script>



	<?php } ?>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			<!--/.col (left) -->
			<!-- right column -->
			<div class="col-md-12">
				<!-- Horizontal Form -->
				<div class="box box-info">

					<!-- /.box-header -->
					<!-- form start -->

					<div class="box-body">
						<?php echo $this->Flash->render(); ?>

						<div class="box box-solid">
							<div class="box-header left-align">
								<div class="user-block col-sm-9 no-padding">
									<img class="img-circle img-bordered-sm" src="<?php echo SITE_URL; ?>images/stu-image.png" alt="No Image"> <span class="username">
										<a href="<?php echo SITE_URL; ?>admin/students/view/<?php echo $students['id']; ?>"><?php echo ucfirst($students['fname']); ?> <?php echo ucfirst($students['middlename']); ?> <?php echo ucfirst($students['lname']); ?></a> (<b style="color:green;"><?php echo $students['enroll']; ?></b>) </span>
									<span class="description">

										<strong>Class </strong> : <?php echo $students['class']['title']; ?> |
										<strong>Section </strong> : <?php echo $students['section']['title']; ?> |
										<strong>House </strong> : <?php $house = $this->Comman->findhouse($students['h_id']);
																	echo $house['name']; ?> |
										<strong>Father Name </strong> : <?php echo $students['fathername']; ?> | <strong>Mobile No. : </strong> <?php echo $students['mobile']; ?>
									</span>
								</div>

							</div>
							<section class="content">








								<div class="row edusec-user-profile">
									<div class="col-sm-12">
										<!--	<ul class="nav nav-tabs responsive hidden-xs hidden-sm" id="">
<?php if ($is_transport == '1') { ?>

			<?php } ?>
			<?php if ($is_hostel == '1') { ?>
			<li id="guardians-tab"><a href="<?php echo ADMIN_URL; ?>studentfees/index/<?php echo $id; ?>/<?php echo $academic_year; ?>?id=guardians" ><i class="fa fa-bed"></i> Hostel Fee</a></li>
		<?php } ?>
			<?php if (!empty($students['due_fees']) && isset($students['due_fees'])) { ?>
			<li id="pduefee-tab"><a href="<?php echo ADMIN_URL; ?>studentfees/index/<?php echo $id; ?>/<?php echo $academic_year; ?>?id=pduefee" ><i cl0%ass="fa fa-bed"></i> Previous Due Fee</a></li>
	 $('.news').each(function(){
    sum += parseFloat($(this).val());  
});	<?php } elseif (!empty($personalduefees['due_fees']) && isset($personalduefees['due_fees'])) { ?>
			<li id="pduefee-tab"><a href="<?php echo ADMIN_URL; ?>studentfees/index/<?php echo $id; ?>/<?php echo $academic_year; ?>?id=pduefee" ><i cl0%ass="fa fa-bed"></i> Previous Due Fee</a></li>
		<?php } ?>	
		</ul>-->


										<div id="content" class="tab-content responsive hidden-xs hidden-sm">
											<script type="text/javascript">
												$(document).ready(function() {
													$('#sevice_form').submit(function(event) {
														if ($('#bankcharged').val()) {



															if (confirm("Do You Want To Cancel Receipt ?")) {
																if (confirm("Do You Want To Print Receipt ?")) {
																	$('input[name=hdfb]').val('1');


																} else {


																	$('input[name=hdfb]').val('2');
																}
																return true;

															} else {


																$('input[name=hdfb]').val('2');

																return false;
															}

														} else {

															/*  if(confirm("Do You Want To Print Receipt ?")){
	   $('input[name=hdfb]').val('1'); 
	
   
}else{   
	
	*/
															$('input[name=hdfb]').val('2');
															//}
														}


													});
												});
											</script>
											<div class="tab-pane active" id="personal">

												<? if ($students['category'] != "RTE") { ?>
													<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_form" validate="validate" action="<?php echo ADMIN_URL; ?>studentfees/add">


														<?


														$quasu = array();
														foreach ($studentfees as $ku => $valueu) {
															$quasu[] = unserialize($valueu['quarter']);
														}


														$quafu = array();

														foreach ($quasu as $hu => $valeu) {

															$quafu = array_merge($quafu, $valeu);
														}
														$rtu = array();
														foreach ($quafu as $ju => $tu) {

															$quau[] = $ju;
														}



														if (!in_array("Admission Fee", $quau)) {
														?>


															<p style="text-align:center;"><input type="checkbox" class="check-alls"><span style="font-size:20px;"> New Student</span> </p>
														<? } ?>

														<div class="row">
															<div class="col-lg-6">




																<? $def = 0;
																$quas = array();
																foreach ($studentfees as $k => $value) {
																	$quas[] = unserialize($value['quarter']);
																}


																$quaf = array();

																foreach ($quas as $h => $vale) {

																	$quaf = array_merge($quaf, $vale);
																}
																$rt = array();
																foreach ($quaf as $j => $t) {

																	$qua[] = $j;
																}
																//pr($qua); 

																if (!in_array("Admission Fee", $qua) || !in_array("Development Fee", $qua) || !in_array("Caution Money", $qua)  || !in_array("Miscellaneous Fee", $qua)  || !in_array("Quater1", $qua)  || !in_array("Quater2", $qua) || !in_array("Quater3", $qua) || !in_array("Quater4", $qua)) { ?>
																	<table class="table table-striped table-hover table-condensed table-responsive" id="mytable">

																		<tbody>
																			<tr class="table_header">
																				<th class="bg-teal color-palette"></th>

																				<th class="text-left bg-teal color-palette"> Heads </th>
																				<th class="text-left bg-teal color-palette"> Last Date </th>
																				<th class="text-left bg-teal color-palette"> Fee </th>





																			</tr>


																			<?php


																			if (isset($classfee) && !empty($classfee)) {


																				$jk = 1;
																				$kl = 0;
																				$y = 1;
																				foreach ($preclassfee as $krt => $value) {
																			?>
																					<tr>


																						<input type="hidden" name="student_id" value="<?php echo $id; ?>">
																						<input type="hidden" name="hdfb" id="hdfbd" value="2">


																						<? $findfee = $this->Comman->findfeeheadsname($value['fee_h_id']); ?>

																						<? if ($findfee['name'] == "Admission Fee") {
																							if (!in_array("Admission Fee", $qua)) {  ?><td style="width:4px;">
																									<label>
																										<input type="checkbox" id="chk<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCk imp news" name="amount[]" onclick="check(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
																									</label>
																								</td>

																							<?

																							}
																						} else if ($findfee['name'] == "Caution Money") {
																							if (!in_array("Caution Money", $qua)) {  ?><td style="width:4px;">
																									<label>
																										<input type="checkbox" onclick="checkpaper(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" id="chk<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCks paper" name="amount[]" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
																									</label>
																								</td>

																							<? }
																						} else if ($findfee['name'] == "Development Fee") {
																							if (!in_array("Development Fee", $qua)) {  ?><td style="width:4px;">
																									<label>
																										<input type="checkbox" onclick="check(<?php echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" id="chk<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCk imp news" name="amount[]" value="<?php echo $value['qu' . $jk . '_fees']; ?>">
																									</label>
																								</td>

																							<? }
																						} else if ($findfee['name'] == "Miscellaneous Fee") {
																							if (!in_array("Miscellaneous Fee", $qua)) {  ?><td style="width:4px;">
																									<label>
																										<input type="checkbox" id="chk<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" class="StuAttendCk" name="amount[]" value="<?php echo $value['qu' . $jk . '_fees']; ?>" <?php if (in_array("Admission Fee", $qua)) { ?> onclick="check(<? echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" <? } else { ?> onclick="check(<? echo $y; ?><? echo $jk; ?>,<?php echo $value['qu' . $jk . '_fees']; ?>,<?php echo $discount_fees; ?>,0)" <? } ?>></label>
																								</td>
																						<? }
																						} ?>






																						<? if ($findfee['name'] == "Admission Fee") {
																							if (!in_array("Admission Fee", $qua)) {  ?>

																								<td> <input type="text" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['name']; ?>" readonly disabled="">

																									<input type="hidden" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
																								</td>


																							<? }
																						} else if ($findfee['name'] == "Caution Money") {
																							if (!in_array("Caution Money", $qua)) {  ?>

																								<td> <input type="text" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" class="paper1" value="<? echo $findfee['name']; ?>" readonly disabled="">
																									<input type="hidden" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">

																								</td>


																							<? }
																						} else if ($findfee['name'] == "Development Fee") {
																							if (!in_array("Development Fee", $qua)) {  ?>
																								<td> <input type="text" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['name']; ?>" readonly disabled="">

																									<input type="hidden" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
																								</td>



																							<? }
																						} else if ($findfee['name'] == "Miscellaneous Fee") {
																							if (!in_array("Miscellaneous Fee", $qua)) {  ?><td> <input type="text" style="background-color: transparent;border: none;" name="quater[]" id="s<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['name']; ?>" readonly disabled="">
																									<input type="hidden" style="background-color: transparent;border: none;" id="sp<? echo $y; ?><? echo $jk; ?><?php echo $value['qu' . $jk . '_fees']; ?>" value="<? echo $findfee['id']; ?>" readonly disabled="">
																								</td>

																						<? }
																						} ?>



																						<? if ($findfee['name'] == "Admission Fee") {
																							if (!in_array("Admission Fee", $qua)) {  ?>

																								<td><?php $dat = date('Y-m-d', strtotime($value['qu' . $jk . '_date']));
																									if ($dat != '1970-01-01') {
																										echo date('d-m-Y', strtotime($dat));
																									} else {
																										echo "not-set";
																									} ?></td>


																							<? }
																						} else if ($findfee['name'] == "Caution Money") {
																							if (!in_array("Caution Money", $qua)) {  ?>

																								<td><?php $dat = date('Y-m-d', strtotime($value['qu' . $jk . '_date']));
																									if ($dat != '1970-01-01') {
																										echo date('d-m-Y', strtotime($dat));
																									} else {
																										echo "not-set";
																									} ?></td>


																							<? }
																						} else if ($findfee['name'] == "Development Fee") {
																							if (!in_array("Development Fee", $qua)) {  ?>
																								<td><?php $dat = date('Y-m-d', strtotime($value['qu' . $jk . '_date']));
																									if ($dat != '1970-01-01') {
																										echo date('d-m-Y', strtotime($dat));
																									} else {
																										echo "not-set";
																									} ?></td>



																							<? }
																						} else if ($findfee['name'] == "Miscellaneous Fee") {
																							if (!in_array("Miscellaneous Fee", $qua)) {  ?><td><?php $dat = date('Y-m-d', strtotime($value['qu' . $jk . '_date']));
																								if ($dat != '1970-01-01') {
																									echo date('d-m-Y', strtotime($dat));
																								} else {
																									echo "not-set";
																								} ?></td>

																						<? }
																						} ?>


																						<? if ($findfee['name'] == "Admission Fee") {
																							if (!in_array("Admission Fee", $qua)) {  ?>

																								<td><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
																																				echo number_format($value['qu' . $jk . '_fees']);
																																			} else {
																																				echo "not-set";
																																			} ?></td>


																							<? }
																						} else if ($findfee['name'] == "Caution Money") {
																							if (!in_array("Caution Money", $qua)) {  ?>

																								<td><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
																																				echo number_format($value['qu' . $jk . '_fees']);
																																			} else {
																																				echo "not-set";
																																			} ?></td>


																							<? }
																						} else if ($findfee['name'] == "Development Fee") {
																							if (!in_array("Development Fee", $qua)) {  ?>
																								<td><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
																																				echo number_format($value['qu' . $jk . '_fees']);
																																			} else {
																																				echo "not-set";
																																			} ?></td>


																							<? }
																						} else if ($findfee['name'] == "Miscellaneous Fee") {
																							if (!in_array("Miscellaneous Fee", $qua)) {  ?><td><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
																									echo number_format($value['qu' . $jk . '_fees']);
																								} else {
																									echo "not-set";
																								} ?></td>

																						<? }
																						} ?>







																					</tr>

																				<? $y++;
																				}

																				for ($i = 1; $i < 5; $i++) {     ?>
																					<tr>
																						<input type="hidden" name="student_id" value="<?php echo $id; ?>">

																						<?php
																						$rg = $this->Comman->findclassfee($academic_class, $academic_year);

																						$currentdoate = strtotime(date('d-m-Y'));

																						$clodate = strtotime(date('Y-m-d', strtotime($rg['qu' . $i . '_date'])));


																						$kb = $i - 1;
																						$clodateprev = strtotime(date('Y-m-d', strtotime($rg['qu' . $kb . '_date'])));


																						if ($i == 1) { ?>




																							<?php $rg = $this->Comman->findclassfee($academic_class, $academic_year);
																							if (!in_array("Quater" . $i, $qua)) {
																								if ($classfee[0]['qu' . $i . '_fees'] != 0) {
																									$def = 1;
																									$dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
																									if ($dat != '1970-01-01') {
																							?>

																										<td style="width:4px;">



																											<label>
																												<input type="checkbox" id="chk<?php echo $i; ?><?php echo
																																								$classfee[0]['qu' . $i . '_fees']; ?>" class="StuAttendCk" name="amount[]" <?php if ($clodate < $currentdoat) { ?> onclick="check(<?php echo $i;
																	?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } else { ?> onclick="check(<?php echo $i;
																																													?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <?   } ?> value="<?php echo $classfee[0]['qu' . $i . '_fees']; ?>"> <?php }
																																																				}
																																																			} ?>


																											</label>
																										</td>


																									<? } else  if ($i == 2) { ?>




																										<?php $rg = $this->Comman->findclassfee($academic_class, $academic_year);
																										if (!in_array("Quater" . $i, $qua)) {
																											if ($classfee[0]['qu' . $i . '_fees'] != 0) {
																												$def = 1;
																												$dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
																												if ($dat != '1970-01-01') {
																										?><td style="width:4px;">



																														<label>
																															<input type="checkbox" id="chk<?php echo $i; ?><?php echo
																																											$classfee[0]['qu' . $i . '_fees']; ?>" class="StuAttendCk <?
																													if ($i == 1) { ?>news <? } ?>" name="amount[]" <?php if (in_array("Quater1", $qua) || $clodate >= $currentdoate && $clodateprev < $currentdoate) { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } else { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo $classfee[0]['id']; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } ?> value="<?php echo $classfee[0]['qu' . $i . '_fees']; ?>"> <?php }
																																																																																																																																															}
																																																																																																																																														} ?>

																														</label>
																													</td>



																												<? } else  if ($i == 3) { ?>




																													<?php $rg = $this->Comman->findclassfee($academic_class, $academic_year);
																													if (!in_array("Quater" . $i, $qua)) {
																														if ($classfee[0]['qu' . $i . '_fees'] != 0) {
																															$def = 1;
																															$dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
																															if ($dat != '1970-01-01') {
																													?><td style="width:4px;">



																																	<label>
																																		<input type="checkbox" id="chk<?php echo $i; ?><?php echo
																																														$classfee[0]['qu' . $i . '_fees']; ?>" class="StuAttendCk <?
																																if ($i == 1) { ?>news <? } ?>" name="amount[]" <?php if (in_array("Quater2", $qua)  || $clodate >= $currentdoate && $clodateprev < $currentdoate) { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']) ?>)" <? } else { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } ?> value="<?php echo $classfee[0]['qu' . $i . '_fees']; ?>"> <?php }
																																																																																																																																							}
																																																																																																																																						} ?>


																																	</label>
																																</td>


																															<? } else  if ($i == 4) { ?>




																																<?php $rg = $this->Comman->findclassfee($academic_class, $academic_year);
																																if (!in_array("Quater" . $i, $qua)) {
																																	if ($classfee[0]['qu' . $i . '_fees'] != 0) {
																																		$def = 1;
																																		$dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
																																		if ($dat != '1970-01-01') {
																																?><td style="width:4px;">



																																				<label>
																																					<input type="checkbox" id="chk<?php echo $i; ?><?php echo
																																																	$classfee[0]['qu' . $i . '_fees']; ?>" class="StuAttendCk <? if ($i == 1) { ?>news <? } ?>" name="amount[]" <?php if (in_array("Quater3", $qua)  || $clodate >= $currentdoate && $clodateprev < $currentdoate) { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } else { ?> onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu' . $i . '_fees']; ?>,<?php echo $discount_fees; ?>,<? echo strtotime($rg['qu' . $i . '_date']); ?>)" <? } ?> value="<?php echo $classfee[0]['qu' . $i . '_fees']; ?>"> <?php }
																																																																																																																																																						}
																																																																																																																																																					} ?>

																																				</label>
																																			</td>



																																		<? } /*else{  ?>
			
					<?php $rg=$this->Comman->findclassfee($academic_class,$academic_year); if (!in_array("Quater".$i, $qua))
  { if($classfee[0]['qu'.$i.'_fees'] != 0){ $def=1;    $dat= date('Y-m-d',strtotime($rg['qu'.$i.'_date'])); if($dat!='1970-01-01'){
	    ?>
						<input type="checkbox"  disabled id="chk<?php echo $i; ?><?php echo $classfee[0]['qu'.$i.'_fees']; ?>" class="StuAttendCk <? if($i==1){ ?>news <? } ?>" name="amount[]" value="<?php echo $classfee[0]['qu'.$i.'_fees']; ?>"  onclick="check(<?php echo $i; ?>,<?php echo $classfee[0]['qu'.$i.'_fees']; ?>,<?php echo $discount_fees; ?>)"> <?php } } }else{ ?><input type="radio"  class="StuAttendCks"  checked="checked" readonly disabled  ><?php } ?>
						
					<?  } */ ?>





																																		<? $rg = $this->Comman->findclassfee($academic_class, $academic_year);
																																		if ($i == 1) {
																																			if (!in_array("Quater" . $i, $qua)) {   ?>
																																				<td>
																																					<input type="text" style="background-color: transparent;border: none;" value="Tution Fee (APRIL-JUNE)">
																																				</td>
																																			<? }
																																		} else if ($i == 2) {
																																			if (!in_array("Quater" . $i, $qua)) {  ?>
																																				<td>
																																					<input type="text" style="background-color: transparent;border: none;" value="Tution Fee (JULY-SEPT.)">
																																				</td>
																																			<? }
																																		} else if ($i == 3) {
																																			if (!in_array("Quater" . $i, $qua)) { ?>
																																				<td>
																																					<input type="text" style="background-color: transparent;border: none;" value="Tution Fee (OCT.-DEC.)">
																																				</td>
																																			<? }
																																		} else if ($i == 4) {
																																			if (!in_array("Quater" . $i, $qua)) { ?>
																																				<td>
																																					<input type="text" style="background-color: transparent;border: none;" value="Tution Fee (JAN.-MARCH)">
																																				</td>
																																		<? }
																																		} ?>
																																		<?php if (!in_array("Quater" . $i, $qua)) {  ?>
																																			<input type="hidden" style="background-color: transparent;border: none;" name="quater[]" id="s<?php echo $i; ?><?php echo $classfee[0]['qu' . $i . '_fees']; ?>" value="Quater<?php echo $i; ?>" readonly disabled="">
																																			<input type="hidden" style="background-color: transparent;border: none;" id="sp<?php echo $i; ?><?php echo $classfee[0]['qu' . $i . '_fees']; ?>" value="2" readonly disabled="">

																																		<?php } ?>



																																		<? $rg = $this->Comman->findclassfee($academic_class, $academic_year);
																																		if ($i == 1) {
																																			if (!in_array("Quater" . $i, $qua)) {   ?>

																																				<td><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
																																					if ($dat != '1970-01-01') {
																																						echo date('d-m-Y', strtotime($dat));
																																					} else {
																																						echo "not-set";
																																					} ?></td>
																																			<? }
																																		} else if ($i == 2) {
																																			if (!in_array("Quater" . $i, $qua)) {  ?>
																																				<td><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
																																					if ($dat != '1970-01-01') {
																																						echo date('d-m-Y', strtotime($dat));
																																					} else {
																																						echo "not-set";
																																					} ?></td>
																																			<? }
																																		} else if ($i == 3) {
																																			if (!in_array("Quater" . $i, $qua)) { ?>
																																				<td><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
																																					if ($dat != '1970-01-01') {
																																						echo date('d-m-Y', strtotime($dat));
																																					} else {
																																						echo "not-set";
																																					} ?></td>
																																			<? }
																																		} else if ($i == 4) {
																																			if (!in_array("Quater" . $i, $qua)) { ?>
																																				<td><?php $dat = date('Y-m-d', strtotime($rg['qu' . $i . '_date']));
																																					if ($dat != '1970-01-01') {
																																						echo date('d-m-Y', strtotime($dat));
																																					} else {
																																						echo "not-set";
																																					} ?></td>
																																		<? }
																																		} ?>






																																		<? $rg = $this->Comman->findclassfee($academic_class, $academic_year);
																																		if ($i == 1) {
																																			if (!in_array("Quater" . $i, $qua)) {   ?>

																																				<td><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
																																																echo number_format($classfee[0]['qu' . $i . '_fees']);
																																															} else {
																																																echo "not-set";
																																															} ?></td>

																																			<? }
																																		} else if ($i == 2) {
																																			if (!in_array("Quater" . $i, $qua)) {  ?>
																																				<td><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
																																																echo number_format($classfee[0]['qu' . $i . '_fees']);
																																															} else {
																																																echo "not-set";
																																															} ?></td>

																																			<? }
																																		} else if ($i == 3) {
																																			if (!in_array("Quater" . $i, $qua)) { ?>
																																				<td><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
																																																echo number_format($classfee[0]['qu' . $i . '_fees']);
																																															} else {
																																																echo "not-set";
																																															} ?></td>

																																			<? }
																																		} else if ($i == 4) {
																																			if (!in_array("Quater" . $i, $qua)) { ?>
																																				<td><span class="text-black">&#8377; </span><?php if ($dat != '1970-01-01') {
																																																echo number_format($classfee[0]['qu' . $i . '_fees']);
																																															} else {
																																																echo "not-set";
																																															} ?></td>

																																		<? }
																																		} ?>







																					</tr>
																			<?php }
																			} ?>

																		</tbody>
																	</table>

																<? } ?>

																<script>
																	$(function() {


																		window.chkotherfsees = function(sid) {




																			var opt = $("#" + sid + " option:selected").val();


																			if (opt == '1') {

																				$("#formnos1").css("display", "inline-block");
																				$("#formnos1").css("width", "100%");
																				document.getElementById("formnos").required = true;

																			} else {
																				$("#formnos1").css("display", "none");
																				$("#formnos1").css("width", "100%");
																				document.getElementById("formnos").required = false;

																			}
																			var boardst = '<? echo $students['board_id']; ?>';

																			$(".addgen").css("display", "block");
																			$(".addgen23").css("display", "none");

																			//$('#otherfeeamts').val('0');

																			$.ajax({
																				type: 'POST',
																				url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
																				data: {
																					'opt': opt,
																					'boardst': boardst
																				},
																				success: function(data) {


																					//var discount=$("#fees_discount").val();
																					var discount = $("#chkdiscountcateg option:selected").val();
																					if (discount > 0) {
																						if ($('#otherfeeamts').val() != '0') {

																							var idf = parseInt($('.tamount').text()) + parseInt(data) - parseInt($('#otherfeeamts').val());

																						} else {

																							var idf = parseInt($('.tamount').text()) + parseInt(data);
																						}


																						if ($('#otherfeeamts').val() != '0') {

																							var newamntdf = parseInt($('.newamnt').text()) + parseInt(data) - parseInt($('#otherfeeamts').val());

																						} else {

																							var newamntdf = parseInt($('.newamnt').text()) + parseInt(data);
																						}

																						$('#otherfeeamts').val(data);

																						$('.tamount').text(idf);

																						$('.newamnt').text(newamntdf);

																						$('.newamnts').val(newamntdf);
																						$('.afdiscount').val(newamntdf);
																						$('#depositamt').val(newamntdf);


																						var vale = $('#otherfeeamts').val();
																						var selectedValue = discount;
																						var ffheads = opt;

																						$.ajax({
																							type: 'POST',
																							url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
																							data: {
																								'ffheads': ffheads,
																								'sevalue': selectedValue,
																								'amty': vale
																							},
																							success: function(data) {


																								if (data > 0) {

																									var toi = parseInt($('.tamount').text());
																									var additionaldis = parseInt($('#additionaldis').val());

																									// alert($('#fees_discount').val());
																									var fdiscou = parseFloat(data);

																									//alert(fdiscou);
																									$('#fees_discount').val(fdiscou);

																									var discounts = fdiscou;
																									var newamount = toi - discounts;


																									if (additionaldis != '0' && newamount >= additionaldis) {
																										var newamounts = parseInt(newamount) - parseInt(additionaldis);
																										//$('.newamnt').text(newamount);
																										$('.newamnt').text(newamount);
																										var cat = parseInt($('#lfines').val()) + parseInt(newamount);
																										$('.newamnts').val(cat);
																										$('#depositamt').val(newamounts);
																									} else {
																										$('.newamnt').text(newamount);
																										var cat = parseInt($('#lfines').val()) + parseInt(newamount);
																										$('.newamnts').val(cat);
																									}
																									$('.afdiscount').val(newamount);
																									$(".disfee").html(discounts);
																									var discounts = discounts;
																									$(".discnt").html(discounts);

																								} else {








																									/* $('#fees_discount').val('0');
	       $(".discnt").html('0');
		var newamount=idf;
		$('.newamnt').text(idf);
		var cat=parseInt($('#lfines').val())+parseInt(idf);
	
		$('.newamnts').val(cat);

		$('.afdiscount').val(idf);
	   
	   */
																								}


																							},
																						});
																						//  alert(dasr);




																						//  alert(dasr);













																						//~ var discounts= idf/100*discount;
																						//~ var discounts= discounts.toFixed(2);

																						//~ var newamount=idf-discounts;
																						//~ $('.newamnt').text(newamount);

																						//~ var cat=parseInt($('#lfines').val())+parseInt(newamount);
																						//~ $('.newamnts').val(cat);



																						//~ $('.discnt').text(discounts);
																						//~ $('.afdiscount').val(newamount);

																					} else {
																						//var idf=data;
																						if ($('#otherfeeamts').val() != '0') {

																							var idf = parseInt($('.tamount').text()) + parseInt(data) - parseInt($('#otherfeeamts').val());

																						} else {

																							var idf = parseInt($('.tamount').text()) + parseInt(data);
																						}
																						$('#otherfeeamts').val(data);

																						$('.tamount').text(idf);




																						//~ var vale=$('#otherfeeamts').val(); 
																						//~ var selectedValue=$('#chkdiscountcateg').val(); 

																						//~ var ffheads= opt;
																						//~ alert(ffheads);

																						//~ alert(selectedValue);
																						//~ alert(vale);

																						//~ $.ajax({ 
																						//~ type: 'POST', 
																						//~ url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
																						//~ data: {'ffheads':ffheads,'sevalue':selectedValue,'amty':vale},
																						//~ success: function(data){ 


																						//~ if(data >0){

																						//~ var toi=parseInt($('.tamount').text());
																						//~ var additionaldis=parseInt($('#additionaldis').val());

																						//~ // alert($('#fees_discount').val());
																						//~ var fdiscou=parseFloat($('#fees_discount').val())+parseFloat(data);

																						//~ //alert(fdiscou);
																						//~ $('#fees_discount').val(fdiscou);

																						//~ var discounts= fdiscou;
																						//~ var newamount=toi-discounts;


																						//~ if(additionaldis!='0' && newamount>=additionaldis){
																						//~ var newamounts=parseInt(newamount)-parseInt(additionaldis);
																						//~ //$('.newamnt').text(newamount);
																						//~ $('.newamnt').text(newamount);
																						//~ var cat=parseInt($('#lfines').val())+parseInt(newamount);
																						//~ $('.newamnts').val(cat);
																						//~ $('#depositamt').val(newamounts);   
																						//~ }else{
																						//~ $('.newamnt').text(newamount);
																						//~ var cat=parseInt($('#lfines').val())+parseInt(newamount);
																						//~ $('.newamnts').val(cat);
																						//~ }
																						//~ $('.afdiscount').val(newamount);
																						//~ $(".disfee").html(discounts);
																						//~ var discounts= discounts;
																						//~ $(".discnt").html(discounts);

																						//~ }


																						//~ },
																						//~ });
																						//  alert(dasr);






																						var newamount = idf;
																						$('.newamnt').text(idf);
																						var cat = parseInt($('#lfines').val()) + parseInt(idf);

																						$('.newamnts').val(cat);

																						$('.afdiscount').val(idf);
																					}
																				},
																			});


																		};
																	});
																</script>



																<table class="table table-striped table-hover table-condensed table-responsive" id="mytable">

																	<tbody>

																		<tr class="table_header">
																			<th class="bg-teal color-palette"></th>

																			<th style="width: 27%;" class="bg-teal color-palette">Reference No.</th>
																			<th class="text-left bg-teal color-palette">Paydate </th>



																			<th class="text-left bg-teal color-palette"> Amount </th>
																			<th class="text-left bg-teal color-palette"> Print </th>


																		</tr>

																		<script type="text/javascript">
																			$(function() {


																				window.checkcancel = function(sid) {



																					var ck = 'ref' + sid;

																					var chkbox = document.getElementById(ck);
																					var selec = $("#" + ck).attr('class');



																					if (chkbox.checked) {


																						$('.StuAttendCk').prop('checked', false);
																						$('#depositamt').prop('required', true);
																						$('#chkotherfee').prop('required', true);

																						$(".addgen").css("display", "none");
																						$(".addgen23").css("display", "block");


																					} else {




																					}

																					if ($('.StuAttendCkcancel:checked').length == 0) {
																						$('#chkotherfee').prop('required', false);

																						$(".addgen23").css("display", "none");
																					} else {

																						$('#chkotherfee').prop('required', true);
																						$(".addgen23").css("display", "block");
																					}



																				};
																			});
																		</script>

																		<?
																		if ($studentfeesk) {
																			$quass = array();
																			foreach ($studentfeesk as $valsf) {

																				$quass = unserialize($valsf['quarter']);




																				$rst = array();
																				foreach ($quass as $sj => $dt) {

																					$rst[] = $sj;
																				}




																		?>
																				<tr>

																					<td><label>
																							<?php /* ?><input  id="ref<?php echo $valsf['id']; ?>" onclick="checkcancel(<?php echo $valsf['id']; ?>)"  class="StuAttendCkcancel" name="amounth[]"  value="<?php echo $valsf['id']; ?>" type="checkbox"> 						
				<? */ ?>
																						</label></td>
																					<td><?php echo $valsf['recipetno'];
																						if (in_array("Bank Cancellation Charge", $rst)) {
																							echo "<strong  title='Bank Cancellation Charge' style='color:red;'>*</strong>";
																						}  ?></td>


																					<td>

																						<?php $dats = date('Y-m-d', strtotime($valsf['paydate']));
																						if ($dats != '1970-01-01') {
																							echo date('d-m-Y', strtotime($dats));
																						} else {
																							echo "not-set";
																						} ?>

																					</td>

																					<td>
																						<?= $this->Html->script('admin/confirmation.js') ?>
																						<span class="text-black">₹ </span><?php echo $valsf['deposite_amt']; ?>
																					</td>
																					<td>



																						<?
																						$quass = array();


																						if ($valsf['refrencepending'] == '0') {
																							$quass[] = unserialize($valsf['quarter']);





																							$quafs = array();

																							foreach ($quass as $h => $vales) {

																								$quafs = array_merge($quafs, $vales);
																							}
																							$rt = array();
																							$quas = array();
																							foreach ($quafs as $sjs => $ts) {

																								$quas[] = $sjs;
																							}
																						} else {
																							$quas = array();
																							$quas[] = $valsf['quarter'];
																						}

																						if (in_array("Caution Money", $quas)) {
																						?>


																							<a title="Print Caution Money" target="_blank" href="<? echo ADMIN_URL; ?>studentfees/printscaution/<?php echo $valsf['id']; ?>"><i class="fa fa-file-text-o"></i></a>
																							<a title="Cancel Receipt" onclick="return confirm('Are You Sure? Do You Want To Cancel Reference No : <?php echo $valsf['recipetno']; ?> !!')" href="<? echo ADMIN_URL; ?>studentfees/add/<?php echo $valsf['id']; ?>/<?php echo $academic_year; ?>"><i class="fa fa-remove"></i></a>

																						<? } else {  ?>
																							<a title="Print Receipt" target="_blank" href="<? echo ADMIN_URL; ?>studentfees/printsadmission/<?php echo $valsf['id']; ?>"><i class="fa fa-file-text-o"></i></a>
																							<a title="Cancel Receipt" onclick="return confirm('Are You Sure? Do You Want To Cancel Reference No : <?php echo $valsf['recipetno']; ?> !!')" href="<? echo ADMIN_URL; ?>studentfees/add/<?php echo $valsf['id']; ?>/<?php echo $academic_year; ?>"><i class="fa fa-remove"></i></a>


																						<? } ?>

																						<script>
																							// Uses 'tooltip-title' as title
																							$('a[tooltip]').tooltip({
																								title: function() {
																									return $(this).attr("tooltip-title");
																								}
																							});

																							// Uses 'confirm-title' attribute for title
																							$('a[confirmation]').confirmation({
																								title: function() {
																									return $(this).attr("confirm-title");
																								}
																							});
																						</script>

																					</td>









																				</tr>

																			<?  }
																		} else { ?>

																			<tr>


																				<td colspan="4" class="text-center">No Deposit Fees Yet</td>




																			</tr>
																		<? } ?>

																		</script>




																	</tbody>
																</table>
															</div>
															<div class="col-lg-6">

																<table class="table table-striped table-hover table-condensed table-responsive" id="mytable">

																	<tbody>

																		<tr class="table_header">

																			<th class="bg-teal color-palette" style=""></th>
																			<th style="width: 51%;" class="bg-teal color-palette">Description</th>
																			<th class="text-center bg-teal color-palette"> Due Fee </th>



																			<th class="text-right bg-teal color-palette"> Status </th>


																		</tr>

																		<?
																		$nk = "51";
																		if ($student_feepending) {
																			foreach ($student_feepending as $val) {  ?>
																				<tr>
																					<td style="width:4px;">



																						<label>

																							<input id="chk<? echo $nk; ?><?php if ($val['amt'] < 0) {
																																echo round($val['amt']);
																															} else {
																																echo round($val['amt']);
																															} ?>" class="StuAttendCkrg" name="amounts[]" <? if ($val['amt'] < 0) { ?>onclick="checkpending(<? echo $nk; ?>,<?php echo round($val['amt']); ?>,0)" <?  } else { ?> onclick="checkpending(<? echo $nk; ?>,<?php echo round($val['amt']); ?>,0)" <? } ?>value="<?php echo round($val['amt']); ?>" type="checkbox">
																						</label>
																					</td>

																					<td style="width:4px;">
																						<label>

																							<input name="student_id" value="<?php echo $val['s_id']; ?>" type="hidden">
																							<input name="refrencepending[]" value="<?php echo $val['r_id']; ?>" type="hidden">
																							<input name="hdfb" id="hdfbd" type="hidden" value="2">
																							<input name="pendid[]" value="<?php echo $val['id']; ?>" type="hidden">

																							Pending As Per Reference No <?php echo $val['recipetnos']; ?>

																						</label>
																					</td>


																					<td class="text-center">
																						<span class="text-black">₹ </span><?php echo round($val['amt']); ?>


																					</td>





																					<td class="text-right">Pending</td>




																				</tr>

																			<? $nk++;
																			}
																		} else { ?>

																			<tr>


																				<td colspan="4" class="text-center">No Pending Fees Yet</td>




																			</tr>
																		<? } ?>

																	</tbody>
																</table>


																<script type="text/javascript">
																	$(function() {


																		window.checkpending = function(sid, id, discount) {


																			var discount = $("#fees_discount").val();

																			var ck = 'chk' + sid + id;
																			var cks = 's' + sid + id;
																			var id1 = 'pd' + sid + id;
																			var chkbox = document.getElementById(ck);
																			var selec = $("#" + ck).attr('class');



																			if (chkbox.checked) {



																				$(".addgen").css("display", "block");

																				if (discount > 0) {
																					var idf = id;

																					idf = parseInt($('.tamount').text()) + parseInt(idf);
																					$('.tamount').text(idf);


																					var newamount = idf - discount;
																					$('.newamnt').text(newamount);


																					$('.newamnts').val(newamount);


																					$('.discnt').text(discount);
																					$('.afdiscount').val(newamount);

																				} else {


																					var idf = id;
																					idf = parseInt($('.tamount').text()) + parseInt(idf);
																					$('.tamount').text(idf);
																					var newamount = idf;
																					$('.newamnt').text(idf);
																					$('.newamnts').val(idf);

																					$('.afdiscount').val(idf);
																				}

																				document.getElementById(cks).disabled = false;


																			} else {




																				if ($('.news').length == $('.news:checked').length) {
																					$('.check-alls').prop('checked', true);

																				} else {
																					$('.check-alls').prop('checked', false);
																				}





																				if (discount > 0) {
																					var idf = parseInt($('.tamount').text()) - parseInt(id);

																					$('.tamount').text(idf);

																					var newamount = idf - discount;



																					$('.newamnt').text(newamount);
																					$('.newamnts').val(newamount);
																					//$('#fees_discount').val(discounts);
																					$('.afdiscount').val(newamount);
																					$('.discnt').text(discount);
																					if (newamount == '0') {
																						$('.discnt').text('0');

																					}

																					$('.afdiscount').val(newamount);
																				} else {


																					var idsf = parseInt($('.tamount').text()) - parseInt(id);
																					$('.tamount').text(idsf);
																					$('.newamnt').text(idsf);
																					$('.newamnts').val(idsf);
																					if (idsf == '0') {
																						$('.discnt').text('0');

																					}
																					$('.afdiscount').val(idsf);

																				}


																				document.getElementById(cks).disabled = true;
																				document.getElementById(id1).disabled = true;
																				document.getElementById(id1).required = false;
																			}

																			if ($('.news').length == $('.news:checked').length) {
																				$('.check-alls').prop('checked', true);

																			} else {
																				$('.check-alls').prop('checked', false);
																			}


																			if ($('.StuAttendCk').length == $('.StuAttendCk:checked').length) {
																				$('.check-all').prop('checked', true);

																			} else {
																				$('.check-all').prop('checked', false);
																			}
																		};
																	});
																</script>

																<table class="table table-striped table-hover table-condensed table-responsive" id="mytable">
																	<tbody>

																		<?php if (isset($classfee) && !empty($classfee)) {  ?>

																			<tr>
																				<td colspan="4" width="50%">


																					<? /* ?><script>
		$(function () {
        $("#chkdiscountcateg").change(function () {
			
			var vatika='<?php echo $students['class']['id']; ?>';
		    var category='<?php echo $students['category']; ?>';
		    var selectedText = $(this).find("option:selected").text();
            $('#discountcategorys').val(selectedText);
            var selectedValue = $(this).val();
            var toi=parseInt($('.tamount').text());
            var additionaldis=parseInt($('#additionaldis').val());
					 
						
            
            
            
            if(selectedValue!='100'){
				
				
				if(selectedValue > 0)
		{
	  
      var discounts= toi/100*selectedValue;
       var newamount=toi-discounts;
       if(additionaldis!='0' && newamount>=additionaldis){
		    var newamounts=parseInt(newamount)-parseInt(additionaldis);
		//$('.newamnt').text(newamount);
		$('.newamnt').text(newamount);
			var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
		$('#depositamt').val(newamounts);   
	   }else{
		$('.newamnt').text(newamount);
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);
	}
	
        $('.afdiscount').val(newamount);
			     $(".disfee").html(discounts);
                   var discounts= discounts.toFixed(2);
                 $(".discnt").html(discounts);
	}else{
		
					 $('.tamount').text(toi);
					 $('.newamnt').text(toi);
					var cat=parseInt($('#lfines').val())+parseInt(toi);
		$('.newamnts').val(cat);
					  $('.afdiscount').val(toi);
		     $(".disfee").html(0);
                
                 $(".discnt").html(0);
	}
				
			       $("#fees_discount").val(selectedValue);
         
           
				
				
				
				}else if(selectedValue=='100'){
	  
	  
	   $("#fees_discount").val('');
	   
	  $(".discnt").html("0");
	 alert("Not Applicable for RTE Discount!!"); 
	  
  }
          
        });
    });
										</script>
			<? */ ?>

																					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="quater[]" id="chkotherfee" onChange="chkotherfsees('chkotherfee');">
																						<option value="">- Add Other Fee -</option>
																						<?php foreach ($feesheadstotal as $ky => $item) { ?>
																							<option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>

																						<? } ?>

																					</select>
																				</td>
																				<td colspan="4" width="50%">
																					<b>Other Fee Charge : &nbsp; </b>
																					<input name="amount[]" readonly="readonly" id="otherfeeamts" value="0" placeholder="Enter Amount" type="number">
																				</td>
																			</tr>


																			<tr>

																				<td colspan="4" width="50%">




																					<label>Receipt No.</label>

																					<? if ($reciptnof) {  ?>
																						<input name="recipetno" value="<? echo $reciptnof; ?>" class="form-control" required="required" id="recipitno" maxlength="9" placeholder="Enter Receipt No. Here">
																					<? } else { ?>

																						<input name="recipetno" class="form-control" required="required" id="recipitno" maxlength="9" placeholder="Enter Receipt No. Here">

																					<? } ?>

																				</td>

																				<td colspan="6" id="formnos1" style="display:none;">




																					<label>Prospectus Form No.</label>



																					<input name="formno" class="form-control" id="formnos" maxlength="9" placeholder="Enter Prospectus Form No.">



																				</td>
																			</tr>
																			<tr>

																				<td colspan="6" width="50%">
																					<b style=" display:block;">Mode :</b> <span>&nbsp;&nbsp;&nbsp;&nbsp;<label class="radio-inline"><input type="radio" required id="radio1" name="mode" checked="checked" value="CASH" onclick="return checks(this);">Cash</label>

																						<label class="radio-inline"><input type="radio" name="mode" required id="radio2" onclick="return checks(this);" value="CHEQUE">Cheque</label>
																						<label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="DD" onclick="return checks(this);">Dd</label>


																						<label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="NETBANKING" onclick="return checks(this);">Netbanking</label>

																						<label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="Credit Card/Debit Card/UPI" onclick="return checks(this);">Credit Card/Debit Card/UPI</label>
																					</span>
																				</td>
																			</tr>
																			<tr>
																				<td colspan="4" width="50%">
																					<b>Discount : &nbsp; </b>

																					<script>
																						$(function() {
																							$("#chkdiscountcateg").change(function() {

																								$('#fees_discount').val(0);


																								var vatika = '<?php echo $students['class']['id']; ?>';
																								var category = '<?php echo $students['category']; ?>';




																								//$('.check-alls').prop('checked', false);


																								var selectedText = $(this).find("option:selected").text();

																								var setnumcnt = 0;

																								var toi = parseInt($('.tamount').text());
																								var additionaldis = parseInt($('#additionaldis').val());
																								$('#discountcategorys').val(selectedText);
																								var selectedValue = $(this).val();




																								if (selectedValue != '100') {


																									if (selectedValue > 0) {

																										var dasr = 0;
																										$('.StuAttendCk:checkbox:checked').each(function() {
																											var myselectedid = $(this).attr('id');
																											var vale = $(this).val();
																											var cleanUrl = myselectedid.replace(/^chk/, 'sp');
																											var ffheads = $('#' + cleanUrl).val();

																											$.ajax({
																												type: 'POST',
																												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
																												data: {
																													'ffheads': ffheads,
																													'sevalue': selectedValue,
																													'amty': vale
																												},
																												success: function(data) {
																													//alert(data);
																													if (data > 0) {
																														dasr++;
																														var toi = parseInt($('.tamount').text());
																														var additionaldis = parseInt($('#additionaldis').val());

																														// alert($('#fees_discount').val());
																														var fdiscou = parseFloat($('#fees_discount').val()) + parseFloat(data);

																														//alert(fdiscou);
																														$('#fees_discount').val(fdiscou);

																														var discounts = fdiscou;
																														var newamount = toi - discounts;


																														if (additionaldis != '0' && newamount >= additionaldis) {
																															var newamounts = parseInt(newamount) - parseInt(additionaldis);
																															//$('.newamnt').text(newamount);
																															$('.newamnt').text(newamount);
																															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
																															$('.newamnts').val(cat);
																															$('#depositamt').val(newamounts);
																														} else {
																															$('.newamnt').text(newamount);
																															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
																															$('.newamnts').val(cat);
																														}
																														$('.afdiscount').val(newamount);
																														$(".disfee").html(discounts);
																														var discounts = discounts;
																														$(".discnt").html(discounts);

																													} else {


																													}


																												},
																											});
																											//  alert(dasr);



																										});


																										if (dasr == 0) {

																											$('#fees_discount').val('0');
																											$(".discnt").html('0');
																											var newamount = toi;
																											$('.newamnt').text(toi);
																											var cat = parseInt($('#lfines').val()) + parseInt(toi);

																											$('.newamnts').val(cat);

																											$('.afdiscount').val(toi);

																										}
																										var opt = $('#chkotherfee').find("option:selected").val();


																										if (opt != '') {
																											var vale = $('#otherfeeamts').val();
																											var selectedValue = selectedValue;

																											var ffheads = opt;

																											$.ajax({
																												type: 'POST',
																												url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
																												data: {
																													'ffheads': ffheads,
																													'sevalue': selectedValue,
																													'amty': vale
																												},
																												success: function(data) {


																													if (data > 0) {

																														var toi = parseInt($('.tamount').text());
																														var additionaldis = parseInt($('#additionaldis').val());

																														// alert($('#fees_discount').val());
																														var fdiscou = parseFloat(data);

																														//alert(fdiscou);
																														$('#fees_discount').val(fdiscou);

																														var discounts = fdiscou;
																														var newamount = toi - discounts;


																														if (additionaldis != '0' && newamount >= additionaldis) {
																															var newamounts = parseInt(newamount) - parseInt(additionaldis);
																															//$('.newamnt').text(newamount);
																															$('.newamnt').text(newamount);
																															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
																															$('.newamnts').val(cat);
																															$('#depositamt').val(newamounts);
																														} else {
																															$('.newamnt').text(newamount);
																															var cat = parseInt($('#lfines').val()) + parseInt(newamount);
																															$('.newamnts').val(cat);
																														}
																														$('.afdiscount').val(newamount);
																														$(".disfee").html(discounts);
																														var discounts = discounts;
																														$(".discnt").html(discounts);

																													} else {


																														/*  $('#fees_discount').val('0');
	       $(".discnt").html('0');
		var newamount=idf;
		$('.newamnt').text(idf);
		var cat=parseInt($('#lfines').val())+parseInt(idf);
	
		$('.newamnts').val(cat);

		$('.afdiscount').val(idf); */


																													}


																												},
																											});



																										} else {



																										}








																									} else {

																										$('.tamount').text(toi);
																										$('.newamnt').text(toi);
																										var cat = parseInt($('#lfines').val()) + parseInt(toi);
																										$('.newamnts').val(cat);
																										$('.afdiscount').val(toi);
																										$(".disfee").html(0);

																										$(".discnt").html(0);
																									}

																									//  $("#fees_discount").val(selectedValue);





																								} else if (selectedValue == '100') {


																									$("#fees_discount").val('');

																									$(".discnt").html("0");
																									alert("Not Applicable for RTE Discount!!");

																								}

																							});
																						});
																					</script>


																					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="discountcategory" required="required" id="chkdiscountcateg">
																						<option value="0">-Discount-</option>
																						<?php foreach ($discountCategorylist as $ky => $item) { ?>
																							<option value="<?php echo $item['id']; ?>" <?php if ($item['id'] == $students['discountcategory']) { ?> selected="selected" <? } ?>><?php echo $item['name']; ?></option>

																						<? } ?>

																					</select>
																				</td>

																				<td colspan="4" width="50%">
																					<b>Paydate : &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;
																						&nbsp; &nbsp;</b>


																					<? if ($paydatef) { ?>

																						<input type="text" style="max-width: 
									 126px;" class="abs_remark 
									 stuattendance-sa_date " readonly="readonly" name="paydate" maxlength="50" placeholder="Enter Paydate" value="<? echo $paydatef; ?>" required="">


																					<? } else { ?><input type="text" style="max-width: 
									 126px;" class="abs_remark 
									 stuattendance-sa_date " readonly="readonly" name="paydate" maxlength="50" placeholder="Enter Paydate" value="<? echo date('d-m-Y'); ?>" required="">

																					<? } ?>
																				</td>

																			</tr>
																			<tr>
																				<td colspan="4" width="50%">
																					<style>
																						input[type='number'] {
																							-moz-appearance: textfield;
																						}

																						/* Webkit browsers like Safari and Chrome */
																						input[type=number]::-webkit-inner-spin-button,
																						input[type=number]::-webkit-outer-spin-button {
																							-webkit-appearance: none;
																							margin: 0;
																						}
																					</style>
																					<b>Total Amount : &nbsp;</b> <span class="text-black">&#8377; </span><span class="tamount">0</span>
																					<input type="hidden" value="<?php echo $discount_fees; ?>" name="discount" id="fees_discount">
																					<input type="hidden" value="<?php echo $students['discountcategory']; ?>" name="discountcategorys" id="discountcategorys">
																				</td>
																				<td colspan="4" width="50%">
																					<b>(+)Late Fee :</b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;
																					<span class="text-black">&#8377; </span>

																					<input name="lfine" style="max-width: 40%;" id="lfines" value="0" type="number">

																				</td>
																			</tr>

																			<tr>
																				<td colspan="4" width="50%">

																					<b>(-)Discount : </b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;<span class="text-black">&#8377; </span> <span class="discnt"><? if ($discount_fees) {
																																																				echo $discount_fees; ?> <? } else { ?> 0 <? }
																						?></span>
																				</td>

																				<td colspan="4">
																					<b>(-)Add. Discount :&nbsp; </b>
																					<input type="number" placeholder="Additional Discount" min="0" id="additionaldis" name="addtionaldiscount" maxlength="10">
																				</td>


																			</tr>




																			<tr>

																				<td colspan="4">
																					<b>Net Amount : &nbsp;&nbsp;&nbsp;&nbsp;</b> <span class="text-black">&#8377; </span><span class="newamnt">0</span>
																					<input type="hidden" value="0" name="fee" class="afdiscount">
																					<input type="hidden" value="<?php echo $academic_year; ?>" name="acedmicyear" class="acedmicyear">
																					<input name="payer" type="hidden" value="" required>
																				</td>

																				<td colspan="4">

																					<b>Deposit Amount :&nbsp; </b> <input name="deposite_amt" class="newamnts" id="depositamt" placeholder="Deposit Amount" type="number">


																				</td>
																			</tr>



																			<script>
																				$(function() {

																					$("#depositamt").on('blur change', function() {




																					});
																				});
																			</script>
																			<script>
																				var myInput = document.querySelectorAll("input[type=number]");

																				function keyAllowed(key) {
																					var keys = [8, 9, 13, 16, 17, 18, 19, 20, 27, 46, 48, 49, 50,
																						51, 52, 53, 54, 55, 56, 57, 91, 92, 93
																					];
																					if (key && keys.indexOf(key) === -1)
																						return false;
																					else
																						return true;
																				}

																				myInput.forEach(function(element) {
																					element.addEventListener('keypress', function(e) {
																						var key = !isNaN(e.charCode) ? e.charCode : e.keyCode;
																						if (!keyAllowed(key))
																							e.preventDefault();
																					}, false);

																					// Disable pasting of non-numbers
																					element.addEventListener('paste', function(e) {
																						var pasteData = e.clipboardData.getData('text/plain');
																						if (pasteData.match(/[^0-9]/))
																							e.preventDefault();
																					}, false);
																				});
																				$(function() {

																					$(".StuAttendCk").on('change', function() {
																						$('#additionaldis').val('0');


																					});
																					$(".news").change(function() {
																						$('#additionaldis').val('0');


																					});


																					$("#lfines").on('blur', function() {

																						if ($('.newamnt').text() != '') {
																							var totl = parseFloat($('#lfines').val()) + parseFloat($('.newamnt').text());

																							$('#depositamt').val(totl);

																						}
																					});
																					$("#otherfeeamts").on('change', function() {

																						var opt = $("#chkotherfee option:selected").val();



																						var boardst = '<? echo $students['board_id']; ?>';


																						$.ajax({
																							type: 'POST',
																							url: '<?php echo ADMIN_URL; ?>Studentfees/findotherfees',
																							data: {
																								'opt': opt,
																								'boardst': boardst
																							},
																							success: function(data) {


																								var discount = $("#chkdiscountcateg option:selected").val();

																								if (discount > 0) {
																									$('.tamount').text('0');
																									if ($('#otherfeeamts').val() != '0') {

																										var idf = parseInt($('#otherfeeamts').val());

																									} else {

																										var idf = parseInt($('#otherfeeamts').val());
																									}

																									var sum = 0;
																									$('input:checkbox[name="amount[]"]:checked').each(function() {
																										sum += parseFloat($(this).val());
																									});

																									var sums = 0;
																									$('input:checkbox[name="amounts[]"]:checked').each(function() {
																										sums += parseFloat($(this).val());
																									});


																									var idf = parseInt(sum) + parseInt(idf) + parseInt(sums);

																									//$('#otherfeeamts').val(data);

																									$('.tamount').text(idf);





																									var opt = $('#chkotherfee').find("option:selected").val();


																									if (opt != '') {
																										var vale = $('#otherfeeamts').val();
																										var selectedValue = discount;

																										var ffheads = opt;

																										$.ajax({
																											type: 'POST',
																											url: '<?php echo ADMIN_URL; ?>Studentfees/finddiscount',
																											data: {
																												'ffheads': ffheads,
																												'sevalue': selectedValue,
																												'amty': vale
																											},
																											success: function(data) {


																												if (data > 0) {

																													var toi = parseInt($('.tamount').text());
																													var additionaldis = parseInt($('#additionaldis').val());

																													// alert($('#fees_discount').val());
																													var fdiscou = parseFloat(data);

																													//alert(fdiscou);
																													$('#fees_discount').val(fdiscou);

																													var discounts = fdiscou;
																													var newamount = toi - discounts;


																													if (additionaldis != '0' && newamount >= additionaldis) {
																														var newamounts = parseInt(newamount) - parseInt(additionaldis);
																														//$('.newamnt').text(newamount);
																														$('.newamnt').text(newamount);
																														var cat = parseInt($('#lfines').val()) + parseInt(newamount);
																														$('.newamnts').val(cat);
																														$('#depositamt').val(newamounts);
																													} else {
																														$('.newamnt').text(newamount);
																														var cat = parseInt($('#lfines').val()) + parseInt(newamount);
																														$('.newamnts').val(cat);
																													}
																													$('.afdiscount').val(newamount);
																													$(".disfee").html(discounts);
																													var discounts = discounts;
																													$(".discnt").html(discounts);

																												} else {


																													/*  $('#fees_discount').val('0');
	       $(".discnt").html('0');
		var newamount=idf;
		$('.newamnt').text(idf);
		var cat=parseInt($('#lfines').val())+parseInt(idf);
	
		$('.newamnts').val(cat);

		$('.afdiscount').val(idf); */


																												}


																											},
																										});



																									}
																									/* var discounts= idf/100*discount;
var discounts= discounts.toFixed(2);
		
		var newamount=idf-discounts;
		$('.newamnt').text(newamount);
		
		var cat=parseInt($('#lfines').val())+parseInt(newamount);
		$('.newamnts').val(cat);

  

$('.discnt').text(discounts);
				$('.afdiscount').val(newamount); */

																								} else {
																									$('.tamount').text('0');

																									//var idf=data;
																									if ($('#otherfeeamts').val() != '0') {

																										var idf = parseInt($('#otherfeeamts').val());

																									} else {

																										var idf = parseInt($('#otherfeeamts').val());
																									}
																									//$('#otherfeeamts').val(data);
																									var sum = 0;
																									$('input:checkbox[name="amount[]"]:checked').each(function() {
																										sum += parseFloat($(this).val());
																									});

																									var sums = 0;
																									$('input:checkbox[name="amounts[]"]:checked').each(function() {
																										sums += parseFloat($(this).val());
																									});


																									var idf = parseInt(sum) + parseInt(idf) + parseInt(sums);
																									$('.tamount').text(idf);
																									var newamount = idf;
																									$('.newamnt').text(idf);
																									var cat = parseInt($('#lfines').val()) + parseInt(idf);

																									$('.newamnts').val(cat);

																									$('.afdiscount').val(idf);
																								}
																							},
																						});




																						var depositamt = parseInt($('#depositamt').val());

																						var additionalamt = parseInt($('#additionaldis').val());

																						if (depositamt >= additionalamt) {
																							var remain = parseInt(depositamt) - parseInt(additionalamt);
																							$('#depositamt').val(remain);
																						}
																					});
																					$("#additionaldis").on('change', function() {
																						var depositamt = parseInt($('#depositamt').val());

																						var additionalamt = parseInt($('#additionaldis').val());

																						if (depositamt >= additionalamt) {
																							var remain = parseInt(depositamt) - parseInt(additionalamt);
																							$('#depositamt').val(remain);
																						}
																					});


																				});
																			</script>

																			<tr>




																				<td colspan="4" id="che" style="display:none;">
																					<b>Cheque/Dd :&nbsp; </b>
																					<input type="text" placeholder="Cheque/Dd Number" style="max-width: 162px;" id="chequno" onclick="checks(1)" name="cheque_no">

																				</td>
																				<td colspan="4" id="bnk" style="display:none;">
																					<b>Bank Name :&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
																					<input name="bank_id" style="max-width: 141px;" id="bank" placeholder="Enter Name" type="text">


																				</td>
																				<td colspan="4" id="ref" style="display:none;">
																					<b>Reference No. :&nbsp; </b>
																					<input type="text" id="refno" style="max-width: 152px;" onclick="" placeholder="Reference Number" name="ref_no" maxlength="25">
																				</td>
																			</tr>
																		<?php  }  ?>



																		<tr>
																			<? if (($studentfeesk || $students['discountcategory']) && $studentfees[0]['discountcategory'] != '') { ?>
																				<td colspan="4" width="50%">
																					<b>Discount Taken :</b> <? if ($studentfees[0]['discountcategory']) {
																												echo " " . $studentfees[0]['discountcategory'];
																											} elseif ($students['discountcategory']) {
																												echo " " . $students['discountcategory'];
																											} ?>

																				</td>
																			<? } ?>
																			<td colspan="4" id="bnkcancellation" style="display:none;">
																				<b>Cancellation Charge :</b>
																				<input name="cancelid" id="cancelid" id='0' type="hidden">
																				<input name="bank_charge" style="max-width: 123px;" id="bankcharged" placeholder="Charge" type="number" maxlength='10'>



																			</td>

																		</tr>
																		<tr>
																			<td colspan="8">



																				<label>Remarks</label>
																				<textarea name="remarks" class="form-control rounded-0" id="exampleFormControlTextarea2" placeholder="Enter Remarks Here" rows="3"></textarea>

																				<input type="hidden" name="student_id" value="<?php echo $students['id']; ?>">


																			</td>
																		</tr>





																	</tbody>




																</table>

															</div>
														</div>
														<div class="box-footer">

															<?php
															if (isset($classes['id'])) {
																echo $this->Form->submit(
																	'Take Fee',
																	array('class' => 'btn btn-info pull-right', 'title' => 'Update')
																);
															} else {
																echo $this->Form->submit(
																	'Take Fee',
																	array('class' => 'btn btn-info pull-right addgen', 'title' => 'Take Fee', 'style' => 'display:none;')
																);
																echo $this->Form->submit(
																	'Cancel Recipiet',
																	array('class' => 'btn btn-info pull-right addgen23', 'title' => 'Cancel Recipiet', 'style' => 'display:none;')
																);
															}
															?>
															<?php
															echo $this->Html->link('Back', [
																'action' => 'view'

															], ['class' => 'btn btn-default']); ?>

														</div>
														<?php echo $this->Form->end(); ?>

													<? } else { ?>
														<table class="table table-striped table-hover" id="mytable">

															<tbody>

																<tr class="table_header">
																	<th style="text-align:center;"> No Fees Structure for RTE Student!!</th>
																</tr>
															</tbody>
														</table>
													<? } ?>


											</div>
											<?php if ($is_transport == '1') { ?>
												<div class="tab-pane" id="academic">
													<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_form" validate="validate" action="<?php echo ADMIN_URL; ?>studentfees/addtransport">
														<h3 class="page-header edusec-border-bottom-primary">
															<i class="fa fa-info-circle"></i> Transport Fee Structure
														</h3>


														<div class="row">
															<div class="col-lg-12">
																<table class="table table-striped table-hover" id="mytable">

																	<tbody>

																		<tr class="table_header">
																			<th class="text-left bg-teal color-palette" style=""><input type="checkbox" class="check-all"></th>

																			<th class="text-left bg-teal color-palette"> Quater </th>
																			<th class="text-left bg-teal color-palette"> Last submission </th>
																			<th class="text-left bg-teal color-palette"> Fee </th>
																			<?php if ($dis_transport >= 0) { ?>
																				<th class="text-left bg-teal color-palette"> Discount </th>
																				<th class="text-left bg-teal color-palette"> Net Amount </th>
																			<?php } ?>
																			<th class="text-left bg-teal color-palette"> Paydate </th>
																			<th class="text-left bg-teal color-palette"> Challan No. </th>
																			<th class="text-left bg-teal color-palette"> Payment Mode </th>
																			<th class="text-left bg-teal color-palette"> Receipt </th>

																		</tr>


																		<?php $def = 0;
																		foreach ($studenttransfee as $values) {
																			$quatrans[] = $values['quarter'];
																		}
																		if (isset($transportfeess) && !empty($transportfeess)) {
																			for ($i = 1; $i < 5; $i++) {    ?>
																				<tr>
																					<td style="
    width: 4px;
">



																						<label><input type="hidden" name="student_id" value="<?php echo $id; ?>">
																							<?php if (!in_array("Quater" . $i, $quatrans)) {
																								if ($transportfeess[0]['qu' . $i . '_fees'] != 0) {
																									$def = 1;
																									$datd = date('Y-m-d', strtotime($transportfeess[0]['qu' . $i . '_date']));
																									if ($datd != '1970-01-01') {   ?>
																										<input type="radio" id="chk1<?php echo $i; ?><?php echo $transportfeess[0]['qu' . $i . '_fees']; ?>" class="StuAttendCk" name="amount[]" value="<?php echo $transportfeess[0]['qu' . $i . '_fees']; ?>" onclick="check1(<?php echo $i; ?>,<?php echo $transportfeess[0]['qu' . $i . '_fees']; ?>,<?php echo $dis_transport; ?>)"><?php }
																																																																																																						}
																																																																																																					} else { ?><input type="checkbox" class="StuAttendCk" checked="checked" readonly disabled><?php }  ?> </label>
																					</td>
																					<td> <?php $rg = $this->Comman->findclassfee($academic_class, $academic_year); ?>
																						<input type="text" style="background-color: transparent;border: none;" name="quater[]" id="s<?php echo $i; ?><?php echo $transportfeess[0]['qu' . $i . '_fees']; ?>" value="Quater<?php echo $i; ?>" readonly disabled="">
																					</td>
																					<td><?php $datd = date('Y-m-d', strtotime($transportfeess[0]['qu' . $i . '_date']));
																						if ($datd != '1970-01-01') {
																							echo  date('d-m-Y', strtotime($datd));
																						} else {
																							echo "not-set";
																						} ?></td>
																					<td><span class="text-black">&#8377; </span><?php $datd = date('Y-m-d', strtotime($transportfeess[0]['qu' . $i . '_date']));
																																if ($datd != '1970-01-01') {
																																	echo number_format($transportfeess[0]['qu' . $i . '_fees']);
																																} else {
																																	echo "not-set";
																																}  ?></td>


																					<?php if (!in_array("Quater" . $i, $quatrans)) {
																						if ($dis_transport > 0) {

																					?>
																							<td><?php echo $dis_transport; ?>%</td>
																							<td><span class="text-black">&#8377; </span><?php $netamount = $transportfeess[0]['qu' . $i . '_fees'] / 100 * $dis_transport;
																																		$remain = $transportfeess[0]['qu' . $i . '_fees'] - $netamount;
																																		echo number_format($remain); ?></td>
																						<?php } else { ?>

																							<td>0%</td>
																							<td><span class="text-black">&#8377; </span><?php echo number_format($transportfeess[0]['qu' . $i . '_fees']);  ?></td>

																						<?php }
																					} else {

																						$paydatevalues = $this->Comman->findtransportfeesallocation("Quater" . $i, $id);
																						if ($paydatevalues['discount']) { ?>
																							<td><?php echo $paydatevalues['discount']; ?>%</td>
																							<td><span class="text-black">&#8377; </span><?php echo number_format($paydatevalues['fee']);  ?></td>


																						<?php	 } else { ?>

																							<td>0%</td>
																							<td><span class="text-black">&#8377; </span><?php echo number_format($transportfeess[0]['qu' . $i . '_fees']);  ?></td>

																					<?php 	}
																					} ?>







																					<td>
																						<div class="form-group field-1">
																							<div class="col-lg-6">
																								<?php if (!in_array("Quater" . $i, $quatrans)) { ?>
																									<input type="text" id="pd<?php echo $i; ?><?php echo $transportfeess[0]['qu' . $i . '_fees']; ?>" class="abs_remark form-control stuattendance-sa_date1" name="paydate[]" disabled="" maxlength="50" style="height:30px !important; width: 115px;" placeholder="Enter Paydate">
																								<?php } else {
																									$paydatevalues = $this->Comman->findtransportfeesallocation("Quater" . $i, $id);  ?>

																									<input type="text" style="
    background-color: transparent;
    border: none; height:30px !important; width: 115px;
" id="pd<?php echo $i; ?><?php echo $transportfeess[0]['qu' . $i . '_fees']; ?>" class="abs_remark form-control " value="<?php echo date('d-m-Y', strtotime($paydatevalues['paydate'])); ?>" name="paydate[]" disabled="" maxlength="50" placeholder="Enter Paydate">


																								<?php } ?>



																							</div>
																						</div>
																					</td>
																					<td>
																						<div class="form-group field-1">
																							<div class="col-lg-6">
																								<?php if (!in_array("Quater" . $i, $quatrans)) {  ?>
																									-<?php } else {
																										$paydatevalues = $this->Comman->findtransportfeesallocation("Quater" . $i, $id);
																										echo $paydatevalues['challan_no'];
																									} ?></div>
																						</div>
																					</td>

																					<td>
																						<div class="form-group field-1">
																							<div class="col-lg-6">
																								<?php if (!in_array("Quater" . $i, $quatrans)) {  ?>
																									-<?php } else {
																										$paydatevalues = $this->Comman->findtransportfeesallocation("Quater" . $i, $id);
																										//  pr($paydatevalues);
																										if ($paydatevalues['mode'] == "Cash") {
																											echo $paydatevalues['mode'];
																										}
																										?> <?php if ($paydatevalues['mode'] == "Cheque") {
																											echo $paydatevalues['mode']; ?></br>No. (<?php echo $paydatevalues['cheque_no'];  ?>) <?php }
																																		} ?></div>
																						</div>
																					</td>

																					<td>
																						<div class="form-group field-1">
																							<div class="col-lg-6">
																								<?php if (!in_array("Quater" . $i, $quatrans)) {  ?>
																									-<?php } else {  ?> <a title="Print Receipt" href="<?php echo SITE_URL; ?>admin/studentfees/printstransport/<?php echo $students['id']; ?>/<?php echo "Quater" . $i; ?>/<?php echo $students['acedmicyear']; ?>"><i class="fa fa-file-text-o"></i></a><?php
																																																																																					} ?></div>
																						</div>
																					</td>

																				</tr>
																			<?php } ?> <?php if ($def == '1') { ?>
																				<tr>
																					<td colspan="4">
																						<b>Discount = </b> <span class="discnt1">0</span>
																					</td>
																				</tr>
																				<tr>
																					<td colspan="4">
																						<b>Total Amount = </b> <span class="text-black">&#8377; </span><span class="tamount1">0</span>
																						<input type="hidden" value="<?php echo $dis_transport; ?>" name="discount" id="#fees_discount1">
																					</td>
																				</tr>

																				<tr>
																					<td colspan="4">
																						<b>Net Amount = </b><span class="text-black">&#8377; </span> <span class="newamnt1">0</span>
																						<input type="hidden" value="" name="fee" class="afdiscount1"> <input type="hidden" value="<?php echo $academic_year; ?>" name="acedmicyear" class="acedmicyear">
																					</td>
																				</tr>
																				<tr>
																					<td colspan="4"><b>Mode: </b> <span><label class="radio-inline"><input type="radio" required id="radio1" name="modes" value="Cash" onclick="return checks1(this);">Cash</label><label class="radio-inline"><input type="radio" name="modes" required id="radio2" onclick="return checks1(this);" value="Cheque">Cheque</label></span></td>
																				</tr>
																				<?php if (!isset($Sitesettings) && empty($Sitesettings)) { ?>
																					<tr>
																						<td><b>Challan No.</b><input type="text" name="challan_no" required></td>
																					</tr>
																				<?php } ?>

																				<tr id="che1">
																					<td><b>Cheque No.</b><input type="text" id="chequno1" name="cheque_no" maxlength="7"></td>
																				</tr>
																				<?php if (!isset($Sitesettings) && empty($Sitesettings)) { ?>
																					<tr id="bnk1">
																						<td><b>Bank</b><?php echo $this->Form->input('bank_id', array('class' => 'form-control', 'id' => 'bank1', 'type' => 'select', 'empty' => 'Select Bank', 'required' => 'required', 'options' => $banks, 'label' => false)); ?></td> <?php } ?>
																					</tr><?php }
																					} ?>

																	</tbody>
																</table>
															</div>
														</div>
														<div class="box-footer">

															<?php if ($def == '1') {
																if (isset($classes['id'])) {
																	echo $this->Form->submit(
																		'Take Fee',
																		array('class' => 'btn btn-info pull-right', 'title' => 'Update')
																	);
																} else {
																	echo $this->Form->submit(
																		'Take Fee',
																		array('class' => 'btn btn-info pull-right', 'title' => 'Add')
																	);
																}
															}
															?>
															<?php
															echo $this->Html->link('Back', [
																'action' => 'view'

															], ['class' => 'btn btn-default']); ?>

														</div>
														<?php echo $this->Form->end(); ?>
												</div>

											<?php } ?>


											<?php if (!empty($students['due_fees']) && isset($students['due_fees'])) { ?>
												<div class="tab-pane" id="pduefee">
													<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_form" validate="validate" action="<?php echo ADMIN_URL; ?>studentfees/previousduefees">
														<h3 class="page-header edusec-border-bottom-primary">
															<i class="fa fa-info-circle"></i> Due Fee Structure
														</h3>


														<div class="row">
															<div class="col-lg-12">
																<table class="table table-striped table-hover" id="mytable">

																	<tbody>

																		<tr class="table_header">
																			<th class="text-left bg-teal color-palette" style=""></th>


																			<th class="text-left bg-teal color-palette"> Due Fee </th>
																			<th class="text-left bg-teal color-palette"> Paydate </th>
																			<th class="text-left bg-teal color-palette"> Challan No. </th>
																			<th class="text-left bg-teal color-palette"> Payment Mode </th>
																			<th class="text-left bg-teal color-palette"> Receipt </th>

																		</tr>

																		<tr>
																			<td> <?php $due = $this->Comman->findstuduefees($students['id']); ?>
																				<label><input type="hidden" name="student_id" value="<?php echo $id; ?>">
																					<label><input type="hidden" name="acedmicyear" value="<?php echo $students['acedmicyear']; ?>">
																						<?php if (!empty($personalduefees['student_id']) && isset($personalduefees['student_id'])) { ?>
																							<input type="radio" id="chk12" class="StuAttendCk" name="due_fees" value="<?php echo $due['due_fees']; ?>" checked>
																						<?php } else { ?>
																							<input type="radio" id="chk12" class="StuAttendCk" name="due_fees" value="<?php echo $due[0]['due_fees']; ?>" required>
																						<?php } ?>
																					</label>
																			</td>
																			<td><?php
																				echo $due[0]['due_fees'];
																				?>
																			</td>

																			<td>
																				<?php if (!empty($personalduefees['student_id']) && isset($personalduefees['student_id'])) { ?>
																					<input type="text" id="pd12" class="abs_remark form-control stuattendance-sa_date2" name="paydate" value="<?php echo $personalduefees['paydate']; ?>" required placeholder="Enter Paydate" disabled>
																				<?php } else { ?>
																					<input type="text" id="pd12" class="abs_remark form-control stuattendance-sa_date2" name="paydate" required placeholder="Enter Paydate">
																				<?php } ?>
																			</td>
																			<?php if (!empty($personalduefees['student_id']) && isset($personalduefees['student_id'])) { ?>
																				<td><?php echo $personalduefees['challan_no']; ?></td>
																				<td><?php echo $personalduefees['mode']; ?></td>
																			<?php } ?>
																			<td></td>
																		</tr>
																		<?php if (empty($personalduefees['student_id']) && !isset($personalduefees['student_id'])) { ?>
																			<tr>
																				<td><b>Mode: </b> <span><label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="Cash" onclick="return checks123(this);">Cash</label><label class="radio-inline"><input type="radio" name="mode" required id="radio2" onclick="return checks123(this);" value="Cheque">Cheque</label></span></td>
																			</tr>
																			<tr>
																				<td><b>Challan No.</b><input type="text" name="challan_no" required></td>
																			</tr>
																			<tr id="che123">
																				<td><b>Cheque No.</b><input type="text" id="chequno12" name="cheque_no" maxlength="7"></td>
																			</tr>
																			<tr id="bnk12">
																				<td><b>Bank</b><?php echo $this->Form->input('bank_id', array('class' => 'form-control', 'id' => 'bank12', 'type' => 'select', 'empty' => 'Select Bank', 'required' => 'required', 'options' => $banks, 'label' => false)); ?></td>
																			</tr>
																		<?php }
																		?>
																	</tbody>
																</table>
																<div class="submit"><input type="submit" class="btn btn-info pull-right addgen" title="Add" style="display: block;" value="Take Fee"></div>


																<?php echo $this->Form->end(); ?>
															<?php } elseif (!empty($personalduefees['student_id']) && isset($personalduefees['student_id'])) {  ?>

																<div class="tab-pane" id="pduefee">
																	<form method="post" enctype="multipart/form-data" accept-charset="utf-8" class="form-horizontal" id="sevice_form" validate="validate" action="<?php echo ADMIN_URL; ?>studentfees/previousduefees">
																		<h3 class="page-header edusec-border-bottom-primary">
																			<i class="fa fa-info-circle"></i> Due Fee Structure
																		</h3>


																		<div class="row">
																			<div class="col-lg-12">
																				<table class="table table-striped table-hover" id="mytable">

																					<tbody>

																						<tr class="table_header">
																							<th class="text-left bg-teal color-palette" style=""></th>


																							<th class="text-left bg-teal color-palette"> Due Fee </th>
																							<th class="text-left bg-teal color-palette"> Paydate </th>
																							<th class="text-left bg-teal color-palette"> Challan No. </th>
																							<th class="text-left bg-teal color-palette"> Payment Mode </th>
																							<th class="text-left bg-teal color-palette"> Receipt </th>

																						</tr>

																						<tr>
																							<td> <?php $due = $this->Comman->findstuduefees($students['id']); ?>
																								<label><input type="hidden" name="student_id" value="<?php echo $id; ?>">
																									<label><input type="hidden" name="acedmicyear" value="<?php echo $students['acedmicyear']; ?>">
																										<?php if (!empty($personalduefees['student_id']) && isset($personalduefees['student_id'])) { ?>
																											<input type="radio" id="chk12" class="StuAttendCk" name="due_fees" value="<?php echo $personalduefees['due_fees']; ?>" checked>
																										<?php } else { ?>
																											<input type="radio" id="chk12" class="StuAttendCk" name="due_fees" value="<?php echo $due[0]['due_fees']; ?>" required>
																										<?php } ?>
																									</label>
																							</td>
																							<td><?php
																								echo $personalduefees['due_fees']; ?>
																							</td>

																							<td>
																								<?php if (!empty($personalduefees['student_id']) && isset($personalduefees['student_id'])) { ?>
																									<input type="text" id="pd12" class="abs_remark form-control stuattendance-sa_date2" name="paydate" value="<?php echo $personalduefees['paydate']; ?>" required placeholder="Enter Paydate" disabled>
																								<?php } else { ?>
																									<input type="text" id="pd12" class="abs_remark form-control stuattendance-sa_date2" name="paydate" required placeholder="Enter Paydate">
																								<?php } ?>
																							</td>
																							<?php if (!empty($personalduefees['student_id']) && isset($personalduefees['student_id'])) { ?>
																								<td><?php echo $personalduefees['challan_no']; ?></td>
																								<td><?php echo $personalduefees['mode']; ?></td>
																								<td><a title="Print Receipt" href="<?php echo SITE_URL; ?>admin/studentfees/dueprints/<?php echo $personalduefees['student_id']; ?>"><i class="fa fa-file-text-o"></i></a></td>
																							<?php } ?>
																						</tr>
																						<?php if (empty($personalduefees['student_id']) && !isset($personalduefees['student_id'])) { ?>
																							<tr>
																								<td><b>Mode: </b> <span><label class="radio-inline"><input type="radio" required id="radio1" name="mode" value="Cash" onclick="return checks123(this);">Cash</label><label class="radio-inline"><input type="radio" name="mode" required id="radio2" onclick="return checks123(this);" value="Cheque">Cheque</label></span></td>
																							</tr>
																							<tr>
																								<td><b>Challan No.</b><input type="text" name="challan_no" required></td>
																							</tr>
																							<tr id="che123">
																								<td><b>Cheque No.</b><input type="text" id="chequno12" name="cheque_no" maxlength="7"></td>
																							</tr>
																							<tr id="bnk12">
																								<td><b>Bank</b><?php echo $this->Form->input('bank_id', array('class' => 'form-control', 'id' => 'bank12', 'type' => 'select', 'empty' => 'Select Bank', 'required' => 'required', 'options' => $banks, 'label' => false)); ?></td>
																							</tr>



																					</tbody>
																				</table>
																				<div class="submit"><input type="submit" class="btn btn-info pull-right addgen" title="Add" style="display: block;" value="Take Fee"></div>

																			<?php }  ?>

																			<?php echo $this->Form->end(); ?>

																		<?php 	} ?>
																			</div>





							</section>

							<div class="modal" id="globalModal" tabindex="-1" role="dialog" aria-labelledby="esModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-body">
											<div class="loader">
												<div class="es-spinner">
													<i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>



						</div>
						<!-- /.box-body -->

						<!-- /.box-footer -->

					</div>

				</div>
				<!--/.col (right) -->
			</div>
			<!-- /.row -->
	</section>
	<!-- /.content -->
</div>