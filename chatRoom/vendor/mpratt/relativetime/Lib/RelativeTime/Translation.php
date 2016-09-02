<?php
/**
 * Translation.php
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
 * This class is responsible for translating
 * an array with time units into a string of
 * a given language
 */
class Translation
{
    /** @var array Array With configuration options **/
    protected $config = array();

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
        ), $config);
    }

    /**
     * Actually translates the units into words
     *
     * @param array $units
     * @param int $direction
     * @return string
     */
    public function translate(array $units = array(), $direction = 0)
    {
        $lang = $this->loadLanguage();
        if (empty($units))
            return $lang['now'];

        $translation = array();
        foreach ($units as $unit => $v)
        {
            if ($v == 1)
                $translation[] = sprintf($lang[$unit]['singular'], $v);
            else
                $translation[] = sprintf($lang[$unit]['plural'], $v);
        }

        $string = implode($this->config['separator'], $translation);
        if (!$this->config['suffix'])
            return $string;
        else if ($direction > 0)
            return sprintf($lang['ago'], $string);

        return sprintf($lang['left'], $string);
    }

    /**
     * Loads the language definitions
     *
     * @return object
     */
    protected function LoadLanguage()
    {
        $languages = array(
            '\RelativeTime\Languages\\' . $this->config['language'],
            $this->config['language'],
        );

        foreach ($languages as $lang)
        {
            if (class_exists($lang))
                return new $lang();
        }

        return new \RelativeTime\Languages\English();
    }
}
?>
