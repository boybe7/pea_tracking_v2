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
    else
        $d = $dates[0];

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

        $this->writeHTMLCell(145, 550, 40, 287, '-'.$this->getAliasNumPage().'/'.$this->getAliasNbPages().'-', 0, 1, false, true, 'C', false);
        //writeHTMLCell ($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=false, $reseth=true, $align='', $autopadding=true)
    }
}

// create new PDF document
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, 30);
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
$pdf->SetFont('thsarabun', '', 12, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = "";


$pj = $model;
$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

$monthBetween = $month_th[$monthEnd]." ".$yearEnd;


$number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
$monthEnd2 = $monthEnd<10 ? "0".$monthEnd : $monthEnd;

$number = $number<10 ? "0".$number : $number;
$dayEnd = $yearEnd."-".$monthEnd2."-".$number;
$monthCondition = " <= '".$dayEnd."'";

//$html .= $monthCondition;

$maxPayment = 6;
$sumPayPCAll = 0;
$sumPayOCAll = 0;
foreach ($model as $key => $pj) {
        
    
    $html .='<div style="text-align:center;"> <font size="13"><b>สรุปรายได้/ค่าใช้จ่าย <br>'.$pj->pj_name."<br>ประจำเดือน ".$monthBetween.'</b></font></div>';
    
    $html .='<table border="1" width="100%" style="margin-left:0px;margin-bottom:20px;">';
        $html .= '<thead>';
        $html .='<tr  style="background-color:#F5C27F">';
         $html .='<td style="text-align:center;width:15%">วดป.<br>ใบเสร็จรับเงิน</td>';
         $html .='<td style="text-align:center;width:20%">รายการ</td>';
         $html .='<td style="text-align:center;width:20%">จำนวนเงิน</td>';
         $html .='<td style="text-align:center;width:15%">วดป.<br>อนุมัติรับเงิน</td>';
         $html .='<td style="text-align:center;width:20%">รายการ</td>';
         $html .='<td style="text-align:center;width:20%">รายจ่าย</td>';
        $html .='</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        $html .='<tr style="line-height:0" >';
         $html .='<td style="text-align:center;width:15%"></td>';
         $html .='<td style="text-align:center;width:20%"></td>';
         $html .='<td style="text-align:center;width:20%"></td>';
         $html .='<td style="text-align:center;width:15%"></td>';
         $html .='<td style="text-align:center;width:20%"></td>';
         $html .='<td style="text-align:center;width:20%"></td>';
        $html .='</tr>';

                        //project contract
                        $Criteria = new CDbCriteria();
                         $Criteria->condition = "pc_proj_id='$pj->pj_id'";
                         $pcs = ProjectContract::model()->findAll($Criteria);
                         $nPC = count($pcs);

                          $pay_pc = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum,YEAR(bill_date) as year')
                                            ->from('payment_project_contract')
                                            ->join('project_contract p', 'proj_id=p.pc_id')
                                            ->where("p.pc_proj_id='$pj->pj_id' AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date ".$monthCondition)
                                            ->group("YEAR(bill_date)")
                                            ->queryAll();

                         //2.outsource contract
                         $Criteria = new CDbCriteria();
                         $Criteria->condition = "oc_proj_id='$pj->pj_id'";
                         $ocs = OutsourceContract::model()->findAll($Criteria);
                         $nOC = count($ocs);
                         $maxContract = $nPC < $nOC ? $nOC : $nPC ;
                         $pj_rowspan = $maxContract * $maxPayment;

                          $pay_oc = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum,YEAR(approve_date) as year')
                                            ->from('payment_outsource_contract')
                                            ->join('outsource_contract o', 'contract_id=o.oc_id')
                                            ->where("o.oc_proj_id='$pj->pj_id' AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date ".$monthCondition)
                                            ->group("YEAR(approve_date)")
                                            ->queryAll();
                        

                         //management
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=2 AND mc_date ".$monthCondition)
                                            ->queryAll();
                        $m_sum1 = $pp[0]["sum"];
                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=1 AND mc_date ".$monthCondition)
                                            ->queryAll();
                        $m_sum2 = $pp[0]["sum"];
                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=3 AND mc_date ".$monthCondition)
                                            ->queryAll();
                        $m_sum3 = $pp[0]["sum"];


                         $pp = Yii::app()->db->createCommand()
                                            ->select('sum(mc_cost) as mc_cost')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=1")
                                            ->queryAll();
                        $m_plan1 = $pp[0]["mc_cost"];

                        $pp = Yii::app()->db->createCommand()
                                            ->select('sum(mc_cost)  as mc_cost')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=2")
                                            ->queryAll();
                        $m_plan2 = $pp[0]["mc_cost"];

                        $pp = Yii::app()->db->createCommand()
                                            ->select('sum(mc_cost)  as mc_cost')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=3")
                                            ->queryAll();
                        $m_plan3 = $pp[0]["mc_cost"];
                        //$html .= $m_sum;   

        $iPC = 0;
        $iOC = 0;
        
        $iPayOC = 0;
        $iPayPC = 0;
         $sumPayPCAll = 0;
        //echo count($pcs);
        for ($i=0; $i < $pj_rowspan; $i++) 
        { 
            $html .='<tr>';
            if($i%$maxPayment==0)
            {
                $paymentOC = array();
                //$paymentPC = array();
                $sumPayOCAll = 0;
                
            }
            
            //draw PC
            if(!empty($pcs[$iPC]))
            {
                $pc = $pcs[$iPC];
                
                $vendor = Vendor::model()->findByPk($pc->pc_vendor_id);
                //print_r($vendor);
                //echo "<br>";
                if($i%$maxPayment==0)
                {
                    $sumPayPC = 0;  
                    $iPC++;
                    if($nPC==1)
                        $html .='<td>วงเงินสัญญา'.$iPC.'</td><td></td>';
                    else if(!empty($vendor))
                        $html .='<td colspan="2">'.$vendor->v_name.'</td>';
                    $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll();
                    $costPC = $pp[0]["sum"] + $pc->pc_cost;                        
                    $html .='<td align="right">'.number_format($costPC,2).'</td>';

                    $Criteria = new CDbCriteria();
                    $Criteria->condition = "proj_id='$pc->pc_id' AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date ".$monthCondition;
                    $payment = PaymentProjectContract::model()->findAll($Criteria);

                    $iPayPC = 0;
                }
                else{

                        //draw payment
                    if(!empty($payment[$iPayPC]))
                    {

                        $html .='<td align="center">'.renderDate($payment[$iPayPC]->bill_date).'</td>';
                        $html .='<td >'.$payment[$iPayPC]->detail.'</td>';
                        $money = str_replace(",", "", $payment[$iPayPC]->money);
                        $sumPayPC += $money;
                        $html .='<td align="right">'.number_format($money,2).'</td>';
                         $iPayPC++;
                    }
                    else{
                        
                        if($i%$maxPayment==$maxPayment-1 && $i<=$iPC*$maxPayment)
                        {   
                            $html .='<td>&nbsp;</td><td align="center" style="color:red"><u>คงเหลือค้างรับ</u></td>';
                            ///echo '<td align="right" style="color:red"><u>'.$costPC.'</u></td>';
                        
                            $rm = $costPC-$sumPayPC==0 ? "-": number_format($costPC-$sumPayPC,2);
                            $sumPayPCAll += $sumPayPC;
                            $html .='<td align="right" style="color:red"><u>'.$rm.'</u></td>';
                        }
                        else
                             $html .='<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>'; 
                        
        
                    }
                }
               
            }
            else
            {
                        //draw payment
                    if(!empty($payment[$iPayPC]))
                    {

                        $html .='<td align="center">'.renderDate($payment[$iPayPC]->bill_date).'</td>';
                        $html .='<td >'.$payment[$iPayPC]->detail.'</td>';
                        $money = str_replace(",", "", $payment[$iPayPC]->money);
                        $sumPayPC += $money;
                        $html .='<td align="right">'.number_format($money,2).'</td>';
                        $iPayPC++;
                    }
                    else{
                        
                        if($i%$maxPayment==$maxPayment-1 && $i<=$iPC*$maxPayment)
                        {   
                            $html .='<td>&nbsp;</td><td align="center" style="color:red"><u>คงเหลือค้างรับ</u></td>';
                            //echo '<td align="right" style="color:red"><u>'.$costPC.'</u></td>';
                            $rm = $costPC-$sumPayPC==0 ? "-": number_format($costPC-$sumPayPC,2);
                            $sumPayPCAll += $sumPayPC;
                            $html .='<td align="right" style="color:red"><u>'.$rm.'</u></td>';
                        }
                        else    
                           $html .='<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
                    }
                    
            }



            //draw OC
            if(!empty($ocs[$iOC]))
            {
                $oc = $ocs[$iOC];
                $vendor = Vendor::model()->findByPk($oc->oc_vendor_id);


                if($i%$maxPayment==0)
                {
                    $iOC++;
                    $sumPayOC = 0;
                    $html .='<td colspan="2">&nbsp;'.$vendor->v_name.'</td>';
                    $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$oc->oc_id' AND type=2")
                                            ->queryAll();
                    $costOC = $pp[0]["sum"] + str_replace(",", "", $oc->oc_cost);                        
                    $html .='<td align="right">'.number_format($costOC,2).'</td>';

                    $Criteria = new CDbCriteria();
                    $Criteria->condition = "contract_id='$oc->oc_id' AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date ".$monthCondition;
                    $paymentOC = PaymentOutsourceContract::model()->findAll($Criteria);
                    //echo(count($paymentOC));
                    $iPayOC = 0;
                }
                else{

                        //draw payment
                    if(!empty($paymentOC[$iPayOC]))
                    {

                        $html .='<td align="center">'.renderDate($paymentOC[$iPayOC]->approve_date).'</td>';
                        $html .='<td >'.$paymentOC[$iPayOC]->detail.'</td>';
                        $money = str_replace(",", "", $paymentOC[$iPayOC]->money);
                        $sumPayOC += $money;
                        $html .='<td align="right">'.number_format($money,2).'</td>';
                        $iPayOC++;
                    }
                    else{
                        if($i%$maxPayment==$maxPayment-1 && $i<=$iOC*$maxPayment)
                        {   
                            $html .='<td>&nbsp;</td><td align="center" style="color:red"><u>ค้างจ่าย</u></td>';
                            //$html .='<td align="right" style="color:red"><u>'.$costPC.'</u></td>';
                            $rm = $costOC-$sumPayOC==0 ? "-": number_format($costOC-$sumPayOC,2);
                            $sumPayOCAll += $sumPayOC;
                            $html .='<td align="right" style="color:red"><u>'.$rm.'</u></td>';
                        }
                        else    
                           $html .='<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';    
                        
        
                    }
                    
                }
            
            }
            else{
                    if(!empty($paymentOC[$iPayOC]))
                    {

                        $html .='<td align="center">'.renderDate($paymentOC[$iPayOC]->approve_date).'</td>';
                        $html .='<td >'.$paymentOC[$iPayOC]->detail.'</td>';
                        $money = str_replace(",", "", $paymentOC[$iPayOC]->money);
                        $sumPayOC += $money;
                        $html .='<td align="right">'.number_format($money,2).'</td>';
                        $iPayOC++;
                    }
                    else{
                        if($i%$maxPayment==$maxPayment-1 && $i<=$iOC*$maxPayment)
                        {   
                            $html .='<td>&nbsp;</td><td align="center" style="color:red"><u>ค้างจ่าย</u></td>';
                            //$html .='<td align="right" style="color:red"><u>'.$costPC.'</u></td>';
                            $rm = $costOC-$sumPayOC==0 ? "-": number_format($costOC-$sumPayOC,2);
                            $sumPayOCAll += $sumPayOC;
                            $html .='<td align="right" style="color:red"><u>'.$rm.'</u></td>';
                        }
                        else    
                           $html .='<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
                    }
                    
                
                    
            }           
                
            $html .='</tr>';
                        
        }                 
        //summary project

        $max = count($pay_pc) < count($pay_oc) ? count($pay_oc): count($pay_pc);
        for ($i=0; $i < $max; $i++) { 
           $html .= '<tr style="background-color:#D7A8F7">';
        
            if(!empty($pay_pc[$i]))
            {   
                if($pay_pc[$i]["year"]==$yearEnd)
                  $html .= '<td colspan="2">รวมรายรับ ณ เดือน '.$month_th[$monthEnd].' '.$yearEnd.'</td>';
                else
                  $html .= '<td colspan="2">รวมรายรับ ณ เดือน ธันวาคม '.$pay_pc[$i]["year"].'</td>';
                
                $html .= '<td align="right">'.number_format($pay_pc[$i]["sum"],2).'</td>';
            }
            else{
                $html .= '<td colspan="2"></td><td></td>';  
            }           
            if(!empty($pay_oc[$i]))
            {   
                if($pay_oc[$i]["year"]==$yearEnd)
                  $html .= '<td colspan="2">รวมรายจ่าย ณ เดือน '.$month_th[$monthEnd].' '.$yearEnd.'</td>';
                else
                  $html .= '<td colspan="2">รวมรายจ่าย ณ เดือน ธันวาคม '.$pay_oc[$i]["year"].'</td>';

                $html .= '<td align="right">'.number_format($pay_oc[$i]["sum"],2).'</td>';
            }
            else{
                $html .='<td colspan="2"></td><td></td>';  
            }
            
            $html .='</tr>';
        
        }
        // $html .= '<tr style="background-color:#D7A8F7">';
        //     $html .= '<td colspan="2">รวมรายรับ ณ เดือน '.$month_th[$monthEnd].' '.$yearEnd.'</td>';
        //     $html .= '<td align="right">'.number_format($sumPayPCAll,2).'</td>';
        //     $html .= '<td colspan="2">รวมรายจ่าย ณ เดือน '.$month_th[$monthEnd].' '.$yearEnd.'</td>';
        //     $html .= '<td align="right">'.number_format($sumPayOCAll,2).'</td>';
        // $html .= '</tr>';
          $html .= '<tr style="background-color:#D7A8F7">';
            $html .= '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
            
          $html .= '<td colspan="2">ค่าบริหารโครงการ ('.number_format($m_plan1,2).')</td>';
          $html .= '<td align="right">'.number_format($m_sum1,2).'</td>';
        $html .= '</tr>';
          $html .= '<tr style="background-color:#D7A8F7">';
            $html .= '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
            
          $html .= '<td colspan="2">ค่ารับรอง ('.number_format($m_plan2,2).')</td>';
          $html .= '<td align="right">'.number_format($m_sum2,2).'</td>';
        $html .= '</tr>';
          $html .= '<tr style="background-color:#D7A8F7">';
            $html .= '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
            
          $html .= '<td colspan="2">ค่าบุคลากร ('.number_format($m_plan3,2).')</td>';
          $html .= '<td align="right">'.number_format($m_sum3,2).'</td>';
        $html .= '</tr>';
          $html .= '<tr style="background-color:#D7A8F7">';
             $html .= '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
            
             $html .= '<td colspan="2"><b>กำไร/ขาดทุน</b></td>';
             $html .= '<td align="right"><b>'.number_format($sumPayPCAll-$sumPayOCAll-$m_sum1-$m_sum3-$m_sum2,2).'</b></td>';
         $html .= '</tr>';
        $html .= '</tbody>';
    $html .="</table>";

    $pdf->AddPage();
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    $html = "";
    
}

    



// ---------------------------------------------------------

// Close and output PDF document
// // This method has several options, check the source code documentation for more information.
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf'))
{    
    if(unlink($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf'))
        $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf','F');
}else{
   $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf','F');
}
ob_end_clean() ;

exit;
?>