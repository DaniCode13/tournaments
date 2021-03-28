import {
    SHOW_LOADER,
    HIDDEN_LOADER,
    SHOW_ALERT,
    SHOW_TOAST,
    ALL_IMAGES_FROM_USER,
    ADD_IMAGE_FROM_USER,
    REMOVE_IMAGE_FROM_USER,
    PREVIEW,
    ADD_PARTICIPANT_TO_TOURNAMENT,
    DELETE_PARTICIPANT_TO_TOURNAMENT,
    ADD_TOURNAMENT,
    IMAGE_SELECTED
} from "./mutations-types";

export const loaderMutations = {
    [SHOW_LOADER]: function(state, payload) {
        payload.LoadingOverlay("show");
    },
    [HIDDEN_LOADER]: function(state, payload) {
        payload.LoadingOverlay("hide");
    }
};
export const alertMutations = {
    [SHOW_ALERT]: function(state, payload) {
        Swal.fire({
            position: "center",
            icon: "" + payload.type,
            title: "" + payload.title,
            showConfirmButton: false,
            timer: 1500
        });
    }
};
export const toastMutations = {
    [SHOW_TOAST]: function(state, payload) {
        Swal.fire({
            toast: true,
            position: payload.position ? payload.position : "center",
            icon: "" + payload.type,
            title: "" + payload.title,
            showConfirmButton: false,
            timer: payload.timer ? payload.timer : 2000,
            timerProgressBar: true
        });
    }
};

export const previewMutation = {
    [PREVIEW]: function(state, payload) {
        state.preview = payload;
    }
};

export const imageMutations = {
    [ALL_IMAGES_FROM_USER]: function(state, payload) {
        state.images = payload;
    },
    [ADD_IMAGE_FROM_USER]: function(state, payload) {
        // if (payload.length > 0) {
        state.images.push(payload);
        // payload.forEach(element => {
        //     state.images.push(element)
        // })
        // }
    },
    [REMOVE_IMAGE_FROM_USER]: function(state, payload) {
        var image_index = state.images.findIndex(image => image.id == payload);
        state.images.splice(image_index, 1);
    },
    [IMAGE_SELECTED]: function(state, payload) {
        if (state.participant_id != null) {
            state.tournament.participants.forEach((element, index) => {
                if (element.id == state.participant_id) {
                    state.tournament.participants[index].image_url =
                        payload.image_selected;
                }
            });
        } else {
            state.new_participant.image_url = payload.image_selected;
        }
    }
};
function clearObject(object) {
    for (const key in object) {
        object[key] = null;
    }
    return object;
}
export const tournamentMutations = {
    [ADD_TOURNAMENT]: function(state, payload) {
        state.tournament.title = payload.title;
        state.tournament.id = payload.id;
    },
    [ADD_PARTICIPANT_TO_TOURNAMENT]: function(state, payload) {
        let order_id =
            state.tournament.participants.length > 0
                ? state.tournament.participants.length
                : 0;
        payload.participant.order = order_id;
        payload.participant.id = order_id;
        state.tournament.participants.push(payload.participant);
        state.new_participants = clearObject(state.new_participant);
    },
    [DELETE_PARTICIPANT_TO_TOURNAMENT]: function(state, payload) {
        let index = state.tournament.participants.findIndex(
            p => p.id === payload
        );
        state.tournament.participants.splice(index, 1);
    }
};
