<template>
    <form @submit.prevent="validate()">
        <div class="card" style="width: 18rem;">
            <div class="card-body position-relative card-overlay-custom">
                <div class="w-100" style="height:100px;">
                    <img src="" class="bg-primary">

                </div>
                <button class="btn btn-option-img" data-toggle="modal" type="button" data-target="#modalSelectFile">
                    <img src="/svg/add_white.svg" alt="">
                </button>
            </div>

            <div class="card-body">
                <input class="form-control form-control-sm" id="title" type="text" placeholder="agregar texto...">
            </div>

        </div>

        <div id="modalSelectFile" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="falsefa">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">agregar imagen</h5>
                    </div>
                    <div class="ml-2 mr-2">
                        <select class="form-control ">
                            <option selected disabled>escoge una opciónn</option>
                            <option value="1">subir imagen</option>
                            <option value="2">Agregar url del archivo</option>

                        </select>
                    </div>

                    <div class="modal-body text-center">
                        <p class=""><button @click="select_file()"> subir imagen</button>
                            <input hidden accept=".png, .jpg, .jpeg" type="file" id="input-upload-image"></p>

                        <p>ó</p>
                        <p class=""><input type="url" placeholder="URL de la imagen/video"></p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</template>

<script>
export default {
    mounted() {
    },
    data() {
        return {}
    },
    methods: {
        validate: function () {

        },
        select_file: function () {
            $('#input-upload-image').click();
        }
    }
}
</script>

<style>


.card-overlay-custom:hover {
    background: rgba(0, 0, 0, 0.5);
}

.card-overlay-custom:hover .btn-option-img {
    visibility: visible;
}
</style>
