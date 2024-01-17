<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .parent {
            width: 100%;
            /* Adjust the percentage as needed */
            margin: 0 auto;
            line-height: 1;
            /* Center the content */
        }

        .parent header {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            /* Adjust as needed */
        }

        .detailsTable td {

            padding: 10px;
            /* Add padding for spacing if needed */
            box-sizing: border-box;


        }

        .mainTable th {
            background-color: #e2efd9;
            border: 1px solid black;
            padding: 4px;
            /* Add padding for spacing if needed */
            box-sizing: border-box;
            text-align: center;
            overflow-wrap: break-word;
            word-wrap: break-word;

        }

        .mainTable td {
            border: 1px solid black;
            padding: 4px;
            /* Add padding for spacing if needed */
            box-sizing: border-box;
            text-align: left;
            overflow-wrap: break-word;
            word-wrap: break-word;

        }

        .recordDetails {

            width: 298;
        }

        .projAct {
            min-width: 96.22px;
            max-width: 96.22px;
        }

        .date {
            min-width: 66.22px;
            max-width: 66.22px;

        }

        .role {
            min-width: 96.22px;
            max-width: 96.22px;

        }

        .program {
            min-width: 96.22px;
            max-width: 96.22px;
        }

        .hoursClient {
            min-width: 110px;
            max-width: 110px;
        }

        .agency {
            min-width: 96.22px;
            max-width: 96.22px;
        }

        .department {
            min-width: 96.22px;
            max-width: 96.22px;
        }
    </style>
    <title>Dynamic Multi-Page PDF</title>
</head>

<body>
    <div class="parent">
        <header>



            <p><b>PROJECT REPORT</b></p>



        </header>


        <table class="detailsTable">
            <tr>
                <td class="recordDetails"><b>Project Title: </b></td>
                <td class="recordDetails"><b>Program Title: </b></td>
            </tr>



            <tr>



                <td class="recordDetails"><b>Project Leader: </b></td>
                <td class="recordDetails"><b>Program Leader: </b></td>
            </tr>
            <tr>



                <td class="recordDetails"><b>Project Start Date: </b></td>
                <td class="recordDetails"><b>Expected End Date: </b></td>
            </tr>
        </table>
        <header>



            <p><b>Project Overview</b></p>



        </header>

        <table class="detailsTable">

            <tr>
                <td class="recordDetails"><b>Project Status: </b></td>
                <td class="recordDetails"><b>Ongoing Activities: </b></td>
            </tr>
            <tr>
                <td class="recordDetails"><b>Total Activities: </b></td>
                <td class="recordDetails"><b>Upcoming Activities: </b></td>
            </tr>
            <tr>
                <td class="recordDetails"><b>Completed Activities: </b></td>
                <td class="recordDetails"><b>Overdue Activities: </b></td>
            </tr>


        </table>

        <header>



            <p><b>Project Activities Table</b></p>



        </header>
    </div>
    <script>

    </script>

</body>

</html>