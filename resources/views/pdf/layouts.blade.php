<!DOCTYPE html>
<html lang="en">

<head>




    <style>
        .tc {
            text-align: center;
            padding: 0;
        }

        html {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }


        tr.borderless td {
            border: 0;
        }

        tr.bgrow {
            background-color: #dddddd;
        }

        .p {
            font-size: 12px;
        }
    </style>
    <!-- icons -->
</head>
@include('pdf.css')

<body>

    <div id="wrapper">

        @yield('content')

    </div>





    <!-- App js -->

</body>

</html>