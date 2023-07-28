<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Output;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateActivityStatus extends Command
{
    protected $signature = 'activity:status:update';

    protected $description = 'Update activity status based on conditions';

    public function handle()
    {

        $this->updateScheduledActivities();
        $this->updateInProgressActivities();
        $this->updatePendingActivities();
        $this->updateOverdueActivities();
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
