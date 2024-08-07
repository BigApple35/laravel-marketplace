@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">{{ __('Create Product') }}</h1>
                <a href="{{ route('admin.products.index') }}" class="btn btn-success btn-sm shadow-sm">{{ __('Go Back') }}</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pesanan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">{{ __('Nama Customer') }}</label>
                    <input type="text" class="form-control" id="nama_customer" placeholder="{{ __('Name') }}" name="nama_customer" value="{{ old('Customer') }}" />
                </div>
                <div class="form-group">
                    <label for="description">{{ __('Jasa') }}</label>
                    <select name="product" id="product" class="form-control">
                        <option value="">Select a product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="nomor">{{ __('Nomor Handphone') }}</label>
                    <input type="text" class="form-control" id="nomor" placeholder="{{ __('Nomor Handphone') }}" name="nomor" value="{{ old('Nomor_Handphone') }}" />
                </div>

                <div class="" style="display: flex; align-items: center; gap : 20px;">
                    <label for="prioritas" >{{ __('Prioritas') }}</label>
                    <input type="checkbox" class="form-control" style="width: 30px" id="prioritas" name="prioritas" value="1" />
                </div>

                <div class="form-group mt-5">
                    <label for="price">{{ __('Total Harga') }}</label>
                    <input type="number" class="form-control" id="price" placeholder="{{ __('0') }}" name="price" readonly />
                </div>



                <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style-alt')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />
@endpush

@push('script-alt')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var productSelect = document.getElementById('product');
        var priceInput = document.getElementById('price');
        var prioritasCheckbox = document.getElementById('prioritas');

        function updatePrice() {
            var selectedOption = productSelect.options[productSelect.selectedIndex];
            var basePrice = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            var additionalPrice = prioritasCheckbox.checked ? 20000 : 0;
            var totalPrice = basePrice + additionalPrice;

            priceInput.value = totalPrice;
        }

        productSelect.addEventListener('change', updatePrice);
        prioritasCheckbox.addEventListener('change', updatePrice);
    });
</script>
@endpush
