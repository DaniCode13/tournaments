<template>
    <form @submit.prevent="validate()">
        <div class="row">
            <div class="card col-lg-8 col-md-8 col-sm-12">
                <div class="card-body">
                    <input
                        style="border-right:0;border-left:0px;border-top:0px;"
                        class="form-control form-control-lg"
                        placeholder="Escribe el tema de la encuesta"
                        v-model="title"
                        required
                        type="text"
                    />
                </div>
                <div class="card-body">
                    <div class="input-group mb-2" v-for="(input, index) in options" :key="index">
                        <div class="input-group-prepend">
                            <div class="input-group-text">{{ index + 1 }}</div>
                        </div>
                        <input
                            style="border-right:0;border-left:0px;border-top:0px;"
                            class="form-control"
                            placeholder="Escribe una opción"
                            type="text"
                            v-model="options[index].option"
                        />
                    </div>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <a @click="add_option()" class="btn btn-block btn-light">
                        <img src="/svg/add.svg" alt/>
                    </a>
                </div>
            </div>
            <div class="card col-lg-4 col-md-4 col-sm-12">
                <div class="card-body">
                    <div v-if="types.length>0" class="form-group">
                        <label for="type_poll">Revisión de Duplicación de votos</label>
                        <select required v-model="type" class="form-control" id="type_poll">
                            <option value selected disabled hidden>Elije una opcion</option>
                            <option :value="types[0].id">Duplicación de Ip</option>
                            <option :value="types[1].id">Duplicación por Cookie</option>
                            <option :value="types[2].id">No revisar duplicación de votos</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-block btn-success">Crear Encuesta</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
<script>
    export default {
        mounted: function () {
            this.get();
        },
        data() {
            return {
                id: null,
                title: null,
                options: [{id: null, option: ""}, {id: null, option: ""}],
                option: "",
                types: {},
                type: "",
            };
        },
        methods: {
            check_min_two: function () {
                // retorna los que no estan vacios
                var filter = this.options.filter(function (o) {
                    return o.option != "";
                });

                this.set_ids_to_options();

                //Si hay minimo 2 campos pasara la validacion
                if (filter.length < 2) {
                    return false;
                } else {
                    this.options = filter;
                    return true;
                }
            },
            set_ids_to_options: function () {
                this.options.forEach(function (value, index, array) {
                    value.id = index + 1;
                });
            },
            add_option: function () {
                this.options.push({id: this.options.length, option: ""});
            },
            validate: function () {
                if (this.check_min_two()) {
                    var params = {
                        title: this.title,
                        options: JSON.stringify(this.options),
                        type_poll_id: this.type
                    };
                    this.post(params);
                } else {
                    alert("debes ingresar al menos 2 opciones");
                }
            },
            post: function (data) {
                axios.post("/p", data).then(res => {
                    window.location.href = "/p/" + res.data.id;
                });
            },
            get: function () {
                axios.get("/p/types_polls").then(res => {
                    if (res.data) {
                        this.types = res.data;
                    }
                });
            }
        }
    };
</script>
