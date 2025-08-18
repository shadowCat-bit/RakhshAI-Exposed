<template>


    <div class="container py-5">
      <div class="text-center"><h1 class="page-title">عکس های ساخته شده با هوش مصنوعی شهرزاد</h1></div>
      <!-- <div class="row d-flex justify-content-center">
        <div class="col-12">
          <div>
            <div class="search">

            </div>
          </div>
        </div>
      </div> -->
      <div class="row">
        <div class="col-md-12">
          <masonry-wall :items="image_data.data" :ssr-columns="1" :column-width="columnWidth" :gap="gap">
            <template #default="{ item, index }">
              <div>
                <a :href="'http://rakhshai.com/explore/image/' + item.uuid" class="img-item" :class="'v-' + item.version">
                  <div class="img-inner" :class="'items-' + item.img.length">
                    <img v-for="(img, index_) in item.img" :key="index_" class="img-fluid" :src="img.thumbnail" data-imgs="" :alt="item.title">

                      <div class="overlay-effect">
                          <div class="top-row">
                              <!--                      <button v-tooltip="'پیش نمایش'" @click.stop="previewImages(item.img)" class="btn btn-float btn-light"><img width="20" :src="`/assets/images/icons/preview.png`"></button>-->
                          </div>
                      </div>
                  </div>
                  <div class="info">
                    <h2 class="title">{{item.title}}</h2>
                    <span class="badge rounded-pill item-label">شهرزاد {{item.version}}</span>
                    <!-- <div class="creator">
                      <img class="img-profile" :src="`/assets/images/main/user.jpg`">
                      <span class="name"></span>
                  </div> -->
                  </div>
                </a>
              </div>
            </template>
          </masonry-wall>
        </div>
      </div>
      </div>

</template>

<style>

</style>

  <script>

import MasonryWall from '@yeger/vue-masonry-wall';

import { defineComponent } from 'vue'
  import 'viewerjs/dist/viewer.css'
  import { api as viewerApi , component as Viewer } from "v-viewer"

  export default {
    name: "explore",
    components: {
      MasonryWall,
      Viewer
        },
        props : ['image_data'],
    mounted() {
        document.getElementById("loading-explore-vue").style.display = "none";
        document.getElementById("explore-paginate").style.display = "block";

        this.updateDeviceWidth();

        window.addEventListener('resize', this.updateDeviceWidth);
    },
    beforeDestroy() {
      window.removeEventListener('resize', this.updateDeviceWidth);
    },
    destroyed() {

    },
    data() {
      return {
        showingImages: [],
        columnWidth: 240,
        gap:20
      }
    },
    methods: {
      previewImages(images){
        this.showingImages = images;
        this.previewImgObject();
      },
      previewImgObject () {
        // Or you can just import the api method and call it.
        const $viewer = viewerApi({
          options: {
            toolbar: true,
            transition:false,
            url: 'original',
            initialViewIndex: 0
          },
          images: this.showingImages
        })
      },
      goToSingleImagePage(uuid){
        window.location.href = 'explore/image/' + uuid
      },
      updateDeviceWidth() {
        // this.deviceWidth = window.innerWidth;
        if(window.innerWidth < 575){
          this.columnWidth = 120;
          this.gap = 12;
        } else {
          this.columnWidth = 240;
          this.gap = 20;
        }
      }
    },
  };
  </script>

<!-- {{route('packages.purchase', $tokenPackage)}} -->
