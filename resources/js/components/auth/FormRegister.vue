<template>
    <form  method="POST" @submit.prevent="validate()">
        <div class="form-group ">
            <input
                id="name"
                type="text"
                placeholder="Nombre"
                class="form-control"
                :class="errors.name ? 'is-invalid' : ''"
                name="name"
                v-model="registerDetails.name"
                required
                autofocus
            />

            <span v-if="errors.name" class="invalid-feedback" role="alert">
                <strong>{{ errors.name[0] }}</strong>
            </span>
        </div>
        <div class="form-group ">
            <input
                id="email"
                type="email"
                placeholder="Correo Electronico"
                class="form-control"
                :class="errors.email ? 'is-invalid' : ''"
                name="email"
                v-model="registerDetails.email"
                required
                autocomplete="email"
                autofocus
            />

            <span v-if="errors.email" class="invalid-feedback" role="alert">
                <strong>{{ errors.email[0] }}</strong>
            </span>
        </div>
        <div class="form-group ">
            <input
                id="username"
                type="text"
                placeholder="Nombre de Usuario"
                class="form-control"
                :class="errors.username ? 'is-invalid' : ''"
                name="username"
                v-model="registerDetails.username"
                required
                autocomplete="email"
                autofocus
            />

            <span v-if="errors.username" class="invalid-feedback" role="alert">
                <strong>{{ errors.username[0] }}</strong>
            </span>
        </div>

        <div class="form-group ">
            <input
                id="password"
                v-model="registerDetails.password"
                type="password"
                placeholder="Contraseña"
                class="form-control"
                :class="errors.password ? 'is-invalid' : ''"
                name="password"
                required
                autocomplete="new-password"
            />
            <span v-if="errors.password" class="invalid-feedback" role="alert">
                <strong>{{ errors.password[0] }}</strong>
            </span>
        </div>
        <div class="form-group ">
            <input
                id="password_confirmation"
                v-model="registerDetails.password_confirmation"
                type="password"
                placeholder="Confirmar Contraseña"
                class="form-control"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />
        </div>

        <div class="form-group  mb-0">
            <button type="submit" class="btn btn-block btn-primary">
                Registrarse
            </button>
        </div>
    </form>
</template>
<script>
export default {
    data() {
        return {
            errors: {},
            successMessage: "",
            errorMessage: "",
            registerDetails: { name:"",username:"",email: "", password: "",password_confirmation:"" }
        };
    },

    methods: {
        keymonitor: function(event) {
            if (event.key == "Enter") {
                app.checkLogin();
            }
        },

        validate: function() {
            $("#auth-container").LoadingOverlay("show");
            var logForm = this.toFormData(this.registerDetails);
            axios
                .post("/register", logForm)
                .then(response => {
                    if (response.data) {
                        this.errors = {};
                        // this.logDetails = { email: "", password: "" };
                        window.location.href = "/";
                        $("#auth-container").LoadingOverlay("hide");

                    }
                })
                .catch(error => {
                    if (error.response.data.errors) {
                        this.errorMessage = error.response.data.message;
                        this.errors = error.response.data.errors;
                        this.clearImputs()
                        $("#auth-container").LoadingOverlay("hide");

                    }
                });
        },

        toFormData: function(obj) {
            var form_data = new FormData();
            for (var key in obj) {
               
                form_data.append(key, obj[key]);
            }
            return form_data;
        },

        clearImputs: function() {
            for(var key in this.errors){
                this.registerDetails[key] = "";
                if(this.errors.hasOwnProperty('password')){
                    this.registerDetails.password_confirmation =""
                }
            }
        }
    }
};
</script>
