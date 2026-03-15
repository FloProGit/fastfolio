<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contact\Actions\DeleteContactMessage;
use App\Domain\Contact\Models\ContactMessage;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);

        return view('admin.contacts.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        $message->markAsRead();

        return view('admin.contacts.show', compact('message'));
    }

    public function destroy(ContactMessage $message, DeleteContactMessage $action)
    {
        $action->execute($message);

        return redirect()->route('admin.contacts.index')
            ->with('success', __('Message supprimé.'));
    }
}
