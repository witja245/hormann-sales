<?php

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$calcExport = Asteq\CalculatorExport::export();


Header("Content-Type: application/force-download");
Header("Content-Type: application/octet-stream");
Header("Content-Type: application/download");
Header("Content-Disposition: attachment;filename=excel_price.xls");
Header("Content-Transfer-Encoding: binary");
?>


<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        td {
            mso-number-format: \@;
        }

        .number0 {
            mso-number-format: 0;
        }

        .number2 {
            mso-number-format: Fixed;
        }
    </style>
</head>
<body>
<table border="1">


    <tr>
        <?php
        foreach ($calcExport['columns'] as $column) { ?>
            <td><?= $column ?></td>
            <?php
        } ?>
    </tr>
    <?php
    foreach ($calcExport['rows'] as $row) { ?>
        <tr>
            <?php
            foreach ($row as $cell) { ?>
                <td><?= $cell ?></td>
            <?php
            } ?>
        </tr>
        <?php
    } ?>

</table>
</body>
</html>

