<?php

namespace Proengeno\Edifact\Message;

<<<<<<< HEAD
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
=======
use Proengeno\Edifact\Exceptions\ValidationException;

class SegmentFactory
{
    protected $segmentNamespace;
    protected $delimiter;

    public function __construct($segmentNamespace, Delimiter $delimiter = null)
>>>>>>> Apfelfrisch/master
    {
        $this->segmentNamespace = $segmentNamespace;
        $this->delimiter = $delimiter ?: new Delimiter;
    }
<<<<<<< HEAD
    
    /**
     * A function that returns a segment from a given segment and a given segment linenumber.
     * @param SegInterface $segment
     * @param int $segline
     * @return SegInterface
     */
    public function fromSegline($segment, $segline)
=======

    public function fromSegline($segline)
    {
        $segment = $this->getSegmentClass($this->getSegname($segline));

        if (is_callable([$segment, 'setBuildDelimiter'])) {
            $segment::setBuildDelimiter($this->delimiter);

            return $segment::fromSegLine($segline);
        }

        throw new ValidationException("Unknown Segment '" . $this->getSegname($segline) . "'");
    }

    public function fromAttributes($segmentName, $attributes = [], $method = 'fromAttributes')
>>>>>>> Apfelfrisch/master
    {
        $segment = $this->getSegmentClass($segmentName);

        $segment::setBuildDelimiter($this->delimiter);

        return call_user_func_array([$segment, $method], $attributes);
    }

<<<<<<< HEAD
    /**
     * A function that returns a Segment from a given segment with given attributes.
     * @param SegInterface $segment
     * @param array[optional] $attributes default is an empty array
     * @param string $method the method to use; default = 'fromAttributes'
     * @return SegInterface
     */
    public function fromAttributes($segment, $attributes = [], $method = 'fromAttributes')
=======
    private function getSegmentClass($segmentName)
>>>>>>> Apfelfrisch/master
    {
        return $this->segmentNamespace . '\\' . ucfirst(strtolower($segmentName));
    }

    private function getSegname($segLine)
    {
        return substr($segLine, 0, 3);
    }
}
