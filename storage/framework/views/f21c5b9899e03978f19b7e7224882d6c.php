<?php $__env->startSection('subhead'); ?>
<title>AI Astrologer</title>
<?php $__env->stopSection(); ?>

<!-- Include SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<style>
    .about1 {
        text-overflow: ellipsis;
        overflow: hidden;
        width: 100px;
        white-space: nowrap;
        display: block;
        position: relative;
        transition: width 0.3s ease;
    }

    .about1:hover {
        overflow: visible;
        white-space: normal;
        width: auto;
        z-index: 10;
    }
</style>
<?php $__env->startSection('subcontent'); ?>
<div class="loader"></div>
<h2 class="intro-y text-lg font-medium mt-10 d-inline">Master AI Chat Bot</h2>

<?php if($aiAstrologers->isEmpty()): ?>
<a class="btn btn-primary shadow-md mr-2 mt-10 d-inline addbtn" href="<?php echo e(route('create.ai.chat.bot')); ?>">Add AI Chat Bot</a>
<?php endif; ?>
<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center">

        <?php if(session('success')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: "<?php echo e(session('success')); ?>",
                    icon: 'success',
                    timer: 2000,
                    timerProgressBar: true,
                    willClose: () => {
                    }
                });
            });
        </script>
        <?php endif; ?>

        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
            <form action="<?php echo e(route('ai.chat.bot')); ?>" method="GET">
                <?php echo csrf_field(); ?>
                <div class="w-56 relative text-slate-500" style="display:inline-block">
                    <input value="<?php echo e($searchString ?? ''); ?>" type="text" class="form-control w-56 box pr-10"
                    placeholder="Search..." id="searchString" name="searchString">
                    <?php if(!empty($searchString)): ?>
                    <a href="<?php echo e(route('ai.chat.bot')); ?>" class="text-slate-500" onclick="clearSearch()">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="x"></i>
                    </a>
                    <?php else: ?>
                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                    <?php endif; ?>
                </div>
                <button class="btn btn-primary shadow-md mr-2">Search</button>
            </form>

        </div>
    </div>
    <!-- BEGIN: Data List -->
</div>
<?php if($aiAstrologers->isNotEmpty()): ?>
<div class="intro-y col-span-12 overflow-auto lg:overflow-visible list-table">
    <table class="table table-report mt-2" aria-label="astrologer-list">
        <thead class="sticky-top">
            <tr>
                <th class="whitespace-nowrap">#</th>
                <th class="whitespace-nowrap">NAME</th>
                <th class="text-center whitespace-nowrap">CHAT CHARGE (INR)</th>
                <th class="text-center whitespace-nowrap">CHAT CHARGE (USD)</th>
                <th class="text-center whitespace-nowrap">System Intruction</th>
                <th class="text-center whitespace-nowrap">ACTIONS</th>
            </tr>
        </thead>
        <tbody id="todo-list">
            <?php
            $no = 0;
            ?>

            <?php $__currentLoopData = $aiAstrologers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $astro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="intro-x">
                <td><?php echo e(($page - 1) * 15 + ++$no); ?></td>
                <td>
                        <div class="flex">
                            <div class="w-10 h-10 image-fit zoom-in">
                                <img class="rounded-full cursor-pointer" 
                                     src="<?php echo e(Str::startsWith($astro->image, ['http://','https://']) ? $astro->image : '/' . $astro->image); ?>"
                                     onerror="this.onerror=null;this.src='/build/assets/images/person.png';"
                                     alt="Customer image"
                                     onclick="openImage('<?php echo e(Str::startsWith($astro->image, ['http://','https://']) ? $astro->image : '/' . $astro->image); ?>')" />
                            </div>
                        </div>
                    </td>
                    
                <td class="text-center">
                    <div>
                        <div class="flex items-center justify-center">
                            <span class="font-medium"><?php echo e($astro->chat_charge); ?></span>
                        </div>
                    </div>
                </td>

                <td class="text-center">
                    <div>
                        <div class="flex items-center justify-center">
                            <span class="font-medium"><?php echo e($astro->chat_charge_usd); ?></span>
                        </div>
                    </div>
                </td>

                <td class="text-center">
                    <div>
                        <div class="flex items-center justify-center">
                            <span class="font-medium about1"><?php echo e($astro->system_intruction); ?></span>
                        </div>
                    </div>
                </td>

                <td class="table-report__action w-56">

                    <div class="flex justify-center items-center">

                        <a class="flex items-center mr-3" href="<?php echo e(route('edit.ai.chat.bot', ['slug' => $astro->slug])); ?>">
                            <i data-lucide="check-square" class="w-4 h-4 mr-1"></i>Edit
                        </a>

                        
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<!-- Fullscreen Image Viewer -->
<div id="imageViewer" class="hidden fixed inset-0 bg-black bg-opacity-80 z-50 flex items-center justify-center">
    <div class="relative flex items-center justify-center w-full h-full">
        <img id="viewImage" class="imagezoom" src="" alt="Zoom Image">
        <button onclick="closeImage()" class="closebtn">✖</button>
    </div>
</div>

<script>
    function openImage(src) {
        document.getElementById("viewImage").src = src;
        document.getElementById("imageViewer").classList.remove("hidden");

        // disable scroll
        document.body.style.overflow = "hidden";
    }

    function closeImage() {
        document.getElementById("imageViewer").classList.add("hidden");

        // enable scroll back
        document.body.style.overflow = "auto";
    }
</script>

<style>
    .closebtn
    {
    position: relative;
    color: black;
    margin-top: -46rem;
    margin-left: -40px;
    font-size: 22px;
    font-weight: 900;
    background: #ffffff;
    color: #000000;
    padding: 7px;
    border-radius: 75px;
    }
    .imagezoom
    {
    background: blue;
    padding: 2px;
    border-radius: 15px;
    margin-top: -27rem;
    margin-left: 20rem;
    width: 22rem;
    height: 22rem;
    }
</style>
<!-- BEGIN: Pagination -->
<?php if($totalRecords > 0): ?>
<div class="d-inline text-slate-500 pagecount">Showing <?php echo e($start); ?> to <?php echo e($end); ?> of <?php echo e($totalRecords); ?> entries</div>
<?php endif; ?>
<div class="d-inline addbtn intro-y col-span-12">
    <nav class="w-full sm:w-auto sm:mr-auto">
        <ul class="pagination">
            <li class="page-item <?php echo e($page == 1 ? 'disabled' : ''); ?>">
                <a class="page-link" href="<?php echo e(route('ai.chat.bot', ['page' => $page - 1, 'searchString' => $searchString])); ?>">
                    <i class="w-4 h-4" data-lucide="chevron-left"></i>
                </a>
            </li>

            <?php
            $showPages = 15; // Number of pages to show at a time
            $halfShowPages = floor($showPages / 2);
            $startPage = max(1, $page - $halfShowPages);
            $endPage = min($startPage + $showPages - 1, $totalPages);
            ?>

            <?php if($startPage > 1): ?>
            <li class="page-item">
                <a class="page-link"
                href="<?php echo e(route('ai.chat.bot', ['page' => 1, 'searchString' => $searchString])); ?>">1</a>
            </li>
            <?php if($startPage > 2): ?>
            <li class="page-item disabled">
                <span class="page-link">...</span>
            </li>
            <?php endif; ?>
            <?php endif; ?>

            <?php for($i = $startPage; $i <= $endPage; $i++): ?>
            <li class="page-item <?php echo e($page == $i ? 'active' : ''); ?>">
                <a class="page-link"
                href="<?php echo e(route('ai.chat.bot', ['page' => $i, 'searchString' => $searchString])); ?>"><?php echo e($i); ?></a>
            </li>
            <?php endfor; ?>

            <?php if($endPage < $totalPages): ?>
            <?php if($endPage < $totalPages - 1): ?>
            <li class="page-item disabled">
                <span class="page-link">...</span>
            </li>
            <?php endif; ?>
            <li class="page-item">
                <a class="page-link"
                href="<?php echo e(route('ai.chat.bot', ['page' => $totalPages, 'searchString' => $searchString])); ?>"><?php echo e($totalPages); ?></a>
            </li>
            <?php endif; ?>

            <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                <a class="page-link"                href="<?php echo e(route('ai.chat.bot', ['page' => $page + 1, 'searchString' => $searchString])); ?>">
                    <i class="w-4 h-4" data-lucide="chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>

<?php else: ?>
<div class="intro-y mt-5" style="height:100%">
    <div style="display:flex;align-items:center;height:100%;">
        <div style="margin:auto">
            <img src="/build/assets/images/nodata.png" style="height:290px" alt="noData">
            <h3 class="text-center">No Data Available</h3>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- END: Pagination -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.7.0/dist/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    function clearSearch() {
        const url = new URL(window.location.href);
        url.searchParams.delete('searchString');  // Remove the searchString from URL
        window.location.href = url.toString();  // Reload the page with the updated URL
    }
</script>


<script>
    function deleteMasterAiChatBot(id) {
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                axios.delete("<?php echo e(route('delete.ai.chat.bot', '')); ?>" + '/' + id)
                .then(response => {
                    swal({
                        title: "Your data has been deleted!",
                        icon: "success",
                    })
                    .then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    swal({
                        title: "Error!",
                        text: error.response.data.error || 'An error occurred while trying to delete the subject.',
                        icon: "error",
                    });
                });
            } else {
                swal({
                    icon: "success",
                    text: "Your data is safe!",
                });
            }
        });
    }
</script>

<script>
    $(window).on('load', function() {
        $('.loader').hide();
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/samarthsharma/Documents/codecanyon-50933419-astroway-astrology-consultation-app-with-php-backend-audiovideo-calls-chat-with-live-streaming/Backend/resources/views/pages/ai-astrologer/master-ai-bot-list.blade.php ENDPATH**/ ?>