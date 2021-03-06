<?php
/**
 * Picon Framework
 * http://code.google.com/p/picon-framework/
 *
 * Copyright (C) 2011-2012 Martin Cassidy <martin.cassidy@webquub.com>

 * Picon Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * Picon Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  General Public License for more details.

 * You should have received a copy of the GNU General Public License
 * along with Picon Framework.  If not, see <http://www.gnu.org/licenses/>.
 * */

namespace picon;

/**
 * Handles all PHP errors and uncaught exceptions, registers handles
 * upon instantiation.
 * 
 * @author Martin Cassidy
 * @package core
 */
class ErrorHandler
{
    public function __construct()
    {
        set_error_handler(array($this, 'onError'));
        set_exception_handler(array($this, 'onException'));
    }
    
    /**
     * @todo the error level should be setable, warnings and notices are currently ignored
     * @param type $errno
     * @param type $errstr
     * @param type $errfile
     * @param type $errline 
     */
    public function onError($errno, $errstr, $errfile, $errline)
    {
        if($errno==E_USER_ERROR||$errno==E_ERROR)
        {
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        }
    }
    
    public function onException(\Exception $exception)
    {
        print('<h1>Unhandled Exception</h1>');
        print('<h3>'.$exception->getMessage().' in '.$exception->getFile().' on line '.$exception->getLine().'</h3>');
        print('<h2>Trace</h2><ul>');
        foreach($exception->getTrace() as $trace)
        {
            print('<li>'.$trace['class'].'::'.$trace['function'].'() in '.$trace['file'].' on line '.$trace['line'].'</li>');
        }
        print('</ul>');

        die();
    }
}

?>
