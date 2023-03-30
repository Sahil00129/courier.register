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
                </p><br/>
                Data complied at <?php 
                    date_default_timezone_set('Asia/Kolkata');
                    echo date("d-m-Y h:m a") ?>
            </td>
        </tr>
    </table>

    <br /><br />


    <table style="width: 100%; border: 1px solid; border-collapse: collapse;">
        <tr>
            <th class="innerCell" style="background: #002930; color: #fff;">Status</th>
            <th class="innerCell" style="background: #002930; color: #fff;">TAT</th>
            <!-- <th class="innerCell" style="background: #002930; color: #fff;">SD1 Count</th>
            <th class="innerCell" style="background: #002930; color: #fff;">MA2 Count</th>
            <th class="innerCell" style="background: #002930; color: #fff;">SD3 Count</th>
            <th class="innerCell" style="background: #002930; color: #fff;">MA4 Count</th> -->
            <th class="innerCell" style="background: #002930; color: #fff;">Total Count</th>
            <th class="innerCell" style="background: #002930; color: #fff;">UNID's List</th>
        </tr>

        <tr>
            <td class="innerCell" valign="top" style="width: 15%; text-align: center;" rowspan="4">Handover</td>
            <td class="innerCell" valign="top" style="width: 15%; text-align: center;">0-3 Days</td>
            <!-- <td class="innerCell" valign="top" style="width: 8%; text-align: center;">{{$terMailData['SD1_h1_count']}}</td>
            <td class="innerCell" valign="top" style="width: 8%; text-align: center;">{{$terMailData['MA2_h1_count']}}</td>
            <td class="innerCell" valign="top" style="width: 8%; text-align: center;">{{$terMailData['SD3_h1_count']}}</td>
            <td class="innerCell" valign="top" style="width: 8%; text-align: center;">{{$terMailData['MA4_h1_count']}}</td> -->
            <td class="innerCell" valign="top" style="width: 8%; text-align: center;">{{$terMailData['total_h1_count']}}</td>
            <td class="innerCell" valign="top" style="width: 30%; text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['handover_ids_1']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style="text-align: center;">4-7 Days</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_h2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_h2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_h2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_h2_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_h2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['handover_ids_2']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style="text-align: center;">7-30 Days</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_h3_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_h3_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_h3_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_h3_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_h3_count']}}</td>
            <td class="innerCell" valign="top" style="text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['handover_ids_3']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style=" text-align: center;">>30 Days</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_h4_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_h4_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_h4_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_h4_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_h4_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['handover_ids_4']}}</p>
            </td>
        </tr>






        <tr>
            <td class="innerCell" valign="top" style=" text-align: center;" rowspan="3">Sent to Finfect</td>
            <td class="innerCell" valign="top" style="text-align: center;">24 Hrs</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_f1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_f1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_f1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_f1_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_f1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['finfect_ids_1']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style=" text-align: center;">48 Hrs</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_f2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_f2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_f2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_f2_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_f2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['finfect_ids_2']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style="text-align: center;">>48 Hrs</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_f3_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_f3_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_f3_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_f3_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_f3_count']}}</td>
            <td class="innerCell" valign="top" style="text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['finfect_ids_3']}}</p>
            </td>
        </tr>

        <tr>
            <td class="innerCell" valign="top" style=" text-align: center;" rowspan="3">Rejected</td>
            <td class="innerCell" valign="top" style=" text-align: center;">24 Hrs</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_r1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_r1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_r1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_r1_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_r1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['rejected_ids_1']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style="text-align: center;">48 Hrs</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_r2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_r2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_r2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_r2_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_r2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['rejected_ids_2']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style=" text-align: center;">>48 Hrs</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_r3_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_r3_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_r3_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_r3_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_r3_count']}}</td>
            <td class="innerCell" valign="top" style="text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['rejected_ids_3']}}</p>
            </td>
        </tr>




        <tr>
            <td class="innerCell" valign="top" style=" text-align: center;" rowspan="2">Pay Later</td>
            <td class="innerCell" valign="top" style="text-align: center;">0-7 Days</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_pl1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_pl1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_pl1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_pl1_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_pl1_count']}}</td>
            <td class="innerCell" valign="top" style="text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['pay_later_ids_1']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style=" text-align: center;">7 Days +</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_pl2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_pl2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_pl2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_pl2_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_pl2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['pay_later_ids_2']}}</p>
            </td>
        </tr>


        <tr>
            <td class="innerCell" valign="top" style=" text-align: center;" rowspan="2">Full & Final</td>
            <td class="innerCell" valign="top" style="text-align: center;">0-15 Days</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_fl1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_fl1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_fl1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_fl1_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_fl1_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['full_n_final_ids_1']}}</p>
            </td>
        </tr>
        <tr>
            <td class="innerCell" valign="top" style=" text-align: center;">15 Days +</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD1_fl2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA2_fl2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['SD3_fl2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['MA4_fl2_count']}}</td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">{{$terMailData['total_fl2_count']}}</td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['full_n_final_ids_2']}}</p>
            </td>
        </tr>




        <tr>
            <td class="innerCell" valign="top" style=" text-align: center;">Unknown</td>
            <td class="innerCell" valign="top" style=" text-align: center;">24 Hrs</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">
                {{$terMailData['SD1_u1_count']}}
            </td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                {{$terMailData['MA2_u1_count']}}
            </td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                {{$terMailData['SD3_u1_count']}}
            </td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                {{$terMailData['MA4_u1_count']}}
            </td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">
                {{$terMailData['total_u1_count']}}
            </td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['unknown_ids_1']}}</p>
            </td>
        </tr>

        <tr>
            <td></td>
            <td class="innerCell" valign="top" style=" text-align: center;">>24 Hrs</td>
            <!-- <td class="innerCell" valign="top" style=" text-align: center;">
                {{$terMailData['SD1_u2_count']}}
            </td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                {{$terMailData['MA2_u2_count']}}
            </td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                {{$terMailData['SD3_u2_count']}}
            </td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                {{$terMailData['MA4_u2_count']}}
            </td> -->
            <td class="innerCell" valign="top" style=" text-align: center;">
                {{$terMailData['total_u2_count']}}
            </td>
            <td class="innerCell" valign="top" style=" text-align: center;">
                <p style="width: 100%; word-wrap: break-word;">{{$terMailData['unknown_ids_2']}}</p>
            </td>
        </tr>



      

    </table>

    <br /><br /><br/>

    <table style="width: 100%; margin: 1.3rem 0;">
        <tr>
            <td>
                <ul>
                    <li>
                        Preset TAT (Turn Around Time): On receiving a TER at reception, UNID is generated from DP portal and a Status is given to that UNID. Status has their TAT and action needs to be done within TAT.
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
                </p>
            </td>
        </tr>
    </table>


</body>

</html>