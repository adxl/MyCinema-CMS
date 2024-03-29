<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="description de la page d'authentification'">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Template d'authentification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <link rel="stylesheet" href="/Views/dist/front.css">
    <script type="module" src="/Views/dist/main.min.js"></script>
</head>

<body>
    <section id="login-section" class="h-100 w-100">
        <?php include $this->view ?>
    </section>
</body>

</html>