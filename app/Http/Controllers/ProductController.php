<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\UserAddresses;
use Storage;
use Response;

class ProductController extends Controller
{
    //
    public function showProduct(Request $request){
        $products = Product::leftJoin("product_type_list","products.product_type_detail","=","product_type_list.id")->select("products.id","products.product_name","products.length","products.available","products.price","products.description","products.product_url")->get();
        return view("products.show",["products"=>$products]);
    }
    public function buyProductPage(Request $request,$product_id){
        $product = Product::where("id","=",$product_id)->first();
        $paymentMethod= auth()->user()->defaultPaymentMethod();
        
        $user_address = UserAddresses::where("user_id","=",auth()->user()->id)->get();
        if(count($user_address)>0){
            auth()->user()->updateStripeCustomer(
                [
                "address"=>[
                    "city"=>$user_address[0]["city"] ?? " ",
                    "line1"=>$user_address[0]["line1"] ?? " ",
                    "line2"=>$user_address[0]["line2"] ?? " ",
                    "country"=>$user_address[0]["country"]  ?? " ",
                    "postal_code"=>$user_address[0]["postal_code"] ?? " ",
                    "state"=>$user_address[0]["state"] ?? " ",
                ],
                "name"=>auth()->user()->name,
                ]
            );
        }
        $customer = auth()->user()->createOrGetStripeCustomer();
        // print_r($customer);
        // exit;
        $intent = auth()->user()->createSetupIntent([
            "customer"=>$customer,
            "payment_method"=>$paymentMethod->id,
            "usage"=>"off_session",
            "description"=>"Buying a product",
            // "currency"=>"INR"
        ]);
        // $stripe = new \Stripe\StripeClient(
        //     env('STRIPE_SECRET')
        //   );
        // $stripe->paymentIntents->create([
        //     'amount' => $product->price,
        //     'currency' => 'INR',
        //     'automatic_payment_methods' => [
        //       'enabled' => true,
        //     ],
        //     // "payment_method_types"=>["card"],
        //     'setup_future_usage'=>"on_session",
        //     // "confirm"=>true,
        //     // "return_url"=>"http://localhost/stripepayment/public/product-purchase-page/1"
        //   ]);
        // print_r($product);
        // exit;
        return view("products.buynow",["product"=>$product,"intent"=>$intent]);
    }
    public function buyProduct(Request $request){
        $user          = $request->user();
        $paymentMethod = $request->input('payment_method');
        $price = $request->price;
        // return $user->hasDefaultPaymentMethod()?$user->defaultPaymentMethod():"";
        // exit;
        try {
            $user->createOrGetStripeCustomer();
            if($user->hasDefaultPaymentMethod()==false){
                $user->addPaymentMethod($paymentMethod);
            }
            else{
                $user->updateDefaultPaymentMethod($paymentMethod);
            }
            $user->charge($price * 100, $paymentMethod,['off_session'=>true,"description"=>"Buying a product"]);        
        } catch (\Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()->route("products")->with('message', 'Product purchased successfully!');
    }
    protected function getImage($filename)
{
   //check image exist or not
   $exists = Storage::disk('public')->exists('products/'.$filename);
   
   if($exists) {
      
      //get content of image
      $content = Storage::get('public/products/'.$filename);
      
      //get mime type of image
      $mime = Storage::mimeType('public/products/'.$filename);
      //prepare response with image content and response code
      $response = Response::make($content, 200);
      //set header 
      $response->header("Content-Type", $mime);
      // return response
      return $response;
   } else {
      abort(404);
   }
    }
}
