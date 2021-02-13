<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestMail;
use App\Mailr;
use App\User;
use Mail;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;

class MailController extends Controller
{

    // Muestra un listado de los correos en Inbox
    function getInbox()
    {
        $users = User::all();
        foreach ($users as $user) {
            $message = Mailr::all()->where('email', '=', $user->email);
            foreach ($message as $msg) {
                $messages[] = $msg;
            }
        }
        $messages = array_reverse($messages);
        return view('mail/mailbox')->with('messages', $messages);
    }

    // Muestra el listado de los correos Enviados
    function sent()
    {
        $message = Mailr::all();
        $message = $message->reverse();
        // dd($message);
        // return view('mail.sent', compact('mensajes'));
        return view('mail/sent')->with('message', $message);
    }

    // Lee el correo seleccionado en el inbox y en enviados
    function read($id)
    {
        $message = Mailr::findOrFail($id);
        return view('mail/read-mail')->with('message', $message);
    }

    public function destroy($id)
    {
        $message = Mailr::findOrFail($id);
        $message->delete();

        return redirect()->route('mailsent')->with('success', 'Deleted successfully');
    }

    // Envia el correo compuesto
    public function send(Request $request)
    {
        Mailr::create($request->all());

        $this->validate($request, [
            'subject'     =>  'required|max:255',
            'email'  =>  'required',
            'message' =>  'required',
        ]);

        $data = array(
            'subject'      =>  $request->input('subject'),
            'message'   =>   $request->input('message'),
            'attachment' => $request->file('attachment')
        );

        $email = $request->input('email');
        $emails = explode("; ", $email);

        foreach ($emails as $em) {
            Mail::to($em)->send(new TestMail($data));
        }

        return view('mail.compose');
    }

    // Envia un correo predeterminado a los usuarios registrados en la DB:
    public function sendAll()
    {

        $users = User::all();

        foreach ($users as $user) {
            Mail::send('emails', ['user' => $user], function ($message) use ($user) {
                $message->from('ceiforestudios87@gmail.com', 'Admin');
                $message->to($user->email, $user->name)->subject('Tenemos novedades para ti');
            });
        }

        return "Se ha enviado el email";
    }
}
