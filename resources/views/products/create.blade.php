@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-plus-circle me-2"></i>Thêm sản phẩm mới</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">Tên điện thoại</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="VD: iPhone 16 Pro Max" value="{{ old('name') }}">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Hãng sản xuất</label>
                                <select name="brand" class="form-select @error('brand') is-invalid @enderror">
                                    <option value="">-- Chọn hãng --</option>
                                    <option value="iPhone" {{ old('brand') == 'iPhone' ? 'selected' : '' }}>iPhone</option>
                                    <option value="Samsung" {{ old('brand') == 'Samsung' ? 'selected' : '' }}>Samsung</option>
                                    <option value="Xiaomi" {{ old('brand') == 'Xiaomi' ? 'selected' : '' }}>Xiaomi</option>
                                    <option value="OPPO" {{ old('brand') == 'OPPO' ? 'selected' : '' }}>OPPO</option>
                                </select>
                                @error('brand') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">RAM</label>
                                <input type="text" name="ram" class="form-control" placeholder="8GB" value="{{ old('ram') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Bộ nhớ (Storage)</label>
                                <input type="text" name="storage" class="form-control" placeholder="256GB" value="{{ old('storage') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Màu sắc</label>
                                <input type="text" name="color" class="form-control" placeholder="Titan" value="{{ old('color') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Giá bán (VNĐ)</label>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="0" value="{{ old('price') }}">
                                @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Số lượng trong kho</label>
                                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" placeholder="0" value="{{ old('quantity') }}">
                                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Hình ảnh sản phẩm</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-2"></i>Lưu máy mới</button>
                            <a href="{{ route('products.index') }}" class="btn btn-light px-4 border">Hủy bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection