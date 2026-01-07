

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header">Xác thực OTP</div>

                    <div class="card-body">

                        <?php if(session('message')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('message')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <?php echo e($errors->first('otp')); ?>

                            </div>
                        <?php endif; ?>

                        <form method="POST" action="<?php echo e(url('/verify-otp')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="form-group mb-3">
                                <label>Nhập mã OTP (6 số)</label>
                                <input type="text" name="otp" class="form-control" placeholder="VD: 123456" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                Xác thực
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nhom4_CongNgheMoi\resources\views/auth/verify-otp.blade.php ENDPATH**/ ?>