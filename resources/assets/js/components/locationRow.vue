<template>
 <div class="row location-wrapper">

     <div class="col-sm-1 col-xs-2">

       <span> {{location.id}}</span>
         <router-link :to="'edit/'+location.id" class="btn btn-xs btn-success"> Edit </router-link>

     </div>

     <div class="col-sm-4 col-xs-10">
         <h5><strong>Location details</strong></h5>
         <p>

     {{location.name}}, {{location.address_1}}, {{location.address_2}}, {{location.postal_code}}

         </p>
     </div>

     <div class="col-sm-6 col-xs-12 preview_wrapper">
         <h5><strong>Location pictures</strong></h5>
          <div v-if="location.thumb" v-for="thumb in location.thumb" class="">

              <a  href="# " class="thumbnail" v-bind:data-featherlight="thumb.srcURL">
                  <img :src="thumb.thumbURL" class="img-fluid" >
              </a>


          </div>

     </div>

</div>
</template>


<script>
    export default {

        props:['location'],
        data:  function() {
            return {
                ready:false,

            }
        },

        methods: {



        }


    }
</script>