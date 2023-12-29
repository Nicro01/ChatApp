<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import MessageContainer from "./MessageContainer.vue";
import InputMessage from "./InputMessage.vue";
import ChatRoomSelection from "./ChatRoomSelection.vue";
import axios from "axios";
import { initFlowbite } from "flowbite";

export default {
    components: {
        AppLayout,
        MessageContainer,
        InputMessage,
        ChatRoomSelection,
    },

    data() {
        return {
            chatRooms: [],
            currentRoom: [],
            messages: [],
        };
    },

    watch: {
        currentRoom(val, oldVal) {
            if (oldVal.id) {
                this.disconnect(oldVal);
            }
            this.connect();
        },
    },

    methods: {
        connect() {
            if (this.currentRoom.id) {
                let vm = this;
                this.getMessages();
                window.Echo.private("chat." + this.currentRoom.id).listen(
                    ".message.new",
                    (e) => {
                        vm.getMessages();
                    }
                );
            }
        },
        disconnect(room) {
            window.Echo.leave("chat." + room.id);
        },
        handleMessageSent(message) {
            this.messages.unshift(message);
        },
        getRooms() {
            axios
                .get("/chat/rooms")
                .then((response) => {
                    this.chatRooms = response.data;
                    this.currentRoom = this.chatRooms[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        setRooms(room) {
            this.currentRoom = room;
        },

        async getMessages() {
            await axios
                .get("/chat/room/" + this.currentRoom.id + "/messages")
                .then((response) => {
                    this.messages = response.data;
                })
                .catch((error) => {
                    console.log(error);
                });

            this.$nextTick(() => {
                const container = this.$refs.messageContainer;
                container.scrollTop = container.scrollHeight;
            });
        },
    },

    created() {
        this.getRooms();
        this.getMessages();
    },

    mounted() {
        initFlowbite();
    },
};
</script>

<template>
    <AppLayout title="Container">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <ChatRoomSelection
                    v-if="currentRoom.id"
                    :rooms="chatRooms"
                    :currentRoom="currentRoom"
                    v-on:roomChanged="setRooms($event)"
                />
            </h2>
        </template>

        <div class="flex justify-end">
            <div class="w-[80%] h-screen">
                <div class="bg-white overflow-hidden py-3">
                    <MessageContainer
                        ref="messageContainer"
                        :messages="messages"
                    />
                    <InputMessage
                        @messageSent="handleMessageSent($event)"
                        :room="currentRoom"
                        v-on:messageSent="getMessages()"
                    />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
