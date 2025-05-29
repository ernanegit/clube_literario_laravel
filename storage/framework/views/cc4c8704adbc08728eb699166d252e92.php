

<?php $__env->startSection('title', 'Minhas Inscrições - Clube Literário'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Minhas Inscrições</h1>
    <p class="text-gray-600">Acompanhe todas as suas inscrições em reuniões</p>
</div>

<?php if($inscricoes->count() > 0): ?>
    <div class="space-y-6">
        <?php $__currentLoopData = $inscricoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inscricao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-start space-x-4">
                            <?php if($inscricao->reuniao && $inscricao->reuniao->imagem): ?>
                                <img src="<?php echo e(asset('storage/' . $inscricao->reuniao->imagem)); ?>" 
                                     alt="<?php echo e($inscricao->reuniao->titulo); ?>" 
                                     class="w-20 h-20 object-cover rounded-lg">
                            <?php else: ?>
                                <div class="w-20 h-20 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center rounded-lg">
                                    <span class="text-white text-2xl">📖</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-800 mb-2">
                                    <?php echo e($inscricao->reuniao ? $inscricao->reuniao->titulo : 'Reunião removida'); ?>

                                </h3>
                                
                                <?php if($inscricao->reuniao): ?>
                                    <div class="space-y-1 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <span class="mr-2">🎭</span>
                                            <span><?php echo e($inscricao->reuniao->tema_literario); ?></span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="mr-2">📅</span>
                                            <span><?php echo e($inscricao->reuniao->data_reuniao->format('d/m/Y \à\s H:i')); ?></span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="mr-2">📍</span>
                                            <span><?php echo e($inscricao->reuniao->local); ?></span>
                                        </div>
                                        <?php if($inscricao->reuniao->livro_sugerido): ?>
                                            <div class="flex items-center">
                                                <span class="mr-2">📚</span>
                                                <span><?php echo e($inscricao->reuniao->livro_sugerido); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mt-3 flex items-center space-x-4">
                                    <span class="text-xs text-gray-500">
                                        Inscrito em <?php echo e($inscricao->data_inscricao->format('d/m/Y H:i')); ?>

                                    </span>
                                    
                                    <?php if($inscricao->confirmada): ?>
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">
                                            ✅ Confirmado
                                        </span>
                                    <?php else: ?>
                                        <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                                            ⏳ Pendente
                                        </span>
                                    <?php endif; ?>
                                    
                                    <?php if($inscricao->reuniao && $inscricao->reuniao->data_reuniao < now()): ?>
                                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">
                                            🕒 Realizada
                                        </span>
                                    <?php elseif($inscricao->reuniao && $inscricao->reuniao->data_reuniao <= now()->addHours(24)): ?>
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                                            🔥 Próxima
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if($inscricao->comentarios): ?>
                                    <div class="mt-3 bg-gray-50 rounded p-3">
                                        <span class="text-xs text-gray-500 font-medium">Seus comentários:</span>
                                        <p class="text-sm text-gray-700 mt-1"><?php echo e($inscricao->comentarios); ?></p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 md:mt-0 md:ml-6 flex flex-col space-y-2">
                        <?php if($inscricao->reuniao): ?>
                            <a href="<?php echo e(route('reunioes.show', $inscricao->reuniao)); ?>" 
                               class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors text-center text-sm">
                                Ver Reunião
                            </a>
                            
                            <?php if($inscricao->reuniao->data_reuniao > now()): ?>
                                <button onclick="cancelarInscricao(<?php echo e($inscricao->id); ?>)" 
                                        class="bg-red-100 text-red-600 px-4 py-2 rounded-lg hover:bg-red-200 transition-colors text-center text-sm">
                                    Cancelar
                                </button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <div class="mt-8">
        <?php echo e($inscricoes->links()); ?>

    </div>
<?php else: ?>
    <div class="text-center py-16">
        <div class="text-6xl mb-4">📝</div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Você ainda não tem inscrições</h3>
        <p class="text-gray-500 mb-6">Explore nossas reuniões e faça sua primeira inscrição!</p>
        <a href="<?php echo e(route('reunioes.index')); ?>" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
            Ver Reuniões Disponíveis
        </a>
    </div>
<?php endif; ?>

<script>
function cancelarInscricao(id) {
    if (confirm('Tem certeza que deseja cancelar esta inscrição?')) {
        // Aqui você pode implementar a funcionalidade de cancelamento via AJAX
        alert('Funcionalidade de cancelamento será implementada em breve!');
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ernane\clube_literario\clube-literario\resources\views/inscricoes/minhas.blade.php ENDPATH**/ ?>