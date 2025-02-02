<div class="max-w-4xl mx-auto py-10 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($method != 'POST')
                @method($method)
            @endif
            <div class="mt-10 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('カテゴリー') }}</h2>
                <div class="mt-0 col-span-2">
                    @foreach ($categories as $category)
                        <label>
                            <input type="radio" name="category_id" value="{{ $category->id }}" 
                                @checked(old('category_id', $report?->category_id) == $category->id) @disabled($method != 'POST')>
                            {{ $category->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('写真') }}</h2>
                <div class="mt-0 col-span-2">
                    <label>
                        <input type="file" name="image" id="imgFile" accept="image/*"
                            class="hidden input-preview__src" @disabled($method != 'POST')>
                        <img id="imgPreview" class="w-full h-80 border border-solid border-black object-contain"
                            src="{{ $report?->image_path ?? 'https://placehold.jp/15/ccc/000/300x300.png?text=%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%82%92%E9%81%B8%E6%8A%9E%E3%81%97%E3%81%A6%E3%81%8F%E3%81%A0%E3%81%95%E3%81%84' }}">
                    </label>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('場所') }}</h2>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                <div class="mt-0 col-span-2">
                    <div class="w-full h-80 border border-solid border-black">
                        <div class="h-full" id="map"></div>
                    </div>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('内容') }}</h2>
                <div class="mt-0 col-span-2">
                    <textarea name="detail" class="w-full h-full" @disabled($method != 'POST')>{{ old('detail', $report?->detail) }}</textarea>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('メールアドレス') }}</h2>
                <div class="mt-0 col-span-2">
                    <input type="email" name="email" class="w-full" value="{{ old('email', $report?->email) }}"
                        @disabled($method != 'POST')>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('連絡先') }}</h2>
                <div class="mt-0 col-span-2">
                    <input type="tel" name="contact" class="w-full" value="{{ old('contact', $report?->contact) }}"
                        @disabled($method != 'POST')>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('報告日') }}</h2>
                <div class="mt-0 col-span-2">
                    <div class="grid grid-cols-5">
                        <div class="col-span-2">
                            <input type="datetime-local" name="reported_at" class="w-full" 
                                value="{{ old('reported_at', $report?->reported_at) }}" @disabled($method != 'POST')>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('対応状況') }}</h2>
                <div class="mt-0 col-span-2">
                    <div class="grid grid-cols-5">
                        <div class="col-span-2">
                            <select name="status_id" class="w-full">
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" @selected(old('status_id', $report?->latestHistory->status_id) == $status->id)>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('非対応理由') }}</h2>
                <div class="mt-0 col-span-2">
                    <div class="grid grid-cols-5">
                        <div class="col-span-2">
                            <select name="reason_id" class="w-full">
                                <option></option>
                                @foreach ($reasons as $reason)
                                    <option value="{{ $reason->id }}" @selected(old('reason_id', $report?->latestHistory->reason_id) == $reason->id)>
                                        {{ $reason->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('コメント') }}</h2>
                <div class="mt-0 col-span-2">
                    <textarea name="comment" class="w-full h-full">{{ old('comment', $report?->latestHistory->comment) }}</textarea>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('対応予定期間') }}</h2>
                <div class="mt-0 col-span-2">
                    <div class="grid grid-cols-5">
                        <div class="col-span-2">
                            <input type="date" name="start_date" class="w-full"
                                value="{{ old('start_date', $report?->latestHistory->start_date?->format('Y-m-d')) }}">
                        </div>
                        <div class="text-center content-center"> ~ </div>
                        <div class="col-span-2">
                            <input type="date" name="end_date" class="w-full"
                                value="{{ old('end_date', $report?->latestHistory->end_date?->format('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-2 grid grid-cols-3 gap-6">
                <h2 class="text-lg font-medium content-center">{{ __('対応完了日') }}</h2>
                <div class="mt-0 col-span-2">
                    <div class="grid grid-cols-5">
                        <div class="col-span-2">
                            <input type="date" name="completed_at" class="w-full"
                                value="{{ old('completed_at', $report?->latestHistory->completed_at?->format('Y-m-d')) }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-10">
                <input type="submit" value="{{ $buttonText }}" class="border border-black px-3 py-1">
            </div>
        </form>
    </div>
</div> 












