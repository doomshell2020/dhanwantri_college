<?php 
class xtcpdf extends TCPDF {
}
 
   $this->set('pdf', new TCPDF('P','mm','A4'));
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();

 
//pdf->SetY(-550);
$pdf->SetFont('', '', 9, '', 'false');

$html.='
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Receipt</title><link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"></head>
<body style="font-family:verdana">

<table width="100%">
<tr><td><img src="images/vatika-r-b-1.png"  alt="" border="0" style="display:block; width:800%;"></td> <td style=" text-align:right;"><img src="images/vatika-r-b-2.png" alt="" border="0" style="width:800%; display:block;"></td></tr>

</table>
<table width="100%">

<tr><td style="text-align:center"><img src="images/L_58839.gif" alt="" border="0" style=" width: 800%; display:block;"></td></tr>
<tr><td style="text-align:center; font-size:10px; color: #000; font-style:italic;"><p style="text-transform:capitalize;">affilited to centeral board of secondary education , delhi , affilitaion no : 1730236<br>
vishwamitra marg , sirsi road , jaipur-302012 | phone:0141-2246189, 2357844 | fax:2245602<br>
e-mail:info@sanskarjaipur.com | website:www.sanskarjaipur.com
</p></td></tr>
</table>

<table width="100%">

<tr style=" line-height:20px;"><td colspan="5" align="center"><h3 style="font-size:16px;">SESSION 2017-2018</h3></td></tr>

<tr style=" line-height:20px;">
<td width="20%" rowspan="5" style="text-align:center; line-height:100px;"><img src="images/blank-profile.png" alt="" border="0" style=" width: 700%; display:block;"></td>
<td width="15%" style="font-weight:bold;">Name:</td>
<td width="30%">SHANTANU KUMAR DUDI</td>
<td width="15%" style="font-weight:bold;">Class:</td>
<td width="20%">Vatika-A</td>
</tr>
<tr style=" line-height:20px;">

<td width="15%" style="font-weight:bold;">Mothers name:</td>
<td width="30%">USHA RANI DUDI</td>
<td width="15%" style="font-weight:bold;">House</td>
<td width="20%"></td>
</tr>
<tr style=" line-height:20px;">

<td width="15%" style="font-weight:bold;">Fathers name:</td>
<td width="30%">CHANDRA PRAKESH DUDI</td>
<td width="15%" style="font-weight:bold;">Date of Birth</td>
<td width="20%">08/09/2001</td>
</tr>
<tr style=" line-height:20px;">

<td width="15%" style="font-weight:bold;">Enrollment No:</td>
<td width="30%">5854</td>
<td width="15%" style="font-weight:bold;">Contact No</td>
<td width="20%">11208</td>
</tr>
<tr style=" line-height:20px;">

<td width="15%" style="font-weight:bold;">Address:</td>
<td colspan="3" width="65%">TARUN NIWAS 116, RAJENDRA NAGAR, SIRSI ROAD, VAISHALI NAGAR,JAIPUR</td>

</tr>


</table>
<br><br><br>
<table width="100%" border="0.1px"  style="line-height:20px">
<tr>
<td width="30%" style="font-size:10px;">Height</td>
<td width="70%" style="font-size:10px;">110cm</td>
</tr>
<tr>
<td width="30%" style="font-size:10px;">Weight</td>
<td width="70%" style="font-size:10px;">17kg</td>
</tr>

</table>
<br><br>
<h2 style=" line-height:16px; text-align:center;">REPORTING CRITERIA</h2>

<table width="100%">
<tr>
<td width="20%" style="font-weight:bold; font-size:14px;">Beginning:</td>
<td width="80%" style="font-size:13px;">Needs constant supervision and assistance to develop the requisite knowledge,
skills and understanding. Is rarely able to communicate / have a dialogue about
his/her learning in a purposeful manner with others.<br></td>

</tr>

<tr>
<td width="20%" style="font-weight:bold; font-size:14px;">Developing:</td>
<td width="80%" style="font-size:13px;">Shows partial development of cognitive skills in form of the work evidence
provided.Is sometimes able to have a meaningful discussion about his/her
learning with others.<br></td>

</tr>


<tr>
<td width="20%" style="font-weight:bold; font-size:14px;">Achieving:</td>
<td width="80%" style="font-size:13px;">Shows advanced cognitive skills in terms of demonstration of skills and
application of knowledge and understanding. Is usually able to discuss his/her
learning with others.<br></td>

</tr>


<tr>
<td width="20%" style="font-weight:bold; font-size:14px;">Excelling:</td>
<td width="80%" style="font-size:13px;">Shows high levels of achievement and provides outstanding work evidence.
Displays exemplary application of learning and is able to discuss his/her
learning in meaningful ways with others most of the time.<br></td>

</tr>








</table><br><br><br><br>

<h3 style="font-weight:bold; font-size:12px;">TRANSDISCIPLINARY THEME 1 - <span style="font-weight:300; font-size:10px;">Who We Are</span></h3>
<h3 style="font-weight:bold; font-size:12px;">CENTRAL IDEA - <span style="font-weight:300; font-size:10px;">People around us help in shaping who we are.</span></h3>
<h3 style="font-weight:bold; font-size:12px;">LINES OF INQUIRY</h3>
<ul style="font-size:10px;">

<li>Knowing Myself.</li>
<li>People around me.</li>
<li>What I learn from people around me.</li>

</ul><br>

<table width="100%" border="0.1px" style="text-align:center; line-height:15px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;">Objectives</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:9px;">
<li>Is able to introduce himself/herself.</li>
<li>Identify relationship and names of people in the
immediate environment</li>
<li>Relate to interactions with people at home and school.</li>
</ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>


<br>
<h2 style=" font-size:14px; font-weight:bold ; line-height:15px;">LEARNER PROFILE</h2>
<div></div>

<table width="100%" style="">
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Inquirer</td>
<td width="80%" height="25px" style="border-top:1px solid #000; border-bottom:1px solid #000;"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Caring</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Balanced</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>


</table>




<br><br>
<h2 style=" font-size:14px; font-weight:bold ; line-height:15px">ATTITUDE</h2>
<div></div>
<table width="100%">
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Respect</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Curiosity</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Enthusiasm</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>


</table>

<br><br>
<h2 style="font-size:14px;font-weight:bold;line-height:15px">TRANSDISCIPLINARY SKILLS</h2>
<div></div>
<table width="100%">
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Social</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Self-management</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>




</table>







<br><br>


<h3 style="font-weight:bold; font-size:12px;">TRANSDISCIPLINARY THEME 2 - <span style="font-weight:300; font-size:10px;"> Sharing the Planet</span></h3>
<h3 style="font-weight:bold; font-size:12px;">CENTRAL IDEA - <span style="font-weight:300; font-size:10px;">Animals and humans interact in different ways.</span></h3>
<h3 style="font-weight:bold; font-size:12px;">LINES OF INQUIRY</h3>
<ul style="font-size:10px;">

<li>Animals around us.</li>
<li>Things we get from animals.</li>
<li>How we take care of animals.</li>

</ul><br><br><br>

<table width="100%" border="1" style="text-align:center; line-height:15px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;">Objectives</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:9px;">
<li>Recognize and name animals and describe their
characteristics.</li>
<li>Recognize and reflect on products we get from animals.</li>
<li>Expresses ways of taking care of animals.</li>
</ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>


<br><br>
<h2 style=" font-size:14px; font-weight:bold ; line-height:25px;">LEARNER PROFILE</h2>
<div></div>

<table width="100%">
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Knowledgeable</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Caring</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Attitude</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Commitment</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Curiosity</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Empathy</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>


</table>




<br><br>
<h2 style=" font-size:14px; font-weight:bold ; line-height:15px">TRANSDISCIPLINARY SKILLS</h2>
<div></div>
<table width="100%" >
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Research</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>
<br><br>
<tr>
<td style="font-weight:bold; font-size:12px" width="20%" height="25px">Communication</td>
<td width="80%" style="border-top:1px solid #000; border-bottom:1px solid #000;" height="25px"></td>
</tr>



</table>
<br><br><br><br><br><br><br><br><br><br>
<div style="width:50%; text-align:center;"><h1 style="font-size:15px; font-weight:500; text-align:center;">English</h1></div>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Oral language - Listening and Speaking</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;">Objectives</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Communicate ideas and thoughts confidently.</li>
<li>Recite rhymes with expression.</li>
<li>Understand simple questions and respond with gestures
and words.</li>
<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>
<br><br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Visual Language - Viewing and Presenting</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Interprets and respond to visual media.</li>
<li>Observes visual cues and matches alphabet with
associated pictures of objects.</li>
<li>Select and incorporate colours, shapes, symbols and
images in free hand drawings / illustrations.</li>
<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>

<br><br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Reading</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Read A to Z in capital.</li>
<li>Associate a given letter with related picture and object.</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>

<br><br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Writing</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Write A to Z in series as well as when dictated.</li>
<li>Write alphabet in proper lines and neat formations.</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>
<br><br>
<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Remarks</h4>
<br><br><br>
<table width="100%" style="">

<tr><td height="25%" style="border-top:1px solid #000; border-bottom:1px solid #000;"></td></tr><br>
<tr><td height="25%" style="border-top:1px solid #000; border-bottom:1px solid #000;"></td></tr><br>



</table>

<br>




<div style="width:50%; text-align:center;"><h1 style="font-size:15px; font-weight:500; text-align:center;">Hindi</h1></div>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Oral</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Communicate ideas and thoughts confidently.</li>
<li>Recite rhymes with expression.</li>
<li>Understand simple questions and respond with gestures
and words.</li>
<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>
<br><br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Visual Language - Viewing and Presenting</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Interprets and respond to visual media.</li>
<li>Observes visual cues and matches alphabet with
associated pictures of objects.</li>
<li>Select and incorporate colours, shapes, symbols and
images in free hand drawings / illustrations.</li>
<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>

<br><br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Reading</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Read A to Z in capital.</li>
<li>Associate a given letter with related picture and object.</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>

<br><br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Writing</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Write A to Z in series as well as when dictated.</li>
<li>Write alphabet in proper lines and neat formations.</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>
<br><br>
<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Remarks</h4>
<br><br><br>
<table width="100%" style="">

<tr><td height="25%" style="border-top:1px solid #000; border-bottom:1px solid #000;"></td></tr><br>
<tr><td height="25%" style="border-top:1px solid #000; border-bottom:1px solid #000;"></td></tr><br>



</table>

<br><br><br><br>
<div style="width:50%; text-align:center;"><h1 style="font-size:15px; font-weight:500; text-align:center;">Mathematics</h1></div>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Numbers</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Read and write numbers 1 to 50.</li>
<li>Identify the numbers after or between any given
number ranging from 1 to 20.</li>
<li>Count objects and pictures and write corresponding
numbers ranging from 1 to 10.</li>
<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>
<br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Measurement</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Compare and describe attributes of real objects using
following non-standard units: Big-Small; Tall-Short;
Fat-Thin; Heavy-Light.</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>

<br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Data Handling</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Sort objects by attributes (colour, shape, size).</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>

<br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Pattern and Function</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Extend and create patterns using shapes.</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>


<br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Shape and Space</h4>

<table width="100%" border="1" style="text-align:center; line-height:25px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Recognize shapes- &lceil;, &upsih; , &piv;, &Omicron; </li>
<li>Use words that describe positions:- In-Out: Up-Down:
Left-Right.
</li>
<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>


<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Remarks</h4>
<br><br><br>
<table width="100%" style="">

<tr><td height="25%" style="border-top:1px solid #000; border-bottom:1px solid #000;"></td></tr><br>
<tr><td height="25%" style="border-top:1px solid #000; border-bottom:1px solid #000;"></td></tr><br>



</table>

<br><br>



<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Dance</h4>

<table width="100%" border="1" style="text-align:center; line-height:15px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Enjoy and learn different dance movement.</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>


<br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Visual Arts</h4>

<table width="100%" border="1" style="text-align:center; line-height:15px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Reflects through free hand drawings</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>


<br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Music</h4>

<table width="100%" border="1" style="text-align:center; line-height:15px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Sing with accuracy</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>


<br>

<h2> PSPE (Personal Social and Physical Education)</h2>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Identity</h4>

<table width="100%" border="1" style="text-align:center; line-height:15px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Have an awareness of themselves and how they are
similar and different.</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>
<br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Active Living</h4>

<table width="100%" border="1" style="text-align:center; line-height:15px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Participate in a range of physical activities and explore
their body capacity</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>

<br>

<h4 style="font-size:12px; font-weight:bold; line-height:15px;">Interactions</h4>

<table width="100%" border="1" style="text-align:center; line-height:15px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Interact and engage with others and demonstrate care.</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>


<br>



<h4 style="font-size:12px; font-weight:bold; line-height:15px;">General Knowledge</h4>

<table width="100%" border="1" style="text-align:center; line-height:15px;">

<tr>

<td width="52%" style="font-size:10px; font-weight:bold;"></td>
<td width="12%" style="font-size:10px; font-weight:bold;">Beginning</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Developing</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Achieving</td>
<td width="12%" style="font-size:10px; font-weight:bold;">Excelling</td>

</tr>

<tr>
<td><ul style="font-size:10px; line-height:15px;">
<li>Show general awareness</li>

<br></ul></td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>
</table>
<br><br>
<table><tr><td width="30%" style=" font-size-adjust:10px"><b>Attendance :</b></td><td width="70%">81 OUT OF 88</td></tr></table>
<br><br><br><br>
<table><tr>
<td style="text-align:left; font-weight:bold;">Date :</td>
<td style="text-align:center; font-weight:bold;">Class Teacher</td>
<td style="text-align:right; font-weight:bold;">Principal</td></tr></table>

</body>
</html>';
//echo $html; die;
$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
echo $pdf->Output('Result');
exit;
?>



?>
