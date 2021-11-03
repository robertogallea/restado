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
            $access_token = $provider->getAccessToken('password', [
                'username' =>config('tado.username'),
                'password' => config('tado.password'),
                'scope' => 'home.user',
            ]);
            return $access_token;

        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

            // Failed to get the access token
            exit($e->getMessage());

        }
    }

    /**
     * @return mixed
     */
    public function me() {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/me',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @return mixed
     */
    public function getHome($home_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id,
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $settings
     * @return mixed
     */
    public function setHome($home_id, $settings) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $home_id,
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @return mixed
     */
    public function getHomeWeather($home_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/weather/',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @return mixed
     */
    public function getHomeDevices($home_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/devices/',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @return mixed
     */
    public function getHomeInstallations($home_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/installations/',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @return mixed
     */
    public function getHomeUsers($home_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/users/',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @return mixed
     */
    public function getHomeMobileDevices($home_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/mobileDevices/',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $device_id
     * @return mixed
     */
    public function deleteHomeMobileDevice($home_id, $device_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'DELETE',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/mobileDevices/' . $device_id,
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }


    /**
     * @param $home_id
     * @param $device_id
     * @return mixed
     */
    public function getHomeMobileDeviceSettings($home_id, $device_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/mobileDevices/' . $device_id . '/settings',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $device_id
     * @param $settings
     * @return mixed
     */
    public function setHomeMobileDeviceSettings($home_id, $device_id, $settings) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/mobileDevices/' . $device_id . '/settings',
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @return mixed
     */
    public function getHomeZones($home_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneState($home_id, $zone_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/state',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneDayReport($home_id, $zone_id, $date) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/dayReport?date=' . $date,
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneCapabilities($home_id, $zone_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/capabilities',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneEarlyStart($home_id, $zone_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/earlyStart',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneEarlyStart($home_id, $zone_id, $settings) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/earlyStart',
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }


    /**
     * @param $home_id
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneOverlay($home_id, $zone_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/overlay',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $access_token
     * @param $home_id
     * @param $zone_id
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneOverlay($home_id, $zone_id, $settings) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/overlay',
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @return mixed
     */
    public function deleteHomeZoneOverlay($home_id, $zone_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'DELETE',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/overlay',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneScheduleActiveTimetable($home_id, $zone_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/schedule/activeTimetable',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneScheduleActiveTimetable($home_id, $zone_id, $settings) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/schedule/activeTimetable',
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneScheduleAway($home_id, $zone_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/schedule/awayConfiguration',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneScheduleAway($home_id, $zone_id, $settings) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();


        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/schedule/awayConfiguration',
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @param $timetableid
     * @param null $daypattern
     * @return mixed
     */
    public function getHomeZoneScheduleTimetableBlocks($home_id, $zone_id, $timetableid, $daypattern=null) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/schedule/timetables/' . $timetableid . '/blocks' . (!is_null($daypattern) ? ('/' . $daypattern) : ''),
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @param $timetableid
     * @param $daypattern
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneScheduleTimetableBlocks($home_id, $zone_id, $timetableid, $daypattern, $settings) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/schedule/timetables/' . $timetableid . '/blocks' . (!is_null($daypattern) ? ('/' . $daypattern) : ''),
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @return mixed
     */
    public function getAppUsersRelativePositions() {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/mobile/1.9/getAppUsersRelativePositions',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $device_id
     * @return bool
     */
    public function identifyDevice($device_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'POST',
            'https://my.tado.com/api/v2/devices/' .  $device_id . '/identify',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return $response->getStatusCode() == 200;
    }

    /**
     * @param $device_id
     * @return mixed
     */
    public function getTemperatureOffset($device_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/devices/' .  $device_id . '/temperatureOffset',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $device_id
     * @param $settings
     * @return bool
     */
    public function setTemperatureOffset($device_id, $settings) {
        $provider = $this->getProvider();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/devices/' .  $device_id . '/temperatureOffset',
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @param $setting
     * @return bool
     */
    public function setDazzle($home_id, $zone_id, $setting) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();


        $options['body'] = json_encode(['enabled' => $setting]);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'POST',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/dazzle',
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return $response->getStatusCode() == 200;
    }

    /**
     * @param $home_id
     * @param $zone_id
     * @param $settings
     * @return bool
     */
    public function setOpenWindowDetection($home_id, $zone_id, $settings) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();


        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'POST',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/zones/' . $zone_id . '/openWindowDetection',
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return $response->getStatusCode() == 200;
    }

    /**
     * @param $home_id
     * @return mixed
     */
    public function isAnyoneAtHome($home_id) {
        $access_token = $this->authorize();

        $anyoneAtHome = false;

        $homeUsers = $this->getHomeUsers($access_token, $home_id);
        foreach($homeUsers as $homeUser) {
            foreach($homeUser->mobileDevices as $device) {
                $anyoneAtHome = $device->location->atHome == 1;
            }
        }

        return $anyoneAtHome;
    }
  
     /**
     * @param $home_id
     * @return mixed
     */
    public function getPresenceLock($home_id) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/state',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }
    
    /**
     * @param $home_id
     * @param $settings
     * @return mixed
     */
    public function setPresenceLock($home_id, $settings) {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://my.tado.com/api/v2/homes/' . $home_id . '/presenceLock',
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
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