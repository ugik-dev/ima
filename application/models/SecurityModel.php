<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SecurityModel extends CI_Model
{

  public function apiKeyGuard()
  {
    $headers = getallheaders();
    if (!isset($headers['X-Api-Key']) || NetworkIO::$apiKeys['sim'] != $headers['X-Api-Key']) {
      header("HTTP/1.1 401 Unauthorized");
      exit;
    }
  }

  public function hasUserdataKeyGuard($key, $ajax = FALSE)
  {
    if ($this->session->userdata($key) == NULL) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
      redirect($this->session->userdata('nama_controller'));
    }
  }

  public function certainUserGuard($userIds = array(), $ajax = FALSE)
  {
    if (!in_array($this->session->userdata('id_user'), $userIds)) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
      redirect($this->session->userdata('nama_controller'));
    }
  }

  public function usulanStepGuard($usulan, $step, $ajax = FALSE)
  {
    if ($usulan['status_pengisian'] != $step) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengubah usulan pada tahap ini', UNAUTHORIZED_CODE);
      redirect($this->session->userdata('nama_controller'));
    }
  }

  public function guestOnlyGuard($ajax = false)
  {
    if ($this->session->userdata('id_user')) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
      redirect($this->session->userdata('nama_controller'));
    }
  }

  public function userOnlyGuard($ajax = false, $forward = false)
  {
    if (!$this->session->has_userdata('id_user')) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
      if ($forward) {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
          $url = "https://";
        else
          $url = "http://";
        // Append the host(domain name, ip) to the URL.   
        $url .= $_SERVER['HTTP_HOST'];

        // Append the requested resource location to the URL   
        $url .= $_SERVER['REQUEST_URI'];
        $this->session->set_flashdata('originnalurl', $url);
      }
      redirect('login');
    }
  }

  public function roleOnlyGuard($role, $ajax = false)
  {
    if (strtolower($this->session->userdata('user_id')['nama_role']) != $role) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
      redirect($this->session->userdata('nama_controller'));
    }
  }

  public function rolesOnlyGuard($roles = [], $ajax = false)
  {
    if (!in_array(strtolower($this->session->userdata('user_id')['nama_role']), $roles)) {
      if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
      redirect($this->session->userdata('nama_controller'));
    }
  }

  public function pengusulSubTypeGuard($subTypes, $ajax = false)
  {
    foreach ($subTypes as $sT) {
      if ($this->session->userdata("id_{$sT}")) return;
    }
    if ($ajax) throw new UserException('Kamu tidak berhak mengakses resource ini', UNAUTHORIZED_CODE);
    redirect($this->session->userdata('nama_controller'));
  }

  public function checkUniquePosition($p, $pd)
  {
    if ($pd['posisi'] != "KETUA") {
      return TRUE;
    }

    foreach ($p['dosen'] as $d) {
      if ($d['posisi'] == "KETUA") {
        throw new UserException('Posisi ketua tidak boleh lebih dari satu.', DUPLICATE_UNIQUE_POSISI_CODE);
      }
    }
    return FALSE;
  }

  public function loginValidation()
  {
    return array($this->idUser, $this->password);
  }

  private $role = array(
    'field' => 'nama_role',
    'label' => 'Role',
    'rules' => 'required|trim'
  );

  public function changePasswordValidation()
  {
    return array($this->password, $this->repassword);
  }

  public function getPenelitian()
  {
    return array($this->tahun);
  }

  public function addPenelitian()
  {
    return array($this->idProgram, $this->tahun, $this->judul, $this->idSkema, $this->noSK);
  }

  public function editPenelitian()
  {
    return array(
      $this->idPenelitian, $this->idProgram, $this->tahun, $this->judul,
      $this->idSkema, $this->noSK
    );
  }

  public function deletePenelitian()
  {
    return array($this->idPenelitian);
  }

  public function addPenelitianDosen()
  {
    return array($this->idPenelitian, $this->idDosen, $this->posisi);
  }

  public function editPenelitianDosen()
  {
    return array($this->idPenelitianDosen, $this->idPenelitian, $this->idDosen, $this->posisi);
  }

  public function deletePenelitianDosen()
  {
    return array($this->idPenelitianDosen);
  }

  public function getPengabdian()
  {
    return array($this->tahun);
  }

  public function addPengabdian()
  {
    return array($this->idProgram, $this->tahun, $this->judul, $this->idSkema, $this->noSK);
  }

  public function editPengabdian()
  {
    return array(
      $this->idPengabdian, $this->idProgram, $this->tahun, $this->judul,
      $this->idSkema, $this->noSK
    );
  }

  public function deletePengabdian()
  {
    return array($this->idPengabdian);
  }

  public function addPengabdianDosen()
  {
    return array($this->idPengabdian, $this->idDosen, $this->posisi);
  }

  public function editPengabdianDosen()
  {
    return array($this->idPengabdianDosen, $this->idPengabdian, $this->idDosen, $this->posisi);
  }

  public function deletePengabdianDosen()
  {
    return array($this->idPengabdianDosen);
  }

  public function getKinerja()
  {
    return array($this->tahun, $this->semester);
  }

  private $idPengabdianDosen = array(
    'field' => 'id_pengabdian_dosen',
    'label' => 'ID Pengabdian Dosen',
    'rules' => 'required|trim'
  );

  private $idPengabdian = array(
    'field' => 'id_pengabdian',
    'label' => 'ID Pengabdian',
    'rules' => 'required|trim'
  );

  private $posisi = array(
    'field' => 'posisi',
    'label' => 'Posisi',
    'rules' => 'required|trim'
  );

  private $idPenelitianDosen = array(
    'field' => 'id_penelitian_dosen',
    'label' => 'ID Penelitian Dosen',
    'rules' => 'required|trim'
  );

  private $idPenelitian = array(
    'field' => 'id_penelitian',
    'label' => 'ID Penelitian',
    'rules' => 'required|trim'
  );

  private $idProgram = array(
    'field' => 'id_program',
    'label' => 'ID Program',
    'rules' => 'required|trim'
  );

  private $idSkema = array(
    'field' => 'id_skema',
    'label' => 'ID Skema',
    'rules' => 'required|trim'
  );

  private $judul = array(
    'field' => 'judul',
    'label' => 'Judul',
    'rules' => 'required|trim'
  );

  private $idDosen = array(
    'field' => 'id_dosen',
    'label' => 'ID Dosen',
    'rules' => 'required|trim'
  );

  private $tanggalKegiatan = array(
    'field' => 'tanggal_kegiatan',
    'label' => 'Tanggal Kegiatan',
    'rules' => 'required|trim'
  );

  private $deskripsi = array(
    'field' => 'deskripsi',
    'label' => 'Deskripsi',
    'rules' => 'required|trim',
  );

  private $noSK = array(
    'field' => 'no_sk',
    'label' => 'No SK',
    'rules' => 'required|trim',
  );

  private $idUser = array(
    'field' => 'username',
    'label' => 'Username',
    'rules' => 'required|trim',
  );

  private $password = array(
    'field' => 'password',
    'label' => 'Password',
    'rules' => 'required|trim'
  );

  private $repassword = array(
    'field' => 'repassword',
    'label' => 'Konfirmasi Password',
    'rules' => 'required|trim|matches[password]'
  );

  private $tahun = array(
    'field' => 'tahun',
    'label' => 'Tahun',
    'rules' => 'required|trim|exact_length[4]'
  );

  private $semester = array(
    'field' => 'semester',
    'label' => 'Semester',
    'rules' => 'required|trim'
  );

  private $bulan = array(
    'field' => 'bulan',
    'label' => 'Bulan',
    'rules' => 'required|trim|max_length[2]'
  );
}
