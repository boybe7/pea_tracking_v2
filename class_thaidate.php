<?php
/**
 * DS Thaidate v2.0.1
 * 
 * @name Thaidate Class
 * @version 2.0.1
 * @author Narong Rammanee, <ranarong@live.com>
 * @copyright Copyright (c) 2010, Narong Rammanee
 * @license No Licence Free 2010
 */
class Thaidate {
	
	private $_day;
	private $_month;
	private $_year;
	private $_hour;
	private $_minute;
	private $_second;
	private $_th_day;
	private $_th_month;
	private $_th_year;
	private $_th_date;
	private $_th_time;
	private $_format;
	private $_tmp;
	
	private $full_day = array('Sun'=>'อาทิตย์', 'Mon'=>'จันทร์', 'Tue'=>'อังคาร', 'Wed'=>'พุธ', 
														'Thu'=>'พฤหัสบดี', 'Fri'=>'ศุกร์', 'Sat'=>'เสาร์'
											);
	private $quick_day = array('Sun'=>'อา.', 'Mon'=>'จ.', 'Tue'=>'อ.', 'Wed'=>'พ.', 
														 'Thu'=>'พฤ.', 'Fri'=>'ศ.', 'Sat'=>'ส.'
											 );
	
	private $full_month = array('01'=>'มกราคม', '02'=>'กุมภาพันธ์', '03'=>'มีนาคม', '04'=>'เมษายน',
									 						'05'=>'พฤษภาคม', '06'=>'มิถุนายน', '07'=>'กรกฎาคม', '08'=>'สิงหาคม',
									 						'09'=>'กันยายน', '10'=>'ตุลาคม', '11'=>'พฤศจิกายน', '12'=>'ธันวาคม'
												);
	private $quick_month = array('01'=>'ม.ค.', '02'=>'ก.พ.', '03'=>'มี.ค.', '04'=>'เม.ย.', 
															'05'=>'พ.ค.', '06'=>'มิ.ย.', '07'=>'ก.ค.', '08'=>'ส.ค.',
										 					'09'=>'ก.ย.', '10'=>'ต.ค.', '11'=>'พ.ย.', '12'=>'ธ.ค.'
												 );
	private $_th_number = array('๐', '๑', '๒', '๓', '๔', '๕', '๖', '๗', '๘', '๙');
	private $_ar_number = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
	
	/**
	 * Initialization
   *
   * @param string $date
   * @param string $format
   */	
	public function __construct($date, $format) {
		
			$this->_day 	 = substr($date, 8, -11);
			$this->_month  = substr($date, 5, -14);
			$this->_year 	 = substr($date, 0, -17);
			$this->_hour 	 = substr($date, 13, -6);
			$this->_minute = substr($date, 16, -3);
			$this->_second = substr($date, 19);
			$this->_format = $format;
	}
	
	/**
	 * Get date time
	 * 
	 * @return thai date time
   */	
	public function getDateTime() {
		
		if(!$this->_th_date = self::convertDate())
			throw new Exception('Error obtaining date!');
		
		return $this->_th_date;
	}
	
	/**
	 * define private 'convertDate()' method
	 * 
	 * @return thai date
   */	
	private function convertDate() {
		
		$this->_th_day 	 = $this->full_day[date("D", mktime(0, 0, 0, $this->_month, $this->_day, $this->_year))];
		$this->_th_month = ($this->_format == 'E8' || $this->_format == 'E10')? $this->quick_month[$this->_month] : $this->full_month[$this->_month];	
		$this->_th_year  = $this->_year + 543;
		$this->_th_time	 = ($this->_format != 'E4') ? $this->_hour.':'.$this->_minute.' น.' 
																								: date("g:i A", mktime($this->_hour, $this->_minute, 0, 0, 0, 0));
		switch($this->_format) {
			case 'E1' : $this->_th_date = $this->_day.'/'.intval($this->_month).'/'.substr($this->_th_year, -2); break;
			case 'E2' : $this->_th_date = $this->_day.'/'.intval($this->_month).'/'.$this->_th_year; break;
			case 'E3' : 
			case 'E4' : $this->_th_date = $this->_day.'/'.intval($this->_month).'/'.$this->_th_year.' '.$this->_th_time; break;
			case 'E5' : $this->_th_date = self::thaiNumber($this->_day).'/'.self::thaiNumber(intval($this->_month)).'/'.self::thaiNumber(substr($this->_th_year, -2)); break;
			case 'E6' : $this->_th_date = self::thaiNumber($this->_day).'/'.self::thaiNumber($this->_month).'/'.self::thaiNumber($this->_th_year); break;
			case 'E7' : $this->_th_date = self::thaiNumber($this->_day).'/'.self::thaiNumber($this->_month).'/'.self::thaiNumber($this->_th_year).' '.self::thaiNumber($this->_hour).':'.self::thaiNumber($this->_minute).' น.'; break;
			case 'E8' : $this->_th_date = $this->_day.' '.$this->_th_month.' '.$this->_th_year; break;
			case 'E9' : $this->_th_date = $this->_day.' '.$this->_th_month.' '.$this->_th_year; break;
			case 'E10' : $this->_th_date = self::thaiNumber($this->_day).' '.$this->_th_month.' '.self::thaiNumber($this->_th_year); break;
			case 'E11' : $this->_th_date = self::thaiNumber($this->_day).' '.$this->_th_month.' '.self::thaiNumber($this->_th_year); break;
			case 'E12' : $this->_th_date = $this->_day.' '.date("M", mktime(0, 0, 0, $this->_month, 0, 0)).' '.substr($this->_th_year, -2); break;
			case 'E13' : $this->_th_date = $this->_day.' '.date("M", mktime(0, 0, 0, $this->_month, 0, 0)).' '.$this->_th_year; break;
			case 'F1' : $this->_th_date = 'วัน'.$this->_th_day.' ที่ '. intval($this->_day).' เดือน '.$this->_th_month.' พ.ศ. '.$this->_th_year; break;
			case 'F2' : $this->_th_date = 'วัน'.$this->_th_day.' ที่ '. intval($this->_day).' เดือน '.$this->_th_month.' พ.ศ. '.$this->_th_year.' เวลา '.$this->_th_time; break;
		        case 'F3' : $this->_th_date = 'วันที่ '. intval($this->_day).'  '.$this->_th_month.'  '.$this->_th_year; break;
			
                    
                }	
		return $this->_th_date;
	}

	/**
	 * define private 'thaiNumber()' method
	 * 
	 * @return thai number digit
   */	
	private function thaiNumber($number) {
		
		return str_replace($this->_ar_number, $this->_th_number, $number);
	}
}