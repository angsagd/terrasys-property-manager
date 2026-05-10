<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->nullable();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('province_id')->constrained()->cascadeOnDelete();
            $table->string('code', 20)->nullable();
            $table->string('name', 100);
            $table->enum('type', ['kabupaten', 'kota'])->nullable();
            $table->timestamps();
        });

        Schema::create('districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->cascadeOnDelete();
            $table->string('code', 20)->nullable();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('district_id')->constrained()->cascadeOnDelete();
            $table->string('code', 20)->nullable();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('property_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('property_utilization_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('color', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('land_right_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code', 50)->nullable();
            $table->text('description')->nullable();
            $table->boolean('has_expiry')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('certificate_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('color', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('lease_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('lease_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('color', 20)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('document_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('property_code', 50)->unique();
            $table->string('property_name', 150);
            $table->foreignId('property_type_id')->constrained('property_types');
            $table->foreignId('utilization_status_id')->constrained('property_utilization_statuses');
            $table->text('address')->nullable();
            $table->foreignId('province_id')->constrained('provinces');
            $table->foreignId('city_id')->constrained('cities');
            $table->foreignId('district_id')->nullable()->constrained('districts')->nullOnDelete();
            $table->foreignId('village_id')->nullable()->constrained('villages')->nullOnDelete();
            $table->string('postal_code', 20)->nullable();
            $table->decimal('land_area', 15, 2)->nullable();
            $table->decimal('building_area', 15, 2)->nullable();
            $table->string('area_unit', 20)->default('m2');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->longText('polygon_geojson')->nullable();
            $table->string('physical_condition', 100)->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['province_id', 'city_id']);
            $table->index(['property_type_id', 'utilization_status_id']);
            $table->index('property_name');
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->unique()->constrained('properties')->cascadeOnDelete();
            $table->string('certificate_number', 100);
            $table->foreignId('land_right_type_id')->constrained('land_right_types');
            $table->foreignId('certificate_status_id')->constrained('certificate_statuses');
            $table->string('holder_name', 150)->nullable();
            $table->string('measurement_letter_number', 100)->nullable();
            $table->date('measurement_letter_date')->nullable();
            $table->decimal('certificate_area', 15, 2)->nullable();
            $table->string('area_unit', 20)->default('m2');
            $table->date('issued_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('land_office', 150)->nullable();
            $table->text('legal_notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index('certificate_number');
            $table->index(['land_right_type_id', 'certificate_status_id']);
            $table->index('expired_date');
        });

        Schema::create('additional_certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->string('document_number', 100)->nullable();
            $table->string('document_type', 100)->nullable();
            $table->foreignId('land_right_type_id')->nullable()->constrained('land_right_types')->nullOnDelete();
            $table->string('holder_name', 150)->nullable();
            $table->date('issued_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->text('relationship_description')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['property_id', 'document_number']);
        });

        Schema::create('lease_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->foreignId('lease_type_id')->constrained('lease_types');
            $table->foreignId('lease_status_id')->constrained('lease_statuses');
            $table->string('counterparty_name', 150);
            $table->text('counterparty_address')->nullable();
            $table->string('agreement_number', 100)->nullable();
            $table->date('agreement_date')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('rental_value', 18, 2)->default(0);
            $table->enum('payment_period', ['monthly', 'quarterly', 'semesterly', 'yearly', 'one_time'])->default('yearly');
            $table->string('payment_status', 100)->nullable();
            $table->date('reminder_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['property_id', 'lease_type_id', 'lease_status_id']);
            $table->index(['start_date', 'end_date']);
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_category_id')->constrained('document_categories');
            $table->foreignId('property_id')->nullable()->constrained('properties')->cascadeOnDelete();
            $table->foreignId('certificate_id')->nullable()->constrained('certificates')->cascadeOnDelete();
            $table->foreignId('additional_certificate_id')->nullable()->constrained('additional_certificates')->cascadeOnDelete();
            $table->foreignId('lease_contract_id')->nullable()->constrained('lease_contracts')->cascadeOnDelete();
            $table->string('document_name', 150);
            $table->string('document_number', 100)->nullable();
            $table->date('document_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->string('file_name', 255);
            $table->string('file_path', 255);
            $table->string('file_extension', 20)->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->integer('version_number')->default(1);
            $table->text('description')->nullable();
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['property_id', 'certificate_id']);
            $table->index(['lease_contract_id', 'expired_date']);
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('notification_type', 100);
            $table->string('title', 150);
            $table->text('message');
            $table->string('related_table', 100)->nullable();
            $table->unsignedBigInteger('related_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->date('notification_date')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'is_read']);
            $table->index(['notification_type', 'notification_date']);
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('module_name', 100);
            $table->string('table_name', 100);
            $table->unsignedBigInteger('record_id')->nullable();
            $table->string('action', 50);
            $table->longText('old_values')->nullable();
            $table->longText('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['table_name', 'record_id']);
            $table->index(['user_id', 'created_at']);
        });

        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('setting_key', 100)->unique();
            $table->text('setting_value')->nullable();
            $table->string('setting_type', 50)->default('string');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_settings');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('documents');
        Schema::dropIfExists('lease_contracts');
        Schema::dropIfExists('additional_certificates');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('properties');
        Schema::dropIfExists('document_categories');
        Schema::dropIfExists('lease_statuses');
        Schema::dropIfExists('lease_types');
        Schema::dropIfExists('certificate_statuses');
        Schema::dropIfExists('land_right_types');
        Schema::dropIfExists('property_utilization_statuses');
        Schema::dropIfExists('property_types');
        Schema::dropIfExists('villages');
        Schema::dropIfExists('districts');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
    }
};
