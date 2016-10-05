<?php 

namespace Proengeno\Edifact\Message;

/**
 * Delimiter for EDIFACT-Messages
 */
class Delimiter 
{
	/**
	 * The UNA-Segment
	 * @var string
	 */
    const UNA_SEGMENT = 'UNA';
    /**
     * The default place-holder
     * @var string
     */
    const PLACE_HOLDER = ' #-|-# ';

    /**
     * Data
     * @var string
     */
    private $data;
	 /**
	  * a Data-Group
	  * @var string
	  */
    private $dataGroup;
    /**
     * The decimal splitter
     * @var string
     */
    private $decimal;
    /**
     * the terminator for the message
     * @var string
     */
    private $terminator;
    /**
     * an empty-value
     * @var string
     */
    private $empty;
    /**
     * a segment splitter
     * @var string
     */
    private $segment;
    
    /**
     * Constructor
     * @param string[optional] $data default = ':'
     * @param string[optional] $dataGroup default = '+'
     * @param string[optional] $decimal decimal separator default = '.'
     * @param string[optional] $terminator default = '?'
     * @param string[optional] $empty default = ' '
     * @param string[optional] $segment default = '\''
     */
    public function __construct($data = ':', $dataGroup = '+', $decimal = '.', $terminator = '?', $empty = ' ', $segment = '\'')
    {
        $this->data = $data;
        $this->dataGroup = $dataGroup;
        $this->decimal = $decimal;
        $this->terminator = $terminator;
        $this->empty = $empty;
        $this->segment = $segment;
    }
    
    /**
     * Static function to get a Delimitter from an existing EDIFACT-File
     * @param EdifactFile $file an existing EDIFACT-File
     * @return \Proengeno\Edifact\Message\Delimiter
     */
    public static function setFromFile(EdifactFile $file)
    {
        $position = $file->tell();
        $file->rewind();

        if ($file->read(3) != self::UNA_SEGMENT) {
            $instance = new self();
        } else {
            $instance = new self(
                $file->getChar(), $file->getChar(), $file->getChar(), $file->getChar(), $file->getChar(), $file->getChar()
            );
        }
        $file->seek($position);

        return $instance;
    }

    /**
     * terminate a given string
     * @param string $string
     * @return string the enterd string with replaced elements
     */
    public function terminate($string)
    {
        return str_replace(
            [$this->data, $this->dataGroup, '\\n'], 
            [$this->terminator . $this->data, $this->terminator . $this->dataGroup, ''],
            $string
        );
    }

    /**
     * Explodes segment from a given string
     * @param string $string
     * @return array an array of segments
     */
    public function explodeSegments($string)
    {
        return $this->explodeString($string, $this->dataGroup);
    }
    
    /**
     * Explode elements from a given string.
     * 
     * @param string $string
     * @return array an array of elements
     */
    public function explodeElements($string)
    {
        return $this->explodeString($string, $this->data);
    }
    
    public function getData()
    {
        return $this->data;
    }

    public function getDataGroup()
    {
        return $this->dataGroup;
    }

    public function getDecimal()
    {
        return $this->decimal;
    }

    public function getTerminator()
    {
        return $this->terminator;
    }

    public function getEmpty()
    {
        return $this->empty;
    }

    public function getSegment()
    {
        return $this->segment;
    }

    /**
     * Explodes a given string.
     * 
     * @param string $string
     * @param int $pattern
     * @return array
     */
    private function explodeString($string, $pattern)
    {
        $string = $this->removeLineBreaks($string);
        $foundTermination = (boolean)strpos($string, $this->terminator . $pattern);

        if ($foundTermination) {
            $string = str_replace($this->terminator . $pattern, self::PLACE_HOLDER, $string);
        }

        $explodedString = explode($pattern, $string);

        if ($foundTermination) {
            for ($i = 0, $count = count($explodedString); $i < $count; $i++) {
                $explodedString[$i] = str_replace(self::PLACE_HOLDER, $pattern, $explodedString[$i]);
            }
        }

        return $this->trimLastItem($explodedString);
    }

    /**
     * Trims the last item.
     * 
     * @param array $array
     * @return array
     */
    private function trimLastItem(array $array)
    {
        if (end($array) == '') {
            array_pop($array);
        }

        return $array;
    }

    /**
     * Removes line-breaks.
     * 
     * @param string $string
     * @return string
     */
    private function removeLineBreaks($string)
    {
        return str_replace(["\r", "\n"], '', $string);
    }
}
