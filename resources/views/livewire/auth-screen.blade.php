<div x-data="{
    screens: @entangle('screens'),
    activeScreen: @entangle('activeScreen'),
    credentials: @entangle('credentials'),
    errors: @entangle('errors'),

    request_in_progress: false,


    notifications: {
        color: '',
        text: '',
        _show: false,
        _timeout: 3000,
        _class: null,

        push_notification(text, color = 'green') {

            console.log('Firing notification');
            this.text = text;
            this._show = true;
            this._class = this.print_notifications_class(color);

            setTimeout(() => {
                this._show = false;
            }, this._timeout);
        },

        print_notifications_class(color) {
            return 'text-'+ color + '-500 bg-'+ color + '-100 dark:bg-'+ color + '-800 dark:text-'+ color + '-200';
        }
    },

    fields: {
        name: '',
        email: '',
        password: '',
    },

    async _validate() {

        this.request_in_progress = true;

        console.log(this.fields);


        if(this.activeScreen == 'register') {
            if(this.fields.email == '' || this.fields.password == '' || this.fields.name == '') {
                this.notifications.push_notification('Email, name or password blank', 'red');
            } else {
                $wire.credentials = this.fields;
                await $wire.attemptLogin();
            }
        } else {
            if(this.fields.email == '' || this.fields.password == '') {
                this.notifications.push_notification('Email or password blank', 'red');
            } else {
                $wire.credentials = this.fields;
                await $wire.attemptLogin();
            }
        }

        this.request_in_progress = false;


    },

    login() {
        this._validate();
    },

    toggleScreens() {

        $wire.clearErrors();

        if(this.activeScreen == 'login') {
            this.activeScreen = 'register';
        } else {
            this.activeScreen = 'login';
        }
    },

    init() {
        console.log(this.screens);
        console.log(this.activeScreen);
        {{-- this.notifications.push_notification('This is a test', 'green'); --}}
    },




}">

<div
    x-show="notifications._show"
    x-transition
    id="toast-bottom-right"
    class="flex absolute right-5 bottom-5 items-center p-4 space-x-4 w-full max-w-xs text-gray-500 bg-white rounded-lg divide-gray-200 shadow dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800"
    role="alert"
>
     <div
        :class="notifications._class"
        class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 rounded-lg">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
    </div>
    <div class="mx-auto text-sm font-normal">
        <span x-text="notifications.text">
        </span>
    </div>
</div>

    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
                {{ config('app.name') }}
            </a>
            <span class="text-gray-400 p-4 mb-5">
                By <strong>Leonard Selvaraja</strong>, Laravel Chennai Meetup, October Chapter
            </span>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        {{ Str::ucfirst($this->activeScreen) }}
                    </h1>


                    <div
                        x-show="errors != ''"
                        class="p-2 bg-red-500 border-2 border-red-600 shadow-red-200 rounded-md text-white"
                    >
                        {{ $this->errors }}
                    </div>

                    <form class="space-y-4 md:space-y-6" action="#">
                            <div>
                                {{-- Email --}}
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                                <input type="email" name="email" x-model="fields.email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                            </div>

                            <div
                                x-show="activeScreen == 'register'"
                                x-transition
                            >
                                {{-- Name --}}
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
                                <input type="text" name="name" x-model="fields.name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John Doe" required="">
                            </div>

                            <div>
                                {{-- Password --}}
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>

                                <div class="flex flex-col" x-data="{
                                    showPassword: false,
                                }">
                                    <input
                                        :type="(showPassword) ? 'text' : 'password'"
                                        name="password"
                                        x-model="fields.password"
                                        id="password"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Your strong password"
                                        required=""

                                    />

                                    <span
                                        class="text-blue-500 text-center font-medium text-xs p-2.5"
                                        x-text="(showPassword) ? 'Hide password' : 'Show password'"
                                        x-on:click="showPassword = !showPassword"
                                        >
                                    </span>
                                </div>
                            </div>

                            <button
                                type="button"

                                :class="(activeScreen != 'login') ? 'bg-green-500 hover:bg-green-700' : 'bg-blue-500 hover:bg-blue-700'"
                                class="w-full text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-blue-800"
                                x-on:click="(request_in_progress) ? notifications.push_notification('A request is already in progress', 'red') : login "
                                >

                                <div x-show="request_in_progress" class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 animate-spin">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                </div>

                                <div x-show="!request_in_progress">
                                    <span x-text="(activeScreen != 'login') ? 'Register' : 'Login'"></span>
                                </div>

                            </button>

                            <p class="text-sm font-light text-gray-500 dark:text-gray-400">

                                <span
                                    x-text="(activeScreen == 'login') ? 'Don\'t have an account?' : 'Already have an account?'"
                                >
                                </span>


                                <span
                                    class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                                    x-on:click="toggleScreens"
                                    x-text="(activeScreen == 'login') ? 'Register' : 'Login'"
                                >
                                </span>
                            </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
