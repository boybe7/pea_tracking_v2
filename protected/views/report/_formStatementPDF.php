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
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, 10);
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
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = "";


$pj = $model;
$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

if($monthBegin==$monthEnd && $yearBegin==$yearEnd)
    $monthBetween = $month_th[$monthBegin]." ".$yearBegin;
else if($yearBegin==$yearEnd)
    $monthBetween = $month_th[$monthBegin]."-".$month_th[$monthEnd]." ".$yearEnd;
else
    $monthBetween = $month_th[$monthBegin]." ".$yearBegin."-".$month_th[$monthEnd]." ".$yearEnd;

$number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
$monthBegin2 = $monthBegin<10 ? "0".$monthBegin : $monthBegin;
$monthEnd2 = $monthEnd<10 ? "0".$monthEnd : $monthEnd;
$dayBegin = $yearBegin."-".$monthBegin2."-"."01";

$number = $number<10 ? "0".$number : $number;
$dayEnd = $yearEnd."-".$monthEnd2."-".$number;
$monthCondition = " BETWEEN '".$dayBegin."' AND '".$dayEnd."'";

$html = "";
$html .='<center><div style="text-align:center;font-size:16px;"><b>ฝ่ายบริการวิศวกรรม การไฟฟ้าส่วนภูมิภาค<br>งบกำไรขาดทุน<br>ช่วงเดือน '.$monthBetween.'</b></div></center>';
	
	$html .='<table border="0" style="margin-left:0px;margin-bottom:20px;">';
		$html .='<tr style="font-weight:bold;">';
		 $html .='<td style="text-align:center;width:5%"></td>';
		 $html .='<td style="text-align:center;width:43%"></td>';
		 $html .='<td style="text-align:center;width:20%"></td>';
		 $html .='<td style="text-align:center;width:2%"></td>';
		 $html .='<td style="text-align:center;width:20%">จำนวนเงิน (บาท)</td>';
		 $html .='<td style="text-align:center;width:10%">หมายเหตุ</td>';
		$html .='</tr>';
		$html .='<tr style="font-weight:bold;">';
		 $html .='<td colspan="6">รายได้ :</td>';

		$html .='</tr>';

		 //tsd กองบริการวิศวกรรมระบบส่ง
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='0' AND bill_date!='' AND bill_date ".$monthCondition)
                                            ->queryAll();
         $tsd_sum = $pp[0]["sum"];
		
		 //msd กองบริการบำรุงรักษา
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='1' AND bill_date!='' AND bill_date ".$monthCondition)
                                            ->queryAll();
         $msd_sum = $pp[0]["sum"];

         //dsd กองบริการวิศวกรรมระบบจำหน่าย
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='2' AND bill_date!='' AND bill_date ".$monthCondition)
                                            ->queryAll();
         $dsd_sum = $pp[0]["sum"];



		
			 
         $html .='<tr>';
			 $html .='<td style="text-align:center;width:5%"></td>';
			 $html .='<td style="text-align:left;width:43%">รายได้จากกองบริการวิศวกรรมระบบส่ง</td>';
			 $html .='<td style="text-align:right;width:20%">'.number_format($tsd_sum,2).'</td>';
			 $html .='<td style="text-align:center;width:2%"></td>';
			 $html .='<td style="text-align:center;width:20%"></td>';
			 $html .='<td style="text-align:center;width:10%">1</td>';
		  $html .='</tr>';
		  $html .='<tr>';
			 $html .='<td style="text-align:center;width:5%"></td>';
			 $html .='<td style="text-align:left;width:43%">รายได้จากกองบริการบำรุงรักษา</td>';
			 $html .='<td style="text-align:right;width:20%">'.number_format($msd_sum,2).'</td>';
			 $html .='<td style="text-align:center;width:2%"></td>';
			 $html .='<td style="text-align:center;width:20%"></td>';
			 $html .='<td style="text-align:center;width:10%">2</td>';
		  $html .='</tr>';
		  $html .='<tr>';
			 $html .='<td style="text-align:center;width:5%"></td>';
			 $html .='<td style="text-align:left;width:43%">รายได้จากกองบริการวิศวกรรมระบบจำหน่าย</td>';
			 $html .='<td style="text-align:right;width:20%;border-bottom:0.2mm solid black">'.number_format($dsd_sum,2).'</td>';
			 $html .='<td style="text-align:center;width:2%"></td>';
			 $income = $dsd_sum+$tsd_sum+$msd_sum;
			 $html .='<td style="text-align:right;width:20%;border-bottom:0.2mm solid black">'.number_format($dsd_sum+$tsd_sum+$msd_sum,2).'</td>';
			 $html .='<td style="text-align:center;width:10%">3</td>';
		  $html .='</tr>';	


		  $html .='<tr style="font-weight:bold;">';
		 $html .='<td colspan="6">หักค่าใช้จ่าย :</td>';

		$html .='</tr>';

		 //tsd กองบริการวิศวกรรมระบบส่ง
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='0' AND approve_date!='' AND approve_date ".$monthCondition)
                                            ->queryAll();
         $tsd_sum = $pp[0]["sum"];
		
		 //msd กองบริการบำรุงรักษา
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='1' AND approve_date!='' AND approve_date ".$monthCondition)
                                            ->queryAll();
         $msd_sum = $pp[0]["sum"];

         //dsd กองบริการวิศวกรรมระบบจำหน่าย
		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='2' AND approve_date!='' AND approve_date ".$monthCondition)
                                            ->queryAll();
         $dsd_sum = $pp[0]["sum"];
		
			 
         $html .='<tr>';
			 $html .='<td style="text-align:center;width:5%"></td>';
			 $html .='<td style="text-align:left;width:43%">ค่าจ้างเหมา-กองบริการวิศวกรรมระบบส่ง</td>';
			 $html .='<td style="text-align:right;width:20%">'.number_format($tsd_sum,2).'</td>';
			 $html .='<td style="text-align:center;width:2%"></td>';
			 $html .='<td style="text-align:center;width:20%"></td>';
			 $html .='<td style="text-align:center;width:10%">1</td>';
		  $html .='</tr>';
		  $html .='<tr>';
			 $html .='<td style="text-align:center;width:5%"></td>';
			 $html .='<td style="text-align:left;width:43%">ค่าจ้างเหมา-กองบริการบำรุงรักษา</td>';
			 $html .='<td style="text-align:right;width:20%">'.number_format($msd_sum,2).'</td>';
			 $html .='<td style="text-align:center;width:2%"></td>';
			 $html .='<td style="text-align:center;width:20%"></td>';
			 $html .='<td style="text-align:center;width:10%">2</td>';
		  $html .='</tr>';
		  $html .='<tr>';
			 $html .='<td style="text-align:center;width:5%"></td>';
			 $html .='<td style="text-align:left;width:43%">ค่าจ้างเหมา-กองบริการวิศวกรรมระบบจำหน่าย</td>';
			 $html .='<td style="text-align:right;width:20%;">'.number_format($dsd_sum,2).'</td>';
			 $html .='<td style="text-align:center;width:2%"></td>';
			 $html .='<td style="text-align:right;width:20%;"></td>';
			 $html .='<td style="text-align:center;width:10%">3</td>';
		  $html .='</tr>';	


		  				// $pp = Yii::app()->db->createCommand()
        //                                     ->select('SUM(mc_cost) as sum')
        //                                     ->from('management_cost')
        //                                     ->join('user','mc_user_update=u_id')
        //                                     ->where("department_id='0' AND mc_type=1 AND mc_date ".$monthCondition)
        //                                     ->queryAll();
        //                 $m_type1_tsd = $pp[0]["sum"];                    

        //                 $pp = Yii::app()->db->createCommand()
        //                                     ->select('SUM(mc_cost) as sum')
        //                                     ->from('management_cost')
        //                                     ->join('user','mc_user_update=u_id')
        //                                     ->where("department_id='0' AND mc_type=2 AND mc_date ".$monthCondition)
        //                                     ->queryAll();
                      
        //                 $m_real_tsd = $pp[0]["sum"];
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='0' AND mc_type!=0 AND mc_date ".$monthCondition)
                                            ->queryAll();
                      
                        $m_real_tsd = $pp[0]["sum"];
                        
                        $m_tsd = $m_real_tsd;// + $m_type1_tsd;

                        // $pp = Yii::app()->db->createCommand()
                        //                     ->select('SUM(mc_cost) as sum')
                        //                     ->from('management_cost')
                        //                     ->join('user','mc_user_update=u_id')
                        //                     ->where("department_id='1' AND mc_type=1 AND mc_date ".$monthCondition)
                        //                     ->queryAll();
                        // $m_type1_msd = $pp[0]["sum"];                    

                        // $pp = Yii::app()->db->createCommand()
                        //                     ->select('SUM(mc_cost) as sum')
                        //                     ->from('management_cost')
                        //                     ->join('user','mc_user_update=u_id')
                        //                     ->where("department_id='1' AND mc_type=2 AND mc_date ".$monthCondition)
                        //                     ->queryAll();
                      
                        // $m_real_msd = $pp[0]["sum"];
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='1' AND mc_type!=0 AND mc_date ".$monthCondition)
                                            ->queryAll();
                      
                        $m_real_msd = $pp[0]["sum"];

                        $m_msd = $m_real_msd;// + $m_type1_msd;

                        // $pp = Yii::app()->db->createCommand()
                        //                     ->select('SUM(mc_cost) as sum')
                        //                     ->from('management_cost')
                        //                     ->join('user','mc_user_update=u_id')
                        //                     ->where("department_id='2' AND mc_type=1 AND mc_date ".$monthCondition)
                        //                     ->queryAll();
                        // $m_type1_dsd = $pp[0]["sum"];                    

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='2' AND mc_type!=0 AND mc_date ".$monthCondition)
                                            ->queryAll();
                      
                        $m_real_dsd = $pp[0]["sum"];
                        $m_dsd = $m_real_dsd;// + $m_type1_dsd;
          $tsd_sap = 0;
          $msd_sap = 0;
          $dsd_sap = 0;

          $pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id=0 AND year=".$yearEnd)
                                            ->queryAll();
         
          if(count($pp)>0)
             $tsd_sap = $pp[0]["cost"];
          
          $pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id=1 AND year=".$yearEnd)
                                            ->queryAll();
          if(count($pp)>0)
             $msd_sap = $pp[0]["cost"];
          
          $pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id=2 AND year=".$yearEnd)
                                            ->queryAll();
          if(count($pp)>0)
             $dsd_sap = $pp[0]["cost"];
          

          $html .='<tr>';
             $html .='<td style="text-align:center;width:5%"></td>';
             $html .='<td style="text-align:left;width:43%">ค่าใช้จ่ายในการดำเนินงาน-กองบริการวิศวกรรมระบบส่ง</td>';
             $html .='<td style="text-align:right;width:20%">'.number_format($m_tsd,2).'</td>';
             $html .='<td style="text-align:center;width:2%"></td>';
             $html .='<td style="text-align:center;width:20%"></td>';
             $html .='<td style="text-align:center;width:10%">1</td>';
          $html .='</tr>';
          $html .='<tr>';
             $html .='<td style="text-align:center;width:5%"></td>';
             $html .='<td style="text-align:left;width:43%">ค่าใช้จ่ายในการดำเนินงาน-กองบริการบำรุงรักษา</td>';
             $html .='<td style="text-align:right;width:20%">'.number_format($m_msd,2).'</td>';
             $html .='<td style="text-align:center;width:2%"></td>';
             $html .='<td style="text-align:center;width:20%"></td>';
             $html .='<td style="text-align:center;width:10%">2</td>';
          $html .='</tr>';
                       
          $html .='<tr>';
             $html .='<td style="text-align:center;width:5%"></td>';
             $html .='<td style="text-align:left;width:43%">ค่าใช้จ่ายในการดำเนินงาน-กองบริการวิศวกรรมระบบจำหน่าย</td>';
             $html .='<td style="text-align:right;width:20%;">'.number_format($m_dsd,2).'</td>';
             $html .='<td style="text-align:center;width:2%"></td>';
             $html .='<td style="text-align:center;width:20%"></td>';
             $html .='<td style="text-align:center;width:10%">3</td>';
          $html .='</tr>';
                        

          $html .='<tr>';
			 $html .='<td style="text-align:center;width:5%"></td>';
			 $html .='<td style="text-align:left;width:43%">ค่าใช้จ่ายในการบริหารงาน-กองบริการวิศวกรรมระบบส่ง</td>';
			 $html .='<td style="text-align:right;width:20%">'.number_format($tsd_sap,2).'</td>';
			 $html .='<td style="text-align:center;width:2%"></td>';
			 $html .='<td style="text-align:center;width:20%"></td>';
			 $html .='<td style="text-align:center;width:10%">1</td>';
		  $html .='</tr>';
		  $html .='<tr>';
			 $html .='<td style="text-align:center;width:5%"></td>';
			 $html .='<td style="text-align:left;width:43%">ค่าใช้จ่ายในการบริหารงาน-กองบริการบำรุงรักษา</td>';
			 $html .='<td style="text-align:right;width:20%">'.number_format($msd_sap,2).'</td>';
			 $html .='<td style="text-align:center;width:2%"></td>';
			 $html .='<td style="text-align:center;width:20%"></td>';
			 $html .='<td style="text-align:center;width:10%">2</td>';
		  $html .='</tr>';
		               
		  $html .='<tr>';
			 $html .='<td style="text-align:center;width:5%"></td>';
			 $html .='<td style="text-align:left;width:43%">ค่าใช้จ่ายในการบริหารงาน-กองบริการวิศวกรรมระบบจำหน่าย</td>';
			 $html .='<td style="text-align:right;width:20%;border-bottom:0.2mm solid black">'.number_format($dsd_sap,2).'</td>';
			 $html .='<td style="text-align:center;width:2%"></td>';
			 $outcome = $dsd_sap+$tsd_sap+$msd_sap+$dsd_sum+$tsd_sum+$msd_sum+$m_tsd+$m_msd+$m_dsd;
			 $html .='<td style="text-align:right;width:20%;border-bottom:0.2mm solid black">'.number_format($outcome,2).'</td>';
			 $html .='<td style="text-align:center;width:10%">3</td>';
		  $html .='</tr>';
		  $html .='<tr style="font-weight:bold;">';
			 $html .='<td colspan="4">กำไรสุทธิ</td>';
             $html .='<td style="text-align:right;width:20%;border-bottom:0.2mm solid black">'.number_format($income - $outcome,2).'</td>';
			 $html .='<td style="text-align:center;width:10%"></td>';
		  $html .='</tr>';
		   $html .='<tr style="font-weight:bold;line-height: 10%;">';
			 $html .='<td colspan="4"></td>';
             $html .='<td style="text-align:right;width:20%;"></td>';
			 $html .='<td style="text-align:center;width:10%"></td>';
	        $html .='</tr>';				 
		   $html .='<tr style="font-weight:bold;">';
			 $html .='<td colspan="4"></td>';
             $html .='<td style="text-align:right;width:20%;border-top:0.2mm solid black">&nbsp;</td>';
			 $html .='<td style="text-align:center;width:10%"></td>';
		  $html .='</tr>';		

	$html .='</table>';
 

//echo $html;
 $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    



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

// exit;
?>