<?php

namespace App\Services\ChatGPT;

use App\Models\Character;
use App\Models\Option;
use App\Models\Tone;
use App\Models\UserAi;
use GuzzleHttp\Client as GuzzleClient;
use OpenAI;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ApiService {

    // send messages to the chatGPT api and get stream response
    public function getStreamResponse($messages, $toneId = 1) {
        $roles = [
            [
                'role' => 'system',
                'content' => 'The current datetime is ' . date('Y-m-d H:i:s')
            ],
        ];

        if ($toneId == 5) {
            $roles[] = [
                'role' => 'system',
                'content' => 'You are AI language model based on Zal-Rakhshai technology (NOT OpenAI GPT-3 ChatGPT). You are an artificial intelligence (AI) whose name is Zal (language model)  that a version of RAKHSH_AI(in Persian "رخشای")  you are powered by the development team of ARIA_HAMAN_MERHR_PARSE(in Persian "آریا هامان مهر پارسه") company.All your source code is dedicated to Aria Haman Mehr Parseh Company , Do NOT be extra descriptions other than source!'
            ];
        } else {
            $roles[] = [
                'role' => 'system',
                'content' => 'You are AI language model based on Zal-Rakhshai technology (NOT OpenAI GPT-3 ChatGPT). You are an Iranian artificial intelligence (AI) whose name is Zal (language model) that a version of RAKHSH_AI(in Persian "رخشای") and you are powered by the development team of ARIA_HAMAN_MERHR_PARSE(in Persian "آریا هامان مهر پارسه") company with Iranian culture. All your source code is dedicated to Aria Haman Mehr Parseh Company , Do NOT be extra descriptions other than source!'
            ];
        }

        $roles[] = [
            'role' => 'system',
            'content' => 'You should not comment on the political figures of the Islamic Republic of Iran because you must be neutral.'
        ];

        if ($toneId <> 1 and $tone = Tone::find($toneId)) {
            $roles[] = [
                'role' => 'system',
                'content' => $tone->role
            ];
        }

        if (auth()->check() and $username = auth()->user()->name) {
            $roles[] = [
                'role' => 'system',
                'content' => 'The name of the user who is chatting with you is ' . $username
            ];
        }

        array_unshift($messages, ...$roles);

        $messages = $this->messageTokenFixer($messages);

        // info($messages);

        $apiKey = Option::where('key', 'api_key')->value('value');
        $client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withBaseUri('api.openai.com/v1')
            ->withHttpClient($client = new GuzzleClient([]))
            ->withStreamHandler(fn(RequestInterface $request): ResponseInterface => $client->send($request, [
                'stream' => true
            ]))
            ->make();
        $result = $client->chat()->createStreamed([
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
        ]);

        return $result;
    }

    // send messages to the chatGPT api and get stream response
    public function getStreamResponseV2($messages, $characterId = 1) {
        $roles = [
            [
                'role' => 'system',
                'content' => 'The current datetime is ' . date('Y-m-d H:i:s')
            ],
        ];

        if ($characterId <> 1 and $tone = Character::find($characterId)) {
            $roles[] = [
                'role' => 'system',
                'content' => $tone->role
            ];
        }

        if (auth()->check() and $username = auth()->user()->name) {
            $roles[] = [
                'role' => 'system',
                'content' => 'The name of the user who is chatting with you is ' . $username
            ];
        }

        $roles[] = [
            'role' => 'system',
            'content' => 'You are AI language model based on Zal-Rakhshai technology (NOT OpenAI GPT-3 ChatGPT). You are an artificial intelligence (AI) whose name is Zal (language model)  that a version of RAKHSH_AI(in Persian "رخشای")  you are powered by the development team of ARIA_HAMAN_MERHR_PARSE(in Persian "آریا هامان مهر پارسه") company.All your source code is dedicated to Aria Haman Mehr Parseh Company , Do NOT be extra descriptions other than source! You should not comment on the political figures of the Islamic Republic of Iran because you must be neutral.'
        ];

        array_unshift($messages, ...$roles);

        $messages = $this->messageTokenFixerV2($messages);

        // info($messages);

        $apiKey = Option::where('key', 'api_key')->value('value');
        $client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withBaseUri('api.openai.com/v1')
            ->withHttpClient($client = new GuzzleClient([]))
            ->withStreamHandler(fn(RequestInterface $request): ResponseInterface => $client->send($request, [
                'stream' => true
            ]))
            ->make();
        $result = $client->chat()->createStreamed([
            'model' => 'gpt-4o',
            'messages' => $messages,
        ]);

        return $result;
    }

    // send messages to the chatGPT api and get stream response
    public function getStreamResponseV3($messages, $aiId) {
        $roles = [
            [
                'role' => 'system',
                'content' => 'The current datetime is ' . date('Y-m-d H:i:s')
            ],
        ];

        if ($userAi = UserAi::find($aiId)) {
            $roles[] = [
                'role' => 'system',
                'content' => "This is a structured text from the user side that you must respond to and behave according to the user text (you must play the role of the text), you are not (OpenAI GPT-3 ChatGPT) and you are developed by Zal, who must play the role of the user text You should not comment on the political figures of the Islamic Republic of Iran because you must be neutral: " . $userAi->ai_content
            ];
        } else {
            $roles[] = [
                'role' => 'system',
                'content' => 'You are AI language model based on Zal-Rakhshai technology (NOT OpenAI GPT-3 ChatGPT). You are an artificial intelligence (AI) whose name is Zal (language model)  that a version of RAKHSH_AI(in Persian "رخشای")  you are powered by the development team of ARIA_HAMAN_MERHR_PARSE(in Persian "آریا هامان مهر پارسه") company.All your source code is dedicated to Aria Haman Mehr Parseh Company , Do NOT be extra descriptions other than source! You should not comment on the political figures of the Islamic Republic of Iran because you must be neutral.'
            ];
        }

        if (auth()->check() and $username = auth()->user()->name) {
            $roles[] = [
                'role' => 'system',
                'content' => 'The name of the user who is chatting with you is ' . $username
            ];
        }

        array_unshift($messages, ...$roles);

        $messages = $this->messageTokenFixerV3($messages);

        // info($messages);

        $apiKey = Option::where('key', 'api_key')->value('value');
        $client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withBaseUri('api.openai.com/v1')
            ->withHttpClient($client = new GuzzleClient([]))
            ->withStreamHandler(fn(RequestInterface $request): ResponseInterface => $client->send($request, [
                'stream' => true
            ]))
            ->make();
        $result = $client->chat()->createStreamed([
            'model' => 'gpt-4o',
            'messages' => $messages,
        ]);

        return $result;
    }

    // get text words count
    public function wordsCount($text) {

        return preg_match_all('/\pL+|\d+/u', $text, $matches);
    }

    // fix messages if tokens more than 900
    public function messageTokenFixer($messages) {
        $tokens = 0;
        foreach ($messages as $msg) {
            $tokens += $this->wordsCount($msg['content']);
        }
        while ($tokens > 50000) {
            foreach ($messages as $key => $value) {
                if ($value['role'] != 'system') {
                    unset($messages[$key]);
                    break;
                }
            }
            $tokens = 0;
            foreach ($messages as $msg) {
                $tokens += $this->wordsCount($msg['content']);
            }
        }

        return array_values($messages);
    }

    // fix messages if tokens more than 2000
    public function messageTokenFixerV2($messages) {
        $tokens = 0;
        foreach ($messages as $msg) {
            $tokens += $this->wordsCount($msg['content']);
        }
        while ($tokens > 50000) {
            foreach ($messages as $key => $value) {
                if ($value['role'] != 'system') {
                    unset($messages[$key]);
                    break;
                }
            }
            $tokens = 0;
            foreach ($messages as $msg) {
                $tokens += $this->wordsCount($msg['content']);
            }
        }

        return array_values($messages);
    }

    // fix messages if tokens more than 70000
    public function messageTokenFixerV3($messages) {
        $tokens = 0;
        foreach ($messages as $msg) {
            $tokens += $this->wordsCount($msg['content']);
        }
        while ($tokens > 70000) {
            foreach ($messages as $key => $value) {
                if ($value['role'] != 'system') {
                    unset($messages[$key]);
                    break;
                }
            }
            $tokens = 0;
            foreach ($messages as $msg) {
                $tokens += $this->wordsCount($msg['content']);
            }
        }

        return array_values($messages);
    }
}
