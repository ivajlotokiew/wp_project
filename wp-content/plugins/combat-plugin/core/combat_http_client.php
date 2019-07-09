<?php

class HttpClient {

    private $api_url;

    private $headers = array("Accept: application/json");

    public function __construct($action="") {
        $this->api_url = $this->setAction($action);
    }

    public function setAction($action) {
        $this->api_url = "http://localhost:8000/" . $action;
    }

    public function setHeaders($headers)
    {
        //merge passed headers with object headers
        if (!empty($headers)) {
            if (is_array($headers)) {
                $this->headers = array_merge($headers, $this->headers);
            }
        }
    }

    public function get($headers = array(), $content_type = "application/json")
    {
        b_log($this->api_url);
        array_push($headers, "Content-Type: " . $content_type);
        $this->setHeaders($headers);

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data, HTTP headers, return HTTP headers
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $response = curl_exec($ch);

        //get error
        $err = curl_error($ch);
        if ($response !== FALSE) {
            $datary = explode("\r\n\r\n", "$response", 2);
            $headers_out = $datary[0];
            $body = $datary[1];
            if (!isset($datary[1])) {
                b_log("the datary explode is broken fix it....!\n");
            }
        }

        if (!isset($headers_out))
        {
            $headers_out = "";
            $body = "";
        }
        //testing
        b_log(serialize($response));
        b_log(serialize($err));


        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //close connection
        curl_close($ch);


        return array("body" => $body, "headers" => $headers_out, "code" => $code);
    }


    public function post($postfields = "", $headers = array(), $content_type = "application/json")
    {
        //append Content-type to headers
        array_push($headers, "Content-Type: " . $content_type);
        $this->setHeaders($headers);
        $postfieldsQuery = http_build_query($postfields);

        //open connection
        $ch = curl_init();
        //set the url, number of POST vars, POST data, HTTP headers, return HTTP headers
        curl_setopt($ch,CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        //curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfieldsQuery);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //execute post
        $response = curl_exec($ch);
        //get error
        $err = curl_error($ch);
        if ($response !== FALSE) {
            $datary = explode("\r\n\r\n", "$response", 3);
            $headers_out = $datary[0];
            if (isset($datary[2]))
            {
                $body = $datary[2];
            }
            else
            {
                $body = $datary[1];
            }

            if (!isset($datary[1])) {
                //b_log("the datary explode is broken fix it....!\n");
            }
        }
        else
        {
            $headers_out = "";
            $body = "";
        }

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //close connection
        curl_close($ch);
        //return headers and body
        return array("body" => $body, "headers" => $headers_out, "code" => $code);
    }

    public function put($somebody = "", $headers = array(), $content_type = "application/json") {
        $this->setHeaders($headers);
        //append Content-type to headers
        array_push($this->headers, "Content-Type: " . $content_type);

        b_log($this->api_url);
        //b_log(serialize($this->headers));
        b_log(serialize($somebody));

        //open connection
        $ch = curl_init();
        //set the url, number of POST vars, POST data, HTTP headers, return HTTP headers
        curl_setopt($ch,CURLOPT_URL, $this->api_url);
        //curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $somebody);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $response = curl_exec($ch);

        //get error
        $err = curl_error($ch);
        if ($response !== FALSE) {
            $datary = explode("\r\n\r\n", "$response", 3);
            $headers_out = $datary[0];
            if (isset($datary[2]))
            {
                $body = $datary[2];
            }
            else
            {
                $body = $datary[1];
            }
            if (!isset($datary[1])) {
                b_log("the datary explode is broken fix it....!\n");
            }
        }
        else
        {
            $headers_out = "";
            $body = "";
        }
        b_log("ERROR");
        b_log(serialize($err));
        b_log("RESPONSE");
        b_log(serialize($response));

        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //close connection
        curl_close($ch);

        //return headers and body
        return array("body" => $body, "headers" => $headers_out, "code" => $code);
    }

    private function delete() {

    }

    public function custom($headers = array(), $content_type = "application/json", $method)
    {
        array_push($headers, "Content-Type: " . $content_type);
        $this->setHeaders($headers);

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data, HTTP headers, return HTTP headers
        curl_setopt($ch, CURLOPT_URL, $this->api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $response = curl_exec($ch);

        //get error
        $err = curl_error($ch);
        if ($response !== FALSE) {
            $datary = explode("\r\n\r\n", "$response", 2);
            $headers_out = $datary[0];
            $body = $datary[1];
            if (!isset($datary[1])) {
                b_log("the datary explode is broken fix it....!\n");
            }
        }

        if (!isset($headers_out))
        {
            $headers_out = "";
            $body = "";
        }
        //testing
        b_log(serialize($response));
        b_log(serialize($err));


        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        //close connection
        curl_close($ch);


        return array("body" => $body, "headers" => $headers_out, "code" => $code);
    }

}

?>