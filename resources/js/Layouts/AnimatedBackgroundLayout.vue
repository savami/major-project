<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-h-screen bg-lines">
            <nav class="bg-transparent">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-transparent">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink class="text-white" :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                                <!-- Teams Dropdown -->
                                <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.current_team.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Manage Team
                                                </div>

                                                <!-- Team Settings -->
                                                <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)">
                                                    Team Settings
                                                </DropdownLink>

                                                <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')">
                                                    Create New Team
                                                </DropdownLink>

                                                <!-- Team Switcher -->
                                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                                    <div class="border-t border-gray-200" />

                                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                                        Switch Teams
                                                    </div>

                                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                        <form @submit.prevent="switchToTeam(team)">
                                                            <DropdownLink as="button">
                                                                <div class="flex items-center">
                                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>

                                                                    <div>{{ team.name }}</div>
                                                                </div>
                                                            </DropdownLink>
                                                        </form>
                                                    </template>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-transparent hover:text-indigo-300 focus:outline-none focus:text-indigo-300 active:text-indigo-300 transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200" />

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" :active="route().current('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200" />

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <div class='light x1'></div>
            <div class='light x2'></div>
            <div class='light x3'></div>
            <div class='light x4'></div>
            <div class='light x5'></div>
            <div class='light x6'></div>
            <div class='light x7'></div>
            <div class='light x8'></div>
            <div class='light x9'></div>

            <!--             Page Heading-->
            <header v-if="$slots.header" class="bg-transparent">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>

        </div>
    </div>
</template>

<style scoped>
/* .background {
    margin: auto;
    font-family: -apple-system, BlinkMacSystemFont, sans-serif;
    overflow: auto;
    background: linear-gradient(315deg, rgba(101,0,94,1) 3%, rgba(60,132,206,1) 38%, rgba(48,238,226,1) 68%, rgba(255,25,25,1) 98%);
    animation: gradient 15s ease infinite;
    background-size: 400% 400%;
    background-attachment: fixed;
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
    z-index: -1;
}

.wave:nth-of-type(2) {
    bottom: -1.25em;
    animation: wave 18s linear reverse infinite;
    opacity: 0.8;
}

.wave:nth-of-type(3) {
    bottom: -2.5em;
    animation: wave 20s -1s reverse infinite;
    opacity: 0.9;
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
} */


/* Header */
.bg-lines {
    margin: 0;
    height: 100vh;
    font-weight: 100;
    background: radial-gradient(#a23982,#1f1013);
    -webkit-overflow-Y: hidden;
    -moz-overflow-Y: hidden;
    -o-overflow-Y: hidden;
    overflow-y: hidden;
    -webkit-animation: fadeIn 1 1s ease-out;
    -moz-animation: fadeIn 1 1s ease-out;
    -o-animation: fadeIn 1 1s ease-out;
    animation: fadeIn 1 1s ease-out;
}

#button {
    position: absolute;
    border: 2px solid white;
    background: transparent;
    font-family: 'Roboto', sans-serif;
    color: white;
    width: 250px;
    height: 50px;
    font-size: 2em;
    border-radius: 5px;
    opacity: .5;
    top: 60vh;
    bottom: 0px;
    left: 0px;
    right: 0px;
    margin: auto;
    transition: .3s;
}

#button:hover {
    border: 2px solid #104F55;
    background-color: rgba(365,365,365,0.5);
    cursor: pointer;
    color: #104F55;
    opacity: .8;
    transition: .3s;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.light {
    position: absolute;
    width: 0px;
    opacity: .75;
    background-color: white;
    box-shadow: #e9f1f1 0px 0px 20px 2px;
    opacity: 0;
    top: 100vh;
    bottom: 0px;
    left: 0px;
    right: 0px;
    margin: auto;
}

.x1{
    -webkit-animation: floatUp 4s infinite linear;
    -moz-animation: floatUp 4s infinite linear;
    -o-animation: floatUp 4s infinite linear;
    animation: floatUp 4s infinite linear;
    -webkit-transform: scale(1.0);
    -moz-transform: scale(1.0);
    -o-transform: scale(1.0);
    transform: scale(1.0);
}

.x2{
    -webkit-animation: floatUp 7s infinite linear;
    -moz-animation: floatUp 7s infinite linear;
    -o-animation: floatUp 7s infinite linear;
    animation: floatUp 7s infinite linear;
    -webkit-transform: scale(1.6);
    -moz-transform: scale(1.6);
    -o-transform: scale(1.6);
    transform: scale(1.6);
    left: 15%;
}

.x3{
    -webkit-animation: floatUp 2.5s infinite linear;
    -moz-animation: floatUp 2.5s infinite linear;
    -o-animation: floatUp 2.5s infinite linear;
    animation: floatUp 2.5s infinite linear;
    -webkit-transform: scale(.5);
    -moz-transform: scale(.5);
    -o-transform: scale(.5);
    transform: scale(.5);
    left: -15%;
}

.x4{
    -webkit-animation: floatUp 4.5s infinite linear;
    -moz-animation: floatUp 4.5s infinite linear;
    -o-animation: floatUp 4.5s infinite linear;
    animation: floatUp 4.5s infinite linear;
    -webkit-transform: scale(1.2);
    -moz-transform: scale(1.2);
    -o-transform: scale(1.2);
    transform: scale(1.2);
    left: -34%;
}

.x5{
    -webkit-animation: floatUp 8s infinite linear;
    -moz-animation: floatUp 8s infinite linear;
    -o-animation: floatUp 8s infinite linear;
    animation: floatUp 8s infinite linear;
    -webkit-transform: scale(2.2);
    -moz-transform: scale(2.2);
    -o-transform: scale(2.2);
    transform: scale(2.2);
    left: -57%;
}

.x6{
    -webkit-animation: floatUp 3s infinite linear;
    -moz-animation: floatUp 3s infinite linear;
    -o-animation: floatUp 3s infinite linear;
    animation: floatUp 3s infinite linear;
    -webkit-transform: scale(.8);
    -moz-transform: scale(.8);
    -o-transform: scale(.8);
    transform: scale(.8);
    left: -81%;
}

.x7{
    -webkit-animation: floatUp 5.3s infinite linear;
    -moz-animation: floatUp 5.3s infinite linear;
    -o-animation: floatUp 5.3s infinite linear;
    animation: floatUp 5.3s infinite linear;
    -webkit-transform: scale(3.2);
    -moz-transform: scale(3.2);
    -o-transform: scale(3.2);
    transform: scale(3.2);
    left: 37%;
}

.x8{
    -webkit-animation: floatUp 4.7s infinite linear;
    -moz-animation: floatUp 4.7s infinite linear;
    -o-animation: floatUp 4.7s infinite linear;
    animation: floatUp 4.7s infinite linear;
    -webkit-transform: scale(1.7);
    -moz-transform: scale(1.7);
    -o-transform: scale(1.7);
    transform: scale(1.7);
    left: 62%;
}

.x9{
    -webkit-animation: floatUp 4.1s infinite linear;
    -moz-animation: floatUp 4.1s infinite linear;
    -o-animation: floatUp 4.1s infinite linear;
    animation: floatUp 4.1s infinite linear;
    -webkit-transform: scale(0.9);
    -moz-transform: scale(0.9);
    -o-transform: scale(0.9);
    transform: scale(0.9);
    left: 85%;
}

#button {
    outline: none;
}

@-webkit-keyframes floatUp{
    0%{top: 100vh; opacity: 0;}
    25%{opacity: 1;}
    50%{top: 0vh; opacity: .8;}
    75%{opacity: 1;}
    100%{top: -100vh; opacity: 0;}
}
@-moz-keyframes floatUp{
    0%{top: 100vh; opacity: 0;}
    25%{opacity: 1;}
    50%{top: 0vh; opacity: .8;}
    75%{opacity: 1;}
    100%{top: -100vh; opacity: 0;}
}
@-o-keyframes floatUp{
    0%{top: 100vh; opacity: 0;}
    25%{opacity: 1;}
    50%{top: 0vh; opacity: .8;}
    75%{opacity: 1;}
    100%{top: -100vh; opacity: 0;}
}
@keyframes floatUp{
    0%{top: 100vh; opacity: 0;}
    25%{opacity: 1;}
    50%{top: 0vh; opacity: .8;}
    75%{opacity: 1;}
    100%{top: -100vh; opacity: 0;}
}

.header {
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: 'Roboto', sans-serif;
    font-weight: 200;
    color: white;
    font-size: 2em;
}

#head1, #head2,#head3, #head4, #head5 {
    opacity: 0;
}

#head1 {
    -webkit-animation: fadeOut 1 5s ease-in;
    -moz-animation: fadeOut 1 5s ease-in;
    -o-animation: fadeOut 1 5s ease-in;
    animation: fadeOut 1 5s ease-in;
}

#head2 {
    -webkit-animation: fadeOut 1 5s ease-in;
    -moz-animation: fadeOut 1 5s ease-in;
    -o-animation: fadeOut 1 5s ease-in;
    animation: fadeOut 1 5s ease-in;
    -webkit-animation-delay: 6s;
    -moz-animation-delay: 6s;
    -o-animation-delay: 6s;
    animation-delay: 6s;
}

#head3 {
    -webkit-animation: fadeOut 1 5s ease-in;
    -moz-animation: fadeOut 1 5s ease-in;
    -o-animation: fadeOut 1 5s ease-in;
    animation: fadeOut 1 5s ease-in;
    -webkit-animation-delay: 12s;
    -moz-animation-delay: 12s;
    -o-animation-delay: 12s;
    animation-delay: 12s;
}

#head4 {
    -webkit-animation: fadeOut 1 5s ease-in;
    -moz-animation: fadeOut 1 5s ease-in;
    -o-animation: fadeOut 1 5s ease-in;
    animation: fadeOut 1 5s ease-in;
    -webkit-animation-delay: 17s;
    -moz-animation-delay: 17s;
    -o-animation-delay: 17s;
    animation-delay: 17s;
}

#head5 {
    -webkit-animation: finalFade 1 5s ease-in;
    -moz-animation: finalFade 1 5s ease-in;
    -o-animation: finalFade 1 5s ease-in;
    animation: finalFade 1 5s ease-in;
    -webkit-animation-fill-mode: forwards;
    -moz-animation-fill-mode: forwards;
    -o-animation-fill-mode: forwards;
    animation-fill-mode: forwards;
    -webkit-animation-delay: 22s;
    -moz-animation-delay: 22s;
    -o-animation-delay: 22s;
    animation-delay: 22s;
}

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

@-webkit-keyframes fadeOut{
    0%{opacity: 0;}
    30%{opacity: 1;}
    80%{opacity: .9;}
    100%{opacity: 0;}
}

@-moz-keyframes fadeOut{
    0%{opacity: 0;}
    30%{opacity: 1;}
    80%{opacity: .9;}
    100%{opacity: 0;}
}

@-o-keyframes fadeOut{
    0%{opacity: 0;}
    30%{opacity: 1;}
    80%{opacity: .9;}
    100%{opacity: 0;}
}

@keyframes fadeOut{
    0%{opacity: 0;}
    30%{opacity: 1;}
    80%{opacity: .9;}
    100%{opacity: 0;}
}

@-webkit-keyframes finalFade{
    0%{opacity: 0;}
    30%{opacity: 1;}
    80%{opacity: .9;}
    100%{opacity: 1;}
}

@-moz-keyframes finalFade{
    0%{opacity: 0;}
    30%{opacity: 1;}
    80%{opacity: .9;}
    100%{opacity: 1;}
}

@-o-keyframes finalFade{
    0%{opacity: 0;}
    30%{opacity: 1;}
    80%{opacity: .9;}
    100%{opacity: 1;}
}

@keyframes finalFade{
    0%{opacity: 0;}
    30%{opacity: 1;}
    80%{opacity: .9;}
    100%{opacity: 1;}
}

#footer{
    font-family: 'Roboto', sans-serif;
    font-size: 1.2em;
    color: white;
    position: fixed;
    -webkit-transform: translate(95vw,90vh);
    -moz-transform: translate(95vw,90vh);
    transform: translate(95vw,90vh);
    transform: translate(95vw,90vh);
}
</style>