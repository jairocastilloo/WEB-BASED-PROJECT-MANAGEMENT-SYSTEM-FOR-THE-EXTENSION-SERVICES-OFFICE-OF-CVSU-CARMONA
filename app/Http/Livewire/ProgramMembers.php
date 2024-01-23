<?php

namespace App\Http\Livewire;

use App\Models\Notification;
use App\Models\ProgramUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyMail;
use Livewire\Component;
use App\Models\EmailLogs;

class ProgramMembers extends Component
{

    public $program;
    public $members;
    public $addmembers;
    public $department;
    protected $listeners = ['saveMembers' => 'handleSaveMembers', 'sendNotification' => 'handleSendNotification'];

    public function mount($indexprogram, $department)
    {
        $this->program = $indexprogram;

        // Retrieve the member IDs associated with the project
        $memberIds = ProgramUser::where('program_id', $this->program->id)
            ->pluck('user_id');

        // Fetch the members using the retrieved IDs
        $this->members = User::whereIn('id', $memberIds)->get();
        if ($department != "All") {
            $this->addmembers = User::where(function ($query) use ($department) {
                $query->where('department', $department)
                    ->orWhere('department', 'All');
            })
                ->whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        } else {
            $this->addmembers = User::whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        }
        $this->department = $department;
    }
    public function saveMembers($selectedMembers)
    {
        foreach ($selectedMembers as $memberId) {
            ProgramUser::create(['user_id' => $memberId, 'program_id' => $this->program->id]);
        }
        // Retrieve the member IDs associated with the project
        $memberIds = ProgramUser::where('program_id', $this->program->id)->pluck('user_id');

        // Fetch the members using the retrieved IDs
        $this->members = User::whereIn('id', $memberIds)->get();
        $department = $this->department;
        if ($this->department != "All") {
            $this->addmembers = User::where(function ($query) use ($department) {
                $query->where('department', $department)
                    ->orWhere('department', 'All');
            })
                ->whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        } else {
            $this->addmembers = User::whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        }
        $this->emit('updateElements', $selectedMembers);
    }
    public function unassignMembers($selectedMember)
    {
        ProgramUser::where('user_id', $selectedMember)
            ->where('program_id', $this->program->id)
            ->delete();
        $memberIds = ProgramUser::where('program_id', $this->program->id)->pluck('user_id');
        Notification::where('task_id', $this->program->id)
            ->where('user_id', $selectedMember)
            ->where('task_type', 'program')
            ->delete();
        // Fetch the members using the retrieved IDs
        $this->members = User::whereIn('id', $memberIds)->get();
        $department = $this->department;
        if ($this->department != "All") {
            $this->addmembers = User::where(function ($query) use ($department) {
                $query->where('department', $department)
                    ->orWhere('department', 'All');
            })
                ->whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        } else {
            $this->addmembers = User::whereNotIn('id', $memberIds)
                ->where('approval', 1)
                ->get();
        }
        $this->emit('updateUnassignElements');
    }
    public function sendNotification($selectedMembers)
    {
        $isMailSendable = 1;
        $sendername = Auth::user()->name . ' ' . Auth::user()->last_name;
        $error = null;
        $message =  $sendername . ' added you as a team member to a program: "' . $this->program->programName . '".';
        foreach ($selectedMembers as $selectedMember) {
            $assignee = User::findorFail($selectedMember);

            if ($assignee->notifyProgramAdded == 1) {
                $notification = new Notification([
                    'user_id' => $selectedMember,
                    'task_id' => $this->program->id,
                    'task_type' => "program",
                    'task_name' => $this->program->programName,
                    'message' => $message,
                ]);
                $notification->save();
            }

            if ($assignee->emailProgramAdded == 1) {
                if ($isMailSendable === 1) {
                    $email = $assignee->email;
                    $name = $assignee->name . ' ' . $assignee->last_name;
                    $taskname = $this->program->programName;
                    $tasktype = "program";
                    $startDate = date('F d, Y', strtotime($this->program->startDate));
                    $endDate = date('F d, Y', strtotime($this->program->endDate));

                    $taskdeadline = $startDate . ' - ' . $endDate;
                    $senderemail = Auth::user()->email;

                    try {
                        Mail::to($email)->send(new MyMail($message, $name, $sendername, $taskname, $tasktype, $taskdeadline, $senderemail));
                    } catch (\Exception $e) {
                        $failedEmail = new EmailLogs([
                            'email' => $email,
                            'message' => $message,
                            'name' => $name,
                            'sendername' => $sendername,
                            'taskname' => $taskname,
                            'taskdeadline' => $taskdeadline,
                            'tasktype' => $tasktype,
                            'senderemail' => $senderemail
                        ]);
                        $failedEmail->save();
                        $isMailSendable = 0;
                    }
                } else {
                    $email = $assignee->email;
                    $name = $assignee->name . ' ' . $assignee->last_name;
                    $taskname = $this->program->programName;
                    $tasktype = "program";
                    $startDate = date('F d, Y', strtotime($this->program->startDate));
                    $endDate = date('F d, Y', strtotime($this->program->endDate));

                    $taskdeadline = $startDate . ' - ' . $endDate;
                    $senderemail = Auth::user()->email;

                    $failedEmail = new EmailLogs([
                        'email' => $email,
                        'message' => $message,
                        'name' => $name,
                        'sendername' => $sendername,
                        'taskname' => $taskname,
                        'taskdeadline' => $taskdeadline,
                        'tasktype' => $tasktype,
                        'senderemail' => $senderemail
                    ]);
                    $failedEmail->save();
                }
            }
        }
        if ($isMailSendable === 1) {
            $this->emit('updateLoading');
        } else {
            $this->emit('updateLoadingFailed', $error);
        }
    }
    public function handleSaveMembers($selectedMembers)
    {
        $this->saveMembers($selectedMembers);
    }
    public function handleSendNotification($selectedMembers)
    {
        $this->sendNotification($selectedMembers);
    }
    public function render()
    {
        return view('livewire.program-members');
    }
}
