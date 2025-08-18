import './bootstrap';

import { createApp } from 'vue/dist/vue.esm-bundler';
import Chat from './components/Chat.vue';
import Image from './components/Image.vue';
import Profile from './components/Profile.vue';
import PublicChat from './components/PublicChat.vue';
import CustomScrollBar from './components/CustomScrollBar.vue';
import Explore from './components/Explore.vue';
import SingleImage from './components/SingleImage.vue';
import HomeProfile from './components/sections/HomeProfile.vue';
import FloatingVue from 'floating-vue';
import { MotionPlugin } from '@vueuse/motion';
import CooddeVue3Tour from 'coodde-vue3-tour';
import 'coodde-vue3-tour/dist/vue3-tour.css';

const app = createApp({});
app.component('chat-component' , Chat);
app.component('image-component' , Image);
app.component('profile-component' , Profile);
app.component('public-chat-component' , PublicChat);
app.component('custom-scroll-bar', CustomScrollBar);
app.component('explore-component', Explore);
app.component('single-image-component', SingleImage);
app.component('home-profile-component', HomeProfile);
app.use(FloatingVue);
app.use(MotionPlugin)
app.use(CooddeVue3Tour)

app.mount('#app');
