<?php
namespace App\Traits;

trait Utilities
{

    /**
     * Check if date is in correct format.
     * 
     * @param Date $date        Required. Date to check.
     * @param String $format    Required. Date format to be compared. Default Y-m-d.
     *
     * @return Boolean
     */
    protected function checkDateFormat($date, $format="Y-m-d")
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * false if date1 is bigger tha date2.
     * 
     * @param Date $date1   Required. Date to check.
     * @param Date $date2   Required. Date to check.
     *
     * @return Boolean
     */
    protected function checkDiffDates($date1, $date2)
    {
        if($date1 > $date2)
            return false;
        return true;
    }
}