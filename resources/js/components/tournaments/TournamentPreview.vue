<template>
<div class=" mb-6">
    <div class="text-center text-uppercase">
        <h1>{{data.title}}</h1>
    </div>

    <div id="tournament-container">
        <div id="tournament"></div>
    </div>
</div>
</template>

<script>
export default {
    props: ["data"],
    data() {
        return {
            participants_count: 2,
            participants_data: {
                teams: [
                    [
                        [],
                        []
                    ]
                ],
                results: [],
            },
        };
    },
    mounted: function () {
        this.format_data_tournament();
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
                    save: function () {},
                    disableToolbar: true,
                    disableTeamEdit: true,
                    decorator: {
                        edit: function () {},
                        render: este.render_fn,
                    },
                });
            });
        },
        validate: function () {
            if (this.title_tournament != null) {
                this.add_order_to_participants();
            }
        },
        format_data_tournament: function () {
            let participants = JSON.parse(this.data.participants);
            let items = [];
            let missing_participants=this.missing_participants(participants);
            for (let index = 0; index < participants.length; index += 2) {
                let next_participant = participants[index + 1] == null ? null : participants[index + 1];
                let participant = participants[index] == null ? null : participants[index];
                items.push([participant, next_participant]);
            }
            if(missing_participants.length>0){
                items.push(missing_participants);
            }
            // this.participants_data.teams =items
            this.participants_data.teams = items.map((team) => {
                return team.map((participant) => {
                    if (participant != null) {
                        return {
                            name: participant.name ? participant.name : null,
                            img: participant.image_url ? participant.image_url : null,
                        };
                    }
                    return null;
                });
            });
            console.log(this.participants_data.teams)
        },
        missing_participants: function (participants) {
            var count = 0;
            var items = [];
            var potencia = 0;
            var index = 0;
            if (participants.length % 2 != 0) {
                count = participants.length+1;
            } else {
                count = participants.length;
            }
            while(potencia<count) {
                index = index + 1;
                potencia = Math.pow(2, index);
            } 

            for (let index = 0; index < (potencia - count); index++) {
                items.push(null, null);
            }
            console.log(potencia)
            console.log(count)
            console.log(items)
            return items;
        },
        format_image: function (image_url, type) {
            if (image_url) {
                return ("/storage/" + image_url.replace("/original/", "/" + type + "/"));
            }
            return "";
        },
        render_fn: function (container, data, score, state) {
            var este = this;
            var image_placeholder = `<button class="btn btn-option-img btn-light" >
                                        <i class="fas fa-image"></i>
                                    </button>`;
            switch (state) {
                case "empty-bye":
                    container.append("Sin parcicipante");
                    return;
                case "empty-tbd":
                    container.append(" Por definirse ...");
                    return;
                case "entry-no-score":
                case "entry-default-win":
                case "entry-complete":
                    if (data.img) {
                        container
                            .append(
                                `<img src="${este.format_image(data.img,"thumbnail")}" height="65px" width="65px" /> `
                            )
                            .append(data.name);
                    } else {
                        container.append(image_placeholder);
                    }
                    if (data.name) {
                        container.append(data.name);
                    } else {
                        container.append("Sin participante");
                    }

                    return;
            }
        },
    },
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

div.jQBracket .team:first-child {
    border-bottom: 1px solid #fff;
}

div.jQBracket .team.na {
    /* background-color: #eee; */
    color: #ececec;
}

div.jQBracket .team.na .label {
    height: auto;
    padding-left: 30px;
}

div.jQBracket .team.na.highlight,
div.jQBracket .team.highlight {
    /* background-color: rgba(0, 0, 0, 0.4); */
    color: #eee !important;
}

.btn-option-img {
    height: 65px;
    width: 60px;
    margin: 0;
    /* color: #fff; */
    margin-right: 0px;
}
</style>
