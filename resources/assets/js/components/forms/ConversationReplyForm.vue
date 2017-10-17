<template>
    <form  @submit.prevent="reply" role="form">
    	<div class="form-group">
    		<textarea rows="3" class="form-control" v-model="body"></textarea>
    	</div>

    	<div class="form-group">
    		<button type="submit" class="btn btn-default btn-sm">Reply</button>
    	</div>
    </form>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex';

	export default {
		data() {
			return {
				body: null
			}
		},
		computed: mapGetters({
			'conversation' : 'currentConversation'
		}),
		methods: {
			reply() {
				this.storeConversationReply({
					id: this.conversation.id,
					body: this.body
				}).then(() => {
					this.body = null
				})
			},
			...mapActions([
				'storeConversationReply'
			])
		}
	}
</script>