<template>
    <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card text-center mb-3">
            <div class="card-header">
                {{title}}
            </div>
            <div class="d-flex justify-content-center">
                <img :src="image" class="mt-3" style="width: 230px; height: 150px;">
            </div>
            <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text">{{description}}</p>
                <a :href="url" class="btn btn-primary">Crear</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["title", "image", "description","url"],
        mounted() {
        }
    };
</script>
