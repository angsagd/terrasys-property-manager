import os

views_dir = '/Users/sastrawangsa/terrasys-property-manager/resources/views'

translations = {
    # Sidebar
    '>Dashboard<': '>Dasbor<',
    '>Properties<': '>Properti<',
    '>Certificates<': '>Sertifikat<',
    '>Leases<': '>Kontrak Sewa<',
    '>Documents<': '>Dokumen<',
    '>Reports<': '>Laporan<',
    '>Map<': '>Peta<',
    '>Main Menu<': '>Menu Utama<',
    '>Administration<': '>Administrasi<',
    '>Admin Area<': '>Area Admin<',
    '>Profile<': '>Profil<',
    '>Log Out<': '>Keluar<',

    # Headers & Titles
    '>New Property<': '>Properti Baru<',
    '>Edit Property<': '>Ubah Properti<',
    '>Property Management<': '>Manajemen Properti<',
    '>User Management<': '>Manajemen Pengguna<',
    '>Add User<': '>Pengguna Baru<',
    '>Roles & Permissions<': '>Peran & Hak Akses<',
    '>Permission Matrix<': '>Matriks Hak Akses<',
    '>Property Distribution Map<': '>Peta Distribusi Properti<',
    '>Lease Management<': '>Manajemen Sewa<',
    '>New Lease<': '>Kontrak Baru<',
    '>Upload Document<': '>Unggah Dokumen<',
    '>Audit Trail<': '>Jejak Audit<',

    # Table Headers & Labels
    '>Property Details<': '>Detail Properti<',
    '>Location<': '>Lokasi<',
    '>Status<': '>Status<',
    '>User Info<': '>Info Pengguna<',
    '>Roles<': '>Peran<',
    '>Last Login<': '>Terakhir Masuk<',
    '>Action<': '>Aksi<',
    '>Actions<': '>Aksi<',
    '>Expired<': '>Kedaluwarsa<',
    '>Download<': '>Unduh<',
    '>Total Property<': '>Total Properti<',
    '>Total Sertifikat<': '>Total Sertifikat<',
    '>Luas Tanah<': '>Luas Tanah<',
    '>Nilai Sewa<': '>Nilai Sewa<',
    '>Overview<': '>Ikhtisar<',
    '>Detail Data<': '>Data Detail<',
    '>Sertifikat<': '>Sertifikat<',
    '>Dokumen Tambahan<': '>Dokumen Tambahan<',
    '>Lease<': '>Sewa<',
    '>Files<': '>Berkas<',
    '>Peta<': '>Peta<',
    '>Log Aktivitas<': '>Log Aktivitas<',

    # Buttons & Inputs
    'placeholder="Search name or email..."': 'placeholder="Cari nama atau email..."',
    'placeholder="Search property name, code, or city..."': 'placeholder="Cari nama properti, kode, atau kota..."',
    '>All Roles<': '>Semua Peran<',
    '>All Statuses<': '>Semua Status<',
    '>All Types<': '>Semua Jenis<',
    '>Filter<': '>Saring<',
    '>Reset<': '>Atur Ulang<',
    '>Active<': '>Aktif<',
    '>Inactive<': '>Nonaktif<',
    '>Save<': '>Simpan<',
    '>Cancel<': '>Batal<',
    '>Batal<': '>Batal<',
    '>Simpan<': '>Simpan<',

    # Alerts & Dashboard
    '>Recent Properties<': '>Properti Terbaru<',
    '>View all &rarr;<': '>Lihat semua &rarr;<',
    '>Key Alerts<': '>Peringatan Utama<',
    '>Sertifikat Expired<': '>Sertifikat Kedaluwarsa<',
    '>Lease Expired<': '>Sewa Kedaluwarsa<',
    '>Dokumen Expired<': '>Dokumen Kedaluwarsa<',
    '>Property Idle<': '>Properti Menganggur<',
    '>Aset per Provinsi<': '>Aset per Provinsi<',

    # Empty States
    '>No properties found<': '>Properti tidak ditemukan<',
    '>No users found<': '>Pengguna tidak ditemukan<',

    # Auth
    '>Email address<': '>Alamat Email<',
    '>Password<': '>Kata Sandi<',
    '>Forgot password?<': '>Lupa kata sandi?<',
    '>Remember me<': '>Ingat saya<',
    '>Sign in to account<': '>Masuk ke akun<',

    # Misc
    '>active permissions<': '>hak akses aktif<',
    'more<': 'lainnya<',
    '>Expired Date<': '>Tgl. Kedaluwarsa<',
    '>Informasi Property<': '>Informasi Properti<',
    '>Jenis Property<': '>Jenis Properti<',
    '>Detail Property<': '>Detail Properti<',
    '>Nama Property<': '>Nama Properti<',
    '>Property<': '>Properti<',
}

def process_file(filepath):
    with open(filepath, 'r') as f:
        content = f.read()

    original_content = content
    
    for eng, ind in translations.items():
        if eng in content:
            content = content.replace(eng, ind)
            
    if content != original_content:
        with open(filepath, 'w') as f:
            f.write(content)
        print(f"Translated UI in: {os.path.relpath(filepath, views_dir)}")

for root, _, files in os.walk(views_dir):
    for file in files:
        if file.endswith('.blade.php'):
            process_file(os.path.join(root, file))

print("UI Translation complete.")
