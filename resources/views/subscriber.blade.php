<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Subscriber</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>

<body>
    <div class="container" id="app">
        <h2>Subscriber Page</h2>
        <form>
            @csrf
            <div class="row mt-5">
                <div class="col-4">
                    <select name="field_name" v-model="query.field_name" class="form-select" aria-label="Default select example">
                        <option selected disabled >Select Filed Name</option>
                        <option value="first_name">First Name</option>
                        <option value="last_name">Last Name</option>
                        <option value="email">Email</option>
                        <option value="birth_day">Birthday</option>
                        <option value="created_at">Created At</option>
                    </select>
                </div>
                <div class="col-4" v-if="query.field_name !== 'birth_day' && query.field_name !== 'created_at' ">
                    <select v-model="query.normal_logic" class="form-select" aria-label="Default select example">
                        <option selected disabled >Select Logic</option>
                        <option value="=">Is</option>
                        <option value="!=">Is Not</option>
                        <option value="LEFT">Start With</option>
                        <option value="RIGHT">End With</option>
                        <option value="LIKE">Contains</option>
                        <option value="NOT LEFT">Doesnot Start With</option>
                        <option value="NOT RIGHT">Doesnot End With</option>
                        <option value="NOT LIKE">Doesnot Contains</option>
                    </select>
                </div>
                <div class="col-4" v-if="query.field_name == 'birth_day' || query.field_name == 'created_at' ">
                    <select v-model="query.date_logic" class="form-select" aria-label="Default select example">
                        <option disabled selected>Select Logic</option>
                        <option value=">">Before</option>
                        <option value="=">On</option>
                        <option value="<">After</option>
                        <option value="<=">On Or Before</option>
                        <option value=">=">On Or After</option>
                        <option value="BETWEEN">Between</option>
                    </select>
                </div>
                <div class="col-4">
                    <input v-model='query.value' name="value" v-bind:type="query.field_name === 'birth_day' || query.field_name === 'created_at' ? 'date':'text'" class="form-control" id="value" placeholder="insert Value">
                    <input v-if="query.date_logic === 'BETWEEN'" v-model='query.value2' name="value2" v-bind:type="query.field_name === 'birth_day' || query.field_name === 'created_at' ? 'date':'text'" class="form-control" id="value" placeholder="insert Value">
                </div>
            </div>
            <button v-on:click.prevent="getValue" class="btn btn-primary mt-5">Submit</button>
        </form>

        <h2>Subscribers List</h2>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Birthday</th>
                <th scope="col">Created At</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(subscriber, index) in subscribers" >
                <th scope="row">@{{ index+1 }}</th>
                <td>@{{ subscriber.first_name }}</td>
                <td>@{{ subscriber.last_name }}</td>
                <td>@{{ subscriber.email }}</td>
                <td>@{{ subscriber.birth_day }}</td>
                <td>@{{ subscriber.created_at }}</td>
              </tr>
            </tbody>
          </table>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
    <script>
        var app = new Vue({
        el: '#app',
            data: {
                query: {},
                subscribers: null,
            },
            methods: {
                getValue(){
                    axios.post('/api/subscribers/search', this.query).then(({ data }) => {
                        this.subscribers = data.subscribers;
                    })
                }
            }
        })
    </script>
</body>

</html>
