<?php

namespace App\Http\Controllers;

use App\Events\SendMessage;
use App\Models\Collection;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Exception;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{

    public function LoginPage()
    {
        return view('login');
    }
    public function RegisterPage()
    {
        return view('register');
    }
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'phonenumber' => ['digits:10', 'regex:/(05|06|07)[0-9]{8}/', 'unique:users,phonenumber'],
            'password' => 'required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'passwordConfirm' => 'required|same:password',
        ]);
        $user = new User();
        $user->email = $request->email;
        $user->phonenumber = $request->phonenumber;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.login')->with('message', 'Account created succesfully.');
    }
    public function check(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $cred = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($cred, 1)) {
            return redirect()->route('user.homepage');
        } else {
            return redirect()->back()->with('error', "Incorrect credentials.");
        }
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('user.login');
    }
    public function homepage()
    {
        $convos = Conversation::where('participant_one', Auth::user()->id)->orWhere('participant_two', Auth::user()->id)->get();
        return view('homepage', ['convos' => $convos->sortByDesc('latestMessageDate')]);
    }
    public function convopage(Conversation $convo)
    {
        if (in_array(Auth::user()->id, [$convo->participant_one, $convo->participant_two])) {
            return view('convo', ['convo' => $convo]);
        }
        return 'not allowed';
    }
    public function sendmessage(Request $request)
    {   
        $convo=Conversation::find($request->convo);
        if (in_array(Auth::user()->id, [$convo->participant_one, $convo->participant_two])) {
            try {
                Message::create([
                    'senderID' => Auth::user()->id,
                    'message' => $request->message,
                    'convo' => $request->convo
                ]);
                event(new SendMessage($request->convo, $request->message, Auth::user()->email));
            } catch (Exception $e) {
                dd($e);
            }
        } else {
            return 'not allowed';
        }
    }
}
