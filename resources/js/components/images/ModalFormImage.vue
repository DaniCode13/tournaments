<template>
    <div
        class="modal"
        id="modal-image"
        data-backdrop="static"
        data-keyboard="false"
    >
        <div
            class="modal-dialog modal-dialog-centered modal-lg"
        >
            <div class="modal-content">
                <div class="card-header modal-header pl-4 pr-4">
                   
                    <ul
                        class="nav nav-pills card-header-pills"
                        id="pills-tab"
                    >
                        <li class="nav-item ">
                            <a
                                class="nav-link active"
                                id="upload-tab"
                                data-toggle="pill"
                                href="#upload-image"
                                aria-selected="true"
                                >Subir Archivos</a
                            >
                        </li>
                        <li class="nav-item">
                            <a
                                class="nav-link "
                                id="gallery-tab"
                                data-toggle="pill"
                                href="#gallery"
                                role="tab"
                                aria-selected="false"
                                >Galleria</a
                            >
                        </li>
                    </ul>
                     <button
                        type="button"
                        class="close align-self-center"
                        data-dismiss="modal"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body p-0">
                    <div class="tab-content" id="pills-tabContent">
                        <div
                            class="tab-pane fade "
                            id="gallery"
                        >
                            <image-list></image-list>
                        </div>
                        <div
                            class="tab-pane fade show active"
                            id="upload-image"
                        >
                            <section-upload-image ></section-upload-image>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {};
    },
    methods: {}
};
</script>
<style scoped>
#gallery{
    height: 400px;
    overflow-y: scroll;
}
</style>
