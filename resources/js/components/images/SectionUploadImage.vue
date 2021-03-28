<template>
<form @submit.prevent="validate()" id="container-upload-image">
    <input id="btn-find-image" hidden @change="render_file_selected($event.target)" accept=".png, .jpg, .jpeg" type="file" />
    <div class="card text-center section-upload container pl-0 pr-0">
        <div class="card-body h-100">
            <div id="container-select-image" class="justify-content-center align-items-center h-100" :class="state_preview(false)">
                <button @click="find_files()" type="button" class="btn-primary btn-lg">
                    <i class="fas fa-paperclip"></i>
                    Buscar Archivo
                </button>
            </div>
            <div id="preview-container" class="justify-content-center h-100" :class="state_preview(true)">
                <div id="preview" class="align-self-center">
                    <div id="preview-header" class="d-flex">
                        <div id="preview-title" class="p-2 flex-grow-1"></div>
                        <div id="preview-close" class="p-2">
                            <button @click="close_preview()" type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="preview_url" class="card-footer text-muted">
            <button type="submit" class="btn btn-primary float-right">
                <i class="fas fa-upload"></i>
                Subir imagen
            </button>
        </div>
    </div>
</form>
</template>

<script>
import {
    mapState
} from 'vuex'
export default {
    data() {
        return {
            preview_url: ""
        };
    },
    compouted: {
        ...mapState(['preview']),
    },
    methods: {
        find_files: function () {
            document.getElementById("btn-find-image").click();
        },
        render_file_selected: function (input) {
            this.$store.state.preview = true;
            if (input.files && input.files[0]) {
                let preview = $("#preview");
                let preview_title = $("#preview-title");
                let name_image = input.files[0].name ? input.files[0].name : "";
                preview_title.text(name_image);
                this.preview_url = URL.createObjectURL(input.files[0]);
                preview.css("background-image", `url("${this.preview_url}")`);
            }
        },
        state_preview: function (condicion) {
            return this.$store.state.preview == condicion ? "d-flex" : "d-none";
        },
        close_preview: function () {
            this.$store.state.preview = !this.$store.state.preview;
            this.preview_url = "";
        },
        validate: function () {
            if (this.preview_url) {
                var formData = new FormData();

                var files = document.getElementById("btn-find-image").files;
                if (files && files[0]) {
                    formData.append("image", files[0]);
                }
                var elementTab = $("#gallery-tab");
                var elementLoader = $("#container-upload-image");
                this.$store.dispatch("addImageFromUser", {
                    formData: formData,
                    elementLoader: elementLoader,
                    elementTab: elementTab
                });
            }
        },
    }
};
</script>

<style scoped>
.section-upload {
    width: 100%;
    height: 300px;
}

#preview {
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
    width: 300px;
    min-height: 200px;
}

#preview-header {
    display: flex;
    color: #fff;
    padding-bottom: 24px;
    background: linear-gradient(180deg,
            rgba(0, 0, 0, 0.7) 20%,
            hsla(0, 0%, 100%, 0));
}

#preview-title {
    font-weight: 700;
    font-size: 14px;
    word-break: break-word;
    text-align: left;
}

#preview-close>.close {
    color: white;
    font-size: 35px;
}
</style>
