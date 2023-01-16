app.component('table-component', {

    props: {
        countries: {
            type: Array,
            required: true,
        }
    },
    template:
    /* HTML */
        `<table class="table table-dark">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="country,key in countries" :key="key">
                    <th scope="row">{{key+1}}</th>
                    <td>{{country}}</td>
                </tr>
            </tbody>
        </table>`,


});