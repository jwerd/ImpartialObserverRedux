<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use App\Contracts\Steps;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class Revalue extends BaseConversation implements Steps
{
    protected $question = 'Step 4 - Re-value';

    /**
     * @return mixed
     */
    public function askQuestion()
    {
        $question = $this->stepFinalQuestion('Step 4: Re-value - This step should really be called De-value. Its purpose is to help you drive into your own thick skull just what has been the real impact of your {{addictive_thought}} in your life: disaster. You know this already, and that is why you are engaged in these four steps. It’s because of the negative impact that you’ve taken yourself by the scruff of the neck and delayed acting on the impulse while you’ve re-labelled and re-attributed it and while you have re-focused on some healthier activity. In this Re-value step you will remind yourself why you’ve gone to all this trouble. The more clearly you see how things are, the more liberated you will be..
        
Be conscious as you write out this fourth step—and do write it out, several times a day if necessary. Be specific: What has been the value of your {{addictive_thought}} in your relationship with your wife? your husband? your partner, your best friend, your children, your boss, your employees, your co-workers? What happened yesterday when you allowed the urge to rule you? What happened last week? What will happen today? Pay close attention to what you feel when you recall these events and when you foresee what’s ahead if you persist in permitting the compulsion to overpower you. Be aware. That awareness will be your guardian.
Do all this without judging yourself. You are gathering information, not conducting a criminal trial against yourself. 

You did not come into life asking to be programmed this way. It’s not personal to you—millions of others with similar experiences have developed the same mechanisms. What is personal to you is how you respond to it in the present. Keep close to your impartial observer.

What has been the value of my {{addictive_thought}}?');

        return $this->ask($question, function (Answer $answer) {
            if(!empty($answer->getText())) {

                $this->bot->userStorage()->save([
                    'revalue_text' => $answer->getText()
                ]);

                $this->bot->startConversation(new FinishConversation());
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
