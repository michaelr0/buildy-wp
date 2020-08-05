import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        isWP: false,
        config: {},
        colours: [],
        dragDisabled: false,
        validComponents: []
    },
    mutations: {
        SET_CONFIG(state, payload) {
            state.config = payload
        },
        SET_VALID_COMPONENTS(state, payload) {
            Vue.set(state, 'validComponents', payload)
        },
        DRAG_TOGGLE(state, payload) {
            state.dragDisabled = payload
        },
        SET_COLOURS(state, colours) {
            state.colours = colours;
        },
        FLAG_WP(state, payload) {
            state.isWP = payload
        }
    },
    actions: {
        config(context, payload) {
            // Set the config options globally
            context.commit('SET_CONFIG', payload)

            if (!payload.is_admin) {
                // If you're not admin, immediately disable dragging.
                context.commit('DRAG_TOGGLE', true)
            }

            if (payload.theme_colours && payload.theme_colours.length) {
                let colours = payload.theme_colours.map(colour => colour.name)
                context.commit('SET_COLOURS', colours)
            }

            // Config object only exists in wordpress scenarios at the moment
            context.commit('FLAG_WP', true)
        },
        dragToggle(context, payload) {
            if (context.state.config.is_admin) {
                // If you're an admin, function as normal
                context.commit('DRAG_TOGGLE', payload)
            } else {
                // If you're not an admin, remain disabled
                context.commit('DRAG_TOGGLE', true)
            }
        },
        validComponents({ commit }, payload) {
            if (payload.length) {
                let clean = payload.filter(el => {
                    return el
                })
                commit('SET_VALID_COMPONENTS', clean)
            }
        }
    },
    getters: {
        isWP: state => {
            return state.isWP;
        },
        config: state => {
            return state.config
        },
        colours: state => {
            return state.colours
        },
        dragDisabled: state => {
            return state.dragDisabled
        },
        validComponents: state => {
            return state.validComponents
        }
    }
})
