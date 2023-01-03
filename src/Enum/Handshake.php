<?php 
namespace Aasanakey\Smsonline\Enum;

class Handshake{
const HSHK_OK = 0;	//Request is validated and accepted for processing
const HSHK_ERR_RH_HTTP_ACCEPT =1101	;	//Missing Accept header in request
const HSHK_ERR_RH_CONTENT_TYPE = 1102; //Missing Content-Type in request header
const HSHK_ERR_UA_MODEL	= 1201; //Missing or invalid authentication model specifier
const HSHK_ERR_UA_AUTH = 1203;	//Authentication failed
const HSHK_ERR_UA_API_NO_ACCES = 1204;	//API access is not permitted
const HSHK_ERR_UA_API_NO_PPASS = 1205;	//Account username and password not permitted for API authentication
const HSHK_ERR_DATA	= 1401; //Missing or invalid request data
const HSHK_ERR_BAD_REQUEST = 1402;	//Invalid request. Usually when the request is not understood
const HSHK_ERR_INTERNAL = 1403; //Internal application error occured
const HSHK_ERR_UNKNOWN = 1404;	//Unknown application error occured
const HSHK_ERR_ACCESS_DENIED = 1405; //Access to requested resource is denied
const HSHK_ERR_API_RETIRED = 1406;	//API version being accessed has been retired and therefore cannot be used to make the request
const HSHK_ERR_SERVICE = 1407;	//Service for which request is made is not permitted, eg. Voice
const HSHK_ERR_ACCT_INACTIVE = 1408; //Account used in making the request is not active
const HSHK_ERR_ACCT_SUSPENDED = 1409; // Account used in making the request has been suspended

}