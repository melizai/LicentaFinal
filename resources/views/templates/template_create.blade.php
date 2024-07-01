<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Template</title>
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
        form {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background: #efdff9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="datetime-local"], input[type="file"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .chapter-container, .subchapter-container {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #cfcfcf;
            border-radius: 4px;
            background-color: white;
        }
        .subchapter-container {
            margin-left: 20px;
        }
        .buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .add-chapter-container {
            display: flex;
            justify-content: flex-start;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        button {
            padding: 10px 20px;
            background-color: #6a3093;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #56306b;
        }
        .remove-button {
            background-color: #9a0000;
        }
        .remove-button:hover {
            background-color: #820000;
        }
    </style>
    <script>
        let chapterCount = 0;

        function addChapter() {
            const chapterContainer = document.createElement('div');
            chapterContainer.classList.add('chapter-container');

            const chapterTitleInput = document.createElement('input');
            chapterTitleInput.setAttribute('type', 'text');
            chapterTitleInput.setAttribute('name', `chapters[${chapterCount}][title]`);
            chapterTitleInput.setAttribute('placeholder', 'Chapter Title');

            const subchapterContainer = document.createElement('div');
            subchapterContainer.classList.add('subchapter-container');
            subchapterContainer.setAttribute('data-chapter', chapterCount);

            const addSubchapterButton = document.createElement('button');
            addSubchapterButton.setAttribute('type', 'button');
            addSubchapterButton.textContent = 'Add Subchapter';
            addSubchapterButton.style.marginRight = '10px';
            addSubchapterButton.addEventListener('click', () => addSubchapter(subchapterContainer));

            const removeChapterButton = document.createElement('button');
            removeChapterButton.setAttribute('type', 'button');
            removeChapterButton.classList.add('remove-button');
            removeChapterButton.textContent = 'Remove Chapter';
            removeChapterButton.addEventListener('click', () => chapterContainer.remove());

            chapterContainer.appendChild(chapterTitleInput);
            chapterContainer.appendChild(subchapterContainer);
            chapterContainer.appendChild(addSubchapterButton);
            chapterContainer.appendChild(removeChapterButton);

            document.getElementById('chapters').appendChild(chapterContainer);
            chapterCount++;
        }

        function addSubchapter(container) {
            const chapterIndex = container.getAttribute('data-chapter');
            const subchapterIndex = container.children.length;

            const subchapterWrapper = document.createElement('div');
            subchapterWrapper.classList.add('subchapter-wrapper');
            subchapterWrapper.style.marginTop = '10px';

            const subchapterInput = document.createElement('input');
            subchapterInput.setAttribute('type', 'text');
            subchapterInput.setAttribute('name', `chapters[${chapterIndex}][subchapters][${subchapterIndex}][title]`);
            subchapterInput.setAttribute('placeholder', 'Subchapter Title');
            subchapterInput.style.marginBottom = '10px';

            const removeSubchapterButton = document.createElement('button');
            removeSubchapterButton.setAttribute('type', 'button');
            removeSubchapterButton.classList.add('remove-button');
            removeSubchapterButton.textContent = 'Remove Subchapter';
            removeSubchapterButton.addEventListener('click', () => subchapterWrapper.remove());

            subchapterWrapper.appendChild(subchapterInput);
            subchapterWrapper.appendChild(removeSubchapterButton);
            container.appendChild(subchapterWrapper);
        }

        function toggleUploadField() {
            const fileUploadField = document.getElementById('fileUploadField');
            fileUploadField.style.display = fileUploadField.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>
<header>
    <div class="header-left">
        <button onclick="window.location.href='/templates'">Templates</button>
    </div>
    <div class="header-right">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Log Out</button>
        </form>
    </div>
</header>

<main>
    <h1>Create Template</h1>
    <form method="POST" action="{{ route('templates.store') }}">
        @csrf
        <div>
            <label for="name">Nume Template</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="deadline">Deadline</label>
            <input type="datetime-local" id="deadline" name="deadline" required>
        </div>
        <div id="chapters"></div>
        <div class="add-chapter-container">
            <button type="button" class="add-chapter" onclick="addChapter()">Add Chapter</button>
        </div>
        <div>
            <label for="zip_description">Descriere ZIP (optional)</label>
            <input type="text" id="zip_description" name="zip_description" placeholder="Descrie ce fisiere sunt necesare">
        </div>
        <div class="buttons">
            <button type="submit" style="box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);">Create Template</button>
        </div>
    </form>
</main>
<footer>
</footer>
</body>
</html>
