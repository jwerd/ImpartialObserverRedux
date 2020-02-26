<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use App\Contracts\Steps;

class Reattribute extends BaseConversation implements Steps
{
    protected $question = 'Step 2 - Re-attribute';

    /**
     * @return mixed
     */
    public function askQuestion()
    {
        $question = $this->stepQuestion('Step 2: Re-attribute - “In Re-attribute you learn to place the blame squarely on your brain. This is my brain sending me a false message.” This step is designed to assign the re-labelled addictive urge to its proper source.

Say the following:

My {{addictive_thought}} is the following:
- Rooted in my childhood
- Deeply ingrained in my brain
- Has nothing to do with me
- Out of my control
- What I control is how I respond.

I\'m compassionate and curious about my addictions origins.  I know this thought or urge will come back and I will repeat these steps again.  Most importantly: I won\'t get frustrated.
');

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'next') {
                    $this->bot->startConversation(new Refocus());
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
