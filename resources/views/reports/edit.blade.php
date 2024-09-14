<x-app-layout>
    @slot('header')
        {{ _('報告編集') }}
    @endslot

    @include('reports._form', [
        'action' => route('reports.update', $report),
        'method' => 'PATCH',
        'buttonText' => __('更新'),
        'report' => $report,
    ])

    <script>
        // 地図表示
        const report = @js($report);
        // すべてのファイルが読み込まれてから処理
        window.onload = (e) => {
            // 地図表示
            const map = L.map('map').setView([report.latitude, report.longitude], 15); // centerとzoomの値を指定
            L.tileLayer('http://tile.openstreetmap.jp/{z}/{x}/{y}.png').addTo(map); // 地図タイルを表示
            L.marker([report.latitude, report.longitude]).addTo(map);
        }
    </script>
</x-app-layout>
