<?PHP
// +-----------------------------------------------------------------------+
// | Copyright 2005 EVDB, Inc.                                             |
// | All rights reserved.                                                  |
// |                                                                       |
// | Redistribution and use in source and binary forms, with or without    |
// | modification, are permitted provided that the following conditions    |
// | are met:                                                              |
// |                                                                       |
// | o Redistributions of source code must retain the above copyright      |
// |   notice, this list of conditions and the following disclaimer.       |
// | o Redistributions in binary form must reproduce the above copyright   |
// |   notice, this list of conditions and the following disclaimer in the |
// |   documentation and/or other materials provided with the distribution.|
// | o The names of the authors may not be used to endorse or promote      |
// |   products derived from this software without specific prior written  |
// |   permission.                                                         |
// |                                                                       |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
// |                                                                       |
// +-----------------------------------------------------------------------+
// | Authors: Chris Radcliff <chris@evdb.com>                              |
// |          Chuck Norris   <chuck@evdb.com>                                |
// +-----------------------------------------------------------------------+
//

/**
 * uses PEAR error management
 */
require_once 'PEAR.php';

/**
 * uses XML_Serializer to read result
 */
require_once 'XML/Unserializer.php';

/**
 * uses HTTP to send the request
 */
require_once 'HTTP/Request.php';

/**
 * Services_EVDB
 *
 * Client for the REST-based webservice at http://api.evdb.com
 *
 * EVDB, the Events and Venues Database, helps people find relevant events 
 * and share their discoveries with others. We're building a worldwide 
 * repository of event and venue data that the whole world can use. Our  
 * goal is to help people discover all kinds of events they might have  
 * otherwise missed.
 *
 * Services_EVDB allows you to
 * - search for events or venues
 * - add events or venues
 * - get details of an event or venue
 * - update or withdraw events or venues
 * from PHP.
 * 
 * See http://api.evdb.com for a complete list of available methods.
 *
 * @author		Chris Radcliff <chris@evdb.com>
 * @package		Services_EVDB
 * @version		0.5.2
 */
class Services_EVDB
{
   /**
    * URI of the REST API
    *
    * @access  public
    * @var     string
    */
    var $api_root = 'http://data.pollstar.com';
        
   /**
    * Application key (as provided by http://api.evdb.com)
    *
    * @access  public
    * @var     string
    */
    var $app_key   = null;

   /**
    * Username
    *
    * @access  private
    * @var     string
    */
    var $user   = null;

   /**
    * Password
    *
    * @access  private
    * @var     string
    */
    var $_password = null;
    
   /**
    * User authentication key
    *
    * @access  private
    * @var     string
    */
    var $user_key = null;
    
   /**
    * Latest request URI
    *
    * @access  private
    * @var     string
    */
    var $_request_uri = null;
    
   /**
    * Latest XML response
    *
    * @access  private
    * @var     string
    */
    var $_xml_response = null;
    
   /**
    * Latest XML response as unserialized data
    *
    * @access  private
    * @var     array
    */
    var $_response_data = null;
    
   /**
    * Create a new client
    *
    * @access  public
    * @param   string      app_key
    */
    function Services_EVDB($app_key)
    {
        $this->app_key = $app_key;
    }
    
   /**
    * Call a method on the EVDB API.
    *
    * @access  public
    * @param   string      args
    * @param   array       forceEnum
    */
    function call($method, $args=array(), $forceEnum=array()) 
    {	
        /* Methods may or may not have a leading slash.
         */
        $method = trim($method,'/ ');

        /* Construct the URL that corresponds to the method.
         */
        $url = $this->api_root . '/' . $method;
		
		    $this->_request_uri = $url;
        $req = &new HTTP_Request($url);
        $req->setMethod(HTTP_REQUEST_METHOD_POST);
        
		
        foreach ($args as $key => $value) 
        {
            if ( preg_match('/_file$/', $key) )
            {
                // Treat file parameters differently.
                
                $req->addFile($key, $value);
            }
            elseif ( is_array($value) ) 
            {
                foreach ($value as $instance) 
                {
                    $req->addPostData($key, $instance);
                }
            } 
            else 
            {
                $req->addPostData($key, $value);
            }
        }
        
        /* Prepare XML_Unserializer.
         */
        $unserializer = &new XML_Unserializer();
        $unserializer->setOption('parseAttributes', true);
        $unserializer->setOption('forceEnum', $forceEnum);
        
        /* Send the request and handle basic HTTP errors.
         */
        $req->sendRequest();
        if ($req->getResponseCode() !== 200) 
        {
            return PEAR::raiseError('Invalid Response Code: ' . $req->getResponseCode(), $req->getResponseCode());
        }
        
        /* Process the response XML through XML_Unserializer
         */
        $response = $req->getResponseBody();
        $this->_xml_response = $response;
        $status = $unserializer->unserialize($response);
    
        /* Deal with serialization errors.
         */
        if(PEAR::isError($status)) 
        {
            return PEAR::raiseError('Invalid XML Response', $status->getMessage());
        }
    
        /* Check for EVDB-specific error messages
         */
        $data = $unserializer->getUnserializedData();
        $this->_response_data = $response;
        if ($unserializer->getRootName() === 'error') 
        {
            $error = $data['string'] . ": " . $data['description'];
            $code = $data['string'];
            return PEAR::raiseError($error, $code);
        }
    
        return($data);
    }
}
?>
