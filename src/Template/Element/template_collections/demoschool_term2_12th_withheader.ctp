<?php
class xtcpdf extends TCPDF
{
}
$this->set('pdf', new TCPDF('L', 'mm', 'A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

foreach ($studentsj as $f => $students) {
    // if (!empty($s_id) && $students['stud_id'] != $s_id) {
    // 	continue;
    // }

    if ($students['marks'] == '0' || $students['marks'] == '0.00') {
        //pr('if');die;
        continue;
    }

    $pdf->AddPage();
    $html .= '
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Result</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


$html .= '</head>
<body style="font-family:"Times New Roman", Times, serif">
<br><br><br><br><br><br> <br><br> <br>

<td colspan="5" align="center">
<h2 style="font-weight:bold; font-size:18px;">
<span style="font-size:20px; display:inline-block;"> REPORT CARD</span><br>   
 SESSION ' . $rolepresentyear . '
</h2>
</td>

<table width="100%">
<br><br>
<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">Student Profile:</h2></td>
</tr>
</table>
<table width="100%">
<tr>
<td width="100%" style="border-top:1px solid #000; border-left:1px solid #000;  border-bottom:1px solid #000; border-right:1px solid #000;">
<table width="100%" style="font-size:11px;">
<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase; font-weight:bold; border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; ';
    $studentn = "Student's Name";

    $fhosue = $this->Comman->findhouse($students['student']['h_id']);
    $classt = $this->Comman->findclass($students['class_id']);
    $sect = $this->Comman->findsectionsss($students['sect_id']);
    $html .= $studentn . '
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%">
&nbsp; ' . ucwords(strtolower($students['student']['fname'])) . '&nbsp;' . ucwords(strtolower($students['student']['middlename'])) . '&nbsp;' . ucwords(strtolower($students['student']['lname'])) . '
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; Class / House
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase; border-bottom:1px solid #a8a8a8;  " width="30%">
&nbsp; ' . $classt['title'] . '- ' . $sect['title'] . ' / ' . $fhosue['name'] . '
</td>

</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; ';
    $studentn = "Father's Name";
    $html .= $studentn . ' 
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="30%">
&nbsp; ' . ucwords(strtolower($students['student']['fathername'])) . '
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8; border-bottom:1px solid #a8a8a8;" width="20%">
&nbsp; Date of Birth
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-bottom:1px solid #a8a8a8; " width="30%">
&nbsp; ' . date('d-m-Y', strtotime($students['student']['dob'])) . '
</td>


</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8;" width="20%">
&nbsp; ';
    $studentn = "Mother's Name";
    $html .= $studentn . '
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;  border-right:1px solid #a8a8a8;" width="30%">
&nbsp; ' . ucwords(strtolower($students['student']['mothername'])) . '
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;  border-right:1px solid #a8a8a8;" width="20%">
&nbsp; Admission No.
</td>

<td style="height:20px; line-height:20px; line-height:15px; text-transform:uppercase;  border-right:1px solid #000" width="30%">
&nbsp; ' . $students['student']['enroll'] . '
</td>
</tr>
</table>

</td>

</tr>

</table>

<br><br>
<table width="100%">
<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">Scholastic Areas:</h2></td>
</tr>
</table>
<table width="100%" >';

    $findroleexamtype1 = $this->Comman->findexamtypesclass($students['class_id'], 1);

    $html .= '<tr style="font-size:11px;"><td width="19%" style="border-top:1px solid #000; border-left:1px solid #000;  height:32px; line-height:32px;  border-right:1px solid #000; text-align:center;  font-weight:bold; " align="center">&nbsp; Subject</td>';
    $cbg = 0;
    foreach ($findroleexamtype1 as $key => $item) {

        $html .= '<td width="10%" style="border-top:1px solid #000; height:16px; line-height:16px;  font-weight:bold;  border-right:1px solid #000;  text-align:center;" align="center">' . $item['examprint'] . '<br>(' . $item['maxnumber'] . ')</td>';
        $cbg += $item['maxnumber'];
    }



    $html .= '<td width="10%" style="border-top:1px solid #000; height:16px; line-height:16px;  font-weight:bold;  border-right:1px solid #000;  text-align:center;" align="center">Term I<br>(' . $cbg . ')</td>';
    $findroleexamtype2 = $this->Comman->findexamtypesclass($students['class_id'], 2);

    $cbg2 = 0;
    foreach ($findroleexamtype2 as $key => $item) {

        $html .= '<td width="10%" style="border-top:1px solid #000; height:16px; line-height:16px;  font-weight:bold;  border-right:1px solid #000;  text-align:center;" align="center">' . $item['examprint'] . '<br>(' . $item['maxnumber'] . ')</td>';
        $cbg2 += $item['maxnumber'];
    }
    $total = $cbg2 + $cbg;

    $html .= '<td width="10%" style="border-top:1px solid #000; height:16px; line-height:16px;  font-weight:bold; border-right:1px solid #000; text-align:center;">Term II<br>(' . $cbg2 . ')</td>
<td width="11%" style="border-top:1px solid #000; height:16px; line-height:16px;  font-weight:bold; border-right:1px solid #000; text-align:center;">Final<br>(' . $total . ')</td>
<td width="10%" style="border-top:1px solid #000; height:32px; line-height:32px;  font-weight:bold; border-right:1px solid #000; text-align:center;">Grade</td>
</tr>';
$subject=$this->Comman->find_examsubjectsnnupdated($students['class_id'],$students['student']['enroll']); 
    $subjectcnt = 0;
    foreach ($subject as $key => $name) {
        // pr($name);

        $subjectcnt++;

        $html .= '<tr style="font-size:12px;"> 
        <td width="19%" style="border-top:1px solid #000;border-bottom:1px solid #000; border-left:1px solid 
        #000; height:15px; line-height:15px; border-right:1px solid #000; " 
        align="center">&nbsp; ' . $name['exprint'] . '</td>';


        $findroleexamtype = $this->Comman->findeexamtsype3s($students['sect_id'], $students['class_id'], 1);
        $ter = 0;
        foreach ($findroleexamtype as $er) {

            $newmarks = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $er['etype_id'], $name['id'], 1);
            if ($newmarks['marks'] != '') {
                $html .= '<td width="10%"  style="border-top:1px solid #000;  border-right:1px solid 
			#000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
			align="center">' . sprintf('%.0f', $newmarks['marks']) . '</td>';
                $ter += $newmarks['marks'];
            } else {
                $html .= '<td width="10%"  style="border-top:1px solid #000;  border-right:1px solid 
			 #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
			 align="center">--</td>';
            }
        }

        $html .= '<td width="10%"  style="border-top:1px solid #000;  border-right:1px solid 
        #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
        align="center">' . $ter . '</td>';

        $findroleexamtype2 = $this->Comman->findeexamtsype3s($students['sect_id'], $students['class_id'], 2);
        $ter2 = 0;
        $ter3 = 0;
        foreach ($findroleexamtype2 as $er) {

            $newmarks = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $er['etype_id'], $name['id'], 2);

            if ($newmarks['marks'] != '') {


                $html .= '<td width="10%"  style="border-top:1px solid #000;  border-right:1px solid 
			#000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
			align="center">' . sprintf('%.0f', $newmarks['marks']) . '</td>';

                $ter2 += $newmarks['marks'];
            } else {
                $html .= '<td width="10%"  style="border-top:1px solid #000;  border-right:1px solid 
			 #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
			 align="center">--</td>';
            }
        }

        $html .= '<td width="10%"  style="border-top:1px solid #000;  border-right:1px solid 
        #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
        align="center">' . $ter2 . '</td>';

      
        $ter3 = $ter + $ter2;
        $html .= '<td width="11%"  style="border-top:1px solid #000;  border-right:1px solid 
        #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
        align="center">' . $ter3 . '</td>';
        $grades = 0;
        $ss = "";
        if ($ter3 != 0) {
            $grades = $ter3 * 100 / 100;

            if ($grades > 90 && $grades < 101)
            $sss = "A1";
        elseif ($grades == 90)
            $sss = "A2";
        elseif ($grades > 80  && $grades < 90)
            $sss = "A2";
        elseif ($grades == 80)
            $sss = "B1";
        elseif ($grades > 70  && $grades < 80)
            $sss = "B1";
        elseif ($grades == 70)
            $sss = "B2";
        elseif ($grades > 60 && $grades < 70)
            $sss = "B2";
        elseif ($grades == 60)
            $sss = "C1";
        elseif ($grades > 50  &&  $grades < 60)
            $sss = "C1";
        elseif ($grades == 50)
            $sss = "C2";
        elseif ($grades > 40 && $grades < 50)
            $sss = "C2";
        elseif ($grades == 40)
            $sss = "D";
        elseif ($grades > 32 && $grades < 40)
            $sss = "D";
        elseif ($grades == 32)
            $sss = "E";
        elseif ($grades > 20 && $grades < 32)
            $sss = "E";
        elseif ($grades == 20)
            $sss = "E";
        elseif ($grades >= 0 && $grades < 20)
            $sss = "E";
         
        }
        $html .= '<td width="10%"  style="border-top:1px solid #000;  border-right:1px solid 
        #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
        align="center">' . $sss . '</td>';

        $html .= '</tr>';
    }
    // exit;

    $html .= '<tr>
<td width="19%" style="border-top:1px solid #000; border-right:1px solid 
#000; border-left:1px solid 
#000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">TOTAL</td>';
    $totalgrand1 = 0;
    $totalgrand2 = 0;
    $iiExam = 1;
    foreach ($findroleexamtype1 as $key => $item) {
        $gtotal = 0;
        foreach ($subject as $key => $name) {

            $newmarks = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $item['id'], $name['id'], 1);
            if ($newmarks['marks'] != '') {
                $gtotal += $newmarks['marks'];
            } else {
            }
        }

        $grades = 0;
        $sss = '';
        if ($gtotal != 0) {
            $totalgrand1 += number_format($gtotal);
            $subjectotal = 0;
                if($iiExam == 1){
                    $subjectotal = $subjectcnt * 40;
                    //$subjectotal = $subjectcnt * $item['maxnumber'];
                }else{
                    if($students['class_id'] ==13){
                        //commmerce
                        $subjectotal = 65;
                    }else if($students['class_id'] ==15){
                        //arts
                        $subjectotal = 55;
                    }else{
                        //science
                        $subjectotal = 70;
                    }
                   
                  //  $subjectotal = $subjectcnt * $item['maxnumber'];
                }
            //echo $subjectotal;
            $grades = $gtotal * 100 / $subjectotal;

            if ($grades > 90 && $grades < 101)
                $sss = "A1";
            elseif ($grades == 90)
                $sss = "A2";
            elseif ($grades > 80  && $grades < 90)
                $sss = "A2";
            elseif ($grades == 80)
                $sss = "B1";
            elseif ($grades > 70  && $grades < 80)
                $sss = "B1";
            elseif ($grades == 70)
                $sss = "B2";
            elseif ($grades > 60 && $grades < 70)
                $sss = "B2";
            elseif ($grades == 60)
                $sss = "C1";
            elseif ($grades > 50  &&  $grades < 60)
                $sss = "C1";
            elseif ($grades == 50)
                $sss = "C2";
            elseif ($grades > 40 && $grades < 50)
                $sss = "C2";
            elseif ($grades == 40)
                $sss = "D";
            elseif ($grades > 32 && $grades < 40)
                $sss = "D";
            elseif ($grades == 32)
                $sss = "E";
            elseif ($grades > 20 && $grades < 32)
                $sss = "E";
            elseif ($grades == 20)
                $sss = "E";
            elseif ($grades >= 0 && $grades < 20)
                $sss = "E";
        }

        $html .= '<td width="10%" style="border-top:1px solid #000; border-right:1px solid 
        #000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">' . $gtotal . ' ' . $sss . ' </td>';
        $iiExam++;   }


    $grades1 = 0;
    $ssss = '';
    if ($totalgrand1 != 0) {
        $subjectotal1 = 0;
        $subjectotal1 = $subjectcnt * 50;
        //echo $subjectotal;
        $grades1 = $totalgrand1 * 100 / $subjectotal1;
        if ($grades1 > 90 && $grades1 < 101)
            $ssss = "A1";
        elseif ($grades1 == 90)
            $ssss = "A2";
        elseif ($grades1 > 80  && $grades1 < 90)
            $ssss = "A2";
        elseif ($grades1 == 80)
            $ssss = "B1";
        elseif ($grades1 > 70  && $grades1 < 80)
            $ssss = "B1";
        elseif ($grades1 == 70)
            $ssss = "B2";
        elseif ($grades1 > 60 && $grades1 < 70)
            $ssss = "B2";
        elseif ($grades1 == 60)
            $ssss = "C1";
        elseif ($grades1 > 50  &&  $grades1 < 60)
            $ssss = "C1";
        elseif ($grades1 == 50)
            $ssss = "C2";
        elseif ($grades1 > 40 && $grades1 < 50)
            $ssss = "C2";
        elseif ($grades1 == 40)
            $ssss = "D";
        elseif ($grades1 > 32 && $grades1 < 40)
            $ssss = "D";
        elseif ($grades1 == 32)
            $ssss = "E";
        elseif ($grades1 > 20 && $grades1 < 32)
            $ssss = "E";
        elseif ($grades1 == 20)
            $ssss = "E";
        elseif ($grades1 >= 0 && $grades1 < 20)
            $ssss = "E";
    }


    $html .= '<td width="10%" style="border-top:1px solid #000; border-right:1px solid 
    #000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">' . $totalgrand1 . ' ' . $ssss . ' </td>';

    $findroleexamtype2s = $this->Comman->findexamtypesclass($students['class_id'], 2);
    $iiExam = 1;
    foreach ($findroleexamtype2s as $k => $item) {
        $gtotals = 0;
        foreach ($subject as $key => $name) {

            $newmarks = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $item['id'], $name['id'], 2);
            if ($newmarks['marks'] != '') {


                $gtotals += $newmarks['marks'];
            } else {
            }
        }

        $grades = 0;
        $sss = '';
        if ($gtotals != 0) {
            $totalgrand2 += number_format($gtotals);
            $subjectotal = 0;
            if($iiExam == 1){

                $subjectotal = $subjectcnt * 40;
            }else{
                if($students['class_id'] ==13){
                    //commmerce
                    $subjectotal = 65;
                }else if($students['class_id'] ==15){
                    //arts
                    $subjectotal = 55;
                }else{
                    //science
                    $subjectotal = 70;
                }
            }
            //$subjectotal = $subjectcnt * $item['maxnumber'];

            //echo $subjectotal;
            $grades = $gtotals * 100 / $subjectotal;
            if ($grades > 90 && $grades < 101)
                $sss = "A1";
            elseif ($grades == 90)
                $sss = "A2";
            elseif ($grades > 80  && $grades < 90)
                $sss = "A2";
            elseif ($grades == 80)
                $sss = "B1";
            elseif ($grades > 70  && $grades < 80)
                $sss = "B1";
            elseif ($grades == 70)
                $sss = "B2";
            elseif ($grades > 60 && $grades < 70)
                $sss = "B2";
            elseif ($grades == 60)
                $sss = "C1";
            elseif ($grades > 50  &&  $grades < 60)
                $sss = "C1";
            elseif ($grades == 50)
                $sss = "C2";
            elseif ($grades > 40 && $grades < 50)
                $sss = "C2";
            elseif ($grades == 40)
                $sss = "D";
            elseif ($grades > 32 && $grades < 40)
                $sss = "D";
            elseif ($grades == 32)
                $sss = "E";
            elseif ($grades > 20 && $grades < 32)
                $sss = "E";
            elseif ($grades == 20)
                $sss = "E";
            elseif ($grades >= 0 && $grades < 20)
                $sss = "E";
        }

        $html .= '<td width="10%" style="border-top:1px solid #000; border-right:1px solid 
	#000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">' . $gtotals . ' ' . $sss . ' </td>';
    $iiExam++;  }

    $grades2 = 0;
    $ssss2 = '';

    if ($totalgrand2 != 0) {

        $subjectotal2 = 0;
        $subjectotal2 = $subjectcnt * 50;
        //echo $subjectotal;
        $grades2 = $totalgrand2 * 100 / $subjectotal2;

        if ($grades2 > 90 && $grades2 < 101)
            $ssss2 = "A1";
        elseif ($grades2 == 90)
            $ssss2 = "A2";
        elseif ($grades2 > 80  && $grades2 < 90)
            $ssss2 = "A2";
        elseif ($grades2 == 80)
            $ssss2 = "B1";
        elseif ($grades2 > 70  && $grades2 < 80)
            $ssss2 = "B1";
        elseif ($grades2 == 70)
            $ssss2 = "B2";
        elseif ($grades2 > 60 && $grades2 < 70)
            $ssss2 = "B2";
        elseif ($grades2 == 60)
            $ssss2 = "C1";
        elseif ($grades2 > 50  &&  $grades2 < 60)
            $ssss2 = "C1";
        elseif ($grades2 == 50)
            $ssss2 = "C2";
        elseif ($grades2 > 40 && $grades2 < 50)
            $ssss2 = "C2";
        elseif ($grades2 == 40)
            $ssss2 = "D";
        elseif ($grades2 > 32 && $grades2 < 40)
            $ssss2 = "D";
        elseif ($grades2 == 32)
            $ssss2 = "E";
        elseif ($grades2 > 20 && $grades2 < 32)
            $ssss2 = "E";
        elseif ($grades2 == 20)
            $ssss2 = "E";
        elseif ($grades2 >= 0 && $grades2 < 20)
            $ssss2 = "E";
    }


    $html .= '<td width="10%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">' . $totalgrand2 . ' ' . $ssss2 . ' </td>';
    $grand = $totalgrand1 + $totalgrand2;

    $grades3 = 0;
    $ssss3 = '';
    if ($grand != 0) {

        $subjectotal3 = 0;


        $subjectotal3 = $subjectcnt * 100;
        //echo $subjectotal;
        $grades3 = $grand * 100 / $subjectotal3;


        if ($grades3 > 90 && $grades3 < 101)
            $ssss3 = "A1";
        elseif ($grades3 == 90)
            $ssss3 = "A2";
        elseif ($grades3 > 80  && $grades3 < 90)
            $ssss3 = "A2";
        elseif ($grades3 == 80)
            $ssss3 = "B1";
        elseif ($grades3 > 70  && $grades3 < 80)
            $ssss3 = "B1";
        elseif ($grades3 == 70)
            $ssss3 = "B2";
        elseif ($grades3 > 60 && $grades3 < 70)
            $ssss3 = "B2";
        elseif ($grades3 == 60)
            $ssss3 = "C1";
        elseif ($grades3 > 50  &&  $grades3 < 60)
            $ssss3 = "C1";
        elseif ($grades3 == 50)
            $ssss3 = "C2";
        elseif ($grades3 > 40 && $grades3 < 50)
            $ssss3 = "C2";
        elseif ($grades3 == 40)
            $ssss3 = "D";
        elseif ($grades3 > 32 && $grades3 < 40)
            $ssss3 = "D";
        elseif ($grades3 == 32)
            $ssss3 = "E";
        elseif ($grades3 > 20 && $grades3 < 32)
            $ssss3 = "E";
        elseif ($grades3 == 20)
            $ssss3 = "E";
        elseif ($grades3 >= 0 && $grades3 < 20)
            $ssss3 = "E";
    }

    $html .= '<td width="11%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">' . $grand . ' ' . $ssss3 . ' </td>';

    $html .= '<td width="10%" rowspan="2" style="border-top:1px solid #000; border-right:1px solid 
#000; height:18px; border-bottom:1px solid #000; line-height:30px; font-size:11px; font-weight:bold; text-align:center;">' . $ssss3 . ' </td>';
    $html .= '</tr>';

    $html .= '<tr>
<td width="19%" style="border-top:1px solid #000; border-right:1px solid 
#000; border-left:1px solid #000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">TOTAL %</td>';
    $totalgrand1 = 0;
    $totalgrand2 = 0;
    $iiExam = 1;
    foreach ($findroleexamtype1 as $key => $item) {
        $gtotal = 0;
        foreach ($subject as $key => $name) {

            $newmarks = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $item['id'], $name['id'], 1);
            if ($newmarks['marks'] != '') {


                $gtotal += $newmarks['marks'];
            } else {
            }
        }

        $grades = 0;
        $sss = '';
        if ($gtotal != 0) {
            $totalgrand1 += number_format($gtotal);

            $subjectotal = 0;

            if($iiExam == 1){

                $subjectotal = $subjectcnt * 40;
                $grades = $gtotal * 100 / $subjectotal;


                if ($grades > 90 && $grades < 101)
                    $sss = "A1";
                elseif ($grades == 90)
                    $sss = "A2";
                elseif ($grades > 80  && $grades < 90)
                    $sss = "A2";
                elseif ($grades == 80)
                    $sss = "B1";
                elseif ($grades > 70  && $grades < 80)
                    $sss = "B1";
                elseif ($grades == 70)
                    $sss = "B2";
                elseif ($grades > 60 && $grades < 70)
                    $sss = "B2";
                elseif ($grades == 60)
                    $sss = "C1";
                elseif ($grades > 50  &&  $grades < 60)
                    $sss = "C1";
                elseif ($grades == 50)
                    $sss = "C2";
                elseif ($grades > 40 && $grades < 50)
                    $sss = "C2";
                elseif ($grades == 40)
                    $sss = "D";
                elseif ($grades > 32 && $grades < 40)
                    $sss = "D";
                elseif ($grades == 32)
                    $sss = "E";
                elseif ($grades > 20 && $grades < 32)
                    $sss = "E";
                elseif ($grades == 20)
                    $sss = "E";
                elseif ($grades >= 0 && $grades < 20)
                    $sss = "E";
            }else{
               // $subjectotal = 70;

               if($students['class_id'] ==13){
                //commmerce
                $subjectotal = 65;
            }else if($students['class_id'] ==15){
                //arts
                $subjectotal = 55;
            }else{
                //science
                $subjectotal = 70;
            }
                $grades = $gtotal * 100 / $subjectotal;


                if ($grades > 90 && $grades < 101)
                    $sss = "A1";
                elseif ($grades == 90)
                    $sss = "A2";
                elseif ($grades > 80  && $grades < 90)
                    $sss = "A2";
                elseif ($grades == 80)
                    $sss = "B1";
                elseif ($grades > 70  && $grades < 80)
                    $sss = "B1";
                elseif ($grades == 70)
                    $sss = "B2";
                elseif ($grades > 60 && $grades < 70)
                    $sss = "B2";
                elseif ($grades == 60)
                    $sss = "C1";
                elseif ($grades > 50  &&  $grades < 60)
                    $sss = "C1";
                elseif ($grades == 50)
                    $sss = "C2";
                elseif ($grades > 40 && $grades < 50)
                    $sss = "C2";
                elseif ($grades == 40)
                    $sss = "D";
                elseif ($grades > 32 && $grades < 40)
                    $sss = "D";
                elseif ($grades == 32)
                    $sss = "E";
                elseif ($grades > 20 && $grades < 32)
                    $sss = "E";
                elseif ($grades == 20)
                    $sss = "E";
                elseif ($grades >= 0 && $grades < 20)
                    $sss = "E";
            }

        
        }

        $html .= '<td width="10%" style="border-top:1px solid #000; border-right:1px solid 
	#000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">' . number_format($grades, 2) . ' </td>';
   $iiExam++; }


    $grades1 = 0;
    $ssss = '';
    if ($totalgrand1 != 0) {

        $subjectotal1 = 0;

        $subjectotal1 = $subjectcnt * 50;
        //echo $subjectotal;

        $grades1 = $totalgrand1 * 100 / $subjectotal1;


        if ($grades1 > 90 && $grades1 < 101)
            $ssss = "A1";
        elseif ($grades1 == 90)
            $ssss = "A2";
        elseif ($grades1 > 80  && $grades1 < 90)
            $ssss = "A2";
        elseif ($grades1 == 80)
            $ssss = "B1";
        elseif ($grades1 > 70  && $grades1 < 80)
            $ssss = "B1";
        elseif ($grades1 == 70)
            $ssss = "B2";
        elseif ($grades1 > 60 && $grades1 < 70)
            $ssss = "B2";
        elseif ($grades1 == 60)
            $ssss = "C1";
        elseif ($grades1 > 50  &&  $grades1 < 60)
            $ssss = "C1";
        elseif ($grades1 == 50)
            $ssss = "C2";
        elseif ($grades1 > 40 && $grades1 < 50)
            $ssss = "C2";
        elseif ($grades1 == 40)
            $ssss = "D";
        elseif ($grades1 > 32 && $grades1 < 40)
            $ssss = "D";
        elseif ($grades1 == 32)
            $ssss = "E";
        elseif ($grades1 > 20 && $grades1 < 32)
            $ssss = "E";
        elseif ($grades1 == 20)
            $ssss = "E";
        elseif ($grades1 >= 0 && $grades1 < 20)
            $ssss = "E";
    }


    $html .= '<td width="10%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">' . number_format($grades1, 2) . ' </td>';

    $findroleexamtype2s = $this->Comman->findexamtypesclass($students['class_id'], 2);
    $iiExam = 1;
    foreach ($findroleexamtype2s as $k => $item) {
        $gtotals = 0;
        foreach ($subject as $key => $name) {

            $newmarks = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $item['id'], $name['id'], 2);
            if ($newmarks['marks'] != '') {


                $gtotals += $newmarks['marks'];
            } else {
            }
        }

        $grades = 0;
        $sss = '';
        if ($gtotals != 0) {
            $totalgrand2 += number_format($gtotals);


            $subjectotal = 0;
            if($iiExam == 1){

                $subjectotal = $subjectcnt * 40;
            }else{
                if($students['class_id'] ==13){
                    //commmerce
                    $subjectotal = 65;
                }else if($students['class_id'] ==15){
                    //arts
                    $subjectotal = 55;
                }else{
                    //science
                    $subjectotal = 70;
                }
            }

       
            //echo $subjectotal;
            $grades = $gtotals * 100 / $subjectotal;


            if ($grades > 90 && $grades < 101)
                $sss = "A1";
            elseif ($grades == 90)
                $sss = "A2";
            elseif ($grades > 80  && $grades < 90)
                $sss = "A2";
            elseif ($grades == 80)
                $sss = "B1";
            elseif ($grades > 70  && $grades < 80)
                $sss = "B1";
            elseif ($grades == 70)
                $sss = "B2";
            elseif ($grades > 60 && $grades < 70)
                $sss = "B2";
            elseif ($grades == 60)
                $sss = "C1";
            elseif ($grades > 50  &&  $grades < 60)
                $sss = "C1";
            elseif ($grades == 50)
                $sss = "C2";
            elseif ($grades > 40 && $grades < 50)
                $sss = "C2";
            elseif ($grades == 40)
                $sss = "D";
            elseif ($grades > 32 && $grades < 40)
                $sss = "D";
            elseif ($grades == 32)
                $sss = "E";
            elseif ($grades > 20 && $grades < 32)
                $sss = "E";
            elseif ($grades == 20)
                $sss = "E";
            elseif ($grades >= 0 && $grades < 20)
                $sss = "E";
        }



        $html .= '<td width="10%" style="border-top:1px solid #000; border-right:1px solid 
	#000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">' . number_format($grades, 2) . ' </td>';
    $iiExam++;  }

    $grades2 = 0;
    $ssss2 = '';
    if ($totalgrand2 != 0) {

        $subjectotal2 = 0;


        $subjectotal2 = $subjectcnt * 50;
        //echo $subjectotal;
        $grades2 = $totalgrand2 * 100 / $subjectotal2;


        if ($grades2 > 90 && $grades2 < 101)
            $ssss2 = "A1";
        elseif ($grades2 == 90)
            $ssss2 = "A2";
        elseif ($grades2 > 80  && $grades2 < 90)
            $ssss2 = "A2";
        elseif ($grades2 == 80)
            $ssss2 = "B1";
        elseif ($grades2 > 70  && $grades2 < 80)
            $ssss2 = "B1";
        elseif ($grades2 == 70)
            $ssss2 = "B2";
        elseif ($grades2 > 60 && $grades2 < 70)
            $ssss2 = "B2";
        elseif ($grades2 == 60)
            $ssss2 = "C1";
        elseif ($grades2 > 50  &&  $grades2 < 60)
            $ssss2 = "C1";
        elseif ($grades2 == 50)
            $ssss2 = "C2";
        elseif ($grades2 > 40 && $grades2 < 50)
            $ssss2 = "C2";
        elseif ($grades2 == 40)
            $ssss2 = "D";
        elseif ($grades2 > 32 && $grades2 < 40)
            $ssss2 = "D";
        elseif ($grades2 == 32)
            $ssss2 = "E";
        elseif ($grades2 > 20 && $grades2 < 32)
            $ssss2 = "E";
        elseif ($grades2 == 20)
            $ssss2 = "E";
        elseif ($grades2 >= 0 && $grades2 < 20)
            $ssss2 = "E";
    }


    $html .= '<td width="10%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">' . number_format($grades2, 2) . '</td>';



    $html .= '<td width="11%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:18px; border-bottom:1px solid #000; line-height:18px; font-size:11px; font-weight:bold; text-align:center;">' . number_format($grades3, 2) . ' </td>';


    $html .= '</tr>';
    $nontheorysub = $this->Comman->find_nontheorysubject($students['class_id']);
    // student Attendence 
    $attendncterm1 = $this->Comman->findstuattendetails($students['student']['id'],$students['class_id'],$students['sect_id'],1);
    $attendncterm2 = $this->Comman->findstuattendetails($students['student']['id'],$students['class_id'],$students['sect_id'],2);

    $WorkingDays = $attendncterm1['total']+$attendncterm2['total'];
    $daysAttended = $attendncterm1['present']+$attendncterm2['present'];

    $html .= '
		</table>	<br><br>';

//Co subject and marks 





$html.='
<table width="100%">

<tr>
<td  style="height:20px;"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold; text-transform:uppercase;">CO-SCHOLASTIC AREAS:</h2></td>
</tr>
</table>

<table width="100%">
<tr>
<td width="100%">
<table width="100%" style="font-size:11px" border="1">
';
//Co subject and marks 



		$html .= '<tr>
<td style="height:16px;  font-weight:bold; line-height:16px; border-left:1px solid #000;   text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="60%">
&nbsp; Work Experience
</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="10%" align="center">
&nbsp;A
</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="30%" align="center">
&nbsp;Attendance
</td>
</tr>';

$html .= '<tr>
<td style="height:16px;  font-weight:bold; line-height:16px; border-left:1px solid #000;   text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="60%">
&nbsp; General Studies


</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="10%" align="center">
&nbsp;A
</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="15%" align="center">
&nbsp;Working Days
</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="15%" align="center">
&nbsp;'.$WorkingDays.'
</td>
</tr>';

$html .= '<tr>
<td style="height:16px;  font-weight:bold; line-height:16px; border-left:1px solid #000;   text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="60%">
&nbsp; Health & Physical Education (Sports/MartialArts/Yoga/NCC etc.)


</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="10%" align="center">
&nbsp;A
</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="15%" align="center">
&nbsp;Days Attended
</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="15%" align="center">
&nbsp;'.$daysAttended.'
</td>
</tr>';


$html.='</table>
</td>
<td width="100%">

</td>
</tr>
</table>




';




$html.='<br><br>

<table width="100%">
<tr>
<td width="60%" align="left" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">&nbsp; 

<table width="100%" cellspacing="7" style="font-size:11px;">
<tr><td width="100%"><b>Remarks:</b></td></tr>
<tr><td width="100%" style="border-bottom:1px dotted #a8a8a8;">'.$attendncterm1['remarks'].'</td></tr>
<tr><td width="100%" style=" border-bottom:1px dotted #a8a8a8;">'.$attendncterm2['remarks'].'</td></tr>
<tr><td width="100%" style="border-bottom:1px dotted #a8a8a8;"></td></tr>


</table>
  </td>

<td width="40%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">
<table width="100%">
<tr>
<td width="1%"></td>
<td width="33%" align="left" style=" font-weight:bold; font-size:9px; ">%-Range</td>
<td width="1%"></td>
<td width="14%" align="left" style=" font-size:9px; font-weight:bold; border-right:1px solid #000;">Grade</td>
<td width="2%"></td>
<td width="33%" align="left" style=" font-weight:bold; font-size:9px;">Co-Scholastic</td>
<td width="1%"></td>
<td width="14%" align="left" style=" font-weight:bold; font-size:9px;">Grade</td>
<td width="1%"></td>
</tr>


<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;91-100</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">A1</td>
<td width="2%"></td>
<td width="35%" align="left" rowspan="3" style="font-size:8px;">Outstanding</td>
<td width="1%" rowspan="3"></td>
<td width="12%" align="left" rowspan="3" style="font-size:8px;">A</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left"style="font-size:8px;">&nbsp;&nbsp;81-90</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">A2</td>
<td width="2%"></td>



<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;71-80</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">B1</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>


<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;61-70</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000;font-size:8px;">B2</td>
<td width="2%"></td>
<td width="35%" align="left" rowspan="3" style="font-size:8px;">Very Good</td>
<td width="1%"></td>
<td width="12%" align="left" rowspan="3" style="font-size:8px;">B</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;51-60</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000;font-size:8px;">C1</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;41-50</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">C2</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;33-40</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000;font-size:8px;">D</td>
<td width="2%"></td>
<td width="35%" align="left" style="font-size:8px;">Fair</td>
<td width="1%"></td>
<td width="12%" align="left" style="font-size:8px;">C</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;32 & Below</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">E</td>
<td width="2%"></td>

<td width="1%"></td>
</tr>


</table>
</td>
</tr>
</table>
<table width="100%" style="font-size:11px;">
<tr><br><br><br><br><br>
<td width="33.333%" align="left" style="line-height:15px; font-weight:bold;" >
<b>Date</b>
</td>

<td width="33.333%" align="center" style="line-height:15px; font-weight:bold;" >
<b>Class Teacher </b>
</td>

<td width="33.333%" align="right" style="line-height:15px; font-weight:bold;" >
<b>Principal</b> 
</td>
</tr>


</table>

 
</body>
</html>';
    $pdf->SetFont('times', '', 9, '', 'false');


    $pdf->WriteHTML($html, true, false, true, false, '');
}
// echo $html; die;
ob_end_clean();
echo $pdf->Output('Result.pdf');
exit;

