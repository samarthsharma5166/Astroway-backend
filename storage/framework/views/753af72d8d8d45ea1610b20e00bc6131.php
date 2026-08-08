

<?php $__env->startSection('subhead'); ?>
<title>Add Puja</title>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('subcontent'); ?>
<style>
    .upload__inputfile {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }

    .upload__btn {
        display: inline-block;
        font-weight: 600;
        color: #fff;
        text-align: center;
        min-width: 116px;
        padding: 5px;
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid;
        background-color: #4045ba;
        border-color: #4045ba;
        border-radius: 10px;
        line-height: 26px;
        font-size: 14px;
    }

    .upload__btn:hover {
        background-color: unset;
        color: #4045ba;
        transition: all 0.3s ease;
    }

    .upload__btn-box {
        margin-bottom: 10px;
    }

    .upload__img-wrap {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }

    .upload__img-box {
        width: 200px;
        padding: 0 10px;
        margin-bottom: 12px;
    }

    .upload__img-close {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: rgba(0, 0, 0, 0.5);
        position: absolute;
        top: 10px;
        right: 10px;
        text-align: center;
        line-height: 24px;
        z-index: 1;
        cursor: pointer;
    }

    .upload__img-close:after {
        content: "✖";
        font-size: 14px;
        color: white;
    }

    .img-bg {
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        position: relative;
        padding-bottom: 100%;
    }
</style>

<div class="grid grid-cols-12 gap-6 mt-5">
    <div class="intro-y col-span-12 mt-2">
        <div class="intro-y box">
            <div
                class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">Add Puja</h2>
            </div>
            <div class="p-5">
                <form action="<?php echo e(isset($puja) ? route('puja.update', $puja->id) : route('puja.store')); ?>" method="POST"
                    enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <!-- Title and Subtitle (Col-6 Col-6) -->
                    <div class="grid grid-cols-12 gap-6">
                        <div class="col-span-12 sm:col-span-6">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control w-full" required
                                value="<?php echo e(old('title',@$puja->puja_title)); ?>" placeholder="Enter title">
                        </div>
                        <div class="col-span-12 sm:col-span-6">
                            <label for="subtitle" class="form-label">Subtitle <span class="text-danger">*</span></label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control w-full" required
                                value="<?php echo e(old('subtitle',@$puja->puja_subtitle)); ?>" placeholder="Enter subtitle">
                        </div>
                    </div>
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-6 md:col-span-6">
                            <label id="input-group" class="form-label">Start Date Time <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" placeholder="FromTime"
                                name="puja_start_datetime" id="puja_start_datetime" aria-describedby="input-group-4"
                                value="<?php echo e(isset($puja) ? date('Y-m-d\TH:i', strtotime($puja->puja_start_datetime)) : old('puja_start_datetime')); ?>">
                        </div>
                        

                        <div class="intro-y col-span-6 md:col-span-6">
                            <label id="input-group" class="form-label">Puja Duration (in minutes) <span class="text-danger">*</span></label>
                            <input type="text" name="puja_duration" id="puja_duration" class="form-control w-full"
                                value="<?php echo e(old('puja_duration',@$puja->puja_duration)); ?>" placeholder="120" required>
                        </div>

                    </div>

                    <!-- Category and Place (Col-6 Col-6) -->
                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 sm:col-span-4">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select w-full" required>
                                <option value="">Select Category</option>
                                <?php $__currentLoopData = $pujaCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pujacat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($pujacat->id); ?>" <?php echo e((isset($puja) && $puja->category_id == $pujacat->id) ? 'selected' : (old('category_id') == $pujacat->id ? 'selected' : '')); ?>>
                                        <?php echo e($pujacat->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                       
                        <div class="col-span-12 sm:col-span-4">
                            <label for="place" class="form-label">Place <span class="text-danger">*</span></label>
                            <input type="text" name="place" id="place" value="<?php echo e(old('place',@$puja->puja_place)); ?>"
                                class="form-control w-full" placeholder="Enter place" required>
                        </div>
                        <div class="col-span-12 sm:col-span-4">
                            <label for="package_id" class="form-label">Select Package <span class="text-danger">*</span></label>
                            <select name="package_id[]" id="package_id" class="form-control select2" multiple required>
                                <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($package->id); ?>"
                                        <?php if(is_array(old('package_id')) && in_array($package->id, old('package_id'))): ?>
                                            selected
                                        <?php elseif(isset($puja) && is_array($puja->package_id) && in_array($package->id, $puja->package_id)): ?>
                                            selected
                                        <?php endif; ?>>
                                        <?php echo e($package->title); ?> - <?php echo e($package->package_price); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                        </div>
                    </div>
                    <!-- Description (Full Width) -->
                    <div class="mt-5">
                        <label for="description" class="form-label">About Puja <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control w-full" required
                            placeholder="Enter description"><?php echo e(old('description',@$puja->long_description)); ?></textarea>
                    </div>
                    <!-- Puja Benefits Section -->
                    <div class="border border-gray-300 p-4 rounded mt-5">
                        <h3 class="text-lg font-medium">Puja Benefits</h3>
                        <button type="button" id="add-benefit" class="btn btn-outline-primary mt-3">+ Add
                            Benefit</button>

                        <div id="puja-benefits" class="grid grid-cols-12 gap-6 mt-3">

                            <?php if(isset($puja) && !empty($puja->puja_benefits) && is_array($puja->puja_benefits)): ?>
                                <?php $__currentLoopData = $puja->puja_benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benkey => $ben): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <div class="col-span-12 sm:col-span-6 relative border border-gray-300 p-4 rounded mt-3">
                                        <h3 class="font-bold mb-2"> Benefit </h3>

                                        <input type="text" name="benefit_title[]"
                                            class="form-control w-full mb-2 border border-gray-300 p-2 rounded"
                                            value="<?php echo e($ben['title'] ?? ''); ?>" placeholder="Enter benefit title" required>

                                        <textarea name="benefit_description[]"
                                            class="form-control w-full border border-gray-300 p-2 rounded"
                                            placeholder="Enter benefit description" required><?php echo e($ben['description'] ?? ''); ?></textarea>

                                        <button type="button"
                                            class="absolute top-0 right-0 bg-red-500 text-danger border border-gray-800 rounded-full w-5 h-5 flex items-center justify-center cursor-pointer text-sm badge-button shadow-md">×</button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- end sections -->
                    <div class="upload__box mt-5">
                        <div class="upload__btn-box">
                            <label class="upload__btn">
                                <p>Upload images</p>
                                <input type="file" multiple="" name="puja_images[]" data-max_length="20"
                                    class="upload__inputfile">
                            </label>
                        </div>
                        <div class="upload__img-wrap">
                            <?php if(isset($puja) && !empty($puja->puja_images) && is_array($puja->puja_images)): ?>
                                <?php $__currentLoopData = $puja->puja_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imgkey => $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="upload__img-box">
                                        <div style="background-image: url('<?php echo e(asset($img)); ?>');" class="img-bg"
                                            data-file="<?php echo e($img); ?>">
                                            <input type="file" name="old_images[]" multiple  style="display:none;">
                                            <input type="hidden" name="existing_images[]" value="<?php echo e($img); ?>">
                                            <div class="upload__img-close" name="removed_images">×</div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="mt-5">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    $(document).ready(function () {
        jQuery('.select2').select2({
            allowClear: true,
            tokenSeparators: [',', ' ']
        });
    });

    jQuery(document).ready(function () {
        ImgUpload();
    });

    function ImgUpload() {
        var imgWrap = "";
        var imgArray = [];

        $('.upload__inputfile').each(function () {
            $(this).on('change', function (e) {
                imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                var maxLength = $(this).attr('data-max_length');

                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
                var iterator = 0;
                filesArr.forEach(function (f) {

                    if (!f.type.match('image.*')) {
                        return;
                    }

                    if (imgArray.length >= maxLength) {
                        return false;
                    } else {
                        imgArray.push(f);

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                            imgWrap.append(html);
                            iterator++;
                        }
                        reader.readAsDataURL(f);
                    }
                });
            });
        });

        $('body').on('click', ".upload__img-close", function () {
            var file = $(this).parent().data("file");
            imgArray = imgArray.filter(f => f.name !== file);
            $(this).closest('.upload__img-box').remove();
        });

        // Optionally reset imgArray on form submit
        $('form').on('submit', function () {
            imgArray = [];
        });
    }



    document.addEventListener('DOMContentLoaded', function () {
        let benefitCount = 0; // Initialize counter

        document.getElementById('add-benefit').addEventListener('click', function () {
            const benefitContainer = document.getElementById('puja-benefits');

            // Increment the counter
            benefitCount++;

            // Create benefit section
            const newBenefit = document.createElement('div');
            newBenefit.classList.add('col-span-12', 'sm:col-span-6', 'relative', 'border', 'border-gray-300', 'p-4', 'rounded', 'mt-3');

            // Create heading for benefit
            const heading = document.createElement('h3');
            heading.textContent = ` Benefit `;
            heading.classList.add('font-bold', 'mb-2');

            // Create input for benefit title
            const titleInput = document.createElement('input');
            titleInput.type = 'text';
            titleInput.name = 'benefit_title[]';
            titleInput.classList.add('form-control', 'w-full', 'mb-2', 'border', 'border-gray-300', 'p-2', 'rounded');
            titleInput.placeholder = 'Enter benefit title';

            // Create textarea for benefit description
            const descriptionTextarea = document.createElement('textarea');
            descriptionTextarea.name = 'benefit_description[]';
            descriptionTextarea.classList.add('form-control', 'w-full', 'border', 'border-gray-300', 'p-2', 'rounded');
            descriptionTextarea.placeholder = 'Enter benefit description';

            // Create remove button (badge style)
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.innerHTML = '&times;';
            removeButton.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-danger', 'border', 'border-gray-800', 'rounded-full', 'w-5', 'h-5', 'flex', 'items-center', 'justify-center', 'cursor-pointer', 'text-sm', 'badge-button', 'shadow-md');

            // Remove benefit section on button click
            removeButton.addEventListener('click', function () {
                benefitContainer.removeChild(newBenefit);
            });

            // Append heading, title input, description textarea, and remove button to the new benefit
            newBenefit.appendChild(heading);
            newBenefit.appendChild(titleInput);
            newBenefit.appendChild(descriptionTextarea);
            newBenefit.appendChild(removeButton);

            // Append the new benefit to the benefit container
            benefitContainer.appendChild(newBenefit);
        });

        // Function to get ordinal number
        function ordinalNumber(num) {
            const suffix = ['th', 'st', 'nd', 'rd'];
            const value = num % 100;
            return num + (suffix[(value - 20) % 10] || suffix[value] || suffix[0]);
        }
    });

</script>
<script>
    <?php if($errors->any()): ?>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            toastr.error("<?php echo e($error); ?>");
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/samarthsharma/Documents/codecanyon-50933419-astroway-astrology-consultation-app-with-php-backend-audiovideo-calls-chat-with-live-streaming/Backend/resources/views/pages/add-puja.blade.php ENDPATH**/ ?>