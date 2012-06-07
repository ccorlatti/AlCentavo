<?php
/**
 * $Id: Util.class.php 12 2010-07-06 04:34:57Z corlatti $
 * @author Claudio Corlatti
 *
 */
final class Util {
	
	function __construct() {
	
	}
	
	public static function irA($url){
		echo '<script> location.href = \'' . $url . '\'</script>';
	}
	
	public static function link($string){
		$string = rtrim(ltrim($string));
		$caracteres = Array(
							 ' ' => '-',
							 '?' => '',
							 ':' => '-',
							 'á' => 'a',
							 'é' => 'e',
							 'í' => 'i',
							 'ó' => 'o',
							 'ú' => 'u'
		);
		foreach (array_keys($caracteres) as $c){
			$string = str_replace($c, $caracteres[$c], $string);
		}
		return $string;
	}
	
	public static function sendmail($to, $subject, $body, $from='no-reply@al-centavo.com'){
		try {
			$resultado = mail($to, $subject, $body, "From: $from\nContent-Type: text/html; charset=iso-8859-1");
			if(!$resultado){
				throw new Exception();
			}
			
		} catch (Exception $e){
			throw $e;
		}
	}
	
	public static function convertDateToDbDate($str){
		try {
			if(!empty($str)){
				$tmp = explode('/', $str);
				if(strlen($tmp[2]) == 2){
					$tmp[2] = $tmp[2] + 2000;
				}
				return $tmp[2] . '-' . $tmp[1] . '-' . $tmp[0];
			} else {
				return '';
			}
		} catch (Exception $e){
			throw $e;
		}	
	}
	
	public static function convertDateToDbDateStandardBank($str){
		try {
				$tmp = explode('/', $str);
				if(strlen($tmp[2]) == 2){
					$tmp[2] = $tmp[2] + 2000;
				}
				return $tmp[2] . '-' . $tmp[0] . '-' . $tmp[1];
		} catch (Exception $e){
			throw $e;
		}	
	}
	
	public static function convertDateToDbDateBancoFrances($str){
		$result = $str;
		try {
			if(strpos($str, '/') > 1 || strpos($str, '-') > 1){
				$tmp = strpos($str, '/') > 1 ? explode('/', $str) : explode('-', $str);
				$result = $tmp[2] . '-' . $tmp[0] . '-' . $tmp[1];
			}
		} catch (Exception $e){
			throw $e;
		}
		return $result;	
	}	
		
	
	public static function convertDbDateToDate($str){
		try {
			
			
			$str = str_replace(' 00:00:00','',$str);
			$str = str_replace('0000-00-00','',$str);
			if(!empty($str)){
				$tmp = explode('-', $str);
				return $tmp[2] . '/' . $tmp[1] . '/' . $tmp[0];
			}
		} catch (Exception $e){
			throw $e;
		}	
	}
	
	public static function convertDbDateToDateWithTime($str, $time){
		$result = '';
		try {
			
			$dateparts = explode(' ', $str);
			if(!empty($str)){
				$tmp = explode('-', $dateparts[0]);
				$result = $tmp[2] . '/' . $tmp[1] . '/' . $tmp[0];
			}
			if($time){
				if($dateparts[1] != '00:00:00')
				$result .=  ' ' . $dateparts[1];
			}
			
		} catch (Exception $e){
			throw $e;
		}	
		return $result;
	}

	/*public function getDateDifference($date1, $date2) {
		$result = -1;
		try {
			if(!empty($date1) && !empty($date2)){
				echo $date1;
				echo '<BR>';
				echo $date2;
				echo '<BR>';
				$date1 = strtotime($date1);
				$date2 = strtotime($date2);
				
				$d1 = mktime(0,0,0,date('d', $date1),date('m', $date1),date('Y', $date1));
				$d2 = mktime(0,0,0,date('d', $date2),date('m', $date2),date('Y', $date2));
				$months = floor(($d2-$d1)/2628000);
				echo $months;	
				echo '<BR>';
				echo '<BR>';
			}
		} catch(Exception $e){
			throw $e;
		}
		return $result;
	}*/
	
	
  // Set timezone
  //date_default_timezone_set("UTC");
 
  // Time format is UNIX timestamp or
  // PHP strtotime compatible strings
  function dateDiff($time1, $time2, $precision = 6) {
    // If not numeric then convert texts to unix timestamps
    if (!is_int($time1)) {
      $time1 = strtotime($time1);
    }
    if (!is_int($time2)) {
      $time2 = strtotime($time2);
    }
 
    // If time1 is bigger than time2
    // Then swap time1 and time2
    if ($time1 > $time2) {
      $ttime = $time1;
      $time1 = $time2;
      $time2 = $ttime;
    }
 
    // Set up intervals and diffs arrays
    $intervals = array('year','month','day','hour','minute','second');
    $diffs = array();
 
    // Loop thru all intervals
    foreach ($intervals as $interval) {
      // Set default diff to 0
      $diffs[$interval] = 0;
      // Create temp time from time1 and interval
      $ttime = strtotime("+1 " . $interval, $time1);
      // Loop until temp time is smaller than time2
      while ($time2 >= $ttime) {
	$time1 = $ttime;
	$diffs[$interval]++;
	// Create new temp time from time1 and interval
	$ttime = strtotime("+1 " . $interval, $time1);
      }
    }
 
    $count = 0;
    $times = array();
    // Loop thru all diffs
    foreach ($diffs as $interval => $value) {
      // Break if we have needed precission
      if ($count >= $precision) {
	break;
      }
      // Add value and interval 
      // if value is bigger than 0
      if ($value > 0) {
	// Add s if value is not 1

	// Add value and interval to times array
	$times[$interval] = $value;
	$count++;
      }
    }
 
    // Return string with times
    return $times;
  }
	
	
	public static function generateToken($seed){
		$result = $seed;
		try {
			$s = strtoupper(md5(uniqid(rand(),true))); 
			$guid = 
				substr($s,0,8) . '-' . 
				substr($s,8,4) . '-' . 
				substr($s,12,4). '-' . 
				substr($s,16,4). '-' . 
				substr($s,20); 
			$result = $guid;
			
		} catch (Exception $e){
			throw $e;
		}	
		return $result;		
	}
	
	/**
	 * 
	 * @param string $dateRange range date format  dd/mm/yyyy - dd/mm/yyyy
	 */
	public static function dateRangeToDbDateRange($dateRange){
		$result = null;
		try {
			//its a range or a single date?
			$initHour = ' 00:00:00';
			$endHour = ' 23:59:59';
			if(strpos($dateRange,' - ') > 0 ){
				$dateParts = explode(' - ', $dateRange);
				$result = array(Util::convertDateToDbDate($dateParts[0]) . $initHour,Util::convertDateToDbDate($dateParts[1]) . $endHour);
			} else {
				$result = array(Util::convertDateToDbDate($dateRange) . $initHour,Util::convertDateToDbDate($dateRange) . $endHour);
			}		
		} catch (Exception $e){
			throw $e;
		}
		return $result;
	}
	
	public static function getUniqueToday(){
		$result = '';
		try {
			$result = date('YmdHisu');
		} catch (Exception $e){
			throw $e;
		}
		return $result;
	}
}

?>
