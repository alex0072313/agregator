<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hi!</title>
</head>
<body>
    Hellow world!
    <?php foreach ($test_results as $test_result): ?>
        <p><?php echo $test_result['value'] ?></p>
    <?php endforeach; ?>
</body>
</html>
