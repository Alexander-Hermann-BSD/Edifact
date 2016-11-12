<?php

namespace Proengeno\Edifact\Message;

use Iterator;
use Exception;
use SplFileInfo;
use LogicException;
use DomainException;
use RuntimeException;
use Proengeno\Edifact\Message\Delimiter;
use phpDocumentor\Reflection\DocBlock\Tags\Factory\StaticMethod;

/**
 * A given EDIFACT-File
 */
class EdifactFile extends SplFileInfo
{
	/**
	 * A file pointer recource to the given filename
	 * @var resource
	 */
    private $rsrc;
    /**
     * The filename path
     * @var string
     */
    private $filename;
    /**
     * The delimiter for the given file.
     * @var Delimiter
     */
    private $delimiter;
<<<<<<< HEAD
    
    /**
     * Constructor.
     * 
     * @param string $filename Path to the file. 
     * @param string[optional] $open_mode The open_mode parameter specifies the type of access you require to the stream. 
     * It may be any of the following:
     * <table title="A list of possible modes for the constructor using open_mode">
     * <th>
     * <tr><td colspan="2">A list of possible modes for the constructor using open_mode</td></tr>
     * <tr><td><b>mode</b></td><td><b>Description</b></td></tr>
     * </th>
     * <tb>
     * <tr><td>'r'</td><td>Open for reading only; place the file pointer at the beginning of the file.</td></tr>
     * <tr><td>'r+'</td><td>Open for reading and writing; place the file pointer at the beginning of the file.</td></tr>
     * <tr><td>'w'</td><td>Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.</td></tr>
     * <tr><td>'w+'</td><td>Open for reading and writing; place the file pointer at the beginning of the file and truncate the file to zero length. If the file does not exist, attempt to create it.</td></tr>
     * <tr><td>'a'</td><td>Open for writing only; place the file pointer at the end of the file. If the file does not exist, attempt to create it. In this mode, fseek() has no effect, writes are always appended.</td></tr>
     * <tr><td>'a+'</td><td>Open for reading and writing; place the file pointer at the end of the file. If the file does not exist, attempt to create it. In this mode, fseek() only affects the reading position, writes are always appended.</td></tr>
     * <tr><td>'x'</td><td>Create and open for writing only; place the file pointer at the beginning of the file. If the file already exists, the fopen() call will fail by returning FALSE and generating an error of level E_WARNING. If the file does not exist, attempt to create it. This is equivalent to specifying O_EXCL|O_CREAT flags for the underlying open(2) system call.</td></tr>
     * <tr><td>'x+'</td><td>Create and open for reading and writing; otherwise it has the same behavior as 'x'.</td></tr>
     * <tr><td>'c'</td><td>Open the file for writing only. If the file does not exist, it is created. If it exists, it is neither truncated (as opposed to 'w'), nor the call to this function fails (as is the case with 'x'). The file pointer is positioned on the beginning of the file. This may be useful if it's desired to get an advisory lock (see flock()) before attempting to modify the file, as using 'w' could truncate the file before the lock was obtained (if truncation is desired, ftruncate() can be used after the lock is requested).</td></tr>
     * <tr><td>'c+'</td><td>Open the file for reading and writing; otherwise it has the same behavior as 'c'.</td></tr>
	  * </tb></table>
	  * Default is 'r'.
     * @param boolean[optional] $use_include_path The optional third use_include_path parameter can be set to '1' or <b>TRUE</b> if you want to search for the file in the include_path, too. </br>
     * by default: <b>FALSE</b>
     * @throws RuntimeException if <b>$filename</b> is an empty string or not a file or directory; see the message.
     * @throws Exception if <b>$open_mode</b> is not a string
     */
    public function __construct($filename, $open_mode = 'r', $use_include_path = false) 
=======

    public function __construct($filename, $open_mode = 'r', $use_include_path = false)
>>>>>>> Apfelfrisch/master
    {
        if (is_string($filename) && empty($filename)) {
            throw new RuntimeException(__METHOD__ . "({$filename}): Filename cannot be empty");
        }
        if (!is_string($open_mode)) {
            throw new Exception('EdifactFile::__construct() expects parameter 2 to be string, ' . gettype($open_mode) . ' given');
        }

        parent::__construct($filename);
        $this->filename = $filename;
        $this->rsrc = @fopen($filename, $open_mode, $use_include_path);
        if (false === $this->rsrc) {
            throw new RuntimeException(__METHOD__ . "({$filename}): failed to open stream: No such file or directory");
        }
    }

<<<<<<< HEAD
    /**
     * 
     * {@inheritDoc}
     * @see SplFileInfo::__toString()
     */
=======
    public function fromString($string)
    {
        $instance = new self('php://temp', 'w+');
        $instance->writeAndRewind($string);

        return $instance;
    }

>>>>>>> Apfelfrisch/master
    public function __toString()
    {
        try {
            $this->rewind();
            return $this->getContents();
        } catch (RuntimeException $e) {
            return '';
        }
    }

    /**
     * Gets the contents
     * @return string
     */
    public function getContents()
    {
        return trim(stream_get_contents($this->rsrc));
    }

<<<<<<< HEAD
    /**
     * Gets information if end of file is reached or not.
     * @return boolean Returns <b>TRUE</b> if the file pointer is at EOF or an error occurs (including socket timeout); otherwise returns <b>FALSE</b>.
     */
    public function eof() 
    {
        return feof($this->rsrc);
    }
    
    /**
     * Trys to flush the output data to the file.
     * @return boolean true if everything worked without a problem.
     */
    public function flush() 
    {
        return fflush($this->rsrc);
    }
    
    /**
     * Gets character from file pointer.
     * 
     * @return string|bool Returns a string containing a single character read from the current file pointer. </br>Returns <b>FALSE</b> on EOF.
     */
    public function getChar() 
    {
        return fgetc($this->rsrc);
    }
    
    /**
     * Gets the next sequence.
     * 
     * @return string|mixed
     */
    public function getSegment() 
=======
    public function eof()
    {
        return feof($this->rsrc);
    }

    public function flush()
    {
        return fflush($this->rsrc);
    }

    public function getChar()
    {
        return fgetc($this->rsrc);
    }

    public function getSegment()
>>>>>>> Apfelfrisch/master
    {
        return $this->fetchSegment();
    }

    public function lock($operation, &$wouldblock = false)
    {
        return flock($this->rsrc, $operation, $wouldblock);
    }

    public function passthru()
    {
        return fpassthru($this->rsrc);
    }

    public function read($length)
    {
        return fread($this->rsrc, $length);
    }
<<<<<<< HEAD
    
    /**
     * Seeks
     * <p>Sets the file position indicator for the current file. The new position, measured in bytes from the beginning of the file, is obtained by adding offset to the position specified by whence.</p>
	  * <p>In general, it is allowed to seek past the end-of-file; if data is then written, reads in any unwritten region between the end-of-file and the sought position will yield bytes with value 0. </br>However, certain streams may not support this behavior, especially when they have an underlying fixed size storage.</p
     * @param int $offset The offset.
	  * <p>To move to a position before the end-of-file, you need to pass a negative value in offset and set whence to <i>SEEK_END</i>.</p>
     * @param int[optional] $whence</br>
     *  whence values are:</br>
	  * <ul>
	  * <li><i>SEEK_SET</i> - Set position equal to offset bytes.</li>
	  * <li><i>SEEK_CUR</i> - Set position to current location plus offset.</li>
     * <li><i>SEEK_END</i> - Set position to end-of-file plus offset.</li>
     * </ul>
     * by default: <i>SEEK_SET</i>
     * @return boolean Upon success, returns <b>TRUE</b>; otherwise, returns <b>FALSE</b>.
     * @link http://www.php.net/manual/en/function.fseek.php  
     */
    public function seek($offset, $whence = SEEK_SET) 
=======

    public function seek($offset, $whence = SEEK_SET)
>>>>>>> Apfelfrisch/master
    {
    	  $result = fseek($this->rsrc, $offset, $whence);
        if (0 == $result) {
            return true;
        }
        return false;
    }
<<<<<<< HEAD
    
    /**
     * Gets information about the file.
     * <p>Returns an array with the statistics of the file; the format of the array is described in detail on the stat() manual page.</p>
     * @see System::stat()
     * @return array an array with the statistics of the file
     */
    public function stat() 
    {
        return fstat($this->rsrc);
    }
    
    /**
     * Returns the current position of the file pointer
     * @return int the current position of the file pointer
     */
    public function tell() 
    {
        return ftell($this->rsrc);
    }
    
    /**
     * 
     * @param string $str
     */
    public function write($str) 
=======

    public function stat()
    {
        return fstat($this->rsrc);
    }

    public function tell()
    {
        return ftell($this->rsrc);
    }

    public function write($str)
>>>>>>> Apfelfrisch/master
    {
        fwrite($this->rsrc, $str);
    }

    /**
     * 
     * @param string $str
     */
    public function writeAndRewind($str)
    {
        $this->write($str);
        $this->rewind();
    }

    /**
     * Gets the current Delimiter
     * @return \Proengeno\Edifact\Message\Delimiter
     */
    public function getDelimiter()
    {
        if ($this->delimiter === null) {
            $this->delimiter = Delimiter::setFromFile($this);
        }
        return $this->delimiter;
    }
<<<<<<< HEAD
    
	 /**
	  * rewind to start point
	  */
    public function rewind() 
    {
        rewind($this->rsrc);
    }
    
    /**
     * Fetches the next segment.
     * 
     * @return string|mixed|string the next segment or FALSE
     */
=======

    public function rewind()
    {
        rewind($this->rsrc);
    }

>>>>>>> Apfelfrisch/master
    private function fetchSegment()
    {
        $mergedLines = '';
        $line = $this->streamGetLine();
        
        while ($line != false) {
            // Skip empty Segments
            if (ctype_cntrl($line) || empty($line)) {
            	$line = $this->streamGetLine();
                continue;
            }
            if ($this->delimiterWasTerminated($line)) {
                $line[(strlen($line) - 1)] = $this->getDelimiter()->getSegment();
                $mergedLines .= $line;
                $line = $this->streamGetLine();
                continue;
            }

            return $mergedLines . $line;
        }

        return $mergedLines;
    }

    /**
     * Gets line from this->rsrc or FALSE, if there are no more lines.
     * @return mixed string or FALSE
     */
    private function streamGetLine()
    {
        return stream_get_line($this->rsrc, 0, $this->getDelimiter()->getSegment());
    }
<<<<<<< HEAD
    
    /**
     * Gives information, if the given line was terminated or not. 
     * @param string $line given line
     * @return boolean true, if the given line was terminated; else false
     */
=======

>>>>>>> Apfelfrisch/master
    private function delimiterWasTerminated($line)
    {
        return $line[(strlen($line) - 1)] == $this->getDelimiter()->getTerminator();
    }
}

