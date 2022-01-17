<template>

    <iframe
            id="show-iframe"
            name="showHere"
            style="width:98%;"
            :src="path">
      <!-- "> -->
    </iframe>
</template>

<script>
  export default{
    data(){
      return{
        path:this.$root.URL,
      }
    }
  }
</script>

<style lang="less" scoped>
  @media screen and (max-width: 1920px) {
      iframe{
        height: 100%;
        max-height: 550px;
        position: relative;

      }
  }

 @media screen and (min-width: 1920px) {
      iframe{
        height: 80%;
        // max-height: 750px;
        position: relative;

      }
  }
</style>
