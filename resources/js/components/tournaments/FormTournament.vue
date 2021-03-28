<template>
    <form @submit.prevent="validate()">
        <div id="section-fixed-button" class="fixed-bottom p-4">
            <button id="btn-save-tournament" type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i>
            </button>
        </div>

        <div class="">
            <input required
                   id="title-tournament"
                   v-model="title_tournament"
                   type="text"
                   class="mx-auto form-control w-50 "
                   placeholder="Nombre del Torneo">
        </div>
        <div id="tournament-container">
            <div id="tournament"></div>
        </div>
        <div
            id="modalSelectFile"
            class="modal fade"
            tabindex="-1"
        >

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Imagen del Participante</h5>
                    </div>

                    <div class="modal-body text-center">
                        <div class="">
                            <button @click="select_file()" class="btn btn-light">
                                <i class="fas fa-paperclip pr-2"></i>Subir Imagen
                            </button>
                            <input
                                @change="render_file_selected($event.target)"
                                hidden
                                accept=".png, .jpg, .jpeg"
                                type="file"
                                id="input-upload-image"
                            />
                        </div>

                        <div id="previsualization-container" class="d-none justify-content-center pt-3">
                            <div id="previsualization-image">
                                <div id="previsualization-header" class="d-flex">
                                    <div id="previsualization-title" class="p-2 flex-grow-1"></div>
                                    <div id="previsualization-close" class="p-2">
                                        <button
                                            @click="close_previsualization()"
                                            type="button"
                                            class="close"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {
            title_tournament: '',
            participants_count: 2,
            participants_data: {
                teams: [
                    [null, null]
                ],
                results: []
            }
        };
    },
    mounted: function () {
        this.$nextTick(function () {
            this.init_tournament();
        });
    },
    methods: {
        add_new: function () {
            this.participants_count += 2;
        },
        init_tournament: function () {
            var este = this;
            $(function () {
                $("#tournament").bracket({
                    skipConsolationRound: true,
                    teamWidth: 320,
                    scoreWidth: 50,
                    matchMargin: 150,
                    roundMargin: 50,
                    init: este.participants_data,
                    save: function () {
                    },
                    decorator: {
                        edit: este.edit_fn,
                        render: este.render_fn
                    }
                });
            });
        },
        edit_fn: function (container, data, doneCb) {
            var input = $('<input type="text">');
            input.val(data ? data.name : "");
            container.html(input);
            input.focus();
            input.blur(function () {
                var inputValue = input.val();
                if (inputValue.length === 0) {
                    doneCb(""); // Drop the team and replace with BYE
                } else {
                    let img = data ? data.img : "";
                    doneCb({img: img, name: inputValue});
                }
            });
        },
        render_fn: function (container, data, score, state) {
            var button_upload = `<button title="Agregar imagen" class="btn btn-option-img btn-secondary" data-toggle="modal" type="button" data-target="#modalSelectFile">
                    <img src="/svg/add_white.svg" >
                </button>
                `;
            switch (state) {
                case "empty-bye":
                    $(function () {
                        if (container[0].parentElement.hasAttribute("data-teamid")) {
                            container.append(button_upload + "Agrega un nombre");
                        }
                    })
                    return;
                case "empty-tbd":
                    container.append('')
                    return;
                case "entry-no-score":
                case "entry-default-win":
                case "entry-complete":
                    if (data.img) {
                        container.append(
                            '<img src="/images/' +
                            data.img +
                            '.png" height="65px" width="65px" /> '
                        );
                    } else {
                        container.append(button_upload);
                    }

                    container.append(data.name);
                    return;
            }
        },
        select_file: function () {
            $("#input-upload-image").click();
        },
        render_file_selected: function (input) {
            if (input.files && input.files[0]) {
                $("#previsualization-container")
                    .removeClass("d-none")
                    .addClass("d-flex");
                $("#previsualization-title").text(
                    input.files && input.files.length ? input.files[0].name : ""
                );

                $("#previsualization-image").css(
                    "background-image",
                    "url(" + URL.createObjectURL(input.files[0]) + ")"
                );
            }
        },
        close_previsualization: function () {
            $("#previsualization-container")
                .removeClass("d-flex")
                .addClass("d-none");
        },
        validate: function () {
            if (this.title_tournament != null) {
                this.add_order_to_participants()
            }
        },
        add_order_to_participants: function () {
            let data = $('#tournament').bracket('data')['teams'];
            console.log(data)
            var count_participant = 0
            var data_reformatted = data.map((team) => {
                return team.map((participant) => {

                    if (participant == null) {
                        participant = {'img': null, 'name': null}
                    }
                    participant['order'] = count_participant
                    ++count_participant
                    return participant
                });
            });

            this.save_tournament(data_reformatted)
        },
        save_tournament: function (data) {
            var params = {
                name: this.title_tournament,
                data_tournament: data

            }
            this.$swal({
                title:"Guardando...",
                html: `<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                          <span class="visually-hidden"></span>
                        </div>`
            });
            axios.post('/t', params)
                .then((res) => {
                    if (!res.data.status && res.data.status !== 'error') {
                        this.$swal({
                            icon: 'success',
                            title: 'Bien Hecho',
                            text: 'torneo creado correctamente',
                            timer: false,
                            allowOutsideClick:false,
                            showConfirmButton: true,

                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href='/t/'+res.data.tournament_id
                            }
                        });
                    } else {
                        this.$swal({icon: 'error', title: 'Hubo un problema', text: res.data.message});
                    }
                })
                .catch((e) => {
                    console.log(e);
                })

        }
    }
};
</script>

<style>
div.jQBracket .team {
    position: relative;
    z-index: 1;
    float: left;
    background-color: #eee;
    cursor: default;
    height: 75px !important;
    padding: 5px;
}

div.jQBracket .team input {
    font-size: 14px;
    padding: 0;
    width: 100%;
    border: 0;
    margin: 0;
    outline: 0;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

div.jQBracket .team div.label {
    padding: 0;
    height: 65px;
    white-space: nowrap;
    overflow: hidden;
    box-sizing: border-box;
    margin: auto;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

div.jQBracket .team div.score {
    margin: auto;
    float: right;
    padding: 0px;
    background-color: rgba(255, 255, 255, 0.3);
    text-align: center;
    box-sizing: border-box;
    line-height: 65px;
    width: 40px !important;
}

div.jQBracket .team div.score input {
    width: 40px !important;
    display: block;
    margin: auto;
    top: 50%;
    transform: translateY(-50%);
}

div.jQBracket .team.highlight {
    background-color: rgba(0, 0, 0, 0.4);
    color: #eee;
}

div.jQBracket .team.na {
    background-color: #eee;
    color: #000;
}

div.jQBracket .team.na.highlight {
    background-color: rgba(0, 0, 0, 0.4);
    color: #eee;
}

.doubleElimination {
    display: none !important;
}

.btn-option-img {
    height: 65px;
    width: 60px;
    margin: 0;
    color: #fff;
    margin-right: 0px;
}

#previsualization-container {
    width: 100%;
    height: 200px;
}

#previsualization-image {
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
    width: 300px;
    min-height: 200px;
}

#previsualization-header {
    display: flex;
    color: #fff;
    padding-bottom: 24px;
    background: linear-gradient(
        180deg,
        rgba(0, 0, 0, 0.7) 20%,
        hsla(0, 0%, 100%, 0)
    );
}

#previsualization-title {
    font-weight: 700;
    font-size: 14px;
    word-break: break-word;
    text-align: left;
}

#previsualization-close > .close {
    color: white;
    font-size: 35px;
}

#title-tournament {

}

#section-fixed-button {
    right: 0px !important;
    left: auto;
}

#section-fixed-button button {
    border-radius: 50%;
}
</style>
