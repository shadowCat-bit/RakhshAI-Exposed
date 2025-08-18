@extends('layouts.public', ['title' => 'سوالات متدوال رخشای'])
@section('head')
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [{
      "@type": "Question",
      "name": "هوش مصنوعی چیست ؟ ",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>هوش مصنوعی به مجموعه ای از تکنولوژیها و الگوریتمهایی گفته میشود که برای تقلید قابلیتهای ذهن انسان با استفاده از محاسبات وجود دارد. به طور دقیق تر هوش مصنوعی در واقع تلاش برای ساخت دستگاهی است که مانند انسان بتواند حل مسائلی را که برای یک انسان پیچیده نیست، انجام دهد. در این راستا از تکنولوژیهایی مانند یادگیری عمیق، شبکه های عصبی و الگوریتم های یادگیری تقویتی استفاده میشود. در زمینه های مختلفی از جمله پردازش زبان طبیعی، بینایی ماشین و بازیابی اطلاعات از این تکنولوژی ها استفاده میشود.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "هوش مصنوعی ایرانی رخشای چیست ؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>رخشای یک هوش مصنوعی ایرانی است که توسط شرکت آریا هامان مهر پارسه در حال توسعه است. این هوش مصنوعی به منظور دستیابی به یک سیستم هوشمند و نزدیک به انسان با تمرکز بر زبان فارسی و فرهنگ ایرانی طراحی شده است. شرکت آریا هامان مهر پارسه در حال حاضر در ایران یکی از اولین شرکتهایی است که در زمینه طراحی هوش مصنوعی و پردازش زبان فارسی فعالیت میکند و زحمات بسیاری را برای توسعه رخشای انجام داده است.</p>"
      }
    },
    {
      "@type": "Question",
      "name": " کاربرد هوش مصنوعی در شاخه هایی مثل تولید محتوا چیست ؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p><div>
        هوش مصنوعی به طور گسترده در تولید محتوا به کار گرفته میشود و برای بهبود ضریب بهره وری در این زمینه، الگوریتم ها و مدل هایی برای تولید محتوای هوشمند به کمک هوش مصنوعی طراحی شده است. برخی از موارد کاربردی هوش مصنوعی در تولید محتوای دیجیتال شامل:
        <br>
        1. تحلیل داده ها و پیشبینی رفتار مخاطبان
        <br>
        2. ساخت آگهی های هدفمند
        <br>
        3. ایجاد خلاصه ی خودکار (Auto Summarizing) متون بلند
        <br>
        4. خودکارسازی فرآیند تهیه و ویرایش محتوای ویدیویی
        <br>
        5. تولید خودکار محتوای صوتی، متنی و تصویری
        <br>
        6. پردازش زبان طبیعی جهت تعامل با مشتریان
        <br>
        7. دسته بندی کردن محتواها و پیشنهاد محتوای مناسب
        در کل، با استفاده از هوش مصنوعی میتواند تولید محتوای بهتر، سریعتر و با کیفیت بالاتری در دنیای دیجیتال امکانپذیر شود.
      </div></p>"
      }
    },
    {
      "@type": "Question",
      "name": "هوش مصنوعی ایرانی در چه شاخه هایی قابلیت استفاده دارد؟ ",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p> برنامه نویسان ، تولیدکنندگان محتوا ، تحلیلگران داده ، پزشکان ، مترجمان ، مدیران پروژه ، معلمان ، دانشجویان ، دانش آموزان ، روانشناسان و ...</p>"
      }
    },
    {
      "@type": "Question",
      "name": "چگونه می توانم از رخشای استفاده کنم؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>به سادگی! کافیست با شماره موبایل خود در رخشای ثبت نام و یک رمز عبور انتخاب کنید تا به تمام بخش ها دسترسی کامل داشته باشید.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "آیا استفاده از رخشای رایگان است؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>ما سعی می کنیم همیشه طرح های رایگانی برای استقبال از کاربران جدیدمان داشته باشیم. برای اطلاع به کانال های رسمی ما در شبکه های اجتماعی معتبر مراجعه نمایید.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "برای ثبت نام در رخشای چه اطلاعاتی نیاز است؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>تنها یک شماره موبایل و یک نام به دلخواه شما نیاز است.</p>"
      }
    },
    {
      "@type": "Question",
      "name": " آیا اطلاعات من در رخشای رمزنگاری می شود؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>بله. اولویت اول و اصلی ما حفظ حریم خصوصی کاربران و امنیت اطلاعات ورودی آنان است و پیش بینی های بسیاری را در این مورد انجام داده ایم.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "اعتبار مورد استفاده چگونه محاسبه می شود؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>ما به ازای هر کلمه پاسخ سیستم، 1 سکه داریک از حساب شما کم می کنیم. برای استفاده از دیگر خدمات در صورت وجود داشتن، میزان سکه مصرفی در همان بخش اطلاع رسانی خواهد شد.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "آیا امکان بازگشت وجه پس از خرید پکیج وجود دارد؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>خیر.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "آیا گفتگوهای من برای همیشه ذخیره می شود؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>بله. تا زمانی که شما گفتگوهای خود را از سیستم حذف نکنید، ما آن ها را به صورت کاملا امن و بدون محدودیت زمانی برای شما ذخیره می کنیم.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "آیا محدودیتی در پین کردن گفتگوها وجود دارد؟",
      "acceptedAnswer": {
        "@type": " خیر.",
        "text": "<p></p>"
      }
    },
    {
      "@type": "Question",
      "name": "آیا اعتبار رایگان من همیشگی است؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>بله.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "آیا زمان استفاده از اعتبار پکیج های خریداری شده همیشگی است؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>بله.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "آیا امکان حذف گفتگوها وجود دارد؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>بله.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "آیا امکان افزایش تعرفه قیمت ها وجود دارد؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>بله. بنا به شرایط پیش رو و منابع زیاد و پرهزینه مصرفی بستر هوش مصنوعی، امکان افزایش تعرفه در آینده وجود دارد. اما ما همیشه سعی بر مناسب بودن هزینه ها برای کاربر داریم.</p>"
      }
    },
    {
      "@type": "Question",
      "name": "آیا امکان اشتباه در پاسخ گویی از سوی هوش مصنوعی ما وجود دارد؟",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<p>بله و ما هیچ گونه مسئولیتی در قبال پاسخ های داده شده توسط هوش مصنوعی خودمان را نداریم به این دلیل که تمام عملیات بدون نظارت انسانی انجام می شود.</p>"
      }
    }
  ]
  }
  </script>
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "سوالات متداول",
        "item": "{{url()->full()}}"
      }]
    }
    </script>
@endsection
@section('content')
@include('layouts.header')
<main class="page-container faq-page">
    <div class="container py-5">
        <div class="text-center"><h1 class="page-title my-4">سوالات متداول رخشای</h1></div>
        <div class="accordion" id="accordionExample">
          <h2></h2>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading0">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse0"
                aria-expanded="true" aria-controls="collapse0">
                هوش مصنوعی چیست ؟ 
              </button>
            </h3>
            <div id="collapse0" class="accordion-collapse collapse show" aria-labelledby="heading0">
              <div class="accordion-body">
                هوش مصنوعی به مجموعه ای از تکنولوژیها و الگوریتمهایی گفته میشود که برای تقلید قابلیتهای ذهن انسان با استفاده از محاسبات وجود دارد. به طور دقیق تر هوش مصنوعی در واقع تلاش برای ساخت دستگاهی است که مانند انسان بتواند حل مسائلی را که برای یک انسان پیچیده نیست، انجام دهد. در این راستا از تکنولوژیهایی مانند یادگیری عمیق، شبکه های عصبی و الگوریتم های یادگیری تقویتی استفاده میشود. در زمینه های مختلفی از جمله پردازش زبان طبیعی، بینایی ماشین و بازیابی اطلاعات از این تکنولوژی ها استفاده میشود.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading01">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse01" aria-expanded="false" aria-controls="collapse01">
                هوش مصنوعی ایرانی رخشای چیست ؟
              </button>
            </h3>
            <div id="collapse01" class="accordion-collapse collapse" aria-labelledby="heading01">
              <div class="accordion-body">
                رخشای یک هوش مصنوعی ایرانی است که توسط شرکت آریا هامان مهر پارسه در حال توسعه است. این هوش مصنوعی به منظور دستیابی به یک سیستم هوشمند و نزدیک به انسان با تمرکز بر زبان فارسی و فرهنگ ایرانی طراحی شده است. شرکت آریا هامان مهر پارسه در حال حاضر در ایران یکی از اولین شرکتهایی است که در زمینه طراحی هوش مصنوعی و پردازش زبان فارسی فعالیت میکند و زحمات بسیاری را برای توسعه رخشای انجام داده است.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading990">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse990" aria-expanded="false" aria-controls="collapse990">
                کاربرد هوش مصنوعی در شاخه هایی مثل تولید محتوا چیست ؟
              </button>
            </h3>
            <div id="collapse990" class="accordion-collapse collapse" aria-labelledby="heading990">
              <div class="accordion-body">
                هوش مصنوعی به طور گسترده در تولید محتوا به کار گرفته میشود و برای بهبود ضریب بهره وری در این زمینه، الگوریتم ها و مدل هایی برای تولید محتوای هوشمند به کمک هوش مصنوعی طراحی شده است. برخی از موارد کاربردی هوش مصنوعی در تولید محتوای دیجیتال شامل:
                <br>
                1. تحلیل داده ها و پیشبینی رفتار مخاطبان
                <br>
                2. ساخت آگهی های هدفمند
                <br>
                3. ایجاد خلاصه ی خودکار (Auto Summarizing) متون بلند
                <br>
                4. خودکارسازی فرآیند تهیه و ویرایش محتوای ویدیویی
                <br>
                5. تولید خودکار محتوای صوتی، متنی و تصویری
                <br>
                6. پردازش زبان طبیعی جهت تعامل با مشتریان
                <br>
                7. دسته بندی کردن محتواها و پیشنهاد محتوای مناسب
                در کل، با استفاده از هوش مصنوعی میتواند تولید محتوای بهتر، سریعتر و با کیفیت بالاتری در دنیای دیجیتال امکانپذیر شود.
              </div>
            </div>
          </div>          
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading991">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse991" aria-expanded="false" aria-controls="collapse4">
                هوش مصنوعی ایرانی در چه شاخه هایی قابلیت استفاده دارد؟ 
              </button>
            </h3>
            <div id="collapse991" class="accordion-collapse collapse" aria-labelledby="heading991">
              <div class="accordion-body">
                برنامه نویسان ، تولیدکنندگان محتوا ، تحلیلگران داده ، پزشکان ، مترجمان ، مدیران پروژه ، معلمان ، دانشجویان ، دانش آموزان ، روانشناسان و ...
              </div>
            </div>
          </div>          
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading992">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse992" aria-expanded="false" aria-controls="collapse992">
                چگونه می توانم از رخشای استفاده کنم؟
              </button>
            </h3>
            <div id="collapse992" class="accordion-collapse collapse" aria-labelledby="heading992">
              <div class="accordion-body">
                به سادگی! کافیست با شماره موبایل خود در رخشای ثبت نام و یک رمز عبور انتخاب کنید تا به تمام بخش ها دسترسی کامل داشته باشید.
              </div>
            </div>
          </div>          
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading993">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse993" aria-expanded="false" aria-controls="collapse993">
                آیا استفاده از رخشای رایگان است؟
              </button>
            </h3>
            <div id="collapse993" class="accordion-collapse collapse" aria-labelledby="heading993">
              <div class="accordion-body">
                ما سعی می کنیم همیشه طرح های رایگانی برای استقبال از کاربران جدیدمان داشته باشیم. برای اطلاع به کانال های رسمی ما در شبکه های اجتماعی معتبر مراجعه نمایید.
              </div>
            </div>
          </div>          
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading994">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse994" aria-expanded="false" aria-controls="collapse994">
                برای ثبت نام در رخشای چه اطلاعاتی نیاز است؟
              </button>
            </h3>
            <div id="collapse994" class="accordion-collapse collapse" aria-labelledby="heading994">
              <div class="accordion-body">
                تنها یک شماره موبایل و یک نام به دلخواه شما نیاز است.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading995">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse995" aria-expanded="false" aria-controls="collapse6">
                آیا اطلاعات من در رخشای رمزنگاری می شود؟
              </button>
            </h3>
            <div id="collapse995" class="accordion-collapse collapse" aria-labelledby="heading995">
              <div class="accordion-body">
                بله. اولویت اول و اصلی ما حفظ حریم خصوصی کاربران و امنیت اطلاعات ورودی آنان است و پیش بینی های بسیاری را در این مورد انجام داده ایم.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading997">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse997" aria-expanded="false" aria-controls="collapse997">
                اعتبار مورد استفاده چگونه محاسبه می شود؟
              </button>
            </h3>
            <div id="collapse997" class="accordion-collapse collapse" aria-labelledby="heading997">
              <div class="accordion-body">
                ما به ازای هر کلمه پاسخ سیستم، 1 سکه داریک از حساب شما کم می کنیم. برای استفاده از دیگر خدمات در صورت وجود داشتن، میزان سکه مصرفی در همان بخش اطلاع رسانی خواهد شد.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading998">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse998" aria-expanded="false" aria-controls="collapse998">
                آیا امکان بازگشت وجه پس از خرید پکیج وجود دارد؟
              </button>
            </h3>
            <div id="collapse998" class="accordion-collapse collapse" aria-labelledby="heading998">
              <div class="accordion-body">
                خیر.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading999">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse999" aria-expanded="false" aria-controls="collapse999">
                آیا گفتگوهای من برای همیشه ذخیره می شود؟
              </button>
            </h3>
            <div id="collapse999" class="accordion-collapse collapse" aria-labelledby="heading999">
              <div class="accordion-body">
                بله. تا زمانی که شما گفتگوهای خود را از سیستم حذف نکنید، ما آن ها را به صورت کاملا امن و بدون محدودیت زمانی برای شما ذخیره می کنیم.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading8">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">
                آیا محدودیتی در پین کردن گفتگوها وجود دارد؟
              </button>
            </h3>
            <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8">
              <div class="accordion-body">
                خیر.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading9">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse9" aria-expanded="false" aria-controls="collapse9">
                آیا اعتبار رایگان من همیشگی است؟
              </button>
            </h3>
            <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9">
              <div class="accordion-body">
                بله.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading10">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse10" aria-expanded="false" aria-controls="collapse10">
                آیا زمان استفاده از اعتبار پکیج های خریداری شده همیشگی است؟
              </button>
            </h3>
            <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10">
              <div class="accordion-body">
                بله.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading11">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse11" aria-expanded="false" aria-controls="collapse11">
                آیا امکان حذف گفتگوها وجود دارد؟
              </button>
            </h3>
            <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11">
              <div class="accordion-body">
                بله.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading12">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse12" aria-expanded="false" aria-controls="collapse12">
                آیا امکان افزایش تعرفه قیمت ها وجود دارد؟
              </button>
            </h3>
            <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12">
              <div class="accordion-body">
                بله. بنا به شرایط پیش رو و منابع زیاد و پرهزینه مصرفی بستر هوش مصنوعی، امکان افزایش تعرفه در آینده وجود دارد. اما ما همیشه سعی بر مناسب بودن هزینه ها برای کاربر داریم.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h3 class="accordion-header" id="heading13">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse13" aria-expanded="false" aria-controls="collapse13">
                آیا امکان اشتباه در پاسخ گویی از سوی هوش مصنوعی ما وجود دارد؟
              </button>
            </h3>
            <div id="collapse13" class="accordion-collapse collapse" aria-labelledby="heading13">
              <div class="accordion-body">
                بله و ما هیچ گونه مسئولیتی در قبال پاسخ های داده شده توسط هوش مصنوعی خودمان را نداریم به این دلیل که تمام عملیات بدون نظارت انسانی انجام می شود.
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
@include('layouts.footer')
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.js')}}"></script>
<script src="{{asset('assets/js/script.js')}}"></script>
@endsection

