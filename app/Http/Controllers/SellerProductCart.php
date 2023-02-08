<?php

namespace App\Http\Controllers;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\SellerProduct;
use Illuminate\Http\Request;

class SellerProductCart extends Controller
{

    //add product to cart
    public function add_product_to_cart($id,Request $request){

        $sellerProduct = SellerProduct::find($id);

        if (empty($sellerProduct)) {
            return $this->sendError('Seller Product not found');
        }else{
            $request->validate(
                [
                    'quantity'=>'required|integer'
                ]
                );

            Cart::session(auth()->user()->id)->add(array(
                'id' => $sellerProduct->id,
                'name' => $sellerProduct->name,
                'price' => $sellerProduct->price,
                'quantity' => $request->quantity,
               'associatedModel' => $sellerProduct
             ));

             $items = Cart::getContent();


             $response = [
                 'success'=>true,
                 'data'=>$items,
                 'message'=> 'Product added successfuly to the cart'
              ];
             return response()->json($response,200);


        }



    }

    //update cart
    public function increase_cart_quantity($id,Request $request){
        $sellerProduct = SellerProduct::find($id);

        if (empty($sellerProduct)) {

            return $this->sendError('Seller Product not found');

        }else{

            $request->validate(
                [
                    'quantity'=>'required|integer'
                ]
                );
            Cart::session(auth()->user()->id)->update($sellerProduct->id, array('quantity' => $request->quantity,));
            $content = $items = \Cart::getContent();

              $response = [
                'success'=>true,
                'data'=> $content,
                'message'=> 'Product quantity successfully increased'
             ];
            return response()->json($response,200);

        }



    }

     //update cart
     public function reduce_cart_quantity($id,Request $request){
        $sellerProduct = SellerProduct::find($id);

        if (empty($sellerProduct)) {
            return $this->sendError('Seller Product not found');

        }else{

            $request->validate(['quantity'=>'required|integer']);
            Cart::session(auth()->user()->id)->update($sellerProduct->id, array(
                'quantity' => -($request->quantity),
              ));
              $content = $items = \Cart::getContent();
              $response = [
                'success'=>true,
                'data'=>$content,
                'message'=> 'Product quantity successfully reduced'
             ];
            return response()->json($response,200);
        }



    }

    //delet product from cart
    public function delete_cart($id,Request $request){

        $sellerProduct = SellerProduct::find($id);
        if (empty($sellerProduct)) {
            return $this->sendError('Seller Product not found');

        }else{

            Cart::session(auth()->user()->id)->remove($sellerProduct->id);
            $content = $items = \Cart::getContent();
              $response = [
                'success'=>true,
                'data'=>$content,
                'message'=> 'Product successfully deleted from the cart'
             ];
            return response()->json($response,200);
        }



    }


    //user cart items
    public function user_seller_cart_products(){

         if(Cart::session(auth()->user()->id)->isEmpty()){
            $response = [
                'success'=>false,
                'message'=> 'Product successfully deleted from the cart'
             ];
            return response()->json($response,200);

         }
         Cart::session($userId)->getContent($itemId);
    }


    //clear cart
    public function clear_cart(){
        Cart::session($userId)->clear();
    }

    // $validated = $request->validated();
    // $product = Product::findOrFail($validated['product_id']);

    // $rowId = $product->id;
    // $userID = $validated['user_id'];
    // $currentCart = \Cart::session($userID);

    // $currentCart->add(array(
    //     'id' => $rowId,
    //     'name' => $product->name,
    //     'price' => $product->price->amount(),
    //     'quantity' => $product->minStock($validated['quantity']),
    //     'associatedModel' => $product,
    //     'attributes' => array(
    //         'first_image' => $product->firstImage,
    //         'formatted_price' => $product->formattedPrice,
    //         'product_stock' => $product->stockCount()
    //     )
    // ));

    // $currentCartContents = $currentCart->get($rowId);
    // $quantity = $product->minStock($currentCartContents->quantity);

    // if($currentCartContents->quantity !== $quantity) {
    //     $currentCart->update($rowId, [
    //         'quantity' => [
    //          'relative' => false,
    //          'value' => $quantity,
    //         ]
    //     ]);
    // }

    // return redirect()->back();
}
