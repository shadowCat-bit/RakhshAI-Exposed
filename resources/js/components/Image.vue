
<script>
// import { SimpleBar } from 'simplebar-vue3';
// import { PerfectScrollbar } from 'vue3-perfect-scrollbar'

import '@/css/a11y-dark.css'
import hljs from 'highlight.js';
import axios from 'axios';
import { Vue3Lottie } from 'vue3-lottie'
import 'vue3-lottie/dist/style.css'
import animation1 from '../animations/animation1.json';
import animation2 from '../animations/animation2.json';
import animation4 from '../animations/animation4.json';
import animation5 from '../animations/animation5.json';
import animation6 from '../animations/animation6.json';
import animation7 from '../animations/animation7.json';
import animation8 from '../animations/animation8.json';
import animation9 from '../animations/animation9.json';
import animation10 from '../animations/animation10.json';
import { defineComponent } from 'vue'
  import 'viewerjs/dist/viewer.css'
  import { component as Viewer } from "v-viewer"

import CustomScrollBar from './CustomScrollBar.vue';
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

export default {
  name: 'MyComponent',

  components: {
    Vue3Lottie,
    Viewer,
    Carousel,
    Slide,
    Pagination,
    Navigation,
},

props : ['server_images' , 'user' , 'tokens' , 'img', 'canusev2'],

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
      cantUseV2AlertStyle:false,
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
      showDeletingConvs: false,
      expand_mobile_convs: false,
      currentVersion:1,
      suggested_questions : [
        { id: 1, name: 'یک فیل در حال قایق سواری با عینک آفتابی' },
        { id: 2, name: 'کره زمین به شکل یک گردو' },
        { id: 3, name: 'یک گوزن موتور سوار در حال تک چرخ زدن' },
        { id: 4, name: 'پیدایش زمین' },
      ],
      isEditingUsername:false,
      username: '',
      showGenerating:false,
      showImages: false,
      imgSizeV1: 'large',
      imgSizeV2: 'small',
      imgCount: 1,
      images:[
        {id:1, path: 'https://th.bing.com/th/id/OIG.d2IYjhm8TJcSN.XwVVAE', size: '1024x1024' , title:'horse running on the clouds'},
        {id:1, path: 'https://cdn.osxdaily.com/wp-content/uploads/2023/03/bing-ai-drawing.jpeg', size: '1024x1024' , title:'horse running on the clouds'},
        {id:1, path: 'https://preview.redd.it/some-images-generated-using-the-new-bing-image-creator-v0-zfohxnf8t3pa1.jpg?width=1024&format=pjpg&auto=webp&s=33274aadae0e0332e60dd15c87617ea6652365b5', size: '1024x1024' , title:'horse running on the clouds'},
      ],
      animations: [animation1 , animation2 , animation4 , animation5 , animation6 , animation7 , animation8 , animation9 , animation10],
      imagesList : [],
      currentImageListId: null,
      bottomSlider:[
        {id:1 , path:'https://rakhshai.com/images/main/dashboard/6b5ab098-18d3-419a-8328-e153867374e22-1688820391.jpg' , title: 'یک ققنوس با بال های آتشین آبی رنگ'},
        {id:2 , path:'https://rakhshai.com/images/main/dashboard/2f83c098-64a9-4c34-a97c-9b7de67a05613-1688820303.jpg' , title: 'داخلی میخانه فانتزی | نقاشی دیجیتال نفس گیر با رنگ های گرم هنر شگفت انگیز مسحور کننده، گیرا، artstation 3'},
        {id:3 , path:'https://rakhshai.com/images/main/dashboard/1ff59443-be43-4f62-b1e2-ecade93356a53-1688820451.jpg' , title: 'دشت آرام آرکادی سبز با گوسفند اثر توماس کول، نقاشی دیجیتالی نفسگیر با رنگ های آرام، هنر شگفت انگیز، ایستگاه هنری 3، کلبه'},
        {id:4 , path:'https://rakhshai.com/images/main/dashboard/b2ac76fa-54a8-4166-a567-29f27e52bee13-1688820228.jpg' , title: 'نقاشی رنگ روغن ماشین پرنده مکانیکی ساعتی از دوره رنسانس، نقاشی دیجیتالی فوق العاده، هنر شگفت انگیز، ایستگاه هنری 3، واقع گرایانه' },
        {id:5 , path:'https://rakhshai.com/images/main/dashboard/628d2922-2aa7-4f6f-89cd-10728c71419e3-1688820549.jpg' , title: 'تصویر دیجیتالی از ماشین پرنده استیم پانک در آسمان با چرخ دنده ها و مکانیزم ها، 4k، جزئیات، پرطرفدار در ایستگاه هنری، رنگ های زنده فانتزی'},
        {id:5 , path:'https://rakhshai.com/images/main/dashboard/31c192b5-e166-4bd0-a870-86442b7d12fa3-1688814225.jpg' , title: 'یک سرباز باستانی در حال مبارزه با دیگر سربازان در یک میدان جنگ بزرگ'},
        {id:5 , path:'https://rakhshai.com/images/main/dashboard/c159ef80-8ce2-4bd9-8762-1890631fb0cd3-1688820381.jpg' , title: 'باغ ها و برج های کاخ آلمان | نقاشی رنگ روغن، ترند در آرت استیشن، انیمه'},
        {id:5 , path:'https://rakhshai.com/images/main/dashboard/89f58d6d-51ec-46b6-a7a6-eca838fa2aef2-1688830364.jpg' , title: 'Pixar style 3D render of a baby dog, 4k, high resolution, trending in artstation'},
      ],
      customPrompt:[],
      customType: 'معمولی',
      showShareLink:false,
      breakpoints: {
      700: {
        itemsToShow: 3.5,
        snapAlign: 'center',
      },
      1000: {
        itemsToShow: 5.5,
        snapAlign: 'center',
      },
      1400: {
        itemsToShow: 6.5,
        snapAlign: 'center',
      },
      1600: {
        itemsToShow: 8.5,
        snapAlign: 'center',
      },
      2300: {
        itemsToShow: 10.5,
        snapAlign: 'start',
      },
      shareLinkIndex:''
    },
    }
  },

  computed: {
    shuffledItems() {
      let items = [...this.suggested_questions];

      for (let i = items.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [items[i], items[j]] = [items[j], items[i]];
      }

      return items.slice(0, 4);
    }
  },

  watch: {
    // Your watch variables here
  },

  created() {
    // Your created hook code here
  },

  mounted() {

    const textarea = document.getElementById("message-input");

    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    this.userTokens = this.tokens.remaining_tokens;

    this.username = this.user.name;

    this.imagesList = this.server_images;

    if(this.img){
      this.images = this.img;
      this.showWelcome = false;
      this.showImages = true;
      this.showGenerating = false;
      this.currentImageListId = this.img.id;

      setTimeout(()=>{

          if (window.screen.width <= 575) {
            const scrollDiv = document.getElementById("mobile-convs-list");
            const item = scrollDiv.querySelector(".item-" + this.img.id.toString());
            const scrollDistance = item.offsetLeft - scrollDiv.scrollLeft;
            scrollDiv.scrollTo({
              left: scrollDistance,
              behavior: 'smooth' // Optional - adds smooth scrolling effect
            });
          } else {
            const scrollDiv = document.getElementById("desktop-convs-list");
            const item = scrollDiv.querySelector(".item-" + this.img.id.toString());
            const scrollDistance = item.offsetTop - scrollDiv.scrollTop;
            scrollDiv.scrollTo({
              top: scrollDistance,
              behavior: 'smooth' // Optional - adds smooth scrolling effect
            });
        }

        // this.$refs.userMessage.focus();

        },300)
    }

    textarea.addEventListener("input", function(e) {

      textarea.style.height = "65px";
      textarea.style.height = `${textarea.scrollHeight}px`;

      if(this.userChatInput.length < 3){
        this.isEnglishOrFarsi(this.userChatInput.charAt(0));
      }
    }.bind(this));

    textarea.addEventListener("keydown", function(e) {

      if(this.userChatInput.length > 500){
        this.userChatInput = this.userChatInput.slice(0, 500);
      }

      const prevHeight = textarea.style.height;

      textarea.style.height = "65px";
      if (e.keyCode === 13 && !e.shiftKey) {
        this.generateImage();
        e.preventDefault();
      }

      if (e.shiftKey || e.keyCode === 37 || e.keyCode === 39 || e.keyCode === 38 || e.keyCode === 40 || e.keyCode !== 17 || e.keyCode !== 18 || e.keyCode !== 20 || e.keyCode !== 9 || e.keyCode !== 91) {
          textarea.style.height = prevHeight;
      }
    }.bind(this));

    textarea.addEventListener("paste", function(e) {

      setTimeout(()=>{

        if(this.userChatInput.length > 500){
          this.userChatInput = this.userChatInput.slice(0, 500);
        }

        this.isEnglishOrFarsi(this.userChatInput.charAt(0));
      },300)

      textarea.style.height = "65px"; // Reset height to default
      textarea.style.height = `${textarea.scrollHeight}px`;
    }.bind(this));

    // setTimeout(()=>{
    //     this.$refs.customScrollbar.scrollToBottom();
    //     this.imagesList = this.server_images;
    // },300)

    // this.getAllimages(true);


  },

  updated() {
    // Your updated hook code here
  },

  beforeUnmount() {
    // Your beforeUnmount hook code here
  },

  methods: {

    pinChat(convId){
      axios
      .get('/image/img/pin?id=' + convId )
      .then(response => {
        if(response.data && response.data.result){
          let convToPin = this.imagesList.find(
            (item) => item.id == convId
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

    getImageListItems (convId , uuid , img){
      if(this.isGettingConvChats){
        return false;
      }
      this.images = img;
      this.showWelcome = false;
      this.showImages = true;
      this.currentImageListId = convId;
      this.updateIdInUrl(uuid);
    },

    deleteChat(convId){
      this.deletingConv = convId;
    },

    cancelDeleteChat(){
      this.deletingConv = null;
    },

    confirmDeleteChat(convId){
      axios
      .get('/image/img/delete?id=' + convId )
      .then(response => {
        if(response.data && response.data.result){
          const convIdToDelete = this.imagesList.findIndex(
            (item) => item.id == convId
          );
          if (convIdToDelete !== -1) {
            this.imagesList.splice(convIdToDelete, 1);
          }
          this.currentImageListId = '';
          this.showWelcome = true;
          this.showImages = false;
          this.showGenerating = false;
          this.deletingConv = null;
          this.mobileConvEditingIndex = null;
          this.removeIdFromUrl();
        }
      })
      .catch(error => {
        this.errored = true
      })
      .finally(() => this.loading = false)
    },

    getAllimages(){
      axios
      .get('/image/img/list' )
      .then(response => {
        if(response.data){
          this.imagesList = response.data;
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

    updateIdInUrl(uuid) {
      const regex = /\/image\/[0-9a-fA-F-]+/; // Regular expression to match UUID after "/chat"
      let currentUrl = window.location.href;
      let newUrl;
      if (regex.test(currentUrl)) {
        // If UUID is already present in the URL, replace it with the new one
        newUrl = currentUrl.replace(regex, '/image/' + uuid);
        window.history.replaceState(null, null, newUrl);
      } else {
        // If UUID is not present in the URL, add it after the "/chat" segment of the URL
        const chatRegex = /\/image/;
        const match = chatRegex.exec(currentUrl);
        if (match !== null) {
          newUrl = currentUrl.slice(0, match.index + match[0].length) + '/' + uuid + currentUrl.slice(match.index + match[0].length);
          window.history.pushState(null, null, newUrl);
        }
      }
    },

    removeIdFromUrl() {
      const regex = /\/image\/[0-9a-fA-F-]+/; // Regular expression to match UUID after "/chat"
      const newUrl = window.location.href.replace(regex, '/image');
      window.history.replaceState(null, null, newUrl);
    },

    detectLanguage(text) {
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

    detectUsePersian(text){
      let persianOrArabicCount = 0;
      for (let i = 0; i < text.length; i++) {
        const charCode = text.charCodeAt(i);
        // Check if the character is Arabic or Persian
        if (charCode >= 0x0600 && charCode <= 0x06FF || charCode >= 0x0750 && charCode <= 0x077F) {
          persianOrArabicCount++;
        }
      }

      if(persianOrArabicCount > 1){
          return 1;
        } else {
          return 0;
        }
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

  deleteAllConvs(){
    axios
      .get('/image/img/delete/all' )
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

  generateImage(){

    let version = this.currentVersion + 1;

    if (version == 2 && !this.canusev2) {
          this.cantUseV2AlertStyle = true;
          return false;
    }

    if (this.userChatInput.length === 0) {
        return false;
    }

    this.showGenerating = true;
    this.showWelcome = false;
    this.showImages = false;
    let is_persian = this.detectUsePersian(this.userChatInput);
    this.errorText = '';
    this.chatGotError = false;
    let count = this.currentVersion == 1 ? 1 : this.imgCount;
    let imageSize = '';
    if(version == 2){
      imageSize = this.imgSizeV2;
    } else if(version == 1){
      imageSize = this.imgSizeV1;
    }

    axios
      .post('/image/img/store' , {
        title : this.userChatInput,
        n: count,
        size:imageSize,
        is_persian: is_persian,
        show_public: 1,
        version:version,
        propmts: this.customPrompt
      } )
      .then(response => {
        console.log(response.data)

        if(response.data.result){
          this.currentImageListId = response.data.data.id;
          this.images = response.data.data
          this.showGenerating = false;
          this.showImages = true;
          this.updateIdInUrl(response.data.data.uuid);
          this.getAllimages();
        } else {
          this.chatGotError = true;
          this.showGenerating = false;
          this.showWelcome = true;
          this.showImages = false;
          if(response.data.msg == "Your request was rejected as a result of our safety system. Your prompt may contain text that is not allowed by our safety system." || response.data.msg == "Your request was rejected as a result of our safety system. "){
            this.errorText = 'NOT_ALLOWED';
            return false;
          }
          this.errorText = response.data.data;
        }
        this.updateTokens();
      })
      .catch(error => {
      })
      .finally();
  },

  inited (viewer) {
        this.$viewer = viewer
      },
  show (index) {
    this.$viewer.show(index)
  },
  openNewChat(){
    this.showImages = false;
    this.showGenerating = false;
    this.showWelcome = true;
    this.currentImageListId = null;
    this.userChatInput = '';
    this.customPrompt = [];
    document.getElementById("message-input").style.height = "65px"
    this.removeIdFromUrl();
  },
  increaseValue() {
    if(this.imgCount < 4){
      this.imgCount = this.imgCount + 1;
    }
  },
  decreaseValue() {
    if(this.imgCount > 1){
      this.imgCount = this.imgCount - 1;
    }
  },
  downloadFile(url) {
      const filename = 'image.jpg'; // Replace with the desired filename

      this.$refs.downloadLink.href = url;
      this.$refs.downloadLink.download = filename;
      this.$refs.downloadLink.click();

    // console.log(url)
    // window.open(url, '_blank');
  },

  toggleShowPublic(imageId){

      axios
      .get('/image/img/public-show?id=' + imageId )
      .then(response => {
        let imageToPublic = this.imagesList.find(
            (item) => item.id == imageId
        );
        if(response.data.data == "PUBLIC_SHOW"){
          imageToPublic.public_show = 1;
        } else if(response.data.data == "NOT_PUBLIC_SHOW"){
          imageToPublic.public_show = 0;
        }


      })
      .catch(error => {

      })
      .finally()



  },

  copyText(link , btnId){
    const temp_textarea = document.createElement('textarea');
    temp_textarea.value = link;
    temp_textarea.style.position = 'fixed';
    document.body.appendChild(temp_textarea);
    temp_textarea.focus();
    temp_textarea.select();

    try {
      const successful = document.execCommand('copy');
      const message = successful ? 'Text copied to clipboard!' : 'Unable to copy text.';
      document.getElementById(btnId).textContent = "کپی شد";
      setTimeout(function(){
        const copyBtn = document.getElementById(btnId);
        if(copyBtn){
          document.getElementById(btnId).textContent = "کپی";
        }
      },3000)
    } catch (error) {
    }

    document.body.removeChild(temp_textarea);
  },

  openShareLink(index){
    this.showShareLink = true;
    this.shareLinkIndex = index;

  }

  }
}

</script>

<template>
    <div class="container-fluid container-main" :class="[lightMode ? 'light-mode' : 'dark-mode' , 'img-v' + (currentVersion + 1)]">

      <div v-if="showLogoutAlert" class="chat-alert chat-input-alert">
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
          <div class="side-column" style="background-image: url('/assets/images/main/pattern1.png')">

            <button @click="openNewChat" id="new-chat-button" class="btn btn-primary">تصویر جدید <img width="18" class="mx-2" :src="`/assets/images/icons/image.png`"></button>

          <custom-scroll-bar customId="desktop-convs-list" :max-height="vh100" @reachedBottom="handleReachedBottom2" ref="customScrollbar2">
            <div id="chat-history">
                <div v-for="(item, index) in imagesList" :key="index" class="chat-item" :class="[currentImageListId == item.id ? 'active' : '', deletingConv && deletingConv == item.id ? 'is-deleting' : '' , `item-${item.id}`]" @click="currentImageListId != item.id ? getImageListItems(item.id , item.uuid , item) : null">
                  <div class="chat-item-header">
                    <div class="chat-item-time">{{ item.date }}</div>
                  </div>
                  <div class="chat-item-body">
                    <div class="right">
                      <div class="inner">
                        <div class="thumbnails" :class="'thumbs-' + item.img.length">
                          <img :src="item.img[0].thumbnail">
                        </div>
                        <div v-if="!chatEditInputId" class="left">
                          <div class="btn-conv btn-pin-chat btn-show-on-active" :class="item.is_pinned == 0 ? 'no-pinned' : ''" @click.stop=" pinChat(item.id)"><img width="16" :src="`/assets/images/icons/pin.png`"></div>
                          <div class="btn-conv btn-delete-chat btn-show-on-active" @click.stop="deleteChat(item.id)"><img width="14" :src="`/assets/images/icons/delete.png`"></div>
                          <div v-if="item.is_pinned == 1" class="btn-conv btn-pin-chat btn-hide-on-active"><img width="16" :src="`/assets/images/icons/pin.png`"></div>
                        </div>
                      </div>

                      <div class="conv-text">
                        <p>{{ item.title.substring(0, 100) + "..." }}</p>
                          <div><span class="subtitle v1 badge rounded-pill bg-dark">شهرزاد {{item.version}}</span></div>
                      </div>

                    </div>
                  </div>
                  <div class="deleting">
                    <span class="txt">آیا مطمئنید؟</span>
                    <div>
                        <img @click.stop="confirmDeleteChat(item.id , $event)" class="mx-3" width="16" :src="`/assets/images/icons/check.png`">
                        <img @click.stop="cancelDeleteChat(item.id)" width="10" :src="`/assets/images/icons/cancel.png`">
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
                  <span class="status-tokens status-value">{{ userTokens.toLocaleString() }}</span>
<!--                  <span class="d-block">معادل <b class="text-shahrzad-light">{{ Math.floor(userTokens / 1000) }}</b> تصویر</span>-->

                </div>
              </div>
            </div>

            <div class="side-menu">
              <div class="item-row">
                <div class="column-menu">
                  <a class="menu-item" href="/chat">چت با زال <img width="16" :src="`/assets/images/icons/chat.png`"></a>
                  <a class="menu-item buy-coins" href="/plans" target="_blank">خرید سکه <img width="16" :src="`/assets/images/icons/coins-gold.png`"></a>
                </div>
              </div>
              <div class="item-row">
                <div class="column-menu">
                  <a class="menu-item logout-btn" href="/explore" target="_blank" >تصاویر عمومی <img width="16" :src="`/assets/images/icons/explore.svg`"></a>
                </div>
                <!-- <div class="column-menu">
                  <span @click="showDeletingConvs = true" class="menu-item">حذف تمام تصاویر <img width="16" :src="`/assets/images/icons/delete.png`"></span>
                </div> -->
                <!-- <div v-show="showDeletingConvs" class="font-setting">
                  <div class="row-1">
                    <div class="text">
                      <span>تمامی تصاویر شما به جز موارد پین شده حذف خواهد شد.</span>
                    </div>
                  </div>
                  <div class="row-confirm">
                    <div class="d-flex justify-content-center pt-3 pb-1">
                      <div class="btn-item" @click="showDeletingConvs = false"><img width="10" :src="`/assets/images/icons/cancel.png`"></div>
                      <div class="btn-item" @click="deleteAllConvs"><img width="16" :src="`/assets/images/icons/check.png`"></div>
                    </div>
                  </div>

                </div> -->
              </div>

              <div class="item-row">
                <div class="column-menu">
                  <a class="menu-item logout-btn" href="/" >خانه <img width="16" :src="`/assets/images/icons/home.png`"></a>
                  <a class="menu-item logout-btn" @click="showLogoutAlert = true" >خروج <img width="16" :src="`/assets/images/icons/log-out.png`"></a>
                </div>
              </div>
            </div>
          </div>

          <span @click="mobileCloseHistory" class="mobile-close-btn"><img width="18" :src="`/assets/images/icons/close.png`"></span>

        </div>
        <!-- Main Body -->
        <div class="col-sm-8 col-md-9 chat-columns left-column">
          <!-- <highlightjs autodetect :code="code" /> -->
          <div id="chat-body">
            <custom-scroll-bar :max-height="vh100" @reachedBottom="handleReachedBottom" ref="customScrollbar">
            <div v-if="showImages" id="chats-scroll">

              <div class="images-inner">

                <div class="image-actions mb-3">
                  <div class="public-show">
                    <VTooltip :triggers="['click', 'focus' , 'touch']" :autoHide="true">
                          <div class="btn-transparent-info"><img width="22" height="22" :src="`/assets/images/icons/info.png`"></div>

                          <template #popper>
                            <div class="info-popper">
                              <p class="info-popper-text">تعیین کنید که تصویر شما در صفحه تصاویر عمومی قابل نمایش باشند.</p>
                            </div>
                          </template>
                        </VTooltip>
                    <div class="form-check form-switch" v-if="images">
                      <input @change="toggleShowPublic(images.id)" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" :value="images.public_show"  :checked="images.public_show == 1 ? true : false" autocomplete="off">
                      <label class="form-check-label public-show-text" for="flexSwitchCheckDefault">نمایش در تصاویر عمومی رخشای</label>
                    </div>
                  </div>
                </div>

                <div class="">
                  <!-- <div v-for="(image, index) in images.img" :key="index" class="img-thumb-item" @click="show(index)">
                    <div class="inner">
                      <img class="img-ai-thumbnail" :src="image.original">
                    </div>
                  </div> -->

                  <viewer :options="options" :images="images.img"
                        @inited="inited"
                        class="viewer images img-thumb-grid" :class="'thumb-items-' + images.img.length" ref="viewer"
                        >
                        <div v-for="(image, index) in images.img" :key="index" class="img-thumb-item">
                          <div class="inner" @click="show()">
                            <img class="img-ai-thumbnail" :src="image.original">
                          </div>
                          <div class="my-3 buttons">
                              <a @click.stop="" :href="image.original" download class="btn btn-secondary btn-sm mx-1 btn-images"><!-- <img width="16" :src="`/assets/images/icons/download-light.svg`"> -->
                                دانلود
                              </a>
                              <button @click="openShareLink(index)" class="btn btn-secondary btn-sm mx-1 btn-images"><!-- <img width="16" :src="`/assets/images/icons/share-light.svg`"> -->
                                اشتراک گذاری
                                </button>
                                <div v-if="showShareLink && shareLinkIndex == index" class="share-link">
                                  <div class="share-head">
                                    <span>اشتراک گذاری</span>
                                    <div @click="showShareLink = false" class="btn-close"><img width="13" :src="`/assets/images/icons/cancel.png`"></div>
                                  </div>
                                  <div class="input-group share-inner mb-3">
                                    <button @click="copyText('https://rakhshai.com/explore/image/' + images.uuid + '?item=' + index , 'btn-copy-share-link')" class="btn btn-outline-secondary" type="button" id="btn-copy-share-link">کپی</button>
                                    <input :value="'https://rakhshai.com/explore/image/' + images.uuid + '?item=' + index" type="text" class="form-control" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                  </div>
                                </div>
                                <div v-if="showShareLink && shareLinkIndex == index" @click="showShareLink = false" class="share-link-overlay"></div>

                          </div>
                  </div>
                </viewer>
                </div>

                <div class="image-title">
                  <p class="txt">{{ images.title }}</p>
                  <div class="image-options">
                    <div class="prompts"><span class="item" v-for="(prompt, index) in images.prompt" :key="index">#{{ prompt }} </span></div>
                  </div>
                </div>

                <div class="image-size mb-5">
                  <p v-if="images.version == 1" class="txt"><span>اندازه: </span> {{ images.size == 'large' ? '1024px x 1024px' : images.size == 'medium' ? '512px x 512px' : '256px x 256px' }}</p>
                  <p v-if="images.version == 2" class="txt"><span>اندازه: </span> {{ images.size == 'large' ? '1792px x 1024px' : images.size == 'medium' ? '1024px x 1792px' : '1024px x 1024px' }}</p>
                </div>

              </div>
              <!-- v-if="isRakhshChatting" -->

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

                  <div class="image-slider">
                    <div class="image-slider-head"><h6>تصاویر عمومی </h6><a href="/explore" class="text-shahrzad-light">مشاهده همه</a></div>
                    <div class="slider-inner">
                    <Carousel :breakpoints="breakpoints" :wrap-around="true" dir="rtl" autoplay="5000" :pauseAutoplayOnHover="true">
                    <Slide v-for="slide in bottomSlider" :key="slide">
                      <div class="carousel__item">
                        <div class="slider-img">
                          <img class="img-fliud" :src="slide.path">
                        </div>
                        <div class="overlay">
                          <span>{{ slide.title }}</span>
                        </div>
                      </div>
                    </Slide>

                    <template #addons>
                      <Navigation />
                    </template>
                  </Carousel>
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
                  <div class="mobile-new-chat" @click="openNewChat">
                      <img class="mx-1" width="15" :src="`/assets/images/icons/picture.svg`">تصویر جدید
                    </div>
                </div>
                  <div class="mobile-tokens">
                      <span class="status-tokens status-value">{{ userTokens.toLocaleString() }} <!--<span class="equal-images-mobile">)<b>{{ Math.floor(userTokens / 1000) }}</b><span>تصویر</span>(</span>--></span>
                      <img width="24" :src="`/assets/images/main/coin.png`">
                  </div>
              </div>
              <div class="mobile-header-bottom" :class="expand_mobile_convs ? 'expanded' : ''">
                <ul class="inner" id="mobile-convs-list">
                  <li v-for="(item, index) in imagesList" :key="index" :class="[currentImageListId == item.id ? 'active' : '' , `item-${item.id}`]">
                    <div class="mobile-conv-item" @click="currentImageListId != item.id ? getImageListItems(item.id , item.uuid , item) : null">
                      <div class="text-inner">
                        <div class="mobile-thumnails" :class="'thumbs-' + item.img.length">
                          <img width="30" height="30" :src="item.img[0].thumbnail">
                        </div>
                        <div class="title">{{ item.title.substring(0, 25) + "..." }}
                            <div class="d-block"><span class="subtitle v1 badge rounded-pill bg-dark">شهرزاد {{item.version}}</span></div>
                        </div>
                      </div>
                      <img v-if="item.is_pinned == 1" class="mx-1" width="15" :src="`/assets/images/icons/pin.png`">

                      <span class="mobile-edit-conv-icon" @click="mobileSelectConvEdit(index)"><img width="12" :src="`/assets/images/icons/write.png`"></span>
                    </div>
                  </li>
                </ul>
                <span @click="expandMobileConvs" class="expand-button d-none"><img width="20" :src="`/assets/images/icons/expand.png`"></span>
              </div>
              <div class="mobile-header-action">
                <div v-if="mobileConvEditingIndex != null" class="edit-conv">
                  <div v-if="deletingConv != null" class="deleting" :class="deletingConv != null ? 'active' : ''">
                    <span class="txt">آیا مطمئنید؟</span>
                    <div>
                        <img @click.stop="confirmDeleteChat(imagesList[mobileConvEditingIndex].id , $event)" class="mx-3" width="16" :src="`/assets/images/icons/check.png`">
                        <img @click.stop="cancelDeleteChat(imagesList[mobileConvEditingIndex].id)" width="10" :src="`/assets/images/icons/cancel.png`">
                    </div>
                  </div>
                  <div class="chat-item-body">
                    <div class="right">
                      <div v-if="isRenamingMobileConvTitle" class="d-flex align-items-center pr-2">
                        <input class="edit-chat-input" :value="conversations[mobileConvEditingIndex].title">
                        <div @click.stop="confirmEditChat(imagesList[mobileConvEditingIndex].id , $event)" class="p-1"><img class="mx-1" width="16" :src="`/assets/images/icons/check.png`"></div>
                        <div @click.stop="cancelEditChat(imagesList[mobileConvEditingIndex].id)" class="p-1"><img class="mx-1" width="10" :src="`/assets/images/icons/cancel.png`"></div>
                      </div>
                      <p v-else>{{ imagesList[mobileConvEditingIndex].title }}</p>
                    </div>
                    <div v-if="!chatEditInputId" class="left">
                      <div class="btn-conv btn-pin-chat btn-show-on-active px-2 mx-1" :class="imagesList[mobileConvEditingIndex].is_pinned == 0 ? 'no-pinned' : ''" @click.stop=" pinChat(imagesList[mobileConvEditingIndex].id)"><img width="16" :src="`/assets/images/icons/pin.png`"></div>
                      <div class="btn-conv btn-delete-chat btn-show-on-active px-2 mx-1" @click.stop="deleteChat(imagesList[mobileConvEditingIndex].id)"><img width="14" :src="`/assets/images/icons/delete.png`"></div>
                    </div>
                  </div>
                  <div @click="mobileCancelEditConv" class="mobile-close-editing"><img width="14" :src="`/assets/images/icons/cancel.png`"></div>
                </div>
              </div>
            </div>

            <div @click="hideOverlay" v-show="showLogoutAlert || showFirstLoginAlert || showMobileHistory || showFirstGuide" class="dark-overlay"></div>

            <!-- v-if="errorText == 'NOT_ENOUGH_TOKENS'" -->

              <div v-show="!showImages" class="textarea-container chatpage-message-input">
                <custom-scroll-bar :max-height="vh100" ref="customScrollbarnewImage">

                  <div class="text-center py-3 img-versions-box fa-num prevent-select d-flex flex-column">

                      <Carousel class="img-versions" :wrap-around="false" dir="rtl" :itemsToShow="1.99" :transition="200" v-model="currentVersion">
                          <Slide @click="currentVersion = 0" class="img-version-item shahrzad1" key="/assets/images/main/shahrzad.png" index="5">
                              <img class="shahrzad-img" width="240" height="240" :src="`/assets/images/main/shahrzad.png`">
                              <h6 class="title">شهرزاد 1</h6>
                          </Slide>
                          <Slide @click="currentVersion = 1" class="img-version-item shahrzad2" key="/assets/images/main/shahrzad-v2.png" index="7">
                              <img class="shahrzad-img" width="240" height="240" :src="`/assets/images/main/shahrzad-v2.png`">
                              <h6 class="title">شهرزاد 2</h6>
                          </Slide>
                      </Carousel>

                      <div v-if="currentVersion == 1" class="d-flex justify-content-center flex-wrap fa-num">
                        <div class="can-not-use-v2" :class="cantUseV2AlertStyle ? 'alert-style shake-alert' : ''" v-if="!canusev2">
                            برای استفاده از دستیار تصویری <b :class="cantUseV2AlertStyle ? '' : 'text-warning'">شهرزاد 2</b>، نیاز است که حداقل یک بار یکی از پکیج های رخشای را خریداری کرده باشید. <br> پس از خرید پکیج، سکه های هدیه شما به سکه های پکیج خریداری شده اضافه خواهد شد.
                            <div class="text-inner">
                                <a href="/plans" class="btn btn-success rounded-3 mt-4">خرید پکیج</a>
                            </div>
                        </div>
                    </div>

                  </div>

                  <div v-if="chatGotError && errorText == 'NOT_ENOUGH_TOKENS'" class="error-floating">
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div v-if="errorText == 'NOT_ENOUGH_TOKENS'" class="inner">
                      <button type="button" class="btn-close" @click="closeError"></button>
                      <strong class="prevent-select mx-3"> سکه های شما به اتمام رسیده و رخش برای تاختن به داریک نیاز دارد!</strong>

                      <a class="btn btn-sm btn-warning" href="/plans">خرید سکه</a>
                    </div>
                  </div>
                </div>

                <div v-if="chatGotError && errorText == 'INVALID_TITLE'" class="error-floating">
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div v-if="errorText == 'INVALID_TITLE'" class="inner">
                      <button type="button" class="btn-close" @click="closeError"></button>
                      <strong class="prevent-select mx-3">عنوان وارد شده نادرست است</strong>
                    </div>
                  </div>
                </div>

                <div v-if="chatGotError && (errorText == 'TRY_AGAIN' || errorText == 'ERR')" class="error-floating">
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div v-if="(errorText == 'TRY_AGAIN' || errorText == 'ERR')" class="inner">
                      <button type="button" class="btn-close" @click="closeError"></button>
                      <strong class="prevent-select mx-3">خطایی رخ داده! مجددا تلاش کنید.</strong>
                    </div>
                  </div>
                </div>

                <div v-if="chatGotError && (errorText == 'NOT_ALLOWED')" class="error-floating">
                  <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div v-if="(errorText == 'NOT_ALLOWED')" class="inner">
                      <button type="button" class="btn-close" @click="closeError"></button>
                      <strong class="prevent-select mx-3">متن درخواستی شما با قوانین ما مطابقت ندارد!</strong>
                    </div>
                  </div>
                </div>

                <div :style="{display : !showImages ? 'flex' : 'none' }" class="input-box">
                    <p class="price-text" v-if="currentVersion == 0">هر تصویر <b class="text-warning">1000</b> سکه</p>
                    <p class="price-text" v-if="currentVersion == 1 && imgSizeV2 == 'small'">هر تصویر <b class="text-warning">4000</b> سکه</p>
                    <p class="price-text" v-if="currentVersion == 1 && imgSizeV2 != 'small'">هر تصویر <b class="text-warning">8000</b> سکه</p>
                  <div class="inner">
                    <textarea placeholder="توضیحات تصویر را وارد کنید" ref="userMessage" v-model="userChatInput" id="message-input" rows="1" :class="userChatDir" :dir="userChatDir" :style="{textAlign: userChatDir == 'rtl' ? 'right' : 'left' , fontSize: fontSize + 'px' , fontWeight: fontWeight , paddingLeft : showChats ? '84px' : ''}"></textarea>
                    <button @click="!listeningNewConv ? generateImage() : null" id="send-button" :style="{ backgroundColor: this.selected_tone ? this.selected_tone.color : ''}"><img v-show="!showGenerating" width="24" :src="!lightMode ? `/assets/images/icons/paint.png` : `/assets/images/icons/paint-light.png`">
                      <div v-show="showGenerating" class="multi-ripple">
                        <div></div>
                        <div></div>
                      </div>
                    </button>
                  </div>
                  <div class="image-options">
                    <div class="prompts"><span class="item" v-for="(prompt, index) in customPrompt" :key="index">#{{ prompt }} </span></div>
                  </div>
                </div>

                <div v-if="showWelcome" class="tone-box img-setting-box">
                  <div class="inner">

                      <!-- <div class="image-type item item1 propmts">
                          <span class="d-block mb-2 title-cards">نوع تصویر:</span>

                          <div>
                              <input value="معمولی" type="radio" class="btn-check" v-model="customType" id="type-item1" autocomplete="off">
                              <label class="btn btn-outline-light" for="type-item1">معمولی</label>
                              <input value="پوستر" type="radio" class="btn-check" v-model="customType" id="type-item2" autocomplete="off">
                              <label class="btn btn-outline-light" for="type-item2">پوستر</label>
                              <input value="لوگو" type="radio" class="btn-check" v-model="customType" id="type-item3" autocomplete="off">
                              <label class="btn btn-outline-light" for="type-item3">لوگو</label>
                              <input value="آیکن" type="radio" class="btn-check" v-model="customType" id="type-item4" autocomplete="off">
                              <label class="btn btn-outline-light" for="type-item4">آیکن</label>
                              <input value="وکتور" type="radio" class="btn-check" v-model="customType" id="type-item5" autocomplete="off">
                              <label class="btn btn-outline-light" for="type-item5">وکتور</label>
                          </div>
                      </div> -->

                    <div class="item item1 propmts">
                      <span class="d-block mb-2 title-cards">
                        دستورات:
                        <VTooltip :triggers="['click', 'focus' , 'touch']" :autoHide="true">
                          <div class="btn-transparent-info"><img width="22" height="22" :src="`/assets/images/icons/info.png`"></div>

                          <template #popper>
                            <div class="info-popper">
                              <p class="info-popper-text">با افزودن دستورات، تصویری دقیق تر و نزدیک تر به خواسته خود بسازید.</p>
                            </div>
                          </template>
                        </VTooltip>
                      </span>
                      <div>
                        <input value="با جزئیات زیاد" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item1" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item1">#با جزئیات زیاد</label>
                        <input value="کارتونی" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item2" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item2">#کارتونی</label>
                        <input value="واقعی" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item3" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item3">#واقعی</label>
                        <input value="فانتزی" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item4" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item4">#فانتزی</label>
                        <input value="نورپردازی سینمایی" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item5" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item5">#نورپردازی سینمایی</label>
                        <input value="هایپررئالیسم" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item6" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item6">#هایپررئالیسم</label>
                        <input value="نقاشی کودکانه" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item7" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item7">#نقاشی کودکانه</label>
                        <input value="نور استدیو" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item8" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item8">#نور استدیو</label>
                        <!-- <input value="قدیمی" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item9" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item9">#قدیمی</label> -->
                        <input value="حداکثر وضوح" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item10" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item10">#حداکثر وضوح</label>
                        <!-- <input value="قاب کامل" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item11" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item11">#قاب کامل</label> -->
                        <input value="نورپردازی گرم" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item12" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item12">#نورپردازی گرم</label>
                        <input value="عکاسی با پهپاد" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item13" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item13">#عکاسی با پهپاد</label>
                        <input value="طراحی کاراکتر" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item14" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item14">#طراحی کاراکتر</label>
                        <!-- <input value="نئون" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item15" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item15">#نئون</label> -->
                        <input value="4K" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item16" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item16">#4K</label>
                        <input value="8K" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item16-2" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item16-2">#8K</label>
                        <input value="فوکوس تند" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item17" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item17">#فوکوس تند</label>
                        <!-- <input value="عمق میدان کم" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item18" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item18">#عمق میدان کم</label> -->
                        <input value="طرح مداد" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item19" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item19">#طرح مداد</label>
                        <input value="نقاشی دیجیتال" type="checkbox" class="btn-check" v-model="customPrompt" id="propmt-item20" autocomplete="off">
                        <label class="btn btn-outline-light" for="propmt-item20">#نقاشی دیجیتال</label>
                      </div>
                    </div>

                    <div class="item item1 size-count">
                      <div v-if="currentVersion == 0" class="mx-2 column">
                        <span class="d-block mb-2 title-cards">تعداد:</span>
                        <div class="count-input">
                          <div class="value-button" id="decrease" @click="decreaseValue" value="Decrease Value">-</div>
                          <input readonly type="number" id="number" v-model="imgCount" />
                          <div class="value-button" id="increase" @click="increaseValue" value="Increase Value">+</div>
                        </div>
                      </div>
                      <div class="mx-2 column">
                        <span class="d-block mb-2 title-cards">اندازه:</span>
                        <div v-if="currentVersion == 0" class="">
                          <input value="small" type="radio" class="btn-check" v-model="imgSizeV1" id="size-item1" autocomplete="off">
                          <label class="btn btn-outline-light" for="size-item1">256X256</label>
                          <input value="medium" type="radio" class="btn-check" v-model="imgSizeV1" id="size-item2" autocomplete="off">
                          <label class="btn btn-outline-light" for="size-item2">512X512</label>
                          <input value="large" type="radio" class="btn-check" v-model="imgSizeV1" id="size-item3" autocomplete="off">
                          <label class="btn btn-outline-light" for="size-item3">1024X1024</label>
                        </div>
                        <div v-if="currentVersion == 1" class="">
                          <input value="medium" type="radio" class="btn-check" v-model="imgSizeV2" id="size-item2" autocomplete="off">
                          <label class="btn btn-outline-light" for="size-item2">1024X1792 <span class="d-block">۸۰۰۰ سکه</span></label>
                          <input value="large" type="radio" class="btn-check" v-model="imgSizeV2" id="size-item3" autocomplete="off">
                          <label class="btn btn-outline-light" for="size-item3">1792X1024 <span class="d-block">۸۰۰۰ سکه</span></label>
                          <input value="small" type="radio" class="btn-check" v-model="imgSizeV2" id="size-item1" autocomplete="off">
                          <label class="btn btn-outline-light" for="size-item1">1024X1024 <span class="d-block">۴۰۰۰ سکه</span></label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="w-100 rakhsh-info fa-num"><p>رخشای نسخه شهرزاد</p></div>
                  <div class="w-100 rakhsh-info2"><p>Shahrzad Engine, Training By stability.ai and DALL·E 2</p></div>
                </div>

                <div v-if="showGenerating" class="generating">
                  <div class="animation-inner">
                    <Vue3Lottie :animationData="animations[Math.floor(Math.random() * animations.length)]" :speed=".5" :autoplay="false" />
                  </div>
                  <p>تصویر شما در حال آماده سازی است
                    <div class="dots-animation">
                      <div class="dots">
                        <div class="dot dot-1"></div>
                        <div class="dot dot-2"></div>
                        <div class="dot dot-3"></div>
                      </div>
                    </div>
                  </p>
                </div>
              </custom-scroll-bar>
              </div>
            </div>

        </div>
      </div>
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


</style>
