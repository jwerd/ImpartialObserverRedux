<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use App\Contracts\Steps;

class Refocus extends BaseConversation implements Steps
{
    protected $question = 'Step 3 - Re-focus';

    /**
     * @return mixed
     */
    public function askQuestion()
    {
        $question = $this->stepQuestion('Step 3: Re-focus - In the Re-focus step you buy yourself time. Although the compulsion to open the bag of cookies or turn on the TV or drive to the store or the casino is powerful, its shelf life is not permanent. Being a mind-phantom, it will pass, and you have to give it time to pass. The key principle here, as Dr. Schwartz points out, is this: "It’s not how you feel that counts; it’s what you do."

Instead of my {{addictive_thought}} I can...
- Go for a walk
- Do something creative
- Learn something interesting
- Stay aware of what I\'m doing and why I\'m doing it.

Whatever buys you the next 15 minutes to allow the re-focus to happen.');

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if($answer->getValue() === 'reset') {
                    $this->bot->startConversation(new StartConversation());
                }
                if ($answer->getValue() === 'next') {
                    $this->bot->startConversation(new Revalue());
                }
            }
        });
    }

    public function askExtended()
    {
    }

    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->askQuestion();
    }
}
