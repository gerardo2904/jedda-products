<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
	public function update()
	{
		$cart = auth()->user()->cart;
		$cart->status = 'Pending';
		$cart->save();  //UPDATE
		
		$notification = "Tu pedido de ha registrado correctamente. Te notificaremos pronto via email.";
		return back()->with(compact('notification'));
	}
}
