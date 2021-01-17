<?php
  session_start();
  if(empty($_SESSION['kd_pembelian']))
  {
    header("Location: tambah.php");
  }
  require_once("../../vendor/autoload.php");
  require_once("../../pengaturan/pengaturan.php");
  require_once("../../pengaturan/helper.php");
  require_once("../../pengaturan/database.php");
  
  $judul = "Detail Pembelian";  
  $daftar_pembelian = $db->query("SELECT a.*, b.nm_barang FROM detail_pembelian_tmp a JOIN barang b ON a.kd_barang = b.kd_barang WHERE kd_pembelian = :kd_pembelian", ['kd_pembelian' => $_SESSION['kd_pembelian']])->fetchAll(PDO::FETCH_ASSOC);
  $daftar_barang = $db->query("SELECT * FROM barang")->fetchAll(PDO::FETCH_ASSOC);
  $detail_pembelian = $db->query("SELECT SUM(total_hrg) as total_hrg FROM detail_pembelian_tmp WHERE kd_pembelian = :kd_pembelian", ['kd_pembelian' => $_SESSION['kd_pembelian']])->fetch();
  
  $_SESSION['total_hrg'] = $detail_pembelian['total_hrg'];
?>

<html>
  <!-- Bagian head -->
  <?php include("../../template/head.php") ?>
  <body>
    <div class="wrapper">
      <!-- Bagian sidebar -->
      <?php include("../../template/header.php") ?>
      <!-- Bagian sidebar -->
      <?php include("../../template/sidebar.php") ?>
      <div class="main-panel">
        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-8">
                <div class="card" id="daftarData" style="display: block;">
                  <div class="card-header">
                    <div class="card-title">Tambah Pembelian Barang
                    </div>
                  </div>
                  <div class="card-body">
                    <form method="POST" action="proses-tambah-barang.php">
                      <div class="form-group">
                        <label>Pilih Barang</label>
                        <select name="kd_barang" class="form-control">
                          <?php foreach($daftar_barang as $d): ?>
                            <option value="<?=$d['kd_barang']?>"><?=$d['nm_barang']?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Jumlah</label>
                        <input type="number" name="jml" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label>Total Harga</label>
                        <input type="number" name="total_hrg" class="form-control" />
                      </div>
                      <div class="form-group">
                        <div style="float: left;">
                          <button type="submit" class="btn btn-primary">Tambahkan Barang</button>
                        </div>
                        <div style="float: right;">
                          <a href="proses-simpan-pembelian.php" class="btn btn-success">Simpan Pembelian</a>
                        </div>
                        <div style="clear: both;"></div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card" id="daftarData" style="display: block;">
                  <div class="card-header">
                    <div class="card-title">Detail Pembelian
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label>Kode Pembelian
                      </label>
                      <p>
                        <?=$_SESSION['kd_pembelian']?>
                      </p>
                    </div>
                    <div class="form-group">
                      <label>Tanggal Pembelian
                      </label>
                      <p>
                        <?=tanggal_indo($_SESSION['tgl_pembelian'])?>
                      </p>
                    </div>
                    <div class="form-group">
                      <label>Supplier
                      </label>
                      <p>
                        <?=$_SESSION['nm_supplier']?>
                      </p>
                    </div>
                    <div class="form-group">
                      <label>Total Harga
                      </label>
                      <p>
                        <?=rupiah($detail_pembelian['total_hrg'], "Rp  ")?>
                      </p>
                    </div>
                    <div class="form-group">
                      <a href="reset-pembelian.php" class="btn btn-danger">Reset Pembelian
                      </a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="card" id="daftarData" style="display: block;">
                  <div class="card-header">
                    <div class="card-title">Daftar Barang Yang Dibeli
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table id="tabel" class="table table-bordered table-head-bg-primary mt-4">
                        <thead>
                          <tr>
                            <th>No
                            </th>
                            <th>Nama Barang
                            </th>
                            <th>Jumlah
                            </th>
                            <th>Total Harga (Rp)
                            </th>
                            <th>Aksi
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
$no = 1;
foreach($daftar_pembelian as $i=>$d):
?>
                          <tr>
                            <td>
                              <?=$no?>
                            </td>
                            <td>
                              <?=$d['nm_barang']?>
                            </td>
                            <td>
                              <?=$d['jml']?>
                            </td>
                            <td>
                              <?=rupiah($d['total_hrg'], "")?>
                            </td>
                            <td>
                              <div class="form-group">
                                <a href="proses-hapus-pembelian.php?kd_tmp=<?=$d['kd_tmp']?>" class="btn btn-danger">Hapus
                                </a>
                              </div>
                            </td>
                          </tr>
                          <?php
$no++;
endforeach;
?>
                        </tbody>
                      </table>
                      <!-- Akhir dari Bagian tabel -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- AKHIR DARI BAGIAN KONTEN -->  
          </div>
        </div>
      </div>
    </div>
    <!-- semua asset js dibawah ini -->
    <?php include("../../template/script.php") ?>
    <!-- notifikasi halaman crud ada disini -->
    <?php include("../../template/notifikasi-crud.php") ?>
    <script>
      noRowsTable('tabel');
    </script>
  </body>
</html>

