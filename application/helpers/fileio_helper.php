<?php
class FileIO
{

  public static function uploadPath($field)
  {
    return realpath(APPPATH . '../uploads/' . $field) . '\\';
  }

  public static function upload($field, $folder, $type, $allowedType = NULL)
  {
    $CI = &get_instance();
    $CI->load->library('upload');
    $CI->upload->initialize(array(
      'upload_path' => realpath(APPPATH . '../uploads/' . $folder),
      'allowed_types' => $allowedType != NULL ? $allowedType : 'jpg|jpeg|png|gif|doc|docx|pdf',
      'max_size' => '2500',
      'encrypt_name' => TRUE,
    ));
    if (!$CI->upload->do_upload($field)) {
      throw new UserException($CI->upload->display_errors(), UPLOAD_FAILED_CODE);
    } else {
      return [
        'type' => $type,
        'filename' => $CI->upload->data()['file_name'],
        'url' => "uploads/{$folder}/{$CI->upload->data()['file_name']}",
        'size' => round($CI->upload->data()['file_size'])
      ];
    }
  }

  public static function upload2($field, $folder, $type, $allowedType = NULL)
  {
    // throw new UserException($folder, UPLOAD_FAILED_CODE);
    $CI = &get_instance();
    $CI->load->library('upload');
    $CI->upload->initialize(array(
      'upload_path' => realpath(APPPATH . '../uploads/' . $folder),
      'allowed_types' => $allowedType != NULL ? $allowedType : 'jpg|jpeg|png|gif|doc|docx|pdf',
      'max_size' => '2500',
      'encrypt_name' => TRUE,
    ));
    if (!$CI->upload->do_upload($field)) {
      throw new UserException($CI->upload->display_errors(), UPLOAD_FAILED_CODE);
    } else {
      return [
        'type' => $type,
        'filename' => $CI->upload->data()['file_name'],
        'url' => "uploads/{$folder}/{$CI->upload->data()['file_name']}",
        'size' => round($CI->upload->data()['file_size'])
      ];
    }
  }

  public static function delete($url)
  {
    $path = realpath(APPPATH . '../' . $url);
    if (!empty($url) && file_exists($path)) {
      if (!unlink($path)) {
        throw new UserException('Gagal mengahapus ', 0);
      }
    } else {
      // throw new UserException('File tidak ada', FILE_NOT_FOUND);
    }

    return NULL;
  }

  public static function headerDownloadxlsx($title)
  {
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $title . '.xlsx"');
    header('Cache-Control: max-age=0');
  }

  public static function headerDownloadxls($title)
  {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $title . '.xls"');
    header('Cache-Control: max-age=0');
  }

  public static function headerDownloadDocx($title)
  {
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment;filename="' . $title . '.docx"');
    header('Cache-Control: max-age=0');
  }

  public static function headerDownloadZip($path, $title)
  {
    header("Content-Disposition: attachment; filename=$title");
    header("Content-length: " . filesize($path . $title));
    header("Content-type: application/zip");
    header('Cache-Control: max-age=0');
  }

  public static function genCompatPDF($field, $oldFilename, $filename)
  {
    $oldFilename = "./uploads/{$field}/{$oldFilename}";
    $newFilename = "./uploads/{$field}/{$filename}";
    putenv('PATH=C:\Program Files\gs\gs9.26\bin');
    shell_exec('gswin64 -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH -sOutputFile=' . $newFilename . ' ' . $oldFilename);
    FileIO::delete($field, $oldFilename);
  }

  public static function genericUpload($field, $allowedType, $oldData = NULL, $data)
  {
    $filename = NULL;
    $filename = !empty($_FILES[$field]['name']) ? FileIO::upload($field, $field, NULL, $allowedType)['filename'] : (!empty($oldData[$field]) ? $oldData[$field] : NULL);
    $filename = !empty($data["delete_{$field}"]) ? FileIO::delete("/uploads/{$field}/" . $data["delete_{$field}"]) : $filename;
    return $filename;
  }

  public static function genericReUpload($field , $allowedType, $oldData = NULL, $data)
  {
    $field = 're_upload_dokumen';
    // var_dump($data);
    // throw new UserException($_FILES[$field]['name'], UPLOAD_FAILED_CODE);
    $filename = NULL;
    $filename = !empty($_FILES[$field]['name']) ? FileIO::upload2($field, $data['parm'], NULL, $allowedType)['filename'] : (!empty($oldData[$field]) ? $oldData[$field] : NULL);
    $filename = !empty($data["delete_{$field}"]) ? FileIO::delete("/uploads/{$field}/" . $data["delete_{$field}"]) : $filename;
    return $filename;
  }
}
