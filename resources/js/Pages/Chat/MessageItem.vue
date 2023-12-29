<template>
    <div
        v-if="message.user_id != loggedUser"
        class="flex gap-2.5 max-w-[320px]"
    >
        <img
            class="w-8 h-8 rounded-full object-cover"
            src="https://img.freepik.com/fotos-gratis/jovem-bonito-vestindo-camiseta-casual-sobre-o-rosto-feliz-de-fundo-azul-sorrindo-com-os-bracos-cruzados-olhando-para-a-camera-pessoa-positiva_839833-12963.jpg?w=1060&t=st=1703259541~exp=1703260141~hmac=afb1f3d3268e6346242e98907393184b8dcffea96b7160b6a8924a04f4555d06"
            alt="Jese image"
        />
        <div class="flex items-center space-x-2 rtl:space-x-reverse">
            <span class="text-sm font-semibold text-gray-900">{{
                message.user.name
            }}</span>
            <span class="text-xs font-normal text-gray-500">{{
                formatTime(message.created_at)
            }}</span>
        </div>
    </div>

    <div
        :class="
            message.user_id == loggedUser
                ? 'relative flex flex-col'
                : 'w-auto h-auto -mt-2'
        "
    >
        <div
            :class="
                message.user_id == loggedUser
                    ? 'flex flex-col break-words max-w-[320px] leading-1.5 px-4 py-2 border-gray-200 bg-blue-500 rounded-s-xl rounded-se-xl text-white my-4'
                    : 'inline-block break-words ms-10 max-w-[320px] leading-1.5 px-4 py-2 border-gray-200 bg-gray-100 rounded-e-xl rounded-es-xl  my-4'
            "
        >
            {{ message.message }}
        </div>
        <span
            v-if="message.user_id == loggedUser"
            class="absolute w-16 -bottom-2 right-0 self-end text-xs font-normal text-gray-500"
            >{{ formatTime(message.created_at) }}</span
        >
    </div>
</template>
<script>
export default {
    props: ["message", "loggedUser"],
    methods: {
        formatTime(datetime) {
            let date = new Date(datetime);
            let hours = date.getHours();
            let minutes = date.getMinutes();
            let day = date.getDate();
            let month = date.getMonth() + 1;

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            return day + "/" + month + " " + hours + ":" + minutes;
        },
    },
};
</script>
