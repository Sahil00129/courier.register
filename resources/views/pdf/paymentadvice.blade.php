<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <style>
        table {
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
        }

        .styled th {
            background: #025b78;
            color: #e6e6e6;
            padding: 4px;
        }

        .styled td {
            padding: 6px;
            line-height: 24px;
        }
    </style>
</head>

<body style="font-family:Arial Helvetica,sans-serif;">
    <table style="width: 100%; margin-bottom: 1.3rem">
        <tr>
            <?php
             $live_host_name = request()->getHttpHost();
            $src_logo = "https://".$live_host_name."/assets/img/f15.png";
            ?>
            <td valign="middle">
                <img src="{{$src_logo}}" style="max-height: 50px" />
                <p>
                   <strong> Frontier Agrotech Private Limited</strong><br />
                    7A, Madhya Marg, Sector 7C<br />
                    Chandigarh 160019
                </p>
            </td>
            <td valign="middle">
                <h3 style="text-align: right; font-size: 1.5rem; line-height: 1.5rem; margin-bottom: 4px;">TER Payment
                    Advice</h3>
                <p style="border: 1px solid #838383; border-radius: 12px; padding:  0.5rem 1rem; margin: 0 0 0 auto; width: fit-content;">
                    Employee Code: <strong> {{$terdata[0]->employee_id}}</strong><br />
                    Employee Name: <strong>{{$terdata[0]->sender_name}}</strong><br />
                    Employee Bank A/c No: <strong>{{$sender_details[0]->account_number}}</strong><br/>
                    IFSC Code: <strong>{{$sender_details[0]->ifsc}}</strong>

                </p>
            </td>
        </tr>
    </table>



    <table class="styled" style="width: 100%; margin-bottom: 1.3rem; background: beige">
        <tr>
            <th valign="middle">Bank Ref No.</th>
            <th valign="middle">Payment Date</th>
            <th valign="middle">Currency</th>
            <th valign="middle">Payment Amount</th>
        </tr>
        <tr>
            <td style="text-align: center" valign="middle">{{$terdata[0]->utr}}</td>
            <td style="text-align: center" valign="middle">{{$terdata[0]->paid_date}}</td>
            <td style="text-align: center" valign="middle">INR</td>
            <td style="text-align: center" valign="middle">{{$terdata[0]->final_payable}}</td>
        </tr>
    </table>

    <table class="styled" style="width: 100%; margin-bottom: 1.3rem; background: beige">

        @if(!empty($advance_money))
        <tr>
            <th valign="middle">Currency</th>
            <th valign="middle">Advance Amount Used</th>
        </tr>
        <tr>
            <td style="text-align: center" valign="middle">INR</td>
            <td style="text-align: center" valign="middle">{{$advance_money}}</td>
        </tr>
        @endif
        <!-- advance_money -->
    </table>

    <br /><br />

    <p>Dear {{$terdata[0]->sender_name}},
        <br /><br />
        We have remitted payment to your bank account against TER.
    </p>

    <table class="styled" style="width: 100%; margin-bottom: 1.3rem; background: beige">
        <tr>
            <th valign="middle" style="text-align: center">S No.</th>
            <th valign="middle" style="text-align: left">TER UNID</th>
            <th valign="middle" style="text-align: left">TER Period</th>
            <th valign="middle" style="text-align: left">TER Claimed</th>
            <th valign="middle" style="text-align: left">TER Passed</th>
            <th valign="middle" style="text-align: left">Deduction</th>
        </tr>
        <tr>
            <td style="text-align: center" valign="middle">1</td>
            <td style="text-align: left" valign="middle">{{$terdata[0]->id}}</td>
            <td style="text-align: left" valign="middle">{{ Helper::ShowFormatDate($terdata[0]->terfrom_date) }} - {{ Helper::ShowFormatDate($terdata[0]->terto_date) }}</td>
            <td style="text-align: left" valign="middle">{{$terdata[0]->amount}}</td>
            <td style="text-align: left" valign="middle">{{$payable_sum}}</td>
            <td style="text-align: left" valign="middle">{{(int)$terdata[0]->amount - (int)$payable_sum}}</td>
        </tr>

    </table>

    <br />
    @if(!empty($dedution_selected))
    <table style="width: 100%; margin: 1.3rem 0">
        <tr>
            <td>
                Deduction Remarks if any
                <ul>
                    @foreach ($dedution_selected as $key => $option_selected)
                    @if($option_selected == 1)
                    <li>Late fine INR 200 deducted – TER received after 15 days</li>
                    @endif
                    @if($option_selected == 2)
                    <li>Fuel limit exceeded</li>
                    @endif
                    @if($option_selected == 3)
                    <li>Telephone/Mobile limit exceeded</li>
                    @endif
                    @if($option_selected == 4)
                    <li>Maintenance limit exceeded</li>
                    @endif
                    @if($option_selected == 5)
                    <li>Lodging & Boarding deduction</li>
                    @endif
                    @if($option_selected == 6)
                    <li>Public Transportation/food limit exceeded</li>
                    @endif
                    @if($option_selected == 7)
                    <li>Courier/Internet/Stationary limit exceeded</li>
                    @endif

                    @endforeach
                </ul>
            </td>
        </tr>
    </table>
    @endif
</body>

</html>
