<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $query = Portfolio::with('provider')->where('is_public', true);
        if ($request->has('provider_id')) {
            $query->where('provider_id', $request->provider_id);
        }
        $portfolios = $query->paginate(20);

        return view('djoki.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('djoki.portfolios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'media_files' => 'nullable|array',
            'external_link' => 'nullable|url',
            'order_id' => 'nullable|exists:orders,id',
        ]);
        $validated['provider_id'] = $request->user()->id;
        Portfolio::create($validated);

        return redirect()->route('portfolios.index')->with('success', 'Portfolio ditambahkan.');
    }

    public function show(Portfolio $portfolio)
    {
        return view('djoki.portfolios.show', compact('portfolio'));
    }

    public function edit(Portfolio $portfolio)
    {
        if ($portfolio->provider_id !== auth()->id()) {
            abort(403);
        }

        return view('djoki.portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        if ($portfolio->provider_id !== auth()->id()) {
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'string',
            'description' => 'nullable|string',
            'media_files' => 'nullable|array',
            'external_link' => 'nullable|url',
            'is_public' => 'boolean',
        ]);
        $portfolio->update($validated);

        return redirect()->route('portfolios.index')->with('success', 'Portfolio diupdate.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->provider_id !== auth()->id()) {
            abort(403);
        }
        $portfolio->delete();

        return redirect()->route('portfolios.index')->with('success', 'Portfolio dihapus.');
    }
}
