<div style="text-align: center;"></div>
<table style="width: 58%; margin-right: calc(20%); margin-left: calc(23%);">
    <tbody>
    <tr>
        <td style="width: 100.0000%;">
            <div style="text-align: center;"><span style="color: rgb(84, 172, 210);"><strong><span
                            style='font-family: "Arial Black", Gadget, sans-serif; font-size: 22px;'>{{ $appointment['has_one_service']['name'] }}</span></strong></span>
            </div>
        </td>
    </tr>
    <tr>
        <td style="width: 100.0000%;">Hi {{ $appointment['has_one_customer']['name'] }},<br><br>&nbsp; &nbsp; &nbsp; &nbsp;
            {{ $msg }}
        </td>
    </tr>
    </tbody>
</table>
