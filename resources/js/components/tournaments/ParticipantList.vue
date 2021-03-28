<template>
<div id="container-participants" class="">
    <h5 class="text-center m-4">Lista de Participantes</h5>
    <div class="row d-flex justify-content-center" v-for="(team, index) in orderByTeam" :key="index">
        <div class="col-auto card " :class="index%2==0 ?'bg-light':''">
            <div class="d-flex align-items-center h-100">
                #{{index+1}}
            </div>
        </div>
        <div class="col-md-8 col-sm-12 ">
            <div class="card p-2 " :class="index%2==0 ?'bg-light':''">
                <div class="row g-0" v-for="(p, i) in team" :key="i">
                    <div class="col-12" v-if="p">
                        <div class="d-flex flex-row  align-items-center">
                            <div v-if="p.image_url == null" class="p-container-add-image mr-2">
                                <button @click="open_modal(p.id)" class="btn btn-secondary w-100 h-100">
                                    <i class="fas fa-plus fa-2x"></i>
                                </button>
                            </div>
                            <div v-else class="mr-2 p-container-image mr-2">
                                <img height="50px" width="50px" :src="format_image(p.image_url,'thumbnail')" />
                            </div>
                            <input v-model="p.name" type="text" class="p-input form-control mr-2" />
                            <button @click="eliminar(p.id)" class="btn btn-outline-danger mr-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
</template>

<script>
import {
    mapGetters,
    mapState
} from "vuex";
export default {
    data() {
        return {
            image: true,
        };
    },
    computed: {
        ...mapGetters(["orderParticipantByTeam"]),
        ...mapState(["tournament", "image_selected"]),
        orderByTeam: function () {
            var items = [];
            var data = this.tournament.participants;
            for (let index = 0; index < data.length; index += 2) {
                items.push([data[index], data[index + 1]]);
            }
            return items;
        },
    },
    mounted: function () {
        this.orderByTeam;
    },
    methods: {
        open_modal: function (id) {
            $("#modal-image").modal("toggle");
            this.$store.state.participant_id = id;
        },
        eliminar: function (id) {
            this.$store.commit("DELETE_PARTICIPANT_TO_TOURNAMENT", id);
        },
        format_image: function (image_url, type) {
            if (image_url) {
                return (
                    "/storage/" +
                    image_url.replace("/original/", "/" + type + "/")
                );
            }
            return "";
        },
    },
};
</script>

<style scoped>
.p.container-image,
.p-container-add-image {
    height: 50px;
    width: 50px;
}

/* 
.p-input {
    border-bottom: 1px solid blueviolet;
    border-top: none;
    border-left: none;
    border-right: none;
}

.p-input:focus {
    box-shadow: none !important;
}

.p-input:focus {
    color: #444;
    background-color: #fff;
    border-color: #593196;
    outline: 0;
}

.p-input:focus-visible {
    text-shadow: 0 0 0 #444;
    outline: none;
} 
*/
</style>
