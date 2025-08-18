<template>
    <div class="container py-5">
      <!-- <div class="text-center"><h1 class="page-title my-4">تصاویر تولید شده با هوش مصنوعی شهرزاد</h1></div> -->
      <div class="main-image" :class="'v-' + images.version">
        <div class="row d-flex justify-content-center">
          <div class="col-12" :class="images.size == 'medium' && images.version == 2 ? 'col-md-5' : 'col-md-6'">
            <div class="images-inner">

              <Carousel id="gallery" :items-to-show="1" :wrap-around="false" v-model="currentSlide" dir="rtl">
                <Slide v-for="(slide , index) in images.img" :key="index">
                  <div class="carousel__item_single" @click="previewImgObject(index)">
                    <img :src="slide.original" :alt="images.title">
                  </div>
                </Slide>
              </Carousel>

              <div class="thumb-images">
                <div v-for="(slide, index) in images.img" :key="index" @click="slideTo(index)" class="thumb-item"><img :src="slide.thumbnail"></div>
              </div>

            </div>
          </div>

          <div class="col-12 info-side" :class="images.size == 'medium' && images.version == 2 ? 'col-md-7' : 'col-md-6'">
              <div class="badge rounded-pill version-label">شهرزاد {{images.version}}</div>
            <div class="info">
              <div class="info-head">
                <a :href="images.img[currentSlide].original" download v-tooltip="'دانلود'" class="btn btn-secondary"><img width="14" :src="`/assets/images/icons/download-light.svg`" alt="download icon"></a>
                <VMenu :triggers="['hover', 'focus']" class="vmenu-button" :placement="'top'">
                  <button class="btn btn-secondary mx-1"><img width="14" :src="`/assets/images/icons/share-light.svg`" alt="share icon"></button>

                  <template #popper>
                    <ul class="share-socials">
                      <li><button @click="shareToSocials('linkedin')" class="btn btn-light"><img width="22" :src="`/assets/images/icons/linkedin.svg`" alt="linkedin share icon"></button></li>
                      <li><button @click="shareToSocials('twitter')" class="btn btn-light"><img width="22" :src="`/assets/images/icons/twitter.svg`" alt="twitter share icon"></button></li>
                      <li><button @click="shareToSocials('whatsapp')" class="btn btn-light"><img width="22" :src="`/assets/images/icons/whatsapp.svg`" alt="whatsapp share icon"></button></li>
                      <li><button @click="shareToSocials('telegram')" class="btn btn-light"><img width="22" :src="`/assets/images/icons/telegram.svg`" alt="telegram share icon"></button></li>
                      <li><button @click="shareToSocials('pinterest')" class="btn btn-light"><img width="22" :src="`/assets/images/icons/pinterest.svg`" alt="pinterest share icon"></button></li>
                    </ul>
                  </template>
                </VMenu>
                <button @click="copyText('https://rakhshai.com/explore/image/' + images.uuid + '?item=' + currentSlide , 'link')" v-tooltip="'کپی لینک'" class="btn btn-secondary" :class="this.linkCopied ? 'copied' : ''"><img alt="copy link icon" width="14" :src="!linkCopied ? `/assets/images/icons/attachment-light.svg` : `/assets/images/icons/check.png`"></button>
              </div>
                <div class="title-inner">
                  <h1 class="title">{{ images.title }}</h1>
                  <button @click="copyText(images.title , 'title')" class="btn btn-sm mx-1" :class="titleCopied ? 'btn-success' : 'btn-dark'"><img width="14" :src="`/assets/images/icons/copy.png`" alt="copy icon"></button>
                </div>
                <ul class="prompts">
                  <li v-for="(prompt, index) in images.prompt" :key="index">#{{ prompt }}</li>
                </ul>
                <div class="creator">
                  <img class="img-profile" :src="`/assets/images/main/user.jpg`" alt="user avatar icon">
                  <span class="name">{{ images.user.name }}
                    <VTooltip v-if="images.user_id == 1008" :triggers="['click', 'focus' , 'touch' , 'hover']" :autoHide="true">
                          <div class="btn-transparent-info"><img width="20" :src="`/assets/images/icons/verified-gold.svg`"></div>

                          <template #popper>
                            <div class="info-popper">
                              <p class="info-popper-text">حساب رسمی</p>
                            </div>
                          </template>
                        </VTooltip>
                  </span>
                </div>
                <div class="details">
<!--                  <div class="item">-->
<!--                    <span>{{ images.size == 'large' ? '1024' : (images.size == 'medium' ? '512' : '256') }}</span> <span class="mx-1">x</span> <span>{{ images.size == 'large' ? '1024' : (images.size == 'medium' ? '512' : '256') }}</span><img alt="size icon" width="18" :src="`/assets/images/icons/size.svg`">-->
<!--                  </div>-->
                  <!-- <div class="item">
                    <time datetime="2008-02-14 20:00">{{ images.created_at }}</time>
                    <img width="18" :src="`/assets/images/icons/date.svg`">
                  </div> -->
                </div>
              </div>
              <div><h2 class="title-label">عکس ساخته شده با هوش مصنوعی شهرزاد</h2>
<!--                  - <span>کپی رایت برای عموم آزاد است.</span>-->
              </div>
          </div>

        </div>
      </div>

      <div class="row user-images">
        <div class="user-images-head">
          <h3 class="title">تصاویر دیگر {{ images.user.name }} </h3>
        </div>
        <div class="col-md-12 user-images-list" @scroll="checkScroll">
          <masonry-wall :items="userImages" :ssr-columns="1" :column-width="columnWidth" :gap="gap">
            <template #default="{ item, index }">
              <div>
                <a :href="'http://rakhshai.com/explore/image/' + item.uuid" class="img-item" :class="'v-' + item.version">
                  <div class="img-inner" :class="'items-' + item.img.length">
                    <img v-for="(img, index_) in item.img" :key="index_" class="img-fluid" :src="img.thumbnail" data-imgs="" :alt="item.title">

                      <div class="overlay-effect">
                          <div class="top-row">
                              <!--                      <button @click.stop="previewImages(item.img)" v-tooltip="'پیش نمایش'" class="btn btn-light btn-float"><img width="20" :src="`/assets/images/icons/preview.png`" alt="preview"></button>-->
                          </div>
                      </div>
                  </div>
                  <div class="info">
                    <h4 class="title">{{item.title}}</h4>
                      <span class="badge rounded-pill item-label">شهرزاد {{item.version}}</span>
                  </div>
                </a>
              </div>
            </template>
          </masonry-wall>
          <div v-if="loading" class="text-center"><div class="loader-circule"></div></div>


        </div>

      </div>

      </div>

</template>

<style>

</style>

  <script>
  import MasonryWall from '@yeger/vue-masonry-wall';
  import 'viewerjs/dist/viewer.css'
  import { api as viewerApi , component as Viewer } from "v-viewer"
  import { defineComponent } from 'vue'
  import { Carousel, Slide } from 'vue3-carousel'
  import 'vue3-carousel/dist/carousel.css'
  import 'floating-vue/dist/style.css'

  export default {
    name: "explore",
    components: {
      MasonryWall,
      Viewer,
      Carousel,
      Slide,
        },
    props : ['images'],
    beforeMount() {
      var match = window.location.href.match(/[?&]item=([^&]+)/);
      var itemValue = match ? match[1] : null;
      if(itemValue){
        this.currentSlide = itemValue;
      } else {
        this.currentSlide = 0;
      }
    },
    mounted() {
      window.addEventListener('scroll', this.checkScroll);
      axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      // this.nextPageUrl = this.user_images.next_page_url;
      // this.userImages = this.user_images;
      this.lastPageUrl = document.referrer;
      window.onpopstate = this.handleBackButton;

      this.getFirstPage();

      this.updateDeviceWidth();

      window.addEventListener('resize', this.updateDeviceWidth);
    },
    beforeDestroy() {
      window.removeEventListener('scroll', this.checkScroll);

      window.removeEventListener('resize', this.updateDeviceWidth);
    },
    destroyed() {

    },
    data() {
      return {
        currentSlide: '',
        userImagesPreview: [],
        userImages: [],
        loading: true,
        nextPageUrl: '',
        currentPage: 1,
        linkCopied: false,
        titleCopied:false,
        columnWidth: 240,
        gap:10
      }
    },
    methods: {
      previewImgObject (index) {
        // Or you can just import the api method and call it.
        const $viewer = viewerApi({
          options: {
            toolbar: true,
            url: 'original',
            initialViewIndex: index
          },
          images: this.images.img
        })
      },
      slideTo(val) {
        this.currentSlide = val;
        this.addParameterTourl(val);
      },
      previewImages(images){
        this.userImagesPreview = images;
        this.previewUserImages();
      },
      previewUserImages () {
        // Or you can just import the api method and call it.
        const $viewer = viewerApi({
          options: {
            toolbar: true,
            transition:false,
            url: 'original',
            initialViewIndex: 0
          },
          images: this.userImagesPreview
        })
      },
      checkScroll() {
        const container = document.querySelector('.user-images-list');
        const scrollPosition = window.innerHeight + window.pageYOffset;
        const containerHeight = container.offsetHeight;

        if (scrollPosition >= containerHeight && !this.loading) {
          if(this.nextPageUrl){
            console.log('bottom of page')
            this.loading = true;
            this.getNewPageData();
          }
        }
      },
      getFirstPage(){
        axios
        .get('/explore/image/other-images?uuid=' + this.images.uuid)
        .then(response => {
          if(response){
            this.nextPageUrl = response.data.other_imgs.next_page_url;
            this.userImages = response.data.other_imgs.data;
            this.loading = false;
          }
        })
        .catch(error => {
          this.loading = false;
        })
        .finally()
      },
      getNewPageData(){
        axios
        .get(this.nextPageUrl + '&uuid=' + this.images.uuid)
        .then(response => {
          if(response){
            console.log('response')
            console.log(response)
            this.nextPageUrl = response.data.other_imgs.next_page_url;
            this.userImages = [...this.userImages, ...response.data.other_imgs.data];
            this.loading = false;
          }
        })
        .catch(error => {
          this.loading = false;
        })
        .finally()
      },
      goToSingleImagePage(uuid){
        var url = window.location.href;
        var domain = url.split('/')[2];
        var newUrl = '/explore/image/' + uuid;
        window.location.href = newUrl;
      },
      shareToSocials(social){
        const imageUrl = this.images.img[this.currentSlide].original;
        const shareText = this.images.title;
        let shareUrl = '';
        if(social == 'instagram'){
          shareUrl = `https://www.instagram.com/sharer.php?u=${encodeURIComponent(imageUrl)}`;
        }
        if(social == 'telegram'){
          shareUrl = 'https://telegram.me/share/url?url=' + encodeURIComponent(imageUrl) + '&text=' + encodeURIComponent(shareText);
        }
        if(social == 'whatsapp'){
          shareUrl = 'https://web.whatsapp.com/send?text=' + encodeURIComponent(shareText + ' ' + imageUrl);
        }
        if(social == 'twitter'){
          shareUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(shareText)}&url=${encodeURIComponent(imageUrl)}`;
        }
        if(social == 'linkedin'){
          shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(imageUrl)}&title=${encodeURIComponent(shareText)}`;
        }
        window.open(shareUrl, '_blank');
      },
      addParameterTourl(value){
        var currentURL = window.location.href;

        var updatedURL = new URL(currentURL);
        updatedURL.searchParams.set("item", value);

        window.history.pushState(null, "", updatedURL);
      },

      copyText(link , type){
        const temp_textarea = document.createElement('textarea');
        temp_textarea.value = link;
        temp_textarea.style.position = 'fixed';
        document.body.appendChild(temp_textarea);
        temp_textarea.focus();
        temp_textarea.select();

        try {
          const successful = document.execCommand('copy');
          if(type == 'link'){
            this.linkCopied = true;
            setTimeout(()=>{
              this.linkCopied = false;
            },2000)
          } else if(type == 'title'){
            this.titleCopied = true;
            setTimeout(()=>{
              this.titleCopied = false;
            },2000)
          }

        } catch (error) {
        }

        document.body.removeChild(temp_textarea);
      },

      handleBackButton() {
        window.location.href = this.lastPageUrl;
      },
      updateDeviceWidth() {
        // this.deviceWidth = window.innerWidth;
        if(window.innerWidth < 575){
          this.columnWidth = 120;
          this.gap = 6;
        } else {
          this.columnWidth = 240;
          this.gap = 10;
        }
      }
    },
  };
  </script>

<!-- {{route('packages.purchase', $tokenPackage)}} -->
