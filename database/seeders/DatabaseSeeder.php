<?php

namespace Database\Seeders;

use App\Models\CertificateStatus;
use App\Models\City;
use App\Models\DocumentCategory;
use App\Models\LandRightType;
use App\Models\LeaseStatus;
use App\Models\LeaseType;
use App\Models\PropertyType;
use App\Models\PropertyUtilizationStatus;
use App\Models\Province;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $permissions = [
            'view_dashboard',
            'view_property', 'create_property', 'update_property', 'delete_property', 'restore_property',
            'view_certificate', 'create_certificate', 'update_certificate', 'delete_certificate',
            'view_additional_certificate', 'create_additional_certificate', 'update_additional_certificate', 'delete_additional_certificate',
            'view_lease', 'create_lease', 'update_lease', 'delete_lease',
            'view_document', 'upload_document', 'update_document', 'delete_document', 'download_document',
            'view_map', 'view_report', 'export_report',
            'view_notification', 'manage_notification',
            'view_master_data', 'create_master_data', 'update_master_data', 'delete_master_data',
            'view_user', 'create_user', 'update_user', 'delete_user',
            'view_role', 'create_role', 'update_role', 'delete_role',
            'view_system_setting', 'update_system_setting', 'view_audit_log',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $propertyManager = Role::firstOrCreate(['name' => 'Property Manager', 'guard_name' => 'web']);
        $viewer = Role::firstOrCreate(['name' => 'Viewer', 'guard_name' => 'web']);

        $superAdmin->syncPermissions($permissions);
        $propertyManager->syncPermissions([
            'view_dashboard',
            'view_property', 'create_property', 'update_property',
            'view_certificate', 'create_certificate', 'update_certificate',
            'view_additional_certificate', 'create_additional_certificate', 'update_additional_certificate', 'delete_additional_certificate',
            'view_lease', 'create_lease', 'update_lease',
            'view_document', 'upload_document', 'update_document', 'download_document',
            'view_map', 'view_report', 'export_report',
            'view_notification', 'manage_notification',
            'view_master_data', 'view_audit_log',
        ]);
        $viewer->syncPermissions([
            'view_dashboard', 'view_property', 'view_certificate', 'view_additional_certificate',
            'view_lease', 'view_document', 'download_document', 'view_map', 'view_report', 'view_notification',
        ]);

        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $user->assignRole($superAdmin);

        foreach (['Tanah Kosong', 'Bangunan', 'Ruko', 'Gudang', 'Toko', 'Kantor', 'Kebun', 'Fasilitas Produksi', 'Lainnya'] as $name) {
            PropertyType::firstOrCreate(['name' => $name]);
        }

        foreach ([
            ['name' => 'Digunakan Sendiri', 'color' => 'blue'],
            ['name' => 'Disewakan ke Pihak Lain', 'color' => 'green'],
            ['name' => 'Disewa dari Pihak Lain', 'color' => 'indigo'],
            ['name' => 'Idle / Tidak Digunakan', 'color' => 'yellow'],
            ['name' => 'Sengketa', 'color' => 'red'],
            ['name' => 'Dalam Proses Jual', 'color' => 'purple'],
            ['name' => 'Dalam Proses Beli', 'color' => 'cyan'],
            ['name' => 'Dalam Proses Perpanjangan', 'color' => 'orange'],
        ] as $status) {
            PropertyUtilizationStatus::firstOrCreate(['name' => $status['name']], $status);
        }

        foreach ([
            ['name' => 'Hak Milik', 'code' => 'HM', 'has_expiry' => false],
            ['name' => 'Hak Guna Bangunan', 'code' => 'HGB', 'has_expiry' => true],
            ['name' => 'Hak Guna Usaha', 'code' => 'HGU', 'has_expiry' => true],
            ['name' => 'Hak Pakai', 'code' => 'HP', 'has_expiry' => true],
            ['name' => 'Hak Pengelolaan', 'code' => 'HPL', 'has_expiry' => true],
            ['name' => 'Hak Sewa', 'code' => 'HS', 'has_expiry' => true],
            ['name' => 'Girik / Petok / Letter C', 'code' => 'GIRIK', 'has_expiry' => false],
            ['name' => 'Dokumen Non-Sertifikat', 'code' => 'NON', 'has_expiry' => false],
            ['name' => 'Lainnya', 'code' => 'OTHER', 'has_expiry' => true],
        ] as $type) {
            LandRightType::firstOrCreate(['name' => $type['name']], $type);
        }

        foreach ([
            ['name' => 'Aktif', 'color' => 'green'],
            ['name' => 'Akan Berakhir', 'color' => 'yellow'],
            ['name' => 'Dalam Proses Perpanjangan', 'color' => 'blue'],
            ['name' => 'Dalam Proses Balik Nama', 'color' => 'indigo'],
            ['name' => 'Dalam Sengketa', 'color' => 'red'],
            ['name' => 'Tidak Aktif', 'color' => 'gray'],
            ['name' => 'Arsip', 'color' => 'slate'],
        ] as $status) {
            CertificateStatus::firstOrCreate(['name' => $status['name']], $status);
        }

        foreach (['Disewakan ke Pihak Lain', 'Disewa dari Pihak Lain'] as $name) {
            LeaseType::firstOrCreate(['name' => $name]);
        }

        foreach (['Aktif', 'Akan Berakhir', 'Berakhir', 'Diperpanjang', 'Dihentikan', 'Dalam Negosiasi'] as $name) {
            LeaseStatus::firstOrCreate(['name' => $name]);
        }

        foreach ([
            'Scan Sertifikat', 'Surat Ukur', 'Perjanjian Sewa', 'IMB / PBG', 'PBB',
            'Foto Lokasi', 'Gambar Bangunan', 'Dokumen Sengketa', 'Dokumen Appraisal',
            'Dokumen Jual Beli', 'Dokumen Perpanjangan Hak', 'Dokumen Balik Nama', 'Dokumen Legal Lainnya',
        ] as $name) {
            DocumentCategory::firstOrCreate(['name' => $name]);
        }

        Province::firstOrCreate(['code' => '51'], ['name' => 'BALI']);
        City::firstOrCreate(['code' => '5171'], ['province_code' => '51', 'name' => 'KOTA DENPASAR']);
        City::firstOrCreate(['code' => '5103'], ['province_code' => '51', 'name' => 'KABUPATEN BADUNG']);

        foreach ([
            ['setting_key' => 'app_name', 'setting_value' => 'Terrasys Property Manager', 'setting_type' => 'string'],
            ['setting_key' => 'default_certificate_reminder_days', 'setting_value' => '180', 'setting_type' => 'integer'],
            ['setting_key' => 'default_lease_reminder_days', 'setting_value' => '180', 'setting_type' => 'integer'],
            ['setting_key' => 'max_upload_size', 'setting_value' => '10240', 'setting_type' => 'integer'],
            ['setting_key' => 'allowed_file_types', 'setting_value' => 'pdf,jpg,jpeg,png,doc,docx,xls,xlsx', 'setting_type' => 'string'],
            ['setting_key' => 'map_default_latitude', 'setting_value' => '-8.6500', 'setting_type' => 'decimal'],
            ['setting_key' => 'map_default_longitude', 'setting_value' => '115.2167', 'setting_type' => 'decimal'],
            ['setting_key' => 'map_default_zoom', 'setting_value' => '10', 'setting_type' => 'integer'],
        ] as $setting) {
            SystemSetting::firstOrCreate(['setting_key' => $setting['setting_key']], $setting);
        }
    }
}
