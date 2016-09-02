<?php
/**
 * Language.php
 *
 * @author  Michael Pratt <pratt@hablarmierda.net>
 * @link    http://www.michael-pratt.com/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace RelativeTime\Adapters;

/**
 * Abstract class for language definitions.
 * It basically gives the option to use an object
 * as as an array.
 */
abstract class Language implements \ArrayAccess
{
    protected $strings = array();

    /**
     * Sets a parameter
     *
     * @param string $id
     * @param string $value
     */
    public function offsetSet($id, $value) { $this->strings[$id] = $value; }

    /**
     * Gets a parameter
     *
     * @param string $id
     * @return string
     *
     * @throws InvalidArgumentException if the id is not defined
     */
    public function offsetGet($id)
    {
        if (!array_key_exists($id, $this->strings))
            throw new \InvalidArgumentException($id . ' is not defined');

        return $this->strings[$id];
    }

    /**
     * Checks if a parameter is set.
     *
     * @param string $id
     * @return bool
     */
    public function offsetExists($id) { return array_key_exists($id, $this->strings); }

    /**
     * Unsets a parameter
     *
     * @param string $id
     * @return void
     */
    public function offsetUnset($id) { unset($this->strings[$id]); }

    /**
     * Returns all defined keys
     *
     * @return array
     */
    public function keys() { return array_keys($this->strings); }
}

?>
