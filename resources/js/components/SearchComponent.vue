<template>
    <div class="row">
        <div class="col-6 bottom-row">
            <button v-on:click="addSubscriber()" class="btn btn-success">Add subscriber</button>
        </div>
        <div class="col-12 bottom-row scrollable">
            <table class="table" id ="subscribers_table">
                <thead>
                    <tr>
                    <th scope="col">Email</th>
                    <th scope="col">Name</th>
                    <th scope="col">Country</th>
                    <th scope="col">Subscribe date</th>
                    <th scope="col">Subscribe time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="subscriber in subscribers">
                        <td>{{ subscriber.email }}</td>
                        <td>{{ subscriber.name }}</td>
                        <td>{{ subscriber.country }}</td>
                        <td>{{ subscriber.subscribe_date }}</td>
                        <td>{{ subscriber.subscribe_time }}</td>
                        <td><button type="button" v-on:click="deleteSubscriber(listing)" class="btn btn-danger btn-sm">Delete subscriber</button></td>
                        <td><button type="button" v-on:click="editSubscriber(listing)" class="btn btn-info btn-sm">Edit subscriber</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>


export default {
    mounted() {
        $('#subscribers_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/search"
        });
    },
    props: {
  
    },
    data() {
        return {
            subscribers: [],
            page: 1
        };
    },
    methods: {
        deleteSubscriber(listing) {
            // Swal.fire({
            //     title: 'Are you sure you want to delete this subscriber id ' + subscriber.id +' ?',
            //     text: 'You will not be able to recover this subscriber!',
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonText: 'Yes',
            //     cancelButtonText: 'No'
            //     }).then((result) => {
            //     if (result.isConfirmed) {
            //         // Deleting the subscriber
            //         axios.get('/delete', { params: { id: subscriber.id}})
            //         .then(res =>  {
            //                 Swal.fire(
            //                     'Deleted!',
            //                     'The subscriber has been deleted.',
            //                     'success'
            //                 );
            //             })
            //         .catch(error => {});
            //     }

            // });
        },
        editSubscriber(listing) {
            // window.location.href = '/add-edit?id=' + subscriber.id;
        },
        addSubscriber() {
            // window.location.href = '/add-edit?id=0';
        }
    }
}
</script>