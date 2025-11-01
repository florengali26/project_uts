<?php 

// Memasukkan file konfigurasi database
include_once 'db-config.php';

class Buku extends Database {

    // Method untuk input data mahasiswa
    public function inputBuku($data){
        // Mengambil data dari parameter $data
        $id_buku      = $data['id_buku'];
        $ISBN         = $data['ISBN'];
        $judul_buku   = $data['judul_buku'];
        $tahun        = $data['tahun'];
        $alamat       = $data['alamat'];
        $kategori     = $data['kategori'];
        $email        = $data['email'];
        $telp         = $data['telp'];
        // Menyiapkan query SQL untuk insert data menggunakan prepared statement
        $query = "INSERT INTO tb_buku (id_buku, ISBN, judul_buku, tahun, alamat, kategori, email, telp ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        // Mengecek apakah statement berhasil disiapkan
        if(!$stmt){
            return false;
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("ssssssss", $id_buku, $ISBN, $judul_buku, $tahun, $alamat, $kategori, $email, $telp );
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk mengambil semua data mahasiswa
    public function getAllBuku(){
        // Menyiapkan query SQL untuk mengambil data mahasiswa beserta prodi dan provinsi
        $query = "SELECT id_buku, ISBN, judul_buku, tahun, kategori, alamat, email, telp  
                  FROM tb_buku
                  JOIN tb_tahun ON tahun = kode_tahun
                  JOIN tb_kategori ON kategori_buku = id_buku";
        $result = $this->conn->query($query);
        // Menyiapkan array kosong untuk menyimpan data mahasiswa
        $buku = [];
        // Mengecek apakah ada data yang ditemukan
        if($result->num_rows > 0){
            // Mengambil setiap baris data dan memasukkannya ke dalam array
            while($row = $result->fetch_assoc()) {
                $buku[] = [
                    'id_buku' => $row['id_buku'],
                    'ISBN' => $row['ISBN'],
                    'judul_buku' => $row['judul_buku'],
                    'tahun' => $row['tahun'],
                    'kategori' => $row['kategori'],
                    'alamat' => $row['alamat'],
                    'email' => $row['email'],
                    'telp' => $row['telp']
                ];
            }
        }
        // Mengembalikan array data mahasiswa
        return $buku;
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
                'id_buku' => $row['id_buku'],
                'ISBN' => $row['ISBN'],
                'judul_buku' => $row['judul_buku'],
                'tahun' => $row['tahun'],
                'alamat' => $row['alamat'],
                'kategori' => $row['kategori'],
                'email' => $row['email'],
                'telp' => $row['telp']
            ];
        }
        $stmt->close();
        // Mengembalikan data mahasiswa
        return $data;
    }

    // Method untuk mengedit data mahasiswa
    public function editBuku($data){
        // Mengambil data dari parameter $data
        $id_buku       = $data['id_buku'];
        $ISBN      = $data['ISBN'];
        $judul_buku     = $data['judul_buku'];
        $tahun    = $data['tahun'];
        $alamat   = $data['alamat'];
        $kategori = $data['kategori'];
        $email    = $data['email'];
        $telp     = $data['telp'];
        // Menyiapkan query SQL untuk update data menggunakan prepared statement
        $query = "UPDATE tb_buku SET  ISBN = ?, judul_buku = ?, tahun = ?, alamat = ?, kategori = ?, email = ?, telp = ?,  WHERE id_buku = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("ssssssssi", $id_buku, $judul_buku,  $ISBN, $tahun, $alamat, $kategori, $email, $telp );
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk menghapus data mahasiswa
    public function deleteBuku($id){
        // Menyiapkan query SQL untuk delete data menggunakan prepared statement
        $query = "DELETE FROM tb_buku WHERE id_buku = ?";
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
    public function searchBuku($kataKunci){
        // Menyiapkan LIKE query untuk pencarian
        $likeQuery = "%".$kataKunci."%";
        // Menyiapkan query SQL untuk pencarian data mahasiswa menggunakan prepared statement
        $query = "SELECT id_buku, judul_buku, ISBN, tahun, alamat, kategori, email, telp
                  FROM tb_buku
                  JOIN tb_tahun ON nama_tahun = kode_tahun
                  JOIN tb_kategori ON kategori_buku = id_buku
                  WHERE id_buku LIKE ? OR judul_buku LIKE ?";
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
        $buku = [];
        if($result->num_rows > 0){
            // Mengambil setiap baris data dan memasukkannya ke dalam array
            while($row = $result->fetch_assoc()) {
                // Menyimpan data mahasiswa dalam array
                $buku[] = [
                    'id_buku' => $row['id_buku'],
                    'ISBN' => $row['ISBN'],
                    'judul_buku' => $row['judul_buku'],
                    'kategori' => $row['kategori'],
                    'alamat' => $row['alamat'],
                    'email' => $row['email'],
                    'telp' => $row['telp']
                ];
            }
        }
        $stmt->close();
        // Mengembalikan array data mahasiswa yang ditemukan
        return $buku;
    }

}

?>