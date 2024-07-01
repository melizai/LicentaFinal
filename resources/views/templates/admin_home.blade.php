<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Templates</title>
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
            color: #9e0000;
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
        .icon-button.delete {
            background: #fbb3ba;
        }
        .icon-button.delete:hover {
            background: #ff7582;
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
    <h1>Templates</h1>
    @if ($templates->isEmpty())
        <p>No templates found.</p>
    @else
        <div class="card-container">
            @foreach ($templates as $template)
                <div class="card" onclick="window.location.href='{{ route('templates.reports', $template->id) }}'">
                    <div class="card-title">{{ $template->name }}</div>
                    <div class="card-footer">
                        <span>Deadline: {{$template->deadline->format('d.m.Y, H:i') }}</span>
                        @if($template->deadline->isFuture())
                            <div class="icon-button delete">
                                <a href="javascript:void(0);" onclick="deleteTemplate('{{ $template->id }}');">
                                    <svg viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M9,3V4H4V6H5V20A2,2 0 0,0 7,22H17A2,2 0 0,0 19,20V6H20V4H15V3H9M7,6H17V20H7V6M9,8V18H11V8H9M13,8V18H15V8H13Z" />
                                    </svg>
                                </a>
                                <form id="delete-form-{{ $template->id }}" action="{{ route('templates.delete', $template->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>
<footer>
</footer>
<script>
    function deleteTemplate(templateId) {
        const form = document.getElementById('delete-form-' + templateId);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _method: 'DELETE'
            })
        }).then(response => {
            if (response.ok) {
                window.location.href = '/templates';
            } else {
                response.json().then(data => {
                    alert('Error: ' + data.error || 'An error occurred. Please try again.');
                });
            }
        }).catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
</script>
</body>
</html>
