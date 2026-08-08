<?php $__env->startSection('subhead'); ?>
<?php $__env->stopSection(); ?>
<style>
    #error-message {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
    }
    .gap-6 {
        gap: 0.5rem!important;
    }
</style>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

<?php $__env->startSection('subcontent'); ?>
<div class="loader"></div>
<form id="editMasterAiChatBot" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 overflow-auto lg:overflow-visible "></div>
    </div>
    <div id="error-message" class="text-danger" style="display: none;"></div>

    <div class="intro-y box  pt-5 mt-5">
        <div id="link-tab" class="p-3">
            <button type="submit"class="btn btn-primary shadow-md mr-2 d-inline addbtn">Update
            </button>
            <ul class="nav nav-link-tabs" role="tablist">
                <li id="example-1-tab" class="nav-item flex-1" role="presentation">
                    <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#example-tab-1"
                    type="button" role="tab" aria-controls="example-tab-1" aria-selected="true">
                    Personal Detail</button>
                </li>
            </ul>

            <div class="tab-content mt-5 editastrologertab">
                <div id="example-tab-1" class="tab-pane leading-relaxed active" role="tabpanel" aria-labelledby="example-1-tab">
                    <div class="input">
                        <div>
                            <label for="regular-form-1" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo e(@$aiAstro->name); ?>"
                            placeholder="AI Astrologer Name"  pattern="^[a-zA-Z\s]{2,50}$" title="Name should contain only letters and be between 2 and 50 characters long." required
                            oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                        </div>
                    </div>

                    <div class="input mt-3">
                        <div>
                            <label for="regular-form-1" class="form-label">Add Your Charge(As per Minute in INR)</label>
                            <input type="text" name="chat_charge" id="charge" class="form-control"
                            placeholder="Charge"
                            value="<?php echo e(@$aiAstro->chat_charge); ?>"  pattern="\d*"
                            inputmode="numeric" title="Charge should be a number."
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>

                    <div class="input mt-3">
                        <div>
                            <label for="regular-form-1" class="form-label">Add Your Charge(As per Minute in USD)</label>
                            <input type="text" name="chat_charge_usd" id="chat_charge_usd" class="form-control"
                            placeholder="Charge"
                            value="<?php echo e(@$aiAstro->chat_charge); ?>"  pattern="\d*"
                            inputmode="numeric" title="Charge should be a number."
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>

                    <div class="input mt-3">
                        <div>
                            <label for="regular-form-1" class="form-label">System Intruction</label>
                            <textarea type="text" name="system_intruction" id="system_intruction"
                            class="form-control" placeholder="System Intruction" cols="5" rows="5"
                            required><?php echo @$aiAstro->system_intruction; ?></textarea>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 mt-2">
                        <label for="profile" class="form-label">Profile Image</label>
                        <img id="thumb" width="150px" src="<?php echo e(asset($aiAstro->image)); ?>"
                        alt="Customer image" onerror="this.style.display='none';" class="border border-warning"/>
                        <input type="file" class="mt-2" name="image" id="profileImage"
                        onchange="preview()" accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"  ></script>
<script type="text/javascript"></script>
<script>
    var spinner = $('.loader');
    $(window).on('load', function() {
        $('.loader').hide();
    });

    function preview() {
        document.getElementById("thumb").style.display = "block";
        thumb.src = URL.createObjectURL(event.target.files[0]);
    }
</script>

<script>

    jQuery(function() {
        jQuery('#editMasterAiChatBot').submit(function(e) {
            e.preventDefault();

            var form = document.getElementById('editMasterAiChatBot');
            if (form.checkValidity() === false) {
                form.reportValidity();
                return;
            }

            spinner.show();

            jQuery('.input .text-danger').remove();

            var data = new FormData(this);
            var masterAiChatBotId = <?php echo e($aiAstro->id); ?>;
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo e(route('update.ai.chat.bot', '')); ?>/" + masterAiChatBotId,
                data: data,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function(response) {
                    toastr.success(response.success);
                    spinner.hide();
                    location.href = "<?php echo e(route('ai.chat.bot')); ?>";
                },

                error: function(xhr) {
                    spinner.hide();
                    console.log(xhr.responseJSON);

                    if (xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessageDiv = jQuery('#error-message');
                        errorMessageDiv.html('').hide();

                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessageDiv.append('<p>' + errors[key][0] + '</p>');
                            }
                        }
                        errorMessageDiv.show();
                    } else {
                        jQuery('#error-message').html('<p>An unexpected error occurred.</p>').show();
                    }
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('../layout/' . $layout, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/samarthsharma/Documents/codecanyon-50933419-astroway-astrology-consultation-app-with-php-backend-audiovideo-calls-chat-with-live-streaming/Backend/resources/views/pages/ai-astrologer/master-ai-bot-edit.blade.php ENDPATH**/ ?>