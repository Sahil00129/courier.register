<!DOCTYPE html>
<html>

<head>
    <style>
        .heading {
            font-size: 1.3rem;
        }

        table {
            font-size: 0.9rem;
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 500px;
            border-radius: 12px;
        }

        th {
            min-width: 120px;
            font-weight: 500;
            background: #003e58;
            color: #fff;
        }

        td {
            font-size: 0.8rem;
            /* width: 120px; */
        }

        td,
        th {
            border: 1px solid #4e4eff;
            text-align: left;
            padding: 8px;
        }
    </style>
</head>

<body>

    <h1 class="heading">{{ $terMailData['title'] }} </h1>

    <table>
        <tbody>
            <tr>
                <th>Received</th>
                <td>{{$terMailData['received']}}</td>
            </tr>
            <tr>
                <th>Handover</th>
                <td>{{$terMailData['handover']}}</td>
            </tr>
            <tr>
                <th>Finfect</th>
                <td>{{$terMailData['finfect']}}</td>
            </tr>
            <tr>
                <th>Unknown</th>
                <td>{{$terMailData['unknown']}}</td>
            </tr>
            <tr>
                <th>Rejected</th>
                <td>{{$terMailData['rejected']}}</td>
            </tr>

            <tr>
                <th>Failed</th>
                <td>{{$terMailData['failed']}}</td>
            </tr>
            <tr>
                <th>Pay Later</th>
                <td>{{$terMailData['paylater']}}</td>
            </tr>

            <tr>
                <th>Full & Final </th>
                <td>{{$terMailData['full_n_final']}}</td>
            </tr>


        </tbody>
    </table>

</body>

</html>