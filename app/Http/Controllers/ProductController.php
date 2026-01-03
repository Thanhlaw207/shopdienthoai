<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * TRANG NGƯỜI DÙNG: Hiển thị sản phẩm cho khách hàng (Shop)
     */
    public function userIndex()
    {
        $products = Product::all();

        // Phân loại sản phẩm để trang Shop hiển thị theo từng dòng máy
        $categories = [
            'iPhone' => $products->filter(fn($p) => $p->category == 'iPhone'),
            'Samsung' => $products->filter(fn($p) => $p->category == 'Samsung'),
            'Dòng máy khác' => $products->filter(fn($p) => !in_array($p->category, ['iPhone', 'Samsung'])),
        ];

        return view('user_shop', compact('categories'));
    }

    /**
     * TRANG ADMIN: Danh sách quản lý
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    /**
     * Lưu sản phẩm mới (Có thêm category)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required', // Bắt buộc chọn dòng máy
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ], [
            'name.required' => 'Vui lòng nhập tên điện thoại',
            'category.required' => 'Vui lòng chọn hãng sản xuất',
            'price.numeric' => 'Giá bán phải là con số',
        ]);

        Product::create($request->all());
        return redirect()->route('products.index')->with('success', 'Đã thêm điện thoại mới thành công!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Đã xóa sản phẩm!');
    }
}