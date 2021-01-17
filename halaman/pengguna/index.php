<?php
  session_start();
  require_once("../../vendor/autoload.php");
  require_once("../../pengaturan/pengaturan.php");
  require_once("../../pengaturan/database.php");
  
  $judul = "Data Pengguna";  
  $daftar_pengguna = $db->query("SELECT * FROM pengguna")->fetchAll(PDO::FETCH_ASSOC);
  
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
                
                <!-- Bagian form tambah data -->
                <form method="POST" id="tambahData" action="proses-tambah.php" style="display: none;">
                  <input type="hidden" value="" name="kd_pengguna" />
                  <div class="card">
                    <div class="card-header">
                      <div class="card-title" id="judulForm">Data Pengguna Baru</div>
                    </div>
                    <div class="card-body">
                      <div class="form-group">
                        <label for="nm_pengguna">Nama Pengguna</label>
                        <input type="text" class="form-control" name="nm_pengguna">
                      </div>
                      <div class="form-group">
                        <label for="nohp">Username</label>
                        <input type="text" class="form-control" name="username">
                      </div>
                      <div class="form-group">
                        <label for="alamat">Password</label>
                        <input type="password" class="form-control" name="password">
                      </div>
                      <div class="form-group">
                        <label for="alamat">Jenis Pengguna</label>
                        <select name="jenis_pengguna" class="form-control">
                          <option value="Admin">Admin</option>
                          <option value="Karyawan Gudang">Karyawan Gudang</option>
                          <option value="Pimpinan">Pimpinan</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="alamat">NOHP</label>
                        <input type="text" class="form-control" name="nohp">
                      </div>
                      <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" name="alamat">
                      </div>
                    </div>
                    <div class="card-action">
                      <button type="submit" class="btn btn-success">Simpan</button>
                      <button type="reset" class="btn btn-danger">Reset</button>
                      <button type="button" class="btn btn-primary" onclick="showPage()">Kembali</button>
                    </div>
                  </div>
                </form>
                <!-- Akhir dari Bagian form tambah data -->
                
                <!-- Bagian tabel -->
                <div class="card" id="daftarData" style="display: block;">
                  <div class="card-header">
                    <div class="card-title">Daftar Pengguna</div>
                  </div>
                  <div class="card-body">
                    <button type="button" class="btn btn-primary" onclick="showPage()">+ Data Baru</button>
                    <div class="table-responsive">
											<table id="tabel" class="table table-bordered table-head-bg-primary mt-4">
												<thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Pengguna</th>
                            <th>Username</th>
                            <th>Jenis Pengguna</th>
                            <th>NOHP</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                            $no = 1;
                            foreach($daftar_pengguna as $i=>$d):
                          ?>
                            <tr>
                              <td><?=$no?></td>
                              <td><?=$d['nm_pengguna']?></td>
                              <td><?=$d['username']?></td>
                              <td><?=$d['jenis_pengguna']?></td>
                              <td><?=$d['nohp']?></td>
                              <td><?=$d['alamat']?></td>
                              <td>
                                <div class="form-group">
                                  <button type="button" class="btn btn-primary" onclick="editPage(<?=$i?>)">Edit</button>
                                  <a href="proses-hapus.php?kd_pengguna=<?=$d['kd_pengguna']?>" class="btn btn-danger">Hapus</a>
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
      var data_detail = <?=json_encode($daftar_pengguna)?>;
      
      // memmunculkan form tambah data dan daftar data dengan javascript.
      function showPage()
      {
        var tambahData = document.getElementById('tambahData');
        var daftarData = document.getElementById('daftarData');
        if(tambahData.style.display == 'block')
        {
          tambahData.style.display = 'none';
          daftarData.style.display = 'block';
          
          // Mereset form menjadi form tambah data
          document.getElementById("judulForm").innerHTML = "Data Pengguna Baru";
          document.getElementById('tambahData').action = "proses-tambah.php"; 
          document.getElementsByName('nm_pengguna')[0].value = ""; 
          document.getElementsByName('username')[0].value = ""; 
          document.getElementsByName('alamat')[0].value = ""; 
          document.getElementsByName('nohp')[0].value = ""; 
          document.getElementsByName('jenis_pengguna')[0].value = ""; 
          document.getElementsByName('kd_pengguna')[0].value = ""; 
        }
        else
        {
          tambahData.style.display = 'block';
          daftarData.style.display = 'none';
        }
      }
      function editPage(id)
      {
        showPage();
        if(document.getElementById('tambahData').action = "proses-tambah.php")
        {
          
          // Mengubah form tambah jadi edit
          document.getElementById("judulForm").innerHTML = "Edit Data Pengguna";
          document.getElementById('tambahData').action = "proses-edit.php";
          
          // Memasukkan nilai yang ingin diedit kedalam form
          document.getElementsByName('nm_pengguna')[0].value = data_detail[id].nm_pengguna; 
          document.getElementsByName('username')[0].value = data_detail[id].username; 
          document.getElementsByName('alamat')[0].value = data_detail[id].alamat; 
          document.getElementsByName('nohp')[0].value = data_detail[id].nohp; 
          document.getElementsByName('jenis_pengguna')[0].value = data_detail[id].jenis_pengguna; 
          document.getElementsByName('kd_pengguna')[0].value = data_detail[id].kd_pengguna; 
        }
      }
      noRowsTable('tabel');
    </script>
  </body>
</html>
