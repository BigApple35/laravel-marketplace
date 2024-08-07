<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TenantController extends Controller
{
   
    public function index(): View
    {
        $tenants = Tenant::get();

        return view('tenants.index', compact('tenants'));
    }

    public function create(): View
    {
        return view('tenants.create');
    }

    public function store(TenantRequest $request): RedirectResponse
    {
        Tenant::create($request->validated());

        return redirect()->route('tenants.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function show(Tenant $tenant): View
    {
        return view('tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant): View
    {
        return view('tenants.edit', compact('tenant'));
    }

    public function update(TenantRequest $request, Tenant $tenant): RedirectResponse
    {
        $tenant->update($request->validated());

        return redirect()->route('tenants.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Tenant $tenant): RedirectResponse
    {
        $tenant->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}