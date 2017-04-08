<?php

namespace bitsquare_api;

use Tester\Assert;

class api_testcase_base {
    
    function __construct() {
        \Tester\Environment::setup();        
    }
    
    // note: derived classes should create a method prefixed with "test" for
    // each test case.
    //
    // Note these are SimpleUnit test cases.
    // See: http://www.simpletest.org/
    
    protected function apicall( $uri, $json_request, $encode=true ) {
        $url = "http://localhost:8080" . $uri;
        $data = $encode && $json_request ? @\json_encode( $json_request ) : $json_request;
        return $this->do_get_request( $url, $data );
    }
    
    protected function apicall_validate_response( $uri, $json_request, $schemafile, $encode=true ) {
        $response = $this->apicall( $uri, $json_request, $encode );
        $data = \json_decode($response, false);
        if( $data === null ) {
            throw new \Exception("Invalid json response from API $uri");
        }
        return $this->validatejson($data, $schemafile);
    }
    
    protected function validatejson($data, $schemafile) {
        // Validate
        $validator = new \JsonSchema\Validator;        
        $validator->validate($data, (object)['$ref' => 'file://' . $schemafile]);
        
        $valid = $validator->isValid();

        $message = '';        
        if( !$valid ) {
            $message .= "server response failed schema validation. Details follow:\n";
            foreach ($validator->getErrors() as $error) {
                $message .= sprintf( "  --> %s: %s\n", $error['property'], $error['message'] );
            }
        }
        
        Assert::true($valid, $message);
    }
    
    /**
     * borrowed from http://wezfurlong.org/blog/2006/nov/http-post-from-php-without-curl/
     */
    function do_post_request($url, $data, $optional_headers = null)
    {
        $params = array('http' => array(
                    'method' => 'POST',
                    'content' => $data
                  ));
        if ($optional_headers !== null) {
            $params['http']['header'] = $optional_headers;
        }
        $ctx = stream_context_create($params);
        $fp = @fopen($url, 'rb', false, $ctx);
        if (!$fp) {
            throw new \Exception("Problem with $url, $php_errormsg");
        }
        $response = @stream_get_contents($fp);
        if ($response === false) {
            throw new \Exception("Problem reading data from $url, $php_errormsg");
        }
        return $response;
    }

    function do_get_request($url)
    {
        return file_get_contents($url);
    }
    
    
}
?>