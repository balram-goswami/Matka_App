<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
	protected $apiEndPoint;
	protected $apiUsername;
	protected $apiPassword;
	public function __construct() {
		$this->apiEndPoint = 'https://cmstvision.tenagents.com/';
		$this->apiUsername = 'punitkumarchawla@gmail.com';
		$this->apiPassword = '0025TE@mp';
	}
    public function fetchDataFromVisionAPI($dataEndpoint)
    {
        try {
            $accessToken = $this->getAccessToken();
            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($dataEndpoint);

            if ($apiResponse->successful()) {
                return $apiResponse->json();
            } else {
                return ['error' => 'Failed to fetch data from the API.'];
            }
        } catch (\Exception $e) {
            return ['error' => 'An error occurred: ' . $e->getMessage()];
        }
    }

    public function searchOption()
    {
        $dataEndpoint = $this->apiEndPoint.'getCourses?results=8&count=100&page=1';
        try {
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($dataEndpoint);

            if ($apiResponse->successful()) {
                return $apiResponse->json();
            } else {
                return ['error' => 'Failed to fetch data from the API.'];
            }
        } catch (\Exception $e) {
            return ['error' => 'An error occurred: ' . $e->getMessage()];
        }
    }

    public function getCountry()
    {
        $dataEndpoint = $this->apiEndPoint.'country?results=40&count=50';
        try {
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($dataEndpoint);

            if ($apiResponse->successful()) {
                return $apiResponse->json();
            } else {
                return ['error' => 'Failed to fetch data from the API.'];
            }
        } catch (\Exception $e) {
            return ['error' => 'An error occurred: ' . $e->getMessage()];
        }
    }

    public function getLevels()
    {
        $dataEndpoint = $this->apiEndPoint.'levels';
        try {
            $accessToken = $this->getAccessToken();

            $apiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($dataEndpoint);

            if ($apiResponse->successful()) {
                return $apiResponse->json();
            } else {
                return ['error' => 'Failed to fetch data from the API.'];
            }
        } catch (\Exception $e) {
            return ['error' => 'An error occurred: ' . $e->getMessage()];
        }
    }

    private function getAccessToken()
    {
    	
        $authResponse = Http::post($this->apiEndPoint.'thirdPartyLogin', [
            'email' => $this->apiUsername,
            'password' => $this->apiPassword,
        ]);

        if ($authResponse->successful()) {
            $responseJson = $authResponse->json();
            return $responseJson['response']['token'];
        } else {
            return ['error' => 'Failed to authenticate and obtain an access token.'];
        }
    }
}
