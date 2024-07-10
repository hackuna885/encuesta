app.component('web-inicio', {
    template: /*html*/ `
    <div class="row justify-content-center align-items-center vh-100 animate__animated animate__fadeIn">
            
        <div class="col-md-10 mx-auto">
            <div class="row justify-content-center align-items-center vh-100">

                <div class="col-md-6 mx-auto text-center d-none d-md-block">
                    <img src="img/login-image.png" class="img-fluid">
                </div>
                <div class="col-md-6 mx-auto">

                    <div class="mx-2 mx-md-5 my-md-5 my-3">
                        <img src="img/Logo_UTFV.svg" class="img-fluid d-block d-md-none mx-auto" alt="logo" style="max-width: 250px;">
                        <br>
                        <h1 class="fw-light h3 mb-4 text-center">Cuestionario de Evaluación Estudiantil</h1>
                        <h2 class="fw-light h5 mb-4 text-center" style="font-size: 1.1em;">Ingresa tu matrícula para comenzar.</h2>
                        <form @submit.prevent="controlLogin">
                            <input type="number" class="form-control form-control-user mb-3 text-input" placeholder="Matrícula" v-model="txtMatricula" @keypress="soloNumeros" @input="limitCharacters" minlength="8" maxlength="16" autofocus required>

                            <div class="form-group" v-html="datos">
                            </div>
                            <button class="btn btn-primary form-control form-control-user my-3" type="submit" :disabled="this.txtMatricula != '' && this.txtMatricula.length >= 8 ? this.estadoBtn = false : this.estadoBtn = true">Inicio</button>
                        </form>

                    </div>
                    
                </div>

            </div>                   

        </div>
    </div>  
    `,
    data () {
        return {
            datos: '',
            txtMatricula: '',
            estadoBtn: true,
        }
    },
    computed: {
        ...Vuex.mapState(['titulo'])
    },
    methods: {
        controlLogin () {
            axios.post('login/inicio.app', {
                opcion: 1,
                txtMatricula: this.txtMatricula
            })
            .then(response => {
                this.datos = response.data
                console.log(response.data)
            })
        },
        soloNumeros () {
          if (event.keyCode > 31 && (event.keyCode < 48 || event.keyCode > 57)) event.returnValue = false
        },
        limitCharacters() {
          if (this.txtMatricula.length > 16) {
            this.txtMatricula = this.txtMatricula.slice(0, 16)
          }
        }
    },
    created () {
        
    },
    mounted() {

    },
})
