<?php


function renderDate($value)
{
    $th_month = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $dates = explode("/", $value);
    $d=0;
    $mi = 0;
    $yi = 0;
    foreach ($dates as $key => $value) {
         $d++;
         if($d==2)
            $mi = $value;
         if($d==3)
            $yi = $value;
    }
    if(substr($mi, 0,1)==0)
        $mi = substr($mi, 1);
    if(substr($dates[0], 0,1)==0)
        $d = substr($dates[0], 1);


    $renderDate = $d." ".$th_month[$mi]." ".$yi;
    if($renderDate==0)
        $renderDate = "";   

    return $renderDate;             
}


function renderDate2($value)
{
    $th_month = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
    $dates = explode("-", $value);
    $d=0;
    $mi = 0;
    $yi = 0;
    foreach ($dates as $key => $value) {
         $d++;
         if($d==2)
            $mi = $value;
         if($d==1)
            $yi = $value;
    }
    if(substr($mi, 0,1)==0)
        $mi = substr($mi, 1);
    if(substr($dates[2], 0,1)==0)
        $d = substr($dates[2], 1);
    else
        $d = $dates[2];

    $renderDate = $d." ".$th_month[$mi]." ".$yi;
    if($renderDate==0)
        $renderDate = "";   

    return $renderDate;             
}



// Include the main TCPDF library (search for installation path).
require_once('/../tcpdf/tcpdf.php');

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        
        // Set font
        //$this->SetFont('helvetica', 'B', 20);
        // Title
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('thsarabun', '', 11);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // Logo
        //$image_file = 'bank/image/mwa2.jpg';
        //$this->Image($image_file, 170, 270, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Cell(0, 5, date("d/m/Y"), 0, false, 'R', 0, '', 0, false, 'T', 'M');

        $this->writeHTMLCell(145, 550, 70, 200, '-'.$this->getAliasNumPage().'/'.$this->getAliasNbPages().'-', 0, 1, false, true, 'C', false);
        //writeHTMLCell ($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=false, $reseth=true, $align='', $autopadding=true)
    }
}

// create new PDF document
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Boybe');
$pdf->SetTitle('TCPDF Example 001');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setPrintHeader(false);
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('thsarabun', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = "";


    $pj = $model;
    //project contract
    $Criteria = new CDbCriteria();
    $Criteria->condition = "pc_proj_id='$pj->pj_id'";
    $pcs = ProjectContract::model()->findAll($Criteria);

    ///$html .= "<table border='0' class='span12' style='margin-left:0px;'><tr><td>DDDDD</td></tr></table>";

    $html .= '<div style="text-align:center;font-size:18px;"><b>โครงการ'.$pcs[0]->pc_details.'<br>ให้ '.$pj->pj_name.'</b></div>';
    $html .= '<br><table style="" border="0" cellpadding="0">';
    $html .=   '<tr><td colspan="4" style="background-color:#eeeeee;text-align:center">ส่วนผู้ว่าจ้าง : '.$pj->pj_name.'</td></tr>';
    foreach ($pcs as $key => $pc) {
        $html .=   "<tr><td width='30%'>ใบสั่งจ้างเลขที่ : ".$pc->pc_code."</td><td width='30%'>วันที่เริ่มในสัญญา : ".renderDate($pc->pc_sign_date)."</td><td width='50%' colspan=2>วันที่สิ้นสุดในสัญญา : ".renderDate($pc->pc_end_date)."</td></tr>";
    
    }
    //workcode
    $Criteria = new CDbCriteria();
    $Criteria->condition = "pj_id='$pj->pj_id'";
    $wcs = WorkCode::model()->findAll($Criteria);
    // print_r($wcs);
    $html .=   "<tr style='vertical-align:top'><td >หมายเลขงาน : ";

    $i=0;
    foreach ($wcs as $key => $wc) {
        if($i==0)  
          $html .= $wc->code."<br>";
        else
          $html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : '.$wc->code.'<br>'; 
        $i++;
    }
    $html .= "</td>";
    $html .= "<td width='30%'>แจ้งจัดสรรงบ กปง./กซข./กฟจ. : ";
    $i=0;
    foreach ($pcs as $key => $pc) {
        if($i==0)  
          $html .= $pc->pc_name_request."<br>";
        else
          $html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : ".$pc->pc_name_request."<br>"; 
        $i++;   
    }   
    $html .= "</td>";
    $html .= "<td width='25%'>เลขที่ส่ง / ลว. : ";
    $i=0;
    $sum_pc_cost = 0;
    foreach ($pcs as $key => $pc) {
        
        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll();
                                        ///print_r($changeHists);
                                        //$html .= $pp[0]["sum"];    

        $pcCost =$pc->pc_cost + $pp[0]["sum"];

        $sum_pc_cost += $pcCost;

        if($i==0)  
          $html .= $pc->pc_code_request."<br>";
        else
          $html .= "<span style='padding-left:182px;'>".$pc->pc_code_request."</span><br>"; 
        $i++;   
    }   
    $html .= "</td>";
    $html .= "<td width='15%'>วงเงิน : ".number_format($sum_pc_cost,2)."</td>";
    $html .= "</tr>";


    $html .= "</table>";

    $html .= '<table border="1" class="span12" style="margin-left:0px;">';
        $html .= '<tr align="center">';
         $html .= '<td rowspan="2" style="width:5%">ที่</td>';
         $html .= '<td colspan="4" style="text-align:center;width:55%">ด้านการดำเนินการโครงการ</td>';
         $html .= '<td colspan="4" style="text-align:center;width:40%">ด้านการเงิน</td>';
        $html .= '</tr>';
        $html .= '<tr>';
         $html .= '<td style="text-align:center;width:23%">รายละเอียด</td>';
         $html .= '<td style="text-align:center;width:10%">อนุมัติโดย/<br>ลงวันที่</td>';
         $html .= '<td style="text-align:center;width:10%">วงเงิน/<br>เป็นเงินเพิ่ม</td>';
         $html .= '<td style="text-align:center;width:12%">ระยะเวลาแล้วเสร็จ/<br>ระยะเวลาขอขยาย</td>';
         
         $html .= '<td style="text-align:center;width:10%">ชำระเงินงวดที่</td>';
         $html .= '<td style="text-align:center;width:10%">ใบแจ้งหนี้/<br>ลงวันที่</td>';
         $html .= '<td style="text-align:center;width:10%">ใบเสร็จเลขที่/<br>ลงวันที่</td>';
         $html .= '<td style="text-align:center;width:10%">วงเงิน</td>';
            
        $html .= '</tr>';

        
        $data_approve = array();
        $data_payment = array();
        $i =0;
        foreach ($pcs as $key => $pc) {
            $approve = Yii::app()->db->createCommand()
                            ->select('detail,approveBy,dateApprove,cost,timeSpend')
                            ->from('contract_approve_history')
                            ->where("contract_id='$pc->pc_id' AND type=1")
                            ->queryAll();
            //print_r($data_approve);                
            if($i==0)
              $data_approve = $approve;
            else    
              array_merge($data_approve,$approve);    
            //print_r($data_approve);            

            $payment = Yii::app()->db->createCommand()
                            ->select('*')
                            ->from('payment_project_contract')
                            ->where("proj_id='$pc->pc_id'")
                            ->queryAll();                
            if($i==0)
              $data_payment = $payment;
            else    
              array_merge($data_payment,$payment);               
            $i++;
        }



        $sum_pay = 0;
        for ($i=0; $i < 5; $i++) { 
            $html .= "<tr>";
                if(!empty($data_approve[$i])) 
                {
                    $html .= '<td style="text-align:center">'.($i+1).'</td>';
                    $html .= '<td >'.$data_approve[$i]['detail'].'</td>';
                    $html .= '<td style="text-align:center">'.$data_approve[$i]['approveBy'].'<br>'.renderDate2($data_approve[$i]['dateApprove']).'</td>';
                    $html .= '<td style="text-align:right">'.number_format($data_approve[$i]['cost'],2).'</td>';
                    $html .= '<td >'.$data_approve[$i]['timeSpend'].'</td>';
                }
                else
                {
                    $html .= '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
                }   


                 if(!empty($data_payment[$i])) 
                {
                    
                    $html .= '<td valign="top">'.$data_payment[$i]['detail'].'</td>';
                    
                    //if(empty($data_payment[$i]["fine_amount"]) || $data_payment[$i]["fine_amount"]==0) 
                    //{
                        $html .= '<td style="text-align:center" valign="top">'.$data_payment[$i]['invoice_no'].'<br>'.renderDate2($data_payment[$i]['invoice_date']).'</td>';
                        $html .= '<td style="text-align:center" valign="top">'.$data_payment[$i]['bill_no'].'<br>'.renderDate2($data_payment[$i]['bill_date']).'</td>';
                    //}
                    //else
                    //{

                        // $html .= '<td style="text-align:center;">'.$data_payment[$i]["invoice_no"]."<br>".renderDate2($data_payment[$i]["invoice_date"]);
                        //             $html .= "<br><br><br><br>ภาษีมูลค่าเพิ่ม";
                        //             $html .= "<br>รวมเบิกจ่าย";
                        //             $html .= "<br><u>หัก</u> ค่าปรับส่งของล่าช้า";
                        //             $html .= "<br>รวมเบิกจ่ายทั้งสิ้น";
                        // $html .= "</td>";
                        // $html .= "<td ><center>".($data_payment[$i]["bill_no"])."<br>".renderDate2($data_payment[$i]["bill_date"]);
                        //         $html .= '</center><br><br><br><div style="text-align:right">';
                                    
                        //         $html .= "<u>".number_format($data_payment[$i]["money"]*0.07,2)."</u><br>";
                                    
                        //         $html .= number_format($data_payment[$i]["money"]*1.07,2)."<br>";
                        //         $html .= "<u>".number_format($data_payment[$i]["fine_amount"],2)."</u><br><br>";
                        //         $html .= '<p style="text-decoration-line: underline;text-decoration-style: double;">'.number_format($data_payment[$i]["money"]*1.07-$data_payment[$i]["fine_amount"],2)."</p></div>";
                        // $html .= "</td>";
                    //}


                    $html .= '<td style="text-align:right" valign="top">'.number_format($data_payment[$i]['money'],2).'</td>';

                    if($data_payment[$i]['bill_no']!=''){
                        $sum_pay += $data_payment[$i]['money'];
                    }
                }
                else
                {
                    if($i!=4)
                       $html .= '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
                    else
                    {
                        $remain = $sum_pc_cost - $sum_pay;
                        $html .= '<td colspan="3" style="text-align:center">คงเหลือ</td><td style="text-align:right">'.number_format($remain,2).'</td>';
                    }
                }   
            $html .= '</tr>';
        }

    $html .= '</table>';
    //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


    //----------outsource---------------------//

    $Criteria = new CDbCriteria();
    $Criteria->condition = "oc_proj_id='$pj->pj_id'";
    $ocs = OutsourceContract::model()->findAll($Criteria);
    //$html = "";
    if(count($ocs)!=0)
	{
         $html .='<br pagebreak="true" />';	
	    //$pdf->AddPage();
	}
    $index = 0;
    foreach ($ocs as $key => $oc) {
            $index++;
            $vendor = Vendor::model()->findByPk($oc->oc_vendor_id); 
			
			//if($index==0)
            //$html .='<br pagebreak="true" />';
		
            $sum_oc_cost = 0;
            $pp = Yii::app()->db->createCommand()
                                                    ->select('SUM(cost) as sum')
                                                    ->from('contract_change_history')
                                                    ->where("contract_id='$oc->oc_id' AND type=2")
                                                    ->queryAll();
                                                ///print_r($changeHists);
            $oc->oc_cost = str_replace(",", "", $oc->oc_cost);    

            $sum_oc_cost =$oc->oc_cost + $pp[0]["sum"];

            $html .= '<br><br><table border="0"  style="margin-left:0px;margin-top:15px;">';
            $html .=   '<tr><td colspan="4" style="background-color:#eeeeee;text-align:center">ส่วนผู้รับจ้าง รายที่ '.$index." : ".$vendor->v_name."</td></tr>";
            $html .=   "<tr><td width='30%'>สัญญาจ้างเลขที่ : ".$oc->oc_code."</td><td width='25%'>วันที่เริ่มในสัญญา : ".renderDate($oc->oc_sign_date).
                            "</td><td width='25%'>วันที่สิ้นสุดในสัญญา : ".renderDate($oc->oc_end_date)."</td><td width='30%' style='text-align:right'>วงเงิน : ".number_format($sum_oc_cost,2)."</td></tr>";
            
            //po
            $Criteria = new CDbCriteria();
            $Criteria->condition = "contract_id='$oc->oc_id'";
            $pos = WorkCodeOutsource::model()->findAll($Criteria);
            
            //print_r($pos);
            
            $index2 = 1;
            foreach ($pos as $key => $po) {
            $html .= "<tr>";    
                $html .= "<td>".$index2.". PO เลขที่ : ".$po->PO."</td>";
                $html .= "<td colspan='2'> เลขที่ส่งแจ้งรับรองงบ กปง. : ".$po->letter."</td>";
                $html .= "<td style='text-align:right'> เป็นเงิน : ".number_format($po->money,2)."</td>";
            $html .= "</tr>";
               $index2++;
            }
            

            // print_r($wcs);
         


            $html .= "</table>";

            $html .= '<table border="1" class="span12" style="margin-left:0px;">';
                $html .= "<tr>";
                 $html .= '<td rowspan="2" style="text-align:center;width:5%">ที่</td>';
                 $html .= '<td colspan="4" style="text-align:center;width:55%">ด้านการดำเนินการโครงการ</td>';
                 $html .= '<td colspan="4" style="text-align:center;width:40%">ด้านการเงิน</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                 $html .= '<td style="text-align:center;width:23%">รายละเอียด</td>';
                 $html .= '<td style="text-align:center;width:10%">อนุมัติโดย/<br>ลงวันที่</td>';
                 $html .= '<td style="text-align:center;width:10%">วงเงิน/<br>เป็นเงินเพิ่ม</td>';
                 $html .= '<td style="text-align:center;width:12%">ระยะเวลาแล้วเสร็จ/<br>ระยะเวลาขอขยาย</td>';
                 
                 $html .= '<td style="text-align:center;width:10%">ชำระเงินงวดที่</td>';
                 $html .= '<td style="text-align:center;width:10%">อนุมัติโดย</td>';
                 $html .= '<td style="text-align:center;width:10%">วัน/เดือน/ปี</td>';
                 $html .= '<td style="text-align:center;width:10%">วงเงิน</td>';
                    
                $html .= '</tr>';

                
                $data_approve = Yii::app()->db->createCommand()
                                    ->select('detail,approveBy,dateApprove,cost,timeSpend')
                                    ->from('contract_approve_history')
                                    ->where("contract_id='$oc->oc_id' AND type=2")
                                    ->queryAll();
                
                $data_payment = Yii::app()->db->createCommand()
                                    ->select('*')
                                    ->from('payment_outsource_contract')
                                    ->where("contract_id='$oc->oc_id'")
                                    ->queryAll();                
                //print_r($data_payment);

                $sum_pay = 0;
                for ($i=0; $i < 5; $i++) { 
                    $html .= "<tr>";
                        if(!empty($data_approve[$i])) 
                        {
                            $html .= "<td style='text-align:center'>".($i+1)."</td>";
                            $html .= "<td >".$data_approve[$i]["detail"]."</td>";
                            $html .= "<td style='text-align:center'>".$data_approve[$i]["approveBy"]."<br>".renderDate2($data_approve[$i]["dateApprove"])."</td>";
                            $html .= "<td style='text-align:right'>".number_format($data_approve[$i]["cost"],2)."</td>";
                            $html .= "<td >".$data_approve[$i]["timeSpend"]."</td>";
                        }
                        else
                        {
                            $html .= "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
                        }   


                         if(!empty($data_payment[$i])) 
                        {
                            
                            $html .= "<td >".$data_payment[$i]["detail"]."</td>";

                            $html .= "<td style='text-align:center'>".$data_payment[$i]["approve_by"]."</td>";
                            $html .= "<td style='text-align:center'>".renderDate2($data_payment[$i]["approve_date"])."</td>";
                            $html .= "<td style='text-align:right'>".number_format($data_payment[$i]["money"],2)."</td>";

                            if($data_payment[$i]["approve_date"]!=""){
                                $sum_pay += $data_payment[$i]["money"];
                            }
                        }
                        else
                        {
                            if($i!=4)
                               $html .= "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
                            else
                            {
                                //$html .= $sum_oc_cost;
                                $remain = $sum_oc_cost - $sum_pay;
                                $html .= "<td colspan='3' style='text-align:center'>คงเหลือ</td><td style='text-align:right'>".number_format($remain,2)."</td>";
                            }
                        }   
                    $html .= "</tr>";
                }

            $html .= "</table><br>";

            /*if($index%2==0)
            {
                $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
                $html = "";
                $pdf->AddPage();
            }*/
			
			        if($index!=count($ocs))
			        {
			           $html .='<br pagebreak="true" />';	
			           $pdf->AddPage();
			        }
    }
    //if($index!=0)
$pdf->AddPage();
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// Print text using writeHTMLCell()
//echo $html;
//$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'summaryReport.pdf','F');

// ---------------------------------------------------------

// Close and output PDF document
// // This method has several options, check the source code documentation for more information.
// if(file_exists($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf'))
// {    
//     if(unlink($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf'))
//         $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf','F');
// }else{
//    $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf','F');
// }

$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport2.pdf','F');
ob_end_clean() ;

exit;
?>