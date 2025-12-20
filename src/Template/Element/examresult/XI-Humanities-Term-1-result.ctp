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

// pr($studentsj);die;

foreach ($studentsj as $f => $students) {
    // if (!empty($s_id) && $students['stud_id'] != $s_id) {
    //     continue;
    // }
    if($students['marks']=='0' || $students['marks']=='0.00'){	
        //pr('if');die;
        continue;
        }
    $pdf->AddPage();
    // pr($students);die;
    // pr($students['student']['comp_sid']);
//     $optionsub = $students['student']['opt_sid'];
//     $comsub = $students['student']['comp_sid'];
//     $comsub_id =explode(",",$students['student']['comp_sid']);
//     $optionsub_id =explode(",",$students['student']['opt_sid']);
//     $allsubject = array_merge($comsub_id,$optionsub_id);

//     foreach ($allsubject as $sub_id) {

//     $st_subject = $this->Comman->opt_com_sub($sub_id);
//     $all_array[]=$st_subject['name'];
    
    
// }
// pr($all_array);die;
    

    $fhosue = $this->Comman->findhouse($students['student']['h_id']);
    $classt = $this->Comman->findclass($students['class_id']);
    $sect = $this->Comman->findsectionsss($students['sect_id']);
    $html = '<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


    $html .= '</head>
<body style="font-family:"Times New Roman", Times, serif">

<br><br><br><br><br><br> <br><br> <br><br> 

<h2 style="font-weight:bold; font-size:16px; text-align:center;">
<span style="font-size:18px; display:inline-block;">Half Yearly Report Card</span><br>   
 Academic Session ' . $rolepresentyear . '<br>
 <span style="display:block; text-align:center; font-size:14px;">Class - ' . $classt['title'] . '- ' . $sect['title'] . '</span>


</h2>


<table width="100%" style="font-size:11px;">
<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
    $studentn = "Scholar No.";

    $html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . $students['student']['enroll'] . '
</td>


</tr>


<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
    $studentn = "Student's Name";

    $html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . ucwords(strtolower($students['student']['fname'])) . '&nbsp;' . ucwords(strtolower($students['student']['middlename'])) . '&nbsp;' . ucwords(strtolower($students['student']['lname'])) . '
</td>


</tr>

<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
    $studentn = "Mother's Name";

    $html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . ucwords(strtolower($students['student']['mothername'])) . '
</td>


</tr>

<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
    $studentn = "Father's Name";

    $html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . ucwords(strtolower($students['student']['fathername'])) . '
</td>


</tr>

<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
    $studentn = "Date of Birth";

    $html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . date('d-m-Y', strtotime($students['student']['dob'])) . '
</td>


</tr>


<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
    $studentn = "House";

    $html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . $fhosue['name'] . '
</td>


</tr>


<tr>
<td style="height:16px; line-height:16px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; ';
    $studentn = "Class / Section";

    $html .= $studentn . '
</td>

<td style="height:16px; line-height:16px;   text-transform:uppercase;" width="5%">:</td>

<td style="height:16px; line-height:16px; text-transform:uppercase; text-align:left;  " width="30%">
&nbsp; ' . $classt['title'] . '- ' . $sect['title'] . '
</td>


</tr>
</table>



<br><br>
<table width="100%">
<tr>
<td align="left" width="20%"  style="height:20px; line-height:20px;border-top:1px solid #000; border-left:1px solid #000;  border-right:1px solid #000;"><h2 style=" font-size:10px; font-weight:bold; ">&nbsp; Scholastic Areas:</h2></td>
<td align="center" width="80%" style=" border-top:1px solid #000; height:20px; line-height:20px;  font-weight:bold; border-right:1px solid #000;">Term-1 (50 Marks)</td>
</tr>
</table>
<table width="100%" >';

    $findroleexamtype1 = $this->Comman->findexamtypesclass($students['class_id'], 1);
    // pr($findroleexamtype1);die;


    $html .= '<tr style="font-size:11px;">
<td width="20%" style="border-top:1px solid #000; border-left:1px solid #000;  height:32px; line-height:32px;  border-right:1px solid #000; text-align:left;  font-weight:bold; " align="left">&nbsp; Subject</td>';

    $cbg = 0;
    foreach ($findroleexamtype1 as $key => $item) {
        // pr($item);die;
        $html .= '<td width="20%" style="border-top:1px solid #000; height:16px; line-height:14px;  font-weight:bold;  border-right:1px solid #000;  text-align:center;" align="center">' . $item['examprint'] . '</td>';
        $cbg += $item['maxnumber'];
    }

    $html .= '<td width="20%" style="border-top:1px solid #000; height:16px; line-height:14px;  font-weight:bold;  border-right:1px solid #000;  text-align:center;" align="center">Marks Obtained<br>(50)</td>

<td width="20%" style="border-top:1px solid #000; height:16px; line-height:14px;  font-weight:bold; border-right:1px solid #000; text-align:center;" align="center">Grade</td>';

    $subject = $this->Comman->find_examsubjectsnnupdated($students['class_id'],$students['student']['enroll']);
    $nontheorysub = $this->Comman->find_nontheorysubject($students['class_id']);
    // pr($subject);die; 
    $subjectcnt = 0;
    foreach ($subject as $key => $name) {
        $subjectcnt++;

        // if(in_array($name['exprint'],$all_array)){
            $html .= '</tr><tr style="font-size:11px;"><td width="20%" style="border-top:1px solid #000; border-left:1px solid #000;  height:20px; line-height:20px; border-bottom:1px solid #000;  border-right:1px solid #000; text-align:center;  font-weight:bold; " align="left">&nbsp; ' .$name['exprint'] . '</td>';
        // }


        $findroleexamtype = $this->Comman->findeexamtsype3s($students['sect_id'], $students['class_id'], 1);
        $ter = 0;
        foreach ($findroleexamtype as $er) {

            $newmarks = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $er['etype_id'], $name['id'], 1);
            // pr($newmarks);die;

            if ($newmarks['marks'] != '') {

                $html .= '
                <td width="20%" style="border-top:1px solid #000;   height:20px; line-height:20px; border-bottom:1px solid #000;  border-right:1px solid #000;  text-align:center;" align="center">' . $newmarks['marks'] . '</td>
                ';
                $ter += $newmarks['marks'];
                // $addall += $ter;
                // pr($addall);
            } else {
                $html .= '<td width="20%" style="border-top:1px solid #000;   height:20px; line-height:20px;  border-right:1px solid #000;  text-align:center;" align="center">--</td>';
            }
        }
        $html .= '<td width="20%"  style="border-top:1px solid #000;  border-right:1px solid #000; border-bottom:1px solid #000; height:20px; line-height:20px;" align="center">' . $ter . '</td>';
        $grade = 0;
        $ss = "";
        if ($ter != 0) {
            // $grade=$ter*100/200; 
            $grade = $ter;


            if ($grade > 45 && $grade < 51)
                $ss = "A1";
            elseif ($grade == 45)
                $ss = "A2";
            elseif ($grade > 40  && $grade < 45)
                $ss = "A2";
            elseif ($grade == 40)
                $ss = "B1";
            elseif ($grade > 35  && $grade < 40)
                $ss = "B1";
            elseif ($grade == 35)
                $ss = "B2";
            elseif ($grade > 30 && $grade < 35)
                $ss = "B2";
            elseif ($grade == 30)
                $ss = "C1";
            elseif ($grade > 25  &&  $grade < 30)
                $ss = "C1";
            elseif ($grade == 25)
                $ss = "C2";
            elseif ($grade > 20 && $grade < 25)
                $ss = "C2";
            elseif ($grade == 20)
                $ss = "D";
            elseif ($grade > 15 && $grade < 20)
                $ss = "D";
            elseif ($grade == 15)
                $ss = "E";
            elseif ($grade > 10 && $grade < 15)
                $ss = "E";
            elseif ($grade == 10)
                $ss = "E";
            elseif ($grade >= 5 && $grade < 10)
                $ss = "E";
        }

        $html .= '<td width="20%"  style="border-top:1px solid #000;  border-right:1px solid #000; border-bottom:1px solid #000; height:20px; line-height:20px;" align="center">' . $ss . '</td>';
    }
    $html .= '</tr>';

    $workingdaysid = $this->Comman->findcoscholsubjectt("Working Days", $students['class_id']);
    $daysAttendedsid = $this->Comman->findcoscholsubjectt("Days Attended", $students['class_id']);    
     // student Attendence 
     $attendnc = $this->Comman->findstuattendetails($students['student']['enroll'],$students['class_id'],$students['sect_id'],$students['term']);

    $workingdaysid = $this->Comman->findcoactivityresultpdf($students['class_id'], $students['sect_id'], "Term2", $workingdaysid['id'], $students['stud_id'], $students['student']['acedmicyear']);

    $daysAttendeds = $this->Comman->findcoactivityresultpdf($students['class_id'], $students['sect_id'], "Term2", $daysAttendedsid['id'], $students['stud_id'], $students['student']['acedmicyear']);

   

    $html .= '

</table>
<br><br>
<table width="100%">

<tr>
<td align="center" style="height:20px;"><h5 style=" text-transform:uppercase; font-size:10px; font-weight:bold; text-decoration:underline;">Co-Scholastic Areas: Term 1 [on a 3-Point(A-C) grading scale]</h5></td>
</tr>
</table>

<table width="100%">
<tr>
<td width="50%">
<table width="100%" style="font-size:11px;">
<tr>
<th style="height:16px;  font-weight:bold; line-height:16px;  border-left:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000;" width="70%">&nbsp; Grade</th>

<th style="height:16px;  font-weight:bold; line-height:16px;   border-right:1px solid #000; border-bottom:1px solid #000; border-top:1px solid #000; text-align:center;" width="30%">Grade</th>
</tr>';


$nonsub = 0;
foreach ($nontheorysub as $key => $name) {

        $gtotals1 = 0;
        $findroleexamtyp1s = $this->Comman->findexamtypesclass($students['class_id'], 1);
        foreach ($findroleexamtyp1s as $k => $item) {

            $newmarkss = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $item['id'], $name['id'], 1);
            if ($newmarkss['marks'] != '') {

                $gtotals1 += $newmarkss['marks'];
            } else {
            }
        }

        $grades1 = 0;
        $sss = '';
        if ($gtotals1 != 0) {
            $subjectotal = 0;
            //echo $subjectotal;
            $grades1 = $gtotals1;
            if ($grades1 > 80 && $grades1 < 101)
                $sss = "A";
            elseif ($grades1 == 80)
                $sss = "B";
            elseif ($grades1 > 60  && $grades1 < 80)
                $sss = "B";
            elseif ($grades1 == 60)
                $sss = "C";
            elseif ($grades1 > 40  &&  $grades1 < 60)
                $sss = "C";
            elseif ($grades1 == 40)
                $sss = "D";
            elseif ($grades1 < 40)
                $sss = "E";
        }
        $workeduidsr = $sss;
        $nonsub++;
        $html .= '<tr>
    <td style="height:16px;  font-weight:bold; line-height:16px; border-left:1px solid #000;   text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="70%">
    &nbsp;' . $name['exprint'] . '
    </td>    
    <td style="height:16px; line-height:16px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="30%" align="center">
    &nbsp; ' . $workeduidsr . '
    </td>     
    </tr>';
    }



$html.='
</table>
</td>
<td width="50%">

</td>
</tr>
</table>
<br>
<br>
<table>

<tr>
<td style="height:16px; line-height:16px; font-size:11px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; Attendence
</td>

<td style="height:16px; line-height:16px; font-size:11px;   text-transform:uppercase;" width="5%">:</td>';

//Attendence
if(!empty($attendnc['present'])){
    $html.='<td style="height:16px; line-height:16px; font-size:11px; text-transform:uppercase; text-align:left;  " width="30%">
    &nbsp;' . $attendnc['present'] . ' / ' . $attendnc['total'] . '
    </td></tr>
    </table>
    <br><br>';
}else{
    $html.='<td style="height:16px; line-height:16px; font-size:11px; text-transform:uppercase; text-align:left;  " width="30%">
    &nbsp;100 / Absent
    </td></tr>
    </table>
    <br><br>';
}

//Remarks
//  if(!empty($attendnc['remarks'])){
$html.='<table width="100%">
<tr>
<th width="30%" style="height:32px; font-weight:bold;  border-left:1px solid #000;  border-right:1px solid #000;  border-top:1px solid #000;  border-bottom:1px solid #000;">&nbsp; Class Teacher Remarks:</th>
<td width="2%" style="  border-top:1px solid #000;  border-bottom:1px solid #000;"> </td>
<td width="68%" style="height:32px; line-height:12px;   border-right:1px solid #000;  border-top:1px solid #000;  border-bottom:1px solid #000;">' . $attendnc['remarks'] . '. </td>
</tr>
</table></body>
</html>';
    $pdf->SetFont('times', '', 9, '', 'false');

    $pdf->WriteHTML($html, true, false, true, false, '');
}
// echo $html; die;
ob_end_clean();
echo $pdf->Output('Result.pdf');
exit;
