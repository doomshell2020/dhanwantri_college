<?php
class xtcpdf extends TCPDF
{
}


define("MAJOR", 'Ruppes Only');
define("MINOR", '');
class toWords
{
    var $pounds;
    var $pence;
    var $major;
    var $minor;
    var $words = '';
    var $number;
    var $magind;
    var $units = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine');
    var $teens = array('Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen');
    var $tens = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety');
    var $mag = array('', 'Thousand', 'Million', 'Billion', 'Trillion');

    function toWords($amount, $major = MAJOR, $minor = MINOR)
    {
        $this->__toWords__((int)($amount), $major);
        $whole_number_part = $this->words;
        #$right_of_decimal = (int)(($amount-(int)$amount) * 100);
        $strform = number_format($amount, 2);
        $right_of_decimal = (int)substr($strform, strpos($strform, '.') + 1);
        $this->__toWords__($right_of_decimal, $minor);
        $this->words = $whole_number_part . ' ' . $this->words;
    }

    function __toWords__($amount, $major)
    {
        $this->major  = $major;
        #$this->minor  = $minor;
        $this->number = number_format($amount, 2);
        list($this->pounds, $this->pence) = explode('.', $this->number);
        $this->words = " $this->major";
        if ($this->pounds == 0)
            $this->words = "$this->words";
        else {
            $groups = explode(',', $this->pounds);
            $groups = array_reverse($groups);
            for ($this->magind = 0; $this->magind < count($groups); $this->magind++) {
                if (($this->magind == 1) && (strpos($this->words, 'Hundred') === false) && ($groups[0] != '000'))
                    $this->words = ' And ' . $this->words;
                $this->words = $this->_build($groups[$this->magind]) . $this->words;
            }
        }
    }

    function _build($n)
    {
        $res = '';
        $na  = str_pad("$n", 3, "0", STR_PAD_LEFT);
        if ($na == '000')
            return '';
        if ($na{
        0} != 0)
            $res = ' ' . $this->units[$na{
            0}] . ' Hundred';
        if (($na{
        1} == '0') && ($na{
        2} == '0'))
            return $res . ' ' . $this->mag[$this->magind];
        $res .= $res == '' ? '' : ' And';
        $t = (int) $na{
        1};
        $u = (int) $na{
        2};
        switch ($t) {
            case 0:
                $res .= ' ' . $this->units[$u];
                break;
            case 1:
                $res .= ' ' . $this->teens[$u];
                break;
            default:
                $res .= ' ' . $this->tens[$t] . ' ' . $this->units[$u];
                break;
        }
        $res .= ' ' . $this->mag[$this->magind];
        return $res;
    }
}



// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set default header data
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('', '', 7, '', 'false');



// add a page
$pdf->AddPage('P', 'A5');

$html .= '
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';

$html .= '</head>
<body>
<table width="100%">
<tr>
<td width="33.3333%"></td>
<td width="33.3333%" align="center">Sri Sai Shikshan Sansthan</td>
<td width="33.3333%" align="right"><table width="100%">
<tr>
<td width="70%"></td>';

if ($studentfees[0]['mode'] == 'CHEQUE') {


    $html .= '<td width="30%" style="border:1px solid #000;" align="center"><a href="javascript:void(0);" style="text-decoration:none; color:#000; width:100px; display:inline-block; border-top:1px solid #000;  border-left:1px solid #000;  border-right:1px solid #000;  border-bottom:1px solid #000;">CHEQUE</a></td>';
} else if ($studentfees[0]['mode'] == 'DD') {

    $html .= '<td width="30%" style="border:1px solid #000;" align="center"><a href="javascript:void(0);" style="text-decoration:none; color:#000; width:100px; display:inline-block; border-top:1px solid #000;  border-left:1px solid #000;  border-right:1px solid #000;  border-bottom:1px solid #000;">DD</a></td>';
} else if ($studentfees[0]['mode'] == 'NETBANKING') {
    $html .= '<td width="40%" style="border:1px solid #000;" align="center"><a href="javascript:void(0);" style="text-decoration:none; color:#000; width:100px; display:inline-block; border-top:1px solid #000;  border-left:1px solid #000;  border-right:1px solid #000;  border-bottom:1px solid #000;">NETBANKING</a></td>';
} else if ($studentfees[0]['mode'] == 'Credit Card/Debit Card/UPI') {
    $html .= '<td width="40%" style="border:1px solid #000;" align="center"><a href="javascript:void(0);" style="text-decoration:none; color:#000; width:100px; display:inline-block; border-top:1px solid #000;  border-left:1px solid #000;  border-right:1px solid #000;  border-bottom:1px solid #000;">CREDIT CARD/<br>DEBIT CARD</a></td>';
} else if ($studentfees[0]['mode'] == 'CASH') {
    $html .= '<td width="30%" style="border:1px solid #000;" align="center"><a href="javascript:void(0);" style="text-decoration:none; color:#000; width:100px; display:inline-block; border-top:1px solid #000;  border-left:1px solid #000;  border-right:1px solid #000;  border-bottom:1px solid #000;">CASH</a></td>';
}



$html .= '</tr>
</table></td>
</tr>
<tr>
<td colspan="3" align="center"><img src="images/L_58839.gif" alt="" border="0" style=" width: 700%; display:block;">
</td>
</tr>
<tr>
<td colspan="3" align="center">Affiliated C.B.S.E. Delhi</td>
</tr>
<tr>
<td><span style="text-align:left; display:inline-block;">Vishwamitra Marg, Defence Colony <br>Sirsi Road, Jaipur (Rajasthan) 302012</span></td>
<td></td>
<td align="right"><span>Ph. No.: 2246189, 2357844</span> &nbsp;  &nbsp; </td>
</tr>
</table>
<br><br>
<table width="100%" cellspacing="0">
<tr>
<th colspan="4" style=" line-height:17px;font-weight:bold; text-align:center; font-size:15px; border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; " height="25px">
Reciept Session:' . $studentfees[0]['acedmicyear'] . '
</th>
</tr>
<tr>
<td width="20%" style=" line-height:20px; height:20px;border-left:1px solid #000;">&nbsp; Receipt No.</td>
<td width="40%" style="line-height:20px; height:20px;">:&nbsp; ' . $studentfees[0]['id'] . '</td>
<td width="12%" style="line-height:20px; height:20px;">Date</td>
<td width="28%" style="line-height:20px; height:20px;border-right:1px solid #000;">:&nbsp; ' . date('d-m-Y', strtotime($studentfees[0]['paydate'])) . '&nbsp;</td>
</tr>
<tr>
<td width="20%" style="line-height:20px; height:20px;border-left:1px solid #000;">&nbsp; Name</td>
<td width="40%" style="line-height:20px; height:20px;"><p>:&nbsp; ' . ucwords($students['fee_submittedby']) . '</p></td>
<td width="12%" style="line-height:20px; height:20px;">Class</td>
<td width="28%" style="line-height:20px; height:20px;border-right:1px solid #000; text-transform:uppercase;">:&nbsp; ' . $students['class']['title'] . '</td>
</tr>
<tr>';
$n = "&nbsp;Pupil's Name";
$html .= '<td width="20%" style="border-left:1px solid #000;line-height:20px; height:20px;">&nbsp;' . $n . ' </td>
<td width="40%" style="text-transform:uppercase;line-height:20px; height:20px;">:&nbsp;&nbsp;' . ucwords($students['fname']) . ' ' . ucwords($students['middlename']) . ' ' . ucwords($students['lname']) . '</td>
<td width="12%" style="line-height:20px; height:20px;">SR No.</td>
<td width="28%" style="border-right:1px solid #000;line-height:20px; height:20px;">:&nbsp; ' . $students['id'] . '</td>
</tr>
<tr>
<td colspan="4" style="padding:0px;">
<table cellspacing="0" width="100%">
<tr>
<td width="6%" style="line-height:20px; text-align:center;height:20px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000;">&nbsp; S.No.</td>
<td width="66%"  style="line-height:20px; text-align:left; height:20px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000;">&nbsp; Particulars</td>
<td width="28%"  style="line-height:20px; text-align:right; height:20px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; text-align:right;">Amount &nbsp; &nbsp; </td>
</tr>';


$count = 1;
$fees = 0;
$j = 0;

foreach ($studentfees as $value) {
    $quas = unserialize($value['quarter']);
}

$arr = array();
foreach ($quas as $h => $vale) {

    $qua[] = $h;
}


foreach ($quas as $iteam['quarter'] => $iteam['amount']) {





    if ($iteam['quarter'] == 'Admission Fee') {


        $fees = $iteam['amount'];
        $iteam['quarter'] = "ADMISSION FEE";
    } else if ($iteam['quarter'] == 'Development Fee') {

        $fees = $iteam['amount'];
        $iteam['quarter'] = "DEVELOPMENT FEE";
    } else if ($iteam['quarter'] == 'Caution Money') {

        $fees = $iteam['amount'];
        $iteam['quarter'] = "CAUTION MONEY";
    } else if ($iteam['quarter'] == 'Caution Money') {

        $fees = $iteam['amount'];
        $iteam['quarter'] = "CAUTION MONEY";
    } else if ($iteam['quarter'] == 'Quater1') {


        $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees[0]['acedmicyear']);
        $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
        $fees = $iteam['amount'];
        $iteam['quarter'] = "TUTION FEE (APRIL-JUNE)";
    } else if ($iteam['quarter'] == 'Quater2') {

        $fees = $iteam['amount'];

        $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees[0]['acedmicyear']);
        $lastdatemonth = date('Y-m-d', strtotime($rg['qu2_date']));
        $iteam['quarter'] = "TUTION FEE (JULY-SEPTEMBER)";
    } else if ($iteam['quarter'] == 'Quater3') {
        $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees[0]['acedmicyear']);
        $fees = $iteam['amount'];
        $iteam['quarter'] = "TUTION FEE (OCTOBER-DECEMBER)";
        $lastdatemonth = date('Y-m-d', strtotime($rg['qu3_date']));
    } else if ($iteam['quarter'] == 'Quater4') {

        $fees = $iteam['amount'];
        $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees[0]['acedmicyear']);
        $lastdatemonth = date('Y-m-d', strtotime($rg['qu4_date']));
        $iteam['quarter'] = "TUTION FEE (JANUARY-MARCH)";
    } else if ($iteam['quarter'] == 'Miscellaneous Fee') {

        $fees = $iteam['amount'];
        $iteam['quarter'] = "MISCELLANEOUS FEE";

        $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees[0]['acedmicyear']);
        $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
    } else {

        $fees = $iteam['amount'];
    }



    $j += $fees;
    if ($fees) {
        $html .= '<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:center;">' . $count++ . '</td>
<td style="line-height:20px; height:20px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;  ' . $iteam['quarter'] . '</td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">' . number_format($fees, 2) . '&nbsp; &nbsp; </td>
</tr>';
    }
}


$html .= '<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:20px; height:20px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>


<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right; border-top:1px solid #000;" colspan="2">Total Fees Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right; border-top:1px solid #000;">' . number_format($j, 2) . ' &nbsp; &nbsp; </td>
</tr>


<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right;" colspan="2">(+)Late Fees Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp; &nbsp; </td>
</tr>

<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Due Amount Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp; &nbsp; </td>
</tr>';


foreach ($studentfees as $key => $iteam) {
    $discount_fees = $iteam['discount'];
    $addtionaldiscount_fees = $iteam['addtionaldiscount'];
    $deposite_amt = $iteam['deposite_amt'];
}
if ($discount_fees > 0) {
    $netamount = $j / 100 * $discount_fees;
    $remain = $j - $netamount;
    $html .= '<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Discount: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">' . number_format($netamount, 2) . ' &nbsp; &nbsp; </td>
</tr>';
} else {
    $remain = $j;
    $html .= '<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Discount: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp; &nbsp; </td>
</tr>';
}

if ($addtionaldiscount_fees > 0 || $addtionaldiscount_fees != 0) {

    $remain = $remain - $addtionaldiscount_fees;
    $html .= '<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Additonal Discount (if any): &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">' . number_format($addtionaldiscount_fees, 2) . ' &nbsp; &nbsp;&nbsp; </td>
</tr>';
} else {
    $html .= '<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Additonal Discount (if any): &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp; &nbsp;&nbsp; </td>
</tr>';
}




if ($deposite_amt) {

    $html .= '<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right; font-weight:bold;" colspan="2">Net Deposited Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; font-weight:bold; text-align:right;">' . number_format($deposite_amt, 2) . ' &nbsp; &nbsp;  </td>
</tr>';
    $obj    = new toWords($deposite_amt);
    $w = $obj->words;
} else if ($remain != '') {
    $html .= '<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right; font-weight:bold;" colspan="2">Net Deposited Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; font-weight:bold; text-align:right;">' . number_format($remain, 2) . ' &nbsp; &nbsp;  </td>
</tr>';
    $obj    = new toWords($remain);
    $w = $obj->words;
} else {

    $html .= '<tr>
<td style="line-height:20px; height:20px;border-left:1px solid #000; text-align:right; font-weight:bold;" colspan="2">Net Deposited Rs.: &nbsp; &nbsp; </td>
<td style="line-height:20px; height:20px;border-left:1px solid #000; border-right:1px solid #000; font-weight:bold; text-align:right;">' . number_format($j, 2) . '&nbsp; &nbsp;  </td>
</tr>';

    $obj    = new toWords($j);
    $w = $obj->words;
}
$html .= '<tr>
<td colspan="3" style="line-height:20px; height:20px;border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000;">&nbsp;  
' . $w . '
</td>
</tr>
<tr>
<td colspan="3" style="line-height:20px; height:20px;border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">';

if ($studentfees[0]['mode'] == 'CHEQUE') {
    $html .= '&nbsp; <span>Paid by Chq.No.: ' . $studentfees[0]['cheque_no'] . ' 
Dt: ' . date('d-m-Y', strtotime($studentfees[0]['paydate'])) . ' ' . $studentfees[0]['bank_id'] . '<br></span>';
} else if ($studentfees[0]['mode'] == 'DD') {
    $html .= '&nbsp; <span>Paid by DD No.: ' . $studentfees[0]['cheque_no'] . ' 
Dt: ' . date('d-m-Y', strtotime($studentfees[0]['paydate'])) . ' ' . $studentfees[0]['bank_id'] . '<br></span>';
} else if ($studentfees[0]['mode'] == 'NETBANKING') {
    $html .= '&nbsp; <span>Paid by Netbanking Refrence No.: 
' . $studentfees[0]['ref_no'] . ' Dt: ' . date('d-m-Y', strtotime($studentfees[0]['paydate'])) . '<br></span>';
} else if ($studentfees[0]['mode'] == 'Credit Card/Debit Card/UPI') {
    $html .= '&nbsp; <span>Paid by Credit/Debit Card Refrence No.: 
' . $studentfees[0]['ref_no'] . ' Dt: ' . date('d-m-Y', strtotime($studentfees[0]['paydate'])) . '<br></span>';
} else if ($studentfees[0]['mode'] == 'CASH') {
    $html .= '&nbsp; <span>Paid by Cash Dt: ' . date('d-m-Y', strtotime($studentfees[0]['paydate'])) . '<br></span>';
}

$dateg = date('M', strtotime("+3 months", strtotime($lastdatemonth)));

$html .= '<span>&nbsp;&nbsp;Next Due on 10, ' . $dateg . ' after Due Date Rs. 10 per day fine will be charged.<br>&nbsp;&nbsp;Amount once deposited will not be refunded<br> &nbsp;Remarks:
</span>
</td>
</tr>

<tr>
<td colspan="3" style="text-align:right;line-height:20px; height:20px;">';

$nh = "Reciever's Signature";

$html .= $nh . '&nbsp;  &nbsp; 
</td>
</tr>
 </table>
</td>
</tr>
</table>
</body>
</html>';
//echo $html; die;
// force print dialog
$pdf->writeHTML($html, true, 0, true, 0);



ob_end_clean();

// write some JavaScript code


// force print dialog
$js .= 'print(true);';

// set javascript
$pdf->IncludeJS($js);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Receipt.pdf');
exit;
?>



?>