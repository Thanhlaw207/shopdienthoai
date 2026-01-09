<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Thêm dòng này để dùng DB::raw

class ProductController extends Controller
{
    /**
     * TRANG NGƯỜI DÙNG: Hiển thị sản phẩm cho khách hàng (Shop)
     */
    public function userIndex()
    {
        $products = Product::all();

        // Đồng bộ dữ liệu dựa trên cột 'brand'
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
     * Lưu sản phẩm mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'brand' => 'required', 
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên điện thoại',
            'brand.required' => 'Vui lòng chọn hãng sản xuất',
            'price.numeric' => 'Giá bán phải là con số',
        ]);

        $data = $request->all();

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
     * Cập nhật sản phẩm
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
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/products'), $fileName);
            $data['image'] = 'uploads/products/' . $fileName;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Đã cập nhật thông tin máy!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Đã xóa sản phẩm!');
    }

    /**
     * TRANG THỐNG KÊ: Lấy dữ liệu thực cho biểu đồ
     */
    public function thongKe() 
{
    // 1. Thống kê số lượng máy theo hãng
    $dataQuantity = Product::select('brand', \DB::raw('count(*) as total'))
                    ->groupBy('brand')
                    ->get();

    // 2. Thống kê doanh thu dự kiến theo từng hãng
    $dataRevenue = Product::select('brand', \DB::raw('SUM(price * quantity) as total_revenue'))
                    ->groupBy('brand')
                    ->get();

    // 3. TÍNH TỔNG TẤT CẢ DOANH THU (Số tiền nhận lại khi bán hết sạch hàng)
    $totalAllRevenue = Product::sum(\DB::raw('price * quantity'));

    return view('products.thongke', [
        'labels' => $dataQuantity->pluck('brand')->toArray(),
        'values' => $dataQuantity->pluck('total')->toArray(),
        'revLabels' => $dataRevenue->pluck('brand')->toArray(),
        'revValues' => $dataRevenue->pluck('total_revenue')->toArray(),
        'totalAllRevenue' => $totalAllRevenue, // Gửi biến này sang View
    ]);
}
}