<?php
ob_start();
class xtcpdf extends TCPDF
{
}

// Initialize TCPDF
if ($Head == 'dateSum') {
$pdf = new TCPDF('P', 'mm', 'A4');
}else{
$pdf = new TCPDF('L', 'mm', 'A4');
}
// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->SetFont('', '', 8, '', 'true');
TCPDF_FONTS::addTTFfont('../Devanagari/Devanagari.ttf', 'TrueTypeUnicode', "", 32);

// Start HTML content

// pr($where);die;

if ($Head == 'dateSum') {
  if($where['ExpenseDetail.add_date >='] !='1970-01-01'  && $where){
    $date = 'Date From:'.date('d-m-Y', strtotime($where['ExpenseDetail.add_date >='])) . ' |  Date To: ' . date('d-m-Y', strtotime( $where['ExpenseDetail.add_date <=']));
  }
  $html = '
  <h1 style="text-align:center;">Actual Expense Report </h1>
 <div style="text-align:center;">
    <h3> ' . $date  . '</h3>
  </div>

  <table cellspacing="0" cellpadding="5"style="font-size:9px;" border="1">
    <thead>
      <tr>
      <th style="width:8%;text-align:left !important;"><b>S.No</b></th>
      <th style="width:20%;text-align:left !important;"><b>Date</b></th>
      <th style="width:30%;text-align:left !important;"><b>Expense Name</b></th>
      <th style="width:30%;text-align:left !important;"><b>Description</b></th>
        <th style="width:12%;text-align:right;"><b>Amount</b></th>
      </tr>
      
    </thead>
    <tbody>';

    $Sum = 0;
  foreach ($expensedet as $value) {
    $i++;
    $expancedetails = $this->Comman->findexpansediscription($value['description']);
    $expansename = $this->Comman->findexpansename($value['exp_cat_id']);
    $html .= '<tr>
    <td style="width:8%;text-align:left;">' . $i . '</td>
     <td style="width:20%;text-align:left;">' . date('d-m-Y', strtotime($value['add_date'])) . '</td>
      <td style="width:30%;text-align:left;">' . $expansename['category_name'] . '</td>
       <td style="width:30%;text-align:left;">' . ucfirst($expancedetails['title']) . '</td>
                <td style="width:12%;text-align:right;">' . $value['amount'] . '</td>
      </tr>';

      $Sum += $value['amount']; 

  }

  $html .= '
 <tr> 
 <th style="text-align:right !important;" colspan="4"><b>Total</b></th>
      <th style="text-align:right !important;"><b>' . $Sum . '</b></th>
      </tr>
    </tbody>
  </table>';
} else {


  if ($where['year']) {
    $year = $where['year'];
    $year1 = $year + 1;
  } else {

    $curyear = date('Y');
    if (date('m') > 3) {
      $year = $curyear;
      $year1 = $year + 1;
    } else {
      $year = $year - 1;
      $year1 = $curyear;
    }

  }



  $html = '
  <h2 style="text-align:center;">Financial Year Actual Expense Report ' . ($year) . '-' . ($year1) . '</h2>
  <table cellspacing="0" cellpadding="5" style="font-size:9px;" border = "1px">
    <thead>
      <tr>
        <th style="width:14.2%;text-align:left;"><b>Expenses</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>April</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>May</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>June</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>July</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>Aug</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>Sep</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>Oct</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>Nov</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>Dec</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>Jan</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>Feb</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>March</b></th>
        <th style="width:6.6%;text-align:right !important;"><b>Total</b></th>
      </tr>
    </thead>
    <tbody>';

  // Define the months
  $mnths = array('1' => '4', '2' => '5', '3' => '6', '4' => '7', '5' => '8', '6' => '9', '7' => '10', '8' => '11', '9' => '12', '10' => '1', '11' => '2', '12' => '3');

  // Iterate over expense categories
  foreach ($expensedet as $ex_catt) {
    $html .= '<tr>
                <td style="width:14.2%;text-align:left;"><b>' . $ex_catt['category_name'] . '</b></td>';
    $total = 0;
    for ($i = 1; $i <= 12; $i++) {
      $m = $this->Comman->getMonthTotal($ex_catt['id'], $mnths[$i], $year);
      $amount = $m['sum'] ? $m['sum'] : 0;
      $total += $amount;
      $html .= '<td style="width:6.6%;text-align:right !important;">' . $amount . '</td>';
    }
    $html .= '<td style="width:6.6%;text-align:right !important;"><b>' . $total . '</b></td>
              </tr>';
  }

  // Total sum for all months
  $html .= '<tr>
            <td style="width:14.2%;text-align:right !important;"><b>Total</b></td>';
  $total_sum = 0;
  for ($i = 1; $i <= 12; $i++) {
    $m = $this->Comman->getMonthTotalSum($mnths[$i], $year);
    $month_sum = $m['sum'] ? $m['sum'] : 0;
    $total_sum += $month_sum;
    $html .= '<td style="width:6.6%;text-align:right !important;"><b>' . $month_sum . '</b></td>';
  }
  $html .= '<td style="width:6.6%;text-align:right !important;"><b>' . $total_sum . '</b></td>
          </tr>';

  $html .= '
    </tbody>
  </table>';
}

// Output the HTML content to PDF
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
ob_end_clean();
echo $pdf->Output('Actual Expense.pdf', 'I');
exit;
?>