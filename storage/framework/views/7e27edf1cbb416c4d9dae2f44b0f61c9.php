<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Admin Nhóm 4')); ?></title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <?php echo app('Illuminate\Foundation\Vite')(['resources/sass/app.scss', 'resources/js/app.js']); ?>

    <style>
        body { overflow-x: hidden; background-color: #f8f9fa; }
        .wrapper { display: flex; width: 100%; align-items: stretch; }
        
        /* Sidebar Styling */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            min-height: 100vh;
            background: #212529; /* Màu tối chuyên nghiệp */
            color: #fff;
            transition: all 0.3s;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }
        #sidebar .sidebar-header { 
            padding: 25px 20px; 
            background: #1a1d20; 
            border-bottom: 1px solid #343a40; 
            text-align: center;
        }
        #sidebar .sidebar-header h3 { font-size: 1.2rem; font-weight: 800; margin: 0; letter-spacing: 1px; }
        
        #sidebar ul li a {
            padding: 15px 25px;
            display: block;
            color: #ced4da;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.95rem;
        }
        #sidebar ul li a:hover, #sidebar ul li.active > a { 
            color: #fff; 
            background: #343a40; 
            border-left: 4px solid #ffc107; /* Vạch vàng làm điểm nhấn */
        }
        #sidebar ul li a i { margin-right: 12px; width: 20px; text-align: center; }
        
        .sidebar-heading {
            padding: 20px 25px 10px;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #6c757d;
        }

        /* Content Styling */
        #content { width: 100%; }
        .navbar { border-bottom: 1px solid #e3e6f0 !important; }
    </style>
</head>
<body>
    <div id="app" class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-user-shield me-2"></i>ADMIN NHÓM 4</h3>
            </div>

            <ul class="list-unstyled components">
                <div class="sidebar-heading">Bảng điều khiển</div>
                <li class="<?php echo e(Request::is('products') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('products.index')); ?>"><i class="fas fa-home"></i> Dashboard</a>
                </li>

                <div class="sidebar-heading">Cửa hàng</div>
                <li class="<?php echo e(Request::is('products*') && !Request::is('products') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('products.index')); ?>"><i class="fas fa-mobile-alt"></i> Quản lý điện thoại</a>
                </li>
                
                <hr style="border-color: #343a40; margin: 20px 0;">
                
                <div class="sidebar-heading">Giao diện khách</div>
                <li>
                    <a href="/shop" class="text-warning fw-bold">
                        <i class="fas fa-shopping-bag"></i> Xem trang Shop
                    </a>
                </li>
            </ul>
        </nav>

        <div id="content">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm py-3">
                <div class="container-fluid">
                    <span class="navbar-text text-muted d-none d-md-block">
                        Chào mừng bạn quay lại, quản trị viên!
                    </span>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <?php if(auth()->guard()->guest()): ?>
                                <?php if(Route::has('login')): ?>
                                    <li class="nav-item"><a class="nav-link" href="<?php echo e(route('login')); ?>">Đăng nhập</a></li>
                                <?php endif; ?>
                            <?php else: ?>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-1"></i> <?php echo e(Auth::user()->name); ?>

                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end shadow border-0">
                                        <a class="dropdown-item py-2" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt me-2 text-danger"></i> Đăng xuất
                                        </a>
                                        <form id="logout-form" action="<?php echo e(url('/logout')); ?>" method="POST" class="d-none">
                                            <?php echo csrf_field(); ?>
                                        </form>
                                    </div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4 px-4">
                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\Nhom4_CongNgheMoi\resources\views/layouts/app.blade.php ENDPATH**/ ?>