<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LoiHeng - Order Confirm</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,600&display=swap"
        rel="stylesheet">


    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
        }

        .btn-primary {
            color: #fff !important;
            background-color: #266bf9 !important;
            border-color: #266bf9 !important;
            font-size: 15px !important;
        }

        .btn {
            display: inline-block;
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            cursor: pointer;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            border-radius: 10rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .my-3,
        .mt-3 {
            margin-top: 1rem;
        }

        .my-3,
        .mb-3 {
            margin-bottom: 1rem;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2) !important;
            transition: 0.3s !important;
            width: 80% !important;
        }

        .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2) !important;
        }

        .container {
            padding: 2px 16px !important;
        }

        h2 {
            text-align: center;
        }

        .welcome {
            font-weight: 500 !important;
        }

        th,
        td {
            border: 1px solid #212529 !important;
            padding: 5px !important;
        }

        h2.ordermail-header {
            background: #266bf9;
            padding: 20px;
            margin-bottom: 15px;
            color: white;
        }

        tbody.bb {
            background: #f1f3f4;
        }

        .table.order-table tbody.bb th,
        tr td {
            border: 1px solid #dedede !important;
            padding: 10px !important;
            /* text-align: center; */
        }
    </style>
</head>

<body>

    <div class="card_">
        <div class="container_">
            <h2 class="ordermail-header">Your order is placed!</h2>
            <p class="welcome"> မင်္ဂလာပါ {{ $data->user->fullname }}</p>

            <p>Loi Heng မှာ ဝယ်ယူအားပေးခြင်းအတွက်ကျေးဇူးတင်ပါသည်။</p>

            <p>လူကြီးမင်း၏အော်ဒါ {{ $data->order_no }} ကို မကြာမီအချိန်တွင်းလက်ခံရရှိမည်ဖြစ်ပြီး လာပို့မည်ဆိုပါက
                ကြိုတင်အကြောင်းကြားပေးပါမည်။
                သင်​၏အော်ဒါအသေးစိတ်အချက်အလက်ကို အောက်တွင်စစ်ဆေးနိုင်ပါသည်။</p>
            <p>အော်ဒါတင်ပြီးပါက လူကြီးမင်းထည့်သွင်းထားသောလိပ်စာအား ပြောင်းလဲ၍မရနိုင်ပါ။</p>
            <p>Please note, we are unable to change your delivery address once your order is placed.​</p>
            <table class="order-table table-striped" style="width:50%;border-collapse: collapse;margin-top: 20px;">
                <tbody class="bb">
                    <tr>
                        <td>Order Number</td>
                        <td>{{ $data->order_no }}</td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                    <tr>
                        <td>Transaction Type</td>
                        <td>{{ $data->payment_method }}</td>
                    </tr>
                    {{-- <tr>
                        <td>Customer ID</td>
                        <td>{{ $data->user_id }}</td>
                    </tr> --}}
                    <tr>
                        <td>Customer Name</td>
                        <td>{{ $data->user->fullname }}</td>
                    </tr>
                    @if ($data->discount_price)
                        <tr>
                            <td>Discount </td>
                            <td>KS {{ number_format($data->discount_price) }}</td>
                        </tr>
                    @endif
                    @if ($data->coupon_price)
                        <tr>
                            <td>Discount </td>
                            <td>KS {{ number_format($data->coupon_price) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>Total Price </td>
                        <td>KS {{ number_format($data->total_price) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
