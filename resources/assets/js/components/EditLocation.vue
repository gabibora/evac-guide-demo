<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit business location
                        <router-link :to="'/'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-chevron-left"></i> Back </router-link>

                        <router-link :to="'/add'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Add new </router-link>

                    </div>

                    <div class="panel-body">
                        <form method="post"  @submit.prevent="update" v-show="ready">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 location-details">
                                    <h4>Locations details </h4>

                                    <div  :class="{'has-error': errors.has('location.name')}" >
                                        <label>Location Name</label>
                                        <input class="form-control" type="text"  v-model="location.name"
                                               v-validate.initial="location.name" data-vv-rules="required" >

                                        <span v-show="errors.has('location.name')" class="help is-danger">The location name is required</span>

                                    </div>

                                    <div :class="{'has-error': errors.has('location.address_1')}"  >
                                        <label>Address 1</label>
                                        <input class="form-control" type="text"   v-model="location.address_1" v-validate.initial="location.address_1" data-vv-rules="required" >
                                        <span v-show="errors.has('location.address_1')" class="help is-danger">The main address is required</span>

                                    </div>


                                    <div class="form-group">
                                        <label>Address 2</label>
                                        <input class="form-control" type="text"  v-model="location.address_2" >

                                    </div>

                                    <div :class="{'has-error': errors.has('location.postal_code')}">
                                        <label>Postal code</label>
                                        <input class="form-control" type="text" v-model="location.postal_code"  v-validate.initial="location.postal_code" data-vv-rules="required"  >
                                        <span v-show="errors.has('location.address_1')" class="help is-danger">Postal code is required</span>

                                    </div>




                                </div>

                                <div class="col-sm-6 col-xs-12">
                                    <h4>Current Images </h4>

                                    <div >

                                        <div class="row preview_wrapper">
                                        <div class="col-xs-6 col-md-4 " v-for="thumb in location.thumb">
                                            <a href="#" class="thumbnail" v-bind:data-featherlight="thumb.srcURL">
                                                <img :src="thumb.thumbURL" alt="">
                                            </a>
                                        </div>

                                    </div>



                                    </div>



                                </div>


                                <div class="col-sm-12 col-md-12 col-xs-12">
                                    <h4>Add Location Images </h4>
                                    <p>Update after the upload is ready</p>

                                    <dropzone

                                            v-on:vdropzone-success="success"
                                            id="imagedropsss" url="/api/upload"

                                              v-bind:dropzone-options="doropZoneConfig"
                                              v-bind:use-custom-dropzone-options="true"

                                    ></dropzone>



                                </div>
                                <div class="col-sm-offset-6 col-sm-6">

                                    <button  :disabled="errors.any()" class="btn btn-sm btn-primary pull-right add-button" >Update location</button>

                                </div>

                            </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Dropzone from 'vue2-dropzone';

    export default {

        data: function () {
            return {
                ready:false,
                location:{
                    name:'',
                    address_1:'',
                    address_2:'',
                    postal_code:'',
                    pictures:[],
                    thumb:[]

                },
                doropZoneConfig:{

                    showRemoveLink:false,
                    headers: {'X-CSRF-TOKEN': Laravel.csrfToken}
                }
            }
        },
        created: function () {

            this.getLocationData();
        },
        components:{
        Dropzone
                  },

        methods: {

            success:function (file, response) {

            this.location.pictures.push(response.image);
                console.log(this.location.pictures);


            },



            getLocationData:function () {

                this.$http.get('business-locations/'+this.$route.params.id).then((response) => {

                    this.location=response.data.location;

                    if(!this.location.pictures){

                        this.location.pictures=[];
                    }

                    this.ready=true;

                    console.log(response);

                }, (response) => {

                    this.$router.push('/');

                });

            },

            update:function () {

                this.$validator.validateAll().then(success => {
                    if (! success) {
                        // handle error
                        return;
                    }


                    this.$http.put('business-locations',{location:this.location}).then((response) => {

                        console.log(response);

                        alert('Update was successful');
                        this.getLocationData();


                    }, (response) => {

                        alert(response.error);

                    });



                });

            }

        }

    }
</script>
