<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Notification;
use App\Models\Output;
use Carbon\Carbon;
use Illuminate\Console\Command;


class UpdateActivityStatus extends Command
{
    protected $signature = 'activity:status:update';

    protected $description = 'Update activity status based on conditions';

    public function handle()
    {
        /*
        $this->updateScheduledActivities();
        $this->updateInProgressActivities();
        $this->updatePendingActivities();
        $this->updateOverdueActivities();
        */
        //$this->changeAllOutputs();
        $notification = new Notification([
            'user_id' => 1,
            'task_id' => 501,
            'task_type' => "project",
            'task_name' => "Watch a movie",
            'message' => "Admin Name appointed you as a Project Leader to a new project:",
        ]);
        $notification->save();
    }
    public function changeAllRemarks()
    {
        $activities = Activity::all();
        foreach ($activities as $activity) {
            // Generate a random value between 'Incomplete' and 'Completed'
            $CompleteorIncomplete = rand(0, 1) ? 'Completed' : 'Incomplete';

            // Update the 'actremark' field with the randomly generated value
            $activity->update(['actremark' => $CompleteorIncomplete]);
        }
    }
    public function changeAllOutputs()
    {
        $outputs = Output::all();
        foreach ($outputs as $output) {
            // Generate a random value between 'Incomplete' and 'Completed'
            $CompleteorIncomplete = rand(0, 100);

            // Update the 'actremark' field with the randomly generated value
            $output->update(['expectedoutput' => $CompleteorIncomplete]);
        }
    }
    private function updateInProgressActivities()
    {
        $now = Carbon::today();

        Activity::where('actstartdate', '<=', $now)
            ->where('actenddate', '>=', $now)
            ->whereNotIn('actremark', ['Completed', 'Pending'])
            ->update(['actremark' => 'In Progress']);
    }

    private function updatePendingActivities()
    {
        $now = Carbon::today();

        $activityids = Activity::where('actstartdate', '<=', $now)
            ->where('actenddate', '>=', $now)
            ->whereNotIn('actremark', ['Completed'])
            ->pluck('id');

        foreach ($activityids as $activityid) {
            $output = Output::where('activity_id', $activityid)
                ->where('totaloutput_submitted', '<>', 0) // Use 'where' method with '<>' for not equal comparison
                ->get();

            if ($output->count() > 0) { // Check if there are any matching outputs
                Activity::where('id', $activityid)
                    ->update(['actremark' => 'Pending']);
            }
        }
    }

    private function updateScheduledActivities()
    {
        $now = Carbon::today();

        Activity::where('actstartdate', '>', $now)
            ->update(['actremark' => 'Scheduled']);
    }
    private function updateOverdueActivities()
    {
        $now = Carbon::today();

        Activity::where('actenddate', '<', $now)
            ->where('actremark', '<>', 'Completed') // Use 'where' method with '<>' for not equal comparison
            ->update(['actremark' => 'Overdue']);
    }
}
