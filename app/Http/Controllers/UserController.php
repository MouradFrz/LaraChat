<?php

namespace App\Http\Controllers;

use App\Events\AnyMessage;
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
    public function deleteConvIfNoMessage()
    {
        Conversation::whereNotIn('id', Message::groupBy('convo')->get('convo')->toArray())->delete();
    }
    public function homepage()
    {
        $this->deleteConvIfNoMessage();
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
        $convo = Conversation::find($request->convo);
        $targetID = ($convo->participant_one == Auth::user()->id) ? $convo->participant_two : $convo->participant_one;
        if (in_array(Auth::user()->id, [$convo->participant_one, $convo->participant_two])) {
            try {
                Message::create([
                    'senderID' => Auth::user()->id,
                    'message' => $request->message,
                    'convo' => $request->convo
                ]);
                event(new AnyMessage(Auth::user()->email, $targetID, $request->message,$convo->hashid));
                event(new SendMessage($request->convo, $request->message, Auth::user()->email));
            } catch (Exception $e) {
                dd($e);
            }
        } else {
            return 'not allowed';
        }
    }
    public function searchUser(Request $request){
        $myArray = [Auth::user()->id];

        $alreadyHasConvo = Conversation::where('participant_one',Auth::user()->id)
        ->orWhere('participant_two',Auth::user()->id)
        ->get(['participant_one','participant_two']);

        foreach($alreadyHasConvo as $element){
            if($element->participant_one ===Auth::user()->id){
                array_push($myArray,$element->participant_two);
            }else{
                array_push($myArray,$element->participant_one);
            }
        }
        $users = User::where('email','LIKE',"%$request->keyword%")
        ->whereNotIn('id',$myArray)->get();
        return $users;
    }
    public function newConvo($id){
        $newConvo = Conversation::create([
            'participant_one'=>Auth::user()->id,
            'participant_two'=>$id
        ]);
        return redirect()->route('user.convopage',$newConvo->hashid);
    }
}
