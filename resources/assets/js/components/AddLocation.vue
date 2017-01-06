<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add new business location
                        <router-link :to="'/'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-chevron-left"></i> Back </router-link>

                        <router-link :to="'add'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Add new </router-link>

                    </div>

                    <div class="panel-body">
                <form method="post"  @submit.prevent="add">
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 col-xs-12 location-details">
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



                            <div class="col-sm-offset-6 col-sm-6">

                                <button  :disabled="errors.any()" class="btn btn-sm btn-primary pull-right add-button" >Add location</button>

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
    export default {



        data: function () {
            return {
                location:{
                    name:'',
                    address_1:'',
                    address_2:'',
                    postal_code:'',
                    pictures:[]

                }
            }
        },
        methods: {

            add:function () {



                this.$validator.validateAll().then(success => {
                    if (! success) {
                        // handle error
                        return;
                    }


                    this.$http.post('business-locations',{location:this.location}).then((response) => {

                        this.$router.push('/edit/'+response.data.id);

                        console.log(response);


                    }, (response) => {

                        alert(response.error);

                    });



                });

            }

        }

    }
</script>
