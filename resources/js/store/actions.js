import axios from "axios";
import {
    SHOW_LOADER,
    HIDDEN_LOADER,
    SHOW_ALERT,
    SHOW_TOAST,
    PREVIEW,
    ALL_IMAGES_FROM_USER,
    ADD_IMAGE_FROM_USER,
    REMOVE_IMAGE_FROM_USER,
    ADD_TOURNAMENT
} from "./mutations-types";

const API_BASE = "";

function response_format(success, data) {
    return { success: success, data: data };
}

export const imageActions = {
    allImagesFromUser({ commit }) {
        return axios
            .get(`${API_BASE}/u/images`)
            .then(response => {
                if (response.data) {
                    commit(ALL_IMAGES_FROM_USER, response.data);
                    return response_format(true, response.data);
                } else {
                    return response_format(false, response.data.messages);
                }
            })
            .catch(error => {
                return response_format(false, error.message);
            });
    },
    addImageFromUser({ commit }, payload) {
        var toast_success = {
            title: "Imagen Subida correctamente",
            type: "success"
        };
        var toast_error = {
            title: "No se pudo subir la imagen",
            type: "error"
        };

        commit(SHOW_LOADER, payload.elementLoader);
        return axios
            .post(`${API_BASE}/u/image`, payload.formData)
            .then(response => {
                commit(HIDDEN_LOADER, payload.elementLoader);
                if (response.data) {
                    commit(SHOW_TOAST, toast_success);
                    commit(ADD_IMAGE_FROM_USER, response.data);
                    payload.elementTab.tab("show");
                    commit(PREVIEW, false);
                    return response_format(true, response.data);
                } else {
                    commit(SHOW_TOAST, toast_error);
                    return response_format(false, response.data.messages);
                }
            })
            .catch(error => {
                commit(SHOW_TOAST, toast_error);
                commit(HIDDEN_LOADER, payload.elementLoader);
                return response_format(false, error.message);
            });
    },

    removeImageFromUser({ commit }, payload) {
        const alert_success = {
            type: "success",
            title: "Imagen eliminada  correctamente"
        };
        const alert_error = {
            type: "error",
            title: "Ocurrio un problema vuelve a intentarlo"
        };
        commit(SHOW_LOADER);
        return axios
            .delete(
                `${API_BASE}/products/${payload.product_id}/images/${payload.image_id}`
            )
            .then(response => {
                commit(HIDDEN_LOADER);
                if (response.status === 204) {
                    commit(REMOVE_IMAGE_FROM_USER, payload.image_id);
                    commit(SHOW_ALERT, alert_success);
                    return response_format(true, null);
                } else {
                    commit(SHOW_ALERT, alert_error);
                    return response_format(false, response.data.messages);
                }
            })
            .catch(error => {
                commit(HIDDEN_LOADER);
                commit(SHOW_ALERT, alert_error);
                return response_format(false, error.message);
            });
    }
};

export const tournamentActions = {
    // initTournamentLocalStorage:function(){
    //     if (typeof localStorage !== 'undefined') {
    //         if (localStorage.getItem('tournanment')==null) {
    //             var tournament={
    //                 name:null,
    //                 participants:null
    //             }
    //             localStorage.setItem('tournament',JSON.stringify(tournament));
    //         }
    //     }

    // },
    createTournament: function({ commit }, payload) {
        commit(SHOW_LOADER, payload.element);
        var toast_success = {
            type: "success",
            title: "Torneo creado correctamente",
            position: "top-end"
        };
        var toast_error = {
            type: "error",
            title: "Hubo un problema al crear el torneo",
            position: "top-end"
        };
        var form = { title: payload.title, participants: payload.participants };
        return axios
            .post(`${API_BASE}/t`, form)
            .then(response => {
                commit(HIDDEN_LOADER, payload.element);
                if (response.data) {
                    commit(ADD_TOURNAMENT, response.data);
                    commit(SHOW_TOAST, toast_success);
                    return response_format(true, null);
                } else {
                    commit(SHOW_TOAST, toast_error);
                    return response_format(false, error.messages);
                }
            })
            .catch(error => {
                commit(HIDDEN_LOADER, payload.element);
                commit(SHOW_TOAST, toast_error);
                return response_format(false, error.message);
            });
    },
    updateTournament: function({ commit }, payload) {
        var toast_success = {
            type: "success",
            title: "Torneo actualizado correctamente",
            position: "top-end"
        };
        var toast_error = {
            type: "error",
            title: "No se pudo actualizar",
            position: "top-end"
        };
        commit(SHOW_LOADER, payload.element);
        var form = { title: payload.title, participants: payload.participants };

        axios
            .patch(`${API_BASE}/t/${payload.id}`, form)
            .then(response => {
                commit(HIDDEN_LOADER, payload.element);
                if (response.data) {
                    commit(ADD_TOURNAMENT, response.data);
                    commit(SHOW_TOAST, toast_success);

                    return response_format(true, null);
                } else {
                    commit(SHOW_TOAST, toast_error);
                    return response_format(false, error.messages);
                }
            })
            .catch(error => {
                commit(HIDDEN_LOADER, payload.element);
                commit(SHOW_TOAST, toast_error);

                return response_format(false, error.message);
            });
    }
};
