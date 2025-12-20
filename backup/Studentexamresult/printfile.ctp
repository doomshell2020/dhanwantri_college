<?php 
class xtcpdf extends TCPDF {
 
}

  $this->set('pdf', new TCPDF('L','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);




$pdf->AddPage();

$html.='<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"></head>


<body>

<table width="100%" align="center">
<tr>
<td style="text-align:left;line-height:60px;" width="30%" >


<img src="images/cbse-logo.png" alt="" border="0" style="display:block; width:80px; height:80px;">
</td>

<td style="text-align:center;" width="40%" align="center">
<img src="images/logo.png" alt="" border="0" style="display:block; width:200px;" height="100px;">

</td>


<td style="text-align:right; line-height:60px;" width="30%" align="right"><img src="http://192.168.5.6/school/stu/6274.JPG"  border="0" style="display:inline-block; height:80px; width:80px"></td>
</tr>
</table>
<table width="100%">
<tr>

<td width="100%" align="center" style="vertical-align:-50px;">
<p style="color:#000; text-align:center; font-size:10px; line-height:12px;"> Affiliation No : 1730236<br>
Vishwamitra Marg , Hanuman Nagar Ext , Sirsi Road , Jaipur-302012<br>
<i>E-Mail:info@sanskarjaipur.com | Website:www.sanskarjaipur.com</i><br>
 <i>Phone:0141-2246189, 2357844 | Fax:2245602</i></p><br>
</td>

</tr>
<tr>
<td colspan="5" align="center" width="100%">

<h2 style="font-size:18px; font-weight:400; line-height:-10px;">ACADEMIC SESSION: 2018-19<br>
</h2>
<h2 style="font-size:18px; font-weight:400; line-height:3px;">
REPORT CARD</h2>
<p style="line-height:5px; font-size:11px;">(Issued by School as per directives of Central Board of Secondary Education, Delhi)</p>

</td>
</tr>
</table>
<table width="100%">
<br><br>
<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size:14px; font-weight:bold;">Student Profile:</h2></td>
</tr>
</table>
<table width="100%">
<tr>
<td width="100%">
<table width="100%" style="font-size:11px;">
<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase; font-weight:bold;" width="20%">
&nbsp; Students Name :
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; Tanmay&nbsp;Kayal&nbsp;
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Class / House :
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; IX - D /Sam
</td>

</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Fathers Name : 
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; Lal Chand Kayal
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Date of Birth :
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; 12-03-2004
</td>


</tr>

<tr>
<td style="height:20px; line-height:20px;   text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Mothers Name :
</td>

<td style="height:20px; line-height:20px; text-transform:uppercase;" width="30%">
&nbsp; Hansa Singh
</td>
<td style="height:20px; line-height:20px;  text-transform:uppercase;  font-weight:bold;" width="20%">
&nbsp; Admission No. :
</td>

<td style="height:20px; line-height:20px; line-height:15px; text-transform:uppercase;" width="30%">
&nbsp; 6274
</td>
</tr>
</table>

</td>

</tr>

</table>

<table width="100%">
<tr>
<td align="left"><h2 style="text-transform:uppercase; font-size:14px; font-weight:bold; line-height:25px;">Scholastic Areas:</h2></td>
</tr>
</table>

<table width="100%">
<tr style="font-size:11px;">
<td width="20%" style="border-top:1px solid #000; border-left:1px solid #000; height:20px;  line-height:20px;  border-right:1px solid #000;  font-weight:bold; " align="center">&nbsp; Subject Name</td>
<td width="16%" style="border-top:1px solid #000;  font-weight:bold;height:38px; height:20px;  line-height:20px; border-right:1px solid #000;" align="center">Periodic Test<br>(10)</td>
<td width="16%" style="border-top:1px solid #000;  font-weight:bold;height:38px; height:20px;  line-height:20px; border-right:1px solid #000;" align="center">Notebook<br>(5)</td>
<td width="16%" style="border-top:1px solid #000;  font-weight:bold;  font-size:11px; height:38px; height:20px;  line-height:20px;border-right:1px solid #000;" align="center">Sub. Enrichment<br>(5)</td>
<td width="16%" style="border-top:1px solid #000;  font-weight:bold; height:38px; height:20px;  line-height:20px; border-right:1px solid #000;" align="center">Annual Exam<br>(80)</td>
<td width="8%" style="border-top:1px solid #000;  font-weight:bold;  height:20px;  line-height:14px; border-right:1px solid #000;" align="center">Grand Total<br>(100)</td>
<td width="8%" style="border-top:1px solid #000; font-weight:bold;height:20px;  line-height:20px; border-right:1px solid #000;" align="center">&nbsp;Grade</td>
</tr><tr style="font-size:12px;">

<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-left:1px solid 
#000; border-right:1px solid #000; height:15px; font-size:11px; line-height:14px;" align="center">English</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">6</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">4</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">54</td><td width="8%" style="border-top:1px solid #000;  border-right:1px solid 
 #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
 align="center">69</td>
<td  width="8%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:15px; border-bottom:1px solid #000; line-height:15px;" 
align="center">B2</td></tr><tr style="font-size:12px;">

<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-left:1px solid 
#000; border-right:1px solid #000; height:15px; font-size:11px; line-height:14px;" align="center">Hindi</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">6</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">4</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">4</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">36</td><td width="8%" style="border-top:1px solid #000;  border-right:1px solid 
 #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
 align="center">50</td>
<td  width="8%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:15px; border-bottom:1px solid #000; line-height:15px;" 
align="center">C2</td></tr><tr style="font-size:12px;">

<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-left:1px solid 
#000; border-right:1px solid #000; height:15px; font-size:11px; line-height:14px;" align="center">Mathematics</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">18</td><td width="8%" style="border-top:1px solid #000;  border-right:1px solid 
 #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
 align="center">33</td>
<td  width="8%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:15px; border-bottom:1px solid #000; line-height:15px;" 
align="center">D</td></tr><tr style="font-size:12px;">

<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-left:1px solid 
#000; border-right:1px solid #000; height:15px; font-size:11px; line-height:14px;" align="center">Science</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">2</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">5</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">21</td><td width="8%" style="border-top:1px solid #000;  border-right:1px solid 
 #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
 align="center">33</td>
<td  width="8%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:15px; border-bottom:1px solid #000; line-height:15px;" 
align="center">D</td></tr><tr style="font-size:12px;">

<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-left:1px solid 
#000; border-right:1px solid #000; height:15px; font-size:11px; line-height:14px;" align="center">Social Science</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">2</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">4</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">4</td><td width="16%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="center">31</td><td width="8%" style="border-top:1px solid #000;  border-right:1px solid 
 #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
 align="center">41</td>
<td  width="8%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:15px; border-bottom:1px solid #000; line-height:15px;" 
align="center">C2</td></tr><tr style="font-size:12px;">

<td width="20%" style="border-top:1px solid #000; border-bottom:1px solid #000;  border-left:1px solid 
#000; border-right:1px solid #000; height:15px; font-size:11px; line-height:14px;" align="center">Computer Application</td><td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Practical Exam (70) :</b> &nbsp;34</td><td width="32%" style="border-top:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000; height:15px; line-height:15px;" align="left"><b style="font-size:11px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Annual Exam (30) :</b> &nbsp;16</td><td width="8%" style="border-top:1px solid #000;  border-right:1px solid 
 #000; border-bottom:1px solid #000; height:15px; line-height:15px;" 
 align="center">50</td>
<td  width="8%" style="border-top:1px solid #000; border-right:1px solid 
#000; height:15px; border-bottom:1px solid #000; line-height:15px;" 
align="center">C2</td></tr></table><br><br>
<table><tr>
<td width="25%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; border-bottom:1px solid #000;  font-weight:bold; height:15px; font-size:12px;" align="left">&nbsp; Total Marks : 600</td>

<td width="25%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px; line-height:15px; border-right:1px solid #000; border-bottom:1px solid #000;  font-weight:bold; height:15px;font-size:12px;" align="left">&nbsp; Marks Obtained : 276</td>
<td width="25%" style="border-top:1px solid #000; border-left:1px solid #000; height:15px;font-size:12px; line-height:15px; border-right:1px solid #000; border-bottom:1px solid #000;  font-weight:bold; height:15px;" align="left">&nbsp; Percentage : 46.00 </td>
<td width="25%" style="border-top:1px solid #000; border-left:1px solid #000; font-size:12px;height:15px; line-height:15px; border-right:1px solid #000; border-bottom:1px solid #000;  font-weight:bold; height:15px;" align="left">&nbsp; Overall Grade : C2</td>


</tr>

</table>
<br>
<table width="100%">


<tr>
<td align="left"><h2 style=" text-transform:uppercase; font-size:14px; font-weight:bold;line-height:25px; text-transform:uppercase;">Co-Scholastic Areas:</h2></td>
</tr>
</table>
<br>
<table width="100%" border="1px">
<tr>
<td width="60%">
<table width="100%" style="font-size:10px;">
<tr>
<td style="height:15px;  font-weight:bold; line-height:15px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="90%">
&nbsp; Work Education
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="10%" align="center">
&nbsp; A
</td>



</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="90%">
&nbsp; Art Education (Visual & Performing Arts)
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="10%" align="center">
&nbsp; A
</td>



</tr>

<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000; " width="90%">
&nbsp; Health & Physical Education (Sports/Martial Arts/Yoga/NCC etc.)
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #000; border-bottom:1px solid #000;" width="10%" align="center">
&nbsp; A
</td>



</tr>


<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #000; " width="90%">
&nbsp; Discipline
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #000; " width="10%" align="center">
&nbsp; A
</td>



</tr>





</table>
</td>
<td width="40%">
<table width="100%" style="font-size:10px;">
<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;  text-align:center; text-transform:uppercase; border-right:1px solid #000;border-bottom:1px solid #000;" width="100%">
&nbsp; Attendance
</td>





</tr>
<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;  text-transform:uppercase; border-right:1px solid #000;border-bottom:1px solid #000;" width="50%">
&nbsp;  Working Days 
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #000;border-bottom:1px solid #000;" width="50%" align="center">
&nbsp; 201
</td>



</tr>
<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-right:1px solid #000;border-bottom:1px solid #000;" width="50%">
&nbsp; Days Attended
</td>

<td style="height:15px; line-height:15px; text-transform:uppercase; border-right:1px solid #000;border-bottom:1px solid #000;" width="50%" align="center">
&nbsp; 166
</td>



</tr>
<tr>
<td style="height:15px; line-height:15px;  font-weight:bold;   text-transform:uppercase; border-left:1px solid #000; border-right:1px solid #000;border-bottom:1px solid #000;" width="100%">
&nbsp; 
</td>



</tr>

</table>
</td>
</tr>
</table>
<br><br>

<table width="100%">
<tr>
<td width="60%" align="left" style="border-top:1px solid #000; border-left:1px solid #000; border-bottom:1px solid #000; border-right:1px solid #000;">&nbsp; 

<table width="100%" cellspacing="7" style="font-size:11px;">
<tr><td width="100%" style="border-bottom:1px dotted #a8a8a8;"><b>Remarks:</b></td></tr>
<tr><td width="100%" style="border-bottom:1px dotted #a8a8a8;"></td></tr>
<tr><td width="100%" style=" border-bottom:1px dotted #a8a8a8;"></td></tr>
<tr><td width="100%"  style="border-bottom:1px dotted #a8a8a8;"><b>Final Result:</b></td></tr>
<tr><td width="100%"  style="border-bottom:1px dotted #a8a8a8;"></td></tr>
</table>
  </td>

<td width="40%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">
<table width="100%">
<tr>
<td width="1%"></td>
<td width="33%" align="left" style=" font-weight:bold; font-size:9px; ">Marks-Range</td>
<td width="1%"></td>
<td width="14%" align="left" style=" font-size:9px; font-weight:bold; border-right:1px solid #000;">Grade</td>
<td width="2%"></td>
<td width="33%" align="left" style=" font-weight:bold; font-size:9px;">Co-Scholastic</td>
<td width="1%"></td>
<td width="14%" align="left" style=" font-weight:bold; font-size:9px;"></td>
<td width="1%"></td>
</tr>


<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;91-100</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">A1</td>
<td width="2%"></td>
<td width="35%" align="left"  style="font-weight:bold;font-size:8px;">Grade Points</td>
<td width="1%" ></td>
<td width="12%" align="left"  style="font-weight:bold;font-size:8px;">Grade</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left"style="font-size:8px;">&nbsp;&nbsp;81-90</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">A2</td>
<td width="2%"></td>
<td width="35%" align="left"  style="font-size:8px;">5</td>
<td width="1%" ></td>
<td width="12%" align="left" style="font-size:8px;">A</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;71-80</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">B1</td>
<td width="2%"></td>
<td width="35%" align="left"  style="font-size:8px;">4</td>
<td width="1%" ></td>
<td width="12%" align="left"  style="font-size:8px;">B</td>
<td width="1%"></td>
</tr>


<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;61-70</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000;font-size:8px;">B2</td>
<td width="2%"></td>
<td width="35%" align="left"  style="font-size:8px;">3</td>
<td width="1%" ></td>
<td width="12%" align="left"  style="font-size:8px;">C</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;51-60</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000;font-size:8px;">C1</td>
<td width="2%"></td>
<td width="35%" align="left" style="font-size:8px;">2</td>
<td width="1%" ></td>
<td width="12%" align="left"  style="font-size:8px;">D</td>
<td width="1%"></td>
</tr>

<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;41-50</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000; font-size:8px;">C2</td>
<td width="2%"></td>
<td width="35%" align="left" style="font-size:8px;">1</td>
<td width="1%" ></td>
<td width="12%" align="left"  style="font-size:8px;">E</td>
<td width="1%"></td>
</tr>
<tr>
<td width="1%"></td>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;33-40</td>
<td width="1%"></td>
<td width="12%" align="left" style="border-right:1px solid #000;font-size:8px;">D</td>
<td width="2%"></td>
<td width="35%" align="left" style="font-size:8px;"></td>
<td width="1%"></td>
<td width="12%" align="left" style="font-size:8px;"></td>
<td width="1%"></td>
</tr>
<tr>
<td width="35%" align="left" style="font-size:8px;">&nbsp;&nbsp;32 & Below</td>
<td width="14%" align="left" style="border-right:1px solid #000; font-size:8px;">E(Fail)</td>
</tr>
<tr>
<td width="35%" align="left" style="font-size:8px;"></td>
<td width="14%" align="left" style="border-right:1px solid #000; font-size:8px;"></td>
</tr>
</table>
</td>
</tr>
</table>
<table width="100%" style="font-size:11px;">

<tr></tr>
<tr></tr>
<tr></tr>
<tr><br><br><br>
<td width="33.333%" align="left" style="line-height:26px; font-weight:bold;" >
<b>Date</b>
</td>
<td width="33.333%" align="center" style="line-height:26px; font-weight:bold;" >
<b>Class Teacher </b>
</td>

<td width="33.333%" align="right" style="line-height:26px; font-weight:bold;" >
<b>Principal</b> 
</td>
</tr>
</table>
</body>
</html>';
echo $html; die;
$pdf->SetFont('times', '', 9, '', 'false');
$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('Result.pdf');
exit;
?>
