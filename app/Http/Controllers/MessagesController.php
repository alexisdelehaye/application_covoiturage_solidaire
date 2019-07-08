<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('messages.create')
            ->with([
                'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id,
                'subject' => $request->subject
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'sender_id' => 'required',
            'receiver_id' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ]);

        // Create message
        $message = new \App\Message();
        $message->sender_id = auth()->user()->id;
        $message->receiver_id = $request->receiver_id;
        $message->subject = $request->subject;
        $message->body = $request->body;
        $message->read = false;
        $message->save();

        return redirect('/dashboard/messages')->with('success', 'Message envoyé !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = \App\Message::find($id);

        // Check for correct user
        if (auth()->user()->id != $message->receiver_id)
            return redirect('/dashboard/messages')->with('error', 'Erreur : accès non autorisé !');

        /*
        if ($route->cover_image != 'null.png') {
            // Delete image
            Storage::delete('public/cover_images/'.$route->cover_image);
        }
        */

        $message->delete();

        return redirect('/dashboard/messages')->with('success', 'Message supprimé !');
    }
}
