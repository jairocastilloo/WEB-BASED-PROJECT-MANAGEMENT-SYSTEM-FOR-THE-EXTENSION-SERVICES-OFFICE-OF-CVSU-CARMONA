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
            <textarea class="form-control" aria-label="Bio Data" aria-describedby="bio-data" value="{{ $bio }}" placeholder="Tell us a little about yourself"></textarea>
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
                <label class="form-check-label fw-bold d-block" for="activityStart">
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



    </div>
    <div class="border border-1 border-success border-top-0 border-end-0 border-start-0">
        <h4 class="p-2 pb-0">
            <b>Email Forwarding Settings</b>
        </h4>
    </div>
    <div class="border border-1 border-success border-top-0 border-end-0 border-start-0">
        <h4 class="p-2 pb-0">
            <b>User Account Settings</b>
        </h4>
    </div>
    <div class="border border-1 border-success border-top-0 border-end-0 border-start-0">
        <h4 class="p-2 pb-0">
            <b>Display Settings</b>
        </h4>
    </div>
</div>