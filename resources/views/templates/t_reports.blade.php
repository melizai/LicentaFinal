<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports for {{ $template->name }}</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        header {
            background-color: #6a3093;
            color: white;
            padding: 0;
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 50px;
        }
        header button {
            background-color: #6a3093;
            border: none;
            color: white;
            padding: 0 20px;
            height: 100%;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        header button:hover {
            background-color: #56306b;
        }
        .header-left {
            display: flex;
            align-items: center;
        }
        .header-left .new-template-button {
            margin-left: 10px;
            padding: 5px 10px;
            background-color: #a044ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            height: auto;
        }
        .header-left .new-template-button:hover {
            background-color: #8e3bb9;
        }
        header nav {
            display: flex;
            align-items: center;
            height: 100%;
        }
        header nav button {
            background-color: #6a3093;
            border: none;
            color: white;
            padding: 0 20px;
            height: 100%;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            box-sizing: border-box;
        }
        header nav button:hover {
            background-color: #56306b;
        }
        .header-right {
            margin-left: auto;
        }
        .download-all-button {
            position: absolute;
            top: 60px;
            left: 15px;
            padding: 10px 12px;
            background-color: #e9c9fd;
            color: #000000;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            margin-top: 25px;
            margin-left: 25px;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .download-all-button:hover {
            background-color: #e5bcff;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }
        .download-all-button svg {
            margin-right: 5px;
        }
        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 60px;
            padding: 20px;
            overflow: hidden;
        }
        footer {
            background-color: #6a3093;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
        h1 {
            margin-top: 10px;
            margin-bottom: 30px;
            color: #6a3093;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
            flex-grow: 1;
            overflow-y: auto;
        }
        .card {
            width: 300px;
            height: 150px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
            text-align: center;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px #ff8ef6;
        }
        .card-title {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card-footer {
            display: flex;
            justify-content: space-around;
            align-items: center;
            font-size: 14px;
            color: #0006ff;
        }
        .icon-button {
            background: #f0f0f0;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
            z-index: 1;
        }
        .icon-button:hover {
            background: #ddd;
        }
        .icon-button svg {
            width: 20px;
            height: 20px;
        }
        .icon-button a {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 2;
            text-decoration: none;
            color: inherit;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .icon-button.download {
            background: #a2d9fb;
        }
        .icon-button.download:hover {
            background: #80bcfd;
        }
    </style>
</head>
<body>
<header>
    <div class="header-left">
        <button onclick="window.location.href='/templates'">Templates</button>
        <button class="new-template-button" onclick="window.location.href='/templates/create'">+ New Template</button>
    </div>
    <div class="header-right">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Log Out</button>
        </form>
    </div>
</header>

<main>
    <button class="download-all-button" onclick="window.location.href='{{ route('admin.reports.downloadAll', $template->id) }}'">
        <svg viewBox="0 0 24 24" fill="currentColor" style="width: 20px; height: 20px;">
            <path d="M5,20H19V18H5V20M14,10.5H17L12,16.5L7,10.5H10V4H14V10.5Z" />
        </svg>
        Download All
    </button>
    <h1>{{ $template->name }}</h1>
    @if ($reports->isEmpty())
        <p>No reports found for this template.</p>
    @else
        <div class="card-container">
            @foreach ($reports as $report)
                <div class="card">
                    <div class="card-title">{{ $report->user->username }}</div>
                    <div class="card-footer">
                        <span>Created on: {{ $report->created_at->format('d.m.Y, H:i') }}</span>
                        <div class="icon-button download">
                            <a href="{{ route('admin.reports.download', ['id' => $report->id]) }}" download="{{ $report->user->username }}_{{ $report->template_id }}.pdf">
                                <svg viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5,20H19V18H5V20M14,10.5H17L12,16.5L7,10.5H10V4H14V10.5Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
<footer>
</footer>
</body>
</html>
