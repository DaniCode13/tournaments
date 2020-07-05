<template>
    <form @submit.prevent="validate()">
        <div class="row">
            <div class="card col-lg-6 col-md-6 col-sm-12">
                <div class="card-body">
                    <h5 class="card-title">{{title}}</h5>
                    <div v-for="(op,index) in options" :key="index" class="form-check">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="exampleRadios"
                            id="exampleRadios1"
                            v-model="select"
                            :value="op.text"
                        />
                        <label class="form-check-label" for="exampleRadios1">{{op.text}}</label>
                    </div>
                    <button type="button" class="btn btn-md mt-2 btn-success">Votar</button>
                    <div>
                        <p class="mt-4 text-center">Compartir</p>
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control"
                                value="/path/to/foo/bar"
                                placeholder="Some path"
                                id="inputUrl"
                            />
                            <span
                                id="copyText"
                                class="d-inline-block"
                                tabindex="0"
                                data-toggle="tooltip"
                                title="URL copiada"
                            >
                                <button
                                    @click="copy_url()"
                                    class="btn btn-secondary"
                                    type="button"
                                >Copiar</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card col-lg-6 col-md-6 col-sm-12">
                <div class="card-body">
                    <div>
                        <button
                            type="submit"
                            class="btn btn-block btn-secondary"
                        >Mostrar Resultadoss</button>
                    </div>
                </div>
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    props: ["title", "options", "id"],
    mounted: function() {
        this.options = JSON.parse(this.options);
        this.url = window.location.href;
        this.init_graph();
        // this.url = this.url t
    },
    data() {
        return {
            type: "",
            select: ""
        };
    },
    methods: {
        copy_url: function() {
            var copyText = document.getElementById("inputUrl");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            $("#copyText").tooltip("enable");
            $("#copyText").tooltip("show");
            $("#copyText").tooltip("disable");
        },
        init_graph: function() {
            var ctx = document.getElementById("myChart");
            var myChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: [
                        "Red",
                        "Blue",
                        "Yellow",
                        "Green",
                        "Purple",
                        "Orange"
                    ],
                    datasets: [
                        {
                            label: "# of Votes",
                            data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: [
                                "rgba(255, 99, 132, 0.2)",
                                "rgba(54, 162, 235, 0.2)",
                                "rgba(255, 206, 86, 0.2)",
                                "rgba(75, 192, 192, 0.2)",
                                "rgba(153, 102, 255, 0.2)",
                                "rgba(255, 159, 64, 0.2)"
                            ],
                            borderColor: [
                                "rgba(255, 99, 132, 1)",
                                "rgba(54, 162, 235, 1)",
                                "rgba(255, 206, 86, 1)",
                                "rgba(75, 192, 192, 1)",
                                "rgba(153, 102, 255, 1)",
                                "rgba(255, 159, 64, 1)"
                            ],
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        yAxes: [
                            {
                                ticks: {
                                    beginAtZero: true
                                }
                            }
                        ]
                    }
                }
            });
        }
    }
};
</script>
