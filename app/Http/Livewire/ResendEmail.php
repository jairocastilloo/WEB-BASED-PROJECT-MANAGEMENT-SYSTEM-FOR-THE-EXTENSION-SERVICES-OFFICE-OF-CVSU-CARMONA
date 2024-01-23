<?php

namespace App\Http\Livewire;

use App\Models\EmailLogs;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyMail;

class ResendEmail extends Component
{
    public $currentPage = 1; // The current page number
    public $perPage = 10;
    protected $listeners = ['sendEmail' => 'handlesendEmail'];
    use WithPagination;
    public function sendEmail($id)
    {
        $emailLog = EmailLogs::findOrFail($id);
        $email = $emailLog->email;
        $message = $emailLog->message;
        $name = $emailLog->name;
        $sendername = $emailLog->sendername;
        $taskname = $emailLog->taskname;
        $tasktype = $emailLog->tasktype;
        $taskdeadline = $emailLog->taskdeadline;
        $senderemail = $emailLog->senderemail;

        try {
            Mail::to($email)->send(new MyMail($message, $name, $sendername, $taskname, $tasktype, $taskdeadline, $senderemail));
            $emailLog->delete();
            $this->emit('updateLoading', $id);
        } catch (\Exception $e) {
            $this->emit('updateLoadingFailed', $id, $e->getMessage());
        }
    }
    public function handlesendEmail($id)
    {
        $this->sendEmail($id);
    }
    public function render()
    {
        $emailLogs = EmailLogs::query()
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

        return view(
            'livewire.resend-email',
            [
                'emailLogs' => $emailLogs,
                'totalPages' => $emailLogs->lastPage(),
            ]
        );
    }
}
