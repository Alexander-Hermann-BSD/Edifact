<?php 

namespace Proengeno\Edifact\Message;

use Proengeno\Edifact\Interfaces\SegInterface;

/**
 * A factory to generate Segments
 */
class SegmentFactory
{
	/**
	 * a Delimiter
	 * @var Delimiter
	 */
    protected $delimiter;
    
    /**
     * Constructor with an optional delimiter.
     * @param Delimiter[optional] $delimiter default is null
     */
    public function __construct(Delimiter $delimiter = null)
    {
        $this->delimiter = $delimiter ?: new Delimiter;
    }
    
    /**
     * A function that returns a segment from a given segment and a given segment linenumber.
     * @param SegInterface $segment
     * @param int $segline
     * @return SegInterface
     */
    public function fromSegline($segment, $segline)
    {
        call_user_func_array($segment . '::setBuildDelimiter', [$this->delimiter]);
        $segment = call_user_func_array($segment . '::fromSegLine', [$segline]);

        return $segment;
    }

    /**
     * A function that returns a Segment from a given segment with given attributes.
     * @param SegInterface $segment
     * @param array[optional] $attributes default is an empty array
     * @param string $method the method to use; default = 'fromAttributes'
     * @return SegInterface
     */
    public function fromAttributes($segment, $attributes = [], $method = 'fromAttributes')
    {
        call_user_func_array($segment . '::setBuildDelimiter', [$this->delimiter]);
        $segment = call_user_func_array([$segment, $method], $attributes);

        return $segment;
    }
}
