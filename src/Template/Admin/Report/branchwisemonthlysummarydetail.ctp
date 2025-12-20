<div class="table-responsive">
<?php setlocale(LC_MONETARY, 'en_IN'); ?>
<table width="100%" class="table table-bordered table-striped">
<tr>
<td colspan="4"><a id=""  class="btn btn-info btn-sm pull-right" target="_blank" href="<?php echo ADMIN_URL ;?>report/branchwisemonthlysum_pdf"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export PDF</a></td>
</tr>
  <tr>
    <th>Branch Name</th>
    <th>April</th>
    <th>May</th>
    <th>June</th>
    <th>July</th>
    <th>August</th>
    <th>September</th>
    <th>October</th>
    <th>November</th>
    <th>December</th>
    <th>January</th>
    <th>February</th>
    <th>March</th>
  </tr>

  <?php //pr($all_data);exit;

  foreach($all_data as $key=> $value){ 
 
    $branch_name = explode("_",$key); 
   
    ?> 
  <tr>
 <td><?php echo ucfirst($branch_name[1]); ?></td>
<td><?php echo $value['apr']; ?></td>
<td><?php echo $value['may']; ?></td>
<td><?php echo $value['june']; ?></td>
<td><?php echo $value['july']; ?></td>
<td><?php echo $value['aug']; ?></td>
<td><?php echo $value['sep']; ?></td>
<td><?php echo $value['oct']; ?></td>
<td><?php echo $value['nov']; ?></td>
<td><?php echo $value['dec']; ?></td>
<td><?php echo $value['jan']; ?></td>
<td><?php echo $value['feb']; ?></td>
<td><?php echo $value['mar']; ?></td>

  </tr>
  <?php 
    $april_total += $value['apr'];
    $may_total += $value['may'];
    $june_total += $value['june'];
    $july_total += $value['july'];
    $aug_total += $value['aug'];
    $sep_total += $value['sep'];
    $oct_total += $value['oct'];
    $nov_total += $value['nov'];
    $dec_total += $value['dec'];
    $jan_total += $value['jan'];
    $feb_total += $value['feb'];
    $march_total += $value['mar'];
} ?>
  <tr>
  <th style="color:green">Net Total</th>
  <th><?php echo $april_total; ?></th>
  <th><?php echo $may_total; ?></th>
  <th><?php echo $june_total; ?></th>
  <th><?php echo $july_total; ?></th>
  <th><?php echo $aug_total; ?></th>
  <th><?php echo $sep_total; ?></th>
  <th><?php echo $oct_total; ?></th>
  <th><?php echo $nov_total; ?></th>
  <th><?php echo $dec_total; ?></th>
  <th><?php echo $jan_total; ?></th>
  <th><?php echo $feb_total; ?></th>
  <th><?php echo $march_total; ?></th>

  </tr>
</table>
</div>
