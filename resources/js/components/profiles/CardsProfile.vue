<template>
  <div class="card mb-3">
    <div class="row no-gutters">
      <div class="col-md-4">
        <div class="d-flex justify-content-center border-right p-2">
          <img :src="imagen" class="card-img" style="height:150px; width:230px;" />
        </div>
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title text-uppercase">{{titulo}}</h5>
          <p class="card-text">{{descripcion}}</p>
        </div>
      </div>
    </div>
  </div>
</template>

 <script>
export default {
  props: ["titulo", "imagen", "descripcion"],
  mounted() {}
};
</script>
