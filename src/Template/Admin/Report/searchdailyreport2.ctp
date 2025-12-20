<div class="table-responsive">
	<div class="d-flex justify-content-end mb-3 pr-3" style="justify-content: end; padding-left:20px;">
		<a class="btn btn-success" href="<?php echo ADMIN_URL; ?>report/exportmonthlyexcel?month=<?php echo urlencode($selected_month); ?>">
			📥 Export to Excel
		</a>
	</div>


	<?php
	$start_date = date('Y-m-01', strtotime($selected_month));
	$end_date = date('Y-m-t', strtotime($selected_month));

	$fee_data = [];
	$daily_totals = [];
	$mode_totals = array_fill_keys($mode, 0);
	$overall_total = 0;

	$period = new DatePeriod(
		new DateTime($start_date),
		new DateInterval('P1D'),
		(new DateTime($end_date))->modify('+1 day')
	);

	foreach ($period as $date) {
		$day = $date->format('Y-m-d');
		$fee_data[$day] = array_fill_keys($mode, 0);
		$daily_totals[$day] = 0;
	}

	// pr($allFees);exit;

	foreach ($allFees as $fee) {
		if (!$fee->paydate || !$fee->mode || !$fee->deposite_amt) continue;

		$date = $fee->paydate->format('Y-m-d');
		$payment_mode = trim($fee->mode);
		$amount = (float)$fee->deposite_amt;

		if (!in_array($payment_mode, $mode)) continue;

		$fee_data[$date][$payment_mode] += $amount;
		$daily_totals[$date] += $amount;
		$mode_totals[$payment_mode] += $amount;
		$overall_total += $amount;
	}

	function formatAmt($value)
	{
		return fmod($value, 1) ? number_format($value, 2) : number_format($value, 0);
	}

	// pr($fee_data);exit;

	$_SESSION['allFees'] = $fee_data;
	$_SESSION['mode'] = $mode;

	?>

	<table class="table table-bordered table-striped">
		<thead class="thead-dark">
			<tr>
				<th>Date</th>
				<?php foreach ($mode as $m): ?>
					<th class="text-right"><?php echo strtoupper($m); ?></th>
				<?php endforeach; ?>
				<th class="text-right">Total</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($fee_data as $date => $modes): ?>
				<tr>
					<td><?php echo date('d M Y', strtotime($date)); ?></td>
					<?php foreach ($mode as $m): ?>
						<td class="text-right"><?php echo formatAmt($modes[$m]); ?></td>
					<?php endforeach; ?>
					<td class="text-right font-weight-bold"><?php echo formatAmt($daily_totals[$date]); ?></td>
				</tr>
			<?php endforeach; ?>

			<tr style="background-color: #d4edda;">
				<th>Total</th>
				<?php foreach ($mode as $m): ?>
					<td class="text-right"><b><?php echo formatAmt($mode_totals[$m]); ?></b></td>
				<?php endforeach; ?>
				<td class="text-right"><b><?php echo formatAmt($overall_total); ?></b></td>
			</tr>
		</tbody>
	</table>
</div>

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