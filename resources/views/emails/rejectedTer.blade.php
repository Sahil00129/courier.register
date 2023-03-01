<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        th, td{
            border: 1px solid;
        }
        </style>
</head>

<body>
    <?php     //dd($employee_id) ?>

    <p>
        Dear <?php echo $employee_name ?>,<br />
        Employee Code: <?php echo  $employee_id ?><br />
        <br />
        <?php echo  $body ?> <strong><?php echo  $body_two ?></strong><br />
    </p><br />
    
    <table class="styled" style="width: 100%; margin-bottom: 1.3rem; background: beige; border: 1px solid #838383; border-collapse: collapse">
        <tr>
            <th valign="middle" style="text-align: center">TER Claim Period</th>
            <th valign="middle" style="text-align: left">Last Day to receive claim</th>
            <th valign="middle" style="text-align: left">TER claim received date</th>
            <th valign="middle" style="text-align: left">TER Claim Amount</th>
            <th valign="middle" style="text-align: left">No. of Exceeded from 45 days policy</th>
            <th valign="middle" style="text-align: left">Comment</th>
        </tr>
        <tr>
            <td style="text-align: center" valign="middle">{{ Helper::ShowFormatDate($terdata->terfrom_date) }} - {{ Helper::ShowFormatDate($terdata->terto_date) }}</td>
            <td style="text-align: left" valign="middle">{{$last_ter_date}}</td>
            <td style="text-align: left" valign="middle">{{ Helper::ShowFormatDate($terdata->received_date) }}</td>
            <td style="text-align: left" valign="middle">{{$terdata->amount}}</td>
            <td style="text-align: left" valign="middle">{{$date_diff}}</td>
            <td style="text-align: left" valign="middle">Rejection due to claim received after 45 days</td>
        </tr>

    </table>

    <p>In future, please ensure to timely submit your claims to avoid any fine /rejection of your TER claim.</p>
    <br /><br />

    <p>
        Thanks & Regards <br />
        Frontiers TER Team

    </p>

</body>

</html>