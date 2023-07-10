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
        //$now = Carbon::now()->format('Y-m-d');
        //$this->updateOngoingActivities();
        //Activity::where('actstartdate', '=', $now)
        //->update(['actremark' => 'Ongoing']);
        // Update activities to 'Upcoming'
        //$this->updateUpcomingActivities();
        $now = Carbon::now()->format('Y-m-d');

        Activity::where('actstartdate', '<=', $now)
            ->where('actenddate', '>=', $now)
            ->where('actremark', '!=', 'Completed')
            ->update(['actremark' => 'Ongoing']);
        // Update activities to 'Incomplete'
        //$this->updateIncompleteActivities();
        //Activity::where('actremark', '=', 'Completed')
        //->update(['actsource' => $now]);

        // $this->info('Activity statuses updated successfully.');
    }
    private function updateOngoingActivities()
    {
        $now = Carbon::now()->format('Y-m-d');

        Activity::where('actstartdate', '<=', $now)
            ->where('actenddate', '>=', $now)
            ->where('actremark', '!=', 'Completed')
            ->update(['actremark' => 'Ongoing']);
    }

    private function updateUpcomingActivities()
    {
        $now = Carbon::now()->format('Y-m-d');
        $upcomingDateRange = [
            Carbon::parse($now)->addDay(),           // Tomorrow
            Carbon::parse($now)->addDays(2)          // Day after tomorrow
        ];

        Activity::whereBetween('actstartdate', $upcomingDateRange)
            ->where('actremark', '!=', 'Completed')
            ->where('actremark', '!=', 'Ongoing')
            ->update(['actremark' => 'Upcoming']);
    }

    private function updateIncompleteActivities()
    {
        $now = Carbon::now()->format('Y-m-d');
        Activity::where('actenddate', '<', $now)
            ->where('actremark', '!=', 'Completed')
            ->where('actremark', '!=', 'Ongoing')
            ->where('actremark', '!=', 'Upcoming')
            ->update(['actremark' => 'Incomplete']);
    }
}
