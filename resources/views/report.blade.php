<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $data['title'] }}</title>
    <style>
        body {
            margin: 40px;
            font-size: 11px;
        }
        .header {
            text-align: left;
            margin-bottom: 20px;
        }
        .header p {
            font-size: 12px;
        }
        .title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 18px;
            font-weight: bold;
        }
        .chapter {
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        .subchapter {
            margin-left: 20px;
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: bold;
        }
        .subchapter-title {
            margin-bottom: 5px;
        }
        .content {
            font-size: 12px;
            font-weight: normal;
            word-wrap: break-word;
        }
        .footer-content {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            width: 50%;
        }
        .footer-content div {
            float: left;
            width: 50%;
        }
        .stanga{
            margin-right: 100%;
            height: 100px;
        }
        .dreapta{
            margin-left: 150%;
            height: 100px;
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
                <div class="content">
                    @if(isset($subchapter['extra']))
                        @foreach($subchapter['extra'] as $extra)
                            <p>{{ $extra }}</p>
                        @endforeach
                    @endif
                    <p>{!! nl2br(e($subchapter['content'])) !!}</p>
                </div>
            </div>
        @endforeach
    </div>
@endforeach

<div class="footer-content">
    <div style="text-align: left;" class="stanga">Data: {{ $data['date'] }}</div>
    <div style="text-align: right;" class="dreapta">Semnatura: {{ $data['signature'] }}</div>
</div>
</body>
</html>
