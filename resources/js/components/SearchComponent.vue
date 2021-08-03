<template>
    <div class="row">
        <div class="col-6 bottom-row">
            <button v-on:click="addSubscriber()" class="btn btn-success">Add subscriber</button>
        </div>
        <div class="col-12 bottom-row scrollable" @click="handleClick">
            <table class="table" id ="subscribers_table">
                <thead>
                    <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">Subscribe date</th>
                    <th scope="col">Subscribe time</th>
                    <th scope="col">id</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>


export default {
    mounted() {
        this.table = $('#subscribers_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/search",
            "searchDelay": 1000,
            "columnDefs": [
                {"render": function ( data, type, row ) {
                    return '<a href="/add-edit/'+row[5]+'" >' + row[0] + '</a>';
                }, "data": null, "targets": [0]},
                {"render": function ( data, type, row ) {
                    return '<button type="button"  data-id="'+ row[5] +'"  class="btn btn-danger btn-xs delete-btn">Delete</button>';
                }, "data": null, "targets": [6]},
                {
                    "targets": [5],
                    "visible": false
                }
            ]
        });
    },
    props: {
    },
    data() {
        return {
            table: 1
        };
    },
    methods: {
        handleClick(e) {
            if (e.target.matches('.delete-btn')) {
                this.deleteSubscriber(e.target.dataset.id);
            }
        },
        deleteSubscriber(subscriber_id) {
            axios.get('/delete/' + subscriber_id)
                    .then(response =>  {
                        if (response.data.error !== undefined) {
                            this.$swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: response.data.error.message
                            });
                        } else {
                            this.table.ajax.reload();
                        }
                    })
                    .catch(error => {});
        },
        editSubscriber(subscriber_id) {
            // window.location.href = '/add-edit?id=' + subscriber.id;
        },
        addSubscriber() {
            window.location.href = '/add-edit/0';
        }
    }
}
</script>
