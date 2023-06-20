<template>
    <div class="background min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <slot name="logo" />
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-100 bg-opacity-40 backdrop-blur-2xl drop-shadow-2xl shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>

        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
</template>

<style scoped>
.background {
    margin: auto;
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    overflow: auto;
    background: linear-gradient(315deg, rgba(101, 0, 94, 1) 3%, rgba(60, 132, 206, 1) 38%, rgb(33, 133, 126) 68%, rgba(255, 25, 25, 1) 98%);
    background-size: 400% 400%;
    background-attachment: fixed;
    animation: gradient 15s ease infinite, fadeIn 1 1s ease-out;
    -webkit-animation: gradient 15s ease infinite, fadeIn 1 1s ease-out;
    -moz-animation: gradient 15s ease infinite, fadeIn 1 1s ease-out;
    -o-animation: gradient 15s ease infinite, fadeIn 1 1s ease-out;
}

@keyframes gradient {
    0% {
        background-position: 0% 0%;
    }
    50% {
        background-position: 100% 100%;
    }
    100% {
        background-position: 0% 0%;
    }
}

.wave {
    background: rgb(255 255 255 / 25%);
    border-radius: 1000% 1000% 0 0;
    position: fixed;
    width: 200%;
    height: 12em;
    animation: wave 10s -3s linear infinite;
    transform: translate3d(0, 0, 0);
    opacity: 0.8;
    bottom: 0;
    left: 0;
    z-index: 2; /* Updated z-index value */
}

.wave:nth-of-type(2) {
    bottom: -1.25em;
    animation: wave 18s linear reverse infinite;
    opacity: 0.8;
    z-index: 3; /* Updated z-index value */
}

.wave:nth-of-type(3) {
    bottom: -2.5em;
    animation: wave 20s -1s reverse infinite;
    opacity: 0.9;
    z-index: 4; /* Updated z-index value */
}

@keyframes wave {
    2% {
        transform: translateX(1);
    }

    25% {
        transform: translateX(-25%);
    }

    50% {
        transform: translateX(-50%);
    }

    75% {
        transform: translateX(-25%);
    }

    100% {
        transform: translateX(1);
    }
}

/* Switch Page Animations */
@-webkit-keyframes fadeIn{
    from{opacity: 0;}
    to{opacity: 1;}
}

@-moz-keyframes fadeIn{
    from{opacity: 0;}
    to{opacity: 1;}
}

@-o-keyframes fadeIn{
    from{opacity: 0;}
    to{opacity: 1;}
}

@keyframes fadeIn{
    from{opacity: 0;}
    to{opacity: 1;}
}
</style>
