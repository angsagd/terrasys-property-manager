<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateStatus;
use App\Models\DocumentCategory;
use App\Models\LandRightType;
use App\Models\LeaseStatus;
use App\Models\LeaseType;
use App\Models\PropertyType;
use App\Models\PropertyUtilizationStatus;
use App\Services\AuditLogService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterDataController extends Controller
{
    public function index()
    {
        $this->authorize('view_master_data');

        return view('admin.master-data.index', [
            'groups' => $this->groups(),
        ]);
    }

    public function create(string $type)
    {
        $this->authorize('create_master_data');
        $definition = $this->definition($type);

        return view('admin.master-data.form', [
            'type' => $type,
            'definition' => $definition,
            'item' => null,
        ]);
    }

    public function store(Request $request, string $type, AuditLogService $auditLog)
    {
        $this->authorize('create_master_data');
        $definition = $this->definition($type);
        $data = $this->validatedData($request, $definition);

        /** @var Model $item */
        $item = $definition['model']::create($data);
        $auditLog->record('Master Data', $item, 'create', null, $item->toArray());

        return redirect()->route('admin.master-data.index')->with('success', 'Master data berhasil ditambahkan.');
    }

    public function edit(string $type, int $id)
    {
        $this->authorize('update_master_data');
        $definition = $this->definition($type);

        return view('admin.master-data.form', [
            'type' => $type,
            'definition' => $definition,
            'item' => $definition['model']::findOrFail($id),
        ]);
    }

    public function update(Request $request, string $type, int $id, AuditLogService $auditLog)
    {
        $this->authorize('update_master_data');
        $definition = $this->definition($type);
        /** @var Model $item */
        $item = $definition['model']::findOrFail($id);
        $oldValues = $item->toArray();
        $data = $this->validatedData($request, $definition, $item->getKey());

        $item->update($data);
        $auditLog->record('Master Data', $item, 'update', $oldValues, $item->fresh()->toArray());

        return redirect()->route('admin.master-data.index')->with('success', 'Master data berhasil diperbarui.');
    }

    public function destroy(string $type, int $id, AuditLogService $auditLog)
    {
        $this->authorize('delete_master_data');
        $definition = $this->definition($type);
        /** @var Model $item */
        $item = $definition['model']::findOrFail($id);

        $auditLog->record('Master Data', $item, 'delete', $item->toArray());
        $item->delete();

        return redirect()->route('admin.master-data.index')->with('success', 'Master data berhasil dihapus.');
    }

    private function groups(): array
    {
        return collect($this->definitions())
            ->map(fn (array $definition, string $type) => $definition + [
                'type' => $type,
                'items' => $definition['model']::orderBy('name')->get(),
            ])
            ->all();
    }

    private function definition(string $type): array
    {
        abort_unless(array_key_exists($type, $this->definitions()), 404);

        return $this->definitions()[$type];
    }

    private function definitions(): array
    {
        return [
            'property-types' => [
                'title' => 'Property Type',
                'model' => PropertyType::class,
                'fields' => ['name', 'description', 'is_active'],
            ],
            'utilization-statuses' => [
                'title' => 'Status Pemanfaatan',
                'model' => PropertyUtilizationStatus::class,
                'fields' => ['name', 'description', 'color', 'is_active'],
            ],
            'land-right-types' => [
                'title' => 'Jenis Hak',
                'model' => LandRightType::class,
                'fields' => ['name', 'code', 'description', 'has_expiry', 'is_active'],
            ],
            'certificate-statuses' => [
                'title' => 'Status Sertifikat',
                'model' => CertificateStatus::class,
                'fields' => ['name', 'description', 'color', 'is_active'],
            ],
            'lease-types' => [
                'title' => 'Lease Type',
                'model' => LeaseType::class,
                'fields' => ['name', 'description', 'is_active'],
            ],
            'lease-statuses' => [
                'title' => 'Lease Status',
                'model' => LeaseStatus::class,
                'fields' => ['name', 'description', 'color', 'is_active'],
            ],
            'document-categories' => [
                'title' => 'Kategori Dokumen',
                'model' => DocumentCategory::class,
                'fields' => ['name', 'description', 'is_active'],
            ],
        ];
    }

    private function rules(array $definition, ?int $ignoreId = null): array
    {
        $table = (new $definition['model'])->getTable();
        $rules = [
            'name' => ['required', 'string', 'max:100', Rule::unique($table, 'name')->ignore($ignoreId)],
        ];

        foreach ($definition['fields'] as $field) {
            $rules[$field] = match ($field) {
                'code' => ['nullable', 'string', 'max:50'],
                'description' => ['nullable', 'string'],
                'color' => ['nullable', 'string', 'max:20'],
                'has_expiry', 'is_active' => ['sometimes', 'boolean'],
                default => $rules[$field] ?? ['nullable', 'string'],
            };
        }

        return $rules;
    }

    private function validatedData(Request $request, array $definition, ?int $ignoreId = null): array
    {
        $data = $request->validate($this->rules($definition, $ignoreId));

        foreach (['is_active', 'has_expiry'] as $field) {
            if (in_array($field, $definition['fields'], true)) {
                $data[$field] = $request->boolean($field);
            }
        }

        return $data;
    }
}
