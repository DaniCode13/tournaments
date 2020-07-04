<template>
  <form @submit.prevent="validate()">
    <div class="row">
      <div class="card col-lg-8 col-md-8 col-sm-12">
        <div class="card-body">
          <input
            style="border-right:0;border-left:0px;border-top:0px;"
            class="form-control form-control-lg"
            placeholder="Escribe el tema de la encuesta"
            v-model="title"
            required
            type="text"
          />
        </div>
        <div class="card-body">
          <div class="input-group mb-2" v-for="(input, index) in inputs" :key="index">
            <div class="input-group-prepend">
              <div class="input-group-text">{{index+1}}</div>
            </div>
            <input
              style="border-right:0;border-left:0px;border-top:0px;"
              class="form-control"
              placeholder="Escribe una opción"
              type="text"
              v-model="inputs[index].text"
            />
          </div>
        </div>
        <div class="card-body d-flex justify-content-center">
          <a @click="add_option()" class="btn btn-block btn-light">
            <img src="/svg/add.svg" alt />
          </a>
        </div>
      </div>
      <div class="card col-lg-4 col-md-4 col-sm-12">
        <div class="card-body">
          <div class="form-group">
            <label for="type_poll">Revision de Duplicación de votos</label>
            <select required v-model="type" class="form-control" id="type_poll">
              <option value selected disabled hidden>Elije una opcion</option>
              <option :value="types[0].id">Duplicacion de Ip</option>
              <option :value="types[1].id">Duplicacion por Cookie</option>
              <option :value="types[2].id">No revisar duplicacion de votos</option>
            </select>
          </div>
          <div>
            <button type="submit" class="btn btn-block btn-success">Crear Encuesta</button>
          </div>
          <div v-if="id">
            <p class="mt-4 text-center">URL</p>
            <div class="input-group mb-2 mr-sm-2 d-flex justify-content-center">
              <input
                type="text"
                class="form-control-md"
                id="inlineFormInputGroupUsername2"
                placeholder="Username"

                :value="url"
              />
              <button type="button" class="btn btn-md btn-secondary">Copiar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>
<script>
export default {
  mounted: function() {
    this.get();
    this.check_min_two;
  },
  data() {
    return {
      id: null,
      title: null,
      inputs: [{ text: "" }, { text: "" }],
      input: "",
      types: {},
      type: "",
      url: ""
    };
  },
  computed: {
    check_min_two: function() {
      // retorna los que no estan vacios
      var filter = this.inputs.filter(function(option) {
        return option.text != "";
      });

      //Si hay minimo 2 campos pasara la validacion
      if (filter.length < 2) {
        return false;
      } else {
        this.inputs = filter;
        return true;
      }
    }
  },
  methods: {
    add_option: function() {
      this.inputs.push({ text: "" });
    },
    validate: function() {
      if (this.check_min_two) {
        var params = {
          title: this.title,
          options: JSON.stringify(this.inputs),
          type_poll_id: this.type
        };
        this.post(params);
      } else {
        alert("debes ingresar al menos 2 opciones");
      }
    },
    post: function(data) {
      axios.post("/p", data).then(res => {
        this.id = res.data.id;
         this.url = res.data.url;
      });
    },
    get: function() {
      axios.get("/p/types_polls").then(res => {
        this.types = res.data;

      });
    }
  }
};
</script>
