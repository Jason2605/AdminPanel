<?php
/**
 * English.php
 *
 * @author  Michael Pratt <pratt@hablarmierda.net>
 * @link    http://www.michael-pratt.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace RelativeTime\Languages;

/**
 * English Translation
 */
class English extends \RelativeTime\Adapters\Language
{
    protected $strings = array(
        'now' => 'just now',
        'ago' => '%s ago',
        'left' => '%s left',
        'seconds' => array(
            'plural' => '%d seconds',
            'singular' => '%d second',
        ),
        'minutes' => array(
            'plural' => '%d minutes',
            'singular' => '%d minute',
        ),
        'hours' => array(
            'plural' => '%d hours',
            'singular' => '%d hour',
        ),
        'days' => array(
            'plural' => '%d days',
            'singular' => '%d day',
        ),
        'months' => array(
            'plural' => '%d months',
            'singular' => '%d month',
        ),
        'years' => array(
            'plural' => '%d years',
            'singular' => '%d year',
        ),
    );
}

?>
