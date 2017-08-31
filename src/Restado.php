<?php
/**
 * Created by PhpStorm.
 * User: n0impossible
 * Date: 6/13/15
 * Time: 11:35 AM
 */

namespace Robertogallea\Restado;

use League\OAuth2\Client\Provider\GenericProvider;

class Restado {
    public function authorize($data = [])
    {
        $provider = $this->getProvider();

        try {

            // Try to get an access token using the resource owner password credentials grant.
            $accessToken = $provider->getAccessToken('password', [
                'username' => env('TADO_USER'),
                'password' => env('TADO_PASS')
            ]);
            return $accessToken;

        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

            // Failed to get the access token
            exit($e->getMessage());

        }
    }

    public function me($accessToken) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/me',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHome($accessToken,$homeid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid,
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeWeather($accessToken,$homeid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/weather/',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeDevices($accessToken,$homeid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/devices/',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeInstallations($accessToken,$homeid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/installations/',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeUsers($accessToken,$homeid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/users/',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeMobileDevices($accessToken,$homeid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/mobileDevices/',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function deleteHomeMobileDevice($accessToken,$homeid,$deviceId) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'DELETE',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/mobileDevices/' . $deviceId . '/settings',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }


    public function getHomeMobileDeviceSetting($accessToken,$homeid,$deviceId) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/mobileDevices/' . $deviceId . '/settings',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function setHomeMobileDeviceSetting($accessToken,$homeid,$deviceId,$settings) {
        $provider = $this->getProvider();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/mobileDevices/' . $deviceId . '/settings',
            $accessToken,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeZones($accessToken,$homeid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeZoneState($accessToken,$homeid,$zoneid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/state',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeZoneCapabilities($accessToken,$homeid,$zoneid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/capabilities',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeZoneEarlyStart($accessToken,$homeid,$zoneid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/earlyStart',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function setHomeZoneEarlyStart($accessToken,$homeid,$zoneid,$settings) {
        $provider = $this->getProvider();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/earlyStart',
            $accessToken,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }


    public function getHomeZoneOverlay($accessToken,$homeid,$zoneid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/overlay',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function setHomeZoneOverlay($accessToken,$homeid,$zoneid,$settings) {
        $provider = $this->getProvider();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/overlay',
            $accessToken,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function deleteHomeZoneOverlay($accessToken,$homeid,$zoneid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'DELETE',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/overlay',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeZoneScheduleActiveTimetable($accessToken,$homeid,$zoneid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/schedule/activeTimetable',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function setHomeZoneScheduleActiveTimetable($accessToken,$homeid,$zoneid,$settings) {
        $provider = $this->getProvider();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/schedule/activeTimetable',
            $accessToken,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeZoneScheduleAway($accessToken,$homeid,$zoneid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/schedule/awayConfiguration',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function setHomeZoneScheduleAway($accessToken,$homeid,$zoneid,$settings) {
        $provider = $this->getProvider();


        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/schedule/awayConfiguration',
            $accessToken,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function getHomeZoneScheduleTimetableBlocks($accessToken,$homeid,$zoneid,$timetableid,$daypattern=null) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/schedule/timetables/' . $timetableid . '/blocks' . (!is_null($daypattern) ? ('/' . $daypattern) : ''),
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function setHomeZoneScheduleTimetableBlocks($accessToken,$homeid,$zoneid,$timetableid,$daypattern,$settings) {
        $provider = $this->getProvider();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/schedule/timetables/' . $timetableid . '/blocks' . (!is_null($daypattern) ? ('/' . $daypattern) : ''),
            $accessToken,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    public function identifyDevice($accessToken,$deviceid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'POST',
            'https://my.tado.com/api/v2/devices/' .  $deviceid . '/identify',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return $response->getStatusCode() == 200;
    }



    private function getProvider() {
        return new GenericProvider([
            'clientId'                => env('TADO_CLIENT_ID','public-api-preview'),    // The client ID assigned to you by the provider
            'clientSecret'            => env('TADO_SECRET','4HJGRffVR8xb3XdEUQpjgZ1VplJi6Xgw'),   // The client password assigned to you by the provider
//            'redirectUri'             => 'http://example.com/your-redirect-url/',
            'urlAuthorize'            => 'http://brentertainment.com/oauth2/lockdin/authorize',
            'urlAccessToken'          => 'https://auth.tado.com/oauth/token',
            'urlResourceOwnerDetails' => 'http://brentertainment.com/oauth2/lockdin/resource'
        ]);
    }
}