<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Laravel 5</div>

                <form action="/ecocash/inbox" method="post">
                    {!! csrf_field() !!}
                    <input typ="hidden" name="device_id" value="123" />
                    <input typ="hidden" name="from" value="+234" />
                    <input typ="hidden" name="message" value="You have received $10.00 from 772748665 -SAM TAKUNDA. Approval Code: SMACLALA. New wallet balance: $20.00" />
                    <input typ="hidden" name="message_id" value="mid1000" />
                    <input typ="hidden" name="secret" value="lepass" />
                    <input typ="hidden" name="sent_timestamp" value="2014-08-08" />
                    <input type="submit" value="SMS">
                </form>

                <form action="/ecocash" method="get">
                    {!! csrf_field() !!}
                    <input typ="hidden" name="account" value="lorem" />
                    <input typ="hidden" name="order" value="10" />
                    <input typ="hidden" name="narration" value="Tomatoes special offer" />
                    <input typ="hidden" name="amount" value="10.00" />
                    <input typ="hidden" name="redirectURL" value="http://buzz.com" />
                    <input typ="hidden" name="cancelURL" value="http://google.com" />
                    <input typ="hidden" name="signature" value="EE9BF036F7949223A32188F069B7A93DD0F8893FBBD9502ECA9B0F3FB8F67FC8080F773EF0EB59B258AE963924FAC9B7ED244C0F1E2B78C2331310B626914AA2" />
                    <input type="submit" value="Checkout">
                </form>

            </div>
        </div>
    </body>
</html>
