<?php

namespace App\Http\Controllers;

use App\Conversations\StartConversation;
use BotMan\BotMan\BotMan;
use App\User;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        \Log::info('This is working...');

        $provider = $bot->getDriver()->getName();
        if($provider !== "Web") {
            // Store our user
            User::firstOrCreate([
                'provider'    => $provider,
                'provider_id' => $bot->getUser()->getId()
            ]);
        }

        $bot->startConversation(new StartConversation());
    }
}
