<?php

namespace Proengeno\Edifact\Exceptions;

use Proengeno\Edifact\Test\Fixtures\Segment;

/**
 * An Exception that appears on validations
 */
class ValidationException extends EdifactException
{
	 /**
	  * @var int
	  */
    protected $lineCount;
    /**
     * 
     * @var Segment
     */
    protected $segment;
    
    /**
     * Constructor
     * 
     * @param string $postMessage A post message
     * @param int[optional] $lineCount the line count to use; default is null
     * @param Segment $segment a given Segment; defaul is null
     */
    public function __construct($postMessage, $lineCount = null, $segment = null)
    {
        $message = '';
        if ($lineCount) {
            $message = "Line $lineCount";
        }
        if ($lineCount && $segment) {
            $message .= ",";
        }
        if ($segment) {
            $message .= " Segment $segment";
        }
        $message .= ", " . $postMessage;
        $this->lineCount = $lineCount;
        $this->segment = $segment;

        parent::__construct($message);
    }
    
    /**
     * A static function to create an Exception for unexpected Segments.
     * @param int $lineCount the line count to use
     * @param Segment $segment the unexpected Segment
     * @param Segment[optional] $expectedSegment the expected Segment; default is null
     * @return \Proengeno\Edifact\Exceptions\ValidationException the new generated Exception
     */
    public static function unexpectedSegment($lineCount, $segment, $expectedSegment = null)
    {
        if ($expectedSegment) {
            $message = "Segment unexpected, $expectedSegment expected.";
        } else {
            $message = "Segment unexpected, End expected.";
        }

        return new static($message, $lineCount, $segment);
    }

    /**
     * A static function to create an Exception for illegal content.
     * @param int $lineCount the line count to use
     * @param Segment $segment the segment, that contains illegal content
     * @param String $illegalContent the illegal content
     * @param String $legalContent the contant, that would be legal
     * @return \Proengeno\Edifact\Exceptions\ValidationException the new generated Exception
     */
    public static function illegalContent($lineCount, $segment, $illegalContent, $legalContent)
    {
        $message = "Illegal Content '$illegalContent', '$legalContent' allowed.";
        return new static($message, $lineCount, $segment);
    }

    /**
     * A static function to create an Exception, if the maximum loop is exceeded
     * @param int $lineCount the line count to use
     * @param Segment $segment the segment, that exceeds the maximum loop
     * @return \Proengeno\Edifact\Exceptions\ValidationException the new generated Exception
     */
    public static function maxLoopsExceeded($lineCount, $segment)
    {
        return new static('Maximal Loops exceeded.', $lineCount, $segment);
    }

    /**
     * A static function to create an Exception, if an unexpected end appears.
     * @return \Proengeno\Edifact\Exceptions\ValidationException the new generated Exception
     */
    public static function unexpectedEnd()
    {
        return new static('Unexpected End.', null, null);
    }
}
