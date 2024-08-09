<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesananRequest;
use App\Models\Pesanan;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

class PesananController extends Controller
{

    public function index(): View
    {
        $isAdmin = auth()->user()->roles->contains(1);

        if (!$isAdmin) {
            $pesanans = Pesanan::where('created_by_id', auth()->id())->with("product")->get();
        } else {
            $pesanans = Pesanan::with("product")->get();
        }

        return view('admin.pesanan.index', compact('pesanans'));
    }

    public function create(): View
    {
        $products = Product::all();

        return view('admin.pesanan.create', compact("products"));
    }

    public function store(PesananRequest $request): RedirectResponse
    {
        $isAdmin = auth()->user()->roles->contains(1);

        if (!$isAdmin) {
            redirect()->route('admin.pesanan.index')->with('success', 'Product created failed!');
        }

        // Validate the request data
        $validated = $request->validate([
            'nama_customer' => 'required|string|max:255',
            'product' => 'required|integer|exists:products,id',
            'price' => 'required|numeric',
            "nomor" => "required",
            'prioritas' => 'nullable|boolean',
        ]);

        // Get the selected product
        $product = Product::findOrFail($validated['product']);


        function generateUniqueOrderCode()
        {
            $code = Str::random(12); // Generate a random 12-character string

            // Check if the generated code already exists in the database
            while (Pesanan::where('kode_pesanan', $code)->exists()) {
                $code = Str::random(12); // Generate a new code if it already exists
            }

            return $code;
        }



        // Create a new product instance and save it to the database

        $newProduct = new Pesanan();
        $newProduct->nama_customer = $validated['nama_customer'];
        $newProduct->product_id = $product->id; // Assuming you have a product_id field
        $newProduct->total_harga = $validated['price'];
        $newProduct->nomor = $validated['nomor'];
        $newProduct->status = "pesanan telah diterima";
        // $newProduct->kode_pesanan = generateUniqueOrderCode(); // Assign unique order code here
        $newProduct->created_by = auth()->id();
        $newProduct->prioritas = $validated['prioritas'] ? 1 : 0; // Convert checkbox value to 1 or 0
        $newProduct->save();


        // Redirect or return success message
        return redirect()->route('admin.pesanan.index')->with('success', 'Product created successfully!');
    }

    public function show(Pesanan $pesanan): View
    {
        return view('pesanans.show', compact('pesanan'));
    }

    public function edit(Pesanan $pesanan): View
    {
        $products = Product::all();
        $statuses = ["pesanan telah diterima", "pesanan dalam proses pengerjaan", "pesanan dalam proses pengiriman", "pesanan sudah selesai dan siap diambil"];

        return view('admin.pesanan.edit', compact(['pesanan', 'products', "statuses"]));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $pesanan = Pesanan::findOrFail($id);

        $pesanan->nama_customer = $request->input('nama_customer');
        $pesanan->product_id = $request->input('product');
        $pesanan->nomor = $request->input('nomor');
        $pesanan->status = $request->input('status');
        $pesanan->prioritas = $request->has('prioritas') ? 1 : 0;
        $pesanan->total_harga = $request->input('price');

        $pesanan->save();

        return redirect()->route('admin.pesanan.index')->with([
            'message' => 'successfully updated !',
            'alert-type' => 'info'
        ]);
    }

    public function destroy(Pesanan $pesanan): RedirectResponse
    {
        $pesanan->delete();

        return back()->with([
            'message' => 'successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
