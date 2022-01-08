<?php
class NetworkIO extends Exception
{

  public static $remotesUrl = array(
    'self' => 'http://localhost/simdasync/',
    'ima' => 'https://indometalasia.com/apps/api/'
  );

  public static $apiKeys = array(
    'self' => '',
    'ima' => 'https://indometalasia.com/apps/api/'
  );

  public static function post($host, $action, $data)
  {
    $payload = http_build_query($data);
    $curl = curl_init(NetworkIO::$remotesUrl[$host] . $action);

    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Api-Key: ' . NetworkIO::$apiKeys[$host]));
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);

    $result = curl_exec($curl);
    $info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $cekerror = curl_error($curl);
    var_dump($cekerror);
    curl_close($curl);

    if ($info != 200) {
      throw new UserException('Gagal ' . $action . '. Status HTTP: ' . $info, 1000 + $info);
    }

    return json_decode($result, true);
  }

  public static function get($host, $action, $data)
  {
    $payload = http_build_query($data);
    $curl = curl_init(NetworkIO::$remotesUrl[$host] . $action . '?' . $payload);
    var_dump(NetworkIO::$remotesUrl[$host] . $action . '?' . $payload);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-Api-Key: ' . NetworkIO::$apiKeys[$host]));
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);

    $result = curl_exec($curl);
    $info = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if ($info != 200) {
      throw new UserException('Gagal ' . $action . '. Status HTTP: ' . $info, 1000 + $info);
    }

    return json_decode($result, true);
  }
}
