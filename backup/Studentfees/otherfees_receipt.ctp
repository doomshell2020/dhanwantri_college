<?php 
class xtcpdf extends TCPDF {
}
 
define("MAJOR", 'Rupees Only');
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
        $strform = number_format($amount,2);
        $right_of_decimal = (int)substr($strform, strpos($strform,'.')+1);
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
        if ($na{0} != 0)
            $res = ' ' . $this->units[$na{0}] . ' Hundred';
        if (($na{1} == '0') && ($na{2} == '0'))
            return $res . ' ' . $this->mag[$this->magind];
        $res .= $res == '' ? '' : ' And';
        $t = (int) $na{1};
        $u = (int) $na{2};
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

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 1);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('', '', 7, '', 'false');

$pdf->SetMargins(5, 2, 5, true);

// add a page
//$pdf->AddPage('P', 'A5');
if($recipt['status']=='N'){

    // -- set new background ---
    
    // get the current page break margin
    $bMargin = $pdf->getBreakMargin();
    // get current auto-page-break mode
    $auto_page_break = $pdf->getAutoPageBreak();
    // disable auto-page-break
    $pdf->SetAutoPageBreak(false, 0);
    // set bacground image
    $img_file = WWW_ROOT.'images/cancelled.png';
    
    $pdf->Image($img_file, 45, 80, 70, 70, '', '', '', false, 300, '', false, false, 0);
    // restore auto-page-break status
    $pdf->SetAutoPageBreak($auto_page_break, $bMargin);
    // set the starting point for the page content
    $pdf->setPageMark();
    }

for($i=0;$i<2;$i++){
	
    $pdf->AddPage('P', 'A5');
    $temp = str_replace(array('{logo}', '{sitetitle}','{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}'), array($sitesetting['logo'], $sitesetting['sitetitle'],$sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website']), $det['template']);
	
$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';

$html.='</head>
<body>';
$html.=$temp;
$html.='<br><br>
<table width="100%" cellspacing="1">
<tr>
<th colspan="4" style=" line-height:17px;font-weight:bold; text-align:center; font-size:15px; border-top:1px solid #000; border-bottom:1px solid #000; border-left:1px solid #000; border-right:1px solid #000; " height="25px">
<strong>RECEIPT SESSION: '.$recipt['academicyear'].'</strong>
</th>
</tr>
<tr style="font-size:12px;">
<td width="20%" style=" line-height:19px; height:19px;border-left:1px solid #000;">&nbsp; Receipt No.</td>
<td width="40%" style="line-height:19px; height:19px;">:&nbsp; '.$recipt['receipt_no'].'</td>
<td width="12%" style="line-height:19px; height:19px;">Date</td>
<td width="28%" style="line-height:19px; height:19px;border-right:1px solid #000;">:&nbsp; '.date('d-m-Y',strtotime($recipt['paydate'])).'&nbsp;</td>
</tr>
<tr style="font-size:12px;">
<td width="20%" style="line-height:19px; height:19px;border-left:1px solid #000;">&nbsp;&nbsp;Name</td>
<td width="40%" style="line-height:19px;height:19px;font-size:11px;">:&nbsp; '.strtoupper(ucwords($recipt['parentsname'])).'</td>
<td width="12%" style="line-height:19px; height:19px;">Class:</td>
<td width="28%" style="line-height:19px; height:19px;border-right:1px solid #000;">:&nbsp; '.$c_id.'</td>
</tr>
<tr style="font-size:12px;">';
$n="&nbsp;Pupil's Name";
if (isset($recipt['s_id']) && !empty($recipt['s_id'])) {$s_no = $recipt['s_id'];} else { $s_no = "--";}
$html .= '<td width="20%" style="border-left:1px solid #000;line-height:19px; height:19px;">&nbsp;' . $n . ' </td>
<td width="40%" style="text-transform:uppercase;line-height:19px; height:19px;">:&nbsp;&nbsp;' . strtoupper(ucwords($recipt['pupilname'])) . '</td>
<td width="12%" style="line-height:19px; height:19px;">Sr.No.</td>
<td width="28%" style="border-right:1px solid #000;line-height:19px; height:19px;">:&nbsp;&nbsp;' . $s_no . '</td>
</tr>
<tr style="font-size:12px;">
<td colspan="4" style="padding:0px;">
<table cellspacing="0" width="100%">
<tr style="font-size:12px;">
<td width="8%" style="line-height:19px; text-align:center;height:19px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000;">&nbsp; S.No.</td>
<td width="64%"  style="line-height:19px; text-align:left; height:19px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000;">&nbsp; Particulars</td>
<td width="28%"  style="line-height:19px; text-align:right; height:19px;border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; text-align:right;">Amount &nbsp; &nbsp; </td>
</tr>';

$html.='<tr style="font-size:12px;">
<td style="line-height:19px; height:19px;border-left:1px solid #000; text-align:center;">1.</td>
<td style="line-height:19px; height:19px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;'.$recipt['title'].'</td>
<td style="line-height:19px; height:19px;border-left:1px solid #000; border-right:1px solid #000; text-align:right;">'.number_format($recipt['amount'],2).'&nbsp; &nbsp; </td>
</tr>'; 
$t=13;
	
for($x = $count; $x <= $t; $x++) {
	
	$html.='<tr style="font-size:12px;">
<td style="line-height:19px; height:19px;border-left:1px solid #000; text-align:center;">&nbsp;</td>
<td style="line-height:19px; height:19px;text-transform:uppercase; border-left:1px solid #000;">&nbsp;</td>
<td style="line-height:19px; height:19px;border-left:1px solid #000; border-right:1px solid #000;">&nbsp;</td>
</tr>';
	
}

$html.='<tr style="font-size:12px;">
<td style="line-height:19px; height:19px;border-left:1px solid #000; text-align:right; font-weight:bold;border-top:1px solid #000;" colspan="2">(-) Discount: &nbsp; &nbsp; </td>
<td style="line-height:19px; height:19px;border-left:1px solid #000; border-right:1px solid #000;border-top:1px solid #000; font-weight:bold; text-align:right;">'.number_format($recipt['discount'],2).'&nbsp; &nbsp;  </td>
</tr>';	
$html.='<tr style="font-size:12px;">
<td style="line-height:19px; height:19px;border-left:1px solid #000; text-align:right; font-weight:bold;" colspan="2">Net Deposited Rs.: &nbsp; &nbsp; </td>
<td style="line-height:19px; height:19px;border-left:1px solid #000; border-right:1px solid #000; font-weight:bold; text-align:right;">'.number_format($recipt['total'],2).'&nbsp; &nbsp;  </td>
</tr>';	
		$obj    = new toWords($recipt['total']);
$w=$obj->words;

$html.='<tr>
<td colspan="3" style="line-height:20px; height:20px;border-top:1px solid #000; border-left:1px solid #000; border-right:1px solid #000;">&nbsp;&nbsp;In Words:  
'.$w.'
</td>
</tr>
<tr>
<td colspan="3" style="line-height:20px; height:20px; border-left:1px solid #000; border-right:1px solid #000;">';

if($recipt['mode']=='CHEQUE' ){ 
$html.='&nbsp; <span>Paid by Chq.No.: '.$recipt['cheque_no'].' 
Dt: '.date('d-m-Y',strtotime($recipt['paydate'])).' '.$recipt['bank_id'].'</span>';
}else if($recipt['mode']=='DD'){
$html.='&nbsp; <span>Paid by DD No.: '.$recipt['cheque_no'].' 
Dt: '.date('d-m-Y',strtotime($recipt['paydate'])).' '.$recipt['bank_id'].'</span>';	
	
	
	
}else if($recipt['mode']=='NETBANKING'){
$html.='&nbsp; <span>Paid by Netbanking Refrence No.: 
'.$recipt['ref_no'].' Dt: '.date('d-m-Y',strtotime($recipt['paydate'])).'</span>';	
	
	
	
}else if($recipt['mode']=='CREDIT CARD/DEBIT CARD'){
$html.='&nbsp; <span>Paid by Credit/Debit Card Refrence No.: 
'.$recipt['ref_no'].' Dt: '.date('d-m-Y',strtotime($recipt['paydate'])).'</span>';	
	
	
	
}else if($recipt['mode']=='CASH'){
$html.='&nbsp; <span>Paid by Cash Dt: '.date('d-m-Y',strtotime($recipt['paydate'])).'</span>';	
	
	
	
}
$html.='</td></tr><tr><td colspan="3" style="line-height:20px; height:20px; border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">
<span>&nbsp;&nbsp;Remarks: '.$recipt['remarks'].'
</span>
</td>
</tr>
<tr><td>&nbsp;</td></tr>';
$html.='<tr style="font-size:12px;">
<td colspan="3" style="text-align:right;line-height:19px; height:19px;">';

$nh="Reciever's Signature";

 $html.=$nh.'&nbsp;  &nbsp; 
</td>
</tr>
 </table>
 </td>
 </tr>
 </table>
</body>
</html>';
// echo $html; die;
$pdf->writeHTML($html, true, 0, true, 0);
//ob_end_clean();
}
// write some JavaScript code
// force print dialog
$js .= 'print(true);';

// set javascript
$pdf->IncludeJS($js);
$pdf->Output('ProspectusReceipt.pdf');
exit;
?>
