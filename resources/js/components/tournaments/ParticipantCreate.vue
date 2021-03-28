<template>
<div id="participant-create" class="mt-5">

    <div class="participant">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 col-sm-12 col-lg-6 ">
                <div class="card p-2 ">
                    <div class="card-header">
                        <h4 class="text-center m-0">Nuevo Participante</h4>
                    </div>
                    <div class="row g-0">
                        <div class="col-12">
                            <div class="d-flex flex-row  align-items-center">
                                <div v-if="new_participant.image_url == null" class="p-container-add-image m-2">
                                    <button @click="open_modal()" class="btn btn-secondary w-100 h-100">
                                        <i class="fas fa-plus fa-2x"></i>
                                    </button>
                                </div>
                                <div v-else class="p-container-image m-2">
                                    <img height="50px" width="50px" :src="format_image(new_participant.image_url, 'thumbnail')" />
                                </div>

                                <input required v-model="new_participant.name" class="p-input form-control mr-2" type="text" placeholder="Agrega un titilo / nombre..." />

                                <button @click="validate()" type="button" class="btn btn-outline-primary">
                                    agregar
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="">
                        <div v-if="new_participant.image_url == null" class="p-container-add-image m-2">
                            <button @click="open_modal()" class="btn btn-secondary w-100 h-100">
                                <i class="fas fa-plus fa-2x"></i>
                            </button>
                        </div>
                        <div v-else class="p-container-image m-2">
                            <img height="50px" width="50px" :src="format_image(new_participant.image_url, 'thumbnail')" />
                        </div>
                    </div>

                    <div class="p-container-title d-flex align-self-center mr-2">
                        <input required v-model="new_participant.name" class="p-input form-control" type="text" placeholder="Agrega un titilo / nombre..." />
                    </div>

                    <div class="d-flex align-self-center">
                        <button @click="validate()" type="button" class="btn btn-outline-primary">
                            agregar
                        </button>
                    </div>
                </div>
            </div>

        </div> -->

    </div>
</div>
</template>

<script>
import {
    mapState
} from "vuex";
export default {
    data() {
        return {};
    },
    computed: {
        ...mapState(["image_selected", "new_participant"]),
    },
    watch: {},
    mounted: function () {},
    methods: {
        open_modal: function () {
            $('#modal-image').modal('show')
            this.$store.state.participant_id = null
        },
        validate: function () {
            let participant = Object.assign({}, this.new_participant);
            if (this.new_participant.name) {
                this.$store.commit("ADD_PARTICIPANT_TO_TOURNAMENT", {
                    participant: participant,
                });
            }
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

<style>
.p.container-image,
.p-container-add-image {
    height: 50px;
    width: 50px;
}
</style>
