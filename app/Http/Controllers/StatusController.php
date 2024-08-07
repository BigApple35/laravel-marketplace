<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StatusController extends Controller
{
   
    public function index(): View
    {
        $statuss = Status::get();

        return view('statuss.index', compact('statuss'));
    }

    public function create(): View
    {
        return view('statuss.create');
    }

    public function store(StatusRequest $request): RedirectResponse
    {
        Status::create($request->validated());

        return redirect()->route('statuss.index')->with([
            'message' => 'successfully created !',
            'alert-type' => 'success'
        ]);
    }

    public function show(Status $status): View
    {
        return view('statuss.show', compact('status'));
    }

    public function edit(Status $status): View
    {
        return view('statuss.edit', compact('status'));
    }

    public function update(StatusRequest $request, Status $status): RedirectResponse
    {
        $status->update($request->validated());

        return redirect()->route('statuss.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Status $status): RedirectResponse
    {
        $status->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}