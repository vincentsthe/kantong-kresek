<?php

/**
 * This class list all utilities needed by the application
 * 
 * @author vincentsthe
 *
 */
class Utilities {
	
	/**
	 * Convert the string $formattedDate into timestamp
	 * The formattedDate is assumed to have format "%d-%m-%Y %H:%M"
	 * 
	 * @param string $formattedDate
	 * @return number timestamp
	 */
	public static function formattedDateToTimestamp($formattedDate, $format = "%d-%m-%Y %H:%M") {
		$time = strptime($formattedDate, $format);
		return mktime($time['tm_hour'], $time['tm_min'], 0, $time['tm_mon']+1, $time['tm_mday'], $time['tm_year'] + 1900);
	}
	
	/**
	 * Convert timestamp to formatted date.
	 * Date format is "%d-%m-%Y %H:%M"
	 * 
	 * @param int $timestamp 	timestamp to be converted
	 * @return string			Formatted date
	 */
	public static function timestampToFormattedDate($timestamp, $format = "d-m-Y G:i") {
		return date($format, $timestamp);
	}
	/**
	 * Convert seconds to formatted date.
	 * @param int $seconds tau lah ya
	 * @return string
	 */
	public static function secondsToFormattedDate($seconds){
		return Utilities::timestampToFormattedDate(mktime(0,0,$seconds,0,0,0));
	}
	
	public static function hashPassword($password) {
		return sha1($password);
	}
	
	public static function currency($value) {
		setlocale(LC_MONETARY, 'id_ID.UTF-8');
		return preg_replace("/^IDR/", "Rp ", money_format('%i', floatval($value)));
	}
	
}