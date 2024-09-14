<x-app-layout>
    @slot('header')
        {{ _('報告登録') }}
    @endslot
    @include('reports._form', [
        'action' => route('reports.store'),
        'method' => 'POST',
        'buttonText' => __('登録'),
        'report' => null,
    ])
    <script>
        // プレビュー
        const fileForm = document.getElementById('imgFile'); // IDがimgFileの要素を取得
        const filePreview = document.getElementById('imgPreview'); // IDがimgPreviewの要素を取得
        // フォームの変更のイベントに処理を追加
        fileForm.onchange = function() {
            const reader = new FileReader(); // 読み込み用Readerを用意
            // Rederで読み込んだときの処理を追加
            reader.onload = function(e) {
                filePreview.src = e.target.result; // 読み取りした内容をプレビュー用要素に指定
            };
            reader.readAsDataURL(this.files[0]); // フォームで読み込んだファイルをReaderで読み取り
        };
    </script>
    <script>
        // 地図表示
        // すべてのファイルが読み込まれてから処理
        window.onload = (e) => {
            // 地図表示
            const map = L.map('map').setView([38.9866042, 141.1137843], 15); // centerとzoomの値を指定
            L.tileLayer('http://tile.openstreetmap.jp/{z}/{x}/{y}.png').addTo(map); // 地図タイルを表示
            // フォーム要素を取得
            const lat = document.getElementById('latitude');
            const lng = document.getElementById('longitude');
            let clicked;
            let marker;
            // クリックでピン立て
            map.on('click', function(e) {
                if (clicked !== true) {
                    clicked = true;
                    marker = L.marker([
                        e.latlng['lat'],
                        e.latlng['lng']
                    ], {
                        draggable: true
                    }).addTo(map);
                    lat.value = e.latlng['lat'];
                    lng.value = e.latlng['lng'];
                    marker.on('dragend', function(event) {
                        const position = marker.getLatLng();
                        lat.value = position.lat;
                        lng.value = position.lng;
                    });
                }
            });
        }
    </script>
</x-app-layout>
