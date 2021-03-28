<template>
    <div class="col-sm-12 col-md-6 col-lg-6">
        
        <div class="list-group ">
            <a data-toggle="collapse" :href="'.list-'+type" role="button" aria-expanded="false"  class="list-group-item list-group-item-action active">
                Mis {{get_type}}
            </a>
            <div v-if="!list" class="alert alert-info" role="alert">
                No hay ningun registro
            </div>
            <a v-else v-for="(l,index) in list" 
            :key="l.id" 
            :href="get_url(l.id)"     
            :class="'collapse multi-collapse list-group-item list-group-item-action list-'+type+''">
                <b>{{index+1}}.- </b>
                {{get_attribute(l)}}
            </a>

        </div>
    </div>
</template>
<script>
export default {
    props: ["title", "type"],
    mounted: function () {
        this.$nextTick(()=>{
            this.get_list();
        })
    },
    computed: {
        get_type: function () {
            let name = "";
            if (this.type == "polls") {
                name = "encuestas";
            } else {
                name = "torneos";
            }
            return name;
        },
    },
    data() {
        return {
            list: null,
        };
    },
    methods: {
        get_attribute: function (l) {
            if (l.hasOwnProperty("title")) {
                return l.title;
            } else if (l.hasOwnProperty("name")) {
                return l.name;
            }
        },
        get_url: function (id) {
            return this.type == "polls" ? "/p/" + id : "/t/" + id;
        },
        get_list: function () {
            var url = this.type == "polls" ? "/p/" : "/t/";
            axios.get(url + this.type).then((res) => {
                if (res.data.length > 0) {
                    this.list = res.data;
                }
            });
        },
    },
};
</script>
<style scoped>
.list-group-item {
    /* position: relative; */
    /* display: block; */
    /* padding: .75rem 1.25rem; */
    background-color: #fff !important;
    border: 1px solid rgba(0,0,0,.125);
    color:black
}
.list-group-item:hover,.list-group-item.active {
    /* color: #495057; */
    text-decoration: none;
    /* background-color: #f8f9fa !important; */
    /* background-color: #e2ddf1 !important; */
    /* background-color: #593196 !important; */
    background-color:rgba(0,0,0,.03) !important;
    color:#000;
}
.list-group-item.active:hover {
    background-color: #2e283e;
}
</style>
