<?php


require 'vendor/autoload.php';

use \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use \PhpOffice\PhpSpreadsheet\Writer\Csv;

$files[] = [
    'cat' => 'تبدیل بنکن',
    'link' => 'https://api.ahanonline.com/product-types/export/1697/false'
];
$files[] = [
    'cat' => 'میلگرد آجدار',
    'link' => 'https://api.ahanonline.com/product-types/export/139/false'
];
$files[] = [
    'cat' => 'میلگرد ساده',
    'link' => 'https://api.ahanonline.com/product-types/export/147/false'
];
$files[] = [
    'cat' => 'پروفیل',
    'link' => 'https://api.ahanonline.com/product-types/export/20/false'
];
$files[] = [
    'cat' => 'پروفیل صنعتی',
    'link' => 'https://api.ahanonline.com/product-types/export/1580/false'
];
$files[] = [
    'cat' => 'پروفیل گالوانیزه',
    'link' => 'https://api.ahanonline.com/product-types/export/5096/false'
];
$files[] = [
    'cat' => 'پروفیل استنلس استیل صنعتی',
    'link' => 'https://api.ahanonline.com/product-types/export/6524/false'
];
$files[] = [
    'cat' => 'ناودانی',
    'link' => 'https://api.ahanonline.com/product-types/export/113/false'
];
$files[] = [
    'cat' => 'نبشی',
    'link' => 'https://api.ahanonline.com/product-types/export/253/false'
];
$files[] = [
    'cat' => 'تیرآهن',
    'link' => 'https://api.ahanonline.com/product-types/export/87/false'
];
$files[] = [
    'cat' => 'هاش',
    'link' => 'https://api.ahanonline.com/product-types/export/1264/false'
];
$files[] = [
    'cat' => 'لوله داربست',
    'link' => 'https://api.ahanonline.com/product-types/export/1249/false'
];
// print_r($files);
// exit;
$allData = [];
foreach ($files as $file) {
    // echo $file['link'];
    // echo '<br>';
    $homepage = file_get_contents($file['link']);
    file_put_contents("test.xlsx", $homepage);


    $xls_file = "test.xlsx";

    $reader = new Xlsx();
    $spreadsheet = $reader->load($xls_file);

    $loadedSheetNames = $spreadsheet->getSheetNames();

    $writer = new Csv($spreadsheet);


    foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
        $writer->setSheetIndex($sheetIndex);
        $writer->save($loadedSheetName . '.csv');
    }
    $fn = fopen($loadedSheetName . '.csv', "r");

    while (!feof($fn)) {
        $result = fgets($fn);
        $resultArray = explode(',', $result);
        if (count($resultArray) > 8) {
            $allData[] = [
                "کد" => str_replace('"',"",$resultArray[0]),
                "نام" => str_replace('"',"",$resultArray[1]),
                "نوع" => str_replace('"',"",$resultArray[2]),
                "سایز" => str_replace('"',"",$resultArray[3]),
                "حالت" => str_replace('"',"",$resultArray[4]),
                "استاندارد" => str_replace('"',"",$resultArray[5]),
                "انبار" => str_replace('"',"",$resultArray[6]),
                "واحد" => str_replace('"',"",$resultArray[7]),
                "قیمت" => str_replace('"',"",$resultArray[8]),
                "تاریخ اخرین قیمت" => str_replace('"',"",$resultArray[9]),
            ];
        }
        // print_r($resultArray);

        //   if ($result!=='"کد","نام","نوع","سایز","حالت","استاندارد","انبار","واحد","قیمت","تاریخ اخرین قیمت"'){
        //     echo $result;
        //   }

    }

    fclose($fn);
    unlink($loadedSheetName . '.csv');
    unlink($xls_file);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.3.3/css/searchBuilder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/searchbuilder/1.3.3/js/dataTables.searchBuilder.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
</head>

<body>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Qlfrtip'
            });
        });
    </script>

    <table id="example" class="display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>کد</th>
                <th>نام</th>
                <th>نوع</th>
                <th>سایز</th>
                <th>حالت</th>
                <th>استاندارد</th>
                <th>انبار</th>
                <th>واحد</th>
                <th>قیمت</th>
                <th>تاریخ اخرین قیمت</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($allData as $data) {
                echo '<tr>';
                echo '<td>' . $data['کد'] . '</td>';
                echo '<td>' . $data['نام'] . '</td>';
                echo '<td>' . $data['نوع'] . '</td>';
                echo '<td>' . $data['سایز'] . '</td>';
                echo '<td>' . $data['حالت'] . '</td>';
                echo '<td>' . $data['استاندارد'] . '</td>';
                echo '<td>' . $data['انبار'] . '</td>';
                echo '<td>' . $data['واحد'] . '</td>';
                echo '<td>' . $data['قیمت'] . '</td>';
                echo '<td>' . $data['تاریخ اخرین قیمت'] . '</td>';
                echo '</tr>';
            }
            ?>

        </tbody>
        <tfoot>
            <tr>
                <th>کد</th>
                <th>نام</th>
                <th>نوع</th>
                <th>سایز</th>
                <th>حالت</th>
                <th>استاندارد</th>
                <th>انبار</th>
                <th>واحد</th>
                <th>قیمت</th>
                <th>تاریخ اخرین قیمت</th>
            </tr>
        </tfoot>
    </table>

</body>

</html>