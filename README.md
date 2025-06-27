# 📦 Inventory Management System

Sistem manajemen inventori berbasis web yang dibangun dengan PHP, MySQL, HTML, CSS, dan JavaScript. Sistem ini memungkinkan pengguna untuk mengelola produk dengan fitur CRUD (Create, Read, Update, Delete) lengkap.

![Inventory System](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

## 🚀 **Fitur Utama**

- ✅ **Dashboard Produk** - Tampilan overview semua produk
- ✅ **Tambah Produk** - Form untuk menambah produk baru
- ✅ **Edit Produk** - Update informasi produk existing
- ✅ **Hapus Produk** - Remove produk dari inventory
- ✅ **Search & Filter** - Pencarian dan filter berdasarkan kategori
- ✅ **Statistik Real-time** - Total produk, quantity, dan low stock alert
- ✅ **Export Data** - Export data ke format CSV
- ✅ **Responsive Design** - Tampilan optimal di desktop dan mobile

## 🛠️ **Teknologi yang Digunakan**

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Framework CSS**: Bootstrap 5
- **Icons**: Font Awesome 6
- **Fonts**: Google Fonts (Montserrat)

## 📋 **Persyaratan Sistem**

- **XAMPP** (Apache + MySQL + PHP)
- **Web Browser** (Chrome, Firefox, Safari, Edge)
- **Git** (untuk clone repository)

## 🔧 **Instalasi & Setup**

### **1. Download & Install XAMPP**

1. Download XAMPP dari [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Install XAMPP di komputer Anda
3. Jalankan XAMPP Control Panel
4. Start **Apache** dan **MySQL** services

### **2. Clone Repository**

\`\`\`bash
# Clone repository ke folder htdocs XAMPP
cd C:\xampp\htdocs  # Windows
# atau
cd /Applications/XAMPP/htdocs  # macOS
# atau  
cd /opt/lampp/htdocs  # Linux

# Clone project
git clone https://github.com/Delsapramuditia/Team1_Web_SistemTerdistribusi.git

# Masuk ke folder project
cd Team1_Web_SistemTerdistribusi
\`\`\`

### **3. Setup Database**

#### **Opsi A: Menggunakan phpMyAdmin**
1. Buka browser dan akses: `http://localhost/phpmyadmin`
2. Klik **"New"** untuk membuat database baru
3. Nama database: `inventory_db`
4. Klik **"Create"**
5. Import file SQL:
   - Klik database `inventory_db`
   - Pilih tab **"Import"**
   - Choose file: `scripts/create_database.sql`
   - Klik **"Go"**

#### **Opsi B: Auto Setup (Recommended)**
1. Akses: `http://localhost/Team1_Web_SistemTerdistribusi/test_connection.php`
2. Script akan otomatis membuat database dan tabel
3. Data dummy akan diinsert secara otomatis

### **4. Konfigurasi Database (Opsional)**

Jika perlu mengubah konfigurasi database, edit file `db.php`:

\`\`\`php
$host = 'localhost';     // Database host
$user = 'root';          // Database username  
$pass = '';              // Database password
$dbname = 'inventory_db'; // Database name
\`\`\`

### **5. Akses Aplikasi**

Buka browser dan akses:
\`\`\`
http://localhost/Team1_Web_SistemTerdistribusi/
\`\`\`

## 📁 **Struktur Project**

\`\`\`
Team1_Web_SistemTerdistribusi/
├── 📄 index.html              # Landing page
├── 📄 dashboard.html          # Dashboard utama
├── 📄 add.html               # Form tambah produk
├── 📄 edit.html              # Form edit produk  
├── 📄 delete.html            # Form hapus produk
├── 📄 db.php                 # Konfigurasi database
├── 📄 add.php                # Backend tambah produk
├── 📄 update.php             # Backend update produk
├── 📄 delete.php             # Backend hapus produk
├── 📄 fetch.php              # API fetch data produk
├── 📄 api_fetch.php          # Clean API endpoint
├── 📄 export.php             # Export data ke CSV
├── 📄 stats.php              # API statistik
├── 📄 test_connection.php    # Test koneksi database
├── 📄 fix_database.php       # Fix struktur database
├── 📄 test_api.html          # Test API endpoints
├── 📂 scripts/
│   ├── 📄 create_database.sql # Script SQL database
│   └── 📄 fix_database.sql   # Script fix database
├── 📂 src/
│   └── 🖼️ Logo T1.png        # Logo aplikasi
└── 📄 README.md              # Dokumentasi ini
\`\`\`

## 🎯 **Cara Penggunaan**

### **1. Dashboard**
- Akses `dashboard.html` untuk melihat semua produk
- Gunakan search box untuk mencari produk
- Filter berdasarkan kategori menggunakan dropdown
- Lihat statistik real-time di bagian atas

### **2. Tambah Produk**
- Klik tombol **"Add"** di dashboard
- Isi form: Nama, Kategori, Quantity
- Klik **"Add"** untuk menyimpan

### **3. Edit Produk**
- Aktifkan **"Edit Mode"** di dashboard
- Klik tombol **"Edit"** pada produk yang ingin diubah
- Update informasi produk
- Klik **"Update"** untuk menyimpan

### **4. Hapus Produk**
- **Opsi 1**: Aktifkan "Edit Mode" → klik "Delete" pada produk
- **Opsi 2**: Klik tombol "Remove" → pilih produk dari dropdown

### **5. Export Data**
- Klik tombol **"Export"** di dashboard
- File CSV akan otomatis terdownload

## 🔍 **Testing & Debugging**

### **Test Koneksi Database**
\`\`\`
http://localhost/Team1_Web_SistemTerdistribusi/test_connection.php
\`\`\`

### **Test API Endpoints**
\`\`\`
http://localhost/Team1_Web_SistemTerdistribusi/test_api.html
\`\`\`

### **Fix Database Issues**
\`\`\`
http://localhost/Team1_Web_SistemTerdistribusi/fix_database.php
\`\`\`

## 🐛 **Troubleshooting**

### **Problem: Database tidak connect**
**Solusi:**
1. Pastikan XAMPP Apache & MySQL running
2. Check konfigurasi di `db.php`
3. Jalankan `test_connection.php`

### **Problem: JSON parse error**
**Solusi:**
1. Gunakan `api_fetch.php` instead of `fetch.php`
2. Check `test_api.html` untuk debugging

### **Problem: File tidak ditemukan**
**Solusi:**
1. Pastikan project di folder `htdocs`
2. Akses via `http://localhost/` bukan `file://`

### **Problem: Permission denied**
**Solusi:**
1. **Windows**: Run XAMPP as Administrator
2. **Linux/macOS**: Check folder permissions

## 👥 **Tim Pengembang**

- **Team**: T1 Team
- **Project**: Sistem Terdistribusi
- **Repository**: [Team1_Web_SistemTerdistribusi](https://github.com/Delsapramuditia/Team1_Web_SistemTerdistribusi)

## 📝 **Changelog**

### **v1.0.0** (2025-06-25)
- ✅ Initial release
- ✅ CRUD functionality
- ✅ Search & filter
- ✅ Export to CSV
- ✅ Responsive design
- ✅ Real-time statistics

## 📄 **License**

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 **Contributing**

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📞 **Support**

Jika ada pertanyaan atau issue, silakan:
- Buat [GitHub Issue](https://github.com/Delsapramuditia/Team1_Web_SistemTerdistribusi/issues)
- Contact team melalui repository

---

**Happy Coding! 🚀**
