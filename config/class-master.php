<?php

// Memasukkan file konfigurasi database
include_once 'db-config.php';

class MasterData extends Database {

    // Method untuk mendapatkan daftar tahun terbit buku
    public function getTahun(){
        $query = "SELECT * FROM tb_tahun";
        $result = $this->conn->query($query);
        $tahun = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $tahun[] = [
                    'id' => $row['kode_tahun'],
                    'nama' => $row['nama_tahun']
                ];
            }
        }
        return $tahun;
    }

    // Method untuk mendapatkan daftar kategori
    public function getKategori(){
        $query = "SELECT * FROM tb_kategori";
        $result = $this->conn->query($query);
        $kategori = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $kategori[] = [
                    'id' => $row['id_kategori'],
                    'nama' => $row['kategori_buku']
                ];
            }
        }
        return $kategori;
    }

    // Method untuk input data tahun
    public function inputtahun($data){
        $kodetahun = $data['kode'];
        $namatahun = $data['nama'];
        $query = "INSERT INTO tb_tahun (kode_tahun, nama_tahun) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("ss", $kodetahun, $namatahun);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk mendapatkan data tahun terbit berdasarkan kode
    public function getUpdatetahun($id){
        $query = "SELECT * FROM tb_tahun WHERE kode_tahun = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $tahun = null;
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $tahun = [
                'id' => $row['kode_tahun'],
                'nama' => $row['nama_tahun']
            ];
        }
        $stmt->close();
        return $tahun;
    }

    // Method untuk mengedit data tahun terbit
    public function updatetahun($data){
        $kodetahun = $data['kode'];
        $namatahun = $data['nama'];
        $query = "UPDATE tb_tahun SET nama_tahun = ? WHERE kode_tahun = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("ss", $namatahun, $kodetahun);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk menghapus data tahun terbit
    public function deletetahun($id){
        $query = "DELETE FROM tb_tahun WHERE kode_tahun = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk input data kategori buku
    public function inputKategori($data){
        $namakategori = $data['nama'];
        $query = "INSERT INTO tb_kategori (kategori_buku) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("s", $namakategori);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk mendapatkan data kategori berdasarkan id buku
    public function getUpdateKategori($id){
        $query = "SELECT * FROM tb_kategori WHERE id_kategori = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $provinsi = null;
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $kategori = [
                'id' => $row['id_kategori'],
                'nama' => $row['kategori_buku']
            ];
        }
        $stmt->close();
        return $kategori;
    }

    // Method untuk mengedit data kategori buku
    public function updateKategori($data){
        $idkategori = $data['id'];
        $namakategori = $data['nama'];
        $query = "UPDATE tb_kategori SET kategori_buku = ? WHERE id_kategori = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("si", $kategori, $id_kategori);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk menghapus data kategori buku
    public function deleteKategori($id){
        $query = "DELETE FROM tb_kategori WHERE id_kategori = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

}

?>