<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>تست پرداخت</title>
</head>
<body>
<h2>تست درگاه سامان</h2>

<form action="{{ route('payment.pay') }}" method="POST">
    @csrf
    <button type="submit">پرداخت تستی</button>
</form>
</body>
</html>
