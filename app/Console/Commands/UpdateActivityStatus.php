<?php

namespace App\Console\Commands;

use App\Models\Activity;
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
        //$this->updatePendingActivities();
        //$this->updateOverdueActivities();
    }
    private function updateInProgressActivities()
    {
        $now = Carbon::today();

        Activity::where('actstartdate', '<=', $now)
            ->where('actenddate', '>=', $now)
            ->whereNotIn('actremark', ['Completed', 'Pending'])
            ->update(['actremark' => 'In Progress']);
    }

    private function updateScheduledActivities()
    {
        $now = Carbon::today();

        Activity::where('actstartdate', '>', $now)
            ->update(['actremark' => 'Scheduled']);
    }
}
