<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Форма обратной связи</title>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <form action="{{ route('feedbacks.store') }}" method="post">
                <div class="form-data">
                    <label for="phone"></label>
                    <input type="number" id="phone" name="phone">
                </div>
                <div class="form-data">
                    <label for="name"></label>
                    <input type="text" id="name" name="name">
                </div>
                <div class="form-data">
                    <label for="message"></label>
                    <textarea id="message" name="message"></textarea>
                </div>
                <div class="submit">
                    <button>Отправить</button>
                </div>
            </form>
        </div>
    </body>
</html>
