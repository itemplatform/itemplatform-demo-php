<?php

/**
 * Class for demonstrating WebMini Itemplatform.
 * http://www.itemplatform.com/
 * @class
 */
class Itemplatform {
	
	const WEBMINI_API_SCHEMA = 'https://my.webmini.com/api/v1/';
	const WEBMINI_WEBHOOK_HASH_ALGORITHM = 'sha1';
	
	const API_ACCESS_METHOD__PERSONAL_TOKEN = 1;
	const API_ACCESS_METHOD__OAUTH = 2;
	
	const HTTP_METHOD__GET = 1;
	const HTTP_METHOD__POST = 2;
	const HTTP_METHOD__DELETE = 3;
	const HTTP_METHOD__PUT = 4;
	const HTTP_METHOD__PATCH = 5;
	
	/**
	 * Itemplatform class contructor.
	 * @method
	 */
	function __construct(
		$userAgent,
		$accountId = false, // some API calls do not need an account ID
		$accessMethod = self::API_ACCESS_METHOD__PERSONAL_TOKEN
	) {
		$this->userAgent = $userAgent;
		$this->accountId = (int) $accountId;
		$this->accessMethod = $accessMethod;
		$this->debug = false;
	}
	
	/**
	 * Set access method.
	 * @method
	 */
	public function setAccessMethod(
		$accessMethod = self::API_ACCESS_METHOD__PERSONAL_TOKEN
	) {
		$this->accessMethod = $accessMethod;
	}
	
	/**
	 * Turn debugging info on or off.
	 * If you want debugging data, set this to true and API calls will
	 * contain a debug value with complete HTTP call data.
	 * @method
	 */
	public function setDebug(
		$debug = true
	) {
		$this->debug = $debug;
	}
	
	/**
	 * Set authentication data for Personal API Token access method.
	 * @method
	 */
	public function setPersonalApiToken(
		$tokenUsername,
		$tokenSecret
	) {
		$this->personalApiTokenUsername = $tokenUsername;
		$this->personalApiTokenSecret = $tokenSecret;
	}
	
	/**
	 * Set authentication data for OAuth2 access method.
	 * @method
	 */
	public function setOAuth2AccessToken(
		$accessToken
	) {
		$this->oAuth2AccessToken = $accessToken;
	}
	
	/**
	 * Perform HTTP call.
	 * @method
	 */
	private function httpCall(
		$method,
		$url,
		$body = false,
		$headers = array(),
		$options = array()
	) {
		$curl = curl_init(
			$url . (($method === self::HTTP_METHOD__GET && is_array($body) && count($body) > 0) ? '?' . http_build_query($body, null, '&') : '')
		);
		
		$headersFinal = array();
		foreach ($headers as $headerName => $headerValue) {
				$headersFinal[] = $headerName . ': ' . $headerValue;
		}
		
		$curlOptions = array();
		
		switch ($method) {
			case self::HTTP_METHOD__GET:
				$curlOptions[CURLOPT_HTTPGET] = true;
				break;
			case self::HTTP_METHOD__POST:
				$curlOptions[CURLOPT_POST] = true;
				break;
			case self::HTTP_METHOD__DELETE:
				$curlOptions[CURLOPT_CUSTOMREQUEST] = 'DELETE';
				break;
			case self::HTTP_METHOD__PUT:
				$curlOptions[CURLOPT_CUSTOMREQUEST] = 'PUT';
				break;
			case self::HTTP_METHOD__PATCH:
				$curlOptions[CURLOPT_CUSTOMREQUEST] = 'PATCH';
				break;
		}
		
		$curlOptions[CURLOPT_USERAGENT] = $this->userAgent;
		
		if (
			isset($options['username']) &&
			isset($options['password'])
		) {
			$curlOptions[CURLOPT_USERPWD] = $options['username'] . ':' . $options['password'];
		}
		
		if (count($headersFinal) > 0) {
			$curlOptions[CURLOPT_HTTPHEADER] = $headersFinal;
		}
		
		$curlOptions[CURLOPT_RETURNTRANSFER] = true;
		
		if (
			$body &&
			$method !== self::HTTP_METHOD__GET
		) {
			//$curlOptions[CURLOPT_POSTFIELDS] = $body;
			$curlOptions[CURLOPT_POSTFIELDS] = (is_array($body)) ? http_build_query($body, null, '&') : $body;
		}
		
		$curlOptions[CURLOPT_CONNECTTIMEOUT] = 20;
		$curlOptions[CURLOPT_TIMEOUT] = 30;
		
		$curlOptions[CURLOPT_SSL_VERIFYHOST] = 2;
		$curlOptions[CURLOPT_SSL_VERIFYPEER] = true;
		
		if ($this->debug) {
			// Store debugging data
			$debugFilePointer = fopen('php://temp', 'r+');
			$curlOptions[CURLOPT_VERBOSE] = true;
			$curlOptions[CURLOPT_STDERR] = $debugFilePointer;
		}
		
		curl_setopt_array($curl, $curlOptions); 
		
		$curlResult = curl_exec($curl);
		
		$return = array(
			'curlerror' => curl_error($curl),
			'httpcode' => (int) curl_getinfo($curl, CURLINFO_HTTP_CODE),
			'contenttype' => curl_getinfo($curl, CURLINFO_CONTENT_TYPE),
			'result' => $curlResult
		);
		
		curl_close($curl);
		
		if ($this->debug) {
			rewind($debugFilePointer);
			$return['debug'] = stream_get_contents($debugFilePointer);
			fclose($debugFilePointer);
		}
		
		return $return;
	}
	
	/**
	 * HTML-encode string.
	 * @method
	 */
	public static function htmlEncode(
		$string
	) {
		return htmlspecialchars($string, ENT_QUOTES, 'utf-8');
	}
	
	/**
	 * Decode JSON.
	 * @method
	 */
	private static function jsonDecode(
		$jsonString
	) {
		$jsonData = json_decode($jsonString, true);
		return (json_last_error() === JSON_ERROR_NONE) ? $jsonData : null;
	}
	
	/**
	 * Call Itemplatform API either using a Personal API Token or OAuth2.
	 * @method
	 */
	private function apiCall($apiEndpoint, $httpMethod, $parameters = false) {
		$headers = array();
		$headers['Content-type'] = 'application/json';
		$options = array();
		switch ($this->accessMethod) {
			case self::API_ACCESS_METHOD__PERSONAL_TOKEN:
				$options['username'] = $this->personalApiTokenUsername;
				$options['password'] = $this->personalApiTokenSecret;
				break;
			case self::API_ACCESS_METHOD__OAUTH:
				$headers['Authorization'] = 'Bearer ' . $this->oAuth2AccessToken;
				break;
		}
		$httpCallResult = $this->httpCall(
			$httpMethod,
			self::WEBMINI_API_SCHEMA . $apiEndpoint,
			($parameters !== false) ? json_encode($parameters) : false,
			$headers,
			$options
		);
		return $httpCallResult;
	}
	
	/**
	 * Send items.
	 * @method
	 */
	public function apiSendItems($items) {
		return $this->apiCall(
			'itemplatform/' . $this->accountId . '/items/send',
			self::HTTP_METHOD__POST,
			$items
		);
	}
	
	/**
	 * Validate WebMini webhook call.
	 * @method
	 */
	public static function webhookValidate($webhookSecret) {
		// Set default values
		$webhookValidationResult = array();
		$webhookValidationResult['success'] = true;
		$webhookValidationResult['httpcode'] = 200;
		$webhookValidationResult['event'] = false;
		$webhookValidationResult['payload'] = null;
		
		// Parse request body
		$webhookBody = file_get_contents('php://input');
		
		// Check headers and validate signature
		if (
			!empty($_SERVER['HTTP_X_WEBMINI_EVENT']) &&
			!empty($_SERVER['HTTP_X_WEBMINI_SIGNATURE']) &&
			$_SERVER['HTTP_X_WEBMINI_SIGNATURE'] === self::WEBMINI_WEBHOOK_HASH_ALGORITHM . '=' . hash_hmac(
				self::WEBMINI_WEBHOOK_HASH_ALGORITHM,
				$webhookBody,
				$webhookSecret
			)
		) {
			$webhookValidationResult['event'] = $_SERVER['HTTP_X_WEBMINI_EVENT'];
		} else {
			// Webhook call has invalid headers / signature
			$webhookValidationResult['success'] = false;
			$webhookValidationResult['httpcode'] = 401; // Unauthorized
		}
		
		// Decode JSON
		$webhookPayload = null;
		if (mb_strlen($webhookBody) > 0) {
			$webhookPayload = self::jsonDecode($webhookBody);
			if (!is_null($webhookPayload)) {
				$webhookValidationResult['payload'] = $webhookPayload;
			} else {
				// Payload JSON is invalid
				$webhookValidationResult['success'] = false;
				$webhookValidationResult['httpcode'] = 400; // Bad Request
			}
		}
		
		// Return result
		return $webhookValidationResult;
	}
		
}
