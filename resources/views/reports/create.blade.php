<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: white;
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: auto;
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
            z-index: 1;
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
            overflow: auto;
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
            text-align: center;
            margin-top: 10px;
            margin-bottom: 30px;
            color: #6a3093;
        }
        .header-right form{
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
        .header-right form:hover {
            background-color: #56306b;
        }
        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background: #efdff9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], input[type="file"], textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        button {
            padding: 10px 20px;
            background-color: #6a3093;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
        }
        button:hover {
            background-color: #56306b;
        }
    </style>
    <script>
        function handleFormSubmit(action) {
            const form = document.getElementById('reportForm');
            form.action = "{{ route('reports.generate', ['templateId' => $templateId]) }}";
            form.submit();
        }
    </script>
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
    <h1>Create Report</h1>
    <div class="container">
        <form id="reportForm" method="POST" action="{{ route('reports.generate', ['templateId' => $templateId]) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="university">University</label>
                <input type="text" id="university" name="university">
            </div>
            <div class="form-group">
                <label for="professor">Professor</label>
                <input type="text" id="professor" name="professor">
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>
            </div>
            <div class="form-group">
                <label for="signature">Signature</label>
                <input type="text" id="signature" name="signature" required>
            </div>
            @foreach($template->content as $chapter)
                <h3>{{ $chapter['title'] }}</h3>
                <div class="form-group">
                    @foreach($chapter['subchapters'] as $subchapter)
                        <label for="subchapter{{ $loop->parent->index }}_{{ $loop->index }}">{{ $subchapter['title'] }}</label>
                        <textarea id="subchapter{{ $loop->parent->index }}_{{ $loop->index }}" name="subchapter{{ $loop->parent->index }}_{{ $loop->index }}"></textarea>
                    @endforeach
                </div>
            @endforeach
            @if($template->zip_description)
                <div class="form-group">
                    <label for="zip_file">{{ $template->zip_description }}</label>
                    <input type="file" id="zip_file" name="zip_file" accept=".zip">
                </div>
            @endif
            <div class="buttons">
                <button type="button" onclick="handleFormSubmit('upload')">Upload</button>
            </div>
        </form>
    </div>
</main>
<footer>
</footer>
</body>
</html>
