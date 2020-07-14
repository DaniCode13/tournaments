<template>
    <div class="row">
        <div class="card col-lg-6 col-md-6 col-sm-12">
            <div class="card-body">
                <template v-if="check_duplication"><h5 class="card-title">{{data.title}}</h5>
                    <div v-for="(op,index) in options" :key="index" class="form-check">
                        <label class="form-check-label" >{{op.option}}</label>
                    </div>
                    <div class="alert alert-primary mt-2" role="alert">
                        Tu voto ya fue registrado
                    </div>
                </template>
                <template v-else>
                    <form @submit.prevent="vote()">
                        <h5 class="card-title">{{data.title}}</h5>
                        <div v-for="(op,index) in options" :key="index" class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="exampleRadios"
                                :id="'exampleRadios'+index"
                                v-model="option_selected"
                                :value="op.id"/>
                            <label class="form-check-label" :for="'exampleRadios'+index">{{op.option}}</label>
                        </div>
                        <button type="submit" class="btn btn-md mt-2 btn-success">Votar</button>
                    </form>

                </template>
                <div>
                    <p class="mt-4 text-center">Compartir</p>
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            :value="url"
                            style="background-color:#f2f2f2;"
                            placeholder="Some path"
                            id="inputUrl"/>
                        <span
                            id="copyText"
                            class="d-inline-block"
                            tabindex="0"
                            data-toggle="tooltip"
                            title="URL copiada">
                                <button
                                    @click="copy_url()"
                                    class="btn btn-secondary"
                                    type="button">Copiar
                                </button>
                            </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card col-lg-6 col-md-6 col-sm-12">
            <div class="card-body">
                <div>
                    <button
                        @click="view_results=!view_results"
                        type="submit"
                        class="btn btn-block btn-secondary">
                        {{view_results==false? 'Mostrar': 'Ocultar'}} Resultados
                    </button>
                </div>
                <chart-results v-if="view_results" :poll_id="this.data.id" :title="this.data.title"></chart-results>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['data', 'duplication'],
        mounted: function () {
            // this.options = JSON.parse(this.data.options);
            // this.title =this.data.title;
            // this.id = this.data.id;
            this.url = window.location.href;
            // this.init_graph();
            // this.url = this.url t
        },
        data() {
            return {
                options: (this.data.options ? JSON.parse(this.data.options) : []),
                type: "",
                option_selected: "",
                title: this.data.title,
                id: this.data.id,
                check_duplication: this.duplication,
                url: "",
                view_results: false
            };
        },
        methods: {
            vote: function () {
                if (this.option_selected != "") {
                    var params = {"vote": this.option_selected};
                    axios.post('/v/vote/' + this.id, params).then(res => {
                        if (res.data != "") {
                            if (this.data.type_poll_id != 3) {
                                this.check_duplication = 1
                            }
                        }
                    })
                }
            },
            copy_url: function () {
                var copyText = document.getElementById("inputUrl");
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                $("#copyText").tooltip("enable");
                $("#copyText").tooltip("show");
                $("#copyText").tooltip("disable");
            },
        }
    };
</script>
