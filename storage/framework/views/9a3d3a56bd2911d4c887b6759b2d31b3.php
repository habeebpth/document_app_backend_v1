<?php $__env->startSection('content'); ?>
<div style="max-width: 600px; margin: 0 auto; text-align: center;">

    <h1 style="margin-bottom: 20px;">Edit User</h1>

    <form method="POST" action="<?php echo e(route('users.update', $user->id)); ?>" 
          style="width: 100%; background: #f8f9fa; padding: 25px; border-radius: 10px;">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <input type="text" 
               name="name" 
               value="<?php echo e($user->name); ?>" 
               placeholder="Name"
               required
               style="width: 100%; padding: 10px; margin-bottom: 15px;">

        <input type="email" 
               name="email" 
               value="<?php echo e($user->email); ?>" 
               placeholder="Email"
               required
               style="width: 100%; padding: 10px; margin-bottom: 15px;">

        <input type="password" 
               name="password" 
               placeholder="Password (leave blank to keep current)"
               style="width: 100%; padding: 10px; margin-bottom: 15px;">

        <input type="password" 
               name="password_confirmation" 
               placeholder="Confirm Password"
               style="width: 100%; padding: 10px; margin-bottom: 15px;">

        <label style="font-weight: bold; display: block; margin-bottom: 10px;">Roles</label>

        <select name="roles[]" 
                multiple 
                required
                style="width: 100%; padding: 10px; height: 120px; margin-bottom: 20px;">
            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($role->name); ?>" 
                    <?php echo e($user->roles->pluck('name')->contains($role->name) ? 'selected' : ''); ?>>
                    <?php echo e($role->name); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button type="submit"
                style="width: 100%; padding: 12px; background: #007bff; color: #fff; 
                       border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">
            Update
        </button>
    </form>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\bexone\resources\views/users/edit.blade.php ENDPATH**/ ?>