<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ProviderService;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ProviderServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = ProviderService::with(['provider', 'service']);
        if ($request->has('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }
        $providerServices = $query->paginate(20);

        return view('djoki.provider-services.index', compact('providerServices'));
    }

    public function create()
    {
        $providers = User::where('role', 'provider')->get();
        $services = Service::all();

        return view('djoki.provider-services.create', compact('providers', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'price_start' => 'nullable|integer',
            'is_negotiable' => 'boolean',
        ]);
        ProviderService::updateOrCreate(
            ['provider_id' => $validated['provider_id'], 'service_id' => $validated['service_id']],
            $validated
        );

        return redirect()->route('provider-services.index')->with('success', 'Layanan provider berhasil ditambahkan.');
    }

    public function show(ProviderService $providerService)
    {
        return view('djoki.provider-services.show', compact('providerService'));
    }

    public function edit(ProviderService $providerService)
    {
        return view('djoki.provider-services.edit', compact('providerService'));
    }

    public function update(Request $request, ProviderService $providerService)
    {
        $validated = $request->validate([
            'price_start' => 'nullable|integer',
            'is_negotiable' => 'boolean',
            'is_available' => 'boolean',
        ]);
        $providerService->update($validated);

        return redirect()->route('provider-services.index')->with('success', 'Layanan provider diupdate.');
    }

    public function destroy(ProviderService $providerService)
    {
        $providerService->delete();

        return redirect()->route('provider-services.index')->with('success', 'Layanan provider dihapus.');
    }
}
