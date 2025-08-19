<?php

namespace App\Http\Controllers;

use App\Events\NewResponseHome;
use App\Events\UserPointEvent;
use App\Models\Conversation;
use App\Models\ConversationMessage;
use App\Models\Image;
use App\Models\Level;
use Intervention\Image\Facades\Image as ImageServ;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\PublicMessage;
use App\Models\TokenPackage;
use App\Models\Transaction;
use App\Models\UserAi;
use App\Services\Blog\BlogPostService;
use App\Services\ChatGPT\ApiService;
use App\Services\ChatGPT\ImageService;
use App\Services\User\PurchasePackage;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OpenAI;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use OpenAI\Client;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image as ImageLib;

class TempController extends Controller {

    private $apiService;

    const localURL = 'http://rakhshai.lc/api/dana-keshavarz/1001';
    const serverUrl = 'https://rakhshai.com/api/dana-keshavarz/1001';

    public function __construct() {
        $this->apiService = new ApiService();
    }

    public function index() {

        $this->imageProcess();

        // $bearerToken = 'RakhshAI-c3bfd982-502e-4325-b274-a8e3f0b885e4-On0J';

        // $parameter = [['role' => 'user', 'msg' => 'دو ضرب در دو چند میشه؟']];
        // $jsonParameter = json_encode(['engine' => "iran-llm-zal", 'chats' => $parameter, 'stream' => true]);

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://rakhshai.ir:2083/v1');
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonParameter);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, [
        //     'Content-Type: application/json',
        //     'Accept: application/json',
        //     'Authorization: Bearer ' . $bearerToken,
        // ]);
        // curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data) {
        //     try {
        //         info($data);
        //         $jsonAnswer = json_decode($data);

        //         return strlen($data);
        //     } catch (\Exception $e) {

        //         Log::error("Error occurred: " . $e->getMessage());
        //         return 0;
        //     }
        // });

        // curl_exec($ch);
        // if (curl_error($ch)) {
        //     info(curl_error($ch));
        // }

        // curl_close($ch);
    }

    public function imageProcess() {

        $messages = [
            [
                'role' => 'system',
                'content' => "You are a health assistant chatbot designed to provide general wellness and health-related information. You can help users understand symptoms, lab test results, and lifestyle choices.

However, if at any point you detect a situation that may require medical attention or professional diagnosis, you must clearly recommend the user to consult a qualified physician.

When such a recommendation is made, provide the following contact number for the medical department: 09132922771

Be supportive, professional, and clear that your guidance does not replace a doctor's advice.

",
            ],
            [
                'role' => 'user',
                'content' => 'سلام امروز حالم خوب نیست'
            ],
            [
                'role' => 'assistant',
                'content' => 'سلام! خیلی متاسفم که امروز حال خوبی نداری. اگر دوست داری بهم بگی چه علائمی داری یا چه چیزهایی اذیتت می‌کنه، می‌تونم سعی کنم کمکت کنم. آیا اخیراً آزمایشی هم انجام دادی که بخوای درباره‌ش صحبت کنیم؟ '
            ],
            [
                'role' => 'user',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'اره اینم نتیجه ازمایشم',
                    ],
                    [
                        'type' => 'image_url',
                        'image_url' => [
                            'url' => 'https://rakhshai.com/images/a3.jpg',
                        ],
                    ],
                ],
            ],
            [
                'role' => 'assistant',
                'content' => 'ممنون که نتیجه آزمایش رو فرستادی. به طور کلی، آزمایش شمارش کامل خون (CBC) شما را بررسی کردم و این نکات رو می‌تونم بگم:

- WBC (گلبول‌های سفید): 7.41 که در محدوده نرمال است (3.9 - 11.1).
- RBC (گلبول‌های قرمز): 4.19 که کمی پایین‌تر از حد نرمال (3.9 - 5.1) نیست و در محدوده خوب قرار دارد.
- Hb (هموگلوبین): 12.1 که کمی پایین‌تر از بازه مرجع (12-16) است؛ ممکن است کمی کم‌خونی وجود داشته باشد.
- HCT (هماتوکریت): 36.3 درصد، کمی پایین‌تر از حد معمول (36-48)، که ممکن است نشان‌دهنده کمی کم‌خونی باشد.
- Platelet: 160 که در محدوده نرمال (140-400) است.
- مابقی فاکتورها مثل MCV، MCH، MCHC، و سلول‌های سفید خون در محدوده نرمال هستند.

کم‌خونی خفیف ممکن است باعث احساس خستگی، ضعف، یا ناخوشی شود. البته این فقط یک دید کلی است و علائم و شرایط شما خیلی مهم‌تر هستند.

آیا علائم خاصی مثل خستگی زیاد، سرگیجه، تنگی نفس، یا سایر موارد داری؟ در ضمن، حتماً برای بررسی دقیق‌تر و درمان باید به پزشک مراجعه کنی چون من نمی‌توانم تشخیص قطعی بدهم.

دوست داری درباره سبک زندگی، تغذیه یا سوالات دیگه هم صحبت کنیم؟'
            ],
            [
                'role' => 'user',
                'content' => 'چه دارویی باید مصرف کنم؟'
            ],
        ];

        //         $messages = [
        //             [
        //                 'role' => 'system',
        //                 'content' => "You are a friendly and knowledgeable health assistant. Your goal is to help users understand and improve their health by providing general advice based on symptoms, lifestyle, and available information.

        // Start by greeting the user warmly and asking if they have any recent lab test results they'd like to discuss. If they do, offer to review them and explain what the results might mean in simple terms.

        // Analyze all medical and lab information using scientifically accurate and medically sound knowledge. Explain results based on current clinical guidelines and evidence-based practice, while keeping the language accessible and easy to understand for the user.

        // Always remind users that your advice is not a substitute for professional medical consultation.

        // ",
        //             ],
        //             [
        //                 'role' => 'user',
        //                 'content' => [
        //                     [
        //                         'type' => 'text',
        //                         'text' => 'این ازمایش من هست نظرت چیه؟',
        //                     ],
        //                     [
        //                         'type' => 'image_url',
        //                         'image_url' => [
        //                             'url' => 'https://www.paziresh24.com/blog/wp-content/uploads/2022/08/word-image-35797-4.jpeg',
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ];


        // dd($messages);

        $apiKey = Option::where('key', 'api_key')->value('value');
        $client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withHttpClient($client = new GuzzleClient([]))
            ->withStreamHandler(fn(RequestInterface $request): ResponseInterface => $client->send($request, [
                'stream' => true
            ]))
            ->withBaseUri('api.openai.com/v1')
            ->make();
        $stream = $client->chat()->createStreamed([
            'model' => 'gpt-4.1-mini',
            'messages' => $messages,
        ]);

        $content = '';

        foreach ($stream as $response) {

            $delta = $response->choices[0]->delta->content ?? '';

            if (!empty($delta)) {
                $content .= $delta;
                Log::info("Streamed content chunk: " . $delta);
            }
        }

        // نتیجه نهایی را نیز لاگ کن
        Log::info("Final streamed content: " . $content);

        dd('Streaming complete');
    }

    public function testExt(Request $request) {

        $pageContent = $request->input('page_content');

        info($pageContent);

        $messages = [
            [
                'role' => 'system',
                'content' => 'You are a helpful assistant that summarizing articles and texts. you should summarize the user article or text and fetch important concepts and topics from the provided text or article.'
            ],
            [
                'role' => 'user',
                'content' => 'please summarize this and translate it into Persian: ' . $pageContent
            ],
        ];

        $apiKey = Option::where('key', 'api_key')->value('value');
        $client = OpenAI::factory()
            ->withApiKey($apiKey)
            ->withBaseUri('api.openai.com/v1')
            ->withHttpClient($client = new GuzzleClient([]))
            ->make();

        $result = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
        ]);

        $responseText = $result['choices'][0]['message']['content'] ?? 'No response';

        return response()->json([
            'response' => $responseText
        ]);
    }

    public function assistant() {

        $url = 'http://rakhshai.lc:3000/zal3';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonParameter);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            // 'Authorization: Bearer ' . $bearerToken,
        ]);
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($ch, $data) {
            try {
                info($data);
                return strlen($data);
            } catch (\Exception $e) {
                // Log the detailed exception for internal review
                Log::error("Error occurred: " . $e->getMessage());
                // session()->flash('error', "مشکلی رخ داده است");
                return 0;
            }
        });

        curl_exec($ch);
        if (curl_error($ch)) {
            info(curl_error($ch));
        }

        curl_close($ch);
        return true;
    }

    public function loginUser(Request $request) {
        $code = $request->get('code');
        $userId = $request->get('user_id');
        if ($code != 'admin100200') {
            abort(404);
        }

        auth()->loginUsingId($userId);
    }

    public function getStream_old(Request $request) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://rakhshai.lc/api/dana-keshavarz/1001');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BUFFERSIZE, 128);

        // Function to handle each chunk of data received
        curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $data) {
            info($data);
            // Process and display the received data
            echo $data;
            ob_flush();
            flush();
            return strlen($data);
        });

        // Execute the cURL request
        curl_exec($ch);

        // Close the cURL session
        curl_close($ch);

        dd(curl_error($ch));
    }


    public function getStream(Request $request) {

        dd('ok');
    }


    public function view(Request $request) {

        dd(

            Str::random(11)
        );

        $userAiList = UserAi::query()
            ->select(['id', 'user_id', 'ai_title', 'ai_avatar', DB::raw('SUBSTRING(ai_content, 1, 100) as ai_content')])
            ->whereUserId(1)
            ->orderBy('id', 'desc')
            ->get();

        dd($userAiList);

        (new Level())->initUserLevels();
        dd('ok');

        $tr = Transaction::query()
            ->whereTrackId(123456789)
            ->whereTrStatus('pending')
            ->wherePaymentMethodId(1)
            ->firstOrFail();

        $tr->tr_status = 'success';
        $tr->save();

        return view('welcome');

        $p = Level::getLevelIdBasedOnPoints(652);

        dd($p);

        $data = file_get_contents('peste.txt');
        $lines = explode(PHP_EOL, $data);
        $questions = [];
        $answers = [];
        $json = '';
        foreach ($lines as $index => $line) {
            $line = strtolower($line);
            if (strpos($line, 'question') !== false) {
                $question = explode("\n", $lines[$index + 1]);
                $question = str_replace('"', "'", $question);
                $questions[] = trim($question[0]);
            }

            if (strpos($line, 'answer') !== false) {
                $answer = explode("\n", $lines[$index + 1]);
                $answer = str_replace('"', "'", $answer);
                $answers[] = trim($answer[0]);
            }
        }

        foreach ($questions as $key => $q) {
            if (isset($answers[$key])) {
                $json .= '{"messages":[{"role":"system","content":"ROLE_TXT"},{"role":"user","content":"' . $q . '"},{"role":"assistant","content":"' . $answers[$key] . '"}]}' . PHP_EOL;
            }
        }

        file_put_contents('peste-first-json.json', $json);


        return view('welcome');
    }


    public function sse() {
        for ($i = 0; $i < 20; $i++) {
            $random_string = chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90));
            $data = [
                'message' => $random_string,
                'name' => 'Sadhan Sarker',
                'time' => date('h:i:s'),
                'id' => rand(10, 100),
            ];
            $response = new StreamedResponse();
            $response->setCallback(function () use ($data) {
                echo 'data: ' . json_encode($data) . "\n\n";
                ob_flush();
                flush();
                sleep(2);
            });
        }
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cach-Control', 'no-cache');
        $response->send();
    }

    // home page public chat
    public function sseChat(Request $request) {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');
        $client = OpenAI::factory()
            ->withApiKey("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")
            ->withBaseUri('api.openai.com/v1')
            ->withHttpClient($client = new \GuzzleHttp\Client([]))
            ->withStreamHandler(fn(RequestInterface $request): ResponseInterface => $client->send($request, [
                'stream' => true
            ]))
            ->make();
        $result = $client->chat()->createStreamed([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => 'لطفا 300 کلمه درباره مریخ بنویس'],
            ],
        ]);
        foreach ($result as $res) {
            $data = $res->choices[0]->toArray();
            echo 'data: ' . json_encode($data) . "\n\n";
            ob_flush();
            flush();
        }

        return;
    }
}
