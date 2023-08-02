<template>
    <div class="d-flex align-items-center justify-content-between pe-5">
        <h5>{{ title }}</h5>
        <slot name="button"></slot>
    </div>
    <hr>
</template>
<script>

    
    export default {
      name: 'PageTitle',
      props: {
        title: String,
      },
      data() {
        return {
          
        };
      },
      
    }
</script>
<style lang="scss">
    .main h5 {
        font-size: 20px;
        font-weight: bold;
        text-align: start;
        margin: 10px 30px;
    }
@media screen and (min-width: 1500px){
    .main h5 {
        font-size: 28px;
    }
}
 
</style>