<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-danger text-white shadow border-0">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <div class="small text-uppercase fw-bold">Tổng số máy</div>
                        <div class="h3 mb-0 fw-bold"><?php echo e($products->count()); ?></div>
                    </div>
                    <i class="fas fa-mobile-alt ms-auto fa-2x opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white shadow border-0">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <div class="small text-uppercase fw-bold">Còn hàng</div>
                        <div class="h3 mb-0 fw-bold"><?php echo e($products->where('quantity', '>', 0)->count()); ?></div>
                    </div>
                    <i class="fas fa-check-circle ms-auto fa-2x opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-primary text-white shadow border-0">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <div class="small text-uppercase fw-bold">Giá cao nhất</div>
                        <div class="h3 mb-0 fw-bold">
                            <?php echo e(number_format(($products->max('price') ?? 0) / 1000000, 1)); ?>M
                        </div>
                    </div>
                    <i class="fas fa-dollar-sign ms-auto fa-2x opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-dark text-white shadow border-0">
                <div class="card-body d-flex align-items-center">
                    <div>
                        <div class="small text-uppercase fw-bold">Hết hàng</div>
                        <div class="h3 mb-0 fw-bold"><?php echo e($products->where('quantity', '<=', 0)->count()); ?></div>
                    </div>
                    <i class="fas fa-exclamation-triangle ms-auto fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow border-0">
        <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list-ul me-2"></i>Quản lý sản phẩm - Nhóm 4</h5>
            <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary shadow-sm px-3">
                <i class="fas fa-plus-circle me-1"></i> Thêm máy mới
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4" style="width: 100px;">Hình ảnh</th>
                            <th>Thông tin máy</th>
                            <th>Hãng</th>
                            <th>Cấu hình (RAM/ROM)</th>
                            <th>Giá bán</th>
                            <th>Kho hàng</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4">
                                <?php if($product->image): ?>
                                    <img src="<?php echo e(asset($product->image)); ?>" class="rounded shadow-sm border" width="60" height="60" style="object-fit: cover;">
                                <?php else: ?>
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-primary"><?php echo e($product->name); ?></div>
                                <div class="text-muted small"><i class="fas fa-palette me-1"></i>Màu: <?php echo e($product->color ?? 'Chưa cập nhật'); ?></div>
                            </td>
                            <td>
                                <span class="badge bg-info text-dark fw-normal px-2 py-1">
                                    <?php echo e($product->brand); ?>

                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <span class="small"><i class="fas fa-memory me-1 text-secondary"></i>RAM: <strong><?php echo e($product->ram ?? '-'); ?></strong></span>
                                    <span class="small"><i class="fas fa-hdd me-1 text-secondary"></i>ROM: <strong><?php echo e($product->storage ?? '-'); ?></strong></span>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-danger"><?php echo e(number_format($product->price, 0, ',', '.')); ?> đ</div>
                            </td>
                            <td>
                                <?php if($product->quantity > 0): ?>
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 6px; width: 50px;">
                                            <div class="progress-bar bg-success" style="width: 100%"></div>
                                        </div>
                                        <span class="small fw-bold"><?php echo e($product->quantity); ?> chiếc</span>
                                    </div>
                                <?php else: ?>
                                    <span class="badge bg-danger rounded-pill">Hết hàng</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="btn btn-warning btn-sm text-white px-3 shadow-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa máy này?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm px-3 shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3">
                                <p class="text-muted">Kho hàng trống, hãy thêm máy mới ngay!</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nhom4_CongNgheMoi\resources\views/products/index.blade.php ENDPATH**/ ?>