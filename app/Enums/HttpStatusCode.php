<?php

namespace App\Enums;

enum HttpStatusCode: int {
    case Ok = 200;
    // case Created = 201;
    // case Accepted = 202;
    // case NonAuthoritativeInformation = 203;
    // case NoContent = 204;
    // case MultipleChoices = 300;
    // case MovedPermanently = 301;
    // case Found = 302;
    // case SeeOther = 303;
    // case NotModified = 304;
    case BadRequest = 400;
    case Unauthorized = 401;
    // case PaymentRequired = 402;
    case Forbidden = 403;
    case NotFound = 404;
    // case MethodNotAllowed = 405;
    case UnprocessableEntity = 422;
    case InternalServerError = 500;
    // case NotImplemented = 501;
    // case BadGateway = 502;
    // case ServiceUnavailable = 503;
    // case GatewayTimeout = 504;
}