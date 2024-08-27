<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
</head>

<body>
    <?php include './functions.php'; ?>
    <header class="inset-x-0 top-0 z-50">
        <?php require './views/partials/nav.php' ?>
    </header>
    <main class="w-60% flex justify-center align-center">
        <?php
        require './app.php';
        ?>
    </main>
    <footer>
        <?php require './views/partials/footer.php' ?>
    </footer>
</body>

</html>