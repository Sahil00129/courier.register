<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .innerCell {
            padding: 8px;
            border: 1px solid #838383;
        }
    </style>
</head>

<body>
    <table style="width: 100%; margin-bottom: 1.3rem;">
        <tr>
            <td>
                <p>
                    Dear Sir,<br /><br />
                    Below is the report generated from DP Portal for the UNIDs exceeding their pre-set TAT and required immediate attention.
                </p>
            </td>
        </tr>
    </table>

    <br /><br />

    <table style="width: 100%; border: 1px solid; border-collapse: collapse;">
        <tr>
            <th class="innerCell" style="background: #002930; color: #fff;">Status</th>
            <th class="innerCell" style="background: #002930; color: #fff;">TAT</th>
            <th class="innerCell" style="background: #002930; color: #fff;">Count</th>
            <th class="innerCell" style="background: #002930; color: #fff;">List of TER ID's</th>
        </tr>

        <tr>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">Received</td>
            <td class="innerCell" valign="top" style="width: 15%; text-align: center;">24 Hrs</td>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">
                {{$terMailData['received_size']}}
            </td>
            <td class="innerCell" valign="top" style="width: 49%; text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['received']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">Handover</td>
            <td class="innerCell" valign="top" style="width: 15%; text-align: center;">7 Days</td>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">
                {{$terMailData['handover_size']}}
            </td>
            <td class="innerCell" valign="top" style="width: 49%; text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['handover']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">Finfect</td>
            <td class="innerCell" valign="top" style="width: 15%; text-align: center;">24 Hrs</td>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">
                {{$terMailData['finfect_size']}}
            </td>
            <td class="innerCell" valign="top" style="width: 49%; text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['finfect']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">Pay Later</td>
            <td class="innerCell" valign="top" style="width: 15%; text-align: center;">7 Days</td>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">
                {{$terMailData['paylater_size']}}
            </td>
            <td class="innerCell" valign="top" style="width: 49%; text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['paylater']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">Full & Final</td>
            <td class="innerCell" valign="top" style="width: 15%; text-align: center;">30 Days</td>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">
                {{$terMailData['full_n_final_size']}}
            </td>
            <td class="innerCell" valign="top" style="width: 49%; text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['full_n_final']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">Rejected</td>
            <td class="innerCell" valign="top" style="width: 15%; text-align: center;">48 Hrs</td>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">
                {{$terMailData['rejected_size']}}
            </td>
            <td class="innerCell" valign="top" style="width: 49%; text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['rejected']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">Failed</td>
            <td class="innerCell" valign="top" style="width: 15%; text-align: center;">24 Hrs</td>
            <td class="innerCell" valign="top" style="width: 18%; text-align: center;">
                {{$terMailData['failed_size']}}
            </td>
            <td class="innerCell" valign="top" style="width: 49%; text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['failed']}}</p>
            </td>
        </tr>
    </table>

    <br /><br /><br/>

    <table style="width: 100%; margin: 1.3rem 0;">
        <tr>
            <td>
                <ul>
                    <li>
                        Preset TAT (Turn Around Time): On receiving a TER at reception, UNID is generated from DP portal and a Status is given to that UNID. Now Status has their TAT and action needs to be done within TAT.
                    </li>
                </ul>
            </td>
        </tr>
    </table>

    <table style="width: 100%;">
        <tr>
            <td>
                <p>
                    Thanks<br />
                    DP Portal Auto Email<br />
                    Data complied at <?php 
                    date_default_timezone_set('Asia/Kolkata');
                    echo date("d-m-Y h:m a") ?>
                </p>
            </td>
        </tr>
    </table>


</body>

</html>