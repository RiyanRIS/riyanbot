<?php

namespace PHPFireStore;

class FireStoreDocument {

	private $fields = [];
	private $name = null;
	private $createTime = null;
	private $updateTime = null;

	/*
	Example:
	{
		"name": "projects/{project_id}/databases/(default)/documents/{collectionName}/{documentId}",
		"fields": {
		"hello": {
			"doubleValue": 3
		}
		},
		"createTime": "2017-10-18T21:27:33.186235Z",
		"updateTime": "2017-10-18T21:27:33.186235Z"
	}
	*/
	public function __construct($json=null) {
		if ($json !== null) {
			$data = json_decode($json, true, 16);
			// Meta properties
			$this->name = $data['name'];
			$this->createTime = $data['createTime'];
			$this->updateTime = $data['updateTime'];
			// Fields
			foreach ($data['fields'] as $fieldName => $value) {
				$this->fields[$fieldName] = $value;
			}
		}
	}

	public function getName() {
		return $this->name;
	}

	public function setString($fieldName, $value) {
		$this->fields[$fieldName] = [
			'stringValue' => $value
		];
	}

	public function setDouble($fieldName, $value) {
		$this->fields[$fieldName] = [
			'doubleValue' => floatval($value)
		];
	}

	public function setArray($fieldName, $value) {
		$this->fields[$fieldName] = [
			'arrayValue' => $value
		];
	}

	public function setBoolean($fieldName, $value) {
		$this->fields[$fieldName] = [
			'booleanValue' => !!$value
		];
	}

	public function setInteger($fieldName, $value) {
		$this->fields[$fieldName] = [
			'integerValue' => intval($value)
		];
	}

	public function get($fieldName) {
		if (array_key_exists($fieldName, $this->fields)) {
			return reset($this->fields);
		}
		throw new \Exception('No such field');
	}

	public function toJson() {
		return json_encode([
			'fields' => $this->fields
		]);
	}

}

class FireStoreApiClient {

	private $apiRoot = 'https://firestore.googleapis.com/v1/';
	private $project;
	private $apiKey;

	function __construct($project, $apiKey) {
		$this->project = $project;
		$this->apiKey = $apiKey;
	}

	private function constructUrl($method, $params=null) {
		$params = is_array($params) ? $params : [];
		return (
			$this->apiRoot . 'projects/' . $this->project . '/' .
			'databases/(default)/' . $method . '?key=' . $this->apiKey . '&' . http_build_query($params)
		);
	}

	private function get($method, $params=null) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_URL => $this->constructUrl($method, $params),
				CURLOPT_USERAGENT => 'cURL'
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	private function post($method, $params, $postBody) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_URL => $this->constructUrl($method, $params),
				CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($postBody)),
				CURLOPT_USERAGENT => 'cURL',
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $postBody
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	private function put($method, $params, $postBody) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => 'PUT',
				CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($postBody)),
				CURLOPT_URL => $this->constructUrl($method, $params),
				CURLOPT_USERAGENT => 'cURL',
				CURLOPT_POSTFIELDS => $postBody
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	private function patch($method, $params, $postBody) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_CUSTOMREQUEST => 'PATCH',
				CURLOPT_HTTPHEADER => array('Content-Type: application/json','Content-Length: ' . strlen($postBody)),
				CURLOPT_URL => $this->constructUrl($method, $params),
				CURLOPT_USERAGENT => 'cURL',
				CURLOPT_POSTFIELDS => $postBody
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	private function delete($method, $params) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_CUSTOMREQUEST => 'DELETE',
				CURLOPT_URL => $this->constructUrl($method, $params),
				CURLOPT_USERAGENT => 'cURL'
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	public function getDocument($collectionName, $documentId) {
		if ($response = $this->get("documents/$collectionName/$documentId")) {
			// return new FireStoreDocument($response);
			return json_decode($response);
		}
	}

	public function getCollection($collectionName) {
		if ($response = $this->get("documents/$collectionName")) {
			return json_decode($response);
		}
	}

	/*
		This does not work
	*/
	public function setDocument($collectionName, $documentId, $document) {
		return $this->put(
			"documents/$collectionName/$documentId", 
			[ ],
			$document->toJson()
		);
	}

	public function updateDocument($collectionName, $documentId, $document, $documentExists=null) {
		$params = [];
		if ($documentExists !== null) {
			$params['currentDocument.exists'] = !!$documentExists;
		}
		return $this->patch(
			"documents/$collectionName/$documentId", 
			$params,
			$document->toJson()
		);
	}

	public function deleteDocument($collectionName, $documentId) {
		return $this->delete(
			"documents/$collectionName/$documentId", []
		);
	}

	public function addDocument($collectionName, $document) {
		return $this->post(
			"documents/$collectionName", 
			[],
			$document->toJson()
		);
	}

}