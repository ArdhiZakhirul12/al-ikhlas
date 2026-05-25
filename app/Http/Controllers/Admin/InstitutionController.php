<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\UploadsFiles;
use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstitutionController extends Controller
{
    use UploadsFiles;

    public function index(): View
    {
        return view('admin.institutions.index', [
            'institutions' => Institution::latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('admin.institutions.form', [
            'institution' => new Institution(['is_active' => true]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Institution::create($this->validatedData($request));

        return redirect()->route('admin.institutions.index')->with('status', 'Lembaga berhasil dibuat.');
    }

    public function edit(Institution $institution): View
    {
        return view('admin.institutions.form', compact('institution'));
    }

    public function update(Request $request, Institution $institution): RedirectResponse
    {
        $institution->update($this->validatedData($request, $institution));

        return redirect()->route('admin.institutions.index')->with('status', 'Lembaga berhasil diperbarui.');
    }

    public function destroy(Institution $institution): RedirectResponse
    {
        $institution->delete();

        return back()->with('status', 'Lembaga berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Institution $institution = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:140'],
            'image' => ['nullable', 'image', 'max:4096'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        return [
            'name' => $validated['name'],
            'image_path' => $this->uploadPublicFile($request->file('image'), 'institutions') ?: $institution?->image_path,
            'summary' => $validated['summary'] ?? null,
            'description' => $validated['description'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ];
    }
}
