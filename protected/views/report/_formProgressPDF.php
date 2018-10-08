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
        $this->SetFont('thsarabun', '', 9);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // Logo
        //$image_file = 'bank/image/mwa2.jpg';
        //$this->Image($image_file, 170, 270, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Cell(0, 5, 'หน้า '.$this->getAliasNumPage().'/'.$this->getAliasNbPages()."  วันที่ ".date("d/m/Y"), 0, false, 'R', 0, '', 0, false, 'T', 'M');
       
        //$this->writeHTMLCell(145, 550, 70, 200, '-'.$this->getAliasNumPage().'/'.$this->getAliasNbPages().'-', 0, 1, false, true, 'C', false);
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
$pdf->SetMargins(5, 10, 5);
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
$pdf->SetFont('thsarabun', '', 7, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('L', 'A3');

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
    $html = "";


    $pj = $model;
    //project contract
    // $Criteria = new CDbCriteria();
    // $Criteria->condition = "pc_proj_id='$pj->pj_id'";
    // $pcs = ProjectContract::model()->findAll($Criteria);

    $html .= '<table border="1" class="span12" style="margin-left:0px;border-collapse: collapse;">';
       
         $html .= '<thead >';
              $html .= '<tr style="background-color:#EEEEEE;font-weight:bold"> ';
                $html .= '<td rowspan="2" style="text-align:center;width:2%">ลำดับ</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:6%">โครงการ</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:5%">รายละเอียดงาน</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:3%">เลขที่<br>สัญญา</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:3%">วันที่<br>ลงนามสัญญา</td>';
                $html .= '<td colspan="8" style="text-align:center;width:25%">รายรับ</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:5%">ชื่อบริษัทจ้างช่วง</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:5%">รายละเอียดงาน</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:3%">เลขที่<br>สัญญา</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:4%">วันที่<br>ลงนามสัญญา</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:3%">วันที่<br>ครบกำหนด</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:3%">วันที่<br>รับรองงบ</td>';
                $html .= '<td colspan="7" style="text-align:center;width:20%">วงเงินช่วง</td>';
                $html .= '<td colspan="3" style="text-align:center;width:9%">ค่าบริหารโครงการ</td>';
                $html .= '<td rowspan="2" style="text-align:center;width:4%">วงเงินที่คาด<br>ว่าจะได้รับ</td>';
              $html .= '</tr>';
              $html .= '<tr style="background-color:#EEEEEE;font-weight:bold">';
                $html .= '<td style="text-align:center;width:4%">วงเงินตาม<br>สัญญา</td>';
                $html .= '<td style="text-align:center;width:4%">รายการ</td>';
                $html .= '<td style="text-align:center;width:3%">ได้รับเงิน</td>';
                $html .= '<td style="text-align:center;width:3%">คงเหลือเรียก<br>เก็บเงิน</td>';
                $html .= '<td style="text-align:center;width:3%">เลขที่<br>ใบแจ้งหนี้</td>';
                $html .= '<td style="text-align:center;width:4%">เลขที่<br>ใบเสร็จรับเงิน</td>';
                $html .= '<td style="text-align:center;width:2%">T%</td>';
                $html .= '<td style="text-align:center;width:2%">A%</td>';

                $html .= '<td style="text-align:center;width:3%">ตามสัญญา</td>';
                $html .= '<td style="text-align:center;width:3%">รายการ</td>';
                $html .= '<td style="text-align:center;width:3%">จ่ายเงิน</td>';
                $html .= '<td style="text-align:center;width:3%">อนุมัติจ่าย</td>';
                $html .= '<td style="text-align:center;width:4%">คงเหลือจ่ายเงิน</td>';
                $html .= '<td style="text-align:center;width:2%">T%</td>';
                $html .= '<td style="text-align:center;width:2%">B%</td>';

                $html .= '<td style="text-align:center;width:3%">ประมาณการ</td>';
                $html .= '<td style="text-align:center;width:3%">ค่ารับรอง</td>';
                $html .= '<td style="text-align:center;width:3%">ใช้จริง</td>';

               $html .= '</tr>';  
            $html .= '</thead>';


             $html .= '<tbody>';
            //fiscalyear
                $fiscalyear = array();

                foreach ($model as $key => $value) {
                    if(!in_array($value->pj_fiscalyear."/".$value->pj_work_cat, $fiscalyear))
                       $fiscalyear[] = $value->pj_fiscalyear."/".$value->pj_work_cat;
                }


                asort($fiscalyear);
                 //summary all
                    $sumall_pc_cost = 0;
                    $sumall_pc_receive = 0;
                     
                    $sumall_oc_cost = 0;
                    $sumall_oc_receive = 0;

                    $sumall_m_real = 0;
                    $sumall_m_type1 = 0;
                    $sumall_m_expect = 0;
                    $sumall_profit = 0;
                foreach ($fiscalyear as $key => $value) {
                    $data = explode("/", $value);
                    $year = $data[0];
                    $cat = $data[1];

                    $mWorkCat = WorkCategory::model()->findByPk($cat);

                    //echo $mWorkCat->wc_name;
                    $html .=  '<tr style="background-color:#EBF8A4;font-weight:bold">';                    
                    $html .=  '<td style="width:100%" colspan="30">ปี '.$year.' '.$mWorkCat->wc_name.'</td>';                   
                    $html .= "</tr>";

                    $maxPayment = 5;
                    $index = 1;

                     //summary
                         $sum_pc_cost = 0;
                         $sum_pc_receive = 0;
                         $sum_pc_T = 0;
                         $sum_pc_A = 0;

                         $sum_oc_cost = 0;
                         $sum_oc_receive = 0;
                         $sum_oc_T = 0;
                         $sum_oc_A = 0;

                         $sum_m_real = 0;
                         $sum_m_type1 = 0;
                         $sum_m_expect = 0;
                         $sum_profit = 0;

                    foreach ($model as $key => $pj) {
                      if($pj->pj_fiscalyear==$year && $pj->pj_work_cat==$cat)
                      { 
                            //project contract
                         $Criteria = new CDbCriteria();
                         $Criteria->condition = "pc_proj_id='$pj->pj_id'";
                         $pcs = ProjectContract::model()->findAll($Criteria);
                         $nPC = count($pcs);

                         //2.outsource contract
                         $Criteria = new CDbCriteria();
                         $Criteria->condition = "oc_proj_id='$pj->pj_id'";
                         $ocs = OutsourceContract::model()->findAll($Criteria);
                         $nOC = count($ocs);

                         //management cost
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=0  AND mc_in_project!=3";
                        $m_plan = ManagementCost::model()->findAll($Criteria);

                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=2 ";
                        $m_real = ManagementCost::model()->findAll($Criteria);

                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=1  AND mc_in_project=3";
                        $m_type1 = ManagementCost::model()->findAll($Criteria);

                        //find tax
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=2 AND mc_detail LIKE '%อากร%'";
                        $m_tax = ManagementCost::model()->findAll($Criteria);

                        //end

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0")
                                            ->queryAll();
                        $sum_m_expect += $pp[0]["sum"];


                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 and mc_in_project=3")
                                            ->queryAll();
                        $m_type1_sum = $pp[0]["sum"];                    

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type!=0")
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
                                            ->where("pc_proj_id='$pj->pj_id'")
                                            ->queryAll();
                        //echo $pp[0]["sum"];
                        $income = $pp[0]["sum"];
                        
                        //1.outcome
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('outsource_contract','contract_id=oc_id')
                                            ->where("oc_proj_id='$pj->pj_id'")
                                            ->queryAll();                    
                        $outcome = $pp[0]["sum"];                    
                        $m_profit = $income - $outcome - $m_real_sum;

                        $sum_profit += $m_profit;




                         $maxContract = $nPC < $nOC ? $nOC : $nPC ;

                         $pj_rowspan = $maxContract * $maxPayment;

                          $iPC = 0;
                         $iOC = 0;
                         $pcCost = 0;
                         $ocCost = 0;
                        for ($i=0; $i <$pj_rowspan ; $i++) { 
                            
                            $html .="<tr>";
                                //draw project detail
                               
                                if($i==0)
                                {
                                   
                                    $html .='<td rowspan="'.$pj_rowspan.'" style="text-align:center;width:2%">'.$index.'</td>';
                                    $html .='<td rowspan="'.$pj_rowspan.'" style="width:6%">'.$pj->pj_name.'<br><br>';
                                    //workcode
                                    $Criteria = new CDbCriteria();
                                    $Criteria->condition = "pj_id='$pj->pj_id'";
                                    $workcodes = WorkCode::model()->findAll($Criteria);
                                    foreach ($workcodes as $key => $wc) {
                                        $html .= $wc->code."<br>";
                                    }
                                    foreach ($m_tax as $key => $t) {
                                        $html .= $t->mc_detail." ".number_format($t->mc_cost,2)." บาท<br>";
                                    }

                                    if(!empty($pj->pj_CA))
                                        $html .= $pj->pj_CA."<br>";
                                    $html .= "</td>";
                                }
                                
                                //draw PC
                                if($i % $maxPayment == 0)
                                {

                                     
                                    if(!empty($pcs[$iPC]))
                                    {   
                                        $pc = $pcs[$iPC];   
                                        $html .='<td rowspan="'.$maxPayment.'" width="5%">'.$pc->pc_details.'<br><br>';
                                        if(!empty($pc->pc_guarantee))
                                            $html .='-หนังสือค้ำประกัน '.$pc->pc_guarantee.'<br>';
                                        if(!empty($pc->pc_garantee_end))
                                            $html .='-เลขที่บันทึกส่งกองการเงิน '.$pc->pc_garantee_end.'<br>';
                                        if(!empty($pc->pc_PO))
                                        {
                                            //$pc->pc_PO = str_replace("PO", "", $pc->pc_PO);
                                            //echo "-PO ".$pc->pc_PO."<br>";
                                            $html .= "-".$pc->pc_PO.'<br>';
                                        }   
                                        $html .= "</td>";

                                        $html .='<td rowspan="'.$maxPayment.'" style="text-align:center;width:3%">'.$pc->pc_code."</td>";
                                
                                        $html .='<td rowspan="'.$maxPayment.'" style="text-align:center;width:3%">'.renderDate($pc->pc_sign_date).'<br><br>';
                                        $html .= '<u>ครบกำหนด</u><br>';
                                        $html .=  renderDate($pc->pc_end_date);
                                        $html .="</td>";



                                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll();
                                        ///print_r($changeHists);
                                        //echo $pp[0]["sum"];    

                                        $pcCost =$pc->pc_cost + $pp[0]["sum"];

                                        $sum_pc_cost += $pcCost;

                                        $html .='<td rowspan="'.$maxPayment.'" style="text-align:right;width:4%">'.number_format($pcCost,2)."</td>";



                                    }
                                    else{

                                        $html .='<td rowspan="'.$maxPayment.'"></td>';
                                        $html .='<td rowspan="'.$maxPayment.'"></td>';
                                        $html .='<td rowspan="'.$maxPayment.'"></td>';
                                        $html .='<td rowspan="'.$maxPayment.'"></td>';
                                    }   

                                    $iPC++; 
                                }

                                //draw Payment PC

                                $Criteria = new CDbCriteria();
                                $Criteria->condition = "proj_id='$pc->pc_id'";
                                $paymentProjs = PaymentProjectContract::model()->findAll($Criteria);

                                if(!empty($paymentProjs[$i]))
                                {
                                        $pay = $paymentProjs[$i];
                                        $html .='<td width="4%">'.$pay->detail."</td>";
                                        $html .='<td style="text-align:right;width:3%">'.$pay->money."</td>";

                                        //find pay before
                                        $str_date = explode("/", $pay->invoice_date);
                                        $invoice_date= "";
                                        if(count($str_date)>1)
                                            $invoice_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];
                                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->where('invoice_date < "'.$invoice_date.'" AND proj_id='.$pc->pc_id)
                                            ->queryAll();
                                            
                                        //print_r($pay->invoice_date);    
                                        $pay->money = str_replace(",", "", $pay->money);
                                        $sum_pc_receive += $pay->money;

                                        $pc_remain = $pcCost - $pay->money - $pp[0]["sum"];
                                        if($pc_remain!=0)
                                            $html .='<td style="text-align:right;width:3%">'.number_format($pc_remain,2)."</td>";
                                        else
                                            $html .='<td style="text-align:right;width:3%">-</td>';

                                        $html .='<td style="text-align:center;width:3%">'.$pay->invoice_no."<br>".renderDate($pay->invoice_date)."</td>";
                                        $html .='<td style="text-align:center;width:4%">'.$pay->bill_no."<br>".renderDate($pay->bill_date)."</td>";
                                
                                        if($i%$maxPayment==0)
                                        {
                                            $html .='<td style="text-align:center;width:2%">'.$pc->pc_T_percent."</td>";
                                            $html .='<td style="text-align:center;width:2%">'.$pc->pc_A_percent."</td>";     
                                            $sum_pc_T += $pc->pc_T_percent;
                                            $sum_pc_A += $pc->pc_A_percent;
                                        } 
                                        else{
                                            $html .='<td style="text-align:right;width:2%"></td><td style="text-align:right;width:2%"></td>';
                                        }
                                }
                                else{
                                    $html .='<td width="4%">&nbsp;</td><td width="3%">&nbsp;</td>';
                                    $html .='<td width="3%">&nbsp;</td><td width="3%">&nbsp;</td><td width="4%">&nbsp;</td>';
                                    //echo "<td>&nbsp;</td><td>&nbsp;</td>";

                                    if($i%$maxPayment==0 && $iPC!=0 && $iPC<=$nPC)
                                        {
                                            $html .='<td style="text-align:center;width:2%">'.$pc->pc_T_percent."</td>";
                                            $html .='<td style="text-align:center;width:2%">'.$pc->pc_A_percent."</td>";     
                                            $sum_pc_T += $pc->pc_T_percent;
                                            $sum_pc_A += $pc->pc_A_percent;
                                        } 
                                        else{
                                            $html .="<td></td><td></td>";
                                        }
                                }   

                                 //draw OC
                                if($i % $maxPayment == 0)
                                {

                                     
                                    if(!empty($ocs[$iOC]))
                                    {   
                                        $oc = $ocs[$iOC];   
                                        $vendor = vendor::model()->findByPk($oc->oc_vendor_id);
                                        $html .='<td rowspan="'.$maxPayment.'" style="width:5%">'.$vendor->v_name."</td>";

                                        $html .='<td rowspan="'.$maxPayment.'" style="width:5%">'.$oc->oc_detail."<br><br>";
                                        if(!empty($oc->oc_PO))
                                        {
                                            $oc->oc_PO = str_replace("PO", "", $oc->oc_PO);
                                            $html .="-WMS ".$oc->oc_PO."<br>";
                                        }
                                        if(!empty($oc->oc_letter))
                                            $html .="-หนังสือสั่งจ้าง ".$oc->oc_letter."<br>";
                                        if(!empty($oc->oc_guarantee))
                                            $html .="-หนังสือค้ำประกัน ".$oc->oc_guarantee."<br>";
                                        if(!empty($oc->oc_guarantee_cf))
                                            $html .="-หนังสือยืนยันค้ำประกัน ".$oc->oc_guarantee_cf."<br>";
                                        if(!empty($oc->oc_adv_guarantee))
                                            $html .="-หนังสือค้ำประกันล่วงหน้า ".$oc->oc_adv_guarantee."<br>";
                                        if(!empty($oc->oc_adv_guarantee_cf))
                                            $html .="-หนังสือยืนยันค้ำประกันล่วงหน้า ".$oc->oc_adv_guarantee_cf."<br>";
                                        
                                        if(!empty($oc->oc_insurance))
                                            $html .="-กรมธรรม์ประกันภัย ".$oc->oc_insurance."(".renderDate($oc->oc_insurance_start)."-".renderDate($oc->oc_insurance_end).")<br>";
                                            
                                        $html .="</td>";
                                        
                                        //echo renderDate($pc->pc_end_date);
                                        //echo "</td>";

                                        $html .='<td rowspan="'.$maxPayment.'" style="text-align:center;width:3%">'.$oc->oc_code."</td>";                                       
                                        $html .='<td rowspan="'.$maxPayment.'" style="text-align:center;width:4%">'.renderDate($oc->oc_sign_date)."</td>";
                                        $html .='<td rowspan="'.$maxPayment.'" style="text-align:center;width:3%">'.renderDate($oc->oc_end_date)."</td>";
                                        $html .='<td rowspan="'.$maxPayment.'" style="text-align:center;width:3%">'.renderDate($oc->oc_approve_date)."</td>";   


                                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$oc->oc_id' AND type=2")
                                            ->queryAll();
                                        ///print_r($changeHists);
                                        //echo $pp[0]["sum"];    
                                        $oc->oc_cost = str_replace(",", "", $oc->oc_cost);
                                        $ocCost =$oc->oc_cost + $pp[0]["sum"];

                                        $sum_oc_cost += $ocCost; 


                                        $html .='<td rowspan="'.$maxPayment.'" style="text-align:right;width:3%">'.number_format($ocCost,2)."</td>";



                                    }
                                    else{

                                        $html .='<td rowspan="'.$maxPayment.'" width="5%"></td>';
                                        $html .='<td rowspan="'.$maxPayment.'" width="5%"></td>';
                                        $html .='<td rowspan="'.$maxPayment.'" width="3%"></td>';
                                        $html .='<td rowspan="'.$maxPayment.'" width="4%"></td>';
                                        $html .='<td rowspan="'.$maxPayment.'" width="3%"></td>';
                                        $html .='<td rowspan="'.$maxPayment.'" width="3%"></td>';
                                        $html .='<td rowspan="'.$maxPayment.'" width="3%"></td>';
                                    }   

                                    $iOC++; 
                                }

                                //draw Payment OC
                                if(!empty($ocs[$iOC]))
                                {   
                                    $Criteria = new CDbCriteria();
                                    $Criteria->condition = "contract_id='$oc->oc_id'";
                                    $paymentProjs = PaymentOutsourceContract::model()->findAll($Criteria);

                                    if(!empty($paymentProjs[$i]))
                                    {
                                            $pay = $paymentProjs[$i];
                                            $html .= '<td width="3%">'.$pay->detail."</td>";
                                            $html .= '<td style="text-align:right;width:3%">'.$pay->money."</td>";
                                            $html .= '<td style="text-align:right;width:3%">'.renderDate($pay->approve_date)."</td>";


                                            //find pay before
                                            $str_date = explode("/", $pay->invoice_receive_date);
                                            $invoice_date= "";
                                            if(count($str_date)>1)
                                                $invoice_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];
                                            $pp = Yii::app()->db->createCommand()
                                                ->select('SUM(money) as sum')
                                                ->from('payment_outsource_contract')
                                                ->where('invoice_receive_date < "'.$invoice_date.'" AND contract_id='.$oc->oc_id)
                                                ->queryAll();
                                                
                                            //print_r($pp);    
                                            $pay->money = str_replace(",", "", $pay->money);
                                            $sum_oc_receive += $pay->money;
                                            $oc_remain = $ocCost - $pay->money - $pp[0]["sum"];
                                            
                                            if($oc_remain!=0)
                                               $html .= '<td style="text-align:right;width:4%">'.number_format($oc_remain,2)."</td>";
                                            else
                                                $html .= '<td style="text-align:right;width:4%">-</td>';
                                            
                                            if($i%$maxPayment==0)
                                            {
                                                $html .= '<td style="text-align:center;width:2%">'.$oc->oc_T_percent."</td>";
                                                $html .= '<td style="text-align:center;width:2%">'.$oc->oc_A_percent."</td>";     
                                                $sum_oc_T += $oc->oc_T_percent;
                                                $sum_oc_A += $oc->oc_A_percent;
                                            } 
                                            else{
                                                $html .= '<td style="text-align:center;width:2%"></td><td style="text-align:center;width:2%"></td>';
                                            }
                                    }
                                    else{

                                        $html .= '<td style="text-align:right;width:3%">&nbsp;</td><td style="text-align:right;width:3%">&nbsp;</td>';
                                        $html .= '<td style="text-align:right;width:3%">&nbsp;</td><td style="text-align:right;width:4%">&nbsp;</td>';
                                        
                                           if($i%$maxPayment==0 && $iOC!=0 && $iOC<=$nOC)
                                            {
                                                $html .= '<td style="text-align:center;width:2%">'.$oc->oc_T_percent."</td>";
                                                $html .= '<td style="text-align:center;width:2%">'.$oc->oc_A_percent."</td>";     
                                                $sum_oc_T += $oc->oc_T_percent;
                                                $sum_oc_A += $oc->oc_A_percent;
                                            } 
                                            else{
                                                $html .= '<td style="text-align:center;width:2%"></td><td style="text-align:center;width:2%"></td>';
                                            }
                                    }   
                                }else{

                                      $html .= '<td style="text-align:center;width:3%">&nbsp;</td><td style="text-align:center;width:3%">&nbsp;</td>';
                                        $html .= '<td style="text-align:center;width:3%">&nbsp;</td><td style="text-align:center;width:4%">&nbsp;</td>';
                                        //$html .= '<td>&nbsp;</td><td>&nbsp;</td>";

                                           if($i%$maxPayment==0 && $iOC!=0 && $iOC<=$nOC)
                                            {
                                                $html .= '<td style="text-align:center;width:2%">'.$oc->oc_T_percent."</td>";
                                                $html .= '<td style="text-align:center;width:2%">'.$oc->oc_A_percent."</td>";     
                                                $sum_oc_T += $oc->oc_T_percent;
                                                $sum_oc_A += $oc->oc_A_percent;
                                            } 
                                            else{
                                                $html .= '<td  style="text-align:center;width:2%"></td><td  style="text-align:center;width:2%"></td>';
                                            }
                                }
                                


                                //draw management cost
                               
                                if(!empty($m_plan[$i])) 
                                 $html .='<td style="text-align:right;width:3%">'.number_format($m_plan[$i]->mc_cost,2)."</td>";
                                else     
                                 $html .='<td width="3%"></td>'; 

                                if($i==0)
                                {
                                    if($m_type1_sum!=0)
                                        $html .='<td style="text-align:right;width:3%">'.number_format($m_type1_sum,2)."</td>";
                                    else
                                        $html .='<td style="text-align:right;width:3%"></td>'; 
                                    if($m_real_sum!=0)
                                        $html .='<td style="text-align:right;width:3%">'.number_format($m_real_sum,2)."</td>";
                                    else
                                        $html .='<td style="text-align:right;width:3%"></td>'; 
                                    if($m_profit!=0)    
                                        $html .='<td style="text-align:right;width:4%">'.number_format($m_profit,2)."</td>";
                                    else
                                        $html .='<td style="text-align:right;width:4%"></td>'; 
                                }
                                else
                                    $html .='<td width="3%"></td><td width="3%"></td><td width="4%"></td>';
                            $html .="</tr>";    
                        }        
                        $index++;
                      }
                    } 

                    //summary
                      $sumall_pc_cost += $sum_pc_cost;
                     $sumall_pc_receive += $sum_pc_receive;
                     $sumall_oc_cost += $sum_oc_cost;
                     $sumall_oc_receive += $sum_oc_receive;

                     $sumall_m_real += $sum_m_real;
                     $sumall_m_type1 += $sum_m_type1;
                     $sumall_m_expect += $sum_m_expect;
                     $sumall_profit += $sum_profit;
                    $html .= '<tr style="background-color:#F0B2FF;font-weight:bold">';
                        $html .= '<td colspan="2" style="text-align:center;background-color:#F0B2FF;">รวมเป็นจำนวนเงิน</td>';
                        $html .= '<td ></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="background-color:#F0B2FF;" align="right">'.number_format($sum_pc_cost,2)."</td>";
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td align="right">'.number_format($sum_pc_receive,2)."</td>";
                        $html .= '<td align="right">'.number_format($sum_pc_cost - $sum_pc_receive,2)."</td>";
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        //$html .= '<td sytle="text-align:center;background-color:#F0B2FF;'>".$sum_pc_T."%</td>";
                        //$html .= '<td sytle="text-align:center;background-color:#F0B2FF;'>".$sum_pc_A."%</td>";
                    
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td align="right">'.number_format($sum_oc_cost,2)."</td>";
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td align="right">'.number_format($sum_oc_receive,2)."</td>";
                        $html .= '<td sytle="text-align:right;background-color:#F0B2FF;"></td>';            
                        $html .= '<td align="right">'.number_format($sum_oc_cost - $sum_oc_receive,2)."</td>";
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';   
                        $html .= '<td align="right">'.number_format($sum_m_expect,2)."</td>";  
                        $html .= '<td align="right">'.number_format($sum_m_type1,2)."</td>";  
                        $html .= '<td align="right">'.number_format($sum_m_real,2)."</td>";  
                        $html .= '<td align="right">'.number_format($sum_profit,2)."</td>";  


                    $html .= '</tr>';      

                }

                $html .= '<tr style="background-color:#F0B2FF;font-weight:bold">';
                        $html .= '<td colspan="2" style="text-align:center;background-color:#F0B2FF;">รวมเป็นจำนวนเงินทั้งหมด</td>';
                        $html .= '<td ></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="background-color:#F0B2FF;" align="right">'.number_format($sumall_pc_cost,2)."</td>";
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td align="right">'.number_format($sumall_pc_receive,2)."</td>";
                        $html .= '<td align="right">'.number_format($sumall_pc_cost - $sumall_pc_receive,2)."</td>";
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        //$html .= '<td sytle="text-align:center;background-color:#F0B2FF;'>".$sum_pc_T."%</td>";
                        //$html .= '<td sytle="text-align:center;background-color:#F0B2FF;'>".$sum_pc_A."%</td>";
                    
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td align="right">'.number_format($sumall_oc_cost,2)."</td>";
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td align="right">'.number_format($sumall_oc_receive,2)."</td>";
                        $html .= '<td sytle="text-align:right;background-color:#F0B2FF;"></td>';            
                        $html .= '<td align="right">'.number_format($sumall_oc_cost - $sumall_oc_receive,2)."</td>";
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';
                        $html .= '<td sytle="text-align:center;background-color:#F0B2FF;"></td>';   
                        $html .= '<td align="right">'.number_format($sumall_m_expect,2)."</td>";  
                        $html .= '<td align="right">'.number_format($sumall_m_type1,2)."</td>";  
                        $html .= '<td align="right">'.number_format($sumall_m_real,2)."</td>";  
                        $html .= '<td align="right">'.number_format($sumall_profit,2)."</td>";  


                    $html .= '</tr>';          
            $html .= '<tbody>';    
    $html .= '</table>';     
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    //$pdf->AddPage('L', 'A4');
   // $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
// Print text using writeHTMLCell()

//$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'summaryReport.pdf','F');

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