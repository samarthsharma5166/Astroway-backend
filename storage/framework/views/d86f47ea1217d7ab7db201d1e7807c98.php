

<?php $__env->startSection('subhead'); ?>
    <title>Product Recommend List</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
    <div class="loader"></div>
    <h2 class="intro-y text-lg font-medium mt-10 d-inline">Product Recommends</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            </div>
        </div>
    </div>
    <?php if($totalRecords > 0): ?>
        <!-- BEGIN: Data List -->
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible list-table">
            <table class="table table-report mt-2" aria-label="customer-list">
                <thead class="sticky-top">
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">Product</th>
                        <th class="whitespace-nowrap">User</th>
                        <th class="whitespace-nowrap"><?php echo e(ucfirst($professionTitle)); ?></th>
                        <th class="whitespace-nowrap">Purchased By User</th>
                        <th class="text-center whitespace-nowrap">Recommend Date</th>

                    </tr>
                </thead>
                <tbody id="todo-list">
                    <?php
                        $no = 0;
                    ?>
                    <?php $__currentLoopData = $productrecommend; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="intro-x">
                            <td><?php echo e(($page - 1) * 15 + ++$no); ?></td>
                            <td>
                        <div class="flex">
                            <div class="w-10 h-10 image-fit zoom-in">
                                 <img class="rounded-full cursor-pointer" 
                                     src="<?php echo e(Str::startsWith($clist->productImage, ['http://','https://']) ? $clist->productImage : '/' . $clist->productImage); ?>"
                                     onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                                     alt="Customer image"
                                     onclick="openImage('<?php echo e(Str::startsWith($clist->productImage, ['http://','https://']) ? $clist->productImage : '/' . $clist->productImage); ?>')" />
                            </div>
                        </div>
                    </td>
                            <td>
                                <div class="font-medium whitespace-nowrap">
                                    <?php echo e($clist->userName ? $clist->userName : '-----'); ?></div>
                            </td>
                            <td>
                                <div class="font-medium whitespace-nowrap">
                                    <?php echo e($clist->astrologerName ? $clist->astrologerName : '--'); ?></div>
                            </td>
                            <td>
                                <div class="font-medium whitespace-nowrap">
                                    <?php echo e($clist->product_recommend ? 'Purchased' : 'Not Purchased'); ?></div>
                            </td>
                            <td class="text-center">
                                <?php echo e(date('d-m-Y h:i a', strtotime($clist->recommDateTime)) ? date('d-m-Y h:i a', strtotime($clist->recommDateTime)) : '--'); ?>

                            </td>
                            
                           
                           
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
                       <!-- Fullscreen Image Viewer -->
<div class="image-overlay" id="imageOverlay">
                <img src="your-image.jpg" id="popupImage" alt="Full Screen Image">
                <span class="closebtn" id="closeBtn">&times;</span>
            </div>
            <script>
            const overlay = document.getElementById('imageOverlay');
            const closeBtn = document.getElementById('closeBtn');
            function openImage(src) {
                document.getElementById('popupImage').src = src;
                overlay.classList.add('active');
            }
            closeBtn.addEventListener('click', () => {
                overlay.classList.remove('active');
            });
            overlay.addEventListener('click', (e) => {
                if(e.target === overlay) {
                    overlay.classList.remove('active');
                }
            });
            </script>
        
        <!-- END: Data List -->
        <!-- BEGIN: Pagination -->
        <?php if($totalRecords > 0): ?>
            <div class="d-inline text-slate-500 pagecount">Showing <?php echo e($start); ?> to <?php echo e($end); ?> of
                <?php echo e($totalRecords); ?> entries</div>
        <?php endif; ?>
        <div class="d-inline intro-y col-span-12 addbtn ">
            <nav class="w-full sm:w-auto sm:mr-auto">
                <ul class="pagination" id="pagination">
                    <li class="page-item <?php echo e($page == 1 ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('productRecommend', ['page' => $page - 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                            <a class="page-link"
                                href="<?php echo e(route('productRecommend', ['page' => $i + 1])); ?>"><?php echo e($i + 1); ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('productRecommend', ['page' => $page + 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php else: ?>
        <div class="intro-y" style="height:100%">
            <div style="display:flex;align-items:center;height:100%;">
                <div style="margin:auto">
                    <img src="/build/assets/images/nodata.png" style="height:290px" alt="noData">
                    <h3 class="text-center">No Data Available</h3>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/samarthsharma/Documents/codecanyon-50933419-astroway-astrology-consultation-app-with-php-backend-audiovideo-calls-chat-with-live-streaming/Backend/resources/views/pages/product-recommend.blade.php ENDPATH**/ ?>