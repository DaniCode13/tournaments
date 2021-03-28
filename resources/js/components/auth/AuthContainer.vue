<template>
<div id="auth-container" class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8 col-lg-4">
            <div class="card">
                <div class="row">
                    <div class="col-6 pr-0">
                        <button @click="change_url('register')" class="btn btn-block  btn-link" 
                        :class="this.form == 'register' ? '': 'btn-primary text-white'
                                ">
                            Registrarse
                        </button>
                    </div>
                    <div class="col-6 pl-0">
                        <button @click="change_url('login')" class="btn btn-block btn-link " 
                        :class="this.form == 'login' ? '' : 'btn-primary text-white' ">
                            Acceder
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class=" d-flex bg-white justify-content-center mt-4 mb-4">
                        <img src="/svg/logo.svg" height="150px" width="150px" alt="" />
                    </div>
                    <!-- <form-login ></form-login>
                        <form-register></form-register>  -->
                    <form-login v-show="form == 'login'"></form-login>
                    <form-register v-show="form == 'register'"></form-register>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: ["type"],
    data() {
        return {
            form: ""
        };
    },
    mounted: function () {
        this.form = this.type;
    },
    methods: {
        change_url(typeform) {
            this.form = typeform;
            window.history.pushState(null, null, typeform);
        }
    }
};
</script>
