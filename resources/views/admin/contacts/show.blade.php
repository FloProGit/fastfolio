@extends('admin.dashboard')

@section('page-title', 'Message de ' . $message->name)

@section('content')
    <div class="mx-auto max-w-2xl">
        <div class="flex items-center justify-between">
            <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Message de {{ $message->name }}</h2>
            <a href="{{ route('admin.contacts.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                &larr; Retour à l'inbox
            </a>
        </div>

        <div class="mt-6 rounded-lg border border-gray-200 bg-white p-6 dark:border-white/10 dark:bg-gray-800">
            <dl class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $message->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                        <a href="mailto:{{ $message->email }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                            {{ $message->email }}
                        </a>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Sujet</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $message->subject ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Reçu le</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $message->created_at->format('d/m/Y à H:i') }}</dd>
                </div>
                @if($message->read_at)
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Lu le</dt>
                    <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $message->read_at->format('d/m/Y à H:i') }}</dd>
                </div>
                @endif
            </dl>

            <div class="mt-6 border-t border-gray-200 pt-6 dark:border-white/10">
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Message</dt>
                <dd class="mt-2 text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $message->message }}</dd>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="mailto:{{ $message->email }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                Répondre par email
            </a>
            <form method="POST" action="{{ route('admin.contacts.destroy', $message) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 dark:bg-red-500 dark:hover:bg-red-400"
                        onclick="return confirm('Supprimer ce message ?')">
                    Supprimer
                </button>
            </form>
        </div>
    </div>
@endsection
