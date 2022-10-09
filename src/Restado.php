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
     * @param $access_token
     * @return mixed
     */
    public function me($access_token) {
        $provider = $this->getProvider();

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
     * @return mixed
     */
    public function getHomeId() {
        $provider = $this->getProvider();
        $access_token = $this->authorize();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/me',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        $decoded = json_decode($response->getBody());
        return $decoded->homes[0]->id;
    }

    /**
     * @param $access_token
     * @return mixed
     */
    public function getHome($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $settings
     * @return mixed
     */
    public function setHome($access_token, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @return mixed
     */
    public function getHomeWeather($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @return mixed
     */
    public function getHomeDevices($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @return mixed
     */
    public function getHomeInstallations($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @return mixed
     */
    public function getHomeUsers($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @return mixed
     */
    public function getHomeMobileDevices($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $device_id
     * @return mixed
     */
    public function deleteHomeMobileDevice($access_token, $device_id) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $device_id
     * @return mixed
     */
    public function getHomeMobileDeviceSettings($access_token, $device_id) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $device_id
     * @param $settings
     * @return mixed
     */
    public function setHomeMobileDeviceSettings($access_token, $device_id, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @return mixed
     */
    public function getHomeZones($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneState($access_token, $zone_id) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneDayReport($access_token, $zone_id, $date) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneCapabilities($access_token, $zone_id) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneEarlyStart($access_token, $zone_id) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneEarlyStart($access_token, $zone_id, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneOverlay($access_token, $zone_id) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $zone_id
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneOverlay($access_token, $zone_id, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @return mixed
     */
    public function deleteHomeZoneOverlay($access_token, $zone_id) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneScheduleActiveTimetable($access_token, $zone_id) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneScheduleActiveTimetable($access_token, $zone_id, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @return mixed
     */
    public function getHomeZoneScheduleAway($access_token, $zone_id) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneScheduleAway($access_token, $zone_id, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @param $timetableid
     * @param null $daypattern
     * @return mixed
     */
    public function getHomeZoneScheduleTimetableBlocks($access_token, $zone_id, $timetableid, $daypattern=null) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @param $timetableid
     * @param $daypattern
     * @param $settings
     * @return mixed
     */
    public function setHomeZoneScheduleTimetableBlocks($access_token, $zone_id, $timetableid, $daypattern, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @return mixed
     */
    public function getAppUsersRelativePositions($access_token) {
        $provider = $this->getProvider();

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
     * @param $access_token
     * @param $device_id
     * @return bool
     */
    public function identifyDevice($access_token, $device_id) {
        $provider = $this->getProvider();

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
     * @param $access_token
     * @param $device_id
     * @return mixed
     */
    public function getTemperatureOffset($access_token, $device_id) {
        $provider = $this->getProvider();

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
     * @param $access_token
     * @param $device_id
     * @param $settings
     * @return bool
     */
    public function setTemperatureOffset($access_token, $device_id, $settings) {
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
     * @param $access_token
     * @param $zone_id
     * @param $setting
     * @return bool
     */
    public function setDazzle($access_token, $zone_id, $setting) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $zone_id
     * @param $settings
     * @return bool
     */
    public function setOpenWindowDetection($access_token, $zone_id, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @return mixed
     */
    public function isAnyoneAtHome($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @return mixed
     */
    public function getPresenceLock($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $settings
     * @return mixed
     */
    public function setPresenceLock($access_token, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

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
     * @param $access_token
     * @param $settings
     * @return mixed
     */
    public function addEnergyIQMeterReading($access_token, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId();

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://energy-insights.tado.com/api/homes/' .  $home_id . '/meterReadings',
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