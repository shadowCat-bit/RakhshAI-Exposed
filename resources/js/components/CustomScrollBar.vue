<template>
  <div :id="customId" class="custom-scrollbar" ref="scrollContainer" :style="{ maxHeight: maxHeight }">
    <div class="scroll-content" ref="scrollContent">
      <slot></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: "CustomScrollBar",
  props: {
    maxHeight: {
      type: String,
      default: "400px",
    },
    customId: ''
  },
  mounted() {
    this.$refs.scrollContainer.addEventListener("scroll", this.handleScroll);
  },
  destroyed() {
    this.$refs.scrollContainer.removeEventListener(
      "scroll",
      this.handleScroll
    );
  },
  methods: {
    handleScroll() {
      const scrollContainer = this.$refs.scrollContainer;
      const scrollContent = this.$refs.scrollContent;

      if (
        scrollContainer.scrollTop + scrollContainer.clientHeight >=
        scrollContent.clientHeight
      ) {
        // reached bottom
        this.$emit("reachedBottom");
      }

      // set scrolling state to true
      this.scrolling = true;

      // debounce scrolling state to false
      clearTimeout(this.debounceTimeout);
      this.debounceTimeout = setTimeout(() => {
        this.scrolling = false;
      }, 200);
    },
    scrollToBottom() {
      const scrollContainer = this.$refs.scrollContainer;
      scrollContainer.scrollTop = scrollContainer.scrollHeight;
    },
    isAtBottom() {
      const scrollContainer = this.$refs.scrollContainer;
      const scrollContent = this.$refs.scrollContent;
      
      return (scrollContainer.scrollTop + scrollContainer.clientHeight) >= scrollContent.clientHeight + 50;
    },
    isScrolling() {
      return this.scrolling;
    },
  },
};
</script>

<style scoped>
.custom-scrollbar {
  overflow-y: auto;
  overflow-x: hidden;
  position: relative;
}

.custom-scrollbar::-webkit-scrollbar {
  width: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #010202;
  border-radius: 10px;
}

.scroll-content {
  
}
</style>