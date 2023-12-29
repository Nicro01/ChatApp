<template>
    <aside
        id="separator-sidebar"
        class="fixed top-0 left-0 z-40 w-[20%] h-screen transition-transform -translate-x-full sm:translate-x-0"
        aria-label="Sidebar"
    >
        <div
            class="h-full px-3 py-4 overflow-y-auto bg-gray-50 flex flex-col justify-between"
        >
            <div>
                <div
                    class="flex gap-2 mb-4 hover:cursor-pointer hover:bg-slate-300 rounded p-4"
                >
                    <img
                        class="w-8 h-8 rounded-full object-cover"
                        src="https://img.freepik.com/fotos-gratis/jovem-bonito-vestindo-camiseta-casual-sobre-o-rosto-feliz-de-fundo-azul-sorrindo-com-os-bracos-cruzados-olhando-para-a-camera-pessoa-positiva_839833-12963.jpg?w=1060&t=st=1703259541~exp=1703260141~hmac=afb1f3d3268e6346242e98907393184b8dcffea96b7160b6a8924a04f4555d06"
                        alt="Jese image"
                    />
                    <h2 class="text-xl font-semibold">
                        {{ loggedUser.name }}
                    </h2>
                </div>
                <h2 class="text-xl font-semibold mb-4">Rooms</h2>

                <ul class="space-y-2 font-medium">
                    <li
                        v-for="(room, index) in rooms"
                        :key="index"
                        @click="$emit('roomChanged', room)"
                        :class="
                            room === selected
                                ? 'bg-gray-300 hover:bg-gray-300 rounded-lg'
                                : 'hover:bg-gray-100 rounded-lg'
                        "
                        ondragstart="event.preventDefault()"
                        ondrop="event.preventDefault()"
                    >
                        <a
                            href="#"
                            class="flex items-center p-2 text-gray-900 group"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                />
                            </svg>

                            <span class="ms-3 text-base">{{ room.name }}</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <hr class="hr my-4" />
                <h2 class="text-xl font-semibold mb-4">Direct Messages</h2>
                <ul class="space-y-2 font-medium"></ul>
            </div>
            <div>
                <hr class="hr my-4" />
                <h2 class="text-xl font-semibold mb-4">Options</h2>
                <ul class="space-y-2 font-medium">
                    <li
                        class="hover:bg-gray-100 rounded-lg"
                        @click="newRoom"
                        ondragstart="event.preventDefault()"
                        ondrop="event.preventDefault()"
                    >
                        <a
                            href="#"
                            class="flex items-center p-2 text-gray-900 group"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />
                            </svg>
                            <span class="ms-3 text-base">Add New Room</span></a
                        >
                    </li>
                    <li
                        class="hover:bg-gray-100 rounded-lg"
                        @click="logout"
                        ondragstart="event.preventDefault()"
                        ondrop="event.preventDefault()"
                    >
                        <a
                            href="#"
                            class="flex items-center p-2 text-gray-900 group"
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-5 h-5"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"
                                />
                            </svg>

                            <span class="ms-3 text-base">Sign Out</span></a
                        >
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</template>

<script>
import { router } from "@inertiajs/vue3";

export default {
    props: ["rooms", "currentRoom"],
    data() {
        return {
            selected: "",
            loggedUser: "",
        };
    },
    created() {
        this.selected = this.currentRoom;

        axios
            .get("/loggedUser")
            .then((response) => {
                this.loggedUser = response.data;
            })
            .catch((error) => {
                console.log(error);
            });
    },
    watch: {
        currentRoom() {
            this.selected = this.currentRoom;
        },
    },
    methods: {
        logout() {
            router.post(route("logout"));
        },
        newRoom() {
            router.get(route("create-room"));
        },
    },
};
</script>
