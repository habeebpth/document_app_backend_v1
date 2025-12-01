<?php $__env->startSection('content'); ?>

<style>
    .users-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px;
    }

    h1 {
        text-align: center;
        margin-bottom: 25px;
    }

    .create-btn {
        display: block;
        width: fit-content;
        margin: 0 auto 20px auto;
        background: #007bff;
        color: white;
        padding: 10px 18px;
        text-decoration: none;
        border-radius: 5px;
    }

    .create-btn:hover {
        background: #0056b3;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table th, table td {
        padding: 12px;
        border: 1px solid #ccc;
        text-align: center;
    }

    table th {
        background: #f7f7f7;
        font-weight: bold;
    }

    .action-btns a,
    .action-btns button {
        margin: 0 5px;
        padding: 6px 12px;
        background: #17a2b8;
        color: white;
        border: none;
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
    }

    .action-btns a:hover {
        background: #0f7283;
    }

    .delete-btn {
        background: #dc3545;
    }

    .delete-btn:hover {
        background: #a11928;
    }
</style>


<div class="users-container">

    <h1>Users</h1>

    <a href="<?php echo e(route('users.create')); ?>" class="create-btn">➕ Create New User</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>Action</th>
        </tr>

        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($user->id); ?></td>
            <td><?php echo e($user->name); ?></td>
            <td><?php echo e($user->email); ?></td>
            <td><?php echo e(implode(', ', $user->roles->pluck('name')->toArray())); ?></td>
            <td class="action-btns">
                <a href="<?php echo e(route('users.edit', $user->id)); ?>">Edit</a>

                <form action="<?php echo e(route('users.destroy', $user->id)); ?>"
                      method="POST"
                      style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="delete-btn">Delete</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </table>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\USER\Desktop\bexone\resources\views/users/index.blade.php ENDPATH**/ ?>