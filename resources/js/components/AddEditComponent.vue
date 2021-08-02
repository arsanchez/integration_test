<template>
    <div class="container">

        <div class="row justify-content-center">
                <p v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                    <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </p>
            <form class="form" ref="propertyForm">
                <div class="form-group col-md-12">
                    <label>Email</label>
                    <input type="text" class="form-control"  placeholder="Email" v-model="subscriber.email">
                </div>
                <div class="form-group col-md-12">
                    <label>Name</label>
                    <input type="text" class="form-control"  placeholder="name" v-model="subscriber.name">
                </div>
                <div class="form-group col-md-12">
                    <label>Country</label>
                    <input type="text" class="form-control" placeholder="country" v-model="subscriber.country">
                </div>

                <a class="btn btn-success col-md-3 bottom-row" v-on:click="save()" href="#">Save</a>
                <a class="btn btn-danger col-md-3 bottom-row" v-on:click="cancel()" href="#">Cancel</a>
            </form>
        </div>
    </div>
</template>

<script>


    export default {
        props: {
            subscriber: []
        },
        data() {
            return {
                errors: []
            };
        },
        mounted() {
        },
        methods: {
            save() {
                if (this.validate()) {

                    //  Posting the data
                    let id = (this.subscriber.id !== undefined) ? this.subscriber.id : 0;
                    let succes_message = (this.subscriber.id !== undefined) ? 'Subscriber updated successfully': 'Subscriber added successfully';
                    axios.post( '/save/',{email: this.subscriber.email, name: this.subscriber.name, country: this.subscriber.country}).then(() =>{
                            this.$swal.fire({
                                icon: 'success',
                                title: succes_message,
                            }).then(() => {
                                window.location.href = '/';
                            });
                        })
                    .catch((err) => {
                        let errors = Object.values(err.response.data.errors).join(",");
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errors
                        });
                    });
                }
            },
            validate: function () {
                this.errors = [];

                if (!this.subscriber.email) {
                    this.errors.push("Email is required.");
                } else if (!this.validEmail(this.subscriber.email)) {
                    this.errors.push('Valid email required.');
                }

                if (!this.subscriber.name) {
                    this.errors.push("Name is required.");
                }

                if (!this.subscriber.country) {
                    this.errors.push("Country is required.");
                }


                if (!this.errors.length) {
                    return true;
                }

                return false;
            },
            validEmail: function (email) {
                var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            cancel() {
                window.location.href = '/';
            }
        }
    }
</script>
