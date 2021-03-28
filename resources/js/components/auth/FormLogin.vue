<template>
    <form method="POST" @submit.prevent="validate()">
        <div class="form-group ">
            <input
                id="email"
                type="email"
                placeholder="Correo Electronico"
                class="form-control"
                :class="errors.email ? 'is-invalid' : ''"
                name="email"
                v-model="logDetails.email"
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
                id="password"
                v-model="logDetails.password"
                type="password"
                placeholder="contraseña"
                class="form-control"
                :class="errors.password ? 'is-invalid' : ''"
                name="password"
                required
                autocomplete="current-password"
            />
            <span v-if="errors.password" class="invalid-feedback" role="alert">
                <strong>{{ errors.password[0] }}</strong>
            </span>
        </div>

        <div class="form-group ">
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    name="remember"
                    id="remember"
                />
                <label class="form-check-label" for="remember">
                    Recordarme
                </label>
            </div>
        </div>

        <div class="form-group  mb-0">
            <button type="submit" class="btn btn-block btn-primary">
                Iniciar Sesion
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
            logDetails: { email: "", password: "" }
        };
    },

    methods: {
        keymonitor: function(event) {
            if (event.key == "Enter") {
                app.checkLogin();
            }
        },

        validate: function() {
            var logForm = this.toFormData(this.logDetails);
            $("#auth-container").LoadingOverlay("show");
            axios
                .post("/login", logForm)
                .then(response => {
                    if (response.data) {
                        this.errors = {};
                        // this.logDetails = { email: "", password: "" };
                                   $("#auth-container").LoadingOverlay("hide");

                            window.location.href = "/";
                       
                    }
                })
                .catch(error => {
                    console.log(error.response);
                    if (error.response.data.errors) {
                        this.errorMessage = error.response.data.message;
                        this.errors = error.response.data.errors;
                                    $("#auth-container").LoadingOverlay("hide");

                        this.clearInputs()
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

        clearInputs: function() {
            this.logDetails.password=""
        }
    }
};
</script>
