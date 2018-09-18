<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Stripe Api</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        #donate{
            color: #ffffff;
            min-height: 30px;
            position: relative;
            padding: 0 12px;
            height: 30px;
            line-height: 30px;
            background: #1275ff;
            background-image: -webkit-linear-gradient(#7dc5ee,#008cdd 85%,#30a2e4);
        }
        input, select, .form{
            padding: 5px;
            margin: 10px;
        }
        .form{
            padding: 30px;
            border: 1px solid #000;
            text-align: center;
        }
        .amount{
            margin-left: 0;
            margin-right: 0;
            border: none;
            width: 70px;
            text-align: center;
        }
        .amount:focus{
            outline: none;
        }
    </style>
    <script src="stripe.js"></script>
</head>
<body>
        <!-- <form action="your-server-side-code" method="POST">
                <script
                  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                  data-key="pk_test_409gPDqwew8vUVLvvN7NvEGs"
                  data-amount="999"
                  data-name="Demo Site"
                  data-description="Widget"
                  data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                  data-locale="auto">
                </script>
              </form> -->
    <div class="form">
        <div>
            <input id="name" autocomplete autocomplete autofocus placeholder="NAME" type="text">
        </div>
        <div>
            <input id="email" autocomplete placeholder="EMAIL" type="email">
        </div>
        <div>
            <select required onchange="changeCurrency(value)" name="currency" id="currency">
            <option selected value="">Select Currency</option>
            <option value="ZAR">South African Rand(ZAR)</option>
            <option value="NGN">Nigerian Naira(NGN)</option>
            <option value="USD">US Dollar(USD)</option>
            <option value="EUR">Euro(EUR)</option>
            <option value="GBP">British Pound(GBP)</option>
        </select>
    </div>
    <div>
        <span style="padding: 5px;outline: 1px solid #000">
            <span id="main"></span>
            <input value="0" class="amount" placeholder="" id="amount" type="text">
            <strong>.</strong>
            <input value="00" class="amount" id="amountSub" type="text">
        </span>
    </div>
    <button id="donate" alt="donate button">Donate</button>
</div>
<div id="response" style="margin-top: 100px;"></div>
</body>
<script
      src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script>
    function changeCurrency (value) {
        if (value === 'NGN') {
            document.getElementById('main').innerText = '#';
        } else if (value === 'ZAR') {
            document.getElementById('main').innerText = 'R';
            } else if (value === 'USD') {
                document.getElementById('main').innerText = '$';
                } else if (value === 'EUR') {
            document.getElementById('main').innerText = '€';
                } else if (value === 'GBP') {
            document.getElementById('main').innerText = '£';
            }
    }
let currency, amount
document.getElementById('donate').addEventListener('click', function(e) {
         let name = document.getElementById('name').value,
             email = document.getElementById('email').value;
             currency = document.getElementById('currency').value
             amount = document.getElementById('amount').value
             let amountSub = document.getElementById('amountSub').value;
             amount = Math.round(amount + '.' + amountSub);
  // Open Checkout with further options:
  handler.open({
    name: name,
    email: email,
    currency: currency,
    allowRememberMe: true,
    description: 'Donation',
    amount: amount
  });
  e.preventDefault();
});

var handler = StripeCheckout.configure({
  key: 'pk_test_409gPDqwew8vUVLvvN7NvEGs',
  image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
  locale: 'auto',
  token: function(token) {
      console.log(JSON.stringify(token))
      $.ajax({
          type: 'POST',
          url: 'payment.php',
          data: {
              stripeToken: token.id,
              amount: amount,
              currency: currency,
              description: 'donate'
          },
          success: (response) => {
              document.getElementById('response').innerHTML += `<p style="margin: 50px;">${response}</p>`;
          }
      })
    // You can access the token ID with `token.id`.
    // Get the token ID to your server-side code for use.
  }
});

// Close Checkout on page navigation:
window.addEventListener('popstate', function() {
  handler.close();
});
</script>

</html>