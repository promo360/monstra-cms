<?php

/**
 * pGelato Library
 *
 * This source file is part of the pGelato Library. More information,
 * documentation and tutorials can be found at http://gelato.monstra.org
 *
 * @package     pGelato
 *
 * @author      Romanenko Sergey / Awilum <awilum@msn.com>
 * @copyright   2012-2014 Romanenko Sergey / Awilum <awilum@msn.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Date
{
    /**
     * Protected constructor since this is a static class.
     *
     * @access  protected
     */
    protected function __construct()
    {
        // Nothing here
    }

    /**
     * Get format date
     *
     *  <code>
     *      echo Date::format($date, 'd.m.Y');
     *  </code>
     *
     * @param  integer $date   Unix timestamp
     * @param  string  $format Date format
     * @return integer
     */
    public static function format($date, $format = 'd.m.Y')
    {
        // Redefine vars
        $format = (string) $format;
        $date   = (int) $date;

        return date($format, $date);
    }

    /**
     * Get number of seconds in a minute, incrementing by a step.
     *
     *  <code>
     *      $seconds = Date::seconds();
     *  </code>
     *
     * @param  integer $step  Amount to increment each step by, 1 to 30
     * @param  integer $start Start value
     * @param  integer $end   End value
     * @return array
     */
    public static function seconds($step = 1, $start = 0, $end = 60)
    {
        // Redefine vars
        $step  = (int) $step;
        $start = (int) $start;
        $end   = (int) $end;

        return Date::_range($step, $start, $end);
    }

    /**
     * Get number of minutes in a hour, incrementing by a step.
     *
     *  <code>
     *      $minutes = Date::minutes();
     *  </code>
     *
     * @param  integer $step  Amount to increment each step by, 1 to 30
     * @param  integer $start Start value
     * @param  integer $end   End value
     * @return array
     */
    public static function minutes($step = 5, $start = 0, $end = 60)
    {
        // Redefine vars
        $step  = (int) $step;
        $start = (int) $start;
        $end   = (int) $end;

        return Date::_range($step, $start, $end);
    }

    /**
     * Get number of hours, incrementing by a step.
     *
     *  <code>
     *      $hours = Date::hours();
     *  </code>
     *
     * @param  integer $step  Amount to increment each step by, 1 to 30
     * @param  integer $long  Start value
     * @param  integer $start End value
     * @return array
     */
    public static function hours($step = 1, $long = false, $start = null)
    {
        // Redefine vars
        $step  = (int) $step;
        $long  = (bool) $long;

        if ($start === null) $start = ($long === FALSE) ? 1 : 0;
        $end = ($long === true) ? 23 : 12;

        return Date::_range($step, $start, $end, true);
    }

    /**
     * Get number of months.
     *
     *  <code>
     *      $months = Date::months();
     *  </code>
     *
     * @return array
     */
    public static function months()
    {
        return Date::_range(1, 1, 12, true);
    }

    /**
     * Get number of days.
     *
     *  <code>
     *      $months = Date::days();
     *  </code>
     *
     * @return array
     */
    public static function days()
    {
        return Date::_range(1, 1, Date::daysInMonth((int) date('M')), true);
    }

    /**
     * Returns the number of days in the requested month
     *
     *  <code>
     *      $days = Date::daysInMonth(1);
     *  </code>
     *
     * @param  integer $month Month as a number (1-12)
     * @param  integer $year  The year
     * @return integer
     */
    public static function daysInMonth($month, $year = null)
    {
        // Redefine vars
        $month = (int) $month;
        $year   = ! empty($year) ? (int) $year : (int) date('Y');

        return (int) date('t', mktime(0, 0, 0, $month, 1, $year));
    }

    /**
     * Get number of years.
     *
     *  <code>
     *      $years = Date::years();
     *  </code>
     *
     * @param  integer $start  Start value
     * @param  integer $end    End value
     * @return array
     */
    public static function years($start = 1980, $end = 2024)
    {
        // Redefine vars
        $start = (int) $start;
        $end   = (int) $end;

        return Date::_range(1, $start, $end, true);
    }

    /**
     * Get current season name
     *
     *  <code>
     *      echo Date::season();
     *  </code>
     *
     * @return string
     */
    public static function season()
    {
        $seasons = array("Winter", "Spring", "Summer", "Autumn");

        return $seasons[(int) ((date("n") %12)/3)];
    }

    /**
     * Get today date
     *
     *  <code>
     *      echo Date::today();
     *  </code>
     *
     * @param  string $format Date format
     * @return string
     */
    public static function today($format = '')
    {
        // Redefine vars
        $format = (string) $format;

        if ($format != '') { return date($format); } else { return date(PROMO_DATE_FORMAT); }
    }

    /**
     * Get yesterday date
     *
     *  <code>
     *      echo Date::yesterday();
     *  </code>
     *
     * @param  string $format Date format
     * @return string
     */
    public static function yesterday($format = '')
    {
        // Redefine vars
        $format = (string) $format;

        if ($format != '') { return date($format, strtotime("-1 day")); } else { return date(PROMO_DATE_FORMAT, strtotime("-1 day")); }
    }

    /**
     * Get tomorrow date
     *
     *  <code>
     *      echo Date::tomorrow();
     *  </code>
     *
     * @param  string $format Date format
     * @return string
     */
    public static function tomorrow($format = '')
    {
        // Redefine vars
        $format = (string) $format;

        if ($format != '') { return date($format, strtotime("+1 day")); } else { return date(PROMO_DATE_FORMAT, strtotime("-1 day")); }
    }

    /**
     * Converts a UNIX timestamp to DOS format.
     *
     *  <code>
     *      $dos = Date::unix2dos($unix);
     *  </code>
     *
     * @param  integer $timestamp UNIX timestamp
     * @return integer
     */
    public static function unix2dos($timestamp = 0)
    {
        $timestamp = ($_timestamp == 0) ? getdate() : getdate($_timestamp);

        if ($timestamp['year'] < 1980) return (1 << 21 | 1 << 16);

        $timestamp['year'] -= 1980;

        return ($timestamp['year']    << 25 | $timestamp['mon']     << 21 |
                $timestamp['mday']    << 16 | $timestamp['hours']   << 11 |
                $timestamp['minutes'] << 5  | $timestamp['seconds'] >> 1);
    }

    /**
     * Converts a DOS timestamp to UNIX format.
     *
     *  <code>
     *      $unix = Date::dos2unix($dos);
     *  </code>
     *
     * @param  integer $timestamp DOS timestamp
     * @return integer
     */
    public static function dos2unix($timestamp)
    {
        $sec  = 2 * ($timestamp & 0x1f);
        $min  =  ($timestamp >> 5) & 0x3f;
        $hrs  =  ($timestamp >> 11) & 0x1f;
        $day  =  ($timestamp >> 16) & 0x1f;
        $mon  = (($timestamp >> 21) & 0x0f);
        $year = (($timestamp >> 25) & 0x7f) + 1980;

        return mktime($hrs, $min, $sec, $mon, $day, $year);
    }
    
    /**
     * Get Time zones for Russia
     *
     * @author Yudin Evgeniy / JINN <info@promo360.ru>
     * @return array
     */
    function timezones() {
        $array = array();
        
        foreach(DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, 'RU') as $zone) {
            date_default_timezone_set($zone);
            $array[$zone] = '(GMT' . date('P', time()) .') '. $zone;
        }
        
        asort($array);
        
        return $array;
    }

    /**
     * _range()
     */
    protected static function _range($step, $start, $end, $flag = false)
    {
        $result = array();
        if ($flag) {
            for ($i = $start; $i <= $end; $i += $step) $result[$i] = (string) $i;
        } else {
            for ($i = $start; $i < $end; $i += $step) $result[$i]  = sprintf('%02d', $i);
        }

        return $result;
    }

}
