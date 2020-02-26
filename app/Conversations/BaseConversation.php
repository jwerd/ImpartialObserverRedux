<?php

namespace App\Conversations;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

abstract class BaseConversation extends Conversation
{
    public function stepQuestion($text, $button = "Continue")
    {
        $addictive_thought = "urge or thought to ".ucwords($this->bot->userStorage()->get('addictive_thought'));

        //$addictive_thought = !stristr($addictive_thought, 'Addiction') ? $addictive_thought. ' Addiction' : $addictive_thought;

        $question = Question::create(str_ireplace("{{addictive_thought}}", $addictive_thought, $text))
            ->fallback('Unable to proceed')
            ->callbackId('step')
            ->addButtons([
                Button::create($button)->value('next'),
                Button::create('Start Over')->value('reset'),
            ]);
        return $question;
    }

    public function stepFinalQuestion($text)
    {
        $addictive_thought = "urge or thought to ".ucwords($this->bot->userStorage()->get('addictive_thought'));

        //$addictive_thought = !stristr($addictive_thought, 'Addiction') ? $addictive_thought. ' Addiction' : $addictive_thought;

        $question = Question::create(str_ireplace("{{addictive_thought}}", $addictive_thought, $text))
            ->fallback('Unable to proceed')
            ->callbackId('step');
        return $question;
    }
}