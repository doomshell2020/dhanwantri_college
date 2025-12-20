<?php
class XTCPDF extends TCPDF {}

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
// $pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
$db = $this->request->session()->read('Auth.User.db');
if (!empty($sitesetting['address1']) || !empty($sitesetting['address2'])) {
    $address = $sitesetting['address1'] . ' ' . $sitesetting['address2'];
} else {
    $address = $sitesetting['address1'];
}
// pr($address);exit;
$mobile = $sitesetting['phone'];
$email = $sitesetting['email'];
$website = $sitesetting['website'];
$school_number = $sitesetting['phone'];

// pr($students['board']);exit;
if ($students['board']['logo']) {
    $logo  = $students['board']['logo'];
    $watermarklogo = $students['board']['transparent_logo'];
    $school_name = $students['board']['full_name'];
} else {
    $logo  = "images/" . $sitesetting['header_logo'];
    $school_name = $sitesetting['subtitle1'];
}

// pr($logo);exit;

// First image
$img_file_1 = $watermarklogo;
$pdf->Image($img_file_1, 7, 50, 140, 140, '', '', '', false, 80, '', false, false, 200);
// Second image 
$img_file_1 = $watermarklogo;
$pdf->Image($img_file_1, 148, 50, 140, 140, '', '', '', false, 80, '', false, false, 200);


$pdf->SetFont('', '', 8, '', 'true');
TCPDF_FONTS::addTTFfont('../Devanagari/Devanagari.ttf', 'TrueTypeUnicode', "", 32);

$html = '
<style>
 .bgimg {
    background-image: url("' . $watermarklogo . '");
    background-repeat: no-repeat;
    background-position: center;
}

img {
    max-width: 100%;
    height: auto;
    display: block;
    margin: 0 auto;
}
.glogo{
    padding: bottom 20px;
}
</style>

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
<td width="16%">
        <img src="' . $logo . '" alt="School Logo">
</td>


<td width="82%" style="color: #000; margin-top:0px; font-size: 13.5px; margin-bottom:0px; line-height: 12px; text-align: center; ">
    <b class="glogo"style="line-height: 17px;">' . $school_name . '</b><br>
    <span style="font-size: 12px;">' . $subtitle . '</span>
    <span style="font-size: 12px;">' . $subtitle . '</span>
    <span style="font-size: 8px;">' . $address . '</span><br>
    <span style="font-size: 9px;">' . $school_number . '</span>
 </td>

</tr>

<tr>

<td width="100%" style="color: #000; font-size: 19px; margin-bottom:0px; line-height: 9px; text-align: center; ">
    <span style="font-size: 9px;">Office Copy</span>
</td>

</tr>

</tbody>
</table>

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

<td width="25%" style="height:12px; line-height:12px;"><b>&nbsp; Receipt No.</b></td>
<td width="35%" style="height:12px; line-height:12px;">: ' . $studentfees['recipetno'] . '  </td>

<td width="10%" style="height:12px; line-height:12px;"><b>Date.</b></td>
<td width="30%" style="height:12px; line-height:12px;">: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '&nbsp;</td>
</tr>

<tr>

<td width="25%" style="height:12px; line-height:12px;"><b>&nbsp; Pupils Name.</b></td>
<td width="35%" style="height:12px; line-height:12px;">: ' . strtoupper(ucwords($students['fname'])) . ' ' . strtoupper(ucwords($students['middlename'])) . ' ' . strtoupper(ucwords($students['lname'])) . ' </td>


<td width="10%" style="height:12px; line-height:12px;"><b>Sr.No.</b></td>
<td width="30%" style="height:12px; line-height:12px;">: ' . $students['enroll'] . ' &nbsp;</td>

</tr>

<tr>

<td width="25%" style="height:12px; line-height:12px;"><b>&nbsp; Father/Mothers Name.</b></td>
<td width="35%" style="height:12px; line-height:12px;">: ' . strtoupper(ucwords($students['fathername'])) . '&nbsp; </td>


<td width="10%" style="height:12px; line-height:12px;"><b>Batch.</b></td>
<td width="30%" style="height:12px; line-height:12px;">: ' . $students['batch'] . ' &nbsp;</td>


</tr>


<tr>
<td width="25%" style="height:12px; line-height:12px;"><b>&nbsp; Course.</b></td>
<-- <td width="50%" style="height:12px; line-height:12px;">: ' . $students['class']['title'] . '-' . $students['section']['title'] . ' &nbsp;</td> -->
<td width="50%" style="height:12px; line-height:12px;">: ' . $students['class']['title'] . ' &nbsp;</td>
</tr>


</table>
</td>

</tr>
</table>
</td>
</tr>
</table>

<table width="100%" cellspacing="0" class="bgimg">
<tr>

<td width="7%" style="border:1px solid #000; height:15px; line-height:15px; text-align:center;">S.No.</td>
<td width="75%" style="border:1px solid #000; height:15px; line-height:15px; ">&nbsp; Particulars</td>
<td width="18%" style="border:1px solid #000; height:15px; line-height:15px; text-align:right;"> Amount &nbsp;&nbsp;</td>

</tr>';

// pr($students); die;

// pr( $subtitle );die;
$count = 1;
$fees = 0;
$j = 0;
$rtt = 0;
if ($studentfees['refrencepending'] == '0') {
    $quas = unserialize($studentfees['quarter']);
    // pr($quas);exit;
    $arr = array();
    $Previous_Year_Due1 = 0;
    foreach ($quas as $iteam['quarter'] => $iteam['amount']) {

        if ($iteam['quarter'] != 'Caution Money') {

            $collect = array('April' => 'April', 'May' => 'May', 'June' => 'June', 'July' => 'July', 'August' => 'August', 'September' => 'September', 'October' => 'October', 'November' => 'November', 'December' => 'December', 'January' => 'January', 'February' => 'February', 'March' => 'March');

            if ($iteam['quarter'] == 'Admission / Prosspectus') {

                // pr($rg['qu1_date']);die;
                $fees = $iteam['amount'];
                $iteam['quarter'] = "Admission / Prosspectus";
                $lastdatemonthw = date('M', strtotime($rg['qu1_date']));
            } else if ($iteam['quarter'] == 'Development Fee') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "Development Fee";
                $lastdatemonthw = date('M', strtotime($rg['qu1_date']));
            } else if ($iteam['quarter'] == 'Quater1') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "1st Year Tuition Fee";

                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
                // $lastdatemonthw = date('M', strtotime($rg['qu2_date'])); Backup 25/02/2022
                $lastdatemonthw = date('M', strtotime($rg['qu1_date'] . "+30 days"));
                // pr($lastdatemonthw);die;
            } else if ($iteam['quarter'] == 'Quater2') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "2nd Year Tuition Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu2_date']));
                // $lastdatemonthw = date('M', strtotime($rg['qu3_date'])); Backup 25/02/2022
                $lastdatemonthw = date('M', strtotime($rg['qu2_date'] . "+30 days"));
            } else if ($iteam['quarter'] == 'Quater3') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "3rd Year Tution Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu3_date']));
                // $lastdatemonthw = date('M', strtotime($rg['qu4_date'])); Backup 25/02/2022
                $lastdatemonthw = date('M', strtotime($rg['qu3_date'] . "+30 days"));
            } else if ($iteam['quarter'] == 'Quater4') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "4th Year Tuition Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu4_date']));

                $aee = ['17', '20', '22', '27'];
                if (!in_array($students['class_id'], $aee)) {
                    $lastdatemonthw = "Apr";
                }
            } else if ($iteam['quarter'] == 'Transport1') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "1st Year Transport Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));

                $aee = ['17', '20', '22', '27'];
                if (!in_array($students['class_id'], $aee)) {
                    $lastdatemonthw = "Apr";
                }
            } else if ($iteam['quarter'] == 'Transport2') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "2nd Year Transport Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu2_date']));
                // $lastdatemonthw = date('M', strtotime($rg['qu3_date'])); Backup 25/02/2022
                $lastdatemonthw = date('M', strtotime($rg['qu2_date'] . "+30 days"));
            } else if ($iteam['quarter'] == 'Transport3') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "3rd Year Transport Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu3_date']));
                // $lastdatemonthw = date('M', strtotime($rg['qu4_date'])); Backup 25/02/2022
                $lastdatemonthw = date('M', strtotime($rg['qu3_date'] . "+30 days"));
            } else if ($iteam['quarter'] == 'Transport4') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "4th Year Transport Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu4_date']));

                $aee = ['17', '20', '22', '27'];
                if (!in_array($students['class_id'], $aee)) {
                    $lastdatemonthw = "Apr";
                }
            } else  if (in_array($iteam['quarter'], $collect)) {

                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "Tuition Fee (" . $iteam['quarter'] . ")";

                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));

                $month_num = date("n", strtotime(trim($iteam['quarter'])));
                $lastdatemonthw = date("F", mktime(0, 0, 0, $month_num, 10));
            } else if ($iteam['quarter'] == 'Miscellaneous Fee') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "Miscellaneous Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
            } else if ($iteam['quarter']) {

                $iteam['quarter'] = str_replace('"', "", $iteam['quarter']);

                $findpending = $this->Comman->findpendingrefrencefee($iteam['quarter'], $iteam['amount']);

                if ($findpending) {
                    $iteam['quarter'] = "Pending Receipt (Reference No " . $findpending['recipetnos'] . ")";
                    $fees = $iteam['amount'];
                } else {
                    $Previous_Year_Due1 = 1;
                    $fees = $iteam['amount'];
                }
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                //  $lastdatemonth=date('Y-m-d',strtotime($rg['qu1_date']));
            } else {

                $fees = $iteam['amount'];
            }


            $j += $fees;

            if ($Previous_Year_Due1 == 1) {

                $forpreviouseyear1 = !empty($studentfees['previous_due_heads']) ? explode(', ', $studentfees['previous_due_heads']) : null;
                if ($forpreviouseyear1) {
                    foreach ($forpreviouseyear1 as $newkey => $headValue) {
                        $html .= '<tr>
                        <td width="7%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:center;">' . $count++ . '</td>
                        <td width="75%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp; ' . $headValue . ' </td>
                        <td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:right;">' . (($newkey == 0) ? number_format($fees, 2) : '&nbsp;') . '&nbsp;&nbsp; </td>
                        </tr>';
                    }
                } else {
                    $html .= '<tr>
                    <td width="7%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:center;">' . $count++ . '</td>
                    <td width="75%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp; ' . $iteam['quarter'] . ' </td>
                    <td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:right;">' . number_format($fees, 2) . '&nbsp;&nbsp; </td>
                    </tr>';
                }
            } else if ($fees) {

                $html .= '<tr>
            <td width="7%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:center;">' . $count++ . '</td>
            <td width="75%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp; ' . $iteam['quarter'] . ' </td>
            <td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:right;">' . number_format($fees, 2) . '&nbsp;&nbsp; </td>
            </tr>';
            }
        }
    }
} else {

    $fees = $studentfees['fee'];
    $iteam['quarter'] = $studentfees['quarter'];
    $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
    $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));

    $j += $fees;
    if ($fees) {
        $html .= '<tr>
       <td width="7%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp;' . $count++ . '</td>
       <td width="75%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp; ' . $iteam['quarter'] . ' </td>
       <td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:right;">' . number_format($fees, 2) . '&nbsp;</td>
       
       </tr>';
    }
}

$t = 11;

for ($x = $count; $x <= $t; $x++) {

    $html .= '<tr>
<td width="7%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp; </td>
<td width="75%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp;  </td>
<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:right;"> &nbsp;</td>

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
 <div style="height:5px; line-height:5px;padding-top: 5px;"> ';
if ($studentfees['mode'] == 'CHEQUE') {
    $html .= '&nbsp;Paid by Chq.No. : ' . $studentfees['cheque_no'] . '
Date: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . ' && Bank Name : ' . $studentfees['bank'] . '<br>';
} else if ($studentfees['mode'] == 'DD') {
    $html .= '&nbsp;Paid by DD No. : ' . $studentfees['cheque_no'] . '
Date: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . ' && Bank Name : ' . $studentfees['bank'] . '<br>';
} else if ($studentfees['mode'] == 'NETBANKING') {
    $html .= '&nbsp;Paid by Netbanking Refrence No.:
' . $studentfees['ref_no'] . ' Date: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '<br>';
} else if ($studentfees['mode'] == 'Credit Card/Debit Card/UPI') {
    $html .= '&nbsp;Paid by Credit/Debit Card/UPI Refrence No.:
' . $studentfees['ref_no'] . ' Date: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '<br>';
} else if ($studentfees['mode'] == 'CASH') {
    $html .= '&nbsp;Paid by Cash Date: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '';
}
$html .= '</div>
 <div style="height:5px; line-height:5px; padding-top:3px;">';

if ($rtt == '1') {
    $dateg = date('M', strtotime("+3 months", strtotime($lastdatemonth)));
} else {
    $html .= '&nbsp;&nbsp;Amount once deposited will not be refunded.';
}

$html .= '</div><div style="height:5px; line-height:8px;">&nbsp;<strong>Remarks:</strong>&nbsp;&nbsp;' .
    wordwrap(ucfirst(strtolower(utf8_encode($studentfees['remarks']))), 80, "<br>&nbsp;&nbsp;") .
    '</div>';
$html .= '<div style="height:5px; line-height:4px;"> </div>

</td>

</tr>
<tr>
<td width="50%" style="height:15px; line-height:15px; text-align:left; font-size:9px;">Username: ' . ucfirst($get_depositor_name['user_name']) . ' &nbsp;</td>
<td width="50%" style="height:15px; line-height:15px; text-align:right; font-size:9px;">Principal/Accountant Signature &nbsp;</td>

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
    <td width="16%">
        <img src="' . $logo . '" alt="School Logo">
    </td>
    <td width="82%" style="color: #000; margin-top:0px; font-size: 13.5px; margin-bottom:0px; line-height: 12px; text-align: center; ">
    <b class="glogo"style="line-height: 17px;">' . $school_name . '</b><br>
    <span style="font-size: 12px;">' . $subtitle . '</span>
    <span style="font-size: 12px;">' . $subtitle . '</span>
    <span style="font-size: 8px; padding-left:5px;">' . $address . '</span><br>
    <span style="font-size: 9px;">' . $school_number . '</span>
    </td>
</tr>

<tr>

<td width="100%" style="color: #000; font-size: 19px; margin-bottom:0px; line-height: 9px; text-align: center; ">
    <span style="font-size: 9px;">Student Copy</span>
</td>

</tr>


</tbody></table>
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

<td width="25%" style="height:12px; line-height:12px;"><b>&nbsp; Receipt No.</b></td>
<td width="35%" style="height:12px; line-height:12px;">: ' . $studentfees['recipetno'] . '  </td>

<td width="10%" style="height:12px; line-height:12px;"><b>Date.</b></td>
<td width="30%" style="height:12px; line-height:12px;">: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '&nbsp;</td>
</tr>

<tr>

<td width="25%" style="height:12px; line-height:12px;"><b>&nbsp; Pupils Name.</b></td>
<td width="35%" style="height:12px; line-height:12px;">: ' . strtoupper(ucwords($students['fname'])) . ' ' . strtoupper(ucwords($students['middlename'])) . ' ' . strtoupper(ucwords($students['lname'])) . ' </td>


<td width="10%" style="height:12px; line-height:12px;"><b>Sr.No.</b></td>
<td width="30%" style="height:12px; line-height:12px;">: ' . $students['enroll'] . ' &nbsp;</td>

</tr>

<tr>

<td width="25%" style="height:12px; line-height:12px;"><b>&nbsp; Father/Mothers Name.</b></td>
<td width="35%" style="height:12px; line-height:12px;">: ' . strtoupper(ucwords($students['fathername'])) . '&nbsp; </td>


<td width="10%" style="height:12px; line-height:12px;"><b>Batch.</b></td>
<td width="30%" style="height:12px; line-height:12px;">: ' . $students['batch'] . ' &nbsp;</td>


</tr>


<tr>
<td width="25%" style="height:12px; line-height:12px;"><b>&nbsp; Course.</b></td>
<-- <td width="50%" style="height:12px; line-height:12px;">: ' . $students['class']['title'] . '-' . $students['section']['title'] . ' &nbsp;</td> -->
<td width="50%" style="height:12px; line-height:12px;">: ' . $students['class']['title'] . ' &nbsp;</td>
</tr>


</table>
</td>

</tr>
</table>
</td>
</tr>
</table>

<table width="100%" cellspacing="0" class="bgimg">
<tr>

<td width="7%" style="border:1px solid #000; height:15px; line-height:15px; text-align:center;"> S.No.</td>
<td width="75%" style="border:1px solid #000; height:15px; line-height:15px; ">&nbsp; Particulars</td>
<td width="18%" style="border:1px solid #000; height:15px; line-height:15px; text-align:right;"> Amount &nbsp;</td>


</tr>';

$count = 1;
$fees = 0;
$j = 0;
$rtt = 0;
if ($studentfees['refrencepending'] == '0') {
    $quas = unserialize($studentfees['quarter']);

    $arr = array();
    $Previous_Year_Due = 0;
    foreach ($quas as $iteam['quarter'] => $iteam['amount']) {

        // pr($iteam);exit;

        if ($iteam['quarter'] != 'Caution Money') {

            $collect = array('April' => 'April', 'May' => 'May', 'June' => 'June', 'July' => 'July', 'August' => 'August', 'September' => 'September', 'October' => 'October', 'November' => 'November', 'December' => 'December', 'January' => 'January', 'February' => 'February', 'March' => 'March');

            if ($iteam['quarter'] == 'Admission / Prosspectus') {

                // pr($rg['qu1_date']);die;
                $fees = $iteam['amount'];
                $iteam['quarter'] = "Admission / Prosspectus";
                $lastdatemonthw = date('M', strtotime($rg['qu1_date']));
            } else if ($iteam['quarter'] == 'Development Fee') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "Development Fee";
                $lastdatemonthw = date('M', strtotime($rg['qu1_date']));
            } else if ($iteam['quarter'] == 'Quater1') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "1st Year Tuition Fee";

                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
                // $lastdatemonthw = date('M', strtotime($rg['qu2_date'])); Backup 25/02/2022
                $lastdatemonthw = date('M', strtotime($rg['qu1_date'] . "+30 days"));
                // pr($lastdatemonthw);die;
            } else if ($iteam['quarter'] == 'Quater2') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "2nd Year Tuition Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu2_date']));
                // $lastdatemonthw = date('M', strtotime($rg['qu3_date'])); Backup 25/02/2022
                $lastdatemonthw = date('M', strtotime($rg['qu2_date'] . "+30 days"));
            } else if ($iteam['quarter'] == 'Quater3') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "3rd Year Tuition Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu3_date']));
                // $lastdatemonthw = date('M', strtotime($rg['qu4_date'])); Backup 25/02/2022
                $lastdatemonthw = date('M', strtotime($rg['qu3_date'] . "+30 days"));
            } else if ($iteam['quarter'] == 'Quater4') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "4th Year Tuition Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu4_date']));

                $aee = ['17', '20', '22', '27'];
                if (!in_array($students['class_id'], $aee)) {
                    $lastdatemonthw = "Apr";
                }
            } else if ($iteam['quarter'] == 'Transport1') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "1st Year Transport Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));

                $aee = ['17', '20', '22', '27'];
                if (!in_array($students['class_id'], $aee)) {
                    $lastdatemonthw = "Apr";
                }
            } else if ($iteam['quarter'] == 'Transport2') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "2nd Year Transport Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu2_date']));
                // $lastdatemonthw = date('M', strtotime($rg['qu3_date'])); Backup 25/02/2022
                $lastdatemonthw = date('M', strtotime($rg['qu3_date'] . "+30 days"));
            } else if ($iteam['quarter'] == 'Transport3') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "3rd Year Transport Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu3_date']));
                // $lastdatemonthw = date('M', strtotime($rg['qu4_date'])); Backup 25/02/2022
                $lastdatemonthw = date('M', strtotime($rg['qu4_date'] . "+30 days"));
            } else if ($iteam['quarter'] == 'Transport4') {
                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "4rt Year Transport Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu4_date']));

                $aee = ['17', '20', '22', '27'];
                if (!in_array($students['class_id'], $aee)) {
                    $lastdatemonthw = "Apr";
                }
            } else  if (in_array($iteam['quarter'], $collect)) {

                $rtt = '1';
                $fees = $iteam['amount'];
                $iteam['quarter'] = "Tuition Fee (" . $iteam['quarter'] . ")";

                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));

                $month_num = date("n", strtotime(trim($iteam['quarter'])));
                $lastdatemonthw = date("F", mktime(0, 0, 0, $month_num, 10));
            } else if ($iteam['quarter'] == 'Miscellaneous Fee') {

                $fees = $iteam['amount'];
                $iteam['quarter'] = "Miscellaneous Fee";
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));
            } else if ($iteam['quarter']) {
                $iteam['quarter'] = str_replace('"', "", $iteam['quarter']);
                $findpending = $this->Comman->findpendingrefrencefee($iteam['quarter'], $iteam['amount']);

                if ($findpending) {
                    $iteam['quarter'] = "Pending Receipt (Reference No " . $findpending['recipetnos'] . ")";
                    $fees = $iteam['amount'];
                } else {
                    $Previous_Year_Due = 1;
                    $fees = $iteam['amount'];
                }
                $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
                //  $lastdatemonth=date('Y-m-d',strtotime($rg['qu1_date']));
            } else {
                $fees = $iteam['amount'];
            }

            $j += $fees;
            if ($Previous_Year_Due == 1) {

                $forpreviouseyear = !empty($studentfees['previous_due_heads']) ? explode(', ', $studentfees['previous_due_heads']) : null;
                if ($forpreviouseyear1) {
                    foreach ($forpreviouseyear as $newkey => $headValue) {
                        $html .= '<tr>
                    <td width="7%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:center;">' . $count++ . '</td>
                    <td width="75%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp; ' . $headValue . ' </td>
                    <td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:right;">' . (($newkey == 0) ? number_format($fees, 2) : '&nbsp;') . '&nbsp;&nbsp; </td>
                    </tr>';
                    }
                } else {
                    $html .= '<tr>
                <td width="7%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:center;">' . $count++ . '</td>
                <td width="75%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp; ' . $iteam['quarter'] . ' </td>
                <td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:right;">' . number_format($fees, 2) . '&nbsp;&nbsp; </td>
                </tr>';
                }
            } else if ($fees) {
                $html .= '<tr>
            <td width="7%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:center;">' . $count++ . '</td>
            <td width="75%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp; ' . $iteam['quarter'] . ' </td>
            <td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:right;">' . number_format($fees, 2) . '&nbsp;&nbsp; </td>
            </tr>';
            }
        }
    }
} else {

    $fees = $studentfees['fee'];
    $iteam['quarter'] = $studentfees['quarter'];
    $rg = $this->Comman->findclassfee($students['class']['id'], $studentfees['acedmicyear']);
    $lastdatemonth = date('Y-m-d', strtotime($rg['qu1_date']));

    $j += $fees;
    if ($fees) {
        $html .= '<tr>
       <td width="7%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp;' . $count++ . '</td>
       <td width="75%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp; ' . $iteam['quarter'] . ' </td>
       <td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:right;">' . number_format($fees, 2) . '&nbsp;</td>
       
       </tr>';
    }
}

$t = 11;

for ($x = $count; $x <= $t; $x++) {

    $html .= '<tr>
<td width="7%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp; </td>
<td width="75%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px;">&nbsp;  </td>
<td width="18%" style=" border-left:1px solid #000; border-right:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; text-align:right;"> &nbsp;</td>

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
 <div style="height:5px; line-height:5px;padding-top: 5px;"> ';
if ($studentfees['mode'] == 'CHEQUE') {
    $html .= '&nbsp;Paid by Chq.No. : ' . $studentfees['cheque_no'] . '
Date: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . ' && Bank Name : ' . $studentfees['bank'] . '<br>';
} else if ($studentfees['mode'] == 'DD') {
    $html .= '&nbsp;Paid by DD No. : ' . $studentfees['cheque_no'] . '
Date: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . ' && Bank Name : ' . $studentfees['bank'] . '<br>';
} else if ($studentfees['mode'] == 'NETBANKING') {
    $html .= '&nbsp;Paid by Netbanking Refrence No.:
' . $studentfees['ref_no'] . ' Date: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '<br>';
} else if ($studentfees['mode'] == 'Credit Card/Debit Card/UPI') {
    $html .= '&nbsp;Paid by Credit/Debit Card/UPI Refrence No.:
' . $studentfees['ref_no'] . ' Date: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '<br>';
} else if ($studentfees['mode'] == 'CASH') {
    $html .= '&nbsp;Paid by Cash Date: ' . date('d-m-Y', strtotime($studentfees['paydate'])) . '';
}
$html .= '</div>
 <div style="height:5px; line-height:5px; padding-top:3px;">';

if ($rtt == '1') {
    $dateg = date('M', strtotime("+3 months", strtotime($lastdatemonth)));
} else {
    $html .= '&nbsp;&nbsp;Amount once deposited will not be refunded.';
}

$html .= '</div><div style="height:5px; line-height:7px;">&nbsp;<strong>Remarks:</strong>&nbsp;&nbsp;' .
    wordwrap(ucfirst(strtolower(utf8_encode($studentfees['remarks']))), 80, "<br>&nbsp;&nbsp;") .
    '</div>';
$html .= '<div style="height:5px; line-height:4px;"> </div>

</td>

</tr>


<tr>
<td width="50%" style="height:15px; line-height:15px; text-align:left; font-size:9px;">Username: ' . ucfirst($get_depositor_name['user_name']) . ' &nbsp;</td>
<td width="50%" style="height:15px; line-height:15px; text-align:right; font-size:9px;">Principal/Accountant Signature &nbsp;</td>
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
// pr($html);
// die;
$pdf->writeHTMLCell(0, 0, '', '', utf8_encode($html), 0, 1, 0, true, '', true);

ob_clean();

$pdf->Output('' . strtoupper(ucwords($students['fname'])) . ' ' . strtoupper(ucwords($students['middlename'])) . ' ' . strtoupper(ucwords($students['lname'])) . '-' . $students['class']['title'] . '-' . $students['section']['title'] . '.pdf');
exit;
