<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use App\Contracts\Steps;

class Relabel extends BaseConversation implements Steps
{
    /**
     * @return mixed
     */
    public function askQuestion()
    {
        $question = $this->stepQuestion('Step 1: Re-label - In Step 1 you label your {{addictive_thought}} for what it is, not mistaking it for reality. I may feel, for example, that I must leave off whatever I’m doing right now and partake in my {{addictive_thought}}. The feeling takes on the quality of a need, of an imperative that must immediately be satisfied.

 When we re-label, we give up the language of need. I say to myself: "I don’t need this {{addictive_thought}} now; I’m only having an obsessive thought that I have such a need. It’s not a real, objective need but a false belief. I may have a feeling of urgency, but there is actually nothing urgent going on."');

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if($answer->getValue() === 'reset') {
                    $this->bot->startConversation(new StartConversation());
                }
                if ($answer->getValue() === 'next') {
                    $this->bot->startConversation(new Reattribute());
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
