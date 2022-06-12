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
        <td style="width: 100.0000%;">Hi {{ $customer->name }},<br><br>&nbsp; &nbsp; &nbsp; &nbsp;Please click the link
            below to
            confirm your booking.<br>
            &nbsp; &nbsp; &nbsp; &nbsp;{!! $appointment['has_one_service']['desc'] !!}
        </td>
    </tr>
    <tr>
        <td style="width: 100.0000%;"><br>
            <div style="text-align: center;"><a
                    href="{{ route('confirm.book', ['id' => encrypt($appointment['id']) ]) }}" style="font-size: 40px;    display: inline-block;
    font-weight: 400;
    line-height: 1.5;
    color: #212529;
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
    font-size: 1rem;
    border-radius: .25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;color: #000;
    background-color: #0dcaf0;
    border-color: #0dcaf0;">
                    <strong>Click Here</strong></a></div>
        </td>
    </tr>
    </tbody>
</table>
<br><br>
<p style="text-align: center;">Powered by <a href="https://www.facebook.com/YaraMay-CMS-1471889562872452"><strong>YARAMAY Computer Maintenance Services</strong></a></p>
