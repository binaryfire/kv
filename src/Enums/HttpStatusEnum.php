<?php

declare(strict_types=1);

namespace App\Enums;

enum HttpStatusEnum: int
{
    case ok = 200;
    case created = 201;
    case accepted = 202;
    case no_content = 204;
    
    case bad_request = 400;
    case unauthorized = 401;
    case forbidden = 403;
    case not_found = 404;
    case method_not_allowed = 405;
    case request_timeout = 408;
    case conflict = 409;
    case gone = 410;
    case payload_too_large = 413;
    case unsupported_media_type = 415;
    case too_many_requests = 429;
    
    case internal_server_error = 500;
    case not_implemented = 501;
    case bad_gateway = 502;
    case service_unavailable = 503;
    case gateway_timeout = 504;
    
    /**
     * Get a human-readable description of the status code.
     */
    public function getDescription(): string
    {
        return match($this) {
            self::ok => 'OK',
            self::created => 'Created',
            self::accepted => 'Accepted',
            self::no_content => 'No Content',
            
            self::bad_request => 'Bad Request',
            self::unauthorized => 'Unauthorized',
            self::forbidden => 'Forbidden',
            self::not_found => 'Not Found',
            self::method_not_allowed => 'Method Not Allowed',
            self::request_timeout => 'Request Timeout',
            self::conflict => 'Conflict',
            self::gone => 'Gone',
            self::payload_too_large => 'Payload Too Large',
            self::unsupported_media_type => 'Unsupported Media Type',
            self::too_many_requests => 'Too Many Requests',
            
            self::internal_server_error => 'Internal Server Error',
            self::not_implemented => 'Not Implemented',
            self::bad_gateway => 'Bad Gateway',
            self::service_unavailable => 'Service Unavailable',
            self::gateway_timeout => 'Gateway Timeout',
        };
    }
}
