<?php

namespace Proengeno\Edifact\Exceptions;

use RuntimeException;

/**
 * Edifact base exception with some static functions.
 */
class EdifactException extends RuntimeException
{
	/**
	 * Static function for unknown segments.
	 *  
	 * @param string $segment an EDIFACT segment
	 * @return \Proengeno\Edifact\Exceptions\EdifactException 
	 */
    public static function segmentUnknown($segment)
    {
        return new static("Segment not registered: '$segment'");
    }

    /**
     * Static function for unknown messages.
     * 
     * @param string $message an EDIFACT message
     * @return \Proengeno\Edifact\Exceptions\EdifactException
     */
    public static function messageUnknown($message)
    {
        return new static("Message not registered: '$message'");
    }
}
