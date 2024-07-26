<?php


namespace App\Responses;


class Errors
{
    protected static array $_MESSAGES = [
        'INVALID_META_ID' => 'Your selected meta id is invalid.',
        'INVALID_SECTION_ID' => 'Your selected section_id is invalid.',
        'INVALID_APPLICATION_ID' => 'Your selected application id is invalid.',
        'INVALID_ROLE_ID' => 'Your selected role id is invalid.',
        'INVALID_REQUEST' => "Your input values has some errors.",
        'INVALID_ROLE' => 'User does not have the right roles.',
        'INVALID_PERMISSION' => 'User does not have the right permissions.',
        'INVALID_TOKEN' => 'Authentication token is invalid.',
        'INVALID_CLIENT' => 'Client authentication failed.',
        'INVALID_GRANT' => 'The user credentials were incorrect.',
        'INVALID_GRANT_TYPE' => 'The authorization grant type is not supported by the authorization server.',
        'INVALID_SCOPE' => 'The requested scope is invalid, unknown, or malformed.',
        'INVALID_REFRESH_TOKEN' => 'The refresh token is invalid.',
        'INVALID_ID' => 'Your selected id is invalid.',
        'INVALID_PERMISSION_NAME' => 'Your selected name is invalid.',
        'EMAIL_IS_NOT_VERIFIED' => 'Your email address is not verified.',
        'PAGE_SLUG_DUPLICATE' => 'Your slug already exists in this template.',
        'INVALID_PARAMETER' => 'Your selected parameters is invalid.',
        'UNKNOWN_ERROR' => ''
    ];
    public static string $_INVALID_ID = 'INVALID_ID';
    public static string $_INVALID_PARAMETER = 'INVALID_PARAMETER';
    public static string $_INVALID_META_ID = 'INVALID_META_ID';
    public static string $_INVALID_SECTION_ID = 'INVALID_SECTION_ID';
    public static string $_INVALID_APPLICATION_ID = 'INVALID_APPLICATION_ID';
    public static string $_INVALID_ROLE = 'INVALID_ROLE';
    public static string $_INVALID_PERMISSION = 'INVALID_PERMISSION';
    public static string $_INVALID_ROLE_ID = 'INVALID_ROLE_ID';
    public static string $_UNKNOWN_ERROR = 'UNKNOWN_ERROR';
    public static string $_INVALID_REQUEST = 'INVALID_REQUEST';
    public static string $_INVALID_TOKEN = 'INVALID_TOKEN';
    public static string $_INVALID_CLIENT = 'INVALID_CLIENT';
    public static string $_INVALID_GRANT = 'INVALID_GRANT';
    public static string $_INVALID_GRANT_TYPE = 'INVALID_GRANT_TYPE';
    public static string $_INVALID_SCOPE = 'INVALID_SCOPE';
    public static string $_INVALID_REFRESH_TOKEN = 'INVALID_REFRESH_TOKEN';
    public static string $_INVALID_PERMISSION_NAME = 'INVALID_PERMISSION_NAME';
    public static string $_EMAIL_IS_NOT_VERIFIED = 'EMAIL_IS_NOT_VERIFIED';
    public static string $_PAGE_SLUG_DUPLICATE = 'PAGE_SLUG_DUPLICATE';
    public static string $_PALETTE_ID = 'INVALID_PALETTE_ID';
    public static string $_DOMAIN_AVAILABLE = 'DOMAIN_AVAILABLE';
    public static string $_DOMAIN_NOT_AVAILABLE = 'DOMAIN_NOT_AVAILABLE';

    public static function message($code){
        if(key_exists($code, self::$_MESSAGES)){
            return self::$_MESSAGES[$code];
        }
        return null;
    }
    public static function error($code, $fields = null, $message = null){
        $error = ['error' => $code, 'message' =>  ($message)?$message:Errors::message($code)];
        if($fields)
            $error['fields'] = $fields;
        return $error;
    }
    public static function exception($code, $message = null){
        return ['error' => $code, 'message' =>  ($message)?$message:Errors::message($code)];
    }
}
