<?php

namespace App\Conversations;

use App\User;
use BotMan\BotMan\Messages\Incoming\Answer;

class StartConversation extends BaseConversation
{
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->ask("Greetings, I'm the Impartial Observer.  
        
Describe your current addictive thought/urge you are experiencing and wish to manage with the four steps.

Finish this statement: My current urge or thought to... ", function(Answer $answer) {

            $this->bot->userStorage()->save([
                'addictive_thought' => $answer->getText()
            ]);

            // Let's check if the bot is using a /start (we will just start over)
            if($answer->getText() === "/start") {
            } else {
                $this->bot->startConversation(new Relabel());
            }
        });
    }
}
