<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $data['title'] }}</title>
    <style>
        @font-face {
            font-family: 'DejaVuSans';
            src: url('{{ storage_path('fonts/DejaVuSans.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body {
            font-family: 'DejaVuSans', sans-serif;
            margin: 40px;
            font-size: 12px;
        }
        .header {
            text-align: left;
            margin-bottom: 20px;
        }
        .title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 20px;
            font-weight: bold;
        }
        .chapter {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .subchapter {
            margin-left: 20px;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .subchapter-title {
            margin-bottom: 5px;
        }
        .footer {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="header">
    <p>{{ $data['university'] }}</p>
    <p>{{ $data['professor'] }}</p>
</div>
<div class="title">
    <h1>{{ $data['title'] }}</h1>
</div>

@foreach($data['chapters'] as $chapter)
    <div class="chapter">
        <h2>{{ $chapter['title'] }}</h2>
        @foreach($chapter['subchapters'] as $subchapter)
            <div class="subchapter">
                <div class="subchapter-title">{{ $subchapter['title'] }}</div>
                @if(isset($subchapter['extra']))
                    @foreach($subchapter['extra'] as $extra)
                        <p>{{ $extra }}</p>
                    @endforeach
                @endif
                <p>{!! nl2br(e($subchapter['content'])) !!}</p>
            </div>
        @endforeach
    </div>
@endforeach

<div class="footer">
    <div>
        <p>Data: {{ $data['date'] }}</p>
        <p  style="text-align: right;">Semnătura: {{ $data['signature'] }}</p>
    </div>
</div>
</body>
</html>
