<?php

if ($db=='palaceschool') {
    
    $this->element('palaceschool_certificates/palaceschool_transfer_certificate_pdf');
    
    }else{

class xtcpdf extends TCPDF
{
}


$this->set('pdf', new TCPDF('P', 'mm', 'A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();
$pdf->SetFooterMargin(0);
$pdf->SetHeaderMargin(0);
$pdf->SetAutoPageBreak(false, 0);

//pdf->SetY(-550);
$pdf->SetFont('', '', 9, '', 'false');
//pr($student);die;
/*++++++++++++++++++++++++++++++++++++++++++
 **      Processing data for pdf view
 **++++++++++++++++++++++++++++++++++++++++++
 */
$name = $student['fname'] . ' ';
$drop_cnt = $this->Comman->countdropout($student['id']);
//pr($drop_cnt);die;
if (!empty($student['middlename'])) {
    $name .= $student['middlename'] . ' ';
}

$name .= $student['lname'];

$mother_name = $student['mothername'];
$father_name = $student['fathername'];
$guardian = $student['guardian'];
$nationality = $student['nationality'];

if ($student['cast'] == 'SC/ST') {
    $cast = $student['cast'];
} else {
    $cast = $student['cast'];
}

$dob = $student['dob'];
$dob = date('d-m-Y', strtotime($dob));
$dobwords = date('M jS, Y', strtotime($student['dob']));
$admission_date = $student['admissiondate'];
if ($student['laststudclass']) {
    $studencl = $this->Comman->findclass123($student['laststudclass']);
    $current_classwordsc = $studencl['wordsc'];

    if ($student['laststudclass'] == '26') {

        $current_class = 'IBDP Year I';
    } else if ($student['laststudclass'] == '27') {
        $current_class = 'IBDP Year II';
    } else if ($student['laststudclass'] == '23') {
        $current_class = 'Grade 6';
    } else if ($student['laststudclass'] == '24') {
        $current_class = 'Grade 7';
    } else if ($student['laststudclass'] == '25') {
        $current_class = 'Grade 9';
    } else if ($student['laststudclass'] == '28') {
        $current_class = 'Grade 8';
    } else if ($student['laststudclass'] == '29') {
        $current_class = 'Grade 10';
    } else {
        $current_class = $studencl['title'];
    }
} else {
    $current_classwordsc = 'N/A';
    $current_class = 'N/A';
}

$tc_issue_date = date('d-m-Y');

if ($student['board_id'] == '1') {

    $enroll_no2 = "C" . $student['enroll'];
} else if ($student['board_id'] == '2') {
    $enroll_no2 = "CAM" . $student['enroll'];
} elseif ($student['board_id'] == '3') {

    $enroll_no2 = "IB" . $student['enroll'];
}
if ($admission_date == NULL) {
    $userdate = $this->Comman->findcreated($enroll_no2);
    $firstadmissiondate = date('d-m-Y', strtotime($userdate['created']));
} else {
    $firstadmissiondate = date('d-m-Y', strtotime($admission_date));
}



$firstadmissionclass = $student['admissionclass'];
$firstadmissionclassss = $this->Comman->showadmissionclasstitle($student['admissionclass']);
if ($firstadmissionclass == 12 || $firstadmissionclass == 13 || $firstadmissionclass == 15 || $firstadmissionclass == 17 || $firstadmissionclass == 20 || $firstadmissionclass == 22) {
    $pos = strpos($firstadmissionclassss['title'], "-");

    $firstadmissionclass = substr($firstadmissionclassss['title'], 0, $pos);
} else if ($firstadmissionclass == '26') {

    $firstadmissionclass = 'IBDP Year I';
} else if ($firstadmissionclass == '27') {
    $firstadmissionclass = 'IBDP Year II';
} else if ($firstadmissionclass == '23') {
    $firstadmissionclass = 'Grade 6';
} else if ($firstadmissionclass == '24') {
    $firstadmissionclass = 'Grade 7';
} else if ($firstadmissionclass == '25') {
    $firstadmissionclass = 'Grade 9';
} else if ($firstadmissionclass == '28' && $db == "sanskar") {
    $firstadmissionclass = 'MAMTA';
} else if ($firstadmissionclass == '29'  && $db == "sanskar") {
    $firstadmissionclass = 'BHOOMIKA';
} else {
    $firstadmissionclass = $firstadmissionclassss['title'];
}
if ($firstadmissionclass) {
} else {

    $firstadmissionclass = $current_class;
}

$enroll_no = $student['enroll'];
//-----------------------------------------------------------
$sno = $student['id'];
$bookno = empty($student['bookno']) ? '-' : $student['bookno'];
$sino = empty($student['sino']) ? '-' : $student['sino'];
$school_lastresult = empty($student['school_lastresult']) ? '-' : $student['school_lastresult'];
$againclass = empty($student['againclass']) ? '-' : $student['againclass'];
$workingdays = empty($student['workingdays']) ? '-' : $student['workingdays'];
$presentdays = empty($student['presentdays']) ? '-' : $student['presentdays'];
$date_issue = empty($student['date_issue']) ? '-' : date('d-m-Y', strtotime($student['date_issue']));
$date_application = empty($student['date_application']) ? '-' : date('d-m-Y', strtotime($student['date_application']));
$qualified_to_promote = empty($student['qualified_to_promote']) ? '-' : $student['qualified_to_promote'];
$anyfeeconcession = empty($student['anyfeeconcession']) ? '-' : $student['anyfeeconcession'];

$promoted_classr = $this->Comman->findclass($student['promoted_to_class_id']);
if ($qualified_to_promote == "Yes") {
    if ($student['promoted_to_class_id'] == '12' || $student['promoted_to_class_id'] == '13' || $student['promoted_to_class_id'] == '15') {
        $promoted_class = 'XI';
        $promoted_classwords = 'Eleventh';
    } else {
        $promoted_class = empty($promoted_classr['title']) ? '-' : $promoted_classr['title'];
        $promoted_classwords = empty($promoted_classr['wordsc']) ? '-' : $promoted_classr['wordsc'];
    }
} else {
    $promoted_class = '-';
    $promoted_classwords = '-';
}
$NCC_cadet = empty($student['NCC_cadet']) ? '-' : $student['NCC_cadet'];
$extra_curricular_activities = empty($student['extra_curricular_activities']) ? '-' : $student['extra_curricular_activities'];
$achievement_level = empty($student['achievement_level']) ? '-' : $student['achievement_level'];
$general_conduct = empty($student['general_conduct']) ? '-' : $student['general_conduct'];
$leaving_reason = empty($student['leaving_reason']) ? '-' : $student['leaving_reason'];
$remarks = empty($student['remarks']) ? '-' : $student['remarks'];
$subjectsclass = $this->Comman->find_subjects($student['class_id']);


$findfeemonthstudent = $this->Comman->findfeemonthstudent($student['id']);
$finddisountany = $this->Comman->finddisountany($student['id']);

foreach ($finddisountany as $y => $yy) {
    if ($yy['discountcategory'] != '') {

        $discountconsession = $yy['discountcategory'];
    }
}
$feemonthstudent = date('M', strtotime($findfeemonthstudent['paydate']));
if ($discountconsession) {

    $discountconsession = $discountconsession;
} else {
    $discountconsession = "-";
}

$logo = '<img src="images/' . $sitesetting['logo'] . '" alt="" border="0" style="display:block; "width="100px">';

$logo_2 = '<img src="images/' . $sitesetting['logo'] . '" alt="" border="0" style="display:block; "width="150px">';
$logo2 = '<img src="images/' . $sitesetting['tc_logo'] . '" alt="" border="0">';

if ($student['board_id'] == '1') {
    // pr($logo2); die;
    
    // $temp = str_replace(array('{logo1}', '{sitetitle}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}', '{logo2}'), array($logo, $sitesetting['sitetitle'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website'], $logo_2), $det['template']);

    $temp = str_replace(array('{logo1}', '{sitetitle}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}', '{biglogo}'), array($logo2, $sitesetting['sitetitle'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website'], $logo_2), $det['template'],$sitesetting['header_logo']);
  
    

} else {
    if ($student['board_id'] == '3') {
        $sitesetting['subtitle2'] = " School Code-0580";
        $sitesetting['subtitle1'] = "IB WORLD";
    }

    if ($student['laststudclass'] == 29) {


        $sitesetting['subtitle2'] = " School Code-IN 276";
    }
    $temp = str_replace(array('{logo1}', '{sitetitle}', '{subtitle1}', '{subtitle2}', '{address1}', '{address2}', '{phone}', '{fax}', '{email}', '{website}', '{logo2}'), array('', $sitesetting['sitetitle'], $sitesetting['subtitle1'], $sitesetting['subtitle2'], $sitesetting['address1'], $sitesetting['address2'], $sitesetting['phone'], $sitesetting['fax'], $sitesetting['email'], $sitesetting['website'], $logo_2), $det['template']);
}


// for canvas school start

if($db=='kidsclub' || $db=='palaceschool' || $db=='demoschool' || $db=='sanskar' || $db=='rajshree'){

        $html = '
        <!DOCTYPE HTML>
        <html>
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Transfer Certificate</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
        </head>

        <body style=" font-family:"Trebuchet MS", Arial, Helvetica, sans-serif">

        <div id="pageContainer1" style="width:992px; margin:auto;background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.4);
        -moz-box-shadow: 0 0 10px rgba(0,0,0,0.4);
        -webkit-box-shadow: 0 0 10px rgba(0,0,0,0.4);
        -o-box-shadow: 0 0 10px rgba(0,0,0,0.4); padding:30px;">';

        if ($drop_cnt > 1) {
        $html .= '
        <table width="100%">
        <tr>
        <td width="80%"></td>
        <td width="20%" style="border:1px solid #000;" align="center"><a href="javascript:void(0);" style="text-decoration:none; color:#000; width:100px; display:inline-block; border-top:1px solid #000;  border-left:1px solid #000;  border-right:1px solid #000;  border-bottom:1px solid #000;">DUPLICATE</a></td></tr></table>';
        }

        $html .= $temp;

        if ($db == "sanskar") {
        } else {
        $html .= '<br><br>';
        }

        $html .= '<hr><table width="100%">';

        if ($student['board_id'] == '1') {
        $html .= '<tr style="border-top:1px solid #000;">
        <td width="25%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b>Schools Code</b> : &nbsp;' . $sitesetting['school_code'] . '</td>
        <td width="50%" align="center" style="height:19px;"></td>
        <td width="25%" align="right" style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;"><b>S.No</b> : ' . $bookno . '</td>
        </tr>';
        } else {
        }

        if ($student['board_id'] == '3') {
        $sitesetting['affiliation_no'] = "0580";
        }
        if ($student['laststudclass'] == 29) {

        $sitesetting['affiliation_no'] = "IN 276";
        }

        $html .= '<tr>
        <td width="25%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b>Affiliation No</b> : &nbsp;' . $sitesetting['affiliation_no'] . '</td>';

        if ($student['board_id'] == '1') {
        $html .= '<td width="50%"  align="center" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"></td>';
        } else {
        $html .= '<td width="50%"  align="center" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"></td>';
        }
        $html .= '<td width="25%" align="right" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b>Scholar No</b> : ' . $enroll_no . '</td>

        </tr>

        </table>

        <table width="100%">
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">1.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px; ">Name of Pupils : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px; "><b style="">' . ucwords(strtolower($name)) . '</b></td>
        </tr>';

        if ($father_name) {
        $fatherr = "Father's Name";
        $html .= '<tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">2.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">' . $fatherr . ' :</td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;"><b style="">' . ucwords(strtolower($father_name)) . '</b>
        </td>
        </tr>';
        } else {
        $fatherr = "Father's Name";
        $html .= '<tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">2.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">' . $fatherr . ' : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"> <b style="">-</b>
        </td>

        </tr>';
        }

        if ($mother_name) {
        $fatherrs = "Mother's Name";
        $html .= '<tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">3.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">' . $fatherrs . ' : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;"><b style="">' . ucwords(strtolower($mother_name)) . '</b>
        </td>
        </tr>';
        } else {
        $fatherrs = "Mother's Name";
        $html .= '<tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">3.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">' . $fatherrs . ' : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">-</b>

        </td>

        </tr>';
        }

        if ($guardian) {
        $fguard = "Guardian Name";
        $html .= '<tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">4.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">' . $fguard . ' : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;"><b style="">' . ucwords(strtolower($guardian)) . '</b>
        </td>
        </tr>';
        } else {

        $fguard = "Guardian Name";
        $html .= '<tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">4.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">' . $fguard . ' : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;"><b style="">-</b>
        </td>
        </tr>';
        }

        $ec = $this->Comman->findfeesmonth34($student['id']);

        $monthupto = $student['month'];

        $html .= '<tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">5.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Nationality : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . ucwords(strtolower($nationality)) . '</b>
        </td>
        </tr>



        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">6.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Whether the Candidate belongs to Schedule Caste or Schedule Tribe : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . $cast . '</b></td>
        </tr>

        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">7.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;">Date of first admission in the school with class : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;"><b style="">' . $firstadmissiondate . ' / ' . $firstadmissionclass . '</b></td>
        </tr>

        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">8.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Date of Birth(in Christian Era) according  to Admission Register (In Figures) : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . $dob . '</b>  &nbsp; (In Words) : <b style="">' . $dobwords . '</b>  </td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">9.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;">Class in which pupil last studied (In Figures): </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;"><b style="">' . $current_class . '</b>    &nbsp; (In Words) : <b style="">' . $current_classwordsc . '</b>  </td>
        </tr>';

        if ($student['board_id'] == '1') {

        $html .= '<tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">10.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Result of School/Board Annual Examination last taken: </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . $school_lastresult . '</b> </td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">11.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;">If failed,whether once/twice in the same class : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;"><b style="">' . $againclass . '</b> </td>
        </tr>
        <tr>';

        if (!empty($selected)) {
        $sel = explode(",", $selected);
        }
        if (!empty($select1)) {
        $opt = explode(",", $select1);
        }

        $opts = array();

        if ($student['tcsubject']) {

        $opts = explode(",", $student['tcsubject']);
        }

        if ($student['laststudclass']) {
        $studenta['class_id'] = $student['laststudclass'];
        } else {

        $studenta['class_id'] = $student['class_id'];
        }
        if ($db == "sanskar") {
        if ($studenta['class_id'] == 12 || $studenta['class_id'] == 13 || $studenta['class_id'] == 15 || $studenta['class_id'] == 17 || $studenta['class_id'] == 20 || $studenta['class_id'] == 22 || $class_id == 23 || $class_id == 24 || $class_id == 26 || $class_id == 25 || $class_id == 28 || $class_id == 29) {

            $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">12.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;">';

            $cnt = 1;
            if (isset($sel)) {
                foreach ($sel as $ki => $ji) {

                    $subjj = $this->Comman->findclassubject($ji);

                    if (strtoupper($subjj['name']) == "PSYCHOLOGY_M") {

                        $html .= $cnt++ . '. <b style="">PSYCHOLOGY</b>&nbsp;';
                    } else {
                        $html .= $cnt++ . '. <b style="">' . strtoupper($subjj['name']) . '</b>&nbsp;&nbsp;';
                    }
                }
            }
            if (isset($opt)) {
                foreach ($opt as $kis => $jis) {
                    $subjjopt = $this->Comman->findclassubject($jis);

                    if (strtoupper($subjjopt['name']) == "PSYCHOLOGY_M") {

                        $html .= $cnt++ . '. <b style="">PSYCHOLOGY</b>&nbsp;';
                    } else {
                        $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopt['name']) . '</b>&nbsp;&nbsp;';
                    }
                }
            }
            $html .= '</td>';
        } else if ($studenta['class_id'] == '18' || $studenta['class_id'] == '19' || $studenta['class_id'] == '1' || $studenta['class_id'] == '2' || $studenta['class_id'] == '3' || $studenta['class_id'] == '4' || $studenta['class_id'] == '5' || $studenta['class_id'] == '6') {

            $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">12.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;">';

            $cnt = 1;
            //pr($opts);die;
            if (isset($opts)) {
                foreach ($opts as $kiss => $jiss) {
                    $subjjopts = $this->Comman->find_subjectsprinttcprint($jiss);
                    $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopts['name']) . '</b>&nbsp;&nbsp;';
                }
            }
            $html .= '</td>';
        } else if ($studenta['class_id'] == '7' || $studenta['class_id'] == '8' || $studenta['class_id'] == '9' || $studenta['class_id'] == '10' || $studenta['class_id'] == '11' || $studenta['class_id'] == '23' || $studenta['class_id'] == '24' || $studenta['class_id'] == '25' || $studenta['class_id'] == '26' || $studenta['class_id'] == '27' || $studenta['class_id'] == '28' || $studenta['class_id'] == '29') {

            $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">12.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;">';

            $cnt = 1;

            if (isset($opts)) {
                foreach ($opts as $kiss => $jiss) {
                    $subjjopts = $this->Comman->find_subjectsexprintertitle($jiss);
                    $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopts['exprint']) . '</b>&nbsp;&nbsp;';
                }
            }
            $html .= '</td>';
        }
        } else {

        $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">12.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;">';

        $cnt = 1;

        if (isset($opts)) {
            foreach ($opts as $kiss => $jiss) {
                $subjjopts = $this->Comman->find_subjectsexprintertitle($jiss);
                $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopts['exprint']) . '</b>&nbsp;&nbsp;';
            }
        }
        $html .= '</td>';
        }

        if ($student['laststudclass'] == '17' || $student['laststudclass'] == '20' || $student['laststudclass'] == '22') {
        $promoted_class = "-";
        $promoted_classwords = "HIGHER STUDY";
        }
        $html .= '</tr>

        </table>
        <table width="100%">

        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">13.</td>
        <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Whether Qualified for Promotion to Higher Class(Yes/No) : <br>If so, to which class (In figures) : </td>
        <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" > <b style="">' . $qualified_to_promote . '</b><br> <b style="">' . $promoted_class . '</b> &nbsp; (In Words) : <b style="">' . $promoted_classwords . '</b> </td>
        </tr><br>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">14.</td>
        <td  width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Month upto which the school fee is paid :</td>
        <td  width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style=""> ' . $monthupto . '</b></td>
        </tr>

        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">15.</td>
        <td  width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Any fee concession availed of:&nbsp;&nbsp; if so,the nature of such concession : </td>
        <td  width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" > <b style="">' . $anyfeeconcession . '</b></td>
        </tr>
        </table>

        <table width="100%">
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">16.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;" >Total number of working days : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;" ><b style="">' . $workingdays . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">17.</td>
        <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Total number of working days present :</td>
        <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b style="">' . $presentdays . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">18.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Whether NCC Cadet/Boy Scout/Girl Guide(Detail may be given) : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" > <b style="">' . $NCC_cadet . '</b></td>
        </tr>

        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">19.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px; " >Games Played or Extra Curricular Activities in which the student usually took part<br><span style="font-size:9px; color:#000;height:19px;line-height:23px;">(Mention achievement level therein) :</span></td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px; " > <b style="">' . $extra_curricular_activities . ' / ' . $achievement_level . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">20.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >General Conduct : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b style="">' . $general_conduct . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">21.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Date of Application of Certificate :</td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b style="">' . $date_application . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">22.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Date of Issue of Certificate :</td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . $date_issue . '</b></td>
        </tr>

        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">23.</td>
        <td  width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Reason for Leaving the School : </td>
        <td  width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b  style="">' . $leaving_reason . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:25px;">24.</td>
        <td  width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:25px;">Any Other Remarks : </td>
        <td  width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:25px;"><b style="">' . $remarks . '</b></td>
        </tr>';
        } else {

        $html .= '
        <tr>';

        if (!empty($selected)) {
        $sel = explode(",", $selected);
        }
        if (!empty($select1)) {
        $opt = explode(",", $select1);
        }

        $opts = array();

        if ($student['tcsubject']) {
        $opts = explode(",", $student['tcsubject']);
        }

        //~ if($student['laststudclass']){
        //~ $studenta['class_id']=$student['laststudclass'];
        //~ }else{

        $studenta['class_id'] = $student['class_id'];
        //}

        if ($studenta['class_id'] == '26' || $studenta['class_id'] == '27') {

        $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">10.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied: </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">';

        $cnt = 1;

        if (isset($opts)) {
            foreach ($opts as $kiss => $jiss) {
                $subjjopts = $this->Comman->find_subjectsexprintertitle($jiss);
                $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopts['exprint']) . '</b>&nbsp;&nbsp;';
            }
        }
        $html .= '</td>';
        } else if ($studenta['class_id'] == 12 || $studenta['class_id'] == 13 || $studenta['class_id'] == 15 || $studenta['class_id'] == 17 || $studenta['class_id'] == 20 || $studenta['class_id'] == 22 || $class_id == 23 || $class_id == 24 || $class_id == 25 || $class_id == 28 || $class_id == 29) {

        $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">10.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td><td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">';

        $cnt = 1;
        if (isset($sel)) {
            foreach ($sel as $ki => $ji) {

                $subjj = $this->Comman->findclassubject($ji);

                if (strtoupper($subjj['name']) == "PSYCHOLOGY_M") {

                    $html .= $cnt++ . '. <b style="">PSYCHOLOGY</b>&nbsp;';
                } else {
                    $html .= $cnt++ . '. <b style="">' . strtoupper($subjj['name']) . '</b>&nbsp;&nbsp;';
                }
            }
        }
        if (isset($opt)) {
            foreach ($opt as $kis => $jis) {
                $subjjopt = $this->Comman->findclassubject($jis);

                if (strtoupper($subjjopt['name']) == "PSYCHOLOGY_M") {

                    $html .= $cnt++ . '. <b style="">PSYCHOLOGY</b>&nbsp;';
                } else {
                    $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopt['name']) . '</b>&nbsp;&nbsp;';
                }
            }
        }
        $html .= '</td>';
        } else if ($studenta['class_id'] == '18' || $studenta['class_id'] == '19' || $studenta['class_id'] == '1' || $studenta['class_id'] == '2' || $studenta['class_id'] == '3' || $studenta['class_id'] == '4' || $studenta['class_id'] == '5' || $studenta['class_id'] == '6') {

        $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">10.</td><td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td><td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">';

        $cnt = 1;

        if (isset($opts)) {
            foreach ($opts as $kiss => $jiss) {
                $subjjopts = $this->Comman->find_subjectsprinttcprint($jiss);
                $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopts['name']) . '</b>&nbsp;&nbsp;';
            }
        }
        $html .= '</td>';
        } else if ($studenta['class_id'] == '7' || $studenta['class_id'] == '8' || $studenta['class_id'] == '9' || $studenta['class_id'] == '10' || $studenta['class_id'] == '11' || $studenta['class_id'] == '23' || $studenta['class_id'] == '24' || $studenta['class_id'] == '25' || $studenta['class_id'] == '28' || $studenta['class_id'] == '29') {

        $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">10.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"> ';

        $cnt = 1;

        if (isset($opts)) {
            foreach ($opts as $kiss => $jiss) {
                $subjjopts = $this->Comman->find_subjectsexprintertitle($jiss);
                $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopts['exprint']) . '</b>&nbsp;&nbsp;';
            }
        }
        $html .= '</td>';
        }
        if ($student['laststudclass'] == '17' || $student['laststudclass'] == '20' || $student['laststudclass'] == '22') {
        $promoted_class = "-";
        $promoted_classwords = "HIGHER STUDY";
        }
        $html .= '</tr><br>

        </table>
        <table width="100%">
        <tr></tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">11.</td>
        <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Whether Qualified for Promotion to Higher Class(Yes/No) :<br> If so, to which class (In figures) :  </td>
        <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" > <b style="">' . $qualified_to_promote . '</b><br><b style="">' . $promoted_class . '</b> &nbsp; (In Words) : <b style="">' . $promoted_classwords . '</b> </td>
        </tr><br>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">12.</td>
        <td  width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Month upto which the school fee is paid :</td>
        <td  width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style=""> ' . $monthupto . '</b></td>
        </tr>

        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">13.</td>
        <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Any fee concession availed of:&nbsp;&nbsp; if so,the nature of such concession : </td>
        <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b style="">' . $anyfeeconcession . '</b></td>
        </tr>
        </table>

        <table width="100%">
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">14.</td>
        <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;" >Total no of working days : </td>
        <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;" ><b style="">' . $workingdays . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">15.</td>
        <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Total no of working days present : </td>
        <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b style="">' . $presentdays . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">16.</td>
        <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Whether NCC Cadet/Boy Scout/Girl Guide(Detail may be given) : </td>
        <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" > <b style="">' . $NCC_cadet . '</b></td>
        </tr>

        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">17.</td>
        <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px; " >Games Played or Extra Curricular Activities in which the student usually took part<br><span style="font-size:9px; color:#000;height:19px;line-height:23px;">(Mention achievement level therein) :</span></td>
        <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px; " > <b style="">' . $extra_curricular_activities . ' / ' . $achievement_level . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">18.</td>
        <td width="45%" align="left"   style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >General Conduct : </td>
        <td width="50%" align="left"   style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" > <b style="">' . $general_conduct . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">19.</td>
        <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Date of Application of Certificate :</td>
        <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b style="">' . $date_application . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">20.</td>
        <td  width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Date of Issue of Certificate :</td>
        <td  width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . $date_issue . '</b></td>
        </tr>

        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">21.</td>
        <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Reason for Leaving the School :</td>
        <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b  style="">' . $leaving_reason . '</b></td>
        </tr>
        <tr>
        <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:25px;">22.</td>
        <td width="45%" align="left"   style="font-size:9px; color:#000; text-transform:uppercase; height:25px;">Any Other Remarks : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:25px;"> <b style="">' . $remarks . '</b></td>
        </tr>';
        }

        $html .= '</table>
        <br><br>
        <table width="100%">
        <tr>
        <td width="6%"></td>
        <td  style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:12px;" width="21%">
        <b style="display:block; text-align:center;">Signature of Class Teacher</b>
        </td>
        <td width="6%"></td>
        <td width="6%"></td>
        <td  style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:12px;" width="22%">
        <b style="display:block; text-align:center;">Checked By (State full)<br>Name and Designation</b>
        </td>
        <td width="6%"></td>
        <td width="6%"></td>
        <td  style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:12px;" width="21%">
        <b style="display:block; text-align:center;">Principal\'s Signature<br>(With Seal)</b>
        </td>
        <td width="6%"></td>
        </tr>
        </table>
        <br>
        <hr>
        <table width="100%" style="padding-top:15px;">
        <tr>
        <td width="70%" style="font-size:8px; color:#000; text-transform:uppercase; text-align:left; height:12px;">
        <b>Note:</b><br>
        (1) No change in entries in this certificate shall be made except by the authority issuing it.<br>
        (2) Any infringement of this certificate is liable to be dealt with suitable punishment.
        </td>
        <td width="15%"></td>
        </tr>
        </table>
        </div>
        </div>
        </body>
        </html>';
}
else{

    // echo "Under Maintanace";die;

    $html = '
    <!DOCTYPE HTML>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Transfer Certificate</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    </head>

    <body style=" font-family:"Trebuchet MS", Arial, Helvetica, sans-serif">

    <div id="pageContainer1" style="width:992px; margin:auto;background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.4);
    -moz-box-shadow: 0 0 10px rgba(0,0,0,0.4);
    -webkit-box-shadow: 0 0 10px rgba(0,0,0,0.4);
    -o-box-shadow: 0 0 10px rgba(0,0,0,0.4); padding:30px;">';

    if ($drop_cnt > 1) {
        $html .= '
        <table width="100%">
        <tr>
        <td width="80%"></td>
        <td width="20%" style="border:1px solid #000;" align="center"><a href="javascript:void(0);" style="text-decoration:none; color:#000; width:100px; display:inline-block; border-top:1px solid #000;  border-left:1px solid #000;  border-right:1px solid #000;  border-bottom:1px solid #000;">DUPLICATE</a></td></tr></table>';
    }

    $html .= $temp;

    if ($db == "sanskar") {
    } else {
        $html .= '<br><br>';
    }

    $html .= '<hr><table width="100%">';

    if ($student['board_id'] == '1') {
        $html .= '<tr style="border-top:1px solid #000;">
    <td width="25%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b>Schools Code</b> : &nbsp;' . $sitesetting['school_code'] . '</td>
    <td width="50%" align="center" style="height:19px;"></td>
    <td width="25%" align="right" style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;"><b>S.No</b> : ' . $bookno . '</td>
    </tr>';
    } else {
    }

    if ($student['board_id'] == '3') {
        $sitesetting['affiliation_no'] = "0580";
    }
    if ($student['laststudclass'] == 29) {

        $sitesetting['affiliation_no'] = "IN 276";
    }

    $html .= '<tr>
    <td width="25%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b>Affiliation No</b> : &nbsp;' . $sitesetting['affiliation_no'] . '</td>';

    if ($student['board_id'] == '1') {
        $html .= '<td width="50%"  align="center" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"></td>';
    } else {
        $html .= '<td width="50%"  align="center" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"></td>';
    }
    $html .= '<td width="25%" align="right" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b>Scholar No</b> : ' . $enroll_no . '</td>

    </tr>

    </table>

    <table width="100%">
    <tr>
    <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">1.</td>
    <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px; ">Name of Pupils : </td>
    <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px; "><b style="">' . ucwords(strtolower($name)) . '</b></td>
    </tr>';

    if ($father_name) {
                $fatherr = "Father's Name";
                $html .= '<tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">2.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">' . $fatherr . ' :</td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;"><b style="">' . ucwords(strtolower($father_name)) . '</b>
            </td>
            </tr>';
            } else {
                $fatherr = "Father's Name";
                $html .= '<tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">2.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">' . $fatherr . ' : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"> <b style="">-</b>
            </td>

            </tr>';
    }

    if ($mother_name) {
                $fatherrs = "Mother's Name";
                $html .= '<tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">3.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">' . $fatherrs . ' : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;"><b style="">' . ucwords(strtolower($mother_name)) . '</b>
            </td>
            </tr>';
            } else {
                $fatherrs = "Mother's Name";
                $html .= '<tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">3.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">' . $fatherrs . ' : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">-</b>

            </td>

            </tr>';
    }

    if ($student['cast'] == 'SC/ST') {
        $cast = ucwords(strtolower($student['cast']));
    } else {
        $cast = 'N/A';
    }

    if ($guardian) {
            $fguard = "Guardian Name";
            $html .= '<tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">4.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">' . $fguard . ' : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;"><b style="">' . ucwords(strtolower($guardian)) . '</b>
            </td>
            </tr>';
    } else {

                $fguard = "Guardian Name";
                $html .= '<tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">4.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">' . $fguard . ' : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;"><b style="">' . ucwords(strtolower($father_name)) . '</b>
            </td>
            </tr>';
            }

            $ec = $this->Comman->findfeesmonth34($student['id']);

            $monthupto = $student['month'];

            $html .= '<tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">5.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Nationality : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . ucwords(strtolower($nationality)) . '</b>
            </td>
            </tr>



            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">6.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Whether the Candidate belongs to Schedule Caste or Schedule Tribe : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . $cast . '</b></td>
            </tr>

            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">7.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;">Date of first admission in the school with class : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;"><b style="">' . $firstadmissiondate . ' / ' . $firstadmissionclass . '</b></td>
            </tr>

            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">8.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Date of Birth(in Christian Era) according  to Admission Register (In Figures) : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . $dob . '</b>  &nbsp; (In Words) : <b style="">' . $dobwords . '</b>  </td>
            </tr>
            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">9.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;">Class in which pupil last studied (In Figures): </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; text-align:left; height:19px;"><b style="">' . $current_class . '</b>    &nbsp; (In Words) : <b style="">' . $current_classwordsc . '</b>  </td>
            </tr>';

    if ($student['board_id'] == '1') {
        // pr($againclass);die;
        if($school_lastresult=='-'){
            $school_lastresult = 'N/A';
        }else{
            $school_lastresult = $school_lastresult;
        }

        if($againclass=='-'){
            $againclass = 'N/A';
        }else{
            $againclass = $againclass;
        }

            $html .= '<tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">10.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Result of School/Board Annual Examination last taken: </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . $school_lastresult . '</b> </td>
            </tr>
            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">11.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;">If failed,whether once/twice in the same class : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;"><b style="">' . $againclass . '</b> </td>
            </tr>
            <tr>';

        if (!empty($selected)) {
            $sel = explode(",", $selected);
        }
        if (!empty($select1)) {
            $opt = explode(",", $select1);
        }

        $opts = array();

        if ($student['tcsubject']) {

            $opts = explode(",", $student['tcsubject']);
        }

        if ($student['laststudclass']) {
            $studenta['class_id'] = $student['laststudclass'];
        } else {

            $studenta['class_id'] = $student['class_id'];
        }

            $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">12.</td>
        <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td>
        <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;height:19px;">';

            $cnt = 1;

            if (isset($opts)) {
                foreach ($opts as $kiss => $jiss) {
                    $subjjopts = $this->Comman->find_subjectsexprintertitle($jiss);
                    $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopts['exprint']) . '</b>&nbsp;&nbsp;';
                }
            }
            $html .= '</td>';
        // }

        if ($student['laststudclass'] == '17' || $student['laststudclass'] == '20' || $student['laststudclass'] == '22') {
            $promoted_class = "-";
            $promoted_classwords = "HIGHER STUDY";
        }
        $html .= '</tr>
            </table>
            <table width="100%">

            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">13.</td>
            <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Whether Qualified for Promotion to Higher Class(Yes/No) : <br>If so, to which class (In figures) : </td>
            <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" > <b style="">' . $qualified_to_promote . '</b><br> <b style="">' . $promoted_class . '</b> &nbsp; (In Words) : <b style="">' . $promoted_classwords . '</b> </td>
            </tr><br>
            </table>

            <table width="100%">
            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">14.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;" >Total number of working days : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;" ><b style="">' . $workingdays . '</b></td>
            </tr>
            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">15.</td>
            <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Total number of working days present :</td>
            <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b style="">' . $presentdays . '</b></td>
            </tr>

            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">16.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >General Conduct : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b style="">' . $general_conduct . '</b></td>
            </tr>
            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">17.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Date of Application of Certificate :</td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b style="">' . $date_application . '</b></td>
            </tr>
            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">18.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Date of Issue of Certificate :</td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . $date_issue . '</b></td>
            </tr>

            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">19.</td>
            <td  width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Reason for Leaving the School : </td>
            <td  width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b  style="">' . $leaving_reason . '</b></td>
            </tr>';
    } else {

        $html .= '<tr>';

        if (!empty($selected)) {
            $sel = explode(",", $selected);
        }
        if (!empty($select1)) {
            $opt = explode(",", $select1);
        }

        $opts = array();

        if ($student['tcsubject']) {
            $opts = explode(",", $student['tcsubject']);
        }

        //~ if($student['laststudclass']){
        //~ $studenta['class_id']=$student['laststudclass'];
        //~ }else{

        $studenta['class_id'] = $student['class_id'];
        //}

        if ($studenta['class_id'] == '26' || $studenta['class_id'] == '27') {

            $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">10.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied: </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">';

            $cnt = 1;

            if (isset($opts)) {
                foreach ($opts as $kiss => $jiss) {
                    $subjjopts = $this->Comman->find_subjectsexprintertitle($jiss);
                    $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopts['exprint']) . '</b>&nbsp;&nbsp;';
                }
            }
                $html .= '</td>';
            } else if ($studenta['class_id'] == 12 || $studenta['class_id'] == 13 || $studenta['class_id'] == 15 || $studenta['class_id'] == 17 || $studenta['class_id'] == 20 || $studenta['class_id'] == 22 || $class_id == 23 || $class_id == 24 || $class_id == 25 || $class_id == 28 || $class_id == 29) {

                    $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">10.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td><td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">';

            $cnt = 1;
            if (isset($sel)) {
                foreach ($sel as $ki => $ji) {

                    $subjj = $this->Comman->findclassubject($ji);

                    if (strtoupper($subjj['name']) == "PSYCHOLOGY_M") {

                        $html .= $cnt++ . '. <b style="">PSYCHOLOGY</b>&nbsp;';
                    } else {
                        $html .= $cnt++ . '. <b style="">' . strtoupper($subjj['name']) . '</b>&nbsp;&nbsp;';
                    }
                }
            }
            if (isset($opt)) {
                foreach ($opt as $kis => $jis) {
                    $subjjopt = $this->Comman->findclassubject($jis);

                    if (strtoupper($subjjopt['name']) == "PSYCHOLOGY_M") {

                        $html .= $cnt++ . '. <b style="">PSYCHOLOGY</b>&nbsp;';
                    } else {
                        $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopt['name']) . '</b>&nbsp;&nbsp;';
                    }
                }
            }
            $html .= '</td>';
        } else if ($studenta['class_id'] == '18' || $studenta['class_id'] == '19' || $studenta['class_id'] == '1' || $studenta['class_id'] == '2' || $studenta['class_id'] == '3' || $studenta['class_id'] == '4' || $studenta['class_id'] == '5' || $studenta['class_id'] == '6') {

            $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">10.</td><td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td><td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">';

            $cnt = 1;

            if (isset($opts)) {
                foreach ($opts as $kiss => $jiss) {
                    $subjjopts = $this->Comman->find_subjectsprinttcprint($jiss);
                    $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopts['name']) . '</b>&nbsp;&nbsp;';
                }
            }
                $html .= '</td>';
            } else if ($studenta['class_id'] == '7' || $studenta['class_id'] == '8' || $studenta['class_id'] == '9' || $studenta['class_id'] == '10' || $studenta['class_id'] == '11' || $studenta['class_id'] == '23' || $studenta['class_id'] == '24' || $studenta['class_id'] == '25' || $studenta['class_id'] == '28' || $studenta['class_id'] == '29') {

                    $html .= '<td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">10.</td>
            <td width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Subject Studied : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"> ';

            $cnt = 1;

            if (isset($opts)) {
                foreach ($opts as $kiss => $jiss) {
                    $subjjopts = $this->Comman->find_subjectsexprintertitle($jiss);
                    $html .= $cnt++ . '. <b style="">' . strtoupper($subjjopts['exprint']) . '</b>&nbsp;&nbsp;';
                }
            }
            $html .= '</td>';
        }
        if ($student['laststudclass'] == '17' || $student['laststudclass'] == '20' || $student['laststudclass'] == '22') {
            $promoted_class = "-";
            $promoted_classwords = "HIGHER STUDY";
        }
        $html .= '</tr><br>

            </table>
            <table width="100%">
            <tr></tr>
            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">11.</td>
            <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Whether Qualified for Promotion to Higher Class(Yes/No) :<br> If so, to which class (In figures) :  </td>
            <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" > <b style="">' . $qualified_to_promote . '</b><br><b style="">' . $promoted_class . '</b> &nbsp; (In Words) : <b style="">' . $promoted_classwords . '</b> </td>
            </tr><br>
            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">12.</td>
            <td  width="45%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Month upto which the school fee is paid :</td>
            <td  width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style=""> ' . $monthupto . '</b></td>
            </tr>

            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">13.</td>
            <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Any fee concession availed of:&nbsp;&nbsp; if so,the nature of such concession : </td>
            <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b style="">' . $anyfeeconcession . '</b></td>
            </tr>
            </table>

            <table width="100%">

            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">14.</td>
            <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Whether NCC Cadet/Boy Scout/Girl Guide(Detail may be given) : </td>
            <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" > <b style="">' . $NCC_cadet . '</b></td>
            </tr>

            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">15.</td>
            <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px; " >Games Played or Extra Curricular Activities in which the student usually took part<br><span style="font-size:9px; color:#000;height:19px;line-height:23px;">(Mention achievement level therein) :</span></td>
            <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px; " > <b style="">' . $extra_curricular_activities . ' / ' . $achievement_level . '</b></td>
            </tr>

            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">16.</td>
            <td  width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;">Date of Issue of Certificate :</td>
            <td  width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;"><b style="">' . $date_issue . '</b></td>
            </tr>

            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:19px;">17.</td>
            <td width="45%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" >Reason for Leaving the School :</td>
            <td width="50%" align="left"  style="font-size:9px; color:#000; text-transform:uppercase; height:19px;" ><b  style="">' . $leaving_reason . '</b></td>
            </tr>
            <tr>
            <td width="5%" align="left" style="font-size:9px; color:#000; text-transform:uppercase;  height:25px;">18.</td>
            <td width="45%" align="left"   style="font-size:9px; color:#000; text-transform:uppercase; height:25px;">Any Other Remarks : </td>
            <td width="50%" align="left" style="font-size:9px; color:#000; text-transform:uppercase; height:25px;"> <b style="">' . $remarks . '</b></td>
            </tr>';
    }

    $html .= '</table>
    <br><br><br>
    <br>
    <br>
    <br>
    <br>
    <br><table width="100%">
    <tr>
    <td width="6%"></td>
    <td  style="font-size:9px; color:#000; text-transform:uppercase; text-align:center; height:12px;" width="21%">
    <b style="display:block; text-align:center;">Signature of Class Teacher</b>
    </td>
    <td width="6%"></td>
    <td width="6%"></td>    
    <td width="18%"> 
    </td>    
    <td width="6%"></td>
    <td width="6%"></td>
    <td  style="font-size:9px; color:#000; text-transform:uppercase; text-align:center; height:12px;" width="21%">
    <b style="display:block; text-align:center;">Principal\'s Signature<br>(With Seal)</b>
    </td>
    <td width="6%"></td>
    </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>  
    <hr>
    <table width="100%" style="padding-top:15px;">
    <tr>
    <td width="70%" style="font-size:8px; color:#000; text-transform:uppercase; text-align:left; height:12px;">
    <b>Note:</b><br>
    (1) No change in entries in this certificate shall be made except by the authority issuing it.<br>
    (2) Any infringement of this certificate is liable to be dealt with suitable punishment.
    </td>
    <td width="15%"></td>
    </tr>
    </table>
    </div>
    </div>
    </body>
    </html>';

// canvas school area end 
}

$pdf->WriteHTML($html);
ob_end_clean();
echo $pdf->Output('tc.pdf');
exit();

}