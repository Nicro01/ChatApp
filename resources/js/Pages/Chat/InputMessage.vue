<template>
    <div class="relative h-10 m-1">
        <div class="grid grid-cols-6">
            <input
                type="text"
                v-model="message"
                @keyup.enter="sendMessage()"
                placeholder="Write something ..."
                class="col-span-6 focus:outline-none focus:ring focus:border-blue-300 border-gray-300 rounded-md"
            />
            <button
                @click="sendMessage()"
                class="bg-blue-500 col-span-1 hover:bg-blue-700 text-white font-bold px-3 py-[0.3rem] rounded place-self-end absolute right-[3px] bottom-[2px]"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="w-6 h-6 font-bold"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"
                    />
                </svg>
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: ["room"],
    data() {
        return {
            message: "",
        };
    },
    methods: {
        async sendMessage() {
            if (this.message === "") {
                return;
            }
            await axios
                .post("/chat/room/" + this.room.id + "/message", {
                    message: this.message,
                })
                .then((response) => {
                    if (response.status == 201) {
                        this.message = "";
                        this.$emit("messageSent", response.data);
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
