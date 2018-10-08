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
$pdf->SetMargins(2, 10, 2);
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
$pdf->SetFont('thsarabun', '', 11, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = "";


    
    ///$html .= "<table border='0' class='span12' style='margin-left:0px;'><tr><td>DDDDD</td></tr></table>";

    $html .= '<div style="text-align:center;font-size:18px;"><b>สรุปงานรายรับ-รายจ่ายงานโครงการ ปี '.$fiscalyear.'</b></div>';
   
    $html .= '<table border="1" class="span12" style="margin-left:0px;">';
        $html .= '<tr align="center">';
         $html .= '<td rowspan="2" style="vertical-align:middle;text-align:center;width:4%"><span style="font-size: 5px;">'.str_repeat('&nbsp;<br/>', 2).'</span>ลำดับ</td>';
         $html .= '<td rowspan="2" style="vertical-align:middle;text-align:center;width:15%"><span style="font-size: 5px;">'.str_repeat('&nbsp;<br/>', 2).'</span>ชื่อโครงการ</td>';
         $html .= '<td rowspan="2" style="vertical-align:middle;text-align:center;width:7%"><span style="font-size: 5px;">'.str_repeat('&nbsp;<br/>', 2).'</span>วงเงินตามสัญญา</td>';
         $html .= '<td rowspan="2" style="vertical-align:middle;text-align:center;width:7%"><span style="font-size: 5px;">'.str_repeat('&nbsp;<br/>', 2).'</span>รายรับ</td>';
         $html .= '<td rowspan="2" style="vertical-align:middle;text-align:center;width:7%"><span style="font-size: 5px;">'.str_repeat('&nbsp;<br/>', 2).'</span>ยอดรับคงเหลือ</td>';
         $html .= '<td rowspan="2" style="vertical-align:middle;text-align:center;width:13%"><span style="font-size: 5px;">'.str_repeat('&nbsp;<br/>', 2).'</span>ชื่อผู้รับจ้าง</td>';
         $html .= '<td rowspan="2" style="vertical-align:middle;text-align:center;width:7%"><span style="font-size: 5px;">'.str_repeat('&nbsp;<br/>', 1).'</span>วงเงินตามสัญญา<br>จ้างช่วง</td>';
         $html .= '<td rowspan="2" style="vertical-align:middle;text-align:center;width:7%"><span style="font-size: 5px;">'.str_repeat('&nbsp;<br/>', 2).'</span>รายจ่าย</td>';

         $html .= '<td rowspan="2" style="text-align:center;width:7%"><span style="font-size: 5px;">'.str_repeat('&nbsp;<br/>', 2).'</span>ยอดจ่ายคงเหลือ</td>';
         $html .= '<td rowspan="2" style="text-align:center;width:7%"><span style="font-size: 5px;">'.str_repeat('&nbsp;<br/>', 1).'</span>ประมาณการค่า<br>บริหารโครงการ</td>';
         $html .= '<td colspan="3" style="text-align:center;width:19%">รายจ่ายที่เกิดขึ้นจริง</td>';
        $html .= '</tr>';

        $html .= '<tr align="center">';
         $html .= '<td style="text-align:center;">ค่าบริหาร<br>โครงการ</td>';
         $html .= '<td style="text-align:center;">ค่ารับรอง</td>';
         $html .= '<td style="text-align:center;">คงเหลือ</td>';
    
        $html .= '</tr>';


                //fiscalyear
                $fiscalyear = array();

                foreach ($model as $key => $value) {
                    
                    //print_r($value);
                    if(!in_array($value->pj_fiscalyear."/".$value->pj_work_cat, $fiscalyear))
                       $fiscalyear[] = $value->pj_fiscalyear."/".$value->pj_work_cat;
                

                }

                //print_r($model);
                //summary all
                $sumall_pc_cost = 0;
                $sumall_pc_receive = 0;
                         
                $sumall_oc_cost = 0;
                $sumall_oc_receive = 0;
                       
                $sumall_m_real = 0;
                $sumall_m_type1 = 0;
                $sumall_m_expect = 0;

                asort($fiscalyear);
                foreach ($fiscalyear as $key => $value) {
                    $data = explode("/", $value);
                    $year = $data[0];
                    $cat = $data[1];

                    $mWorkCat = WorkCategory::model()->findByPk($cat);

                    //$html .= $mWorkCat->wc_name;
                    $html .= "<tr>";
                    
                    $html .= '<td colspan="13"> '.$mWorkCat->wc_name.'</td>';
                    
                    $html .= "</tr>";

                    $index = 1;

                     //summary
                         $sum_pc_cost = 0;
                         $sum_pc_receive = 0;
                         
                         $sum_oc_cost = 0;
                         $sum_oc_receive = 0;
                       
                         $sum_m_real = 0;
                         $sum_m_type1 = 0;
                         $sum_m_expect = 0;
                       

                    foreach ($model as $key => $pj) {
                      
                      //$html .= $cat.",".$pj->pj_work_cat."<br>";
                        
                      if($pj->pj_fiscalyear==$year && $pj->pj_work_cat==$cat)
                      { 
                        
                        //if($cat==2)
                        //    $html .= $pj->pj_name;
                        //project contract
                         $Criteria = new CDbCriteria();
                         $Criteria->condition = "pc_proj_id='$pj->pj_id'";
                         $pcs = ProjectContract::model()->findAll($Criteria);
                         $nPC = count($pcs);

                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(pc_cost) as sum')
                                            ->from('project_contract')
                                            ->where("pc_proj_id='$pj->pj_id'")
                                            ->queryAll();  
                        $pcCostAll = $pp[0]["sum"];                     
                        foreach ($pcs as $key => $pc) {
                            $pp2 = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll(); 
                            $pcCostAll += $pp2[0]["sum"];                 
                         } 
                         
                                                                                
                            

                         //2.outsource contract
                         $Criteria = new CDbCriteria();
                         $Criteria->condition = "oc_proj_id='$pj->pj_id'";
                         $ocs = OutsourceContract::model()->findAll($Criteria);
                         $nOC = count($ocs);

                         //management cost
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=0";
                        $m_plan = ManagementCost::model()->findAll($Criteria);

                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type!=0 AND mc_type!=1";
                        $m_real = ManagementCost::model()->findAll($Criteria);

                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=1";
                        $m_type1 = ManagementCost::model()->findAll($Criteria);

                        

                        //end

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0")
                                            ->queryAll();
                        $sum_m_expect += $pp[0]["sum"];
                        $m_expect_sum = $pp[0]["sum"];


                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=1")
                                            ->queryAll();
                        $m_type1_sum = $pp[0]["sum"];                    

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type!=0 AND mc_type!=1")
                                            ->queryAll();
                        $m_real_sum = $pp[0]["sum"];

                        $sum_m_real += $m_real_sum;
                        $sum_m_type1 += $m_type1_sum;
                        //profit
                        //1.income
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('project_contract','proj_id=pc_id')
                                            ->where("pc_proj_id='$pj->pj_id' AND bill_no!=''")
                                            ->queryAll();
                        //$html .= $pp[0]["sum"];
                        $income = $pp[0]["sum"];
                        
                        //1.outcome
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('outsource_contract','contract_id=oc_id')
                                            ->where("oc_proj_id='$pj->pj_id'")
                                            ->queryAll();                    
                        $outcome = $pp[0]["sum"];                    
                      



                         $maxContract = $nOC==0? 1:$nOC;

                         $pj_rowspan = $maxContract ;

                        
                        

                         //end

                         $iPC = 0;
                         $iOC = 0;
                         $pcCost = 0;
                         $ocCost = 0;
                        for ($i=0; $i <$pj_rowspan ; $i++) { 
                            
                            $html .= "<tr>";
                                //draw project detail
                                if($i==0)
                                {
                                    $html .= '<td style="text-align:center">'.$index."</td>";
                                    $html .= "<td >".$pj->pj_name."</td>";
                                    //draw PC
                                    $html .= '<td style="text-align:right" >'.number_format($pcCostAll,2).'</td>';
                                    $sum_pc_cost += $pcCostAll;
                                    $sum_pc_receive += $income;
                                    $income1 = $income==0 ? '-' : number_format($income,2);
                                    $html .= '<td style="text-align:right" >'.$income1.'</td>';
                                    
                                    $html .= '<td style="text-align:right" >'.number_format($pcCostAll-$income,2).'</td>';
                                }
                                else{
                                    $html .= '<td></td>';
                                    $html .= '<td></td>';
                                    $html .= '<td></td>';
                                    $html .= '<td></td>';
                                    $html .= '<td></td>';
                                }
                                // for ($i=0; $i <8 ; $i++) { 
                                //     $html .= '<td></td>';
                                // }
                                    
                                    
                                //draw OC
                                if(!empty($ocs[$i]))
                                {
                                    $oc = $ocs[$i];
                                    $vendor = Vendor::model()->findByPk($oc->oc_vendor_id);
                                    $html .= '<td>'.$vendor->v_name.'</td>';

                                    $pp2 = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where('contract_id='.$oc->oc_id.' AND type=2')
                                            ->queryAll(); 
                                    $ocCostAll =str_replace(',', '', $oc->oc_cost) + $pp2[0]['sum'];                 
                                    $html .= '<td style="text-align:right">'.number_format($ocCostAll,2).'</td>';
                                    $sum_oc_cost += $ocCostAll;

                                    $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->where('contract_id='.$oc->oc_id.' AND approve_date!=""')
                                            ->queryAll();                    
                                    $outcomeOC = $pp[0]['sum'];   
                                    $sum_oc_receive += $outcome; 
                                    $outcomeOC1 = $outcomeOC==0 ? '-' : number_format($outcomeOC,2);
                                    $html .= '<td style="text-align:right">'.$outcomeOC1.'</td>';
                                    $html .= '<td style="text-align:right">'.number_format($ocCostAll-$outcomeOC,2).'</td>';
                                    

                                }else{
                                    $html .= '<td></td>';
                                    $html .= '<td></td>';
                                    $html .= '<td></td>';
                                    $html .= '<td></td>';

                                }

                                if($i==0)
                                {
                                    
                                    $expect = $m_expect_sum==0 ? '-' : number_format($m_expect_sum,2);
                                    $real = $m_real_sum==0 ? '-' : number_format($m_real_sum,2);
                                    $type1 = $m_type1_sum==0 ? '-' : number_format($m_type1_sum,2);
                                    $html .= '<td style="text-align:right" >'.$expect.'</td>';
                                    $html .= '<td style="text-align:right" >'.$real.'</td>';
                                    $html .= '<td style="text-align:right" >'.$type1.'</td>';
                                    $rm =($m_expect_sum - $m_type1_sum - $m_real_sum)==0 ? '-' : number_format($m_expect_sum - $m_type1_sum - $m_real_sum,2);
                                    $html .= '<td style="text-align:right" >'.$rm.'</td>';
                                }
                                else{
                                    $html .= '<td></td>';
                                    $html .= '<td></td>';
                                    $html .= '<td></td>';
                                    $html .= '<td></td>';
                                 
                                }    
                           $html .= '</tr>'; 


                         
                         
                        }//end rowspan   

                        $index++;
                      }//end if     
                                
                            
                                    
                                    
                    }//end project   
                    
                    //summary
                     
                    $html .= "<tr>";
                    //summary
                                    $html .= '<td colspan="2" style="text-align:center">รวม</td>';
                                    if($sum_pc_cost!=0)
                                     $html .= '<td style="text-align:right" >'.number_format($sum_pc_cost,2).'</td>';
                                    else
                                     $html .= '<td style="text-align:right" >-</td>';   
                                    if($sum_pc_receive!=0)
                                     $html .= '<td style="text-align:right" >'.number_format($sum_pc_receive,2).'</td>';
                                    else
                                     $html .= '<td style="text-align:right" >-</td>';  
                                    if($sum_pc_cost-$sum_pc_receive!=0)
                                     $html .= '<td style="text-align:right" >'.number_format($sum_pc_cost-$sum_pc_receive,2).'</td>';
                                    else
                                      $html .= '<td style="text-align:right" >-</td>';    
                                    $html .= '<td></td>';
                                    if($sum_oc_cost!=0)
                                    $html .= '<td style="text-align:right" >'.number_format($sum_oc_cost,2).'</td>';
                                    else
                                     $html .= '<td style="text-align:right" >-</td>';  
                                    if($sum_oc_receive!=0)
                                    $html .= '<td style="text-align:right" >'.number_format($sum_oc_receive,2).'</td>';
                                    else
                                     $html .= '<td style="text-align:right" >-</td>';  
                                   
                                    if($sum_oc_cost-$sum_oc_receive!=0)
                                     $html .= '<td style="text-align:right" >'.number_format($sum_oc_cost-$sum_oc_receive,2).'</td>';
                                    else
                                      $html .= '<td style="text-align:right" >-</td>'; 
                                    $sum_expect = $sum_m_expect==0 ? '-': number_format($sum_m_expect,2);
                                    $html .= '<td style="text-align:right" >'.$sum_expect.'</td>';
                                    $sum_real = $sum_m_real==0 ? '-': number_format($sum_m_real,2);
                                    $html .= '<td style="text-align:right" >'.$sum_real.'</td>';
                                    $sum_type1 = $sum_m_type1==0 ? '-': number_format($sum_m_type1,2);
                                    $html .= '<td style="text-align:right" >'.$sum_type1.'</td>';
                                    $sum_rm = $sum_m_expect - $sum_m_real - $sum_m_type1==0 ? '-': number_format($sum_m_expect - $sum_m_real - $sum_m_type1,2);
                                    $html .= '<td style="text-align:right" >'.$sum_rm.'</td>';
                                   
                                $sumall_pc_cost += $sum_pc_cost;
                                $sumall_pc_receive += $sum_pc_receive;
                                         
                                $sumall_oc_cost += $sum_oc_cost;
                                $sumall_oc_receive += $sum_oc_receive;
                                       
                                $sumall_m_real += $sum_m_real;
                                $sumall_m_type1 += $sum_m_type1;
                                $sumall_m_expect += $sum_m_expect; 
                    $html .= "</tr>";

                    

                }

                $html .= "<tr>";
                    //summary
                                    $html .= '<td colspan="2" style="text-align:center">รวมทั้งหมด</td>';
                                    if($sumall_pc_cost!=0)
                                     $html .= '<td style="text-align:right" >'.number_format($sumall_pc_cost,2).'</td>';
                                    else
                                     $html .= '<td style="text-align:right" >-</td>';   
                                    if($sumall_pc_receive!=0)
                                     $html .= '<td style="text-align:right" >'.number_format($sumall_pc_receive,2).'</td>';
                                    else
                                     $html .= '<td style="text-align:right" >-</td>';  
                                    if($sumall_pc_cost-$sumall_pc_receive!=0)
                                     $html .= '<td style="text-align:right" >'.number_format($sumall_pc_cost-$sumall_pc_receive,2).'</td>';
                                    else
                                      $html .= '<td style="text-align:right" >-</td>';    
                                    $html .= '<td></td>';
                                    if($sumall_oc_cost!=0)
                                    $html .= '<td style="text-align:right" >'.number_format($sumall_oc_cost,2).'</td>';
                                    else
                                     $html .= '<td style="text-align:right" >-</td>';  
                                    if($sumall_oc_receive!=0)
                                    $html .= '<td style="text-align:right" >'.number_format($sumall_oc_receive,2).'</td>';
                                    else
                                     $html .= '<td style="text-align:right" >-</td>';  
                                   
                                    if($sumall_oc_cost-$sumall_oc_receive!=0)
                                     $html .= '<td style="text-align:right" >'.number_format($sumall_oc_cost-$sumall_oc_receive,2).'</td>';
                                    else
                                      $html .= '<td style="text-align:right" >-</td>'; 
                                    $sum_expect = $sumall_m_expect==0 ? '-': number_format($sumall_m_expect,2);
                                    $html .= '<td style="text-align:right" >'.$sum_expect.'</td>';
                                    $sum_real = $sumall_m_real==0 ? '-': number_format($sumall_m_real,2);
                                    $html .= '<td style="text-align:right" >'.$sum_real.'</td>';
                                    $sum_type1 = $sumall_m_type1==0 ? '-': number_format($sumall_m_type1,2);
                                    $html .= '<td style="text-align:right" >'.$sum_type1.'</td>';
                                    $sum_rm = $sumall_m_expect - $sumall_m_real - $sumall_m_type1==0 ? '-': number_format($sumall_m_expect - $sumall_m_real - $sumall_m_type1,2);
                                    $html .= '<td style="text-align:right" >'.$sum_rm.'</td>';
                                    
                    $html .= "</tr>";

    $html .= '</table>';


    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// Print text using writeHTMLCell()

//$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf','F');

// ---------------------------------------------------------

// Close and output PDF document
// // This method has several options, check the source code documentation for more information.
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf'))
{    
    if(unlink($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf'))
        $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf','F');
}
else{
   $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf','F');
}
ob_end_clean() ;

exit;
?>