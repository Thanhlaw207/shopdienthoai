<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm mt-5">
                    <div class="card-header text-center fw-bold fs-5">
                        🔐 Xác thực OTP
                    </div>

                    <div class="card-body">

                        
                        <?php if(session('message')): ?>
                            <div class="alert alert-success text-center">
                                <?php echo e(session('message')); ?>

                            </div>
                        <?php endif; ?>

                        
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger text-center">
                                <?php echo e($errors->first('otp')); ?>

                            </div>
                        <?php endif; ?>

                        
                        <form method="POST" action="<?php echo e(route('otp.verify')); ?>">
                            <?php echo csrf_field(); ?>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-center w-100">
                                    Nhập mã OTP (6 số)
                                </label>
                                <input type="text" name="otp" class="form-control text-center fs-3 letter-spacing"
                                    maxlength="6" placeholder="123456" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                ✅ Xác thực
                            </button>
                        </form>

                        <hr>

                        
                        <div class="text-center">
                            <form method="POST" action="<?php echo e(route('otp.resend')); ?>">
                                <?php echo csrf_field(); ?>
                                <button id="resendBtn" type="submit" class="btn btn-outline-secondary btn-sm" disabled>
                                    Gửi lại OTP (<span id="countdown"><?php echo e($resendSeconds); ?></span>s)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <script>
        let seconds = <?php echo e($resendSeconds); ?>;
        const btn = document.getElementById('resendBtn');
        const countdown = document.getElementById('countdown');

        const timer = setInterval(() => {
            seconds--;
            countdown.innerText = seconds;

            if (seconds <= 0) {
                clearInterval(timer);
                btn.disabled = false;
                btn.innerText = 'Gửi lại OTP';
            }
        }, 1000);
    </script>

    <style>
        .letter-spacing {
            letter-spacing: 6px;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nhom4_CongNgheMoi\resources\views/auth/verify-otp.blade.php ENDPATH**/ ?>