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

        // Đồng bộ: Đổi 'category' thành 'brand' theo database của bạn
        $categories = [
            'iPhone' => $products->filter(fn($p) => $p->brand == 'iPhone'),
            'Samsung' => $products->filter(fn($p) => $p->brand == 'Samsung'),
            'Dòng máy khác' => $products->filter(fn($p) => !in_array($p->brand, ['iPhone', 'Samsung'])),
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
     * Lưu sản phẩm mới (Sửa tên các trường cho chi tiết hơn)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'brand' => 'required', // Đã đổi từ category sang brand
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validation ảnh
        ], [
            'name.required' => 'Vui lòng nhập tên điện thoại',
            'brand.required' => 'Vui lòng chọn hãng sản xuất',
            'price.numeric' => 'Giá bán phải là con số',
        ]);

        $data = $request->all();

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            $fileName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('uploads/products'), $fileName);
            $data['image'] = 'uploads/products/' . $fileName;
        }

        Product::create($data);
        
        return redirect()->route('products.index')->with('success', 'Đã thêm điện thoại mới thành công!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Cập nhật sản phẩm (Cũng phải đổi category -> brand)
     */
public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required',
        'brand' => 'required',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        // Lưu ảnh mới
        $fileName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads/products'), $fileName);
        $data['image'] = 'uploads/products/' . $fileName;
    }

    $product->update($data); // Cập nhật vào DB

    return redirect()->route('products.index')->with('success', 'Đã cập nhật thông tin máy!');
}

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Đã xóa sản phẩm!');
    }
}