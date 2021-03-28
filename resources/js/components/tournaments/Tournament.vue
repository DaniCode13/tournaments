<template>
<div id="tournament">

    <!-- <a role="button" :href="'/t/'+tournament.id+'/preview'" class="btn btn-primary">preview</a> -->
    <form @submit.prevent="validate">
        <div class="row align-items-center mb-4">
            <div class="col-6 pr-0">
                <button type="submit" class="btn btn-block btn-primary">
                    <i class="fas fa-save"></i>
                    Guardar
                </button>
            </div>
            <div class="col-6 pl-0">
                <a role="button" :href="'/t/'+tournament.id+'/preview'" class="btn btn-block btn-secondary">
                    <i class="fas fa-eye"></i>
                    preview
                </a>
            </div>

        </div>
        <div class="section-name-tournament d-flex justify-content-center">
            <input v-model="tournament.title" class="input-title-tournament text-center form-control-lg" placeholder="Nombre del Torneo" type="text" required />
        </div>

    </form>
    <div class="section-create">
        <participant-create> </participant-create>
    </div>

    <div class="section-list">
        <participant-list> </participant-list>
    </div>
    <modal-form-image></modal-form-image>
</div>
</template>

<script>
import {
    mapGetters,
    mapState
} from "vuex";
export default {
    props: ["data"],
    data() {
        return {};
    },
    computed: {
        ...mapState(["tournament"]),
    },
    mounted: function () {
        if (this.data != null) {
            this.tournament.participants = JSON.parse(this.data.participants);
            this.tournament.title = this.data.title;
            this.tournament.id = this.data.id;
        }
    },
    methods: {
        validate: function () {
            var element = $("#tournament");
            if (
                this.tournament.participants.length > 1 &&
                this.tournament.title != null
            ) {
                if (this.tournament.id == null) {
                    this.$store.dispatch("createTournament", {
                        title: this.tournament.title,
                        participants: this.tournament.participants,
                        element: element,
                    });
                } else {
                    this.$store.dispatch("updateTournament", {
                        id: this.tournament.id,
                        title: this.tournament.title,
                        participants: this.tournament.participants,
                        element: element,
                    });
                }
            } else {
                this.$store.commit("SHOW_TOAST", {
                    type: "info",
                    title: "agrega un al menos 2 participantes",
                    position: "top-end",
                    timer: 3000,
                });
            }
        },
    },
};
</script>

<style>
.save-tournament {
    position: fixed;
    right: 0;
    bottom: 0;
    z-index: 1030;
    margin: 30px;
}
</style>
