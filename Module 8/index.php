<!-- Create our HTML file with bootstrap -->
<!DOCTYPE html>

<html lang='en'>

    <head>

        <meta charset='UTF-8'>

        <meta name='viewport' content='width=device-width, initial-scale=1.0'>

        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM' crossorigin='anonymous'>

        <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js' integrity='sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r' crossorigin='anonymous'></script>

        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js' integrity='sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS' crossorigin='anonymous'></script>

        <title>AndrewDatabaseFun</title>

    </head>

    <body>

        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js' integrity='sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz' crossorigin='anonymous'></script>

        <!-- Create a div to display our buttons in a neat way -->
        <div class="container text-center mt-5">

            <!-- Create a form to hold the buttons -->
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

                <!-- Create 4 buttons for altering the MySQL database -->
                <button type="submit" name="dropTableBtn" class="btn btn-danger mb-3">Drop Table</button>

                <br>

                <button type="submit" name="createTableBtn" class="btn btn-primary mb-3">Create Table</button>

                <br>

                <button type="submit" name="populateTableBtn" class="btn btn-warning mb-3">Populate Table</button>

                <br>

                <button type="submit" name="queryTableBtn" class="btn btn-success mb-3">Query Table</button>

            </form>

            <!-- Create a div to display the results neatly -->
            <div class="text-center">

            <?php

                // Include all 4 of the php files
                include 'AndrewDropTable.php';
                include 'AndrewCreateTable.php';
                include 'AndrewPopulateTable.php';
                include 'AndrewQueryTable.php';

            ?>

            </div>

        </div>

    </body>

</html>