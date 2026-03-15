<?php

namespace App\Domain\Contact\Actions;

use App\Domain\Contact\Models\ContactMessage;

class DeleteContactMessage
{
    public function execute(ContactMessage $message): void
    {
        $message->delete();
    }
}
