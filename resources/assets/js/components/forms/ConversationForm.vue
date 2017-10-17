<template>
    <div class="panel panel-default">
    	<div class="panel-heading">
			New Message
    	</div>
    	<div class="panel-body">
    		<form action="#" @submit.prevent="send">
	    		<div class="form-group">
	    			<label for="users">Choose Participants</label>
	    			<input type="text" id="users" placeholder="Start typing to find users" class="form-control">
	    		</div>
	    		<ul class="list-inline" v-if="recipients.length">
					<li><strong>To:</strong> </li>
					<li v-for="recipient in recipients">{{ recipient.name }}&nbsp;[<a href="#" @click.prevent="removeRecipient(recipient)">x</a>]</li>
	    		</ul>
	    		<div class="form-group">
	    			<label for="message">Conversation Message</label>
	    			<textarea rows="3" class="form-control" v-model="body" placeholder="Type conversation"></textarea>
	    		</div>
	    		<div class="form-group">
	    			<input type="submit" class="btn btn-sm btn-default" value="Send">
	    		</div>
    		</form>
    	</div>
    </div>
</template>

<script>
	import { mapActions, mapGetters } from 'vuex';
	import { userautocomplete } from '../../helpers/autocomplete.js';

	export default {
		data () {
			return {
				body: null,
				recipients: []
			}
		},
		methods: {
			...mapActions([
				'createConversation'
			]),
			addReceipient(recipient) {
				var existing = this.recipients.find((r) => {
					return r.id === recipient.id
				})
				if(typeof existing !== 'undefined') { return; }

				this.recipients.push(recipient)
			},
			removeRecipient(recipient) {
				this.recipients = this.recipients.filter((f) => {
					return f.id !== recipient.id
				})
			},
			send() {
				this.createConversation({
					recipientIds: this.recipients.map((r) => {
						return r.id
					}),
					body: this.body
				}).then((response) => {
					this.body = null
					this.recipients = []
				})
			}
		},
	    mounted() {
	    	var users = userautocomplete('#users').on('autocomplete:selected', (e, selection) => {
	    		this.addReceipient(selection)
	    		users.autocomplete.setVal('')
	    	})
	    }
	}
</script>