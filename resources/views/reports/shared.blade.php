<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Reports</title>
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
            justify-content: flex-start;
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
        }
        header button:hover {
            background-color: #56306b;
        }
        .header-left {
            display: flex;
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
        }

        header nav button:hover {
            background-color: #56306b;
        }
        .header-right {
            margin-left: auto;
        }
        h1 {
            margin-top: 10px;
            margin-bottom: 30px;
            color: #6a3093;
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
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            width: 100%;
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
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #4e4d4d;
            width: 90%;
            padding: 0 20px;
        }
        .icon-button {
            background: #a2d9fb;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: background 0.2s;
            margin: 0 10px;
            position: relative;
            z-index: 1;
        }
        .icon-button:hover {
            background: #80bcfd;
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
    </style>
</head>
<body>
<header>
    <div class="header-left">
        <button onclick="window.location.href='/user-templates'">Deadlines</button>
        <button onclick="window.location.href='/reports/history'">History</button>
        <button onclick="window.location.href='/reports/shared'">Shared</button>
    </div>
    <div class="header-right">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Log Out</button>
        </form>
    </div>
</header>
<main>
    <h1>Shared Reports</h1>
    @if ($documents->isEmpty())
        <p>No reports found.</p>
    @else
        <div class="card-container">
            @foreach ($documents as $document)
                <div class="card">
                    <div class="card-title">{{ $document->title }} de la {{ $document->user->username }}</div>
                    <div class="card-footer">
                        <span>{{ $document->created_at->format('d.m.Y H:i') }}</span>
                        <div class="icon-button">
                            <a href="{{ route('reports.download', $document->id) }}" download="{{ $document->title }}.pdf">
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
