import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    isWP: false,
    config: {},
    dragDisabled: false,
  },
  mutations: {
    SET_CONFIG(state, payload) {
      state.config = payload
    },
    DRAG_TOGGLE(state, payload) {
      state.dragDisabled = payload
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
    }
  },
  getters: {
    isWP: state => {
      return state.isWP;
    },
    config: state => {
      return state.config
    },
    dragDisabled: state => {
      return state.dragDisabled
    }
  }
})
