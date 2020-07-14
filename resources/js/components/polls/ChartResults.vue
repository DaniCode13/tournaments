<template>
    <div>
        <canvas id="chart_results" width="400" height="400"></canvas>
    </div>
</template>
<script>
    export default {
        props: ['poll_id', 'title'],
        mounted: function () {
            this.get_results();
        },
        data() {
            return {
                results: [],
                chart: null,
            }
        },
        computed: {},
        methods: {
            get_results: function () {
                axios.get('/v/get_results/' + this.poll_id).then(res => {
                    if (res.data) {
                        this.results = res.data;
                        if (this.chart == null) {
                            this.chart_init();
                        } else {
                            this.chart.data.datasets[0].data = this.get_data_results();
                            this.chart.update();
                        }
                    }
                    this.chart_update();
                });
            },
            chart_update: function () {
                var este = this
                setTimeout(function () {
                    este.get_results();
                }, 5000)
            },
            chart_init: function () {
                var ctx = document.getElementById('chart_results');
                this.chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: this.get_data_results(),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                            ],
                        }],
                        labels: this.get_labels(),
                    },
                    options: {
                        title: {
                            display: true,
                            text: this.title
                        }
                    }
                });
            },

            get_labels: function () {
                var labels = [];
                this.results.forEach(function (value, index, array) {
                    labels.push(value.option);
                });
                return labels;
            },
            get_data_results: function () {
                var data = [];
                this.results.forEach(function (value) {
                    data.push(value.votes);
                })
                return data;
            },
        }
    };
</script>
