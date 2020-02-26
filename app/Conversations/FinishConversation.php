<?php

namespace App\Conversations;

use App\Journal;
use App\User;
use BotMan\BotMan\Messages\Incoming\Answer;
use App\Contracts\Steps;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Validator;

class FinishConversation extends BaseConversation implements Steps
{
    /**
     * @return mixed
     */
    public function askQuestion()
    {
        $question = Question::create('I\'m Listening.  Keep going.  Press "I\'m Finished" when you are done.')
            ->fallback('Unable to proceed')
            ->callbackId('step')
            ->addButtons([
                Button::create('I\'m Finished')->value('finished'),
            ]);
        return $this->ask($question, function (Answer $answer) {

            if ($answer->isInteractiveMessageReply()) {
                if($answer->getValue() === 'finished') {

                    $provider = $this->bot->getDriver()->getName();

                    $fields = [
                        'subject' => $this->bot->userStorage()->get('addictive_thought'),
                        'body' => $this->bot->userStorage()->get('revalue_text'),
                        'user_id' => User::getUserByProvider($provider, $this->bot->getUser()->getId())
                    ];

                    $validator = Validator::make($fields, [
                        'subject' => 'required|max:255',
                        'body'    => 'required',
                        'user_id' => 'required|integer',
                    ]);

                    \Log::info('Completed', $this->bot->userStorage()->all());

                    if ($validator->fails()) {
                        $this->bot->reply('It appears the session timed out.  Can you try that again?');
                        $this->bot->startConversation(new StartConversation());
                        return true;
                    }

                    $journal = Journal::create($fields);

                    \Log::info($journal);

                    // Remove the user storage for this instance since it's persisted to DB.
                    $this->bot->userStorage()->delete();

                    $this->bot->reply('All set.  It takes courage to do what you just did.  When you are ready to start again, type /start');

                    return true;
                }
            } else {
                if($answer->getText() === '/start') {
                    $this->bot->startConversation(new StartConversation());
                } else {
                    if (!empty($answer->getText())) {
                        $text = $this->bot->userStorage()->get('revalue_text');

                        $text .= PHP_EOL . $answer->getText();

                        $this->bot->userStorage()->save([
                            'revalue_text' => $text
                        ]);

                        $this->bot->startConversation(new FinishConversation());
                    }
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
