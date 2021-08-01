<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Please provide your mailerlite API key</div>

                    <div class="card-body">
                        <p v-if="errors.length">
                            <b>Please correct the following error(s):</b>
                            <ul>
                            <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </p>
                        <form class="form" ref="propertyForm"> 
                            <div class="form-group v">
                                <input type="text" class="form-control" placeholder="API key" v-model="api_key">
                            </div>
                        
                            <a class="btn btn-success col-md-3 bottom-row" v-on:click="save()" href="#">Save</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            api_key: String,
        },
         data() {
            return {
                errors: []
            };
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
             save() {
                if (this.validate()) {

                    //  Posting the data 
                    axios.post( '/add_key/',{api_key:this.api_key} ).then(function(){
                            window.location.href = '/';
                        })
                        .catch((err) => {
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: err.response.data.message
                            });
                        });
                    }
            },
            validate: function () {
                this.errors = [];

                if (!this.api_key) {
                    this.errors.push("The API key is required.");
                }

                if (!this.errors.length) {
                    return true;
                }

                return false;
            },
        }
    }
</script>
