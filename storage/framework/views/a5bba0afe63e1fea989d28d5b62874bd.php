<?php $__env->startSection('content'); ?>
<div class="container">
    <h3>Company Settings</h3>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <form action="<?php echo e(route('settings.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="mb-3">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" value="<?php echo e(old('company_name', $setting->company_name ?? '')); ?>">
        </div>

        <div class="mb-3">
            <label>Company Address</label>
            <textarea name="company_address" class="form-control"><?php echo e(old('company_address', $setting->company_address ?? '')); ?></textarea>
        </div>

     <div class="mb-3">
    <label>Phone Number</label>
    <input type="text" id="phone_number"
           name="phone_number"
           class="form-control"
           maxlength="10"
           value="<?php echo e(old('phone_number', $setting->phone_number ?? '')); ?>">
</div>

        <div class="mb-3">
            <label>Company Logo</label>
            <input type="file" name="company_logo" class="form-control">
           <?php if(!empty($setting->company_logo)): ?>
    <img src="<?php echo e(asset('storage/settings/' . basename($setting->company_logo))); ?>" style="height: auto;
    width: 100px;">
<?php endif; ?>

        </div>


        
        <div class="mb-3">
            <label>Background Image</label>
            <input type="file" name="background_image" class="form-control">
            <?php if(!empty($setting->background_image)): ?>
                <img src="<?php echo e(asset('storage/settings/' . basename($setting->background_image))); ?>" alt="Background" style="height: auto;
    width: 100px; margin-top:10px;">
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
</div>

<script>
document.getElementById('phone_number').addEventListener('input', function () {
    // Allow only digits
    this.value = this.value.replace(/[^0-9]/g, '');

    // Limit to 10 digits
    if (this.value.length > 10) {
        this.value = this.value.slice(0, 10);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\bexone\resources\views/settings/edit.blade.php ENDPATH**/ ?>