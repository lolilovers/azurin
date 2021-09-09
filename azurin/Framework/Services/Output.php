<?php

namespace Azurin\Framework\Services;

class Output
{
    // REST API response
    public function api($code, $data = null, $msg = null)
    {
        // Link
        $scheme = isset($_SERVER['REQUEST_SCHEME']) ?: 'http';
        $url = $scheme . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        // REST specific status codes
        if ($code == 200) {
            $status = 'OK';
        } elseif ($code == 201) {
            $status = 'Created';
        } elseif ($code == 202) {
            $status = 'Accepted';
        } elseif ($code == 203) {
            $status = 'Non-Authoritative Information';
        } elseif ($code == 204) {
            $status = 'No Content';
        } elseif ($code == 300) {
            $status = 'Multiple Choices';
        } elseif ($code == 301) {
            $status = 'Moved Permanently';
        } elseif ($code == 302) {
            $status = 'Found';
        } elseif ($code == 303) {
            $status = 'See Other';
        } elseif ($code == 304) {
            $status = 'Not Modified';
        } elseif ($code == 307) {
            $status = 'Temporary Redirect';
        } elseif ($code == 400) {
            $status = 'Bad Request';
        } elseif ($code == 401) {
            $status = 'Unauthorized';
        } elseif ($code == 403) {
            $status = 'Forbidden';
        } elseif ($code == 404) {
            $status = 'Not Found';
        } elseif ($code == 405) {
            $status = 'Method Not Allowed';
        } elseif ($code == 406) {
            $status = 'Not Acceptable';
        } elseif ($code == 412) {
            $status = 'Precondition Failed';
        } elseif ($code == 415) {
            $status = 'Unsupported Media Type';
        } elseif ($code == 500) {
            $status = 'Internal Server Error';
        } else {
            $status = 'Not Implemented';
        }

        // Parse data to JSend format
        $response   = [
            'status'    => $status,
            'data'      => isset($data) ? $data : '',
            'message'   => isset($msg) ? $msg : '',
            'links'     => ['self'  => $url]
        ];

        // Set header and compile data to JSON
        http_response_code($code);
        header('Content-Type: application/json');
        $response = str_replace('\/', '/', json_encode($response));

        return $response;
    }

    // HTTP cache
    public function cache($checksum, $timestamp)
    {
        $tsstring = gmdate('D, d M Y H:i:s ', $timestamp) . 'GMT';
        $etag = $checksum . $timestamp;

        $if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false;
        $if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : false;
        if ((($if_none_match && $if_none_match == $etag) || (!$if_none_match))
            && ($if_modified_since && $if_modified_since == $tsstring)) {
            $this->api(304);
            
            exit();
        } else {
            header("Last-Modified: $tsstring");
            header("ETag: \"{$etag}\"");
        }
    }
}