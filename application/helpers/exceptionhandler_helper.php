<?php
class ExceptionHandler {
  public static function handle(Exception $e){
    if ($e instanceof UserException){
      echo json_encode(array('error' => true, 'message' => $e->getMessage()));
    } else {
      echo json_encode(array('error' => true, 'message' => "Kesalahan internal server. Kode: " . $e->getCode()));
    }
  }

  public static function handleDBError($e, $aksi = "", $resourceName = "", $otherResourceName = ""){
    switch($e['code']){
      case 0:
        return;
      case 1062:
        throw new UserException($aksi . " gagal! " . $resourceName . " sudah ada", $e['code']);
      case 1451:
        throw new UserException($aksi . " gagal! " . $resourceName . " memiliki " . $otherResourceName, $e['code']);
      default: 
        throw new UserException($e['code'] . ': ' . $e['message'], $e['code']);
    }
  }
}