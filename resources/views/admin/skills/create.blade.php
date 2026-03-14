@extends('admin.dashboard')

@section('page-title', 'Ajouter une compétence')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Ajouter une compétence</h2>
        <p class="mt-1 text-sm/6 text-gray-600 dark:text-gray-400">Renseignez les informations de la compétence.</p>

        <form method="POST" action="{{ route('admin.skills.store') }}" class="mt-10">
            @csrf

            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-4">
                    <label for="name_fr" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Nom (FR)</label>
                    <div class="mt-2">
                        <input id="name_fr" type="text" name="name[fr]" value="{{ old('name.fr') }}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('name.fr')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-4">
                    <label for="name_en" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Nom (EN)</label>
                    <div class="mt-2">
                        <input id="name_en" type="text" name="name[en]" value="{{ old('name.en') }}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('name.en')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="category" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Catégorie</label>
                    <div class="mt-2 grid grid-cols-1">
                        <select id="category" name="category"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                            <option value="">-- Choisir --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->value }}" {{ old('category') === $category->value ? 'selected' : '' }}>
                                    {{ ucfirst($category->value) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('category')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="level" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Niveau</label>
                    <div class="mt-2 grid grid-cols-1">
                        <select id="level" name="level"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                            <option value="">-- Choisir --</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->value }}" {{ old('level') === $level->value ? 'selected' : '' }}>
                                    {{ ucfirst($level->value) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('level')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="icon" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Icône</label>
                    <div class="mt-2">
                        <input id="icon" type="text" name="icon" value="{{ old('icon') }}" placeholder="ex: devicon-laravel-plain"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('icon')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="sort_order" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Ordre d'affichage</label>
                    <div class="mt-2">
                        <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('sort_order')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('admin.skills.index') }}" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Annuler</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
@endsection
