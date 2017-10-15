<template>
    <div class="panel panel-default">
        <div class="panel-heading" style="font-size: large;">
            All conversations
        </div>
        <div class="panel-body">
            <div class="loader" v-if="loading">Loading...</div>
            <div class="media" v-for="conversation in conversations" v-else-if="conversations.length">
                <div class="media-body">
                    <a href="#" @click.prevent="getConversation(conversation.id)">{{ trunc(conversation.body, 35) }}</a>
                    <p> You and {{ conversation.participant_count }} {{ pluralize('other', conversation.participant_count) }}
                    </p>
                    <ul class="list-inline">
                        <li class="participant_list">
                            <img v-bind:src="user.avatar" v-bind:alt="user.name + ' avatar'" v-for="user in conversation.users.data">
                        </li>
                        <li v-if="conversation.last_reply_human">
                            Last reply {{ conversation.last_reply_human }}
                        </li>
                    </ul>
                </div>
            </div>
            <div v-else>No conversations</div>
        </div>
    </div>
</template>

<script>
    import pluralize from 'pluralize';
    import trunc from '../helpers/trunc.js';
    import { mapActions, mapGetters } from 'vuex';

    export default {
        computed: mapGetters({
            conversations : 'allConversations',
            loading: 'loadingConversations'
        }),
        methods: {
            ...mapActions([
                'getConversations',
                'getConversation'
            ]),
            trunc: trunc,
            pluralize: pluralize
        },
        mounted() {
            this.getConversations(1)
        }
    }
</script>
<style scoped>
    .participant_list img {
        padding-right: 4px;
    }
</style>