<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title>Employee Management System</title>


<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />

<!-- Bootstrap Css -->
<link href="<?php echo e(asset('build/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="<?php echo e(asset('build/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="<?php echo e(asset('build/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
<!-- custom Css-->
<link href="<?php echo e(asset('build/css/custom.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.1/dist/sweetalert2.min.css" rel="stylesheet">


<?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo e(route('employees.index')); ?>">Employee Management System</a>
    <div class="d-flex">
      <?php if(auth()->guard()->check()): ?>
      <span class="me-3"><?php echo e(auth()->user()->name); ?></span>
      <form action="<?php echo e(route('logout')); ?>" method="POST"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-secondary">Logout</button></form>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container mt-4">
    <?php echo $__env->yieldContent('content'); ?>
</div>

<script src="<?php echo e(asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('build/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(asset('build/libs/node-waves/waves.min.js')); ?>"></script>
<script src="<?php echo e(asset('build/libs/feather-icons/feather.min.js')); ?>"></script>
<script src="<?php echo e(asset('build/js/pages/plugins/lord-icon-2.1.0.js')); ?>"></script>
<script src="<?php echo e(asset('build/js/plugins.js')); ?>"></script>
<script src="<?php echo e(asset('build/js/layout.js')); ?>"></script>
<script src="<?php echo e(asset('build/libs/prismjs/prism.js')); ?>"></script>
<script src="<?php echo e(asset('build/js/app.js')); ?>"></script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.1/dist/sweetalert2.all.min.js"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="<?php echo e(asset('build/js/pages/datatables.init.js')); ?>"></script>




<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\USER\Desktop\bexone\resources\views/layouts/app.blade.php ENDPATH**/ ?>