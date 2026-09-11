<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes notifications</title>
</head>
<body>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Mes notifications</h1>

        @if($notifications->isEmpty())
            <p>Aucune notification pour le moment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Message</th>
                            <th class="border px-4 py-2 text-left">Date</th>
                            <th class="border px-4 py-2 text-left">État</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($notifications as $notification)
                            <tr>
                                <td class="border px-4 py-2">
                                    {{ $notification->data['message'] ?? $notification->data['status'] ?? 'Notification' }}
                                </td>
                                <td class="border px-4 py-2">
                                    {{ $notification->created_at ? $notification->created_at->format('d/m/Y H:i') : '-' }}
                                </td>
                                <td class="border px-4 py-2">
                                    @if($notification->read_at)
                                        <span>Lu</span>
                                    @else
                                        <span>Non lu</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>
