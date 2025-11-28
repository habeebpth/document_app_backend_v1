<?php
use App\Models\Setting;
$setting = Setting::first();
?>

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script> ©  <?php echo e($setting->company_name ?? ''); ?>

            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Cloudocz
                </div>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH C:\Users\USER\Desktop\bexone\resources\views/layouts/footer.blade.php ENDPATH**/ ?>