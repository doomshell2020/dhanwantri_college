<?php
class xtcpdf extends TCPDF
{
}
$this->set('pdf', new TCPDF('L', 'mm', 'A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->SetTitle('Students Results');
// $pdf->AddPage();

// Get School Information 
$findschoolinformation = $this->Comman->findschoolinformation($dbname);
$schoollogo = $this->Comman->schoollogo($dbname);
// $principal_sign_img = SITE_URL . 'images/' . $sitesetting['sign'];
// pr($principal_sign_img);exit;

// $img_file = SITE_URL . 'webroot/images/'. $schoollogo[0]['logo'];
// $pdf->Image($img_file, 0, 0, 225, 305, '', '', '', false, 300, '', false, false, 0);
// $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
function gradecalculation($marks, $maxnumber, $number)
{

    if ($marks != 0) {
        $totalgrade = NULL;

        $totalgrade = round($marks / $maxnumber * $number);
        // pr($totalgrade);die;

        if ($totalgrade >= 96 && $totalgrade <= 100)
            $ss2 = "O";
        // elseif ($totalgrade == 96)
        //     $ss2 = "O";
        elseif ($totalgrade >= 91  && $totalgrade <= 95)
            $ss2 = "A+";
        // elseif ($totalgrade == 91)
        //     $ss2 = "A+";
        elseif ($totalgrade >= 86  && $totalgrade <= 90)
            $ss2 = "A";
        // elseif ($totalgrade == 86)
        //     $ss2 = "A";
        elseif ($totalgrade >= 76 && $totalgrade <= 85)
            $ss2 = "B+";
        // elseif ($totalgrade == 76)
        //     $ss2 = "C1";
        elseif ($totalgrade >= 66 && $totalgrade <= 75)
            $ss2 = "B";
        // elseif ($totalgrade == 66)
        //     $ss2 = "C2";
        elseif ($totalgrade >= 56 && $totalgrade <= 65)
            $ss2 = "C+";
        // elseif ($totalgrade == 56)
        //     $ss2 = "D";
        elseif ($totalgrade >= 40 && $totalgrade <= 55)
            $ss2 = "D";
        // elseif ($totalgrade == 40)
        //     $ss2 = "E";
        // elseif ($totalgrade >= 0 && $totalgrade < 40)
        //     $ss2 = "E";
        // elseif ($totalgrade == 30)
        //     $ss2 = "E";
        elseif ($totalgrade > 0 && $totalgrade <= 40)
            $ss2 = "E";
        else
            $ss2 = 'E';
    } else {
        $ss2 = "E";
    }
    return $ss2;
}

foreach ($studentsj as $f => $students) {
    // pr($students);die;
    // if (!empty($s_id) && $students['stud_id'] != $s_id) {
    //     continue;
    // }

    if ($students['marks'] == '0' || $students['marks'] == '0.00') {
        //pr('if');die;
        continue;
    }

    $pdf->AddPage();
    $img_file = SITE_URL . 'images/canwas_bg5.png';
    $pdf->Image($img_file, 17, 90, 180, 125, '', '', '', false, 100, '', false, false, 300);

    $fhosue = $this->Comman->findhouse($students['student']['h_id']);
    $classt = $this->Comman->findclass($students['class_id']);
    $sect = $this->Comman->findsectionsss($students['sect_id']);



    $html = '<!DOCTYPE HTML>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">';


    $html .= '</head>
    <body style="font-family:"Times New Roman", Times, serif; ">

    <table width="100%">
        <tr style="text-align:center; font-size:16px; font-weight:bold;">
            <td width="10%"></td>
            <td width="70%">
            ' . ucwords(strtolower($findschoolinformation[0]['school_name'])) . '
            </td>
            <td rowspan="3" width="20%">
            <img src="' . SITE_URL . 'images/' . $schoollogo[0]['small_logo'] . '" alt="" border="0" style="display:block; " height="80px" width="80px">
            </td>
        </tr>

        <tr style="text-align:center; font-weight:bold;">
            <td width="10%"></td>
            <td style="text-align:center;" width="70%">
            ' . ucwords(strtolower($findschoolinformation[0]['school_address'])) . '
            </td>
        </tr>

        <tr style="text-align:center; font-weight:bold;">
        <td width="10%"></td>
            <td width="70%" style="text-align:center; ">
            Phone No : ' . $findschoolinformation[0]['school_contact'] . '<br>
            Email: ' . $schoollogo[0]['email'] . '<br>
            Website: ' . $schoollogo[0]['website'] . '
            <br>
            </td>
        </tr>

    </table>

    <hr>

    <br>

    <table>
    <tr>
    <td style="text-align:center; font-size:16px; font-weight:bold;" width="100%">
    Academic Session ' . $rolepresentyear . '<br>
    Progress Report Card
    </td>
    </tr> 
    </table>
    <br>

    <table width="100%">
    <tr>
    <td width="100%" style="font-weight:bold;">
    STUDENT PROFILE
    </td>
    </tr>
    </table>

    <table width="100%" style="border:1px solid #000;" >
    <tr>
    <td width="20%" style="height:15px; line-height:15px; font-weight:bold;">Admission No</td>
    <td width="30%" style="height:15px; line-height:15px; font-weight:bold;">:&nbsp; ' . $students['student']['enroll'] . '</td>
    <td width="20%" style="height:15px; line-height:15px; font-weight:bold;">Students Name</td>
    <td width="30%" style="height:15px; line-height:15px; font-weight:bold;">: &nbsp;' . ucwords(strtolower($students['student']['fname'])) . '&nbsp;' . ucwords(strtolower($students['student']['middlename'])) . '&nbsp;' . ucwords(strtolower($students['student']['lname'])) . '</td>
    </tr>
    <tr>
    <td width="20%" style="height:15px; line-height:15px; font-weight:bold;">Fathers Name</td>
    <td width="30%" style="height:15px; line-height:15px; font-weight:bold;">: &nbsp;' . ucwords(strtolower($students['student']['fathername'])) . '</td>
    <td width="20%" style="height:15px; line-height:15px; font-weight:bold;">Mothers Name</td>
    <td width="30%" style="height:15px; line-height:15px; font-weight:bold;">: &nbsp;' . ucwords(strtolower($students['student']['mothername'])) . '</td>
    </tr>
    <tr>
    <td width="20%" style="height:15px; line-height:15px; font-weight:bold;">Date of Birth</td>
    <td width="30%" style="height:15px; line-height:15px; font-weight:bold;">:&nbsp; ' . date('d-M-Y', strtotime($students['student']['dob'])) . '</td>
    <td width="20%" style="height:15px; line-height:15px; font-weight:bold;">Class</td>
    <td width="30%" style="height:15px; line-height:15px; font-weight:bold;">:&nbsp; ' . $classt['title'] . '- ' . $sect['title'] . '</td>
    </tr>
    </table>
    <br>

    <table width="100%">
    <tr>
    <td width="100%" style="font-weight:bold;">SCHOLASTIC AREAS</td>
    </tr>
    </table>

    <table width="100%" border="1">
    <tr>
    <th width="13%" rowspan="2" style="font-weight:bold;">Subject Name</th>
    <th colspan="7" width="40.6%" style="text-align:center; font-weight:bold;">Term-I</th>
    <th colspan="7" width="40.6%" style="text-align:center; font-weight:bold;">Term-II</th>
    <th width="5.8%" style="text-align:center; font-weight:bold;">Total</th>
    </tr>

    <tr>';
    $findroleexamtype1 = $this->Comman->findexamtypesclass($students['class_id'], 1);

    $cbg = 0;
    foreach ($findroleexamtype1 as $key => $item) { //pr($item);die;

        $html .= '<th style="text-align:center; font-weight:bold;" width="5.8%">
        ' . $item['examprint'] . '<br>(' . $item['maxnumber'] . ')</th>';

        $cbg += $item['maxnumber'];
    }
    $html .= '
    <th style="text-align:center; font-weight:bold;" width="5.8%">Marks<br>Obtained<br>(100) </th>

    <th style="text-align:center; font-weight:bold;" width="5.8%">
    Grade
    </th>';

    $findroleexamtype2 = $this->Comman->findexamtypesclass($students['class_id'], 2);
    $cbg2 = 0;
    foreach ($findroleexamtype2 as $key => $item) {

        $html .= '<th style="text-align:center; font-weight:bold;" width="5.8%">
        ' . $item['examprint'] . '<br>(' . $item['maxnumber'] . ')</th>';

        $cbg2 += $item['maxnumber'];
    }

    $html .= '
    <th style="text-align:center; font-weight:bold;" width="5.8%">Marks<br>Obtained<br>
    (100)

    </th>

    <th style="text-align:center; font-weight:bold;" width="5.8%">
    Grade
    </th>

    <th style="text-align:center; font-weight:bold;" width="5.8%">

    </th>
    </tr>';

    $subject = $this->Comman->find_examsubjectsnnupdated($students['class_id']);
    $nontheorysub = $this->Comman->find_nontheorysubject($students['class_id']);
    // pr(count($subject));die;
    $subjectcount = count($subject);

    // // student Attendence term 1
    // $attendnc1 = $this->Comman->findstuattendetails($students['student']['id'], $students['class_id'], $students['sect_id'], 1);

    // // student Attendence term 2
    // $attendnc2 = $this->Comman->findstuattendetails($students['student']['id'], $students['class_id'], $students['sect_id'], $students['term']);

    // student Attendence term 1
    $attendnc1 = $this->Comman->findstuattendetails($students['student']['id'], $students['class_id'], $students['sect_id'], 1, $students['student']['acedmicyear']);
    // pr($attendnc1);exit;

    // student Attendence term 2
    $attendnc2 = $this->Comman->findstuattendetails($students['student']['id'], $students['class_id'], $students['sect_id'], 2, $students['student']['acedmicyear']);

    // pr($attendnc1);die;

    // $attendnc = $this->Comman->findstuattendetails($students['student']['id'], $students['class_id'], $students['sect_id'], $students['term']);

    $subjectcnt = 0;
    $term1overall = 0;
    $term2overall = 0;
    $getgrade = 0;
    $marksobtainedterm2 = 0;
    $marksobtainedterm1 = 0;
    $overall =0;
    $overalls = 0;
    foreach ($subject as $key => $name) { //pr($name);die; 
        $subjectcnt++;
        $html .= '<tr> <td style="height:15px; font-weight:bold; line-height:15px;">&nbsp;' . $name['exprint'] . '</td>';
        $findroleexamtype = $this->Comman->findexamtypesclass($students['class_id'], 1);
        // pr($findroleexamtype);die;
        $ter = 0;
        foreach ($findroleexamtype as $er) {

            $newmarks = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $er['id'], $name['id'], 1, $students['student']['acedmicyear']);
            // pr($newmarks);exit;

            // pr($er['maxnumber']);die;
            if ($newmarks['marks'] != '') {
                // $getgrade = gradecalculation($newmarks['marks'], $er['maxnumber'], 100.0);
                $getgrade = gradecalculation($newmarks['marks'], $er['maxnumber'], 100.0);

                $html .= '<td style="height:15px; line-height:15px; text-align:center;">' . $getgrade . '</td>';
                $ter += $newmarks['marks'];
            } else {
                $html .= '<td style="height:15px; line-height:15px; text-align:center;">---</td>';
            }
        }
        $marksobtainedterm1 = gradecalculation($ter, 100.0, 100.0);
        $term1overall += $ter;
        $allmarksss = $subjectcount * 100;

        $html .= '<td style="height:15px; line-height:15px; text-align:center;">' . $marksobtainedterm1 . '</td>';

        $html .= '<td style="height:15px; line-height:15px; text-align:center;">' . $marksobtainedterm1 . '</td>';

        $findroleexamtype2 = $this->Comman->findexamtypesclass($students['class_id'], 2);
        $ter2 = 0;
        foreach ($findroleexamtype2 as $er) {
            // pr($er);exit;
            $newmarks2 = $this->Comman->fsubjectmarks2($students['stud_id'], $students['sect_id'], $students['class_id'], $er['id'], $name['id'], 2, $students['student']['acedmicyear']);

            if ($newmarks2['marks'] != '') {
                $getgrade2 = gradecalculation($newmarks2['marks'], $er['maxnumber'], 100.0);
                $html .= '<td style="height:15px; line-height:15px; text-align:center;">' . $getgrade2 . '</td>';
                $ter2 += $newmarks2['marks'];
            } else {
                $html .= '<td style="height:15px; line-height:15px; text-align:center;">---</td>';
            }
        }

        $marksobtainedterm2 = gradecalculation($ter2, 100.0, 100.0);

        $term2overall += $ter2;

        $html .= '<td style="height:15px; line-height:15px; text-align:center;">' . $marksobtainedterm2 . '</td>';
        if ($ter2 == 0) {
            $overall = round($ter);
            // pr($overall);exit;
            $overalls = gradecalculation($overall, 100.0, 100.0);
        } else {
            $overall = round($ter + $ter2);
            $overalls = gradecalculation($overall, 200.0, 100.0);
        }



        $html .= '<td style="height:15px; line-height:15px; text-align:center;">' . $marksobtainedterm2 .'</td>
        <td style="height:15px; line-height:15px; text-align:center;">' . $overalls . '</td>';
        $html .= '</tr>';
    }
    // pr($allmarksss);exit;
    $term1overallgrade = gradecalculation($term1overall, $allmarksss, 100.0);
    $term2overallgrade = gradecalculation($term2overall, $allmarksss, 100.0);
    $retVal = ($term2overall == 0) ? '--' : $term2overallgrade;
    // pr($term2overall);exit;
    if ($term2overall == 0) {
        $allmarks = $allmarksss * 1;
        $obtainedfinalmarks = $term1overall;
    } else {
        $allmarks = $allmarksss * 2;
        $obtainedfinalmarks = $term1overall + $term2overall;
    }
    $finalreport = gradecalculation($obtainedfinalmarks, $allmarks, 100.0);

    $html .= '<tr>
        <td width="47.8%" style="height:15px; line-height:15px; text-align:right;">
        Term-I Grade &nbsp;
        </td>
        <td width="5.8%" style="height:15px; line-height:15px; text-align:center;">' . $term1overallgrade . '</td>
        <td width="34.8%" style="height:15px; line-height:15px; text-align:right;">
        Term-II Grade &nbsp;
        </td>
        <td width="5.8%" style="height:15px; line-height:15px; text-align:center;">' . $retVal . '</td>
        <td width="5.8%" style="height:15px; line-height:15px; text-align:center;"></td>
        </tr>

        <tr>
        <td width="94.2%" style="height:15px; line-height:15px; text-align:right;">
        Overall Grade &nbsp;
        </td>

        <td width="5.8%" style="height:15px; line-height:15px; text-align:center;">' . $finalreport . '</td>

        </tr>

        </table>
        <br>
        <br>
        <table width="100%">
        <tr>
        <td style="font-weight:bold;">CO-SCHOLASTIC AREAS
        </td>
        </tr>
        <tr>
        <td style="font-weight:bold;">Class Teachers Remarks Term-I
        </td>
        </tr>

        <tr>
        <td width="100%" style="border:1px solid #000; height:30px; line-height:22px;">&nbsp; ' . ucwords(strtolower($students['student']['fname'])) . '&nbsp;' . ucwords(strtolower($students['student']['middlename'])) . '&nbsp;' . ucwords(strtolower($students['student']['lname'])) . ' &nbsp; ' . ucwords(strtolower($attendnc1['remarks'])) . '.</td>
        </tr>
        </table>

        <table width="100%">

        <tr>
        <td style="font-weight:bold;">Class Teachers Remarks Term-II
        </td>
        </tr>

        <tr>
        <td width="100%" style="border:1px solid #000; height:30px; line-height:22px;">&nbsp; ' . ucwords(strtolower($students['student']['fname'])) . '&nbsp;' . ucwords(strtolower($students['student']['middlename'])) . '&nbsp;' . ucwords(strtolower($students['student']['lname'])) . ' &nbsp; ' . ucwords(strtolower($attendnc2['remarks'])) . '.</td>
        </tr>
        </table>
        <br>
        <br>
       

        <table>
        <tr>
        <td style=" text-align:left; font-weight:bold; border-bottom:1px solid #000; height:28px;" width="33.333%">
        <br><br>
        &nbsp; Date : ' . date("d M,Y") . '<br>
        &nbsp; Place : ' . ucwords(strtolower($findschoolinformation[0]['city'])) . '
        </td>
        <td style="text-align:center; font-weight:bold; border-bottom:1px solid #000; height:28px;" width="33.333%">
        <br><br>
        Class Teachers<br>
        Signature
        </td>
        <td style="text-align:center; font-weight:bold; border-bottom:1px solid #000; height:28px;" width="33.333%">
        <br>
        <br>
        Principal Signature<br><br>
        </td>
        </tr>
        </table>
        <br>
        <br>
        <table width="100%">
        <tr>
        <td width="100%" style="text-align:center; font-weight:bold; font-size:12px;">Instructions</td>
        </tr>
        </table>

        <table>
        <tr>
        <td width="15%"></td>
        <td width="70%">
        <table width="100%" align="center">
        <tr>
        <td width="100%" style="text-align:left; font-weight:bold; font-size:12px;">
        Grading scale for Scholastic Areas:
        </td>
        </tr>
        </table>
        </td>
        <td width="15%"></td>
        </tr>
        </table>


        <table>
        <tr>
        <td width="15%"></td>
        <td width="70%">

        <table width="100%" align="center" border="1">
        <tr>
        <th width="20%" style="text-align:center; font-weight:bold;">
        % Scale
        </th>

        <th style="font-weight:bold;"width="10%">Grade</th>
        <th style="font-weight:bold;" width="70%">Description</th>
        </tr>

        <tr>
        <td width="20%" style="text-align:center;">
        96-100
        </td>

        <td width="10%">O</td>
        <td width="70%">Has an outstanding understanding of the subject</td>
        </tr>

        <tr>
        <td width="20%" style="text-align:center;">
        91-95
        </td>

        <td width="10%">A+</td>
        <td width="70%">Has an excellent understanding of the subject</td>
        </tr>

        <tr>
        <td width="20%" style="text-align:center;">
        86-90
        </td>

        <td width="10%">A</td>
        <td width="70%">Has a deep understanding of the subject</td>
        </tr>

        <tr>
        <td width="20%" style="text-align:center;">
        76-85
        </td>

        <td width="10%">B+</td>
        <td width="70%">Has a good understanding of the subject</td>
        </tr>
        <tr>
        <td width="20%" style="text-align:center;">
        66-75
        </td>

        <td width="10%">B</td>
        <td width="70%">Has a adequate understanding of the subject</td>
        </tr>
        <tr>
        <td width="20%" style="text-align:center;">
        56-65
        </td>

        <td width="10%">C+</td>
        <td width="70%">Has a fair understanding of the subject</td>
        </tr>
        <tr>
        <td width="20%" style="text-align:center;">
        40-55
        </td>

        <td width="10%">D</td>
        <td width="70%">Has a satisfactory understanding of the subject</td>
        </tr>
        <tr>
        <td width="20%" style="text-align:center;">
        32 & Below
        </td>

        <td width="10%">E</td>
        <td width="70%">Needs considerable help in understanding the subject</td>
        </tr>
        </table>
        </td>

        <td width="15%"></td>
        </tr>
        </table>
        </body>

        </html>';
    // pr($html);die;
    $pdf->SetFont('times', '', 10, '', 'false');

    $pdf->WriteHTML($html, true, false, true, false, '');
}
ob_end_clean();
echo $pdf->Output('Result.pdf');
exit;
