@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-edit me-2 text-warning"></i>Chỉnh sửa sản phẩm
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Tên điện thoại</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" placeholder="VD: iPhone 15 Pro Max">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Hãng sản xuất</label>
                                <select name="brand" class="form-select @error('brand') is-invalid @enderror">
                                    <option value="iPhone" {{ old('brand', $product->brand) == 'iPhone' ? 'selected' : '' }}>iPhone</option>
                                    <option value="Samsung" {{ old('brand', $product->brand) == 'Samsung' ? 'selected' : '' }}>Samsung</option>
                                    <option value="Xiaomi" {{ old('brand', $product->brand) == 'Xiaomi' ? 'selected' : '' }}>Xiaomi</option>
                                    <option value="OPPO" {{ old('brand', $product->brand) == 'OPPO' ? 'selected' : '' }}>OPPO</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-secondary"><i class="fas fa-memory me-1"></i>RAM</label>
                                <input type="text" name="ram" class="form-control" value="{{ old('ram', $product->ram) }}" placeholder="8GB">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-secondary"><i class="fas fa-hdd me-1"></i>Bộ nhớ (ROM)</label>
                                <input type="text" name="storage" class="form-control" value="{{ old('storage', $product->storage) }}" placeholder="256GB">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-secondary"><i class="fas fa-palette me-1"></i>Màu sắc</label>
                                <input type="text" name="color" class="form-control" value="{{ old('color', $product->color) }}" placeholder="Titan tự nhiên">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Giá bán (VNĐ)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-danger fw-bold">₫</span>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}">
                                </div>
                                @error('price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-uppercase text-secondary">Số lượng trong kho</label>
                                <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $product->quantity) }}">
                                @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3 p-3 bg-light rounded border">
                            <label class="form-label fw-bold small text-uppercase text-secondary">Hình ảnh sản phẩm</label>
                            <div class="d-flex align-items-center gap-3">
                                @if($product->image)
                                    <div class="position-relative">
                                        <img src="{{ asset($product->image) }}" width="80" height="80" class="rounded shadow-sm border object-fit-cover" alt="Ảnh cũ">
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary" style="font-size: 10px;">Ảnh cũ</span>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                                    <small class="text-muted italic">Chọn ảnh mới nếu muốn thay đổi, nếu không hãy để trống.</small>
                                </div>
                            </div>
                            @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                            <a href="{{ route('products.index') }}" class="btn btn-light px-4 border text-secondary">
                                <i class="fas fa-times me-2"></i>Hủy bỏ
                            </a>
                            <button type="submit" class="btn btn-warning px-4 text-white fw-bold shadow-sm">
                                <i class="fas fa-save me-2"></i>Cập nhật thông tin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection