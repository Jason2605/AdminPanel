<?php
/**
 * RelativeTime.php
 *
 * @author  Michael Pratt <pratt@hablarmierda.net>
 * @link    http://www.michael-pratt.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace RelativeTime;

/**
 * The Main Class of the library
 */
class RelativeTime
{
    /** @var int Class constant with the current Version of this library */
    const VERSION = '1.0';

    /** @var array Array With configuration options **/
    protected $config = array();

    /** @var object instance of \Relativetime\Translation **/
    protected $translation;

    /**
     * Construct
     *
     * @param array $config Associative array with configuration directives
     * @return void
     */
    public function __construct(array $config = array())
    {
        $this->config = array_merge(array(
            'language' => '\RelativeTime\Languages\English',
            'separator' => ', ',
            'suffix' => true,
            'truncate' => 0,
        ), $config);

        $this->translation = new \RelativeTime\Translation($this->config);
    }

    /**
     * Converts 2 dates to its relative time.
     *
     * @param string $fromTime
     * @param string $toTime When null is given, uses the current date.
     * @return string
     */
    public function convert($fromTime, $toTime = null)
    {
        $interval = $this->getInterval($fromTime, $toTime);
        $units = $this->calculateUnits($interval);
        return $this->translation->translate($units, $interval->invert);
    }

    /**
     * Tells the time passed between the current date and the given date
     *
     * @param string $date
     * @return string
     */
    public function TimeAgo($date)
    {
        $interval = $this->getInterval(time(), $date);
        if ($interval->invert)
            return $this->convert(time(), $date);

        return $this->translation->translate();
    }

    /**
     * Tells the time until the given date
     *
     * @param string $date
     * @return string
     */
    public function TimeLeft($date)
    {
        $interval = $this->getInterval($date, time());
        if ($interval->invert)
            return $this->convert(time(), $date);

        return $this->translation->translate();
    }

    /**
     * Calculates the interval between the dates and returns
     * an array with the valid time.
     *
     * @param string $fromTime
     * @param string $toTime When null is given, uses the current date.
     * @return array
     */
    protected function getInterval($fromTime, $toTime = null)
    {
        $fromTime = new \DateTime($this->normalizeDate($fromTime));
        $toTime   = new \DateTime($this->normalizeDate($toTime));
        return $fromTime->diff($toTime);
    }

    /**
     * Normalizes a date for the \DateTime class
     *
     * @param string $date
     * @return string
     */
    protected function normalizeDate($date)
    {
        $date = str_replace(array('/', '|'), '-', $date);
        if (empty($date))
            return date('Y-m-d H:i:s');
        else if (ctype_digit($date))
            return date('Y-m-d H:i:s', $date);

        return $date;
    }

    /**
     * Given a DateInterval, creates an array with the time
     * units and truncates it when necesary.
     *
     * @param object $interval Instance of \DateInterval
     * @return array
     */
    protected function calculateUnits(\DateInterval $interval)
    {
        $units = array_filter(array(
            'years'   => (int) $interval->y,
            'months'  => (int) $interval->m,
            'days'    => (int) $interval->d,
            'hours'   => (int) $interval->h,
            'minutes' => (int) $interval->i,
            'seconds' => (int) $interval->s,
        ));

        if (empty($units))
            return array();
        else if ($this->config['truncate'] > 0)
            return array_slice($units, 0, $this->config['truncate']);
        else
            return $units;
    }
}
?>
