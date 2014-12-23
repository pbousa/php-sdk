<?php

/**
 * Copyright 2014 Photo Booth Options. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 *
 *
 * @author Bret Mette <bret.mette@rowdydesign.com>
 */


namespace PboApi\Services;


class ClientService {


    /**
     * @var string
     */
    protected $apiToken;


    /**
     * @var string
     */
    protected $apiUrl;


    /**
     * @var resource
     */
    protected $curl;


    /**
     * Initialize the class
     */
    public function __construct()
    {
        $this->curl = curl_init();

		curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        /**
         * TODO : Find a better way to handle token and url
         */
        $this->apiToken = PBOAPI_COMMON_TOKEN;
        $this->apiUrl = PBOAPI_COMMON_URL;
    }


    /**
     * @return string
     */
    protected function getApiToken()
    {
        return $this->apiToken;
    }


    /**
     * @return string
     */
    protected function getApiUrl()
    {
        return $this->apiUrl;
    }


    /**
     * @param string $resource
     *
     * @return string
     */
    protected function getApiUrlForResource($resource)
    {
        return $this->getApiUrl() . $resource . '?token=' . $this->getApiToken() . '&';
    }


    /**
     * @param string $type
     * @param string $resource
     * @param array $payload
     *
     * @return stdClass
     */
	public function sendRequest($type = 'GET', $resource = '', $payload = array())
	{
        $response = null;

        curl_setopt($this->curl, CURLOPT_URL, $this->getApiUrlForResource($resource));
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $type);

		switch (strtolower($type)) {

			case 'get':
                curl_setopt($this->curl, CURLOPT_URL, $this->getApiUrlForResource($resource) . http_build_query($payload));
				break;

			case 'delete':
			case 'put':
			case 'post':
				$dataString = json_encode($payload);

				curl_setopt($this->curl, CURLOPT_POSTFIELDS, $dataString);

				curl_setopt($this->curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($dataString),
                ));
				break;
		}


		/**
		 * Send the request
		 *
		 * We do not care what the result is or if an error occurs.
		 * this is a one time attempt.
		 */
		@$result = curl_exec($this->curl);


		if (isset($result) && strlen($result)) {

			@$response = json_decode($result);
		}


		return $response;
    }


    /**
     * Destroy the object
     */
    public function __destruct()
    {
        curl_close($this->curl);
    }

}
