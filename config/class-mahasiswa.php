<?php 

// Memasukkan file konfigurasi database
include_once 'db-config.php';

class Mahasiswa extends Database {

    // Method untuk input data mahasiswa
    public function inputBuku($data){
        // Mengambil data dari parameter $data
        $idbuku      = $data['id_buku'];
        $ISBN     = $data['ISBN'];
        $judulbuku     = $data['judul_buku'];
        $tahun    = $data['tahun'];
        $alamat   = $data['alamat'];
        $kategori = $data['kategori'];
        $email    = $data['email'];
        $telp     = $data['telp'];
        $status   = $data['status'];
        // Menyiapkan query SQL untuk insert data menggunakan prepared statement
        $query = "INSERT INTO tb_buku (id_buku, ISBN, judul_buku, tahun, alamat, kategori, email, telp, status_mhs) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        // Mengecek apakah statement berhasil disiapkan
        if(!$stmt){
            return false;
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("ssssssss", $idbuku, $ISBN, $judulbuku, $tahun, $alamat, $kategori, $email, $telp, $status);
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk mengambil semua data mahasiswa
    public function getAllBuku(){
        // Menyiapkan query SQL untuk mengambil data mahasiswa beserta prodi dan provinsi
        $query = "SELECT id_buku, ISBN, judul_buku, tahun, kategori, alamat, email, telp, status_mhs 
                  FROM tb_buku
                  JOIN tb_tahun ON tahun = kode_tahun
                  JOIN tb_kategori ON kategori_buku = id_kategori";
        $result = $this->conn->query($query);
        // Menyiapkan array kosong untuk menyimpan data mahasiswa
        $mahasiswa = [];
        // Mengecek apakah ada data yang ditemukan
        if($result->num_rows > 0){
            // Mengambil setiap baris data dan memasukkannya ke dalam array
            while($row = $result->fetch_assoc()) {
                $mahasiswa[] = [
                    'id' => $row['id_buku'],
                    'ISBN' => $row['ISBN'],
                    'judul' => $row['judul_buku'],
                    'tahun' => $row['tahun'],
                    'kategori' => $row['kategori'],
                    'alamat' => $row['alamat'],
                    'email' => $row['email'],
                    'telp' => $row['telp'],
                    'status' => $row['status_mhs']
                ];
            }
        }
        // Mengembalikan array data mahasiswa
        return $mahasiswa;
    }

    // Method untuk mengambil data mahasiswa berdasarkan ID
    public function getUpdateBuku($id){
        // Menyiapkan query SQL untuk mengambil data mahasiswa berdasarkan ID menggunakan prepared statement
        $query = "SELECT * FROM tb_buku WHERE id_buku = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = false;
        if($result->num_rows > 0){
            // Mengambil data mahasiswa  
            $row = $result->fetch_assoc();
            // Menyimpan data dalam array
            $data = [
                'id' => $row['id_buku'],
                'ISBN' => $row['ISBN'],
                'judul' => $row['judul_buku'],
                'tahun' => $row['tahun'],
                'alamat' => $row['alamat'],
                'kategori' => $row['kategori'],
                'email' => $row['email'],
                'telp' => $row['telp'],
                'status' => $row['status_mhs']
            ];
        }
        $stmt->close();
        // Mengembalikan data mahasiswa
        return $data;
    }

    // Method untuk mengedit data mahasiswa
    public function editMahasiswa($data){
        // Mengambil data dari parameter $data
        $id       = $data['id'];
        $ISBN      = $data['ISBN'];
        $judul     = $data['judul_buku'];
        $tahun    = $data['tahun'];
        $alamat   = $data['alamat'];
        $kategori = $data['kategori'];
        $email    = $data['email'];
        $telp     = $data['telp'];
        $status   = $data['status'];
        // Menyiapkan query SQL untuk update data menggunakan prepared statement
        $query = "UPDATE tb_buku SET nim_mhs = ?, nama_mhs = ?, prodi_mhs = ?, alamat = ?, provinsi = ?, email = ?, telp = ?, status_mhs = ? WHERE id_mhs = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("ssssssssi", $nim, $nama, $prodi, $alamat, $provinsi, $email, $telp, $status, $id);
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk menghapus data mahasiswa
    public function deleteMahasiswa($id){
        // Menyiapkan query SQL untuk delete data menggunakan prepared statement
        $query = "DELETE FROM tb_mahasiswa WHERE id_mhs = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk mencari data mahasiswa berdasarkan kata kunci
    public function searchMahasiswa($kataKunci){
        // Menyiapkan LIKE query untuk pencarian
        $likeQuery = "%".$kataKunci."%";
        // Menyiapkan query SQL untuk pencarian data mahasiswa menggunakan prepared statement
        $query = "SELECT id_mhs, nim_mhs, nama_mhs, nama_prodi, nama_provinsi, alamat, email, telp, status_mhs 
                  FROM tb_mahasiswa
                  JOIN tb_prodi ON prodi_mhs = kode_prodi
                  JOIN tb_provinsi ON provinsi = id_provinsi
                  WHERE nim_mhs LIKE ? OR nama_mhs LIKE ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            // Mengembalikan array kosong jika statement gagal disiapkan
            return [];
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("ss", $likeQuery, $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        // Menyiapkan array kosong untuk menyimpan data mahasiswa
        $mahasiswa = [];
        if($result->num_rows > 0){
            // Mengambil setiap baris data dan memasukkannya ke dalam array
            while($row = $result->fetch_assoc()) {
                // Menyimpan data mahasiswa dalam array
                $mahasiswa[] = [
                    'id' => $row['id_mhs'],
                    'nim' => $row['nim_mhs'],
                    'nama' => $row['nama_mhs'],
                    'prodi' => $row['nama_prodi'],
                    'provinsi' => $row['nama_provinsi'],
                    'alamat' => $row['alamat'],
                    'email' => $row['email'],
                    'telp' => $row['telp'],
                    'status' => $row['status_mhs']
                ];
            }
        }
        $stmt->close();
        // Mengembalikan array data mahasiswa yang ditemukan
        return $mahasiswa;
    }

}

?>