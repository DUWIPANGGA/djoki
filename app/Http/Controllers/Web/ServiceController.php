<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->paginate(20);

        return view('djoki.services.index', compact('services'));
    }

    public function create()
    {
        $categories = ServiceCategory::all();

        return view('djoki.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'name' => 'required|string',
            'slug' => 'nullable|string|unique:services,slug',
            'description' => 'required|string',
            'min_price' => 'nullable|integer',
            'max_price' => 'nullable|integer',
            'estimated_time' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        }

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Layanan berhasil dibuat.');
    }

    public function show(Service $service)
    {
        return view('djoki.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $categories = ServiceCategory::all();

        return view('djoki.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'name' => 'required|string',
            'slug' => 'nullable|string|unique:services,slug,'.$service->id,
            'description' => 'required|string',
            'min_price' => 'nullable|integer',
            'max_price' => 'nullable|integer',
            'estimated_time' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        }

        $service->update($validated);

        return redirect()->route('services.index')->with('success', 'Layanan berhasil diupdate.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Layanan dihapus.');
    }
}
