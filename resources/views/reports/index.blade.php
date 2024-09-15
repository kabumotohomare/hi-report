<x-app-layout>
    @slot('header')
        {{ _('報告一覧') }}
    @endslot


    {{-- 検索部分 --}}
    <div class="max-w-4xl mx-auto mt-5">
        <div class=" bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('reports.index') }}">
                <div class="grid grid-cols-3 gap-1 p-6">
                    <div class="col-span-1">
                        カテゴリー
                    </div>
                    <div class="col-span-2">
                        <div class="grid grid-cols-4 gap-6">
                            @foreach ($categories as $category)
                                <label>
                                    <input type="checkbox" name="category_id[]" value="{{ $category->id }}"
                                        @checked(in_array($category->id, old('category_id', request()->query('category_id')) ?? []))>
                                    {{ $category->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-span-1">
                        対応状況
                    </div>
                    <div class="col-span-2">
                        <div class="grid grid-cols-{{ $statuses->count() }} gap-1">
                            @foreach ($statuses as $status)
                                <label>
                                    <input type="checkbox" name="status_id[]" value="{{ $status->id }}" id=""
                                        @checked(in_array($status->id, old('status_id', request()->query('status_id')) ?? []))>
                                    {{ $status->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-span-1">
                        報告日
                    </div>
                    <input type="date" name="reported_start_date" class="py-0"
                        value="{{ old('reported_start_date',request()->has('reported_start_date')? request()->query('reported_start_date'): now()->addMonth(-1)->format('Y-m-d')) }}">
                    <input type="date" name="reported_end_date" class="py-0"
                        value="{{ old('reported_end_date', request()->query('reported_end_date')) }}">
                    <div class="col-span-1">
                        対応予定期間
                    </div>
                    <input type="date" name="start_date" class="py-0"
                        value="{{ old('start_date', request()->query('start_date')) }}">
                    <input type="date" name="end_date" class="py-0"
                        value="{{ old('end_date', request()->query('end_date')) }}">
                    <div class="col-span-1">
                        完了日
                    </div>
                    <input type="date" name="completed_start_date" class="py-0"
                        value="{{ old('completed_start_date', request()->query('completed_start_date')) }}">
                    <input type="date" name="completed_end_date" class="py-0"
                        value="{{ old('completed_end_date', request()->query('completed_end_date')) }}">
                    <div class="flex mt-6">
                        <div class="border border-solid border-black p-1">
                            <input type="submit" value="再検索">
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>

    {{-- 一覧表示 --}}
    <div class="max-w-4xl mx-auto mt-5">
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <div class="max-h-96 overflow-scroll scrollbar-hidden">
                <table class="table-auto w-full text-center">
                    <thead class="sticky top-0 bg-gray-100">
                        <tr>
                            <th></th>
                            <th>カテゴリー</th>
                            <th>対応状態</th>
                            <th>非対応理由</th>
                            <th>報告日</th>
                            <th>開始予定 ~ 終了予定</th>
                            <th>完了日</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr>
                                <td>
                                    <img src="{{ $report->image_path }}" alt=""
                                        class="h-12 w-12 object-contain">
                                </td>
                                <td>{{ $report->category_name }}</td>
                                <td>{{ $report->status_name }}</td>
                                <td>{{ $report->reason_name }}</td>
                                <td>{{ $report->reported_at->format('Y/m/d') }}</td>
                                <td>
                                    {{ $report->latestHistory->start_date?->format('Y/m/d') }} ~
                                    {{ $report->latestHistory->end_date?->format('Y/m/d') }}
                                </td>
                                <td>
                                    {{ $report->latestHistory->completed_at?->format('Y/m/d') }}
                                </td>
                                <td>
                                    <a href="{{ route('reports.edit', $report) }}">
                                        <div
                                            class="border border-solid border-black py-1 px-3 rounded-md hover:bg-gray-300">
                                            編集
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        <br>
                        対応状況
                        @foreach ($statuses as $status)
                            <input type="checkbox" name="category_id[]" value="{{ $category->id }}"
                                @checked(in_array($category->id, old('category_id', request()->query('category_id')) ?? []))>
                            {{ $status->name }}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- 地図表示 --}}
    <div class="max-w-4xl mx-auto mt-5 h-96 border border-solid border-black">
        <div class="h-full" id="map"></div>
    </div>
    {{-- スペーサー --}}
    <div class="pt-5"></div>
    <script>
        // 地図表示
        // すべてのファイルが読み込まれてから処理
        window.onload = (e) => {
            // 地図表示
            const map = L.map('map').setView([38.9866042, 141.1137843], 15); // centerとzoomの値を指定
            L.tileLayer('http://tile.openstreetmap.jp/{z}/{x}/{y}.png').addTo(map); // 地図タイルを表示
            // PHPの変数からJavaScriptの変数に変換
            const reports = @js($reports);

            // マーカーを追加(jsディレクティブではオブジェクトが渡されるので値を取得)
            for (const report of Object.values(reports)) {
                L.marker([report.latitude, report.longitude]).addTo(map);
            }
        }
    </script>
</x-app-layout>
