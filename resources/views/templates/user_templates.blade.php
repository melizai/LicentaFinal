<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deadlines</title>
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
        header nav a {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            padding: 0 20px;
            color: white;
            text-decoration: none;
            font-size: 16px;
            background-color: #6a3093;
        }
        header nav a:hover {
            background-color: #56306b;
        }
        .header-right {
            margin-left: auto;
        }
        main {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 60px;
            padding: 20px;
            overflow-y: auto;
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
            justify-content: center;
            cursor: pointer;
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
            flex-direction: column;
        }
        .deadline {
            color: #d50202;
            margin-top: 5px;
        }
        .card-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            font-size: 14px;
        }
        .status-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            color: white;
            margin-left: 5px;
        }
        .completed {
            background-color: green;
        }
        .not-completed {
            border: 2px solid red;
            background-color: transparent;
        }
        .missed {
            background-color: #9e0000;
            position: relative;
        }
        .missed::after {
            content: '✖';
            color: white;
            font-size: 14px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .status-text {
            display: flex;
            align-items: center;
        }
        .missed-card {
            pointer-events: none;
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
    <h1>Reports To Do</h1>
    <div class="card-container">
        @foreach ($templates->sortBy(function ($template) use ($completedTemplates) {
            if (in_array($template->id, $completedTemplates)) {
                return '1' . $template->deadline->timestamp;
            } elseif ($template->deadline->isFuture()) {
                return '0' . $template->deadline->timestamp;
            } else {
                return '2' . $template->deadline->timestamp;
            }
        }) as $template)
            <div class="card @if($template->deadline->isPast() && !in_array($template->id, $completedTemplates)) missed-card @endif"
                 @if(!$template->deadline->isPast() && !in_array($template->id, $completedTemplates)) onclick="window.location.href='/reports/create/{{ $template->id }}'" @endif>
                <div class="card-title">
                    {{ $template->name }}
                    <div class="deadline">Deadline: {{$template->deadline->format('d.m.Y, H:i') }}</div>
                </div>
                <div class="card-footer">
                    <div class="status-text">
                        @if (in_array($template->id, $completedTemplates))
                            Uploaded
                            <div class="status-icon completed">&#10004;</div>
                        @elseif ($template->deadline->isFuture())
                            Not Uploaded
                            <div class="status-icon not-completed"></div>
                        @else
                            Missed
                            <div class="status-icon missed"></div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</main>
<footer>
</footer>
</body>
</html>
