<template>
    <div class="h-[90vh] w-full">
        <div class="h-full p-2 flex flex-col-reverse overflow-y-scroll">
            <div
                v-for="(message, index) in messages"
                :key="index"
                :class="message.user_id == loggedUser ? 'flex justify-end' : ''"
            >
                <MessageItem :message="message" :loggedUser="loggedUser" />
            </div>
        </div>
    </div>
</template>
<script>
import MessageItem from "./MessageItem.vue";

export default {
    props: ["messages"],
    data() {
        return {
            loggedUser: "",
        };
    },
    components: { MessageItem },
    created() {
        axios
            .get("/loggedUser")
            .then((response) => {
                this.loggedUser = response.data.id;
            })
            .catch((error) => {
                console.log(error);
            });
    },
};
</script>
