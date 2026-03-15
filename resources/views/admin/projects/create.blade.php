@extends('admin.dashboard')

@section('page-title', 'Ajouter un projet')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Ajouter un projet</h2>
        <p class="mt-1 text-sm/6 text-gray-600 dark:text-gray-400">Renseignez les informations du projet.</p>

        <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data" class="mt-10">
            @csrf

            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                {{-- Titre FR --}}
                <div class="sm:col-span-3">
                    <label for="title_fr" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Titre (FR)</label>
                    <div class="mt-2">
                        <input id="title_fr" type="text" name="title[fr]" value="{{ old('title.fr') }}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('title.fr')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Titre EN --}}
                <div class="sm:col-span-3">
                    <label for="title_en" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Titre (EN)</label>
                    <div class="mt-2">
                        <input id="title_en" type="text" name="title[en]" value="{{ old('title.en') }}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('title.en')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug FR --}}
                <div class="sm:col-span-3">
                    <label for="slug_fr" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Slug (FR)</label>
                    <div class="mt-2">
                        <input id="slug_fr" type="text" name="slug[fr]" value="{{ old('slug.fr') }}" placeholder="mon-projet"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('slug.fr')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Slug EN --}}
                <div class="sm:col-span-3">
                    <label for="slug_en" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Slug (EN)</label>
                    <div class="mt-2">
                        <input id="slug_en" type="text" name="slug[en]" value="{{ old('slug.en') }}" placeholder="my-project"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('slug.en')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Extrait FR --}}
                <div class="sm:col-span-3">
                    <div class="mt-2">

                        <x-quill-editor name="excerpt[fr]" label="Extrait (FR)" :value="old('excerpt.fr')" :rows="5" />

{{--                        <textarea id="excerpt_fr" name="excerpt[fr]" rows="3"--}}
{{--                                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500">{{ old('excerpt.fr') }}</textarea>--}}
                    </div>
                    @error('excerpt.fr')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Extrait EN --}}
                <div class="sm:col-span-3">
                    <div class="mt-2">
                        <x-quill-editor name="excerpt[en]" label="Extrait (EN)" :value="old('excerpt.en')" :rows="5" />

{{--                        <textarea id="excerpt_en" name="excerpt[en]" rows="3"--}}
{{--                                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500">{{ old('excerpt.en') }}</textarea>--}}
                    </div>
                    @error('excerpt.en')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description FR --}}
                <div class="sm:col-span-3">
                    <div class="mt-2">
                        <x-quill-editor name="description[fr]" label="Description (FR)" :value="old('description.fr')" :rows="5" />
{{--                        <textarea id="description_fr" name="description[fr]" rows="5"--}}
{{--                                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500">{{ old('description.fr') }}</textarea>--}}
                    </div>
                    @error('description.fr')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description EN --}}
                <div class="sm:col-span-3">
                    <div class="mt-2">
                        <x-quill-editor name="description[en]" label="Description (EN)" :value="old('description.en')" :rows="5" />

{{--                        <textarea id="description_en" name="description[en]" rows="5"--}}
{{--                                  class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500">{{ old('description.en') }}</textarea>--}}
                    </div>
                    @error('description.en')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- URL --}}
                <div class="sm:col-span-3">
                    <label for="url" class="block text-sm/6 font-medium text-gray-900 dark:text-white">URL du projet</label>
                    <div class="mt-2">
                        <input id="url" type="url" name="url" value="{{ old('url') }}" placeholder="https://example.com"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('url')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Repository URL --}}
                <div class="sm:col-span-3">
                    <label for="repository_url" class="block text-sm/6 font-medium text-gray-900 dark:text-white">URL du dépôt</label>
                    <div class="mt-2">
                        <input id="repository_url" type="url" name="repository_url" value="{{ old('repository_url') }}" placeholder="https://github.com/..."
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('repository_url')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Statut --}}
                <div class="sm:col-span-2">
                    <label for="status" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Statut</label>
                    <div class="mt-2 grid grid-cols-1">
                        <select id="status" name="status"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:*:bg-gray-800 dark:focus:outline-indigo-500">
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ old('status') === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('status')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Featured --}}
                <div class="sm:col-span-2">
                    <label for="featured" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Mis en avant</label>
                    <div class="mt-2">
                        <input id="featured" type="checkbox" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}
                               class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-white/10 dark:bg-white/5" />
                    </div>
                </div>

                {{-- Sort order --}}
                <div class="sm:col-span-2">
                    <label for="sort_order" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Ordre d'affichage</label>
                    <div class="mt-2">
                        <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('sort_order')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Date de réalisation --}}
                <div class="sm:col-span-3">
                    <label for="completed_at" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Date de réalisation</label>
                    <div class="mt-2">
                        <input id="completed_at" type="date" name="completed_at" value="{{ old('completed_at') }}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('completed_at')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Images --}}
                <div class="sm:col-span-6">
                    <label class="block text-sm/6 font-medium text-gray-900 dark:text-white">Images du projet</label>
                    <div id="images-container" class="mt-2 space-y-4">
                        <template id="image-template">
                            <div class="image-row rounded-md border border-gray-300 p-4 dark:border-white/10">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label class="block text-sm text-gray-700 dark:text-gray-300">Fichier</label>
                                        <input type="file" name="images[__INDEX__][file]" accept="image/jpg,image/jpeg,image/png,image/webp"
                                               class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 dark:text-gray-400 dark:file:bg-indigo-500/10 dark:file:text-indigo-400" />
                                    </div>
                                    <div class="sm:col-span-3 flex items-end gap-4">
                                        <label class="inline-flex items-center gap-x-2">
                                            <input type="checkbox" name="images[__INDEX__][is_main]" value="1"
                                                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-white/10 dark:bg-white/5" />
                                            <span class="text-sm text-gray-700 dark:text-gray-300">Image principale</span>
                                        </label>
                                        <button type="button" onclick="this.closest('.image-row').remove()"
                                                class="text-sm text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            Retirer
                                        </button>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label class="block text-sm text-gray-700 dark:text-gray-300">Alt (FR)</label>
                                        <input type="text" name="images[__INDEX__][alt_fr]"
                                               class="mt-1 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label class="block text-sm text-gray-700 dark:text-gray-300">Alt (EN)</label>
                                        <input type="text" name="images[__INDEX__][alt_en]"
                                               class="mt-1 block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button type="button" id="add-image-btn"
                            class="mt-3 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-white/5 dark:text-white dark:ring-white/10 dark:hover:bg-white/10">
                        + Ajouter une image
                    </button>
                    @error('images')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Skills --}}
                <div class="sm:col-span-6">
                    <label class="block text-sm/6 font-medium text-gray-900 dark:text-white">Compétences associées</label>
                    <div class="mt-2 flex flex-wrap gap-3">
                        @foreach($skills as $skill)
                            <label class="inline-flex items-center gap-x-2">
                                <input type="checkbox" name="skill_ids[]" value="{{ $skill->id }}"
                                       {{ in_array($skill->id, old('skill_ids', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-white/10 dark:bg-white/5" />
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $skill->getTranslation('name') }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('skill_ids')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('admin.projects.index') }}" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Annuler</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    <script>
        let imageIndex = 0;
        document.getElementById('add-image-btn').addEventListener('click', function () {
            const template = document.getElementById('image-template');
            const clone = template.content.cloneNode(true);
            clone.querySelector('.image-row').innerHTML = clone.querySelector('.image-row').innerHTML.replaceAll('__INDEX__', imageIndex);
            document.getElementById('images-container').appendChild(clone);
            imageIndex++;
        });
    </script>
@endpush
