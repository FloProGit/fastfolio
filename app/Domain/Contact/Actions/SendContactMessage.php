<?php

namespace App\Domain\Contact\Actions;

use App\Domain\Contact\Models\ContactMessage;

class SendContactMessage
{
    public function execute(array $data): ContactMessage
    {
        return ContactMessage::create($data);
    }
}
