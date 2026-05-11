<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->remapExistingPropertyRegions();

        Schema::table('properties', function (Blueprint $table) {
            $table->dropForeign(['province_id']);
            $table->dropForeign(['city_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['village_id']);
        });
    }

    public function down(): void
    {
        // Intentionally do not recreate legacy foreign keys. Region data now comes
        // from laravolt/indonesia tables and the legacy local tables are unused.
    }

    private function remapExistingPropertyRegions(): void
    {
        if (! Schema::hasTable('properties') || ! Schema::hasTable('indonesia_provinces')) {
            return;
        }

        $properties = DB::table('properties')->get(['id', 'province_id', 'city_id', 'district_id', 'village_id']);

        foreach ($properties as $property) {
            $updates = [];

            if ($property->province_id && Schema::hasTable('provinces')) {
                $legacyProvince = DB::table('provinces')->where('id', $property->province_id)->first(['code', 'name']);
                $newProvinceId = $this->findIndonesiaRegionId('indonesia_provinces', $legacyProvince);

                if ($newProvinceId) {
                    $updates['province_id'] = $newProvinceId;
                }
            }

            if ($property->city_id && Schema::hasTable('cities')) {
                $legacyCity = DB::table('cities')->where('id', $property->city_id)->first(['code', 'name']);
                $newCityId = $this->findIndonesiaRegionId('indonesia_cities', $legacyCity);

                if ($newCityId) {
                    $updates['city_id'] = $newCityId;
                }
            }

            if ($property->district_id && Schema::hasTable('districts')) {
                $legacyDistrict = DB::table('districts')->where('id', $property->district_id)->first(['code', 'name']);
                $newDistrictId = $this->findIndonesiaRegionId('indonesia_districts', $legacyDistrict);

                if ($newDistrictId) {
                    $updates['district_id'] = $newDistrictId;
                }
            }

            if ($property->village_id && Schema::hasTable('villages')) {
                $legacyVillage = DB::table('villages')->where('id', $property->village_id)->first(['code', 'name']);
                $newVillageId = $this->findIndonesiaRegionId('indonesia_villages', $legacyVillage);

                if ($newVillageId) {
                    $updates['village_id'] = $newVillageId;
                }
            }

            if ($updates) {
                DB::table('properties')->where('id', $property->id)->update($updates);
            }
        }
    }

    private function findIndonesiaRegionId(string $table, ?object $legacyRegion): ?int
    {
        if (! $legacyRegion) {
            return null;
        }

        $query = DB::table($table);

        if (! empty($legacyRegion->code)) {
            $region = (clone $query)->where('code', $legacyRegion->code)->first(['id']);

            if ($region) {
                return (int) $region->id;
            }
        }

        $region = $query->where('name', $legacyRegion->name)->first(['id']);

        return $region ? (int) $region->id : null;
    }
};
