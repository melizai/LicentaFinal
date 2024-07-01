<!DOCTYPE html>
<html>
<head>
    <title>Template Deadline Reminder</title>
</head>
<body>
<h1>Reminder: Template Deadline</h1>
<p>Buna ziua, {{ $user->last_name }} {{ $user->first_name }}!</p>
<p>Acesta este un reminder ca termenul limita pentru template-ul <strong>{{ $template->name }}</strong> se apropie in mai putin de 24 de ore.</p>
<p>Deadline: {{ $template->deadline }}</p>
<p>Va rugam sa va asigurati ca finalizati toate actiunile necesare inainte de termenul limita.</p>
<p>Va multumim!</p>
</body>
</html>
