@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h1 class="text-xl font-semibold text-gray-800">Profil étudiant</h1>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <div class="text-sm text-gray-500">Nom</div>
                        <div class="text-gray-800 font-medium">{{ $profile->user->name ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Email</div>
                        <div class="text-gray-800">{{ $profile->user->email ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Téléphone</div>
                        <div class="text-gray-800">{{ $profile->phone ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Adresse</div>
                        <div class="text-gray-800">{{ $profile->address ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Domaine de formation</div>
                        <div class="text-gray-800">{{ $profile->training_domain ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-sm text-gray-500">Compétences</div>
                        <div class="text-gray-800 whitespace-pre-wrap">{{ $profile->skills ?? '—' }}</div>
                    </div>
                </div>

                <div class="md:col-span-1 flex flex-col items-stretch gap-4">
                    <div class="bg-gray-50 p-4 rounded">
                        <div class="text-sm text-gray-500">CV</div>
                        @if(!empty($profile->cv_path))
                            <a href="{{ Storage::url($profile->cv_path) }}" target="_blank" rel="noopener" class="mt-3 inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Télécharger le CV
                            </a>
                        @else
                            <div class="text-gray-500 mt-2">Aucun CV téléchargé</div>
                        @endif
                    </div>

                    <div class="flex mt-auto">
                        <a href="{{ route('student-profile.edit') }}" class="w-full text-center px-4 py-2 bg-yellow-500 text-white rounded">Modifier</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
