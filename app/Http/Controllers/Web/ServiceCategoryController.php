<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::all();

        return view('djoki.service-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('djoki.service-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:service_categories,slug',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        ServiceCategory::create($validated);

        return redirect()->route('service-categories.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function show(ServiceCategory $serviceCategory)
    {
        return view('djoki.service-categories.show', compact('serviceCategory'));
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        return view('djoki.service-categories.edit', compact('serviceCategory'));
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:service_categories,slug,'.$serviceCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $serviceCategory->update($validated);

        return redirect()->route('service-categories.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        $serviceCategory->delete();

        return redirect()->route('service-categories.index')->with('success', 'Kategori dihapus.');
    }
}
