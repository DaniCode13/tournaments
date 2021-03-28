<template>
    <div class="container p-2">
        <div v-if="images.length>0" class="row  row-cols-sm-5 m-0 row-cols-md-4  row-cols-sm-3 row-cols-3 ">
            <div v-for="(i, index) in images" :key="index" class="col p-0">
                <img
                    @click="select_image(i.image_url)"
                    :src="format_image(i.image_url, 'small')"
                    class=" img-thumbnail mx-auto d-block"
                    width="200px"
                    height="200px"
                />
            </div>
        </div>
        <div v-else class="d-flex justify-content-center">
            <div class="align-self-cente">No tienes imagenes</div>
        </div>
    </div>
</template>
<script>
import {mapState} from "vuex";
export default {
    data() {
        return {
        };
    },
    mounted: function() {
      this.$store.dispatch('allImagesFromUser');
    },
    computed:{
        ...mapState(['images'])
    },
    methods: {
        select_image:function(image_url){
            this.$store.commit('IMAGE_SELECTED',{
                image_selected:image_url
            })
        $("#modal-image").modal("toggle");
        },
        format_image: function(image_url, type) {
            if (image_url) {
                return (
                    "/storage/" +
                    image_url.replace("/original/", "/" + type + "/")
                );
            }
            return "";
        }
    }
};
</script>
<style scoped>
.masonry{
    column-count: 4;
    column-gap: 1em;
}

.item { /* Masonry bricks or child elements */
  display: inline-block;
  margin: 0 0 1em;
  width: 100%;
}
</style>
