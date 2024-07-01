<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports History</title>
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
            box-sizing: border-box; /* Add this line */
        }

        header nav button:hover {
            background-color: #56306b;
        }
        .header-right {
            margin-left: auto;
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
            margin: 0;
        }
        header button:hover {
            background-color: #56306b;
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
            font-size: 12px;
            color: #4e4d4d;
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
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            justify-content: center;
            width: 100%;
            margin: 20px 0 0;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination a {
            color: #007BFF;
            text-decoration: none;
            font-size: 14px;
        }
        .pagination a:hover {
            text-decoration: underline;
        }
        .pagination svg {
            width: 16px;
            height: 16px;
        }
        .pagination .hidden {
            display: none;
        }

        .icon-button.download {
            background: #a2d9fb;
        }
        .icon-button.download:hover {
            background: #80bcfd;
        }

        .icon-button.share {
            background: #bcfacb;
        }
        .icon-button.share:hover {
            background: #86fba4;
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
    <h1>Reports History</h1>
    @if ($documents->isEmpty())
        <p>No reports found.</p>
    @else
        <div class="card-container">
            @foreach ($documents as $document)
                <div class="card">
                    <div class="card-title">{{ $document->title }}</div>
                    <div class="card-footer">
                        <span>{{ $document->created_at->format('d.m.Y H:i') }}</span>
                        <div class="icon-button download">
                            <a href="{{ route('reports.download', $document->id) }}" download="{{ $document->title }}.pdf">
                                <svg viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5,20H19V18H5V20M14,10.5H17L12,16.5L7,10.5H10V4H14V10.5Z" />
                                </svg>
                            </a>
                        </div>
                        <div class="icon-button share">
                            <a href="javascript:void(0);" onclick="shareReport('{{ $document->id }}')">
                                <svg viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M18,16.08C17.24,16.08 16.56,16.38 16.03,16.88L8.91,12.7C8.96,12.47 9,12.24 9,12C9,11.76 8.96,11.53 8.91,11.3L15.96,7.25C16.5,7.78 17.21,8.13 18,8.13C19.38,8.13 20.5,7 20.5,5.63C20.5,4.25 19.38,3.13 18,3.13C16.62,3.13 15.5,4.25 15.5,5.63C15.5,5.87 15.54,6.1 15.59,6.33L8.54,10.38C8,9.85 7.29,9.5 6.5,9.5C5.12,9.5 4,10.62 4,12C4,13.38 5.12,14.5 6.5,14.5C7.29,14.5 8,14.15 8.54,13.62L15.66,17.88C15.61,18.1 15.58,18.33 15.58,18.58C15.58,19.96 16.7,21.08 18.08,21.08C19.46,21.08 20.58,19.96 20.58,18.58C20.58,17.2 19.46,16.08 18,16.08Z" />
                                </svg>
                            </a>
                        </div>
                        <div class="icon-button delete">
                            <a href="javascript:void(0);" onclick="deleteReport('{{ $document->id }}');">
                                <svg viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M9,3V4H4V6H5V20A2,2 0 0,0 7,22H17A2,2 0 0,0 19,20V6H20V4H15V3H9M7,6H17V20H7V6M9,8V18H11V8H9M13,8V18H15V8H13Z" />
                                </svg>
                            </a>
                            <form id="delete-form-{{ $document->id }}" action="{{ route('reports.delete', $document->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pagination">
            {{ $documents->appends(['page_size' => 8])->links() }}
        </div>
    @endif
</main>
<footer>
</footer>
<script>
    function shareReport(documentId) {
        const username = prompt("Enter the username to share the document with:");

        if (!username) {
            alert("Username is required to share the document.");
            return;
        }

        const url = `/reports/share`;
        const data = { username: username, document_id: documentId };

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                return response.json().then(data => ({
                    status: response.status,
                    body: data
                }));
            })
            .then(({ status, body }) => {
                if (status >= 400) {
                    throw new Error(body.error || 'Unknown error');
                }
                alert('Report shared successfully!');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred: ' + error.message);
            });
    }
    function deleteReport(documentId) {
        const form = document.getElementById('delete-form-' + documentId);
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
                window.location.href = '/reports/history?page_size=8&page=1';
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
