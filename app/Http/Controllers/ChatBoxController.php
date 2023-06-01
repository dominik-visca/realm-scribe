<?php

namespace App\Http\Controllers;

class ChatBoxController extends Controller
{
    public function index()
    {
        return view('chatbox.index');
    }
}