<?php

const DATA_JSON = 'data.json';
require_once __DIR__ . '/vendor/autoload.php';

use PhpGpio\Gpio;

$gpio = new GPIO();
$numButtons = 9;
$mapping = [
    1 => 15,
    2 => 16,
    3 => 4,
    4 => 5,
    5 => 6,
    7 => 10,
    8 => 11,
    9 => 31,
];
$data = file_exists(DATA_JSON) ? json_decode(file_get_contents(DATA_JSON)) : [];
$dataCopy = $data;

if (!empty($_POST)) {
    for ($i = 1; $i <= $numButtons; $i++) {
        $key = sprintf('%02d', $i);
        if (array_key_exists($key, $_POST)) {
            $dataCopy[$i] = (int)$_POST[$key];
        }
        if ($data[$i] !== $dataCopy[$i]) {
            $pinNo = $mapping[$i];
            $gpio->setup($pinNo, 'out');
            $gpio->output($pinNo, $dataCopy[$i]);
        }
    }
}
@file_put_contents(DATA_JSON, json_encode($dataCopy));

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Flat UI - Free Bootstrap Framework and Theme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="dist/css/vendor/bootstrap.min.css" rel="stylesheet">
    <link href="dist/css/flat-ui.css" rel="stylesheet">
    <link rel="shortcut icon" href="dist/favicon.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <!--[if lt IE 9]>
      <script src="dist/js/vendor/html5shiv.js"></script>
      <script src="dist/js/vendor/respond.min.js"></script>
    <![endif]-->
    <style>.container { margin-top: 70px; }</style>
  </head>
  <body>
    <nav class="navbar fixed-top navbar-light bg-light">
      <a class="navbar-brand" href="#">Fixed top</a>
    </nav>
    <div class="container">
      <div class="row">
        <div class="col col-md-6 col-sm-12">
            <form action="/" method="post">
              <?php for ($i = 1; $i <= $numButtons; $i++): ?>
                <div class="form-check">
                  <label for="chk<?=sprintf('%02d', $i);?>">Switch <?=sprintf('%02d', $i);?></label>
                  <input type="checkbox" checked="<?=$dataCopy[$i] ? 'checked' : '';?>" name="ch<?=sprintf('%02d', $i);?>" data-toggle="switch" id="chk<?=sprintf('%02d', $i);?>" data-on-text="<span class='fui-check'></span>" data-off-text="<span class='fui-cross'></span>">
                </div>
              <?php endfor; ?>
              <button type="submit" class="btn btn-lg btn-primary">Submit</button>
            </form>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js@1.14.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="http://vjs.zencdn.net/6.6.3/video.js"></script>
    <script src="dist/scripts/flat-ui.js"></script>
    <script src="docs/assets/js/application.js"></script>
  </body>
</html>
