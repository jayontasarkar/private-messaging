import api from '../api/all';
import conversation from './conversation';

const state = {
	conversations: [],
	loadingConversations: false
}

const getters = {
	allConversations: state => {
		return state.conversations
	},
	loadingConversations: state => {
		return state.loadingConversations
	}
}

const actions = {
	getConversations({dispatch, commit}, page) {
		commit('setLoadingConversation', true)
		api.getConversations(1).then((response) => {
			commit('setConversations', response.data.data)
			commit('setLoadingConversation', false)
		});
	}
}

const mutations = {
	setConversations(state, conversations) {
		state.conversations = conversations
	},
	setLoadingConversation(state, status) {
		state.loadingConversations = status
	}
}

const modules = {
	conversation: conversation
}

export default {
	state,
	getters,
	actions,
	mutations,
	modules
}