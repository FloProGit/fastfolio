@props(['name', 'value' => '', 'label' => '', 'rows' => 5])

@php
    $editorId = str_replace(['[', ']', '.'], '-', $name);
@endphp

<div>
    @if($label)
        <label class="block text-sm/6 font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    @endif
    <div class="mt-2 quill-wrapper">
        <div id="quill-{{ $editorId }}" style="min-height: {{ $rows * 1.5 }}rem;"></div>
        <input type="hidden" name="{{ $name }}" id="quill-input-{{ $editorId }}" value="{{ $value }}" />
    </div>
    @error($name)
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>

@once
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css" rel="stylesheet" />
        <style>
            .quill-wrapper .ql-toolbar.ql-snow {
                border: none !important;
                border-radius: 0.375rem 0.375rem 0 0 !important;
                background: white;
                outline: 1px solid rgb(209 213 219);
                outline-offset: -1px;
            }
            .quill-wrapper .ql-container.ql-snow {
                border: none !important;
                border-radius: 0 0 0.375rem 0.375rem !important;
                font-size: 0.875rem;
                line-height: 1.5rem;
                font-family: inherit;
                background: white;
                outline: 1px solid rgb(209 213 219);
                outline-offset: -1px;
            }
            .quill-wrapper .ql-editor {
                padding: 0.375rem 0.75rem;
                color: rgb(17 24 39);
            }
            .quill-wrapper .ql-editor.ql-blank::before {
                color: rgb(156 163 175);
                font-style: normal;
            }

            /* Focus — même style que les inputs */
            .quill-wrapper .ql-container.ql-snow:focus-within {
                outline: 2px solid rgb(79 70 229);
                outline-offset: -2px;
            }

            /* Dark mode */
            .dark .quill-wrapper .ql-toolbar.ql-snow {
                background: rgba(255, 255, 255, 0.05);
                outline-color: rgba(255, 255, 255, 0.1);
            }
            .dark .quill-wrapper .ql-container.ql-snow {
                background: rgba(255, 255, 255, 0.05);
                outline-color: rgba(255, 255, 255, 0.1);
            }
            .dark .quill-wrapper .ql-container.ql-snow:focus-within {
                outline-color: rgb(99 102 241);
            }
            .dark .quill-wrapper .ql-editor {
                color: #fff;
            }
            .dark .quill-wrapper .ql-editor.ql-blank::before {
                color: #9ca3af;
            }
            .dark .quill-wrapper .ql-toolbar .ql-stroke {
                stroke: #d1d5db;
            }
            .dark .quill-wrapper .ql-toolbar .ql-fill {
                fill: #d1d5db;
            }
            .dark .quill-wrapper .ql-toolbar .ql-picker-label {
                color: #d1d5db;
            }
            .dark .quill-wrapper .ql-toolbar .ql-picker-options {
                background: rgb(31 41 55);
                outline: 1px solid rgba(255, 255, 255, 0.1);
            }
            .dark .quill-wrapper .ql-toolbar button:hover .ql-stroke,
            .dark .quill-wrapper .ql-toolbar button.ql-active .ql-stroke {
                stroke: #818cf8;
            }
            @media (prefers-color-scheme: dark) {
                .quill-wrapper .ql-toolbar.ql-snow {
                    background: rgba(255, 255, 255, 0.05);
                    outline-color: rgba(255, 255, 255, 0.1);
                }
                .quill-wrapper .ql-container.ql-snow {
                    background: rgba(255, 255, 255, 0.05);
                    outline-color: rgba(255, 255, 255, 0.1);
                }
                .quill-wrapper .ql-container.ql-snow:focus-within {
                    outline-color: rgb(99 102 241);
                }
                .quill-wrapper .ql-editor {
                    color: #fff;
                }
                .quill-wrapper .ql-editor.ql-blank::before {
                    color: #9ca3af;
                }
                .quill-wrapper .ql-toolbar .ql-stroke {
                    stroke: #d1d5db;
                }
                .quill-wrapper .ql-toolbar .ql-fill {
                    fill: #d1d5db;
                }
                .quill-wrapper .ql-toolbar .ql-picker-label {
                    color: #d1d5db;
                }
                .quill-wrapper .ql-toolbar .ql-picker-options {
                    background: rgb(31 41 55);
                    outline: 1px solid rgba(255, 255, 255, 0.1);
                }
                .quill-wrapper .ql-toolbar button:hover .ql-stroke,
                .quill-wrapper .ql-toolbar button.ql-active .ql-stroke {
                    stroke: #818cf8;
                }
            }
        </style>
    @endpush
@endonce

@push('scripts')
    @once
        <script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>
    @endonce
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quill = new Quill('#quill-{{ $editorId }}', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                        ['link'],
                        ['clean'],
                    ],
                },
            });

            const input = document.getElementById('quill-input-{{ $editorId }}');

            if (input.value) {
                quill.root.innerHTML = input.value;
            }

            quill.on('text-change', function () {
                input.value = quill.root.innerHTML;
            });
        });
    </script>
@endpush
