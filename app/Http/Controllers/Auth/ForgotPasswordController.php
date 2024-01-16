<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
class ForgotPasswordController extends Controller
{

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // Sprawdź, czy użytkownik z podanym adresem e-mail istnieje
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // Użytkownik nie istnieje, więc przekazujemy informację zwrotną do widoku
            return back()->withErrors(['email' => __('Nie znaleziono użytkownika z podanym adresem e-mail.')]);
        }

        // Użytkownik istnieje, wysyłamy link do resetowania hasła
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }

    public function debugMail() {
        Mail::raw('Test email content', function($message) {
            $message->to('patryk.gensch@gmail.com')->subject('Test Email');
        });
    }

    use SendsPasswordResetEmails;
}
