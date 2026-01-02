@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-danger text-white shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase small">Tổng số máy</h6>
                        <h2 class="fw-bold mb-0">{{ $products->count() }}</h2>
                    </div>
                    <i class="fas fa-mobile-alt fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase small">Còn hàng</h6>
                        <h2 class="fw-bold mb-0">{{ $products->where('quantity', '>', 0)->count() }}</h2>
                    </div>
                    <i class="fas fa-check-circle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase small">Giá cao nhất</h6>
                        <h2 class="fw-bold mb-0">{{ number_format($products->max('price') / 1000000, 1) }}M</h2>
                    </div>
                    <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white shadow-sm border-0">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-uppercase small">Hết hàng</h6>
                        <h2 class="fw-bold mb-0">{{ $products->where('quantity', '<=', 0)->count() }}</h2>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list me-2"></i>Danh sách sản phẩm - Nhóm 4</h5>
            <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-plus"></i> Thêm máy mới
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">Tên máy</th>
                            <th>Giá bán</th>
                            <th>Số lượng</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $p)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">{{ $p->name }}</td>
                            <td class="fw-bold text-danger">{{ number_format($p->price) }} VNĐ</td>
                            <td>
                                @if($p->quantity > 0)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">{{ $p->quantity }} chiếc</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Hết hàng</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('products.edit', $p->id) }}" class="btn btn-warning btn-sm mx-1 shadow-sm">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('products.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mx-1 shadow-sm" onclick="return confirm('Xóa máy này?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection