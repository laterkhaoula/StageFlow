@extends('layouts.app')

@section('content')
<div class="page-container max-w-4xl">
    <div class="mb-8">
        <h1 class="page-title">Mes notifications</h1>
        <p class="page-subtitle">Suivez l'activité récente concernant vos candidatures et vos offres.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-6">{{ session('success') }}</div>
    @endif

    @if($notifications->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center shadow-sm">
            <div class="mx-auto inline-flex items-center justify-center h-14 w-14 rounded-full bg-slate-100 text-slate-400 mb-4">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900">Aucune notification</h3>
            <p class="text-slate-500 mt-1">Vous n'avez pas de nouvelle notification pour le moment.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($notifications as $notification)
                @php
                    $data = $notification->data ?? [];
                    $isAccept = false;
                    $isRefuse = false;

                    if (!empty($data['candidate_name'])) {
                        $message = 'Nouvelle candidature de '.$data['candidate_name'].' pour « '.($data['offre_title'] ?? 'un stage').' »';
                    } elseif (!empty($data['status'])) {
                        $isAccept = $data['status'] === 'acceptee';
                        $isRefuse = $data['status'] === 'refusee';
                        $statusLabel = $isAccept ? 'acceptée' : ($isRefuse ? 'refusée' : $data['status']);
                        $message = 'Votre candidature pour « '.($data['offre_title'] ?? 'un stage').' » a été '.$statusLabel;
                        if (!empty($data['company_name'])) {
                            $message .= ' chez '.$data['company_name'];
                        }
                    } else {
                        $message = $data['message'] ?? 'Notification système StageFlow';
                    }
                @endphp

                <div class="bg-white rounded-2xl border {{ is_null($notification->read_at) ? 'border-blue-200 bg-blue-50/20' : 'border-slate-200' }} p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm transition-all">
                    <div class="flex items-start gap-4">
                        <div class="h-10 w-10 rounded-xl flex items-center justify-center shrink-0 {{ $isAccept ? 'bg-emerald-50 text-emerald-600' : ($isRefuse ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600') }}">
                            @if($isAccept)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif($isRefuse)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>

                        <div>
                            <p class="text-base font-bold text-slate-900 leading-snug">{{ $message }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-1">
                                {{ $notification->created_at ? $notification->created_at->format('d/m/Y à H:i') : '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0 self-end sm:self-center">
                        @if(is_null($notification->read_at))
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">Marquer comme lu</button>
                            </form>
                        @else
                            <span class="text-xs font-medium text-slate-400">Lu</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if($notifications->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $notifications->links() }}
            </div>
        @endif
    @endif
</div>
@endsection