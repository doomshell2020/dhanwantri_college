<?php
class xtcpdf extends TCPDF
{
}

define("MAJOR", 'Rupees Only');
define("MINOR", '');
class toWords
{
    public $pounds;
    public $pence;
    public $major;
    public $minor;
    public $words = '';
    public $number;
    public $magind;
    public $units = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine');
    public $teens = array('Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen');
    public $tens = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety');
    public $mag = array('', 'Thousand', 'Million', 'Billion', 'Trillion');

    public function toWords($amount, $major = MAJOR, $minor = MINOR)
    {
        $this->__toWords__((int) ($amount), $major);
        $whole_number_part = $this->words;
        #$right_of_decimal = (int)(($amount-(int)$amount) * 100);
        $strform = number_format($amount, 2);
        $right_of_decimal = (int) substr($strform, strpos($strform, '.') + 1);
        $this->__toWords__($right_of_decimal, $minor);
        $this->words = $whole_number_part . ' ' . $this->words;
    }

    public function __toWords__($amount, $major)
    {
        $this->major = $major;
        #$this->minor  = $minor;
        $this->number = number_format($amount, 2);
        list($this->pounds, $this->pence) = explode('.', $this->number);
        $this->words = " $this->major";
        if ($this->pounds == 0) {
            $this->words = "$this->words";
        } else {
            $groups = explode(',', $this->pounds);
            $groups = array_reverse($groups);
            for ($this->magind = 0; $this->magind < count($groups); $this->magind++) {
                if (($this->magind == 1) && (strpos($this->words, 'Hundred') === false) && ($groups[0] != '000')) {
                    $this->words = ' And ' . $this->words;
                }

                $this->words = $this->_build($groups[$this->magind]) . $this->words;
            }
        }
    }

    public function _build($n)
    {
        $res = '';
        $na = str_pad("$n", 3, "0", STR_PAD_LEFT);
        if ($na == '000') {
            return '';
        }

        if ($na{
            0} != 0) {
            $res = ' ' . $this->units[$na{
                0}] . ' Hundred';
        }

        if (($na{
            1} == '0') && ($na{
            2} == '0')) {
            return $res . ' ' . $this->mag[$this->magind];
        }

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

//$subject=$this->Comman->findexamsubjectsresult($students['id'],$students['section']['id'],$students['acedmicyear']);

$this->set('pdf', new TCPDF('1', 'mm', 'A4'));
$pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->setHeaderMargin(0);
// set margins
$pdf->SetMargins(0, 0, 0, 0); // set the margins 

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetAutoPageBreak(TRUE, 0);
//$pdf->SetMargins(5, 0, 5, true);

$address = $sitesetting['address1'];
$mobile = $sitesetting['phone'];
$email = $sitesetting['email'];
$website = $sitesetting['website'];
$school_name = $sitesetting['subtitle1'];
$logo  = SITE_URL . "/images/" . $sitesetting['small_logo'];

$pdf->SetFont('', '', 8, '', 'true');
TCPDF_FONTS::addTTFfont('../Devanagari/Devanagari.ttf', 'TrueTypeUnicode', "", 32);
$html = '
<table width="100%" cellspacing="0">
<tr>
<td width="48%">
<table width="100%" cellspacing="0">
<tr>
<td width="1%"> </td>
<td width="98%">
<table width="100%" border="0" style="border:none">
<tbody>
<tr>
    <td width="18%"><img src="' . $logo . '"></td>
    <td width="82%"  style="color: #000; margin-top:0px; font-size: 13px; margin-bottom:0px;  text-align: center;"><br><b>' . $school_name . '</b><br>
        <span style="text-align:center; display:inline-block; font-size:10px;"><b>' . $address . '</b></span>
    </td>
</tr>
</tbody></table>
<br>
<br>
<table width="100%" cellspacing="0">
<tr>
<td width="100%">
<table width="100% " cellspacing="0">
<tr>
<td width="100%" style="border:1px  solid #000; font-size:12px; text-transform:uppercase; text-align:center; height:28px; line-height:28px;"><strong>
RECEIPT SESSION:  ' . $studentfees['acedmicyear'] . '</strong>
</td>
</tr>

<tr>
<td width="100%" style="border:1px solid #000;">
<table width="100%">
<tr>

<td width="25%" style="height:12px; line-height:12px;">&nbsp; Receipt No.</td>
<td width="35%" style="height:12px; line-height:12px;">: ' . $studentfees['recipetno'] . '  </td>

<td width="15%" style="height:12px; line-height:12px;">Date.</td>
<td width="25%" style="height:12px; line-height:12px;">: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '&nbsp;</td>
</tr>

<tr>
<td width="25%" style="height:12px; line-height:12px;">&nbsp; Father/Mothers Name.</td>
<td width="35%" style="height:12px; line-height:12px;">: ' . strtoupper(ucwords($students['fee_submittedby'])) . '&nbsp; </td>

<td width="15% " style="height:12px; line-height:12px;">Class.</td>
<td width="25%" style="height:12px; line-height:12px;">: ' . $students['class']['title'] . '-' . $students['section']['title'] . ' &nbsp;</td>
</tr>

<tr>
<td width="25%" style="height:12px; line-height:12px;">&nbsp; Pupils Name.</td>
<td width="35%" style="height:12px; line-height:12px;">: ' . strtoupper(ucwords($students['fname'])) . ' ' . strtoupper(ucwords($students['middlename'])) . ' ' . strtoupper(ucwords($students['lname'])) . ' </td>

<td width="15%" style="height:12px; line-height:12px;">Sr.No.</td>
<td width="25%" style="height:12px; line-height:12px;">: ' . $students['enroll'] . ' &nbsp;</td>
</tr>

</table>
</td>

</tr>
</table>
</td>
</tr>
</table>

<table width="100%" cellspacing="0">
<tr>

<td width="7%" style="border:1px solid #000; height:15px; line-height:15px; ">&nbsp; S.No.</td>
<td width="75%" style="border:1px solid #000; height:15px; line-height:15px; ">&nbsp; Particulars</td>
<td width="18%" style="border:1px solid #000; height:15px; line-height:15px; text-align:right;"> Amount &nbsp;&nbsp;</td>

</tr>';



$count = 1;
$fees = 0;
$j = 0;
if ($studentfees['refrencepending'] == '0') {
    $quas = unserialize($studentfees['quarter']);
    $arr = array();

    foreach ($quas as $iteam['quarter'] => $iteam['amount']) {

        if ($iteam['quarter'] == 'Caution Money') {

            if ($iteam['quarter'] == 'Admission Fee') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "ADMISSION FEE";
            } else if ($iteam['quarter'] == 'Development Fee') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "DEVELOPMENT FEE";
            } else if ($iteam['quarter'] == 'Caution Money') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "Caution Money";
            } else if ($iteam['quarter'] == 'Quater1') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "TUTION FEE (APRIL-JUNE)";

                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
            } else if ($iteam['quarter'] == 'Quater2') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "TUTION FEE (JULY-SEPTEMBER)";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu2_date']));
            } else if ($iteam['quarter'] == 'Quater3') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "TUTION FEE (OCTOBER-DECEMBER)";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu3_date']));
            } else if ($iteam['quarter'] == 'Quater4') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "TUTION FEE (JANUARY-MARCH)";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu4_date']));
            } else if ($iteam['quarter'] == 'Miscellaneous Fee') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "MISCELLANEOUS FEE";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
            } else if ($iteam['quarter']) {

                $fees = $iteam['amount'];

                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
            } else {

                $fees = $iteam['amount'];
            }



            $j += $fees;
            if ($fees) {
                $html .= '<tr style="font-size:12px;">
<td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:center;">' . $count++ . '</td>
<td style="line-height:17px; height:17px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;  ' . $iteam['quarter'] . '</td>
<td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">' . number_format($fees, 2) . '&nbsp; &nbsp; </td>
</tr>';
            }
        }
    }
} else {

    $fees = $studentfees['deposite_amt'];
    $iteam['quarter'] = $studentfees['quarter'];
    $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
    $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));

    $j += $fees;
    if ($fees) {
        $html .= '<tr style="font-size:12px;">
<td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:center;">' . $count++ . '</td>
<td style="line-height:17px; height:17px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;  ' . $iteam['quarter'] . '</td>
<td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">' . number_format($fees, 2) . '&nbsp; &nbsp; </td>
</tr>';
    }
}



$t = 11;

for ($x = $count; $x <= $t; $x++) {

    $html .= '<tr style="font-size:12px;">
<td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:17px; height:17px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>';
}

$html .= '
</table>

<table width="100%">
<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
Total Fees Rs.: &nbsp;
</td> 
<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
' . number_format($j, 2) . ' &nbsp;
</td>
</tr>';
$lfine = $studentfees['lfine'];
$html .= '
<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; ">
(+)Late Fee.: &nbsp;
</td>


<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
' . number_format($lfine, 2) . ' &nbsp;
</td>

</tr>';
$dueamt = $this->Comman->findpendingrefrencefees23($studentfees['id']);

$html .= '
<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; ">
(-)Due Amount Fee.: &nbsp;
</td>


<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
' . number_format($dueamt['amt'], 2) . ' &nbsp;
</td>

</tr>';
$discount_fees = $studentfees['discount'];
$addtionaldiscount_fees = $studentfees['addtionaldiscount'];
$deposite_amt = $studentfees['deposite_amt'];

$netamount = $discount_fees;
$remain = $j - $netamount;

$html .= '
<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; ">
(-)Discount.: &nbsp;
</td>


<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
' . number_format($discount_fees, 2) . ' &nbsp;
</td>

</tr>

<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; ">
(+)Additonal Discount(if any): &nbsp;
</td>


<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
' . number_format($addtionaldiscount_fees, 2) . ' &nbsp;
</td>
</tr>

<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; font-weight:bold;">
Net Deposited Rs.: &nbsp;
</td>


<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; font-weight:bold;">
' . number_format($deposite_amt, 2) . ' &nbsp;
</td>
</tr>';
$dueamt = $this->Comman->findpendingrefrencefees23($studentfees['id']);
$html .= '
</table>


<table width="100%">
<tr>';
$obj = new toWords($deposite_amt);
$w = $obj->words;
$html .= '
<td width="100%" style="border:1px solid #000; height:15px; line-height:15px;">
&nbsp; ' . $w . '
</td>
</tr>

<tr>

<td width="100%" style="border:1px solid #000; ">
 <div style="height:10px; line-height:7px;"> ';
if ($studentfees['mode'] == 'CHEQUE') {
    $html .= '&nbsp;Paid by Chq.No. : ' . $studentfees['cheque_no'] . '
Dt: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . ' && Bank Name : ' . $studentfees['bank'] . '<br>';
} else if ($studentfees['mode'] == 'DD') {
    $html .= '&nbsp;Paid by DD No. : ' . $studentfees['cheque_no'] . '
Dt: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . ' && Bank Name : ' . $studentfees['bank'] . '<br>';
} else if ($studentfees['mode'] == 'NETBANKING') {
    $html .= '&nbsp;Paid by Netbanking Refrence No.:
' . $studentfees['ref_no'] . ' Dt: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '<br>';
} else if ($studentfees['mode'] == 'CREDIT CARD /<br>DEBIT CARD') {


    $html .= '&nbsp;Paid by Credit/Debit Card Refrence No.:
' . $studentfees['ref_no'] . ' Dt: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '<br>';
} else if ($studentfees['mode'] == 'CASH') {
    $html .= '&nbsp;Paid by Cash Dt: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '';
}
$html .= '</div>
 <div style="height:10px; line-height:7px;">';

if ($rtt == '1') {
    $dateg = date('M', strtotime("+3 months", strtotime($lastdatemonth)));
    $db = $this->request->session()->read('Auth.User.db');

    if ($lastdatemonthw) {
        if ($db['db'] == "kidsclub") {
            $html .= '&nbsp;&nbsp;Amount once deposited will not be refunded.';
        } else {
            $html .= '&nbsp;&nbsp;Next Due on 10, ' . $lastdatemonthw . ' after Due Date Rs. 10 per day fine will be charged.&nbsp;Amount once deposited <br> &nbsp;will not be refunded.';
        }
    } else {
        $html .= '&nbsp;&nbsp;Amount once deposited will not be refunded.';
    }
} else {
    $html .= '&nbsp;&nbsp;Amount once deposited will not be refunded.';
}
$html .= '</div><div style="height:10px; line-height:7px;"> &nbsp;Remarks :&nbsp;' . wordwrap(ucfirst(strtolower($studentfees['remarks'])), 80, "<br>&nbsp;&nbsp;") . '</div>
 <div style="height:10px; line-height:4px;"> </div>


</td>

</tr>

<tr>

<td width="100%" style="height:15px; line-height:15px; text-align:right; font-size:10px;">Principal/Accountant Signature &nbsp;</td>

</tr>
</table>

</td>
<td width="1%"> </td>
</tr>
</table>
</td>

<td  width="4%"></td>

<td width="48%">
<table width="100%" cellspacing="0">
<tr>
<td width="1%"> </td>
<td width="98%">
<table width="100%" border="0" style="border:none">
<tbody>
<tr>
    <td width="18%"><img src="' . $logo . '"></td>
    <td width="82%"  style="color: #000; margin-top:0px; font-size: 13px; margin-bottom:0px;  text-align: center;"><br><b>' . $school_name . '</b><br>
        <span style="text-align:center; display:inline-block; font-size:10px;"><b>' . $address . '</b></span>
    </td>
</tr>
</tbody></table>
<br>
<br>
<table width="100%" cellspacing="0">
<tr>
<td width="100%">
<table width="100% " cellspacing="0">
<tr>
<td width="100%" style="border:1px  solid #000; font-size:12px; text-transform:uppercase; text-align:center; height:28px; line-height:28px;"><strong>
RECEIPT SESSION:  ' . $studentfees['acedmicyear'] . '</strong>
</td>
</tr>

<tr>
<td width="100%" style="border:1px solid #000;">
<table width="100%">
<tr>


<td width="25%" style="height:12px; line-height:12px;">&nbsp; Receipt No.</td>
<td width="35%" style="height:12px; line-height:12px;">: ' . $studentfees['recipetno'] . '  </td>

<td width="15%" style="height:12px; line-height:12px;">Date.</td>
<td width="25%" style="height:12px; line-height:12px;">: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '&nbsp;</td>
</tr>

<tr>
<td width="25%" style="height:12px; line-height:12px;">&nbsp; Father/Mothers Name.</td>
<td width="35%" style="height:12px; line-height:12px;">: ' . strtoupper(ucwords($students['fee_submittedby'])) . '&nbsp; </td>

<td width="15% " style="height:12px; line-height:12px;">Class.</td>
<td width="25%" style="height:12px; line-height:12px;">: ' . $students['class']['title'] . '-' . $students['section']['title'] . ' &nbsp;</td>
</tr>

<tr>
<td width="25%" style="height:12px; line-height:12px;">&nbsp; Pupils Name.</td>
<td width="35%" style="height:12px; line-height:12px;">: ' . strtoupper(ucwords($students['fname'])) . ' ' . strtoupper(ucwords($students['middlename'])) . ' ' . strtoupper(ucwords($students['lname'])) . ' </td>

<td width="15%" style="height:12px; line-height:12px;">Sr.No.</td>
<td width="25%" style="height:12px; line-height:12px;">: ' . $students['enroll'] . ' &nbsp;</td>
</tr>

</table>
</td>

</tr>
</table>
</td>
</tr>
</table>

<table width="100%" cellspacing="0">
<tr>

<td width="7%" style="border:1px solid #000; height:15px; line-height:15px; ">&nbsp; S.No.</td>
<td width="75%" style="border:1px solid #000; height:15px; line-height:15px; ">&nbsp; Particulars</td>
<td width="18%" style="border:1px solid #000; height:15px; line-height:15px; text-align:right;"> Amount &nbsp;</td>


</tr>';


$count = 1;
$fees = 0;
$j = 0;
if ($studentfees['refrencepending'] == '0') {
    $quas = unserialize($studentfees['quarter']);
    $arr = array();
    foreach ($quas as $iteam['quarter'] => $iteam['amount']) {

        if ($iteam['quarter'] == 'Caution Money') {

            if ($iteam['quarter'] == 'Admission Fee') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "ADMISSION FEE";
            } else if ($iteam['quarter'] == 'Development Fee') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "DEVELOPMENT FEE";
            } else if ($iteam['quarter'] == 'Caution Money') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "Caution Money";
            } else if ($iteam['quarter'] == 'Quater1') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "TUTION FEE (APRIL-JUNE)";

                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
            } else if ($iteam['quarter'] == 'Quater2') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "TUTION FEE (JULY-SEPTEMBER)";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu2_date']));
            } else if ($iteam['quarter'] == 'Quater3') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "TUTION FEE (OCTOBER-DECEMBER)";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu3_date']));
            } else if ($iteam['quarter'] == 'Quater4') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "TUTION FEE (JANUARY-MARCH)";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu4_date']));
            } else if ($iteam['quarter'] == 'Miscellaneous Fee') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "MISCELLANEOUS FEE";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
            } else if ($iteam['quarter']) {

                $fees = $iteam['amount'];

                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
            } else {

                $fees = $iteam['amount'];
            }



            $j += $fees;
            if ($fees) {
                $html .= '<tr style="font-size:12px;">
<td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:center;">' . $count++ . '</td>
<td style="line-height:17px; height:17px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;  ' . $iteam['quarter'] . '</td>
<td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">' . number_format($fees, 2) . '&nbsp; &nbsp; </td>
</tr>';
            }
        }
    }
} else {

    $fees = $studentfees['deposite_amt'];
    $iteam['quarter'] = $studentfees['quarter'];
    $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
    $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));

    $j += $fees;
    if ($fees) {
        $html .= '<tr style="font-size:12px;">
<td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:center;">' . $count++ . '</td>
<td style="line-height:17px; height:17px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;  ' . $iteam['quarter'] . '</td>
<td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">' . number_format($fees, 2) . '&nbsp; &nbsp; </td>
</tr>';
    }
}

$t = 11;

for ($x = $count; $x <= $t; $x++) {

    $html .= '<tr style="font-size:12px;">
<td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:17px; height:17px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>';
}

$html .= '
</table>

<table width="100%">
<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
Total Fees Rs.: &nbsp;
</td> 
<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
' . number_format($j, 2) . ' &nbsp;
</td>
</tr>';
$lfine = $studentfees['lfine'];
$html .= '
<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; ">
(+)Late Fee.: &nbsp;
</td>
<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
' . number_format($lfine, 2) . ' &nbsp;
</td>
</tr>';
$dueamt = $this->Comman->findpendingrefrencefees23($studentfees['id']);

$html .= '
<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; ">
(-)Due Amount Fee.: &nbsp;
</td>
<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
' . number_format($dueamt['amt'], 2) . ' &nbsp;
</td>
</tr>';
$discount_fees = $studentfees['discount'];
$addtionaldiscount_fees = $studentfees['addtionaldiscount'];
$deposite_amt = $studentfees['deposite_amt'];

$netamount = $discount_fees;
$remain = $j - $netamount;

$html .= '
<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; ">
(-)Discount.: &nbsp;
</td>
<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
' . number_format($discount_fees, 2) . ' &nbsp;
</td></tr>
<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; ">
(+)Additonal Discount(if any): &nbsp;
</td>
<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right;">
' . number_format($addtionaldiscount_fees, 2) . ' &nbsp;
</td>
</tr>
<tr>
<td width="82%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; font-weight:bold;">
Net Deposited Rs.: &nbsp;
</td>
<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-top:1px solid #000; height:15px; line-height:15px; text-align:right; font-weight:bold;">
' . number_format($deposite_amt, 2) . ' &nbsp;
</td>
</tr>
</table><table width="100%">
<tr>';
$obj = new toWords($deposite_amt);
$w = $obj->words;
$html .= '
<td width="100%" style="border:1px solid #000; height:15px; line-height:15px;">
&nbsp; ' . $w . '
</td>
</tr>

<tr>

<td width="100%" style="border:1px solid #000; ">
 <div style="height:10px; line-height:7px;"> ';

if ($studentfees['mode'] == 'CHEQUE') {
    $html .= '&nbsp;Paid by Chq.No. : ' . $studentfees['cheque_no'] . '
Dt: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . ' && Bank Name : ' . $studentfees['bank'] . '<br>';
} else if ($studentfees['mode'] == 'DD') {
    $html .= '&nbsp;Paid by DD No. : ' . $studentfees['cheque_no'] . '
Dt: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . ' && Bank Name : ' . $studentfees['bank'] . '<br>';
} else if ($studentfees['mode'] == 'NETBANKING') {
    $html .= '&nbsp;Paid by Netbanking Refrence No.:
' . $studentfees['ref_no'] . ' Dt: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '<br>';
} else if ($studentfees['mode'] == 'CREDIT CARD /<br>DEBIT CARD') {
    $html .= '&nbsp;Paid by Credit/Debit Card Refrence No.:
' . $studentfees['ref_no'] . ' Dt: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '<br>';
} else if ($studentfees['mode'] == 'CASH') {
    $html .= '&nbsp;Paid by Cash Dt: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '';
}
$html .= '</div>
 <div style="height:10px; line-height:7px;">';

if ($rtt == '1') {
    $dateg = date('M', strtotime("+3 months", strtotime($lastdatemonth)));
    $db = $this->request->session()->read('Auth.User.db');

    if ($lastdatemonthw) {
        if ($db['db'] == "kidsclub") {
            $html .= '&nbsp;&nbsp;Amount once deposited will not be refunded.';
        } else {
            $html .= '&nbsp;&nbsp;Next Due on 10, ' . $lastdatemonthw . ' after Due Date Rs. 10 per day fine will be charged.&nbsp;Amount once deposited <br> &nbsp;will not be refunded.';
        }
    } else {
        $html .= '&nbsp;&nbsp;Amount once deposited will not be refunded.';
    }
} else {
    $html .= '&nbsp;&nbsp;Amount once deposited will not be refunded.';
}
$html .= '</div><div style="height:10px; line-height:7px;"> &nbsp;Remarks :&nbsp;' . wordwrap(ucfirst(strtolower($studentfees['remarks'])), 80, "<br>&nbsp;&nbsp;") . '</div>
 <div style="height:10px; line-height:4px;"> </div>
</td>
</tr>
<tr>
<td width="100%" style="height:15px; line-height:15px; text-align:right; font-size:10px;">Principal/Accountant Signature &nbsp;</td>
</tr>
</table>
</td>
<td width="1%"> </td>
</tr>
</table>
</td>
</tr>
</table>
';
// pr($html);die;
$pdf->writeHTMLCell(0, 0, '', '', utf8_encode($html), 0, 1, 0, true, '', true);

ob_clean();

$pdf->Output('printsadmission.pdf');
exit;
?>





<?php //ob_start();
// class xtcpdf extends TCPDF {
// }


// define("MAJOR", 'Rupees Only');
// define("MINOR", '');
// class toWords
// {
//     var $pounds;
//     var $pence;
//     var $major;
//     var $minor;
//     var $words = '';
//     var $number;
//     var $magind;
//     var $units = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine');
//     var $teens = array('Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen');
//     var $tens = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety');
//     var $mag = array('', 'Thousand', 'Million', 'Billion', 'Trillion');

//     function toWords($amount, $major = MAJOR, $minor = MINOR)
//     {
//         $this->__toWords__((int)($amount), $major);
//         $whole_number_part = $this->words;
//         #$right_of_decimal = (int)(($amount-(int)$amount) * 100);
//         $strform = number_format($amount,2);
//         $right_of_decimal = (int)substr($strform, strpos($strform,'.')+1);
//         $this->__toWords__($right_of_decimal, $minor);
//         $this->words = $whole_number_part . ' ' . $this->words;
//     }

//     function __toWords__($amount, $major)
//     {
//         $this->major  = $major;
//         #$this->minor  = $minor;
//         $this->number = number_format($amount, 2);
//         list($this->pounds, $this->pence) = explode('.', $this->number);
//         $this->words = " $this->major";
//         if ($this->pounds == 0)
//             $this->words = "$this->words";
//         else {
//             $groups = explode(',', $this->pounds);
//             $groups = array_reverse($groups);
//             for ($this->magind = 0; $this->magind < count($groups); $this->magind++) {
//                 if (($this->magind == 1) && (strpos($this->words, 'Hundred') === false) && ($groups[0] != '000'))
//                     $this->words = ' And ' . $this->words;
//                 $this->words = $this->_build($groups[$this->magind]) . $this->words;
//             }
//         }
//     }

//     function _build($n)
//     {
//         $res = '';
//         $na  = str_pad("$n", 3, "0", STR_PAD_LEFT);
//         if ($na == '000')
//             return '';
//         if ($na{0} != 0)
//             $res = ' ' . $this->units[$na{0}] . ' Hundred';
//         if (($na{1} == '0') && ($na{2} == '0'))
//             return $res . ' ' . $this->mag[$this->magind];
//         $res .= $res == '' ? '' : ' And';
//         $t = (int) $na{1};
//         $u = (int) $na{2};
//         switch ($t) {
//             case 0:
//                 $res .= ' ' . $this->units[$u];
//                 break;
//             case 1:
//                 $res .= ' ' . $this->teens[$u];
//                 break;
//             default:
//                 $res .= ' ' . $this->tens[$t] . ' ' . $this->units[$u];
//                 break;
//         }
//         $res .= ' ' . $this->mag[$this->magind];
//         return $res;
//     }
// }


// create new PDF document
// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A5', true, 'UTF-8', false);



// set default header data
// $pdf->SetPrintHeader(false);
// $pdf->SetPrintFooter(false);
// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
// $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
// $pdf->SetAutoPageBreak(TRUE, 0);

// set image scale factor
// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
// if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
// 	require_once(dirname(__FILE__).'/lang/eng.php');
// 	$pdf->setLanguageArray($l);
// }

// ---------------------------------------------------------

// set font
// $pdf->SetFont('', '', 7, '', 'false');

// $pdf->SetMargins(5, 3, 5, true);

// add a page
//$pdf->AddPage('P', 'A5');
// add a page
// if($studentfees['status']=='N'){

// // -- set new background ---

// // get the current page break margin
// $bMargin = $pdf->getBreakMargin();
// // get current auto-page-break mode
// $auto_page_break = $pdf->getAutoPageBreak();
// // disable auto-page-break
// $pdf->SetAutoPageBreak(false, 0);
// // set bacground image
// $img_file = WWW_ROOT.'images/cancelled.png';

// $pdf->Image($img_file, 45, 80, 70, 70, '', '', '', false, 300, '', false, false, 0);
// // restore auto-page-break status
// $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// // set the starting point for the page content
// $pdf->setPageMark();
// }

// for($i=0;$i<2;$i++){

// 	$pdf->AddPage('P', 'A5');
// $html.='
// <!DOCTYPE HTML>
// <html>
// <head>
// <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
// <title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';

// if($studentfees['mode']=='CHEQUE' ){

// 	 $studentfees['mode']='CHEQUE';

//     }else if($studentfees['mode']=='DD'){

//      $studentfees['mode']='DD';

//    }else if($studentfees['mode']=='NETBANKING'){

//      $studentfees['mode']='NETBANKING';

//     }else if($studentfees['mode']=='Credit Card/Debit Card/UPI'){

//      $studentfees['mode']='CREDIT CARD /<br>DEBIT CARD';

//     }else if($studentfees['mode']=='CASH'){
//      $studentfees['mode']='CASH';


//     }


//     $html .= '</head>
//     <body>';
//     $temp = str_replace(array('{logo}', '{sitetitle}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}','{mode}'), array($sitesetting['logo'], $sitesetting['sitetitle'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website'],$studentfees['mode']), $det['template']);

//     $html .= $temp;


// $html .= '
// <br><br>
// <table width="100%" cellspacing="1">
// <tr>
// <th colspan="4" style=" line-height:17px;font-weight:bold; text-align:center; font-size:15px; border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; border-right:1px solid #000;" height="25px">
// <strong>RECEIPT SESSION: '.$studentfees['acedmicyear'].'</strong>
// </th>
// </tr>
// <tr style="font-size:12px;">
// <td width="20%" style=" line-height:17px; height:17px;border-left:1px solid #000;">&nbsp; Receipt No.</td>
// <td width="40%" style="line-height:17px; height:17px;">:&nbsp; '.$studentfees['recipetno'].'</td>
// <td width="12%" style="line-height:17px; height:17px;">Date</td>
// <td width="28%" style="line-height:17px; height:17px;border-right:1px solid #000;">:&nbsp; '.date('d-m-Y',strtotime($studentfees['paydate'])).'&nbsp;</td>
// </tr>
// <tr style="font-size:12px;">
// <td width="20%" style="line-height:17px; height:17px;border-left:1px solid #000;">&nbsp; Name</td>
// <td width="40%" style="line-height:17px; height:17px;font-size:11px;"><p>:&nbsp; '.strtoupper(ucwords($students['fee_submittedby'])).'</p></td>
// <td width="12%" style="line-height:17px; height:17px;">Class</td>
// <td width="28%" style="line-height:17px; height:17px;border-right:1px solid #000; text-transform:uppercase;">:&nbsp; '.$students['class']['title'].'-'.$students['section']['title'].'</td>
// </tr>
// <tr style="font-size:12px;">';
// $n="&nbsp;Pupil's Name";
// $html.='<td width="20%" style="border-left:1px solid #000;line-height:17px; height:17px;">&nbsp;'.$n.' </td>
// <td width="40%" style="text-transform:uppercase;line-height:17px; height:17px;font-size:11px;">:&nbsp;&nbsp;'.strtoupper(ucwords($students['fname'])).' '.strtoupper(ucwords($students['middlename'])).' '.strtoupper(ucwords($students['lname'])).'</td>
// <td width="12%" style="line-height:17px; height:17px;">Sr. No.</td>
// <td width="28%" style="border-right:1px solid #000;line-height:17px; height:17px;">:&nbsp; '.$students['enroll'].'</td>
// </tr>
// <tr>
// <td colspan="4" style="padding:0px;">
// <table cellspacing="0" width="100%" cellpadding="1px">
// <tr style="font-size:12px;">
// <td width="8%" style="line-height:17px; text-align:center;height:17px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000;">&nbsp; S.No.</td>
// <td width="64%"  style="line-height:17px; text-align:left; height:17px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000;">&nbsp; Particulars</td>
// <td width="28%"  style="line-height:17px; text-align:right; height:17px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; text-align:right;">Amount &nbsp; &nbsp; </td>
// </tr>';


// $count=1; $fees=0; $j=0;
//  if($studentfees['refrencepending']=='0'){
// 							$quas=unserialize($studentfees['quarter']);




// 							$arr=array();


// foreach($quas as $iteam['quarter']=>$iteam['amount']){


// if($iteam['quarter']=='Caution Money'){


// if($iteam['quarter']=='Admission Fee'){


// 	  $fees=$iteam['amount'];
// 	  	 $iteam['quarter']="ADMISSION FEE";

// 	 }else if($iteam['quarter']=='Development Fee'){

// 	$fees=$iteam['amount'];
// 	 $iteam['quarter']="DEVELOPMENT FEE";
// 	 }else if($iteam['quarter']=='Caution Money'){

// 	$fees=$iteam['amount'];
// 	 $iteam['quarter']="Caution Money";
// 	 }else if($iteam['quarter']=='Quater1'){

// 	$fees=$iteam['amount'];
// 	 $iteam['quarter']="TUTION FEE (APRIL-JUNE)";

// 	  $rg=$this->Comman->findclassfee($students['class']['id'],$studentfees['acedmicyear']);
// 	  $lastdatemonth=date('Y-m-d',strtotime($rg['qu1_date']));
// 	 }else if($iteam['quarter']=='Quater2'){

// 	$fees=$iteam['amount'];
// 	 $iteam['quarter']="TUTION FEE (JULY-SEPTEMBER)";
// 	   $rg=$this->Comman->findclassfee($students['class']['id'],$studentfees['acedmicyear']);
// 	  $lastdatemonth=date('Y-m-d',strtotime($rg['qu2_date']));
// 	 }else if($iteam['quarter']=='Quater3'){

// 	$fees=$iteam['amount'];
// 	 $iteam['quarter']="TUTION FEE (OCTOBER-DECEMBER)";
// 	   $rg=$this->Comman->findclassfee($students['class']['id'],$studentfees['acedmicyear']);
// 	  $lastdatemonth=date('Y-m-d',strtotime($rg['qu3_date']));
// 	 }else if($iteam['quarter']=='Quater4'){

// 	$fees=$iteam['amount'];
// 	 $iteam['quarter']="TUTION FEE (JANUARY-MARCH)";
// 	   $rg=$this->Comman->findclassfee($students['class']['id'],$studentfees['acedmicyear']);
// 	  $lastdatemonth=date('Y-m-d',strtotime($rg['qu4_date']));
// 	 }else if($iteam['quarter']=='Miscellaneous Fee'){

// 	$fees=$iteam['amount'];
// 	 $iteam['quarter']="MISCELLANEOUS FEE";
// 	   $rg=$this->Comman->findclassfee($students['class']['id'],$studentfees['acedmicyear']);
// 	  $lastdatemonth=date('Y-m-d',strtotime($rg['qu1_date']));
// 	 }else if($iteam['quarter']){

// 	$fees=$iteam['amount'];

// 	   $rg=$this->Comman->findclassfee($students['class']['id'],$studentfees['acedmicyear']);
// 	  $lastdatemonth=date('Y-m-d',strtotime($rg['qu1_date']));
// 	 }else{

// 		 $fees=$iteam['amount'];
// 		 }



// $j+=$fees;
// if($fees){
// $html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:center;">'.$count++.'</td>
// <td style="line-height:17px; height:17px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;  '.$iteam['quarter'].'</td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">'.number_format($fees,2).'&nbsp; &nbsp; </td>
// </tr>';
// }
// }

// }

// }else{

// 		$fees=$studentfees['deposite_amt'];
// 	 $iteam['quarter']=$studentfees['quarter'];
// 	   $rg=$this->Comman->findclassfee($students['class']['id'],$studentfees['acedmicyear']);
// 	  $lastdatemonth=date('Y-m-d',strtotime($rg['qu1_date']));

// 	$j+=$fees;
// if($fees){
// $html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:center;">'.$count++.'</td>
// <td style="line-height:17px; height:17px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;  '.$iteam['quarter'].'</td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">'.number_format($fees,2).'&nbsp; &nbsp; </td>
// </tr>';
// }


// }



// $t=11;

// for ($x = $count; $x <= $t; $x++) {

// 	$html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
// <td style="line-height:17px; height:17px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
// </tr>';

// }

// $html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:right; border-top:1px solid #000;" colspan="2">Total Fees Rs.: &nbsp; &nbsp; </td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right; border-top:1px solid #000;">'.number_format($j,2).' &nbsp; &nbsp; </td>
// </tr>


// <tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:right;" colspan="2">(+) Late Fees Rs.: &nbsp; &nbsp; </td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp; &nbsp; </td>
// </tr>

// <tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Due Amount Rs.: &nbsp; &nbsp; </td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp; &nbsp; </td>
// </tr>';




// $discount_fees='0';
// $addtionaldiscount_fees='0';;
// $deposite_amt=$j;

// if($discount_fees>0){
// 	$netamount =$j/100*$discount_fees; $remain=$j-$netamount;
// 	$html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Discount: &nbsp; &nbsp; </td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">'.number_format($netamount,2).' &nbsp; &nbsp; </td>
// </tr>';


// }else{
// 	$remain=$j;
// 	$html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Discount: &nbsp; &nbsp; </td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp; &nbsp; </td>
// </tr>';




// }

// if($addtionaldiscount_fees>0 || $addtionaldiscount_fees!=0 ){

// $remain=$remain-$addtionaldiscount_fees;
// $html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Additonal Discount (if any): &nbsp; &nbsp; </td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">'.number_format($addtionaldiscount_fees,2).' &nbsp; &nbsp; </td>
// </tr>';

// }else{
// 	$html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:right;" colspan="2">(-) Additonal Discount (if any): &nbsp; &nbsp; </td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">0.00 &nbsp; &nbsp; </td>
// </tr>';


// }



// if($deposite_amt){

// 	$html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:right; font-weight:bold;" colspan="2">Net Deposited Rs.: &nbsp; &nbsp; </td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; font-weight:bold; text-align:right;">'.number_format($deposite_amt,2).' &nbsp; &nbsp;  </td>
// </tr>';
// $obj    = new toWords($deposite_amt);
// $w=$obj->words;




// }else if($remain!=''){
// $html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:right; font-weight:bold;" colspan="2">Net Deposited Rs.: &nbsp; &nbsp; </td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; font-weight:bold; text-align:right;">'.number_format($remain,2).' &nbsp; &nbsp;  </td>
// </tr>';
// $obj    = new toWords($remain);
// $w=$obj->words;
// }else{

// $html.='<tr style="font-size:12px;">
// <td style="line-height:17px; height:17px;border-left:1px solid #000; text-align:right; font-weight:bold;" colspan="2">Net Deposited Rs.: &nbsp; &nbsp; </td>
// <td style="line-height:17px; height:17px;border-left:1px solid #000; border-right:1px solid #000; font-weight:bold; text-align:right;">'.number_format($j,2).'&nbsp; &nbsp;  </td>
// </tr>';
// 	$obj    = new toWords($j);
// $w=$obj->words;

// }
// $html.='<tr>
// <td colspan="3" style="line-height:17px; height:17px;border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000;">&nbsp;
// '.$w.'
// </td>
// </tr>
// <tr>
// <td colspan="3" style="line-height:17px; height:17px;border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">';


// if($studentfees['mode']=='CHEQUE' ){
// $html.='&nbsp; <span>Paid by Chq.No.: '.$studentfees['cheque_no'].'
// Dt: '.date('d-m-Y',strtotime($studentfees['paydate'])).' && Bank Name : '.$studentfees['bank'].'<br></span>';
// }else if($studentfees['mode']=='DD'){
// $html.='&nbsp; <span>Paid by DD No.: '.$studentfees['cheque_no'].'
// Dt: '.date('d-m-Y',strtotime($studentfees['paydate'])).' && Bank Name : '.$studentfees['bank'].'<br></span>';



// }else if($studentfees['mode']=='NETBANKING'){
// $html.='&nbsp; <span>Paid by Netbanking Refrence No.:
// '.$studentfees['ref_no'].' Dt: '.date('d-m-Y',strtotime($studentfees['paydate'])).'<br></span>';



// }else if($studentfees['mode']=='Credit Card/Debit Card/UPI'){
// $html.='&nbsp; <span>Paid by Credit/Debit Card Refrence No.:
// '.$studentfees['ref_no'].' Dt: '.date('d-m-Y',strtotime($studentfees['paydate'])).'<br></span>';



// }else if($studentfees['mode']=='CASH'){
// $html.='&nbsp; <span>Paid by Cash Dt: '.date('d-m-Y',strtotime($studentfees['paydate'])).'<br></span>';



// }
// $html.='<span>&nbsp;&nbsp;Caution-Money Is Refundable In Principle On Prestantion Of Original Receipt. <br> &nbsp;Remarks: '.ucwords(strtolower($studentfees['remarks'])).'
// </span>
// </td>
// </tr>

// <tr>
// <td colspan="3" style="text-align:right;line-height:17px; height:17px;">
// </td></tr>
// <tr style="font-size:12px;">
// <td colspan="3" style="text-align:right;line-height:10px; height:14px;">';

// $nh="Reciever's Signature";

//  $html.=$nh.'&nbsp;  &nbsp;
// </td>
// </tr>
//  </table>
// </td>
// </tr>
// </table>
// </body>
// </html>';

// $pdf->writeHTML($html, true, 0, true, 0);
// }

// if($gid!=1){

// 	// force print dialog
// $js .= 'print(true);';

// // set javascript
// $pdf->IncludeJS($js);

// }

// ob_end_clean();
// $pdf->Output('Receipt.pdf');
// exit;
?>