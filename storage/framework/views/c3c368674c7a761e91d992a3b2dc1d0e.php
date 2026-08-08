

<?php $__env->startSection('subhead'); ?>
    <title>ContactUs List</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
<link href="https://vjs.zencdn.net/8.3.0/video-js.css" rel="stylesheet" />


    <div class="loader"></div>
    <h2 class="intro-y text-lg font-medium mt-10 d-inline">Calls Monitoring</h2>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                <form method="GET" action="<?php echo e(route('calls.monitoring')); ?>" id="searchForm">
                    
                    <select name="astrologerId" id="astrologerId">
                        <option value="">-- Select <?php echo e(ucfirst($professionTitle)); ?> --</option>
                        <?php $__currentLoopData = $astrologers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $astrologer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($astrologer->id); ?>" <?php echo e(request('astrologerId') == $astrologer->id ? 'selected' : ''); ?>>
                                <?php echo e($astrologer->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <select name="userId" id="userId">
                        <option value="">-- Select User --</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($user->id); ?>" <?php echo e(request('userId') == $user->id ? 'selected' : ''); ?>>
                                <?php echo e($user->name); ?> (<?php echo e($user->contactNo); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <input type="date" name="date" id="date" value="<?php echo e(request('date')); ?>">

                   <button type="submit" class="btn btn-primary">
                        <i data-lucide="search"  class="w-4 h-4 mr-1"></i> Search
                    </button>
                
                    <button type="button" id="clearButton" class="btn btn-secondary">
                        <i data-lucide="x"  class="w-4 h-4 mr-1"></i> Clear
                    </button>
                </form>
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
                        <th class="whitespace-nowrap">Counsellor Name</th>
                        <th class="whitespace-nowrap">User Name</th>
                        <th class="whitespace-nowrap">Date</th>
                        <th class="whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody id="todo-list">
                    <?php
                        $no = 0;
                    ?>
                    <?php $__currentLoopData = $completedCalls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="intro-x">
                            <td><?php echo e(($page - 1) * 15 + ++$no); ?></td>

                            <td>
                                <div class="font-medium whitespace-nowrap">
                                    <?php echo e($clist->astrologerName ? $clist->astrologerName : $clist->contactNo); ?>

                                    
                                </div>
                            </td>
                           
                            <td>
                                <div class="font-medium whitespace-nowrap">
                                    <?php echo e($clist->Username ? $clist->Username : $clist->contactNo); ?>

                                     
                                </div>
                            </td>
                             <td>
                                <div class="font-medium whitespace-nowrap">
                                    <?php echo e($clist->created_at ? date("d-m-Y h:i a" , strtotime($clist->created_at)) : '--'); ?></div>
                            </td>

                           <td>
                                <?php
                                    $bucketname = DB::table('systemflag')->where('name', 'GoogleBucketName')->select('value')->first();
                                    $file = "https://storage.googleapis.com/{$bucketname->value}/{$clist->sId}_{$clist->channelName}.m3u8";
                                ?>
                                <?php if(!empty($clist->sId)): ?>
                                <a class="flex items-center mr-3 text-success" href="javascript:void(0);" onclick="toggleAudio('<?php echo e($clist->callId); ?>', '<?php echo e($file); ?>', this)">
                                    ▶️ Play
                                </a>
                                <?php else: ?>
                                <p>---</p>
                                <?php endif; ?>
                            </td>
                        
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
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
                        <a class="page-link" href="<?php echo e(route('calls.monitoring', ['page' => $page - 1])); ?>">
                            <i class="w-4 h-4" data-lucide="chevron-left"></i>
                        </a>
                    </li>
                    <?php for($i = 0; $i < $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($page == $i + 1 ? 'active' : ''); ?> ">
                            <a class="page-link"
                                href="<?php echo e(route('calls.monitoring', ['page' => $i + 1])); ?>"><?php echo e($i + 1); ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo e($page == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link" href="<?php echo e(route('calls.monitoring', ['page' => $page + 1])); ?>">
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
    <link href="https://cdn.jsdelivr.net/npm/lucide-icons@latest/dist/lucide.min.css" rel="stylesheet">

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="https://vjs.zencdn.net/8.3.0/video.min.js"></script>

    <!-- Optional: hls.js for additional HLS support -->
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    
   <script>
   let currentPlayer = null; // Track the currently playing player

    function toggleAudio(callId, file, element) {
        console.log(file);

        // If a different player is already playing, stop it
        if (currentPlayer && currentPlayer.id !== `hls-player-${callId}`) {
            videojs(currentPlayer.id).pause();
            currentPlayer.style.display = 'none';
            currentPlayer = null;
        }

        // Check if player already exists for this callId
        let existingPlayer = document.getElementById(`hls-player-${callId}`);
        if (!existingPlayer) {
            // Create new player if not exists
            const playerContainer = document.createElement('div');
            playerContainer.innerHTML = `
                <video
                    id="hls-player-${callId}"
                    class="video-js vjs-default-skin"
                    controls
                    width="200"
                    height="150"
                    style="display: block;"
                ></video>
            `;
            element.parentNode.appendChild(playerContainer);

            const video = videojs(`hls-player-${callId}`);
            video.src({
                src: file,
                type: 'application/vnd.apple.mpegurl'
            });
            video.play();

            currentPlayer = document.getElementById(`hls-player-${callId}`);
        } else {
            // If player exists, toggle visibility and play/pause
            if (existingPlayer.style.display === 'none') {
                existingPlayer.style.display = 'block';
                videojs(`hls-player-${callId}`).play();
                currentPlayer = existingPlayer;
            } else {
                videojs(`hls-player-${callId}`).pause();
                existingPlayer.style.display = 'none';
                currentPlayer = null;
            }
        }
    }
</script>


    <script>
        $(window).on('load', function() {
            $('.loader').hide();
        })
    </script>
     <script>
    document.getElementById('clearButton').addEventListener('click', function () {
        const form = document.getElementById('searchForm');
        form.reset(); // Reset the form fields to their default values
        window.location.href = "<?php echo e(route('calls.monitoring')); ?>"; // Redirect to remove query parameters
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/samarthsharma/Documents/codecanyon-50933419-astroway-astrology-consultation-app-with-php-backend-audiovideo-calls-chat-with-live-streaming/Backend/resources/views/pages/data-monitor/calls-monitoring.blade.php ENDPATH**/ ?>