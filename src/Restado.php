<?php
/**
 * Created by PhpStorm.
 * User: n0impossible
 * Date: 6/13/15
 * Time: 11:35 AM
 */

namespace Robertogallea\Restado;

use League\OAuth2\Client\Provider\GenericProvider;

/**
 * Class Restado
 * @package Robertogallea\Restado
 */
class Restado {

    /**
     * @param array $data
     * @return \League\OAuth2\Client\Token\AccessToken
     */
    public function authorize($data = [])
    {
        $provider = $this->getProvider();

        try {

            // Try to get an access token using the resource owner password credentials grant.
            $accessToken = $provider->getAccessToken('password', [
                'username' =>config('tado.username'),
                'password' => config('tado.password'),
                'scope' => 'home.user',
            ]);
            return $accessToken;

        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

            // Failed to get the access token
            exit($e->getMessage());

        }
    }

    /**
     * @param $accessToken
     * @return mixed
     */
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

    /**
     * @param $accessToken
     * @param $homeid
     * @return mixed
     */
    public function getHome($accessToken, $homeid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $settings
     * @return mixed
     */
    public function setHome($accessToken, $homeid, $settings) {
        $provider = $this->getProvider();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $homeid,
            $accessToken,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $accessToken
     * @param $homeid
     * @return mixed
     */
    public function getHomeWeather($accessToken, $homeid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @return mixed
     */
    public function getHomeDevices($accessToken, $homeid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @return mixed
     */
    public function getHomeInstallations($accessToken, $homeid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @return mixed
     */
    public function getHomeUsers($accessToken, $homeid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @return mixed
     */
    public function getHomeMobileDevices($accessToken, $homeid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $deviceId
     * @return mixed
     */
    public function deleteHomeMobileDevice($accessToken, $homeid, $deviceId) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'DELETE',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/mobileDevices/' . $deviceId,
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }


    /**
     * @param $accessToken
     * @param $homeid
     * @param $deviceId
     * @return mixed
     */
    public function getHomeMobileDeviceSettings($accessToken, $homeid, $deviceId) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $deviceId
     * @param $settings
     * @return mixed
     */
    public function setHomeMobileDeviceSettings($accessToken, $homeid, $deviceId, $settings) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @return mixed
     */
    public function getHomeZones($accessToken, $homeid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @return mixed
     */
    public function getHomeZoneState($accessToken, $homeid, $zoneid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @return mixed
     */
    public function getHomeZoneDayReport($accessToken, $homeid, $zoneid, $date) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/dayReport?date=' . $date,
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @return mixed
     */
    public function getHomeZoneCapabilities($accessToken, $homeid, $zoneid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @return mixed
     */
    public function getHomeZoneEarlyStart($accessToken, $homeid, $zoneid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneEarlyStart($accessToken, $homeid, $zoneid, $settings) {
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


    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @return mixed
     */
    public function getHomeZoneOverlay($accessToken, $homeid, $zoneid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneOverlay($accessToken, $homeid, $zoneid, $settings) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @return mixed
     */
    public function deleteHomeZoneOverlay($accessToken, $homeid, $zoneid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @return mixed
     */
    public function getHomeZoneScheduleActiveTimetable($accessToken, $homeid, $zoneid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneScheduleActiveTimetable($accessToken, $homeid, $zoneid, $settings) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @return mixed
     */
    public function getHomeZoneScheduleAway($accessToken, $homeid, $zoneid) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneScheduleAway($accessToken, $homeid, $zoneid, $settings) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @param $timetableid
     * @param null $daypattern
     * @return mixed
     */
    public function getHomeZoneScheduleTimetableBlocks($accessToken, $homeid, $zoneid, $timetableid, $daypattern=null) {
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

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @param $timetableid
     * @param $daypattern
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneScheduleTimetableBlocks($accessToken, $homeid, $zoneid, $timetableid, $daypattern, $settings) {
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

    /**
     * @param $accessToken
     * @return mixed
     */
    public function getAppUsersRelativePositions($accessToken) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/mobile/1.9/getAppUsersRelativePositions',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $accessToken
     * @param $deviceid
     * @return bool
     */
    public function identifyDevice($accessToken, $deviceid) {
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

    /**
     * @param $accessToken
     * @param $deviceid
     * @return mixed
     */
    public function getTemperatureOffset($accessToken, $deviceid) {
        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/devices/' .  $deviceid . '/temperatureOffset',
            $accessToken
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $accessToken
     * @param $deviceid
     * @param $settings
     * @return bool
     */
    public function setTemperatureOffset($accessToken, $deviceid, $settings) {
        $provider = $this->getProvider();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/devices/' .  $deviceid . '/temperatureOffset',
            $accessToken,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @param $setting
     * @return bool
     */
    public function setDazzle($accessToken, $homeid, $zoneid, $setting) {
        $provider = $this->getProvider();

        $options['body'] = json_encode(['enabled' => $setting]);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'POST',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/dazzle',
            $accessToken,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return $response->getStatusCode() == 200;
    }

    /**
     * @param $accessToken
     * @param $homeid
     * @param $zoneid
     * @param $settings
     * @return bool
     */
    public function setOpenWindowDetection($accessToken, $homeid, $zoneid, $settings) {
        $provider = $this->getProvider();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'POST',
            'https://my.tado.com/api/v2/homes/' . $homeid . '/zones/' . $zoneid . '/openWindowDetection',
            $accessToken,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return $response->getStatusCode() == 200;
    }


    /**
     * @return GenericProvider
     */
    private function getProvider() {
        return new GenericProvider([
            'clientId'                => config('tado.clientId'),    // The client ID assigned to you by the provider
            'clientSecret'            => config('tado.clientSecret'),   // The client password assigned to you by the provider
            'urlAuthorize'            => 'https://auth.tado.com/oauth/authorize',
            'urlAccessToken'          => 'https://auth.tado.com/oauth/token',
            'urlResourceOwnerDetails' => null,
        ]);
    }
}