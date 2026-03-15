@extends('admin.dashboard')

@section('page-title', 'Modifier le profil')

@section('content')
    <div class="mx-auto max-w-2xl">
        <h2 class="text-base/7 font-semibold text-gray-900 dark:text-white">Modifier le profil</h2>
        <p class="mt-1 text-sm/6 text-gray-600 dark:text-gray-400">Informations affichées sur le portfolio.</p>

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="mt-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                {{-- Titre FR --}}
                <div class="sm:col-span-3">
                    <label for="title_fr" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Titre (FR)</label>
                    <div class="mt-2">
                        <input id="title_fr" type="text" name="title[fr]" value="{{ old('title.fr', $profile->title['fr'] ?? '') }}" placeholder="Développeur Full Stack"
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
                        <input id="title_en" type="text" name="title[en]" value="{{ old('title.en', $profile->title['en'] ?? '') }}" placeholder="Full Stack Developer"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('title.en')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bio FR --}}
                <div class="sm:col-span-3">
                    <x-quill-editor name="bio[fr]" label="Bio (FR)" :value="old('bio.fr', $profile->bio['fr'] ?? '')" :rows="6" />
                </div>

                {{-- Bio EN --}}
                <div class="sm:col-span-3">
                    <x-quill-editor name="bio[en]" label="Bio (EN)" :value="old('bio.en', $profile->bio['en'] ?? '')" :rows="6" />
                </div>

                {{-- Avatar --}}
                <div class="sm:col-span-6">
                    <label class="block text-sm/6 font-medium text-gray-900 dark:text-white">Avatar</label>
                    @if($profile->avatar)
                        <div class="mt-2 flex items-center gap-4">
                            <img src="{{ asset('storage/' . $profile->avatar) }}" alt="Avatar" class="h-16 w-16 rounded-full object-cover" />
                            <span class="text-sm text-gray-500 dark:text-gray-400">Image actuelle</span>
                        </div>
                    @endif
                    <div class="mt-2">
                        <input type="file" name="avatar" accept="image/jpg,image/jpeg,image/png,image/webp"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100 dark:text-gray-400 dark:file:bg-indigo-500/10 dark:file:text-indigo-400" />
                    </div>
                    @error('avatar')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="sm:col-span-3">
                    <label for="email" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Email public</label>
                    <div class="mt-2">
                        <input id="email" type="email" name="email" value="{{ old('email', $profile->email) }}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location FR --}}
                <div class="sm:col-span-3">
                    <label for="location_fr" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Localisation (FR)</label>
                    <div class="mt-2">
                        <input id="location_fr" type="text" name="location[fr]" value="{{ old('location.fr', $profile->location['fr'] ?? '') }}" placeholder="Nîmes, France"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('location.fr')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Location EN --}}
                <div class="sm:col-span-3">
                    <label for="location_en" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Localisation (EN)</label>
                    <div class="mt-2">
                        <input id="location_en" type="text" name="location[en]" value="{{ old('location.en', $profile->location['en'] ?? '') }}" placeholder="Nîmes, France"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('location.en')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CV FR --}}
                <div class="sm:col-span-3">
                    <label for="resume_url_fr" class="block text-sm/6 font-medium text-gray-900 dark:text-white">URL CV (FR)</label>
                    <div class="mt-2">
                        <input id="resume_url_fr" type="url" name="resume_url[fr]" value="{{ old('resume_url.fr', $profile->resume_url['fr'] ?? '') }}" placeholder="https://..."
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('resume_url.fr')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- CV EN --}}
                <div class="sm:col-span-3">
                    <label for="resume_url_en" class="block text-sm/6 font-medium text-gray-900 dark:text-white">URL CV (EN)</label>
                    <div class="mt-2">
                        <input id="resume_url_en" type="url" name="resume_url[en]" value="{{ old('resume_url.en', $profile->resume_url['en'] ?? '') }}" placeholder="https://..."
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('resume_url.en')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Réseaux sociaux --}}
                <div class="sm:col-span-6">
                    <h3 class="text-sm/6 font-medium text-gray-900 dark:text-white">Réseaux sociaux</h3>
                </div>

                <div class="sm:col-span-3">
                    <label for="socials_github" class="block text-sm/6 font-medium text-gray-900 dark:text-white">GitHub</label>
                    <div class="mt-2">
                        <input id="socials_github" type="url" name="socials[github]" value="{{ old('socials.github', $profile->socials['github'] ?? '') }}" placeholder="https://github.com/..."
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('socials.github')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="socials_linkedin" class="block text-sm/6 font-medium text-gray-900 dark:text-white">LinkedIn</label>
                    <div class="mt-2">
                        <input id="socials_linkedin" type="url" name="socials[linkedin]" value="{{ old('socials.linkedin', $profile->socials['linkedin'] ?? '') }}" placeholder="https://linkedin.com/in/..."
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('socials.linkedin')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="socials_twitter" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Twitter / X</label>
                    <div class="mt-2">
                        <input id="socials_twitter" type="url" name="socials[twitter]" value="{{ old('socials.twitter', $profile->socials['twitter'] ?? '') }}" placeholder="https://x.com/..."
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('socials.twitter')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SEO --}}
                <div class="sm:col-span-6">
                    <h3 class="text-sm/6 font-medium text-gray-900 dark:text-white">SEO</h3>
                </div>

                <div class="sm:col-span-3">
                    <label for="seo_title_fr" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Titre SEO (FR)</label>
                    <div class="mt-2">
                        <input id="seo_title_fr" type="text" name="seo_title[fr]" value="{{ old('seo_title.fr', $profile->seo_title['fr'] ?? '') }}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('seo_title.fr')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="seo_title_en" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Titre SEO (EN)</label>
                    <div class="mt-2">
                        <input id="seo_title_en" type="text" name="seo_title[en]" value="{{ old('seo_title.en', $profile->seo_title['en'] ?? '') }}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('seo_title.en')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="seo_desc_fr" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Meta description (FR)</label>
                    <div class="mt-2">
                        <input id="seo_desc_fr" type="text" name="seo_desc[fr]" value="{{ old('seo_desc.fr', $profile->seo_desc['fr'] ?? '') }}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('seo_desc.fr')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-3">
                    <label for="seo_desc_en" class="block text-sm/6 font-medium text-gray-900 dark:text-white">Meta description (EN)</label>
                    <div class="mt-2">
                        <input id="seo_desc_en" type="text" name="seo_desc[en]" value="{{ old('seo_desc.en', $profile->seo_desc['en'] ?? '') }}"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 dark:bg-white/5 dark:text-white dark:outline-white/10 dark:focus:outline-indigo-500" />
                    </div>
                    @error('seo_desc.en')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="{{ route('admin.dashboard') }}" class="text-sm/6 font-semibold text-gray-900 dark:text-white">Annuler</a>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
@endsection
