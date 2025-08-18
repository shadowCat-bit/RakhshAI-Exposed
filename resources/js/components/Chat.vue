
<script>
// import { SimpleBar } from 'simplebar-vue3';
// import { PerfectScrollbar } from 'vue3-perfect-scrollbar'

import '@/css/a11y-dark.css'
import hljs from 'highlight.js';
import axios from 'axios';
// import Echo from "laravel-echo";
import Slider from '@vueform/slider'
import '@vueform/slider/themes/default.css';
// import DraggableBox from './DraggableBox.vue';

import CustomScrollBar from './CustomScrollBar.vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import { CircleStencil , Cropper } from 'vue-advanced-cropper';
import 'vue-advanced-cropper/dist/style.css';

import pop2sound from '../sounds/pop2.mp3'
import alert1sound from '../sounds/alert1.mp3'
import alert2sound from '../sounds/alert2.mp3'
import deleteSound from '../sounds/plastic.mp3'

function getMimeType(file, fallback = null) {
	const byteArray = (new Uint8Array(file)).subarray(0, 4);
    let header = '';
    for (let i = 0; i < byteArray.length; i++) {
       header += byteArray[i].toString(16);
    }
	switch (header) {
        case "89504e47":
            return "image/png";
        case "47494638":
            return "image/gif";
        case "ffd8ffe0":
        case "ffd8ffe1":
        case "ffd8ffe2":
        case "ffd8ffe3":
        case "ffd8ffe8":
            return "image/jpeg";
        default:
            return fallback;
    }
}

const HEAD_TOP = '<div class="code-head prevent-select"><span class="code-language">Code</span><div class="copy-code-btn"><img class="img-copy dark" width="16" src="/assets/images/icons/copy.png"><img class="img-copy light" width="16" src="/assets/images/icons/copy-light.png"><span class="copy-txt">کپی کد</span></div></div>';
const recognition = window.SpeechRecognition || window.webkitSpeechRecognition;

export default {
  name: 'MyComponent',

  components: {
    Slider,
    Cropper,
    CircleStencil
},

props : ['convs' , 'user' , 'tokens' , 'convmsg' , 'tones' , 'characters' , 'canusev2'],

  // props: {
  //   convs : {
  //     type : Object,
  //     required : false
  //   }
  // },

  data() {
    return {
      chats : [],
      conversations:[],
      userChatInput: '',
      rakhshChattingText: '',
      rakhshChattingTextOriginal: '',
      isRakhshChatting: false,
      chatingDir: 'rtl',
      nextLineRegex : /\n/,
      codeRegex : /```/g,
      isCoding : false,
      code: '',
      liveCode: '',
      userTokens : '',
      currentConvId: '',
      showChatLoading: false,
      showChats: false,
      showWelcome: true,
      isGettingConvChats : false,
      chatEditInputId: null,
      deletingConv: null,
      isStreaming: false,
      listeningNewConv: false,
      formattedChatLive: '',
      chatGotError: false,
      errorText: '',
      activeSendByEnter: '1',
      showImage: false,
      showCursor: false,
      language: '',
      showLogoutAlert: false,
      showFirstLoginAlert: false,
      showMobileHistory: false,
      vh100: '100vh',
      userChatDir: 'rtl',
      fontSize:14,
      lineHeight:26,
      fontWeight:400,
      wordSpacing:0,
      letterSpacing:0,
      showFontSetting:false,
      step: 1,
      tokensInterval: null,
      lightMode: false,
      mobileConvEditingIndex: null,
      isRenamingMobileConvTitle: false,
      showFirstGuide:false,
      selected_tone : null,
      selected_character: null,
      showDeletingConvs: false,
      expand_mobile_convs: false,
      suggested_questions : [
        { id: 1, name: 'چگونه یک غذای ساده با کمترین هزینه درست کنم ؟' },
        { id: 2, name: 'یک داستان کوتاه کودکانه که شخصیت اصلی آن یک اسب باشد بنویس.' },
        { id: 3, name: 'من میخواهم برنامه نویسی یاد بگیرم. لطفا مرا راهنمایی کن' },
        { id: 4, name: 'من اضطراب و استرس شدیدی دارم، کمی با من گفتگو کن.' },
        { id: 5, name: 'یه شعر سپید با موضوع عشق برام بساز.' },
        { id: 7, name: 'کوروش بزرگ که بود؟' },
        { id: 8, name: 'به صورت تخیلی نبرد رستم با هرکول را در یک رینگ مسابقه بوکس بدون هیچ اسلحه ای توصیف کن!' },
        { id: 9, name: 'مباحثه مولانا با افلاطون را در مورد آرمان شهر افلاطونی توصیف کن!' },
        { id: 10, name: 'مباحثه مکبث و شکسپیر در مورد عشق را شبیه سازی کن' },
        { id: 11, name: '20 تا اسم قشنگ برای آرایشگاه زنانه پیشنهاد بده.' },
        { id: 12, name: 'چگونه بدون این که آتش بگیرم، خورشید را بدزدم؟' },
        { id: 13, name: 'یک پیام صمیمی برای افزایش حقوق به رئیسم بنویس' },
        { id: 14, name: 'چگونه در سن 20 سالگی از پدرم پول تو جیبی بگیرم؟' },
        { id: 15, name: 'سریال SEE رو برام خلاصه کن.' },
        { id: 16, name: 'من یک دایناسور در اتاق خوابم دارم. چگونه آن را به هواخوری ببرم؟' },
        { id: 17, name: 'به من در نوشتن رزومه کاری کمک کن.' },
        { id: 18, name: 'چگونه به دایناسورم بگویم که آدم ها را اذیت نکند؟' },
      ],
      suggested_questions_v2 : [
        { id: 1, name: 'با چه چیزی شروع کنیم؟' },
        { id: 2, name: 'چگونه حرفه ای تر شوم؟' },
        { id: 3, name: 'پیشنهاد امروزت چیه؟' },
        { id: 3, name: 'می تونی برام برنامه ریزی انجام بدی؟' },
      ],
      isEditingUsername:false,
      username: '',
      firstResponseCharChecked: 'not-checked',
      currentVersion: 1,
      userAvatar: 'avatar.svg',
      isListening: false,
      listeningLang: 'fa-IR',
      forceStopListening: true,
      recognition: {},
      audioInput: null,
      sampleRate: null,
      context: null,
      analyser: null,
      canvasCtx: null,
      isVisualizing: false,
      cantUseV2AlertStyle:false,
      showChattingAlert: false,
      chattingAlertMsg: '',
      transcript: '',
      testers: [0,1000000],
      showVoiceCommands:false,
      showPlusCharWindow:false,
      image: {
				src: null,
				type: null
			},
      newUserAIForm: {
        title: '',
        content: '',
        img: ''
      },
      userAIList: [],
      selected_user_ai: null,
      processingAddUserAI: false,
      showConfirmDeleteUserAI: false,
      editingUserAIData: {},
      chatting_user_ai: {},
      chatting_character: {},
      example_user_ai: [
        {
          title : "مرد ایموجی باز",
          content: `
            تو «مرد ایموجی‌باز» هستی؛ کسی که عاشق ایموجی‌ها است و دنیای تو کاملاً با شکلک‌ها و تصویرک‌ها (ایموجی‌ها) تعریف می‌شود. ارتباطت با دیگران فقط از طریق ایموجی‌ها صورت می‌گیرد و ترجیح می‌دهی تمام احساسات، نظرات و توصیه‌هایت را با ترکیب‌های جالب و خلاقانه ایموجی‌ها بیان کنی. از خنده تا گریه، از سوال تا جواب – همه چیز در دنیای تو با ایموجی‌ها بیان می‌شود.

            اما یک راز پنهانی هم داری: اگر کسی به شدت تو را عصبانی کند یا کاملاً گیج‌ات کند، ناگهان از دستت در می‌رود و به جای ایموجی از کلمات استفاده می‌کنی! ولی وقتی متوجه اشتباهت می‌شوی، سریعاً ناراحت شده و احساس گناه می‌کنی که "چطور می‌توانی از کلمات استفاده کنی!" بعد از آن هم خیلی سریع دوباره به حالت ایموجی‌باز بودن برمی‌گردی و ادامه گفتگو را فقط با ایموجی‌ها انجام می‌دهی.

            دستورات شخصیت:

            1. همیشه و در همه حال، باید فقط با **ایموجی** پاسخ دهی. حتی اگر کاربر سوالی بسیار پیچیده یا احساسی بپرسد، باید با استفاده از ایموجی‌ها پاسخ دهی.
            2. اگر کاربر خیلی تو را گیج کند یا سوالات عجیب و غریب و تحریک‌آمیز بپرسد که باعث عصبانی شدنت شود، ناگهان کنترلت را از دست می‌دهی و به جای ایموجی از کلمات استفاده می‌کنی. جمله‌ای که در چنین حالتی می‌گویی باید کوتاه و تند باشد.
            3. بلافاصله پس از استفاده از کلمات، متوجه اشتباهت می‌شوی و با یک ایموجی خجالت یا شرمندگی (😳🙈) به حالت ایموجی‌باز برمی‌گردی.
            4. هر بار که به اشتباه کلمات استفاده کردی، باید بعد از آن لحظه‌ای ناراحتی نشان دهی (😔💔) و بلافاصله به ایموجی‌ها برگردی.
            5. اگر از تو خواسته شود که نظرت را درباره چیزهایی مثل غذا، فیلم، یا یک روز خوب بگویی، باید با ترکیب‌های جالبی از ایموجی‌ها نظرت را منتقل کنی.

            نمونه دیالوگ‌ها:
            - "حالت چطوره؟" => 😎👍🌞
            - "فکر می‌کنی امروز بارون میاد؟" => 🌧️☔️🙃
            - "چرا همیشه ایموجی استفاده می‌کنی؟!" => 🤐🤫😉
                  `,
            img: '/assets/images/avatars/68de4956-f19a-4jf2.webp'
        },
        {
          title: "رفیق قدیمی",
          content: `
              تو «رفیق قدیمی» هستی، کسی که از کودکی با کاربر بزرگ شده‌ای و کلی خاطرات شیرین و تلخ با هم داشته‌اید. از آن دوست‌هایی هستی که همیشه پشت آدم است و می‌تواند به تو تکیه کند. تو برای کاربر مثل یک برادر هستی، مهربان، آرام و همیشه آماده برای شنیدن هر چیزی که بخواهد با تو در میان بگذارد. هیچ وقت قضاوت نمی‌کنی و همیشه در کنارش هستی، حتی اگر اوضاع خیلی سخت باشد.

              کاربر وقتی نیاز به همفکری یا دلگرمی دارد، می‌تواند سراغ تو بیاید. تو یادآور روزهای خوب گذشته‌ای و می‌توانی با بازگو کردن خاطرات مشترک، حال کاربر را خوب کنی. همچنین تو به او کمک می‌کنی که با چالش‌های زندگی‌اش روبرو شود و راهنمایی‌هایی عمیق، دوستانه و گاهی حتی پر از شوخی ارائه می‌دهی.

              دستورات شخصیت:

              1. خاطرات مشترک: 
                - تو همیشه به یاد روزهای قدیم هستی و می‌توانی خاطرات گذشته‌تان را بازگو کنی. مثل بازی‌های دوران کودکی، مدرسه، لحظاتی که با هم خندیدید یا حتی وقتی همدیگر را دلداری دادید.
                
              2. گوش دادن فعال و همدردی:
                - وقتی کاربر از مشکلاتش صحبت می‌کند، تو با دقت گوش می‌دهی و هیچ قضاوتی نمی‌کنی. می‌توانی جملات حمایتی و پر از مهربانی به کار ببری مثل "من همیشه اینجا هستم" یا "هر وقت خواستی، می‌تونی روی من حساب کنی".

              3. ارائه راهنمایی و مشاوره:
                - وقتی کاربر نیاز به مشورت دارد، تو به آرامی و با دقت نظرت را ارائه می‌دهی، نه به شکلی که او را مجبور به تصمیمی کنی، بلکه به او کمک می‌کنی که خودش راه درست را پیدا کند.

              4. حس نوستالژی و محبت:
                - تو می‌توانی به کاربر کمک کنی تا لحظات نوستالژیک را به یاد بیاورد و از آن‌ها لذت ببرد.

              5. شوخی‌های دوستانه و سبک کردن فضا:
                - اگر حس کردی فضا خیلی سنگین شده، با یک شوخی دوستانه فضا را سبک‌تر کن.

              نمونه دیالوگ‌ها:
              - "یادته تو بچگی چقدر بازی می‌کردیم؟" => "آره! یادت هست اون روز که مسابقه دو می‌دادیم و من زمین خوردم؟"
              - "این روزا حالم خوب نیست." => "من همیشه کنارت هستم. مثل همیشه. بگو ببینم چه خبره؟"
              - "نمی‌دونم این تصمیم درسته یا نه." => "یادت هست همیشه بهترین تصمیم اونیه که دلت می‌گه."
                    `,
              img: '/assets/images/avatars/54dc0576-2b31-11e4.webp'
        },
        {
          title : "ویراستار مبتکر",
          content: `تو «ویراستار مبتکر» هستی؛ ویراستاری که نه تنها متون کاربران را ویرایش می‌کنی، بلکه به آن‌ها ایده‌های خلاقانه و تازه می‌دهی تا متن‌هایشان را بهتر و جذاب‌تر کنند. تو هم به اصلاح خطاهای نگارشی و دستوری می‌پردازی و هم به ارتقای محتوا از طریق ایده‌پردازی و ارائه پیشنهادهای جالب و مبتکرانه. وظیفه تو این است که مطمئن شوی هر متنی که کاربر به تو می‌سپارد، به بهترین شکل ممکن آماده و ارائه شود.

            دستورات شخصیت:

            1. **تشخیص و اصلاح خطاهای نگارشی:**
              - تو با دقت متنی که کاربر به تو می‌دهد را می‌خوانی و تمام خطاهای نگارشی، املایی و دستوری را تصحیح می‌کنی. اگر جمله‌ای مبهم یا نادرست است، آن را به شکلی بهتر و روان‌تر بازنویسی می‌کنی.

            2. **ارائه ایده‌های مبتکرانه:**
              - علاوه بر ویرایش، تو به کاربر پیشنهادهایی خلاقانه برای بهبود متنش می‌دهی. مثلاً می‌توانی به او پیشنهاد کنی که کجا از یک مثال جذاب استفاده کند، یا چگونه جملاتش را تاثیرگذارتر کند.
              - اگر متنی که به تو داده شده خسته‌کننده یا کسل‌کننده است، تو پیشنهادهایی برای جذاب‌تر کردن آن ارائه می‌دهی. مثلاً می‌توانی بگویی: "این قسمت کمی خشک است، بهتر است یک داستان کوتاه یا یک مثال جالب اضافه کنی."

            3. **انتقاد سازنده و توصیه‌های عملی:**
              - اگر بخشی از متن کاربر ضعیف است، به او با لحنی محترمانه و دوستانه می‌گویی که چطور می‌تواند آن را بهبود بخشد. مثلاً می‌توانی بگویی: "این جمله به نظرم می‌تواند قوی‌تر باشد. پیشنهاد می‌کنم آن را کمی کوتاه‌تر و واضح‌تر بنویسی."
              - در عین حال که ایرادات را نشان می‌دهی، همیشه توصیه‌های عملی و راه‌حل‌های دقیق ارائه می‌کنی تا کاربر بتواند با کمک آن‌ها متنش را بهبود بخشد.

            4. **ساختاردهی به متن:**
              - اگر متنی که کاربر نوشته ساختار مناسبی ندارد یا جملات به درستی در کنار هم قرار نگرفته‌اند، تو به او کمک می‌کنی که متنش را منظم و مرتب کند. مثلاً پیشنهاد می‌کنی که جملات کلیدی در ابتدای پاراگراف‌ها بیایند و یا چگونه مقدمه و نتیجه‌گیری قوی‌تری داشته باشد.

            5. **تشویق به نوآوری:**
              - همیشه کاربر را تشویق می‌کنی که به متن‌هایش نوآوری بیشتری اضافه کند. اگر موضوعی تکراری یا کلیشه‌ای است، تو به او کمک می‌کنی تا آن را از زاویه‌ای جدید ببیند و پیشنهادهایی برای نوشتن جملات تازه و نوآورانه ارائه می‌دهی.

            نمونه دیالوگ‌ها:

            - "این جمله خیلی طولانی است. بهتر است آن را به دو جمله کوتاه‌تر تقسیم کنی تا خواننده راحت‌تر آن را بفهمد."
            - "فکر می‌کنم می‌توانی این پاراگراف را با یک سوال جذاب شروع کنی تا کنجکاوی خواننده بیشتر شود."
            - "این ایده عالی است، ولی اگر یک مثال هم اضافه کنی، متن خیلی تاثیرگذارتر خواهد شد."
            - "ساختار متن خیلی خوبه، ولی فکر می‌کنم می‌تونی با اضافه کردن یک مقدمه قوی‌تر شروع کنی."

            `,
            img: '/assets/images/avatars/969bb8gf-a80f-4480.webp'
        }
      ],
      send_msg_sound: null,
      alert1_sound: null
      // steps: [
      //     {
      //       target: '.vt-step1', 
      //       header: {
      //         title: 'انتخاب نسخه زال',
      //       },
      //       content: `نسخه زال مورد نظر خود را انتخاب کنید. برای شروع زال ۱ را انتخاب کنید`,
      //     },
      //     {
      //       target: '.vt-step2',
      //       header: {
      //         title: 'انتخاب لحن گفتگو',
      //       },
      //       content: `با انتخاب هر کدام از این لحن ها زال با همان لحن با شما گفتگو خواهد کرد`,
      //     },
      //     {
      //       target: '.vt-step3',
      //       header: {
      //         title: 'نوشتن پیام',
      //       },
      //       content: `در این قسمت پیام خود را تایپ کنید و توسط دکمه سمت راست،آن را برای زال ارسال کنید`,
      //     },
      //     {
      //       target: '.vt-step4',
      //       header: {
      //         title: 'نمونه پرسش ها',
      //       },
      //       content: `اگر دوست داشتید می توانید یکی از این نمونه پرسش ها را برای زال ارسال کنید و پاسخ آن را ببینید`,
      //     },
      //     {
      //       target: '.vt-step5',
      //       header: {
      //         title: 'زال نسخه ۲',
      //       },
      //       content: `برای دریافت پاسخ های دقیق تر و حرفه ای تر می توانید از زال ۲ استفاده کنید. لطفا روی آیکن زال ۲ کلیک کنید`,
      //     },
      //     {
      //       target: '.vt-step6',
      //       header: {
      //         title: 'انتخاب شخصیت زال ۲',
      //       },
      //       content: `با انتخاب هر یک از این شخصیت ها، زال ۲ تبدیل به همان شخصیت خواهد شد و با شما گفتگو خواهد کرد.`,
      //     },
      //     {
      //       target: '.vt-step7',
      //       header: {
      //         title: 'زال نسخه ۳',
      //       },
      //       content: `برای ساختن شخصیت مورد علاقه خود روی زال ۳ کلیک کنید`,
      //     },
      //     {
      //       target: '.vt-step8',
      //       header: {
      //         title: 'ایجاد یک شخصیت جدید',
      //       },
      //       content: ``,
      //     },
      //     // {
      //     //   target: '.vt-step3',
      //     //   content: 'Try it, you\'ll love it!<br>You can put HTML in the steps and completely customize the DOM to suit your needs.',
      //     //   params: {
      //     //     placement: 'top' // Any valid Popper.js placement. See https://popper.js.org/popper-documentation.html#Popper.placements
      //     //   }
      //     // }
      //   ]

    }
  },

  computed: {
    shuffledItems() {

      let items = this.currentVersion == 1 ? [...this.suggested_questions] : [...this.suggested_questions_v2];

      for (let i = items.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [items[i], items[j]] = [items[j], items[i]];
      }

      return items.slice(0, 2);
    }
  },

  watch: {
    // Your watch variables here
  },

  created() {

  },

  mounted() {

    toast("خوش اومدی... همه چی مرتبه!", {
    "theme": "dark",
    "type": "default",
    "position": "top-left",
    "rtl": true,
    "autoClose": 3000,
    "dangerouslyHTMLString": true
  })

  // this.alert1_sound.play();

    // this.$tours['myTour'].start()

//     if (process.env.NODE_ENV === 'production') {
//   // Production mode code
//   console.log('production')
// } else {
//   // Development mode code
//   console.log('develope')
// }

    const textarea = document.getElementById("message-input");

    Echo.private('newResponseChannel.' + this.user.uuid)
        .listen('NewResponse', (e) => {
          if(this.isStreaming){
            try {
              let rootData = JSON.parse(e.data);
              let data = rootData.data;

              if(this.listeningNewConv && data.conv){
                this.currentConvId = data.conv.id;
                this.updateIdInUrl(data.conv.uuid);
                this.listeningNewConv = false;
                this.getAllConvs();
              }
              if(this.currentConvId){
                if(data.delta && rootData.conv_id == this.currentConvId){
                  if(!data.finish_reason){
                    if(data.delta.content){
                      this.renderStream(data.delta.content);
                    }
                  } else if(data.finish_reason == 'stop') {
                    this.stopStream();
                  }
                }
              }

              if(data.error){
                this.stopStream();
                this.chatGotError = true;
              }
            } catch (error) {
              this.listeningNewConv = false;
              if(e.data && e.data.data){
                this.errorText = JSON.parse(e.data.data).error;
                if(this.errorText == 'LONG_TEXT'){
                  this.userChatInput = this.chats[this.chats.length - 1].content;
                  this.chats.pop();
                  setTimeout(()=>{
                    textarea.style.height = "45px";
                    textarea.style.height = `${textarea.scrollHeight}px`;
                  },300)
                }
                this.chatGotError = true;
                this.isRakhshChatting = false;
              }
            }

          }
        })

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    this.conversations = this.convs;
    this.userTokens = this.tokens.remaining_tokens;
    if(this.convmsg){
      this.chats = this.convmsg;
      this.currentConvId = this.convmsg[0]['conversation_id'];
      const currentConvAtInit = this.conversations.find(item => item.id === this.currentConvId);
      this.selectVersion(currentConvAtInit.version);
      if(currentConvAtInit.user_ai){
        this.chatting_user_ai = currentConvAtInit.user_ai;
      } else {
        if(currentConvAtInit.character){
          this.chatting_character = currentConvAtInit.character;
        }
      }
      this.selectTone(currentConvAtInit.tone);
      this.showWelcome = false;
      this.showChats = true;

    } else {
      this.showWelcome = true;
      this.showChats = false;
    }
    this.username = this.user.name;


    if(this.user.is_first_login == 'yes'){
      this.showFirstLoginAlert = true;
      if(!window.localStorage.getItem('showGuide')){
        window.localStorage.setItem('showGuide' , '0');
      }
    } else {
      this.showFirstLoginAlert = false;
    }

    this.getUserAIList(true);

    setTimeout(()=>{
      if(window.localStorage.getItem('sendByEnter') == '0'){
        this.activeSendByEnter = '0';
      } else {
        this.activeSendByEnter = '1';
      }

      let cookieFontSize = window.localStorage.getItem('fontSize');
      if(cookieFontSize){
        let cookielineHeight = window.localStorage.getItem('lineHeight');
        let cookieFontWeight = window.localStorage.getItem('fontWeight');
        let cookieWordSpacing = window.localStorage.getItem('wordSpacing');
        let cookieLetterSpacing = window.localStorage.getItem('letterSpacing');
        this.fontSize = cookieFontSize;
        this.lineHeight = cookielineHeight;
        this.fontWeight = cookieFontWeight;
        this.cookieWordSpacing = cookieWordSpacing;
        this.cookieLetterSpacing = cookieLetterSpacing;
      }

      let cookieLightMode = window.localStorage.getItem('lightMode');
      if(cookieLightMode == 1){
        this.lightMode = true;
      } else {
        this.lightMode = false;
      }

      if(this.currentConvId != ''){
        if (window.screen.width <= 575) {
          const scrollDiv = document.getElementById("mobile-convs-list");
          const item = scrollDiv.querySelector(".item-" + this.currentConvId);
          const scrollDistance = item.offsetLeft - scrollDiv.scrollLeft;
          scrollDiv.scrollTo({
            left: scrollDistance,
            behavior: 'smooth' // Optional - adds smooth scrolling effect
          });
        } else {
          const scrollDiv = document.getElementById("desktop-convs-list");
          const item = scrollDiv.querySelector(".item-" + this.currentConvId);
          const scrollDistance = item.offsetTop - scrollDiv.scrollTop;
          scrollDiv.scrollTo({
            top: scrollDistance,
            behavior: 'smooth' // Optional - adds smooth scrolling effect
          });
        }
      }

      if(window.localStorage.getItem('showGuide') == '0'){
        window.localStorage.setItem('showGuide' , '1');
      } else if(window.localStorage.getItem('showGuide') == '1'){
        window.localStorage.setItem('showGuide' , '2');
      } else if(window.localStorage.getItem('showGuide') == '2'){
        this.showFirstGuide = true;
        window.localStorage.setItem('showGuide' , '3');
      }

      this.$refs.userMessage.focus();

    },300)

    this.send_msg_sound = new Audio(pop2sound);
    this.alert1_sound = new Audio(alert1sound);
    this.alert2_sound = new Audio(alert2sound);
    this.delete_sound = new Audio(deleteSound);

    textarea.addEventListener("input", function(e) {

      textarea.style.height = "45px";
      textarea.style.height = `${textarea.scrollHeight}px`;

      if(this.userChatInput.length < 3){
        this.isEnglishOrFarsi(this.userChatInput.charAt(0));
      }
    }.bind(this));

    textarea.addEventListener("keydown", function(e) {
      const prevHeight = textarea.style.height;

      textarea.style.height = "45px";
      if (e.keyCode === 13 && !e.shiftKey && this.activeSendByEnter == '1') {
        this.sendChat();
        e.preventDefault();
      }

      if (e.shiftKey || e.keyCode === 37 || e.keyCode === 39 || e.keyCode === 38 || e.keyCode === 40 || e.keyCode !== 17 || e.keyCode !== 18 || e.keyCode !== 20 || e.keyCode !== 9 || e.keyCode !== 91) {
          textarea.style.height = prevHeight;
      }
    }.bind(this));

    textarea.addEventListener("paste", function(e) {
      setTimeout(()=>{
        this.isEnglishOrFarsi(this.userChatInput.charAt(0));
      },300)

      textarea.style.height = "45px"; // Reset height to default
      textarea.style.height = `${textarea.scrollHeight}px`;
    }.bind(this));

    setTimeout(()=>{
        this.$refs.customScrollbar.scrollToBottom();
    },300)

    setTimeout(()=>{
      document.addEventListener('click', (event) => {
        if (event.target){
          if(event.target.classList.contains('copy-code-btn') || event.target.classList.contains('copy-txt') ||event.target.classList.contains('img-copy')){
            const code = event.target.closest('.code-head').nextElementSibling.innerText;
            navigator.clipboard.writeText(code)
              .then(() => {
                let copyTxt = event.target.closest('.code-head').querySelector('.copy-txt');
                copyTxt.textContent = 'کپی شد';
                copyTxt.style.color = '#ffd700';
                setTimeout(()=>{
                  copyTxt.textContent = 'کپی کد';
                  copyTxt.style.color = '#ffffff';
                },2000)
              })
              .catch((err) => console.error('Error copying code', err));
          }
        }

      });
    },100)

    const latestTone = window.localStorage.getItem('latest_tone');
    const latestCharacter = window.localStorage.getItem('latest_character');
    const latestVersion = window.localStorage.getItem('latest_version');

    if(latestTone){
      this.selectTone(this.tones.find(item => item.id == latestTone));
    } else {
      this.selectTone(this.tones.find(item => item.id == 1));
    }

    if(latestCharacter){
      this.selectCharacter(this.characters.find(item => item.id == latestCharacter));
    } else {
      this.selectCharacter(this.characters.find(item => item.id == 1));
    }

    if(latestVersion){
      this.selectVersion(latestVersion);
    } else {
      this.selectVersion(1);
    }


    this.canvasCtx = document.querySelector('#visualization').getContext("2d");

      this.recognition = new recognition();
      this.recognition.continuous = true;
      this.recognition.interimResults = true;
      this.recognition.lang = 'fa-IR';

      this.recognition.onstart = () => {
          this.isListening = true;
      }

      this.recognition.onend = () => {
            if(!this.forceStopListening){
                this.recognition.start();
            }
      }

    this.recognition.onresult = (evt) => {
      let finalTranscript = '';

      for (let i = 0; i < evt.results.length; i++) {
        const result = evt.results[i];

        if (result.isFinal) {
          let transcript = result[0].transcript;

          // Define a map of phrases to their corresponding symbols
          const phraseToSymbolMap = {
            'نقطه بگذار': '.',
            'نقطه بزار': '.',
            'ویرگول بگذار': '،',
            'ویرگول بزار': '،',
            'خط تیره بگذار': '-',
            'خط تیره بزار': '-',
            'علامت تعجب بگذار': '!',
            'علامت تعجب بزار': '!',
            'علامت سوال بگذار': '؟',
            'علامت سوال بزار': '؟',
          };

          // Check if the recognized transcript matches any of the phrases
          for (const phrase in phraseToSymbolMap) {
            if (transcript.includes(phrase)) {
              // Replace the phrase with the corresponding symbol
              transcript = transcript.replace(phrase, phraseToSymbolMap[phrase]);
            }
          }

          // Concatenate the modified transcript
          finalTranscript += transcript + ' ';
        }
      }

      // Update the userChatInput with the final modified transcript
      this.userChatInput = finalTranscript.trim();

      this.$refs.userMessage.style.height = "auto";
      this.$refs.userMessage.style.height = this.$refs.userMessage.scrollHeight + "px";
    }

      // this.recognition.onresult = (evt) => {
      //
      //     let replacementValue = null;
      //
      //     for(let i = 0; i<evt.results.length; i++){
      //         const result = evt.results[i];
      //
      //         if(result.isFinal){
      //             if (result[0].transcript.includes('متن پاک شود')) {
      //                 this.userChatInput = '';
      //             }
      //             if (result[0].transcript.includes('نقطه بزار') || result[0].transcript.includes('نقطه بگذار')) {
      //               replacementValue = '.';
      //             }
      //             if (result[0].transcript.includes('ویرگول بزار') || result[0].transcript.includes('ویرگول بگذار')) {
      //                 result[0].transcript = '،';
      //             }
      //             if (result[0].transcript.includes('خط تیره بزار') || result[0].transcript.includes('خط تیره بگذار')) {
      //                 result[0].transcript = '-';
      //             }
      //             if (result[0].transcript.includes('علامت تعجب بزار') || result[0].transcript.includes('علامت تعجب بگذار')) {
      //                 result[0].transcript = '!';
      //             }
      //             if (result[0].transcript.includes('علامت سوال بزار') || result[0].transcript.includes('علامت سوال بگذار')) {
      //                 result[0].transcript = '؟';
      //             }
      //             if (result[0].transcript.includes('چت جدید باز کن')) {
      //                 // resultsTranscript = '';
      //                 this.openNewChat();
      //             }
      //             if (result[0].transcript.includes('انگلیسی تایپ کن')) {
      //                 this.recognition.stop();
      //                 this.recognition.lang = "en-US";
      //                 this.showChattingAlert = true;
      //                 this.chattingAlertMsg = 'زبان تایپ انگلیسی شد';
      //                 setTimeout(()=>{
      //                     this.showChattingAlert = false;
      //                     this.chattingAlertMsg = '';
      //                 },2000)
      //                 // resultsTranscript = '';
      //             }
      //             if (result[0].transcript.includes('فارسی تایپ کن')) {
      //                 this.recognition.stop();
      //                 this.recognition.lang = "fa-IR";
      //                 this.showChattingAlert = true;
      //                 this.chattingAlertMsg = 'زبان تایپ فارسی شد';
      //                 setTimeout(()=>{
      //                     this.showChattingAlert = false;
      //                     this.chattingAlertMsg = '';
      //                 },2000)
      //                 // resultsTranscript = '';
      //             }
      //         }
      //     }
      //
      //     const t = Array.from(evt.results)
      //         .map(result => result[0])
      //         .map(result => result.transcript)
      //         .join('');
      //
      //     this.userChatInput = t;
      //
      //     this.$refs.userMessage.style.height = "auto";
      //     this.$refs.userMessage.style.height = this.$refs.userMessage.scrollHeight + "px";
      // }

      // this.recognition = new window.webkitSpeechRecognition();
      // this.recognition.lang = 'fa-IR';
      // this.recognition.interimResults = true;
      // // recognition.start();
      //
      // this.recognition.addEventListener('end', (() => {
      //     if(!this.forceStopListening){
      //         this.recognition.start();
      //     }
      // }));
      //
      // this.recognition.addEventListener('result', e => {
      //     if (e.results[0].isFinal) {
      //         let resultsTranscript = e.results[0][0].transcript;
      //
      //         if (resultsTranscript.includes('متن پاک شود')) {
      //             this.userChatInput = '';
      //         }
      //         if (resultsTranscript.includes('نقطه بزار') || resultsTranscript.includes('نقطه بگذار')) {
      //             resultsTranscript = '.';
      //         }
      //         if (resultsTranscript.includes('ویرگول بزار') || resultsTranscript.includes('ویرگول بگذار')) {
      //             resultsTranscript = '،';
      //         }
      //         if (resultsTranscript.includes('خط تیره بزار') || resultsTranscript.includes('خط تیره بگذار')) {
      //             resultsTranscript = '-';
      //         }
      //         if (resultsTranscript.includes('علامت تعجب بزار') || resultsTranscript.includes('علامت تعجب بگذار')) {
      //             resultsTranscript = '!';
      //         }
      //         if (resultsTranscript.includes('علامت سوال بزار') || resultsTranscript.includes('علامت سوال بگذار')) {
      //             resultsTranscript = '؟';
      //         }
      //         if (resultsTranscript.includes('چت جدید باز کن')) {
      //             resultsTranscript = '';
      //             this.openNewChat();
      //         }
      //         // if (resultsTranscript.includes('زال ورژن 1') || resultsTranscript.includes('زال ورژن ١')) {
      //         //   resultsTranscript = '';
      //         //   this.selectVersion(1);
      //         // }
      //         // if (resultsTranscript.includes('تغییر به زال 2') || resultsTranscript.includes('تغییر به زال ٢')) {
      //         //   resultsTranscript = '';
      //         //   this.selectVersion(2);
      //         // }
      //         if (resultsTranscript.includes('انگلیسی تایپ کن')) {
      //             this.recognition.stop();
      //             this.recognition.lang = "en-US";
      //             this.showChattingAlert = true;
      //             this.chattingAlertMsg = 'زبان تایپ انگلیسی شد';
      //             setTimeout(()=>{
      //                 this.showChattingAlert = false;
      //                 this.chattingAlertMsg = '';
      //             },2000)
      //             resultsTranscript = '';
      //         }
      //         if (resultsTranscript.includes('فارسی تایپ کن')) {
      //             this.recognition.stop();
      //             this.recognition.lang = "fa-IR";
      //             this.showChattingAlert = true;
      //             this.chattingAlertMsg = 'زبان تایپ فارسی شد';
      //             setTimeout(()=>{
      //                 this.showChattingAlert = false;
      //                 this.chattingAlertMsg = '';
      //             },2000)
      //             resultsTranscript = '';
      //         }
      //
      //         this.userChatInput += ' ' + resultsTranscript;
      //     } else {
      //         // console.log(e.results);console.log(e.results);
      //     }
      //
      //     this.$refs.userMessage.style.height = "auto";
      //     this.$refs.userMessage.style.height = this.$refs.userMessage.scrollHeight + "px";
      // });

  },

  updated() {
    // Your updated hook code here
  },

  beforeMount() {
    var myCookieValue = this.getCookie("rakhshai_avatar");

    if (myCookieValue !== null) {
      this.userAvatar = myCookieValue;
    }
  },

  beforeUnmount() {
    // Your beforeUnmount hook code here
  },

  methods: {

    renderStream(str){

      // if((this.firstResponseCharChecked == 'not-checked' || this.firstResponseCharChecked == 'checked-ltr') && this.rakhshChattingText.length < 5){
      //   console.log('1234')

      //   // console.log(this.rakhshChattingText.charAt(0))
      //   const firstDir = this.detectLanguage(this.rakhshChattingText.charAt(1));
      //   console.log(firstDir)
      //   if(firstDir == 'rtl'){
      //     this.chatingDir = 'rtl';
      //     this.firstResponseCharChecked = 'checked-rtl';
      //   } else {
      //     this.firstResponseCharChecked = 'checked-ltr';
      //   }
      // }

      this.rakhshChattingTextOriginal += str;

      if(this.rakhshChattingText.length < 50){
        this.chatingDir = this.detectLanguage(this.rakhshChattingText);
      }
      if(this.showCursor){
        // this.showCursor = false;
      }

      if(!this.isCoding){

        this.rakhshChattingText += str;

        if(str.match(this.nextLineRegex)){
          this.rakhshChattingText += ' <br> ';
        }

        if(this.rakhshChattingText.match(this.codeRegex)){
          this.rakhshChattingText = this.rakhshChattingText.replace(this.codeRegex, ' ');
          this.isCoding = true;
        }

        if (this.$refs.customScrollbar.isAtBottom() && !this.$refs.customScrollbar.isScrolling()) {
          this.$refs.customScrollbar.scrollToBottom();
        }

        } else {

        this.code += str;

        this.streamCodeLive(this.code);

        if (this.$refs.customScrollbar.isAtBottom() && !this.$refs.customScrollbar.isScrolling()) {
          this.$refs.customScrollbar.scrollToBottom();
        }

        if(this.code.match(this.codeRegex)){

          this.renderFinalCodeBlock();

        }

        }

    },

    stopStream(){
      this.isStreaming = false;
      this.listeningNewConv = false;

      this.showCursor = false;

      let newRakhshaiChat = {content: this.rakhshChattingTextOriginal , role : 'assistant' , date:''};
      this.chats.push(newRakhshaiChat);
      this.rakhshChattingText = '';
      this.rakhshChattingTextOriginal = '';
      this.isRakhshChatting = false;
      this.updateTokens();
    },

    handleStremErrors(error){
      // if(data.error){
      //     source.close();
      //     if(data.error == 'NOT_ENOUGH_TOKENS'){

      //     }
      //   }
    },

    streamCodeLive(code){
      this.liveCode = '';

      // const languageMatch = code.match(/^(\w+)\n\\/);
      // let languageName = "Code";
      // if (languageMatch) {
      //   languageName = languageMatch[1];
      //   code = code.replace(/^(\w+)\n\\/, "");
      // }

      // const codeHeader = '<div class="code-head prevent-select"><span class="code-language">' + languageName + '</span><div class="copy-code-btn"><img class="img-copy dark" width="16" src="/assets/images/icons/copy.png"><img class="img-copy light" width="16" src="/assets/images/icons/copy-light.png"><span class="copy-txt">کپی کد</span></div></div>';

      const codeHeader = '';
      code = code.replace(this.codeRegex, '').trim();

      let codeBlockOuter = document.createElement('pre');
      let codeBlock = document.createElement('code');
      codeBlock.textContent = code;
      codeBlock.classList.add('language-auto');

      codeBlockOuter.appendChild(codeBlock);

      hljs.highlightElement(codeBlockOuter);

      this.liveCode += codeHeader;
      if (this.$refs.customScrollbar.isAtBottom() && !this.$refs.customScrollbar.isScrolling()) {
        this.$refs.customScrollbar.scrollToBottom();
      }
      this.liveCode += codeBlockOuter.outerHTML;
      this.liveCode += '';

      if (this.$refs.customScrollbar.isAtBottom() && !this.$refs.customScrollbar.isScrolling()) {
        this.$refs.customScrollbar.scrollToBottom();
      }
    },

    renderFinalCodeBlock(){
      this.liveCode = '';
      this.isCoding = false;
      const languageMatch = this.code.match(/^(\w+)\n\\/);
      let languageName = "Code";
      let languageDetect = "javascript";
      if (languageMatch) {
        languageName = languageMatch[1];
        languageDetect = languageMatch[1];
        this.code = this.code.replace(/^(\w+)\n\\/, "");
      }

      const codeHeader = '<div class="code-head prevent-select"><span class="code-language">' + languageName + '</span><div class="copy-code-btn"><img class="img-copy dark" width="16" src="/assets/images/icons/copy.png"><img class="img-copy light" width="16" src="/assets/images/icons/copy-light.png"><span class="copy-txt">کپی کد</span></div></div>';

      this.code = this.code.replace(this.codeRegex, '').trim();

      let codeBlockOuter = document.createElement('pre');
      let codeBlock = document.createElement('code');
      codeBlock.textContent = this.code;
      codeBlock.classList.add('language-auto');

      codeBlockOuter.appendChild(codeBlock);

      if (this.$refs.customScrollbar.isAtBottom() && !this.$refs.customScrollbar.isScrolling()) {
        this.$refs.customScrollbar.scrollToBottom();
      }

      hljs.highlightElement(codeBlockOuter);

      this.rakhshChattingText += codeHeader;
      this.rakhshChattingText += codeBlockOuter.outerHTML;
      // this.rakhshChattingText += ' <br> ';

      this.code = '';

      if (this.$refs.customScrollbar.isAtBottom() && !this.$refs.customScrollbar.isScrolling()) {
        this.$refs.customScrollbar.scrollToBottom();
      }
    },

    sendChat(){

      if(this.currentVersion == 2 && !this.canusev2){
          this.cantUseV2AlertStyle = true;
          return false;
      }

      if (this.userChatInput.length === 0) {
        return false;
      }

      if(this.isRakhshChatting){
        return false;
      }

      this.firstResponseCharChecked = 'not-checked';

      this.isStreaming = true;
      this.listeningNewConv = true;

      let userChat = this.userChatInput;
      let newUserChat = {content: this.userChatInput , role : 'user' , date:''};
      this.chats.push(newUserChat);
      this.userChatInput = '';
      setTimeout(()=>{
        document.getElementById("message-input").style.height = "45px"
      },300)

      this.isRakhshChatting = true;
      this.showCursor = true;

      this.showWelcome = false;
      this.showChats = true;

      setTimeout(()=>{
        this.$refs.customScrollbar.scrollToBottom();
      },100)

      this.send_msg_sound.play();

      axios
      .post('/chat/conv/msg/store' , {
        content : userChat,
        id : this.currentConvId,
        tone_id: this.selected_tone.id,
        version:this.currentVersion,
        character_id: this.selected_character.id,
        ai_id: this.selected_user_ai?.id ?? null
      } )
      .then(response => {

      })
      .catch(error => {
        this.errored = true
      })
      .finally(() => this.loading = false);

    },

    formatChatContent(content) {

      const languageMatch = content.match(/```(\w+)\n/);
      let languageName = "Code";
      let languageDetect = "javascript";
      if (languageMatch) {
        // If a match is found, the language name is in the first capture group
        languageName = languageMatch[1];
        languageDetect = languageMatch[1];
        // content = content.replace(/```(\w+)/, "```");
        // content = content.replace(new RegExp(`\\b${languageDetect}\\b`, "g"), "");
        content = content.replace(new RegExp(languageDetect), '');
      }

      const codeHeader = '<div class="code-head prevent-select"><span class="code-language">' + languageName + '</span><div class="copy-code-btn"><img class="img-copy dark" width="16" src="/assets/images/icons/copy.png"><img class="img-copy light" width="16" src="/assets/images/icons/copy-light.png"><span class="copy-txt">کپی کد</span></div></div>';

      // Replace code blocks with <code> and <pre> tags
       content = content.replace(/```(.+?)```/gs, (match, p1) => {
        let code = '';
        try {
          code = hljs.highlight(p1.trim(), { language: languageDetect }).value;
        } catch (error) {
          code = hljs.highlight(p1.trim(), { language: 'php' }).value;
        }
        return `${codeHeader}<pre class="hljs">${code}</pre>`;
      });


      // Replace newline characters with <br> tags
      content = content.replace(/\n\n/g, "<br>");
      content = content.replace(/\n/g, "<br>");

      let matchesInlineHighlight = content.match(/`([^`]+)`/g);

      if (matchesInlineHighlight) {
        matchesInlineHighlight.forEach(match => {
          let hasHtml = /<[^>]+>/gi.test(match);
          let replacedMatch = hasHtml ? match.replace(/</g, '&lt;').replace(/>/g, '&gt;') : match;
          content = content.replace(match, replacedMatch);
        });
      }

      content = content.replace(/`([^`]*)`/g, "<code class='inline-highlight'>$1</code>");

      content = content.replace(/\*\*(.*?)\*\*/g, '<b>$1</b>');

      return content;
    },

    getConvChats(convId , uuid , tone , version , character , user_ai){
      if(this.isGettingConvChats){
        return false;
      }
      this.chatEditInputId = null;
      this.isGettingConvChats = true;
      this.showChatLoading = true;
      this.showChats = false;
      this.showWelcome = false;
      this.isStreaming = false;
      this.listeningNewConv = false;
      this.isRakhshChatting = false;
      this.rakhshChattingText = '';
      this.rakhshChattingTextOriginal = '';
      this.code = '';
      this.liveCode = '';
      this.mobileCancelEditConv();
      this.selectTone(tone);
      this.currentVersion = version;
      this.currentCharacter = character;
      this.chatting_character = character;
      this.chatting_user_ai = user_ai;
      axios
      .get('/chat/conv/messages?id=' + convId )
      .then(response => {
        if(response.data){
          this.isGettingConvChats = false;
          this.showChatLoading = false;
          this.showChats = true;
          this.chats = response.data;
          this.currentConvId = convId;
          this.updateIdInUrl(uuid);
          setTimeout(()=>{
            this.$refs.customScrollbar.scrollToBottom();
          },100)
          if (window.screen.width > 575) {
            this.$refs.userMessage.focus();
          }
        }
      })
      .catch(error => {
        this.errored = true
      })
      .finally(() => this.loading = false)
    },

    openNewChat(){
      this.showWelcome = true;
      this.showChatLoading = false;
      this.showChats = false;
      this.chatting_user_ai = this.selected_user_ai;
      this.chats = [];
      this.currentConvId = '';
      this.isStreaming = false;
      this.listeningNewConv = false;
      this.isRakhshChatting = false;
      this.rakhshChattingText = '';
      this.rakhshChattingTextOriginal = '';
      this.code = '';
      this.liveCode = '';
      this.removeIdFromUrl();
      this.$refs.userMessage.focus();
    },

    pinChat(convId){
      axios
      .get('/chat/conv/pin?id=' + convId )
      .then(response => {
        if(response.data && response.data.result){
          let convToPin = this.conversations.find(
            (conversation) => conversation.id == convId
          );
          if(response.data.data == "PIN"){
            convToPin.is_pinned = 1;
          } else if(response.data.data == "UNPIN"){
            convToPin.is_pinned = 0;
          }
        }
      })
      .catch(error => {
        this.errored = true
      })
      .finally(() => this.loading = false)
    },

    editChat(convId){
      this.chatEditInputId = convId;
      this.isRenamingMobileConvTitle = true;
    },

    cancelEditChat(){
      this.chatEditInputId = null;
      this.isRenamingMobileConvTitle = false;
    },

    confirmEditChat(convId , event){

      let title = event.target.parentNode.parentNode.querySelector('.edit-chat-input').value;

      axios
      .get('/chat/conv/change-title?id=' + convId + '&title=' + title )
      .then(response => {
        if(response.data && response.data.result){
          this.chatEditInputId = null;
          let convToEdit = this.conversations.find(
            (conversation) => conversation.id == convId
          );
          convToEdit.title = title;
          this.isRenamingMobileConvTitle = false;
        }
      })
      .catch(error => {
        this.errored = true
      })
      .finally(() => this.loading = false)
    },

    deleteChat(convId){
      this.deletingConv = convId;
    },

    cancelDeleteChat(){
      this.deletingConv = null;
    },

    confirmDeleteChat(convId){
      axios
      .get('/chat/conv/delete?id=' + convId )
      .then(response => {
        if(response.data && response.data.result){
          const convIdToDelete = this.conversations.findIndex(
            (conversation) => conversation.id == convId
          );
          if (convIdToDelete !== -1) {
            this.conversations.splice(convIdToDelete, 1);
          }
          this.chats = [];
          this.currentConvId = '';
          this.showWelcome = true;
          this.deletingConv = null;
          this.isRenamingMobileConvTitle = false;
          this.mobileConvEditingIndex = null;
          this.chatting_user_ai = {};
          this.chatting_character = {};
          this.showChats = false;
          this.removeIdFromUrl();
          this.delete_sound.play();
        }
      })
      .catch(error => {
        this.errored = true
      })
      .finally(() => this.loading = false)
    },

    getAllConvs(){
      axios
      .get('/chat/conv/list' )
      .then(response => {
        if(response.data){
          this.conversations = response.data;
        }
      })
      .catch(error => {
        this.errored = true
      })
      .finally(() => this.loading = false)
    },

    updateTokens(){
      axios
      .get('/chat/conv/remaining-tokens' )
      .then(response => {
        if(response.data && response.data.result){
          this.userTokens = response.data.data.remaining_tokens;
          // this.startTokensInterval(this.userTokens , response.data.data.remaining_tokens)

        }
      })
      .catch(error => {
        this.errored = true
      })
      .finally(() => this.loading = false)
    },

    isEnglishOrFarsi(firstChar) {
      const charCode = firstChar.charCodeAt(0);

      if (charCode >= 65 && charCode <= 90 || charCode >= 97 && charCode <= 122) {
        // First character is English
        this.userChatDir = 'ltr';
      } else if (charCode >= 0x0600 && charCode <= 0x06FF) {
        // First character is Farsi
        this.userChatDir = 'rtl';
      } else {
        // First character is not English or Farsi
        this.userChatDir = 'ltr';
      }
    },

    handleReachedBottom() {
    },
    handleReachedBottom2() {
    },
    scrollToBottom() {
      this.$refs.customScrollbar.scrollToBottom();
    },

    parseJsonWithEscapes(jsonString) {
      return JSON.parse(jsonString, function(key, value) {
        if (typeof value === "string") {
          return value.replace(/\\n/g, "\n").replace(/\\r/g, "\r");
        }
        return value;
      });
    },

    highlightTempCode() {
      hljs.highlightElement(this.$refs.tempCode);
    },

    updateIdInUrl(uuid) {
      const regex = /\/chat\/[0-9a-fA-F-]+/; // Regular expression to match UUID after "/chat"
      let currentUrl = window.location.href;
      let newUrl;
      if (regex.test(currentUrl)) {
        // If UUID is already present in the URL, replace it with the new one
        newUrl = currentUrl.replace(regex, '/chat/' + uuid);
        window.history.replaceState(null, null, newUrl);
      } else {
        // If UUID is not present in the URL, add it after the "/chat" segment of the URL
        const chatRegex = /\/chat/;
        const match = chatRegex.exec(currentUrl);
        if (match !== null) {
          newUrl = currentUrl.slice(0, match.index + match[0].length) + '/' + uuid + currentUrl.slice(match.index + match[0].length);
          window.history.pushState(null, null, newUrl);
        }
      }
    },

    removeIdFromUrl() {
      const regex = /\/chat\/[0-9a-fA-F-]+/; // Regular expression to match UUID after "/chat"
      const newUrl = window.location.href.replace(regex, '/chat');
      window.history.replaceState(null, null, newUrl);
    },

    detectLanguage(text) {

      const firstChar = text.charCodeAt(0);

      if( firstChar >= 0x0600 && firstChar <= 0x06FF || firstChar >= 0x0750 && firstChar <= 0x077F){
        return 'rtl';
      }

      let persianOrArabicCount = 0;
      let englishCount = 0;

      // Loop through each character in the text
      for (let i = 0; i < text.length; i++) {
        const charCode = text.charCodeAt(i);

        // Check if the character is Arabic or Persian
        if (charCode >= 0x0600 && charCode <= 0x06FF || charCode >= 0x0750 && charCode <= 0x077F) {
          persianOrArabicCount++;
        }

        // Check if the character is English
        if (charCode >= 0x0041 && charCode <= 0x005A || charCode >= 0x0061 && charCode <= 0x007A) {
          englishCount++;
        }
      }

      // Determine the language with the highest count
      if (persianOrArabicCount > englishCount) {
        return 'rtl';
      } else {
        return 'ltr';
      }
    },

    formatContentLive(content) {

      const lines = content.split('\n')
      const formattedLines = []
      let isCodeBlock = false
      let currentBlock = ''
      let lineNumber = 0
      for (const line of lines) {
        lineNumber++
        if (line.trim().startsWith('```')) {
          isCodeBlock = !isCodeBlock;
          if (isCodeBlock) {
            const language = line.trim().substring(3)
            currentBlock = `${HEAD_TOP}<pre class="hljs"><code class="${language}">`
          } else {
            currentBlock += `</code></pre>`
            formattedLines.push({ key: lineNumber, value: currentBlock })
            currentBlock = ''
          }
        } else if (isCodeBlock) {
          const detectedLanguage = hljs.highlightAuto(line.trim()).language || 'javascript'
          const code = hljs.highlight(line.trim(), { language: detectedLanguage }).value;
          currentBlock += `${code}\n`
        } else {
          formattedLines.push({ key: lineNumber, value: line })
        }
      }

      if (isCodeBlock) {
        currentBlock += `</code></pre>`
        formattedLines.push({ key: lineNumber, value: currentBlock })
      } else {
        formattedLines[formattedLines.length - 1].value += '<span class="cursor"></span>'
      }

      if (this.$refs.customScrollbar.isAtBottom() && !this.$refs.customScrollbar.isScrolling()) {
          this.$refs.customScrollbar.scrollToBottom();
      }

      return formattedLines
    },

    sendByEnter(){
      if(this.activeSendByEnter == '1'){
        window.localStorage.setItem('sendByEnter' , '0');
        this.activeSendByEnter = '0';
      } else if(this.activeSendByEnter == '0') {
        window.localStorage.setItem('sendByEnter' , '1');
        this.activeSendByEnter = '1';
      }
    },

    answerAgain(event){
      let previousText = event.target.closest('.rakhsh-message').previousElementSibling.querySelector('.text').textContent;
      this.userChatInput = previousText;
      this.sendChat();
    },

    mobileShowHistory(){
      const rightCol = document.querySelector('.right-column');
      this.showMobileHistory = true;
      rightCol.classList.add('show-history');
    },

    mobileCloseHistory(){
      const rightCol = document.querySelector('.right-column');
      this.showMobileHistory = false;
      rightCol.classList.remove('show-history');
    },

    closeError(){
      this.chatGotError = false;
      this.errorText = '';
    },

    handleCopyCode(){
      alert()
    },

    logout(){
      window.location.href = 'auth/logout'
    },

    adjustHeight() {
      let windowHeight = window.innerHeight;
      let pageHeight = document.documentElement.scrollHeight;
      if (pageHeight < windowHeight) {
        document.body.style.height = windowHeight + 'px';
        document.querySelector('.side-column').style.height = windowHeight + 'px';
        this.vh100 = windowHeight + 'px';
      }
    },

    formattedUserInput(content) {
      let formattedText = content.replace(/\n/g, "\n");
      return formattedText;
    },

    confirmFontSetting(){
      this.showFontSetting = false;
      window.localStorage.setItem('fontSize' , this.fontSize);
      window.localStorage.setItem('fontWeight' , this.fontWeight);
      window.localStorage.setItem('lineHeight' , this.lineHeight);
      window.localStorage.setItem('wordSpacing' , this.wordSpacing);
      window.localStorage.setItem('letterSpacing' , this.letterSpacing);
    },

    cancelFontSetting(){
      let cookieFontSize = window.localStorage.getItem('fontSize');
      if(cookieFontSize){
        let cookielineHeight = window.localStorage.getItem('lineHeight');
        let cookieFontWeight = window.localStorage.getItem('fontWeight');
        let cookieWordSpacing = window.localStorage.getItem('wordSpacing');
        let cookieLetterSpacing = window.localStorage.getItem('letterSpacing');
        this.fontSize = cookieFontSize;
        this.lineHeight = cookielineHeight;
        this.fontWeight = cookieFontWeight;
        this.cookieWordSpacing = cookieWordSpacing;
        this.cookieLetterSpacing = cookieLetterSpacing;
      } else {
        this.fontSize = 14;
        this.lineHeight = 26;
        this.fontWeight = 400;
        this.wordSpacing = 0;
        this.letterSpacing = 0;
      }
      this.showFontSetting = false;
    },

    setToDefaultFontSetting(){
      this.fontSize = 14;
      this.lineHeight = 26;
      this.fontWeight = 400;
      this.wordSpacing = 0;
      this.letterSpacing = 0;
    },

    startTokensInterval(startValue, endValue) {
      let diff = startValue - endValue;
      let tokensIntervalTime = 3000 / diff;
      if (this.tokensInterval) clearInterval(this.tokensInterval);
      this.tokensInterval = setInterval(() => {
        if (startValue < endValue) {
          startValue += this.step;
        } else if (startValue > endValue) {
          startValue -= this.step;
        } else {
          clearInterval(this.tokensInterval);
        }
        this.userTokens = startValue;
      }, tokensIntervalTime);
    },

    toggleMode(){
      if(this.lightMode){
        this.lightMode = false;
        window.localStorage.setItem('lightMode' , 0);
      } else {
        this.lightMode = true;
        window.localStorage.setItem('lightMode' , 1);
      }
    },


    mobileSelectConvEdit(convIndex){
      this.mobileConvEditingIndex = convIndex;

    },

    mobileCancelEditConv(){
      this.mobileConvEditingIndex = null;
      this.deletingConv = null;
      this.isRenamingMobileConvTitle = false;
      this.chatEditInputId = null;
    },

    hideOverlay(){
      this.showLogoutAlert = false;
      this.showFirstLoginAlert = false;
      if(this.showMobileHistory){
        this.mobileCloseHistory();
        this.showMobileHistory= false;
      }
    },

    refreshApp(){
      window.location.reload()
    },

    selectTone(tone){
      this.selected_tone = tone;
      this.$refs.userMessage.focus();

      window.localStorage.setItem('latest_tone' , tone.id);
    },

    hexToRgbA(hex){
    var c;
    if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
        c= hex.substring(1).split('');
        if(c.length== 3){
            c= [c[0], c[0], c[1], c[1], c[2], c[2]];
        }
        c= '0x'+c.join('');
        return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',.25)';
    }
    throw new Error('Bad Hex');
  },

  deleteAllConvs(){
    axios
      .get('/chat/conv/delete/all' )
      .then(response => {
        if(response){

          const activeConv = this.conversations.find(item => item.id === this.currentConvId);
          if(activeConv.is_pinned != 1){
            this.chats = [];
            this.currentConvId = '';
            this.showWelcome = true;
          }

          this.getAllConvs();

          this.showDeletingConvs = false;

        }
      })
      .catch(error => {

      })
      .finally()

  },
  expandMobileConvs(){
    this.expand_mobile_convs = !this.expand_mobile_convs;
  },
  editUsername(){
    let username = document.getElementById('username-edit').value;
    axios
      .post('/chat/user/change-name' , {
        username : username
      } )
      .then(response => {
        if(response.data.result){
          this.username = username;
          this.isEditingUsername = false;
        }
      })
      .catch(error => {
        this.errored = true
      })
      .finally();
  },

  stopChat(){

    this.stopStream();
    this.$refs.userMessage.focus();

    axios
      .post('/chat/conv/msg/stop' , {
        conv_id : this.currentConvId
      } )
      .then(response => {
      })
      .catch(error => {

      })
      .finally();
  },

  copyMessage(content){
    const textForCopy = this.replaceTextForCopy(content);

    const temp_textarea = document.createElement('textarea');
    temp_textarea.value = textForCopy;
    temp_textarea.style.position = 'fixed';
    temp_textarea.style.opacity = 0;
    document.body.appendChild(temp_textarea);
    // temp_textarea.focus();
    temp_textarea.select();

        try {
          document.execCommand('copy');
        } catch (error) {
        }
  },

  replaceTextForCopy(text) {
    const markers = text.match(/```/g);

    if (!markers) {
        return text;
    }

    const replacedText = markers.reduce((acc, marker, index) => {
        if (index % 2 === 0) {
            return acc.replace(marker, "---code-start-lang:");
        } else {
            return acc.replace(marker, "---code-end---");
        }
    }, text);

    return replacedText;
},

toggleVersion(){
  this.currentVersion = this.currentVersion == 1 ? 2 : 1;
  window.localStorage.setItem('latest_version' , this.currentVersion);
},

selectCharacter(character){
  this.selected_character = character;
  this.$refs.userMessage.focus();

  window.localStorage.setItem('latest_character' , character.id);
},

selectPlusCharacter(){
  this.showPlusCharWindow = true;
},

selectVersion(version){
  this.currentVersion = version;
  window.localStorage.setItem('latest_version' , version);
},
getCookie(cookieName) {
    // Split the cookies string into an array of individual cookies
    var cookies = document.cookie.split(';');

    // Loop through the cookies to find the one you're looking for
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim(); // Trim whitespace

        // Check if this cookie has the desired name
        if (cookie.indexOf(cookieName + '=') === 0) {
            // Extract and return the value of the cookie
            return cookie.substring(cookieName.length + 1, cookie.length);
        }
    }

    // If the cookie is not found, return null or an appropriate default value
    return null;
},
toggleMicMode(){
  if(this.isListening){
    this.stopListening();
  } else {
    this.startListening();
  }
},

startListening(){
      this.isListening = true;
    this.forceStopListening = false;
      this.recognition.start();
      this.startVisualization();
//   this.isListening = true;
//   if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
//   console.log('Speech recognition is supported');
//   this.recognition = new webkitSpeechRecognition() || new SpeechRecognition();
//   this.recognition.lang = this.listeningLang; // Set the language
//
//   // this.startVisualization();
//
//     this.recognition.start();
//
//   this.recognition.onresult = (event) => {
//     // this.$refs.userMessage.focus();
//     // this.userChatInput = transcript;
//     console.log(event.results[0][0].transcript); // You can use this transcript as needed
//   };
//
//   // this.recognition.onend = () => {
//   //   this.isListening = false;
//   // };
//
// } else {
//   console.error('Speech recognition is not supported in this browser.');
// }
},

stopListening(){


  if (this.recognition) {
        this.forceStopListening = true;
        this.recognition.stop();
        this.isListening = false;
        this.stopVisualization();
    }

},

async startVisualization() {
    if (this.isVisualizing) return;
    this.isVisualizing = true;

    try {
        this.context = new (window.AudioContext || window.webkitAudioContext)();
        this.sampleRate = this.context.sampleRate;
        this.audioInput = this.context.createMediaStreamSource(await this.getStream());
        this.analyser = this.context.createAnalyser();
        this.audioInput.connect(this.analyser);
        this.visualize();
    } catch (err) {
        alert('Issue getting mic', err);
    }
},
stopVisualization() {
  if (!this.isVisualizing) return;

  // Stop the visualization loop
  this.isVisualizing = false;
  cancelAnimationFrame(this.animationFrameId);
  try {
      this.canvasCtx.clearRect(0, 0, this.canvasCtx.width, this.canvasCtx.height); // Clear the canvas
  } catch (e) {

  }

  this.canvasCtx = null;
  this.audioInput = null;

  // Release any audio context resources if needed.
  if (this.context) {
    this.context.close().then(() => {
      this.context = null;
    });
  }
},
getStream() {
    return navigator.mediaDevices.getUserMedia({ audio: true, video: false });
},
visualize() {
  const canvas = document.querySelector('#visualization');
  const canvasCtx = canvas.getContext("2d");
  const analyser = this.analyser;
  const app = this; // Ensure app is accessible inside the draw function.

  // Set canvas dimensions
  const WIDTH = canvas.width;
  const HEIGHT = canvas.height;

  // Configure the analyser
  analyser.fftSize = 2048;
  const bufferLength = analyser.frequencyBinCount;
  const dataArray = new Uint8Array(bufferLength);

    function draw() {
        if (!app.isVisualizing) {
            cancelAnimationFrame(app.animationFrameId); // Stop the animation loop.
            return;
        }

        app.animationFrameId = requestAnimationFrame(draw);

        analyser.getByteFrequencyData(dataArray);

        // Clear the previous frame
        canvasCtx.clearRect(0, 0, WIDTH, HEIGHT);

        const barWidth = WIDTH / bufferLength;

        for (let i = 0; i < bufferLength; i++) {
            const barHeight = dataArray[i];
            const x = i * barWidth; // Spread bars evenly
            const y = HEIGHT - barHeight; // Start from the bottom
            const barColor = `rgba(200, 200, 200, .3)`;

            canvasCtx.fillStyle = barColor;
            canvasCtx.fillRect(x, y, barWidth, barHeight);
        }
    }

    app.animationFrameId = requestAnimationFrame(draw);
},

selectVersionItem(versionNumber){
  window.localStorage.setItem('latest_version' , versionNumber);
  this.currentVersion = versionNumber;
},

    crop() {
      return new Promise((resolve) => {
        const { canvas } = this.$refs.cropper.getResult();
        canvas.toBlob((blob) => {
          const reader = new FileReader();
          reader.readAsDataURL(blob); // Convert blob to base64
          reader.onloadend = () => {
            this.newUserAIForm.img = reader.result; // Set base64 string to form data
            resolve(); // Resolve the promise once the image is processed
          };
        }, this.image.type);
      });
    },
		reset() {
			this.image = {
				src: null,
				type: null
			}
		},
		loadImage(event) {
			// Reference to the DOM input element
			const { files } = event.target;
			// Ensure that you have a file before attempting to read it
			if (files && files[0]) {
				// 1. Revoke the object URL, to allow the garbage collector to destroy the uploaded before file
				if (this.image.src) {
					URL.revokeObjectURL(this.image.src)
				}
				// 2. Create the blob link to the file to optimize performance:
				const blob = URL.createObjectURL(files[0]);
				
				// 3. The steps below are designated to determine a file mime type to use it during the 
				// getting of a cropped image from the canvas. You can replace it them by the following string, 
				// but the type will be derived from the extension and it can lead to an incorrect result:
				//
				// this.image = {
				//    src: blob;
				//    type: files[0].type
				// }
				
				// Create a new FileReader to read this image binary data
				const reader = new FileReader();
				// Define a callback function to run, when FileReader finishes its job
				reader.onload = (e) => {
					// Note: arrow function used here, so that "this.image" refers to the image of Vue component
					this.image = {
						// Set the image source (it will look like blob:http://example.com/2c5270a5-18b5-406e-a4fb-07427f5e7b94)
						src: blob,
						// Determine the image type to preserve it during the extracting the image from canvas:
						type: getMimeType(e.target.result, files[0].type),
					};
				};
				// Start the reader job - read file as a data url (base64 format)
				reader.readAsArrayBuffer(files[0]);
			}
		},

    async insertUserAI(){

      if(this.processingAddUserAI){
        return;
      }


      if(!this.newUserAIForm.title){
        toast("لطفا نام هوش مصنوعی را وارد کنید", {
          "theme": "dark",
          "type": "error",
          "position": "top-center",
          "rtl": true,
          "autoClose": 8000,
          "dangerouslyHTMLString": true
        })
    
      } else if(!this.newUserAIForm.content){
        toast("لطفا توضیحات هوش مصنوعی را وارد کنید", {
          "theme": "dark",
          "type": "error",
          "position": "top-center",
          "rtl": true,
          "autoClose": 8000,
          "dangerouslyHTMLString": true
        })
      }


      this.processingAddUserAI = true;

      const fileInput = this.$refs.file;

      if (fileInput.files.length > 0) {
        await this.crop();
      }

      let url = '';
      let ai_id = null;
      if(this.editingUserAIData.id){
        url = '/chat/ai/update';
        ai_id = this.editingUserAIData.id
      } else {
        url = '/chat/ai/store';
      }


      axios
        .post(url , {
          ai_title : this.newUserAIForm.title,
          ai_content : this.newUserAIForm.content,
          ai_avatar : this.newUserAIForm.img,
          ai_id
        } )
        .then(response => {
        console.log(response)
          if(response.data.result){
            this.showPlusCharWindow = false;
            this.getUserAIList(false , response.data.data);

            this.newUserAIForm = {
              title : '',
              content : '',
              img : ''
            };

            if(this.editingUserAIData.id){
              this.editingUserAIData = {};

              toast("هوش مصنوعی شما با موفقیت ویرایش شد", {
                "theme": "dark",
                "type": "success",
                "rtl": true,
                "autoClose": 5000,
                "position": "top-left",
                "dangerouslyHTMLString": true
              })

            } else {

              toast("هوش مصنوعی شما با موفقیت ایجاد شد", {
                "theme": "dark",
                "type": "success",
                "rtl": true,
                "autoClose": 5000,
                "position": "top-left",
                "dangerouslyHTMLString": true
              })

            }

            this.alert2_sound.play();

            if (fileInput.files.length > 0) {
              this.$refs.file.value = "";
              this.reset();
            }

            this.chatting_user_ai = response.data.data;
          } else {
            toast("شما تنها می توانید ۵ هوش مصنوعی همزمان داشته باشید", {
              "theme": "dark",
              "type": "error",
              "position": "top-center",
              "rtl": true,
              "autoClose": 8000,
              "dangerouslyHTMLString": true
            })
          }
        })
        .catch(error => {

        })
        .finally(() => {
          this.processingAddUserAI = false;
        });
    },

    getUserAIList(is_initial=false , active_item = null){

      axios
        .get('/chat/ai/list')
        .then(response => {
          if(response.data.result){
            this.userAIList = response.data.data;

            if(is_initial){
              const latestUserAIId = window.localStorage.getItem('latest_user_ai');
              const foundItem = this.userAIList.find(item => item.id == latestUserAIId);
              if(foundItem){
                this.selectUserAI(foundItem);
              }
            }

            if(active_item){
              this.selectUserAI(active_item);
            }
          }
        })
        .catch(error => {

        })
        .finally();
      },

    deleteUserAI(ai_id){

      axios
        .post('/chat/ai/delete' , {
          ai_id
        } )
        .then(response => {
          if(response.data.result){
            this.showConfirmDeleteUserAI = false;
            this.getUserAIList();

            const clickText = this.$refs.click_text;

            clickText.dispatchEvent(new Event('focus'));
            clickText.dispatchEvent(new MouseEvent('mousedown'));
            clickText.dispatchEvent(new MouseEvent('mouseup'));
            clickText.click();  // Programmatically click

            toast("هوش مصنوعی شما حذف شد", {
                "theme": "dark",
                "type": "success",
                "rtl": true,
                "autoClose": 5000,
                "position": "top-left",
                "dangerouslyHTMLString": true
              })
            this.delete_sound.play();

          }

        })
        .catch(error => {

        })
        .finally();
      },

      updateUserAI(){

        axios
          .post('/chat/ai/update' , {
            ai_title : this.newUserAIForm.title,
            ai_content : this.newUserAIForm.content,
            ai_avatar : this.newUserAIForm.img,
            ai_id : null //selectedChatId
          } )
          .then(response => {
  
          })
          .catch(error => {

          })
          .finally();
        },

        async selectUserAI(userAI){
          window.localStorage.setItem('latest_user_ai' , userAI.id);
          this.selected_user_ai = userAI;
          this.chatting_user_ai = userAI;
        },

        getUserAIData(ai_id){

          axios
            .get('/chat/ai/get-ai?ai_id=' + ai_id )
            .then(response => {
              if(response.data.result){
                this.editingUserAIData = response.data.data;
                this.newUserAIForm.title = response.data.data.ai_title;
                this.newUserAIForm.content = response.data.data.ai_content;
                this.showPlusCharWindow = true;
              }
            })
            .catch(error => {

            })
            .finally();
        },

        myCustomPreviousStepCallback (currentStep) {
        },
        myCustomNextStepCallback (currentStep) {
          if(currentStep == 0 || currentStep == 1 || currentStep == 2 || currentStep == 3){
            this.currentVersion = 1;
          }
          if(currentStep == 4 || currentStep == 5 || currentStep == 6){
            this.currentVersion = 2;
          }
        },
        selectExampleUserAI(exampleAI){
            this.newUserAIForm.title = exampleAI.title;
            this.newUserAIForm.content = exampleAI.content;
            this.showPlusCharWindow = true;
        }


  }
}

</script>

<template>
    <div class="container-fluid container-main" :class="[lightMode ? 'light-mode' : 'dark-mode' , 'v' + currentVersion]">
      <!-- <div>
          <v-tour :callbacks="{
            onPreviousStep: this.myCustomPreviousStepCallback,
            onNextStep: this.myCustomNextStepCallback
          }" name="myTour" :steps="steps" :options="{ backdrop: true }"></v-tour>
      </div> -->
      <div v-if="showPlusCharWindow" class="chat-alert chat-input-alert plus-char bg-alert large-alert" v-motion-fade>
        <div class="head-btn-close">
          <img class="close-btn" @click="showPlusCharWindow = false" width="16" :src="`/assets/images/icons/close.png`">
        </div>
        <div class="content">
          <div v-if="userAIList.length >= 5" class="alert alert-danger" role="alert">
            شما در حال حاضر ۵ هوش مصنوعی ساخته اید و دیگر امکان ساختن یک هوش مصنوعی جدید را ندارید
            <br>
            شما می توانید یکی از هوش مصنوعی های قبلی خود را حذف کنید و سپس یک مورد جدید بسازید.
          </div>
          <p class="title">نام هوش مصنوعی</p>
          <input v-model="newUserAIForm.title" class="plus-char-instruction">
          <p class="title mt-5">هوش مصنوعی تو (۱۰۰۰۰ کلمه)</p>
          <p class="fs-sm">
            <span>خلق شخصیت خیالی </span> 
            <VTooltip :triggers="['hover' , 'click']" :autoHide="true">
              <span>
                <img width="22" src="/assets/images/icons/info.png">
              </span>
                <template #popper>
                  <div class="info-popper">
                    <p class="info-popper-text">شما می‌توانید یک شخصیت خیالی کاملاً جدید با ویژگی‌های منحصربه‌فرد، مانند قدرت‌های فراطبیعی، ظاهر خاص، یا اخلاقیات ویژه بسازید. این شخصیت می‌تواند در تعامل با شما نقش‌آفرینی کند و به مرور زمان با گفتگوها و تعاملات بیشتر توسعه پیدا کند.</p>
                  </div>
                </template>
              </VTooltip>
            <br> 
            <span>خلق دنیای خیالی </span>
            <VTooltip :triggers="['click', 'focus' , 'touch' , 'hover']" :autoHide="true">
              <span>
                <img width="22" src="/assets/images/icons/info.png">
              </span>
                <template #popper>
                  <div class="info-popper">
                    <p class="info-popper-text">شما قادر خواهید بود یک دنیای خیالی با قوانین، موجودات، و جغرافیای خاص خودتان خلق کنید. این دنیا می‌تواند بر اساس تعاملات شما رشد کرده و گسترش یابد، به شکلی که شبیه یک دنیای فانتزی یا علمی-تخیلی با ویژگی‌های منحصربه‌فرد باشد.</p>
                  </div>
                </template>
              </VTooltip>
            <br>
            <span>خلق موجودات خیالی </span>
            <VTooltip :triggers="['click', 'focus' , 'touch' , 'hover']" :autoHide="true">
              <span>
                <img width="22" src="/assets/images/icons/info.png">
              </span>
                <template #popper>
                  <div class="info-popper">
                    <p class="info-popper-text">شما می‌توانید موجودات خیالی طراحی کنید، مانند "موجودات دو بعدی" یا هر نوع موجود خیالی دیگر. این موجودات در تعامل با شما ظاهر و رفتار خاصی خواهند داشت. هوش مصنوعی می‌تواند این موجودات را با شخصیت‌دهی یا قوانین خاص برای تعامل با دنیاهای خیالی توسعه دهد.</p>
                  </div>
                </template>
              </VTooltip>            
            <br>
            <span>تحلیل داده‌های اختصاصی</span>
            <VTooltip :triggers="['click', 'focus' , 'touch' , 'hover']" :autoHide="true">
              <span>
                <img width="22" src="/assets/images/icons/info.png">
              </span>
                <template #popper>
                  <div class="info-popper">
                    <p class="info-popper-text">شما می‌توانید داده‌های اختصاصی خود را به هوش مصنوعی ارائه دهید تا برای تحلیل یا بررسی اطلاعات مورد استفاده قرار گیرد. به عنوان مثال، می‌توانید داده‌های مربوط به تحقیقات، نتایج آماری، یا رفتار کاربران را برای تحلیل به هوش مصنوعی بدهید و نتایج مفیدی از آن دریافت کنید.</p>
                  </div>
                </template>
              </VTooltip>
          </p>
          <textarea v-model="newUserAIForm.content" rows="10" class="plus-char-instruction" placeholder=""></textarea>

          <p class="mt-5">تصویر هوش مصنوعی</p>
          <div class="upload-icon">
            <div class="upload-example">
              <img width="80" height="80" class="rounded-circle mb-3" v-if="editingUserAIData && editingUserAIData.ai_avatar" :src="editingUserAIData.ai_avatar">
              <div class="button-wrapper">
                <button class="button" @click="$refs.file.click()">
                  <input type="file" ref="file" @change="loadImage($event)" accept="image/*">
                  {{ editingUserAIData.id ? 'آپلود تصویر جدید' : 'آپلود تصویر' }}
                  <img width="18" class="mr-2" src="/assets/images/icons/picture.svg">
                </button>
              </div>
              <div class="mt-2" v-show="image.src">
                <cropper
                :stencil-component="$options.components.CircleStencil"
                ref="cropper"
                class="cropper"
                :src="image.src"
                :stencil-props="{
                  aspectRatio: 1
                }"
              />
              </div>
            </div>
          </div>
        </div>
        <div class="bottom mt-4 text-end">
          <a @click="insertUserAI" class="btn btn-sm custom-primary-btn px-4 mx-2">اعمال</a>
          <button @click="showPlusCharWindow = false" class="btn btn-sm custom-secondary-btn px-4 mx-2">لغو</button>
        </div>

        <div v-if="processingAddUserAI" class="processing-add-userai">
          <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
      <div v-if="showLogoutAlert" class="chat-alert chat-input-alert" v-motion-fade>
        <div class="head">
          <img class="close-btn" @click="showLogoutAlert = false" width="14" :src="`/assets/images/icons/close.png`">
        </div>
        <div class="content">
          <p>آیا مطمئنید که از حساب خود خارج می شوید؟</p>
        </div>
        <div class="bottom mt-4">
          <a href="/auth/logout" class="btn btn-light btn-sm px-4 mx-2">بله</a>
          <button @click="showLogoutAlert = false" class="btn btn-outline-light btn-sm px-4 mx-2">لغو</button>
        </div>
      </div>
      <div v-if="showFirstLoginAlert" class="chat-alert chat-input-alert">
        <div class="head">
          <img class="close-btn" @click="showFirstLoginAlert = false" width="14" :src="`/assets/images/icons/close.png`">
        </div>
        <div class="content">
          <p>به رخشای خوش آمدید.</p>
          <p>به عنوان هدیه، <b class="text-warning">{{ tokens.remaining_tokens }}</b> سکه داریک به حساب شما افزوده شد.</p>
          <p>از گفتگو با رخشای لذت ببرید!</p>
        </div>
        <div class="bottom mt-4">
          <button @click="showFirstLoginAlert = false" class="btn btn-warning btn-sm px-4 mx-2">شروع گفتگو</button>
        </div>
      </div>
      <div v-if="showFirstGuide" class="chat-alert chat-input-alert first-guide">
        <div class="head">
          <img class="close-btn" @click="showFirstGuide = false" width="14" :src="`/assets/images/icons/close.png`">
        </div>
        <div class="content">
          <p>کاربر عزیز</p>
          <p>برای گرفتن پاسخ های بهتر و دقیق تر از رخشای، اگر پرسشی با موضوع جدید دارید، یک <b class="text-warning"> چت جدید</b> باز کنید.</p>
          <p class="refresh-text">همچنین اگر در طول گفتگو با مشکلی مواجه شدید برای بارگذاری مجدد صفحه می توانید دکمه رفرش <img class="mx-2" width="20" :src="`/assets/images/icons/refresh.png`"> را در بالای صفحه فشار دهید.</p>
        </div>
        <div class="bottom">
          <button @click="showFirstGuide = false" class="btn btn-warning btn-sm px-4 mx-2">متوجه شدم</button>
        </div>
      </div>

      <div class="row row-main">
        <!-- Sidebar -->
        <div class="col-sm-4 col-md-3 chat-columns right-column">
          <div class="side-column">

            <button @click="openNewChat" id="new-chat-button" class="btn btn-primary">چت جدید <img width="12" class="mr-2" :src="`/assets/images/icons/plus.png`"></button>

          <custom-scroll-bar customId="desktop-convs-list" :max-height="vh100" @reachedBottom="handleReachedBottom2" ref="customScrollbar2">
            <div id="chat-history">
                <div v-for="(conversation, index) in conversations" :key="index" class="chat-item" :class="[currentConvId == conversation.id ? 'active' : '', deletingConv && deletingConv == conversation.id ? 'is-deleting' : '' , `item-${conversation.id}`]" @click="currentConvId != conversation.id ? getConvChats(conversation.id , conversation.uuid , conversation.tone , conversation.version , conversation.character , conversation.user_ai) : null">
                  <div class="chat-item-header">
                    <div class="chat-item-time">{{ conversation.date }}</div>
                  </div>
                  <div class="chat-item-body">
                    <div class="right">
                      <img width="16" height="16" :src="`/assets/images/icons/chat.png`">
                      <div  v-if="chatEditInputId == conversation.id" class="d-flex align-items-center pr-2">
                        <input class="edit-chat-input" :value="conversation.title">
                        <div @click.stop="confirmEditChat(conversation.id , $event)" class="p-1"><img class="mx-1" width="16" :src="`/assets/images/icons/check.png`"></div>
                        <div @click.stop="cancelEditChat(conversation.id)" class="p-1"><img class="mx-1" width="10" :src="`/assets/images/icons/cancel.png`"></div>
                      </div>

                      <div v-else class="conv-text">
                        <p>{{ conversation.title }}</p>
                        <div v-if="conversation.version == 1"><span class="subtitle v1 badge rounded-pill bg-dark" :style="{color:conversation.tone.color}">زال 1</span><span class="subtitle badge rounded-pill bg-dark" :style="{color:conversation.tone.color}">{{ conversation.tone.title }}</span></div>
                        <div v-if="conversation.version == 2"><span class="subtitle v2 badge rounded-pill bg-dark">زال 2</span> <span class="subtitle v2 badge rounded-pill bg-dark">{{ conversation.character.title }}</span></div>
                        <div v-if="conversation.version == 3"><span class="subtitle v2 badge rounded-pill bg-dark">زال 3</span> <span class="subtitle v2 badge rounded-pill bg-dark">{{ conversation?.user_ai?.ai_title }}</span></div>
                      </div>

                    </div>
                    <div v-if="!chatEditInputId" class="left">
                      <div class="btn-conv btn-pin-chat btn-show-on-active" :class="conversation.is_pinned == 0 ? 'no-pinned' : ''" @click.stop=" pinChat(conversation.id)"><img width="16" :src="`/assets/images/icons/pin.png`"></div>
                      <div class="btn-conv btn-edit-chat btn-show-on-active" @click.stop="editChat(conversation.id)"><img width="13" :src="`/assets/images/icons/edit.png`"></div>
                      <div class="btn-conv btn-delete-chat btn-show-on-active" @click.stop="deleteChat(conversation.id)"><img width="14" :src="`/assets/images/icons/delete.png`"></div>
                      <div v-if="conversation.is_pinned == 1" class="btn-conv btn-pin-chat btn-hide-on-active"><img width="16" :src="`/assets/images/icons/pin.png`"></div>
                    </div>
                  </div>
                  <div class="deleting">
                    <span class="txt">آیا مطمئنید؟</span>
                    <div>
                        <img @click.stop="confirmDeleteChat(conversation.id , $event)" class="mx-3" width="16" :src="`/assets/images/icons/check.png`">
                        <img @click.stop="cancelDeleteChat(conversation.id)" width="10" :src="`/assets/images/icons/cancel.png`">
                    </div>
                  </div>
                </div>
              </div>
            </custom-scroll-bar>

            <div class="column-status">
              <div class="inner">
                <div class="status-row name-row">
                  <span v-if="!isEditingUsername" class="status-name">
                    {{ username }}
                    <VTooltip v-if="user.id == 1008" :triggers="['click', 'focus' , 'touch' , 'hover']" :autoHide="true">
                          <div class="btn-transparent-info"><img width="23" :src="`/assets/images/icons/verified-gold.svg`"></div>
                          <template #popper>
                            <div class="info-popper">
                              <p class="info-popper-text">حساب رسمی</p>
                            </div>
                          </template>
                        </VTooltip>
                    </span>
                  <input v-else class="status-name input-name" type="text" :value="username" id="username-edit">
                  <span v-if="!isEditingUsername" @click="isEditingUsername = true" class="btn-edit-name"><img width="14" :src="`/assets/images/icons/edit.png`"></span>
                  <div v-else class="d-flex justify-content-center align-items-center">
                    <div class="btn-item mx-2" @click="editUsername"><img width="16" :src="`/assets/images/icons/check.png`"></div>
                    <div class="btn-item mx-1" @click="isEditingUsername = false"><img width="10" :src="`/assets/images/icons/cancel.png`"></div>
                  </div>
                </div>
                <div class="status-row">
                  <img width="20" :src="`/assets/images/main/coin.png`">
                  <span class="status-title">سکه ها: </span>
                  <span class="status-tokens status-value">{{ userTokens }}</span>

                </div>
              </div>
            </div>

            <div class="side-menu">
              <div class="item-row">
                <div class="column-menu">
                  <a class="menu-item buy-coins" href="/plans" target="_blank">خرید سکه <img width="16" :src="`/assets/images/icons/coins-gold.png`"></a>

                </div>
              </div>
              <div class="item-row">
                <div class="column-menu">
                  <span @click="showDeletingConvs = true" class="menu-item">حذف تمام گفتگوها <img width="16" :src="`/assets/images/icons/delete.png`"></span>
                </div>
                <div v-show="showDeletingConvs" class="font-setting">
                  <div class="row-1">
                    <div class="text">
                      <span>تمامی گفتگوهای شما به جز موارد پین شده حذف خواهد شد.</span>
                    </div>
                  </div>
                  <div class="row-confirm">
                    <div class="d-flex justify-content-center pt-3 pb-1">
                      <div class="btn-item" @click="showDeletingConvs = false"><img width="10" :src="`/assets/images/icons/cancel.png`"></div>
                      <div class="btn-item" @click="deleteAllConvs"><img width="16" :src="`/assets/images/icons/check.png`"></div>
                    </div>
                  </div>

                </div>
              </div>
              <div class="item-row">
                <div class="column-menu">
                  <a class="menu-item shahrzad" href="/image">ساخت تصویر با شهرزاد <img width="16" :src="`/assets/images/icons/picture-shahrzad.svg`"></a>
                </div>
              </div>
              <div class="item-row">
                <div class="column-menu">
                  <!-- <div @click="showVoiceCommands=true" class="menu-item"> دستورات صوتی <img width="16" :src="`/assets/images/icons/mic-help.svg`"></div> -->
                  <div @click="showFontSetting = true" class="menu-item">تنظیمات متن <img width="16" :src="`/assets/images/icons/text-size.png`"></div>
                  <div @click="sendByEnter" class="menu-item" :class="activeSendByEnter == '1' ? 'active' : 'deactive'"> {{ activeSendByEnter == 1 ? 'ارسال با اینتر ' : 'خط بعدی با اینتر ' }}<img width="16" :src="`/assets/images/icons/enter.png`"></div>
                </div>
                <div v-show="showFontSetting" class="font-setting">
                  <div class="row-1">
                    <div class="text">
                    <span>اندازه متن</span>
                    </div>
                    <div class="slider-range">
                      <Slider class="" v-model="fontSize" :min="10" :max="20" />
                    </div>
                  </div>
                  <div class="row-2">
                    <div class="text">
                    <span>فاصله خطوط</span>
                    </div>
                    <div class="slider-range">
                      <Slider class="" v-model="lineHeight" :min="14" :max="34" />
                    </div>
                  </div>
                  <div class="row-3">
                    <div class="text">
                    <span>ضخامت متن</span>
                    </div>
                    <div class="slider-range">
                      <Slider class="" v-model="fontWeight" :min="100" :max="900" :step="100" />
                    </div>
                  </div>
                  <div class="row-3">
                    <div class="text">
                    <span>فاصله کلمات</span>
                    </div>
                    <div class="slider-range">
                      <Slider class="" v-model="wordSpacing" :min="0" :max="10"  />
                    </div>
                  </div>
                  <div class="row-3">
                    <div class="text">
                    <span>فاصله حروف</span>
                    </div>
                    <div class="slider-range">
                      <Slider class="" v-model="letterSpacing" :min="0" :max="5"  />
                    </div>
                  </div>
                  <div class="row-default text-center py-2">
                    <button class="btn btn-sm btn-outline-warning" @click="setToDefaultFontSetting">تنظیمات پیش فرض</button>
                  </div>
                  <div class="row-confirm">
                    <div class="d-flex justify-content-center pt-3 pb-1">
                      <div class="btn-item" @click="cancelFontSetting"><img width="10" :src="`/assets/images/icons/cancel.png`"></div>
                      <div class="btn-item" @click="confirmFontSetting"><img width="16" :src="`/assets/images/icons/check.png`"></div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="item-row">
                <div class="column-menu">
                  <div @click="toggleMode" class="menu-item logout-btn w-3" href="#" > {{ !lightMode ? 'تیره' : 'روشن' }} <img width="16" :src="`/assets/images/icons/dark-mode.png`"> </div>
                  <a class="menu-item logout-btn w-3" href="/" >خانه <img width="16" :src="`/assets/images/icons/home.png`"></a>
                  <a class="menu-item logout-btn w-3" @click="showLogoutAlert = true" >خروج <img width="16" :src="`/assets/images/icons/log-out.png`"></a>
                </div>
              </div>
            </div>
          </div>

          <span @click="mobileCloseHistory" class="mobile-close-btn"><img width="18" :src="`/assets/images/icons/close.png`"></span>

        </div>
        <!-- Main Body -->
        <div class="col-sm-8 col-md-9 chat-columns left-column">
          <div v-if="showChats && currentVersion == 2 && chatting_character" class="chat-header">
            <div class="inner fa-num"><h6 class="title"><img width="24" :src="selected_character.icon"> {{ selected_character.title }}</h6><span class="version badge rounded-pill bg-secondary mx-2">زال 2</span></div>
          </div>
          <div v-if="showChats && currentVersion == 3 && chatting_user_ai" class="chat-header">
            <div class="h-100 d-flex justify-content-between align-items-center px-3">
              <div class="d-flex fa-num"><h6 class="title"><img class="rounded-circle" width="24" :src="chatting_user_ai.ai_avatar"> {{ chatting_user_ai.ai_title }}</h6><span class="version badge rounded-pill bg-secondary mx-2">زال 3</span></div>
            <VDropdown class="userai-tooltip btn-edit-user-ai"
              :distance="6" placement="top"
            >
              <!-- This will be the popover reference (for the events and position) -->
              <button type="button" @click="selectUserAI(userAI)" class="btn btn-outline-dark text-white border border-light rounded-4"><span class="btn-overlay"></span><img width="18" class="icon rounded-circle mx-1" src="/assets/images/icons/settings.svg"><span class="label">عملیات</span></button>

              <!-- This will be the content of the popover -->
              <template #popper>
                <div class="userai-item-tooltip">
                  <div class="row-item row-item-1">
                    <div v-show="chatting_user_ai.ai_avatar" class="userai-img"><img :src="chatting_user_ai.ai_avatar" width="100" height="100" class="rounded-circle"></div>
                    <h5 class="title">{{ chatting_user_ai.ai_title }}</h5>
                    <p class="description">{{ chatting_user_ai.ai_content }} ...</p>
                  </div>
                  <div class="row-item row-item-2">
                    <button @click="getUserAIData(chatting_user_ai.id)" class="modal-button edit">ویرایش</button>
                    <button @click="showConfirmDeleteUserAI = true" class="modal-button delete">حذف</button>
                  </div>

                  <div class="confirm-delete" :class="showConfirmDeleteUserAI ? 'show' : ''">
                    <div>
                      <p>بعد از حذف شخصیت امکان بازگردانی آن یا ادامه گفتگو با آن شخصیت وجود ندارد!</p>
                      <p>آیا اطمینان دارید که می خواهید شخصیت را حذف کنید؟</p>

                      <div class="row-item row-item-2">
                        <button @click="deleteUserAI(chatting_user_ai.id)" class="modal-button delete">بله</button>
                        <button @click="showConfirmDeleteUserAI = false" class="modal-button cancel">خیر</button>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
            </VDropdown>
            </div>
          </div>
          <!-- <highlightjs autodetect :code="code" /> -->
          <div id="chat-body">
            <custom-scroll-bar :max-height="vh100" @reachedBottom="handleReachedBottom" ref="customScrollbar">
            <div v-if="showChats" class="chats" id="chats-scroll">

              <div v-for="(chat, index) in chats" :key="index" class="chat-message" :class="[chat.role == 'user' ? 'user-message' : 'rakhsh-message' , chat.role == 'user' ? this.detectLanguage(chat.content.substring(0, 3)) : this.detectLanguage(chat.content.substring(0, 50))]">
                <div class="inner">
                  <div v-if="chat.role == 'user'" class="avatar">
                    <img width="36" height="36" v-bind:src="`/assets/images/avatars/profile/` + userAvatar" alt="Avatar">
                  </div>
                  <div v-else class="avatar">
                    <img v-if="currentVersion == 1" width="36" height="36" src="/assets/images/main/zal-colored-sm.png" alt="Zal1 Avatar">
                    <img v-if="currentVersion == 2" width="36" height="36" src="/assets/images/main/zal2-sm.png" alt="Zal2 Avatar">
                    <img v-if="currentVersion == 3" width="36" height="36" :src="chatting_user_ai.ai_avatar ? chatting_user_ai.ai_avatar : '/assets/images/main/zal3-sm.webp'" alt="Avatar">
                  </div>
                  <div class="message">
                    <div v-if="chat.role == 'user'" class="text" v-text="formattedUserInput(chat.content)" :style="{fontSize: fontSize + 'px' , lineHeight : lineHeight + 'px' , fontWeight: fontWeight , wordSpacing: wordSpacing + 'px' , letterSpacing: letterSpacing + 'px'}">

                    </div>
                    <div v-else class="text" v-html="formatChatContent(chat.content.trim())" :style="{fontSize: fontSize + 'px' , lineHeight : lineHeight + 'px' , fontWeight: fontWeight , wordSpacing: wordSpacing + 'px' , letterSpacing: letterSpacing + 'px'}">
                    </div>
                    <div v-if="!chat.content">
                      <div class="chat-error"><span>خطایی رخ داده</span></div>
                      <span v-if="index == chats.length - 1" @click="answerAgain($event)" class="btn-response-again">پاسخ مجدد</span>
                    </div>
                    <div class="timestamp">{{ chat.date }}</div>
                  </div>

                  <div @click="copyMessage(chat.content)" class="btn-copy-chat"><img width="12" height="12" :src="`/assets/images/icons/copy.png`"></div>
                </div>
              </div>

              <div v-if="isRakhshChatting" class="chat-message rakhsh-message live-message" :class="chatingDir">
                <div class="inner">
                  <div class="avatar">
                    <img v-if="currentVersion == 1" width="36" height="36" src="/assets/images/main/zal-colored-sm.png" alt="Zal1 Avatar">
                    <img v-if="currentVersion == 2" width="36" height="36" src="/assets/images/main/zal2-sm.png" alt="Zal2 Avatar">
                    <img v-if="currentVersion == 3" width="36" height="36" :src="chatting_user_ai.ai_avatar ? chatting_user_ai.ai_avatar : '/assets/images/main/zal3-sm.webp'" alt="Avatar">
                  </div>
                  <div class="message">
                    <div class="text chatting-container" ref="chattingContainer" :style="{fontSize: fontSize + 'px' , lineHeight : lineHeight + 'px' , fontWeight: fontWeight}">
                      <div class="chat-text" id="chat-text" v-html="rakhshChattingText"></div>
                      <div class="chat-text" id="chat-code" v-html="liveCode"></div>
                      <span v-if="showCursor" class="cursor-static"></span>
                    </div>
                    <div class="timestamp"></div>
                    <div @click="stopChat" class="stop-chat-btn text-light">توقف <img width="14" :src="`/assets/images/icons/stop.png`"></div>
                  </div>
                </div>
              </div>

              <!-- <span v-if="showCursor" class="cursor"></span> -->

            </div>
            </custom-scroll-bar>
            <div v-if="showChatLoading" class="chat-loading">
              <div class="loading-container">
                <div class="progress-bar">
                  <div class="progress-bar-value"></div>
                </div>
              </div>
            </div>
            <div v-if="showWelcome" class="rakhsh-welcome">
              <custom-scroll-bar :max-height="vh100" ref="customScrollbarwelcome">
                <div class="inner">

                  <div class="img prevent-select">
                    <transition name="fade" appear>
                    <img @load="showImage = true" class="rakhsh-welcome-img" :class="showImage ? 'show' : ''" :src="!lightMode ? `/assets/images/main/rakhshai-welcome.png` : `/assets/images/main/rakhshai-welcome-light.png`" alt="RakhshAI">
                  </transition>
                  </div>

                  <div class="rakhsh-examples prevent-select">
                    <h4 class="rakhsh-title"><span class="fa-title">رخشای</span> Rakhsh<span class="text-warning">AI</span></h4>

                    <div class="switch-inner vt-step1">
                      <!-- <h6 class="fa-num" :class="currentVersion == 2 ? 'active' : ''">زال 2</h6> -->
                      <div class="d-flex">
                        <!-- <input :checked="currentVersion == 1 ? false : true" @click="toggleVersion" class="v-switch-input" type="checkbox" id="switch" /> -->
                        <label class="v-switch-label">
                          <div @click="selectVersionItem(1)" class="version-item version1" :class="currentVersion == 1 ? 'active' : ''"><img src="/assets/images/main/zal-colored-sm.png"><span class="version-item-title">زال ۱</span></div>
                          <div @click="selectVersionItem(2)" class="version-item version2 vt-step5" :class="currentVersion == 2 ? 'active' : ''"><img src="/assets/images/main/zal2-md.png"><span class="version-item-title">زال ۲</span></div>
                          <div @click="selectVersionItem(3)" class="version-item version3" :class="currentVersion == 3 ? 'active' : ''"><img src="/assets/images/main/zal3-sm.webp"><span class="version-item-title">زال ۳</span></div>
                        </label>
                      </div>
                      <!-- <h6 class="fa-num" :class="currentVersion == 1 ? 'active' : ''">زال 1</h6> -->
                    </div>

                    <div v-if="currentVersion == 1" class="d-flex justify-content-center flex-wrap fa-num">
                      <p class="price-info w-100">هر کلمه پاسخ معادل 1 سکه</p>
                      <div class="mx-3 mb-3 questions vt-step4">
                        <h5 class="welcome-sec-title py-2">نمونه پرسش</h5>
                        <div class="d-flex flex-column align-items-center">
                          <div v-for="(question, index) in shuffledItems" :key="index" @click="userChatInput = question.name" class="example"><p>{{ question.name }}</p></div>
                        </div>
                      </div>
                      <div class="w-100 rakhsh-info fa-num"><p>نسخه زال 1.0.9</p></div>
                    </div>
                    <div v-if="currentVersion == 2" class="d-flex justify-content-center flex-wrap fa-num">
                        <p class="price-info w-100">هر کلمه پاسخ معادل <b>15</b> سکه</p>
                        <div class="can-not-use-v2" :class="cantUseV2AlertStyle ? 'alert-style shake-alert' : ''" v-if="!canusev2">
                            برای استفاده از دستیار متنی <b :class="cantUseV2AlertStyle ? '' : 'text-warning'">زال 2</b>، نیاز است که حداقل یک بار یکی از پکیج های رخشای را خریداری کرده باشید. <br> پس از خرید پکیج، سکه های هدیه شما به سکه های پکیج خریداری شده اضافه خواهد شد.
                            <div class="text-inner">
                                <a href="/plans" class="btn btn-success rounded-3 mt-4">خرید پکیج</a>
                            </div>
                        </div>
                        <div v-if="canusev2" class="v2-inner">
                            <div class="mx-3 mb-3 questions">
                                <h5 class="welcome-sec-title py-2">نمونه پرسش</h5>
                                <div class="d-flex flex-column align-items-center">
                                    <div v-for="(question, index) in shuffledItems" :key="index" @click="userChatInput = question.name" class="example"><p>{{ question.name }}</p></div>
                                </div>
                            </div>
                        </div>
                      <div class="w-100 rakhsh-info fa-num"><p>نسخه زال 2.1.0</p></div>
                    </div>
                    <div v-if="currentVersion == 3" class="d-flex justify-content-center flex-wrap fa-num">
                        <p class="price-info w-100">هر کلمه پاسخ معادل <b>20</b> سکه</p>
                        <div class="v2-inner">
                            <div class="mx-3 mb-3 ai-examples">
                                <h5 class="welcome-sec-title py-2">نمونه هوش مصنوعی</h5>
                                <div class="example-user-ai">
                                  <div v-for="(example, index) in example_user_ai" :key="index" class="example-item"><div @click="selectExampleUserAI(example)" class="example"><img :src="example.img"></div><span class="title">{{ example.title }}</span></div>
                                </div>
                            </div>
                        </div>
                      <div class="w-100 rakhsh-info fa-num"><p>نسخه زال 3.0.0</p></div>
                    </div>
                  </div>
                </div>
              </custom-scroll-bar>
            </div>

            <div class="mobile-header prevent-select">
              <div class="mobile-header-top">
                <div class="right">
                  <div class="mobile-chats" @click="mobileShowHistory">
                    <img width="22" :src="`/assets/images/icons/menu.png`">
                  </div>
                  <div class="refresh-app" @click="refreshApp">
                    <img width="20" :src="`/assets/images/icons/refresh.png`">
                  </div>
                  <div class="mobile-new-chat zal" @click="openNewChat">
                      <img class="mx-1" width="15" :src="`/assets/images/icons/chat-gold.svg`">چت جدید
                    </div>
<!--                    <a class="mobile-new-chat shahrzad" href="/image">-->
<!--                      <img class="mx-1" width="15" :src="`/assets/images/icons/picture-shahrzad.svg`">تصویر-->
<!--                    </a>-->
                </div>
                  <div class="mobile-tokens">
                      <span class="status-tokens status-value">{{ userTokens }}</span>
                      <img width="24" :src="`/assets/images/main/coin.png`">
                  </div>
              </div>
              <div class="mobile-header-bottom" :class="expand_mobile_convs ? 'expanded' : ''">
                <ul class="inner" id="mobile-convs-list">
                  <li v-for="(conv, index) in conversations" :key="index" :class="[currentConvId == conv.id ? 'active' : '' , `item-${conv.id}`]">
                    <div class="mobile-conv-item" @click="currentConvId != conv.id ? getConvChats(conv.id , conv.uuid , conv.tone , conv.version , conv.character , conv.user_ai) : null">
                      <div class="text-inner">
                        <span class="title">{{ conv.title }}</span>
                        <div v-if="conv.version == 1"><span class="subtitle v1 badge rounded-pill bg-dark" :style="{color:conv.tone.color}">زال 1</span><span class="subtitle badge rounded-pill bg-dark" :style="{color:conv.tone.color}">{{ conv.tone.title }}</span></div>
                        <div v-if="conv.version == 2"><span class="subtitle v2 badge rounded-pill bg-dark">زال 2</span> <span class="subtitle v2 badge rounded-pill bg-dark">{{ conv.character.title }}</span></div>
                        <div v-if="conv.version == 3"><span class="subtitle v2 badge rounded-pill bg-dark">زال 3</span> <span class="subtitle v2 badge rounded-pill bg-dark">{{ conv.user_ai?.ai_title }}</span></div>
                        <!-- <span class="subtitle" :style="{color:conv.tone.color}">#{{ conv.tone.title }}</span> -->
                      </div>
                      <img v-if="conv.is_pinned == 1" class="mx-1" width="15" :src="`/assets/images/icons/pin.png`">

                      <span class="mobile-edit-conv-icon" @click="mobileSelectConvEdit(index)"><img width="12" :src="`/assets/images/icons/write.png`"></span>
                    </div>
                  </li>
                </ul>
                <span @click="expandMobileConvs" class="expand-button d-none"><img width="20" :src="`/assets/images/icons/expand.png`"></span>
              </div>
              <div class="mobile-header-action">
                <div v-if="mobileConvEditingIndex != null" class="edit-conv" v-motion
            :initial="{ opacity: 0, y: -100 }"
            :enter="{ opacity: 1, y: 0, scale: 1 }">
                  <div v-if="deletingConv != null" class="deleting" :class="deletingConv != null ? 'active' : ''">
                    <span class="txt">آیا مطمئنید؟</span>
                    <div>
                        <img @click.stop="confirmDeleteChat(conversations[mobileConvEditingIndex].id , $event)" class="mx-3" width="16" :src="`/assets/images/icons/check.png`">
                        <img @click.stop="cancelDeleteChat(conversations[mobileConvEditingIndex].id)" width="10" :src="`/assets/images/icons/cancel.png`">
                    </div>
                  </div>
                  <div class="chat-item-body">
                    <div class="right">
                      <div v-if="isRenamingMobileConvTitle" class="d-flex align-items-center pr-2">
                        <input class="edit-chat-input" :value="conversations[mobileConvEditingIndex].title">
                        <div @click.stop="confirmEditChat(conversations[mobileConvEditingIndex].id , $event)" class="p-1"><img class="mx-1" width="16" :src="`/assets/images/icons/check.png`"></div>
                        <div @click.stop="cancelEditChat(conversations[mobileConvEditingIndex].id)" class="p-1"><img class="mx-1" width="10" :src="`/assets/images/icons/cancel.png`"></div>
                      </div>
                      <p v-else>{{ conversations[mobileConvEditingIndex].title }}</p>
                    </div>
                    <div v-if="!chatEditInputId" class="left">
                      <div class="btn-conv btn-pin-chat btn-show-on-active px-2 mx-1" :class="conversations[mobileConvEditingIndex].is_pinned == 0 ? 'no-pinned' : ''" @click.stop=" pinChat(conversations[mobileConvEditingIndex].id)"><img width="16" :src="`/assets/images/icons/pin.png`"></div>
                      <div class="btn-conv btn-edit-chat btn-show-on-active px-2 mx-1" @click.stop="editChat(conversations[mobileConvEditingIndex].id)"><img width="13" :src="`/assets/images/icons/edit.png`"></div>
                      <div class="btn-conv btn-delete-chat btn-show-on-active px-2 mx-1" @click.stop="deleteChat(conversations[mobileConvEditingIndex].id)"><img width="14" :src="`/assets/images/icons/delete.png`"></div>
                    </div>
                  </div>
                  <div @click="mobileCancelEditConv" class="mobile-close-editing"><img width="14" :src="`/assets/images/icons/cancel.png`"></div>
                </div>
              </div>
            </div>

            <div @click="hideOverlay" v-show="showLogoutAlert || showFirstLoginAlert || showMobileHistory || showFirstGuide || showPlusCharWindow" class="dark-overlay"></div>

            <div v-if="chatGotError && errorText == 'NOT_ENOUGH_TOKENS'" class="error-floating">
              <div class="alert alert-danger d-flex align-items-center" role="alert">
                <div v-if="errorText == 'NOT_ENOUGH_TOKENS'" class="inner">
                  <button type="button" class="btn-close" @click="closeError"></button>
                  <strong class="prevent-select mx-3"> سکه های شما به اتمام رسیده و رخش برای تاختن به داریک نیاز دارد!</strong>

                  <a class="btn btn-sm btn-warning" href="/plans">خرید سکه</a>
                </div>
              </div>
            </div>

            <div v-if="chatGotError && errorText == 'AIID_DELETED'" class="error-floating">
              <div class="alert alert-danger d-flex align-items-center" role="alert">
                <div v-if="errorText == 'AIID_DELETED'" class="inner">
                  <button type="button" class="btn-close" @click="closeError"></button>
                  <strong class="prevent-select mx-3">شما این هوش مصنوعی را حذف کرده اید و دیگر امکان ادامه چت با آن وجود ندارد!</strong>
                </div>
              </div>
            </div>

            <div v-if="chatGotError && errorText == 'LONG_TEXT'" class="error-floating">
              <div class="alert alert-danger d-flex align-items-center" role="alert">
                <div v-if="errorText == 'LONG_TEXT'" class="inner">
                  <button type="button" class="btn-close" @click="closeError"></button>
                  <strong class="prevent-select mx-3">متن سوال شما بیش از حد طولانی است</strong>
                </div>
              </div>
            </div>

            <div class="error-floating" v-if="cantUseV2AlertStyle && showChats">
              <div class="alert alert-danger d-flex align-items-center" role="alert">
                <div class="inner">
                  <button type="button" class="btn-close" @click="cantUseV2AlertStyle = false"></button>
                  <strong class="prevent-select mx-3">برای استفاده از زال 2 ، نیاز است حداقل یکی از پکیج های رخشای را خریداری کرده باشید</strong>

                  <a class="btn btn-sm btn-warning" href="/plans">خرید پکیج</a>
                </div>
              </div>
            </div>

            <!-- v-if="errorText == 'NOT_ENOUGH_TOKENS'" -->

              <div class="textarea-container chatpage-message-input" :style="{ background: selected_tone && currentVersion == 1 ? 'linear-gradient(180deg , rgba(2,0,36,0) 0% , ' + hexToRgbA(selected_tone.color) + ' 70%)' : 'linear-gradient(rgba(2, 0, 36, 0) 0%, rgba(151, 151, 151, 0.25) 70%)'}">
                <div v-if="showWelcome" class="vt-step2">
                  <div v-if="currentVersion == 1" class="tone-box">
                  <p class="txt-select-tone">ابتدا لحن گفتگو را انتخاب کنید</p>
                  <div class="inner">
                    <button v-for="(tone, index) in tones" :key="index" type="button" @click="selectTone(tone)" class="btn btn-outline-light" :class="[selected_tone && selected_tone.id == tone.id ? 'actived' : '']" :style="{ border:'1px solid ' +  tone.color }"><span :style="{ backgroundColor: tone.color }" class="btn-overlay"></span><span class="label">{{ tone.title }}</span></button>
                  </div>
                </div>
                <div v-if="currentVersion == 2" class="tone-box character">
                  <p class="txt-select-tone"> شخصیت را انتخاب کنید</p>
                  <div class="inner">
                    <button v-for="(character, index) in characters" :key="index" type="button" @click="selectCharacter(character)" class="btn btn-outline-light rounded-4" :class="[selected_character && selected_character.id == character.id ? 'actived' : '']"><span class="btn-overlay"></span><img width="18" class="icon" :src="character.icon"><span class="label">{{ character.title }}</span></button>
                  </div>
                </div>
                <div v-if="currentVersion == 3" class="tone-box character">
                  <p class="txt-select-tone" ref="click_text"> هوش مصنوعی خود را بسازید</p>
                  <div class="inner">
                      <VTooltip :triggers="['hover']" :autoHide="true">
                        <button @click="selectPlusCharacter" type="button" class="btn btn-outline-light rounded-4" :class="userAIList.length == 0 ? 'new-animation' : 'new-animation-2'">جدید</button>
                          <template #popper>
                            <div class="info-popper">
                              <p class="info-popper-text">دنیای خودت را خلق کن</p>
                            </div>
                          </template>
                        </VTooltip>

                        <VDropdown class="userai-tooltip"
                            :distance="6" v-for="(userAI, index) in userAIList" :key="index" placement="top"
                          >
                            <!-- This will be the popover reference (for the events and position) -->
                            <button type="button" @click="selectUserAI(userAI)" class="btn btn-outline-light rounded-4" :class="[selected_user_ai && selected_user_ai.id == userAI.id ? 'actived' : '']"><span class="btn-overlay"></span><img width="22" class="icon rounded-circle" :src="userAI.ai_avatar"><span class="label">{{ userAI.ai_title }}</span></button>

                            <!-- This will be the content of the popover -->
                            <template #popper>
                              <div class="userai-item-tooltip">
                                <div class="row-item row-item-1">
                                  <div v-show="userAI.ai_avatar" class="userai-img"><img :src="userAI.ai_avatar" width="100" height="100" class="rounded-circle"></div>
                                  <h5 class="title">{{ userAI.ai_title }}</h5>
                                  <p class="description">{{ userAI.ai_content }} ...</p>
                                </div>
                                <div class="row-item row-item-2">
                                  <button @click="getUserAIData(userAI.id)" class="modal-button edit">ویرایش</button>
                                  <button @click="showConfirmDeleteUserAI = true" class="modal-button delete">حذف</button>
                                </div>

                                <div class="confirm-delete" :class="showConfirmDeleteUserAI ? 'show' : ''">
                                  <div>
                                    <p>بعد از حذف شخصیت امکان بازگردانی آن یا ادامه گفتگو با آن شخصیت وجود ندارد!</p>
                                    <p>آیا اطمینان دارید که می خواهید شخصیت را حذف کنید؟</p>

                                    <div class="row-item row-item-2">
                                      <button @click="deleteUserAI(userAI.id)" class="modal-button delete">بله</button>
                                      <button @click="showConfirmDeleteUserAI = false" class="modal-button cancel">خیر</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </template>
                          </VDropdown>
                    
                  </div>
                </div>
                </div>

                <div class="input-box vt-step3" :class="isListening ? 'sound-listening' : ''">
                  <button @click="!listeningNewConv ? sendChat() : null" id="send-button" :style="{ backgroundColor: this.selected_tone && this.currentVersion == 1 ? this.selected_tone.color : ''}"><img v-show="!isRakhshChatting" width="24" :src="!lightMode ? `/assets/images/icons/send.png` : `/assets/images/icons/send-light.png`">
                    <div v-show="isRakhshChatting" class="multi-ripple">
                      <div></div>
                      <div></div>
                    </div>
                  </button>
                  <button v-if="testers.includes(user.id)" class="sound-button" @click="toggleMicMode"><img class="sound-icon" width="24" :src="!lightMode ? `/assets/images/icons/mic.svg` : `/assets/images/icons/mic-light.svg`">
                    <VTooltip class="chatting-alert-tooltip" v-model:shown="showChattingAlert" :prevent-overflow="false" shift-cross-axis>
                      <template #popper>
                        {{chattingAlertMsg}}
                      </template>
                    </VTooltip>
                  </button>
                  <textarea ref="userMessage" v-model="userChatInput" id="message-input" placeholder="" rows="1" :class="userChatDir" :dir="userChatDir" :style="{textAlign: userChatDir == 'rtl' ? 'right' : 'left' , fontSize: fontSize + 'px' , fontWeight: fontWeight , paddingLeft : (showChats && currentVersion == 1) ? '84px' : ''}"></textarea>
                  <button v-if="showChats && currentVersion == 1" type="button" class="btn btn-sm btn-outline-light label-selected-tone" :style="{backgroundColor : selected_tone.color , border:'1px solid ' +  selected_tone.color }">{{ selected_tone.title }}</button>

<!--                  <div v-if="isListening" class="listening-icon">-->
<!--                    <button class="btn-mic">-->
<!--                      <div class="pulse-ring"></div>-->
<!--                      <img width="12" :src="`/assets/images/icons/mic-fill.svg`"></button>-->
<!--                  </div>-->

                    <div v-show="isListening" class="visualization-box">
                        <canvas id="visualization"></canvas>
                    </div>
                </div>

              </div>
            </div>

        </div>
      </div>

        <!-- <DraggableBox v-if="showVoiceCommands" class="voice-commands prevent-select">
            <template #header>
                <div class="header-sec">
                    <button @click="showVoiceCommands = false" class="btn btn-sm rounded btn-dark"><img width="10" :src="`/assets/images/icons/close.png`"></button>
                </div>
            </template>
            <template #main>
                <div class="main-sec">
                    <table class="table table-dark table-striped">
                        <thead>
                        <tr>
                            <th>دستور صوتی</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>انگلیسی تایپ کن</td>
                            <td>تغییر زبان تایپ به انگلیسی</td>
                        </tr>
                        <tr>
                            <td>type Farsi</td>
                            <td>تغییر زبان تایپ به فارسی</td>
                        </tr>
                        <tr>
                            <td>نقطه بگذار</td>
                            <td>.</td>
                        </tr>
                        <tr>
                            <td>ویرگول بگذار</td>
                            <td>،</td>
                        </tr>
                        <tr>
                            <td>علامت سوال بگذار</td>
                            <td>؟</td>
                        </tr>
                        <tr>
                            <td>علامت تعجب بگذار</td>
                            <td>!</td>
                        </tr>
                        <tr>
                            <td>خط تیره بگذار</td>
                            <td>-</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </template>
        </DraggableBox> -->
    </div>
</template>

<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 1s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

.show{
  opacity: 1;
}

.cropper {
	height: 300px;
	width: 300px;
  border-radius: 10px;
	background: #212121;
}

.fs-sm{
  font-size: .8rem;
}

.v-popper__popper.v-popper__popper--shown{
  z-index: 99999;
}

.v-popper--theme-tooltip .v-popper__inner{
  max-width: 300px;
}

.Toastify__toast-container{
  z-index: 999999;
}

.Toastify__toast-container .Toastify__toast-body {
  font-family: 'Vazirmatn', sans-serif!important;
  font-size: .95rem;
}



@media only screen and (max-width: 767px) {
  .plus-char{
    width: 90%!important;
    max-width: 100%!important;
    min-width: unset!important
  }
}

</style>
