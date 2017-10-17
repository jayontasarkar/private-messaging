import api from '../api/all';

const state = {
	conversation: null,
	loadingConversation: false
}

const getters = {
	currentConversation: state => {
		return state.conversation
	},
	loadingConversation: state => {
		return state.loadingConversation
	}
}

const actions = {
	getConversation({dispatch, commit}, id) {
		commit('setLoadingConversation', true)
		api.getConversation(id).then((response) => {
			commit('setConversation', response.data.data)
			commit('setLoadingConversation', false)
			window.history.pushState(null, null, '/conversations/' + id)
		});
	},
	storeConversationReply({dispatch, commit}, {id, body}) {
		return api.storeConversationReply(id, {
			body: body
		}).then((response) => {
			commit('prependToConversation', response.data.data)
			commit('prependToConversations', response.data.data.parent.data)
		})
	},
	createConversation({dispatch, commit}, {body, recipientIds}) {
		return api.storeConversation({
			body: body,
			receipientIds: recipientIds
		}).then((response) => {
			dispatch('getConversation', response.data.data.id)
			commit('prependToConversations', response.data.data)
		})
	}
}

const mutations = {
	setConversation(state, conversation) {
		state.conversation = conversation
	},
	setLoadingConversation(state, status) {
		state.loadingConversation = status
	},
	prependToConversation(state, reply) {
		state.conversation.replies.data.unshift(reply)
	},
}

export default {
	state,
	getters,
	actions,
	mutations
}