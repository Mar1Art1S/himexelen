<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нове замовлення</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #fbf8ef;
            color: #2f2718;
            margin: 0;
            padding: 20px;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e2d4ad;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        }
        .header {
            background-color: #b86f17;
            padding: 24px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .header p {
            margin: 8px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .field-group {
            margin-bottom: 20px;
            border-bottom: 1px dashed #e3d7b6;
            padding-bottom: 15px;
        }
        .field-group:last-child {
            margin-bottom: 0;
            border-bottom: none;
            padding-bottom: 0;
        }
        .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #766748;
            margin-bottom: 5px;
            font-weight: 600;
        }
        .value {
            font-size: 16px;
            color: #2f2718;
            font-weight: 500;
            line-height: 1.5;
        }
        .message-box {
            background-color: #fffdf8;
            border: 1px solid #e3d7b6;
            border-radius: 8px;
            padding: 15px;
            font-style: italic;
            color: #5d5035;
        }
        .footer {
            background-color: #2f2718;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #d8caa6;
        }
        .footer a {
            color: #b86f17;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Нове замовлення з сайту</h1>
        <p>ТМ Хімекселен — Вулики з ППУ</p>
    </div>
    
    <div class="content">
        <div class="field-group">
            <div class="label">Ім'я клієнта</div>
            <div class="value">{{ $orderData['name'] }}</div>
        </div>

        <div class="field-group">
            <div class="label">Номер телефону</div>
            <div class="value">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $orderData['phone']) }}" style="color: #b86f17; text-decoration: none; font-weight: 600;">
                    {{ $orderData['phone'] }}
                </a>
            </div>
        </div>

        @if(!empty($orderData['email']))
            <div class="field-group">
                <div class="label">Електронна пошта</div>
                <div class="value">
                    <a href="mailto:{{ $orderData['email'] }}" style="color: #b86f17; text-decoration: none;">
                        {{ $orderData['email'] }}
                    </a>
                </div>
            </div>
        @endif

        @if(!empty($orderData['items']))
            <div class="field-group">
                <div class="label" style="margin-bottom: 10px;">Склад замовлення (список товарів)</div>
                <table style="width: 100%; border-collapse: collapse; border: 1px solid #e3d7b6;">
                    <thead>
                        <tr style="background-color: #f3ead3;">
                            <th style="padding: 10px; border: 1px solid #e3d7b6; font-size: 12px; color: #766748; text-transform: uppercase; letter-spacing: 0.5px; text-align: left;">Товар / Комплектація</th>
                            <th style="padding: 10px; border: 1px solid #e3d7b6; font-size: 12px; color: #766748; text-transform: uppercase; letter-spacing: 0.5px; width: 90px; text-align: center;">Кількість</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderData['items'] as $item)
                            <tr>
                                <td style="padding: 10px; border: 1px solid #e3d7b6; font-size: 14px; color: #2f2718; font-weight: 500;">{{ $item['name'] }}</td>
                                <td style="padding: 10px; border: 1px solid #e3d7b6; font-size: 14px; color: #2f2718; font-weight: bold; text-align: center; background-color: #fffdf8;">{{ $item['quantity'] }} шт.</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @if(!empty($orderData['product']))
                <div class="field-group">
                    <div class="label">Обраний товар / Послуга</div>
                    <div class="value" style="background-color: #f3ead3; color: #b86f17; display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 14px; font-weight: 600;">
                        {{ $orderData['product'] }}
                    </div>
                </div>
            @endif

            @if(!empty($orderData['quantity']))
                <div class="field-group">
                    <div class="label">Кількість комплектів / деталей</div>
                    <div class="value" style="font-size: 16px; color: #2f2718; font-weight: bold;">
                        {{ $orderData['quantity'] }} шт.
                    </div>
                </div>
            @endif
        @endif

        @if(!empty($orderData['subtotal']))
            <div class="field-group" style="background-color: #fffdf8; border: 1px solid #e3d7b6; border-radius: 8px; padding: 15px; margin-top: 15px;">
                <div class="label" style="margin-bottom: 8px;">Фінансовий підсумок</div>
                <table style="width: 100%; font-size: 14px; color: #2f2718;">
                    @if(!empty($orderData['discountRate']) && $orderData['discountRate'] > 0)
                        <tr>
                            <td style="padding: 3px 0; text-align: left;">Сума:</td>
                            <td style="padding: 3px 0; text-align: right; font-weight: 600;">{{ number_format($orderData['subtotal'], 0, ',', ' ') }} грн</td>
                        </tr>
                        <tr>
                            <td style="padding: 3px 0; text-align: left; color: #15803d;">Знижка ({{ $orderData['discountRate'] }}%):</td>
                            <td style="padding: 3px 0; text-align: right; font-weight: 600; color: #15803d;">-{{ number_format($orderData['discountAmount'], 0, ',', ' ') }} грн</td>
                        </tr>
                    @endif
                    <tr style="font-size: 16px; font-weight: bold; border-top: 1px solid #e3d7b6;">
                        <td style="padding: 8px 0 0 0; text-align: left;">Всього до сплати:</td>
                        <td style="padding: 8px 0 0 0; text-align: right; color: #b86f17;">{{ number_format($orderData['total'], 0, ',', ' ') }} грн</td>
                    </tr>
                </table>
            </div>
        @endif

        @if(!empty($orderData['message']))
            <div class="field-group">
                <div class="label">Коментар до замовлення</div>
                <div class="value message-box">
                    {!! nl2br(e($orderData['message'])) !!}
                </div>
            </div>
        @endif

        <div class="field-group" style="margin-top: 30px; border-bottom: none; padding-bottom: 0;">
            <div style="font-size: 11px; color: #766748; text-align: right;">
                IP-адреса відправника: {{ $orderData['ip'] ?? 'N/A' }} | Час: {{ date('d.m.Y H:i:s') }}
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} <a href="http://himexelen.test">Хімекселен</a>. Всі права захищені.</p>
    </div>
</div>

</body>
</html>
