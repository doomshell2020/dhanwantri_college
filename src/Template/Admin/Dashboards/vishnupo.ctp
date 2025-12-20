<?php 
class xtcpdf extends TCPDF {
 
}


 //$subject=$this->Comman->findexamsubjectsresult($students['id'],$students['section']['id'],$students['acedmicyear']);

   $this->set('pdf', new TCPDF('L','mm','A4'));
$pdf = new TCPDF("P", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, true);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);
$pdf->AddPage();



$pdf->SetFont('', '', 10, '', 'false');




$html.='

<div style="border: 1px solid #000;">

<table width="100%">
<tr>
<td width="100%">
<h4 style="text-align:center; height:25px; line-height:26px; font-size:14px;">Kiran Infra Engineers Ltd
</h4>
<p style="text-align:center; height:1px; line-height:-10px;">B-141, Road No. 9-D, V.K.I. Area,
Jaipur- 302013 </p>
</td>
</tr>
</table>
<br><br>

<table width="100%">

<tr>
<td width="35%">
<table width="100%">
<tr>
<td width="100%"> &nbsp;  <img src="images/logo.png" alt="" border="0" style="display:block;"
width="130px" height="60px;"></td>
</tr>
</table>
</td>

<td width="65%">
<table width="100%">
<tr>
<td width="50%" style="text-align: left; height:15px; line-height:30px;">
<p style="font-size:10px; color:#000; text-align:left"><strong style="width: 100px;;">Phone</strong>   : 0141-2330305/2330427 </p>


                        </td>

                        <td width="50%" style="text-align: left;  height:15px; line-height:6px;">
                            <p style="font-size:10px; color:#000; text-align:left"><strong style="width: 100px;;">CIN No</strong>   : U45201RJ2006PLC022536 </p>
                                                    </td>
</tr>

<tr>
<td width="50%" style="text-align: left; height:15px; line-height:7px;">

<p style="font-size:10px; color:#000; text-align:left line-height:-30px;"><strong style="width: 100px;;">Email</strong>   : contact@kiraninfra.com </p>

                        </td>

                        <td width="50%" style="text-align: left;  height:15px; line-height:6px;">
                          
                                                    </td>
</tr>
</table>
</td>

</tr>
</table>




                 




<table width="100%">
<tr>
<td width="100%" style="height:16px; line-height:18px; color:#000; text-align:center; border-top:1px solid #000; border-bottom:1px solid #000; font-size:14px; font-weight;bold;">Purchase Order</td>
</tr>
</table>
<table width="100%">
<tr>
<td width="50%" style="border-right:1px solid #000;">

<table width="100%">

<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">TO</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
<strong style="font-weight:bold; font-size:8px; text-align:left;">RASHTRADOOT</strong><br>
VATAN PRESS, SUDHARMA, MI ROAD, JAIPUR-Rajasthan-Jaipur
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>


<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">GST No.</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
08AACHR1183F1Z9
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>


<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">State Code</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
Rajasthan
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>


<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">Phone No. </td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
0141-4103333
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>

<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">Email</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
<a href="#">deepak@doomshell.com</a>
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>
</table>
</td>




<td width="50%">

<table width="100%">

<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">Purchase Order No. </td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="61%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
200001 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>


<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">Purchase Order Date</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="61%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
12-02-2020
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>


<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">Delivery Date</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="61%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
11-02-2020
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>


<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">LOA No</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="61%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
--
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>

<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;"></td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;"></td>
<td width="61%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">

 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>
<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">Quotation No</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="61%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
--
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>

<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">Amendment No </td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="61%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">1&nbsp;(<b>Date : </b>12-02-2020 )</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>
</table>
</td>

</tr>
</table>




<table width="100%">
<tr>
<td width="100%" style="text-align:center; font-size:8px; color:#000; height:20px; line-height:20px; border-top:1px solid #000; border-bottom:1px solid #000;">
We are pleased to confirm our order as per details below. You are requested to execute the order as per mentioned terms & conditions
</td>
</tr>
</table>



<table width="100%">
<tr>
<td width="50%" style="border-right:1px solid #000;">

<table width="100%">

<tr>
<td width="2%" style="height:12px; line-height:12px"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">Bill To </td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">
<strong style="font-weight:bold; font-size:8px; text-align:left;">SANSKAR SCHOOL</strong><br>
117-121, Vishwamitra Marg, Hanuman Nagar Ext., Sirsi Road, Jaipur - 302012

</td>
<td width="2%" style="height:12px; line-height:12px"></td>
</tr>





<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">GST No </td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
08AACCK8188N1ZQ
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>


<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">Branch</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
Rajasthan

 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>

<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">State Code</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
8
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>

<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">Phone No.</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
0141-2246189 / 2357844
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>

</table>
</td>




<td width="50%">

<table width="100%">

<tr>
<td width="2%" style="height:12px; line-height:12px"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">Consignee Name  </td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px">:</td>
<td width="61%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">
SANSKAR SCHOOL
 
</td>
<td width="2%" style="height:12px; line-height:12px"></td>
</tr>


<tr>
<td width="2%" style="height:12px; line-height:12px;"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">And Address Details
</td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px;">:</td>
<td width="61%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
117-121, Vishwamitra Marg, Hanuman Nagar Ext., Sirsi Road, Jaipur - 302012
 
</td>
<td width="2%" style="height:12px; line-height:12px;"></td>
</tr>

</table>
</td>

</tr>
</table>




<table width="100%">
<tr>
<td width="4%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px; font-size:8px; font-weight:bold; text-align:left;"> S.No</td>

<td width="10%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; font-weight:bold; text-align:left;"> &nbsp; Item Code </td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; font-weight:bold; text-align:left;"> &nbsp; Sch Item No</td>
<td width="24%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; font-weight:bold; text-align:left;"> &nbsp; Railway Description</td>

<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000;height:12px; line-height:12px; font-size:8px; font-weight:bold; text-align:left;"> &nbsp; Insp. By</td>
<td width="8%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; font-weight:bold; text-align:left;"> &nbsp; Quantity</td>
<td width="8%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; font-weight:bold; text-align:left;"> &nbsp; UOM</td>
<td width="10%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000;height:12px; line-height:12px; font-size:8px; font-weight:bold; text-align:left;"> &nbsp; Rate</td>



<td width="12%" style="border-top:1px solid #000;  border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; font-weight:bold; text-align:left;"> &nbsp; Amount</td>
</tr>

<tr>
<td width="4%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px; font-size:8px; text-align:left;"> 1.</td>

<td width="10%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; RM0162 </td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; </td>
<td width="24%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; ISMB 250 x 125</td>

<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000;height:12px; line-height:12px; font-size:8px; text-align:left;"> &nbsp; </td>
<td width="8%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp;  3.50</td>
<td width="8%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; MT</td>
<td width="10%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000;height:12px; line-height:12px; font-size:8px; text-align:left;"> &nbsp;  34300.00</td>



<td width="12%" style="border-top:1px solid #000;  border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; 120050.00</td>
</tr>



<tr>
<td width="4%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px; font-size:8px; text-align:left;"> 2.</td>

<td width="10%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; RM0162 </td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; </td>
<td width="24%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; ISMB 150 x 75</td>

<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000;height:12px; line-height:12px; font-size:8px; text-align:left;"> &nbsp; </td>
<td width="8%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp;   16.20</td>
<td width="8%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; MT</td>
<td width="10%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000;height:12px; line-height:12px; font-size:8px; text-align:left;"> &nbsp;   33200.00</td>



<td width="12%" style="border-top:1px solid #000;  border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp;  537840.00</td>
</tr>



<tr>
<td width="4%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px; font-size:8px; text-align:left;"> 3.</td>

<td width="10%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; RM0162 </td>
<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; </td>
<td width="24%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; ISMC 125 x 65</td>

<td width="12%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000;height:12px; line-height:12px; font-size:8px; text-align:left;"> &nbsp; </td>
<td width="8%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp;   25.70</td>
<td width="8%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp; MT</td>
<td width="10%" style="border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000; color:#000;height:12px; line-height:12px; font-size:8px; text-align:left;"> &nbsp;   33200.00</td>



<td width="12%" style="border-top:1px solid #000;  border-bottom:1px solid #000; color:#000; height:12px; line-height:12px;font-size:8px; text-align:left;"> &nbsp;  853240.00</td>
</tr>
</table>

<table width="100%">
<tr>
<td width="88%" style="text-align:right; font-size:8px; border-right:1px solid #000; border-bottom:1px solid #000;">Total &nbsp;
</td>

<td width="12%" style="text-align:left; font-size:8px; border-right:1px solid #000; border-bottom:1px solid #000;"> &nbsp;  1511130.00
</td>
</tr>
</table>


<table width="100%">
<tr>
<td width="50%" style="border-right:1px solid #000;">

<table width="100%">

<tr>
<td width="2%" style="height:12px; line-height:12px"></td>
<td width="25%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">Remarks </td>
<td width="5%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px">:</td>
<td width="66%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">
All Material required with ISI TC

</td>
<td width="2%" style="height:12px; line-height:12px"></td>
</tr>






</table>
</td>




<td width="50%">

<table width="100%">

<tr>
<td width="2%" style="height:12px; line-height:12px"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">Discount  </td>
<td width="30%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px">0.00%</td>
<td width="36%" style=" text-align:right; color:#000; font-size:8px; height:12px; line-height:12px">
 0.00
 
</td>
<td width="2%" style="height:12px; line-height:12px"></td>
</tr>


<tr>
<td width="2%" style="height:12px; line-height:12px"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">Freight Charges  </td>
<td width="30%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px"></td>
<td width="36%" style=" text-align:right; color:#000; font-size:8px; height:12px; line-height:12px">
 0.00
 
</td>
<td width="2%" style="height:12px; line-height:12px"></td>
</tr>

<tr>
<td width="2%" style="height:12px; line-height:12px"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">Taxable Value  </td>
<td width="30%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px"></td>
<td width="36%" style=" text-align:right; color:#000; font-size:8px; height:12px; line-height:12px">
 1511130.00
 
</td>
<td width="2%" style="height:12px; line-height:12px"></td>
</tr>

<tr>
<td width="2%" style="height:12px; line-height:12px"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">CGST  </td>
<td width="30%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px">9.00 %</td>
<td width="36%" style=" text-align:right; color:#000; font-size:8px; height:12px; line-height:12px">
 136001.70
 
</td>
<td width="2%" style="height:12px; line-height:12px"></td>
</tr>

<tr>
<td width="2%" style="height:12px; line-height:12px"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">SGST  </td>
<td width="30%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px">9.00 %</td>
<td width="36%" style=" text-align:right; color:#000; font-size:8px; height:12px; line-height:12px">
 136001.70
 
</td>
<td width="2%" style="height:12px; line-height:12px"></td>
</tr>

<tr>
<td width="2%" style="height:12px; line-height:12px"></td>
<td width="30%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px">IGST  </td>
<td width="30%" style="text-align:center; color:#000; font-size:8px; height:12px; line-height:12px">0.00%</td>
<td width="36%" style=" text-align:right; color:#000; font-size:8px; height:12px; line-height:12px">
 0.00
 
</td>
<td width="2%" style="height:12px; line-height:12px"></td>
</tr>

</table>
</td>

</tr>
</table>


<table width="100%">
<tr>
<td width="20%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px; font-weight:bold; border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;"> &nbsp; Amount (In Words)</td>
<td width="50%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px; border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;"> &nbsp; RUPEES SEVENTEEN LAKHS EIGHTY-THREE THOUSAND <br> &nbsp;  ONE HUNDRED
THIRTY-THREE AND FORTY PAISA ONLY</td>
<td width="18%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px; font-weight:bold; border-top:1px solid #000; border-right:1px solid #000; border-bottom:1px solid #000;">Total Value (INR)</td>
<td width="12%" style=" text-align:right; color:#000; font-size:8px; height:12px; line-height:12px; border-top:1px solid #000;  border-bottom:1px solid #000;"> 1783133.40 &nbsp;</td>
</tr>
</table>


<br><br>
<table width="100%">
<tr >

<td width="20%" style="font-weight:bold; text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;"> &nbsp;&nbsp;&nbsp;Remarks</td>

<td width="80%" style=" text-align:left; color:#000; font-size:8px; height:12px; line-height:12px;">
Sweater size -30  qty are 100.
 
</td>

</tr>
</table>
<br>

<table width="100%">
<tr>
<td width="100%" style="border-top:1px solid #000; border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000; height:12px; line-height:12px; font-weight:bold;">
 &nbsp; Terms and Condition
</td>
</tr>
</table>



<table width="100%"><tr>
<td width="5%" style="height:12px; line-height:12px;">
 &nbsp; 1.
</td><td width="95%" style="font-size:8px; text-align:left; height:12px; line-height:12px;">F.O.R. Freight will be reimbursed by at actuals.</td></tr><tr>
<td width="5%" style="height:12px; line-height:12px;">
 &nbsp; 2.
</td><td width="95%" style="font-size:8px; text-align:left; height:12px; line-height:12px;">Payment with in 15 days.</td></tr><tr>
<td width="5%" style="height:12px; line-height:12px;">
 &nbsp; 3.
</td><td width="95%" style="font-size:8px; text-align:left; height:12px; line-height:12px;">Inspection charges:- Not Applicable.</td></tr><tr>
<td width="5%" style="height:12px; line-height:12px;">
 &nbsp; 4.
</td><td width="95%" style="font-size:8px; text-align:left; height:12px; line-height:12px;">Price - No increase in price will become effective unless specially agreed to in writing by company.</td></tr><tr>
<td width="5%" style="height:12px; line-height:12px;">
 &nbsp; 5.
</td><td width="95%" style="font-size:8px; text-align:left; height:12px; line-height:12px;">Delivery time is the essence of this order and must be strictly/adhered to. If supplier fails to deliver the goods in time, the purchaser may, at its sole discretion:-
(A) Treat the order as cancelled at any time. 
(B) Purchase the goods ordered or any part thereof from other sources.</td></tr><tr>
<td width="5%" style="height:12px; line-height:12px;">
 &nbsp; 6.
</td><td width="95%" style="font-size:8px; text-align:left; height:12px; line-height:12px;">Return:-
(A) Sanskar School Reserve the rights to accept and reject the materials supplied if the same does not fulfill the required specification.
(B) Sanskar School shall make a check on quality and specs of the materials supplied and in case if does not meet the required standard Sanskar School reserves
the right to reject it on vendor cost.
(C) If any rejection found at customer line/warranty due past problem, the debit amount from the customer will be debited to supplier.</td></tr><tr>
<td width="5%" style="height:12px; line-height:12px;">
 &nbsp; 7.
</td><td width="95%" style="font-size:8px; text-align:left; height:12px; line-height:12px;">In case we do not receive your acceptance within 3 days from the date of issue of this order, The order would be considered as accepted.</td></tr></table>


<table width="100%">
<tr>
<td width="100%" style="height:70px;"></td>
</tr>
</table>


<table width="100%">
<tr>
<td width="25%" style="text-align:left; border-top:1px solid #000;">
&nbsp;&nbsp; Prepared by
</td>

<td width="50%" style="text-align:center; border-top:1px solid #000;">
Checked by
</td>

<td width="25%" style="text-align:right; border-top:1px solid #000;">
 Approved by &nbsp;&nbsp;
</td>
</tr>
</table>
</td>
</tr>
</table>

	<table width="100%">
	<tr>
	<td width="100%" style="text-align:center; font-size:8px;font-weight:bold; color:#000;">Subject to Jaipur Jurisdiction
</td>
	</tr>
	</table>
	</div>

';

$pdf->WriteHTML($html, true, false, true, false, '');
ob_end_clean();
$date=date('d-m-Y');
echo $pdf->Output('Daily-Summary-'.$bordd.'-'.$date.'.pdf');
exit;
?>