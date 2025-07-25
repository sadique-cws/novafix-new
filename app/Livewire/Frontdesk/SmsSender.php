<?php

namespace App\Livewire\Frontdesk;

use App\Services\Msg91Service;
use Livewire\Attributes\Layout;
use Livewire\Component;

class SmsSender extends Component
{
    public $mobile;
    public $message;
    public $response;
    public $isSuccess = false;
    #[Layout('components.layouts.frontdesk-layout')]

    public function sendOtp(Msg91Service $msg91)
    {
        $this->validate([
            'mobile' => 'required|digits:10',
            'message' => 'required|string|max:160'
        ]);

        $response = $msg91->sendOtp($this->mobile, $this->message);

        if ($response) {
            $this->isSuccess = true;
            $this->response = 'SMS sent successfully!';
        } else {
            $this->response = 'Failed to send SMS. Please try again.';
        }
    }
    public function render()
    {
        return view('livewire.frontdesk.sms-sender');
    }
}
