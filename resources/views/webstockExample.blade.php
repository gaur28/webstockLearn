<!doctype html>
<html lang="en">

<head>
  <title>websocket trial</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/8.0.2/pusher.min.js" integrity="sha512-FFchpqjQzRMR75a1q5Se4RZyBsc7UZhHE8faOLv197JcxmPJT0/Z4tGiB1mwKn+OZMEocLT+MmGl/bHa/kPKuQ==" crossorigin="anonymous" referrerpolicy="no-referrer" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.14/vue.min.js" integrity="sha512-XdUZ5nrNkVySQBnnM5vzDqHai823Spoq1W3pJoQwomQja+o4Nw0Ew1ppxo5bhF2vMug6sfibhKWcNJsG8Vj9tg==" crossorigin="anonymous" referrerpolicy="no-referrer" ></script>
</head>

<body>
  <div class="container" id="app">
    <h1 class="text-center mt-4">Laravel Webstock Example</h1>

    <div class="card mt-4">
        <div class="card-header p-2">
            <div>
                <p>@{{state}}</p>
            </div>
            <form action=>
                <div class="col-lg-2 col-md-3 col-sm-2 pd-0">
                    <label for="name">Name</label>
                    <input type="text" class="form-control-sm" placeholder="name" v-model="name">
                </div>
                <div class="col-lg-1 col-md-2 col-sm-12 mt-2 p-0">
                    <button v-if="connected===false" v-on:click="connect()" type="submit" class="m-r2 btn btn-primary">Connect</button>
                    <button v-if="connected===true" v-on:click="disconnect()" type="submit" class="m-r2 btn btn-danger">Disconnect</button>
                </div>
            </form>
        </div>
    </div>
  </div>

  <script>
    new Vue({
        'el': '#app',
        'data':{
            connected: false,

            pusher:null,
            app:null,
            port: "{{$port}}",
            host: "{{$host}}",
            authEndpoint: "{{$authEndpoint}}",
            apps: "{{$apps}}",

            state: null,

            name:null,
            message:[
                {
                    message: 'your message',
                    name: "Emad",
                    time: '2023'
                }
            ]
        },
        mounted(){
            this.app = this.apps[0] || null
        },
        methods:{
            connect(){
                this.pusher = new Pusher('staging',{
                    wsHost: this.host,
                    wsPort: this.port,
                    wssPort: this.port,
                    wsPath: this.app.path,
                    disabledStat: true,
                    authEndpoint: this.authEndpoint,
                    falseTLS: false,
                    auth:{
                        headers:{
                            "X-CSRF-Token": "{{csrf_token()}}",
                            "x-App-ID": this.app.id
                        },
                        enabledTransports: ["ws", "flash"]
                    }
                });

                this.pusher.connection.bind('state_change', states =>{
                    this.state = states.current
                })
                this.pusher.connection.bind('connected', () =>{
                    this.connected= true
                })
                this.pusher.connection.bind('disconnected', () =>{
                    this.connected = false
                })
                this.pusher.connection.bind('error', event =>{

                })
            },
            disconnect(){
                this.connected = false
            }
        }
    })
  </script>
</body>

</html>
