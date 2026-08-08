<style>
    .loader_full__LR0ml {
    transition: opacity .4s ease;
}
.loader_image__D6P69 {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.object-cover {
    -o-object-fit: cover;
    object-fit: cover;
}
.read-more
        {
            color :blue;
        }

</style>

<?php $__env->startSection('content'); ?>
<div class="py-5 bg-light">
    <div class="container d-flex flex-column gap-5">
        <h2 class="position-relative border-bottom pb-2 text-dark">
            Ours Blogs
            <span class="position-absolute bottom-0 start-50 translate-middle-x bg-warning d-block rounded"
                  style="width: 110px; height: 3px; margin-top: -1px;">
            </span>
        </h2>
        <?php if(isset($bloglist) && count($bloglist)>0): ?>
        <div class="row justify-content-strat">

            <?php $__currentLoopData = $bloglist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mt-4">
                <a href="<?php echo e(route('front.getBlogDetails', ['slug' => $blog->slug])); ?>" class="text-decoration-none">
                    <div class="product-card parad-shivling shadow-sm overflow-hidden p-0">
                        <div class="position-relative" style="height:250px;">
                            <?php
                                $extension = pathinfo($blog->blogImage, PATHINFO_EXTENSION);
                                $videoExtensions = ['mp4', 'webm', 'ogg'];
                            ?>

                            

                            <?php if(in_array($extension, $videoExtensions)): ?>
                                <video class="product-image position-absolute w-100 h-100 d-flex" controls>
                                    <source src="<?php echo e(asset($blog->blogImage)); ?>" type="video/<?php echo e($extension); ?>">
                                    Your browser does not support the video tag.
                                </video>
                            <?php else: ?>
                                <img src="<?php echo e(asset($blog->blogImage)); ?>"
                                    class="product-image position-absolute w-100 h-100"
                                    style="top: 0; left: 0; object-fit: cover;">
                            <?php endif; ?>
                        </div>
                        <div class="p-3 text-left">
                            <h3 class="font-weight-700"><?php echo e($blog->title); ?></h3>
                            <p class="text-dark">
                                <?php echo \Illuminate\Support\Str::words($blog->description, 15); ?>

                            </p>
                            <span class="mt-1 text-blue-500 group-hover:text-black text-sm group-hover:underline read-more">
                                Read More →
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



        </div>
        <?php else: ?>
        <h3 class="mt-5 mb-5 text-center">No Blog Available</h3>
        <?php endif; ?>
        <!-- Pagination Controls -->
        <div class="mt-4 d-flex justify-content-center">
            <?php echo e($bloglist->links()); ?>

        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>




<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/samarthsharma/Documents/codecanyon-50933419-astroway-astrology-consultation-app-with-php-backend-audiovideo-calls-chat-with-live-streaming/Backend/resources/views/frontend/pages/blogs.blade.php ENDPATH**/ ?>