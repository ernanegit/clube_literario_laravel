

<?php $__env->startSection('title', 'Todas as Reuniões - Clube Literário'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Todas as Reuniões</h1>
    <p class="text-gray-600">Explore todas as nossas reuniões literárias e encontre a perfeita para você</p>
</div>

<?php if($reunioes->count() > 0): ?>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php $__currentLoopData = $reunioes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reuniao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                <?php if($reuniao->imagem): ?>
                    <img src="<?php echo e(asset('storage/' . $reuniao->imagem)); ?>" alt="<?php echo e($reuniao->titulo); ?>" class="w-full h-48 object-cover">
                <?php else: ?>
                    <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                        <span class="text-white text-6xl">📖</span>
                    </div>
                <?php endif; ?>
                
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2"><?php echo e($reuniao->titulo); ?></h3>
                    <p class="text-gray-600 mb-3"><?php echo e(Str::limit($reuniao->descricao, 100)); ?></p>
                    
                    <div class="space-y-2 text-sm text-gray-500 mb-4">
                        <div class="flex items-center">
                            <span class="mr-2">🎭</span>
                            <span><?php echo e($reuniao->tema_literario); ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2">📅</span>
                            <span><?php echo e($reuniao->data_reuniao->format('d/m/Y H:i')); ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="mr-2">📍</span>
                            <span><?php echo e($reuniao->local); ?></span>
                        </div>
                        <?php if($reuniao->livro_sugerido): ?>
                            <div class="flex items-center">
                                <span class="mr-2">📚</span>
                                <span><?php echo e($reuniao->livro_sugerido); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <?php
                            $totalInscritos = \App\Models\Inscricao::where('reuniao_id', $reuniao->id)->count();
                            $vagas = $reuniao->limite_participantes - $totalInscritos;
                        ?>
                        <span class="text-sm text-gray-500">
                            <?php echo e($vagas); ?> vagas restantes
                        </span>
                        <a href="<?php echo e(route('reunioes.show', $reuniao)); ?>" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                            Ver Detalhes
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <div class="mt-8">
        <?php echo e($reunioes->links()); ?>

    </div>
<?php else: ?>
    <div class="text-center py-16">
        <div class="text-6xl mb-4">📚</div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Nenhuma reunião disponível</h3>
        <p class="text-gray-500">Fique atento! Novas reuniões serão anunciadas em breve.</p>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ernane\clube_literario\clube-literario\resources\views/reunioes/index.blade.php ENDPATH**/ ?>