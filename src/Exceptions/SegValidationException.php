<?php 

namespace Proengeno\Edifact\Exceptions;

use Proengeno\Edifact\Message\Message;

/**
 * An exception for segment validations.
 */
class SegValidationException extends EdifactException
{
	/**
	 * Key
	 * @var string
	 */
    protected $key;
    /**
     * Value
     * @var string
     */
    protected $value;

    /**
     * Constructor
     * @param string $key a key
     * @param string $value a value
     * @param string $message a message
     * @param string $code some code
     */
    public function __construct($key, $value, $message, $code)
    {
        $this->setKey($key);
        $this->setValue($value);
        parent::__construct($message, $code);
    }
    
    /**
     * A static function for key value messages
     * @param string $key a key
     * @param string $value a value
     * @param string $message a message
     * @param string $code [optional] some code
     * @return \Proengeno\Edifact\Exceptions\SegValidationException
     */
    public static function forKeyValue($key, $value, $message, $code = 0)
    {
        $message = $key . ' (' . $value . ') : ' . $message;

        return new static($key, $value, $message, $code);
    }

    /**
     * Static function for key messages
     * @param string $key a key
     * @param string $message a message
     * @param string $code [optional] some code
     * @return \Proengeno\Edifact\Exceptions\SegValidationException
     */
    public static function forKey($key, $message, $code = 0)
    {
        $message = $key . ': ' . $message;

        return new static($key, null, $message, $code);
    }

    /**
     * Static function for value messages
     * @param string $value a value
     * @param string $message a message
     * @param string $code [optional] some code
     * @return \Proengeno\Edifact\Exceptions\SegValidationException
     */
    public static function forValue($value, $message, $code = 0)
    {
        $message = $value . ': ' . $message;

        return new static(null, $value, $message, $code);
    }

    /**
     * Gets the current key
     * @return string the current key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Gets the current value
     * @return string the current value
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Sets the current key
     * @param string $key the key to set
     * @return string the current (new) key
     */
    private function setKey($key)
    {
        return $this->key = $key;
    }

    /**
     * Sets the current value
     * @param string $value the value to set
     * @return string the current (new) value
     */
    private function setValue($value)
    {
        return $this->value = $value;
    }
}
