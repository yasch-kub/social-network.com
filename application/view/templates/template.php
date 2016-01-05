<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <?php if (isset($links)): ?>
        <?php foreach($links as $link): ?>
            <link rel="stylesheet" href="css/<? echo $link; ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (isset($scripts)): ?>
        <?php foreach($scripts as $script): ?>
            <script src="js/<? echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <?php include_once(view . $view)?>
</body>
</html>