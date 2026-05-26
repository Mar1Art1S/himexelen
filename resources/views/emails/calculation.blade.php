<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новий розрахунок вартості</title>
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
        .total-box {
            background-color: #fbf8ef;
            border: 1px solid #e2d4ad;
            border-radius: 10px;
            padding: 20px;
            margin-top: 25px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: #6d6045;
        }
        .total-row:last-child {
            margin-bottom: 0;
            padding-top: 10px;
            border-top: 1px solid #cdbb8c;
            font-size: 18px;
            color: #2f2718;
            font-weight: 800;
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
        <h1>Новий розрахунок вартості вуликів</h1>
        <p>ТМ Хімекселен — Вулики з ППУ</p>
    </div>
    
    <div class="content">
        <div class="field-group">
            <div class="label">Ім'я клієнта</div>
            <div class="value">{{ $calcData['name'] }}</div>
        </div>

        <div class="field-group">
            <div class="label">Номер телефону</div>
            <div class="value">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $calcData['phone']) }}" style="color: #b86f17; text-decoration: none; font-weight: 600;">
                    {{ $calcData['phone'] }}
                </a>
            </div>
        </div>

        @if(!empty($calcData['email']))
            <div class="field-group">
                <div class="label">Електронна пошта</div>
                <div class="value">
                    <a href="mailto:{{ $calcData['email'] }}" style="color: #b86f17; text-decoration: none;">
                        {{ $calcData['email'] }}
                    </a>
                </div>
            </div>
        @endif

        <div class="field-group">
            <div class="label" style="margin-bottom: 10px;">Склад розрахунку (калькулятор)</div>
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #e3d7b6;">
                <thead>
                    <tr style="background-color: #f3ead3;">
                        <th style="padding: 10px; border: 1px solid #e3d7b6; font-size: 12px; color: #766748; text-transform: uppercase; letter-spacing: 0.5px; text-align: left;">Товар / Комплектуюча</th>
                        <th style="padding: 10px; border: 1px solid #e3d7b6; font-size: 12px; color: #766748; text-transform: uppercase; letter-spacing: 0.5px; width: 80px; text-align: center;">Ціна</th>
                        <th style="padding: 10px; border: 1px solid #e3d7b6; font-size: 12px; color: #766748; text-transform: uppercase; letter-spacing: 0.5px; width: 60px; text-align: center;">К-ть</th>
                        <th style="padding: 10px; border: 1px solid #e3d7b6; font-size: 12px; color: #766748; text-transform: uppercase; letter-spacing: 0.5px; width: 90px; text-align: right;">Вартість</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calcData['items'] as $item)
                        <tr>
                            <td style="padding: 10px; border: 1px solid #e3d7b6; font-size: 14px; color: #2f2718; font-weight: 500;">
                                {{ $item['name'] }}
                                @if(!empty($item['description']))
                                    <div style="font-size: 11px; color: #766748; font-weight: normal; margin-top: 3px;">{{ $item['description'] }}</div>
                                @endif
                            </td>
                            <td style="padding: 10px; border: 1px solid #e3d7b6; font-size: 13px; color: #5d5035; text-align: center;">{{ number_format($item['price'], 0, ',', ' ') }} грн</td>
                            <td style="padding: 10px; border: 1px solid #e3d7b6; font-size: 13px; color: #2f2718; font-weight: bold; text-align: center; background-color: #fffdf8;">{{ $item['quantity'] }} шт</td>
                            <td style="padding: 10px; border: 1px solid #e3d7b6; font-size: 14px; color: #2f2718; font-weight: bold; text-align: right; background-color: #fffdf8;">{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} грн</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total-box">
                <div class="total-row">
                    <span>Загальна сума:</span>
                    <span>{{ number_format($calcData['subtotal'], 0, ',', ' ') }} грн</span>
                </div>
                @if($calcData['discountRate'] > 0)
                    <div class="total-row" style="color: #97580f; font-weight: 600;">
                        <span>Знижка ({{ $calcData['discountRate'] }}%):</span>
                        <span>-{{ number_format($calcData['discountAmount'], 0, ',', ' ') }} грн</span>
                    </div>
                @endif
                @if($calcData['packagingAmount'] > 0)
                    <div class="total-row">
                        <span>Пакування:</span>
                        <span>+{{ number_format($calcData['packagingAmount'], 0, ',', ' ') }} грн</span>
                    </div>
                @endif
                <div class="total-row">
                    <span>Разом до сплати:</span>
                    <span style="color: #b86f17;">{{ number_format($calcData['total'], 0, ',', ' ') }} грн</span>
                </div>
            </div>
        </div>

        <div class="field-group" style="margin-top: 30px; border-bottom: none; padding-bottom: 0;">
            <div style="font-size: 11px; color: #766748; text-align: right;">
                IP-адреса відправника: {{ $calcData['ip'] ?? 'N/A' }} | Час: {{ date('d.m.Y H:i:s') }}
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} <a href="http://himexelen.test">Хімекселен</a>. Всі права захищені.</p>
    </div>
</div>

</body>
</html>
