<?php
class CustomFunctions {
  public static function status_permohonan_word($textrun, $status){    
    if($status == 'DIMULAI')
      $textrun->addText('Draft', array('name' => 'Times New Roman', 'size' => 12, 'color' => 'f8ac59'));
    else if($status == 'DIPROSES')
      $textrun->addText('Diproses', array('name' => 'Times New Roman', 'size' => 12, 'color' => '007bff'));
    else if($status == 'DITERIMA')
      $textrun->addText('Diterima', array('name' => 'Times New Roman', 'size' => 12, 'color' => '28a745'));
    else if($status == 'DITOLAK')
      $textrun->addText('Ditolak', array('name' => 'Times New Roman', 'size' => 12, 'color' => 'ed5565'));
    else
      $textrun->addText('-', array('name' => 'Times New Roman', 'size' => 12));
  }

 
}