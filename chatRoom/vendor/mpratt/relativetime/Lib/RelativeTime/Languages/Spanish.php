<?php
/**
 * Spanish.php
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
 * Spanish Translation
 */
class Spanish extends \RelativeTime\Adapters\Language
{
    protected $strings = array(
        'now' => 'justo ahora',
        'ago' => 'hace %s',
        'left' => 'faltan %s',
        'seconds' => array(
            'plural' => '%d segundos',
            'singular' => '%d segundo',
        ),
        'minutes' => array(
            'plural' => '%d minutos',
            'singular' => '%d minuto',
        ),
        'hours' => array(
            'plural' => '%d horas',
            'singular' => '%d hora',
        ),
        'days' => array(
            'plural' => '%d dias',
            'singular' => '%d dia',
        ),
        'months' => array(
            'plural' => '%d meses',
            'singular' => '%d mes',
        ),
        'years' => array(
            'plural' => '%d años',
            'singular' => '%d año',
        ),
    );
}

?>
