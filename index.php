<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        li {
            display: block;
            float: left;
            width: 50px;
            height: 50px;
            margin: auto;
            padding-top: 25px;
            text-align: center;
        }
    </style>
    <title>Heatmap</title>
</head>

<body>
    <h2>Example</h2>
    <?php
    require "heatmap.php";

    // set scale by tuning below variable
    $scale = 20;

    $listcolor = '<ul>';
    for ($i = 0; $i <= $scale; $i++) {
        $listcolor .= '<li style="background-color:' . numberToColorHsl($i / $scale, 0, 1) . '">' . $i . "</li>\n";
    }
    $listcolor .= '</ul>';

    echo $listcolor;
    ?>
</body>

</html>