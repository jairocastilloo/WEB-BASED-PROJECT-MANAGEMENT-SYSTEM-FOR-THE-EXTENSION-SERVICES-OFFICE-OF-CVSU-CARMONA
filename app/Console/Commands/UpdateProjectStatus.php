<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Project;

class UpdateProjectStatus extends Command
{

    protected $signature = 'project:status:update';

    protected $description = 'Update project status based on conditions';

    public function handle()
    {

        $this->updateScheduledProjects();
        $this->updateInProgressProjects();
        $this->updateOverdueProjects();
    }
    private function updateInProgressProjects()
    {
        $now = Carbon::today();

        Project::where('projectstartdate', '<=', $now)
            ->where('projectenddate', '>=', $now)
            ->whereNotIn('projectstatus', ['Completed'])
            ->update(['projectstatus' => 'In Progress']);
    }


    private function updateScheduledProjects()
    {
        $now = Carbon::today();

        Project::where('projectstartdate', '>', $now)
            ->update(['projectstatus' => 'Scheduled']);
    }
    private function updateOverdueProjects()
    {
        $now = Carbon::today();

        Project::where('projectenddate', '<', $now)
            ->where('projectstatus', '<>', 'Completed') // Use 'where' method with '<>' for not equal comparison
            ->update(['projectstatus' => 'Incomplete']);
    }
}
