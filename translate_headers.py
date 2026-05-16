import os
import re

views_dir = '/Users/sastrawangsa/terrasys-property-manager/resources/views'

translations = {
    'Monitor certificates that are nearing their expiration dates.': 'Pantau sertifikat yang masa berlakunya akan segera habis.',
    'Track properties that are currently not in active use.': 'Lacak properti yang saat ini tidak sedang dimanfaatkan.',
    'Analyze property distribution and valuation by region.': 'Analisis distribusi dan valuasi properti berdasarkan wilayah.',
    'Analyze property distribution based on land rights type.': 'Analisis distribusi properti berdasarkan jenis hak tanah.',
    'Visual distribution of your entire property portfolio.': 'Distribusi visual dari seluruh portofolio properti Anda.',
    'Add a new property to your portfolio.': 'Tambahkan data properti baru ke portofolio Anda.',
    'Update information and details of the property.': 'Perbarui informasi dan detail dari properti ini.',
    'Add a new legal certificate for a property.': 'Tambahkan data legalitas/sertifikat baru.',
    'Update information for this certificate.': 'Perbarui informasi untuk sertifikat ini.',
    'Create a new lease contract for a property.': 'Buat kontrak sewa (lease) baru untuk properti.',
    'Modify existing lease contract details.': 'Ubah detail kontrak sewa yang sudah ada.',
    'Upload a new document related to a property.': 'Unggah dokumen baru yang berkaitan dengan properti.',
    'View detailed information about this document.': 'Lihat informasi terperinci mengenai dokumen ini.',
    'Manage secondary or supplementary property certificates.': 'Kelola dokumen atau sertifikat pendukung tambahan.',
    'Add a new supplementary certificate.': 'Tambahkan dokumen pendukung tambahan baru.',
    'Update supplementary certificate details.': 'Perbarui detail dokumen pendukung tambahan.',
    'Create or update system user details.': 'Buat atau perbarui detail akun pengguna.',
    'Configure permissions for this specific role.': 'Konfigurasi hak akses (permissions) untuk peran spesifik ini.',
    'Manage core reference data used across the system.': 'Kelola data referensi inti di seluruh sistem.',
    'Create or update master data entries.': 'Buat atau perbarui entri master data.',
    'Review chronological records of system activities.': 'Tinjau catatan kronologis aktivitas sistem (Audit Trail).',
    'Configure global system parameters and preferences.': 'Konfigurasi pengaturan dan parameter sistem secara global.',
    'View your recent system alerts and updates.': 'Lihat pemberitahuan dan pembaruan sistem terbaru Anda.',
    'Comprehensive view of the property details.': 'Tampilan menyeluruh dari detail dan metrik properti.',
    'Detailed information regarding the certificate.': 'Informasi terperinci mengenai sertifikat terkait.',
    'View complete details of the lease contract.': 'Lihat detail lengkap dari kontrak sewa.',
    "Welcome back, {{ Auth::user()->name }}! Here's what's happening with your properties.": 'Selamat datang kembali, {{ Auth::user()->name }}! Berikut ringkasan aktivitas portofolio Anda.',
    'Manage and track your entire property portfolio.': 'Kelola dan lacak seluruh portofolio properti Anda.',
    'Manage all legal certificates and tracking records.': 'Kelola dan pantau seluruh data sertifikat/legalitas properti.',
    'Manage all your property lease contracts.': 'Kelola semua data kontrak sewa (lease) properti Anda.',
    'Repository for all property-related files.': 'Repositori terpusat untuk semua berkas dan dokumen properti.',
    'Manage system access, roles, and user accounts.': 'Kelola akses sistem, daftar peran, dan akun pengguna.',
    'Manage system roles and access control lists.': 'Kelola peran pengguna dan daftar kontrol akses.',
    'Manage your account settings and preferences.': 'Kelola pengaturan akun dan preferensi profil Anda.',
    'Manage your data and configurations.': 'Kelola data dan konfigurasi Anda.',
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
        print(f"Translated: {os.path.relpath(filepath, views_dir)}")

for root, _, files in os.walk(views_dir):
    for file in files:
        if file.endswith('.blade.php'):
            process_file(os.path.join(root, file))

print("Translation complete.")
