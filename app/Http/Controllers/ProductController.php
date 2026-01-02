<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm (Trang Index)
     */
    public function index()
    {
        $products = Product::all(); // Lấy tất cả sản phẩm từ DB
        return view('products.index', compact('products'));
    }

    /**
     * Hiển thị form thêm sản phẩm mới
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Lưu sản phẩm mới vào DB
     */
    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào (Validation) để tránh lỗi
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ], [
            'name.required' => 'Vui lòng nhập tên điện thoại',
            'price.numeric' => 'Giá bán phải là con số',
]);
        Product::create($request->all()); // Lưu dữ liệu
        return redirect()->route('products.index')->with('success', 'Đã thêm điện thoại mới thành công!');
    }

    /**
     * Hiển thị chi tiết sản phẩm (không bắt buộc cho demo)
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Hiển thị form chỉnh sửa sản phẩm
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Cập nhật thông tin sản phẩm vào DB
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Xóa sản phẩm
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Đã xóa sản phẩm!');
    }
}