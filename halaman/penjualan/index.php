<?php
  session_start();
  require_once("../../vendor/autoload.php");
  require_once("../../pengaturan/pengaturan.php");
  require_once("../../pengaturan/database.php");
  require_once("../../pengaturan/helper.php");
  
  $judul = "Data Penjualan";  
  $daftar_penjualan = $db->query("SELECT a.*, b.nm_pelanggan FROM penjualan a JOIN pelanggan b ON a.kd_pelanggan = b.kd_pelanggan")->fetchAll(PDO::FETCH_ASSOC);
  
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
            
            <!-- AWAL DARI BAGIAN KONTEN --> 
                
                <!-- Bagian tabel -->
                <div class="card" id="daftarData" style="display: block;">
                  <div class="card-header">
                    <div class="card-title">Daftar Penjualan</div>
                  </div>
                  <div class="card-body">
                    <a href="tambah.php" class="btn btn-primary">+ Data Baru</a>
                    <div class="table-responsive">
											<table id="tabel" class="table table-bordered table-head-bg-primary mt-4">
												<thead>
                          <tr>
                            <th>No</th>
                            <th>Kode Penjualan</th>
                            <th>Tanggal Penjualan</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no = 1;
                            foreach($daftar_penjualan as $i=>$d):
                          ?>
                            <tr>
                              <td><?=$no?></td>
                              <td><?=$d['kd_penjualan']?></td>
                              <td><?=tanggal_indo($d['tgl_penjualan'])?></td>
                              <td><?=$d['nm_pelanggan']?></td>
                              <td><?=$d['total_hrg']?></td>
                              <td>
                                <div class="form-group">
                                  <a href="proses-hapus.php?kd_penjualan=<?=$d['kd_penjualan']?>" class="btn btn-danger">Hapus</a>
                                  <a href="detail.php?kd_penjualan=<?=$d['kd_penjualan']?>" class="btn btn-success">Detail</a>
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
