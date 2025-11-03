<?php 

// Memasukkan file konfigurasi database
include_once 'db-config.php';

class Buku extends Database {

    // Method untuk input data buku
    public function inputBuku($data){
        // Mengambil data dari parameter $data
        $ISBN         = $data['ISBN'];
        $judul_buku   = $data['judul_buku'];
        $tahun        = $data['tahun'];
        $penerbit     = $data['penerbit'];
        $kategori     = $data['kategori'];
        $email        = $data['email'];
        $telp         = $data['telp'];
        // Menyiapkan query SQL untuk insert data menggunakan prepared statement
        $query = "INSERT INTO tb_buku (ISBN, judul_buku, tahun, nama_penerbit, kategori_buku, email, telp ) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        // Mengecek apakah statement berhasil disiapkan
        if(!$stmt){
            return false;
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("sssssss",  $ISBN, $judul_buku, $tahun, $penerbit, $kategori, $email, $telp );
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk mengambil semua data buku
    public function getAllBuku(){
        // Menyiapkan query SQL untuk mengambil data buku beserta tahun dan kategori buku
        $query = "SELECT id_buku, ISBN, judul_buku, tahun, nama_penerbit, tb_kategori.kategori_buku, email, telp  
                  FROM tb_buku
                  JOIN tb_tahun ON tahun = kode_tahun
                  JOIN tb_kategori ON tb_buku.kategori_buku = id_kategori";
        $result = $this->conn->query($query);
        // Menyiapkan array kosong untuk menyimpan data buku
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
                    'penerbit' => $row['nama_penerbit'],
                    'kategori' => $row['kategori_buku'],
                    'email' => $row['email'],
                    'telp' => $row['telp']
                ];
            }
        }
        // Mengembalikan array data buku
        return $buku;
    }

    // Method untuk mengambil data buku berdasarkan ID
    public function getUpdateBuku($id){
        // Menyiapkan query SQL untuk mengambil data buku berdasarkan ID menggunakan prepared statement
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
            // Mengambil data buku  
            $row = $result->fetch_assoc();
            // Menyimpan data dalam array
            $data = [
                'id_buku' => $row['id_buku'],
                'ISBN' => $row['ISBN'],
                'judul_buku' => $row['judul_buku'],
                'tahun' => $row['tahun'],
                'penerbit' => $row['nama_penerbit'],
                'kategori' => $row['kategori_buku'],
                'email' => $row['email'],
                'telp' => $row['telp']
            ];
        }
        $stmt->close();
        // Mengembalikan data buku
        return $data;
    }

    // Method untuk mengedit data buku
    public function editBuku($data){
        // Mengambil data dari parameter $data
        $id_buku        = $data['id_buku'];
        $ISBN           = $data['ISBN'];
        $judul_buku     = $data['judul'];
        $tahun          = $data['tahun'];
        $penerbit     = $data['penerbit'];
        $kategori       = $data['kategori'];
        $email          = $data['email'];
        $telp           = $data['telp'];
        // Menyiapkan query SQL untuk update data menggunakan prepared statement
        $query = "UPDATE tb_buku SET  ISBN = ?, judul_buku = ?, tahun = ?, nama_penerbit = ?, kategori_buku = ?, email = ?, telp = ?  WHERE id_buku = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("sssssssi", $ISBN, $judul_buku,   $tahun, $penerbit, $kategori, $email, $telp, $id_buku );
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk menghapus data buku
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

    // Method untuk mencari data buku berdasarkan kata kunci
    public function searchBuku($kataKunci){
        // Menyiapkan LIKE query untuk pencarian
        $likeQuery = "%".$kataKunci."%";
        // Menyiapkan query SQL untuk pencarian data buku menggunakan prepared statement
        $query = "SELECT id_buku, judul_buku, ISBN, tahun, nama_penerbit, tb_kategori.kategori_buku, email, telp
                  FROM tb_buku
                  JOIN tb_tahun ON tahun = kode_tahun
                  JOIN tb_kategori ON tb_buku.kategori_buku = id_kategori
                  WHERE judul_buku LIKE ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            // Mengembalikan array kosong jika statement gagal disiapkan
            return [];
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("s", $likeQuery);
        $stmt->execute();
        $result = $stmt->get_result();
        // Menyiapkan array kosong untuk menyimpan data buku
        $buku = [];
        if($result->num_rows > 0){
            // Mengambil setiap baris data dan memasukkannya ke dalam array
            while($row = $result->fetch_assoc()) {
                // Menyimpan data buku dalam array
                $buku[] = [
                    'id_buku' => $row['id_buku'],
                    'ISBN' => $row['ISBN'],
                    'judul_buku' => $row['judul_buku'],
                    'tahun' => $row['tahun'],
                    'penerbit' => $row['nama_penerbit'],
                    'kategori' => $row['kategori_buku'],
                    'email' => $row['email'],
                    'telp' => $row['telp']
                ];
            }
        }
        $stmt->close();
        // Mengembalikan array data buku yang ditemukan
        return $buku;
    }

}

?>