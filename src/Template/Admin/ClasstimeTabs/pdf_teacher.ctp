<?php
class xtcpdf extends TCPDF
{
}
$this->set('pdf', new TCPDF('P', 'mm', 'A6'));
$pdf = new TCPDF("L", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();

//pdf->SetY(-550);
$pdf->SetFont('', '', 9, '', 'true');
$html = '

<span style="text-align:center;  line-height:40px; display:block"><b> TIME TABLE : </b><span>' . $fname . ' ' . $middlename . ' ' . $lname . '</span>&nbsp;</span><br><br>
 <table style="width:100%;" align="center">
        		<thead>
        			<tr align="center"><th style="width:17%; background-color:#39cccc;  text-align:center; margin-right:1px; color:#fff;">Class Timing</th>
        				<th style="width:14%; background-color:#39cccc;   text-align:center; color:#fff;">Monday</th>
        				<th style="width:14%; background-color:#39cccc;   text-align:center; color:#fff;">Tuesday</th>
        				<th style="width:14%; background-color:#39cccc;   text-align:center; color:#fff;">Wednesday</th>
        				<th style="width:14%; background-color:#39cccc;   text-align:center; color:#fff;">Thursday</th>
        				<th style="width:14%; background-color:#39cccc;  text-align:center; color:#fff;">Friday</th>
        				<th style="width:14%; background-color:#39cccc;   text-align:center; color:#fff;">Saturday</th></tr>
        		</thead>
     <tbody>';



if (isset($timetabledata) && !empty($timetabledata)) {
  foreach ($timetabledata as $work) {
    $getdata = '0';
    if ($work['is_break'] != 1) {
      $getdata = $this->Comman->gettimetableteacher($work['id'], "Monday", $classectionid);
      $a = array();
      foreach ($getdata as $key => $value2) {
        $a[] = $value2['class_id'];
      }

      $emp = explode(',', $getdata[0]['employee_id']);
      $sub = explode(',', $getdata[0]['subject_id']);
      $subjectname = array();
      foreach ($emp as $k => $value) {
        foreach ($sub as $s => $val) {
          $vbn = array();
          if ($k == $s && $value == $classectionid) {
            $subj = $this->Comman->findclassubject($val);
            $subjectname[$val] = $subj['alias'];
          }
        }
      }


      $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
      $class = $clsssection['class_id'];
      $section = $clsssection['section_id'];
      $classtitle = $clsssection['Classes']['title'];
      $sectiontitle = $clsssection['Sections']['title'];

      $html .= '<tr align="center"><td  style="width:17%;    text-align:center; border-left:1px solid #e0e0e0; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;">' . $work['name'] . '</td><td style="width:14%; margin-top:26px;  text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;">';
      if (strpos($work['weekday'], "Monday") !== false) {
        $html .= '<span   rel="tooltip" data-toggle="tooltip" title="">';
        if (!empty($getdata)) {
          $b = array_unique($a);
          foreach ($subjectname as $ko => $bhu) {
            $html .= '<span style="color:green;">' . $bhu . '</span><br>';
          }

          foreach ($b as $key => $va) {
            $sdf = $this->Comman->findclasssectionid($va);

            $sec = $sdf['section_id'];
            $cls = $sdf['class_id'];
            $cl1 = $this->Comman->findclass123($cls);
            $sl2 = $this->Comman->findsection123($sec);
            $html .= $cl1['title'] . '(' . $sl2['title'] . ')<br>';
          }
        } else {
          $html .= 'N.A.';
        }
        $html .= '</span>';
      }
      $html .= '</td>';
      $getdata = $this->Comman->gettimetableteacher($work['id'], "Tuesday", $classectionid);
      $a = array();
      foreach ($getdata as $key => $value2) {
        $a[] = $value2['class_id'];
      }
      $emp = explode(',', $getdata[0]['employee_id']);
      $sub = explode(',', $getdata[0]['subject_id']);
      $subjectname = array();
      foreach ($emp as $k => $value) {
        foreach ($sub as $s => $val) {
          $vbn = array();
          if ($k == $s && $value == $classectionid) {
            $subj = $this->Comman->findclassubject($val);
            $subjectname[$val] = $subj['alias'];
          }
        }
      }


      $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
      $class = $clsssection['class_id'];
      $section = $clsssection['section_id'];
      $classtitle = $clsssection['Classes']['title'];
      $sectiontitle = $clsssection['Sections']['title'];

      $html .= '<td class="text-center" style="white-space: pre-wrap; word-break: keep-all; width:14%;   text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;">';
      if (strpos($work['weekday'], "Tuesday") !== false) {
        $html .= '<span   rel="tooltip" data-toggle="tooltip" title="">';
        if (!empty($getdata)) {

          $b = array_unique($a);
          foreach ($subjectname as $ko => $bhu) {
            $html .= '<span style="color:green;">' . $bhu . '</span><br>';
          }

          foreach ($b as $key => $va) {
            $sdf = $this->Comman->findclasssectionid($va);

            $sec = $sdf['section_id'];
            $cls = $sdf['class_id'];
            $cl1 = $this->Comman->findclass123($cls);
            $sl2 = $this->Comman->findsection123($sec);
            $html .= $cl1['title'] . '(' . $sl2['title'] . ')<br>';
          }
        } else {
          $html .= 'N.A.';
        }


        $html .= '</span>';
      }
      $html .= '</td>';
      $getdata = $this->Comman->gettimetableteacher($work['id'], "Wednesday", $classectionid);
      $a = array();
      foreach ($getdata as $key => $value2) {
        $a[] = $value2['class_id'];
      }

      $emp = explode(',', $getdata[0]['employee_id']);
      $sub = explode(',', $getdata[0]['subject_id']);
      $subjectname = array();
      foreach ($emp as $k => $value) {
        foreach ($sub as $s => $val) {
          $vbn = array();
          if ($k == $s && $value == $classectionid) {
            $subj = $this->Comman->findclassubject($val);
            $subjectname[$val] = $subj['alias'];
          }
        }
      }

      $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
      $class = $clsssection['class_id'];
      $section = $clsssection['section_id'];
      $classtitle = $clsssection['Classes']['title'];
      $sectiontitle = $clsssection['Sections']['title'];

      $html .= '<td class="text-center" style="white-space: pre-wrap; word-break: keep-all; width:14%;   text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;">';
      if (strpos($work['weekday'], "Wednesday") !== false) {
        $html .= '<span   rel="tooltip" data-toggle="tooltip" title="">';
        if (!empty($getdata)) {


          $b = array_unique($a);
          foreach ($subjectname as $ko => $bhu) {
            $html .= '<span style="color:green;">' . $bhu . '</span><br>';
          }

          foreach ($b as $key => $va) {
            $sdf = $this->Comman->findclasssectionid($va);
            $sec = $sdf['section_id'];
            $cls = $sdf['class_id'];
            $cl1 = $this->Comman->findclass123($cls);
            $sl2 = $this->Comman->findsection123($sec);
            $html .= $cl1['title'] . '(' . $sl2['title'] . ')<br>';
          }
        } else {
          $html .= 'N.A.';
        }
        $html .= '</span>';
      }
      $html .= '</td>';

      $getdata = $this->Comman->gettimetableteacher($work['id'], "Thursday", $classectionid);
      $a = array();
      foreach ($getdata as $key => $value2) {
        $a[] = $value2['class_id'];
      }
      $emp = explode(',', $getdata[0]['employee_id']);
      $sub = explode(',', $getdata[0]['subject_id']);
      $subjectname = array();
      foreach ($emp as $k => $value) {
        foreach ($sub as $s => $val) {
          $vbn = array();
          if ($k == $s && $value == $classectionid) {
            $subj = $this->Comman->findclassubject($val);
            $subjectname[$val] = $subj['alias'];
          }
        }
      }

      $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
      $class = $clsssection['class_id'];
      $section = $clsssection['section_id'];
      $classtitle = $clsssection['Classes']['title'];
      $sectiontitle = $clsssection['Sections']['title'];

      $html .= '<td class="text-center" style="white-space: pre-wrap; word-break: keep-all; width:14%;   text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;">';
      if (strpos($work['weekday'], "Thursday") !== false) {
        $html .= '<span   rel="tooltip" data-toggle="tooltip" title="">';
        if (!empty($getdata)) {
          $b = array_unique($a);
          foreach ($subjectname as $ko => $bhu) {
            $html .= '<span style="color:green;">' . $bhu . '</span><br>';
          }

          foreach ($b as $key => $va) {
            $sdf = $this->Comman->findclasssectionid($va);
            $sec = $sdf['section_id'];
            $cls = $sdf['class_id'];
            $cl1 = $this->Comman->findclass123($cls);
            $sl2 = $this->Comman->findsection123($sec);
            $html .= $cl1['title'] . '(' . $sl2['title'] . ')<br>';
          }
        } else {
          $html .= 'N.A.';
        }

        $html .= '</span>';
      }
      $html .= '</td>';
      $getdata = $this->Comman->gettimetableteacher($work['id'], "Friday", $classectionid);

      $a = array();
      foreach ($getdata as $key => $value2) {
        $a[] = $value2['class_id'];
      }

      $emp = explode(',', $getdata[0]['employee_id']);
      $sub = explode(',', $getdata[0]['subject_id']);
      $subjectname = array();
      foreach ($emp as $k => $value) {
        foreach ($sub as $s => $val) {
          $vbn = array();
          if ($k == $s && $value == $classectionid) {
            $subj = $this->Comman->findclassubject($val);
            $subjectname[$val] = $subj['alias'];
          }
        }
      }

      $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
      $class = $clsssection['class_id'];
      $section = $clsssection['section_id'];
      $classtitle = $clsssection['Classes']['title'];
      $sectiontitle = $clsssection['Sections']['title'];

      $html .= '<td class="text-center" style="white-space: pre-wrap; word-break: keep-all; width:14%;   text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;">';
      if (strpos($work['weekday'], "Friday") !== false) {
        $html .= '<span   rel="tooltip" data-toggle="tooltip" title="">';
        if (!empty($getdata)) {

          $b = array_unique($a);
          foreach ($subjectname as $ko => $bhu) {
            $html .= '<span style="color:green;">' . $bhu . '</span><br>';
          }

          foreach ($b as $key => $va) {
            $sdf = $this->Comman->findclasssectionid($va);
            $sec = $sdf['section_id'];
            $cls = $sdf['class_id'];
            $cl1 = $this->Comman->findclass123($cls);
            $sl2 = $this->Comman->findsection123($sec);

            $html .= $cl1['title'] . '(' . $sl2['title'] . ')<br>';
          }
        } else {
          $html .= 'N.A.';
        }
        $html .= '</span>';
      }
      $html .= '</td>';


      $getdata = $this->Comman->gettimetableteacher($work['id'], "Saturday", $classectionid);
      $a = array();
      foreach ($getdata as $key => $value2) {
        $a[] = $value2['class_id'];
      }

      $emp = explode(',', $getdata[0]['employee_id']);
      $sub = explode(',', $getdata[0]['subject_id']);
      $subjectname = array();
      foreach ($emp as $k => $value) {
        foreach ($sub as $s => $val) {
          $vbn = array();
          if ($k == $s && $value == $classectionid) {
            $subj = $this->Comman->findclassubject($val);
            $subjectname[$val] = $subj['alias'];
          }
        }
      }

      $clsssection = $this->Comman->find_alls($getdata[0]['class_id']);
      $class = $clsssection['class_id'];
      $section = $clsssection['section_id'];
      $classtitle = $clsssection['Classes']['title'];
      $sectiontitle = $clsssection['Sections']['title'];

      $html .= '<td class="text-center" style="white-space: pre-wrap; word-break: keep-all; width:14%;   text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;">';
      if (strpos($work['weekday'], "Saturday") !== false) {
        $html .= '<span   rel="tooltip" data-toggle="tooltip" title="">';
        if (!empty($getdata)) {

          $b = array_unique($a);
          foreach ($subjectname as $ko => $bhu) {
            $html .= '<span style="color:green;">' . $bhu . '</span><br>';
          }

          foreach ($b as $key => $va) {
            $sdf = $this->Comman->findclasssectionid($va);
            $sec = $sdf['section_id'];
            $cls = $sdf['class_id'];
            $cl1 = $this->Comman->findclass123($cls);
            $sl2 = $this->Comman->findsection123($sec);
            $html .= $cl1['title'] . '(' . $sl2['title'] . ')<br>';
          }
        } else {
          $html .= 'N.A.';
        }
        $html .= '</span>';
      }
      $html .= '</td></tr>';
    }
    if ($work['is_break']) {
      if ($work['time_from']) {
        $html .= '<tr><td  style="width:17%;   text-align:center; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;  border-left:1px solid #e0e0e0;">' . $work['name'];

        $html .= '</td><td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; "><span title="Break" data-toggle="tooltip" style="color:red; text-align:center;   width:14%;  "> <br><br>Break</span></td>
                                    <td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center;"> <br><br>Break</span></td>
                                   <td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center;   line-height:8px;"> <br><br>Break</span></td>
                                 <td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center;"> <br><br>Break</span></td>
                                 <td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center; "> <br><br>Break</span></td>
                                  <td class="text-center" style="white-space: pre-wrap; word-break: keep-all; border-right:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0;"><span title="Break" data-toggle="tooltip" style="color:red; text-align:center;"> <br><br>Break</span></td>
                                    	  		    </tr>';
      }
    }
  }
}

$html .= '</tbody>
        </table>  		
				';

$pdf->WriteHTML($html, '', 0, 'L', true, 0, false, false, 0);
ob_end_clean();
echo $pdf->Output('Result');
?>



?>