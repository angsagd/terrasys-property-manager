import os
import re

views_dir = '/Users/sastrawangsa/terrasys-property-manager/resources/views'

translations = {
    # Buttons & Actions
    '>Save<': '>Simpan<',
    '>Update<': '>Perbarui<',
    '>Delete<': '>Hapus<',
    '>Remove<': '>Hapus<',
    '>Cancel<': '>Batal<',
    '>Submit<': '>Kirim<',
    '>Create<': '>Buat<',
    '>Add<': '>Tambah<',
    '>Edit<': '>Ubah<',
    '>View<': '>Lihat<',
    '>Search<': '>Cari<',
    '>Filter<': '>Saring<',
    '>Reset<': '>Atur Ulang<',
    '>Upload<': '>Unggah<',
    '>Download<': '>Unduh<',
    '>Back<': '>Kembali<',
    '>Next<': '>Berikutnya<',
    '>Previous<': '>Sebelumnya<',
    '>Confirm<': '>Konfirmasi<',

    # Table Headers & Form Labels
    '>Name<': '>Nama<',
    '>Type<': '>Jenis<',
    '>Status<': '>Status<',
    '>Date<': '>Tanggal<',
    '>Created At<': '>Dibuat Pada<',
    '>Updated At<': '>Diperbarui Pada<',
    '>Description<': '>Deskripsi<',
    '>Notes<': '>Catatan<',
    '>Actions<': '>Aksi<',
    '>Action<': '>Aksi<',
    '>Details<': '>Detail<',
    '>User<': '>Pengguna<',
    '>Role<': '>Peran<',
    '>Email<': '>Email<',
    '>Password<': '>Kata Sandi<',

    # Statuses & Common Terms
    '>Active<': '>Aktif<',
    '>Inactive<': '>Nonaktif<',
    '>Pending<': '>Tertunda<',
    '>Approved<': '>Disetujui<',
    '>Rejected<': '>Ditolak<',
    '>Expired<': '>Kedaluwarsa<',
    '>Valid<': '>Berlaku<',
    '>Total<': '>Total<',
    '>All<': '>Semua<',
    '>None<': '>Tidak Ada<',

    # Specific Phrases
    '>Are you sure you want to delete this?<': '>Apakah Anda yakin ingin menghapus data ini?<',
    '>Yes, delete it<': '>Ya, hapus<',
    '>No, cancel<': '>Tidak, batal<',
    '>No data available<': '>Tidak ada data yang tersedia<',
    '>Search...<': '>Cari...<',
    '>Select an option<': '>Pilih salah satu<',

    # Layout & Navigation
    '>Notifications<': '>Pemberitahuan<',
    '>Settings<': '>Pengaturan<',
    '>System Settings<': '>Pengaturan Sistem<',
    '>Profile<': '>Profil<',
    '>Log Out<': '>Keluar<',
    '>Dashboard<': '>Dasbor<',

    # Dashboard & Widgets
    '>Recent Activity<': '>Aktivitas Terbaru<',
    '>Overview<': '>Ikhtisar<',
    '>Metrics<': '>Metrik<',
    '>Quick Stats<': '>Statistik Singkat<',
    
    # Specific attributes
    'placeholder="Search"': 'placeholder="Cari"',
    'placeholder="Search..."': 'placeholder="Cari..."',
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
        print(f"Translated terms in: {os.path.relpath(filepath, views_dir)}")

for root, _, files in os.walk(views_dir):
    for file in files:
        if file.endswith('.blade.php'):
            process_file(os.path.join(root, file))

print("Comprehensive UI Translation complete.")
