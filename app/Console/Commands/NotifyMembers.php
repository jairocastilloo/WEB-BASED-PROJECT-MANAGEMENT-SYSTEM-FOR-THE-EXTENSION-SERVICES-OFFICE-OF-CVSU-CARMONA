<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\ActivityUser;
use App\Models\SubtaskUser;
use App\Models\Notification;
use App\Models\Activity;
use App\Models\Subtask;
use App\Models\ScheduledTasks;
use App\Models\User;
use Carbon\Carbon;

class NotifyMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:members';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify all members if a task due';


    public function handle()
    {

        $this->notifyTaskDue();
    }
    public function notifyTaskDue()
    {
        $now = now()->format('Y-m-d');
        $projectsStarted = Project::where('projectstartdate', $now)
            ->get(['id', 'projecttitle']);
        $projectsEnded = Project::where('projectenddate', $now)
            ->get(['id', 'projecttitle']);
        $activitiesStarted = Activity::where('actstartdate', $now)
            ->get(['id', 'actname']);
        $activitiesEnded = Activity::where('actenddate', $now)
            ->get(['id', 'actname']);

        $scheduledTasksIds = ScheduledTasks::where('scheduledDate', $now)
            ->pluck('subtask_id')
            ->unique()
            ->toArray();
        $scheduledTasks = Subtask::whereIn('id', $scheduledTasksIds)
            ->get(['id', 'subtask_name']);

        $subtasksDue = Subtask::where('subduedate', $now)
            ->get(['id', 'subtask_name']);


        $users = User::where('approval', 1)
            ->get();


        foreach ($projectsStarted as $projectStarted) {
            $membersInProjectStartedIds = ProjectUser::where('project_id', $projectStarted->id)
                ->pluck('user_id')
                ->toArray();
            $membersInProjectStarted = $users->where('notifyInProjectStart', 1)
                ->whereIn('id', $membersInProjectStartedIds)
                ->get();
            foreach ($membersInProjectStarted as $memberInProjectStarted) {
                $notification = new Notification([
                    'user_id' => $memberInProjectStarted->id,
                    'task_id' => $projectStarted->id,
                    'task_type' => "project",
                    'task_name' => $projectStarted->projecttitle,
                    'message' => "The project: " . $projectStarted->projecttitle . " starts today.",
                ]);
                $notification->save();
            }
        }
        foreach ($projectsEnded as $projectEnded) {
            $membersInProjectEndedIds = ProjectUser::where('project_id', $projectEnded->id)
                ->pluck('user_id')
                ->toArray();
            $membersInProjectEnded = $users->where('notifyInProjectDue', 1)
                ->whereIn('id', $membersInProjectEndedIds)
                ->get();
            foreach ($membersInProjectEnded as $memberInProjectEnded) {
                $notification = new Notification([
                    'user_id' => $memberInProjectEnded->id,
                    'task_id' => $projectEnded->id,
                    'task_type' => "project",
                    'task_name' => $projectEnded->projecttitle,
                    'message' => "The project: " . $projectEnded->projecttitle . " will end today.",
                ]);
                $notification->save();
            }
        }

        foreach ($activitiesStarted as $activityStarted) {
            $membersInActivityStartedIds = ActivityUser::where('activity_id', $activityStarted->id)
                ->pluck('user_id')
                ->toArray();
            $membersInActivityStarted = $users->where('notifyInActivityStart', 1)
                ->whereIn('id', $membersInActivityStartedIds)
                ->get();
            foreach ($membersInActivityStarted as $memberInActivityStarted) {
                $notification = new Notification([
                    'user_id' => $memberInActivityStarted->id,
                    'task_id' => $activityStarted->id,
                    'task_type' => "activity",
                    'task_name' => $activityStarted->actname,
                    'message' => "The activity: " . $activityStarted->actname . " will end today.",
                ]);
                $notification->save();
            }
        }

        foreach ($activitiesEnded as $activityEnded) {
            $membersInActivityEndedIds = ActivityUser::where('activity_id', $activityEnded->id)
                ->pluck('user_id')
                ->toArray();

            $membersInActivityEnded = $users->where('notifyInActivityDue', 1)
                ->whereIn('id', $membersInActivityEndedIds)
                ->get();
            foreach ($membersInActivityEnded as $memberInActivityEnded) {
                $notification = new Notification([
                    'user_id' => $memberInActivityEnded->id,
                    'task_id' => $activityEnded->id,
                    'task_type' => "activity",
                    'task_name' => $activityEnded->actname,
                    'message' => "The activity: " . $activityEnded->actname . " will end today.",
                ]);
                $notification->save();
            }
        }

        foreach ($scheduledTasks as $scheduledTask) {
            $membersInScheduledTaskIds = ScheduledTasks::where('subtask_id', $scheduledTask->id)
                ->pluck('user_id')
                ->unique()
                ->toArray();
            $membersInScheduledTask = $users->where('notifyInSubtaskToDo', 1)
                ->whereIn('id', $membersInScheduledTaskIds)
                ->get();
            foreach ($membersInScheduledTask as $memberInScheduledTask) {
                $notification = new Notification([
                    'user_id' => $memberInScheduledTask->id,
                    'task_id' => $scheduledTask->id,
                    'task_type' => "subtask",
                    'task_name' => $scheduledTask->subtask_name,
                    'message' => "The task: " . $scheduledTask->subtask_name . " is scheduled for completion today.",
                ]);
                $notification->save();
            }
        }
        foreach ($subtasksDue as $subtaskDue) {
            $membersInSubtaskDueIds = SubtaskUser::where('subtask_id', $subtaskDue->id)
                ->pluck('user_id')
                ->toArray();
            $membersInSubtaskDue = $users
                ->filter(function ($user) use ($membersInSubtaskDueIds) {
                    return $user->notifyInSubtaskDue == 1 && in_array($user->id, $membersInSubtaskDueIds);
                });

            if ($membersInSubtaskDue->isNotEmpty()) {
                foreach ($membersInSubtaskDue as $memberInSubtaskDue) {
                    $notification = new Notification([
                        'user_id' => $memberInSubtaskDue->id,
                        'task_id' => $subtaskDue->id,
                        'task_type' => "subtask",
                        'task_name' => $subtaskDue->subtask_name,
                        'message' => "The subtask: " . $subtaskDue->subtask_name . " is due today.",
                    ]);
                    $notification->save();
                }
            }
        }
    }
}
