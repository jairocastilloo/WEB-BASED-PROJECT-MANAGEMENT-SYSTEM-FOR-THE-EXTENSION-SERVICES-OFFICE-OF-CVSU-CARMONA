<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div>
        <div class="border border-1 border-success border-top-0 border-end-0 border-start-0 mb-3">
            <h4 class="p-2 pb-0">
                <b>Profile Settings</b>
            </h4>
        </div>
        <div class="form-group row mb-3">
            <div class="col-md-4">
                <label for="lastName" class="form-label fw-bold">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="{{ $last_name }}" required>
            </div>
            <div class="col-md-4">
                <label for="firstName" class="form-label fw-bold">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="{{ $name }}" required>
            </div>
            <div class="col-md-4">
                <label for="middleName" class="form-label fw-bold">Middle Name</label>
                <input type="text" class="form-control" id="middleName" name="middleName" value="{{ $middle_name }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="middleName" class="form-label fw-bold">Bio</label>
            <textarea class="form-control" aria-label="Bio Data" id="bio" aria-describedby="bio-data" placeholder="Tell us a little about yourself">{{ $bio }}</textarea>
        </div>
        <div class="form-group row mb-3">
            <div class="col-md-8">
                <label for="socialProfile" class="form-label fw-bold">Social account</label>
                <div class="input-group">
                    <span class="input-group-text" id="social-profile"><i class="bi bi-link-45deg"></i></span>
                    <input type="text" class="form-control" value="{{ $social }}" id="socialProfile" placeholder="Link to social profile" aria-label="Social Profile" aria-describedby="social-profile">
                </div>
            </div>

        </div>
        <div class="mb-3">
            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="btnUpdateProfile">
                <b class="small">Update Profile</b>
            </button>
            <span class="ms-2 small loadingMessage" id="updateProfileLoadingSpan" style="display: none;">Saving data...</span>
        </div>
        <div class="alert alert-danger alert-dismissible fade show ms-2 mt-1" role="alert" id="updateProfileError" style="display: none;">
            <!-- Your error message goes here -->
            <strong>Error:</strong><span id="updateProfileErrorMessage"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="alert alert-success mt-3" id="updateProfileSuccessMessage" style="display:none;">
            Profile Settings updated successfully!
        </div>
    </div>
    <div>
        <div class="border border-1 border-success border-top-0 border-end-0 border-start-0 mb-3">
            <h4 class="p-2 pb-0">
                <b>Notification Settings</b>
            </h4>
        </div>

        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="subtaskToDoDate" @if ($notifyInSubtaskToDo==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="subtaskToDoDate">
                    Notify me on the day of the subtask's to do date.
                </label>
                <small class="text-secondary">
                    Enabling this option will trigger a notification on the day of the scheduled subtask.
                </small>
            </div>

        </div>
        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="subtaskDueDate" @if($notifyInSubtaskDue==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="subtaskDueDate">
                    Notify me on the day of the subtask's due date.
                </label>
                <small class="text-secondary">
                    Enabling this option will trigger a notification on the day when the specified subtask is due.
                </small>
            </div>

        </div>

        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="addedAssignee" @if($notifySubtaskAdded==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="addedAssignee">
                    Notify me when I'm added as an assignee in a subtask.
                </label>
                <small class="text-secondary">
                    Enabling this option will send you a notification whenever you are assigned to a subtask.
                </small>
            </div>


        </div>


        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="activityStartDate" @if($notifyInActivityStart==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="activityStartDate">
                    Notify me on the day the activity starts.
                </label>
                <small class="text-secondary">
                    Enabling this option will trigger a notification on the day when the specified activity begins.
                </small>
            </div>


        </div>
        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="activityEndDate" @if($notifyInActivityDue==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="activityEndDate">
                    Notify me on the last day of the activity's scheduled duration.
                </label>
                <small class="text-secondary">
                    Enabling this option will send a notification on the final day of the scheduled duration for the specified activity.
                </small>
            </div>

        </div>
        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="activityAdded" @if($notifyActivityAdded==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="activityAdded">
                    Notify me when I'm added as an implementer in an activity.
                </label>
                <small class="text-secondary">
                    Enabling this option will send you a notification whenever you are added as an implementer to an activity.
                </small>
            </div>


        </div>
        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="projectStartDate" @if($notifyInProjectStart==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="projectStartDate">
                    Notify me on the day the project starts.
                </label>
                <small class="text-secondary">
                    Enabling this option will trigger a notification on the day when the specified project begins.
                </small>
            </div>


        </div>
        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="projectEndDate" @if($notifyInProjectDue==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="projectEndDate">
                    Notify me on the last day of the project's scheduled duration.
                </label>
                <small class="text-secondary">
                    Enabling this option will send a notification on the final day of the scheduled duration for the specified project.
                </small>
            </div>

        </div>
        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="projectAdded" @if($notifyProjectAdded==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="projectAdded">
                    Notify me when I'm added as a team member in a project.
                </label>
                <small class="text-secondary">
                    Enabling this option will send you a notification whenever you are added as a team member in a project.
                </small>
            </div>


        </div>

        <div class="btn-group mb-3">
            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="btnUpdateNotification">
                <b class="small">Update Notification</b>
            </button>

            <span class="ms-2 small loadingMessage" id="updateNotificationLoadingSpan" style="display: none;">Saving data...</span>
        </div>
        <div class="alert alert-danger alert-dismissible fade show ms-2 mt-1" role="alert" id="updateNotificationError" style="display: none;">
            <!-- Your error message goes here -->
            <strong>Error:</strong><span id="updateNotificationErrorMessage"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="alert alert-success mt-3" id="updateNotificationSuccessMessage" style="display:none;">
            Notification Settings updated successfully!
        </div>

    </div>
    <div>
        <div class="border border-1 border-success border-top-0 border-end-0 border-start-0 mb-3">
            <h4 class="p-2 pb-0">
                <b>Email Forwarding Settings</b>
            </h4>
        </div>
        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="emailSubtaskAdded" @if($emailSubtaskAdded==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="emailSubtaskAdded">
                    Send me an email when I got assigned in a subtask.
                </label>
                <small class="text-secondary">
                    Enabling this option will send you a notification whenever you are assigned in a subtask.
                </small>
            </div>


        </div>
        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="emailActivityAdded" @if($emailActivityAdded==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="emailActivityAdded">
                    Send me an email when I'm added as an implementer in an activity.
                </label>
                <small class="text-secondary">
                    Enabling this option will send you a notification whenever you are added as an implementer in an activity.
                </small>
            </div>


        </div>
        <div class="mb-3">

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="emailProjectAdded" @if($emailProjectAdded==1) checked @endif>
                <label class="form-check-label fw-bold d-block" for="emailProjectAdded">
                    Send me an email when I'm added as a team member in a project.
                </label>
                <small class="text-secondary">
                    Enabling this option will send you a notification whenever you are added as a team member in a project.
                </small>
            </div>


        </div>
        <div class="btn-group mb-3">
            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="btnUpdateEmailForwarding">
                <b class="small">Update Email Forwarding</b>
            </button>
            <span class="ms-2 small loadingMessage" id="updateEmailForwardingLoadingSpan" style="display: none;">Saving data...</span>
        </div>
        <div class="alert alert-danger alert-dismissible fade show ms-2 mt-1" role="alert" id="updateEmailForwardingError" style="display: none;">
            <!-- Your error message goes here -->
            <strong>Error:</strong><span id="updateEmailForwardingErrorMessage"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="alert alert-success mt-3" id="updateEmailForwardingSuccessMessage" style="display:none;">
            Email Forwarding Settings updated successfully!
        </div>
    </div>

    <div>
        <div class="border border-1 border-success border-top-0 border-end-0 border-start-0 mb-3">
            <h4 class="p-2 pb-0">
                <b>User Account Settings</b>
            </h4>
        </div>
        <form method="post" action="{{ route('useraccount.update') }}">
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label fw-bold">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $username) }}" required>
                @error('username')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="currentPassword" class="form-label fw-bold">Current Password</label>
                <input type="password" class="form-control @error('currentPassword') is-invalid @enderror" id="currentPassword" name="currentPassword" required>
                @error('currentPassword')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="newPassword" class="form-label fw-bold">New Password</label>
                <input type="password" class="form-control @error('newPassword') is-invalid @enderror" id="newPassword" name="newPassword" required>
                @error('newPassword')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="confirmNewPassword" class="form-label fw-bold">Confirm New Password</label>
                <input type="password" class="form-control" id="confirmNewPassword" name="newPassword_confirmation" required>
            </div>

            <div class="btn-group mb-3">
                <button type="submit" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="btnUpdateUserAccount">
                    <b class="small">Update User Account</b>
                </button>
            </div>
        </form>

    </div>
    <div>
        <div class="border border-1 border-success border-top-0 border-end-0 border-start-0 mb-3">
            <h4 class="p-2 pb-0">
                <b>Display Settings</b>
            </h4>
        </div>


        <div class="mb-3">
            <label for="fontSizeRange" class="form-label fw-bold">Adjust Font Size:</label>
            <input type="range" id="fontSizeRange" min="6" max="36" step="1" value="{{ $fontSize }}">

            <!-- Display the selected font size -->
            <span id="fontSizeValue">{{ $fontSize }}</span> px
        </div>
        <div class="btn-group mb-3">
            <button type="button" class="btn btn-sm rounded border border-1 border-warning btn-gold shadow" id="btnUpdateDisplay">
                <b class="small">Update Display</b>
            </button>
            <span class="ms-2 small loadingMessage" id="updateDisplayLoadingSpan" style="display: none;">Saving data...</span>
        </div>
        <div class="alert alert-danger alert-dismissible fade show ms-2 mt-1" role="alert" id="updateDisplayError" style="display: none;">
            <!-- Your error message goes here -->
            <strong>Error:</strong><span id="updateDisplayErrorMessage"></span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="alert alert-success mt-3" id="updateDisplaySuccessMessage" style="display: none;">
            Display Settings updated successfully! Please refresh site for the updated display.
        </div>


    </div>

    <script>
        document.addEventListener('livewire:load', function() {
            const lastName = document.getElementById('lastName');
            const firstName = document.getElementById('firstName');
            const middleName = document.getElementById('middleName');
            const bio = document.getElementById('bio');
            const socialProfile = document.getElementById('socialProfile');

            const subtaskToDoDate = document.getElementById('subtaskToDoDate');
            const subtaskDueDate = document.getElementById('subtaskDueDate');
            const addedAssignee = document.getElementById('addedAssignee');
            const activityStartDate = document.getElementById('activityStartDate');
            const activityEndDate = document.getElementById('activityEndDate');
            const activityAdded = document.getElementById('activityAdded');
            const projectStartDate = document.getElementById('projectStartDate');
            const projectEndDate = document.getElementById('projectEndDate');
            const projectAdded = document.getElementById('projectAdded');

            const emailSubtaskAdded = document.getElementById('emailSubtaskAdded');
            const emailActivityAdded = document.getElementById('emailActivityAdded');
            const emailProjectAdded = document.getElementById('emailProjectAdded');

            const fontSizeRange = document.getElementById('fontSizeRange');
            const fontSizeValue = document.getElementById('fontSizeValue');

            const btnUpdateProfile = document.getElementById('btnUpdateProfile');
            const btnUpdateNotification = document.getElementById('btnUpdateNotification');
            const btnUpdateEmailForwarding = document.getElementById('btnUpdateEmailForwarding');
            const btnUpdateDisplay = document.getElementById('btnUpdateDisplay');

            btnUpdateProfile.addEventListener('click', function() {
                var profileData = {
                    lastName: lastName.value,
                    firstName: firstName.value,
                    middleName: middleName.value,
                    bio: bio.value,
                    socialProfile: socialProfile.value
                };
                btnUpdateProfile.disabled = true;
                document.getElementById('updateProfileLoadingSpan').style.display = 'block';
                Livewire.emit('updateProfile', profileData);

            });

            Livewire.on('updateProfileSuccess', function() {

                document.getElementById('updateProfileSuccessMessage').style.display = 'block';
                btnUpdateProfile.disabled = false;
                document.getElementById('updateProfileLoadingSpan').style.display = 'none';
                // You may want to hide the message after a certain time
                setTimeout(function() {
                    document.getElementById('updateProfileSuccessMessage').style.display = 'none';
                }, 3000);

            });

            Livewire.on('updateProfileFailed', function(e) {
                document.getElementById('updateProfileErrorMessage').textContent = e;
                document.getElementById('updateProfileError').style.display = 'block';

                btnUpdateProfile.disabled = false;
                document.getElementById('updateProfileLoadingSpan').style.display = 'none';
            });

            btnUpdateNotification.addEventListener('click', function() {
                var subtaskToDoDateValue = 0;
                var subtaskDueDateValue = 0;
                var addedAssigneeValue = 0;
                var activityStartDateValue = 0;
                var activityEndDateValue = 0;
                var activityAddedValue = 0;
                var projectStartDateValue = 0;
                var projectEndDateValue = 0;
                var projectAddedValue = 0;
                if (subtaskToDoDate.checked === true) {
                    subtaskToDoDateValue = 1;
                }
                if (subtaskDueDate.checked === true) {
                    subtaskDueDateValue = 1;
                }
                if (addedAssignee.checked === true) {
                    addedAssigneeValue = 1;
                }
                if (activityStartDate.checked === true) {
                    activityStartDateValue = 1;
                }
                if (activityEndDate.checked === true) {
                    activityEndDateValue = 1;
                }
                if (activityAdded.checked === true) {
                    activityAddedValue = 1;
                }
                if (projectStartDate.checked === true) {
                    projectStartDateValue = 1;
                }
                if (projectEndDate.checked === true) {
                    projectEndDateValue = 1;
                }
                if (projectAdded.checked === true) {
                    projectAddedValue = 1;
                }
                var notificationData = {
                    notifyInSubtaskToDo: subtaskToDoDateValue,
                    notifyInSubtaskDue: subtaskDueDateValue,
                    notifySubtaskAdded: addedAssigneeValue,
                    notifyInActivityStart: activityStartDateValue,
                    notifyInActivityDue: activityEndDateValue,
                    notifyActivityAdded: activityAddedValue,
                    notifyInProjectStart: projectStartDateValue,
                    notifyInProjectDue: projectEndDateValue,
                    notifyProjectAdded: projectAddedValue,
                };

                btnUpdateNotification.disabled = true;
                document.getElementById('updateNotificationLoadingSpan').style.display = 'block';
                Livewire.emit('updateNotification', notificationData);

            });

            Livewire.on('updateNotificationSuccess', function() {

                document.getElementById('updateNotificationSuccessMessage').style.display = 'block';
                btnUpdateNotification.disabled = false;
                document.getElementById('updateNotificationLoadingSpan').style.display = 'none';
                // You may want to hide the message after a certain time
                setTimeout(function() {
                    document.getElementById('updateNotificationSuccessMessage').style.display = 'none';
                }, 3000);

            });

            Livewire.on('updateNotificationFailed', function(e) {
                document.getElementById('updateNotificationErrorMessage').textContent = e;
                document.getElementById('updateNotificationError').style.display = 'block';

                btnUpdateNotification.disabled = false;
                document.getElementById('updateNotificationLoadingSpan').style.display = 'none';
            });

            btnUpdateEmailForwarding.addEventListener('click', function() {

                var emailSubtaskAddedValue = 0;
                var emailActivityAddedValue = 0;
                var emailProjectAddedValue = 0;

                if (emailSubtaskAdded.checked === true) {
                    emailSubtaskAddedValue = 1;
                }
                if (emailActivityAdded.checked === true) {
                    emailActivityAddedValue = 1;
                }
                if (emailProjectAdded.checked === true) {
                    emailProjectAddedValue = 1;
                }

                var emailForwardingData = {
                    emailSubtaskAdded: emailSubtaskAddedValue,
                    emailActivityAdded: emailActivityAddedValue,
                    emailProjectAdded: emailProjectAddedValue,
                };

                btnUpdateEmailForwarding.disabled = true;
                document.getElementById('updateEmailForwardingLoadingSpan').style.display = 'block';
                Livewire.emit('updateEmailForwarding', emailForwardingData);

            });

            Livewire.on('updateEmailForwardingSuccess', function() {

                document.getElementById('updateEmailForwardingSuccessMessage').style.display = 'block';
                btnUpdateEmailForwarding.disabled = false;
                document.getElementById('updateEmailForwardingLoadingSpan').style.display = 'none';
                // You may want to hide the message after a certain time
                setTimeout(function() {
                    document.getElementById('updateEmailForwardingSuccessMessage').style.display = 'none';
                }, 3000);

            });

            Livewire.on('updateEmailForwardingFailed', function(e) {
                document.getElementById('updateEmailForwardingErrorMessage').textContent = e;
                document.getElementById('updateEmailForwardingError').style.display = 'block';

                btnUpdateEmailForwarding.disabled = false;
                document.getElementById('updateEmailForwardingLoadingSpan').style.display = 'none';
            });

            btnUpdateDisplay.addEventListener('click', function() {
                var displayData = {
                    fontSize: fontSizeRange.value
                };
                Livewire.emit('updateDisplay', displayData);
            });

            Livewire.on('updateDisplaySuccess', function() {
                document.getElementById('updateDisplaySuccessMessage').style.display = 'block';
                btnUpdateDisplay.disabled = false;
                document.getElementById('updateDisplayLoadingSpan').style.display = 'none';
                // You may want to hide the message after a certain time
                setTimeout(function() {
                    document.getElementById('updateDisplaySuccessMessage').style.display = 'none';
                }, 3000);
            });

            Livewire.on('updateDisplayFailed', function(e) {
                document.getElementById('updateDisplayErrorMessage').textContent = e;
                document.getElementById('updateDisplayError').style.display = 'block';
                btnUpdateDisplay.disabled = false;
                document.getElementById('updateDisplayLoadingSpan').style.display = 'none';
            });

            fontSizeRange.addEventListener('input', () => {
                const fontSize = fontSizeRange.value;
                fontSizeValue.textContent = fontSize;

            });
        });
    </script>
</div>