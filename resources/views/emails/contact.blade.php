<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Нове запитання з сайту</title>
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
        <h1>Нове запитання з сайту</h1>
        <p>ТМ Хімекселен — Вулики з ППУ</p>
    </div>
    
    <div class="content">
        <div class="field-group">
            <div class="label">Ім'я відправника</div>
            <div class="value">{{ $contactData['name'] }}</div>
        </div>

        <div class="field-group">
            <div class="label">Номер телефону</div>
            <div class="value">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactData['phone']) }}" style="color: #b86f17; text-decoration: none; font-weight: 600;">
                    {{ $contactData['phone'] }}
                </a>
            </div>
        </div>

        @if(!empty($contactData['email']))
            <div class="field-group">
                <div class="label">Електронна пошта</div>
                <div class="value">
                    <a href="mailto:{{ $contactData['email'] }}" style="color: #b86f17; text-decoration: none;">
                        {{ $contactData['email'] }}
                    </a>
                </div>
            </div>
        @endif

        <div class="field-group">
            <div class="label">Текст запитання</div>
            <div class="value message-box">
                {!! nl2br(e($contactData['question'])) !!}
            </div>
        </div>

        <div class="field-group" style="margin-top: 30px; border-bottom: none; padding-bottom: 0;">
            <div style="font-size: 11px; color: #766748; text-align: right;">
                IP-адреса відправника: {{ $contactData['ip'] ?? 'N/A' }} | Час: {{ date('d.m.Y H:i:s') }}
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} <a href="http://himexelen.test">Хімекселен</a>. Всі права захищені.</p>
    </div>
</div>

</body>
</html>
