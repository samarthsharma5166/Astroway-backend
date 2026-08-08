<?php $__env->startSection('content'); ?>
<?php
     $countries = DB::table('countries')
    ->orderByRaw("CASE WHEN phonecode = 91 THEN 0 ELSE 1 END")
    ->get();
?>

    <div class="pt-1 pb-1 bg-red d-none d-md-block astroway-breadcrumb">
        <div class="container">
            <div class="row afterLoginDisplay">
                <div class="col-md-12 d-flex align-items-center">

                    <span style="text-transform: capitalize; ">


                        <span class="text-white breadcrumbs">
                            <a href="<?php echo e(route('front.home')); ?>" style="color:white;text-decoration:none">
                                <i class="fa fa-home font-18"></i>
                            </a>
                            <i class="fa fa-chevron-right"></i> <span
                                class="breadcrumbtext"><?php echo e($getAstrologer['recordList'][0]['name']); ?></span>
                        </span>

                    </span>

                </div>
            </div>
        </div>
    </div>


    <!--Report and block modal-->
     <div id="reportBlockModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm h-100 d-flex align-items-center">

            <!-- Modal content-->
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold">
                        Reason
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="reportBlockForm">
                         <?php if(authcheck()): ?>
                        <input type="hidden" name="userId" id="userId" value="<?php echo e(authcheck()['id']); ?>">
                        <?php endif; ?>
                        <input type="hidden" id="astrologerId" name="astrologerId" value="<?php echo e($getAstrologer['recordList'][0]['id']); ?>">
                        <div class="text-center">
                            <div class="form-group mt-1">

                                <textarea class="form-control" id="review" name="reason" rows="3" placeholder="Enter your reason"><?php echo e(isset($getUserHistoryReview['recordList'][0]['review']) ? $getUserHistoryReview['recordList'][0]['review'] : ''); ?></textarea>
                            </div>
                            <button class="btn btn-chat" id="reportBlockBtn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--End-->




    
    <div class="modal fade rounded mt-2 mt-md-5 " id="intake" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title font-weight-bold">
                        Birth Details
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <div class="bg-white body">
                        <div class="row ">

                            <div class="col-lg-12 col-12 ">
                                <div class="mb-3 ">

                                    <form class="px-3 font-14" method="post" id="intakeForm">

                                        <?php if(authcheck()): ?>
                                            <input type="hidden" name="userId" value="<?php echo e(authcheck()['id']); ?>">
                                            <input type="hidden" name="countryCode"
                                                value="<?php echo e(authcheck()['countryCode']); ?>">
                                        <?php endif; ?>
                                        <input type="hidden" name="astrologerId"
                                            value="<?php echo e($getAstrologer['recordList'][0]['id']); ?>">
                                        <div class="row">
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="Name">Name<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="Name" name="name" placeholder="Enter Name"
                                                        type="text"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['name'] ?? ''); ?>" pattern="^[a-zA-Z\s]{2,50}$" title="Name should contain only letters and be between 2 and 50 characters long." required
                                                        oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <label for="profileImage">Contact No*</label>
                                                <div class="d-flex inputform country-dropdown-container" style="border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">

                                                    <!-- Country Code Dropdown -->
                                                    <select class="form-control select2" id="countryCode" name="countryCode" style="border: none; border-right: 1px solid #ddd; border-radius: 0; width: 20%;">
                                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option data-country="in" value="<?php echo e($getIntakeForm['recordList'][0]['countryCode'] ?? $country->phonecode); ?>" data-ucname="India">
                                                                +<?php echo e($country->phonecode); ?> <?php echo e($country->iso); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <!-- Mobile Number Input -->
                                                    <input class="form-control mobilenumber text-box single-line" id="contact" maxlength="12" name="phoneNumber"  type="number" value="<?php echo e($getIntakeForm['recordList'][0]['phoneNumber'] ?? ''); ?>" style="border: none; border-radius: 0; width: 130%;" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group">
                                                    <label for="Gender">Gender <span class="color-red">*</span></label>
                                                    <select class="form-control" id="Gender" name="gender" required>
                                                        <option value="Male"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['gender']) && $getIntakeForm['recordList'][0]['gender'] == 'Male' ? 'selected' : ''); ?>>
                                                            Male</option>
                                                        <option value="Female"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['gender']) && $getIntakeForm['recordList'][0]['gender'] == 'Female' ? 'selected' : ''); ?>>
                                                            Female</option>
                                                        <option value="Other"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['gender']) && $getIntakeForm['recordList'][0]['gender'] == 'Other' ? 'selected' : ''); ?>>
                                                            Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <input type="hidden" id="latitude" name="latitude" value="<?php echo e($getIntakeForm['recordList'][0]['latitude'] ?? ''); ?>">
                                                        <input type="hidden" id="longitude" name="longitude" value="<?php echo e($getIntakeForm['recordList'][0]['longitude'] ?? ''); ?>">
                                                        <input type="hidden" id="timezone" name="timezone" value="<?php echo e($getIntakeForm['recordList'][0]['timezone'] ?? '5.5'); ?>">
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="BirthDate">Birthdate<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="BirthDate" name="birthDate" placeholder="Enter Birthdate"
                                                        type="date" required
                                                        value="<?php echo e(isset($getIntakeForm['recordList'][0]['birthDate']) ? date('Y-m-d', strtotime($getIntakeForm['recordList'][0]['birthDate'])) : ''); ?>">
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="BirthTime">Birthtime<span class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="BirthTime" name="birthTime" placeholder="Enter Birthtime"
                                                        type="time"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['birthTime'] ?? ''); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="BirthPlace">Birthplace<span
                                                            class="color-red">*</span></label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="BirthPlace" name="birthPlace" placeholder="Enter Birthplace"
                                                        type="text"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['birthPlace'] ?? ''); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="MaritalStatus">Marital Status<span
                                                            class="color-red">*</span></label>
                                                    <select class="form-control" id="MaritalStatus" name="maritalStatus" required>
                                                        <option value="Single"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['maritalStatus']) && $getIntakeForm['recordList'][0]['maritalStatus'] == 'Single' ? 'selected' : ''); ?>>
                                                            Single</option>
                                                        <option value="Married"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['maritalStatus']) && $getIntakeForm['recordList'][0]['maritalStatus'] == 'Married' ? 'selected' : ''); ?>>
                                                            Married</option>
                                                        <option value="Divorced"
                                                            <?php echo e(isset($getIntakeForm['recordList'][0]['maritalStatus']) && $getIntakeForm['recordList'][0]['maritalStatus'] == 'Divorced' ? 'selected' : ''); ?>>
                                                            Divorced</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="Occupation">Occupation</label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="Occupation" name="occupation" placeholder="Enter Occupation"
                                                        type="text"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['occupation'] ?? ''); ?>">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 py-2">
                                                <div class="form-group mb-0">
                                                    <label for="TopicOfConcern">Topic Of Concern *</label>
                                                    <input class="form-control border-pink matchInTxt shadow-none"
                                                        id="TopicOfConcern" name="topicOfConcern"
                                                        placeholder="Enter Topic Of Concern" type="text"
                                                        value="<?php echo e($getIntakeForm['recordList'][0]['topicOfConcern'] ?? ''); ?>" required>
                                                </div>
                                            </div>

                                            <?php if(authcheck()): ?>
                                                <?php if($getAstrologer['recordList'][0]['isFreeAvailable'] != true): ?>
                                                <input type="hidden" name="isFreeSession"
                                                value="0">
                                                    <div class="col-12 py-3">
                                                        <div class="form-group mb-0">
                                                            <label>Select Time You want to chat<span
                                                                    class="color-red">*</span></label><br>
                                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                                <label class="btn btn-info btn-sm mt-1">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration300" value="300" required> 5 mins
                                                                </label>
                                                                <label class="btn btn-info btn-sm mt-1">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration600" value="600" required> 10 mins
                                                                </label>
                                                                <label class="btn btn-info btn-sm mt-1">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration900" value="900" required> 15 mins
                                                                </label>
                                                                <label class="btn btn-info btn-sm mt-1">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration1200" value="1200" required> 20 mins
                                                                </label>
                                                                <label class="btn btn-info btn-sm mt-1">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration1500" value="1500" required> 25 mins
                                                                </label>
                                                                <label class="btn btn-info btn-sm mt-1">
                                                                    <input type="radio" name="chat_duration"
                                                                        id="chat_duration1800" value="1800" required> 30 mins
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <input type="hidden" name="chat_duration"
                                                        value="<?php echo e($getIntakeForm['default_time']); ?>">
                                                        <input type="hidden" name="isFreeSession"
                                                        value="1">
                                                <?php endif; ?>
                                            <?php endif; ?>



                                        </div>

                                        <div class="col-12 col-md-12 py-3">
                                            <div class="row">

                                                <div class="col-12 pt-md-3 text-center mt-2">
                                                    <button class="font-weight-bold ml-0 w-100 btn btn-chat"
                                                        id="loaderintakeBtn" type="button" style="display:none;"
                                                        disabled>
                                                        <span class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span> Loading...
                                                    </button>
                                                    <button type="submit"
                                                        class="btn btn-block btn-chat px-4 px-md-5 mb-2"
                                                        id="intakeBtn">Start Chat</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    

  

<div class="modal fade rounded mt-2 mt-md-5 " id="callintake" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title font-weight-bold">
                    Birth Details
                </h4>
                <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
            </div>
            <div class="modal-body pt-0 pb-0">
                <div class="bg-white body">
                    <div class="row ">

                        <div class="col-lg-12 col-12 ">
                            <div class="mb-3 ">

                                <form class="px-3 font-14" method="post" id="callintakeForm">

                                    <?php if(authcheck()): ?>
                                    <input type="hidden" name="userId" value="<?php echo e(authcheck()['id']); ?>">
                                    <?php endif; ?>

                                    <input type="hidden" name="call_type" id="call_type" value="">
                                    <input type="hidden" name="astrocharge" id="astrocharge" value="">
                                    <input type="hidden" name="astrologerId" id="astroId" value="<?php echo e($getAstrologer['recordList'][0]['id']); ?>">

                                    <div class="row">
                                        <div class="col-12 col-md-6 py-2">
                                            <div class="form-group mb-0">
                                                <label for="Name">Name<span class="color-red">*</span></label>
                                                <input class="form-control border-pink matchInTxt shadow-none"
                                                    id="Name" name="name" placeholder="Enter Name"
                                                    type="text"
                                                    value="<?php echo e($getIntakeForm['recordList'][0]['name'] ?? ''); ?>"
                                                    pattern="^[a-zA-Z\s]{2,50}$"
                                                    title="Name should contain only letters and be between 2 and 50 characters long."
                                                    required
                                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 py-2">
                                            <label for="profileImage">Contact No*</label>
                                            <div class="d-flex inputform country-dropdown-container" style="border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                                                <!-- Country Code Dropdown -->
                                                <select class="form-control select2" id="countryCode1" name="countryCode" style="border: none; border-right: 1px solid #ddd; border-radius: 0; width: 20%;">
                                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option data-country="in" value="<?php echo e($getIntakeForm['recordList'][0]['countryCode'] ?? $country->phonecode); ?>" data-ucname="India">
                                                        +<?php echo e($country->phonecode); ?> <?php echo e($country->iso); ?>

                                                    </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <!-- Mobile Number Input -->
                                                <input class="form-control mobilenumber text-box single-line" id="contact" maxlength="12"
                                                    name="phoneNumber" type="number"
                                                    value="<?php echo e($getIntakeForm['recordList'][0]['phoneNumber'] ?? ''); ?>"
                                                    style="border: none; border-radius: 0; width: 130%;" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 py-2">
                                            <div class="form-group">
                                                <label for="Gender">Gender <span class="color-red">*</span></label>
                                                <select class="form-control" id="Gender" name="gender" required>
                                                    <option value="Male" <?php echo e(isset($getIntakeForm['recordList'][0]['gender']) && $getIntakeForm['recordList'][0]['gender'] == 'Male' ? 'selected' : ''); ?>>Male</option>
                                                    <option value="Female" <?php echo e(isset($getIntakeForm['recordList'][0]['gender']) && $getIntakeForm['recordList'][0]['gender'] == 'Female' ? 'selected' : ''); ?>>Female</option>
                                                    <option value="Other" <?php echo e(isset($getIntakeForm['recordList'][0]['gender']) && $getIntakeForm['recordList'][0]['gender'] == 'Other' ? 'selected' : ''); ?>>Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 py-2">
                                            <div class="form-group mb-0">
                                                <label for="BirthDate">Birthdate<span class="color-red">*</span></label>
                                                <input class="form-control border-pink matchInTxt shadow-none"
                                                    id="BirthDate" name="birthDate" placeholder="Enter Birthdate"
                                                    type="date"
                                                    value="<?php echo e(isset($getIntakeForm['recordList'][0]['birthDate']) ? date('Y-m-d', strtotime($getIntakeForm['recordList'][0]['birthDate'])) : ''); ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 py-2">
                                            <div class="form-group mb-0">
                                                <label for="BirthTime">Birthtime</label>
                                                <input class="form-control border-pink matchInTxt shadow-none"
                                                    id="BirthTime" name="birthTime" placeholder="Enter Birthtime"
                                                    type="time"
                                                    value="<?php echo e($getIntakeForm['recordList'][0]['birthTime'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <input type="hidden" id="latitude" name="latitude" value="<?php echo e($getIntakeForm['recordList'][0]['latitude'] ?? ''); ?>">
                                        <input type="hidden" id="longitude" name="longitude" value="<?php echo e($getIntakeForm['recordList'][0]['longitude'] ?? ''); ?>">
                                        <input type="hidden" id="timezone" name="timezone" value="<?php echo e($getIntakeForm['recordList'][0]['timezone'] ?? '5.5'); ?>">

                                        <div class="col-12 col-md-6 py-2">
                                            <div class="form-group mb-0">
                                                <label for="BirthPlace">Birthplace<span class="color-red">*</span></label>
                                                <input class="form-control border-pink matchInTxt shadow-none"
                                                    id="BirthPlace" name="birthPlace" placeholder="Enter Birthplace"
                                                    type="text"
                                                    value="<?php echo e($getIntakeForm['recordList'][0]['birthPlace'] ?? ''); ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 py-2">
                                            <div class="form-group mb-0">
                                                <label for="MaritalStatus">Marital Status<span class="color-red">*</span></label>
                                                <select class="form-control" id="MaritalStatus" name="maritalStatus" required>
                                                    <option value="Single" <?php echo e(isset($getIntakeForm['recordList'][0]['maritalStatus']) && $getIntakeForm['recordList'][0]['maritalStatus'] == 'Single' ? 'selected' : ''); ?>>Single</option>
                                                    <option value="Married" <?php echo e(isset($getIntakeForm['recordList'][0]['maritalStatus']) && $getIntakeForm['recordList'][0]['maritalStatus'] == 'Married' ? 'selected' : ''); ?>>Married</option>
                                                    <option value="Divorced" <?php echo e(isset($getIntakeForm['recordList'][0]['maritalStatus']) && $getIntakeForm['recordList'][0]['maritalStatus'] == 'Divorced' ? 'selected' : ''); ?>>Divorced</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 py-2">
                                            <div class="form-group mb-0">
                                                <label for="Occupation">Occupation</label>
                                                <input class="form-control border-pink matchInTxt shadow-none"
                                                    id="Occupation" name="occupation" placeholder="Enter Occupation"
                                                    type="text"
                                                    value="<?php echo e($getIntakeForm['recordList'][0]['occupation'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 py-2">
                                            <div class="form-group mb-0">
                                                <label for="TopicOfConcern">Topic Of Concern</label>
                                                <input class="form-control border-pink matchInTxt shadow-none"
                                                    id="TopicOfConcern" name="topicOfConcern"
                                                    placeholder="Enter Topic Of Concern" type="text"
                                                    value="<?php echo e($getIntakeForm['recordList'][0]['topicOfConcern'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <?php if(authcheck()): ?>
                                        <?php if($isFreeAvailable == false): ?>
                                        <input type="hidden" name="isFreeSession" value="0">
                                        <div class="col-12 py-3">
                                            <div class="form-group mb-0">
                                                <label>Select Time You want to call<span class="color-red">*</span></label><br>
                                                <div class="btn-group-toggle" data-toggle="buttons">
                                                    <label class="btn btn-info btn-sm mt-2">
                                                        <input type="radio" name="call_duration" value="60" required> 1 mins
                                                    </label>
                                                    <label class="btn btn-info btn-sm mt-2">
                                                        <input type="radio" name="call_duration" value="300" required> 5 mins
                                                    </label>
                                                    <label class="btn btn-info btn-sm mt-2">
                                                        <input type="radio" name="call_duration" value="600" required> 10 mins
                                                    </label>
                                                    <label class="btn btn-info btn-sm mt-2">
                                                        <input type="radio" name="call_duration" value="900" required> 15 mins
                                                    </label>
                                                    <label class="btn btn-info btn-sm mt-2">
                                                        <input type="radio" name="call_duration" value="1200" required> 20 mins
                                                    </label>
                                                    <label class="btn btn-info btn-sm mt-2">
                                                        <input type="radio" name="call_duration" value="1500" required> 25 mins
                                                    </label>
                                                    <label class="btn btn-info btn-sm mt-2">
                                                        <input type="radio" name="call_duration" value="1800" required> 30 mins
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <input type="hidden" name="call_duration" value="<?php echo e($getIntakeForm['default_time']); ?>">
                                        <input type="hidden" name="isFreeSession" value="1">
                                        <?php endif; ?>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Call Mode -->
                                    <div class="col-12 py-3">
                                        <div class="form-group mb-0">
                                            <label>Call Mode <span class="color-red">*</span></label><br>
                                            <div class="btn-group-toggle" data-toggle="buttons">
                                                <label id="instantBtn" class="btn btn-light btn-sm mt-2 active">
                                                    <input type="radio" name="IsSchedule" value="0" checked
                                                        onclick="toggleSchedule(false)"> Instant Call
                                                </label>
                                                <label id="scheduleBtn" class="btn btn-light btn-sm mt-2">
                                                    <input type="radio" name="IsSchedule" value="1"
                                                        onclick="toggleSchedule(true)"> Schedule Appointment
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Schedule Fields -->
                                    <div id="scheduleFields" class="col-12 row py-3" style="display:none;">
                                        <div class="col-12 col-md-6 py-2">
                                            <div class="form-group mb-0">
                                                <label for="schedule_date">Schedule Date<span class="color-red">*</span></label>
                                                <input type="date" class="form-control" id="schedule_date" name="schedule_date">
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 py-2">
                                            <div class="form-group mb-0">
                                                <label for="schedule_time">Schedule Time<span class="color-red">*</span></label>
                                                <input type="time" class="form-control" id="schedule_time" name="schedule_time">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Submit Buttons -->
                                    <div class="col-12 col-md-12 py-3">
                                        <div class="row">
                                            <div class="col-12 pt-md-3 text-center mt-2">
                                                <button class="font-weight-bold ml-0 w-100 btn btn-chat"
                                                    id="callloaderintakeBtn" type="button" style="display:none;" disabled>
                                                    <span class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true"></span> Loading...
                                                </button>
                                                <button type="submit" class="btn btn-block btn-chat px-4 px-md-5 mb-2"
                                                    id="callintakeBtn">Start Call</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <!-- JS Logic -->


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







    <div class="bg-pink py-3 py-md-4 expert-profile-page-new">
        <div class="container">

            <div class="row align-items-center">
                <div class="col-md-7">
                    <div class="d-block d-md-flex">
                        <!--Expert profile image and badge -->
                        <div class="profile-image position-relative pb-5 border">
                            <?php if($getAstrologer['recordList'][0]['profileImage']): ?>
                            <img class="psychicpic img-fluid" src="<?php echo e(Str::startsWith($getAstrologer['recordList'][0]['profileImage'], ['http://','https://']) ? $getAstrologer['recordList'][0]['profileImage'] : '/' . $getAstrologer['recordList'][0]['profileImage']); ?>" onerror="this.onerror=null;this.src='/build/assets/images/person.png';" alt="Customer image" onclick="openImage('<?php echo e($getAstrologer['recordList'][0]['profileImage']); ?>')" width="143" height="143" loading="lazy"/>

                                <!-- <img src="/<?php echo e($getAstrologer['recordList'][0]['profileImage']); ?>"
                                    class="psychicpic img-fluid" alt="<?php echo e($getAstrologer['recordList'][0]['name']); ?>"
                                    width="143" height="143" /> -->
                            <?php else: ?>
                                <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img-new.png')); ?>"
                                    class="psychicpic img-fluid" alt="<?php echo e($getAstrologer['recordList'][0]['name']); ?>"
                                    width="143" height="143" />
                            <?php endif; ?>
                            <div id="psychic-21599-status" class="status-badge specific-Clr-Online hidden"></div>
                            <div class="position-absolute profile-badge">
                                <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/astroway/images/deals/seal.png')); ?>"
                                    width="52" height="52" />
                            </div>

                        </div>

                        <!-- Expert Information -->
                        <div class="ml-md-4 mt-2 mt-md-0">
                            <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                                <p class="font-weight-bold text-capitalize mb-0 font-24">
                                    <?php echo e($getAstrologer['recordList'][0]['name']); ?></p>
                                    <div>

                                    <?php if(authcheck()): ?>
                                    <?php if(!$getfollower): ?>
                                    <form id="followastro" class="ml-5">
                                        <input type="hidden" name="astrologerId"
                                        value="<?php echo e($getAstrologer['recordList'][0]['id']); ?>">
                                        <a class="btn btn-lg bg-white rounded text-dark font-weight-bold buttonshowmoreprofile" role="button" id="btnFollow" >
                                            <span class="show-more-btn-txt">Follow</span>
                                        </a>
                                    </form>
                                    <?php else: ?>
                                    <form id="unfollowfollowastro" class="ml-5">
                                        <input type="hidden" name="astrologerId"
                                        value="<?php echo e($getAstrologer['recordList'][0]['id']); ?>">
                                        <a class="btn btn-lg bg-white rounded text-dark font-weight-bold buttonshowmoreprofile" role="button" id="btnUnFollow" >
                                            <span class="show-more-btn-txt">Unfollow</span>
                                        </a>
                                    </form>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if($getAstrologer['recordList'][0]['isBlock']==true): ?>

                                    <form id="unblockastrologer" class="ml-5 mt-2">
                                    <input type="hidden" name="astrologerId" value="<?php echo e($getAstrologer['recordList'][0]['id']); ?>">
                                    <a class="btn btn-lg bg-white rounded text-dark font-weight-bold buttonshowmoreprofile" role="button" id="btnunBlock" style="height:50%">
                                        <span class="show-more-btn-txt">Unblock</span>
                                    </a>
                                    </form>
                                    <?php endif; ?>
                                </div>

                            </div>

                            <!--report and block-->

                                <?php if(authcheck()): ?>

                                <?php if($getAstrologer['recordList'][0]['isBlock']==false): ?>

                                <span class="dropdown d-flex justify-content-end">
                                        <a href="#" class="colorblack" id="optionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="optionsDropdown" style="">
                                            <a class="dropdown-item" id="reportBlock" href="#" data-toggle="modal" data-target="#reportBlockModal">Report and Block</a>

                                        </div>
                                </span>

                                <?php endif; ?>

                                <?php endif; ?>

                                <!--end-->


                            <div class="text-center text-md-left order-2 order-md-5">
                                <p class="mb-0 font-16 color-darkgray">
                                    <?php $__currentLoopData = $getAstrologer['recordList'][0]['primarySkill']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $primarySkill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span id="exp_CatName"
                                            title="<?php echo e($primarySkill['name']); ?>"><?php echo e($primarySkill['name']); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>
                                <p class="font-16 m-0 profileCatName color-darkgray pb-1">
                                    <?php $__currentLoopData = $getAstrologer['recordList'][0]['languageKnown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="colorblack lang"><?php echo e($language['languageName']); ?>,</span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </p>




                            </div>
                            <div class="order-3 order-md-3"><span class="border-top d-block m-2"></span></div>
                            <div
                                class="d-flex align-items-center justify-content-center justify-content-md-start order-4 order-md-2 flex-wrap">
                                <p class="text-left font-16  p-0 m-0 font-weight-normal color-darkgray">
                                    <span> Reviews : </span> <span
                                        class="reviews-count"><text><?php echo e($getAstrologer['recordList'][0]['ratingcount']); ?></text></span>
                                </p>
                                <span class="font-16 px-3">|</span>
                                <p class="font-16 text-left p-0 m-0 text-nowrap">Rating:
                                    <?php
                                        $totalReviews = count($getAstrologer['recordList'][0]['review']);
                                        $totalRating = 0; // Total sum of ratings
                                        foreach ($getAstrologer['recordList'][0]['review'] as $review) {
                                            $totalRating += $review['rating'];
                                        }
                                        if ($totalReviews > 0) {
                                            $averageRating = $totalRating / $totalReviews;
                                        } else {
                                            $averageRating = 0;
                                        }
                                    ?>
                                    <span>
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $averageRating): ?>
                                                <i class="fas fa-star filled-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star empty-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </span>
                                </p>


                                <span class="font-16 px-3">|</span>
                                <p class="font-16 m-0">Exp :<span
                                        class="colorblack ml-1"><?php echo e($getAstrologer['recordList'][0]['experienceInYears']); ?>

                                        Years</span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mt-3 mt-md-0">
                    <!--Expert Call Chat Buttons -->
                    <ul class="list-inline psychic-badge text-center text-md-right mb-0">
                        <li class="list-inline-item mt-sm-2 mt-md-0">
                            <div class="profile-buttons d-block align-items-center justify-content-center ">
                                <?php if($getAstrologer['recordList'][0]['chatStatus']=='Busy' || $getAstrologer['recordList'][0]['chatStatus']=='Offline' || empty($getAstrologer['recordList'][0]['chatStatus'])): ?>
                                <div class="my-2 position-relative">
                                    <a class="btn-block  colorblack  btn-chat-profile <?php if($getAstrologer['recordList'][0]['chatStatus']=='Busy'): ?> expert-busy <?php else: ?> expert-offline <?php endif; ?> ">
                                        <span class="d-flex w-100 justify-content-between">
                                            <span class="position-relative">
                                                <span class="d-block mb-3 font-weight-bold"> Chat </span>
                                                <span class="d-block font-12 position-absolute bsy-txtded text-left font-16"> <?php echo e($getAstrologer['recordList'][0]['chatStatus'] ?? 'Offline'); ?> </span>
                                            </span>

                                            <span class="separator d-block">
                                                <span class="d-block text-center p-0">
                                                    <span class="d-block font-12"></span>
                                                    <span class="d-block font-16">
                                                        <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                        <?php echo e($getAstrologer['recordList'][0]['charge']); ?> /Min</span>
                                                </span>
                                            </span>

                                        </span>
                                    </a>
                                </div>
                                <?php elseif($getAstrologer['recordList'][0]['chat_sections']==0 || $chatsection['value']==0): ?>

                                <div class="my-2 position-relative">
                                    <a class="btn-block  colorblack  btn-chat-profile expert-busy btn-opacity disabled" style="border: 2px solid #53535a !important;">
                                        <span class="d-flex w-100 justify-content-between">
                                            <span class="font-weight-bold"> Chat </span>
                                            <?php if($getAstrologer['recordList'][0]['isFreeAvailable'] == true): ?>
                                                <span class="separator d-block">
                                                    <span class="d-block text-center p-0 font-12"><del>
                                                            <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                            <?php echo e($getAstrologer['recordList'][0]['charge']); ?>

                                                            /Min</del></span>
                                                    <span class="d-block text-center p-0">Free</span>
                                                </span>
                                            <?php else: ?>
                                                <span class="d-block font-16">
                                                    <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                    <?php echo e($getAstrologer['recordList'][0]['charge']); ?> /Min</span>
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                </div>
                                <?php else: ?>
                                <div class="my-2 position-relative">
                                    <a class="btn-block btn-chat-profile colorblack" data-toggle="modal" role="button"
                                        id="chat-btn"
                                        <?php if(!authcheck()): ?> data-target="#loginSignUp" <?php else: ?> data-target="#intake" <?php endif; ?>>
                                        <span class="d-flex w-100 justify-content-between">
                                            <span class="font-weight-bold"> Chat </span>
                                            <?php if($getAstrologer['recordList'][0]['isFreeAvailable'] == true): ?>
                                                <span class="separator d-block">
                                                    <span class="d-block text-center p-0 font-12"><del>
                                                       <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                            <?php echo e($getAstrologer['recordList'][0]['charge']); ?>

                                                            /Min</del></span>
                                                    <span class="d-block text-center p-0">Free</span>
                                                </span>
                                            <?php else: ?>
                                                <span class="d-block font-16">
                                                    <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                    <?php echo e($getAstrologer['recordList'][0]['charge']); ?> /Min</span>
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                </div>
                                <?php endif; ?>

                                 <?php if($getAstrologer['recordList'][0]['callStatus']=='Busy' || $getAstrologer['recordList'][0]['callStatus']=='Offline' || empty($getAstrologer['recordList'][0]['callStatus'])): ?>

                                <div class="my-2 position-relative">
                                    <a class="btn-block  colorblack btn-audio-call btn-chat-profile <?php if($getAstrologer['recordList'][0]['callStatus']=='Busy'): ?> expert-busy <?php else: ?> expert-offline <?php endif; ?> ">
                                        <span class="d-flex w-100 justify-content-between">
                                            <span class="position-relative">
                                                <span class="d-block mb-3 font-weight-bold">Audio Call </span>
                                                <span class="d-block font-12 position-absolute bsy-txtded text-left font-16"> <?php echo e($getAstrologer['recordList'][0]['callStatus']  ?? 'Offline'); ?> </span>
                                            </span>

                                            <span class="separator d-block">
                                                <span class="d-block text-center p-0">
                                                    <span class="d-block font-12"></span>
                                                    <span class="d-block font-16">
                                                       <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                        <?php echo e($getAstrologer['recordList'][0]['charge']); ?> /Min</span>
                                                </span>
                                            </span>

                                        </span>
                                    </a>
                                </div>
                                <?php elseif($getAstrologer['recordList'][0]['call_sections']==0 || $callsection['value']==0): ?>

                                <div class="my-2 position-relative">
                                    <a class="btn-block  colorblack  btn-chat-profile expert-busy btn-opacity disabled" style="border: 2px solid #53535a !important;">
                                        <span class="d-flex w-100 justify-content-between">
                                            <span class="font-weight-bold">Audio Call </span>
                                            <?php if($getAstrologer['recordList'][0]['isFreeAvailable'] == true): ?>
                                                <span class="separator d-block">
                                                    <span class="d-block text-center p-0 font-12"><del>
                                                      <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                            <?php echo e($getAstrologer['recordList'][0]['charge']); ?>

                                                            /Min</del></span>
                                                    <span class="d-block text-center p-0">Free</span>
                                                </span>
                                            <?php else: ?>
                                                <span class="d-block font-16">
                                                    <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                    <?php echo e($getAstrologer['recordList'][0]['charge']); ?> /Min</span>
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                </div>

                                <?php else: ?>
                                <div class="my-2 position-relative">
                                    <a class="other-country btn-block btn btn-chat-profile btn-audio-call colorblack" role="button"
                                        data-toggle="modal"
                                        <?php if(!authcheck()): ?> data-target="#loginSignUp" <?php else: ?> data-target="#callintake" <?php endif; ?>
                                        id="audio-call-btn">
                                        <span class="d-flex w-100 justify-content-between">
                                            <span class="font-weight-bold">Audio Call </span>
                                            <?php if($getAstrologer['recordList'][0]['isFreeAvailable'] == true): ?>
                                                <span class="separator d-block">
                                                    <span class="d-block text-center p-0 font-12"><del>
                                                       <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                            <?php echo e($getAstrologer['recordList'][0]['charge']); ?>

                                                            /Min</del></span>
                                                    <span class="d-block text-center p-0">Free</span>
                                                </span>
                                            <?php else: ?>
                                                <span class="d-block font-16">
                                                   <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                    <?php echo e($getAstrologer['recordList'][0]['charge']); ?> /Min</span>
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                </div>

                                <?php endif; ?>

                                <?php if($getAstrologer['recordList'][0]['callStatus']=='Busy' || $getAstrologer['recordList'][0]['callStatus']=='Offline' || empty($getAstrologer['recordList'][0]['callStatus'])): ?>

                                <div class="my-2 position-relative">
                                    <a class="btn-block  colorblack btn-video-call btn-chat-profile <?php if($getAstrologer['recordList'][0]['callStatus']=='Busy'): ?> expert-busy <?php else: ?> expert-offline <?php endif; ?> ">
                                        <span class="d-flex w-100 justify-content-between">
                                            <span class="position-relative">
                                                <span class="d-block mb-3 font-weight-bold">Video Call </span>
                                                <span class="d-block font-12 position-absolute bsy-txtded text-left font-16"> <?php echo e($getAstrologer['recordList'][0]['callStatus'] ?? 'Offline'); ?> </span>
                                            </span>

                                            <span class="separator d-block">
                                                <span class="d-block text-center p-0">
                                                    <span class="d-block font-12"></span>
                                                    <span class="d-block font-16">
                                                       <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                        <?php echo e($getAstrologer['recordList'][0]['videoCallRate']); ?> /Min</span>
                                                </span>
                                            </span>

                                        </span>
                                    </a>
                                </div>
                                <?php elseif($getAstrologer['recordList'][0]['call_sections']==0 || $callsection['value']==0): ?>
                                <div class="my-2 position-relative">
                                    <a class="btn-block  colorblack  btn-chat-profile expert-busy btn-opacity disabled" style="border: 2px solid #53535a !important;">
                                        <span class="d-flex w-100 justify-content-between">
                                            <span class="font-weight-bold">Video Call </span>
                                            <?php if($getAstrologer['recordList'][0]['isFreeAvailable'] == true): ?>
                                                <span class="separator d-block">
                                                    <span class="d-block text-center p-0 font-12"><del>
                                                       <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                            <?php echo e($getAstrologer['recordList'][0]['videoCallRate']); ?>

                                                            /Min</del></span>
                                                    <span class="d-block text-center p-0">Free</span>
                                                </span>
                                            <?php else: ?>
                                                <span class="d-block font-16">
                                                   <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                    <?php echo e($getAstrologer['recordList'][0]['videoCallRate']); ?> /Min</span>
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                </div>

                                <?php else: ?>
                                <div class="my-2 position-relative">
                                    <a class="other-country btn-block btn btn-chat-profile btn-video-call colorblack" role="button"
                                        data-toggle="modal"
                                        <?php if(!authcheck()): ?> data-target="#loginSignUp" <?php else: ?> data-target="#callintake" <?php endif; ?>
                                        id="video-call-btn">
                                        <span class="d-flex w-100 justify-content-between">
                                            <span class="font-weight-bold">Video Call </span>
                                            <?php if($getAstrologer['recordList'][0]['isFreeAvailable'] == true): ?>
                                                <span class="separator d-block">
                                                    <span class="d-block text-center p-0 font-12"><del>
                                                      <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                            <?php echo e($getAstrologer['recordList'][0]['videoCallRate']); ?>

                                                            /Min</del></span>
                                                    <span class="d-block text-center p-0">Free</span>
                                                </span>
                                            <?php else: ?>
                                                <span class="d-block font-16">
                                                    <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                    <?php echo e($getAstrologer['recordList'][0]['videoCallRate']); ?>/Min
                                                </span>
                                            <?php endif; ?>
                                        </span>
                                    </a>
                                </div>
                                <?php endif; ?>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container profile-page">
        <div class="row my-3 profile-desc">
            <div class="col-sm-12" id="order2">
                <div class="bg-white div_Shadow pb-4">
                   
                    <div class="psychic-specialization">
                        <h3 class="font-18 weight500 colorblack m-0 font-weight-bold">Specialization</h3>
                        <p class="font15 colorblack m-0 p-0 pt-3" id="profile-specialization">
                        <ul>
                            <?php $__currentLoopData = $getAstrologer['recordList'][0]['astrologerCategoryId']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($category['name']); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        </p>
                    </div>
                    <h3 class="font-18 weight500 colorblack m-0 pt-4 font-weight-bold">About My Services</h3>
                    <p class="font15 colorblack m-0 p-0 pt-2">
                        <?php echo e($getAstrologer['recordList'][0]['loginBio']); ?>

                    </p>
                    <h3 class="font-18 weight500 colorblack m-0  pt-4 font-weight-bold">Experience &amp; Qualification</h3>
                    <p class="font15 colorblack m-0 p-0 pt-2">
                        I am a practicing Astrology in
                        <?php if(!empty($getAstrologer['recordList'][0]['primarySkill'])): ?>
                            <?php
                                $skills = collect($getAstrologer['recordList'][0]['primarySkill'])->pluck('name')->implode(', ');
                            ?>
                            <?php echo e($skills); ?>

                        <?php endif; ?>
                        with an experience of more than <?php echo e($getAstrologer['recordList'][0]['experienceInYears']); ?> years now. I obtained my
                        <?php echo e($getAstrologer['recordList'][0]['degree']); ?> degree from
                        <?php echo e($getAstrologer['recordList'][0]['college']); ?> college.
                    </p>

                    <div class="rounded border mt-4">
                        <div class="d-block d-sm-flex align-items-center justify-content-between bg-pink-light p-2">
                            <h3 class="font-18 weight500 colorblack m-0 font-weight-bold text-center text-md-left my-1">
                                Send Gift to Expert
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#giftInfoModal">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16.764" height="16.764"
                                            viewBox="0 0 16.764 16.764">
                                            <g id="Icon_feather-info" data-name="Icon feather-info"
                                                transform="translate(0.5 0.5)">
                                                <path id="Path_195175" data-name="Path 195175"
                                                    d="M18.764,10.882A7.882,7.882,0,1,1,10.882,3,7.882,7.882,0,0,1,18.764,10.882Z"
                                                    transform="translate(-3 -3)" fill="none" stroke="#848484"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1" />
                                                <path id="Path_195176" data-name="Path 195176" d="M18,23.369V18"
                                                    transform="translate(-10.118 -11.461)" fill="none"
                                                    stroke="#848484" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="1.5" />
                                                <path id="Path_195177" data-name="Path 195177" d="M18,12h0"
                                                    transform="translate(-10.118 -8.146)" fill="none" stroke="#848484"
                                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                            </g>
                                        </svg>
                                    </span>
                                </a>
                            </h3>

                        </div>
                        <form id="giftForm">
                            <div id="loadGiftItems" class="loadGiftItems d-flex align-items-center flex-wrap py-2">
                                <?php $__currentLoopData = $getGift['recordList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a class="d-flex align-items-center justify-content-center loadGiftItem"
                                        data-gift-id="<?php echo e($gift['id']); ?>" data-gift-amount="<?php echo e($gift['amount']); ?>">
                                        <div>
                                            <img src="<?php echo e(Str::startsWith($gift['image'], ['http://','https://']) ? $gift['image'] : '/' . $gift['image']); ?>" onerror="this.onerror=null;this.src='/build/assets/images/person.png';" alt="Customer image" onclick="openImage('<?php echo e($gift['image']); ?>')" style="width: 60px;height:60px;" loading="lazy"/>

                                            <!-- <img src="/<?php echo e($gift['image']); ?>" style="width: 60px;height:60px;"> -->
                                            <p style="margin-bottom: 0;"
                                                class="gift-name text-nowrap font-weight-bold py-2">
                                                <?php echo e($gift['name']); ?>

                                            </p>
                                            <span
                                                class="font-weight-semi-bold">
                                                    <?php if($walletType == 'Coin'): ?>
                                                        <img src="<?php echo e(asset($coinIcon)); ?>" alt="Wallet Icon" width="15">
                                                    <?php else: ?>
                                                        <?php echo e($currency['value']); ?>

                                                    <?php endif; ?>
                                                    <?php echo e($gift['amount']); ?>

                                            </span>
                                        </div>
                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <input type="hidden" name="astrologerId"
                                    value="<?php echo e($getAstrologer['recordList'][0]['id']); ?>">
                                <input type="hidden" name="giftId" value="">
                                <input type="hidden" name="giftamount" id="giftamount" value="">

                            </div>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <?php if(authcheck()): ?>
                                    <a class="btn btn-Waitlist send-gift active" id="send-gift" role="button"
                                        data-toggle="modal">
                                        Send
                                    </a>
                                    <button class="btn btn-Waitlist send-gift active" id="send-giftBtn" type="button"
                                        style="display:none;" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span> Loading...
                                    </button>
                                <?php else: ?>
                                    <a class="btn btn-Waitlist send-gift" id="send-gift" role="button"
                                        data-toggle="modal" data-target="#loginSignUp">
                                        Send
                                    </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                    <!-- Modal -->
                    <div id="giftInfoModal" class="modal fade" role="dialog">
                        <div class="modal-dialog h-100 d-flex align-items-center">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">

                                    <h4 class="modal-title font-weight-bold">
                                        How does it work?
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <ol>
                                        <li>
                                            <p>Users can send virtual gifts to the <?php echo e(ucfirst($professionTitle)); ?>s.</p>
                                        </li>
                                        <li>
                                            <p>Users will send these gifts voluntarily and the company does not guarantee
                                                any service in exchange of these gifts.</p>
                                        </li>
                                        <li>
                                            <p> These gifts are non-refundable.</p>
                                        </li>
                                        <li>
                                            <p> As per the Company&#39;s policies, gifts can be en-cashed by the <?php echo e(ucfirst($professionTitle)); ?>s
                                                in monetary terms.</p>
                                        </li>
                                    </ol>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="schedule-list-containter">
                        <h3 class="font-18 weight500 colorblack m-0  pt-4 font-weight-bold">Check Online Availability</h3>

                        <ul id="scheduleContainer"
                        class="bg-pink d-flex py-3 list-unstyled mt-3 justify-content-between px-3 schedule-progressbar">
                        <?php if(!empty($getAstrologer['recordList']) && !empty($getAstrologer['recordList'][0]['astrologerAvailability'])): ?>
                            <?php $__currentLoopData = $getAstrologer['recordList'][0]['astrologerAvailability']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $astrologerAvailability): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="active">
                                    <div class="schedule-range pb-3">
                                        <div class="d-block text-left">
                                            <p class="font-weight-bold font-16 mb-2 text-left text-md-center">
                                                <?php echo e(\Carbon\Carbon::parse($astrologerAvailability['day'])->format('l')); ?>

                                            </p>
                                            <p class="color-red font-12 font-weight-semi-bold text-left text-md-center mb-2">
                                                (<?php echo e(\Carbon\Carbon::parse($astrologerAvailability['day'])->format('F d')); ?>)
                                            </p>
                                        </div>
                                    </div>
                                    <ul>
                                        <?php if(!empty($astrologerAvailability['time']) && !empty($astrologerAvailability['time'][0])): ?>
                                            <li><?php echo e($astrologerAvailability['time'][0]['fromTime'] ?? '-'); ?></li>
                                            <li><?php echo e($astrologerAvailability['time'][0]['toTime'] ?? '-'); ?></li>
                                        <?php else: ?>
                                            <li>-</li>
                                            <li>-</li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-pink">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                </div>
            </div>
        </div>
    </div>
    <div class="container py-3 py-md-5">
        <div class="row">
            <div class="col-sm-12">
                <div class="bg-white" id="review">
                    <ul class="list-unstyled border-bottom pb-2">
                        <li class="font-20 colorblack pb-0 font-weight-bold">Reviews <span
                                class="color-red"><?php echo e($getAstrologer['recordList'][0]['ratingcount']); ?></span>
                        </li>
                        <?php if($getAstrologer['recordList'][0]['rating'] > 0): ?>
                            <li class="font18 weight600 coloryellow d-flex align-items-center">
                                <p class="mb-0 ml-1">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if($i <= $averageRating): ?>
                                            <i class="fas fa-star filled-star"></i>
                                        <?php else: ?>
                                            <i class="far fa-star empty-star"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </p>
                            </li>

                    </ul>
                    <div class="reviewrapper list row">
                        <?php $__currentLoopData = $getAstrologer['recordList'][0]['review']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="reviewslist col-sm-12 col-md-6 <?php echo e($index % 2 == 0 ? 'even' : 'odd'); ?>">
                                <div class="border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex justify-content-between pt-2">
                                            <div
                                                class="review-profile-pic d-flex align-items-center justify-content-center bg-pink">
                                                <p class="mb-0 font-20 font-weight-bold">
                                                    <?php if($review['profile']): ?>
                                                        <img src="/<?php echo e($review['profile']); ?>" class="review-profile-pic"
                                                            alt="">
                                                    <?php else: ?>
                                                        <img src="<?php echo e(asset('public/frontend/astrowaycdn/dashaspeaks/web/content/images/user-img.png')); ?>"
                                                            class="review-profile-pic" alt="">
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            <div class="ml-2">
                                                <p class="font-16 weight500 m-0 font-weight-bold">
                                                    <?php echo e($review['userName'] ? $review['userName'] : 'Anonymous'); ?></p>
                                                <p> <i class="font-18" data-star="<?php echo e($review['rating']); ?>"></i></p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="font-14 mt-1">
                                        <?php echo e($review['review']); ?>

                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p>No Review Found</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<?php
$apikey = DB::table('systemflag')->where('name', 'googleMapApiKey')->value('value');
?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e($apikey); ?>&libraries=places">
</script>
<script>
        <?php if(authcheck()): ?>
         $(document).ready(function() {
            $('.select2').select2({
                width: '100%' // Ensure Select2 dropdown takes full width of the parent
            });
        });
        <?php endif; ?>
        function initializeAutocomplete(inputId, latitudeId, longitudeId) {
    var input = document.getElementById(inputId);
    var autocomplete = new google.maps.places.Autocomplete(input);
    var latitude = document.getElementById(latitudeId);
    var longitude = document.getElementById(longitudeId);

    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if (place.hasOwnProperty('place_id')) {
            if (!place.geometry) {
                return;
            }
            latitude.value = place.geometry.location.lat();
            longitude.value = place.geometry.location.lng();
        } else {
            var service = new google.maps.places.PlacesService(document.createElement('div'));
            service.textSearch({
                query: place.name
            }, function(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    latitude.value = results[0].geometry.location.lat();
                    longitude.value = results[0].geometry.location.lng();
                }
            });
        }
    });
}

// Initialize when the page loads
initializeAutocomplete('BirthPlace', 'latitude', 'longitude');
initializeAutocomplete('BirthPlace1', 'latitude1', 'longitude1');


</script>

    <script>

        $(document).ready(function() {
            $('.loadGiftItem').on('click', function() {
                $('.loadGiftItem').css({
                    'box-shadow': '',
                    'background': ''
                });
                $(this).css({
                    'box-shadow': '0px 3px 6px #E7F1FF',
                    'background': '#E7F1FF'
                });

                var selectedGiftId = $(this).data('gift-id');
                 var giftamount = $(this).data('gift-amount');

                $('input[name="giftId"]').val(selectedGiftId);
                $('input[name="giftamount"]').val(giftamount);
            });



            $('#send-gift').click(function(e) {
                e.preventDefault();

                var textarea = document.getElementById("giftamount").value;
                // Check if textarea is empty and prevent form submission
                if (textarea.trim() === "") {
                    toastr.error('Please select a gift🎁');
                    event.preventDefault(); // Prevent form submission if empty
                    return;
                }
                var giftamount=$("#giftamount").val();
                // console.log(giftamount);return false;
                <?php
                    use Symfony\Component\HttpFoundation\Session\Session;
                    $session = new Session();
                    $token = $session->get('token');

                $wallet_amount = '';
                if (authcheck()) {
                    $wallet_amount = $walletAmount;
                }

                ?>

                var wallet_amount = "<?php echo e($wallet_amount); ?>";

                $('#send-gift').hide();
                $('#send-giftBtn').show();
                setTimeout(function() {
                    $('#send-gift').show();
                    $('#send-giftBtn').hide();
                }, 7000);


                var formData = $('#giftForm').serialize();

                // console.log(parseInt(giftamount),'giftamnt');
                // console.log(parseInt(wallet_amount), 'waltamnt');
              if (parseInt(giftamount) > parseInt(wallet_amount)) {
                  toastr.error('Insufficient Balance');
                  window.location.href="<?php echo e(route('front.walletRecharge')); ?>"
                //   console.log("hhh");
              return false;

              }

                $.ajax({
                    url: '<?php echo e(route('api.sendGifts', ['token' => $token])); ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        toastr.success('Gift Sent Successfully');
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseText);
                    }
                });
            });

            // Follow
            $('#btnFollow').click(function(e) {
                e.preventDefault();

                <?php
                    $token = $session->get('token');
                ?>

                var formData = $('#followastro').serialize();
                $.ajax({
                    url: '<?php echo e(route('api.addFollowing', ['token' => $token])); ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        toastr.success('Followed Successfully');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseText);
                    }
                });
            });

            // Unfollow
            $('#btnUnFollow').click(function(e) {
                e.preventDefault();
                <?php
                    $token = $session->get('token');
                ?>

                var formData = $('#unfollowfollowastro').serialize();
                $.ajax({
                    url: '<?php echo e(route('api.updateFollowing', ['token' => $token])); ?>',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        toastr.success('UnFollowed Successfully');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                        toastr.error(xhr.responseText);
                    }
                });
            });


        });
    </script>

    
    <script>
        const firestore = firebase.firestore();
        // Function to send a message
        function sendMessage(senderId, receiverId, message, isEndMessage, attachementPath) {
            const chatRef = firestore.collection('chats').doc(`${receiverId}_${senderId}`).collection('userschat').doc(
                receiverId).collection('messages');
            const timestamp = new Date();
            // Generate a unique ID for the message
            const messageId = chatRef.doc().id;

            chatRef.doc(messageId).set({
                    id: null,
                    createdAt: timestamp,
                    invitationAcceptDecline: null,
                    isDelete: false,
                    isEndMessage: isEndMessage,
                    isRead: false,
                    messageId: messageId,
                    reqAcceptDecline: null,
                    status: null,
                    updatedAt: timestamp,
                    url: null,
                    userId1: senderId,
                    userId2: receiverId,
                    message: message,
                    attachementPath: attachementPath, // Pass attachementPath to the message object
                })
                .then(() => {
                    // console.log("Message sent with ID: ", messageId);
                })
                .catch((error) => {
                    console.error("Error sending message: ", error);
                });
        }




        $(document).ready(function() {
            $('#intakeBtn').click(function(e) {
                e.preventDefault();

                var form = document.getElementById('intakeForm');
                if (form.checkValidity() === false) {
                    form.reportValidity();
                    return;
                }

                <?php if(authcheck()): ?>
                    var sessionAvailable = "<?php echo e($isChatSessionavailable); ?>";
                <?php endif; ?>


                if (sessionAvailable == false) {
                    toastr.error('Your request is already there');
                    return false;
                }

                $('#intakeBtn').hide();
                $('#loaderintakeBtn').show();
                setTimeout(function() {
                    $('#intakeBtn').show();
                    $('#loaderintakeBtn').hide();
                }, 3000);


                var astrocharge = <?php echo e($getAstrologer['recordList'][0]['charge']); ?>;


                <?php
                $wallet_amount = '';
                if (authcheck()) {
                    $wallet_amount = authcheck()['totalWalletAmount'];
                }
                ?>

                var formData = $('#intakeForm').serialize();


                // Parse form data as URL parameters
                var urlParams = new URLSearchParams(formData);
                var chat_duration = parseInt(urlParams.get('chat_duration'));

                var chat_duration_minutes = Math.ceil(chat_duration / 60);

                var total_charge = astrocharge * chat_duration_minutes;
                var isFreeAvailable = "<?php echo e($getAstrologer['recordList'][0]['isFreeAvailable']); ?>";

                var wallet_amount = "<?php echo e($wallet_amount); ?>";

                // for message send
                var astrologerId="<?php echo e($getAstrologer['recordList'][0]['id']); ?>";
                <?php if(authcheck()): ?>
                var userId="<?php echo e(authcheck()['id']); ?>";
                <?php endif; ?>
                var formDatas = $('#intakeForm').serializeArray();
                var name = formDatas.find(item => item.name === 'name').value;
                var gender = formDatas.find(item => item.name === 'gender').value;
                var birthDate = formDatas.find(item => item.name === 'birthDate').value;
                var birthTime = formDatas.find(item => item.name === 'birthTime').value;
                var birthPlace = formDatas.find(item => item.name === 'birthPlace').value;
                var maritalStatus = formDatas.find(item => item.name === 'maritalStatus').value;
                var topicOfConcern = formDatas.find(item => item.name === 'topicOfConcern').value;

                var message = `Hi <?php echo e($getAstrologer['recordList'][0]['name']); ?>

                Below are my details:

                Name: ${name},
                Gender: ${gender},
                DOB: ${birthDate},
                TOB: ${birthTime},
                POB: ${birthPlace},
                Marital status: ${maritalStatus},
                TOPIC: ${topicOfConcern}

                This is an automated message to confirm that chat has started.`;


                // Check if free chat is available and wallet has sufficient balance
                if (isFreeAvailable != true) {
                    if (total_charge <= wallet_amount) {
                        $.ajax({
                            url: "<?php echo e(route('api.addChatRequest', ['token' => $token])); ?>",
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                               $.ajax({
                                    url: "<?php echo e(route('api.intakeForm', ['token' => $token])); ?>",
                                    type: 'POST',
                                    data: formData,
                                    success: function(response) {
                                        sendMessage(userId, astrologerId, message, false,'');
                                        setTimeout(function() {
                                            toastr.success(
                                                'Chat Request Sent ! you will be notified if <?php echo e(strtolower($professionTitle)); ?> accept your request.'
                                                );
                                            window.location.reload();

                                        }, 2000);
                                    },
                                    error: function(xhr, status, error) {
                                    if (xhr.responseJSON && xhr.responseJSON.recordList && xhr.responseJSON.recordList.message) {
                                    toastr.error(xhr.responseJSON.recordList.message);
                                        } else {
                                            toastr.error(xhr.responseText);
                                        }
                                    }
                                });
                            },
                            error: function(xhr, status, error) {
                                if (xhr.responseJSON && xhr.responseJSON.recordList && xhr.responseJSON.recordList.message) {
                                    toastr.error(xhr.responseJSON.recordList.message);
                                } else {
                                    toastr.error(xhr.responseText);
                                    }
                            }
                        });

                    } else {
                        toastr.error('Insufficient balance. Please recharge your wallet.');
                        window.location.href="<?php echo e(route('front.walletRecharge')); ?>"
                    }
                } else {

                    $.ajax({
                        url: "<?php echo e(route('api.addChatRequest', ['token' => $token])); ?>",
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                           $.ajax({
                                url: "<?php echo e(route('api.intakeForm', ['token' => $token])); ?>",
                                type: 'POST',
                                data: formData,
                                success: function(response) {

                                    setTimeout(function() {
                                        sendMessage(userId, astrologerId, message, false,'');
                                        toastr.success(
                                            'Chat Request Sent ! you will be notified if <?php echo e(strtolower($professionTitle)); ?> accept your request.'
                                            );
                                        window.location.reload();

                                    }, 2000);
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseJSON && xhr.responseJSON.recordList && xhr.responseJSON.recordList.message) {
                                        toastr.error(xhr.responseJSON.recordList.message);
                                    } else {
                                        toastr.error(xhr.responseText);
                                    }
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            if (xhr.responseJSON && xhr.responseJSON.recordList && xhr.responseJSON.recordList.message) {
                            toastr.error(xhr.responseJSON.recordList.message);
                        } else {
                            toastr.error(xhr.responseText);
                        }
                        }
                    });


                }
            });
        });
    </script>

 <script>
    $(document).ready(function() {



    <script>
        $(document).ready(function() {

            <?php if($getAstrologer): ?>
            // Handle Audio Call Click
            $(document).on('click', '.btn-audio-call', function() {
                initiateCallRequest($(this), 10); // 10 = Audio
            });

            // Handle Video Call Click
            $(document).on('click', '.btn-video-call', function() {
                initiateCallRequest($(this), 11); // 11 = Video
            });

            function initiateCallRequest(element, callType) {
                var astrologerCard = element.closest('.psychic-card');
                var astrologerId = astrologerCard.data('astrologer-id');
                var astroChargeText = astrologerCard.find('.exprt-price').text().trim();
                var astroCharge = parseFloat(astroChargeText.match(/[\d.]+/));
                
                // Get User Wallet Balance
                <?php
                    $walletAmount = 0;
                    if(authcheck()){
                         $walletAmount = authcheck()['totalWalletAmount'];
                    }
                ?>
                var walletAmount = <?php echo e($walletAmount); ?>;
                var isFreeAvailable = "<?php echo e($isFreeAvailable ?? false); ?>"; 

                // Set Modal Details
                $('#req_call_type').val(callType);
                $('#req_astrologerId').val(astrologerId);
                $('#confCallType').text(callType == 10 ? 'Audio Call' : 'Video Call');
                $('#confRate').text(astroCharge);
                $('#confWallet').text(walletAmount);
                
                // Calculate Max Duration
                var maxMinutes = 0;
                if(isFreeAvailable == '1' || isFreeAvailable == true)  {
                     maxMinutes = 5; // Default free minutes
                     $('#confMaxDuration').text(maxMinutes + " Mins (Free Session)");
                     $('#req_isFreeSession').val(1);
                } else {
                     if (astroCharge > 0) {
                        maxMinutes = Math.floor(walletAmount / astroCharge);
                    } else {
                        maxMinutes = 0; 
                    }
                    $('#confMaxDuration').text(maxMinutes + " Mins");
                    $('#req_isFreeSession').val(0);
                }

                // If balance is 0 or insufficient for even 1 min
                if (maxMinutes < 1 && (isFreeAvailable != '1' && isFreeAvailable != true)) {
                     toastr.error('Insufficient wallet balance. Please recharge.');
                     window.location.href = "<?php echo e(route('front.walletRecharge')); ?>";
                     return;
                }
                
                // Set duration in SECONDS for backend
                var durationInSeconds = maxMinutes * 60;
                $('#req_call_duration').val(durationInSeconds);

                // Show Modal
                $('#callConfirmationModal').modal('show');
            }
            <?php endif; ?>


            // Handle Confirm Start Call Click
            $('#confirmStartCallBtn').click(function(e) {
                e.preventDefault();

                var formData = $('#callRequestForm').serialize();
                
                $('#confirmStartCallBtn').hide();
                $('#startingCallLoader').show();

                <?php
                    $session = new Session();
                    $token = $session->get('token');
                ?>

                $.ajax({
                    url: "<?php echo e(route('api.addCallRequest', ['token' => $token])); ?>",
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Success - Call Request added
                         toastr.success(
                            'Call Request Sent! You will be notified if the astrologer accepts your request.'
                        );
                        $('#callConfirmationModal').modal('hide');
                        $('#confirmStartCallBtn').show();
                        $('#startingCallLoader').hide();
                         
                         // Optional: Reload to update UI state
                        setTimeout(function() {
                             window.location.reload(); 
                        }, 2000);
                    },
                    error: function(xhr, status, error) {
                         $('#confirmStartCallBtn').show();
                         $('#startingCallLoader').hide();
                        if (xhr.responseJSON && xhr.responseJSON.recordList && xhr.responseJSON.recordList.message) {
                            toastr.error(xhr.responseJSON.recordList.message);
                        } else {
                            toastr.error(xhr.responseText || 'Something went wrong.');
                        }
                    }
                });
            });
        });

    document.getElementById('clearButton').addEventListener('click', function() {
        window.location.href = "<?php echo e(route('front.talkList')); ?>";
    });
</script>


     <script>
        $(document).ready(function() {
            $('#reportBlockBtn').click(function(e) {
                e.preventDefault();

                var textarea = document.getElementById("review");
                if (textarea.value.trim() === "") {
                    toastr.error('Please enter your reason.');
                    event.preventDefault(); // Prevent form submission if empty
                }

                <?php
                    $token = $session->get('token');

                ?>

                    var formData = $('#reportBlockForm').serialize();
                    $.ajax({
                        url: '<?php echo e(route('api.reportBlockAstrologer', ['token' => $token])); ?>',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            toastr.success('Reported Successfully');
                            setTimeout(function() {
                                window.location.reload()
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = JSON.parse(xhr.responseText).error.paymentMethod[0];
                            toastr.error(errorMessage);
                        }
                    });

            });
        });


        $(document).ready(function() {
            $('#btnunBlock').click(function(e) {
                e.preventDefault();

                <?php
                    $token = $session->get('token');
                ?>

                    var formData = $('#unblockastrologer').serialize();
                    $.ajax({
                        url: '<?php echo e(route('api.unblockAstrologer', ['token' => $token])); ?>',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            toastr.success('Unblocked Successfully ');
                            setTimeout(function() {
                                window.location.reload()
                            }, 1000);
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = JSON.parse(xhr.responseText).error.paymentMethod[0];
                            toastr.error(errorMessage);
                        }
                    });

            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/samarthsharma/Documents/codecanyon-50933419-astroway-astrology-consultation-app-with-php-backend-audiovideo-calls-chat-with-live-streaming/Backend/resources/views/frontend/pages/astrologer-details.blade.php ENDPATH**/ ?>