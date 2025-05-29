<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Clube Literário'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-md border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-blue-600">
                        📚 Clube Literário
                    </a>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="<?php echo e(route('home')); ?>" class="text-gray-600 hover:text-blue-600 font-medium">
                        Início
                    </a>
                    <a href="<?php echo e(route('reunioes.index')); ?>" class="text-gray-600 hover:text-blue-600 font-medium">
                        Reuniões
                    </a>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('inscricoes.minhas')); ?>" class="text-gray-600 hover:text-blue-600 font-medium">
                            Minhas Inscrições
                        </a>
                        <div class="flex items-center space-x-4">
                            <span class="text-gray-700">Olá, <?php echo e(auth()->user()->name); ?></span>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                    Sair
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-blue-600 font-medium">
                            Entrar
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            Cadastrar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Alerts -->
    <?php if(session('success')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                <?php echo e(session('success')); ?>

            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <?php echo e(session('error')); ?>

            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; <?php echo e(date('Y')); ?> Clube Literário. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html><?php /**PATH C:\Users\ernane\clube_literario\clube-literario\resources\views/layouts/public.blade.php ENDPATH**/ ?>