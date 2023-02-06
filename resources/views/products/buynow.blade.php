@extends("layouts.app")

@section("content")
<style>
    .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }
    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
        border-color: #fa755a;
    }
    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>

<div class="container-fluid">
    <div class="offset-1 col-4">
        @if(session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
        @endif
    </div>
    <div class="offset-1 col-4">
        <img src="{{ route('productImage',basename($product->product_url)) }}" height="200px" width="200px">
        <br>
        <span>{{ $product->product_name }}</span><br>
        <span>${{ $product->price }}</span>
    </div>
    <div class="offset-1 col-8">
        <form method="POST" action="{{ route('products.purchase', $product->id) }}" class="card-form mt-3 mb-3">
            @csrf
            <input type="hidden" name="payment_method" class="payment-method">
            <input type="hidden" name="price" value="{{ $product->price }}">
            <input class="StripeElement mb-3 mx-3 col-6" name="card_holder_name" placeholder="Card holder name" required>
            <div class="col-lg-9 col-md-9">
                <div id="card-element"></div>
            </div>
            <div id="card-errors" role="alert"></div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary pay">
                    Purchase
                </button>
            </div>
        </form>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
    let stripe = Stripe("{{ env('STRIPE_KEY') }}")
    let elements = stripe.elements()
    let style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    }
    let card = elements.create('card', {style: style})
    card.mount('#card-element')
    let paymentMethod = null
    $('.card-form').on('submit', function (e) {
        $('button.pay').attr('disabled', true)
        if (paymentMethod) {
            return true
        }
        stripe.confirmCardSetup(
            "{{ $intent->client_secret }}",
            {
                payment_method: {
                    card: card,
                    billing_details: {name: $('.card_holder_name').val()}
                }
            }
        ).then(function (result) {
            if (result.error) {
                $('#card-errors').text(result.error.message)
                $('button.pay').removeAttr('disabled')
            } else {
                paymentMethod = result.setupIntent.payment_method
                $('.payment-method').val(paymentMethod)
                $('.card-form').submit()
            }
        })
        return false
    })
</script>
@endsection