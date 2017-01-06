<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Business locations

                        <router-link :to="'add'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Add </router-link>

                    </div>

                    <div class="panel-body">


                        <div  v-for="location in locations">

                            <location v-bind:location="location"></location>

                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    import Location from './locationRow.vue';


    export default {

        created: function() {

            this.fetchLocations();

        },
        data:  function() {
            return {
                ready:false,
                locations:[]
            }
        },
        components:{

            Location
        },
        methods: {

            fetchLocations:function () {

                this.$http.get('business-locations').then((response) => {

                    this.locations=response.data.locations;
                    console.log(response);
                    this.ready=true;



                }, (response) => {



                });




            }

        }

    }
</script>
