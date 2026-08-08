<?php if($paginator->hasPages()): ?>
    <nav aria-label="Pagination Navigation">
        
        <div class="mb-3">
            <span class="text-muted">
                Showing <?php echo e($paginator->firstItem()); ?> to <?php echo e($paginator->lastItem()); ?> of <?php echo e($paginator->total()); ?> items (Page <?php echo e($paginator->currentPage()); ?> of <?php echo e($paginator->lastPage()); ?>)
            </span>
        </div>

        
        <ul class="pagination justify-content-center">
            
            <?php if($paginator->onFirstPage()): ?>
                <li class="page-item disabled">
                    <span class="page-link">
                        <?php echo __('pagination.previous'); ?>

                    </span>
                </li>
            <?php else: ?>
                <li class="page-item">
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="page-link">
                        <?php echo __('pagination.previous'); ?>

                    </a>
                </li>
            <?php endif; ?>

            
            <?php if($paginator->hasMorePages()): ?>
                <li class="page-item">
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="page-link">
                        <?php echo __('pagination.next'); ?>

                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">
                        <?php echo __('pagination.next'); ?>

                    </span>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php /**PATH /Users/samarthsharma/Documents/codecanyon-50933419-astroway-astrology-consultation-app-with-php-backend-audiovideo-calls-chat-with-live-streaming/Backend/resources/views/vendor/pagination/simple-tailwind.blade.php ENDPATH**/ ?>