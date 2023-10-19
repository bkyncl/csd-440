<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script>
        function getPDF(filename) {
            window.open(filename);
        }
    </script>
    <button onclick="getPDF('PDF_program.php');" target="_blank"> Click Me To Open Example PDF</button>
    <br>
    <br>
    <button onclick="getPDF('db_table.php');" target="_blank"> Click Me To Open Db Table PDF</button>
</body>
</html>