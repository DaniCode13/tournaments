<template>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="list-group">
            <a href="javascript:void(0)" class="list-group-item list-group-item-action active">
                Mis {{get_type}}
            </a>
            <div v-if="!list" class="alert alert-primary" role="alert">
                Sin resultados
            </div>
            <a v-else v-for="(l,index) in list" :href="get_url(l.id)"
               class="list-group-item list-group-item-action">
                <b>{{index+1}}.- </b>
                {{l.title}}
            </a>

        </div>
    </div>
</template>
<script>
    export default {
        props: ['title', 'type'],
        mounted: function () {
            this.get_list()
        },
        computed: {
            get_type: function () {
                let name = ""
                if (this.type == "polls") {
                    name = "encuestas"
                } else {
                    name = "torneos"
                }
                return name;
            }
        },
        data() {
            return {
                list: null
            }
        },
        methods: {
            get_url: function (id) {
                return (this.type == 'polls') ? ('/p/' + id) : ('/t//' + id);
            },
            get_list: function () {
                var url = (this.type == 'polls') ? '/p/' : '/t/';
                axios.get(url + this.type).then(res => {
                    if (res.data.length>0) {
                        this.list = res.data
                    }
                });
            }
        }
    }
</script>
