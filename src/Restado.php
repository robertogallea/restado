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

    protected $home_id;

    /**
     * Get a Verification Url
     * for authorization based on RFC 8628
     * this is required by tado starting on March 2025
     *
     * see also https://support.tado.com/en/articles/8565472-how-do-i-authenticate-to-access-the-rest-api
     *          https://www.oauth.com/oauth2-servers/device-flow/token-request/
     *
     * @return url
     */
    public function getVerificationUrl()
    {
        $provider = $this->getProvider();

        // from https://stackoverflow.com/questions/52718933/making-post-request-with-thephpleague-oauth2-client

        $requestUrl = 'https://login.tado.com/oauth2/device_authorize';
        $postData = [
            'client_id' => config('tado.clientId'),
            'scope' => 'offline_access',
        ];
        $options = [
            'body' => http_build_query($postData),
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ];

        $request = $provider->getRequest("POST", $requestUrl, $options);
        $response = $provider->getParsedResponse($request);

        if (!isset($response['verification_uri_complete'])) return FALSE;
        return $response;
    }

    /**
     * @param array $data
     * @return \League\OAuth2\Client\Token\AccessToken
     */
    public function authorize($data = [])
    {
        $provider = $this->getProvider();

        try {

            // Try to get an access token using the device code.
            $access_token = $provider->getAccessToken('device_code', [
                'device_code' => $data['device_code'],
            ]);
            return $access_token;

        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

            // Failed to get the access token
            exit($e->getMessage());

        }
    }

    public function refreshToken($data) {
        $provider = $this->getProvider();

        try {
            $refreshed_token = $provider->getAccessToken('refresh_token', [
                'client_id' => config('tado.clientId'),
                'grant_type' => 'refresh_token',
                'refresh_token' => $data['refresh_token'],
            ]);
            return $refreshed_token;

        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

            // Failed to get the access token
            $responseBody = $e->getResponseBody();
            exit($responseBody['error_description']);

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
    public function getHomeId($access_token) {

        // do caching....
        if (isset($this->home_id)) return $this->home_id;

        $provider = $this->getProvider();

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://my.tado.com/api/v2/me',
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        $decoded = json_decode($response->getBody());

        $this->home_id = $decoded->homes[0]->id;
        return $this->home_id;
    }

    /**
     * @param $access_token
     * @return mixed
     */
    public function getHome($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
    * @param $home_id
    * @return mixed
    */
   public function getHomeZoneStates($access_token, $home_id) {
       $provider = $this->getProvider();

       $request = $provider->getAuthenticatedRequest(
           'GET',
           'https://my.tado.com/api/v2/homes/' . $home_id . '/zoneStates',
           $access_token
       );
       $client = new \GuzzleHttp\Client();
       $response = $client->send($request);
       return json_decode($response->getBody());
   }

    /**
     * @param $access_token
     * @param $zone_id
     * @param $date
     * @return mixed
     */
    public function getHomeZoneDayReport($access_token, $zone_id, $date) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

        $anyoneAtHome = false;
        $homeCount = 0;

        $homeUsers = $this->getHomeUsers($access_token);
        foreach($homeUsers as $homeUser) {
            foreach($homeUser->mobileDevices as $device) {
                if($device->location->atHome) {
                    $homeCount++;
                }
            }
        }

        if ($homeCount > 0) {
            $anyoneAtHome = true;
        }

        return $anyoneAtHome;
        }

     /**
     * @param $access_token
     * @return mixed
     */
    public function getPresenceLock($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId($access_token);

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
        $home_id = $this->getHomeId($access_token);

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
     * @return mixed
     */
    public function getEnergyIQ($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId($access_token);

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://energy-insights.tado.com/api/homes/' .  $home_id . '/consumption',
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
    public function getEnergyIQMeterReadings($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId($access_token);

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://energy-insights.tado.com/api/homes/' .  $home_id . '/meterReadings',
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
    public function getEnergyIQTariff($access_token) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId($access_token);

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://energy-insights.tado.com/api/homes/' .  $home_id . '/tariff',
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
    public function updateEnergyIQTariff($access_token, $settings) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId($access_token);

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'PUT',
            'https://energy-insights.tado.com/api/homes/' .  $home_id . '/tariff',
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
        $home_id = $this->getHomeId($access_token);

        $options['body'] = json_encode($settings);
        $options['headers']['content-type'] = 'application/json';

        $request = $provider->getAuthenticatedRequest(
            'POST',
            'https://energy-insights.tado.com/api/homes/' .  $home_id . '/meterReadings',
            $access_token,
            $options
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $access_token
     * @param $reading_id
     * @return mixed
     */
    public function deleteEnergyIQMeterReading($access_token, $reading_id) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId($access_token);

        $request = $provider->getAuthenticatedRequest(
            'DELETE',
            'https://energy-insights.tado.com/api/homes/' .  $home_id . '/meterReadings/' . $reading_id,
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @param $access_token
     * @param $year
     * @param $month
     * @param $country_code
     * @return mixed
     */
    public function getEnergySavingsReport($access_token, $year, $month, $country_code) {
        $provider = $this->getProvider();
        $home_id = $this->getHomeId($access_token);

        $request = $provider->getAuthenticatedRequest(
            'GET',
            'https://energy-bob.tado.com/' .  $home_id . '/' . $year . '-' . $month . '?country=' . $country_code,
            $access_token
        );
        $client = new \GuzzleHttp\Client();
        $response = $client->send($request);
        return json_decode($response->getBody());
    }

    /**
     * @return GenericProvider
     */
    private function getProvider() {

        if (config('tado.timeout') !== NULL) {
          $timeout = config('tado.timeout');
        } else {
          // set a timeout based on PHP max_execution_time if not configured
          // in case of an invalid max_execution_time (empty or FALSE) a default of 20s is being set
          // in case of an valid max_execution_time the timeout is being set to 90% of this value with a maximum of 20s
          $timeout = floor((int)ini_get('max_execution_time') * 0.9);
          if (($timeout>20) or ($timeout<=0)) $timeout = 20;
        }

        return new GenericProvider([
            'clientId'                => config('tado.clientId'),    // The client ID assigned to you by the provider
            'urlAuthorize'            => 'https://login.tado.com/oauth2/device_authorize',
            'urlAccessToken'          => 'https://login.tado.com/oauth2/token',
            'urlResourceOwnerDetails' => null,
            'timeout'                 => $timeout,
        ]);
    }
}
